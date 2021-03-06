<?php

/**
 * User: Mikk Tarvas
 * Date: 20/04/16
 */
use Phroute\Phroute\RouteCollector;
use app\Template;
use app\CsrfMismatchException;
use app\AuthenticationException;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;

$router = new RouteCollector();
$ctx = getCtx();

###########
# Filters #
###########

$router->filter("csrf", function() {
    $data = getRequestData();
    $csrfIsValid = checkCsrfToken($data);

    if (!$csrfIsValid) {
        throw new CsrfMismatchException("csrf token mismatch");
    }

    return null;
});

$router->filter("auth", function() {
    $isLoggedIn = isLoggedIn();

    if (!$isLoggedIn) {
        throw new AuthenticationException("not logged in");
    }

    return null;
});

$router->filter("redirect_logged_in", function() {
    $isLoggedIn = isLoggedIn();
    if ($isLoggedIn) {
        location("/home");
    }
});

$router->filter("json_header", function() {
    jsonHeader();
});

#########
# Pages #
#########

$router->get("/", function() {
    $template = new Template("questions");
    $template->set("tag", null);
    return $template->render();
});

$router->get("/home", function() {
    $template = new Template("questions");
    $template->set("tag", null);
    return $template->render();
});

$router->get("/tags", function() use (&$ctx) {
    $result = $ctx["listTagsExecution"]->execute();
    $template = new Template("tags");
    $template->set("tags", $result->getData());
    return $template->render();
});

$router->get("/tags/{tag}", function($tag) {
    $template = new Template("questions");
    $template->set("tag", $tag);
    return $template->render();
});

$router->get("/ask", function() {
    $template = new Template("ask");
    $template->set("errors", []);
    $template->set("content", "");
    $template->set("title", "");
    $template->set("tags", "");
    return $template->render();
});

$router->post("/ask", function() use (&$ctx) {
    $data = getRequestData();
    $result = $ctx["askQuestionExecution"]->execute(getLoggedInUser(), $data);

    if ($result->isSuccessful()) {
        $urlInfo = $result->getData();
        location("/question/$urlInfo->id/$urlInfo->slug");
    }

    $template = new Template("ask");
    $template->set("errors", translateErrors($result->getErrors()));
    $template->set("content", $data["content"]);
    $template->set("title", $data["title"]);
    $template->set("tags", $data["tags"]);
    return $template->render();
}, ["before" => ["csrf", "auth"]]);

$router->get("/question/{id}/{slug}", function($id) use(&$ctx) {
    $result = $ctx["findQuestionExecution"]->execute($id);
    $template = new Template("question");

    if ($result->notSuccessful() && $result->getErrors()->contains("question_not_found")) {
        throw new HttpRouteNotFoundException();
    }

    $template->set("question_id", $id);
    $template->set("question", $result->getData());
    $template->set("content", "");
    $template->set("answer_ok", false);
    return $template->render();
});

$router->post("/question/{id}/{slug}", function($id) use(&$ctx) {
    $data = getRequestData();
    $insertResult = $ctx["answerQuestionExecution"]->execute($data, getLoggedInUser());
    $result = $ctx["findQuestionExecution"]->execute($id);
    if ($result->notSuccessful() && $result->getErrors()->contains("question_not_found")) {
        throw new HttpRouteNotFoundException();
    }

    $template = new Template("question");

    $errors = $insertResult->notSuccessful() ? translateErrors($insertResult->getErrors()) : [];

    $template->set("errors", $errors);
    $template->set("question_id", $id);
    $template->set("question", $result->getData());
    $template->set("content", $result->isSuccessful() ? "" : $data["content"]);
    $template->set("answer_ok", $result->isSuccessful());
    return $template->render();
}, ["before" => "auth"]);

$router->get("/login/{email}?", function($email = null) {
    $template = new Template("login");
    $template->set("is_login_page", true);
    $template->set("login_failed", false);
    $template->set("email", urldecode($email));
    return $template->render();
}, ["before" => ["redirect_logged_in"]]);

$router->post("/login/{email}?", function() use (&$ctx) {

    $data = getRequestData();

    $result = $ctx["loginExecution"]->execute($data);
    if ($result->isSuccessful()) {
        $userId = $result->getData();
        regenerateCsrfToken();
        logIn($userId);
        location("/home");
    }

    $template = new Template("login");
    $template->set("is_login_page", true);
    $template->set("login_failed", true);
    $template->set("email", $data["email"]);
    return $template->render();
}, ["before" => ["csrf", "redirect_logged_in"]]);

$router->get("/register", function() {
    $template = new Template("register");
    $template->set("email", "");
    $template->set("registration_completed", false);
    $template->set("errors", []);
    return $template->render();
}, ["before" => ["redirect_logged_in"]]);

$router->post("/register", function() use (&$ctx) {

    $data = getRequestData();
    $result = $ctx["registrationExecution"]->execute($data);
    $errors = $result->notSuccessful() ? translateErrors($result->getErrors()) : [];

    $template = new Template("register");
    $template->set("email", $data["email"]);
    $template->set("registration_completed", $result->isSuccessful());
    $template->set("errors", $errors);
    return $template->render();
}, ["before" => ["csrf", "redirect_logged_in"]]);

$router->post("/logout", function() {

    $isLoggedIn = isLoggedIn();
    if (!$isLoggedIn) {
        location("/home");
    }

    logOut();
    location("/home");
}, ["before" => "csrf"]);

########
# REST #
########

$router->post("/api/questions/{offset}/{tag}?", function($offset, $tag = null) use (&$ctx) {
    $result = $ctx["listQuestionsExecution"]->execute($offset, $tag);
    return resultToJson($result);
}, ["before" => "json_header"]);

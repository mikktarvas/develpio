<?php

/**
 * User: Mikk Tarvas
 * Date: 20/04/16
 */
use Phroute\Phroute\RouteCollector;
use app\Template;
use app\CsrfMismatchException;

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

#########
# Pages #
#########

$router->get("/", function() {
    $template = new Template("home");
    return $template->render();
});

$router->get("/home", function() {
    $template = new Template("home");
    return $template->render();
});

$router->get("/ask", function() {
    $template = new Template("ask");
    return $template->render();
});

$router->get("/login/{email}?", function($email = null) {

    $isLoggedIn = isLoggedIn();
    if ($isLoggedIn) {
        //already logged in, redirect to home
        header("Location: /home");
        exit();
    }

    $template = new Template("login");
    $template->set("is_login_page", true);
    $template->set("login_failed", false);
    $template->set("email", urldecode($email));
    return $template->render();
});

$router->post("/login/{email}?", function() {

    $data = getRequestData();

    $template = new Template("login");
    $template->set("is_login_page", true);
    $template->set("login_failed", true);
    $template->set("email", $data["email"]);
    return $template->render();
}, ["before" => "csrf"]);

$router->get("/register", function() {

    $isLoggedIn = isLoggedIn();
    if ($isLoggedIn) {
        //already logged in, redirect to home
        header("Location: /home");
        exit();
    }

    $template = new Template("register");
    $template->set("email", "");
    $template->set("registration_completed", false);
    $template->set("errors", []);
    return $template->render();
});

$router->post("/register", function() use (&$ctx) {

    $isLoggedIn = isLoggedIn();
    if ($isLoggedIn) {
        //already logged in, redirect to home
        header("Location: /home");
        exit();
    }

    $data = getRequestData();
    $result = $ctx["registrationExecution"]->execute($data);
    $errors = $result->notSuccessful() ? translateErrors($result->getErrors()) : [];

    $template = new Template("register");
    $template->set("email", $data["email"]);
    $template->set("registration_completed", $result->isSuccessful());
    $template->set("errors", $errors);
    return $template->render();
}, ["before" => "csrf"]);

$router->post("/logout", function() {
    
}, ["before" => "csrf"]);

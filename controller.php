<?php

/**
 * User: Mikk Tarvas
 * Date: 20/04/16
 */
use Phroute\Phroute\RouteCollector;
use app\Template;

$router = new RouteCollector();

###########
# Filters #
###########

$router->filter("csrf", function() {
    $data = getRequestData();
    $csrfIsValid = checkCsrfToken($data);

    if (!$csrfIsValid) {
        throw new Exception("csrf token mismatch");
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

$router->get("/login", function() {

    $isLoggedIn = isLoggedIn();
    if ($isLoggedIn) {
        //already logged in, redirect to home
        header("Location: /home");
        exit();
    }

    $template = new Template("login");
    $template->set("is_login_page", true);
    $template->set("login_failed", false);
    $template->set("email", "");
    return $template->render();
});

$router->post("/login", function() {

    $data = getRequestData();

    $template = new Template("login");
    $template->set("is_login_page", true);
    $template->set("login_failed", true);
    $template->set("email", $data["email"]);
    return $template->render();
}, ["before" => "csrf"]);


$router->post("/logout", function() {
    
}, ["before" => "csrf"]);

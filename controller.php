<?php

/**
 * User: Mikk Tarvas
 * Date: 20/04/16
 */
use Phroute\Phroute\RouteCollector;
use app\Template;

$router = new RouteCollector();

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
    return $template->render();
});

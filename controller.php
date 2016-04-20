<?php

/**
 * User: Mikk Tarvas
 * Date: 20/04/16
 */
use Phroute\Phroute\RouteCollector;
use app\Template as Template;

$router = new RouteCollector();

#########
# Pages #
#########

$router->get("/", function() {
    $template = new Template("home");
    return $template->render();
});

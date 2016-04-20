<?php

use Phroute\Phroute\RouteCollector;
use app\Template as Template;

$router = new RouteCollector();

$router->get("/", function() {
    $template = new Template("home");
    return $template->render();
});

<?php

use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();

$router->get("/", function() {
    return "Home Page";
});

<?php

/**
 * User: Mikk Tarvas
 * Date: 20/04/16
 */
use Phroute\Phroute\Dispatcher;
use Phroute\Phroute\Exception\HttpRouteNotFoundException;

require __DIR__ . "/../base.php";
require __DIR__ . "/../controller.php";

$method = $_SERVER["REQUEST_METHOD"];
$path = $_SERVER["REQUEST_URI"];

if (preg_match("/^\\/?static\\/.+$/", $path) || $path === "/favicon.ico") {
    //access static resource, do not re-route
    return false;
}

$dispatcher = new Dispatcher($router->getData());
try {
    echo $dispatcher->dispatch($method, $path);
    require __DIR__ . "/../sandbox.php";
    return true;
} catch (HttpRouteNotFoundException $ex) {
    return false;
}

<?php

/**
 * User: Mikk Tarvas
 * Date: 20/04/16
 */
use Phroute\Phroute\Dispatcher;

require __DIR__ . "/../base.php";
require __DIR__ . "/../controller.php";

$method = $_SERVER["REQUEST_METHOD"];
$path = $_SERVER["REQUEST_URI"];

if (preg_match("/^\\/?static\\/.+$/", $path) || $path === "/favicon.ico") {
    //access static resource, do not re-route
    return false;
}

$dispatcher = new Dispatcher($router->getData());
echo $dispatcher->dispatch($method, $path);

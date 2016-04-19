<?php

require_once "base.php";
require "app/controller.php";

use Phroute\Phroute\Dispatcher;

$dispatcher = new Dispatcher($router->getData());
echo $dispatcher->dispatch($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);

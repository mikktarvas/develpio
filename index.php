<?php

use Phroute\Phroute\Dispatcher;

require "base.php";
require "app/controller.php";

$dispatcher = new Dispatcher($router->getData());
echo $dispatcher->dispatch($_SERVER["REQUEST_METHOD"], $_SERVER["REQUEST_URI"]);

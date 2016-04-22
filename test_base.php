<?php

/**
 * User: Mikk Tarvas
 * Date: 20/04/16
 */
require __DIR__ . "/base.php";

$registered = spl_autoload_register(function($className) {
    if (substr($className, 0, 6) !== "tests\\") {
        return;
    }
    $toLoad = str_replace("\\", "/", substr($className, 6));
    require __DIR__ . "/tests/$toLoad.php";
});
if (!$registered) {
    throw new Exception("unable to register autoloader");
}
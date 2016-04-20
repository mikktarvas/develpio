<?php

#########################
# Bootstrap application #
#########################

error_reporting(E_ALL | E_STRICT);

require "./vendor/autoload.php";

define("ROOT_DIR", __DIR__);
define("CONF_FILE_PATH", __DIR__ . "/conf.ini");

$started = session_start();
if (!$started) {
    throw new Exception("unable to start session");
}

$registered = spl_autoload_register(function($className) {
    if (substr($className, 0, 4) !== "app\\") {
        return;
    }
    $toLoad = str_replace("\\", "/", substr($className, 4));
    require __DIR__ . "/app/$toLoad.php";
});
if (!$registered) {
    throw new Exception("unable to register autoloader");
}

##########################
# Basic helper functions #
##########################

function readConfiguration() {
    return app\Configuration::read();
}

function beginTransaction() {
    app\ConnectionFactory::getConnection()->beginTransaction();
}

function rollback($toReturn = null) {
    app\ConnectionFactory::getConnection()->rollBack();
    return $toReturn;
}

function commit($toReturn = null) {
    app\ConnectionFactory::getConnection()->commit();
    return $toReturn;
}

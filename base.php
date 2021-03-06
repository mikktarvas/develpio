<?php

/**
 * User: Mikk Tarvas
 * Date: 20/04/16
 */
error_reporting(E_ALL | E_STRICT);

use Doctrine\Common\Collections\ArrayCollection;
use app\ConnectionFactory;
use app\Configuration;
use Assert\Assertion;
use app\ContextHolder;
use app\ErrorTranslator;
use app\util\Result;

#########################
# Bootstrap application #
#########################

function exception_error_handler($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        return;
    }
    throw new ErrorException($message, 0, $severity, $file, $line);
}

set_error_handler("exception_error_handler");

require "./vendor/autoload.php";

define("ROOT_DIR", __DIR__);
define("CONF_FILE_PATH", __DIR__ . "/conf.ini");
define("ERROR_FILE_PATH", __DIR__ . "/errors.ini");

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
    return Configuration::read();
}

function beginTransaction() {
    ConnectionFactory::getConnection()->beginTransaction();
}

function rollback($toReturn = null) {
    ConnectionFactory::getConnection()->rollBack();
    return $toReturn;
}

function commit($toReturn = null) {
    ConnectionFactory::getConnection()->commit();
    return $toReturn;
}

function getConnection() {
    return ConnectionFactory::getConnection();
}

function getCtx() {
    return ContextHolder::getContext();
}

function getRequestData() {
    $merged = array_merge($_GET, $_POST);
    return new ArrayCollection($merged);
}

function getRestData() {
    $asString = file_get_contents("php://input");
    if ($asString === false) {
        throw new Exception("unable to read request data");
    }
    $parsed = json_decode($asString);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("unable to parse json");
    }
    return new ArrayCollection($parsed);
}

function getSession() {
    return new ArrayCollection($_SESSION);
}

function isLoggedIn() {
    $session = getSession();
    return $session["is_logged_in"] === true;
}

function logIn($userId) {
    $_SESSION["is_logged_in"] = true;
    $_SESSION["user_id"] = $userId;
}

function getLoggedInUser() {
    return isLoggedIn() ? $_SESSION["user_id"] : null;
}

function logOut() {
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
    }
    session_destroy();
}

function hashPassword($password) {
    Assertion::string($password);
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hash) {
    Assertion::string($password);
    Assertion::string($hash);
    return password_verify($password, $hash);
}

function randomString($length) {
    $bytes = ($length >> 1) + 1;
    $hex = bin2hex(openssl_random_pseudo_bytes($bytes));
    return substr($hex, 0, $length);
}

function regenerateCsrfToken() {
    $_SESSION["csrf"] = randomString(32);
}

function generateCsrfTokenIfNeeded() {
    $session = getSession();
    if ($session["csrf"] === null) {
        regenerateCsrfToken();
    }
}

function getCsrfToken() {
    generateCsrfTokenIfNeeded();
    $session = getSession();
    return $session["csrf"];
}

function checkCsrfToken(ArrayCollection $data) {
    $token = $data["csrf_token"];
    return $token !== null && $token === getCsrfToken();
}

function translateErrors($codes) {
    if ($codes instanceof ArrayCollection) {
        $codes = $codes->toArray();
    }
    return ErrorTranslator::translate($codes);
}

function location($location) {
    header("Location: $location");
    exit();
}

function isBlank($string) {
    Assertion::string($string);
    return strlen(trim($string)) === 0;
}

function resultToJson(Result $result) {
    $json = null;
    if ($result->isSuccessful()) {
        $json = ["data" => $result->getData(), "errors" => []];
    } else {
        $json = ["data" => null, "errors" => $result->getErrors()->toArray()];
    }
    return json_encode($json);
}

function jsonHeader() {
    header("Content-Type: application/json;charset=utf-8");
}

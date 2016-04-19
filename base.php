<?php

error_reporting(E_ALL | E_STRICT);

require "./vendor/autoload.php";

$started = session_start();
if (!$started) {
    throw new Exception("unable to start session");
}

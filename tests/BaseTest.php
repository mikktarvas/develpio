<?php

namespace tests;

use PHPUnit_Framework_TestCase;
use PDO;

/**
 * User: Mikk Tarvas
 * Date: 22/04/16
 */
abstract class BaseTest extends PHPUnit_Framework_TestCase {

    /**
     * 
     * @return PDO
     */
    protected function getPdo() {
        return getConnection();
    }

    protected function randomEmail() {
        return randomString(16) . "@localhost";
    }

    protected function randomPassword() {
        return randomString(16);
    }

}

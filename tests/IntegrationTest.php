<?php

namespace tests;

use \Pimple\Container;

/**
 * User: Mikk Tarvas
 * Date: 23/04/16
 */
abstract class IntegrationTest extends BaseTest {

    private static $ipsum = null;

    /**
     * 
     * @return Container
     */
    protected function getCtx() {
        return getCtx();
    }

    protected function getBean($name) {
        return getCtx()[$name];
    }

    protected function randomUser() {
        $usersDao = $this->getBean("usersDao");
        return $usersDao->insertUser($this->randomEmail(), hashPassword("password"));
    }

    protected function loremIpsum() {
        if (self::$ipsum === null) {
            self::$ipsum = file_get_contents("http://loripsum.net/api/20/plaintext");
        }
        return self::$ipsum;
    }

}

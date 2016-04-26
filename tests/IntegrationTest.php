<?php

namespace tests;

use Pimple\Container;
use Faker\Factory AS FakerFactory;
use Faker\Generator;

/**
 * User: Mikk Tarvas
 * Date: 23/04/16
 */
abstract class IntegrationTest extends BaseTest {

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
        return $this->faker()->paragraphs(10, true);
    }

    /**
     * 
     * @return Generator
     */
    protected function faker() {
        return FakerFactory::create();
    }

    /**
     * 
     * @return PDO
     */
    protected function getPdo() {
        return getConnection();
    }

    protected function randomEmail() {
        return $this->faker()->userName . "@localhost";
    }

    protected function randomPassword() {
        return randomString(16);
    }

}

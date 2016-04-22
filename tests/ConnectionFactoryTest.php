<?php

namespace tests;

use app\ConnectionFactory;
use PDO;

/**
 * User: Mikk Tarvas
 * Date: 22/04/16
 */
class ConnectionFactoryTest extends BaseTest {

    public function testGetConnection() {
        $connection = ConnectionFactory::getConnection();
        $this->assertTrue($connection instanceof PDO);
    }

}

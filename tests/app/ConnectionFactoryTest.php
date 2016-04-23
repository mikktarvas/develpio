<?php

namespace tests\app;

use app\ConnectionFactory;
use PDO;
use tests\BaseTest;

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

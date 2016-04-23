<?php

namespace tests\app;

use app\Configuration;
use tests\BaseTest;

/**
 * User: Mikk Tarvas
 * Date: 22/04/16
 */
class ConfigurationTest extends BaseTest {

    public function testGetConnection() {
        $configuration = Configuration::read();
        $this->assertNotNull($configuration);
    }

}

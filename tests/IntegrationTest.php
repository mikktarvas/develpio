<?php

namespace tests;

use \Pimple\Container;

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

}

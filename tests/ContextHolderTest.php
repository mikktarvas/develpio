<?php

namespace tests;

use app\ContextHolder;

/**
 * User: Mikk Tarvas
 * Date: 22/04/16
 */
class ContextHolderTest extends BaseTest {

    public function testGetContext() {
        $ctx = ContextHolder::getContext();
        $this->assertNotNull($ctx);
    }

}

<?php

namespace tests;

use app\util\Lazy;

/**
 * User: Mikk Tarvas
 * Date: 22/04/16
 */
class LazyTest extends BaseTest {

    public function testProviderIsOnlyInvokedOnce() {

        $invicationCount = 0;

        $provider = function() use (&$invicationCount) {
            $invicationCount++;
            return "provided";
        };
        $lazy = new Lazy($provider);

        $lazy->get();
        $value = $lazy->get();

        $this->assertEquals("provided", $value);
        $this->assertEquals(1, $invicationCount);
    }

}

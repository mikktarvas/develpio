<?php

namespace tests;

use tests\BaseTest;

/**
 * User: Mikk Tarvas
 * Date: 23/04/16
 */
class FunctionsTest extends BaseTest {

    public function testHashPassword() {
        $hash = hashPassword("password");
        $isVerified = verifyPassword("password", $hash);

        $this->assertInternalType("string", $hash);
        $this->assertTrue($isVerified);
    }

    public function testRandomString() {
        $string = randomString(32);

        $this->assertInternalType("string", $string);
        $this->assertEquals(32, strlen($string));
    }

}

<?php

namespace tests\app\util;

use tests\BaseTest;
use stdClass;
use app\util\Result;

/**
 * User: Mikk Tarvas
 * Date: 22/04/16
 */
class ResultTest extends BaseTest {

    public function testSuccessfulResult() {
        $obj = new stdClass();
        $result = Result::success($obj);

        $this->assertTrue($obj === $result->getData());
        $this->assertNull($result->getErrors());
        $this->assertTrue($result->isSuccessful());
        $this->assertFalse($result->notSuccessful());
    }

    public function testNotSuccessfulResult() {
        $result = Result::error(["err1", "err2"]);

        $this->assertNull($result->getData());
        $this->assertCount(2, $result->getErrors());
        $this->assertFalse($result->isSuccessful());
        $this->assertTrue($result->notSuccessful());
    }

}

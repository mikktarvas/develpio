<?php

namespace tests\app\util;

use tests\IntegrationTest;
use Doctrine\Common\Collections\ArrayCollection;
use app\dao\UsersDao;
use app\exec\AskQuestionExecution;

/**
 * User: Mikk Tarvas
 * Date: 22/04/16
 */
class AskQuestionExecutionITest extends IntegrationTest {

    /**
     * @var UsersDao
     */
    private $usersDao;

    /**
     *
     * @var AskQuestionExecution
     */
    private $askQuestionExecution;

    public function setUp() {
        $this->askQuestionExecution = $this->getBean("askQuestionExecution");
        $this->usersDao = $this->getBean("usersDao");
    }

    public function testSuccess() {
        $data = new ArrayCollection([
            "title" => "title-" . randomString(16),
            "content" => $this->loremIpsum(),
            "tags" => "tag1,tag2,tag3"
        ]);
        $userId = $this->randomUser();

        $result = $this->askQuestionExecution->execute($userId, $data);
        $this->assertTrue($result->isSuccessful());
    }

    public function testMissingTitle() {
        $data = new ArrayCollection([
            "title" => "",
            "content" => $this->loremIpsum(),
            "tags" => "tag1,tag2,tag3"
        ]);
        $userId = $this->randomUser();

        $result = $this->askQuestionExecution->execute($userId, $data);
        $this->assertFalse($result->isSuccessful());
        $this->assertTrue($result->getErrors()->contains("missing_title"));
    }

    public function testMissingContent() {
        $data = new ArrayCollection([
            "title" => "title-" . randomString(16),
            "content" => "",
            "tags" => "tag1,tag2,tag3"
        ]);
        $userId = $this->randomUser();

        $result = $this->askQuestionExecution->execute($userId, $data);
        $this->assertFalse($result->isSuccessful());
        $this->assertTrue($result->getErrors()->contains("missing_content"));
    }

    public function testMissingTags() {
        $data = new ArrayCollection([
            "title" => "title-" . randomString(16),
            "content" => $this->loremIpsum(),
            "tags" => ""
        ]);
        $userId = $this->randomUser();

        $result = $this->askQuestionExecution->execute($userId, $data);
        $this->assertFalse($result->isSuccessful());
        $this->assertTrue($result->getErrors()->contains("missing_tags"));
    }

}

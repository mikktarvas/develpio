<?php

namespace tests\app\util;

use tests\IntegrationTest;
use app\exec\LoginExecution;
use Doctrine\Common\Collections\ArrayCollection;
use app\dao\UsersDao;

/**
 * User: Mikk Tarvas
 * Date: 22/04/16
 */
class LoginExecutionITest extends IntegrationTest {

    /**
     * @var LoginExecution
     */
    private $loginExecution;

    /**
     * @var UsersDao
     */
    private $usersDao;

    public function setUp() {
        $this->loginExecution = $this->getBean("loginExecution");
        $this->usersDao = $this->getBean("usersDao");
    }

    public function testMissingUser() {
        $data = new ArrayCollection([
            "email" => $this->randomEmail(),
            "password" => $this->randomPassword()
        ]);

        $result = $this->loginExecution->execute($data);
        $this->assertFalse($result->isSuccessful());
        $this->assertTrue($result->getErrors()->contains("invalid_credentials"));
    }

    public function testPasswordMismatch() {

        $email = $this->randomEmail();
        $password = "password1";
        $this->usersDao->insertUser($email, hashPassword($password));

        $data = new ArrayCollection([
            "email" => $email,
            "password" => "password2"
        ]);

        $result = $this->loginExecution->execute($data);
        $this->assertFalse($result->isSuccessful());
        $this->assertTrue($result->getErrors()->contains("invalid_credentials"));
    }

    public function testSuccessfulLogin() {

        $email = $this->randomEmail();
        $password = "password";
        $this->usersDao->insertUser($email, hashPassword($password));

        $data = new ArrayCollection([
            "email" => $email,
            "password" => $password
        ]);

        $result = $this->loginExecution->execute($data);
        $this->assertTrue($result->isSuccessful());
    }

}

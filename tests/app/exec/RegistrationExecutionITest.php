<?php

namespace tests\app\util;

use tests\IntegrationTest;
use app\exec\RegistrationExecution;
use Doctrine\Common\Collections\ArrayCollection;
use app\dao\UsersDao;

/**
 * User: Mikk Tarvas
 * Date: 22/04/16
 */
class RegistrationExecutionITest extends IntegrationTest {

    /**
     * @var RegistrationExecution
     */
    private $registrationExecution;

    /**
     * @var UsersDao
     */
    private $usersDao;

    public function setUp() {
        $this->registrationExecution = $this->getBean("registrationExecution");
        $this->usersDao = $this->getBean("usersDao");
    }

    public function testInvalidEmail() {
        $data = new ArrayCollection([
            "email" => "invalidemail",
            "password" => "password",
            "password-confirmation" => "password"
        ]);

        $result = $this->registrationExecution->execute($data);
        $this->assertFalse($result->isSuccessful());
        $this->assertTrue($result->getErrors()->contains("invalid_email"));
    }

    public function testInvalidPassword() {
        $data = new ArrayCollection([
            "email" => $this->randomEmail(),
            "password" => "123",
            "password-confirm" => "123"
        ]);

        $result = $this->registrationExecution->execute($data);
        $this->assertFalse($result->isSuccessful());
        $this->assertTrue($result->getErrors()->contains("invalid_password"));
    }

    public function testPasswordMismatch() {
        $data = new ArrayCollection([
            "email" => $this->randomEmail(),
            "password" => "password",
            "password-confirm" => "drowssap"
        ]);

        $result = $this->registrationExecution->execute($data);
        $this->assertFalse($result->isSuccessful());
        $this->assertTrue($result->getErrors()->contains("password_confirm_mismatch"));
    }

    public function testEmailAlreadyExists() {

        $email = $this->randomEmail();
        $this->usersDao->insertUser($email, hashPassword($this->randomPassword()));

        $data = new ArrayCollection([
            "email" => $email,
            "password" => "password",
            "password-confirm" => "password"
        ]);

        $result = $this->registrationExecution->execute($data);
        $this->assertFalse($result->isSuccessful());
        $this->assertTrue($result->getErrors()->contains("email_already_exists"));
    }

    public function testSuccessfulRegistration() {

        $email = $this->randomEmail();

        $data = new ArrayCollection([
            "email" => $email,
            "password" => "password",
            "password-confirm" => "password"
        ]);

        $result = $this->registrationExecution->execute($data);
        $this->assertTrue($result->isSuccessful());
    }

}

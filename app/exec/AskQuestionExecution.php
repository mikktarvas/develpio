<?php

namespace app\exec;

use Doctrine\Common\Collections\ArrayCollection;
use app\util\Result;
use app\process\VerifyPassword;
use app\dao\UsersDao;

/**
 * User: Mikk Tarvas
 * Date: 23/04/16
 */
class AskQuestionExecution {

    /**
     * @var VerifyPassword
     */
    private $verifyPassword;

    /**
     *
     * @var UsersDao 
     */
    private $usersDao;

    /**
     * 
     * @param ArrayCollection $data
     * @return Result
     */
    public function execute(ArrayCollection $data) {

        $validation = $this->validateInput($data);
        if (count($validation) !== 0) {
            return Result::error($validation);
        }
        $email = trim($data["email"]);

        $matches = $this->verifyPassword->matches($email, $data["password"]);
        if (!$matches) {
            return Result::error("invalid_credentials");
        }

        return Result::success($this->usersDao->findUserIdByEmail($email));
    }

    private function validateInput(ArrayCollection $data) {
        $errors = [];

        $email = $data["email"];
        if (!is_string($email)) {
            $errors[] = "invalid_email";
        }

        $password = $data["password"];
        if (!is_string($password)) {
            $errors[] = "invalid_password";
        }

        return $errors;
    }

    function getVerifyPassword() {
        return $this->verifyPassword;
    }

    function setVerifyPassword(VerifyPassword $verifyPassword) {
        $this->verifyPassword = $verifyPassword;
    }

    function getUsersDao() {
        return $this->usersDao;
    }

    function setUsersDao(UsersDao $usersDao) {
        $this->usersDao = $usersDao;
    }

}

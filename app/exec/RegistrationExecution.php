<?php

namespace app\exec;

use Doctrine\Common\Collections\ArrayCollection;
use app\util\Result;
use app\process\InsertNewUser;
use Exception;

/**
 * User: Mikk Tarvas
 * Date: 23/04/16
 */
class RegistrationExecution {

    /**
     * @var InsertNewUser
     */
    private $insertNewUser;

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

        try {
            beginTransaction();
            $result = $this->insertNewUser->insert(trim($data["email"]), $data["password"]);
            if ($result->isSuccessful()) {
                return commit($result);
            } else {
                return rollback($result);
            }
        } catch (Exception $ex) {
            rollback();
            throw $ex;
        }
    }

    private function validateInput(ArrayCollection $data) {
        $errors = [];

        $email = $data["email"];
        if (!is_string($email) || !preg_match("/^.+\\@.+$/", $email)) {
            $errors[] = "invalid_email";
        }

        $password = $data["password"];
        if (!is_string($password) || strlen($password) < 8) {
            $errors[] = "invalid_password";
        }

        $confirmation = $data["password-confirm"];
        if ($password !== $confirmation) {
            $errors[] = "password_confirm_mismatch";
        }

        return $errors;
    }

    function getInsertNewUser() {
        return $this->insertNewUser;
    }

    function setInsertNewUser(InsertNewUser $insertNewUser) {
        $this->insertNewUser = $insertNewUser;
    }

}

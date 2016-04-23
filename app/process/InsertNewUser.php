<?php

namespace app\process;

use app\util\Result;
use app\dao\UsersDao;

/**
 * User: Mikk Tarvas
 * Date: 23/04/16
 */
class InsertNewUser {

    /**
     * @var UsersDao
     */
    private $usersDao;

    /**
     * 
     * @param string $email
     * @param string $password
     * 
     * @return Result
     */
    public function insert($email, $password) {

        if ($this->usersDao->emailExists($email)) {
            return Result::error("email_already_exists");
        }

        $hash = hashPassword($password);
        $this->usersDao->insertUser($email, $hash);

        return Result::success();
    }

    function getUsersDao() {
        return $this->usersDao;
    }

    function setUsersDao(UsersDao $usersDao) {
        $this->usersDao = $usersDao;
    }

}

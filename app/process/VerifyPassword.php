<?php

namespace app\process;

use app\dao\UsersDao;

/**
 * User: Mikk Tarvas
 * Date: 23/04/16
 */
class VerifyPassword {

    /**
     * @var UsersDao
     */
    private $usersDao;

    /**
     * 
     * @param string $email
     * @param string $password
     * 
     * @return bool
     */
    public function matches($email, $password) {
        $hash = $this->usersDao->findPasswordHashByEmail($email);
        if ($hash === null) {
            return false;
        }
        $matches = verifyPassword($password, $hash);
        return $matches;
    }

    function getUsersDao() {
        return $this->usersDao;
    }

    function setUsersDao(UsersDao $usersDao) {
        $this->usersDao = $usersDao;
    }

}

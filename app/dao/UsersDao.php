<?php

namespace app\dao;

/**
 * User: Mikk Tarvas
 * Date: 22/04/16
 */
class UsersDao extends BaseDao {

    public function findPasswordHashByEmail($email) {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare("SELECT password FROM core.users WHERE email = ?;");
        $stmt->bindParam(1, $email);
        $row = $stmt->fetch();
        return $row === false ? null : $row->password;
    }

}

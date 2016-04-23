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
        $stmt->execute();
        $row = $stmt->fetch();
        //TODO: probably broken
        return $row === false ? null : $row->password;
    }

    public function emailExists($email) {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare("SELECT COUNT(users_id) > 0 AS exists FROM core.users WHERE email = ?;");
        $stmt->bindParam(1, $email);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row->exists;
    }

    public function insertUser($email, $passwordHash) {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare("INSERT INTO core.users (email, password) VALUES (?, ?) RETURNING users_id;");
        $stmt->bindParam(1, $email);
        $stmt->bindParam(2, $passwordHash);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row->users_id;
    }

}

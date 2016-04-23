<?php

namespace app\dao;

use PDO;

/**
 * User: Mikk Tarvas
 * Date: 22/04/16
 */
abstract class BaseDao {

    /**
     * @var PDO
     */
    private $pdo;

    /**
     * 
     * @return PDO
     */
    function getPdo() {
        return $this->pdo;
    }

    /**
     * 
     * @param PDO $pdo
     */
    function setPdo(PDO $pdo) {
        $this->pdo = $pdo;
    }

}

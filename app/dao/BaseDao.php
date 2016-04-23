<?php

namespace app\dao;

use PDO;

/**
 * User: Mikk Tarvas
 * Date: 22/04/16
 */
abstract class BaseDao {

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
    function setPdo($pdo) {
        $this->pdo = $pdo;
    }

}

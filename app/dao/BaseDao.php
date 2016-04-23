<?php

namespace app\dao;

use PDO;

/**
 * User: Mikk Tarvas
 * Date: 22/04/16
 */
abstract class BaseDao {

    /**
     * 
     * @return PDO
     */
    protected function getPdo() {
        return getConnection();
    }

}

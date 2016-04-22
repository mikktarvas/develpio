<?php

namespace app\dao;

/**
 * User: Mikk Tarvas
 * Date: 22/04/16
 */
abstract class BaseDao {

    protected function getPdo() {
        return getConnection();
    }

}

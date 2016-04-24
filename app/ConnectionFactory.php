<?php

namespace app;

use PDO;
use Exception;

/**
 * User: Mikk Tarvas
 * Date: 20/04/16
 */
class ConnectionFactory {

    private static $DEFAULT_OPTIONS = [
        PDO::ATTR_CASE => PDO::CASE_NATURAL,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ];
    private static $connection = null;

    public static function getConnection() {
        if (self::$connection === null) {
            self::$connection = self::connect();
        }
        return self::$connection;
    }

    private static function connect() {

        $configuration = readConfiguration();
        $host = $configuration->{"db.host"};
        $user = $configuration->{"db.user"};
        $password = $configuration->{"db.password"};
        $port = $configuration->{"db.port"};
        $name = $configuration->{"db.name"};

        try {
            return new PDO("pgsql:host=$host;port=$port;dbname=$name;user=$user;password=$password;", null, null, self::$DEFAULT_OPTIONS);
        } catch (Exception $ex) {
            //do not dump credentials to output
            throw new Exception("unable to connect to database");
        }
    }

}

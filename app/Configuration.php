<?php

/**
 * User: Mikk Tarvas
 * Date: 20/04/16
 */

namespace app;

use Exception;

class Configuration {

    private static $parsed = null;

    public static function read() {
        if (self::$parsed === null) {
            $path = \CONF_FILE_PATH;
            $parsed = parse_ini_file($path);
            if ($parsed === false) {
                throw new Exception("unable to read configuration file: $path");
            }
            self::$parsed = (Object) $parsed;
        }
        return self::$parsed;
    }

}

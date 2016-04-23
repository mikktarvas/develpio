<?php

/**
 * User: Mikk Tarvas
 * Date: 23/04/16
 */

namespace app;

class ContextHolder {

    private static $context = null;

    public static function getContext() {
        if (self::$context === null) {
            self::$context = require ROOT_DIR . "/container.php";
        }
        return self::$context;
    }

}

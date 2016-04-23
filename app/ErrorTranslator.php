<?php

namespace app;

/**
 * User: Mikk Tarvas
 * Date: 23/04/16
 */
class ErrorTranslator {

    private static $parsed = null;

    protected static function read() {
        if (self::$parsed === null) {
            $path = ERROR_FILE_PATH;
            $parsed = parse_ini_file($path);
            if ($parsed === false) {
                throw new Exception("unable to read configuration file: $path");
            }
            self::$parsed = (Object) $parsed;
        }
        return self::$parsed;
    }

    public static function translate(array $codes) {
        $translations = self::read();
        $translated = [];
        foreach ($codes AS $code) {
            if (property_exists($translations, $code)) {
                $translated[] = $translations->{$code};
            } else {
                $translated[] = $code;
            }
        }
        return $translated;
    }

}

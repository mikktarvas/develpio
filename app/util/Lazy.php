<?php

namespace app\util;

/**
 * User: Mikk Tarvas
 * Date: 20/04/16
 */
class Lazy {

    private $value;
    private $provider;

    public function __construct($provider) {
        $this->provider = $provider;
    }

    public function get() {
        if ($this->value === null) {
            $this->value = call_user_func($this->provider);
        }
        return $this->value;
    }

}

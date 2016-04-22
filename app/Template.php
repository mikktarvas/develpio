<?php

/**
 * User: Mikk Tarvas
 * Date: 20/04/16
 */

namespace app;

use Assert\Assertion;
use Smarty;

class Template {

    private $name;
    private $smarty;

    public function __construct($name) {
        Assertion::notBlank($name);
        $this->name = $name;
        $this->smarty = $this->getSmartyInstance();
    }

    protected function getSmartyInstance() {
        $smarty = new Smarty();
        $tempDir = sys_get_temp_dir();
        $smarty->setTemplateDir(ROOT_DIR . "/tpl/");
        $smarty->setCacheDir($tempDir);
        $smarty->setCompileDir($tempDir);
        return $smarty;
    }

    public function set($name, $value) {
        $this->smarty->assign($name, $value);
        return null;
    }

    public function render() {
        $this->setCommonVariables();
        return $this->smarty->display($this->name . ".tpl");
    }

    private function setCommonVariables() {
        $this->set("is_logged_in", isLoggedIn());
    }

}

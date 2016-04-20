<?php

namespace app;

use \Assert\Assertion as Assertion;
use \Smarty as Smarty;

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
        $tempDir = ROOT_DIR . "/tmp/";
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
        return $this->smarty->display($this->name . ".tpl");
    }

}

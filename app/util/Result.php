<?php

namespace app\util;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * User: Mikk Tarvas
 * Date: 23/04/16
 */
class Result {

    private $data;
    private $errors;

    /**
     * 
     * @param mixed $data
     * @return \app\util\Result
     */
    public static function success($data = null) {
        $result = new Result();
        $result->data = $data;
        $result->errors = null;
        return $result;
    }

    /**
     * 
     * @param string|array $errors
     * @return \app\util\Result
     */
    public static function error($errors) {
        $result = new Result();
        $result->data = null;
        $result->errors = new ArrayCollection(is_array($errors) ? $errors : [$errors]);
        return $result;
    }

    function getData() {
        return $this->data;
    }

    /**
     * 
     * @return ArrayCollection
     */
    function getErrors() {
        return $this->errors;
    }

    function isSuccessful() {
        return $this->errors === null;
    }

    function notSuccessful() {
        return !$this->isSuccessful();
    }

}

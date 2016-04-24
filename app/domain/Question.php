<?php

namespace app\domain;

/**
 * User: Mikk Tarvas
 * Date: 24/04/16
 */
class Question {

    private $userId;
    private $title;
    private $content;

    function getUserId() {
        return $this->userId;
    }

    function getTitle() {
        return $this->title;
    }

    function getContent() {
        return $this->content;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setContent($content) {
        $this->content = $content;
    }

}

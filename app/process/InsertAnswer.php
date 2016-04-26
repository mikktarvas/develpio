<?php

namespace app\process;

use app\dao\TagsDao;
use app\process\InsertNewTag;
use app\dao\AnswersDao;
use app\dao\QuestionsDao;
use app\dao\UsersDao;
use app\util\Result;

/**
 * User: Mikk Tarvas
 * Date: 26/04/16
 */
class InsertAnswer {

    /**
     * @var AnswersDao
     */
    private $answersDao;

    /**
     * @var QuestionsDao
     */
    private $questionsDao;

    /**
     * @var UsersDao
     */
    private $usersDao;

    public function insert($questionId, $userId, $content) {

        if (!$this->usersDao->userExists($userId)) {
            return Result::error("user_not_found");
        }

        if (!$this->questionsDao->questionExists($questionId)) {
            return Result::error("question_not_found");
        }

        $answerId = $this->answersDao->insertAnswer($userId, $questionId, $content);
        return Result::success($answerId);
    }

    function getAnswersDao() {
        return $this->answersDao;
    }

    function getQuestionsDao() {
        return $this->questionsDao;
    }

    function getUsersDao() {
        return $this->usersDao;
    }

    function setAnswersDao(AnswersDao $answersDao) {
        $this->answersDao = $answersDao;
    }

    function setQuestionsDao(QuestionsDao $questionsDao) {
        $this->questionsDao = $questionsDao;
    }

    function setUsersDao(UsersDao $usersDao) {
        $this->usersDao = $usersDao;
    }

}

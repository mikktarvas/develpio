<?php

namespace app\exec;

use app\util\Result;
use app\dao\QuestionsDao;
use stdClass;
use app\dao\UsersDao;
use app\dao\TagsDao;

/**
 * User: Mikk Tarvas
 * Date: 24/04/16
 */
class FindQuestionExecution {

    /**
     * @var QuestionsDao
     */
    private $questionsDao;

    /**
     * @var UsersDao
     */
    private $usersDao;

    /**
     * @var TagsDao
     */
    private $tagsDao;

    public function execute($questionId) {

        $question = $this->questionsDao->findQuestion($questionId);
        if ($question === null) {
            //TODO: handle in controller
            return Result::error("question_not_found");
        }

        $user = $this->usersDao->findUserById($question->user_id);
        $tags = $this->tagsDao->findQuestionTags($question->id);

        //TODO: tags
        //TODO: answers

        $data = $this->createData($question, $user, $tags);
        return Result::success($data);
    }

    private function createData($question, $user, $tags) {
        $data = new stdClass();

        $data->title = $question->title;
        $data->content = $question->content;
        $data->inserted = $question->inserted;
        $data->user = $user->email;
        $data->userId = $user->id;
        $data->tags = [];
        foreach ($tags AS $tag) {
            $data->tags[] = $tag->name;
        }

        return $data;
    }

    function getQuestionsDao() {
        return $this->questionsDao;
    }

    function getUsersDao() {
        return $this->usersDao;
    }

    function setQuestionsDao(QuestionsDao $questionsDao) {
        $this->questionsDao = $questionsDao;
    }

    function setUsersDao(UsersDao $usersDao) {
        $this->usersDao = $usersDao;
    }

    function getTagsDao() {
        return $this->tagsDao;
    }

    function setTagsDao(TagsDao $tagsDao) {
        $this->tagsDao = $tagsDao;
    }

}

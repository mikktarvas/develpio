<?php

namespace app\exec;

use app\dao\QuestionsDao;
use app\util\Result;
use app\dao\TagsDao;

/**
 * User: Mikk Tarvas
 * Date: 24/04/16
 */
class ListQuestionsExecution {

    /**
     * @var TagsDao
     */
    private $tagsDao;

    /**
     * @var QuestionsDao
     */
    private $questionsDao;

    public function execute($offset, $tag) {

        if ($offset === "" || $offset === null || !ctype_digit($offset) || $offset < 0) {
            return Result::error("invalid_offset");
        }
        $offset = (int) $offset;

        $tagId = null;
        if ($tag !== null) {
            $tagId = $this->tagsDao->findTagIdByName($tag);
            if ($tagId === null) {
                return Result::success([]);
            }
        }

        $questions = $tagId === null ? $this->questionsDao->listQuestions($offset) : $this->questionsDao->listQuestionsByTagId($tagId, $offset);
        return Result::success($this->buildResponse($questions));
    }

    private function buildResponse($questions) {
        $response = [];
        foreach ($questions AS $value) {
            $response[] = (object) [
                        "inserted" => $value->inserted,
                        "title" => $value->title,
                        "tags" => $value->tag_names,
                        "author" => $value->email,
                        "id" => $value->question_id,
                        "slug" => $value->slug
            ];
        }
        return $response;
    }

    function getTagsDao() {
        return $this->tagsDao;
    }

    function getQuestionsDao() {
        return $this->questionsDao;
    }

    function setTagsDao(TagsDao $tagsDao) {
        $this->tagsDao = $tagsDao;
    }

    function setQuestionsDao(QuestionsDao $questionsDao) {
        $this->questionsDao = $questionsDao;
    }

}

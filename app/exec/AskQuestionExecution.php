<?php

namespace app\exec;

use Doctrine\Common\Collections\ArrayCollection;
use app\process\InsertNewQuestion;
use app\util\Result;
use app\dao\QuestionsDao;
use Exception;

/**
 * User: Mikk Tarvas
 * Date: 23/04/16
 */
class AskQuestionExecution {

    /**
     * @var InsertNewQuestion
     */
    private $insertNewQuestion;

    /**
     * @var QuestionsDao
     */
    private $questionsDao;

    /**
     * 
     * @param ArrayCollection $data
     * @return Result
     */
    public function execute($userId, ArrayCollection $data) {

        $validation = $this->validateInput($data);
        if (count($validation) !== 0) {
            return Result::error($validation);
        }

        $tags = $this->parseTags($data["tags"]);
        $content = trim($data["content"]);
        $title = trim($data["title"]);

        if (count($tags) === 0) {
            return Result::error("missing_tags");
        }

        try {
            beginTransaction();
            $result = $this->insertNewQuestion->insert($title, $content, $userId, $tags);
            if ($result->isSuccessful()) {
                $urlInfo = $this->questionsDao->findQuestionUrlInfo($result->getData());
                return commit(Result::success($urlInfo));
            } else {
                return rollback($result);
            }
        } catch (Exception $ex) {
            rollback();
            throw $ex;
        }
    }

    private function validateInput(ArrayCollection $data) {
        $errors = [];

        $title = $data["title"];
        if (!is_string($title) || isBlank($title)) {
            $errors[] = "missing_title";
        }

        $content = $data["content"];
        if (!is_string($content) || isBlank($content)) {
            $errors[] = "missing_content";
        }

        $tags = $data["tags"];
        if (!is_string($tags) || isBlank($tags)) {
            $errors[] = "missing_tags";
        }

        return $errors;
    }

    private function parseTags($tags) {
        $tags = preg_split("/\\s*,\\s*/", trim($tags));
        $tags = array_filter($tags, function($tag) {
            return strlen($tag) > 0;
        });

        $tags = array_map(function($tag) {
            return strtolower($tag);
        }, $tags);
        return $tags;
    }

    function getInsertNewQuestion() {
        return $this->insertNewQuestion;
    }

    function setInsertNewQuestion(InsertNewQuestion $insertNewQuestion) {
        $this->insertNewQuestion = $insertNewQuestion;
    }

    function getQuestionsDao() {
        return $this->questionsDao;
    }

    function setQuestionsDao(QuestionsDao $questionsDao) {
        $this->questionsDao = $questionsDao;
    }

}

<?php

namespace app\exec;

use app\util\Result;
use Doctrine\Common\Collections\ArrayCollection;
use app\process\InsertAnswer;

/**
 * User: Mikk Tarvas
 * Date: 23/04/16
 */
class AnswerQuestionExecution {

    /**
     * @var InsertAnswer
     */
    private $insertAnswer;

    public function execute(ArrayCollection $data, $userId) {

        $validation = $this->validateInput($data);
        if (count($validation) !== 0) {
            return Result::error($validation);
        }

        try {
            beginTransaction();
            $result = $this->insertAnswer->insert((int) $data["question_id"], $userId, $data["content"]);
            if ($result->isSuccessful()) {
                return commit(Result::success());
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

        $questionId = $data["question_id"];
        if (!$questionId || !ctype_digit($questionId)) {
            var_dump($data);
            $errors[] = "question_not_specified";
        }

        $content = $data["content"];
        if (!is_string($content) || isBlank($content)) {
            $errors[] = "missing_content";
        }

        return $errors;
    }

    function getInsertAnswer() {
        return $this->insertAnswer;
    }

    function setInsertAnswer(InsertAnswer $insertAnswer) {
        $this->insertAnswer = $insertAnswer;
    }

}

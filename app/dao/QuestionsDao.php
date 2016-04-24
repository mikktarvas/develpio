<?php

namespace app\dao;

use app\domain\Question;

/**
 * User: Mikk Tarvas
 * Date: 24/04/16
 */
class QuestionsDao extends BaseDao {

    public function insertQuestion(Question $question) {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare("INSERT INTO core.questions (user_id, title, content) VALUES (?, ?, ?) RETURNING question_id;");
        $stmt->bindParam(1, $question->getUserId());
        $stmt->bindParam(2, $question->getTitle());
        $stmt->bindParam(3, $question->getContent());
        $stmt->execute();
        $row = $stmt->fetch();
        return $row->questions_id;
    }

}

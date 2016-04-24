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
        $stmt = $pdo->prepare("
                INSERT INTO core.questions 
                    (user_id, title, content, slug) 
                VALUES 
                    (?, ?, ?, ?) RETURNING question_id;");
        $stmt->execute([
            $question->getUserId(), $question->getTitle(), $question->getContent(), $question->getSlug()
        ]);
        $row = $stmt->fetch();
        return $row->question_id;
    }

    public function findQuestionUrlInfo($id) {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare("
                SELECT 
                    question_id AS id, 
                    slug AS slug
                FROM core.questions WHERE question_id = ?;
                ");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

}

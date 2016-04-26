<?php

namespace app\dao;

/**
 * User: Mikk Tarvas
 * Date: 26/04/16
 */
class AnswersDao extends BaseDao {

    public function insertAnswer($userId, $questionId, $content) {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare("
                INSERT INTO core.answers
                    (user_id, question_id, content) 
                VALUES 
                    (?, ?, ?) RETURNING answer_id;");
        $stmt->execute([
            $userId, $questionId, $content
        ]);
        $row = $stmt->fetch();
        return $row->answer_id;
    }

    public function listAnswersByQuestionId($questionId) {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare("
                SELECT
                    ca.content AS content,
                    ca.inserted AS inserted,
                    cu.email AS author
                FROM
                    core.answers ca
                JOIN 
                    core.users cu ON cu.user_id = ca.user_id
                WHERE
                    ca.question_id = ?
                ORDER BY
                    ca.inserted DESC;
            ");
        $stmt->bindParam(1, $questionId);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }

}

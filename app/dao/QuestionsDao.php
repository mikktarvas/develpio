<?php

namespace app\dao;

use app\domain\Question;

/**
 * User: Mikk Tarvas
 * Date: 24/04/16
 */
class QuestionsDao extends BaseDao {

    private static $PAGE_SIZE = 5;

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

    public function findQuestion($id) {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare("
                SELECT 
                    user_id AS user_id,
                    title AS title,
                    content AS content,
                    question_id AS id, 
                    inserted AS inserted,
                    modified AS modified
                FROM core.questions WHERE question_id = ?;
                ");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row === false ? null : $row;
    }

    public function listQuestions($offset) {
        $offset = $offset * self::$PAGE_SIZE;
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare("SELECT * FROM core.list_questions OFFSET ? LIMIT ?;");
        $stmt->bindParam(1, $offset);
        $stmt->bindParam(2, self::$PAGE_SIZE);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        self::parseQuestionRows($rows);
        return $rows;
    }

    public function listQuestionsByTagId($tagId, $offset) {
        $offset = $offset * self::$PAGE_SIZE;
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare("SELECT * FROM core.list_questions WHERE to_jsonb(list_questions.tag_ids) @> ?::varchar::jsonb OFFSET ? LIMIT ?;");
        $stmt->bindParam(1, $tagId);
        $stmt->bindParam(2, $offset);
        $stmt->bindParam(3, self::$PAGE_SIZE);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        self::parseQuestionRows($rows);
        return $rows;
    }

    private static function parseQuestionRows($rows) {
        foreach ($rows AS $row) {
            $row->tag_ids = json_decode($row->tag_ids);
            $row->tag_names = json_decode($row->tag_names);
        }
    }

}

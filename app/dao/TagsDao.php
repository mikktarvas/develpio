<?php

namespace app\dao;

/**
 * User: Mikk Tarvas
 * Date: 24/04/16
 */
class TagsDao extends BaseDao {

    public function tagExistsByName($name) {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare("SELECT COUNT(tag_id) > 0 AS exists FROM core.tags WHERE name = ?;");
        $stmt->bindParam(1, $name);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row->exists;
    }

    public function insertIfMissing($name) {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare("INSERT INTO core.tags (name) values (?) ON CONFLICT ON CONSTRAINT tags_name__uniq DO NOTHING;");
        $stmt->bindParam(1, $name);
        $stmt->execute();
    }

    public function findTagIdByName($name) {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare("SELECT tag_id FROM core.tags WHERE name = ?;");
        $stmt->bindParam(1, $name);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row === false ? null : $row->tag_id;
    }

    public function attachTagToQuestion($tagId, $questionId) {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare("INSERT INTO core.question_tags (question_id, tag_id) values (?, ?);");
        $stmt->bindParam(1, $questionId);
        $stmt->bindParam(2, $tagId);
        $stmt->execute();
    }

    public function findQuestionTags($questionId) {
        $pdo = $this->getPdo();
        $stmt = $pdo->prepare("
                SELECT 
                    ct.tag_id AS tag_id,  
                    ct.name AS name 
                FROM core.tags ct JOIN core.question_tags cqt ON ct.tag_id = cqt.tag_id WHERE cqt.question_id = ?;");
        $stmt->bindParam(1, $questionId);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        return $rows;
    }

}

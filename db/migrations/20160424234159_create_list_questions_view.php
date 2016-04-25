<?php

use Phinx\Migration\AbstractMigration;

class CreateListQuestionsView extends AbstractMigration {

    public function change() {
        $this->execute("
            CREATE OR REPLACE VIEW core.list_questions AS
                SELECT 
                    first_value(cq.inserted) OVER (PARTITION BY cq.question_id) AS inserted,
                    cq.title AS title,
                    cq.slug AS slug,
                    json_agg(ct.tag_id) AS tag_ids,
                    json_agg(ct.name) AS tag_names,
                    cu.user_id AS user_id,
                    cu.email AS email,
                    cq.question_id AS question_id
                FROM core.questions cq
                JOIN core.question_tags cqt ON cq.question_id = cqt.question_id
                JOIN core.users cu ON cq.user_id = cu.user_id
                JOIN core.tags ct ON ct.tag_id = cqt.tag_id
                GROUP BY cq.question_id, cu.user_id
                ORDER BY inserted DESC
        ");
    }

}

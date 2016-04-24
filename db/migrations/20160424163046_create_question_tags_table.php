<?php

use Phinx\Migration\AbstractMigration;

class CreateQuestionTagsTable extends AbstractMigration {

    public function change() {
        $this->execute("

            CREATE TABLE core.question_tags (
                tag_id BIGINT NOT NULL,
                question_id BIGINT NOT NULL,
                
                created_at TIMESTAMP WITH TIME ZONE,
                updated_at TIMESTAMP WITH TIME ZONE,
                
                CONSTRAINT question_tags__pkey PRIMARY KEY(tag_id, question_id)
            );

            CREATE TRIGGER question_tags_meta_trigger 
            BEFORE INSERT OR UPDATE ON core.question_tags
            FOR EACH ROW EXECUTE PROCEDURE core.update_meta_fields();
            
        ");
    }

}

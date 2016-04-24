<?php

use Phinx\Migration\AbstractMigration;

class CreateQuestionsTable extends AbstractMigration {

    public function change() {
        $this->execute("
            
            CREATE SEQUENCE core.questions_seq START 100000;

            CREATE TABLE core.questions (
                question_id BIGINT DEFAULT nextval('core.questions_seq'),
                user_id BIGINT NOT NULL,
                title VARCHAR(512) NOT NULL,
                content TEXT NOT NULL,
                slug VARCHAR(64) NOT NULL,
                inserted TIMESTAMP WITH TIME ZONE DEFAULT current_timestamp,
                modified TIMESTAMP WITH TIME ZONE DEFAULT NULL,
                
                created_at TIMESTAMP WITH TIME ZONE,
                updated_at TIMESTAMP WITH TIME ZONE,
                
                CONSTRAINT questions__pkey PRIMARY KEY(question_id)
            );

            CREATE TRIGGER questions_meta_trigger 
            BEFORE INSERT OR UPDATE ON core.questions
            FOR EACH ROW EXECUTE PROCEDURE core.update_meta_fields();
            
        ");
    }

}

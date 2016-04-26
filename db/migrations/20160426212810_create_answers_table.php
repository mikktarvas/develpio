<?php

use Phinx\Migration\AbstractMigration;

class CreateAnswersTable extends AbstractMigration {

    public function change() {
        $this->execute("
            
            CREATE SEQUENCE core.answers_seq START 1000;

            CREATE TABLE core.answers (
                answer_id BIGINT DEFAULT nextval('core.questions_seq'),
                question_id BIGINT NOT NULL,
                user_id BIGINT NOT NULL,
                content TEXT NOT NULL,
                inserted TIMESTAMP WITH TIME ZONE DEFAULT current_timestamp,
                modified TIMESTAMP WITH TIME ZONE DEFAULT NULL,
                
                created_at TIMESTAMP WITH TIME ZONE,
                updated_at TIMESTAMP WITH TIME ZONE,
                
                CONSTRAINT answers__pkey PRIMARY KEY(answer_id)
            );

            CREATE TRIGGER answers_meta_trigger 
            BEFORE INSERT OR UPDATE ON core.answers
            FOR EACH ROW EXECUTE PROCEDURE core.update_meta_fields();
            
        ");
    }

}

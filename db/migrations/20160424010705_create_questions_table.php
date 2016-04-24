<?php

use Phinx\Migration\AbstractMigration;

class CreateQuestionsTable extends AbstractMigration {

    public function change() {
        $this->execute("
            
            CREATE SEQUENCE core.questions_seq START 1000;

            CREATE TABLE core.questions (
                question_id BIGINT DEFAULT nextval('core.questions_seq'),
                user_id BIGINT,
                title VARCHAR(512),
                content TEXT,
                inserted TIMESTAMP WITH TIME ZONE DEFAULT current_timestamp,
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

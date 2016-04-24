<?php

use Phinx\Migration\AbstractMigration;

class CreateTagsTable extends AbstractMigration {

    public function change() {
        $this->execute("
            
            CREATE SEQUENCE core.tags_seq START 1000;

            CREATE TABLE core.tags (
                tag_id BIGINT DEFAULT nextval('core.tags_seq'),
                name VARCHAR(256) NOT NULL,
                
                created_at TIMESTAMP WITH TIME ZONE,
                updated_at TIMESTAMP WITH TIME ZONE,
                
                CONSTRAINT tags__pkey PRIMARY KEY(tag_id),
                CONSTRAINT tags_name__uniq UNIQUE(name)
            );

            CREATE TRIGGER tags_meta_trigger 
            BEFORE INSERT OR UPDATE ON core.tags
            FOR EACH ROW EXECUTE PROCEDURE core.update_meta_fields();
            
        ");
    }

}

<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration {

    public function change() {
        $this->execute("
            
            CREATE SEQUENCE core.users_seq START 1000;

            CREATE TABLE core.users (
                user_id BIGINT DEFAULT nextval('core.users_seq'),
                email VARCHAR(256),
                password VARCHAR(256),
                active BOOLEAN DEFAULT TRUE,
                
                created_at TIMESTAMP WITH TIME ZONE,
                updated_at TIMESTAMP WITH TIME ZONE,
                
                CONSTRAINT users__pkey PRIMARY KEY(user_id),
                CONSTRAINT users_email__uniq UNIQUE(email)
            );

            CREATE TRIGGER users_meta_trigger 
            BEFORE INSERT OR UPDATE ON core.users 
            FOR EACH ROW EXECUTE PROCEDURE core.update_meta_fields();
            
        ");
    }

}

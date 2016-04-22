<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration {

    public function change() {
        $this->execute("
            CREATE TABLE core.users (
                users_id BIGINT,
                email VARCHAR(255),
                password VARCHAR(255),
                active BOOLEAN DEFAULT TRUE,
                created_at TIMESTAMP WITH TIME ZONE,
                updated_at TIMESTAMP WITH TIME ZONE,
                
                CONSTRAINT users__pkey PRIMARY KEY(users_id)
            );

            CREATE TRIGGER users_meta_trigger 
            BEFORE INSERT OR UPDATE ON core.users 
            FOR EACH ROW EXECUTE PROCEDURE core.update_meta_fields();
        ");
    }

}
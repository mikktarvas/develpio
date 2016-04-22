<?php

use Phinx\Migration\AbstractMigration;

class CreateCoreSchema extends AbstractMigration {

    public function change() {
        $this->execute("
            DO $$ BEGIN 
                IF NOT EXISTS (SELECT schema_name FROM information_schema.schemata WHERE schema_name = 'core') THEN
                    EXECUTE 'CREATE SCHEMA core';
                END IF;
            END $$;
        ");
    }

}

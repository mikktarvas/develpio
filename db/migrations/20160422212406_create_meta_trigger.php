<?php

use Phinx\Migration\AbstractMigration;

class CreateMetaTrigger extends AbstractMigration {

    public function change() {
        $this->execute("
            CREATE OR REPLACE FUNCTION core.update_meta_fields() 
            RETURNS TRIGGER AS $$
                DECLARE 
                    now TIMESTAMP(0) WITH TIME ZONE;
                BEGIN
                    now = clock_timestamp();
                    NEW.updated_at = now;
                    NEW.created_at = COALESCE(NEW.created_at, now);
                    RETURN NEW;
                END;
            $$ language 'plpgsql';
        ");
    }

}

<?php

use yii\db\Migration;

/**
 * Class m180501_124255_TrigerForNotificationsMain
 */
class m180501_124255_TrigerForNotificationsMain extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Insert record
        $sql_insert = '
            CREATE OR REPLACE FUNCTION public.notifications_insert()
            RETURNS trigger
            LANGUAGE \'plpgsql\'
            NOT LEAKPROOF 
            AS $BODY$
            BEGIN
            IF (OLD.nt_read = true AND OLD.nt_view > 0) THEN
                INSERT INTO "NotificationsArchive" SELECT NEW.*;
            ELSIF (OLD.nt_read = false OR OLD.nt_view = 0) THEN
                INSERT INTO "NotificationsActual" SELECT NEW.*;
            END IF;
            RETURN NULL;
            END;
            $BODY$;
            
            ALTER FUNCTION public.notifications_insert()
                OWNER TO yii2_db;
            
            
            CREATE TRIGGER notifications_insert
                BEFORE INSERT
                ON public."NotificationsMain"
                FOR EACH ROW
                EXECUTE PROCEDURE public.notifications_insert();
        ';

        $sql_update = '
            CREATE FUNCTION public.notifications_update()
                RETURNS trigger
                LANGUAGE \'plpgsql\'
                VOLATILE NOT LEAKPROOF 
            AS $BODY$
            BEGIN
            IF (OLD.nt_read = true AND OLD.nt_view > 0) THEN
                INSERT INTO "NotificationsArchive" SELECT OLD.*;
                DELETE FROM "NotificationsActual" WHERE OLD.*;
            ELSIF (OLD.nt_read = false OR OLD.nt_view = 0) THEN
                INSERT INTO "NotificationsActual" SELECT OLD.*;
                DELETE FROM "NotificationsArchive" WHERE OLD.*;
            END IF;
            RETURN NULL;
            END;
            $BODY$;
            
            ALTER FUNCTION public.notifications_update()
                OWNER TO yii2_db;
            
            
            CREATE TRIGGER notifications_update
                AFTER UPDATE OF nt_read, nt_view
                ON public."NotificationsMain"
                FOR EACH ROW
                EXECUTE PROCEDURE public.notifications_update();
        ';

        Yii::$app->db->getMasterPdo()->setAttribute(\PDO::ATTR_EMULATE_PREPARES, true);
        Yii::$app->db->getMasterPdo()->query($sql_insert);
        Yii::$app->db->getMasterPdo()->query($sql_update);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180501_124255_TrigerForNotificationsMain cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180501_124255_TrigerForNotificationsMain cannot be reverted.\n";

        return false;
    }
    */
}

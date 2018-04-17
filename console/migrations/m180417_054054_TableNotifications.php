<?php

use yii\db\Migration;

/**
 * Class m180417_054054_TableNotifications
 */
class m180417_054054_TableNotifications extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = 'CREATE TABLE "Notifications" (
                nt_id bigint NOT NULL,
                nt_type smallint,
                nt_data jsonb,
                nt_date timestamp without time zone DEFAULT now(),
                nt_user_id integer,
                nt_read boolean DEFAULT false NOT NULL,
                nt_text text,
                nt_view integer DEFAULT 0,
                nt_identical integer);
                
                ALTER TABLE "Notifications" OWNER TO yii2_db;';

        Yii::$app->db->createCommand($sql)->queryAll();
        //$this->execute($sql);

        $sql = ''; // не выполнится если нет нужного пользователя

        $this->execute($sql);

        $sql = 'COMMENT ON TABLE "Notifications" IS \'Таблица, содержащая уведомления пользователей\';
                COMMENT ON COLUMN "Notifications".nt_type IS \'Типы увдедомлений . Хранятся в params\';
                COMMENT ON COLUMN "Notifications".nt_data IS \'Параметры увдомления\';
                COMMENT ON COLUMN "Notifications".nt_date IS \'Дата создания уведомления\';
                COMMENT ON COLUMN "Notifications".nt_user_id IS \'Получатель уведомления\';
                COMMENT ON COLUMN "Notifications".nt_view IS \'Вид уведомления\';
                COMMENT ON COLUMN "Notifications".nt_identical IS \'Идентичные уведомления\';';

        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%Notifications}}');

        echo "m180417_054054_TableNotifications cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180417_054054_TableNotifications cannot be reverted.\n";

        return false;
    }
    */
}

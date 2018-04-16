<?php

use yii\db\Migration;

/**
 * Class m180416_072931_Table_NotificationsActual
 */
class m180416_072931_Table_NotificationsActual extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = 'CREATE TABLE "NotificationsActual" (
                nt_id bigint NOT NULL,
                nt_type smallint,
                nt_data jsonb,
                nt_date timestamp without time zone DEFAULT now(),
                nt_user_id integer,
                nt_read boolean DEFAULT false NOT NULL,
                nt_text text,
                nt_view integer DEFAULT 0,
                nt_identical integer);
                
                ALTER TABLE "NotificationsActual" OWNER TO postgres;
                
                COMMENT ON TABLE "NotificationsActual" IS \'Таблица, содержащая уведомления пользователей\';
                COMMENT ON COLUMN "NotificationsActual".nt_type IS \'Типы увдедомлений. Хранятся в params\';
                COMMENT ON COLUMN "NotificationsActual".nt_data IS \'Параметры увдомления\';
                COMMENT ON COLUMN "NotificationsActual".nt_date IS \'Дата создания уведомления\';
                COMMENT ON COLUMN "NotificationsActual".nt_user_id IS \'Получатель уведомления\';
                COMMENT ON COLUMN "NotificationsActual".nt_view IS \'Вид уведомления\';
                COMMENT ON COLUMN "NotificationsActual".nt_identical IS \'Идентичные уведомления\';
                
                '; //ALTER TABLE ONLY "NotificationsActual" ADD CONSTRAINT "NotificationsActual_pkey"

        //Yii::$app->db->createCommand($sql)->execute();
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%NotificationsActual}}');
        echo "m180416_072931_Table_NotificationsActual cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180416_072931_Table_NotificationsActual cannot be reverted.\n";

        return false;
    }
    */
}

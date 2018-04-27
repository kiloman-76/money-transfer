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
        $sql = 'CREATE TABLE "NotificationsMain" (
                nt_id bigint NOT NULL,
                nt_type smallint,
                nt_data jsonb,
                nt_date timestamp without time zone DEFAULT now(),
                nt_user_id integer,
                nt_read boolean DEFAULT false NOT NULL,
                nt_text text,
                nt_is_push boolean DEFAULT false NOT NULL,
                nt_view integer DEFAULT 0,
                nt_identical integer);
                ';

        $this->execute($sql);
        $this->execute('ALTER TABLE "NotificationsMain" OWNER TO yii2_db;');

        $this->execute('COMMENT ON TABLE "NotificationsMain" IS \'Таблица, содержащая уведомления пользователей\'');
        $this->execute('COMMENT ON COLUMN "NotificationsMain".nt_type IS \'Типы увдедомлений . Хранятся в params\'');
        $this->execute('COMMENT ON COLUMN "NotificationsMain".nt_data IS \'Параметры увдомления\'');
        $this->execute('COMMENT ON COLUMN "NotificationsMain".nt_date IS \'Дата создания уведомления\'');
        $this->execute('COMMENT ON COLUMN "NotificationsMain".nt_user_id IS \'Получатель уведомления\'');
        $this->execute('COMMENT ON COLUMN "NotificationsMain".nt_view IS \'Вид уведомления\'');
        $this->execute('COMMENT ON COLUMN "NotificationsMain".nt_identical IS \'Идентичные уведомления\'');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%NotificationsMain}}');
    }
}

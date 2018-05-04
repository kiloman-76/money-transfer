<?php

use yii\db\Migration;

/**
 * Class m180417_060130_TableNotificationsActual
 */
class m180417_060130_TableNotificationsActual extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = 'CREATE TABLE "NotificationsActual" (
                CHECK ( nt_read = FALSE  OR nt_view = 0)
                ) INHERITS ("NotificationsMain")';

        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%NotificationsActual}}');
    }
}

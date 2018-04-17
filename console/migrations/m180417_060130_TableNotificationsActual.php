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
                CHECK ( nt_read = FALSE )
                ) INHERITS ("Notifications")';

        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%NotificationsActual}}');

        echo "m180417_060130_TableNotificationsActual cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180417_060130_TableNotificationsActual cannot be reverted.\n";

        return false;
    }
    */
}

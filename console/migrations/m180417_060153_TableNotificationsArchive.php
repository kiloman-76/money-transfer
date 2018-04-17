<?php

use yii\db\Migration;

/**
 * Class m180417_060153_TableNotificationsArchive
 */
class m180417_060153_TableNotificationsArchive extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = 'CREATE TABLE "NotificationsArchive" (
                CHECK ( nt_read = TRUE )
                CHECK ( nt_view > 0 )
                ) INHERITS ("Notifications")';

        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%NotificationsArchive}}');
        echo "m180417_060153_TableNotificationsArchive cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180417_060153_TableNotificationsArchive cannot be reverted.\n";

        return false;
    }
    */
}

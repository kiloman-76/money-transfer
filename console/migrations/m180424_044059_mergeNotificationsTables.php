<?php

use yii\db\Migration;

/**
 * Class m180424_044059_mergeNotificationsTables
 */
class m180424_044059_mergeNotificationsTables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        //$list_table = $this->execute('SELECT table_name FROM INFORMATION_SCHEMA.tables WHERE table_name LIKE \'Notifications_user%\' ORDER BY table_name ASC;');
        //echo $list_table;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180424_044059_mergeNotificationsTables cannot be reverted.\n";


        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180424_044059_mergeNotificationsTables cannot be reverted.\n";

        return false;
    }
    */
}

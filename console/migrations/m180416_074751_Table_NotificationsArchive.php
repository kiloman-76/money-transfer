<?php

use yii\db\Migration;

/**
 * Class m180416_074751_Table_NotificationsArchive
 */
class m180416_074751_Table_NotificationsArchive extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = 'CREATE TABLE "NotificationsArchive"(
                CHECK ( nt_read = TRUE )
                --CHECK ( nt_view > 0 )
                ) 
                INHERITS ("NotificationsActual");';
        //Yii::$app->db->createCommand($sql)->execute();

        $this->execute($sql);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180416_074751_Table_NotificationsArchive cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180416_074751_Table_NotificationsArchive cannot be reverted.\n";

        return false;
    }
    */
}

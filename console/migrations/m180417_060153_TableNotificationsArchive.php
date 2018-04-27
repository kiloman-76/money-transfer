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
                CHECK ( nt_read == TRUE ),
                CHECK ( nt_view > 0 )
                ) INHERITS ("NotificationsMain")';

        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%NotificationsArchive}}');
    }
}

<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class HellowController extends Controller
{
    public function actionIndex()
    {
        $table_list = Yii::$app->db->createCommand('SELECT table_name FROM INFORMATION_SCHEMA.tables WHERE table_name LIKE \'Notifications_user%\' ORDER BY table_name ASC;');
        $table_list = $table_list->queryAll();

        //var_dump($table_list);

        foreach ($table_list as $key => $value) {
            $table_name = $value['table_name'];
            $sql = 'INSERT INTO "NotificationsMain" select * from "' . $table_name . '";';
            //echo "\n============================================================\n";
            Yii::$app->db->createCommand($sql)->execute();
        }

        ExitCode::OK;
    }
}
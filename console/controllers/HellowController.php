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
        $table_list = $table_list->execute();


        ExitCode::OK;
    }
}
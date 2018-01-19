<?php
return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/main.php',
    require __DIR__ . '/main-local.php',
    require __DIR__ . '/test.php',
    [
        'components' => [
            'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'pgsql:host=localhost;port=5432;dbname=yii2_db_test',
                'username' => 'yii2_db',
                'password' => 'yii2_db',
                'charset' => 'utf8',
            ]
        ],
    ]
);

<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=localhost;port=5432;dbname=yii2_db',
            'username' => 'yii2_db',
            'password' => 'yii2_db',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                  'class' => 'Swift_SmtpTransport',
                  'host' => 'debugmail.io',
                  'username' => 'vyacheslav-x@hotmail.com',
                  'password' => '35d34ff0-06ad-11e8-8c0d-e34c4746c3e2',
                  'port' => '25',
            ],

        ],
    ],
];

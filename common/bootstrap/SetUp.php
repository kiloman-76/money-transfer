<?php

namespace common\bootstrap;

use yii\base\BootstrapInterface;
use src\services\PasswordResetService;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(PasswordResetService::class, [], [
            [$app->params['supportEmail'] => $app->name . 'robot']
        ]);
    }

}
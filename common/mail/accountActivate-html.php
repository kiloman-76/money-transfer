<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user src\entities\user\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/account-acivate', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to activate your account::</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>

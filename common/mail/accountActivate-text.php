<?php

/* @var $this yii\web\View */
/* @var $user src\entities\user\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/account-acivate', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to activate your account:

<?= $resetLink ?>

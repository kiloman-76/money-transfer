<?php

namespace src\services;

use src\forms\auth\ResetPasswordForm;
use Yii;
use yii\base\Model;
use src\entities\user\User;
use src\forms\auth\PasswordResetRequestForm;


class PasswordResetService
{
    private $supportEmail;

    public function __construct($supportEmail)
    {
        $this->supportEmail = $supportEmail;
    }


    public function request(PasswordResetRequestForm $form): void
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => [User::STATUS_ACTIVE, User::STATUS_NOT_ACTIVE],
            'email' => $form->email,
        ]);

        if (!$user) {
            throw new \DomainException('User is not found.');
        }

        $user->generatePasswordResetToken();

        if (!$user->save())
        {
            throw new \RuntimeException('Saving error.');
        }

        $sent = Yii::$app
            ->mailer
            ->compose(
                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                ['user' => $user]
            )
            ->setFrom($this->supportEmail)
            ->setTo($form->email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
        if (!$sent)
        {
            throw new \RuntimeException('Sending error.');
        }
    }



    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token))
        {
            throw new \DomainException('Password reset token cannot be blank.');
        }

        if (!User::findByPasswordResetToken($token))
        {
            throw new \DomainException('Wrong password reset token.');
        }
    }

    public function reset(string $token, ResetPasswordForm $form): void
    {
        $user = User::findByPasswordResetToken($token);

        if (!$user)
        {
            throw new \DomainException('User not found.');
        }

        $user->resetPassword($form->password);

        if (!$user->save())
        {
            throw new \RuntimeException('Saving error.');
        }


    }
}
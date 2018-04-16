<?php

namespace src\services;

use Yii;
use src\entities\user\User;
use src\forms\auth\SignupForm;

class SignupService
{

    private $supportEmail;

    public function __construct($supportEmail)
    {
        $this->supportEmail = $supportEmail;
    }

    public function signup(SignupForm $form): User
    {
        $user = User::signup($form->username, $form->email, $form->password);

        if (!$user->save())
        {
            throw new \RuntimeException('Saving error.');
        }

        return $user;
    }

    public function sendEmail(User $user)
    {
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
                ['html' => 'accountActivate-html', 'text' => 'accountActivate-text'],
                ['user' => $user]
            )
            ->setFrom($this->supportEmail)
            ->setTo($user->email)
            ->setSubject('Activate account for ' . Yii::$app->name)
            ->send();
        if (!$sent)
        {
            throw new \RuntimeException('Sending error.');
        }
    }
}
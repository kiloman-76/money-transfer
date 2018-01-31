<?php

namespace src\services;

use src\entities\user\User;
use src\forms\auth\SignupForm;

class SignupService
{
    public function signup(SignupForm $form): User
    {
        $user = User::signup($form->username, $form->email, $form->password);

        if (!$user->save())
        {
            throw new \RuntimeException('Saving error.');
        }

        return $user;
    }
}
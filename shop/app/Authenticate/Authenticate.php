<?php
//declare(strict_types = 1);

use JetBrains\PhpStorm\NoReturn;
require_once __DIR__ . '/../../helpers.php';
require_once __DIR__.'/../../app/Interfaces/AuthenticateInterface.php';

class Authenticate implements AuthenticateInterface
{
    public function __construct(
        public $model = User::class
    ) {
    }

    #[NoReturn] public function login(array $credentials): void
    {
        $this->loginInputValidation($credentials);
        $model = (new $this->model)->getByCredentials($credentials['email']);
        if (!$model) {
            redirect('/login.php');
        }
        $verified = password_verify(($credentials['password'] ?? ''), ($model['password'] ?? ''));

        if ($verified) {
            $this->setAuthenticated($model);
            redirect('/shop/create');
        }else{
            $_SESSION['rejectMsg'] = 'email or password incorrect!!';
            redirect('login.php');
        }
    }

    public function setAuthenticated(array $model): void
    {
        $_SESSION['authenticated'] = 1;
        $_SESSION['user_id'] = $model['id'];
    }

    public function loginInputValidation(array $credentials): void
    {
        unset($_SESSION['inputEmailReject']);
        unset($_SESSION['inputPasswordReject']);
        unset($_SESSION['rejectMsg']);

        if(($credentials['email']) === '') {
            $_SESSION['inputEmailReject'] = 'Email cannot be empty!';
        } else if (!filter_var($credentials['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['inputEmailReject'] = 'Please enter valid email!';
        } else if (($credentials['password']) === '') {
            $_SESSION['inputPasswordReject'] = 'Password cannot be empty!';
        }
    }
}
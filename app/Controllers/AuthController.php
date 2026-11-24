<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;

class AuthController
{
    public function login()
    {
        echo view('auth.login');
    }

    public function submitLogin()
    {
        $user = new User;

        $user->email = $_POST['email'];
        $user->password = $_POST['password'];

        if($user->login()){
            header('Location: /dashboard');
            exit;
        } else {
            echo 'Unable to login.';
        }
    }

    public function register()
    {
        echo view('auth.register');
    }

    public function submitRegister()
    {
        $user = new User;

        $user->name = $_POST['name'];
        $user->email = $_POST['email'];
        if($_POST['password'] === $_POST['confirm_password']){
            $user->password = $_POST['password'];
        }

        if($user->register()){
            header('Location: /login');
            exit;
        } else {
            echo 'Unable to register.';
        }
    }
}

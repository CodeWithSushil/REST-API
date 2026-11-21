<?php

declare(strict_types=1);

namespace App\Controllers;

class AuthController
{
    public function login()
    {
        echo view('auth.login');
    }

    public function register()
    {
        echo view('auth.register');
    }
}

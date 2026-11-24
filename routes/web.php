<?php

use App\Services\Routing\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Middleware\Auth;
use App\Middleware\Guest;

Router::get('/', [HomeController::class, 'index'], [Auth::class]);
Router::get('/dashboard', [HomeController::class, 'index'], [Auth::class]);

Router::get('/login', [AuthController::class, 'login'], [Guest::class]);
Router::post('/login', [AuthController::class, 'submitLogin']);

Router::get('/register', [AuthController::class, 'register'], [Guest::class]);
Router::post('/register', [AuthController::class, 'submitRegister']);


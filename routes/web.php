<?php

use App\Services\Routing\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;

Router::get('/', [HomeController::class, 'index']);

Router::get('/login', [AuthController::class, 'login']);

Router::get('/register', [AuthController::class, 'register']);


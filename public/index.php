<?php

define('APP_ROOT', dirname(__DIR__));

require_once APP_ROOT . '/vendor/autoload.php';

use App\Services\Routing\Router;

$router = new Router();

require APP_ROOT . '/routes/web.php';

$router->dispatch();


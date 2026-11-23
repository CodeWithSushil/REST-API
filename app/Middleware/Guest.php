<?php

declare(strict_types=1);

namespace App\Middleware;

final class Guest
{
    public function __invoke(mixed $request = null, ?callable $next = null): mixed
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }

        return $next !== null ? $next($request) : null;
    }
}

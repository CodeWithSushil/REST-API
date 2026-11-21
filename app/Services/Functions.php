<?php

declare(strict_types=1);

use App\Config\Views;

if (!function_exists('view')) {

    /**
     * Render a PHP view.
     *
     * @param string $path View path (e.g. users.profile)
     * @param array<string, mixed> $data View data
     */
    function view(string $path, array $data = []): string
    {
        static $engine = null;

        $engine ??= new Views(
            APP_ROOT . '/views'
        );

        return $engine->render($path, $data);
    }
}

/**
 * Escape HTML output.
 */
if (!function_exists('e')) {

    function e(mixed $value): string
    {
        return Views::e($value);
    }
}

function dd(...$args){
    foreach($args as $arg){
        echo '<pre>';
        var_dump($arg);
        echo '</pre>';
    }
    exit();
}

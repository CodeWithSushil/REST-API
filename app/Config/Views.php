<?php

declare(strict_types=1);

namespace App\Config;

use RuntimeException;
use Throwable;

final class Views
{
    private string $viewPath;

    /** @var array<string, mixed> */
    private array $data = [];

    public function __construct(string $viewPath)
    {
        $this->viewPath = rtrim($viewPath, '/\\');
    }

    /**
     * Render a PHP view.
     *
     * @param array<string, mixed> $data
     */
    public function render(string $view, array $data = []): string
    {
        $file = $this->resolve($view);

        $level = ob_get_level();

        ob_start();

        try {
            // Extract variables without overwriting existing variables.
            extract($data, EXTR_SKIP);

            require $file;

            return (string) ob_get_clean();

        } catch (Throwable $e) {

            // Clean only buffers created by this render operation.
            while (ob_get_level() > $level) {
                ob_end_clean();
            }

            throw $e;
        }
    }

    /**
     * Resolve and validate view file.
     */
    private function resolve(string $view): string
    {
        if (
            $view === ''
            || str_contains($view, "\0")
            || str_contains($view, '\\')
        ) {
            throw new RuntimeException('Invalid view path.');
        }

        $relative = str_replace('.', DIRECTORY_SEPARATOR, $view);

        if (!preg_match('/^[a-zA-Z0-9_\/-]+$/D', $relative)) {
            throw new RuntimeException('Invalid view name.');
        }

        $file = realpath(
            $this->viewPath . DIRECTORY_SEPARATOR . $relative . '.php'
        );

        $base = realpath($this->viewPath);

        if (
            $file === false
            || $base === false
            || !str_starts_with(
                $file,
                $base . DIRECTORY_SEPARATOR
            )
            || !is_file($file)
        ) {
            throw new RuntimeException(
                "View not found: {$view}"
            );
        }

        return $file;
    }

    /**
     * Escape HTML output.
     */
    public static function escape(
        mixed $value,
        bool $doubleEncode = true
    ): string {
        if (!is_scalar($value) && $value !== null) {
            throw new RuntimeException(
                'Only scalar values can be escaped.'
            );
        }

        return htmlspecialchars(
            (string) ($value ?? ''),
            ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5,
            'UTF-8',
            $doubleEncode
        );
    }

    /**
     * Output escaped HTML.
     */
    public static function e(mixed $value): string
    {
        return self::escape($value);
    }

    /**
     * Render and send view.
     */
    public function display(string $view, array $data = []): void
    {
        echo $this->render($view, $data);
    }
}

<?php

declare(strict_types=1);

namespace App\Services\Routing;

use Closure;
use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;
use RuntimeException;
use Throwable;

final class Router
{
    /**
     * Registered routes.
     *
     * @var array<int, array{
     *     method: string,
     *     pattern: string,
     *     params: array<int, string>,
     *     action: mixed,
     *     middleware: array<int, mixed>
     * }>
     */
    private static array $routes = [];

    /** @var array<int, mixed> */
    private static array $globalMiddleware = [];

    /**
     * Register global middleware.
     */
    public static function use(string|callable|object|array $middleware): void
    {
        $items = is_array($middleware) && !is_callable($middleware)
            ? $middleware
            : [$middleware];

        foreach ($items as $item) {
            self::validateMiddleware($item);
            self::$globalMiddleware[] = $item;
        }
    }

    /**
     * Register a route.
     */
    private static function add(
        string $method,
        string $uri,
        mixed $action,
        array $middleware = []
    ): void {
        if (!is_callable($action) && !is_string($action) && !is_array($action) && !is_object($action)) {
            throw new RuntimeException('Invalid route action.');
        }

        foreach ($middleware as $item) {
            self::validateMiddleware($item);
        }

        [$pattern, $params] = self::compileUri($uri);

        self::$routes[] = [
            'method'     => strtoupper($method),
            'pattern'    => $pattern,
            'params'     => $params,
            'action'     => $action,
            'middleware' => $middleware,
        ];
    }

    public static function get(string $uri, mixed $action, array $middleware = []): void
    {
        self::add('GET', $uri, $action, $middleware);
    }

    public static function post(string $uri, mixed $action, array $middleware = []): void
    {
        self::add('POST', $uri, $action, $middleware);
    }

    public static function put(string $uri, mixed $action, array $middleware = []): void
    {
        self::add('PUT', $uri, $action, $middleware);
    }

    public static function patch(string $uri, mixed $action, array $middleware = []): void
    {
        self::add('PATCH', $uri, $action, $middleware);
    }

    public static function delete(string $uri, mixed $action, array $middleware = []): void
    {
        self::add('DELETE', $uri, $action, $middleware);
    }

    public static function head(string $uri, mixed $action, array $middleware = []): void
    {
        self::add('HEAD', $uri, $action, $middleware);
    }

    public static function options(string $uri, mixed $action, array $middleware = []): void
    {
        self::add('OPTIONS', $uri, $action, $middleware);
    }

    /**
     * Normalize URI.
     */
    private static function normalizeUri(string $uri): string
    {
        $path = '/' . trim($uri, '/');

        return $path === '//' ? '/' : $path;
    }

    /**
     * Compile route URI into regex.
     *
     * Example:
     * /users/{id}/posts/{slug}
     */
    private static function compileUri(string $uri): array
    {
        $uri = self::normalizeUri($uri);

        $params = [];

        if ($uri === '/') {
            return ['#^/$#D', []];
        }

        $segments = explode('/', trim($uri, '/'));
        $compiled = [];

        foreach ($segments as $segment) {
            if (preg_match('/^\{([a-zA-Z_][a-zA-Z0-9_]*)\}$/', $segment, $matches)) {
                $name = $matches[1];

                if (in_array($name, $params, true)) {
                    throw new RuntimeException("Duplicate route parameter: {$name}");
                }

                $params[] = $name;
                $compiled[] = '([^/]+)';

            } elseif (str_contains($segment, '{') || str_contains($segment, '}')) {
                throw new RuntimeException("Invalid route parameter: {$segment}");

            } else {
                $compiled[] = preg_quote($segment, '#');
            }
        }

        return [
            '#^/' . implode('/', $compiled) . '$#D',
            $params
        ];
    }

    /**
     * Dispatch HTTP request.
     */
    public function dispatch(): mixed
    {
        $rawUri = $_SERVER['REQUEST_URI'] ?? '/';

        $path = parse_url($rawUri, PHP_URL_PATH);

        $requestUri = self::normalizeUri(
            is_string($path) ? $path : '/'
        );

        $requestMethod = strtoupper(
            $_SERVER['REQUEST_METHOD'] ?? 'GET'
        );

        $allowedMethods = [];

        foreach (self::$routes as $route) {

            if (preg_match($route['pattern'], $requestUri, $matches) !== 1) {
                continue;
            }

            $allowedMethods[] = $route['method'];

            // HEAD requests can use GET routes.
            $matchedMethod = $route['method'] === 'GET'
                && $requestMethod === 'HEAD';

            if (
                $route['method'] !== $requestMethod
                && !$matchedMethod
            ) {
                continue;
            }

            array_shift($matches);

            $params = [];

            foreach ($route['params'] as $index => $name) {
                $params[$name] = rawurldecode($matches[$index]);
            }

            $pipeline = array_merge(
                self::$globalMiddleware,
                $route['middleware']
            );

            $runner = array_reduce(
                array_reverse($pipeline),

                fn (callable $next, mixed $middleware): Closure =>
                    fn () => $this->runMiddleware(
                        $middleware,
                        $params,
                        $next
                    ),

                fn () => $this->invoke(
                    $route['action'],
                    $params
                )
            );

            return $runner();
        }

        if ($allowedMethods !== []) {
            http_response_code(405);

            header(
                'Allow: ' . implode(', ', array_unique($allowedMethods))
            );

            return '405 Method Not Allowed';
        }

        http_response_code(404);

        return '404 Not Found';
    }

    /**
     * Validate middleware.
     */
    private static function validateMiddleware(mixed $middleware): void
    {
        if (is_string($middleware) && class_exists($middleware)) {
            return;
        }

        if (is_object($middleware) && method_exists($middleware, 'handle')) {
            if (is_callable([$middleware, 'handle'])) {
                return;
            }
        }

        if (is_callable($middleware)) {
            return;
        }

        throw new RuntimeException('Invalid middleware definition.');
    }

    /**
     * Execute middleware.
     */
    private function runMiddleware(
        mixed $middleware,
        array $params,
        callable $next
    ): mixed {

        if (is_string($middleware) && class_exists($middleware)) {
            $reflection = new ReflectionClass($middleware);

            if (!$reflection->isInstantiable()) {
                throw new RuntimeException(
                    "Middleware {$middleware} cannot be instantiated."
                );
            }

            $middleware = $reflection->newInstance();
        }

        if (is_object($middleware) && is_callable([$middleware, 'handle'])) {
            return $middleware->handle($params, $next);
        }

        if (is_callable($middleware)) {
            return $middleware($params, $next);
        }

        throw new RuntimeException('Invalid middleware definition.');
    }

    /**
     * Execute route action using Reflection API.
     */
    private function invoke(mixed $action, array $params): mixed
    {
        // Closure or function.
        if ($action instanceof Closure || (is_string($action) && function_exists($action))) {
            $reflection = new ReflectionFunction($action);

            $arguments = $this->resolveArguments(
                $reflection->getParameters(),
                $params
            );

            return $reflection->invokeArgs($arguments);
        }

        // [Controller::class, 'method']
        // [$controller, 'method']
        if (is_array($action) && count($action) === 2) {

            [$classOrObject, $method] = $action;

            if (!is_string($method)) {
                throw new RuntimeException('Invalid controller method.');
            }

            $controller = is_object($classOrObject)
                ? $classOrObject
                : $this->createController($classOrObject);

            $reflection = new ReflectionMethod($controller, $method);

            if (!$reflection->isPublic()) {
                throw new RuntimeException(
                    "Controller method {$method} must be public."
                );
            }

            $arguments = $this->resolveArguments(
                $reflection->getParameters(),
                $params
            );

            return $reflection->invokeArgs($controller, $arguments);
        }

        // Invokable controller class.
        if (is_string($action) && class_exists($action)) {

            $controller = $this->createController($action);

            if (!is_callable($controller)) {
                throw new RuntimeException(
                    "Controller {$action} is not invokable."
                );
            }

            $reflection = new ReflectionMethod($controller, '__invoke');

            $arguments = $this->resolveArguments(
                $reflection->getParameters(),
                $params
            );

            return $reflection->invokeArgs($controller, $arguments);
        }

        // Invokable object.
        if (is_object($action) && is_callable($action)) {

            $reflection = new ReflectionMethod($action, '__invoke');

            $arguments = $this->resolveArguments(
                $reflection->getParameters(),
                $params
            );

            return $reflection->invokeArgs($action, $arguments);
        }

        throw new RuntimeException('Invalid route action.');
    }

    /**
     * Instantiate controller using ReflectionClass.
     */
    private function createController(string $class): object
    {
        if (!class_exists($class)) {
            throw new RuntimeException(
                "Controller class {$class} does not exist."
            );
        }

        $reflection = new ReflectionClass($class);

        if (!$reflection->isInstantiable()) {
            throw new RuntimeException(
                "Controller {$class} cannot be instantiated."
            );
        }

        $constructor = $reflection->getConstructor();

        if ($constructor !== null && $constructor->getNumberOfRequiredParameters() > 0) {
            throw new RuntimeException(
                "Controller {$class} requires constructor dependencies. "
                . "Use dependency injection or pass an instance."
            );
        }

        return $reflection->newInstance();
    }

    /**
     * Resolve controller arguments using ReflectionParameter.
     */
    private function resolveArguments(
        array $parameters,
        array $routeParams
    ): array {

        $arguments = [];

        foreach ($parameters as $parameter) {

            $name = $parameter->getName();

            if (array_key_exists($name, $routeParams)) {

                $value = $routeParams[$name];

                $arguments[] = $this->castParameter(
                    $value,
                    $parameter
                );

                continue;
            }

            if ($parameter->isDefaultValueAvailable()) {
                $arguments[] = $parameter->getDefaultValue();
                continue;
            }

            if ($parameter->allowsNull()) {
                $arguments[] = null;
                continue;
            }

            if ($parameter->isVariadic()) {
                continue;
            }

            throw new RuntimeException(
                "Unable to resolve controller parameter: {$name}"
            );
        }

        return $arguments;
    }

    /**
     * Cast route parameters according to their declared type.
     */
    private function castParameter(
        string $value,
        ReflectionParameter $parameter
    ): mixed {

        $type = $parameter->getType();

        if (!$type instanceof ReflectionNamedType) {
            return $value;
        }

        if ($type->isBuiltin() === false) {
            return $value;
        }

        return match ($type->getName()) {

            'string' => $value,

            'int' => filter_var(
                $value,
                FILTER_VALIDATE_INT
            ) !== false
                ? (int) $value
                : throw new RuntimeException(
                    "Invalid integer route parameter: {$parameter->getName()}"
                ),

            'float' => is_numeric($value)
                ? (float) $value
                : throw new RuntimeException(
                    "Invalid float route parameter: {$parameter->getName()}"
                ),

            'bool' => match ($value) {
                '1', 'true' => true,
                '0', 'false' => false,
                default => throw new RuntimeException(
                    "Invalid boolean route parameter: {$parameter->getName()}"
                )
            },

            default => $value,
        };
    }

    /**
     * Clear routes and middleware.
     * Useful for testing.
     */
    public static function reset(): void
    {
        self::$routes = [];
        self::$globalMiddleware = [];
    }
}

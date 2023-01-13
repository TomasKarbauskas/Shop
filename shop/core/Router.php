<?php

include_once __DIR__ . '/Request.php';

class Router
{
    private array $loadedRoutes;

    public function get(string $path, array $callback): void
    {
        $this->loadRoutes('get', $path, $callback);
    }

    public function post(string $path, array $callback): void
    {
        $this->loadRoutes('post', $path, $callback);
    }

    public function put(string $path, array $callback): void
    {
        $this->loadRoutes('put', $path, $callback);
    }

    public function delete(string $path, array $callback): void
    {
        $this->loadRoutes('delete', $path, $callback);
    }

    public function loadRoutes(string $method, string $path, array $callback): void
    {
        $this->loadedRoutes[$method][$path] = $callback;
    }

    public function getLoadedRoutes(): array
    {
        return $this->loadedRoutes;
    }

    public function getRoute($requestMethod, $requestUri)
    {
        return $this->loadedRoutes[$requestMethod][$requestUri] ?? [];
    }

    public function callAction($action, $parameters = [])
    {
        if ($action) {
            $controllerPath = $action[0];
            $controllerMethod = $action[1];
            include_once __DIR__ . "/../$controllerPath.php";
            $controller = basename($action[0]);
            $instance = new $controller;
            $reflect = $this->reflect($controller, $controllerMethod);
            $parameters = $parameters + $reflect;
            call_user_func_array([$instance, $controllerMethod], $parameters);
        } else {
            echo http_response_code(404);
            exit('PAGE NOT FOUND');
        }
    }

    public function reflect($class, $method): array
    {
        $refClass = new ReflectionClass($class);
        $refArguments = $refClass->getMethod($method);
        $parameters = $refArguments->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            if ($parameter->hasType()) {
                $type = $parameter->getType()->getName();
                $name = $parameter->getName();
                $file = $this->getFile(__DIR__ . "/$type.php");

                if ($file) {
                    $dependencies[$name] = new $type;
                }
            }
        }
        return $dependencies;
    }

    public function getFile(string $path)
    {
        $include = false;

        if (file_exists($path) && !class_exists(basename($path))) {
            $include = include_once $path;
        }

        return $include;
    }

    public function resolve(): void
    {
        $request = new Request();


        $requestUri = $request->uri();
        $requestMethod =  $request->method();
        if ($action = $this->getRoute($requestMethod, $requestUri)) {
            $this->callAction($action);
        } else {
            $match = $this->matchUris($requestMethod, $requestUri);
            $action = $this->getRoute($requestMethod, $match['matched_uri'] ?? '');
            $this->callAction($action, $match['parameters'] ?? []);
        }
    }

    public function matchUris(string $requestMethod, string $requestUri)
    {
        $requestUriSegments = explode('/', $requestUri);

        $result = [];

        foreach ($this->loadedRoutes[$requestMethod] as $routeUri => $routeAction) {
            $routeUriSegments = explode('/', $routeUri);

            if (count($requestUriSegments) !== count($routeUriSegments)) {
                continue;
            }

            $matched = $this->matchUriSegments($requestUriSegments, $routeUriSegments);
            $matched['matched_uri'] = implode('/', $matched['segments']);

            if ($matched['matched_uri'] === $routeUri) {
                $result = $matched;
            }
        }

        return $result;
    }

    public function matchUriSegments(array $requestUriSegments, array $routeUriSegments): array
    {
        $match = [];

        foreach ($routeUriSegments as $key => $routeUriSegment) {
            if ($requestUriSegments[$key] === $routeUriSegment) {
                $match['segments'][] = $routeUriSegment;
            } elseif ($parameter = $this->parameter($routeUriSegment)) {
                $match['segments'][] = $routeUriSegment;
                $match['parameters'][$parameter] = $requestUriSegments[$key];
            }
        }

        return $match;
    }

    public function parameter(string $value): string
    {
        $parameter = '';

        if (str_starts_with($value, '{') && str_ends_with($value, '}')) {
            $parameter = substr($value, 1, -1);
        }

        return $parameter;
    }
}

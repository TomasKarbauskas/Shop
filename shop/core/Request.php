<?php
declare(strict_types = 1);

class Request
{
    public static function uri(): string
    {
        $path = $_SERVER['REQUEST_URI'] ?? "/";

        $position = strpos($path, '?');
        if ($position === false) {
            return $path;
        }

        return substr($path, 0, $position);
    }

    public function get(string $key)
    {
        $all = $this->all();
        return $all[$key] ?? '';
    }

    public function baseUri(): string
    {
        return $_SERVER['HTTP_HOST'] ?? "/";
    }

    public function method(): string
    {
        $method = $this->get("_method");
        return strtolower($method ?: $_SERVER['REQUEST_METHOD']);
    }

    public function all(): array
    {
        if ($_FILES) {
            return $_REQUEST + ['files' => $_FILES];
        }

        return $_REQUEST;
    }

    public function getHost(): string
    {
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
    }
}

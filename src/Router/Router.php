<?php

namespace bits\Router;

use ReflectionException;
use ReflectionMethod;

class Router
{
    private $routes = [];

    public function __construct()
    {
        $this->routes = [];
    }

    public function get(string $route, array $handler)
    {
        $this->add("GET", $route, $handler);
    }

    public function post(string $route, array $handler)
    {
        $this->add("POST", $route, $handler);
    }

    public function put(string $route, array $handler)
    {
        $this->add("PUT", $route, $handler);
    }

    public function delete(string $route, array $handler)
    {
        $this->add("DELETE", $route, $handler);
    }

    public function patch(string $route, array $handler)
    {
        $this->add("PATCH", $route, $handler);
    }

    public function any(array $methods, string $route, array $handler)
    {
        foreach ($methods as $method) {
            $this->add($method, $route, $handler);
        }
    }

    public function add(string $method, string $route, array $handler)
    {
        $m = strtoupper($method);
        $this->routes[$m] = $this->routes[$m] ?? [];
        $this->routes[$m][$route] = $this->routes[$m][$route] ?? [];
        $this->routes[$m][$route][] = $handler;
    }

    public function handle(string $route, string $method)
    {
        $routes = $this->routes[strtoupper($method)];
        if (!isset($routes)) {
            return null;
        }
        $url = $route;
        foreach ($routes as $route => $handlers) {
            $res = preg_replace("/\//", "\/", $route);
            $res = preg_replace("/:[^\/]+/", "([^\/]*)", $res);
            preg_match("/^$res$/", $url, $matches);
            if (count($matches) > 0) {
                array_shift($matches);
                foreach ($handlers as $handler) {
                    try {
                        $method = new ReflectionMethod($handler[0], $handler[1]);
                    } catch (ReflectionException $e) {
                        continue;
                    }
                    $res = $method->invokeArgs($handler[0], $matches);
                    if ($res === null) {
                        continue;
                    }
                    return $res;
                }
            }
        }
    }
}

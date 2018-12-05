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

    /**
     * Register a route on a method.
     *
     * The handler is a array with the first item is the
     * controller class and the second is the method that
     * will handle the route.
     *
     * @param string $method
     * @param string $route
     * @param array $handler
     */
    public function add(string $method, string $route, array $handler)
    {
        $m = strtoupper($method);
        $this->routes[$m] = $this->routes[$m] ?? [];
        $this->routes[$m][$route] = $this->routes[$m][$route] ?? [];
        $this->routes[$m][$route][] = $handler;
    }

    /**
     * Handles a route.
     *
     * @param string $route
     * @param string $method
     * @return mixed|string|string[]|null
     */
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
                    $instance = new $handler[0]();
                    $res = call_user_func_array([$instance, $handler[1]], $matches);
                    if ($res === null) {
                        continue;
                    }
                    return $res;
                }
            }
        }
        return null;
    }
}

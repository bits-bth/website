<?php

namespace bits\Request;

class Request
{
    private $route;
    private $path;

    private $method;
    private $server;
    private $post;
    private $get;

    public function __construct()
    {
        $path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        $this->route = str_replace($path, '', $_SERVER['REQUEST_URI']);
        $this->path = str_replace($this->route, '', $path);

        $this->server = array_merge($_SERVER);
        $this->post = array_merge($_POST);
        $this->get = array_merge($_GET);
        $this->method = $this->getServer("REQUEST_METHOD", "GET");
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod($method): void
    {
        $this->method = $method;
    }

    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getServer(string $key, $default = null)
    {
        return $this->server[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getPost(string $key, $default = null)
    {
        return $this->post[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function getGet(string $key, $default = null)
    {
        return $this->get[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setServer(string $key, $value)
    {
        return $this->server[$key] = $value;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setPost(string $key, $value)
    {
        return $this->post[$key] = $value;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setGet(string $key, $value)
    {
        return $this->get[$key] = $value;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasServer(string $key): bool
    {
        return array_key_exists($key, $this->server);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasPost(string $key): bool
    {
        return array_key_exists($key, $this->post);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function hasGet(string $key): bool
    {
        return array_key_exists($key, $this->get);
    }
}

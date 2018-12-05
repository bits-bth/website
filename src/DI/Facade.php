<?php

namespace bits\DI;

abstract class Facade
{
    /** @var DI */
    public static $root;

    abstract public static function name(): string;

    /**
     * @param DI $root
     */
    public static function setRoot($root): void
    {
        static::$root = $root;
    }

    public static function __callStatic($name, $arguments)
    {
        $service = static::$root->get(static::name());

        switch (count($arguments)) {
            case 1:
                return $service->$name($arguments[0]);
            case 2:
                return $service->$name($arguments[0], $arguments[1]);
            case 3:
                return $service->$name($arguments[0], $arguments[1], $arguments[2]);
            case 4:
                return $service->$name($arguments[0], $arguments[1], $arguments[2], $arguments[3]);
            default:
                return call_user_func_array([$service, $name], $arguments);
        }
    }
}
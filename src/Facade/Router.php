<?php

namespace bits\Facade;

use bits\DI\Facade;

/**
 * @method static get(string $string, array $array)
 * @method static handle(string $getRoute, string $getMethod)
 */
class Router extends Facade
{
    public static function name(): string
    {
        return "router";
    }
}
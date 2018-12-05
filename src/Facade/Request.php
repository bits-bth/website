<?php

namespace bits\Facade;

use bits\DI\Facade;

/**
 * @method static getRoute(): string
 * @method static getMethod(): string
 * @method static getServer(string $key, $default): string
 */
class Request extends Facade
{
    public static function name(): string
    {
        return "request";
    }
}
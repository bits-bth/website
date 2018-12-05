<?php

namespace bits\Facade;

use bits\DI\Facade;

/**
 * @method static send($response)
 */
class Response extends Facade
{
    public static function name(): string
    {
        return "response";
    }
}
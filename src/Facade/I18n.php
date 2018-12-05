<?php

namespace bits\Facade;

use bits\DI\Facade;

/**
 * @method static parse(string $string): string
 */
class I18n extends Facade
{
    public static function name(): string
    {
        return "i18n";
    }
}
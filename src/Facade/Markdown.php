<?php

namespace bits\Facade;

use bits\DI\Facade;
use bits\Markdown\Content;

/**
 * @method static Content parse(string $markdown)
 * @method static Content getFile(string $file)
 */
class Markdown extends Facade
{
    public static function name(): string
    {
        return "markdown";
    }
}
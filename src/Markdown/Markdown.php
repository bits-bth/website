<?php

namespace bits\Markdown;

use bits\DI\ServiceProvider;
use Parsedown;

class Markdown extends ServiceProvider
{
    private $parser;

    public function __construct()
    {
        $this->parser = new Parsedown();
    }

    public static function name(): string
    {
        return "markdown";
    }

    public static function alias(): array
    {
        return ["md"];
    }

    public function getFile(string $path): Content
    {
        return $this->parse(file_get_contents($path));
    }

    public function parse(string $source): Content
    {
        $data = [];
        preg_match("/^---\n/", $source, $matches);
        if (count($matches) > 0) {
            preg_match("/---\n([\s\S]*)\n\.\.\.\n?/iuU", $source, $matches);
            $source = str_replace($matches[0], "", $source);
            spyc_load($matches[1]);
        }
        $html = $this->parser->text($source);
        return new Content($data, $html);
    }
}

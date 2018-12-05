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

    // function extract_post($path, $parser) {
    //     $file = file_get_contents($path);
    //     $data = null;
    //     if (starts_with($file, "---")) {
    //         preg_match("/---\n([\s\S]*)\n\.\.\.\n?/iuU", $file, $matches);
    //         $file = str_replace($matches[0], "", $file);
    //         $data = spyc_load($matches[1]);
    //         while (preg_grep("/.+@(en|sv)/", array_keys($data))) {
    //             $keys = preg_grep("/.+@(en|sv)/", array_keys($data));
    //             preg_match("/(.+)@(en|sv)/", $keys[0], $match);
    //             $data[$match[1]] = 
    //                 $match[2] === "sv" && $GLOBALS["LANG"] === "sv" ? $data[$keys[0]] :
    //                 $match[2] === "sv" && $GLOBALS["LANG"] === "en" ? $data[$keys[1]] :
    //                 $match[2] === "en" && $GLOBALS["LANG"] === "sv" ? $data[$keys[1]] :
    //                 $match[2] === "en" && $GLOBALS["LANG"] === "en" ? $data[$keys[0]] :
    //                 ""
    //             ;
    //             unset($data[$keys[0]]);
    //             unset($data[$keys[1]]);
    //         }
    //     }
    
    //     $languageContent = explode("<hr />", $parser->text($file));
    //     $swedish = $languageContent[0];
    //     $english = $languageContent[1];
    //     $content = $GLOBALS["LANG"] === "sv" ? $swedish : $GLOBALS["LANG"] === "en" ? $english : "";
    
    //     return [
    //         "content" => $content,
    //         "data" => $data
    //     ];
    // }
}

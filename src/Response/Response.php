<?php

namespace bits\Response;

use bits\DI\ServiceProvider;

class Response extends ServiceProvider
{
    private $statusCode;
    private $body;

    public static function name(): string
    {
        return "response";
    }

    public static function alias(): array
    {
        return ["res"];
    }

    public function send($body)
    {
        if (is_array($body)) {
            header("Content-Type: application/json; charset=utf8");
            echo json_encode($body);
        } else {
            echo $body;
        }
    }
}

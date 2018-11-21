<?php

namespace bits\Response;

class Response
{
    private $statusCode;
    private $body;

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

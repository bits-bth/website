<?php

$markdown = new \bits\Markdown\Markdown();
return [
    [
        "name" => "markdown",
        "callback" => $markdown
    ],
    [
        "name" => "md",
        "callback" => $markdown
    ]
];
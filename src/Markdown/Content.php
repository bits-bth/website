<?php

namespace bits\Markdown;

class Content
{
    /**@var array*/
    public $data;
    /**@var string*/
    public $html;

    /**
     * Content constructor.
     * @param array $data
     * @param string $html
     */
    public function __construct(array $data, string $html)
    {
        $this->data = $data;
        $this->html = $html;
    }
}

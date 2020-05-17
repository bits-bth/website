<?php

namespace bits\Controller;

use bits\Facade\I18n;
use bits\Facade\Markdown;

class DevController
{

    public function handleIndex($file)
    {
        return Markdown::getFile(INSTALL_PATH . "/content/" . ($file ?: "index") . ".md")->html;
    }

    public function about()
    {
        return I18n::parse("page.about.bits");
    }

    public function handleJSON()
    {
        return [
            "name" => "Martin Hövre",
            "id" => "ocpu"
        ];
    }
}

<?php

namespace bits\Controller;

use bits\Facade\Markdown;

class FlatFileController
{
    public function serveFile($file)
    {
        $file = $file ?: "index";
        $path = INSTALL_PATH . "/content/$file.md";
        if (file_exists($path)) {
            $content = Markdown::getFile($path);
            return $content->html;
        }
        return null;
    }
}

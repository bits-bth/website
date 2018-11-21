<?php
return [
    [
        "name" => "i18n",
        "callback" => function () {
            global $di;

            $i18n = new \bits\Translation\I18n();
            $i18n->setDI($di);

            foreach (glob(INSTALL_PATH . "/config/translations/*.php") as $file) {
                $language = basename($file, ".php");
                $i18n->add($language, require $file);
            }

            return $i18n;
        }
    ]
];
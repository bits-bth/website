<?php

namespace bits\Translation;

use bits\Facade\Request;
use bits\DI\ServiceProvider;

class I18n extends ServiceProvider
{
    private $translations = [];

    public static function name(): string
    {
        return "i18n";
    }

    public function boot()
    {
        foreach (glob(INSTALL_PATH . "/config/translations/*.php") as $file) {
            $language = basename($file, ".php");
            I18n::add($language, require $file);
        }
    }

    public function add(string $language, array $translations)
    {
        $this->translations[$language] = array_merge($this->translations[$language] ?? [], $translations);
    }

    public function parse(string $key, ?string $language = null): string
    {
        $lang = $language ?: $this->getLanguageTarget();
        return $this->translations[$lang][$key];
    }

    /**
     * @return string The language target found (default: en_US)
     */
    private function getLanguageTarget(): string
    {
        $languages = explode(",", Request::getServer("HTTP_ACCEPT_LANGUAGE", "en_US"));
        foreach ($languages as $lang) {
            $lang = explode(";", $lang)[0];
            if (isset($this->translations[$lang])) {
                return $lang;
            } else {
                $keys = [];
                foreach ($this->translations as $key => $value)
                    if (substr($key, 0, strlen($lang)) === $lang)
                        $keys[] = $key;

                if (count($keys) == 1) return $keys[0];
                elseif (count($keys) == 0) continue;
                else {
                    // TODO: Determinate a better translation
                    return $keys[0];
                }
            }
        }
        return "en_US";
    }
}
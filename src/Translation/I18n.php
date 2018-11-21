<?php

namespace bits\Translation;

use bits\DI\IDIContainer;
use bits\DI\TDIContainer;

class I18n implements IDIContainer
{
    use TDIContainer;

    private $translations = [];

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
     * @throws TranslationTargetNotFoundException If no language target was found.
     */
    private function getLanguageTarget(): string
    {
        $languages = explode(",", $this->di->request->getServer("HTTP_ACCEPT_LANGUAGE", "en_US"));
        foreach ($languages as $lang) {
            if (isset($this->translations[$lang]))
                return $lang;
            else {
                $keys = [];
                foreach ($this->translations as $key => $value)
                    if (substr($key, 0, strlen($lang)) === $lang)
                        $keys[] = $key;

                if (count($keys) == 1) return $keys[0];
                elseif (count($keys) == 0) throw new TranslationTargetNotFoundException($lang);
                else {
                    // TODO: Determinate a better translation
                    continue;
                }
            }
        }
        return "en_US";
    }
}
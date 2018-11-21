<?php

namespace bits\Translation;

class TranslationTargetNotFoundException extends \Exception
{
    public function __construct($languageTarget)
    {
        parent::__construct("$languageTarget not found in your translations");
    }
}
<?php

namespace bits\Common;

class Util
{
    public static function is_assoc($array): bool
    {
        return is_array($array) && array_diff_key($array, array_keys(array_keys($array)));
    }
}

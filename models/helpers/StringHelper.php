<?php

namespace app\models\helpers;

class StringHelper
{
    public static function filterString(string $string)
    {
        return strip_tags(addslashes($string));
    }
}
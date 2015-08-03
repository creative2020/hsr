<?php

namespace hji\common\utils;

class HTTP
{
    public static function getParameter($paramName, $defaultValue = false)
    {
        $value = false;
        
        if (isset($_POST[$paramName]))
        {
            $value = stripslashes(trim($_POST[$paramName]));
        }
        else if (isset($_GET[$paramName]))
        {
            $value = stripslashes(trim($_GET[$paramName]));
        }
        
        return (!empty($value)) ? $value : $defaultValue;
    }
}

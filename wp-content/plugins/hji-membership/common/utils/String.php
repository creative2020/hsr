<?php

namespace hji\common\utils;

class String
{
    static function truncate($s, $length)
    {
        if (!empty($s) && is_string($s))
        {
            if (strlen($s) > $length)
            {
                $s = substr($s, 0, $length) . '...';
            }
        }
        
        return $s;
    }
    
    static function toBoolean($s)
    {
        $b = false;
        
        if (isset($s) && ($s !== false))
        {
            if ($s === true)
            {
                $b = true;
            }
            else
            {
                $s = strtolower(trim($s));
        
                if (ctype_digit($s))
                {
                    $b = (intval($s) != 0) ? true : false;
                }
                else if (($s == 'true') || ($s == 'yes') || ($s == 'y') || ($s == 'on') || ($s == 't'))
                {
                    $b = true;
                }
            }
        }
        
        return $b;
    }
    
    static function toInteger($s)
    {
        $i = 0;
        
        if (!is_array($s) && !is_object($s))
        {
            $i = intval($s);
        }
        
        return !is_nan($i) ? $i : 0;
    }    
}
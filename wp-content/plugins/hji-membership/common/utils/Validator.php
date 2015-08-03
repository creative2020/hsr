<?php

namespace hji\common\utils;

class Validator
{
    private static $licenseKeyRegex;
    
    public static function isLicenseKey($value)
    {
        if (empty(self::$licenseKeyRegex))
        {
            self::$licenseKeyRegex = '/^[A-Z0-9]{4}\-[A-Z0-9]{4}\-[A-Z0-9]{4}(\-[A-Z0-9]{4})?$/';
        }
        
        return (preg_match(self::$licenseKeyRegex, $value) === 1);
    }    
}

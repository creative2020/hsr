<?php
namespace hji\common\utils;


class WPCache
{
    /**
     * @param                          $transient
     * @param                          $value
     * @param \hji\common\utils\in|int $expiration in hours
     */
    function setCache($transient, $value, $expiration = 24)
    {
        $seconds = 60*60*$expiration;

        set_transient($transient, $value, $seconds);
    }


    function getCache($transient)
    {
        return get_transient($transient);
    }
} 
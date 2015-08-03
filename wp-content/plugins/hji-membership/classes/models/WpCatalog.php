<?php
namespace hji\membership\models;

use hji\membership\Membership;

class WpCatalog
{
    const PROD_HOST = 'http://membership.homejunction.com';
    const STAGING_HOST  = 'http://membership-test.homejunction.com';


    private static function _getToken()
    {
        $membership = Membership::getInstance();

        return $membership->customerModel->license->token;
    }


    static function getHost()
    {
        $membership = \hji\membership\Membership::getInstance();

        if ($membership->apiController->api->isStagingServer())
        {
            return self::STAGING_HOST;
        }

        return self::PROD_HOST;
    }


    private static function request($endpoint, $slug = false)
    {
        if (!$token = self::_getToken())
        {
            return false;
        }

        // Break token into parts to use last part for cacheToken

        $tParts = explode('-', $token);

        // Cache token keeps cache relevant to the actual authentication token

        $cacheToken = array_pop($tParts);

        require_once(Membership::$dir . '/common/utils/WPCache.php');
        $cacheTransport = new \hji\common\utils\WPCache();
        $cacheTransient = 'wpcatalog_' . $cacheToken. '_' . $endpoint . '_' . $slug;

        if ($cache = $cacheTransport->getCache($cacheTransient))
        {
            return $cache;
        }

        $url = self::getHost() . '/' . $token . '/' . $endpoint;

        $url .= ($slug) ? '/' . $slug : '';

        $result = wp_remote_get($url);

        $json = wp_remote_retrieve_body($result);

        $data = json_decode($json, true);

        if (JSON_ERROR_NONE == json_last_error() && isset($data['result']))
        {
            $cacheTransport->setCache($cacheTransient, $data['result'], 12);

            return $data['result'];
        }

        return false;
    }


    static function browse()
    {
        return self::request('browse');
    }


    static function info($slug)
    {
        return self::request('info', $slug);
    }


    static function getInfoUrl($slug)
    {
        if (!$token = self::_getToken())
        {
            return false;
        }

        $url = self::getHost() . '/' . $token . '/info';

        $url .= ($slug) ? '/' . $slug : '';

        return $url;
    }


    static function download($slug)
    {
        return self::request('download', $slug);
    }
} 
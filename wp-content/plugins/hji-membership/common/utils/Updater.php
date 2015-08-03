<?php

namespace hji\common\utils;

use \hji\membership\Membership;
use \hji\membership\models\WpCatalog;

class Updater
{
//    const URL = 'http://wp.homejunction.com/updates/plugins';
    
    public function __construct($plugin)
    {
        require_once(Membership::$dir . '/third-party/updater/plugin-update-checker.php');
        
        $slug = basename(dirname($plugin));

        if ($infoURL = WpCatalog::getInfoUrl($slug))
        {
            $this->checker = new \PluginUpdateChecker($infoURL, $plugin, $slug);
        }
    }
}

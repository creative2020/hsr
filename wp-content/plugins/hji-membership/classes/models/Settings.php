<?php

namespace hji\membership\models;

use hji\common\AbstractSettingsModel;
use hji\membership\Membership;

require_once(Membership::$dir . '/common/interfaces/AbstractSettingsModel.php');

class Settings extends \hji\common\interfaces\AbstractSettingsModel
{
    protected static $__CLASS__ = __CLASS__; // Provide this in each singleton class.

    const KEY = 'hji-membership-settings';


    public function __construct()
    {
        parent::__construct('membership', self::KEY);

        $this->loadOptions();

        $data = $this->settings;

        $this->licenseKey = !empty($data['license-key']) ? trim($data['license-key']) : false;
    }
}
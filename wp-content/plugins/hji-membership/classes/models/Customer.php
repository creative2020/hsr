<?php
namespace hji\membership\models;


class Customer
{
    private static $_instance;

    // Option name where customer data is being saved,
    // Which is returned on license key authentication:
    // customer, products, markets etc.

    const AUTH_DATA = 'hji-membership-customer';

    public $license     = false;
    public $customer    = false;
    public $markets     = false;


    static function getInstance()
    {
        if (!( self::$_instance instanceof self))
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }


    function __construct()
    {
        $authData = get_option(self::AUTH_DATA);
        $settingsData = get_option(Settings::KEY);

        if (isset($authData->license->licenseKey))
        {
            $this->license = $authData->license;
        }
        else
        {
            $this->license = new \stdClass();

            $this->license->licenseKey = !empty($settingsData['license-key']) ? trim($settingsData['license-key']) : false;

            $this->license->token = false;
            $this->license->expires = false;
        }

        if (isset($authData->customer))
        {
            $this->customer = $authData->customer;
        }

        if (isset($authData->markets))
        {
            $this->markets = $authData->markets;
        }

    }


    function update($data = false)
    {
        if (isset($data['licenseKey'])
            && isset($data['token'])
            && isset($data['expires']))
        {
            $this->license->licenseKey = $data['licenseKey'];
            $this->license->token = $data['token'];
            $this->license->expires = $data['expires'];

            if (isset($data['customer']))
            {
                $customer = new \stdClass();

                foreach ($data['customer'] as $k => $v)
                {
                    $customer->$k = $v;
                }

                $this->customer = $customer;
            }

            if (isset($data['markets']))
            {
                $this->markets = (is_array($data['markets']) && !empty($data['markets'])) ? $data['markets'] : false;
            }
        }
        else
        {
            $this->license->token = false;
            $this->license->expires = false;
        }

        update_option(self::AUTH_DATA, $this);
    }

}
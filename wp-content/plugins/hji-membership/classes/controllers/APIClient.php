<?php

namespace hji\membership\controllers;

use \hji\membership\Membership;
use \hji\common\utils\Validator;

use \hji\membership\models\Settings as M_Settings;
use \hji\membership\models\Customer;

use \hji\common\utils\APIClient as M_APIClient;

class APIClient
{
    private $customerModel;
    private $settingsModel;

    public $api;


    function __construct()
    {
        $this->customerModel = Customer::getInstance();
        $this->settingsModel  = M_Settings::getInstance();

        $this->authenticate();

        //TODO: test this
        // add_action('wp_ajax_hjiAjaxApiCall', array($this, 'hjiAjaxApiCall'));

    }


    function authenticate($force = false)
    {
//        require_once(Membership::$dir . '/common/utils/Validator.php');
//
//        if (Validator::isLicenseKey($this->settingsModel->licenseKey) !== false)
//        {
//            $licenseKey = $this->settingsModel->licenseKey;
//        }
//        else
//        {
//            return;
//        }

        $licenseKey = $this->settingsModel->licenseKey;

        if (!is_object($this->api))
        {
            require_once(Membership::$dir . '/common/utils/APIClient.php');
            $this->api = new M_APIClient($licenseKey);

            require_once(Membership::$dir . '/common/utils/WPCache.php');

            $this->api->setCacheTransport(new \hji\common\utils\WPCache());

            if (defined('HJI_DEV') && HJI_DEV == true)
            {
                $this->api->setDeveloperMode(true);
            }
        }

        // util/APIClent will update customer model
        $this->api->authenticate($force);

        if ($this->api->getErrors())
        {
            add_action('admin_notices', array($this, 'authFailureNotice'));
        }

    }


    function authFailureNotice()
    {
        echo '<div id="message" class="error"><p><strong>' . $this->api->getErrors() . '</strong> Check your <a href="' . admin_url('admin.php?page=' . Membership::$slug) . '">' . Membership::NAME . ' Settings</a> or contact customer support.</p></div>';
    }


    /** AJAX API Methods */

    //TODO: Test this
    function _ajaxApiCall()
    {
        if ((!isset($_POST['method']) || empty($_POST['params'])))
        {
            die(-1);
        }

        $method = trim($_POST['method']);

        if (!method_exists($this->api, $method))
        {
            $response = array(
                'success'   => false,
                'error'     => array(
                    'message' => 'API Method ' . $method . ' doesn\'t exist'
                )
            );

            die(json_encode($response));
        }


        $results = $this->apiController->api->$method($_POST['params']);

        if ($results && !$this->apiController->api->getErrors())
        {
            $response = array(
                'success'   => true,
                'data'     => array(
                    $results
                )
            );
            die(json_encode($response));
        }
        else if ($error = $this->apiController->api->getErrors())
        {
            $response = array(
                'success'   => false,
                'error'     => array(
                    'message' => $error
                )
            );

            die(json_encode($response));
        }

        $response = array(
            'success'   => false,
            'error'     => array(
                'message' => 'Request failed.'
            )
        );

        die(json_encode($response));
    }


    /**
     * Deprecated since 1.0.4
     *
     * returning instance via Membership
     */
    static function getInstance()
    {
        _deprecated_function('getInstance', '1.0.4', 'Membership::$apiController');

        $membership = Membership::getInstance();

        return $membership->apiController;
    }
}
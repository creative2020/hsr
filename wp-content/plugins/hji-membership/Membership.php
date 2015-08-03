<?php

namespace hji\membership;

/*
    Plugin Name: HJI Membership
    Description: Core functionality required by all other Home Junction plugins.
    Version: 1.0.9
    Author URI: http://www.homejunction.com
    Author: Home Junction
*/

use hji\membership\controllers\CommonScripts;

class Membership
{
    const NAME = 'HJI Membership';

    const SUPPORT_EMAIL = 'help@homejunction.com';
    const SUPPORT_PHONE = '(858) 777-9533 Ext. 4';

    private static $_instance;

    private $_isLicensed = false;
    private $_authHasRan = false;

    public static $slug;
    public static $dir;
    public static $url;

    private $hji_mce_buttons = array();
    
    function __construct()
    {
        self::$slug = basename(dirname(__FILE__));
        self::$dir = WP_PLUGIN_DIR . '/' . self::$slug;
        self::$url = WP_PLUGIN_URL . '/' . self::$slug;

        // Using this as action
        add_filter('tiny_mce_plugins', array($this, 'consolidateHjiMceButtons'));
        add_filter('mce_buttons_4', array($this, 'addTinyMceButtons'), 99);

        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));

        add_action('admin_print_footer_scripts', array($this, 'adminFooterScripts'));

        add_action('admin_menu', array($this, 'admin_menu'));            
        add_action('init', array($this, 'init'));

        // Registering scripts for admin and front-end at once
        add_action('init', array($this, 'register_scripts'));

        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

        require_once(self::$dir . '/classes/controllers/Downloads.php');
        require_once(self::$dir . '/classes/controllers/Settings.php');
        require_once(self::$dir . '/classes/controllers/APIClient.php');
        require_once(self::$dir . '/classes/models/Customer.php');



        add_action('activated_plugin', array($this, 'loadThisPluginFirst'), 100);

        add_action('plugins_loaded', array($this, 'initMembershipPlugins'));
    }


    /**
     * Instantiating classes separately only once
     *
     * @since 1.0.4
     */
    function initAccessibleClasses()
    {
        $this->settingsController   = new controllers\Settings();
        $this->customerModel        = models\Customer::getInstance();
        $this->apiController        = new controllers\APIClient($this->customerModel);

        if ($this->isLicensed())
            $this->downloadsController = new controllers\Downloads();
    }


    /**
     * All membership plugin should have to hook into
     * hji_membership_init in order to initialize themselves
     *
     * @since 1.0.4
     */
    function initMembershipPlugins()
    {
        if ($this->isLicensed())
        {
            do_action('hji_membership_init');
        }
    }


    /**
     * Instance of the Membership Class
     *
     * @return Membership
     * @since   1.0.4
     */
    static function getInstance()
    {
        if (!( self::$_instance instanceof self))
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }


    /**
     * Checks if membership is licensed
     * based on last available authentication token.
     *
     * @return bool
     *
     * @since 1.0.4
     */
    function isLicensed()
    {
        // If authentication has ran in this session
        // return the existing result

        if ($this->_authHasRan)
        {
            return $this->_isLicensed;
        }

        $timestamp = time();

        $licenseKey = \hji\membership\models\Settings::getInstance()->licenseKey;

        // Is license key valid?
        require_once(Membership::$dir . '/common/utils/Validator.php');

        if (\hji\common\utils\Validator::isLicenseKey($licenseKey))
        {
            // Does customer have license data from previous authentication
            // and is authenticated license the same as in the settings?

            if (isset($this->customerModel->license->licenseKey)
                && $this->customerModel->license->licenseKey == $licenseKey)
            {

                // If token has not expired - return true

                if (isset($this->customerModel->license->token)
                    && $timestamp < $this->customerModel->license->expires)
                {
                    $this->_isLicensed = true;
                    return $this->_isLicensed;
                }

                // If expired

                else
                {
                    return $this->_doAuthentication();
                }
            }

            // Customer never authenticated in his life

            else
            {
                return $this->_doAuthentication();
            }
        }

        return $this->_isLicensed;
    }


    private function _doAuthentication()
    {
        // If we have not authenticate in this session - force it

        if (!$this->_authHasRan)
        {
            // Force authentication

            $this->apiController->authenticate(true);

            $this->_authHasRan = true;

            // Check if licensing data is good

            $this->_isLicensed = $this->isLicensed();
        }

        return $this->_isLicensed;
    }


    /**
     * Returns array of licensed markets
     * or false
     *
     * @return bool
     */
    function getMarkets()
    {
        $markets = (array) $this->customerModel->markets;
        return (!empty($markets)) ? array_keys($markets) : array();
    }


    /**
     * Forces Membership plugin to load first
     * Important, since we're calling common membership methods
     * from other HJI plugins.
     */
    function loadThisPluginFirst()
    {
        // ensure path to this file is via main wp plugin path
        $wp_path_to_this_file = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR."/$2", __FILE__);
        $this_plugin = plugin_basename(trim($wp_path_to_this_file));
        $active_plugins = get_option('active_plugins');
        $this_plugin_key = array_search($this_plugin, $active_plugins);

        if ($this_plugin_key)
        {
            // If it's 0 it's the first plugin already, no need to continue

            array_splice($active_plugins, $this_plugin_key, 1);
            array_unshift($active_plugins, $this_plugin);
            update_option('active_plugins', $active_plugins);
        }
    }


    function admin_menu()
    {
        add_menu_page(
            self::NAME,
            self::NAME,
            'manage_options',
            self::$slug,
            false,
            self::$url . '/resources/images/admin-menu.png'
        );
    }

    function init()
    {
        require_once(self::$dir . '/common/utils/Updater.php');

        $this->updater = new \hji\common\utils\Updater(__FILE__);
    }


    function register_scripts()
    {
        require_once(self::$dir . '/classes/controllers/CommonScripts.php');
        CommonScripts::register();

        wp_register_script('hji-membership-admin', self::$url . '/resources/scripts/admin.js', array('hji-membership'));
        wp_register_style('hji-membership-admin', self::$url . '/resources/styles/admin.css');

        wp_enqueue_style('selectize');

        $hjiCommonVars = array(
            'ajaxUrl'   => admin_url('admin-ajax.php'),
        );

        wp_localize_script('hji-common', 'hjiCommonVars', $hjiCommonVars);


        wp_register_script('hji-membership', self::$url . '/resources/scripts/membership.js', array('hji-common'));
        wp_register_style('hji-membership', self::$url . '/resources/styles/membership.css');
    }


    function enqueue_scripts()
    {
        wp_enqueue_script('hji-common');
        wp_enqueue_style('hji-common');

        if (!current_theme_supports('hji-twitter-bootstrap'))
        {
            wp_enqueue_style('hji-essential');
        }

        if (is_admin())
        {
            wp_register_script('hji-membership-admin', self::$url . '/resources/scripts/admin.js', array('hji-membership'));        
            wp_enqueue_style('hji-membership-admin', self::$url . '/resources/styles/admin.css');
        }

        // Load admin.js in Widgets dashboard

        if (stristr($_SERVER['REQUEST_URI'], 'widgets.php'))
        {
            wp_enqueue_script('hji-membership-admin');
        }
    }


    /**
     * Invoke js in the footer for common usage
     */
    function adminFooterScripts()
    {
        if (stristr($_SERVER['REQUEST_URI'], 'widgets.php'))
        {
            ?>
            <script type="text/javascript">
                jQuery(document).ready(function(){
                    HJI.Membership.Admin.autoSaveWidgets();
                });
            </script>
        <?php
        }
    }


    /**
     * Consolidating HJI MCE buttons into a single array.
     *
     * Before TinyMCE gets initialized, we're running custom filter
     * to gather all HJI buttons, so they can be added
     * to MCE panel at once.
     *
     * @param $plugins
     * @return mixed
     */
    function consolidateHjiMceButtons($plugins)
    {
        $this->hji_mce_buttons = apply_filters('hji_mce_buttons', $this->hji_mce_buttons);

        return $plugins;
    }


    function addTinyMceButtons($buttons)
    {
        if (empty($this->hji_mce_buttons))
        {
            return $buttons;
        }

        return array_merge($this->hji_mce_buttons, $buttons);
    }


}

Membership::getInstance();
Membership::getInstance()->initAccessibleClasses();

<?php

namespace hji\membership\controllers;

use \hji\membership\Membership;

use \hji\common\utils\HTTP;
use \hji\common\utils\String;
use \hji\common\utils\Validator;
use \hji\common\utils\View;

use \hji\common\models\Notices;

use \hji\membership\models\Settings as M_Settings;

require_once(Membership::$dir . '/classes/models/Settings.php');

class Settings
{
    public function __construct()
    {
        add_action('admin_init', array($this, 'admin_init'));
        add_action('admin_menu', array($this, 'admin_menu'));            
        add_action('admin_notices', array($this, 'admin_notices'));
    }

    function admin_init()
    {
        register_setting(M_Settings::KEY, M_Settings::KEY);
    }

    function admin_menu()
    {
        add_submenu_page(Membership::$slug,
                         Membership::NAME . ' | Settings',
                         'License Key',
                         'manage_options',
                         Membership::$slug,
                         array($this, 'add_submenu_page_callback'));
    }

    function admin_notices()
    {
        require_once(Membership::$dir . '/common/utils/HTTP.php');
        require_once(Membership::$dir . '/common/utils/Validator.php');

        $page = strtolower(HTTP::getParameter('page'));

        if ($page != Membership::$slug)
        {
            $settings = new M_Settings();

            if (Validator::isLicenseKey($settings->licenseKey) === false)
            {
?>
                <div class='updated'>
                    <p>
                        Before you can start using your <strong>Home Junction</strong> plugins, you must 
                        <a href='<?php echo admin_url('admin.php?page=' . Membership::$slug) ?>'>enter</a>
                        a valid license key.
                    </p>
                </div>
<?php            
            }
        }

    }

    
    function add_submenu_page_callback()
    {
        require_once(Membership::$dir . '/common/utils/HTTP.php');
        require_once(Membership::$dir . '/common/utils/String.php');
        require_once(Membership::$dir . '/common/models/Notices.php');
        require_once(Membership::$dir . '/common/utils/View.php');

        require_once(Membership::$dir . '/classes/models/Settings.php');

        $page = strtolower(HTTP::getParameter('page'));
        
        $notices = new Notices();

        if ($page == Membership::$slug)
        {
            $updated = HTTP::getParameter('settings-updated');
                
            if (String::toBoolean($updated) == true)
            {
                $notices->addNotice('Your settings have been saved.');

                // Re-authenticate API

                Membership::getInstance()->apiController->authenticate(true);
            }

            wp_enqueue_script('hji-membership-admin');
                        
            $settings = new M_Settings();
            
            echo View::render(Membership::$dir . '/classes/views/settings.phtml',
                              array('settings' => $settings, 'notices' => $notices));
        }
    }
}

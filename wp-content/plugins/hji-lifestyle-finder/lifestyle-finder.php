<?php
namespace hji\lifestylefinder;

/*
    Plugin Name: HJI Lifestyle Finder
    Description: Lifestyle Finder by Home Junction Inc.
    Version: 1.0.3
    Author URI: http://www.homejunction.com
    Author: Home Junction
*/

use \hji\membership\Membership;
use \hji\membership\models\Settings as M_Settings;
use \hji\common\utils\Validator;

class LifestyleFinder
{
    private $licenseKey;


    public function __construct()
    {
        add_action('hji_membership_init', array($this, 'init'));
    }


    function init()
    {
        if (class_exists('\hji\membership\Membership'))
        {
            $settings = new M_Settings();
            $this->licenseKey = $settings->licenseKey;
        }

        add_action('admin_init', array($this, 'initUpdater'));
        add_action('admin_notices', array($this, 'admin_notices'));

        if (!$this->licenseKey)
        {
            return;
        }

        add_shortcode('lifestyle_finder', array($this, 'shortcodeHandler'));
        add_filter('widget_text', 'do_shortcode');
        add_action('wp_enqueue_scripts', array($this, 'loadScripts'));
    }


    function loadScripts()
    {
        $lifestyleFinderApi = '//finder.homejunction.com/resources/api/api.js';
        wp_register_script('lifestyle-finder', $lifestyleFinderApi, array('jquery'), '1.0', false);
        wp_enqueue_script('lifestyle-finder');
    }


    /**
     * Lifestyle Finder Shortcode
     *
     * Supported parameters are optional: bookmark, width, height.
     *
     * Default values:
     * - bookmark = "/areas"
     * - width = "100%"
     * - height = "auto"
     *
     * Example:
     * [lifestyle_finder bookmark="/schools" width="90%" height="800px"]
     *
     * @param $atts array of keys to values: bookmark, width, height
     * @return string
     */
    function shortcodeHandler($atts)
    {
        extract(shortcode_atts(array(
                                    'licensekey'    => $this->licenseKey,
                                    'bookmark'      => '/areas',
                                    'width'         => '100%',
                                    'height'        => 'auto'
                               ), $atts));

        ob_start();

        ?>
        <div id="finder-wrapper">
            <script type="text/javascript">
            LifestyleFinder.embed(
            {
                licenseKey: '<?php echo $licensekey;?>',
                bookmark:   '<?php echo $bookmark;?>',
                width:      '<?php echo $width;?>',
                height:     '<?php echo $height;?>'
            });
            </script>
        </div>
        <?php

        $htmlOutput = ob_get_contents();
        ob_end_clean();

        return $htmlOutput;
    }


    /**
     * Plugin AutoUpdate
     */
    function initUpdater()
    {
        if (!class_exists('\hji\membership\Membership'))
        {
            return;
        }

        require_once(Membership::$dir . '/common/utils/Updater.php');

        $this->updater = new \hji\common\utils\Updater(__FILE__);
    }


    function admin_notices()
    {
        if (!class_exists('\hji\membership\Membership'))
        {
            ?>
            <div class='updated'>
                <p>
                    Before you can start using <strong>Lifestyle Finder</strong> plugin, you must
                    install and activate <strong>HJI Membership</strong> plugin and enter a valid license key.
                </p>
            </div>
        <?php
        }
    }
}

new LifestyleFinder;
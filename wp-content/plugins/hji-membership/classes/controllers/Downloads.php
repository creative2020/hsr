<?php

namespace hji\membership\controllers;

use \hji\membership\Membership;
use \hji\membership\models\WpCatalog;

require_once(Membership::$dir . '/classes/models/WpCatalog.php');

class Downloads
{
//    CONST CATALOG_URL = 'http://wp.homejunction.com/updates/catalog.php';

    private $catalog = false;

    static $plugins_settings_key = 'hj_plugins_options';
    static $themes_settings_key = 'hj_themes_options';

    private $plugins = false;
    private $themes = false;

    function __construct()
    {
        $this->menuSlug = Membership::$slug . '-downloads';
        
        if (is_admin())
        {
            add_action('admin_menu', array($this, 'add_menu'));

            add_action('admin_init', array($this, 'register_plugins_page'));
            add_action('admin_init', array($this, 'register_themes_page'));

            add_filter('install_themes_tabs', array($this, 'install_themes_tab'));
            add_filter('install_plugins_tabs', array($this, 'install_plugins_tab'));

            add_action('install_themes_pre_hj_themes', array($this, 'init_hj_themes_list_table'));
            add_action('install_plugins_pre_hj_plugins', array($this, 'init_hj_plugins_list_table'));
    
            add_action('install_themes_hj_themes', array($this, 'display_hj_themes'));
            add_action('install_plugins_hj_plugins', array($this, 'display_hj_plugins'));
    
            add_filter('themes_api_result', array($this, 'substitute_theme_api_results'), 12, 3);
            add_filter('plugins_api_result', array($this, 'substitute_plugin_api_results'), 12, 3);
    
            add_filter('themes_api', array($this, 'themes_api_before_request'), 12, 3);
            add_filter('plugins_api', array($this, 'plugins_api_before_request'), 12, 3);
    
            add_filter('theme_install_actions', array($this, 'theme_install_actions'), 12, 2);
            add_filter('plugin_install_action_links', array($this, 'plugin_install_action_links'), 12, 2);
    
            add_filter('install_theme_complete_actions', array($this, 'install_theme_complete_actions'), 12, 4);
            add_filter('install_plugin_complete_actions', array($this, 'install_plugin_complete_actions'), 12, 3);
        }
    }
    
    public function add_menu()
    {
        add_submenu_page(Membership::$slug,
                         Membership::NAME . ' | Product Library',
                         'Product Library',
                         'manage_options',
                         $this->menuSlug,
                         array($this, 'add_submenu_page_handler'));
    }

    public function add_submenu_page_handler()
    {
        $tab = isset($_GET['tab']) ? $_GET['tab'] : self::$plugins_settings_key;
        $_GET['tab'] = $tab;

        echo '<div class="wrap">';

        if ($this->getPluginsCatalog() || $this->getThemesCatalog())
        {
            $this->plugin_options_tabs();
        }

        do_settings_sections($tab);

        echo '</div>';
    }

    function getCatalog()
    {
        if (!$this->catalog)
        {
            $this->catalog = WpCatalog::browse();
        }

        return $this->catalog;
    }


    function getThemesCatalog()
    {
        $catalog = $this->getCatalog();

        if (!isset($catalog['themes']) || empty($catalog['themes']))
        {
            return;
        }

        return $catalog['themes'];
    }


    function getPluginsCatalog()
    {
        $catalog = $this->getCatalog();

        if (!isset($catalog['plugins']) || empty($catalog['plugins']))
        {
            return;
        }

        return $catalog['plugins'];
    }


    
    function install_themes_tab($tabs)
    {
        if (!$this->getThemesCatalog())
        {
            return $tabs;
        }

        $newTab = array();
        
        if (isset($_GET['page']) && ($_GET['page'] == $this->menuSlug))
        {
            $newTab['hj_themes_options'] = __('Home Junction Themes');
        }
        else
        {
            $newTab['hj_themes'] = __('Home Junction Themes');
        }

        return $tabs + $newTab;
    }

    function install_plugins_tab($tabs)
    {
        if (!$this->getPluginsCatalog())
        {
            return $tabs;
        }

        $newTab = array();
        
        if (isset($_GET['page']) && ($_GET['page'] == $this->menuSlug))
        {
            $newTab['hj_plugins_options'] = __('Home Junction Plugins');
        }
        else
        {
            $newTab['hj_plugins'] = __('Home Junction Plugins');
        }

        return $tabs + $newTab;
    }
    
    function plugin_options_tabs()
    {
        $current_tab = isset($_GET['tab']) ? $_GET['tab'] : self::$plugins_settings_key;

        echo '<div class="hji-membership-icon32 icon32"><br></div>';
        echo '<h2>Product Library</h2>';
        //screen_icon();
        echo '<h2 class="nav-tab-wrapper">';
        
        foreach ($this->plugin_settings_tabs as $tab_key => $tab_caption)
        {
            $active = $current_tab == $tab_key ? 'nav-tab-active' : '';
            echo '<a class="nav-tab ' . $active . '" href="?page=' . $this->menuSlug . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
        }
        
        echo '</h2>';
    }

    function register_plugins_page()
    {
        if ($this->getPluginsCatalog())
        {
            $this->plugin_settings_tabs[self::$plugins_settings_key] = 'Plugins';

            register_setting(self::$plugins_settings_key, self::$plugins_settings_key, array($this, 'validate_settings'));
        }

        add_settings_section('plugins_page', 'Home Junction Plugins', array($this, 'plugins_page'), self::$plugins_settings_key);
    }

    function register_themes_page()
    {
        if (!$this->getThemesCatalog())
        {
            return;
        }

        $this->plugin_settings_tabs[self::$themes_settings_key] = 'Themes';
            
        register_setting(self::$themes_settings_key, self::$themes_settings_key, array($this, 'validate_settings'));

        add_settings_section('themes_page', 'Home Junction Themes', array($this, 'themes_page'), self::$themes_settings_key);
    }

    public function validate_settings()
    {
                
    }

    public function themes_page()
    {
        wp_enqueue_script('theme-install');
        wp_enqueue_script('theme');

        $this->init_hj_themes_list_table();
        $this->display_hj_themes();
    }

    public function plugins_page()
    {
        if (!$this->getPluginsCatalog())
        {
            if (!Membership::getInstance()->isLicensed())
            {
                echo '<p>Please make sure your Membership license key is correct and authorized by Home Junction.</p>';
            }
            else
            {
                echo '<p>There are no products available for this License. Please contact customer support for details by email ' . Membership::SUPPORT_EMAIL . ' or call ' . Membership::SUPPORT_PHONE . '.</p>';
            }
            return;
        }

        wp_enqueue_script('plugin-install');
        add_thickbox();

        $this->init_hj_plugins_list_table();
        $this->display_hj_plugins();
    }

    public function get_plugins()
    {
        if (!$plugins = $this->getPluginsCatalog())
        {
            return;
        }

        $object_array = array();

        foreach ($plugins as $plugin)
        {
            $ct = new \stdClass;
            $ct->name = $plugin['name'];
            $ct->slug = @$plugin['slug'];
            $ct->version = $plugin['version'];
            $ct->author = (isset($plugin['author'])) ? $plugin['author'] : 'Home Junction';
            $ct->author_profile = '';
            $ct->requires = (isset($plugin['requires'])) ? $plugin['requires'] : '3.6';
            $ct->tested = (isset($plugin['tested'])) ? $plugin['tested'] : '3.6';
            $ct->rating = (isset($plugin['rating'])) ? $plugin['rating'] : 0;
            $ct->num_ratings = (isset($plugin['num_ratings'])) ? $plugin['num_ratings'] : 0;
            $ct->homepage = 'http://homejunction.com';
            $ct->description = @$plugin['sections']['description'];
            $ct->short_description = (isset($plugin['short_description'])) ? $plugin['short_description'] : @$plugin['sections']['description'];
            $ct->download_link = $plugin['download_url'];
            $ct->sections = @$plugin['sections'];

            $object_array[] = $ct;
        }

        return $object_array;
    }

    public function get_themes()
    {
        $theme_screenshot = Membership::$url . '/resources/images/screenshot.png';
        $theme_description = 'Home Junction real estate theme for WordPress.';

        if (!$themes = $this->getThemesCatalog())
        {
            return;
        }

        $object_array = array();
        foreach ($themes as $theme)
        {
            $ct = new \stdClass;
            $ct->name = $theme['name'];
            $ct->slug = @$theme['slug'];
            $ct->version = $theme['version'];
            $ct->author = (isset($theme['author'])) ? $theme['author'] : 'Home Junction Inc';
            $ct->preview_url = @$theme['preview_url'];
            $ct->screenshot_url = (isset($theme['screenshot'])) ? $theme['screenshot'] : $theme_screenshot;
            $ct->homepage = 'http://homejunction.com';
            $ct->description = @$theme['description'];
            $ct->download_link = $theme['download_url'];
            $ct->rating = 0;
            $ct->num_ratings = 0;

            $object_array[] = $ct;
        }

        return $object_array;
    }

    function get_theme($slug)
    {
        $themes = $this->get_themes();
        
        foreach ($themes as $theme)
        {
            if ($slug == $theme->slug)
            {
                return $theme;
            }
        }

        return NULL;
    }

    function get_plugin($slug)
    {
        $plugins = $this->get_plugins();
        
        foreach ($plugins as $plugin)
        {
            if ($slug == $plugin->slug)
            {
                return $plugin;
            }
        }

        return NULL;
    }

    /**
     * Displays HJ Themes under Appearance => Themes => Install Themes => Install HJ Themes
     * Runs in conjunction with action hook to alter theme_api, which returns the correct object array
     * to hj_themes_list_table
     */
    
    function display_hj_themes()
    {
        $this->hj_themes_list_table->display();
    }

    function display_hj_plugins()
    {
        $this->hj_plugins_list_table->display();
    }

    function themes_api_before_request($x, $action, $args)
    {
        if ((isset($_REQUEST['tab'])
            && ('hj_themes' == $_REQUEST['tab'] || 'hj_themes_options' == $_REQUEST['tab'])) ||
                isset($_REQUEST['isHJTheme']))
        {
            $args->isHJTheme = true;
            return $args;
        }

        return false;
    }

    function plugins_api_before_request($x, $action, $args)
    {
        if ((isset($_GET['tab']) && ('hj_plugins' == $_GET['tab'] || 'hj_plugins_options' == $_GET['tab']))
            || isset($_GET['isHJPlugin']))
        {
            $args->isHJPlugin = true;
            return $args;
        }
        
        return false;
    }

    function substitute_theme_api_results($res, $action, $args)
    {
          /*
         [0] => stdClass Object
                (
                    [name] => Alexandria
                    [slug] => alexandria
                    [version] => 2.0.12
                    [author] => tskk
                    [preview_url] => http://wp-themes.com/alexandria
                    [screenshot_url] => http://wp-themes.com/wp-content/themes/alexandria/screenshot.png
                    [rating] => 87.8
                    [num_ratings] => 28
                    [homepage] => http://wordpress.org/themes/alexandria
                    [description] => HTML5 & CSS3 Responsive WordPress Business theme with business style home page layout with welcome section, 3 product/services blocks and a client quote/testimonial section. 2 logo section layout options. 2 premade (Blue, Red) ready to use color schemes/skins. 3 widget areas in footer, 1 widget area in sidebar. 2 page layouts including a full width page template. Social media icons in footer.
                )
           */

        if (is_object($args) && property_exists($args, 'isHJTheme') && ($args->isHJTheme == 'hj_themes'))
        {


            //if slug is passed, then return just that theme

            if (isset($args->slug))
            {
                return $this->get_theme($args->slug);
            }

            //otherwise return all themes

            $result = new \stdClass();
            $result->themes = $this->get_themes();
            $result->info = array
            (
                'results' => count($result->themes)
            );
    
            return $result;
        }

        return $res;
    }

    function substitute_plugin_api_results($res, $action, $args)
    {
        if (is_object($args) && property_exists($args, 'isHJPlugin') && ($args->isHJPlugin == 'hj_plugins'))
        {
            //if slug is passed, then return just that theme

            if (isset($args->slug))
            {
                return $this->get_plugin($args->slug);
            }

            //otherwise return all themes

            $result = new \stdClass();
            $result->plugins = $this->get_plugins();
            $result->info = array
            (
                'results' => count($result->plugins)
            );

            return $result;
        }

        return $res;
    }

    function theme_install_actions($actions, $themes)
    {
        if (($_GET['tab'] != 'hj_themes') && ($_GET['tab'] != 'hj_themes_options'))
        {
            return $actions;
        }

        // Inject isHJPlugin into Details action link

        foreach ($actions as $i => $html_link)
        {
            if (stristr($html_link, 'theme-information') && !stristr($html_link, 'isHJTheme'))
            {
                $actions[$i] = str_replace('theme-information', 'theme-information&isHJTheme=1', $html_link);
            }
        }

        // Inject isHJPlugin into Install link

        foreach ($actions as $i => $html_link)
        {
            if (stristr($html_link, 'install-theme') && !stristr($html_link, 'isHJTheme'))
            {
                $actions[$i] = str_replace('install-theme', 'install-theme&isHJTheme=1', $html_link);
            }
        }

        return $actions;
    }

    function plugin_install_action_links($action_links, $plugin)
    {
        if (($_GET['tab'] != 'hj_plugins') && ($_GET['tab'] != 'hj_plugins_options'))
        {
            return $action_links;
        }

        // Inject isHJPlugin into Details action link

        foreach ($action_links as $i => $html_link)
        {
            if (stristr($html_link, 'plugin-information') && !stristr($html_link, 'isHJPlugin'))
            {
                $action_links[$i] = str_replace('plugin-information', 'plugin-information&isHJPlugin=1', $html_link);
            }
        }

        // Inject isHJPlugin into Install link

        foreach ($action_links as $i => $html_link)
        {
            if (stristr($html_link, 'install-plugin') && !stristr($html_link, 'isHJPlugin'))
            {
                $action_links[$i] = str_replace('install-plugin', 'install-plugin&isHJPlugin=1', $html_link);
            }
        }

        return $action_links;
    }

    function install_theme_complete_actions($install_actions, $api, $stylesheet, $theme_info)
    {
        if (isset($install_actions['themes_page']) && isset($_GET['isHJTheme']))
        {
            $install_actions['themes_page'] = '<a href="' . admin_url('admin.php?page=hji-membership-downloads&tab=hj_themes_options') .
                '" target="_parent">Return to Home Junction Themes</a>';
        }

        return $install_actions;
    }

    function install_plugin_complete_actions($install_actions, $api, $plugin_file)
    {
        if (isset($install_actions['plugins_page']) && isset($_GET['isHJPlugin']))
        {
            $install_actions['plugins_page'] = '<a href="' . admin_url('admin.php?page=hji-membership-downloads') .
                '" target="_parent">Return to Home Junction Plugins</a>';
        }

        return $install_actions;
    }

    /**
     * Action hook for install_themes_pre_ - fo initializing our own version of hj_themes_list_table
     * before themes are queried from remote server and rendered on the screen.
     */
 
    function init_hj_themes_list_table()
    {
        _get_list_table('WP_Theme_Install_List_Table');

        __inject_theme_table();
        
        $this->hj_themes_list_table = new Theme_Install_List_Table(array('themes', 'theme-install'));
        $this->pagenum = $this->hj_themes_list_table->get_pagenum();
        $this->hj_themes_list_table->prepare_items();
    }

    function init_hj_plugins_list_table()
    {
        _get_list_table('WP_Plugin_Install_List_Table');

        __inject_plugin_table();
        
        $screen = get_current_screen();
        
        $this->hj_plugins_list_table = new Plugin_Install_List_Table($screen->id);
        $this->pagenum = $this->hj_plugins_list_table->get_pagenum();
        $this->hj_plugins_list_table->prepare_items();
    }
}

function __inject_theme_table()
{
    class Theme_Install_List_Table extends \WP_Theme_Install_List_Table
    {
        function prepare_items()
        {
            //include(ABSPATH . 'wp-admin/includes/theme-install.php');
    
            global $tabs, $tab, $paged, $type, $theme_field_defaults;
            wp_reset_vars(array('tab'));
    
            $search_terms = array();
            $search_string = '';
            if (! empty($_REQUEST['s'])){
                $search_string = strtolower(wp_unslash($_REQUEST['s']));
                $search_terms = array_unique(array_filter(array_map('trim', explode(',', $search_string))));
            }
    
            if (! empty($_REQUEST['features']))
                $this->features = $_REQUEST['features'];
    
            $paged = $this->get_pagenum();
    
            $per_page = 36;
    
            // These are the tabs which are shown on the page,
            $tabs = array();
            $tabs['dashboard'] = __('Search');
            if ('search' == $tab)
                $tabs['search']	= __('Search Results');
            $tabs['upload'] = __('Upload');
            $tabs['featured'] = _x('Featured','Theme Installer');
            //$tabs['popular']  = _x('Popular','Theme Installer');
            $tabs['new']      = _x('Newest','Theme Installer');
            $tabs['updated']  = _x('Recently Updated','Theme Installer');
    
            $nonmenu_tabs = array('theme-information'); // Valid actions to perform which do not have a Menu item.
    
            $tabs = apply_filters('install_themes_tabs', $tabs);
            $nonmenu_tabs = apply_filters('install_themes_nonmenu_tabs', $nonmenu_tabs);
    
            // If a non-valid menu tab has been selected, And it's not a non-menu action.
            if (empty($tab) || (! isset($tabs[ $tab ]) && ! in_array($tab, (array) $nonmenu_tabs)))
                $tab = key($tabs);
    
            $args = array('page' => $paged, 'per_page' => $per_page, 'fields' => $theme_field_defaults);
    
            switch ($tab)
            {
                case 'search':
                    $type = isset($_REQUEST['type']) ? wp_unslash($_REQUEST['type']) : 'term';
                    switch ($type)
                    {
                        case 'tag':
                            $args['tag'] = array_map('sanitize_key', $search_terms);
                            break;
                        case 'term':
                            $args['search'] = $search_string;
                            break;
                        case 'author':
                            $args['author'] = $search_string;
                            break;
                    }
    
                    if (! empty($this->features))
                    {
                        $args['tag'] = $this->features;
                        $_REQUEST['s'] = implode(',', $this->features);
                        $_REQUEST['type'] = 'tag';
                    }
    
                    add_action('install_themes_table_header', 'install_theme_search_form', 10, 0);
                    break;
    
                case 'hj_themes':
                case 'hj_themes_options':
                case 'featured':
                    //case 'popular':
                case 'new':
                case 'updated':
                    $args['browse'] = $tab;
                    break;
    
                default:
                    $args = false;
            }
    
            if (! $args)
                return;
    
            $api = themes_api('query_themes', $args);
    
            if (is_wp_error($api))
                wp_die($api->get_error_message() . '</p> <p><a href="#" onclick="document.location.reload(); return false;">' . __('Try again') . '</a>');
    
            $this->items = $api->themes;
    
            $this->set_pagination_args(array(
                'total_items' => $api->info['results'],
                'per_page' => $per_page,
                'infinite_scroll' => true,
            ));
        }
    
    
        function single_row($theme)
        {
            global $themes_allowedtags;
    
            if (empty($theme))
            {
                return;
            }
    
            $name   = wp_kses($theme->name,   $themes_allowedtags);
            $author = wp_kses($theme->author, $themes_allowedtags);
    
            $preview_title = sprintf(__('Preview &#8220;%s&#8221;'), $name);
            $preview_url   = add_query_arg(array(
                'tab'   => 'theme-information',
                'theme' => $theme->slug,
            ));
    
            $actions = array();
    
            $install_url = add_query_arg(array(
                'action' => 'install-theme',
                'theme'  => $theme->slug,
            ), self_admin_url('update.php'));
    
            $update_url = add_query_arg(array(
                'action' => 'upgrade-theme',
                'theme'  => $theme->slug,
            ), self_admin_url('update.php'));
    
            $status = $this->_get_theme_status($theme);
    
            switch ($status)
            {
                default:
                case 'install':
                    $actions[] = '<a class="install-now" href="' . esc_url(wp_nonce_url($install_url, 'install-theme_' . $theme->slug)) . '" title="' . esc_attr(sprintf(__('Install %s'), $name)) . '">' . __('Install Now') . '</a>';
                    break;
                case 'update_available':
                    $actions[] = '<a class="install-now" href="' . esc_url(wp_nonce_url($update_url, 'upgrade-theme_' . $theme->slug)) . '" title="' . esc_attr(sprintf(__('Update to version %s'), $theme->version)) . '">' . __('Update') . '</a>';
                    break;
                case 'newer_installed':
                case 'latest_installed':
                    $actions[] = '<span class="install-now" title="' . esc_attr__('This theme is already installed and is up to date') . '">' . _x('Installed', 'theme') . '</span>';
                    break;
            }
    
            $actions[] = '<a class="install-theme-preview" href="' . esc_url($preview_url) . '" title="' . esc_attr(sprintf(__('Preview %s'), $name)) . '">' . __('Preview') . '</a>';
    
            $actions = apply_filters('theme_install_actions', $actions, $theme);
    
            ?>
            <a class="screenshot install-theme-preview" href="<?php echo esc_url($preview_url); ?>" title="<?php echo esc_attr($preview_title); ?>">
                <img src='<?php echo esc_url($theme->screenshot_url); ?>' width='150' />
            </a>
    
            <h3><?php echo $name; ?></h3>
            <div class="theme-author"><?php printf(__('By %s'), $author); ?></div>
    
            <div class="action-links">
                <ul>
                    <?php foreach ($actions as $action): ?>
                        <li><?php echo $action; ?></li>
                    <?php endforeach; ?>
                    <li class="hide-if-no-js"><a href="#" class="theme-detail"><?php _e('Details') ?></a></li>
                </ul>
            </div>
    
            <?php
            $this->install_theme_info($theme);
        }
    
        private function _get_theme_status($theme)
        {
            $status = 'install';
    
            $installed_theme = wp_get_theme($theme->slug);
    
            if ($installed_theme->exists())
            {
                if (version_compare($installed_theme->get('Version'), $theme->version, '='))
                    $status = 'latest_installed';
                elseif (version_compare($installed_theme->get('Version'), $theme->version, '>'))
                    $status = 'newer_installed';
                else
                    $status = 'update_available';
            }
    
            return $status;
        }    
    }
}

function __inject_plugin_table()
{
    class Plugin_Install_List_Table extends \WP_Plugin_Install_List_Table
    {
        function prepare_items()
        {
            if(isset($_GET['tab']) && $_GET['tab'] == 'hj_plugins_options')
                include(ABSPATH . 'wp-admin/includes/plugin-install.php');
    
            global $tabs, $tab, $paged, $type, $term;
    
            wp_reset_vars(array('tab'));
    
            $paged = $this->get_pagenum();
    
            $per_page = 30;
    
            // These are the tabs which are shown on the page
            $tabs = array();
            $tabs['dashboard'] = __('Search');
            if ('search' == $tab)
                $tabs['search']	= __('Search Results');
            $tabs['upload']    = __('Upload');
            $tabs['featured']  = _x('Featured', 'Plugin Installer');
            $tabs['popular']   = _x('Popular', 'Plugin Installer');
            $tabs['new']       = _x('Newest', 'Plugin Installer');
            $tabs['favorites'] = _x('Favorites', 'Plugin Installer');
    
            $nonmenu_tabs = array('plugin-information'); //Valid actions to perform which do not have a Menu item.
    
            $tabs = apply_filters('install_plugins_tabs', $tabs);
            $nonmenu_tabs = apply_filters('install_plugins_nonmenu_tabs', $nonmenu_tabs);
    
            // If a non-valid menu tab has been selected, And it's not a non-menu action.
            if (empty($tab) || (!isset($tabs[ $tab ]) && !in_array($tab, (array) $nonmenu_tabs)))
                $tab = key($tabs);
    
            $args = array('page' => $paged, 'per_page' => $per_page);
    
            switch ($tab)
            {
                case 'search':
                    $type = isset($_REQUEST['type']) ? wp_unslash($_REQUEST['type']) : 'term';
                    $term = isset($_REQUEST['s']) ? wp_unslash($_REQUEST['s']) : '';
    
                    switch ($type)
                    {
                        case 'tag':
                            $args['tag'] = sanitize_title_with_dashes($term);
                            break;
                        case 'term':
                            $args['search'] = $term;
                            break;
                        case 'author':
                            $args['author'] = $term;
                            break;
                    }
    
                    add_action('install_plugins_table_header', 'install_search_form', 10, 0);
                    break;
    
                case 'hj_plugins':
                case 'hj_plugins_options':
                case 'featured':
                case 'popular':
                case 'new':
                    $args['browse'] = $tab;
                    break;
    
                case 'favorites':
                    $user = isset($_GET['user']) ? wp_unslash($_GET['user']) : get_user_option('wporg_favorites');
                    update_user_meta(get_current_user_id(), 'wporg_favorites', $user);
                    if ($user)
                        $args['user'] = $user;
                    else
                        $args = false;
    
                    add_action('install_plugins_favorites', 'install_plugins_favorites_form', 9, 0);
                    break;
    
                default:
                    $args = false;
            }
    
            if (!$args)
                return;
    
            $api = plugins_api('query_plugins', $args);
    
            if (is_wp_error($api))
                wp_die($api->get_error_message() . '</p> <p class="hide-if-no-js"><a href="#" onclick="document.location.reload(); return false;">' . __('Try again') . '</a>');
    
            $this->items = $api->plugins;

            $this->set_pagination_args(array(
                'total_items' => $api->info['results'],
                'per_page' => $per_page,
           ));
        }
    
        function get_column_info()
        {
            return array(
                array(
                    'name'          => 'Name',
                    'version'       => 'Version',
                    'rating'        => 'Rating',
                    'description'   => 'Description'
                ),
                array(),
                array()
            );
        }
    }
}    
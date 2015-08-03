<?php
/**
 * Plugin Name: HSR Agent
 * Plugin URI: http://2020creative.com
 * Description: Agent Display
 * Version: 1.1
 * Author: 2020 Creative
 * Author URI: http://2020creative.com
 * License: @2014 2020Creative,Inc. and Home Spot Realty
 * GitHub Plugin URI: https://github.com/creative2020/hsr-agent
 * GitHub Branch: master
 */
 /*  Copyright 2014
 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/////////////////////////////////////////////////////////

define( 'TEMPPATH', get_stylesheet_directory_uri());
define( 'IMAGES', TEMPPATH. "/imgages");

// Custom fields adds the ACF plugin
define( 'ACF_LITE', false ); //hides the ACF interface in the dashboard
require_once ('ttp-lib/plugins/advanced-custom-fields/acf.php');
require_once ('ttp-lib/plugins/email-encoder-bundle/email-encoder-bundle.php');

// Shortcodes
require_once ('ttp-lib/ttp-shortcodes.php');

// CPT's
require_once ('ttp-lib/ttp-cpt.php');

// Plugin functions
require_once ('ttp-lib/ttp-functions.php');

/////////////////////////////////////////////////////////





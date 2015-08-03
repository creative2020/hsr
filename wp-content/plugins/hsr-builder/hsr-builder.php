<?php
/**
 * Plugin Name: hsr-builder
 * Plugin URI: http://2020creative.com
 * Description: Builder section
 * Version: 1.5
 * Author: 2020 Creative
 * Author URI: http://2020creative.com
 * Bitbucket Plugin URI: https://2020C:310design@bitbucket.org/2020C/hsr-builder
 * Bitbucket Branch: master
 * License: @2014 2020Creative,Inc. and Home Spot Realty
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

/////////////////////////////////////////////////////////////////////////////////// required

define( 'TEMPPATH', get_stylesheet_directory_uri());
define( 'IMAGES', TEMPPATH. "/imgages");

// Custom fields adds the ACF plugin
define( 'ACF_LITE', false ); //hides the ACF interface in the dashboard
require_once ('ttp-lib/plugins/advanced-custom-fields/acf.php');

// Shortcodes
require_once ('ttp-lib/ttp-shortcodes.php');

// CPT's
require_once ('ttp-lib/ttp-cpt.php');

// Plugin functions
require_once ('ttp-lib/ttp-functions.php');
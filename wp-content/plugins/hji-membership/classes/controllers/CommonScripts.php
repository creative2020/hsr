<?php
namespace hji\membership\controllers;

use \hji\membership\Membership;

/**
 * Included Scripts
 *
 *    Name - handle - type
 *
 * 1. HJI Twitter Bootstrap Essential - hji-essential|css
 * 2. HJI Common - hji-common|js|css
 * 3. MapBpx - hji-mapbox|js|css
 * 4. Google Maps API - google-maps-api|js
 * 5. BxSlider - bxslider|js|css
 * 6. Colorbox - colorbox|js|css
 * 7. FontAwesome - font-awesome|css
 */


class CommonScripts
{
    const IN_FOOTER = true;

    static function register()
    {
        // 1. HJI Twitter Bootstrap Essentials

        wp_register_style('hji-essential', Membership::$url . '/resources/styles/essential.min.css', array(), false);

        // 2. HJI Common

        wp_register_script('hji-common', Membership::$url . '/resources/scripts/common.js', array('jquery', 'google-maps-api'), false, self::IN_FOOTER);
        wp_register_style('hji-common', Membership::$url . '/resources/styles/common.css');

        // 3. MapBpx - https://www.mapbox.com/

        wp_register_script('hji-mapbox', 'http://api.tiles.mapbox.com/mapbox.js/v1.6.3/mapbox.js', array(), '1.6.3', self::IN_FOOTER);
        wp_register_style('hji-mapbox',  'http://api.tiles.mapbox.com/mapbox.js/v1.6.3/mapbox.css', array(), '1.6.3');

        // 4. Google Maps API

        wp_register_script('google-maps-api', 'http://maps.googleapis.com/maps/api/js?sensor=false', array(), 'latest', self::IN_FOOTER);

        // 5. BxSlider - http://bxslider.com/

        wp_register_script('bxslider', Membership::$url . '/third-party/jquery.bxslider/jquery.bxslider.min.js', array('jquery'), '4.1.1', self::IN_FOOTER);
        wp_register_style('bxslider', Membership::$url . '/third-party/jquery.bxslider/jquery.bxslider.css', array(), '4.1.1');

        // 6. Colorbox - http://www.jacklmoore.com/colorbox/

        wp_register_script('colorbox', Membership::$url . '/third-party/colorbox/jquery.colorbox-min.js', array('jquery'), '1.4.27', self::IN_FOOTER);
        wp_register_style('colorbox', Membership::$url . '/third-party/colorbox/colorbox.css', array(), '1.4.27');

        // 7. FontAwesome - http://fortawesome.github.io/Font-Awesome/

        wp_register_style('font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css', array(), 'latest');

    }
} 

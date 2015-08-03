<?php
/*
Author: 2020 Creative
URL: htp://2020creative.com
*/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////2020 Functions
define( 'TEMPPATH', get_stylesheet_directory_uri());
define( 'IMAGES', TEMPPATH. "/imgages");

// css

function hsr_agent_css() {
    wp_enqueue_style( 'ttp-agent-style', plugins_url( 'css/ttp-style.css', __FILE__ ) );
    //wp_enqueue_style( 'fontawesome-style', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' );
    //wp_enqueue_style( 'tt-slider-css', plugins_url( 'lightbox/lightbox.css', __FILE__ ) );
    
    //wp_enqueue_script( 'tt-slider', plugins_url( 'js/responsiveslides.min.js', __FILE__ ) );
    //wp_enqueue_script( 'google-ajax', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js' );
    
    //wp_enqueue_script( 'bootstrap-script', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js' );
    //wp_enqueue_style( 'bootstrap-style', '//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css' );
}

add_action( 'wp_enqueue_scripts', 'hsr_agent_css' );

////////////////////////////////////////////////////////
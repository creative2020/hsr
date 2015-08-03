<?php
/*
Author: 2020 Creative
URL: htp://2020creative.com
*/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////2020 Functions
define( 'TEMPPATH', get_stylesheet_directory_uri());
define( 'IMAGES', TEMPPATH. "/imgages");

// css

function hsr_builder_css() {
    wp_enqueue_style( 'ttp-builder-style', plugins_url( 'css/ttp-style.css', __FILE__ ) );
    wp_enqueue_style( 'fontawesome-style', '//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' );
    wp_enqueue_style( 'tt-slider-css', plugins_url( 'lightbox/lightbox.css', __FILE__ ) );
    
    //wp_enqueue_script( 'tt-slider', plugins_url( 'js/responsiveslides.min.js', __FILE__ ) );
    //wp_enqueue_script( 'google-ajax', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js' );
    
    //wp_enqueue_script( 'bootstrap-script', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js' );
    //wp_enqueue_style( 'bootstrap-style', '//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css' );
}

add_action( 'wp_enqueue_scripts', 'hsr_builder_css' );

add_post_type_support( 'builder', 'genesis-cpt-archives-settings' );

////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////// head script for slider

add_action('wp_head','hook_javascript');

function hook_javascript()
{

?> <script>$(function () {

      // Slideshow 1
      $("#slider1").responsiveSlides({
        maxwidth: 800,
        speed: 800
      });

      // Slideshow 2
      $("#slider2").responsiveSlides({
        auto: false,
        pager: true,
        speed: 300,
        maxwidth: 540
      });

      // Slideshow 3
      $("#slider3").responsiveSlides({
        manualControls: '#slider3-pager',
        maxwidth: 540
      });

      // Slideshow 4
      $("#slider4").responsiveSlides({
        auto: false,
        pager: false,
        nav: true,
        speed: 500,
        namespace: "callbacks",
        before: function () {
          $('.events').append("<li>before event fired.</li>");
        },
        after: function () {
          $('.events').append("<li>after event fired.</li>");
        }
      });

    });</script>

<?php


}
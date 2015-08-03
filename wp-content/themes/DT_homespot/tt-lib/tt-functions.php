<?php
/*
Author: 2020 Creative
URL: htp://2020creative.com
*/
//////////////////////////////////////////////////////// 2020 Functions
define( 'TEMPPATH', get_stylesheet_directory_uri());
define( 'IMAGES', TEMPPATH. "/imgages");

// Plugins
// require_once ('plugins/advanced-custom-fields/acf.php');
// require_once ('plugins/acf-options-page/acf-options-page.php');
require_once ('plugins/github-updater/github-updater.php');

// Shortcodes
require_once ('tt-shortcodes.php');

// CPT's
//require_once ('tt-cpt.php');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////// Taxonomies

// Register Custom Taxonomy

if ( ! function_exists( 'tt_taxonomy_area' ) ) {

// Register Custom Taxonomy
function tt_taxonomy_area() {

	$labels = array(
		'name'                       => 'locations', // plural name
		'singular_name'              => 'location', // singular name
		'menu_name'                  => 'Locations',
		'all_items'                  => 'All Items',
		'parent_item'                => 'Parent Item',
		'parent_item_colon'          => 'Parent Item:',
		'new_item_name'              => 'New Item Name',
		'add_new_item'               => 'Add New Item',
		'edit_item'                  => 'Edit Item',
		'update_item'                => 'Update Item',
		'separate_items_with_commas' => 'Separate items with commas',
		'search_items'               => 'Search Items',
		'add_or_remove_items'        => 'Add or remove items',
		'choose_from_most_used'      => 'Choose from the most used items',
		'not_found'                  => 'Not Found',
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'rewrite'                    => false,
	);
	register_taxonomy( 'location', array( 'listing_type' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'tt_taxonomy_area', 0 );

}

//////////////////////////////////////////////////////// Add shortcode functionality to text widgets

add_filter('widget_text', 'do_shortcode');

////////////////////////////////////////////////////////

if(function_exists('acf_add_options_page')) { 
 
	acf_add_options_page();
	acf_add_options_sub_page('Homepage');
	acf_add_options_sub_page('Footer');
 
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////// Fields

if( function_exists('register_field_group') ):

register_field_group(array (
	'key' => 'tt_homepage',
	'title' => 'Homepage',
	'fields' => array (
		array (
			'key' => 'hp_message',
			'label' => 'Message',
			'name' => 'hp_message',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'Enter your message',
			'prepend' => '',
			'append' => '',
			'formatting' => 'html',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
        array (
			'key' => 'field_hpbox1_img',
			'label' => 'Box1 Image',
			'name' => 'box1_image',
			'prefix' => '',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'return_format' => 'url',
		),
		array (
			'key' => 'field_hpbox1_headline',
			'label' => 'Box1 Headline',
			'name' => 'box1_headline',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'Enter your headline',
			'prepend' => '',
			'append' => '',
			'formatting' => 'html',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_hpbox1_link',
			'label' => 'Box1 Link',
			'name' => 'box1_link',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'www.homespotrealty.com/#',
			'prepend' => 'http://',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
        array (
			'key' => 'field_hpbox2_img',
			'label' => 'Box2 Image',
			'name' => 'box2_image',
			'prefix' => '',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'return_format' => 'url',
		),
		array (
			'key' => 'field_hpbox2_headline',
			'label' => 'Box2 Headline',
			'name' => 'box2_headline',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'Enter your headline',
			'prepend' => '',
			'append' => '',
			'formatting' => 'html',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_hpbox2_link',
			'label' => 'Box2 Link',
			'name' => 'box2_link',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'www.homespotrealty.com/#',
			'prepend' => 'http://',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
        array (
			'key' => 'field_hpbox3_img',
			'label' => 'Box3 Image',
			'name' => 'box3_image',
			'prefix' => '',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'return_format' => 'url',
		),
		array (
			'key' => 'field_hpbox3_headline',
			'label' => 'Box3 Headline',
			'name' => 'box3_headline',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'Enter your headline',
			'prepend' => '',
			'append' => '',
			'formatting' => 'html',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_hpbox3_link',
			'label' => 'Box3 Link',
			'name' => 'box3_link',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'www.homespotrealty.com/#',
			'prepend' => 'http://',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
        array (
			'key' => 'field_hpbox4_img',
			'label' => 'Box4 Image',
			'name' => 'box4_image',
			'prefix' => '',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'return_format' => 'url',
		),
		array (
			'key' => 'field_hpbox4_headline',
			'label' => 'Box4 Headline',
			'name' => 'box4_headline',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'Enter your headline',
			'prepend' => '',
			'append' => '',
			'formatting' => 'html',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_hpbox4_link',
			'label' => 'Box4 Link',
			'name' => 'box4_link',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'www.homespotrealty.com/#',
			'prepend' => 'http://',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
        array (
			'key' => 'field_hpbox5_img',
			'label' => 'Box5 Image',
			'name' => 'box5_image',
			'prefix' => '',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'return_format' => 'url',
		),
		array (
			'key' => 'field_hpbox5_headline',
			'label' => 'Box5 Headline',
			'name' => 'box5_headline',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'Enter your headline',
			'prepend' => '',
			'append' => '',
			'formatting' => 'html',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_hpbox5_link',
			'label' => 'Box5 Link',
			'name' => 'box5_link',
			'prefix' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'default_value' => '',
			'placeholder' => 'www.homespotrealty.com/#',
			'prepend' => 'http://',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-homepage',
			),
		),
	),
	'menu_order' => 1,
	'position' => 'normal',
	'style' => 'seamless',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
));

endif;

//////////////////////////////////////////////////////////////////////////////////////////////////////////////// CSS Enqueue Styles

if( !function_exists("tt_theme_styles") ) {  
    function tt_theme_styles() { 
        // parent theme
        // wp_register_style( 'tt-main', get_template_directory_uri() . '/css/tt-main.css', array(), '1.0', 'all' );
        // wp_enqueue_style( 'tt-main' );

        // child themes
        wp_enqueue_style( 'hsr-main', get_stylesheet_directory_uri() . '/tt-lib/css/tt-hsr-main.css', array('core'), '1.0', 'all' );
        //wp_enqueue_style( 'tt-beta-css', 'http://local3.homespotrealty.com/wp-content/themes/DT_homespot/tt-lib/css/tt-hsr-main.css', array('hsr-main'), '1.0', 'all' );
    }
}
add_action( 'wp_enqueue_scripts', 'tt_theme_styles',99 );

//wp_enqueue_style( $handle, $src, $deps, $ver, $media );

////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////// TT Admin

// Custom Backend Footer
add_filter('admin_footer_text', 'tt_custom_admin_footer');
function tt_custom_admin_footer() {
	echo '<span id="footer-thankyou">Developed by <a href="http://2020creative.com" target="_blank">2020creative.com</a></span>.';
}
// adding it to the admin area
add_filter('admin_footer_text', 'tt_custom_admin_footer');

////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////// Menus

register_nav_menus( array(
	'tt_main' => 'TT Main',
	
) );

//////////////////////////////////////////////////////////////////////////////////////////////////////////////// Sidebars

////////////////////////////////////////////////////////

$args = array(
	'name'          => __( 'TT Sidebar', 'theme_text_domain' ),
	'id'            => 'tt_sidebar',
	'description'   => '',
    'class'         => '',
	'before_widget' => '<li id="%1$s" class="widget %2$s">',
	'after_widget'  => '</li>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2>' );

register_sidebar( $args );

////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////// disable admin area

function tt_disable_admin_bar() { 
	if( ! current_user_can('edit_dashboard') )
		add_filter('show_admin_bar', '__return_false');	
}
add_action( 'after_setup_theme', 'tt_disable_admin_bar' );
 

function tt_redirect_admin(){
	if ( ! current_user_can( 'edit_dashboard' ) ){
		wp_redirect( site_url() . '/' );
		exit;		
	}
}
add_action( 'admin_init', 'tt_redirect_admin' );

////////////////////////////////////////////////////////

function tt_print_acf() {
    
    //$user_meta = get_user_meta(1);
    //print_r($user_meta);
}
add_action('admin_print_footer_scripts', 'tt_print_acf');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////// 


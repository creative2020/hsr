<?php
/*
Author: 2020 Creative
URL: htp://2020creative.com
Requirements: php5.5.*
*/
//////////////////////////////////////////////////////////////////////////////////////// 2020 CPT's

//////////////////////////////////////////////////////////////////////////////////////// CPT: Builder
add_action( 'init', 'cpt_builder_init' );
/**
 * Register a custom post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function cpt_builder_init() {
	$labels = array(
		'name'               => _x( 'floorplan', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'floorplan', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Builder', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'floorplan', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'floorplan', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Floorplan', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Floorplan', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Floorplan', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Floorplan', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Floorplans', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Floorplans', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Floorplans:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No floorplans found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No floorplans found in Trash.', 'your-plugin-textdomain' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'builder' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
        'menu_icon'          => '/wp-content/plugins/hsr-builder/images/hsr-admin-icon-sm.png',             
		'supports'           => array( 'title', 'editor', 'thumbnail', )
	);

	register_post_type( 'builder', $args );
}
////////////////////////////////////////////////////////////////////////////////////////    
    
//////////////////////////////////////////////////////////////////////////////////////// Taxonomies

//////////////////////////////////////////////////////////////////////////////////////// Taxonomy: builder
add_action( 'init', 'create_builder_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_builder_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Details', 'taxonomy general name' ),
		'singular_name'     => _x( 'Detail', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Details' ),
		'all_items'         => __( 'All Details' ),
		'parent_item'       => __( 'Parent Detail' ),
		'parent_item_colon' => __( 'Parent Detail:' ),
		'edit_item'         => __( 'Edit Detail' ),
		'update_item'       => __( 'Update Detail' ),
		'add_new_item'      => __( 'Add New Detail' ),
		'new_item_name'     => __( 'New Detail Name' ),
		'menu_name'         => __( 'Details' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'details' ),
	);

	register_taxonomy( 'details', array( 'builder' ), $args );
}
////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////// Custom Fields for Builder


// Create three meta boxes: floorplans (5 Images) , photos (5 images) and specs. 
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_description',
		'title' => 'Description',
		'fields' => array (
			array (
				'key' => 'description',
				'label' => 'Description',
				'name' => 'description',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
	
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'builder',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'the_content',
			),
		),
		'menu_order' => 0,
	));
    register_field_group(array (
		'id' => 'acf_plan-specifications',
		'title' => 'Plan Specifications',
		'fields' => array (
			array (
				'key' => 'field_53777bdefc2a4',
				'label' => 'Square Feet',
				'name' => 'square_feet',
				'type' => 'number',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array (
				'key' => 'field_53777bf1fc2a5',
				'label' => 'Bedrooms',
				'name' => 'bedrooms',
				'type' => 'number',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array (
				'key' => 'field_53777c07fc2a6',
				'label' => 'Bathroom',
				'name' => 'bathroom',
				'type' => 'number',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'builder',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'the_content',
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_photos',
		'title' => 'Photos',
		'fields' => array (
			array (
				'key' => 'field_53777ad4ff2d3',
				'label' => 'Photo 1',
				'name' => 'photo_1',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_53777af0ff2d4',
				'label' => 'Photo 2',
				'name' => 'photo_2',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_53777af9ff2d5',
				'label' => 'Photo 3',
				'name' => 'photo_3',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_53777b02ff2d6',
				'label' => 'Photo 4',
				'name' => 'photo_4',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_53777b0dff2d7',
				'label' => 'Photo 5',
				'name' => 'photo_5',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'builder',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 1,
	));
	register_field_group(array (
		'id' => 'acf_floorplans',
		'title' => 'Floorplans',
		'fields' => array (
			array (
				'key' => 'field_537779d54dc5a',
				'label' => 'Plan 1',
				'name' => 'plan_1',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_53777a3f4dc5b',
				'label' => 'Plan 2',
				'name' => 'plan_2',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_53777a504dc5c',
				'label' => 'Plan 3',
				'name' => 'plan_3',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_53777a5e4dc5d',
				'label' => 'Plan 4',
				'name' => 'plan_4',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_53777a6a4dc5e',
				'label' => 'Plan 5',
				'name' => 'plan_5',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'builder',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'the_content',
			),
		),
		'menu_order' => 2,
	));
}



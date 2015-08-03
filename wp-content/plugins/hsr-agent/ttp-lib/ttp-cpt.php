<?php
/*
Author: 2020 Creative
URL: htp://2020creative.com
Requirements: php5.5.*
*/
//////////////////////////////////////////////////////////////////////////////////////// 2020 CPT's

//////////////////////////////////////////////////////////////////////////////////////// CPT: Builder
add_action( 'init', 'cpt_agent_init' );
/**
 * Register a custom post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function cpt_agent_init() {
	$labels = array(
		'name'               => _x( 'agent', 'post type general name', 'your-plugin-textdomain' ),
		'singular_name'      => _x( 'agent', 'post type singular name', 'your-plugin-textdomain' ),
		'menu_name'          => _x( 'Agents', 'admin menu', 'your-plugin-textdomain' ),
		'name_admin_bar'     => _x( 'agent', 'add new on admin bar', 'your-plugin-textdomain' ),
		'add_new'            => _x( 'Add New', 'Agent', 'your-plugin-textdomain' ),
		'add_new_item'       => __( 'Add New Agent', 'your-plugin-textdomain' ),
		'new_item'           => __( 'New Agent', 'your-plugin-textdomain' ),
		'edit_item'          => __( 'Edit Agent', 'your-plugin-textdomain' ),
		'view_item'          => __( 'View Agent', 'your-plugin-textdomain' ),
		'all_items'          => __( 'All Agents', 'your-plugin-textdomain' ),
		'search_items'       => __( 'Search Agents', 'your-plugin-textdomain' ),
		'parent_item_colon'  => __( 'Parent Agent:', 'your-plugin-textdomain' ),
		'not_found'          => __( 'No agents found.', 'your-plugin-textdomain' ),
		'not_found_in_trash' => __( 'No agents found in Trash.', 'your-plugin-textdomain' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'agent' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
        'menu_icon'          => '/wp-content/plugins/hsr-agent/images/hsr-admin-icon-sm.png',             
		'supports'           => array( 'title', 'editor', 'thumbnail', )
	);

	register_post_type( 'agent', $args );
}
////////////////////////////////////////////////////////////////////////////////////////    
    
//////////////////////////////////////////////////////////////////////////////////////// Taxonomies

//////////////////////////////////////////////////////////////////////////////////////// Taxonomy: builder
//add_action( 'init', 'create_agent_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "book"
function create_agent_taxonomies() {
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

	//register_taxonomy( 'details', array( 'builder' ), $args );
}
////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////// Custom Fields for Builder


// Agent custom fields
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'agents',
		'title' => 'Agent Information',
		'fields' => array (
			array (
				'key' => 'agent_name_first',
				'label' => 'Agent Name First',
				'name' => 'agent_name_first',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
            array (
				'key' => 'agent_name_last',
				'label' => 'Agent Name Last',
				'name' => 'agent_name_last',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
            array (
				'key' => 'agent_bio',
				'label' => 'Agent Bio',
				'name' => 'agent_bio',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
            array (
				'key' => 'agent_title',
				'label' => 'Agent Title',
				'name' => 'agent_title',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
            array (
				'key' => 'agent_designations',
				'label' => 'Agent Designations',
				'name' => 'agent_designations',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
            array (
				'key' => 'agent_email',
				'label' => 'Agent Email',
				'name' => 'agent_email',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
            array (
				'key' => 'agent_office_name',
				'label' => 'Agent Office Name',
				'name' => 'agent_office_name',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
            array (
				'key' => 'agent_phone_1_label',
				'label' => 'Agent phone 1 label',
				'name' => 'agent_phone_1_label',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array (
				'key' => 'agent_phone_1',
				'label' => 'Agent phone 1',
				'name' => 'agent_phone_1',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
             array (
				'key' => 'agent_phone_2_label',
				'label' => 'Agent phone 2 label',
				'name' => 'agent_phone_2_label',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array (
				'key' => 'agent_phone_2',
				'label' => 'Agent phone 2',
				'name' => 'agent_phone_2',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
             array (
				'key' => 'agent_phone_3_label',
				'label' => 'Agent phone 3 label',
				'name' => 'agent_phone_3_label',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
		array (
				'key' => 'agent_phone_3',
				'label' => 'Agent phone 3',
				'name' => 'agent_phone_3',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
             array (
				'key' => 'agent_order',
				'label' => 'Agent order',
				'name' => 'agent_order',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
            array (
				'key' => 'agent_search',
				'label' => 'Agent Search',
				'name' => 'agent_search',
				'type' => 'text',
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
					'value' => 'agent',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
				//0 => 'the_content',
			),
		),
		'menu_order' => 1,
	));
    	
}



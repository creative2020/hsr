<?php
/*
Author: 2020 Creative
URL: htp://2020creative.com
*/
////////////////////////////////////////////////////////////////////////////// 2020 Shortcodes


////////////////////////////////////////////////////////////////////////////// Agent
// shortcode show agents
function show_agent( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'name' => '',
			'list' => 'n',
		), $atts )
	);

// code
	
// The Query
$args = array(
	'post_type' => 'agent',
	'post_status' => 'publised',
	'meta_key' => 'agent_name_first',
	'orderby' => 'meta_value',
	'order' => 'ASC',
);

$the_query = new WP_Query( $args );

global $post;

// The Loop
if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		// pull meta for each post
		$permalink = get_permalink( $id );
		$agent_name_first = get_post_meta($post->ID, "agent_name_first", true);
		$agent_name_last = get_post_meta($post->ID, "agent_name_last", true);
		$agent_desc = get_the_content();
		$agent_excerpt = get_the_excerpt();
		$agent_img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium');
		$agent_title = get_post_meta($post->ID, "agent_title", true);
		$agent_designation = get_post_meta($post->ID, "agent_designations", true);
		$agent_email = get_post_meta($post->ID, "agent_email", true);
		$agent_office_name = get_post_meta($post->ID, "agent_office_name", true);
		$agent_phone_1_label = get_post_meta($post->ID, "agent_phone_1_label", true);
		$agent_phone_1 = get_post_meta($post->ID, "agent_phone_1", true);
		$agent_phone_2_label = get_post_meta($post->ID, "agent_phone_2_label", true);
		$agent_phone_2 = get_post_meta($post->ID, "agent_phone_2", true);
		$agent_phone_3_label = get_post_meta($post->ID, "agent_phone_3_label", true);
		$agent_phone_3 = get_post_meta($post->ID, "agent_phone_3", true);
		$agent_search = get_post_meta($post->ID, "agent_search", true);
		//
		$icon = "/wp-content/plugins/hsr-agent/images/hsr-icon-med.png";
		$color = "#003764";
		
// display html
 		$output .= '<div class="agent-wrap">'.
 		'<div class="agent-img-wrap">'.
 		'<div class="agent-img"><img src="' . $agent_img[0] . '"></div></div>'.
 		'<div class="agent-info-block"><div class="agent-name">' . $agent_name_first . ' ' . $agent_name_last . '</div>'.
 		'<div class="agent-title">, ' . $agent_title . '</div>'.
 		'<div class="agent-designation">' . $agent_designation . '</div>'.
 		'<div class="agent-office-name clearfix">' . $agent_office_name . ' Office</div>'.
 		'<div class="agent-email">' . eeb_email($agent_email, 'Email Me') . '</div>'.
 		'<div class="agent-search">'.
 		//
 		// hsr icon button
 		'<div class="hsr-icon-btn-wrap">'.
			'<div class="hsr-btn-left-agent"><img src="' . $icon .'"></div>'.
			'<div class="hsr-btn-right" style="background:' . $color .';"><a href="' . $agent_search .'">Search homes with ' . $agent_name_first .'</a></div>'.
			//
			'</div>'.
 		'<div class="phone-wrap">'.
 		'<div class="agent-phone">' . $agent_phone_1 . '</div><div class="agent-phone-label"> ' . $agent_phone_1_label . '</div>'.
 		'<div class="agent-phone">' . $agent_phone_2 . '</div><div class="agent-phone-label"> ' . $agent_phone_2_label . '</div>'.
 		'<div class="agent-phone">' . $agent_phone_3 . '</div><div class="agent-phone-label"> ' . $agent_phone_3_label . '</div></div'.
 		'<div class="agent-excerpt">' . $agent_desc . '</div></div></div>'.
 		
			'</div>';
	}
} else {
	// no posts found
}
/* Restore original Post Data */
wp_reset_postdata();
return $output;
}
add_shortcode( 'hsr_show_agent', 'show_agent' );

// Office Shortcode
function show_office( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'name' => '',
			'list' => 'n',
		), $atts )
	);

// code
	
// The Query
$args = array(
	'post_type' => 'office',
	'post_status' => 'publised',
	'meta_key' => '',
	'orderby' => 'meta_value_num',
	'order' => 'ASC',
);

$the_query = new WP_Query( $args );

global $post;


// The Loop
if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		// pull meta for each post
		$permalink = get_permalink( $id );
		$office_name = get_post_meta($post->ID, "office_name", true);
		$office_email = get_post_meta($post->ID, "office_email", true);
		$office_desc = get_the_content();
		$office_excerpt = get_the_excerpt();
		$office_img = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium');
		$office_add_1 = get_post_meta($post->ID, "office_add_1", true);
		$office_add_2 = get_post_meta($post->ID, "office_add2", true);
		$office_city = get_post_meta($post->ID, "office_city", true);
		$office_state = get_post_meta($post->ID, "office_state", true);
		$office_zip = get_post_meta($post->ID, "office_zip", true);
		$office_phone_1_label = get_post_meta($post->ID, "office_phone_1_label", true);
		$office_phone_1 = get_post_meta($post->ID, "office_phone_1", true);
				
// display html
 		echo '<div class="agent-wrap">',
 				'<div class="agent-img-wrap">',
					'<div class="agent-img">',
						'<img src="' . $office_img[0] . '">',
						'</div>',
				'</div>',
				'<div class="agent-info-block">',
					'<h2 class="office-name title">' . $office_name . '</h2>',
					'<div class="office-add1">' . $office_add_1 . '</div>',
					'<div class="office-add2">' . $office_add_2 . '</div>',
					'<div class="office-city fleft">' . $office_city . ' </div><div class="office-state fleft">' . $office_state .'</div><div class="office-zip">' . $office_zip .'</div>',
					'<div class="agent-phone">' . $office_phone_1 . '</div><div class="agent-phone-label"> ' . $office_phone_1_label . '</div>',
					'<div class="agent-excerpt">' . $office_desc . '</div>',
					'<div class="agent-email">' . eeb_email($office_email, 'Email Us') . '</div>',
				'</div>',
			'</div>';
	}
} else {
	// no posts found
}
/* Restore original Post Data */
wp_reset_postdata();
}
add_shortcode( 'hsr_office', 'show_office' );
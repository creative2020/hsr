<?php
/*
Author: 2020 Creative
URL: htp://2020creative.com
*/
////////////////////////////////////////////////////////////////////////////// 2020 Shortcodes


////////////////////////////////////////////////////////////////////////////// Builder Grid
add_shortcode( 'hsr_builder_grid', 'hsr_builder_grid' );
function hsr_builder_grid ( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'display' => 'grid',
		), $atts )
	);

/////////////////////////////////////// Variables
$user_ID = get_current_user_id();
$user_data = get_user_meta( $user_ID );
$user_photo_id = $user_data[photo][0];
$user_photo_url = wp_get_attachment_url( $user_photo_id );
$user_photo_img = '<img src="' . $user_photo_url . '">';


/////////////////////////////////////// All Query    
if ($display == 'grid') {
	// The Query
$args = array(
	'post_type' => 'builder',
	'post_status' => 'publish',
	'order' => 'ASC',
	'posts_per_page'=> -1
);
$the_query = new WP_Query( $args );
} else { 
	//nothing
	}
    
global $post;
    
/////////////////////////////////////// The Loop
if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		// pull meta for each post
        
		$post_id = get_the_ID();
		$permalink = get_permalink( $id );
		$name_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail', false, '');
		$name_img_url = $party_img[0];
		$builder_title = get_the_title();
        $name_url = get_field( 'field_name' );
        $square_feet = get_field( 'square_feet' );
        $bedrooms = get_field( 'bedrooms' );
        $bathroom = get_field( 'bathroom' );
        $photo_1 = get_field('photo_1');
        
		
		$edit_link_url = get_edit_post_link($post->ID);
		$edit_link = '<span class="edit-pencil-link"><a href="' . $edit_link_url . '"><i class="fa fa-pencil"></i></a></span>';
		
		// set variables
        if( empty( $var_name ) ) {
        	$var_name = "/wp-content/themes/Gem/images/gem-icon-pink-25.png";
				};
				
		if( empty( $edit_link_url ) ) {
        	$edit_link = "";
				};
/////////////////////////////////////// HTML
        //print_r( $photo_1 ) . ' <-photo';
        ?>
        
        <a href="<?php echo $permalink; ?>"><div class="build-grid-view-wrap">
            <div class="build-item-wrap">
                <div class="build-item-feature">
                    <img class="build-feature-img" src="<?php echo $photo_1['url']; ?>" alt="<?php echo $photo_1['alt']; ?>" />
                </div>
                <div class="build-details-wrap">
                    <ul class="build-details">
                        <li class="build-details-label build-style"><?php echo $builder_title ?></li>
                        <li class="build-details-label bed">Bed:</li>
                        <li class="build-details-data bed"> <?php echo $bedrooms ?></li>
                        <li class="build-details-label bath">Bath:</li>
                        <li class="build-details-data bath"> <?php echo $bathroom ?></li>
                        <li class="build-details-data sqft"><?php echo $square_feet ?></li>
                        <li class="build-details-label sqft">SqFt</li>
                    </ul>
                </div>
              </div>
        </div></a>

<?php
            //print_r($post);

	}
} else {
	// no posts found
	echo '<h2>No data found</h2>';
}
/* Restore original Post Data */
wp_reset_postdata();
return $output;
}
//////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////// Shortcode: Button
add_shortcode( 'name_button', 'name_button1' );
function gem_button1($atts, $content = null) {
    extract(shortcode_atts(array(
        'size'   => '', // (sizes are xs, sm or lg)
        'color'  => '#a50050',
        'text'  => '#ffffff',
        'link'    => '#',
        'float'    => 'left',
        'target'    => '',
        'class'    => '',
        'span' => 'y',
    ), $atts ) );

    $classes = 'btn btn-primary btn-' . $size . ' ' . $span_class;
    
    if( $span == 'y') {
        	$span_class = "btn-block";
				};

    return '<a class="' . $classes . '" href="' . $link . '" style="background:' . $color . ';float:' . $float . '" target="' . $target . '">' . $content . '</a>';
}
//////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////// Builder featured floorplan
add_shortcode( 'hsr_builder_feature_floorplan', 'hsr_builder_feature_floorplan' );
function hsr_builder_feature_floorplan ( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'limit' => '1',
            'detail' => '',
		), $atts )
	);

/////////////////////////////////////// Variables



/////////////////////////////////////// Query    

$args = array(
	'post_type' => 'builder',
	'post_status' => 'publish',
	'order' => 'ASC',
	'posts_per_page'=> $limit,
    'tax_query' => array(
		array(
			'taxonomy' => 'details',
            'field' => 'slug',
            'terms' => array( $detail )
		)
	)
);
$the_query = new WP_Query( $args );

    
global $post;
    
/////////////////////////////////////// The Loop
if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		// pull meta for each post
        
		$post_id = get_the_ID();
		$permalink = get_permalink( $id );
		$name_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail', false, '');
		$builder_title = get_the_title();
        $name_url = get_field( 'field_name' );
        $square_feet = get_field( 'square_feet' );
        $bedrooms = get_field( 'bedrooms' );
        $bathroom = get_field( 'bathroom' );
        $photo_1 = get_field('photo_1');
		
		$edit_link_url = get_edit_post_link($post->ID);
		$edit_link = '<span class="edit-pencil-link"><a href="' . $edit_link_url . '"><i class="fa fa-pencil"></i></a></span>';
		
/////////////////////////////////////// HTML
        //print_r( $the_query );
        ?>
        <h2>Featured Floorplan</h2>
        <a href="<?php echo $permalink; ?>"><div class="build-grid-view-wrap">
            <div class="build-item-wrap-full">
                <div class="build-item-feature">
                    <img class="build-feature-img" src="<?php echo $photo_1['url']; ?>" alt="<?php echo $photo_1['alt']; ?>" />
                </div>
                <div class="build-details-wrap">
                    <ul class="build-details">
                        <li class="build-details-label build-style"><?php echo $builder_title ?></li>
                        <li class="build-details-label bed">Bed:</li>
                        <li class="build-details-data bed"> <?php echo $bedrooms ?></li>
                        <li class="build-details-label bath">Bath:</li>
                        <li class="build-details-data bath"> <?php echo $bathroom ?></li>
                        <li class="build-details-data sqft"><?php echo $square_feet ?></li>
                        <li class="build-details-label sqft">SqFt</li>
                    </ul>
                </div>
              </div>
        </div></a>

<?php
            //print_r($post);

	}
} else {
	// no posts found
	return '';
}
/* Restore original Post Data */
wp_reset_postdata();
echo $output;
}
//////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////// Builder brochure
add_shortcode( 'hsr_builder_guide', 'hsr_builder_guide' );
function hsr_builder_brochure ( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'name' => 'name',
		), $atts )
	);

/////////////////////////////////////// Variables



/////////////////////////////////////// Query    

$args = array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'order' => 'ASC',
	'posts_per_page'=> 1,
    'tax_query' => array(
		array(
			'taxonomy' => 'details',
            'field' => 'slug',
            'terms' => array( 'Featured' )
		)
	)
);
$the_query = new WP_Query( $args );

    
global $post;
    
/////////////////////////////////////// The Loop
if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		// pull meta for each post
        
		$post_id = get_the_ID();
		$permalink = get_permalink( $id );
		$name_img = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail', false, '');
		$builder_title = get_the_title();
        $name_url = get_field( 'field_name' );
        $square_feet = get_field( 'square_feet' );
        $bedrooms = get_field( 'bedrooms' );
        $bathroom = get_field( 'bathroom' );
        $photo_1 = get_field('photo_1');
		
		$edit_link_url = get_edit_post_link($post->ID);
		$edit_link = '<span class="edit-pencil-link"><a href="' . $edit_link_url . '"><i class="fa fa-pencil"></i></a></span>';
		
/////////////////////////////////////// HTML
        //print_r( $the_query );
        ?>
        <h2>Featured Floorplan</h2>
        <a href="<?php echo $permalink; ?>"><div class="build-grid-view-wrap">
            <div class="build-item-wrap-full">
                <div class="build-item-feature">
                    <img class="build-feature-img" src="<?php echo $photo_1['url']; ?>" alt="<?php echo $photo_1['alt']; ?>" />
                </div>
                <div class="build-details-wrap">
                    <ul class="build-details">
                        <li class="build-details-label build-style"><?php echo $builder_title ?></li>
                        <li class="build-details-label bed">Bed:</li>
                        <li class="build-details-data bed"> <?php echo $bedrooms ?></li>
                        <li class="build-details-label bath">Bath:</li>
                        <li class="build-details-data bath"> <?php echo $bathroom ?></li>
                        <li class="build-details-data sqft"><?php echo $square_feet ?></li>
                        <li class="build-details-label sqft">SqFt</li>
                    </ul>
                </div>
              </div>
        </div></a>

<?php
            //print_r($post);

	}
} else {
	// no posts found
	return '<h2>No data found</h2>';
}
/* Restore original Post Data */
wp_reset_postdata();
echo $output;
}
//////////////////////////////////////////////////////////////////////////////














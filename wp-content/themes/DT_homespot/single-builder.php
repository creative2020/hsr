<?php

get_header();


////////////////////////////////////////////////////////////////////////////// builder detail layout

function hsr_builder_detail_loop() {
    $args = array(
	'post_type' => 'builder',
	'post_status' => 'publish',
	'order' => 'ASC',
	'posts_per_page'=> 1
);
$the_query = new WP_Query( $args );

    
global $post;
    
$taxonomies = array( 
    
    'details',
);

$args = array(
    'taxonomy'      => 'details',
    'orderby'       => 'name', 
    'order'         => 'ASC',
    'hide_empty'    => true, 
    'exclude'       => array(), 
    'exclude_tree'  => array(), 
    'include'       => array(),
    'number'        => '', 
    'fields'        => 'all', 
    'slug'          => '', 
    'parent'         => '',
    'hierarchical'  => true, 
    'child_of'      => 0, 
    'get'           => '', 
    'name__like'    => '',
    'pad_counts'    => false, 
    'offset'        => '', 
    'search'        => '', 
    'cache_domain'  => 'core',
    'title_li'     => '',
); 
    

    
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
        $photo_2 = get_field('photo_2');
        $photo_3 = get_field('photo_3');
        $photo_4 = get_field('photo_4');
        $photo_5 = get_field('photo_5');
        $desc = get_field('description');
        $plan_1 = get_field('plan_1');
        $plan_2 = get_field('plan_2');
        $plan_3 = get_field('plan_3');
        $plan_4 = get_field('plan_4');
        $plan_5 = get_field('plan_5');
        
        $taxonomy = 'details';
        $sep = '</li><li>';
        $before = '<li>';
        $after = '</li>';
        //$details_list = get_the_term_list( $post_id, $taxonomy, $before, $sep, $after );
        
		
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
        
    <div class="w70 pull-left">
        <img class="build-photo-feature" src="<?php echo $photo_1['url']; ?>" alt="<?php echo $photo_1['alt']; ?>" />
    </div>
    <div class="w30 pull-left build-specs-wrap">
        <ul class="list-unstyled">
            <li class="build-label">Bed</li>
            <li class="build-data"><?php echo $bedrooms; ?></li>
            <li class="build-label">Bath</li>
            <li class="build-data"><?php echo $bathroom; ?></li>
            <li class="build-label">SqFt</li>
            <li class="build-data"><?php echo $square_feet; ?></li>
        </ul>
    <div class="build-section">
    </div>
        <ul class="list-unstyled">
            <li class="build-icon-link"><a href="#picture_1"><i class="fa fa-arrow-circle-right"></i> Gallery</a></li>
            <li class="build-icon-link"><a href="#build"><i class="fa fa-arrow-circle-right"></i> Features</a></li>
            <li class="build-icon-link"><a href="#plan_1"><i class="fa fa-arrow-circle-right"></i> Floorplan</a></li>
            <li class="build-icon-link"><a href="#information"><i class="fa fa-arrow-circle-right"></i> Information</a></li>
        </ul>
    </div>
        
    <div class="w100 build-menu clearfix">
        <ul class="build-menu-links list-unstyled">
            <a href="#plan_1"><li class="build-btn build-view-floorplan pull-left">View Floorplan</li></a>
            <a href="#picture_1"><li class="build-btn build-view-gallery pull-left">View Gallery</li></a>
            <a href="#information"><li class="last build-btn build-information pull-left">Information</li></a>
        </ul>
    </div>  

 <span id="gallery"></span><input id="do_loop" type="checkbox" name="do_loop" value=""><!--
Storing big pictures below
--><span
    id="picture_1" class="picture">
  <img src="<?php echo $photo_1['url']; ?>" alt="<?php echo $photo_1['alt']; ?>">
  <a class="prev loop" href="#picture_7"></a>
  <a class="next" href="#picture_2"></a>
</span><span
    id="picture_2" class="picture">
  <img src="<?php echo $photo_2['url']; ?>" alt="<?php echo $photo_2['alt']; ?>">
  <a class="prev" href="#picture_1"></a>
  <a class="next" href="#picture_3"></a>
</span><span
    id="picture_3" class="picture">
  <img src="<?php echo $photo_3['url']; ?>" alt="<?php echo $photo_3['alt']; ?>">
  <a class="prev" href="#picture_2"></a>
  <a class="next" href="#picture_4"></a>
</span><span
    id="picture_4" class="picture">
  <img src="<?php echo $photo_4['url']; ?>" alt="<?php echo $photo_4['alt']; ?>">
  <a class="prev" href="#picture_3"></a>
  <a class="next" href="#picture_5"></a>
</span><span
    id="picture_5" class="picture">
  <img src="<?php echo $photo_5['url']; ?>" alt="<?php echo $photo_5['alt']; ?>">
  <a class="prev" href="#picture_4"></a>
  <a class="next" href="#picture_1"></a>
</span><!--
Storing big pictures above
--><span id="chrome">
  <label class="loop" for="do_loop">Loop</label>
  <a class="close" href="#gallery">Close</a>
</span>


    <div class="w100 clearfix">    
        <ul class="build-photo-thumbs list-unstyled">
            <a href="#picture_1"><li><img class="build-tn" src="<?php echo $photo_1['url']; ?>" alt="<?php echo $photo_1['alt']; ?>"></li></a>
            <a href="#picture_2"><li><img class="build-tn" src="<?php echo $photo_2['url']; ?>" alt="<?php echo $photo_2['alt']; ?>"></li></a>
            <a href="#picture_3"><li><img class="build-tn" src="<?php echo $photo_3['url']; ?>" alt="<?php echo $photo_3['alt']; ?>"></li></a>
            <a href="#picture_4"><li><img class="build-tn" src="<?php echo $photo_4['url']; ?>" alt="<?php echo $photo_4['alt']; ?>"></li></a>
            <a href="#picture_5"><li><img class="build-tn" src="<?php echo $photo_5['url']; ?>" alt="<?php echo $photo_5['alt']; ?>"></li></a>
        </ul>
    </div>
        
        <div class="build-desc" id="build">
            <h3 class="build">Description</h3>
            <p><?php echo $desc; ?></p>
        </div>
        <div class="build-information" id="information">
            <h3 class="build"><i class="fa fa-arrow-circle-right ltblue"></i> Information</h3>
            
            
            
                <ul class="list-unstyled">
                    <?php //print_r($details_list); ?>
                    <?php 
                    $taxonomy = 'details';

// get the term IDs assigned to post.
$post_terms = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );
// separator between links
$separator = ', ';

if ( !empty( $post_terms ) && !is_wp_error( $post_terms ) ) {

	$term_ids = implode( ',' , $post_terms );
    $terms = wp_list_categories( $args );
	$terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );

	// display post categories
	echo  $terms;
    //print_r($post_terms);
}
                    
                    ?>
                    
                    
                </ul>    
        </div>

        <div class="build-floorplan" id="floorplan">
                    <h3 class="build"><i class="fa fa-arrow-circle-right ltblue"></i> Floorplan</h3>
            
            <span id="gallery"></span><input id="do_loop" type="checkbox" name="do_loop" value=""><!--
Storing big pictures below
--><span
    id="plan_1" class="picture">
  <img src="<?php echo $plan_1['url']; ?>" alt="<?php echo $plan_1['alt']; ?>">
  <a class="prev loop" href="#plan_5"></a>
  <a class="next" href="#plan_2"></a>
</span><span
    id="plan_2" class="picture">
  <img src="<?php echo $plan_2['url']; ?>" alt="<?php echo $plan_2['alt']; ?>">
  <a class="prev" href="#plan_1"></a>
  <a class="next" href="#plan_3"></a>
</span><span
    id="plan_3" class="picture">
  <img src="<?php echo $plan_3['url']; ?>" alt="<?php echo $plan_3['alt']; ?>">
  <a class="prev" href="#plan_2"></a>
  <a class="next" href="#plan_4"></a>
</span><span
    id="plan_4" class="picture">
  <img src="<?php echo $plan_4['url']; ?>" alt="<?php echo $plan_4['alt']; ?>">
  <a class="prev" href="#plan_3"></a>
  <a class="next" href="#plan_5"></a>
</span><span
    id="plan_5" class="picture">
  <img src="<?php echo $plan_5['url']; ?>" alt="<?php echo $plan_5['alt']; ?>">
  <a class="prev" href="#plan_4"></a>
  <a class="next" href="#plan_1"></a>
</span><!--
Storing big pictures above
--><span id="chrome">
  <label class="loop" for="do_loop">Loop</label>
  <a class="close" href="#gallery">Close</a>
</span>


            
            <div class="w100 clearfix">    
        <ul class="build-photo-thumbs list-unstyled">
            <a href="#plan_1"><li><img class="build-tn" src="<?php echo $plan_1['url']; ?>" alt="<?php echo $plan_1['alt']; ?>"></li></a>
            <a href="#plan_2"><li><img class="build-tn" src="<?php echo $plan_2['url']; ?>" alt="<?php echo $plan_2['alt']; ?>"></li></a>
            <a href="#plan_3"><li><img class="build-tn" src="<?php echo $plan_3['url']; ?>" alt="<?php echo $plan_3['alt']; ?>"></li></a>
            <a href="#plan_4"><li><img class="build-tn" src="<?php echo $plan_4['url']; ?>" alt="<?php echo $plan_4['alt']; ?>"></li></a>
            <a href="#plan_5"><li><img class="build-tn" src="<?php echo $plan_5['url']; ?>" alt="<?php echo $plan_5['alt']; ?>"></li></a>
        </ul>
    </div>
    
            
            <!-- Lightbox usage markup -->

<!-- thumbnail image wrapped in a link -->

<!-- lightbox container hidden with CSS -->
            
            
            
        </div>
     


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

///////////////////////////////////////		
hsr_builder_detail_loop();	
?>		
	
	<?php hook_single_after(); ?>
	
	 
	<?php get_footer();

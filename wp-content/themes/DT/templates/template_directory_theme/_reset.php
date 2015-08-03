<?php

add_action('hook_new_install','_newinstall');
function _newinstall(){ global $CORE, $wpdb;

 

// 4. CUSTOM SUBMISSION FIELDS
$submissionfields[0] = array(
"name" => "Website Link", 
"help" => "", 
"fieldtype" => "input", 
"values" => "", 
"taxonomy" => "", 
"key" => "url", 
"order" => "1", 
"required" => "yes", 
"ID" => "0", 
);
// SAVE ARRAY DATA		 
update_option( "submissionfields", $submissionfields);

// 5. DEFAULT TEMPLATE DATA
$GLOBALS['theme_defaults']['template'] 		= "template_directory_theme";

// SET HEADER
$GLOBALS['theme_defaults']["layout_header"] = "1";
					// SET MENU
$GLOBALS['theme_defaults']["layout_menu"] = "2";
					// SET RESPONISVE DESIGN
$GLOBALS['theme_defaults']["responsive"] = "1";
					// SET COLUMN LAYOUTS
$GLOBALS['theme_defaults']["layout_columns"] = array('homepage' => '3', 'search' => '2', 'single' => '3', 'page' => '2', 'footer' => '4', '2columns' => '0', 'style' => 'fluid', '3columns' => '');
					// SET WELCOME TEXT
$GLOBALS['theme_defaults']["header_welcometext"] = "Your own text could go here!";        
					// SET RATING
$GLOBALS['theme_defaults']["rating"] 		= "1";
$GLOBALS['theme_defaults']["rating_type"] 	= "1";
					// BREADCRUMBS
$GLOBALS['theme_defaults']["breadcrumbs_inner"] 	= "0";
$GLOBALS['theme_defaults']["breadcrumbs_home"] 		= "0"; 
					// TURN OFF CATEGORY DESCRIPTION
$GLOBALS['theme_defaults']["category_descrition"] 	= "1";	
					// GEO LOCATION
$GLOBALS['theme_defaults']["geolocation"] 	= "1";
$GLOBALS['theme_defaults']["geolocation_flag"] 	= "US";
$GLOBALS['theme_defaults']['google_coords'] = " 50.792047, 9.906235";
$GLOBALS['theme_defaults']['google_coords1'] = " 50.792047, 9.906235";

					// FOOTER SOCIAL ICONS
$GLOBALS['theme_defaults']["social"] 	= array(
					'twitter' => '##', 'twitter_icon' => 'fa-twitter', 
					'facebook' => '##', 'facebook_icon' => 'fa-facebook', 
					'dribbble' => '', 'dribbble_icon' => 'fa-google-plus', 
					'linkedin' => '##', 'linkedin_icon' => 'fa-linkedin', 
					'youtube' => '##', 'youtube_icon' => 'fa-youtube', 
					'rss' => '##', 'rss_icon' => 'fa-rss',         
					);


$GLOBALS['theme_defaults']['logo_url'] = "Directory<span>Theme</span>";
 
 // HOME PAGE OBJECT SETUP
$GLOBALS['theme_defaults']["homepage"]["widgetblock1"] = "text_39,homecatsd_38";	
					

$GLOBALS['theme_defaults']['widgetobject']['text']['39'] = array(
'text' => "<div class=\"home-banner clearfix\"></div><div class=\"home-features clearfix\"><div class=\"container\"><div class=\"row\"><div class=\"col-md-4\"><div class=\"features-intro clearfix\"><h2>Responsive HTML5 Directory Theme</h2>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.<a class=\"read-more\" href=\"".home_url()."/?s=\">View Our Listings</a></div></div><div class=\"col-md-8\"><div class=\"row\"><div class=\"col-sm-6 single-feature\"><div class=\"row\"><div class=\"col-sm-3 icon-wrapper\"><i class=\"fa fa-filter\"></i></div><div class=\"col-sm-9\"><h3>Search Filtering</h3>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod.</div></div></div><div class=\"col-sm-6 single-feature\"><div class=\"row\"><div class=\"col-sm-3 icon-wrapper\"><i class=\"fa fa-map-marker\"></i></div><div class=\"col-sm-9\"><h3>Google Maps</h3>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore.</div></div></div><div class=\"col-sm-6 single-feature\"><div class=\"row\"><div class=\"col-sm-3 icon-wrapper\"><i class=\"fa fa-users\"></i></div><div class=\"col-sm-9\"><h3>Members Area</h3>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore.</div></div></div><div class=\"col-sm-6 single-feature\"><div class=\"row\"><div class=\"col-sm-3 icon-wrapper\"><i class=\"fa fa-envelope\"></i></div><div class=\"col-sm-9\"><h3>Contact Forms</h3>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore.</div></div></div></div></div></div></div></div>",
'autop' => "1",
'fullw' => "yes",
);
 		


$GLOBALS['theme_defaults']['widgetobject']['homecatsd']['38'] = array(
'fullw' => "yes",
);	
					// SET ITEMCODE
						
// CONTENT LAYOUT / SINGLE LAYOUT
$GLOBALS['theme_defaults']['content_layout'] = "listing-directory";
$GLOBALS['theme_defaults']['single_layout'] = "content-listing-directory";


// TURN ON GALLEYRY MAP
$GLOBALS['theme_defaults']['default_gallery_map'] = 1;

$GLOBALS['theme_defaults']['header_accountdetails'] = 1;
 
// 5. REINSTALL THE SAMPLE DATA CATEGORIES 
$new_cat_array = array(
"Automotive" => array ('Car Accessories','Car Dealers','Car Wash','Car Repairs','Car Rentals'),
"Business Services" => array ('Advertising','Employment Agencies','Careers Center','Legal Services'),
"Education" => array ('Schools','Collages','Universities','Library','Museum'),
"Food" => array ('Bakers','Resturants','Take Aways','McDonalds','Drive Throughts'),
"Health & Medicine" => array ('Walk Ins','Hospitals','Pharmacy','Drug Store'),
"IT Services" => array ('Website Designers','Hosting Services','Online Marketing','Advertising'),
"Shopping" => array ('Retail Stores','Furniture Stores','Home Stores','Warehouses','Markets'),
"Sports & Recreation" => array ('Extreme','Fishing','Golf','Hunting','Running'),
//"Travel & Transport" => array ('Hotels','Motels','Bed &amp; Breakfast','Airport','Taxi Services'),
);

$cat_icons_small = array('','fa-car','fa-archive','fa-university','fa-coffee','fa-heart-o','fa-desktop','fa-cc-visa','fa-futbol-o','fa-bus');

 
$saved_cats_array = array(); $ff=1;
foreach($new_cat_array as $cat=>$catlist){
	if ( is_term( $cat , THEME_TAXONOMY ) ){	
		$term = get_term_by('slug', $cat, THEME_TAXONOMY);		 
		$nparent  = $term->term_id;
		$saved_cats_array[] = $term->term_id;	
	}else{
	
		$cat_id = wp_insert_term($cat, THEME_TAXONOMY, array('cat_name' => $cat, 'description' =>  'Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore.' ));
		if(!is_object($cat_id) && isset($cat_id['term_id'])){
		$saved_cats_array[] = $cat_id['term_id'];
		$nparent = $cat_id['term_id'];
		}else{
		$saved_cats_array[] = $cat_id->term_id;
		$nparent = $cat_id->term_id;
		}			
		// add in icon for this cat		
		 $GLOBALS['theme_defaults']['category_icon_'.$nparent] = THEME_URI."/templates/".$GLOBALS['theme_defaults']['template']."/img/demo/c".$ff.".jpg";
		 $GLOBALS['theme_defaults']['category_icon_small_'.$nparent] = $cat_icons_small[$ff];
		$ff++; 
	}
	/* SUB CATS */
	if(is_array($catlist)){
		foreach($catlist as $newcat){
		wp_insert_term($newcat, THEME_TAXONOMY, array('cat_name' => $newcat,'parent' => $nparent));
		}	
	}
}
// 6. INSTALL THE SAMPLE DATA LISTINGS
$posts_array = array(
"1" => array("name" =>"Example Listing 1","price" => "100",  "url" => "http://google.com", "map"=>"London", "image" => get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template']."/img/demo/1-min.jpg"),
"2" => array("name" =>"Example Listing 2","price" => "130",  "url" => "http://bing.com", "map"=>"London", "image" => get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template']."/img/demo/2-min.jpg"),
"3" => array("name" =>"Example Listing 3","price" => "150",  "url" => "http://yahoo.com", "map"=>"London", "image" => get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template']."/img/demo/3-min.jpg"),
"4" => array("name" =>"Example Listing 4","price" => "160",  "url" => "http://lycos.com", "map"=>"London", "image" => get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template']."/img/demo/4-min.jpg"),
"5" => array("name" =>"Example Listing 5","price" => "150",  "url" => "http://dogpile", "map"=>"London", "image" => get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template']."/img/demo/5-min.jpg"),
"6" => array("name" =>"Example Listing 6","price" => "170",  "url" => "http://ask.com", "map"=>"London", "image" => get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template']."/img/demo/6-min.jpg"),
"7" => array("name" =>"Example Listing 7","price" => "200",  "url" => "http://mahalo.com", "map"=>"London", "image" => get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template']."/img/demo/7-min.jpg"),
"8" => array("name" =>"Example Listing 8","price" => "300",  "url" => "http://webopedia.com", "map"=>"London", "image" => get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template']."/img/demo/8-min.jpg"),
"9" => array("name" =>"Example Listing 9","price" => "500",  "url" => "http://clusty.com", "map"=>"London", "image" => get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template']."/img/demo/9-min.jpg")

);
foreach($posts_array as $np){
 
	$my_post = array();
	$my_post['post_title'] 		= $np['name'];
	$my_post['post_content'] 	= "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p><blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p><small>Someone famous <cite title='Source Title'>Source Title</cite></small>
</blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p><dl class='dl-horizontal'>
				<dt>Description lists</dt>
				<dd>A description list is perfect for defining terms.</dd>
				<dt>Euismod</dt>
				<dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</dd>
				<dd>Donec id elit non mi porta gravida at eget metus.</dd>
				<dt>Malesuada porta</dt>
				<dd>Etiam porta sem malesuada magna mollis euismod.</dd>
				<dt>Felis euismod semper eget lacinia</dt>
				<dd>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</dd>
			  </dl>";
	$my_post['post_type'] 		= THEME_TAXONOMY."_type";
	$my_post['post_status'] 	= "publish";
	$my_post['post_category'] 	= "";
	$my_post['tags_input'] 		= "";
	$POSTID 					= wp_insert_post( $my_post );	
 
	add_post_meta($POSTID, "url", $np['url']);
	add_post_meta($POSTID, "image", $np['image']);
	add_post_meta($POSTID, "featured", "no");
	// UPDATE CAT LIST
	wp_set_post_terms( $POSTID, $saved_cats_array, THEME_TAXONOMY );		
} 
 

} 

?>
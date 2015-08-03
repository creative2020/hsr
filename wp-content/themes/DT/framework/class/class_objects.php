<?php

class core_objects extends white_label_themes {

	function core_objects(){}
	
	// STORES AN ARRAY OF ALL THE AVAILABLE OBJECT ITEMS BUILD INTO THE FRAMEWORK
	function DEFAULT_WIDGETBLOCKS_LIST($existing_objects){
	
		global $post, $wpdb; $STRING = ""; $i=0; 
		
		$a[$i]['id'] 				= "recentlisting";
		$a[$i]['name'] 				= "Recent Listings";
		$a[$i]['desc'] 				= "display a block of your listings";
		$a[$i]['icon'] 				= "rl.jpg";
		$a[$i]['type'] 				= "content";
		$i++;
 		
		$a[$i]['id'] 				= "categoryblock";
		$a[$i]['name'] 				= "Categories"; 
		$a[$i]['desc'] 				= "display block of categories";
		$a[$i]['icon'] 				= "cb.jpg";
		$a[$i]['type'] 				= "content";
		$i++;
 		
		$a[$i]['id'] 				= "carsousel";
		$a[$i]['name'] 				= "Listing Carousel"; 
		$a[$i]['desc'] 				= "display carousel of listings";
		$a[$i]['icon'] 				= "lc.jpg";
		$a[$i]['type'] 				= "content";
		$i++;
		
		$a[$i]['id'] 				= "tabs";
		$a[$i]['name'] 				= "Tabs";
		$a[$i]['desc'] 				= "custom tabs and content";
		$a[$i]['icon'] 				= "tabs.jpg";
		$a[$i]['type'] 				= "content";
		$i++;
		
		$a[$i]['id'] 				= "gmap";
		$a[$i]['name'] 				= "Google Map"; 
		$a[$i]['desc'] 				= "google map bar";
		$a[$i]['icon'] 				= "map1.jpg";
		$a[$i]['type'] 				= "content";
		$i++;
		
		$a[$i]['id'] 				= "newgooglemap";
		$a[$i]['name'] 				= "Google Map"; 
		$a[$i]['desc'] 				= "New Google Map"; 
		$a[$i]['icon'] 				= "map2.jpg";
		$a[$i]['type'] 				= "content";
		$i++;
		
		$a[$i]['id'] 				= "blog";
		$a[$i]['name'] 				= "Blog Posts"; 
		$a[$i]['desc'] 				= "display recent blog posts";
		$a[$i]['icon'] 				= "blog.jpg";
		$a[$i]['type'] 				= "content";
		$i++;
		 
		$a[$i]['id'] 				= "navs";
		$a[$i]['name'] 				= "Navigation Links"; 
		$a[$i]['desc'] 				= "displsy a row of links";
		$a[$i]['icon'] 				= "blank.png";
		$a[$i]['type'] 				= "";
		$i++;
		 
		$a[$i]['id'] 				= "shortcode";
		$a[$i]['name'] 				= "Shortcodes"; 
		$a[$i]['desc'] 				= "add your custom shortcodes";
		$a[$i]['icon'] 				= "blank.png";
		$i++;
		 
		$a[$i]['id'] 				= "slider1";
		$a[$i]['name'] 				= "Full Image Slider"; 
		$a[$i]['desc'] 				= "add your own images + link";
		$a[$i]['icon'] 				= "slider1.jpg";
		$a[$i]['type'] 				= "slider";
		$i++;
		
		$a[$i]['id'] 				= "slider2";
		$a[$i]['name'] 				= "Half Image Slider"; 
		$a[$i]['desc'] 				= "add images &amp; sidebar text";
		$a[$i]['icon'] 				= "slider2.jpg";
		$a[$i]['type'] 				= "slider";
		$i++;
		 
		$a[$i]['id'] 				= "slider3";
		$a[$i]['name'] 				= "HTML Slider";
		$a[$i]['desc'] 				= "add images &amp; HTML content";
		$a[$i]['icon'] 				= "slider3.jpg";
		$a[$i]['type'] 				= "slider";
		$i++;
		
		$a[$i]['id'] 				= "slider4";
		$a[$i]['name'] 				= "Video Slider";
		$a[$i]['desc'] 				= "add Youtube video slider";
		$a[$i]['icon'] 				= "slider4.jpg";
		$a[$i]['type'] 				= "slider";
		$i++;
		
		$a[$i]['id'] 				= "slider6";
		$a[$i]['name'] 				= "Carousel Slider";
		$a[$i]['desc'] 				= "Listing carousel slider"; 
		$a[$i]['icon'] 				= "s6.jpg";
		$a[$i]['type'] 				= "slider";
		$i++;
		
		if(isset($GLOBALS['WLT_REVSLIDER'])  ){
		$a[$i]['id'] 				= "slider5";
		$a[$i]['name'] 				= "New Plugin Slider";
		$a[$i]['desc'] 				= "this slider uses your plugin setup";
		$a[$i]['icon'] 				= "slider5.jpg";
		$a[$i]['type'] 				= "slider";
		$i++;
		}
		 
		
		$a[$i]['id'] 				= "text";
		$a[$i]['name'] 				= "Text/ HTML";
		$a[$i]['desc'] 				= "add your own content";
		$a[$i]['icon'] 				= "blank.png";
		$a[$i]['type'] 				= "text";
		$i++;
		 
		$a[$i]['id'] 				= "element1";
		$a[$i]['name'] 				= "Styled Block 1"; 
		$a[$i]['desc'] 				= "3 columns with image headings"; 
		$a[$i]['icon'] 				= "blank.png";
		$a[$i]['type'] 				= "text";
		$i++;

		$a[$i]['id'] 				= "element2";
		$a[$i]['name'] 				= "Styled Block 2"; 
		$a[$i]['desc'] 				= "2 columns with large right image"; 
		$a[$i]['icon'] 				= "blank.png";
		$a[$i]['type'] 				= "text";
		$i++;
		 
		$a[$i]['id'] 				= "element3";
		$a[$i]['name'] 				= "Headline"; 
		$a[$i]['desc'] 				= "page headline &amp; description"; 
		$a[$i]['icon'] 				= "blank.png";
		$a[$i]['type'] 				= "text";
		$i++;
		
 
		$a[$i]['id'] 				= "element5";
		$a[$i]['name'] 				= "Headline + Well"; 
		$a[$i]['desc'] 				= "page headline &amp; content in a well"; 
		$a[$i]['icon'] 				= "blank.png";
		$a[$i]['type'] 				= "text";
		$i++;
		
		$a[$i]['id'] 				= "element6";
		$a[$i]['name'] 				= "3 Headings"; 
		$a[$i]['desc'] 				= "3 columns with headings &amp; buttons"; 
		$a[$i]['icon'] 				= "blank.png";
		$a[$i]['type'] 				= "text";
		$i++;

		$a[$i]['id'] 				= "element7";
		$a[$i]['name'] 				= "Text + Listbox"; 
		$a[$i]['desc'] 				= "2 columns with text &amp; list items"; 
		$a[$i]['icon'] 				= "blank.png";
		$a[$i]['type'] 				= "text";
		$i++;
		
		$a[$i]['id'] 				= "element8";
		$a[$i]['name'] 				= "Text + Box"; 
		$a[$i]['desc'] 				= "2 columns with box on the right"; 
		$a[$i]['icon'] 				= "blank.png";
		$a[$i]['type'] 				= "text";
		$i++;
 

		$a[$i]['id'] 				= "element10";
		$a[$i]['name'] 				= "Text + Image"; 
		$a[$i]['desc'] 				= "Text with image on the right."; 
		$a[$i]['icon'] 				= "blank.png";
		$a[$i]['type'] 				= "text";
		$i++;
		
	 
 		
		$a[$i]['id'] 				= "new1";
		$a[$i]['name'] 				= "Top Style 1"; 
		$a[$i]['desc'] 				= ""; 
		$a[$i]['icon'] 				= "h1.jpg";
		$a[$i]['type'] 				= "head";
		$i++;	


		$a[$i]['id'] 				= "new2";
		$a[$i]['name'] 				= "Top Style 2"; 
		$a[$i]['desc'] 				= ""; 
		$a[$i]['icon'] 				= "h2.jpg";
		$a[$i]['type'] 				= "head";
		$i++;	
		
		
		$a[$i]['id'] 				= "new3";
		$a[$i]['name'] 				= "Top Style 3"; 
		$a[$i]['desc'] 				= "";  
		$a[$i]['icon'] 				= "h3.jpg";
		$a[$i]['type'] 				= "head";
		$i++;	
		
		
		$a[$i]['id'] 				= "new4";
		$a[$i]['name'] 				= "Top Style 4"; 
		$a[$i]['desc'] 				= ""; 
		$a[$i]['icon'] 				= "h4.jpg";
		$a[$i]['type'] 				= "head";
		$i++;
		
		$a[$i]['id'] 				= "new5";
		$a[$i]['name'] 				= "Top Style 5"; 
		$a[$i]['desc'] 				= ""; 
		$a[$i]['icon'] 				= "h5.jpg";
		$a[$i]['type'] 				= "head";
		$i++;
		
		$a[$i]['id'] 				= "new6";
		$a[$i]['name'] 				= "Top Style 6"; 
		$a[$i]['desc'] 				= ""; 
		$a[$i]['icon'] 				= "h6.jpg";
		$a[$i]['type'] 				= "head";
		$i++;
		
		
		$a[$i]['id'] 				= "new7";
		$a[$i]['name'] 				= "Bottom Style 1"; 
		$a[$i]['desc'] 				= " "; 
		$a[$i]['icon'] 				= "f1.jpg";
		$a[$i]['type'] 				= "footer";
		$i++;	
		
		$a[$i]['id'] 				= "new8";
		$a[$i]['name'] 				= "Bottom Style 2"; 
		$a[$i]['desc'] 				= ""; 
		$a[$i]['icon'] 				= "f2.jpg";
		$a[$i]['type'] 				= "footer";
		$i++;	
		
		$a[$i]['id'] 				= "new9";
		$a[$i]['name'] 				= "Bottom Style 3"; 
		$a[$i]['desc'] 				= ""; 
		$a[$i]['icon'] 				= "f3.jpg";
		$a[$i]['type'] 				= "footer";
		$i++;		
		
		
		$a[$i]['id'] 				= "search1";
		$a[$i]['name'] 				= "Search Style 1"; 
		$a[$i]['desc'] 				= ""; 
		$a[$i]['icon'] 				= "search1.jpg";
		$a[$i]['type'] 				= "search";
		$i++;
		
		$a[$i]['id'] 				= "search2";
		$a[$i]['name'] 				= "Search Style 2"; 
		$a[$i]['desc'] 				= ""; 
		$a[$i]['icon'] 				= "search3.jpg";
		$a[$i]['type'] 				= "search";
		$i++;	
 		
		$a[$i]['id'] 				= "basicsearch";
		$a[$i]['name'] 				= "Search Style 3"; 
		$a[$i]['desc'] 				= ""; 
		$a[$i]['icon'] 				= "search2.jpg";
		$a[$i]['type'] 				= "search";
		$i++;
		
		
		// COLUMN LAYOUTS
		
		$a[$i]['id'] 				= "2columns";
		$a[$i]['name'] 				= "2 Columns"; 
		$a[$i]['desc'] 				= "2 column layout setup";
		$a[$i]['icon'] 				= "blank.png";
		$a[$i]['type'] 				= "cols2";
		$i++;
		
		$a[$i]['id'] 				= "3columns";
		$a[$i]['name'] 				= "3 Columns"; 
		$a[$i]['desc'] 				= "3 column layout setup";
		$a[$i]['icon'] 				= "blank.png";
		$a[$i]['type'] 				= "cols3";
		$i++;
		
		$a[$i]['id'] 				= "4columns";
		$a[$i]['name'] 				= "4 Columns"; 
		$a[$i]['desc'] 				= "4 column layout setup";
		$a[$i]['icon'] 				= "blank.png";
		$a[$i]['type'] 				= "cols4";
		$i++;
		
		$a[$i]['id'] 				= "col2s1";
		$a[$i]['name'] 				= "2Cols Style 1"; 
		$a[$i]['desc'] 				= ""; 
		$a[$i]['icon'] 				= "cols1.jpg";
		$a[$i]['type'] 				= "cols2";
		$i++;
		
		$a[$i]['id'] 				= "col3s1";
		$a[$i]['name'] 				= "3Cols Style 1"; 
		$a[$i]['desc'] 				= ""; 
		$a[$i]['icon'] 				= "cols1.jpg";
		$a[$i]['type'] 				= "cols3";
		$i++;	
		
		$a[$i]['id'] 				= "col4s1";
		$a[$i]['name'] 				= "4Cols Style 1"; 
		$a[$i]['desc'] 				= ""; 
		$a[$i]['icon'] 				= "cols1.jpg";
		$a[$i]['type'] 				= "cols4";
		$i++;
		
		$a[$i]['id'] 				= "col2s2";
		$a[$i]['name'] 				= "2Cols Style 2"; 
		$a[$i]['desc'] 				= ""; 
		$a[$i]['icon'] 				= "cols2.jpg";
		$a[$i]['type'] 				= "cols2";
		$i++;
		
		$a[$i]['id'] 				= "col3s2";
		$a[$i]['name'] 				= "3Cols Style 2"; 
		$a[$i]['desc'] 				= ""; 
		$a[$i]['icon'] 				= "cols2.jpg";
		$a[$i]['type'] 				= "cols3";
		$i++;	
		
		$a[$i]['id'] 				= "col4s2";
		$a[$i]['name'] 				= "4Cols Style 2"; 
		$a[$i]['desc'] 				= ""; 
		$a[$i]['icon'] 				= "cols2.jpg";
		$a[$i]['type'] 				= "cols4";
		$i++;	
		
		
		// IMAGE PLACEMENT BLOCKS
		$a[$i]['id'] 				= "image1";
		$a[$i]['name'] 				= "Image Block 1"; 
		$a[$i]['desc'] 				= "2 columns"; 
		$a[$i]['icon'] 				= "i1.jpg";
		$a[$i]['type'] 				= "image";
		$i++;
								
		$a[$i]['id'] 				= "image2";
		$a[$i]['name'] 				= "Image Block 2"; 
		$a[$i]['desc'] 				= "2 columns"; 
		$a[$i]['icon'] 				= "i2.jpg";
		$a[$i]['type'] 				= "image";
		$i++; 
 
		$a[$i]['id'] 				= "image3";
		$a[$i]['name'] 				= "Image Block 3"; 
		$a[$i]['desc'] 				= "2 columns"; 
		$a[$i]['icon'] 				= "i3.jpg";
		$a[$i]['type'] 				= "image";
		$i++;
		
		$a[$i]['id'] 				= "image4";
		$a[$i]['name'] 				= "Image Block 4"; 
		$a[$i]['desc'] 				= "1 columns"; 
		$a[$i]['icon'] 				= "i4.jpg";
		$a[$i]['type'] 				= "image";
		$i++;
	 
								 
		return array_merge($existing_objects,$a);
		
		}

	
	// TAKES A STRING OF OBJECT CODE AND FORMATS IT
	function WIDGETBLOCKS($c,$fullwidth=false, $underheader = false){ 
	
	global $post, $CORE, $wpdb; $STRING = ""; $i =0;
		// FORMAT IS ID-TEXT,
		$widget_blocks = explode(",",$c); 
		
		// LOOP THROUGH AND FIND OUTPUT	
		foreach($widget_blocks as $key=>$widget){
			
			// BREAK UP THE STRING				
			$ff 		= explode("_",$widget);	
			if(isset($ff[1])){					
				$gg 		= explode("-", $ff[1]);
				$nkey		= $ff[0];
				$nrefid 	= $gg[0];
				
				// MAKE SURE ITS A VALID OBJECT
				if(strlen($nkey) > 1 ){ 
				$STRING .= $this->DEFAULT_WIDGETBLOCKS_OUTPUT($nkey, $nrefid ,$fullwidth, $underheader);
				}	
			}	
		}
	return $STRING;
	}
	
	// LOOPS THROUGH THE AVAILABLE OBJECTS TO GET THE DISPLAY OUTPIT
	function DEFAULT_WIDGETBLOCKS_OUTPUT($item, $i, $fullwidth, $underheader){ global $post, $CORE, $wpdb; $STRING = "";  $SLIDERSTRING =""; $core_admin_values = $GLOBALS['CORE_THEME']; 
	
		// SETUP GLOBALS FOR OBJECT FILES
		$GLOBALS['object_name'] = $item;
		$GLOBALS['object_data'] = $core_admin_values['widgetobject'][$item][$i];
		$GLOBALS['object_id'] 	= $i;		
		
		// MOVE IF NOTHING IS SET
		if($core_admin_values['widgetobject'][$item][$i]['fullw'] == ""){ return; }		
		
		//echo $fullwidth." - ".$underheader." - ".$core_admin_values['widgetobject'][$item][$i]['fullw'];
		// CHECK IF ITS FULL PAGE OR INLINE
		if($fullwidth && $core_admin_values['widgetobject'][$item][$i]['fullw'] != "yes"){ return; }
		if(!$fullwidth && !$underheader && $core_admin_values['widgetobject'][$item][$i]['fullw'] != "no"){ return; }
		if($underheader && $core_admin_values['widgetobject'][$item][$i]['fullw'] != "underheader"){ return; }

	  
	 	// SWITCH THE DEFAULT ITEMS
		switch($item){
		
			case "newgooglemap": {  $GLOBALS['noschema'] = true;         
 
// BUILD MAP STRING
$_map_string 	= ""; 
 
$args = array(
'post_type' => THEME_TAXONOMY.'_type',
'orderby' => 'ID',
'order' => 'desc',
'posts_per_page' => 100,
	'meta_query' => array (
		array (
		'key' => 'map-lat',
		'value' => '',
		 'compare' => '!='
		)		 
	),
);
 
$my_query = new WP_Query($args); $g=0;	$foundCounter = 0; $HasIconArray = array(); 			 
if( $my_query->have_posts() ) {	
 	 				
	foreach($my_query->posts as $post){	
	 	
		// GET CATEGORY ID
		$catID = 0;
		$cat =  wp_get_object_terms( $post->ID , THEME_TAXONOMY );
		if(isset($cat[0])){
		$catID = $cat[0]->term_id;		
		}
		
		// ADD TO ARRAY
		$HasIconArray[$catID] = $catID;
		 
		// MAP ICON
		$mapimg = "image";
		$tts = wp_get_post_terms($post->ID, THEME_TAXONOMY, array("fields" => "ids") );
		if(isset($tts[0])){ $mapimg = "icon_".$tts[0]; }
		
		// GET LISTING DATA
		$permalink 	= get_permalink($post->ID);
		$long 		= get_post_meta($post->ID,'map-log',true);
		$lat 		= get_post_meta($post->ID,'map-lat',true);					
		if($long == "" || $lat == ""){ continue; }
 		
		$_map_string .= "[".$lat.", ".$long.",'".$permalink."','".addslashes(trim($CORE->ITEM_CONTENT($post, "[IMAGE pid='".$post->ID."'][EXCERPT striptags=true]")))."','".$mapimg."', '".strip_tags(str_replace("'","",$post->post_title))."', '".$catID."'],";
		
		$foundCounter++;
	}
} 
wp_reset_postdata(); 

// GET CATEGORY ICONS
$terms = get_terms(THEME_TAXONOMY, 'orderby=count&hide_empty=0');
$count = count($terms);
 

?>
<script src="<?php echo $CORE->googlelink(); ?>" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/framework/js/jquery.infobox.js" type="text/javascript"></script>
  
<div id="wlt_objects_newgooglemap">

	<div id="headerb"></div>

    <div id="wlt_childtheme_map"></div>
     
    <div class="mapresults">
        <div> <?php echo str_replace("0", $foundCounter, $CORE->_e(array('validate','26'))); ?>  | 
        <a href="javascript:void(0);" onclick="getMyLocation();"><span><?php echo $CORE->_e(array('widgets','16')); ?></span> </a> |
        <a href="javascript:void(0);" onclick="switchMarkers(0);"> <span><?php echo $CORE->_e(array('widgets','17')); ?></span> </a> <input type="hidden" id="cat_marker_0" value="on" /> </div> 
    </div>
        
      
    <div id="wlt_childtheme_searchbar">
    
    <?php 
	 
	if($core_admin_values['widgetobject'][$item][$i]['showbar'] == 1){ ?>
    
    <div class="container"><div class="row">
     
    <ul class="mapmarker">
      
        <?php
      
            if ( $count > 0 ){
                foreach ( $terms as $term ) {
				
						if(!in_array($term->term_id,$HasIconArray)){ continue; }
            			
						//if(isset($GLOBALS['CORE_THEME']['category_icon_'.$term->term_id])){
                        $IMG_PATH = $GLOBALS['CORE_THEME']['category_icon_'.$term->term_id];
                        if(strlen($IMG_PATH) > 1){ }else{ $IMG_PATH = get_template_directory_uri()."/framework/img/map/icon.png"; }
						
						
                        ?>
                        <li><a href="javascript:void(0);" onclick="zoomMarkers(<?php echo $term->term_id; ?>);">
                        <img src="<?php echo $IMG_PATH; ?>" /><span><?php echo $term->name; ?></span></a>
                        
                        <div style="font-size:11px;"><input name="" type="checkbox" value=""  onChange="switchMarkers(<?php echo $term->term_id; ?>);" checked="checked" /> <?php echo $CORE->_e(array('widgets','18')); ?> </div>
                        
                        
                        <input type="hidden" id="cat_marker_<?php echo $term->term_id; ?>" value="on" />
                        </li>
                        <?php 
                }
            }
        
        ?>
    
    </ul>     
    
    </div></div>
    
    <?php } // end show bars ?>
    
    </div>
</div>
<script type="text/javascript">
 	var image;
	var map; 
	var AllMarkers = [];
	var locations = new Array(<?php echo substr(str_replace("<p>","",str_replace("</p>","",$_map_string)),0,-1); ?>);
	var bounds = new google.maps.LatLngBounds();
	var image_here = ""; //new google.maps.MarkerImage('<?php echo get_template_directory_uri(); ?>/framework/img/map/you.png');
	<?php	
	// MULTIPLE MAP MARKERS BASIC ON THE CATEGORY ICON	
	if ( $count > 0 ){
		foreach ( $terms as $term ) { 
				
				// CHECK FOR ICON
 				$thisCatId = $term->term_id;
				$IMG_PATH = $GLOBALS['CORE_THEME']['category_icon_'.$term->term_id];
				
					// CHECK FOR PARENT ICON
					if($IMG_PATH == ""){
					$IMG_PATH = $GLOBALS['CORE_THEME']['category_icon_'.$term->parent];	
					}
				
				if(strlen($IMG_PATH) > 1){
				?>				
				var icon_<?php echo $term->term_id; ?> = new google.maps.MarkerImage('<?php echo $IMG_PATH; ?>');
				<?php }else{ ?>
				var icon_<?php echo $term->term_id; ?> = new google.maps.MarkerImage('<?php echo get_template_directory_uri(); ?>/framework/img/map/icon.png');
				<?php }
				
				?>
				var cat_markers_<?php echo $thisCatId; ?> = []; 
				<?php
				
				
		}
	}	
	?>
	
	function initialize() {
		var myLatlng = new google.maps.LatLng(0,0);
		var myOptions = { zoom: 3,  center: myLatlng,  mapTypeId: google.maps.MapTypeId.ROADMAP}
		map = new google.maps.Map(document.getElementById("wlt_childtheme_map"), myOptions); 
		/** now loop through each location and plot it on the graph **/
		<?php if($foundCounter > 0){ ?>
		jQuery.each(locations, function(index, location) {	
			placeMarker(location[0],location[1],location[2],location[3],location[4],location[5],location[6]);
		});
		<?php } ?>
		
		<?php if(isset($_GET['map_r']) && is_numeric($_GET['map_r']) && strlen($_map_string) > 5 ){ ?>		
		getMapLocation('<?php echo strip_tags($_GET['map_l']); ?>', <?php echo $_GET['map_r']; ?>);		
		<?php } ?>
		
		/** SETUP DEFAULT MARKER AND ADD ICONS ***/
		getMyLocation();		
		
	}
	function getMyLocation(){
	
	<?php
	
	// MY LOCATION SETUP
	if(isset($_SESSION['mylocation']) && $_SESSION['mylocation']['lat'] != "" && $_SESSION['mylocation']['log'] != ""){
		$lat 		= $_SESSION['mylocation']['lat'];
		$log 		= $_SESSION['mylocation']['log'];
		$zoom		= 5;
	}else{
	
			// GET DEFAULT ROOM AND COORDS FROM ADMIN
            $default_coords = $GLOBALS['CORE_THEME']['google_coords'];    
            
			// CHECK AND VALDATE
            if($default_coords == ""){
				$lat 		= "54.2755532";
				$log 		= "-0.4127722";
			}else{
				$g = explode(",", $default_coords);
				$lat 		= $g[0];
				$log 		= $g[1];
			}
			$zoom 		= 3;
	}
	
	?>
			$mylat = <?php echo $lat; ?>;
			$mylog = <?php echo $log; ?>;
			map.setCenter(new google.maps.LatLng($mylat, $mylog));
			placeMarker($mylat,$mylog,'#','<div class="text-center">Change your location by clicking the link below. </div>', image_here ,'wanna dance');
			map.setZoom(<?php echo $zoom; ?>);
			//addRadius($mylat, $mylog, 100);
	}
	function mapzoomfull(){
		map.setZoom(8);
		map.setCenter(location);
	}
	function centerMarker(colon,colat,plink,pinfo,iconid) { 
		var location = new google.maps.LatLng(colon,colat);
		map.setCenter(location);
	}	
	function placeMarker(colon, colat, plink, pinfo, iconid, ptitle, catid) { 
	
		var mapicon = eval(iconid);	
		var location = new google.maps.LatLng(colon,colat);
		map.setCenter(location);
		bounds.extend(location); 
 
		var myOptions = {
			content: document.createElement("div"),
			boxClass: "mybox",	 
			closeBoxURL: "",
			pixelOffset: new google.maps.Size(-10, -220),
			pane: "floatPane",
			enableEventPropagation: true
		};		 
		
		if(plink == "#"){	
		
			var marker = new google.maps.Marker({
				position: location, 
				map: map,
				url: plink,
				icon: mapicon,
				animation: google.maps.Animation.DROP,
				info: '<div class="wlt-marker-wrapper animated fadeInDown"><div class="wlt-marker-title">My Current Location</div> <div class="wlt-marker-content">'+pinfo+'<div class="clearfix"></div><div class="readmore"><a href="javascript:void(0);" onclick="GMApMyLocation();" data-toggle="modal" data-target="#MyLocationModal">Change Location</a></div><div class="clearfix"></div> <div class="close" onClick=\'javascript:infoBox.close();\'><span class="glyphicon glyphicon-remove"></span></div>',	
			}); 
			marker.setAnimation(google.maps.Animation.BOUNCE);
			setTimeout(function() {
				marker.setAnimation(null)
			}, 10000);
		}else{
		
			var marker = new google.maps.Marker({
				position: location, 
				map: map,
				url: plink,
				icon: mapicon,
				animation: google.maps.Animation.DROP,
				info: '<div class="wlt-marker-wrapper animated fadeInDown"><div class="wlt-marker-title"> <a href="'+ plink +'">'+ ptitle +'</a></div> <div class="wlt-marker-content">'+pinfo+'<div class="clearfix"></div><div class="readmore"><a href="'+ plink +'"><?php echo $CORE->_e(array('button','40','flag_noedit')); ?></a></div><div class="clearfix"></div> <div class="close" onClick=\'javascript:infoBox.close();\'><span class="glyphicon glyphicon-remove"></span></div>',	
			}); 
		
		}
		
		// ADD MARKER TO ARRAY		 
		if(catid != "0" && typeof catid != "undefined"){
			var catmarkers = eval('cat_markers_' + catid);		
			catmarkers.push(marker);		
		}
		
		// ADD TO ALL MARKERS ARRAY
		AllMarkers.push(marker);
  	
		infoBox = new InfoBox(myOptions);	
		 
			google.maps.event.addListener(marker, 'mouseover', function() {
				
			});
			google.maps.event.addListener(marker, 'mouseout', function() {
				//infoBox.close();
			});
			google.maps.event.addListener(marker, 'click', function() {
				infoBox.setContent(this.info);
				infoBox.open(map, this);
			}); 
			  
	} 

initialize();
 
function toggleMarkers(visible, catid){
	
	if( catid == 0){
		var catmarkers = AllMarkers;
	}else{
		var catmarkers = eval('cat_markers_' + catid);
	}
	
    jQuery(catmarkers).each(function(id, marker) {
	
        marker.setVisible(visible);
    });
}
function zoomMarkers(catid){
	
	if( catid == 0){
		var catmarkers = AllMarkers;
	}else{
		var catmarkers = eval('cat_markers_' + catid);
	}
	
	map.setZoom(12);
	
    jQuery(catmarkers).each(function(id, marker) {
		
		map.panTo(marker.position);
		setTimeout(function() { google.maps.event.trigger(marker, 'click'); }, 5000);
		
    });
}
function addRadius(long,lat, radius){

var marker = new google.maps.Marker({
				position: new google.maps.LatLng(long,lat),
				map: map,
				url: '#',
				 
				info: '11',					
				});	 
				
				var circle = {
				  strokeColor: '#FF0000',
				  strokeOpacity: 0.8,
				  strokeWeight: 2,
				  fillColor: '#FF0000',
				  fillOpacity: 0.35,
				  map: map,
				  center: marker.position,
				  radius: radius*1609.344,
				};
				// Add the circle for this city to the map.
				cityCircle = new google.maps.Circle(circle);
	 			map.setCenter(marker.position);
				map.panTo(marker.position);
				map.setZoom(8);
}
function cbutn(){
	if(jQuery('#wlt_map_cat').val() != "0"){ 
	document.wlt_map_search.submit();
	return;
	
	}else if(jQuery('#wlt_map_s').val() != "" && jQuery('#wlt_map_s').val() != "<?php echo strip_tags($_GET['map_s']); ?>" ){ 
	document.wlt_map_search.submit();
	return;
	}
}


function getMapLocation(location, radius){
 
	var geocoder = new google.maps.Geocoder();
		if (geocoder) {	geocoder.geocode({"address": location}, function(results, status) {	
			if (status == google.maps.GeocoderStatus.OK) {	
			 
				map.setCenter(results[0].geometry.location);
		 		
				addRadius(results[0].geometry.location.lat(), results[0].geometry.location.lng(), radius);
			
			}
		});
	}			
}

function switchMarkers(id){
	
	if(jQuery('#cat_marker_'+id).val() == "on"){
	jQuery('#cat_marker_'+id).val('off');
	toggleMarkers(false, id);
	}else{
	jQuery('#cat_marker_'+id).val('on');
	toggleMarkers(true, id);
	}
}	
</script>  

<?php if(!defined('WLT_CHILDTHEME') && get_option('wlt_base_theme') == "template_directory_theme"){ ?>
<style>#core_new_header { display:none; }</style>
<?php } ?>
                
                
<?php 
			
			unset($GLOBALS['noschema']);
			} break;
			
			
			case "slider6": { 
		 
			// ADD-ON SLIDER STYLES
			wp_enqueue_script('slider', get_template_directory_uri().'/framework/slider/jquery.flexslider-min.js');
			wp_enqueue_script('slider');
			
			// ADD-ON PLAYER FILES ENCASE WE HAVE VIDEO
			wp_enqueue_script('video', get_template_directory_uri().'/framework/player/mediaelement-and-player.min.js');
			wp_enqueue_script('video');
			
			//wp_enqueue_style('video', get_template_directory_uri().'/framework/player/mediaelementplayer.min.css');
			//wp_enqueue_style('video'); 
			
			// QUERY
			$querystring = $core_admin_values['widgetobject']['slider6'][$i]['query'];
			if($querystring == ""){ $querystring = "orderby=rand&post_type=listing_type&posts_per_page=10"; }
 
			// RUN
			$slider_query = new WP_Query( hook_custom_queries($querystring) );

			// The Loop
			if ( $slider_query->have_posts() ) {
	
			// DEFAULTS
			$data_carousel = "";
			$slide_carousel = "";
			
			// LOOP
			while ( $slider_query->have_posts() ) {
			
				// GET DATA
				$slider_query->the_post();
				
				// IMAGE		
				$image = hook_image_display(get_the_post_thumbnail($post->ID, 'thumbnail', array('class'=> "wlt_thumbnail")));			
				if($image == ""){$image = hook_fallback_image_display($CORE->FALLBACK_IMAGE($post->ID)); }	
				
				// VIDEO IMAGE
				$image1 = do_shortcode('[VIDEO postid='.$post->ID.' limit=1]');
				if($image1 == ""){
					$image1 = $image;
					$extra = "";
				}else{
					$extra = '<div class="overlay-video fa fa-play"></div>';
				}
				
				// SLIDER DATA
				$slide_carousel .= '<li>
				
				<div class="col-md-5 col-sm-5">' . $image1 . '</div>
				<div class="col-md-7 col-sm-7">
				
				<div class="wrap">
				<h1>'.get_the_title().'</h1> 
				
				<hr />
					<a href="'.get_permalink($post->ID).'" class="btn btn-lg hidden-sm hidden-xs">'.$CORE->_e(array('button','4','flag_noedit')).'</a>
				'.do_shortcode('[RATING style=1 results=1]').'
				<hr class="hidden-sm hidden-xs" />
				 
				<div class="excerptb hidden-sm hidden-xs">'.get_the_excerpt().'</div>
				 
				</div>
				
				</div>
				</li>';
				
				// CAROUSEL DATA
				$data_carousel .= '<li class="playli">' . $image . $extra . '</li>';
			}
		
		} else {
			// no posts found
			return;
		}
		/* Restore original Post Data */
		wp_reset_postdata();
	
?>  

<div class="wlt_object_slider_6 hidden-xs">

    <div class="container-fluid"><div class="row1">
    
    <div id="slider" class="flexslider" style="display:none;">
      <ul class="slides"><?php echo $slide_carousel; ?></ul>
    </div> 
    
    </div></div>
    <div class="wlt_object_slider_6_carousel">
       
        <div id="carousel" class="flexslider">
          <ul class="slides"><?php echo $data_carousel; ?></ul>
        </div>
    </div>
 
</div>

 
<script>
//jQuery('.wlt_object_slider_6 video').mediaelementplayer();
jQuery(window).load(function() {
  // The slider being synced must be initialized first
  jQuery('.wlt_object_slider_6 #carousel').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    itemWidth: 210,
    itemMargin: 5,
    asNavFor: '.wlt_object_slider_6 #slider',
	prevText: '<i class="fa fa-caret-left"></i>',
	nextText: '<i class="fa fa-caret-right"></i>',
  });
 
  jQuery('.wlt_object_slider_6 #slider').flexslider({
    animation: "slide",
    controlNav: false,
    animationLoop: false,
    slideshow: false,
    sync: ".wlt_object_slider_6 #carousel",
	prevText: '',
	nextText: '',
  });
  
  jQuery('#slider').show();
});
</script>

<?php
			
			} break;
			
			
			case "slider5": { 
			//if(isset($GLOBALS['WLT_REVSLIDER'])  ){
			echo "<div class='hidden-xs'>";
			echo do_shortcode(stripslashes("[rev_slider ".$core_admin_values['widgetobject']['slider5'][$i]['id']."]"));
			echo '</div>';
			//}
			
			} break;
		
		
			case "slider4": { 
		
			 
				// GET SLIDER DATA
				$current_data = get_option("wlt_slider4_".$i); 
			 	
				// LOOP TRHOUGH SLIDES
				if(is_array($current_data)){ $s=0;  $slide = 1;
				
				// ADD ON WRAPPER
				echo '<div id="wlt_objectvideoslider_'.$i.'" class="royalSlider rsMinW videoGallery">';
				
				foreach($current_data['name'] as $data){ if($current_data['name'][$s] !=""){ ?>
                
                <a class="rsImg" data-rsw="843" data-rsh="473" data-rsvideo="<?php echo stripslashes($current_data['link'][$s]); ?>" 
                href="<?php echo stripslashes($current_data['image'][$s]); ?>" class="slide<?php echo $slide; ?>">
                    <div class="rsTmb"><?php echo stripslashes($current_data['html'][$s]); ?></div>                    
                 </a>
                             
                <?php $slide++; } $s++;  }		
				
				// ADD ON WRAPPER
				?>
                </div>
                
                <?php } // IF ARRAY ?>
			 	 
<script>

jQuery(document).ready(function($) {
  jQuery('#wlt_objectvideoslider_<?php echo $i; ?>').royalSlider({
    arrowsNav: false,
    fadeinLoadedSlide: true,
    controlNavigationSpacing: 0,
    controlNavigation: 'thumbnails',

    thumbs: {
      autoCenter: false,
      fitInViewport: true,
      orientation: 'vertical',
      spacing: 0,
      paddingBottom: 0
    },
    keyboardNavEnabled: true,
    imageScaleMode: 'fill',
    imageAlignCenter:true,
    slidesSpacing: 0,
    loop: false,
    loopRewind: true,
    numImagesToPreload: 3,
    video: {
      autoHideArrows:true,
      autoHideControlNav:false,
      autoHideBlocks: true
    }, 
    autoScaleSlider: true, 
    autoScaleSliderWidth: 960,     
    autoScaleSliderHeight: 450,
    imgWidth: 640,
    imgHeight: 360

  });
});

</script>

<style>
#wlt_objectvideoslider_<?php echo $i; ?> {  width: 100%; }
#wlt_objectvideoslider_<?php echo $i; ?>.videoGallery .rsTmb {  padding: 20px; padding-top:10px; }
#wlt_objectvideoslider_<?php echo $i; ?>.videoGallery .rsThumbs .rsThumb {  width: 220px;  height: 80px;  border-bottom: 1px solid #2E2E2E; }
#wlt_objectvideoslider_<?php echo $i; ?>.videoGallery .rsThumbs {  background: #111; width: 220px;  padding: 0;}
#wlt_objectvideoslider_<?php echo $i; ?>.videoGallery .rsThumb:hover {  background: #000; }
#wlt_objectvideoslider_<?php echo $i; ?>.videoGallery .rsThumb.rsNavSelected {  background-color: #000;}
#wlt_objectvideoslider_<?php echo $i; ?>.videoGallery .rsTmb h5 {font-size: 16px;margin: 0;padding: 0;line-height: 20px;color: #FFF;}
#wlt_objectvideoslider_<?php echo $i; ?>.videoGallery .rsTmb span {color: #DDD;margin: 0;padding: 0;font-size: 13px;line-height: 18px;}
@media screen and (min-width: 0px) and (max-width: 500px) {
#wlt_objectvideoslider_<?php echo $i; ?>.videoGallery .rsTmb {    padding: 6px 8px;  }
#wlt_objectvideoslider_<?php echo $i; ?>.videoGallery .rsTmb h5 {    font-size: 12px;    line-height: 17px;  }
#wlt_objectvideoslider_<?php echo $i; ?>.videoGallery .rsThumbs.rsThumbsVer {    width: 100px;    padding: 0;  }
#wlt_objectvideoslider_<?php echo $i; ?>.videoGallery .rsThumbs .rsThumb {    width: 100px;    height: 47px;  }
#wlt_objectvideoslider_<?php echo $i; ?>.videoGallery .rsTmb span {    display: none;  }
#wlt_objectvideoslider_<?php echo $i; ?>.videoGallery .rsOverflow,
#wlt_objectvideoslider_<?php echo $i; ?>.royalSlider.videoGallery {    height: 300px !important; }
#wlt_objectvideoslider_<?php echo $i; ?>.sampleBlock {    font-size: 14px;}
}
</style>


            <?php  
		
		
			} break;
		
			case "slider3": { 
			
			 
				// GET SLIDER DATA
				$current_data = get_option("wlt_slider3_".$i); 
				
				// DEMO DATA
				if(defined('WLT_DEMOMODE') && isset($GLOBALS['wlt_slider3'])){ 
				$current_data = $GLOBALS['wlt_slider3'];
				}
				  
				// LOOP TRHOUGH SLIDES
				if(is_array($current_data)){ $s=0;  $slide = 1;
				
				// INCLUDE CSS BEFORE SLIDES
				?>
                <style>
				#wlt_objectslider_<?php echo $i; ?> { width: 100%; }
				#wlt_objectslider_<?php echo $i; ?> .rsImg {position: absolute;}
				#wlt_objectslider_<?php echo $i; ?> .rsContent {  color: #FFF;  font-size: 50px;  line-height: 32px;  float: left;}
				#wlt_objectslider_<?php echo $i; ?> .bContainer {  position: relative;}
				#wlt_objectslider_<?php echo $i; ?> .bContainer {  top: 10%; text-align:center;}
				#wlt_objectslider_<?php echo $i; ?> .bContainer h1 { font-size:200%; }
				#wlt_objectslider_<?php echo $i; ?> .bContainer h2 { font-size:150%; }
				#wlt_objectslider_<?php echo $i; ?> .bContainer h3 { font-size:100%; }
				#wlt_objectslider_<?php echo $i; ?> .bContainer p { font-size:60%; }
				#wlt_objectslider_<?php echo $i; ?> .bContainer .btn { 				 
				color: #fff;
				padding: 26px 33px;
				background: #444;
				border-radius:0px;
				}
				</style>
                <?php
				
				// ADD ON WRAPPER
				echo '<div id="wlt_objectslider_'.$i.'" class="royalSlider rsMinW hidden-xs">';
				
				foreach($current_data['name'] as $data){ if($current_data['name'][$s] !=""){ ?>
                
                <div class="rsContent slide<?php echo $slide; ?>">
                                
					<?php 
                    // CHECK FOR IMAGE
                    if(strlen($current_data['image'][$s]) > 1){ ?>
                    <img class="rsImg" src="<?php echo $current_data['image'][$s]; ?>" alt="img">
                    <?php } ?>
                    
                    <div class="bContainer"><?php echo stripslashes($current_data['html'][$s]); ?></div>
                
                </div>  
                             
                <?php $slide++; } $s++;  }		
				
				// ADD ON WRAPPER
				?>
                </div>
                
                <?php
				
				// LOOP FOR BACKGROUND COLORS
				$s = 0; $slide = 1;
				foreach($current_data['name'] as $data){ if($current_data['name'][$s] !=""){ 
				 
                    // CHECK FOR IMAGE
                    if(strlen($current_data['bgcolor'][$s]) > 1){ 
                    echo '<style>.slide'.$slide.' { background:'.$current_data['bgcolor'][$s].' }</style>';
                    }
				
				$slide++; 
				
				} $s++;  }	
				
				?>
                
                <script>
				jQuery(document).ready(function($) {
  jQuery.rsCSS3Easing.easeOutBack = 'cubic-bezier(0.175, 0.885, 0.320, 1.275)';
  jQuery('#wlt_objectslider_<?php echo $i; ?>').royalSlider({
 
    	autoPlay: {
    		// autoplay options go gere
    		enabled: true,
    		pauseOnHover: true,
			delay:	5000,
    	},
    arrowsNav: false,
    arrowsNavAutoHide: false,
    fadeinLoadedSlide: false,
    controlNavigationSpacing: 0,
    controlNavigation: 'bullets',
    imageScaleMode: 'none',
    imageAlignCenter:false,
    blockLoop: true,
    loop: true,
    numImagesToPreload: 6,
    transitionType: 'fade',
    keyboardNavEnabled: true,	
	block: {
    		// animated blocks options go gere
    		fadeEffect: false,
    		moveEffect: 'left'
    	}
  });
});</script>
                
                <?php 
				
				} // end if array
			 
			
			} break;
		
			case "slider2": {
							
			 
				// ENQUEUE SCRIPTS
				wp_enqueue_script('flexslider', get_template_directory_uri()."/framework/slider/jquery.flexslider-min.js");
				wp_enqueue_style('flexslider', get_template_directory_uri()."/framework/slider/flexslider.css");	

				
			if(isset($GLOBALS['CORE_THEME']['slider2']) && strlen($GLOBALS['CORE_THEME']['slider2']['c1']) > 3){ $bg1 = "style='background:".$GLOBALS['CORE_THEME']['slider2']['c1']."'"; }else{ $bg1 = ''; }
			if(isset($GLOBALS['CORE_THEME']['slider2']) && strlen($GLOBALS['CORE_THEME']['slider2']['c2']) > 3){ $bg2 = "style='background:".$GLOBALS['CORE_THEME']['slider2']['c2']."'"; }else{ $bg2 = ''; }
			if(isset($GLOBALS['CORE_THEME']['slider2']) && strlen($GLOBALS['CORE_THEME']['slider2']['c3']) > 3){ $bg3 = "style='background:".$GLOBALS['CORE_THEME']['slider2']['c3']."'"; }else{ $bg3 = ''; }
			
			if(isset($GLOBALS['CORE_THEME']['slider2']) && strlen($GLOBALS['CORE_THEME']['slider2']['img1']) > 3){ $img1 = "style='background-image:url(".$GLOBALS['CORE_THEME']['slider2']['img1'].");'"; }else{ $img1 = ''; }
			if(isset($GLOBALS['CORE_THEME']['slider2']) && strlen($GLOBALS['CORE_THEME']['slider2']['img2']) > 3){ $img2 = "style='background-image:url(".$GLOBALS['CORE_THEME']['slider2']['img2'].");'"; }else{ $img2 = ''; }
			if(isset($GLOBALS['CORE_THEME']['slider2']) && strlen($GLOBALS['CORE_THEME']['slider2']['img3']) > 3){ $img3 = "style='background-image:url(".$GLOBALS['CORE_THEME']['slider2']['img3'].");'"; }else{ $img3 = ''; }
			
			 
				
				if(!defined('SLIDER2-NOSIDE')){ $fspan = "col-md-8"; }else{ $fspan = "col-md-12"; }	
				$STRING = '<div class="wlt_core_slider_two hidden-xs"> 
					<div class="row">
						<div class="'.$fspan.'">
						
							<div class="flexslider-holder">
								<div class="flexslider-container">
									<div class="flexslider">
										<ul class="slides">';
										$i=1; 
										while($i < 5){	
											if(isset($GLOBALS['CORE_THEME']['slider2']['slider_item_'.$i]) && strlen($GLOBALS['CORE_THEME']['slider2']['slider_item_'.$i]) > 5){ 
											$STRING .= '<li> <a href="'.$GLOBALS['CORE_THEME']['slider2']['slider_link_'.$i].'"><img src="'.$GLOBALS['CORE_THEME']['slider2']['slider_item_'.$i].'" alt="" class="wltatt_id" /></a> </li>';
											}
										$i++;
										}
										
										$STRING .= '</ul>
									</div>
								</div>
							</div> 
				
				
				</div>';
				
				$STRING .= '<div class="col-md-4 sidebox hidden-sm hidden-xs">
			
			<div class="box1" '.$bg1.' '.$img1.'>
				<a href="'.$GLOBALS['CORE_THEME']['slider2']['l1'].'" class="text_widget">';
				
				if(isset($GLOBALS['CORE_THEME']['slider2']) && strlen($GLOBALS['CORE_THEME']['slider2']['b1']) > 0){ $STRING .= '<span class="main_text">'.stripslashes($GLOBALS['CORE_THEME']['slider2']['b1'])."</span>"; }
				if(isset($GLOBALS['CORE_THEME']['slider2']) && strlen($GLOBALS['CORE_THEME']['slider2']['b2']) > 0){ $STRING .= '<span class="text_span">'.stripslashes($GLOBALS['CORE_THEME']['slider2']['b2'])."</span>"; }
				if(isset($GLOBALS['CORE_THEME']['slider2']) && strlen($GLOBALS['CORE_THEME']['slider2']['b3']) > 0){ $STRING .= '<span class="text_span1">'.stripslashes($GLOBALS['CORE_THEME']['slider2']['b3'])."</span>"; }
		 
			$STRING .= '</a>
			</div>
			<div class="clearfix"></div>
			
			<div class="box2" '.$bg2.' '.$img2.'>
				<a href="'.$GLOBALS['CORE_THEME']['slider2']['l2'].'" class="text_widget">';
				
				if(isset($GLOBALS['CORE_THEME']['slider2']) && strlen($GLOBALS['CORE_THEME']['slider2']['b4']) > 0){ $STRING .= '<span class="main_text">'.stripslashes($GLOBALS['CORE_THEME']['slider2']['b4'])."</span>"; }
				if(isset($GLOBALS['CORE_THEME']['slider2']) && strlen($GLOBALS['CORE_THEME']['slider2']['b5']) > 0){ $STRING .= '<span class="text_span">'.stripslashes($GLOBALS['CORE_THEME']['slider2']['b5'])."</span>"; }
				if(isset($GLOBALS['CORE_THEME']['slider2']) && strlen($GLOBALS['CORE_THEME']['slider2']['b6']) > 0){ $STRING .= '<span class="text_span1">'.stripslashes($GLOBALS['CORE_THEME']['slider2']['b6'])."</span>"; }
		 
			$STRING .= '</a>
			</div>
			<div class="clearfix"></div>
			
			<div class="box3" '.$bg3.' '.$img3.'> 
				<a href="'.$GLOBALS['CORE_THEME']['slider2']['l3'].'" class="text_widget">';
				
				if(isset($GLOBALS['CORE_THEME']['slider2']) && strlen($GLOBALS['CORE_THEME']['slider2']['b7']) > 0){ $STRING .= '<span class="main_text">'.stripslashes($GLOBALS['CORE_THEME']['slider2']['b7'])."</span>"; }
				if(isset($GLOBALS['CORE_THEME']['slider2']) && strlen($GLOBALS['CORE_THEME']['slider2']['b8']) > 0){ $STRING .= '<span class="text_span">'.stripslashes($GLOBALS['CORE_THEME']['slider2']['b8'])."</span>"; }
				if(isset($GLOBALS['CORE_THEME']['slider2']) && strlen($GLOBALS['CORE_THEME']['slider2']['b9']) > 0){ $STRING .= '<span class="text_span1">'.stripslashes($GLOBALS['CORE_THEME']['slider2']['b9'])."</span>"; }
		 
			$STRING .= '</a>
			</div>
			
			
			<div class="clearfix"></div>
			</div>';
		 
			$STRING .= '</div>
			<!-- end top half -->';

			 	 
				
				$STRING .= '</div>
			 
				<script type="text/javascript">
					jQuery(window).load(function() {
						jQuery(\'.flexslider\').flexslider({
							animation: "fade",              //String: Select your animation type, "fade" or "slide"
							slideDirection: "horizontal",   //String: Select the sliding direction, "horizontal" or "vertical"
							slideshow: true,                //Boolean: Animate slider automatically
							slideshowSpeed: 5000,           //Integer: Set the speed of the slideshow cycling, in milliseconds
							animationDuration: 500,         //Integer: Set the speed of animations, in milliseconds
							directionNav: true,             //Boolean: Create navigation for previous/next navigation? (true/false)
							controlNav: false,               //Boolean: Create navigation for paging control of each clide? Note: Leave true for manualControls usage
							keyboardNav: true,              //Boolean: Allow slider navigating via keyboard left/right keys
							mousewheel: false,              //Boolean: Allow slider navigating via mousewheel
							prevText: "Previous",           //String: Set the text for the "previous" directionNav item
							nextText: "Next",               //String: Set the text for the "next" directionNav item
							pausePlay: false,               //Boolean: Create pause/play dynamic element
							randomize: false,               //Boolean: Randomize slide order
							slideToStart: 0,                //Integer: The slide that the slider should start on. Array notation (0 = first slide)
							animationLoop: true,            //Boolean: Should the animation loop? If false, directionNav will received "disable" classes at either end
							pauseOnAction: true,            //Boolean: Pause the slideshow when interacting with control elements, highly recommended.
							pauseOnHover: false,            //Boolean: Pause the slideshow when hovering over slider, then resume when no longer hovering
				 
						});
					});
				</script>';
				
				echo $STRING;
			
			} break;
		 
		
			case "slider1": {
				
			get_template_part('framework/objects/object', 'slider1' ); 
			
			} break;
				
			case "navs": {
			
				/* check which width we should show at */
				if($fullwidth && $core_admin_values['widgetobject']['navs'][$i]['fullw'] != "yes"){ continue; }
				if(!$fullwidth && $core_admin_values['widgetobject']['navs'][$i]['fullw'] == "yes"){ continue; }
				
				$type = $core_admin_values['widgetobject']['navs'][$i]['type'];
				
				?>
				<div class="navs_object_container">
				<ul class="nav nav-pills">
				<?php if($type == 1){ ?>
				<?php wp_list_categories('title_li=&taxonomy='.THEME_TAXONOMY ); ?> 
				<?php }elseif($type == 2){ ?>
				<?php wp_list_categories('title_li='); ?> 
				<?php }elseif($type == 3){ ?>
				<?php wp_list_pages('title_li=&taxonomy='.THEME_TAXONOMY ); ?> 
				<?php } ?>
				</ul>
				</div>
				<?php
				 
			} break;
			
			case "blog": {
				
				/* check which width we should show at */
				if($fullwidth && $core_admin_values['widgetobject']['blog'][$i]['fullw'] != "yes"){ continue; }
				if(!$fullwidth && $core_admin_values['widgetobject']['blog'][$i]['fullw'] == "yes"){ continue; }
				
				$_title 		= $core_admin_values['widgetobject']['blog'][$i]['title'];
				$_amount 		= $core_admin_values['widgetobject']['blog'][$i]['amount'];
				
				if($_amount == ""){ $_amount = 5; }
				
				echo '<div class="panel panel-default" id="core_object_blogs">
				<div class="panel-heading">'.$_title.'</div>		
				';
				
				// GET QUERY FOR BLOG POSTS
				
				$query_string = "post_type=post&orderby=ID&order=desc&posts_per_page=".$_amount;
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$posts = query_posts($query_string."&paged=".$paged); 
					 
				if (have_posts()) : ?>
                <ul class="list-group">
                
                <?php while (have_posts()) : the_post();  ?>
                
                <li class="list-group-item">
				
				<?php get_template_part( 'content', 'post' ); ?>
				
				</li>   
				
				<?php endwhile; ?>
                </ul>
                <?php endif; 
				
				
				echo "</div>";
				// output
				 
				
			} break;
		
			case "gmap": {
			 
			// FULL OR HALF WIDTH
			if($fullwidth && $core_admin_values['widgetobject']['gmap'][$i]['fullw'] != "yes"){ continue; }
			if(!$fullwidth && $core_admin_values['widgetobject']['gmap'][$i]['fullw'] == "yes"){ continue; }
			
			$num = $core_admin_values['widgetobject']['gmap'][$i]['num'];
			$dtype = $core_admin_values['widgetobject']['gmap'][$i]['dtype'];
			if($num == ""){ $num = 100; } 
			if($dtype == ""){ $dtype = 1; } 
			
			switch($dtype){
			
			case "2": {
			$_query = array(		  
			  'post_type' => THEME_TAXONOMY.'_type',
			  'orderby' => 'rand',
			  'posts_per_page' => $num,
			  'meta_query' => array (
				array (
				  'key' => 'map-lat',
				  'value' => '',
				   'compare' => '!='
				),
				array (
				  'key' => 'featured',
				  'value' => 'yes',
				   'compare' => '='
				),
			  ) );
			} break;
			
			case "3": {
			$_query = array(		  
			  'post_type' => THEME_TAXONOMY.'_type',
			  'orderby' => 'rand',
			  'posts_per_page' => $num,
			  'meta_query' => array (
				array (
				  'key' => 'map-lat',
				  'value' => '',
				   'compare' => '!='
				),
				array (
				  'key' => 'frontpage',
				  'value' => 'yes',
				   'compare' => '='
				),
			  ) );
			} break;
			
			default: {
			$_query = array(		  
			  'post_type' => THEME_TAXONOMY.'_type',
			  'orderby' => 'rand',
			  'posts_per_page' => $num,
			  'meta_query' => array (
				array (
				  'key' => 'map-lat',
				  'value' => '',
				   'compare' => '!='
				)
			  ) );
			} break;
			} 
			
			 
			$_zoom 			= $core_admin_values['widgetobject']['gmap'][$i]['zoom']; if($_zoom == "" || !is_numeric($_zoom)){ $_zoom =7; }
			$_dc 			= $core_admin_values['widgetobject']['gmap'][$i]['dc']; if($_dc == ""){ $_dc = "0,0"; }
			$_clickme 		= $core_admin_values['widgetobject']['gmap'][$i]['clickme'];
			$_caticons 		= $core_admin_values['widgetobject']['gmap'][$i]['caticons'];
			$_title 		= $core_admin_values['widgetobject']['gmap'][$i]['title'];
		 
			$_map_string 	= "";
			// DEFAULTS
					$string = "";
					$stopcount = 4;
					$f = query_posts($_query); 				 
					$i=1; $aset = "active"; $runningCount = 0; $totalcount = 0;  $openedtags = false;				
					if ( have_posts() ) : while ( have_posts() ) : the_post();
						
						$GLOBALS['POSTID'] = $post->ID;
						$long = get_post_meta($post->ID,'map-log',true);
						$lat = get_post_meta($post->ID,'map-lat',true);					
						if($long == "" || $lat == ""){ continue; }	
						 
						/*** build map string ***/
						$mapimg = "image";
						if($_caticons == "yes"){
						$tts = wp_get_post_terms($post->ID, THEME_TAXONOMY, array("fields" => "ids") );
						if(isset($tts[0])){ $mapimg = "icon_".$tts[0]; }
						}				 
						$permalink = get_permalink($post->ID);
						$_map_string .= "[".$lat.", ".$long.",'".$permalink."','".addslashes($CORE->ITEM_CONTENT($post, "[IMAGE pid='".$post->ID."'][EXCERPT striptags=true]"))."',".$mapimg.",'".strip_tags(str_replace("'","",$post->post_title))."'],";
						if($_dc == "0,0"){ $_dc = $long.",".$lat; }
						
						/*** build display ***/ 			
						$_btn_d = 'WLTMapData(\''.str_replace("http://","",get_home_url()).'\', '.$post->ID.', \'map_sidebarcontent\');jQuery(\'#map_sidebarslider\').fadeIn(300);mapzoomfull();';					
						
						// BUILD STRING
						if($i == 1){ $string .= '<div class="item '.$aset.'"><div class="wlt_search_results grid_style">'; $aset = ""; $openedtags = true; }
						
						if($i == $stopcount){ $ac =" lastitem"; }else{$ac =""; }
						if($i == 1){ $ee =" "; }else{$ee =" hidden-xs"; }
						
						// CONTENT LISTING 
						$GLOBALS['item_class_size'] = 'col-md-3 '.$ee;
						
						ob_start();
						get_template_part( 'content', hook_content_templatename($post->post_type) );
						$string .= ob_get_contents();
						ob_end_clean();
					 
						// STR_REPLACE FOR PERMALINK		
						$string = str_replace($permalink,'javascript:void(0);" onclick="centerMarker(\''.$lat.'\',\''.$long.'\',\''.$permalink.'\',\''.strip_tags(str_replace("'","",$post->post_title)).'\');'.$_btn_d.'',$string);
						
						 				
						if($i == $stopcount){$string .= '</div></div>'; $i=0;  $runningCount++; $openedtags = false; }	
						$i++;  $totalcount++;
						
					endwhile; endif; wp_reset_query();
					unset($GLOBALS['POSTID']); 		
					
					// CLOSE TAGS
					if($openedtags){
					$string .= '</div></div>';
					}
			// MAKE SURE WE CAN DISPLAY THIS MAP (IE, IT HAS VALUES)
			if($_map_string == ""){ return; }
			?> 
		   
			<div id="map_object_container" class="hidden-xs">
            <div class="panel panel-default">
            
			<?php if(strlen($_title) > 0){ ?><div class="panel-heading"><?php echo $_title; ?></div><?php } ?>
			
			<div id="map_container" class="container1 clearfix">         
			  <div id="map_map" class="map-inner"></div>         
			  <div id="map_sidebarslider" class="hidden-xs"><div id="map_sidebarcontent"></div></div>
			</div><!-- end map container -->
            
			   
			<div id="map_carousel" class="carousel_block">
            	<div id="wlt_carsousel_aa" class="carousel slide"  data-ride="carousel">      
                
                
                  <!-- Indicators -->
				  <?php
				  
				  if($runningCount > 0){ 
				  $runningCount++; 				  
				  if($totalcount == 4 || $totalcount == 8 || $totalcount == 12 || $totalcount == 16 || $totalcount == 20 || $totalcount == 24 || $totalcount == 28){  $runningCount--; }
				  ?>  
                  <div class="clearfix"></div>                 
				  <ol class="carousel-indicators">					 
					<?php $aa=0; while($aa < $runningCount){ ?>
					<li data-target="#wlt_carsousel_aa" data-slide-to="<?php echo $aa; ?>" <?php if($aa == 0){ ?> class="active"<?php } ?>></li>
					<?php $aa++; } ?>
				  </ol>
				  <?php } ?> 
                     
                 <!-- slider content -->
                 <div class="carousel-inner"><?php echo $string; ?></div>                 
                 
          	</div>
          </div> <!-- END MAP CAROUSEL -->  			
 
        
        </div><!-- end block -->
        </div><!-- END MAP CONTAINER -->
		 
	<script src="<?php echo $CORE->googlelink(); ?>" type="text/javascript"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/framework/js/jquery.infobox.js" type="text/javascript"></script>    
	<script type="text/javascript"> 
	var map;
	<?php
	// MULTIPLE MAP MARKERS BASIC ON THE CATEGORY ICON
	if($_caticons == "yes"){
		$terms = get_terms(THEME_TAXONOMY, 'orderby=count&hide_empty=0');
		$count = count($terms);
		if ( $count > 0 ){
			foreach ( $terms as $term ) {
				$IMG_PATH = $GLOBALS['CORE_THEME']['category_icon_'.$term->term_id];
				if(strlen($IMG_PATH) > 1){
				?>
				var icon_<?php echo $term->term_id; ?> = new google.maps.MarkerImage('<?php echo $IMG_PATH; ?>');
				<?php }else{ ?>
				var icon_<?php echo $term->term_id; ?> = new google.maps.MarkerImage('<?php echo get_template_directory_uri(); ?>/framework/img/map/icon.png');
				<?php }
			}
		}
	}
	?>
	
	var image = new google.maps.MarkerImage('<?php echo get_template_directory_uri(); ?>/framework/img/map/icon.png');
	var shadow = new google.maps.MarkerImage('<?php echo get_template_directory_uri(); ?>/framework/img/map/shadow.png');
	var locations = new Array(<?php echo substr(str_replace("<p>","",str_replace("</p>","",$_map_string)),0,-1); ?>);
	function initialize() {
		var myLatlng = new google.maps.LatLng('<?php echo $_dc; ?>');
		var myOptions = { zoom: <?php echo $_zoom; ?>,  center: myLatlng,  mapTypeId: google.maps.MapTypeId.ROADMAP, disableDefaultUI: true }
		map = new google.maps.Map(document.getElementById("map_map"), myOptions); 
		/** now loop through each location and plot it on the graph **/
		jQuery.each(locations, function(index, location) {	
		placeMarker(location[0],location[1],location[2],location[3],location[4],location[5]);
		});	
		<?php if($_clickme == "yes"){ ?>
		jQuery('#map_container').hide(); 
		<?php } ?>
	}
	function mapzoomfull(){
	map.setZoom(<?php echo $_zoom+2; ?>);
	//map.setCenter(location);
	}
	function centerMarker(colon,colat,plink,pinfo,iconid) {
		<?php if($_clickme == "yes"){ ?>jQuery('#map_container').show(); google.maps.event.trigger(map, 'resize');<?php } ?>
		var location = new google.maps.LatLng(colon,colat);
		map.setCenter(location);
	}
	function placeMarker(colon,colat,plink,pinfo,iconid,ptitle) {
	
		<?php if($_clickme == "yes"){ ?>jQuery('#map_container').show(); google.maps.event.trigger(map, 'resize');<?php } ?>
		
		var location = new google.maps.LatLng(colon,colat);
		//map.setCenter(location);	
		var marker = new google.maps.Marker({
			position: location, 
			shadow: shadow,
			map: map,
			url: plink,			 
			icon: iconid,
			animation: google.maps.Animation.DROP,
			info: '<div class="wlt-marker-wrapper animated fadeInDown"><div class="wlt-marker-title"> <a href="'+ plink +'">'+ ptitle +'</a></div> <div class="wlt-marker-content">'+pinfo+'<div class="clearfix"></div><div class="readmore"><a href="'+ plink +'"><?php echo $CORE->_e(array('button','40','flag_noedit')); ?></a></div><div class="clearfix"></div> <div class="close" onClick=\'javascript:infoBox.close();\'><span class="glyphicon glyphicon-remove"></span></div>',				
		});	  
			
			var myOptions = {
			content: document.createElement("div"),
			boxClass: "mybox",	 
			closeBoxURL: "",
			pixelOffset: new google.maps.Size(-10, -220),
			pane: "floatPane",
			enableEventPropagation: true
			};
			infoBox = new InfoBox(myOptions);
			
			
			google.maps.event.addListener(marker, 'mouseover', function() {
				infoBox.setContent(this.info);
				infoBox.open(map, this);
			});
						
			google.maps.event.addListener(marker, 'click', function() {
				window.location.href = this.url;
			});
			
		
			map.setCenter(location);	 
	}
	initialize();
	
	jQuery(document).ready(function() {
		jQuery('#wlt_carsousel_aa').carousel({
			interval: 7500,
			pause: "hover"
		});
	});
	</script> <?php
	
			} break;
		
			case "tabs": {
			
			// LOAD IN UDER SETTINGS
			if($fullwidth && $core_admin_values['widgetobject']['tabs'][$i]['fullw'] != "yes"){ continue; }
			if(!$fullwidth && $core_admin_values['widgetobject']['tabs'][$i]['fullw'] == "yes"){ continue; }
			if($core_admin_values['widgetobject']['tabs'][$i]['btnview'] == "yes"){ $btnview = "yes"; }else{ $btnview = "no"; }
			 
			
			switch($core_admin_values['widgetobject']['tabs'][$i]['perrow']){
				case "3": { $perrow = 'col-md-4 col-sm-4 col-xs-6'; } break;
				case "4": { $perrow = 'col-md-3 col-sm-3 col-xs-6'; } break;
				case "5": { $perrow = 'col-md-new5 col-sm-4 col-xs-6'; } break;
				case "6": { $perrow = 'col-md-2 col-sm-3 col-xs-6'; } break;
				default: { $perrow = 'col-md-4 col-sm-4 col-xs-6'; }
			}
			
			
			
			echo "<div class='wlt_object_tabs'>";
			
			// WRAPPER
			echo '<ul class="wlt_tab_object nav nav-tabs hidden-xs">
				  <li class="active"><a href="#t1">'.stripslashes($core_admin_values['widgetobject']['tabs'][$i]['title1']).'</a></li>';
				  if(strlen($core_admin_values['widgetobject']['tabs'][$i]['title2']) > 0){
				  echo '<li><a href="#t2">'.stripslashes($core_admin_values['widgetobject']['tabs'][$i]['title2']).'</a></li>';
				  }
				  if(strlen($core_admin_values['widgetobject']['tabs'][$i]['title3']) > 0){
				  echo '<li><a href="#t3">'.stripslashes($core_admin_values['widgetobject']['tabs'][$i]['title3']).'</a></li>';
				  }
				  if(strlen($core_admin_values['widgetobject']['tabs'][$i]['title4']) > 0){
				  echo '<li><a href="#t4">'.stripslashes($core_admin_values['widgetobject']['tabs'][$i]['title4']).'</a></li>';
				  }
				  
				  // ADD ON BUTTON	
				if($btnview == "yes"){ echo '<li class="pull-right hidden-xs"><a href="javascript:void(0);" onclick="window.location=\''.get_home_url().'\/?s=\'" rel="nofollow">'.$CORE->_e(array('button','35')).'</a></li>'; } 
			
				echo '</ul>
				 
				<div class="tab-content row">';
				$a=1; $extra = "";
				while($a < 5){ 
					// CHECK FOR QUERY STRING	
					if($a ==1){ $atab = " active"; }else{ $atab = ""; }
					echo '<div class="tab-pane'.$atab.'" id="t'.$a.'">';
					// CHECK FOR CUSTOM TEXT
					if(strlen(stripslashes($core_admin_values['widgetobject']['tabs'][$i]['content'.$a])) > 1){
					echo "<div class='padding'>".do_shortcode(stripslashes($core_admin_values['widgetobject']['tabs'][$i]['content'.$a]))."</div>";
					}
						if( strlen($core_admin_values['widgetobject']['tabs'][$i]['query'.$a]) > 2 ){
							  
							$qr = hook_custom_queries("post_type=".THEME_TAXONOMY."_type&".$core_admin_values['widgetobject']['tabs'][$i]['query'.$a]);
							$my_query = new WP_Query($qr); $g=0;						 
						 
							if( $my_query->have_posts() ) {
														
								// GET LIST STYLE
								if($core_admin_values['widgetobject']['tabs'][$i]['style'.$a] == "list"){											
									$lsst = "list_style"; 						
								}else{ 
									$lsst = "grid_style"; 
								}
								
								// WRAPPER
								echo '<div class="wlt_search_results '.$lsst.'">';
													
								// CHECK WE HAVE RESULTS	
								foreach($my_query->posts as $post){
									
									// CONTENT LISTING 
									$GLOBALS['item_class_size'] = $perrow;
									get_template_part( 'content', hook_content_templatename($post->post_type) );
				
									 	 
								}// end foreach
								
								// END WRAPPER
								echo '</div>';							 					
							}
							// RESET QUERY
							wp_reset_postdata();
						}
						
					// END WRAPPER
					echo '</div>';	 
					
				$a++;
				}
				 
				echo '</div><script>jQuery(document).ready(function(){ jQuery(\'.wlt_tab_object a\').click(function (e) {  e.preventDefault(); jQuery(this).tab(\'show\');  equalheight(\'.tab-content .grid_style .itemdata .thumbnail\');  }) })
			 
			jQuery(window).load(function() {
			  equalheight(\'.tab-content .grid_style .itemdata .thumbnail\');
			});
			
			jQuery(window).resize(function(){
			  equalheight(\'.tab-content .grid_style .itemdata .thumbnail\');
			});
			 
			 </script>';
			 
			 echo "</div>"; // end wrapper
	 
			} break;
		
			case "carsousel": {
			
				if($fullwidth && $core_admin_values['widgetobject']['carsousel'][$i]['fullw'] != "yes"){ continue; }
				if(!$fullwidth && $core_admin_values['widgetobject']['carsousel'][$i]['fullw'] == "yes"){ continue; }
				
				// LOAD DATA
				get_template_part('framework/objects/object', 'carsousel' ); 
			
			} break;
			
			case "recentlisting": {		 	
				
				/* check which width we should show at */
				if($fullwidth && $core_admin_values['widgetobject']['recentlisting'][$i]['fullw'] != "yes"){ continue; }
				if(!$fullwidth && $core_admin_values['widgetobject']['recentlisting'][$i]['fullw'] == "yes"){ continue; }
				 
				echo '<div id="recentlistings" class="clearfix"><div class="_searchresultsdata"><div class="panel panel-default">';
				
				if(strlen($core_admin_values['widgetobject']['recentlisting'][$i]['title']) > 1){
				echo '<div class="panel-heading">'.$core_admin_values['widgetobject']['recentlisting'][$i]['title'].'</div>';
				}
				 		
				// DEFAULTS
				if(!isset($core_admin_values['widgetobject']['recentlisting'][$i]['query'])){ $core_admin_values['widgetobject']['recentlisting'][$i]['query'] = ""; }
				if($core_admin_values['widgetobject']['recentlisting'][$i]['query'] == ""){ $eq = ""; }else{ $eq = $core_admin_values['widgetobject']['recentlisting'][$i]['query'];  }	
				if($core_admin_values['widgetobject']['recentlisting'][$i]['style'] == "grid"){ $ss = "grid_style"; $cssExtra = "panel-body"; }else{ $ss = "list_style"; $cssExtra = "";  }
				 
				
				switch($core_admin_values['widgetobject']['recentlisting'][$i]['perrow']){
				case "3": { $perrow = 'col-md-4 col-sm-4 col-xs-6'; } break;
				case "4": { $perrow = 'col-md-3 col-sm-3 col-xs-6'; } break;
				case "5": { $perrow = 'col-md-new5 col-sm-4 col-xs-6'; } break;
				case "6": { $perrow = 'col-md-2 col-sm-3 col-xs-6'; } break;
				default: { $perrow = 'col-md-4 col-sm-4 col-xs-6'; }
				}
				
				if($core_admin_values['widgetobject']['recentlisting'][$i]['pagenav'] == "yes"){ $pagenav = "yes"; }else{ $pagenav = "no"; }	   
				// MARKS CUSTOM PAGED ELEMENTS
				$paged = (isset($_GET['home_paged']) && $_GET['home_paged']) ? $_GET['home_paged'] : 1;
				// CHECK FOR USER SETTINGS OF POSTS PER PAGE, OTHERWISE SET OUR OWN
				if (strpos($eq,'posts_per_page') == false){				
				$eq .= "&posts_per_page=".intval(get_query_var('posts_per_page'));
				} 
						 
				// WRAPPER			     
				echo '<div class="'.$ss.' '.$cssExtra.' wlt_search_results row">';			
				
				// LOOP RESULTS
				query_posts(hook_custom_queries($eq.'&post_type='.THEME_TAXONOMY.'_type&paged='.$paged)); $i=1; 
				if ( have_posts() ) : while ( have_posts() ) : the_post();  
				
				// CONTENT LISTING 
				$GLOBALS['item_class_size'] = $perrow;
				get_template_part( 'content', hook_content_templatename($post->post_type) );
				 
				// END LOOP
				$i++; endwhile; endif;
				
				// END WRAPPER
				echo '<div class="clearfix"></div>  </div> </div> </div>';
				
				// ADD ON PAGE NAVIGATION
				if($i > 1 && $pagenav == "yes"){			  
				echo $CORE->PAGENAV();	
				}
				
				echo '</div><script>        
					jQuery(window).load(function() {
					  equalheight(\'#recentlistings .grid_style .itemdata .thumbnail\');
					}); 
					
					jQuery(window).resize(function(){
					  equalheight(\'#recentlistings .grid_style .itemdata .thumbnail\');
					}); 
					
				</script>';	
				 
				// CLOSE QUERY
				wp_reset_query();		 
				 
			} break;
			
					
			case "2columns": {	
	  			
				if($core_admin_values['widgetobject'][$item][$i]['autop'] == 1){
				echo do_shortcode('<div class="row columns2_object hidden-xs">
				<div class="col-md-6 col-sm-6">'.wpautop(do_shortcode(stripslashes($core_admin_values['widgetobject']['2columns'][$i]['col1']))).'</div>
				<div class="col-md-6 col-sm-6">'.wpautop(do_shortcode(stripslashes($core_admin_values['widgetobject']['2columns'][$i]['col2']))).'</div>	
				</div>');
				}else{
				echo do_shortcode('<div class="row columns2_object hidden-xs">
				<div class="col-md-6 col-sm-6">'.do_shortcode(stripslashes($core_admin_values['widgetobject']['2columns'][$i]['col1'])).'</div>
				<div class="col-md-6 col-sm-6">'.do_shortcode(stripslashes($core_admin_values['widgetobject']['2columns'][$i]['col2'])).'</div>	
				</div>');
				}
	
			} break;
			
			case "3columns": {	
	  	
				echo do_shortcode('<div class="row columns3_object hidden-xs">
				<div class="col-md-4 col-sm-4">'.wpautop(do_shortcode(stripslashes($core_admin_values['widgetobject']['3columns'][$i]['col1']))).'</div>
				<div class="col-md-4 col-sm-4">'.wpautop(do_shortcode(stripslashes($core_admin_values['widgetobject']['3columns'][$i]['col2']))).'</div>
				<div class="col-md-4 col-sm-4">'.wpautop(do_shortcode(stripslashes($core_admin_values['widgetobject']['3columns'][$i]['col3']))).'</div>		
				</div>');
	
			} break;
			
			case "4columns": {	
	  	
				echo do_shortcode('<div class="row columns4_object hidden-xs">
				<div class="col-md-3 col-sm-3">'.wpautop(do_shortcode(stripslashes($core_admin_values['widgetobject']['4columns'][$i]['col1']))).'</div>
				<div class="col-md-3 col-sm-3">'.wpautop(do_shortcode(stripslashes($core_admin_values['widgetobject']['4columns'][$i]['col2']))).'</div>
				<div class="col-md-3 col-sm-3">'.wpautop(do_shortcode(stripslashes($core_admin_values['widgetobject']['4columns'][$i]['col3']))).'</div>
				<div class="col-md-3 col-sm-3">'.wpautop(do_shortcode(stripslashes($core_admin_values['widgetobject']['4columns'][$i]['col4']))).'</div>	
				</div>');
	
			} break;
			
			
			case "image1":
			case "image2":
			case "image3":
			case "image4":
			case "image5":
			case "image6":
			
			case "element1":
			case "element2":
			case "element3":
			case "element4":
			case "element5":
			case "element6":
			case "element7":
			case "element8":
			case "element9":
			case "element10":
			 
			case "text": {	
			 	
				if($core_admin_values['widgetobject'][$item][$i]['autop'] == 1){
				echo wpautop(do_shortcode(stripslashes($core_admin_values['widgetobject'][$item][$i]['text'])));
				}else{
				echo do_shortcode(stripslashes($core_admin_values['widgetobject'][$item][$i]['text']));
				}				
	
			} break;
			
			
			case "sec1": { 
		 
			get_template_part('framework/objects/object', 'sec1' ); 			 
			
			} break;
			
			
	 		case "col2s1":
			case "col2s2":
			case "col2s3":
			case "col2s4":
			case "col2s5":
			case "col2s6":
			
	 		case "col3s1":
			case "col3s2":
			case "col3s3":
			case "col3s4":
			case "col3s5":
			case "col3s6":
			
	 		case "col4s1":
			case "col4s2":
			case "col4s3":
			case "col4s4":
			case "col4s5":
			case "col4s6":			
			
			case "new1":
			case "new2":
			case "new3":
			case "new4":
			case "new5":
			case "new6":
			case "new7":
			case "new8":
			case "new9":
			case "search1":
			case "search2":
			
			case "search3": {	
			 	 
				if(isset($core_admin_values['widgetobject'][$item][$i]['autop']) && $core_admin_values['widgetobject'][$item][$i]['autop'] == 1){
				echo wpautop(do_shortcode(stripslashes($core_admin_values['widgetobject'][$item][$i]['text'])));
				}else{
				echo do_shortcode(stripslashes($core_admin_values['widgetobject'][$item][$i]['text']));
				}
				
	
			} break;
			
			
			
			case "shortcode": {	
			 
				echo do_shortcode(stripslashes($core_admin_values['widgetobject']['shortcode'][$i]['text']));
	
			} break;
			
			case "advancedsearch": {
				 
				$STRING .= '<h4>'.$core_admin_values['widgetobject']['advancedsearch'][$i]['title'].'</h4><hr>'.core_search_form(null,'home').'';
				 echo $STRING;
			} break;	
			
			case "basicsearch": {
			
			if($core_admin_values['widgetobject']['basicsearch'][$i]['fullw'] == "underheader"){
			$colspan = "container";
			}else{
			$colspan = "container-fluid";
			}
			
				echo "<section><div class='BasicSearchBox'><div class='".$colspan."'><div class='row'>";
			
				echo do_shortcode(stripslashes($core_admin_values['widgetobject']['basicsearch'][$i]['col1']));
			 
				$STRING .= '<div class="well">    
				<form method="get" action="'.get_home_url().'/" class="clearfix">
				<div class="col-md-5">        
					<input type="text" value="" placeholder="'.$CORE->_e(array('homepage','6','flag_noedit')).'" class="hsk form-control" name="s" />        
				</div>
				<div class="col-md-5">        
					<select name="cat1" class="form-control"><option value="">&nbsp;</option>'.$CORE->CategoryList(array(0,false,0,THEME_TAXONOMY)).'</select> 
				</div>
				<div class="col-md-2">
				<button class="btn btn-primary">'.$CORE->_e(array('button','11')).'</button>     
				</div>
				</form></div>';	
				
			 echo $STRING;
			 
			 echo do_shortcode(stripslashes($core_admin_values['widgetobject']['basicsearch'][$i]['col2']));
			 
			 echo "</div></div></div></section>";
			 
			} break;
			
			case "categoryblock": {
			
				get_template_part('framework/objects/object', 'categories' );
				
			} break;
			
			case "slider1": {
			
				$objID = "slider1";
				 
			
			} break;
	
			default: {
			 
			$STRING .= hook_object(array($item,$i,$fullwidth));
			
			} break;
		
		} // end switch
		
	} 
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// GET THE SLIDER SETTINGS
	function DEFAULT_WIDGETBLOCKS_SETTINGS(){  global $CORE; $core_admin_values = get_option("core_admin_values");  $i=0;
	
	// GET THE DATA
	$bits = explode(",",$core_admin_values['homepage']['widgetblock1']);
	
	// LOOP ALL OF THE ELEMENTS
	foreach($bits as $key=>$bit){ 
	 
		// BREAK UP THE STRING				
		$tt 		= explode("_",$bit);						
		$gg 		= explode("-", $tt[1]);
		$nkey		= $tt[0];
		$nrefid 	= $gg[0];
		
		// MAKE SURE ITS NUMERICAL
		if(!is_numeric($nrefid)){ continue; }
		
		// FIX FOR OLD VERSIONS
		if(strpos($bit,"_") === false){  }else{ $bit = $tt[0]."-"; }
 	 
	 //ADD-ON WRAPPER
	echo '<!-- Modal --><div id="ObjOptions_'.$nrefid.'" class="well" style="display:none;background-color: rgb(236, 255, 243); border: 1px solid #B3E4B5;">
	<div>';
	
	
	
	// TEXT OBJECT SETTINGS	  
	if (strpos($bit, "new1") !== false) { $ITEMKEY = "new1"; 
	
	$defaultcode = '<section><div class="wlt_object_head_1">
  
    <div class="banner">
    <div class="col-md-4 col-sm-4 col-xs-12">
    <a href="#">
    <div class="s-desc">
        <h1>TITLE TEXT</h1>
        <h2>SUB TITLE TEXT</h2>
        <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
        <span>BUTTON</span>
    </div>
    </a>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
    <a href="#">
    <div class="s-desc">
        <h1>TITLE TEXT</h1>
        <h2>SUB TITLE TEXT</h2>
        <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
        <span>BUTTON</span>
    </div>
    </a>
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
    <a href="#">
    <div class="s-desc">
        <h1>TITLE TEXT</h1>
        <h2>SUB TITLE TEXT</h2>
        <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
        <span>BUTTON</span>
    </div>
    </a>
    </div>
    
</div></section>';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	 	 // FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}
	
	
	
	
	// TEXT OBJECT SETTINGS	  
	if (strpos($bit, "new2") !== false) { $ITEMKEY = "new2"; 
	
	$defaultcode = '<section><div class="wlt_object_head_2">
<div class="banner row">

    <div class="col-md-4 col-sm-4 col-xs-12">
    <a href="#">
        <img src="http://placehold.it/370x260" alt="" class="wltatt_id" class="wltatt_id">
        <div class="s-desc"><span>Headline</span><div>
       <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
        </div>
    </a>
    </div>
    
    <div class="col-md-4 col-sm-4 col-xs-12">
    <a href="#">
        <img src="http://placehold.it/370x260" alt="" class="wltatt_id">
        <div class="s-desc"><span>Headline</span><div>
        <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
        </div>
    </a>
    </div>
    
    <div class="col-md-4 col-sm-4 col-xs-12">
    <a href="#">
        <img src="http://placehold.it/370x260" alt="" class="wltatt_id">
        <div class="s-desc"><span>Headline</span><div>         
        <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
        </div>
    </a>
    </div>

</div>
</div></section>';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	 // FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);

	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}	
	
	
	
	// TEXT OBJECT SETTINGS	  
	if (strpos($bit, "new3") !== false) { $ITEMKEY = "new3"; 
	
	$defaultcode = '<section><div class="wlt_object_head_3">
<div class="row">
<ul>

    <li class="col-xs-3">
    <a href="#" class="item-link">
    <img src="http://placehold.it/270x170" alt="" class="wltatt_id" >
    <div class="item-html">
    <h2><span>Headline</span></h2>
    </div>
    </a>
    </li>
    
    <li class="col-xs-3">
    <a href="#" class="item-link">
    <img src="http://placehold.it/270x170" alt="" class="wltatt_id">
    <div class="item-html">
    <h2><span>Headline</span></h2>
    </div>
    </a>
    </li>
    
    <li class="col-xs-3">
    <a href="#" class="item-link">
    <img src="http://placehold.it/270x170" alt="" class="wltatt_id">
    <div class="item-html">
    <h2><span>Headline</span></h2>
    </div>
    </a>
    </li>
    
    <li class="col-xs-3">
    <a href="#" class="item-link">
    <img src="http://placehold.it/270x170" class="item-img" alt="" class="wltatt_id">
    <div class="item-html">
    <h2><span>Headline</span></h2>
    </div>
    </a>
    </li>
 
</ul>
</div></div>
</section>';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	 // FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]' )  ); 
	
	}		
	
	
	
	
	// TEXT OBJECT SETTINGS	  
	if (strpos($bit, "new4") !== false) { $ITEMKEY = "new4"; 
	
	$defaultcode = '<section>
<div class="wlt_object_head_4">
<div class="row">
<ul>

<li class="col-md-4 col-sm-4 col-xs-12">
<div class="b">
    <a href="" class="item-link">
    <img src="http://placehold.it/400x95"  alt="" class="wltatt_id">
    <div class="item-html">
    <h3><span>TITLE TEXT</span> sub title</h3>
    <span class="btn1">more</span>
    </div>
    </a>
</div>
</li>

<li class="col-md-4 col-sm-4 col-xs-12">
<div class="b">
    <a href="" class="item-link">
    <img src="http://placehold.it/400x95"  alt="" class="wltatt_id">
    <div class="item-html">
    <h3><span>TITLE TEXT</span> sub title</h3>
    <span class="btn1">more</span>
    </div>
    </a>
</div>
</li>

<li class="col-md-4 col-sm-4 col-xs-12">
<div class="b">
    <a href="" class="item-link">
    <img src="http://placehold.it/400x95"  alt="" class="wltatt_id">
    <div class="item-html">
    <h3><span>TITLE TEXT</span> sub title</h3>
    <span class="btn1">more</span>
    </div>
    </a>
</div>
</li>
                
</ul>
</div>
</div>
</section>';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	 // FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}		
	
	
	
	
	// TEXT OBJECT SETTINGS	  
	if (strpos($bit, "new5") !== false) { $ITEMKEY = "new5"; 
	
	$defaultcode = '<section><div class="wlt_object_head_5"> 
<div class="row">
<ul>
    <li class="boxli col-md-4 col-sm-4 col-xs-12">
    <div>
    <a href="#" class="boxlink">
        <div class="item-html">
        <i class="glyphicon glyphicon-cloud"></i>
        <h2>Headline Text</h2>
        <h3>Sub Title Text</h3>
        </div>
    </a>
    </div>
    </li>
    <li class="boxli col-md-4 col-sm-4 col-xs-12">
    <div>
    <a href="#" class="boxlink">
        <div class="item-html">
        <i class="fa fa-desktop"></i>
        <h2>Headline Text</h2>
        <h3>Sub Title Text</h3>
        </div>
    </a>
    </div>
    </li>
    <li class="boxli col-md-4 col-sm-4 col-xs-12">
    <div>
    <a href="#" class="boxlink">
        <div class="item-html">
        <i class="glyphicon glyphicon-bullhorn"> </i>
        <h2>Headline Text</h2>
        <h3>Sub Title Text</h3>
        </div>
    </a>
    </div>
    </li>
</ul>
</div>
</div></section>';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	 	 // FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}	

	// TEXT OBJECT SETTINGS	  
	if (strpos($bit, "new6") !== false) { $ITEMKEY = "new6"; 
	
	$defaultcode = '<section><div class="wlt_object_head_6">
<div class="banner">
<div class="row ">


<div class="col-md-4">
    <div class="banner-wrap">
    <span>
    <a href="#"><img src="http://placehold.it/370x210" alt="" class="wltatt_id"></a>
    </span>
    <h5>Headline <br> goes here</h5>
    </div>
</div>

<div class="col-md-4">
    <div class="banner-wrap">
    <span>
    <a href="#"><img src="http://placehold.it/370x210" alt="" class="wltatt_id"></a>
    </span>
    <h5>Headline <br> goes here</h5>
    </div>
</div>

<div class="col-md-4">
    <div class="banner-wrap">
    <span>
    <a href="#"><img src="http://placehold.it/370x210" alt="" class="wltatt_id"></a>
    </span>
    <h5>Headline <br> goes here</h5>
    </div>
</div>


</div> 
</div>
</div></section>';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	 // FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}		
	
	
	
	
	
	
	// FOOTER 1  
	if (strpos($bit, "new7") !== false) { $ITEMKEY = "new7"; 
	
	$defaultcode = '<section>
<div class="wlt_object_footer_1">
<div class="row">
<ul>
    <li class="col-md-4 col-xs-4">
    <a href="#" class="item-link">
    <span>
        <img src="http://placehold.it/370x195" alt="" class="wltatt_id">
    </span>
    <div class="item-html">
    <h3>Headline</h3>
    <h4>Lorem ipsum dolor sit amet</h4>
    <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
    </div>
    </a>
    </li> 
    
    <li class="col-md-4 col-xs-4">
    <a href="#" class="item-link">
    <span>
        <img src="http://placehold.it/370x195" alt="" class="wltatt_id">
    </span>
    <div class="item-html">
    <h3>Headline</h3>
    <h4>Lorem ipsum dolor sit amet</h4>
    <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
    </div>
    </a>
    </li> 
    
    
    <li class="col-md-4 col-xs-4">
    <a href="#" class="item-link">
    <span>
        <img src="http://placehold.it/370x195" alt="">
    </span>
    <div class="item-html">
    <h3>Headline</h3>
    <h4>Lorem ipsum dolor sit amet</h4>
    <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
    </div>
    </a>
    </li>    
                            
</ul>
</div></div>
</section>';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	 // FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}			
	
	
	
	// FOOTER 2  
	if (strpos($bit, "new8") !== false) { $ITEMKEY = "new8"; 
	
	$defaultcode = '<section><div class="wlt_object_head_1">
<div class="content_bottom">
    <div id="banner1" class="banner">
        <div class="col-md-4 col-sm-4 col-xs-12">
        <a href="#">
        <div class="s-desc">
        <h3>Headline</h3>
        <h4>Sub Title Text</h4>
        <p>Lorem ipsum dolor sit amet conse ctetur </p></div>
        </a>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
        <a href="#">
        <div class="s-desc">
        <h5>Call us now toll free:</h5>
        <h3>0123-456-789</h3>
        <p>Lorem ipsum dolor sit amet conse ctetur</p></div>
        </a>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12">
        <a href="#">
        <div class="s-desc">
        <h3>Headline</h3>
        <h5>Sub Title Text</h5>
        <p>Lorem ipsum dolor sit amet conse ctetur</p></div>
        </a>
        </div>
    </div>
</div>
</div></section>';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}

	// FOOTER 3  
	if (strpos($bit, "new9") !== false) { $ITEMKEY = "new9"; 
	
	$defaultcode = '<section><div class="wlt_object_footer_3 clearfix">
<div class="col-xs-4">
<ul>
    <li>
    <i class="glyphicon glyphicon-bullhorn"> </i>
    <div class="type-text">
    <h3>Lorem ipsum dolor sit</h3>
    <p>Lorem ipsum dolor sit amet conse ctetur voluptate velit esse cillum dolor.</p>
    </div>
    </li>
    <li>
    <i class="glyphicon glyphicon-cloud"> </i>
    <div class="type-text">
    <h3>Excepteur sint</h3>
    <p>Lorem ipsum dolor sit amet conse ctetur voluptate velit esse cillum dolor.</p>
    </div>
    </li>
    <li>
    <i class="fa fa-desktop"></i>
    <div class="type-text">
    <h3>Occaecat cupidatat non</h3>
    <p>Lorem ipsum dolor sit amet conse ctetur voluptate velit esse cillum dolor.</p>
    </div>
    </li>
</ul>
</div>

<div class="col-xs-4">
<h3>Custom Block</h3>
<p><strong>Lorem ipsum dolor sit amet conse ctetu</strong></p>
<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatu.</p>
</div>

<div class="col-xs-4">
<h3>Custom Block</h3>
<p><strong>Lorem ipsum dolor sit amet conse ctetu</strong></p>
<p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatu.</p>
</div>
 
</div></section>';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}
	
	

	// SEARCH STYLE 1 
	if (strpos($bit, "search1") !== false) { $ITEMKEY = "search1"; 
	
	$defaultcode = '
        <div class="wlt_object_search_1">        
        <div class="container"><div class="row">        
        	<div class="col-md-4">            
            <div class="panel panel-default">             
            	<div class="panel-body">
                <h3>Website Search</h3>                
				<p>Search our webiste listings below;</p>                
                <div class="row">
                [ADVANCEDSEARCH home=yes]
                </div>                
                </div>                
            </div>            
            </div>            
            <div class="col-md-8"> 
                  <img src="http://placehold.it/750x400" alt="" class="wltatt_id img-responsive">                  
            </div>
        </div></div>        
        </div>';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}
 		
	
	
	// SEARCH STYLE 2
	if (strpos($bit, "search2") !== false) { $ITEMKEY = "search2"; 
	
	$defaultcode = '
        <div class="wlt_object_search_2">        
        <div class="container"><div class="row"> 
		 	<div class="col-md-8"> 
                  <img src="http://placehold.it/750x400" alt="" class="wltatt_id img-responsive">                  
            </div>       
        	<div class="col-md-4">            
            <div class="panel panel-default">             
            	<div class="panel-body">
                <h3>Website Search</h3>                
				<p>Search our webiste listings below;</p>                
                <div class="row">
                [ADVANCEDSEARCH home=yes]
                </div>                
                </div>                
            </div>            
            </div>
        </div></div>        
        </div>';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	 // FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}	
	
	
	
	
	
	// SEARCH STYLE 1 
	if (strpos($bit, "col2s1") !== false) { $ITEMKEY = "col2s1"; 
	
	$defaultcode = '<section>
<div class="wlt_object_cols2_1">
    <div class="container">
        <div class="row">   
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="box"><div class="box_inner">
                <h2>Headline Here</h2>
                <h3>Lorem ipsum dolor sit amet conse ctetur.</h3>
                <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.  </p>
               </div></div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="box"><div class="box_inner">
                <h2>Headline Here</h2>
                <h3>Lorem ipsum dolor sit amet conse ctetur.</h3>
                <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.  </p>
               </div></div>
            </div>
        </div>
    </div>
</div>
</section>';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}
	
	
	// SEARCH STYLE 1 
	if (strpos($bit, "col3s1") !== false) { $ITEMKEY = "col3s1"; 
	
	$defaultcode = '<section>
<div class="wlt_object_cols3_1">
<div class="container">
<div class="row">   
	<div class="col-lg-4 col-md-4 col-sm-4">
    	<div class="box"><div class="box_inner">
        <h2>Headline Here</h2>
        <h3>Lorem ipsum dolor sit amet conse ctetur.</h3>
        <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.  </p>
       </div></div>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4">
    	<div class="box"><div class="box_inner">
        <h2>Headline Here</h2>
        <h3>Lorem ipsum dolor sit amet conse ctetur.</h3>
        <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.  </p>
       </div></div>
    </div>
    
    <div class="col-lg-4 col-md-4 col-sm-4">
    	<div class="box"><div class="box_inner">
        <h2>Headline Here</h2>
        <h3>Lorem ipsum dolor sit amet conse ctetur.</h3>
        <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.  </p>
       </div></div>
    </div>
</div>
</div>
</div>
</section> ';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}
	
	
	
		// SEARCH STYLE 1 
	if (strpos($bit, "col4s1") !== false) { $ITEMKEY = "col4s1"; 
	
	$defaultcode = '<section>
<div class="wlt_object_cols4_1">
<div class="container">
<div class="row">   
	<div class="col-lg-3 col-md-3 col-sm-6">
    	<div class="box"><div class="box_inner">
        <h2>Headline Here</h2>
        <h3>Lorem ipsum dolor sit amet conse ctetur.</h3>
        <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.  </p>
       </div></div>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-6">
    	<div class="box"><div class="box_inner">
        <h2>Headline Here</h2>
        <h3>Lorem ipsum dolor sit amet conse ctetur.</h3>
        <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.  </p>
       </div></div>
    </div>
    
    <div class="col-lg-3 col-md-3 col-sm-6">
    	<div class="box"><div class="box_inner">
        <h2>Headline Here</h2>
        <h3>Lorem ipsum dolor sit amet conse ctetur.</h3>
        <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.  </p>
       </div></div>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-6">
    	<div class="box"><div class="box_inner">
        <h2>Headline Here</h2>
        <h3>Lorem ipsum dolor sit amet conse ctetur.</h3>
        <p>Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna.  </p>
       </div></div>
    </div>
    
</div>
</div>
</div>
</section>';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}
	
	
	
	// SEARCH STYLE2 
	if (strpos($bit, "col2s2") !== false) { $ITEMKEY = "col2s2"; 
	
	$defaultcode = '<section>
<div class="wlt_object_cols2_2">
<div class="container"><div class="row">

<div class="col-md-6 col-sm-6">
	<div class="box">
    <h4><a href=""><i class="pull-left fa fa-star"></i> Headline Here</a></h4>
    <p>Praesent dignissim dui eu urna feugiat lobortis. Morbi varius nibh sit amet adipiscing mollis. Aenean id neque ut augue gravida posuere.</p>
  	</div>
</div>

<div class="col-md-6 col-sm-6">
	<div class="box">
    <h4><a href=""><i class="pull-left fa fa-star"></i> Headline Here</a></h4>
    <p>Praesent dignissim dui eu urna feugiat lobortis. Morbi varius nibh sit amet adipiscing mollis. Aenean id neque ut augue gravida posuere.</p>
  	</div>
</div>


</div></div>
</div>
</section>';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}
	
	
	// SEARCH STYLE2 
	if (strpos($bit, "col3s2") !== false) { $ITEMKEY = "col3s2"; 
	
	$defaultcode = '<section>
<div class="wlt_object_cols3_2">
<div class="container"><div class="row">

<div class="col-md-4 col-sm-4">
	<div class="box">
    <h4><a href=""><i class="pull-left fa fa-star"></i> Headline Here</a></h4>
    <p>Praesent dignissim dui eu urna feugiat lobortis. Morbi varius nibh sit amet adipiscing mollis. Aenean id neque ut augue gravida posuere.</p>
  	</div>
</div>

<div class="col-md-4 col-sm-4">
	<div class="box">
    <h4><a href=""><i class="pull-left fa fa-star"></i> Headline Here</a></h4>
    <p>Praesent dignissim dui eu urna feugiat lobortis. Morbi varius nibh sit amet adipiscing mollis. Aenean id neque ut augue gravida posuere.</p>
  	</div>
</div>

<div class="col-md-4 col-sm-4">
	<div class="box">
    <h4><a href=""><i class="pull-left fa fa-star"></i> Headline Here</a></h4>
    <p>Praesent dignissim dui eu urna feugiat lobortis. Morbi varius nibh sit amet adipiscing mollis. Aenean id neque ut augue gravida posuere.</p>
  	</div>
</div>

</div></div>
</div>
</section>';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}
		
	
	// SEARCH STYLE2 
	if (strpos($bit, "col4s2") !== false) { $ITEMKEY = "col4s2"; 
	
	$defaultcode = '<section>
<div class="wlt_object_cols4_2">
<div class="container"><div class="row">

<div class="col-md-3 col-sm-6">
	<div class="box">
    <h4><a href=""><i class="pull-left fa fa-star"></i> Headline Here</a></h4>
    <p>Praesent dignissim dui eu urna feugiat lobortis. Morbi varius nibh sit amet adipiscing mollis. Aenean id neque ut augue gravida posuere.</p>
  	</div>
</div>

<div class="col-md-3 col-sm-6">
	<div class="box">
    <h4><a href=""><i class="pull-left fa fa-star"></i> Headline Here</a></h4>
    <p>Praesent dignissim dui eu urna feugiat lobortis. Morbi varius nibh sit amet adipiscing mollis. Aenean id neque ut augue gravida posuere.</p>
  	</div>
</div>

<div class="col-md-3 col-sm-6">
	<div class="box">
    <h4><a href=""><i class="pull-left fa fa-star"></i> Headline Here</a></h4>
    <p>Praesent dignissim dui eu urna feugiat lobortis. Morbi varius nibh sit amet adipiscing mollis. Aenean id neque ut augue gravida posuere.</p>
  	</div>
</div>

<div class="col-md-3 col-sm-6">
	<div class="box">
    <h4><a href=""><i class="pull-left fa fa-star"></i> Headline Here</a></h4>
    <p>Praesent dignissim dui eu urna feugiat lobortis. Morbi varius nibh sit amet adipiscing mollis. Aenean id neque ut augue gravida posuere.</p>
  	</div>
</div>

</div></div>
</div>
</section>';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	// TEXT OBJECT SETTINGS	  
	if (strpos($bit, "newgooglemap") !== false) { $ITEMKEY = "newgooglemap"; $defaultcode = "";	
	
  ?>
  
  
  	<p><label><b>Display Category Bar</b></label>
			  <select name="admin_values[widgetobject][<?php echo $ITEMKEY; ?>][<?php echo $nrefid; ?>][showbar]" class="chzn-select" id="default_1showbar_<?php echo $ITEMKEY; ?>">
			  <option value="1" <?php selected( $core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['showbar'], "1" ); ?>>Yes</option>
			<option value="2" <?php selected( $core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['showbar'], "2" ); ?>>No</option>  
			  			
			</select>
	</p>
    
    <p> Google map default location settings are found in the admin under the General setup -> submission settings tab. </p>
    
  <?php 
	
	}		
	  
	
	// TEXT OBJECT SETTINGS	  
	if (strpos($bit, "text") !== false) { $ITEMKEY = "text"; $defaultcode = "";	
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	// FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	 
	// LOAD UP EDITOR 
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	?>
    <p><label><b>Include Autoparagraph</b></label>
			  <select name="admin_values[widgetobject][<?php echo $ITEMKEY; ?>][<?php echo $nrefid; ?>][autop]" class="chzn-select" id="default_autop_<?php echo $ITEMKEY; ?>">
			  <option value="1" <?php selected( $core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['autop'], "1" ); ?>>Yes</option>
			<option value="2" <?php selected( $core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['autop'], "2" ); ?>>No</option>  
			  			
			</select>
	</p>
    <?php
	
	}	
	
 
	
 
	
	// TEXT OBJECT SETTINGS	  
	if (strpos($bit, "element10") !== false) { $ITEMKEY = "element10"; 
	
	$defaultcode = '<div class="wlt_'.$ITEMKEY.'"> <hr /><h2>Headline</h2> <img src="//placehold.it/150x100/EEEEEE" class="img-responsive pull-right"> <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sed diam eget risus varius blandit sit amet non magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Cras mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Aenean lacinia bibendum nulla sed consectetur.</p> <button class="btn btn-default">More</button> <hr /></div>';
	
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	 else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}
 		
		
	// TEXT OBJECT SETTINGS	  
	if (strpos($bit, "element8") !== false) { $ITEMKEY = "element8"; 
	
	$defaultcode = '<div class="wlt_'.$ITEMKEY.'"> <div class="col-md-7">
          <h1>Bootstrap Sidebar
            <p class="lead">With Affix and Scrollspy</p>
          </h1>
        </div>
        <div class="col-md-5">
            <div class="well well-lg"> 
              <div class="row">
                <div class="col-sm-6">
        	      	<img src="//placehold.it/180x100" class="img-responsive">
                </div>
                <div class="col-sm-6">
	              	Some text here
                </div>
              </div>
            </div>
        </div></div>';
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	// FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}	
	
	// TEXT OBJECT SETTINGS	  
	if (strpos($bit, "element7") !== false) { $ITEMKEY = "element7"; 
	
	$defaultcode = '<div class="wlt_'.$ITEMKEY.'"> <div class="col-md-8">
          <h1>Heading</h1>
		  <hr />
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">View details</a></p>
       </div>
      
	 <div class="col-sm-4">
          <ul class="list-group">
            <li class="list-group-item">Cras justo odio</li>
            <li class="list-group-item">Dapibus ac facilisis in</li>
            <li class="list-group-item">Morbi leo risus</li>
            <li class="list-group-item">Porta ac consectetur ac</li>
            <li class="list-group-item">Vestibulum at eros</li>
          </ul>
       </div> </div> ';
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	// FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}
	
	// TEXT OBJECT SETTINGS	  
	if (strpos($bit, "element6") !== false) { $ITEMKEY = "element6"; 
	
	$defaultcode = ' <div class="wlt_'.$ITEMKEY.'">
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">View details</a></p>
        </div>
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">View details</a></p>
       </div>
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn btn-default" href="#" role="button">View details</a></p>
     
      </div></div>';
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	// FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}
	

	// TEXT OBJECT SETTINGS	  
	if (strpos($bit, "element5") !== false) { $ITEMKEY = "element5"; 
	
	$defaultcode = '<div class="wlt_'.$ITEMKEY.'"> <div class="page-header">
        <h1>Example Headline</h1>
      </div><div class="well">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas sed diam eget risus varius blandit sit amet non magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Cras mattis consectetur purus sit amet fermentum. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Aenean lacinia bibendum nulla sed consectetur.</p>
      </div></div>';
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	// FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  );  
	
	}
	
 	
	
	// TEXT OBJECT SETTINGS	  
	if (strpos($bit, "element3") !== false) { $ITEMKEY = "element3"; 
	
	$defaultcode = '<div class="wlt_'.$ITEMKEY.'"> <div class="jumbotron">
        <h1>Hello, world!</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pharetra varius quam sit amet vulputate. Quisque mauris augue, molestie tincidunt condimentum vitae, gravida a libero.</p>
        <p><a href="#" class="btn btn-primary btn-lg" role="button">Learn more</a></p>
      </div></div>';
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	// FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text' , array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}
	
	
	
	// TEXT OBJECT SETTINGS	  
 
	if (strpos($bit, "image1-") !== false) { $ITEMKEY = "image1"; 
	
	$defaultcode = '<div class="row">
	<div class="col-md-8">
	<img src="http://placehold.it/800x395" class="img-responsive">
	</div>
	<div class="col-md-4">
	<img src="http://placehold.it/370x120" class="img-responsive wltatt_id">
	<img src="http://placehold.it/370x120" class="img-responsive wltatt_id paddingtop10">
	<img src="http://placehold.it/370x120" class="img-responsive wltatt_id paddingtop10">
	</div>
	</div>';
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	// FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}
	
	
	if (strpos($bit, "image2-") !== false) { $ITEMKEY = "image2"; 
	
	$defaultcode = '<div class="row">
	<div class="col-md-8">
	<img src="http://placehold.it/800x395" class="img-responsive">
	</div>
	<div class="col-md-4">
	<img src="http://placehold.it/370x185" class="img-responsive wltatt_id">
	<img src="http://placehold.it/370x185" class="img-responsive wltatt_id paddingtop10">

	</div>
	</div>';
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	// FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}	
	
	
	
	if (strpos($bit, "image3-") !== false) { $ITEMKEY = "image3"; 
	
	$defaultcode = '<div class="row">
	<div class="col-md-3">
		[D_CATEGORIES title="Categories" show_count="0"]
	</div>
	<div class="col-md-9">
		<img src="http://placehold.it/900x400" class="img-responsive wltatt_id">

	</div>
	</div>';
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	// FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}	
	
	
	if (strpos($bit, "image4-") !== false) { $ITEMKEY = "image4"; 
	
	$defaultcode = '<img src="http://placehold.it/1170x450" class="img-responsive wltatt_id">';
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	// FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}		
	
	
		
	// TEXT OBJECT SETTINGS	  
 
	if (strpos($bit, "element1-") !== false) { $ITEMKEY = "element1"; 
	
	$defaultcode = ' <div class="wlt_'.$ITEMKEY.'"> 
    <div class="col-md-4 text-center">
      <img class="img-circle" src="http://placehold.it/140x140">
      <h2>Mobile-first</h2>
      <p>Tablets, phones, laptops. The new 3 promises to be mobile friendly from the start.</p>
      <p><a class="btn btn-default" href="#">View details</a></p>
    </div>
    <div class="col-md-4 text-center">
      <img class="img-circle" src="http://placehold.it/140x140">
      <h2>One Fluid Grid</h2>
      <p>There is now just one percentage-based grid for Bootstrap 3. Customize for fixed widths.</p>
      <p><a class="btn btn-default" href="#">View details</a></p>
    </div>
    <div class="col-md-4 text-center">
      <img class="img-circle" src="http://placehold.it/140x140">
      <h2>LESS is More</h2>
      <p>Improved support for mixins make the new Bootstrap 3 easier to customize.</p>
      <p><a class="btn btn-default" href="#">View details</a></p>
    </div><div class="clearfix"></div></div>';
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	// FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}		
	
	
	// TEXT OBJECT SETTINGS	  
	if (strpos($bit, "element2") !== false) { $ITEMKEY = "element2"; 
	
	$defaultcode = '<div class="wlt_'.$ITEMKEY.'"> <hr /><div class="featurette">
    <img class="featurette-image img-circle pull-right" src="http://placehold.it/512">
    <h2 class="featurette-heading">Responsive Design. <span class="text-muted">Itll blow your mind.</span></h2>
    <p class="lead">In simple terms, a responsive web design figures out what resolution of device its being served on. Flexible grids then size correctly to fit the screen.</p>
  </div><div class="clearfix"></div></div>';
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['text']); } 
	 
	// FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_text', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][text]')  ); 
	
	}
	  
	  
	if (strpos($bit, "blog-") !== false) { $ITEMKEY = "blog"; 
	 
	?> 
	 
	<label><b>Block Box Title</b></label>
	<input type="text"  name="admin_values[widgetobject][blog][<?php echo $nrefid; ?>][title]" class="row-fluid" value="<?php echo  $core_admin_values['widgetobject']['blog'][$nrefid]['title']; ?>">
	
	 <label><b>Display Amount (numerical)</b></label>
	<input type="text"  name="admin_values[widgetobject][blog][<?php echo $nrefid; ?>][amount]" class="row-fluid short" style="width:80px;" value="<?php echo  $core_admin_values['widgetobject']['blog'][$nrefid]['amount']; ?>">
	
	 
	<?php
	
	} 
	
	
	
	if (strpos($bit, "slider6-") !== false) {  $ITEMKEY = "slider6"; global $wpdb;  ?>
	
     <p><b>Custom Query (<a href="http://codex.wordpress.org/Function_Reference/query_posts" target="_blank">example info</a>)</b></p>
        <select onChange="jQuery('#slider6s').val(this.value);">
        <option value="">--- sample query strings ---</option>
        <option value="meta_key=featured&amp;meta_value=yes&post_type=<?php echo THEME_TAXONOMY; ?>_type&amp;posts_per_page=10">Only Featured Listings</option>
        <option value="meta_key=frontpage&amp;meta_value=yes&post_type=<?php echo THEME_TAXONOMY; ?>_type&amp;posts_per_page=10">Only Frontpage Enhanced Listings</option>
        <option value="orderby=IDorder=desc&post_type=<?php echo THEME_TAXONOMY; ?>_type&amp;posts_per_page=10">Latest Listings</option>
        <option value="orderby=rand&post_type=<?php echo THEME_TAXONOMY; ?>_type&amp;posts_per_page=10">Random Listings</option>
        <option value="meta_key=hits&amp;orderby=meta_value_num&amp;order=desc&amp;post_type=<?php echo THEME_TAXONOMY; ?>_type&amp;posts_per_page=10">Popular Listings</option>
        </select>
	<input class="widefat" type="text" id="slider6s" name="admin_values[widgetobject][slider6][<?php echo $nrefid; ?>][query]" value="<?php echo  $core_admin_values['widgetobject']['slider6'][$nrefid]['query']; ?>" /> <br /> 	
     

	<?php }
    
    
	if (strpos($bit, "slider5-") !== false) {  $ITEMKEY = "slider5"; global $wpdb;  ?>

	<p><b>Note</b> You need to create sliders first before they will be visible below. <a href="admin.php?page=revslider">Click here</a> to setup new sliders. </p>
    
    <div class="well">
	<label><b>Which slider should i display?</b></label>
	<select name="admin_values[widgetobject][slider5][<?php echo $nrefid; ?>][id]" class="chzn-select" id="default_slider5_type_<?php echo $nrefid; ?>">
  				 
    <?php
	
	$results = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."revslider_sliders", OBJECT);
	foreach ($results as $result){	
	?> 
    <option value="<?php echo $result->alias; ?>" <?php selected( $core_admin_values['widgetobject']['slider5'][$nrefid]['id'], $result->alias ); ?>><?php echo $result->title; ?></option>
    <?php } ?>            
                 		
	</select>
    
    </div>
    
    

	<?php }
	
	if (strpos($bit, "slider4-") !== false) {  $ITEMKEY = "slider4"; $current_data = get_option("wlt_slider4_".$nrefid); ?>

<a href="javascript:void(0);" onClick="jQuery('#wlt_slider_list_<?php echo $nrefid; ?>_fields').clone().appendTo('#wlt_slider_list_<?php echo $nrefid; ?>');" class="button">Add New Slide</a>	

<hr />


<div  class="postbox meta-box-sortables" style="border:0px;">
<ul id="wlt_slider_list_<?php echo $nrefid; ?>" class="ui-sortable">
<?php if(is_array($current_data)){ $i=0; foreach($current_data['name'] as $data){ if($current_data['name'][$i] !=""){ ?>

<li class="postbox closed" id="ss<?php echo $nrefid.$i; ?>" style="border-left: 4px solid #D03AB2;padding:5px;padding-bottom:0px;">


<a href="javascript:void(0);" onclick="jQuery('#ss<?php echo $nrefid.$i; ?> .inside').hide();jQuery('#<?php echo $nrefid.$i; ?>_hide').hide();jQuery('#<?php echo $nrefid.$i; ?>_show').show();" id="<?php echo $nrefid.$i; ?>_hide" style="background:red;color:#fff;padding:3px;float:right;display:none;">hide box</a>

<a href="javascript:void(0);" onclick="jQuery('#ss<?php echo $nrefid.$i; ?> .inside').show();jQuery('#<?php echo $nrefid.$i; ?>_hide').show();jQuery('#<?php echo $nrefid.$i; ?>_show').hide();" id="<?php echo $nrefid.$i; ?>_show" style="background:#666;color:#fff;padding:3px;float:right;">open</a>
   
    <h3 class="hndle"><?php echo $current_data['name'][$i]; ?></h3>
   
    <div class="inside"> 
     
        <input type="hidden" name="adminArray[<?php echo "wlt_slider4_".$nrefid; ?>][name][]" id="<?php echo $nrefid.$i; ?>_title" value="<?php echo $current_data['name'][$i]; ?>"  style="width:100%; font-size:11px;"  />  
        
        
        <div class="form-row control-group row-fluid">
				<label class="control-label span3">Slide Image</label>
				<div class="controls span7">
				<div class="input-append row-fluid">
					  <input type="text"  name="adminArray[<?php echo "wlt_slider4_".$nrefid; ?>][image][]" id="upload_slideritem<?php echo $i; ?>" class="row-fluid" 
					  value="<?php echo $current_data['image'][$i]; ?>">
					  <span class="add-on" id="aupload_slideritem<?php echo $i; ?>"><i class="gicon-search"></i></span>
					  </div>
				</div>
		</div> 
                 		
		<script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery('#aupload_slideritem<?php echo $i; ?>').click(function() { 
                 
                 ChangeImgBlock('upload_slideritem<?php echo $i; ?>');
                 formfield = jQuery('#upload_slideritem<?php echo $i; ?>').attr('name');
                 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
				 jQuery("div").remove('#TB_overlay');
                 return false;
                });
            });	
        </script>   
        
        <p>Video Link  (YouTube & Vimeo links only)</p>
        <div class="row-fluid" data-color="<?php echo $current_data['link'][$i] ?>">               
            <input name="adminArray[<?php echo "wlt_slider4_".$nrefid; ?>][link][]" type="text" value="<?php echo $current_data['link'][$i]; ?>" class="row-fluid">
        </div>
          
        <p>Video Description <small>(HTML Allowed)</small></p>
        <textarea name="adminArray[<?php echo "wlt_slider4_".$nrefid; ?>][html][]" style="width:100%;height:100px;"><?php echo stripslashes($current_data['html'][$i]); ?></textarea>  
    	 
        <a href="javascript:void(0);" onClick="jQuery('#<?php echo $nrefid.$i; ?>_title').val('');jQuery('#ss<?php echo $nrefid.$i; ?>').hide();" style="background:#D03AB2;color:#fff;padding:3px;float:right">Remove Field</a>
    
       
        <div class="clear"></div>
    
    </div>    
    
    </li>
<?php }  $i++; } } ?>
</ul>
</div>

<div style="display:none"><div id="wlt_slider_list_<?php echo $nrefid; ?>_fields">
    <li class="postbox"><div title="Click to toggle" class="handlediv"></div>
    <h3 style="padding:8px">New Slide</h3>
    <div class="inside">  
         
        <p>Slide Title <small>(used to help you remember it)</small></p>
        <input type="text" name="adminArray[<?php echo "wlt_slider4_".$nrefid; ?>][name][]" value=""  style="width:100%; font-size:11px;"  />  
        <input type="hidden" name="adminArray[<?php echo "wlt_slider4_".$nrefid; ?>][html][]" value="<h5>Video Title Text</h5><span>Your custom video description here.</span>"  style="width:100%; font-size:11px;"  />  
        
    </div>
    </li>    
</div></div>

<script type="application/javascript">
jQuery( document ).ready(function() {
	 jQuery( "#wlt_slider_list_<?php echo $nrefid; ?>" ).sortable();	
});
</script>
	
	<?php } 	
	
	
	
 
	
	if (strpos($bit, "slider3-") !== false) {  $ITEMKEY = "slider3"; $current_data = get_option("wlt_slider3_".$nrefid); ?>

<a href="javascript:void(0);" onClick="jQuery('#wlt_slider_list_<?php echo $nrefid; ?>_fields').clone().appendTo('#wlt_slider_list_<?php echo $nrefid.$i; ?>');" class="button">Add New Slide</a>	

<hr />


<div  class="postbox meta-box-sortables ui-sortable" style="border:0px;">
<ul id="wlt_slider_list_<?php echo $nrefid.$i; ?>">
<?php if(is_array($current_data)){ $i=0; foreach($current_data['name'] as $data){ if($current_data['name'][$i] !=""){ ?>

<li class="postbox closed" id="ss<?php echo $nrefid.$i; ?>" style="border-left: 4px solid #D03AB2;padding:5px;padding-bottom:0px;">


<a href="javascript:void(0);" onclick="jQuery('#ss<?php echo $nrefid.$i; ?> .inside').hide();jQuery('#<?php echo $nrefid.$i; ?>_hide').hide();jQuery('#<?php echo $nrefid.$i; ?>_show').show();" id="<?php echo $nrefid.$i; ?>_hide" style="background:red;color:#fff;padding:3px;float:right;display:none;">hide box</a>

<a href="javascript:void(0);" onclick="jQuery('#ss<?php echo $nrefid.$i; ?> .inside').show();jQuery('#<?php echo $nrefid.$i; ?>_hide').show();jQuery('#<?php echo $nrefid.$i; ?>_show').hide();" id="<?php echo $nrefid.$i; ?>_show" style="background:#666;color:#fff;padding:3px;float:right;">open</a>
   
    <h3 class="hndle"><?php echo $current_data['name'][$i]; ?></h3>
   
    <div class="inside"> 
     
        <input type="hidden" name="adminArray[<?php echo "wlt_slider3_".$nrefid; ?>][name][]" id="<?php echo $nrefid.$i; ?>_title" value="<?php echo $current_data['name'][$i]; ?>"  style="width:100%; font-size:11px;"  />  
        
        
        <div class="form-row control-group row-fluid">
				<label class="control-label span3">Slide Image</label>
				<div class="controls span7">
				<div class="input-append row-fluid">
					  <input type="text"  name="adminArray[<?php echo "wlt_slider3_".$nrefid; ?>][image][]" id="upload_slideritem<?php echo $i; ?>" class="row-fluid" 
					  value="<?php echo $current_data['image'][$i]; ?>">
					  <span class="add-on" id="aupload_slideritem<?php echo $i; ?>"><i class="gicon-search"></i></span>
					  </div>
				</div>
		</div> 
                 		
		<script type="text/javascript">
            jQuery(document).ready(function () {
                jQuery('#aupload_slideritem<?php echo $i; ?>').click(function() { 
                 
                 ChangeImgBlock('upload_slideritem<?php echo $i; ?>');
                 formfield = jQuery('#upload_slideritem<?php echo $i; ?>').attr('name');
                 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
				 jQuery("div").remove('#TB_overlay');
                 return false;
                });
            });	
        </script>   
        
        <p>Background Color</p>
        <div class="input-append color row-fluid" data-color="<?php echo $current_data['bgcolor'][$i] ?>" data-color-format="hex" id="colorpicker_<?php echo $nrefid.$i; ?>">               
            <input name="adminArray[<?php echo "wlt_slider3_".$nrefid; ?>][bgcolor][]" type="text" value="<?php echo $current_data['bgcolor'][$i]; ?>" class="row-fluid">    
         <span class="add-on"><i style="background-color:<?php echo $current_data['bgcolor'][$i]; ?>;"></i></span>    </div>    
          <script type="text/javascript">
                jQuery(document).ready(function () { jQuery('#colorpicker_<?php echo $nrefid.$i; ?>').colorpicker();  });	
            </script> 
        
          
        <p>Slider Content <small>(HTML Allowed)</small></p>
        <textarea name="adminArray[<?php echo "wlt_slider3_".$nrefid; ?>][html][]" style="width:100%;height:100px;"><?php echo stripslashes($current_data['html'][$i]); ?></textarea>  
    	 
        <a href="javascript:void(0);" onClick="jQuery('#<?php echo $nrefid.$i; ?>_title').val('');jQuery('#<?php echo $nrefid.$i; ?>').hide();" style="background:#D03AB2;color:#fff;padding:3px;float:right">Remove Field</a>
    
       
        <div class="clear"></div>
    
    </div>    
    
    </li>
<?php }  $i++; } } ?>
</ul>
</div>

<div style="display:none"><div id="wlt_slider_list_<?php echo $nrefid; ?>_fields">
    <li class="postbox"><div title="Click to toggle" class="handlediv"></div>
    <h3 style="padding:8px">New Slide</h3>
    <div class="inside">  
         
        <p>Slide Title <small>(used to help you remember it)</small></p>
        <input type="text" name="adminArray[<?php echo "wlt_slider3_".$nrefid; ?>][name][]" value=""  style="width:100%; font-size:11px;"  />  
        
    </div>
    </li>    
</div></div>

<script type="application/javascript">
jQuery(function() {
	 jQuery( "#wlt_slider_list_<?php echo $nrefid.$i; ?>" ).sortable({});	
});
</script>
	
	<?php } 	
	
	
	
	
	
 if (strpos($bit, "slider999-") !== false) {  $ITEMKEY = "slider3"; $current_data = get_option("wlt_slider3_".$nrefid); ?>

<a href="javascript:void(0);" onClick="jQuery('#wlt_shop_attribute_fields').clone().appendTo('#wlt_shop_attributelist');" class="button">Add New Attribute</a>	

<hr />


<div  class="postbox meta-box-sortables ui-sortable" style="border:0px;">
<ul id="wlt_slider_list_<?php echo $nrefid.$i; ?>">
<?php if(is_array($current_data)){ $i=0; foreach($current_data['name'] as $data){ if($current_data['name'][$i] !=""){ ?>

<li class="postbox closed" id="ss<?php echo $nrefid.$i; ?>" style="border-left: 4px solid #D03AB2;padding:5px;padding-bottom:0px;">


<a href="javascript:void(0);" onclick="jQuery('#ss<?php echo $nrefid.$i; ?> .inside').hide();jQuery('#<?php echo $nrefid.$i; ?>_hide').hide();jQuery('#<?php echo $nrefid.$i; ?>_show').show();" id="<?php echo $nrefid.$i; ?>_hide" style="background:red;color:#fff;padding:3px;float:right;display:none;">hide box</a>

<a href="javascript:void(0);" onclick="jQuery('#ss<?php echo $nrefid.$i; ?> .inside').show();jQuery('#<?php echo $nrefid.$i; ?>_hide').show();jQuery('#<?php echo $nrefid.$i; ?>_show').hide();" id="<?php echo $nrefid.$i; ?>_show" style="background:#666;color:#fff;padding:3px;float:right;">open</a>
   
    <h3 class="hndle"><?php echo $current_data['name'][$i]; ?></h3>
   
    <div class="inside"> 
          
        <p><b>Display Text</b> <small>(e.g size)</small></p>
        <input type="text" name="adminArray[<?php echo "wlt_slider3_".$nrefid; ?>][name][]" id="<?php echo $nrefid.$i; ?>_title" value="<?php echo $current_data['name'][$i]; ?>"  style="width:100%; font-size:11px;"  />  
        
        <p><b>Selection Values</b> (1 per line) <b>Special Formatting:</b> Name [value] - example: Extra Large[x-large]</p>
        <textarea name="adminArray[<?php echo "wlt_slider3_".$nrefid; ?>][value][]" style="width:100%;height:100px;"><?php echo trim($current_data['value'][$i]); ?></textarea>  
    	 
        <a href="javascript:void(0);" onClick="jQuery('#<?php echo $nrefid.$i; ?>_title').val('');jQuery('#<?php echo $nrefid.$i; ?>').hide();" style="background:#D03AB2;color:#fff;padding:3px;float:right">Remove Field</a>
    
       
        <div class="clear"></div>
    
    </div>    
    
    </li>
<?php }  $i++; } } ?>
</ul>
</div>

<div style="display:none"><div id="wlt_shop_attribute_fields">
    <li class="postbox"><div title="Click to toggle" class="handlediv"></div>
    <h3 style="padding:8px">New Slide</h3>
    <div class="inside">       
        <p>Display Text <small>(e.g size)</small></p>
        <input type="text" name="adminArray[<?php echo "wlt_slider3_".$nrefid; ?>][name][]" value=""  style="width:100%; font-size:11px;"  />  
        <p>Selection Values (1 per line)</p>
        <textarea name="adminArray[<?php echo "wlt_slider3_".$nrefid; ?>][value][]" style="width:100%;height:100px;"></textarea>  
       
       
    </div>
    </li>    
</div></div>

<script type="application/javascript">
jQuery(function() {
	 jQuery( "#wlt_slider_list_<?php echo $nrefid.$i; ?>" ).sortable({});	
});
</script>
	
	<?php } 
	 
 	
	if (strpos($bit, "slider2-") !== false) {  $ITEMKEY = "slider2";  ?>
 
 <div class="row-fluid">
 <div class="span7">
 <p>Side Images</p>
          <?php $i=1; while($i < 5){ 
		  
		  $content = $core_admin_values['slider2']['slider_item_'.$i];
		  
		  if($i == 1 && $content == ""){ $content = "http://placehold.it/780x400"; }
		  ?>
         
        <div class="form-row control-group row-fluid">
                <label class="control-label span3">Slide <?php echo $i; ?></label>
                <div class="controls span7">
                <div class="input-append row-fluid">
                  <input type="text"  name="admin_values[slider2][slider_item_<?php echo $i; ?>]" id="upload_slider2item<?php echo $i; ?>" class="row-fluid" 
                  value="<?php echo $content; ?>">
                  <span class="add-on" id="aupload_slider2item<?php echo $i; ?>"><i class="gicon-search"></i></span>
                  </div>
                </div>
            </div>  
            
            
         <div class="form-row control-group row-fluid">
                <label class="control-label span3">Link <?php echo $i; ?></label>
                <div class="controls span7">
                <div class="input-append row-fluid">
                  <input type="text"  name="admin_values[slider2][slider_link_<?php echo $i; ?>]" class="row-fluid" 
                  value="<?php echo $core_admin_values['slider2']['slider_link_'.$i]; ?>">
                
                  </div>
                </div>
            </div>  
            
			<script type="text/javascript">
                jQuery(document).ready(function () {
                    jQuery('#aupload_slider2item<?php echo $i; ?>').click(function() { 
                     
                     ChangeImgBlock('upload_slider2item<?php echo $i; ?>');
                     formfield = jQuery('#upload_slider2item<?php echo $i; ?>').attr('name');
                     tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
					 jQuery("div").remove('#TB_overlay');
                     return false;
                    });
                });	
            </script>   
         
         <?php $i++; } ?>       
 </div>
 
     
        <?php if(!defined('SLIDER2-NOSIDE')){ ?>
        <div class="span5" style="background:#ddd; padding:10px;" >
        
        <p>Slide Text</p>
            
            <input type="text" name="admin_values[slider2][b1]" placeholder="text here" class="span12" style="text-align:center;" value="<?php if(isset($core_admin_values['slider2'])){ echo stripslashes($core_admin_values['slider2']['b1']); } ?>" />
            <input type="text" name="admin_values[slider2][b2]" placeholder="text here" class="span12" style="text-align:center;" value="<?php if(isset($core_admin_values['slider2'])){ echo stripslashes($core_admin_values['slider2']['b2']); } ?>" />
            <input type="text" name="admin_values[slider2][b3]" placeholder="text here" class="span12" style="text-align:center;" value="<?php if(isset($core_admin_values['slider2'])){ echo stripslashes($core_admin_values['slider2']['b3']); } ?>" />
            <input type="text" name="admin_values[slider2][l1]" placeholder="Link Here" class="span12" style="text-align:center;" value="<?php if(isset($core_admin_values['slider2'])){ echo stripslashes($core_admin_values['slider2']['l1']); } ?>" />
            
             <input type="text" name="admin_values[slider2][img1]" placeholder="Image Path Here (http://..)" class="span12" style="text-align:center;" value="<?php if(isset($core_admin_values['slider2'])){ echo $core_admin_values['slider2']['img1']; } ?>" />
           
           
            <div class="input-append color row-fluid" data-color="<?php if(isset($core_admin_values['slider2'])){ echo $core_admin_values['slider2']['c1']; } ?>" data-color-format="hex" id="colorpicker_1">               
            <input name="admin_values[slider2][c1]" type="text" id="up_1" value="<?php if(isset($core_admin_values['slider2'])){ echo $core_admin_values['slider2']['c1']; } ?>" class="row-fluid">    
            <span class="add-on"><i style="background-color:<?php if(isset($core_admin_values['slider2'])){ echo $core_admin_values['slider2']['c1']; } ?>;"></i></span>    </div>    
            <script type="text/javascript">
                jQuery(document).ready(function () { jQuery('#colorpicker_1').colorpicker();  });	
            </script> 
    
            <hr />
            
            <input type="text" name="admin_values[slider2][b4]" placeholder="text here" class="span12" style="text-align:center;" value="<?php if(isset($core_admin_values['slider2'])){ echo stripslashes($core_admin_values['slider2']['b4']); } ?>"/>
            <input type="text" name="admin_values[slider2][b5]" placeholder="text here" class="span12" style="text-align:center;" value="<?php if(isset($core_admin_values['slider2'])){ echo stripslashes($core_admin_values['slider2']['b5']); } ?>"/>
            <input type="text" name="admin_values[slider2][b6]" placeholder="text here" class="span12" style="text-align:center;" value="<?php if(isset($core_admin_values['slider2'])){ echo stripslashes($core_admin_values['slider2']['b6']); } ?>"/>
             <input type="text" name="admin_values[slider2][l2]" placeholder="Link Here" class="span12" style="text-align:center;" value="<?php if(isset($core_admin_values['slider2'])){ echo stripslashes($core_admin_values['slider2']['l2']); } ?>" />
             
             <input type="text" name="admin_values[slider2][img2]" placeholder="Image Path Here (http://..)" class="span12" style="text-align:center;" value="<?php if(isset($core_admin_values['slider2'])){ echo $core_admin_values['slider2']['img2']; } ?>" />
           
               <div class="input-append color row-fluid" data-color="<?php if(isset($core_admin_values['slider2'])){ echo $core_admin_values['slider2']['c2']; } ?>" data-color-format="hex" id="colorpicker_2">               
    <input name="admin_values[slider2][c2]" type="text" id="up_2" value="<?php if(isset($core_admin_values['slider2'])){ echo $core_admin_values['slider2']['c2']; } ?>" class="row-fluid">    
    <span class="add-on"><i style="background-color:<?php if(isset($core_admin_values['slider2'])){ echo $core_admin_values['slider2']['c2']; } ?>;"></i></span>    </div>    
    <script type="text/javascript">
        jQuery(document).ready(function () { jQuery('#colorpicker_2').colorpicker();  });	
    </script> 
           
           
            <hr />
            
            <input type="text" name="admin_values[slider2][b7]" placeholder="text here" class="span12" style="text-align:center;" value="<?php if(isset($core_admin_values['slider2'])){ echo stripslashes($core_admin_values['slider2']['b7']); } ?>"/>
            <input type="text" name="admin_values[slider2][b8]" placeholder="text here" class="span12" style="text-align:center;" value="<?php if(isset($core_admin_values['slider2'])){ echo stripslashes($core_admin_values['slider2']['b8']); } ?>"/>
            <input type="text" name="admin_values[slider2][b9]" placeholder="text here" class="span12" style="text-align:center;" value="<?php if(isset($core_admin_values['slider2'])){ echo stripslashes($core_admin_values['slider2']['b9']); } ?>"/>      
             <input type="text" name="admin_values[slider2][l3]" placeholder="Link Here" class="span12" style="text-align:center;" value="<?php if(isset($core_admin_values['slider2'])){ echo stripslashes($core_admin_values['slider2']['l3']); } ?>" />
             
             <input type="text" name="admin_values[slider2][img3]" placeholder="Image Path Here (http://..)" class="span12" style="text-align:center;" value="<?php if(isset($core_admin_values['slider2'])){ echo $core_admin_values['slider2']['img3']; } ?>" />
           
           
               <div class="input-append color row-fluid" data-color="<?php if(isset($core_admin_values['slider2'])){ echo $core_admin_values['slider2']['c3']; } ?>" data-color-format="hex" id="colorpicker_3">               
    <input name="admin_values[slider2][c3]" type="text" id="up_3" value="<?php if(isset($core_admin_values['slider2'])){ echo $core_admin_values['slider2']['c3']; } ?>" class="row-fluid">    
    <span class="add-on"><i style="background-color:<?php if(isset($core_admin_values['slider2'])){ echo $core_admin_values['slider2']['c3']; } ?>;"></i></span>    </div>    
    <script type="text/javascript">
        jQuery(document).ready(function () { jQuery('#colorpicker_3').colorpicker();  });	
    </script> 
           
            </div>
        <?php } ?>
        
         </div>
 
 
    
    <?php }
	
	if (strpos($bit, "slider1-") !== false) {  $ITEMKEY = "slider1";
	
	get_template_part('framework/objects/object', 'slider1-admin' ); 
	
	}
	
	
	if (strpos($bit, "navs-") !== false) {  $ITEMKEY = "navs"; 
	
	?>
	<p><label><b>Display Type</b></label>
			  <select name="admin_values[widgetobject][navs][<?php echo $nrefid; ?>][type]" class="chzn-select" id="default_navs_type_<?php echo $nrefid; ?>">
			  <option value="1" <?php selected( $core_admin_values['widgetobject']['navs'][$nrefid]['type'], "1" ); ?>>Listing Categories</option>
				<option value="2" <?php selected( $core_admin_values['widgetobject']['navs'][$nrefid]['type'], "2" ); ?>>Blog Categories</option>  
				<option value="3" <?php selected( $core_admin_values['widgetobject']['navs'][$nrefid]['type'], "3" ); ?>>Pages</option>  
						
			</select>
	</p>
	<?php 
	}
	
	if (strpos($bit, "gmap-") !== false) {  $ITEMKEY = "gmap"; 
	 
	if($core_admin_values['widgetobject']['gmap'][$nrefid]['clickme'] == "yes"){ $c2 = ""; $c1 = "selected=selected"; }else{ $c1 = ""; $c2 = "selected=selected"; }   
	if($core_admin_values['widgetobject']['gmap'][$nrefid]['caticons'] == "yes"){ $cc2 = ""; $cc1 = "selected=selected"; }else{ $cc1 = ""; $cc2 = "selected=selected"; }  ?>
	
	<div class="alert">Note: Only listing with a valid long/latitude value will be displayed.</div>
	
	<div class="row-fluid"><div class="span6">	
	 
	<fieldset class="subset2">
	<h4>Display Options</h4>
	<label><b>Block Box Title</b></label>
	<input type="text"  name="admin_values[widgetobject][gmap][<?php echo $nrefid; ?>][title]" class="row-fluid" value="<?php echo  $core_admin_values['widgetobject']['gmap'][$nrefid]['title']; ?>">
	
	<p><label><b>Show map on image click</b></label>
			  <select name="admin_values[widgetobject][gmap][<?php echo $nrefid; ?>][clickme]" class="chzn-select" id="default_gmap_clickme_id<?php echo $nrefid; ?>">
			  <option value="yes" <?php echo $c1; ?>>Yes</option>
			  <option value="no" <?php echo $c2; ?>>No</option>                     
			</select>
	</p>
	
	<label><b>Disply Type</b></label>
			  <select name="admin_values[widgetobject][gmap][<?php echo $nrefid; ?>][dtype]" class="chzn-select" id="default_gmap_dtype_id<?php echo $nrefid; ?>">
			  <option value="1" <?php if($core_admin_values['widgetobject']['gmap'][$nrefid]['dtype'] == "1"){ echo "selected=selected"; } ?>>All Available Listings</option>
			  <option value="2" <?php if($core_admin_values['widgetobject']['gmap'][$nrefid]['dtype'] == "2"){ echo "selected=selected"; } ?>>Featured Only (enhancement)</option> 
			  <option value="3" <?php if($core_admin_values['widgetobject']['gmap'][$nrefid]['dtype'] == "3"){ echo "selected=selected"; } ?>>Frontpage Only (enhancement)</option>                     
			</select>
			
	<label><b>Disply # Listings</b></label>
	<input type="text"  name="admin_values[widgetobject][gmap][<?php echo $nrefid; ?>][num]" id="gmap_q<?php echo $i; ?>" class="row-fluid" value="<?php echo  $core_admin_values['widgetobject']['gmap'][$nrefid]['num']; ?>" style="width:50px;">
	
	</fieldset>
	
	
	</div>
	<div class="span6">	
	
	<fieldset class="subset1">
	<h4>Google Map Defaults</h4>
	<p><label><b>Default Map Coords (0,0)</b></label>
	<input type="text"  name="admin_values[widgetobject][gmap][<?php echo $nrefid; ?>][dc]" class="row-fluid" value="<?php echo  $core_admin_values['widgetobject']['gmap'][$nrefid]['dc']; ?>"></p>
	
	<p><label><b>Default Zoom Value (0 - 20)</b></label>
	<input type="text"  name="admin_values[widgetobject][gmap][<?php echo $nrefid; ?>][zoom]" class="row-fluid" value="<?php echo  $core_admin_values['widgetobject']['gmap'][$nrefid]['zoom']; ?>"></p>
	
	<p><label><b>Use Category Icons (where possible)</b></label>
			  <select name="admin_values[widgetobject][gmap][<?php echo $nrefid; ?>][caticons]" class="chzn-select" id="default_gmap_caticons_id<?php echo $nrefid; ?>">
			  <option value="yes" <?php echo $cc1; ?>>Yes</option>
			  <option value="no" <?php echo $cc2; ?>>No</option>                     
			</select>
	</p>
	
	</fieldset>
	
	</div>
	</div>
	
	<?php
	
	}
	
	if (strpos($bit, "tabs-") !== false) { $ITEMKEY = "tabs";
	 
	if($core_admin_values['widgetobject']['tabs'][$nrefid]['btnview'] == "no"){ $b1 = ""; $b2 = "selected=selected"; }else{ $b2 = ""; $b1 = "selected=selected"; }
	if($core_admin_values['widgetobject']['tabs'][$nrefid]['perrow'] == 4){ $ba1 = ""; $ba2 = "selected=selected"; }else{ $ba2 = ""; $ba1 = "selected=selected"; }
	?>
	
	
	<ul class="nav nav-tabs" id="myTab1">
	  <li class="active"><a href="#t1_<?php echo $nrefid;?>">Tab1</a></li>
	  <li><a href="#t2_<?php echo $nrefid;?>">Tab2</a></li>
	  <li><a href="#t3_<?php echo $nrefid;?>">Tab3</a></li>
	  <li><a href="#t4_<?php echo $nrefid;?>">Tab4</a></li>
	</ul>
	 
	<div class="tab-content" style="min-height:200px;">
	<div class="tab-pane active" id="t1_<?php echo $nrefid;?>">
	<div class="row-fluid">
		<div class="span6">	
		<label><b>Title Text</b></label>
		<input type="text"  name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][title1]" class="row-fluid" value="<?php echo $core_admin_values['widgetobject']['tabs'][$nrefid]['title1']; ?>">	
		<label><b>Query String <a href="http://codex.wordpress.org/Function_Reference/query_posts" target="_blank" class="label label-success">Help</a></b></label>
		<?php echo $this->_custom_query_selection('tab1_q'.$i); ?>
		<input type="text"  name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][query1]" id="tab1_q<?php echo $i; ?>" class="row-fluid" value="<?php echo  $core_admin_values['widgetobject']['tabs'][$nrefid]['query1']; ?>">
	 
		
		</div>    
		<div class="span6">
		<label><b>Content (HTML/Shortcodes)</b></label>
		<textarea name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][content1]" style="height:150px;font-size:11px;width:100%;"><?php echo stripslashes($core_admin_values['widgetobject']['tabs'][$nrefid]['content1']); ?></textarea>
		
		<label>Display Style</label>
		<select name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][style1]">
		<option value="grid">Gird View</option>
		<option value="list" <?php if($core_admin_values['widgetobject']['tabs'][$nrefid]['style1'] == "list"){ echo "selected=selected"; } ?>>List View</option>
		</select>

		
		</div>
	</div>
	</div>
	<div class="tab-pane" id="t2_<?php echo $nrefid;?>">
	<div class="row-fluid">
		<div class="span6">	
		<label><b>Title Text</b></label>
		<input type="text"  name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][title2]" class="row-fluid" value="<?php echo $core_admin_values['widgetobject']['tabs'][$nrefid]['title2']; ?>">	
		<label><b>Query String <a href="http://codex.wordpress.org/Function_Reference/query_posts" target="_blank" class="label label-success">Help</a></b></label>
		 <?php echo $this->_custom_query_selection('tab2_q'.$i); ?>
		<input type="text"  name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][query2]" id="tab2_q<?php echo $i; ?>" class="row-fluid" value="<?php echo  $core_admin_values['widgetobject']['tabs'][$nrefid]['query2']; ?>">    
		  
		</div>
		<div class="span6">
		<label><b>Content (HTML/Shortcodes)</b></label>
		<textarea name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][content2]" style="height:150px;font-size:11px;width:100%;"><?php echo stripslashes($core_admin_values['widgetobject']['tabs'][$nrefid]['content2']); ?></textarea>
		
			<label>Display Style</label>
		<select name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][style2]">
		<option value="grid">Gird View</option>
		<option value="list" <?php if($core_admin_values['widgetobject']['tabs'][$nrefid]['style2'] == "list"){ echo "selected=selected"; } ?>>List View</option>
		</select>
		</div>
	</div>
	</div>
	<div class="tab-pane" id="t3_<?php echo $nrefid;?>">
	<div class="row-fluid">
		<div class="span6">	
		<label><b>Title Text</b></label>
		<input type="text"  name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][title3]" class="row-fluid" value="<?php echo $core_admin_values['widgetobject']['tabs'][$nrefid]['title3']; ?>">	
		<label><b>Query String <a href="http://codex.wordpress.org/Function_Reference/query_posts" target="_blank" class="label label-success">Help</a></b></label>
		 <?php echo $this->_custom_query_selection('tab3_q'.$i); ?>
		<input type="text"  name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][query3]" id="tab3_q<?php echo $i; ?>" class="row-fluid" value="<?php echo  $core_admin_values['widgetobject']['tabs'][$nrefid]['query3']; ?>">
	   
		</div>
		<div class="span6">
		<label><b>Content (HTML/Shortcodes)</b></label>
		<textarea name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][content3]" style="height:150px;font-size:11px;width:100%;"><?php echo stripslashes($core_admin_values['widgetobject']['tabs'][$nrefid]['content3']); ?></textarea>
		
			<label>Display Style</label>
		<select name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][style3]">
		<option value="grid">Gird View</option>
		<option value="list" <?php if($core_admin_values['widgetobject']['tabs'][$nrefid]['style3'] == "list"){ echo "selected=selected"; } ?>>List View</option>
		</select>
		</div>
	</div>
	</div>
	<div class="tab-pane" id="t4_<?php echo $nrefid;?>">
	<div class="row-fluid">
		<div class="span6">	
		<label><b>Title Text</b></label>
		<input type="text"  name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][title4]" class="row-fluid" value="<?php echo $core_admin_values['widgetobject']['tabs'][$nrefid]['title4']; ?>">	
		<label><b>Query String <a href="http://codex.wordpress.org/Function_Reference/query_posts" target="_blank" class="label label-success">Help</a></b></label>
		 <?php echo $this->_custom_query_selection('tab4_q'.$i); ?>
		<input type="text"  name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][query4]" id="tab4_q<?php echo $i; ?>" class="row-fluid" value="<?php echo  $core_admin_values['widgetobject']['tabs'][$nrefid]['query4']; ?>">
	  
		</div>
		<div class="span6">
		<label><b>Content (HTML/Shortcodes)</b></label>
		<textarea name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][content4]" style="height:150px;font-size:11px;width:100%;"><?php echo stripslashes($core_admin_values['widgetobject']['tabs'][$nrefid]['content4']); ?></textarea>
		
			<label>Display Style</label>
		<select name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][style4]">
		<option value="grid">Gird View</option>
		<option value="list" <?php if($core_admin_values['widgetobject']['tabs'][$nrefid]['style4'] == "list"){ echo "selected=selected"; } ?>>List View</option>
		</select>
		</div>
	</div>
	</div>
	
	
	</div>
	
	 
			  <select name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][btnview]" class="chzn-select" id="default_6_btnview_id<?php echo $nrefid; ?>">
			  <option value="yes" <?php echo $b1; ?>>Show View Listings Button</option>
			  <option value="no" <?php echo $b2; ?>>Hide View Listings Button</option>                     
			</select>
            
              <select name="admin_values[widgetobject][tabs][<?php echo $nrefid; ?>][perrow]" class="chzn-select" id="default_6_perrow_<?php echo $nrefid; ?>">
			  <option value="3" <?php selected( $core_admin_values['widgetobject']['tabs'][$nrefid]['perrow'], 3 ); ?>>3 per row</option>
			  <option value="4" <?php selected( $core_admin_values['widgetobject']['tabs'][$nrefid]['perrow'], 4 ); ?>>4 per row</option> 
              <option value="5" <?php selected( $core_admin_values['widgetobject']['tabs'][$nrefid]['perrow'], 5 ); ?>>5 per row</option> 
              <option value="6" <?php selected( $core_admin_values['widgetobject']['tabs'][$nrefid]['perrow'], 6 ); ?>>6 per row</option>                    
			</select>
	 
	<script>
	 jQuery('#myTab1 a').click(function (e) {
	  e.preventDefault();
	  jQuery(this).tab('show');
	})
	</script>
	
	<?php
	
	
	}
	
	
	if (strpos($bit, "carsousel-") !== false) { $ITEMKEY = "carsousel";
			
			 
			if($core_admin_values['widgetobject']['carsousel'][$nrefid]['arrows'] == "top"){ $a1 = ""; $a2 = "selected=selected"; }else{ $a2 = ""; $a1 = "selected=selected"; }
	
			echo '
			
			<div class="row-fluid">
			<div class="span12">	
			<label><b>Block Box Title</b></label>
			<input type="text"  name="admin_values[widgetobject][carsousel]['.$nrefid.'][title]" class="row-fluid" value="'.$core_admin_values['widgetobject']['carsousel'][$nrefid]['title'].'">	
			</div>		
			</div>
			
			<div class="row-fluid">
			<div class="span6">	
			
			
			<fieldset class="subset2">
		
			<h4>Data Setup Options</h4>
			
					 
				
			<label><b>Query String <a href="http://codex.wordpress.org/Function_Reference/query_posts" target="_blank" class="label label-success">Help</a></b></label>
			
			'.$this->_custom_query_selection('car_q'.$i).'
			 
			<input type="text"  name="admin_values[widgetobject][carsousel]['.$nrefid.'][query]" class="row-fluid" value="'.$core_admin_values['widgetobject']['carsousel'][$nrefid]['query'].'" id="car_q'.$i.'">
		 
			 
			<label><b>Taxonomy </b></label>
			<select name="admin_values[widgetobject][carsousel]['.$nrefid.'][tax]" class="chzn-select" id="default_carsousel_tax_id'.$i.'"><option value="">--- do not use taxonomy ---</option>';		  
			$taxonomies=get_taxonomies('','names'); 
			foreach ($taxonomies as $taxonomy ) { 		
				if($taxonomy == "post_tag" || $taxonomy == "nav_menu"|| $taxonomy == "post_format" || $taxonomy == "link_category"){ continue; }		
				if($core_admin_values['widgetobject']['carsousel'][$nrefid]['tax'] == $taxonomy){$ss = "selected=selected"; }else{ $ss = "";  }		
				echo '<option value="'. $taxonomy. '" '.$ss.'>'. $taxonomy. '</option>';
			}		  
								  
			echo '</select>
			 
			 </fieldset>
			 
			 </div>
			 <div class="span6">
		 
			<fieldset class="subset1">
		
			<h4>Display Options</h4>
			
			<label><b>Control Arrows</b></label>
			  <select name="admin_values[widgetobject][carsousel]['.$nrefid.'][arrows]" class="chzn-select" id="default_carsousel_arrows_id'.$i.'">
			  <option value="default" '.$a1.'>Left/Right (default)</option>
			  <option value="top" '.$a2.'>Top</option>                     
			</select>
			
			 
			<label><b>Items per row</b></label>
			
			  <select name="admin_values[widgetobject][carsousel]['.$nrefid.'][perrow]" class="chzn-select" id="default_carsousel_perrow_id'.$i.'">
			  <option value="2" '.selected( $core_admin_values['widgetobject']['carsousel'][$nrefid]['perrow'], 2 ).'>2</option>
			  <option value="3" '.selected( $core_admin_values['widgetobject']['carsousel'][$nrefid]['perrow'], 3 ).'>3</option>
			  <option value="4" '.selected( $core_admin_values['widgetobject']['carsousel'][$nrefid]['perrow'], 4 ).'>4</option>
			  <option value="5" '.selected( $core_admin_values['widgetobject']['carsousel'][$nrefid]['perrow'], 5 ).'>5</option>
			  <option value="6" '.selected( $core_admin_values['widgetobject']['carsousel'][$nrefid]['perrow'], 6 ).'>6</option> 
			                      
			</select>
			
			</fieldset>
			
			</div></div>
			';
			
			}// end if
			
			
	if (strpos($bit, "2columns-") !== false) { $ITEMKEY = "2columns";
	
	$defaultcode = '<div class="panel panel-default">
            <div class="panel-heading"><h3>Box Headline</h3></div>
            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pharetra varius quam sit amet vulputate. 
            Quisque mauris augue, molestie tincidunt condimentum vitae, gravida a libero. Aenean sit amet felis 
            dolor, in sagittis nisi. Sed ac orci quis tortor imperdiet venenatis. Duis elementum auctor accumsan. 
            Aliquam in felis sit amet augue.
            </div></div>'; 
	 
	?>
 	<ul class="nav nav-tabs" id="Columns2Tabs">
	  <li class="active"><a href="#c21_<?php echo $nrefid;?>">Column 1</a></li>
	  <li><a href="#c22_<?php echo $nrefid;?>">Column 2</a></li>
	 
	</ul>
	 
	<div class="tab-content" style="min-height:200px;">
	<div class="tab-pane active" id="c21_<?php echo $nrefid;?>">
    
    <?php
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col1'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col1']); } 
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_col1', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][col1]')  ); 
	
	?>
  
	
	</div>
	<div class="tab-pane" id="c22_<?php echo $nrefid;?>">
	 
    <?php
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col2'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col2']); } 
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_col2',  array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][col2]')  ); 
	
	?>
	 
	</div> 
	
	</div>
    
      <p><label><b>Include Autoparagraph</b></label>
		 <select name="admin_values[widgetobject][<?php echo $ITEMKEY; ?>][<?php echo $nrefid; ?>][autop]" class="chzn-select" id="default_autop1_<?php echo $ITEMKEY; ?>">
			  <option value="1" <?php selected( $core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['autop'], "1" ); ?>>Yes</option>
			<option value="2" <?php selected( $core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['autop'], "2" ); ?>>No</option>  
			  			
			</select>
	</p>
 
	 
	<script>
 	 jQuery('#Columns2Tabs a').click(function (e) {
	  e.preventDefault();
	  jQuery(this).tab('show');
	})
	</script>
	<?php
	
	}
	
	if (strpos($bit, "3columns-") !== false) { $ITEMKEY = "3columns";
	
	
		$defaultcode = '<div class="panel panel-default">
            <div class="panel-heading"><h3>Box Headline</h3></div>
            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pharetra varius quam sit amet vulputate. 
            Quisque mauris augue, molestie tincidunt condimentum vitae, gravida a libero. Aenean sit amet felis 
            dolor, in sagittis nisi. Sed ac orci quis tortor imperdiet venenatis. Duis elementum auctor accumsan. 
            Aliquam in felis sit amet augue.
            </div></div>'; 
	 
	
	?>
	<ul class="nav nav-tabs" id="Columns3Tabs">
	  <li class="active"><a href="#c31_<?php echo $nrefid;?>">Column 1</a></li>
	  <li><a href="#c32_<?php echo $nrefid;?>">Column 2</a></li>
	  <li><a href="#c33_<?php echo $nrefid;?>">Column 3</a></li>
	</ul>
	 
	<div class="tab-content" style="min-height:200px;">
	<div class="tab-pane active" id="c31_<?php echo $nrefid;?>">
	 
    <?php
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col1'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col1']); } 
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_col1', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][col1]')  ); 
	
	?>
	
	</div>
	<div class="tab-pane" id="c32_<?php echo $nrefid;?>">
	 
    <?php
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col2'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col2']); } 
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_col2', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][col2]')  ); 
	
	?>
	 
	</div>
	<div class="tab-pane" id="c33_<?php echo $nrefid;?>">
	 
    <?php
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col3'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col3']); } 
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_col3', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][col3]')  ); 
	
	?>
	 
	</div>
	
	
	</div>
	 
	<script>
 	
	 jQuery('#Columns3Tabs a').click(function (e) {
	  e.preventDefault();
	  jQuery(this).tab('show');
	})
	</script>
	<?php
	
	}
	
	if (strpos($bit, "4columns-") !== false) { $ITEMKEY = "4columns";
	
	
		$defaultcode = '<div class="panel panel-default">
            <div class="panel-heading"><h3>Box Headline</h3></div>
            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pharetra varius quam sit amet vulputate. 
            Quisque mauris augue, molestie tincidunt condimentum vitae, gravida a libero. Aenean sit amet felis 
            dolor, in sagittis nisi. Sed ac orci quis tortor imperdiet venenatis. Duis elementum auctor accumsan. 
            Aliquam in felis sit amet augue.
            </div></div>'; 
	 
	?>
	
	<ul class="nav nav-tabs" id="Columns4Tabs">
	  <li class="active"><a href="#c41_<?php echo $nrefid;?>">Column 1</a></li>
	  <li><a href="#c42_<?php echo $nrefid;?>">Column 2</a></li>
	  <li><a href="#c43_<?php echo $nrefid;?>">Column 3</a></li>
	  <li><a href="#c44_<?php echo $nrefid;?>">Column4</a></li>
	</ul>
	 
	<div class="tab-content" style="min-height:200px;">
	<div class="tab-pane active" id="c41_<?php echo $nrefid;?>">
	
    <?php
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col1'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col1']); } 
	
		 // FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_col1', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][col1]')  ); 
	
	?>
	
	</div>
	<div class="tab-pane" id="c42_<?php echo $nrefid;?>">
	
    <?php
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col2'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col2']); }
	
		 // FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content); 
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_col2', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][col2]')  ); 
	
	?>
	
	
	</div>
	<div class="tab-pane" id="c43_<?php echo $nrefid;?>">
	 
    <?php
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col3'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col3']); } 
	
		 // FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_col3', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][col3]')  ); 
	
	?>
	
	 
	</div>
	<div class="tab-pane" id="c44_<?php echo $nrefid;?>">
	 
    <?php
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col4'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col4']); } 
	
		 // FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_col4', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][col4]')  ); 
	
	?>
		 
	</div>
	
	
	</div>
	 
	<script>
	 jQuery('#Columns4Tabs a').click(function (e) {
	  e.preventDefault();
	  jQuery(this).tab('show');
	})
	</script>
	<?php
	 
	
	}
	
	if (strpos($bit, "recentlisting-") !== false) { $ITEMKEY = "recentlisting";
	
	if($core_admin_values['widgetobject']['recentlisting'][$nrefid]['style'] == "list"){ $s3 = ""; $s1 = ""; $s2 = "selected=selected"; }elseif($core_admin_values['widgetobject']['recentlisting'][$nrefid]['style'] == "smalllist"){ $s1 = ""; $s2 = ""; $s3 = "selected=selected"; }else{ $s3 = ""; $s2 = ""; $s1 = "selected=selected"; }
	
		 
	echo '<label><b>Block Box Title</b></label>
	<input type="text"  name="admin_values[widgetobject][recentlisting]['.$nrefid.'][title]" class="row-fluid" value="'.$core_admin_values['widgetobject']['recentlisting'][$nrefid]['title'].'">
	
	
	<div class="row-fluid">
			<div class="span6">	 
			
			<fieldset class="subset2">
		
			<h4>Listing Data</h4>
			
			<p>Which listings should we display?</p>
	
			<label><b>Query String <a href="http://codex.wordpress.org/Function_Reference/query_posts" target="_blank" class="label label-success">Help</a></b></label>
			
			'.$this->_custom_query_selection('recentlisting_q'.$i).'
			<input type="text" id="recentlisting_q'.$i.'"  name="admin_values[widgetobject][recentlisting]['.$nrefid.'][query]" class="row-fluid" value="'.$core_admin_values['widgetobject']['recentlisting'][$nrefid]['query'].'">
		 
	
	 
			</fieldset>
	
	</div><div class="span6">
	
	
	<fieldset class="subset1">
		
			<h4>Display Options</h4>
	
			
	 <label><b>Display Style</b></label>
	  <select name="admin_values[widgetobject][recentlisting]['.$nrefid.'][style]" class="chzn-select" id="default_object_style_id'.$i.'">
	  <option value="grid" '.$s1.'>Grid</option>
	  <option value="list" '.$s2.'>List</option>                 
	</select>
	
		 <label><b>Items Per Row</b></label>
	  <select name="admin_values[widgetobject][recentlisting]['.$nrefid.'][perrow]" class="chzn-select" id="default_object_perrow_id'.$i.'">
	 
	  <option value="3" '.selected( $core_admin_values['widgetobject']['recentlisting'][$nrefid]['perrow'], 3 ).'>3</option>
	  <option value="4" '.selected( $core_admin_values['widgetobject']['recentlisting'][$nrefid]['perrow'], 4 ).'>4</option>
	  <option value="5" '.selected( $core_admin_values['widgetobject']['recentlisting'][$nrefid]['perrow'], 5 ).'>5</option>
	  <option value="6" '.selected( $core_admin_values['widgetobject']['recentlisting'][$nrefid]['perrow'], 6 ).'>6</option>
	  
	               
	</select>';
	
	?>
	
	        
        <label>Display Page Nav</label> 
		<select name="admin_values[widgetobject][recentlisting][<?php echo $nrefid; ?>][pagenav]">
		<option value="yes" <?php selected( $core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['pagenav'], "yes" ); ?>>Yes</option>
		<option value="no"  <?php selected( $core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['pagenav'], "no" ); ?>>No</option>
		</select>
			 
	 
			</fieldset>
	
	</div></div>
	<?php
	
	}
	
	if (strpos($bit, "advancedsearch-") !== false) { $ITEMKEY = "advancedsearch";
	
	 
	echo ' 
	<label class="control-label for="normal-field"><b>Block Box Title</b></label>
	<input type="text"  name="admin_values[widgetobject][advancedsearch]['.$nrefid.'][title]" class="row-fluid" value="'.$core_admin_values['widgetobject']['advancedsearch'][$nrefid]['title'].'">
	
	 ';
	
	}
	 
	
	if (strpos($bit, "categoryblock-") !== false) { $ITEMKEY = "categoryblock";
	
 
	if($core_admin_values['widgetobject']['categoryblock'][$nrefid]['catcount'] == "no"){ $c1 = ""; $c2 = "selected=selected"; }else{ $c2 = ""; $c1 = "selected=selected"; }
	if($core_admin_values['widgetobject']['categoryblock'][$nrefid]['desc'] == "no"){ $d1 = ""; $d2 = "selected=selected"; }else{ $d2 = ""; $d1 = "selected=selected"; }
	
	
	if($core_admin_values['widgetobject']['categoryblock'][$nrefid]['subcatcount'] == "no"){ $sc1 = ""; $sc2 = "selected=selected"; }else{ $sc2 = ""; $sc1 = "selected=selected"; }
	if($core_admin_values['widgetobject']['categoryblock'][$nrefid]['btnview'] == "no"){ $b1 = ""; $b2 = "selected=selected"; }else{ $b2 = ""; $b1 = "selected=selected"; }
	if($core_admin_values['widgetobject']['categoryblock'][$nrefid]['subcatempty'] == "no"){ $sce1 = ""; $sce2 = "selected=selected"; }else{ $sce2 = ""; $sce1 = "selected=selected"; }
	if($core_admin_values['widgetobject']['categoryblock'][$nrefid]['iconsize'] == "no"){ $is1 = "";$is3 = "";  $is2 = "selected=selected"; }
	elseif($core_admin_values['widgetobject']['categoryblock'][$nrefid]['iconsize'] == "noshow"){ $is1 = "";$is3 = "selected=selected";  $is2 = ""; }
	else{ $is2 = "";  $is3 = ""; $is1 = "selected=selected"; }
	
	
	
	echo ' 
	
	<div class="row-fluid">
	
	<div class="span6">	 
			
	<label><b>Block Box Title</b></label>
	<input type="text"  name="admin_values[widgetobject][categoryblock]['.$nrefid.'][title]" class="row-fluid" value="'.$core_admin_values['widgetobject']['categoryblock'][$nrefid]['title'].'">
	
	</div>
	<div class="span6">	 
		<label style="font-size:12px;line-height:25px;"><b>Show View Listings Button</b></label>
			  <select name="admin_values[widgetobject][categoryblock]['.$nrefid.'][btnview]" class="chzn-select" id="default_4_btnview_id'.$i.'">
			  <option value="yes" '.$b1.'>Show</option>
			  <option value="no" '.$b2.'>Hide</option>                     
			</select>
		
	</div>
	
	</div>
	 
	<div class="row-fluid">
	
			<div class="span6">	 
	
		<fieldset class="subset2">
		
			<h4>Parent Category Display</h4>
			
			<label><b>Display Selected Categories (optional)</b></label>
			  <select name="admin_values[widgetobject][categoryblock]['.$nrefid.'][selected][]" class="chzn-select" id="default_4_cats_id'.$i.'" multiple=yes>		  
			  '.$this->CategoryList(array($core_admin_values['widgetobject']['categoryblock'][$nrefid]['selected'],false,0,THEME_TAXONOMY)).'                    
			</select>
			
			<label><b>Display Category Image </b></label>
			  <select name="admin_values[widgetobject][categoryblock]['.$nrefid.'][image]" class="chzn-select" id="default_4_image_id'.$i.'">
			  <option value="yes" '.selected( $core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['image'], "yes" ).'>Yes - Top display (large)</option>
			  <option value="yes-side" '.selected( $core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['image'], "yes-side" ).'>Yes - Side Display (medium)</option>
			  <option value="no" '.selected( $core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['image'], "no" ).'>Yes - Opposite Title (small)</option> 
			  <option value="off" '.selected( $core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['image'], "off" ).'>No - Do not Display</option>                       
			</select>
			
			<label><b>Display Category Description </b></label>
			  <select name="admin_values[widgetobject][categoryblock]['.$nrefid.'][desc]" class="chzn-select" id="default_4_desc_id'.$i.'">
			  <option value="yes" '.$d1.'>Yes </option>			  
			  <option value="no" '.$d2.'>No</option>                     
			</select>
			
			';
			
			if($i2 == "selected=selected"){ $ex = ""; }else{ $ex = 'style="display:none"'; }
			
			echo '<div id="default_4_iconsize_idblock'.$i.'" '.$ex.'>
			<label><b>Small Category Icon Size</b></label>
			  <select name="admin_values[widgetobject][categoryblock]['.$nrefid.'][iconsize]" class="chzn-select" id="default_4_iconsize_id'.$i.'">
			  <option value="yes" '.$is1.'>Very Small (24px/24px)</option>
			  <option value="no" '.$is2.'>Small (32px/32px)</option>   
			  <option value="noshow" '.$is3.'>Do not Show Icons</option>                    
			</select>
			</div>
			
			<script>jQuery("#default_4_image_id'.$i.'").change(function(e) { if(jQuery("#default_4_image_id'.$i.'").val() == "no"){ jQuery("#default_4_iconsize_idblock'.$i.'").show(); } else { jQuery("#default_4_iconsize_idblock'.$i.'").hide(); }  }); </script> 
			
			<label><b>Category Count</b></label>
			  <select name="admin_values[widgetobject][categoryblock]['.$nrefid.'][catcount]" class="chzn-select" id="default_4_catcount_id'.$i.'">
			  <option value="yes" '.$c1.'>Show</option>
			  <option value="no" '.$c2.'>Hide</option>                     
			</select>
		
		</fieldset>
	
	</div><div class="span6">
	
		<fieldset class="subset1">
			<h4>Sub Category Display</h4>
			
			<label><b>Max Parent Cats</b></label>
			<input type="text"  name="admin_values[widgetobject][categoryblock]['.$nrefid.'][pcats]" class="row-fluid" value="'.$core_admin_values['widgetobject']['categoryblock'][$nrefid]['pcats'].'" style="width:90px;">
			
			<label><b>Max Sub Cats</b></label>
			<input type="text"  name="admin_values[widgetobject][categoryblock]['.$nrefid.'][subcats]" class="row-fluid" value="'.$core_admin_values['widgetobject']['categoryblock'][$nrefid]['subcats'].'" style="width:90px;">
			
			
			<label><b>Category Count</b></label>
			  <select name="admin_values[widgetobject][categoryblock]['.$nrefid.'][subcatcount]" class="chzn-select" id="default_4_subcatcount_id'.$i.'">
			  <option value="yes" '.$sc1.'>Show</option>
			  <option value="no" '.$sc2.'>Hide</option>                     
			</select>		
			
			<label><b>Show Empty Categories</b></label>
			  <select name="admin_values[widgetobject][categoryblock]['.$nrefid.'][subcatempty]" class="chzn-select" id="default_4_subcatempty_id'.$i.'">
			  <option value="yes" '.$sce1.'>Show</option>
			  <option value="no" '.$sce2.'>Hide</option>                     
			</select>	
			
		</fieldset>
		
		
	
	</div></div>
	';
	
	}
	
	
	
	if (strpos($bit, "basicsearch-") !== false) { $ITEMKEY = "basicsearch";
	 
	$defaultcode = ''; 
	 
	?>
 	<ul class="nav nav-tabs" id="Columns2Tabs">
	  <li class="active"><a href="#c21_<?php echo $nrefid;?>">Text Before</a></li>
	  <li><a href="#c22_<?php echo $nrefid;?>">Text After</a></li>
	 
	</ul>
	 
	<div class="tab-content" style="min-height:200px;">
	<div class="tab-pane active" id="c21_<?php echo $nrefid;?>">
    
    <?php
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col1'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col1']); } 
	
		 // FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_col1', array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][col1]')  ); 
	
	?>
  
	
	</div>
	<div class="tab-pane" id="c22_<?php echo $nrefid;?>">
	 
    <?php
	
	// LOAD IN DEFAULT CODE
	if($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col2'] == ""){ $content = $defaultcode; }
	else{  $content = stripslashes($core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['col2']); } 
	
		 // FILTER FOR ATTACHMENT IDS	
	$content = str_replace("wltatt_id","wp-image-".$CORE->randattachmentid(),$content);
	 
	// LOAD UP EDITOR
	echo wp_editor( $content, ''.$ITEMKEY.'_'.$nrefid.'_col2',  array('textarea_name' => 'admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][col2]')  ); 
	
	?>
	 
	</div> 
	
	</div>
 
	 
	<script>
 	 jQuery('#Columns2Tabs a').click(function (e) {
	  e.preventDefault();
	  jQuery(this).tab('show');
	})
	</script>
   <?php 
	
	}
	
	
	
	if (strpos($bit, "sec1") !== false) { $ITEMKEY = "sec1";
	
	?>
    
    asdasd
    <?php
	
	
	} 
	
	
	
	
	
	

	
	if (strpos($bit, "shortcode") !== false) { $ITEMKEY = "shortcode"; 
	
		echo '
		<fieldset class="subset2">	
		<h4>Content (accepts HTML/shortcodes)</h4>
		<textarea  name="admin_values[widgetobject][shortcode]['.$nrefid.'][text]" class="row-fluid" style="min-height:300px;">'.stripslashes($core_admin_values['widgetobject']['shortcode'][$nrefid]['text']).'</textarea>
		</fieldset>';
	}
	
	// HOOK FOR PLUGINS	 
	$out = hook_object_setup(array($bit, $nrefid, $i));
	if(!is_array($out) && $out != ""){ $ITEMKEY = $out; }
	// end
	 
	if(isset($core_admin_values['widgetobject'][$ITEMKEY]) && $core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['fullw'] == "no"){ $w1 = ""; $w2 = "checked=checked"; $w3 = "";  }
	elseif(isset($core_admin_values['widgetobject'][$ITEMKEY]) && $core_admin_values['widgetobject'][$ITEMKEY][$nrefid]['fullw'] == "underheader"){ $w1 = ""; $w2 = ""; $w3 = "checked=checked"; }
	else{ $w2 = ""; $w1 = "checked=checked"; $w3 = ""; } 
	
	echo '</div>
	  <div class="modal-footer" style="background:#fff;border:1px solid #B3E4B5; margin-top:30px;">
	
	<div class="row-fluid">
	<div class="span8">
	<div class="checkbox" style="background:transparent;text-align:left; font-size:14px;">
	
	<b style="font-weight:900;">Display Location:</b>
	 
	<input type="radio" value="yes" '.$w1.' name="admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][fullw]" style="margin-top:0px;"> Full Width (<i class="gicon-align-justify"></i>) 
	<input type="radio" value="no" '.$w2.' name="admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][fullw]" style="margin-top:0px; margin-left:20px;"> Inline  (<i class="gicon-indent-left"></i>)
	
	<input type="radio" value="underheader" '.$w3.' name="admin_values[widgetobject]['.$ITEMKEY.']['.$nrefid.'][fullw]" style="margin-top:0px;  margin-left:20px;"> Under Header (<i class="gicon-fullscreen"></i>) </div>
	
	
	</div>
	<div class="span4">
	 <button type="button" onclick="jQuery(\'#ObjOptions_'.$nrefid.'\').hide();">Close</button>
		<button class="btn btn-primary" style="background:#417743;">Save Changes</button>
	</div>
	</div>
	  
	   
	  </div>
	</div>';
	$i++;
	}// end foreach 
	
	
	
	
	
	
	
	}
	
	
} // END CLASS
	
?>
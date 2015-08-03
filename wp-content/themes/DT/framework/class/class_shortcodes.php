<?php
class core_shortcodes extends white_label_themes {

	function core_shortcodes(){
			
			/*
				THERE ARE TWO TYPES OF SHORTCODES HERE;
				1) REPLIES ON BEING INSIDE THE LOOP
				2) CAN BE USED ON NORMAL PAGES			
			*/
			 
			// LOOP SHORTCODES
			add_shortcode( 'IMAGE', array($this,'wlt_shortcode_image') );
			add_shortcode( 'RATING', array($this,'wlt_shortcode_rating') );		
			
			
			add_shortcode( 'URL', array($this,'wlt_shortcode_url') );
			add_shortcode( 'TIMELEFT', array($this,'wlt_shortcode_timeleft') );
			add_shortcode( 'FIELDS', array($this,'wlt_shortcode_fields') );
			add_shortcode( 'TOOLBAR', array($this,'wlt_shortcode_toolbar') );
			add_shortcode( 'TOOLBOX', array($this,'wlt_shortcode_toolbox') );
			add_shortcode( 'TOOLSET', array($this,'wlt_shortcode_toolset') );
			add_shortcode( 'FILES', array($this,'wlt_shortcode_files') );
			add_shortcode( 'ATTACHMENTS', array($this,'wlt_shortcode_attachments') );
			add_shortcode( 'TIMESINCE', array($this,'wlt_shortcode_timesince') );
			
			add_shortcode( 'IMAGES', array($this,'wlt_shortcode_images') );
			add_shortcode( 'VISITORCHART', array($this,'wlt_shortcode_visitorchart') );
						
			add_shortcode( 'BTN',  array($this, 'wlt_shortcode_btn' ) );			
			add_shortcode( 'USERID',  array($this, 'wlt_shortcode_userid' ) );
			add_shortcode( 'CONTACT',  array($this, 'wlt_shortcode_contact' ) );
			add_shortcode( 'COMMENTS',  array($this, 'wlt_shortcode_comments' ) );
			add_shortcode( 'FAVS',  array($this, 'wlt_shortcode_favs' ) );
			add_shortcode( 'MSG',  array($this, 'wlt_shortcode_msg' ) );
			add_shortcode( 'RELATED',  array($this, 'wlt_shortcode_related' ) );			
			add_shortcode( 'IMAGEAUTHOR',  array($this, 'wlt_shortcode_author' ) );
			add_shortcode( 'EXCERPT',  array($this, 'wlt_shortcode_excerpt' ) );
			add_shortcode( 'TAGS',  array($this, 'wlt_shortcode_tags' ) );
			add_shortcode( 'CAROUSEL',  array($this, 'wlt_shortcode_carousel' ) );
			add_shortcode( 'VIDEO',  array($this, 'wlt_shortcode_video' ) );
			add_shortcode( 'PRINT',  array($this, 'wlt_shortcode_print' ) );
			
			// NORMAL PAGES
			add_shortcode( 'LISTINGS', array($this,'wlt_page_listings') );			
			add_shortcode( 'ADVANCEDSEARCH', array($this,'wlt_shortcode_advancedsearch') );	
			add_shortcode( 'MEMBERS', array($this,'wlt_page_members') );
			add_shortcode( 'TAXONOMY', array($this,'wlt_page_taxonomy') );
			add_shortcode( 'CATEGORIES', array($this,'wlt_page_categories') );
			add_shortcode( 'MEMBERSHIP', array($this,'wlt_membership_filter') );
			add_shortcode( 'GOOGLEMAP', array($this, 'wlt_google_maps_display' ) );				
			
			// BETA
			add_shortcode( 'SHOWME', array($this,'wlt_listing_filter') );
			add_shortcode( 'ICON', array($this, 'wlt_icon' ) );
			add_shortcode( 'DISTANCE', array($this, 'wlt_distance' ) );	
			add_shortcode( 'WLT_SLIDER', array($this, 'wlt_slider' ) );
			add_shortcode( 'BTNBAR',  array($this, 'wlt_shortcode_btnbar' ) );		 
			add_shortcode( 'COUNTRY',  array($this, 'wlt_shortcode_country' ) );
			
			add_shortcode( 'MUSIC',  array($this, 'wlt_shortcode_music' ) );
			
			// BETA DISPLAY
			add_shortcode( 'D_CATEGORIES',  array($this, 'wlt_shortcode_dcats' ) );
			add_shortcode( 'D_FEEDBACK',  array($this, 'wlt_shortcode_dfeedback' ) );
			add_shortcode( 'AUTHORBOX',  array($this, 'wlt_shortcode_authorbox' ) );
			add_shortcode( 'D_SOCIAL',  array($this, 'wlt_shortcode_socialbtns' ) );
			add_shortcode( 'D_BREADCRUMBS',  array($this, 'wlt_shortcode_breadcrumbs' ) );
			
			
			
	}

function wlt_shortcode_breadcrumbs(){ global $post, $CORE; 

return '<ol class="breadcrumb wlt_shortcode_breadcrumbs">'.$CORE->BREADCRUMBS('<li>','</li>').'</ol>';

}


function wlt_shortcode_socialbtns(){ 

global $post; 

ob_start();
?>
 
<a href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url=<?php echo get_permalink($post->ID); ?>&pubid=ra-53d6f43f4725e784&ct=1&title=<?php echo $post->post_title; ?>&pco=tbxnj-1.0" target="_blank">
<img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/facebook.png" border="0" alt="Facebook"/></a>
<a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url=<?php echo get_permalink($post->ID); ?>&pubid=ra-53d6f43f4725e784&ct=1&title=<?php echo $post->post_title; ?>&pco=tbxnj-1.0" target="_blank">
<img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/twitter.png" border="0" alt="Twitter"/></a>
<a href="https://api.addthis.com/oexchange/0.8/forward/linkedin/offer?url=<?php echo get_permalink($post->ID); ?>&pubid=ra-53d6f43f4725e784&ct=1&title=<?php echo $post->post_title; ?>&pco=tbxnj-1.0" target="_blank">
<img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/linkedin.png" border="0" alt="LinkedIn"/></a>
<a href="https://api.addthis.com/oexchange/0.8/forward/google_plusone_share/offer?url=<?php echo get_permalink($post->ID); ?>&pubid=ra-53d6f43f4725e784&ct=1&title=<?php echo $post->post_title; ?>&pco=tbxnj-1.0" target="_blank"><img src="https://cache.addthiscdn.com/icons/v2/thumbs/32x32/google_plusone_share.png" border="0" alt="Google+"/></a>

<?php 
return ob_get_clean(); 

}	
	
function wlt_shortcode_authorbox(){

global $post, $CORE;

		//  GET USER DATA
		$userid = $post->post_author; $user_info = get_userdata($userid); 
		
		// GET LAST LOGIN DATE
		$lastlogin = get_user_meta($userid, 'login_lastdate', true);
		
		// USER COUNTRY
		$selected_country = get_user_meta($userid,'country',true);
		
		// GET LISTING COUNT
		$listings = $CORE->count_user_posts_by_type( $post->post_author, THEME_TAXONOMY."_type" );
		
		// START OUTPUT 
		ob_start();
?>

    <div class="panel panel-default hidden-xs hidden-sm" id="shortcode_authorbox">
    <div class="panel-heading">
   
    <?php echo $user_info->data->display_name; ?>
    
	<?php if(strlen($selected_country) > 0){ ?>
            <div class="flag flag-<?php echo strtolower($selected_country); ?> pull-right wlt_locationflag"></div>
   <?php } ?>
   
    </div>
    <div class="panel-body">
    
		<div class="row">
   
        	<div class="col-md-4">
            
            <div class="thumbnail">
            
			<a href="<?php echo get_author_posts_url( $post->post_author ); ?>" class="frame"><?php echo get_avatar( $userid, 100 ); ?></a>
            
            <?php echo _user_trustbar($userid, 'big'); ?>
            
            </div>
            
            </div>
       
            <div class="col-md-8">
           
            <div class="joined"><?php echo str_replace("%a",$CORE->TimeDiff($user_info->user_registered,'','',false, array('years','months','days')), $CORE->_e(array('widgets','25')) ); ?></div>
            
             <?php if(strlen($user_info->user_description) > 2){ ?> 
         
             <div class="user_desc"><?php echo wpautop( strip_tags($user_info->user_description) ); ?></div>
             
             <script>
			jQuery(document).ready(function() {
			 
			  jQuery('.user_desc').expander({
				slicePoint: 220,   
				expandSpeed: 0,
				userCollapseText: '<?php echo $CORE->_e(array('feedback','4')); ?>',
				expandText: '<?php echo $CORE->_e(array('feedback','3')); ?>',
			  });
			 
			  jQuery('div.expandDiv').expander();
			}); 
			</script>
 
			 <?php } ?>
          
            
		</div>       
        
        </div>        
         
        <div class="clearfix"></div>    
        
          
            <hr />
            
            <a href="<?php echo get_author_posts_url( $post->post_author ); ?>" class="v1"><i class="fa fa-user"></i> <?php echo $CORE->_e(array('widgets','24')); ?></a>
            
            <div class="lastonline pull-right"><?php echo $CORE->_e(array('widgets','26')); ?> <?php echo hook_date($lastlogin); ?></div> 
    
   
    
    
    </div>
    </div>      

<?php
$output = ob_get_contents();
ob_end_clean();
return $output;
}
	
	function wlt_shortcode_dfeedback($atts, $content = null){ global $wpdb, $userdata, $CORE; $STRING = "";
	
		extract( shortcode_atts( array( 'pid' => '', 'purchased_only' => false ), $atts ) );	
  
		
		if($pid != ""){
		
			$STRING .= '<div id="shortcode_dfeedback">';
			
			// GET USER FEEDBACK
			$feedback = new WP_Query('posts_per_page=200&post_type=wlt_feedback&meta_key=pid&meta_value='.$pid);
		 
			if(!empty($feedback->posts)){
			 
				$STRING .= '<ul class="list-group">';
				foreach($feedback->posts as $ff){
				
				
				// CHECK IF THIS USER HAS PURCHASED THIS ITEM
				if($purchased_only){
					$SQL1 = "SELECT count(*) AS total FROM `".$wpdb->prefix."core_orders` WHERE order_items LIKE ('%".$pid."%') AND user_id='".$ff->post_author."' LIMIT 1 ";
					$result1 = $wpdb->get_results($SQL1);
					if($result1[0]->total < 1){
					continue;
					}
				}
				
					// GET SCORE
					$score = get_post_meta($ff->ID,'score',true);
					if($score == ""){ $score = 0; }
					
					$STRING .= "<li class='list-group-item'>";
					
					$STRING .= "<a href='".get_author_posts_url($ff->post_author )."' class='hidden-xs pull-right'>".str_replace("avatar ","avatar img-circle ",get_avatar($ff->post_author,50))."</a>";
					
					$STRING .= "<div class='post_date pull-right' style='margin-right:10px;'>".hook_date($ff->post_date)."</div>";
					
					$STRING .= "<h4>".$ff->post_title."</h4>";
					
					$STRING .= "<div class='post_content'>".$ff->post_content."</div>";
					
					$STRING .= "<script type='text/javascript'>jQuery(document).ready(function(){ 
								jQuery('#wlt_feedbackstar_".$ff->ID."').raty({
								readOnly:  true,
								path: '".FRAMREWORK_URI."img/rating/',
								score: ".$score.",
								size: 16,
								 
								}); });
							</script>
							 
							<div id='wlt_feedbackstar_".$ff->ID."' class='wlt_starrating'></div>";
					
					$STRING .= "</li>";				
				}
				$STRING .= "</ul>";
			
			}else{
			
				//$STRING .= "<h5>".$CORE->_e(array('feedback','21'))."</h5>";
			}
			
			$STRING .= "</div>";
				
		}
		
		// OUTPUT DATA
		return $STRING;
	
	}
	
	function wlt_shortcode_dcats($atts, $content = null){ global $wpdb; $STRING = "";
	
		extract( shortcode_atts( array( 'show_count' => '', 'title' => '' ), $atts ) );	
		 
		$cats = wp_list_categories(array('walker'=> new Walker_Simple_Example1, 
		'taxonomy' => THEME_TAXONOMY, 'show_count' => $show_count, 'hide_empty' => 0, 'echo' => 0, 'title_li' =>  false, 'show_image' => true, 'depth' => 1) ); 
	 
	  
		$STRING .= '<ul class="list-group clearfix">';
		
		// SHOW TITLE
		if(strlen($title) > 0){
		$STRING .= '<li class="list-group-item active">'.$title.'</li>';
		}
	 	
		// BUILD LIST
		$STRING .= str_replace("cat-item","list-group-item",$cats);
	 
	 	// CLEAN UP
		$STRING .= '</ul>';
		
		// RETURN
		return $STRING;		 
	
	}
	
	function shortcodelist(){
	
	return hook_shortcodelist(array(
	'AUTHOR-FLAG' => array('desc' => 'Displays the user country flag', 'type' => 'inner'),
	'LOCATION-FLAG' => array('desc' => 'Displays the listing country flag', 'type' => 'inner'),
	'LOCATION' => array('desc' => 'Displays the user selected map location', 'type' => 'inner'),
	'CATEGORY' => array('desc' => 'Listing Category', 'type' => 'inner'),
	'CATEGORYLIST' => array('desc' => 'Listing Category', 'type' => 'inner'),
	
	'LISTINGSTATUS' => array('desc' => 'Listing Status', 'type' => 'inner'),
	'EDIT' => array('desc' => 'Edit Button for Authors', 'type' => 'inner'),
	'FEEDBACK' => array('desc' => 'Listing Feedback Link', 'type' => 'inner'),
	
	'ID' => array('desc' => 'Listing ID', 'type' => 'inner'),
	'LINK' => array('desc' => 'Listing Link', 'type' => 'inner'),
	'DATE' => array('desc' => 'Listing Post Date', 'type' => 'inner'),
	'BUTTON' => array('desc' => 'More Info Button', 'type' => 'inner'),
	'AUTHOR' => array('desc' => 'Author Name + Link', 'type' => 'inner'),
	'MODIFIED' => array('desc' => 'Listing Modified Date', 'type' => 'inner'),
	'CONTENT' => array('desc' => 'Listing Content', 'type' => 'inner'),
	'COMMENT_COUNT' => array('desc' => 'Comment Counter', 'type' => 'inner'),
	'COMMENT_AJAX' => array('desc' => 'Comment Count + Ajax Comments', 'type' => 'inner'),
	'youtube' => array('desc' => 'Youtube', 'type' => 'inner'),
	'FEATUREDSPAN' => array('desc' => 'Featured Listing ID', 'type' => 'inner'),
	'STICKER' => array('desc' => 'Sticker ID', 'type' => 'inner'),
	'AUTHORIMAGE-LCIRCLE' => array('desc' => 'Author Image Large (Circular Box)', 'type' => 'inner'),
	'AUTHORIMAGE-CIRCLE' => array('desc' => 'Author Image', 'type' => 'inner'),
	'AUTHORIMAGE' => array('desc' => 'Author Image', 'type' => 'inner'),
	'TITLE' => array('desc' => 'Lsting Title', 'type' => 'inner'),
	'TITLE-NOLINK' => array('desc' => 'Listing Title without link', 'type' => 'inner'),
	'SOCIAL' => array('desc' => 'Addthis Social Icons', 'type' => 'inner'),
	//'TAB_IMAGES' => array('desc' => 'Tabbed mages (single page only)', 'type' => 'inner'),
 	
	'URL' => array('desc' => '', 'type' => 'shortcode'),
	'TIMELEFT' => array('desc' => 'Listing Expiry Countdown', 'type' => 'shortcode'),
	'FIELDS' => array('desc' => 'Listing Fields', 'type' => 'shortcode', 'singleonly' => true),
	'TOOLBAR' => array('desc' => 'Toolbar', 'type' => 'shortcode', 'singleonly' => true),
	'TOOLBOX' => array('desc' => 'Toolbox', 'type' => 'shortcode', 'singleonly' => true),
	'TOOLSET' => array('desc' => 'Toolset', 'type' => 'shortcode', 'singleonly' => true),
	'FILES' => array('desc' => 'List of files', 'type' => 'shortcode', 'singleonly' => true),
	'ATTACHMENTS' => array('desc' => 'List of attachments', 'type' => 'shortcode', 'singleonly' => true),
	'TIMESINCE' => array('desc' => 'Time till expires', 'type' => 'shortcode'),
	'IMAGE' => array('desc' => 'Display Image', 'type' => 'shortcode'),
	'IMAGES' => array('desc' => 'Image Gallery', 'type' => 'shortcode', 'singleonly' => true),
 
	'RATING' => array('desc' => 'Rating Icon', 'type' => 'shortcode'),					
	'BTN' => array('desc' => 'Button', 'type' => 'shortcode'),			
	'USERID' => array('desc' => 'User ID', 'type' => 'shortcode'),
	'CONTACT' => array('desc' => 'Contact Form', 'type' => 'shortcode', 'singleonly' => true),
	'COMMENTS' => array('desc' => 'Comments Form', 'type' => 'shortcode', 'singleonly' => true),
	'FAVS' => array('desc' => 'Add/Remov Favs', 'type' => 'shortcode'),
	'MSG' => array('desc' => '', 'type' => 'shortcode'),
	'RELATED' => array('desc' => 'Related Listings', 'type' => 'shortcode', 'singleonly' => true),			
	'IMAGEAUTHOR' => array('desc' => '', 'type' => 'shortcode'),
	'EXCERPT' => array('desc' => 'Short Description', 'type' => 'shortcode'),
	'TAGS' => array('desc' => 'Listing Tags', 'type' => 'shortcode'),
	'CAROUSEL' => array('desc' => 'Carousel', 'type' => 'shortcode', 'singleonly' => true),
	'VIDEO' => array('desc' => 'Video Box', 'type' => 'shortcode', 'singleonly' => true),
	
	'DISTANCE' => array('desc' => 'Displays distance to listing from current location', 'type' => 'shortcode'),
	'BTNBAR' => array('desc' => 'Bar of button items', 'type' => 'shortcode', 'singleonly' => true),
 	
	));
	
	}
	function wlt_shortcode_print(){ global $post, $CORE;
	
		$pl = get_permalink($post->ID);		 
		if(substr($pl,-1) != "/"){ $print_link = $pl."&print=true&amp;pid=".$post->ID; }else{ $print_link = $pl."/?print=true&amp;pid=".$post->ID; }
		
		return '<a href="'.$print_link.'" rel="nofollow" target="_blank">'.$CORE->_e(array('single','24')).'</a>';
	
	}
 	/* =============================================================================
	[MUSIC] - SHORTCODE
	========================================================================== */
	function wlt_shortcode_music($atts, $content = null){  global $userdata, $CORE, $post; $STRING = ""; 
	
		// GET ARRAY ASSIGNED TO LISTING
		$audio = get_post_meta($post->ID, 'music_array', true); 
		 
		// MAKE SURE ITS NOT EMMPTY
		if(is_array($audio) && !empty($audio) ){ 
			
			$media_file = $CORE->UPLOAD_GET($post->ID, 2, array('type' => 'music', 'limit' => 1) );
		 
			if(strlen($media_file) > 1){ 
				
				// IF IS LISTING PAGE
				if(isset($GLOBALS['flag-single'])){
				
				$add_string = "<div class='single_audio_file'>".$media_file."</div>"; 
				$add_string .= "<script>jQuery('.single_audio_file audio').mediaelementplayer({ audioWidth: '100%', audioHeight: 30, enableAutosize: true });</script>";
				
				}else{
				
				if(!isset($GLOBALS['media_id'])){ $GLOBALS['media_id']=0; }
				
				$add_string = '<div class="audiobox" id="playbutton_'.$GLOBALS['media_id'].'_wrapper">
			
				<div class="player">
				
					<div class="col-md-1">
						<div class="playbtn">	
							<span class="glyphicon glyphicon-play play" id="playbutton_'.$GLOBALS['media_id'].'_play" ></span>
							<span class="glyphicon glyphicon-pause pause hidden" id="playbutton_'.$GLOBALS['media_id'].'_pause"></span>	
						</div>
					</div>
					
					<div class="col-md-9 hidden-xs">
						<div class="progress">
							<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:0%;"></div>
						</div>
					</div>		
				<div class="clearfix"></div>
				</div>		
				
			</div> '; 
	
			$add_string .= "<div style='display:none;'>".$media_file.'</div><script type="application/javascript">
				jQuery(\'#audio_id_'.($GLOBALS['media_id']-1).'\').mediaelementplayer({ 
				audioWidth: 1, audioHeight: 1,
				 success: function(media, domElement, player) {
				
				 jQuery(\'#playbutton_'.$GLOBALS['media_id'].'_wrapper .play\').on(\'click\', function() {  media.play(); 
				 jQuery(\'#playbutton_'.$GLOBALS['media_id'].'_play\').addClass(\'hidden\'); 
				 jQuery(\'#playbutton_'.$GLOBALS['media_id'].'_pause\').removeClass(\'hidden\');
				 });
				 jQuery(\'#playbutton_'.$GLOBALS['media_id'].'_wrapper .pause\').on(\'click\', function() {  media.pause(); 
				 jQuery(\'#playbutton_'.$GLOBALS['media_id'].'_play\').removeClass(\'hidden\');  
				 jQuery(\'#playbutton_'.$GLOBALS['media_id'].'_pause\').addClass(\'hidden\');
				 }) 
				 }});
				 
				 var progress'.$GLOBALS['media_id'].';
				 jQuery(\'#playbutton_'.$GLOBALS['media_id'].'_wrapper .play\').on("click", function(event) {
				  setTimeout(audioprocess'.$GLOBALS['media_id'].'() ,300);
				 });
				 
				 jQuery(\'#playbutton_'.$GLOBALS['media_id'].'_wrapper .pause\').on("click", function(event) {
				 clearInterval(progress'.$GLOBALS['media_id'].');
				  var me = jQuery(\'#playbutton_'.$GLOBALS['media_id'].'_wrapper .progress-bar\');
				  perc = me.attr("data-percentage");
				  me.css(\'width\', perc+\'%\');
				 });
					 
				 function audioprocess'.$GLOBALS['media_id'].'(){	  
						var me = jQuery(\'#playbutton_'.$GLOBALS['media_id'].'_wrapper .progress-bar\');
						var perc = me.attr("data-percentage"); 			 
						var current_perc = me.width()/2;
						progress'.$GLOBALS['media_id'].' = setInterval(function() {
							if (current_perc>=perc || current_perc > 99 || perc > 99) {
								clearInterval(progress'.$GLOBALS['media_id'].');
							} else {
								current_perc +=1;
								me.css(\'width\', (current_perc)+\'%\');
							}
							me.text((current_perc)+\'%\');
						}, 500); 
				 }
				  
				 </script>';
				
				}
				
				
				return $add_string;
			
			}
		
		}
		
		return;
		
		
	}	
 
 	/* =============================================================================
	[SLIDER] - SHORTCODE
	========================================================================== */
	function wlt_shortcode_country($atts, $content = null){  global $userdata, $CORE, $post; $STRING = ""; 
		
		$country = get_post_meta($post->ID,'map-country',true);
		if(isset($GLOBALS['core_country_list'][$country])){
			$STRING = $GLOBALS['core_country_list'][$country];
		}else{
			$STRING = $country;
		}
		
		return $STRING;
		
	}
	/* =============================================================================
	[SLIDER] - SHORTCODE
	========================================================================== */
	function wlt_slider($atts, $content = null){  global $userdata, $CORE, $post; $STRING = ""; $PRICE = ""; $IMG = "";
	
	extract( shortcode_atts( array('id' => '', 'featured' => false, 'fontpage' => false, 'limit' => 5 ), $atts ) );	
	
	if($content != ""){
	
		$STRING .= '<div class="wlt_bxslider"><ul class="bxslider">';
		
		// CHECK FOR LI TAGS IF NOT WRAP IMAGES
		if(strpos($content, "<li>") == false){
			$STRING .= preg_replace('/(<img([^>]*)>)/i','<li>$0</li>', trim($content));
		}else{
			$STRING .= trim($content);
		} 
		
		$STRING .= '</ul></div>';
	
	}else{
	
		if($featured){
			$args = array(
				'post_type' => THEME_TAXONOMY."_type",
				'orderby' => 'rand',
				'posts_per_page' => $limit,
				'meta_query' => array(
					array(
						'key' => '_thumbnail_id',
						'value' => '',
						'compare' => '!=',
					),
					
					array(
						'key' => 'featured',
						'value' => 'yes',
						'compare' => '=',
					),
				),
			); 
		}elseif($frontpage){
			$args = array(
				'post_type' => THEME_TAXONOMY."_type",
				'orderby' => 'rand',
				'posts_per_page' => $limit,
				'meta_query' => array(
					array(
						'key' => '_thumbnail_id',
						'value' => '',
						'compare' => '!=',
					),
					
					array(
						'key' => 'frontpage',
						'value' => 'yes',
						'compare' => '=',
					),
				),
			); 		
		}else{
		$args = array(
			'post_type' => THEME_TAXONOMY."_type",
			'orderby' => 'rand',
			'posts_per_page' => $limit,
			'meta_query' => array(
				array(
					'key' => '_thumbnail_id',
					'value' => '',
					'compare' => '!=',
				),				 
			),
		); 
		}
	 	
		$q = query_posts($args);
		
		$i=1;
		if ( have_posts() ){
		
		$STRING .= '<div class="wlt_bxslider"><ul class="bxslider">';
		
		while ( have_posts() ) : the_post();
		
			// GET IMAGE
			$IMG = hook_image_display(get_the_post_thumbnail($post->ID, 'full', array('class'=> "wlt_thumbnail")));
			 
			
			// GET PRICE
			$price = get_post_meta($post->ID,'price', true);
			if($print != ""){
			$PRICE = '<p><strong>'.hook_price($price).'</strong></p>';
			}
				
		 $STRING .= '<li>'.$IMG.'
		  
		<div class="desc">
		'.$PRICE.'
		<h2>'.$post->post_title.'</h2>
		<p>'.strip_tags(substr($post->post_content,0,150)).'</p>
		</div>
		  
		  </li>'; 
	 
			$i++;
		endwhile; 
		
		$STRING .= '</ul></div>';
		
		}
		// RESET QUERY
		wp_reset_query(); 
	
	}
	
 

$STRING .= '<script src="'.get_template_directory_uri().'/framework/slider/jquery.bxslider.min.js"></script>';
$STRING .= "<script> jQuery(document).ready(function(){ jQuery('.bxslider').bxSlider({mode: 'fade',  captions: false, auto: true, }); }); </script>";

return $STRING;
			
	}
	/* =============================================================================
	[DISTANCE] - SHORTCODE
	========================================================================== */
	function wlt_distance($atts, $content = null){  global $userdata, $CORE, $post, $wp_query;
	
	 
		extract( shortcode_atts( array('postid' => '', 'icon' => '', 'text_before' => '<strong>'.$CORE->_e(array('widgets','12')).'</strong>', 'text_after' => '', 'info' => true ), $atts ) );
		
		// GET POST ID
		if($postid == ""){ $postid = $post->ID; }
			
		// GET DATA
		$item_long  	= get_post_meta($postid,'map-log',true);
		$item_lat  		= get_post_meta($postid,'map-lat',true);
		
		if($item_long == ""){ return; }
		 
		// GET MY DATA
		if(isset($_SESSION['mylocation']) && is_numeric($_SESSION['mylocation']['log']) && is_numeric($_SESSION['mylocation']['lat']) ){
		
			$my_long 	= $_SESSION['mylocation']['log'];
			$my_lat 	= $_SESSION['mylocation']['lat'];
			$my_zip 	= $_SESSION['mylocation']['zip'];
		
		}else{
		
			if(isset($GLOBALS['CORE_THEME']['google_coords1']) && $GLOBALS['CORE_THEME']['google_coords1'] != ""){ 
			
			$default_coords = $GLOBALS['CORE_THEME']['google_coords1']; 
			$dc = explode(",",$default_coords);
			$my_long 	= $dc[1];
			$my_lat 	= $dc[0];
		 	
			}else{ 
			
			$my_long 	= "-0.399693";
			$my_lat 	= "54.286891";
			
			}
		
		$my_zip 	= get_post_meta($post->ID,'map-zip',true);			
		} 
 
		
		// WORK OUT THE DIFFERENCE		
		$theta = $item_long - $my_long;
		 
		if(is_numeric($item_lat) && is_numeric($my_lat) && is_numeric($item_lat) && is_numeric($my_lat) && is_numeric($theta) ){
		$dist = sin(deg2rad($item_lat)) * sin(deg2rad($my_lat)) +  cos(deg2rad($item_lat)) * cos(deg2rad($my_lat)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);	 
		$miles =  $dist * 60 * 1.1515;
	 
		}
		
		// GET THE UNIT
		$unit = strtoupper($GLOBALS['CORE_THEME']['geolocation_unit']);			
		if ($unit == "K") {			 
			$rt = number_format(($miles * 1.609344)) ." ".$CORE->_e(array('widgets','13'));			
			
		} else if ($unit == "N") {
			$rt = number_format(($miles * 0.8684)) ." ".$CORE->_e(array('widgets','14'));	
		} else {
		   $rt = number_format($miles) ." ".$CORE->_e(array('widgets','15'));    
		}
		
		// DISPLAY ICON
		$II = "";
		if($icon != ""){
		$II = "<i class='".$icon."'></i>";
		}
		
		if($info == 0 || isset($GLOBALS['flag-home']) ){
		
		return "<span class='wlt_shortcode_distance'>".$II." ".$text_before." ".$rt." ".$text_after."</span>";
		
		}else{
		
		return "<span class='wlt_shortcode_distance'>".$II." ".$text_before." ".$rt."
		<i class='fa fa-info-circle wlt_pop_distance_".$post->ID."' 
		style='cursor:pointer;'  
		rel='popover' 
		data-placement='top'
		data-original-title='".$CORE->_e(array('gallerypage','20'))."' 
		data-trigger='hover'></i>
		".$text_after." 
		</span>
			
			
			<div id='wlt_pop_distance_".$post->ID."_content' style='display:none;'>	
		
			<a href='https://www.google.com/maps/dir/".str_replace(",","",str_replace(" ","+",get_post_meta($post->ID,'map_location',true)))."/".$my_lat.",".trim($my_long)."' target='_blank'>".$CORE->_e(array('gallerypage','18'))."</a> <br /> 	
		 
			<a href='".get_home_url()."/?s=&amp;zipcode=".str_replace(" ","%20",$my_zip)."&amp;radius=50&amp;showmap=1&amp;orderby=distance&amp;order=desc'>".$CORE->_e(array('gallerypage','19'))."</a> <br /> 
			
			<a href='#' onclick='GMApMyLocation();' data-toggle='modal' data-target='#MyLocationModal'> ".$CORE->_e(array('widgets','8'))." </a>
		
		</div>
			
			<script>jQuery(document).ready(function(){
		
	 jQuery('.wlt_pop_distance_".$post->ID."').popover({ 
			html: true,
			trigger: 'manual',
			container: jQuery(this).attr('id'),
			placement: 'top',
			content: function () {
				return jQuery('#wlt_pop_distance_".$post->ID."_content').html();
			}
		}).on('mouseover', function(){
		
	   
		}).on('mouseenter', function () {
			var _this = this;
			jQuery(this).popover('show');
			jQuery(this).siblings('.popover').on('mouseleave', function () {
				jQuery(_this).popover('hide');
			});
		}).on('mouseleave', function () {
			var _this = this;
			setTimeout(function () {
				if (!jQuery('.popover:hover').length) {
					jQuery(_this).popover('hide')
				}
			}, 100);
		});
		
		 
	});</script>";
	
	}
		
	}	
	/* =============================================================================
	[ICON] - SHORTCODE
	========================================================================== */
	function wlt_icon($atts, $content = null){  global $userdata, $CORE, $post;
	
	extract( shortcode_atts( array('id' => '', 'fa' => false ), $atts ) );	
		
		if($fa){
		return '<i class="fa fa-'.$id.'"></i>';
		}else{
		return '<i class="glyphicon glyphicon-'.$id.'"></i>';
		}
		
	}
	/* =============================================================================
	[SHOWME] - SHORTCODE
	========================================================================== */
	function wlt_listing_filter($atts, $content = null){  global $userdata, $CORE, $post;
	
	extract( shortcode_atts( array('id' => '' ), $atts ) );	
		
		// GET PACKAGE ID ASSIGNED TO LISTING
		$listing_package = get_post_meta($post->ID,'packageID',true);		

		// GET ALLOWED ID'S
		$allowed_ids 		= explode(",",$atts['id']);
		
		// RETURN DATA
		if(in_array($listing_package,$allowed_ids)){	 
			return $content;
		}else{
		  return "";
		}
	}	
	/* =============================================================================
	[MEMBERSHIP] - SHORTCODE
	========================================================================== */
	function wlt_membership_filter($atts, $content = null){ 
	
	global $userdata, $CORE, $post;
	 
		if($userdata->ID && !isset($GLOBALS['current_membership'])){$GLOBALS['current_membership'] = get_user_meta($userdata->ID,'wlt_membership',true);}
		if($GLOBALS['current_membership'] == ""){ $GLOBALS['current_membership'] = 0; }
		
		extract( shortcode_atts( array('show' => '' ), $atts ) );	
		$allowed_ids 		= array();
		$not_allowed_ids 	= array();
		$allowed_ids 		= explode(",",$atts['id']);
		$not_allowed_ids 	= explode(",",$atts['not']);
			 
		if(in_array($GLOBALS['current_membership'],$allowed_ids)){	 
			return $content;
		}else{
		  
			if(in_array($GLOBALS['current_membership'],$not_allowed_ids)){
			//return $content;
			
			}else{
			$rs = $GLOBALS['CORE_THEME']['membership_restrictedtext'];
			if($rs != ""){$content = '<div class="alert alert-error">'.$rs.'</div>'; }else{ $content = ""; }	
			return $content;
			}
		}	
	}
	/* =============================================================================
	[VIDEO] - SHORTCODE
	========================================================================== */
	function wlt_shortcode_video($atts, $content = null){  global $wpdb, $post, $CORE; 
	
		extract( shortcode_atts( array('link' => '', 'postid' => '', 'limit' => 1 ), $atts ) ); 
		
		if($postid != ""){			
			// FIRST CHECK VIDEO ARRAY 
			return $CORE->UPLOAD_GET($postid,2,array('video',1));		
		}
	 
	 	// CHECK FOR THE BASIC YOUTUBE LINK FIRST		
		if($link != ""){		
			$YOUTUBELINK = $link;
		}else{
			$YOUTUBELINK = get_post_meta($post->ID,'Youtube_link',true);
			if($YOUTUBELINK == ""){
			$YOUTUBELINK = get_post_meta($post->ID,'youtube',true);
			}
		}
		
		if($YOUTUBELINK != ""){	
		$youid = explode("v=",$YOUTUBELINK);
		$thisid = explode("&",$youid[1]);
		return '
		<div class="hidden-sm hidden-xs">
			<video width="640" height="360" id="player1" preload="none" style="width: 100%; height: 100%;" autoplay="true">
				<source type="video/youtube" src="'.$YOUTUBELINK.'" />				 	
			</video>
		</div>
		<div class="visible-sm visible-xs">
				<iframe style="width:100%; height:100%;" src="//www.youtube.com/embed/'.$thisid[0].'" frameborder="0" allowfullscreen></iframe>
		</div>';
		}else{
			// NOW RETURN DEFAULT THEME CONTENTS	
			return $this->UPLOAD_GET($post->ID, 2, array("type" => "video", "limit" => $atts['limit'] ));
		}
	
	}
	 
	/* =============================================================================
		[GOOGLEMAP] - SHORTCODE
		========================================================================== */
	function wlt_google_maps_display($atts, $content = null){  global $wpdb, $post, $CORE; 
	
	extract( shortcode_atts( array('tab' => false, 'init' => true ), $atts ) ); 
	
	//3. IF ITS NOT EMPTY, LETS CHECK THE VALUE IS NOT EMPTY
	if(isset($GLOBALS['CORE_THEME']['google_zoom'])){ $default_zoom = $GLOBALS['CORE_THEME']['google_zoom']; }else{ $default_zoom = 7; }
	if($default_zoom == ""){ $default_zoom = 7; }
	 
	$map_long  = get_post_meta($post->ID,'map-log',true);
	
	if($map_long == ""){ return; }
	$packagefields = get_option("packagefields");
	
	if( get_post_meta($post->ID,'showgooglemap',true) != "yes" && !defined('WLT_DEMOMODE') && count($packagefields) != 0 ){ return; }
	
	$STRING = '<script src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;language='.$GLOBALS['CORE_THEME']['google_lang'].'&amp;region='.$GLOBALS['CORE_THEME']['google_region'].'" type="text/javascript"></script>';
	$STRING .= "<div id='wlt_google_maps_div' style='width:100%;height:250px;'></div>";
	
	$STRING .= '<script type="text/javascript">
	var map = null, marker = null; 
	function initialize() {
	
		var myLatlng = new google.maps.LatLng('.get_post_meta($post->ID,'map-lat',true).','.get_post_meta($post->ID,'map-log',true).');		 
		map = new google.maps.Map(document.getElementById("wlt_google_maps_div"), { zoom:'.$default_zoom.',  center: myLatlng,  mapTypeId: google.maps.MapTypeId.ROADMAP} );
 
		marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			icon: new google.maps.MarkerImage(\''.get_template_directory_uri().'/framework/img/map/icon.png\'),
			draggable: false, 
        	animation: google.maps.Animation.DROP,					 
		});		 
	}	
	</script>'; 
	
	if($init){
	$STRING .= '<script type="text/javascript"> 
		jQuery(document).ready(function () {
			initialize();
		});
		</script>'; 
	
	}
	
	if($tab){
		$STRING .= '<script type="text/javascript"> 
		jQuery(document).ready(function () {
			jQuery(\'#Tabs a\').click(function (e) {
			setTimeout(function(){ initialize(); }, 1000);
			});
		});
		</script>'; 
	}
	 
	return $STRING;
	}
	/* =============================================================================
		[CATEGORY] - SHORTCODE
		========================================================================== */
	function wlt_page_categories( $atts, $content = null ) { global $userdata, $CORE, $post; $STRING = "";
	
		extract( shortcode_atts( array( 'show' => false ,'hide' => false, 'count' => "no" ), $atts ) );
		 
		// build query
		$args = array(
				  'taxonomy'     => THEME_TAXONOMY,
				  'orderby'      => 'name',
				  'show_count'   => 0,
				  'pad_counts'   => $count,
				  'hierarchical' => 0,
				  'title_li'     => '',
				  'include'		 => $show,
				  'exclude'		 => $hide,
				  'hide_empty'   => 0,
				 
		);			
		
		$STRING .= '<div class="shortcode_category_block">';
		
		$categories = get_categories($args);  $nc = 1;
				
		foreach ($categories as $category) { 
				// HIDE PARENT
				if($category->parent != 0){ continue; }
				
				if($nc == 1){ $STRING .= '<div class="row-old">'; }
									
				$STRING .= '<ul class="col-md-4"><li class="head">
							<a href="'.get_term_link($category->slug, THEME_TAXONOMY).'"><span>'.$category->name.'</span></a> ';
							if($count == "yes"){ $STRING .= '('.$category->count.')'; }
					
				// CHECK FOR SUB CATS	
				$s = wp_list_categories("echo=0&taxonomy=".THEME_TAXONOMY."&hide_empty=0&title_li=&child_of=".$category->term_id);				
				if(strlen($s) > 25){
				$STRING .= '<ul class="categorysublist">'.$s.'</ul>';
				}	
				
				$STRING .= '</li></ul>';			
				if($nc == 3){ $STRING .= '</div> <div class="clearfix"></div>'; $nc = 0; }
				$nc++;		
		 
		}			
		if($nc != 1){	$STRING .= '</ul> <div class="clearfix"></div>'; }
				 
		$STRING .= '</div>';
		return $STRING; 
	
	}
	/* =============================================================================
		[TAGS] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_tags( $atts, $content = null ) {
	
			global $userdata, $CORE, $post, $shortcode_tags; $STRING = "";
		
			extract( shortcode_atts( array('text' => ''  ), $atts ) );
	
			$t = wp_get_post_tags($post->ID);
		
			if(is_array($t) && !empty($t) ){
				$STRING .= "<span class='wlt_shortcode_tags'>";
				foreach($t as $tag){				  
					$STRING .= "<a href='".get_term_link($tag->term_id, $tag->taxonomy)."' rel='tag'>".esc_attr($text)."".$tag->name."</a>&nbsp;";
				}
				$STRING .= "</span>";
			}
			// RETURN
			return $STRING;
	}
	/* =============================================================================
		[EXCERPT] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_excerpt($atts, $content = null){ global $wpdb, $wp_query, $CORE, $post;  
	
		extract( shortcode_atts( array( 'size' => 200, 'readmore' => true, 'end' => '', 'striptags' => false ), $atts ) );
		
		// GET excerpt
		if($post->post_excerpt == ""){ $exce = $post->post_content; }else{ $exce = $post->post_excerpt; }
		 
			if(!isset($GLOBALS['flag-single'])){	
				$rd = "...<a href='".get_permalink($post->ID)."' class='readmore'>".$CORE->_e(array('button','40'))."</a>";					
			}else{			
				$rd = "";			
			}
			
			// read more
			if($readmore){ $rd = ""; }	
			
			if($striptags){ 
			return preg_replace( "/\r|\n/", "",strip_tags(substr(preg_replace('/\[gallery[^>]+\]/i', "",$exce), 0, $size))).$rd.$end;	
			}else{
			return "<span class='wlt_shortcode_excerpt' ".$this->ITEMSCOPE("itemprop","description").">".strip_tags(substr(preg_replace('/\[gallery[^>]+\]/i', "",$exce), 0, $size)).$rd.$end."</span>";			
			}		
		
			
		
	}
	/* =============================================================================
		[IMAGEAUTHOR] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_author($atts, $content = null){ global $wpdb,  $wp_query, $CORE, $post;  
	
		extract( shortcode_atts( array( 'size' => '', 'circle' => false), $atts ) );
		
		if($circle){
		return str_replace("avatar ","avatar img-circle ",str_replace('photo"','photo img-circle"',get_avatar($post->post_author,$size)));
		}else{
		return str_replace('photo"','photo img-circle"',get_avatar($post->post_author,$size));
		}		
		
	}	
	/* =============================================================================
		[carousel] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_carousel($atts, $content = null){ global $wpdb,  $wp_query, $CORE, $post; $STRING = "";
	
		extract( shortcode_atts( array( 'postid' => '', 'id' => 1, 'data' => '', 'query' => '', 'perrow' => '3'), $atts ) );
 
		// SINGLE PAGE ONLY
		if(!isset($GLOBALS['flag-single']) && !isset($GLOBALS['flag-home']) ){ return; }

		// SAVE CURRENT POST ID
		$savedPostID = $post->ID;
		
		// UNSET SINGLE TO PREVENT LOOPS
		if(isset($GLOBALS['flag-single'])){ $singleunset = true; unset($GLOBALS['flag-single']); }
		
		// CHECK FOR DATA
		if(isset($data) && is_array($GLOBALS['args_array'])  ){
		$args = $GLOBALS['args_array'];
		}else{
		$args = hook_custom_queries('post_type='.THEME_TAXONOMY.'_type&'.$query);		
		}
		
 		// NOW LETS GET THE DATA FOR THE CAROUSEL ITEMS
 		$the_query = null;
		$the_query = new WP_Query($args); $i=1; $aset = "active"; 				

		if(count($the_query->posts) > 1 ){ //meta_value_num
		
		$STRING .= '<div id="wlt_shortcode_carousel-'.$id.'" class="wlt_carsousel_main_wrapper carousel slide" data-ride="carousel">

		
		  <!-- Wrapper for slides -->
		  <div class="carousel-inner">';
		  
		  	// SETUP PER ROW AMOUNT
			if($perrow == "1"){ $spansize = "col-md-12"; $stopcount = 1;  }
			elseif($perrow == "2"){ $spansize = "col-md-6 col-sm-6"; $stopcount = 2;  }
			elseif($perrow == "3"){ $spansize = "col-md-4 col-sm-4"; $stopcount = 3;  }
			elseif($perrow == "4"){ $spansize = "col-md-3 col-sm-4"; $stopcount = 4;  }
			elseif($perrow == "5"){ $spansize = "col-md-2 col-sm-2"; $stopcount = 5;  }
			elseif($perrow == "6"){ $spansize = "col-md-4 col-sm-4"; $stopcount = 6;  }
			else{ $spansize = "col-md-3 col-sm-3"; $stopcount = 4;  }
			
		  	// LOOP CONTENT
			$i=1;  $aset = "active"; 
		  	foreach($the_query->posts as $post){
				
				if($post->ID == $savedPostID){ continue; }
			 
				if($i == 1){ $STRING .= '<div class="item '.$aset.'"><div class="wlt_search_results row grid_style">'; }			
			
				$STRING .= '<div class="'.$spansize.'">';
				
				ob_start();
				get_template_part( 'content', hook_content_templatename($post->post_type) );
				$STRING .= str_replace("col-sm-6","",ob_get_contents());
				ob_end_clean();
				
				$STRING .= '</div>';	
				
				$set=false;
				if($i == $stopcount){ $STRING .= '</div></div>'; $i=0; $set=true; $aset = ""; }
				$i++; 	
			} // END LOOP
			
			// ADD-ON FINAL DIV
			if(!$set){ $STRING .= '</div></div>'; }
		
		
		// END CAROUSEL INNER
		$STRING .= '</div>';
		
		 $STRING .= '		 
		  <!-- Controls -->
		  <a class="left carousel-control" href="#wlt_shortcode_carousel-'.$id.'" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left"></span>
		  </a>
		  <a class="right carousel-control" href="#wlt_shortcode_carousel-'.$id.'" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right"></span>
		  </a>		  
		</div> ';
		
		// JAVASCRIPT
		$STRING .= "<script>jQuery(document).ready(function() {	jQuery('#wlt_shortcode_carousel-".$id."').carousel({	interval: 7500,		pause: 'hover'	});});</script>";
		
		}// end has posts
		
		// RESET THE QUERY
		wp_reset_postdata(); 
		
		// RESET SINGLE
		if(isset($singleunset)){ $GLOBALS['flag-single'] = true; }	
		
		// RETURN OUTPUT
		return $STRING;
	
	}	
	
	/* =============================================================================
		[RELATED] - SHORTCODE
		========================================================================== */
function wlt_shortcode_related($atts, $content = null){ global $wpdb,  $wp_query, $CORE, $post; $STRING = ""; $OUTTERSTRING = ""; $regfields = get_option("submissionfields"); $STROED_POST_ID = $post->ID;

	// SINGLE PAGE ONLY
	if(!isset($GLOBALS['flag-single'])){ return; }
	
	extract( shortcode_atts( array( 'box' => false, 'postid' => '', 'carousel' => false, 'view' => $GLOBALS['CORE_THEME']['display']['default_gallery_style']), $atts ) );

	// CHECK WHICH POST ID TO USE
	if($postid != "" && is_numeric($postid)){ $ThisPID = $postid; }else{ $ThisPID = $post->ID; }
 	
	// GETS TERMS
	$terms = wp_get_post_terms( $ThisPID, THEME_TAXONOMY, array("fields" => "slugs"));
 
	// GET RELATED PER PAGE AMOUNT
	$RELATED_PER_PAGE = $GLOBALS['CORE_THEME']['related_perpage'];
	if($RELATED_PER_PAGE == ""){ $RELATED_PER_PAGE = 9; }
	
	// CHECK FOR RELATED ARRAY
	$selected_related_products = get_post_meta($ThisPID,"related",true);
	
	// CHECK RELATED FOR CART
	if(defined('WLT_CART') && is_array($selected_related_products) && !empty($selected_related_products)){
	 
		$args = array( 'post_type' => THEME_TAXONOMY.'_type', 'posts_per_page' => $RELATED_PER_PAGE, 'orderby' => 'rand', 'post__in' => $selected_related_products );	
 		
	// GET THE CURRENT CATEGORY	
	}elseif(defined('WLT_COUPON')){	
		$categories = get_the_terms($postID, 'store');
		if(is_array($categories)){
			foreach($categories as $key=>$val){
			$term_name = $val->slug;
			}
		}
		if($term_name != ""){
		$args = array('post_type' => THEME_TAXONOMY.'_type', 'taxonomy' => 'store', 'term' => $term_name, 'showposts' => $RELATED_PER_PAGE ); 
		}else{
		$args = array( 'post_type' => THEME_TAXONOMY.'_type', 'posts_per_page' => $RELATED_PER_PAGE, 'orderby' => 'rand' );
		}	
	// CHECK RELATED FOR EVERYTHING ELSE
	}else{
		$args = array( 'post_type' => THEME_TAXONOMY.'_type', 'posts_per_page' => $RELATED_PER_PAGE, 'orderby' => 'rand', 'tax_query' => array(
			array(
				'taxonomy' => THEME_TAXONOMY,
				'field' => 'slug',
				'terms' => $terms[0],
			)
		) );	
	}
  
	// CHECK FOR CAROUSEL
	if($carousel){
	$GLOBALS['args_array'] = $args;
	return do_shortcode('[CAROUSEL data='.$args.']');
	}
 	
	// ADD MAIN WRAPPER
	$OUTTERSTRING .= '<div class="wlt_shortcode_related">';
	
	// BUIULD STRING
	if($box){
	$OUTTERSTRING .= '<div class="row show-grid"><div class="block"><div class="block-title"><h3><span>'.$CORE->_e(array('single','0')).'</span></h3></div><div class="block-content">'; 
	}	
 	
	// DEFAULTS
	unset($GLOBALS['flag-single']);
	
	// RUN QUERY
	$q = query_posts($args);
 
	if($view == "grid"){ $lt= "grid_style";  }else{ $lt= "list_style"; } 
 		
		
		$OUTTERSTRING .='<div class="wlt_search_results row '.$lt.'">%HERE%';
		$i=1;
		if ( have_posts() ) : while ( have_posts() ) : the_post();  if($ThisPID == $post->ID){ continue; }
		
		
		ob_start();
		get_template_part( 'content', hook_content_templatename($post->post_type) );
		$STRING .= ob_get_contents();
		ob_end_clean();
		
		$i++;
		endwhile; endif; wp_reset_query(); 
		// MORE OUTTER STRING
		$OUTTERSTRING .='</div>';
		
		if($box){
		$OUTTERSTRING .='<div class="clearfix"></div></div></div></div>';
		}
 
	
	// RESET SINGLE FLAG
	$GLOBALS['flag-single'] = 1;
	
	if($STRING == ""){ return; }	
	
	$STRING .='<script language="javascript">        
				 
				
				jQuery(window).resize(function(){
				  setTimeout(function(){equalheight(\'.wlt_shortcode_related .wlt_search_results .itemdata .thumbnail\');  },2000);
				}); 
				
			</script>';	
			
	// CLOSE MAIN WRAPPER
	$OUTTERSTRING .= '</div><div class="clearfix"></div>';
		
	
	return  str_replace("%HERE%",$STRING,$OUTTERSTRING);
	//}
}
	
	/* =============================================================================
		[LISTINGS] - SHORTCODE
		========================================================================== */
function wlt_page_listings( $atts, $content = null ) {

	global $userdata, $wpdb, $CORE; $STRING = ""; $extra=""; $i=1; $stopcount = 4;

	extract( shortcode_atts( array( 'query' => '', 'show' => '', 'type' => '',  'cat' => '', 'orderby' => '', 'order' => '', 'grid' => "no", 'featuredonly' => "no"), $atts ) );
 
   // SETUP DEFAULTS
   if(!isset($atts['show']) || (isset($atts['show']) && $atts['show'] == "") ){ 	$atts['show'] = 5; }
   if($atts['type'] == ""){ 	$atts['type'] = THEME_TAXONOMY.'_type'; }
   if($atts['orderby'] == ""){ 	$atts['orderby'] = "post_title"; }
   if($atts['order'] == ""){ 	$atts['order'] = "desc"; }
   
   // DEFAULT FOR LIST STYLE
   if($grid == "yes"){ 
		$sstyle = "grid_style";  
		$STRING .= '<script language="javascript">jQuery(window).load(function() { equalheight(\'.grid_style .itemdata .thumbnail\');});</script>';	
   }else{ 
		$sstyle = "list_style";
   } 
   
   $query= str_replace("#038;","&",$query);
  	
   if(strlen($query) > 1){
		// ADD ON POST TYPE FOR THOSE WHO FORGET
		if(strpos($query,'post_type') == false){
		$args = $query ."&post_type=".THEME_TAXONOMY."_type";
		}else{
		$args = $query;
		}
		
	}elseif($featuredonly == "yes"){ 
	$args = array('posts_per_page' => $atts['show'], 
	'post_type' => $atts['type'], 'orderby' => $atts['orderby'], 'order' => $atts['order'],
	'meta_query' => array (
		    array (
			  'key' => 'featured',
			  'value' => 'yes',
		    )
		  ) 
	 );
	
	}else{
	/*** default string ***/
	$args = array('posts_per_page' => $atts['show'], 'post_type' => $atts['type'], 'orderby' => $atts['orderby'], 'order' => $atts['order'] );
	}
	
	/*** custom category ***/
	if(strlen($atts['cat']) > 1){ 	
	$args = array('tax_query' => array( array( 'taxonomy' => str_replace("_type","",$atts['type']) ,'field' => 'term_id','terms' => array( $atts['cat'] ))), 'posts_per_page' => $atts['show'] );
	} 
 
	// BUILD QUERY
	$the_query = new WP_Query( hook_custom_queries($args) );
 
	 if ( $the_query->have_posts() ) {
	
		$STRING .= '<div class="_searchresultsdata"><div class="wlt_search_results row '.$sstyle.'">'; 
	
		while ( $the_query->have_posts() ) {  $the_query->the_post();  $post = get_post();
		
		ob_start();
		get_template_part( 'content', hook_content_templatename($post->post_type) );
		$STRING .= ob_get_contents();
		ob_end_clean();
 		 				
		}
		
		$STRING .= '</div></div><div class="clearfix"></div>'; 
	
	} 
	// END QUERY
	wp_reset_postdata();
	
	return $STRING; 	
	
}
	/* =============================================================================
		[MEMBERS] - SHORTCODE
		========================================================================== */
function wlt_page_members( $atts, $content = null ) {

	global $userdata, $wpdb, $CORE, $post; $STRING = "";  $default_options = 'show|hide';

	extract( shortcode_atts( array( 'show' => 5, 'showuid' => "" ,'hideuid' => ""  ), $atts ) );
	
	$user_show = explode(",",$atts['showuid']);
	$user_hide = explode(",",$atts['hideuid']);

	$wp_user_search = $wpdb->get_results("SELECT ID FROM ".$wpdb->prefix."users ORDER BY ID");
    foreach ( $wp_user_search as $userid ) {
	
		if(is_array($user_show) && !empty($user_show[0]) && !in_array($userid->ID,$user_show)){ continue; }
	 	if(is_array($user_hide) && !empty($user_hide[0]) && in_array($userid->ID,$user_hide)){ continue; }
	 
        $user 	= new WP_User($userid->ID);	
        $ADD = explode("**",$user->jabber);		
        $r = $user->roles;
        $r = array_shift($r);
		//".get_author_posts_url( $user->post_author, $user->user_nicename )."
		
		$STRING .= "<div class='thumbnail wlt_user'>
		<div class='col-md-3'>".get_avatar($user->ID)."</div>
		<div class='col-md-7'>
		<h4>".$user->display_name."</h4><p>".stripslashes($user->description)."</p>
		<p><a href='".home_url()."/?s=".$userid->ID."' class='wlt_user_link'>".$CORE->_e(array('account','15'))."</a></p>
		</div>
		<div class='clearfix'></div>
		</div><br />";
		
	}
	
	return $STRING;

}
	/* =============================================================================
		[TAXONOMIES] - SHORTCODE
		========================================================================== */
function wlt_page_taxonomy( $atts, $content = null ) {

	global $userdata, $CORE, $post; $STRING = "";  $default_options = 'show|hide';

	extract( shortcode_atts( array( 'show' => "" ,'hide' => "", 'name' => "", 'count' => "yes", 'icon' => "yes", "limit" => 500, 'perrow' => '3' ), $atts ) );
	 
 	// build query
	$args = array(
			  'taxonomy'     => $atts['name'],
			  'orderby'      => 'count',
			  'order' 		 => 'desc',
			  'show_count'   => 0,
			  'pad_counts'   => $atts['count'],
			  'hierarchical' => 0,
			  'title_li'     => '',
			  'include'		 => $atts['show'],
			  'exclude'		 => $atts['hide'],
			  'hide_empty'   => 0,
			 
	);			
	
	$STRING .= '<div class="shortcode_taxonomy_block">';
	
	// SWITCH PER ROW
	switch($perrow){
		case "3": {
		$class = "col-md-4 col-sm-4"; $sotpc = 3;
		} break;
		case "6": {
		$class = "col-md-2 col-sm-4"; $sotpc = 6;
		} break;
		default: {
		$class = "col-md-3 col-sm-6"; $sotpc = 4;
		} break;
	}
	
	
	$categories = get_categories($args);  $nc = 1; $counter = 0;
	if(isset($categories['errors']['invalid_taxonomy'])){ return "Invalid taxonomy"; }
  	foreach ($categories as $category) {
	if($counter >= $limit){ continue; }
	 
	
 	
		// CHECK FOR ICON
		if(isset($category->term_id) && isset($GLOBALS['CORE_THEME']['category_icon_'.$category->term_id]) && $atts['icon'] == "yes" ){
		$merchant_logo = $GLOBALS['CORE_THEME']['category_icon_'.$category->term_id];
		$img = "<img src='".$merchant_logo."' alt='merchant' class='wlt_thumbnail storelogo' /><br />";
		}else{
		$img = "";
		}
	 					 
		$STRING .= '<div class="'.$class.'">
					<a href="'.get_term_link($category->slug, $atts['name']).'">'.$img.'<span class="tname">'.$category->name.'</span></a> ';
					
					if($atts['count'] == "yes"){ $STRING .= '('.$category->count.')'; }
			
		$STRING .= '</div>';			
		 
		$nc++;		
	$counter++; 
  	}			
 
			 
	$STRING .= '</div><div class="clearfix"></div>';
	return $STRING; 

}
	
	/* =============================================================================
		[MSG] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_msg(){ global $userdata, $CORE, $post; $STRING = ""; 
	
		// EXTRACT OPTIONS
		extract( shortcode_atts( array(), $atts ) );
 		// ONLY SHOW IF ENABLED
		if($GLOBALS['CORE_THEME']['message_system'] == '1'){ 
		
			$userid = $post->post_author; 
			$user_info = get_userdata($userid); 
			$phone = get_the_author_meta( 'aim', $userid);
		
			$STRING .= "<a href='".$GLOBALS['CORE_THEME']['links']['myaccount'].'?u='.$user_info->data->user_login."&tab=msg&show=1'>Send Message</a>";
			
		}else{		
				$STRING = "";
		}
		
		// RETURN CODE
		return $STRING; 
	}		
	/* =============================================================================
		[FAVS] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_favs(){ global $userdata, $CORE, $post; $STRING = ""; 
 
 		// ONLY SHOW IF ENABLED
		if($GLOBALS['CORE_THEME']['show_account_favs'] == '1'){ 
		
				$show_add = true;
				$ThisLink = home_url().'/wp-login.php?action=login&redirect_to='.get_permalink($post->ID);
				//*** check if this listing is already in their favs list so we can display remove favs **/
				if($userdata->ID){
						$ThisLink = "javascript:void(0);";
						$my_list = get_user_meta($userdata->ID, 'favorite_list',true);
						if(is_array($my_list) && in_array($post->ID, $my_list) ){
							$show_add = false;
						}
				}						
				 
						
				if($show_add){
				
					$STRING .= '<a class="list_favorites_add" href="'.$ThisLink.'"';
					if($userdata->ID){
					$STRING .= 'onclick="WLTAddF(\''.str_replace("http://","",get_home_url()).'\', \'favorite\', '.$post->ID.', \'core_ajax_callback\');"';
					}
					$STRING .= '><span>'.$CORE->_e(array('button','32')).'</span></a>'; 
				
				}else{
				
					$STRING .= '<a class="list_favorites_remove" href="'.$ThisLink.'"';
					if($userdata->ID){
					$STRING .= 'onclick="WLTAddF(\''.str_replace("http://","",get_home_url()).'\', \'favorite\', '.$post->ID.', \'core_ajax_callback\');"';
					}
					$STRING .= '><span>'.$CORE->_e(array('button','33')).'</span></a>';				
				} 
			
		}else{		
				$STRING = "";
		}
		
		// RETURN CODE
		return $STRING; 
	}	
	/* =============================================================================
		[BTNBAR] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_btnbar(){ global $userdata, $CORE, $post; $STRING = ""; 
	
		// EXTRACT OPTIONS
		extract( shortcode_atts( array('hits' => 1), $atts ) );
		
		// WRAPPER
		$STRING = "<div class='wlt_shortcode_btnbar'>";
 
		$STRING .= str_replace("col-xs-12","",do_shortcode('[CONTACT style=1]'));
		
		$STRING .= str_replace("list_favorites_remove","list_favorites_remove btn btn-danger",str_replace("list_favorites_add","list_favorites_add btn btn-danger",do_shortcode('[FAVS]')))." ";
		 
			$pl = get_permalink($post->ID);		 
			if(substr($pl,-1) != "/"){ $print_link = $pl."&print=true&amp;pid=".$post->ID; }else{ $print_link = $pl."/?print=true&amp;pid=".$post->ID; }
		
		
		$STRING .= '<a class="btn btn-danger"  href="'.$print_link.'" rel="nofollow" target="_blank"><i class="glyphicon glyphicon-print"></i> '.$CORE->_e(array('button','23')).'</a>';
		
		
		// ADD THIS // SHARE
		if($GLOBALS['CORE_THEME']['addthis'] != "0"){
		$STRING .= '<a class="btn btn-danger addthis_button_compact"  href="javascript:void(0);" rel="nofollow" target="_blank"><i class="fa fa-share-square"></i> '.$CORE->_e(array('button','15')).' </a>' ;
		$STRING .= '<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid='.$GLOBALS['CORE_THEME']['addthis_name'].'"></script>';
		}
		
		// CONTACT FORM // REPORT LINK
		if(isset($GLOBALS['CORE_THEME']['links']['contact']) && $GLOBALS['CORE_THEME']['links']['contact'] != ""){
		
		$STRING .= '<a class="btn btn-danger"  href="'.$GLOBALS['CORE_THEME']['links']['contact'].'?report='.$post->ID.'" rel="nofollow" target="_blank"><i class="fa fa-exclamation-circle"></i> '.$CORE->_e(array('button','53')).'  </a>';
		
		}
		
		// HITS
		if($hits == 1){
		$v = get_post_meta($post->ID,'hits',true);
		$STRING .= '<span class="right hitsbit hidden-xs"><i class="fa fa-signal"></i> '.number_format($v,0).' '.$CORE->_e(array('single','19')).'</span> ';
		}
		
		$STRING .= '</div>';
		
		return $STRING;	
		
	}	
	/* =============================================================================
		[COMMENTS] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_comments($atts, $content = null){ global $userdata, $CORE, $post; $STRING = "";  $comment_string = ""; 
	
		// EXTRACT OPTIONS
		extract( shortcode_atts( array('box' => false, 'tab' => 1), $atts ) );
		
		if(!isset($atts['tab'])){ $atts['tab'] = true; }
		
		if($post->comment_status != "open"){ return; }
		 
	   
		if($box){
			// BUILD COMMENT BLOCK
			$commentdata = $CORE->get_comment_form($post->ID);
			if($commentdata == false){ return; }
			$STRING = '<!-- START COMMENT BLOCK --><div class="panel panel-default" id="wlt_comments_block">		 
			 <div class="panel-heading">'.$CORE->_e(array('comment','11')).'</div>		 
			 <div class="panel-body">'.$commentdata.'
			 
			 
			 '.hook_shortcode_comments('').'
			  
			 
			 </div></div>
			 <!-- END COMMENT BLOCK -->';
				
		}else{
		// BUILD COMMENT BLOCK
		$STRING = '<!-- START COMMENT BLOCK --><div class="clearfix"></div>'.$CORE->get_comment_form($post->ID, $atts['tab']).hook_shortcode_comments('').'<!-- END COMMENT BLOCK -->';
		}
		
		return $STRING;
	}
	/* =============================================================================
		[IMAGES] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_images( $atts, $content = null){ global $post, $wpdb, $CORE; $STRING = ""; $extras = "";
		
		// EXTRACT OPTIONS
		extract( shortcode_atts( array('style' => "0", 'type' => 'allbutmusic'), $atts ) );
		
		$pid = $post->ID;
		
		// FIX FOR PRINT PAGE IMAGES
		if(isset($_GET['pid']) && isset($_GET['print'])){ $pid = $_GET['pid']; }
	 	
		// EXTRA FOR DEFAULT GALLERY
		if(!isset($GLOBALS['wordpress_default_gallery_ids'])){ $GLOBALS['wordpress_default_gallery_ids'] = array(); }
 		
		 // LOAD DEFAULT FLEX SLIDER
		$STRING =  hook_single_images($CORE->SINGLE_IMAGES( $pid, $GLOBALS['wordpress_default_gallery_ids'],false, false, $type));		
		
		// RETURN STRING	
		return $STRING.$extras;
	} 
	/* =============================================================================
		[CONTACT] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_contact( $atts, $content = null){ global $userdata, $post, $CORE; $STRING = "";
	
		// EXTRACT OPTIONS
		extract( shortcode_atts( array('style' => "0", 'button' => "0", "class" => "btn  btn-primary" ), $atts ) );
		 
		if($button == 1){ $style = 1; }
		
		// SWITCH STYLE
		switch($style){
		
			case "0": {
			
			$STRING  = $this->SHOW_CONTACTFORM(3);
			
			} break;
		
			case "1": {
			
			$STRING .= "<a href='#wlt_shortcode_contactmodal_".$post->ID."' role='button' data-toggle='modal' class='".$class."  wlt_shortcode_contact_button'>".$CORE->_e(array('single','1'))."</a>";
			
			$STRING .= '<!-- CONTACT FORM MODAL -->
			<div id="wlt_shortcode_contactmodal_'.$post->ID.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="wlt_shortcode_contactmodalLabel_'.$post->ID.'" aria-hidden="true">
			  <div class="modal-dialog"><div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h4 id="myModalLabel">'.$CORE->_e(array('single','1')).'</h4>
			  </div>
			  <form action="#" method="post" id="ContactForm" onsubmit="return CheckFormData();">
			  <div class="modal-body">'.$this->SHOW_CONTACTFORM(1).'</div>
			  <div class="modal-footer">
			  <button type="submit" class="btn btn-primary" style="float:none;">'.$CORE->_e(array('single','7')).'</button>
			  <button class="btn" data-dismiss="modal" aria-hidden="true">'.$CORE->_e(array('single','14')).'</button>
			  </div>
			  </form>
			  </div></div></div>
			<!-- END CONTACT FORM MODAL	 -->';			
			
			} break; // END STYLE 1
			
			case "2": {
			 
			$STRING  = $this->SHOW_CONTACTFORM(2);
			
			} break;
		
			default: { $STRING = $this->SHOW_CONTACTFORM(); } break;
		}// end switch
		
		return $STRING;
		
	} 	
function SHOW_CONTACTFORM($style=0){ global $CORE, $post; $STRING = ""; $rn1 = rand("0", "9"); $rn2 = rand("0", "9");	

	// POST VALUES AND BASIC VALIDATION
	 
	if(isset($_POST['contact_n1'])){
	$val1 = esc_attr($_POST['contact_n1']); 
	$val2 = esc_attr($_POST['contact_e1']); 
	$val3 = esc_attr($_POST['contact_p1']); 
	$val4 = esc_attr($_POST['contact_m1']); 
	}else{
	$val1= "";
	$val2= "";
	$val3= "";
	$val4= "";
	}
	

	
	// BUILD CORE FIELD FIELDS
	$formField = '<table class="table table-bordered table-striped">
           
            <tbody>
			
              <tr>
			  <td>'.$CORE->_e(array('single','2')).' <span class="required">*</span></td>
              <td><input class="col-md-12 form-control" type="text" name="contact_n1" id="name" value="'.$val1.'"></td>
              </tr>
			  
              <tr>
			  <td>'.$CORE->_e(array('single','3')).' <span class="required">*</span></td>
              <td><input class="col-md-12 form-control" type="text" name="contact_e1" id="email1" value="'.$val2.'"></td>
              </tr>
			  
              <tr>
			  <td>'.$CORE->_e(array('single','4')).'</td>
              <td><input class="col-md-12 form-control" name="contact_p1" value="'.$val3.'" type="text"></td>
              </tr> 
			  
              <tr>
			  <td>'.$CORE->_e(array('single','6')).' <span class="required">*</span></td>
              <td><textarea class="col-md-12 form-control" name="contact_m1" id="message">'.$val4.'</textarea></td>
              </tr>
			  
			   <tr>
			  <td>'.$CORE->_e(array('single','5')).' <span class="required">*</span></td>
              <td><input class="col-md-6 form-control" type="text" id="code" name="contact_code" placeholder="'.$rn1." + ".$rn2.'"></td>
              </tr>			  
               
            </tbody>
          </table>';
		  
	$formField2 = '<form action="#" method="post" id="ContactForm2" onsubmit="return CheckFormData();" class="well" role="form">
			<input type="hidden" name="code_value" value="'.($rn1+$rn2).'" />
			<input type="hidden" name="action" value="contactform" />
			<input type="hidden" name="pid" value="'.$post->ID.'" /> 
			
			<h3>'.$CORE->_e(array('single','1')).' <small class="pull-right">'.$CORE->_e(array('single','49')).'</small> </h3>
			<hr />
			<div class="row">
            <div class="col-md-6">
			
				<div class="form-group">
                <label>'.$CORE->_e(array('single','2')).' <span class="required">*</span></label> 
                <input class="col-md-12 form-control" type="text" name="contact_n1" id="name" value="'.$val1.'">
				<div class="clearfix"></div>
				</div>
                
				<div class="form-group">
                <label>'.$CORE->_e(array('single','3')).' <span class="required">*</span></label>
                <input class="col-md-12 form-control" type="text" name="contact_e1" id="email1" value="'.$val2.'">
				<div class="clearfix"></div>
                </div>
				
				<div class="form-group">
                <label>'.$CORE->_e(array('single','4')).'</label>
				<input class="col-md-12 form-control" name="contact_p1" value="'.$val3.'" type="text">
				<div class="clearfix"></div>
				</div>
                
                <div class="form-group">
                <label>'.$CORE->_e(array('single','5')).' <span class="required">*</span></label>
				<input class="col-md-6 form-control" type="text" id="code" name="contact_code" placeholder="'.$rn1." + ".$rn2.'">
				<div class="clearfix"></div>
				</div>
				
    		</div>
            <div class="col-md-6">
                <label>'.$CORE->_e(array('single','6')).' <span class="required">*</span></label> 
                <textarea class="col-md-12 form-control" name="contact_m1" id="message" rows=10>'.$val4.'</textarea>
            </div>
			</div>           
			 
            <button class="btn btn-primary pull-right active" style="margin-top:10px; margin-right:10px;" type= "submit">'.$CORE->_e(array('single','7')).'</button>
			
	   <div class="clearfix"></div>
	</form>';
	
	

	
	$formField3 = '<form action="#" method="post" id="ContactForm2" onsubmit="return CheckFormData();" class="contact" role="form">
			<input type="hidden" name="code_value" value="'.($rn1+$rn2).'" />
			<input type="hidden" name="action" value="contactform" />
			<input type="hidden" name="pid" value="'.$post->ID.'" /> 
			
	 <h4>'.$CORE->_e(array('widgets','30')).'</h4>
			 
	 <ul>
			
			<li> <input type="text" name="contact_n1" id="name" value="'.$val1.'" placeholder="'.$CORE->_e(array('single','2')).'"></li>
            <li><input  type="text" name="contact_e1" id="email1" value="'.$val2.'" placeholder="'.$CORE->_e(array('single','3')).'"></li>
			<li><input  name="contact_p1" value="'.$val3.'" type="text" placeholder="'.$CORE->_e(array('single','4')).'"></li>
			<li><input type="text" id="code" name="contact_code" placeholder="'.$CORE->_e(array('single','5')).' '.$rn1." + ".$rn2.'"></li>			 
            <li><textarea name="contact_m1" id="message" rows=5 placeholder="'.$CORE->_e(array('single','6')).' ">'.$val4.'</textarea></li>		      
            <li><button class="btn btn-warning btn-lg"  type= "submit">'.$CORE->_e(array('single','7')).'</button></li>
			
	  </ul>
	  
	  
	</form>';
	
	// MSG SENT
	if(isset($GLOBALS['contactformsent'])){
		$formField1 = '<h4 class="text-center">'.$CORE->_e(array('single','8')).'</h4>';
		$formField2 = '<h4 class="text-center">'.$CORE->_e(array('single','8')).'</h4>';
		$formField3 = '<h4 class="text-center">'.$CORE->_e(array('single','8')).'</h4>';
	}
	
	
	// SWITCH DISPLAY STYLE
	switch($style){
	
		case "0": {
		
		$STRING = $formField3;
		
		} break;
	
		case "1": {
		
		$STRING = '		
		<input type="hidden" name="code_value" value="'.($rn1+$rn2).'" />
		<input type="hidden" name="action" value="contactform" />
		<input type="hidden" name="pid" value="'.$post->ID.'" /> 
		'.$formField.'';
		
		} break;
		
		case "2": {
		
		$STRING = $formField2;
		
		} break; 
	
		default: {
		
		$STRING = '			 
			<form action="#" method="post" id="ContactForm" onsubmit="return CheckFormData();">
			<input type="hidden" name="code_value" value="'.($rn1+$rn2).'" />
			<input type="hidden" name="action" value="contactform" />
			<input type="hidden" name="pid" value="'.$post->ID.'" /> 
			'.$formField.'
			<hr />
			<button type="submit" class="btn btn-primary" style="float:none;">'.$CORE->_e(array('single','7')).'</button></form>';
		
		} break;
	}
	
 

		
		$STRING .= '<script type="text/javascript">
		function CheckFormData(){
		var name 	= document.getElementById("name"); 
		var email1 	= document.getElementById("email1");
		var code 	= document.getElementById("code");
		var message = document.getElementById("message");	 
		
		if(name.value == \'\')
		{
			alert(\''.$CORE->_e(array('validate','0')).'\');
			name.focus();
			name.style.border = \'thin solid red\';
			return false;
		}
		
		if(email1.value == \'\')
		{
			alert(\''.$CORE->_e(array('validate','3')).'\');
			email1.focus();
			email1.style.border = \'thin solid red\';
			return false;
		}	
		
		if( !isValidEmail( email1.value ) ) {	
		
			alert(\''.$CORE->_e(array('validate','23')).'\');
			email1.focus();
			email1.style.border = \'thin solid red\';
			return false;
		}	
		
		if(code.value == \'\')
		{
			alert(\''.$CORE->_e(array('validate','0')).'\');
			code.focus();
			code.style.border = \'thin solid red\';
			return false;
		}
		
		if(code.value != '.($rn1 + $rn2).')
		{
			alert(\''.$CORE->_e(array('single','9')).'\');
			code.focus();
			code.style.border = \'thin solid red\';
			return false;
		} 
		
		if(message.value == \'\')
		{
			alert(\''.$CORE->_e(array('validate','0')).'\');
			message.focus();
			message.style.border = \'thin solid red\';
			return false;
		} 
		
		return true;
		} 
		</script>';
        
        return $STRING;
}
	/* =============================================================================
		[USERID] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_userid( $atts, $content = null){ global $userdata;
	
		if($userdata->ID){ return $userdata->ID; }else{ return 0; }
	} 
	/* =============================================================================
		[URL] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_url( $atts, $content = null ) {
	
		global $userdata, $CORE, $post, $shortcode_tags; $STRING = ""; 
		extract( shortcode_atts( array('key' => "url", 'newwindow' => false), $atts ) );	
		
		$url = get_post_meta($post->ID,$key,true);
		 
		if(strlen($url) > 1){
			if(strpos($url,"http") === false){ $url1 = "http://".$url; }else{ $url1 = $url; }
			
			if($newwindow){ $ex = " target='_blank'"; }else{  $ex = ""; } 
			
			$STRING = "<a href='".$url1."'". $ex." rel='nofollow'>".$url."</a>";
		}
		return $STRING;
	
	}
	/* =============================================================================
		[TIMELEFT] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_timeleft( $atts, $content = null ) {
	
		global $wpdb, $userdata, $CORE, $post, $shortcode_tags; $STRING = ""; 
		
		extract( shortcode_atts( array('postid' => "", "layout" => "", "text_before" => "", "text_ended" => "", "key" => "listing_expiry_date" ), $atts ) );
		
		// SETUP ID FOR CUSTOM DISPLAY	
		$milliseconds = str_replace("+","",round(microtime(true) * 100));
		$milliseconds .= rand( 0, 10000 );
		
		// CHECK FOR CUSTOM POST ID
		if($postid == ""){ $postid = $post->ID; }
		
		// GET VALUE FROM LISTING
		$expiry_date = get_post_meta($postid,$key,true);
		if($expiry_date == ""){
			$expiry_date = $wpdb->get_var( "SELECT meta_value FROM $wpdb->postmeta WHERE post_id =('".$postid."') AND meta_key=('".$key."') LIMIT 1" );
		}
		
		if($expiry_date == "" || strlen($expiry_date) < 3){ 		 
			return hook_shortcode_timeleft_ended("<span class='nds'>".$text_ended."</span>"); 
		}
		
		// SWITCH LAYOUTS
		switch($layout){
		case "1": { $layout_code = ",layout: '".$text_before." {sn} {sl}, {mn} {ml}, {hn} {hl}, and {dn} {dl}',"; } break;
		case "2": { $layout_code = ",compact: true, "; } break;
		
		
		default: { $layout_code = ""; } break;
		} 
		if(strlen($expiry_date) == 10){ $expiry_date = $expiry_date." 00:00:00"; }
		
		// REFRESH PAGE EXTR
		$run_extra =  "";
		if(isset($GLOBALS['flag-single'])){ $run_extra = "location.reload();"; }
		
		return "<span id='timeleft_".$postid.$milliseconds."'></span>
			<script>
			
			jQuery(document).ready(function() {		
			var dateStr ='".$expiry_date."'
			var a=dateStr.split(' ');
			var d=a[0].split('-');
			var t=a[1].split(':');
			var date1 = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);			 
			jQuery('#timeleft_".$postid.$milliseconds."').countdown({until: date1, onExpiry: WLTvalidateexpiry".$postid.", timezone: ".get_option('gmt_offset')."".$layout_code." });
			});
			
			function WLTvalidateexpiry".$postid."(){ CoreDo('".get_home_url()."/?core_aj=1&action=validateexpiry&pid=".$postid."', 'timeleft_".$postid.$milliseconds."'); ".$run_extra." }
			
			</script>";	
	}	
	/* =============================================================================
		[FIELDS] - SHORTCODE
		========================================================================== */	
	function wlt_shortcode_fields( $atts, $content = null ) {
	
		global $userdata, $CORE, $post; $STRING = "";  $default_options = 'default|address|category|tags'; if(defined('WLT_COUPON')){ $default_options = 'default|category|tax_store'; }
	
	   extract( shortcode_atts( array(
		  'show' => $default_options,	
		  'hide' => "", 
		  'postid' => '',
		  'smalllist' => false,
		  'title' => false
		  ), $atts ) );
		  
		 // CHECK FOR THE LISTING PACKAGE ID
		 $packageID = get_post_meta($post->ID, 'packageID',true);
		 
		
		// INCLUDE TITLE
		if($title){
		$STRING .= '<div class="block"><div class="block-title"><h3>'.$CORE->_e(array('single','16')).'</h3></div><div class="block-content">';
		}
		
		// START MAIN FIELDS TABLE
		if($smalllist == 1){
		$show = str_replace("|category|tags","",$show);
		$STRING .= '<table class="table table-condensed small" id="TableCustomFieldsSmall">';
		}else{
		$STRING .= '<table class="table table-bordered" id="TableCustomFieldsBig">';
		}
 		
		// BUILD OPTIONS
		$options = explode("|",esc_attr($show));
		$hide_options = explode("|",esc_attr($hide));
		
		
		$STRING .= '<tbody>';
		
		if(is_numeric($postid) && strlen($postid) > 0){ $THISPOSTID = $postid; }else{ $THISPOSTID = $post->ID; }
		
		// LOOP AND GET THE DATA
		foreach($options as $option){
		
		$explode_custom_titles = explode("=",$option);
		
			switch($explode_custom_titles[0]){
			
				case "default": { 
				
					// TWO TYPES OF FIELDS, DEFAULT LISTING FIELDS
					// AND CUSTOM WP FIELDS
					$regfields = get_option("submissionfields"); $i=0;
				 
					if(is_array($regfields)){
					 
						//PUT IN CORRECT ORDER
						$regfields = $this->multisort( $regfields , array('order') );
						
						// LOOP
						foreach($regfields as $field){ 
						 
						 
						// CHECK IF THIS IS A HIDDEN FIELD
						if(isset($field['hideme']) && $field['hideme'] == "yes"){ continue; }
						 
						// HIDE IF NOT IN SMALL LIST
						if($smalllist == 1 && isset($field['smalllist']) && $field['smalllist'] != "yes"){ continue; }
						
						// CHECK FOR HIDDEN KEYS
						if(in_array($field['key'], $hide_options) ){ continue; }
						
						// CHECK IF FIELD IS WITHIN USERS PACKAGE ID
						if(is_numeric($packageID) && is_array($field['package']) && !in_array($packageID, $field['package']) ){ continue; }			
					 
					 
						// CHECK FOR YOUTUBE LINK
						if($field['key'] == "youtube"){
						
							$v_check = get_post_meta($THISPOSTID, $field['key'], true);	
							$yb = explode("v=",$v_check);
							 
							if(isset($yb[1])){
								$yf = explode("&",$yb[1]);					
								$STRING .= '<div class="youtubebox"><iframe width="480" height="360" src="//www.youtube.com/embed/'.$yf[0].'" frameborder="0" allowfullscreen></iframe></div>';
							}
							continue;
						
						// GET VALUE FOR THIS FIELD					
						}elseif($field['fieldtype'] == "title" && !isset($GLOBALS['flag-single']) ){
							$STRING .= '<div class="fieldtitlebox"><span>'.$field['name'].'</span></div>';
							
							continue;
						
						}elseif($field['fieldtype'] == "taxonomy"){					
							$value = get_the_terms( $THISPOSTID, $field['taxonomy'] );
						
						}else{
							$v_check = get_post_meta($THISPOSTID, $field['key'], true);						 
							// CHECK IF ITS BLANK
							if($v_check == ""){ continue; }
								
								// CHECK FOR EMAIL
							
							if(!is_array($v_check) && strpos($v_check,"@") !== false){								
								$v_check = "<a href='mailto:".$v_check."' rel='nofollow' style='text-decoration:underline;'>".$v_check."</a>";								
								// IF LINKS MAKE OUTBOUND
							}elseif(!is_array($v_check) && substr($v_check,0,4) == "http"){	
									if(get_option('permalink_structure') == ""){
									$link = $v_check;								
									}else{
									//$link = get_home_url()."/out/".$THISPOSTID."/".$field['key']."/";
									$link = $v_check;
									}
									$v_check = "<a href='".$link."' rel='nofollow' target='_blank' style='text-decoration:underline;'>".$CORE->_e(array('single','25'))."</a>";													
							// CHECK BOX DISPLAY						 						
							}elseif(is_array($v_check)){
								$nstring = "";						 					 				 									
								foreach($v_check as $vk=>$vd){
									if(!is_array($vd) && $vd != "" && $vd != "--" && $vd !="Array"){
									//if($field['fieldtype'] == "checkbox"){	COULD ADD ICON?
									$nstring .= "<div>".$vd."</div> ";
									}
								}
								$v_check = $nstring;						
							}
							if($field['key'] == "price"){						 
							$v_check = hook_price($v_check);						
							}
							
							if($field['key'] == "phone" || $field['key'] == "phonenumber"){						 
							$v_check = "<a href='tel:".$v_check."'>".$v_check."</a>";						
							}
							
							if($field['fieldtype'] == "textarea"){	
							$v_check = wpautop($v_check);
							}
							
							// INTEGRATION FOR COUPONS
							if( isset($GLOBALS['CORE_THEME']['coupon']['code_key']) && $GLOBALS['CORE_THEME']['coupon']['code_key'] == $field['key']  ){
								$v_check = '[CBUTTON]';
							}
							if($field['key'] == "expires" || $field['key'] == "expiry_date"){						 
							$v_check = $this->TimeDiff( $v_check );						
							}
							if($field['key'] == "start_date"){						 
							$v_check = $this->format_date( $v_check );						
							}							
							$value = $v_check;
						}
						$values = "";
						 
						// DONT SHOW BLANK FIELDS
						if($value == ""){ continue; }
						
						if(is_array($value)){ 
						
							foreach($value as $val){			
								if(is_object($val)){
								$values .= " <a href='".get_term_link($val->slug, $field['taxonomy']). "'>".$val->name."</a>";
								}if(!is_array($val) && !is_object($val) && strlen($val) > 2){ $values .= " ".$val; 
								}elseif(is_array($val)){ 
									foreach($val as $val1){ 						 
										$values .= " ".$val1; 						 
									} // end foreach
								} // end if
							} // end foreach
						
						}else{ $values = $value; }	
							
							 
							if(!is_object($values)){ 
							
							// ADD ON DATE FORMAT
							if($field['fieldtype'] == "date"){ $values = hook_date($values); }
							
							// CUSTOM CSS STYLES
						 if($i%2){ $ec = "odd"; }else{ $ec = "even"; }	 $i++;
								$STRING .= '<tr class="'.$ec.' roww'.$field['key'].'">
								<th>'.$field['name'].'</th>
								<td class="val_'.$field['key'].'">'.$values.'</td>								
								</tr>';
							}
						}
					}
				
				} break;
				
				case "tax_store": {
			 
					// GET LIST
					$LIST = get_the_term_list( $THISPOSTID, 'store', "", ', ', '' );
					if(strlen($LIST) > 1){
					// ADD ON CATEGORY
					 if($i%2){ $ec = "odd"; }else{ $ec = "even"; }	 $i++;
					$STRING .= '<tr class="'.$ec.'">
					<td>'.$CORE->_e(array('button','49')).'</td>
					<td>'.$LIST.'</td>				
					</tr>';
					}
				
				} break;				

				
				case "ctype": {
			 
					// GET LIST
					 $ctype = get_post_meta($post->ID,'ctype',true); 
					// ADD ON CATEGORY
					 if($i%2){ $ec = "odd"; }else{ $ec = "even"; }	 $i++;
					$STRING .= '<tr class="'.$ec.'">
					<td>'.$CORE->_e(array('dealer','3')).'</td>
					<td>'.$CORE->_e(array('dealer','t'.$ctype)).'</td>				
					</tr>'; 
				
				} break;
								
				case "category": {
					
					// CHECK FOR HIDDEN KEYS
					if(in_array('category', $hide_options)){ continue;  }
					// GET LIST
					$LIST = get_the_term_list( $THISPOSTID, THEME_TAXONOMY, "", ', ', '' );
					if(strlen($LIST) > 1){
					// ADD ON CATEGORY
					 if($i%2){ $ec = "odd"; }else{ $ec = "even"; }	 $i++;
					$STRING .= '<tr class="'.$ec.'">
					<th>'.$CORE->_e(array('add','13')).'</th>
					<td>'.$LIST.'</td>					
					</tr>';
					}
					
				} break;
				
				case "address": {
					
					// CHECK FOR HIDDEN KEYS
					if(in_array('address', $hide_options)){ continue;  }
					
					// COUNTRY
				 	$country =  get_post_meta($THISPOSTID, 'map-country', true);
					if(strlen($country) > 1){
					 if($i%2){ $ec = "odd"; }else{ $ec = "even"; }	 $i++;
					$STRING .= '<tr class="'.$ec.'">
					<th>'.$CORE->_e(array('add','47')).'</th>
					<td>'.$GLOBALS['core_country_list'][$country].'</td>					
					</tr>';
					}
					
					// STATE
				 	$state =  get_post_meta($THISPOSTID, 'map-state', true);
					if(strlen($state) > 1){
					 if($i%2){ $ec = "odd"; }else{ $ec = "even"; }	 $i++;
					$STRING .= '<tr class="'.$ec.'">
					<th>'.$CORE->_e(array('add','48')).'</th>
					<td>'.$state.'</td>					
					</tr>';
					}				
					
					// MAP LOCATION
				 	$map_location =  get_post_meta($THISPOSTID, 'map_location', true);
					if(strlen($map_location) > 1){
					
					
					if($i%2){ $ec = "odd"; }else{ $ec = "even"; }	 $i++;
					$STRING .= '<tr class="'.$ec.'">
					<th>'.$CORE->_e(array('widgets','12')).'</th>
					<td>'.do_shortcode('[DISTANCE text_before=""]').'</td>					
					</tr>';
						if($smalllist != 1){
						if($i%2){ $ec = "odd"; }else{ $ec = "even"; }	 $i++;
						$STRING .= '<tr class="'.$ec.'">
						<th>'.$CORE->_e(array('checkout','41')).'</th>
						<td>'.$map_location.'</td>					
						</tr>';					 
						}
					}	
					
				} break;
				
				case "tags": {
					
					$tagc = $this->wlt_shortcode_tags(array(),false);
					if(strlen($tagc) > 5){
						if($i%2){ $ec = "odd"; }else{ $ec = "even"; }	 $i++;
						$STRING .= '<tr class="'.$ec.'">
						<th>'.$CORE->_e(array('add','71')).'</th>
						<td>'.$tagc.'</td>					
						</tr>';
					}
				
				} break;
				
				default: {
					
					if(isset($explode_custom_titles[1])){ $custom_title = $explode_custom_titles[1]; }else{ $custom_title = $explode_custom_titles[0]; }
					// ADD ON CATEGORY
					 if($i%2){ $ec = "odd"; }else{ $ec = "even"; }	 $i++;
					$STRING .= '<tr class="'.$ec.'">
					<td>'.$custom_title.'</td>
					<td>'.get_post_meta($THISPOSTID,$explode_custom_titles[0],true).'</td>
					</tr>';
							
				}
				
			} // end switch 
		
		} // end foreach
		
		$STRING  = hook_shortcode_fields_show($STRING);
			
		$STRING .= '</tbody></table>';
		
		// END TITLE
		if($title){
		$STRING .= '</div></div><div class="clearfix"></div>';
		}
		
		// RETURN CODE
		return do_shortcode($STRING); 
	  
	}
	/* =============================================================================
		[TOOLBOX] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_toolbox( $atts, $content = null ) {
	
		global $userdata, $CORE, $post, $shortcode_tags; $STRING = "";  $default_options = 'views|comments|print|social|favorites|feedback|rating';
	
	   extract( shortcode_atts( array(
		  'style' => "wlt_toolbox",
		  'show' => $default_options,	 
		  ), $atts ) );
		$options = explode("|",esc_attr($show));
		
		// GET THE SYSTEM DATE FORMAT SET BY WP
		$date_format = get_option('date_format') . ' ' . get_option('time_format');
		$date = mysql2date($date_format, $post->post_date, false);
		
		if(esc_attr($style) == "wlt_toolbar"){ $sp = "li"; }else{ $sp = "p"; }
		
		$STRING = '<div class="'.esc_attr($style).'"> 
		<strong>'.$CORE->_e(array('button','42')).'</strong>
		<div id="expandToolbox">';
	 
		foreach($options as $option){
		
			switch($option){
			case "views": {
			$v = get_post_meta($post->ID,'hits',true);
			if($v == ""){ $v = 0; }
			$STRING .=' <'.$sp.'><i class="glyphicon glyphicon-signal"></i>'.number_format($v,0).' '.$CORE->_e(array('single','19')).'</'.$sp.'>';
			} break;			
			case "date": {
			$STRING .=' <'.$sp.'><i class="glyphicon glyphicon-calendar"></i>'.$date.'</'.$sp.'>';
			} break;	
			case "category": {
			$STRING .=' <'.$sp.'><i class="glyphicon glyphicon-folder-open"></i>'.get_the_term_list( $post->ID, THEME_TAXONOMY, "", ', ', '' ).'</'.$sp.'>';
			} break;
			case "comments": {
			$STRING .=' <'.$sp.'><i class="glyphicon glyphicon-comment"></i>'.$post->comment_count.' '.$CORE->_e(array('comment','11')).'</'.$sp.'>';
			} break;
			case "price": {
			$STRING .=' <'.$sp.' class="price"><i class="glyphicon glyphicon-check"></i>'.hook_price(get_post_meta($post->ID,'price',true)).'</'.$sp.'>';
			} break;
			case "feedback": {
			if(isset($GLOBALS['CORE_THEME']['feedback_enable']) && $GLOBALS['CORE_THEME']['feedback_enable'] == '1'){ 
			if($userdata->ID == $post->post_author){ continue; }
			$STRING .=' <'.$sp.' class="feedback"><i class="fa fa-comment"></i> <a href="'.$GLOBALS['CORE_THEME']['links']['myaccount'].'?fdid='.$post->ID.'">'.$CORE->_e(array('feedback','1')).'</a></'.$sp.'>';
			}
			} break;
			
			case "rating": {
			$STRING .=' <'.$sp.' class="rating">'.$this->wlt_shortcode_rating().'</'.$sp.'>';
			} break;
			
			case "social": {
			if(!isset($GLOBALS['CORE_THEME']['addthis']) || ( isset($GLOBALS['CORE_THEME']['addthis']) && $GLOBALS['CORE_THEME']['addthis']  == 1 ) ){
			$STRING .=' <'.$sp.' class="social">
			
			<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=300&amp;pubid=ra-51b6bbde12f521a6">
			<img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a>
			<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
			<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-51b6bbde12f521a6"></script>
			</'.$sp.'>';
			}
			} break;
			case "print": {
			$pl = get_permalink($post->ID);		 
			if(substr($pl,-1) != "/"){ $print_link = $pl."&print=true&amp;pid=".$post->ID; }else{ $print_link = $pl."/?print=true&amp;pid=".$post->ID; }
			$STRING .= ' <'.$sp.'><i class="glyphicon glyphicon-print"></i><a href="'.$print_link.'" rel="nofollow" target="_blank">'.$CORE->_e(array('single','24')).'</a></'.$sp.'>';
			} break;
			case "favorites": {
			 
				if($GLOBALS['CORE_THEME']['show_account_favs'] == '1'){ 
					$show_add = true;
					//*** check if this listing is already in their favs list so we can display remove favs **/
					if($userdata->ID){
						$my_list = get_user_meta($userdata->ID, 'favorite_list',true);
					 	if(is_array($my_list) && in_array($post->ID, $my_list) ){
						$show_add = false;
						}
					}	 
				if($show_add){
				$STRING .='<'.$sp.'><i class="glyphicon glyphicon-plus-sign"></i>  <a href="javascript:void(0);" onclick="WLTAddF(\''.str_replace("http://","",get_home_url()).'\', \'favorite\', '.$post->ID.', \'core_ajax_callback\');">'.$CORE->_e(array('button','32')).'</a></'.$sp.'>'; 
				}else{
				$STRING .='<'.$sp.'><i class="glyphicon glyphicon-remove-sign"></i> <a href="javascript:void(0);" onclick="WLTAddF(\''.str_replace("http://","",get_home_url()).'\', \'favorite\', '.$post->ID.', \'core_ajax_callback\');">'.$CORE->_e(array('button','33')).'</a></'.$sp.'>'; 
				} 
				}	    
			} break;
			default:{
			
				if ( array_key_exists($option, $shortcode_tags ) ){			 
				$STRING .= '<'.$sp.'>'.do_shortcode("[".$option."]").'</'.$sp.'>';
				}else{
				$STRING .='<'.$sp.'>'. hook_shortcode_toolbox_item($option).'</'.$sp.'>';
				}
			
			}			
			
			}	// end switch
		}// end foreach
	 
		$STRING .= '</div></div>';
		if(esc_attr($style) == "wlt_toolbar"){ $STRING .= '<div class="clearfix"></div>'; }
	
	return $STRING;
	  
	}
	/* =============================================================================
		[TOOLBAR] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_toolbar($atts, $content = null){
	$default_options = 'date|category';
	extract( shortcode_atts( array('style' => "wlt_toolbar", 'show' => $default_options ), $atts ) );
	return $this->wlt_shortcode_toolbox( $a = array("style"=>esc_attr($style), "show"=>esc_attr($show)), $content);
	}
	/* =============================================================================
		[TIMESINCE] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_timesince( $atts, $content = null ) {
	
		global $userdata, $CORE, $post, $shortcode_tags; $STRING = ""; 
		extract( shortcode_atts( array('text_before' => "", 'text_after' => "" ), $atts ) );	 
		// ADD IN END DTATE IF NONE IS SET
		$STRING = $text_before." ".$this->TimeDiff($post->post_date,'','',false)." ".$text_after; 			
		// RETURN VALUE
		return "<span class='wlt_shortcodes_timesince'>".$STRING." </span>";  
	} 
	/* =============================================================================
		[TOOLSET] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_toolset( $atts, $content = null ) {
	
		global $userdata, $CORE, $post, $shortcode_tags; $STRING = "";  $default_options = 'views|comments|print|social|favorites|rating';
		
		// FIELD DATA
		$pl = get_permalink($post->ID);
		if(substr($pl,-1) != "/"){ $print_link = $pl."&print=true&amp;pid=".$post->ID; }else{ $print_link = $pl."/?print=true&amp;pid=".$post->ID; }
		$hits = get_post_meta($post->ID,'hits',true);	 
			 
		$STRING = '<div class="wlt_toolset">
		
			<ul>
			
			<li class="ts1"><i class="glyphicon glyphicon-signal"></i> '.$hits.' '.$CORE->_e(array('single','19')).'</li>
			
			<li class="ts2"><i class="glyphicon glyphicon-star-empty"></i> '.$CORE->_e(array('single','40')).' ('.$post->ID.')</li>
			
			<li class="ts3"><i class="glyphicon glyphicon-print"></i> <a href="'.$print_link.'" rel="nofollow" target="_blank">'.$CORE->_e(array('single','24')).'</a></li>
			
			<li class="ts4"><i class="glyphicon glyphicon-thumbs-up"></i> <a href="javascript:void(0);" class="addthis_button_facebook">'.$CORE->_e(array('single','41')).'</a></li>
			
			<li class="ts5"><i class="glyphicon glyphicon-bullhorn"></i> <a href="javascript:void(0);" class="addthis_button_twitter">'.$CORE->_e(array('single','42')).'</a></li>
			
			<li class="ts6"><i class="glyphicon glyphicon-font"></i> <a href="javascript:void(0);" class="addthis_button_pdfmyurl">'.$CORE->_e(array('single','43')).'</a></li>	
			
			<li class="ts7"><i class="glyphicon glyphicon-book"></i> <a href="javascript:void(0);" class="addthis_button_favorites">'.$CORE->_e(array('single','44')).'</a></li>	
			
			<li class="ts8"><i class="glyphicon glyphicon-envelope"></i> <a class="addthis_button_email">'.$CORE->_e(array('single','45')).'</a></li>
			
			</ul> 
		<div class="clearfix"></div>
		</div>
		
	<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=premiumpress"></script>
	';
		
		return $STRING;
	
	}
	/* =============================================================================
		[IMAGE] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_image( $atts, $content = null ) {
	  
		global $userdata, $CORE, $post;  $image = ""; $linkextra = "";
		
		extract( shortcode_atts( array('pid' => $post->ID, "pathonly" => false, 'text' => "", 'striptags' => false, 'link' => 1, "gallery" => 0,  "class" => "wlt_thumbnail img-responsive", "right" => 0, "count" => 0), $atts ) );
		 
 	 
		// LEFT RIGHT IMAGE
		if($right == 1){
		$linkextra = " pull-right";
		}else{
		$linkextra = "";
		}
	  
 		// GET IMAGE LINK
		$permalink = get_permalink($pid); 
		
		// STRIP TAGS IF CONTENT IN NOT EMPTY
		if(strlen($content) > 1){ $striptags = true; }
 	 	
		// DISPLAY OVERLAY TEXT
		$text_overlay = esc_attr(strip_tags($text));
		
		// CONTENT
		$content = do_shortcode($content);
	 
		// FIX FOR PRINT PAGE IMAGES
		if(isset($_GET['pid']) && isset($_GET['print'])){ $pid = $_GET['pid']; }	
	
		// CHECK IF WE HAVE A THUMBNAIL
		if ( has_post_thumbnail($pid) ) { 
		 
		 		if($link == 1){ $image = '<a href="'.$permalink.'" class="frame'.$linkextra.'">'; }else{ $image .= '<div class="frame'.$linkextra.'">'; } 
				 
				$image .= hook_image_display(get_the_post_thumbnail($pid, array(get_option('thumbnail_size_w'),get_option('thumbnail_size_h')), array('class'=> $class)));
				$image .= $this->STICKER($pid); 
				
				if(strlen($text_overlay) > 1){ $image .= "<span class='ftext'>".$text_overlay."</span>"; }	
				if(strlen($content) > 1){ $image .= $content; }
						 
				if($link == 1){ $image .= '</a>'; }else{ $image .= '</div>'; }
			 
		}else{
		
			// CHECK FOR FALLBACK IMAGE
			$fimage = $this->FALLBACK_IMAGE($pid); 
		
			
			if($fimage !=""){
				 
					if($link == 1){ $image = '<a  href="'.$permalink.'" class="frame'.$linkextra.'">'; }else{ $image .= '<div class="frame'.$linkextra.'">'; }
					$image .= $fimage;
					$image .= $this->STICKER($pid);	
					
					if($count == 1){
						$old_imgs_system = get_post_meta($pid,'image_array',true);
						if(!is_array($old_imgs_system)){ $fc = 0; }else{ $fc = count($old_imgs_system); }
						$image .= "<span class='img-count'>".$fc."</span>";
					}
					
					if(strlen($text_overlay) > 1){ $image .= "<span class='ftext'>".$text_overlay."</span>"; }	
					if(strlen($content) > 1){ $image .= $content; }			
						 
					if($link == 1){ $image .= '</a>'; }else{ $image .= '</div>'; }
				  
			}
		}
		
		
		if($pathonly){
			preg_match( '@src="([^"]+)"@' , $image , $match ); 
			if(isset($match[1])){
			return $match[1];
			}
		}
		 
				 
		// REMOVE FIXED WIDTH/HEIGHT VALUES
		$image = preg_replace( '/(width|height)="\d*"\s/', "", $image );	 
 
		// ADD ON POP-UP GALLERY
		if($gallery){
	 
			preg_match( '@src="([^"]+)"@' , $image , $match ); 
			 
			$image 	= "<a href='".$match[1]."' rel='prettyPhoto[ppt_gal]' class='mainimage'>".preg_replace("/<a[^>]*>(.*)<\/a>/iU", "$1", $image)."</a>";
			// NOW ADDON EXTRA GALLERY IMAGES AS HIDDEN VALUES
			$images = $user_attachments = $this->UPLOAD_GET($pid,0,array('type' => 'image'));
			if(is_array($images) && !empty($images)){
				foreach($images as $nimg){
				$image 	.= "<a href='".$nimg['src']."' rel='prettyPhoto[ppt_gal]'></a>";
				}
			}
			 
			$image .= '<script>jQuery(window).load(function(){jQuery("a[rel^=\'prettyPhoto\']").prettyPhoto({animation_speed: "normal",	autoplay_slideshow: true,	slideshow: 3000	});});</script>';
		}
		
		// UNSET
		unset($GLOBALS['noeditor']);
		
		// ITEMSCOPE
		$image = str_replace("<img ","<img ".$this->ITEMSCOPE("itemprop","image")." ",$image);
		 
		// RETURN VALUE
		if($striptags){	
			return hook_image_display($image);  
		}else{
			return hook_shortcode_image_output(hook_image_display($image));  
		}
		
	}
	/* =============================================================================
		[RATING] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_rating( $atts = "", $content = null ) {
	
		global $wpdb, $userdata, $CORE, $post, $shortcode_tags; $STRING = "";  $default_options = 'all';
		
		// CHECK IF DISABLED BY SYSTEM
		if(isset($GLOBALS['CORE_THEME']['rating']) && $GLOBALS['CORE_THEME']['rating'] == 0){ return; }
		
		extract( shortcode_atts( array('size' => '24', 'id' => '', 'before' => '', 'after' =>'', 'style' =>'', 'results' => false, 'small' => false, 'readonly' => false ), $atts ) );
		$size = esc_attr($size);
		$id = esc_attr($id);
		$style = esc_attr($style);
		$results = esc_attr($results);
		$small = esc_attr($small); 
		$small = esc_attr($small); 
 		$readonly = esc_attr($readonly); 
		
		// GET THE ID OF THE STAR ITEM
		if(isset($id) && strlen($id) > 0){ $thisID = $id; }elseif(isset($GLOBALS['POSTID'])){ $thisID = $GLOBALS['POSTID']; }else{ $thisID = $post->ID; }
 	
		// SETUP UNIQUE ID
		$divID = str_replace("+","",round(microtime(true) * 440)).$post->ID;
		if(isset($GLOBALS[$divID])){ return; }
		$GLOBALS[$divID] = true;
		
		if($style ==""){ $style = $GLOBALS['CORE_THEME']['rating_type']; }
		
		// ITEM SCOPE RATING
		$itemscope_ratingcount = 0;
		$itemscope_ratingvalue = 0;		
		
		// SETUP DSPLAY TYPE
		switch($style){
		
			case "feedback": {
			
			
				// COUNT RATING FROM ALL LISTINGS
				$fback = $CORE->FEEDBACKSCORE($post->ID); 
				 
				// working out
				$ratingV = $fback['votes'];
				$rating = $fback['score'];
				if($rating == ""){ $rating = 0; }
				
				// ITEM SCOPE
				$itemscope_ratingcount = $ratingV;
				$itemscope_ratingvalue = $rating;
		
				$STRING = $before."<span id='wlt_star_".$divID."' class='wlt_starrating'></span>".$after."
		
				<script type='text/javascript'>jQuery(document).ready(function(){ 
				jQuery('#wlt_star_".$divID."').raty({
				path: '".FRAMREWORK_URI."img/rating/',
				score: ".$rating.",";
				
				if($readonly){ $STRING .= "readOnly: true, "; }
				
				if($small == 1 && $size != 16){
				$STRING .= "size: 16, ";
				}else{
				$STRING .= "size: 24,
				";
				}
				 
				
				$STRING .= "}); }); </script>";
				
			
			} break;

			// THUMBS H
			case "2": {
			
				$up 	= get_post_meta($thisID, 'ratingup', true);
				$down 	= get_post_meta($thisID, 'ratingdown', true);
				if($up == ""){ $up =0; }
				if($down == ""){ $down =0; }
				$total = $up+$down;
				
				// ITEM SCOPE
				$itemscope_ratingcount = $total;
				$itemscope_ratingvalue = 5;
				
				$STRING = '<div class="btn-group wlt_thumbs_style1">
				
				  <button class="btn up">
				  <a href="javascript:void(0);" onclick="WLTSaveUpRating(\''.str_replace("http://","",get_home_url()).'\', \''.$post->ID.'\', \'up\', \''.$divID.'_up\');">
				  <i class="glyphicon glyphicon-thumbs-up"></i></a>
				  <span id="'.$divID.'_up">'.$up.'</span>
				  </button>
				  
				  <button class="btn down">
				  <a href="javascript:void(0);" onclick="WLTSaveUpRating(\''.str_replace("http://","",get_home_url()).'\', \''.$post->ID.'\', \'down\', \''.$divID.'_down\');">
				  <i class="glyphicon glyphicon-thumbs-down"></i></a> 
				  <span id="'.$divID.'_down">'.$down.'</span>
				  </button>
				  
				</div>';
				
			} break;
						
			// VOTE UP / DOWNLOAD
			case "3": {
			
				$up 	= get_post_meta($thisID, 'ratingup', true);
				$down 	= get_post_meta($thisID, 'ratingdown', true);
				if($up == ""){ $up =0; }
				if($down == ""){ $down =0; }
				$total = $up+$down;
				
				// ITEM SCOPE
				$itemscope_ratingcount = $total;
				$itemscope_ratingvalue = 5;
				
				$STRING = "<div id='wlt_star_".$divID."' class='wlt_rating_updown'>
				<div class='upv'><a href='javascript:void(0);' onclick=\"WLTSaveUpRating('".str_replace("http://","",get_home_url())."', '".$post->ID."', 'up', '".$divID."_up');\">
				".$CORE->_e(array('button','47'))." +<span id='".$divID."_up'>".$up."</span></a></div>
				
				<div class='downv'><a href='javascript:void(0);' onclick=\"WLTSaveUpRating('".str_replace("http://","",get_home_url())."', '".$post->ID."', 'down', '".$divID."_down');\">
				".$CORE->_e(array('button','48'))." -<span id='".$divID."_down'>".$down."</span></a></div>
				</div>";
			
			} break;
			
			// VOTE UP / DOWNLOAD WITH BAR
			case "3a": {
				
				$up 	= get_post_meta($thisID, 'ratingup', true);
				$down 	= get_post_meta($thisID, 'ratingdown', true);
				if($up == ""){ $up = 0; }
				if($down == ""){ $down =0; }				
				$total = $up+$down;
				
				// ITEM SCOPE
				$itemscope_ratingcount = $total;
				$itemscope_ratingvalue = 5;
				
$STRING = '<div class="wlt_rating_style'.$style.'">';
				
$STRING .= "<div id='wlt_star_".$divID."' class='wlt_rating_updown'>
				<a href='javascript:void(0);' onclick=\"WLTSaveUpRating('".str_replace("http://","",get_home_url())."', '".$post->ID."', 'up', '".$divID."_up');\"><div class='upv'>
				<i class='fa fa-thumbs-o-up'></i>  <span id='".$divID."_up'>".$up."</span></div></a>
				
				<a href='javascript:void(0);' onclick=\"WLTSaveUpRating('".str_replace("http://","",get_home_url())."', '".$post->ID."', 'down', '".$divID."_down');\">
				<div class='downv'><i class='fa fa-thumbs-o-down'></i> <span id='".$divID."_down'>".$down."</span></div></a>
				</div>";
 

$STRING .= '</div>';
 		
			} break;
			
			// THUMBS V
			case "4": {
			
				$up 	= get_post_meta($thisID, 'ratingup', true);
				$down 	= get_post_meta($thisID, 'ratingdown', true);
				if($up == ""){ $up =0; }
				if($down == ""){ $down =0; }
				$total = $up+$down;
				
				// ITEM SCOPE
				$itemscope_ratingcount = $total;
				$itemscope_ratingvalue = 5;
				
				$STRING = '<div class="btn-group btn-group-vertical wlt_thumbs_style2">
					  <button type="button" class="btn">
					  <a href="javascript:void(0);" onclick="WLTSaveUpRating(\''.str_replace("http://","",get_home_url()).'\', \''.$post->ID.'\', \'up\', \''.$divID.'_up\');">
						  <i class="glyphicon glyphicon-thumbs-up"></i>
						</a></button>
					  <button type="button" class="btn btn-default"><span id="'.$divID.'_up">'.$up.'</span></button>
					  <button type="button" class="btn btn-default"><a href="javascript:void(0);" onclick="WLTSaveUpRating(\''.str_replace("http://","",get_home_url()).'\', \''.$post->ID.'\', \'down\', \''.$divID.'_down\');">
				  <i class="glyphicon glyphicon-thumbs-down"></i></a></button>
					  <button type="button" class="btn btn-default"><span id="'.$divID.'_down">'.$down.'</span></button>
					</div>';
				
			} break;
			
			// THUMBS
			case "5": {
			
				$up 	= get_post_meta($thisID, 'ratingup', true);
				$down 	= get_post_meta($thisID, 'ratingdown', true);
				if($up == ""){ $up =0; }
				if($down == ""){ $down =0; }
				$total = $up+$down;
				
				// ITEM SCOPE
				$itemscope_ratingcount = $total;
				$itemscope_ratingvalue = 5;
				
				$STRING = '<div class="btn-group wlt_thumbs_style1">
				
				  <button class="btn up">
				  <a href="javascript:void(0);" onclick="WLTSaveUpRating(\''.str_replace("http://","",get_home_url()).'\', \''.$post->ID.'\', \'up\', \''.$divID.'_up\');">
				  <img src="'.FRAMREWORK_URI.'img/rating/thumb_up.png" alt=""></a>
				  <span id="'.$divID.'_up">'.$up.'</span>
				  </button>
				  
				  <button class="btn down">
				  <a href="javascript:void(0);" onclick="WLTSaveUpRating(\''.str_replace("http://","",get_home_url()).'\', \''.$post->ID.'\', \'down\', \''.$divID.'_down\');">
				  <img src="'.FRAMREWORK_URI.'img/rating/thumb_down.png" alt=""></a>
				  <span id="'.$divID.'_down">'.$down.'</span>
				  </button>
				  
				</div>';
				
			} break;
			
			// THUMBS V
			case "6": {
			
				$up 	= get_post_meta($thisID, 'ratingup', true);
				$down 	= get_post_meta($thisID, 'ratingdown', true);
				if($up == ""){ $up =0; }
				if($down == ""){ $down =0; }
				$total = $up+$down;
				
				// ITEM SCOPE
				$itemscope_ratingcount = $total;
				$itemscope_ratingvalue = 5;
				
				$STRING = '<div class="btn-group btn-group-vertical wlt_thumbs_style2">
					  <button type="button" class="btn btn-default"><a href="javascript:void(0);" onclick="WLTSaveUpRating(\''.str_replace("http://","",get_home_url()).'\', \''.$post->ID.'\', \'up\', \''.$divID.'_up\');">
						  <img src="'.FRAMREWORK_URI.'img/rating/thumb_up.png" alt="">
						  </a></button>
					  <button type="button" class="btn btn-default"><span id="'.$divID.'_up">'.$up.'</span></button>
					  <button type="button" class="btn btn-default"><a href="javascript:void(0);" onclick="WLTSaveUpRating(\''.str_replace("http://","",get_home_url()).'\', \''.$post->ID.'\', \'down\', \''.$divID.'_down\');">
				  <img src="'.FRAMREWORK_URI.'img/rating/thumb_down.png" alt="">
				  </a></button>
					  <button type="button" class="btn btn-default"><span id="'.$divID.'_down">'.$down.'</span></button>
					</div>';
				
			} break;
			
			// VOTE UP / DOWNLOAD
			case "7": {
			
				$up 	= get_post_meta($thisID, 'ratingup', true);
				$down 	= get_post_meta($thisID, 'ratingdown', true);
				if($up == ""){ $up =0; }
				if($down == ""){ $down =0; }
				$total = $up+$down;
				
				// ITEM SCOPE
				$itemscope_ratingcount = $total;
				$itemscope_ratingvalue = 5;
				
				$STRING = "<div id='wlt_star_".$divID."' class='wlt_rating_textonly'>
				
				<a href='javascript:void(0);' onclick=\"WLTSaveUpRating('".str_replace("http://","",get_home_url())."', '".$post->ID."', 'up', '".$divID."_up');\">
				".$CORE->_e(array('button','47'))." +<span id='".$divID."_up'>".$up."</span></a> /
				
				<a href='javascript:void(0);' onclick=\"WLTSaveUpRating('".str_replace("http://","",get_home_url())."', '".$post->ID."', 'down', '".$divID."_down');\">
				".$CORE->_e(array('button','48'))." -<span id='".$divID."_down'>".$down."</span></a>
				</div>";
				
			} break;
			
			// SUCCESS BOX
			case "9":
			case "8": {
			
				$up 	= get_post_meta($thisID, 'ratingup', true);
				$down 	= get_post_meta($thisID, 'ratingdown', true);
				if($up == ""){ $up = 0; }
				if($down == ""){ $down =0; }				
				$total = $up+$down;
				
				
				// ITEM SCOPE
				$itemscope_ratingcount = $total;
				$itemscope_ratingvalue = 5;
				
				
				// WORK OUT GOOD PERCENTAGE
				if($total == 0 || $up == 0 ){
					$good_per = 0;					
				}else{
					$good_per = ($up*100)/$total;				
				}
				// WORK OUT BAD PERCENTAGE
				if($total == 0 || $down == 0 ){
					$bad_per = 0;					
				}else{
					$bad_per = ($down*100)/$total;			
				}	
				// TESTING		
				//$STRING .= $total." total votes: ".$total." ( ".$up." good (".$good_per."%) | ".$down." bad (".$bad_per."%))";
				
				// CHANGE BAACKGROUND BASED ON RESULTS
				if($total == 0){ $barbg = ""; }elseif($good_per == 50){ $barbg = "bg-info"; }elseif($good_per > 50){ $barbg = "bg-success"; }else{ $barbg = "bg-danger"; }
			
			$STRING .= '<div class="'.$barbg .' wlt_rating_successmeter style'.$style.' hidden-xs">
			 
			
<h4>'.$CORE->_e(array('coupons','25')).'</h4>			
			
<div class="progress" id="'.$divID.'_down">	
  <div class="progress-bar progress-bar-success"  style="width: '.$good_per.'%">
    <span>('.round($good_per).'%)</span>
  </div>  
  <div class="progress-bar progress-bar-danger" style="width: '.$bad_per.'%">
    <span>&nbsp;</span>
  </div>    
</div>
  
<div class="clearfix">';

if($style == 8){

$STRING .= '<ul class="nav nav-pills nav-stacked">
  <li class="active">
    <a href="javascript:void(0);" onclick="WLTSaveUpRating(\''.str_replace("http://","",get_home_url()).'\', \''.$post->ID.'\', \'up\', \''.$divID.'_down\');">
      <span class="badge pull-right">'.$up.' '.$CORE->_e(array('coupons','28')).'</span>
      '.$CORE->_e(array('coupons','26')).'
    </a>
  </li>
   <li class="active">
    <a href="javascript:void(0);" onclick="WLTSaveUpRating(\''.str_replace("http://","",get_home_url()).'\', \''.$post->ID.'\', \'down\', \''.$divID.'_down\');">
      <span class="badge pull-right">'.$down.' '.$CORE->_e(array('coupons','28')).'</span>
      '.$CORE->_e(array('coupons','27')).'
    </a>
  </li>
</ul>';

}elseif($style == 9){

$STRING .= '
<div class="successvoting'.$divID.'">
 <a href="javascript:void(0);" onclick="WLTSaveUpRating(\''.str_replace("http://","",get_home_url()).'\', \''.$post->ID.'\', \'up\', \''.$divID.'_down\');" class="'.$divID.'_ub">
  
      '.$CORE->_e(array('coupons','26')).'
    </a> |
<a href="javascript:void(0);" onclick="WLTSaveUpRating(\''.str_replace("http://","",get_home_url()).'\', \''.$post->ID.'\', \'down\', \''.$divID.'_down\');" class="'.$divID.'_db">
    
      '.$CORE->_e(array('coupons','27')).'
    </a>
</div>
	<script>
	jQuery(".'.$divID.'_ub,.'.$divID.'_db").click(function(e){  
		jQuery(\'.successvoting'.$divID.'\').html("'.$CORE->_e(array('coupons','29')).'");
	});
	</script>

';
}
 
$STRING .= '</div></div>';
			
			
			
			} break;
			
			
			case "10": {
			
				$up 	= get_post_meta($thisID, 'ratingup', true);
				$down 	= get_post_meta($thisID, 'ratingdown', true);
				if($up == ""){ $up =0; }
				if($down == ""){ $down =0; }
				$total = $up+$down;
				
				// ITEM SCOPE
				$itemscope_ratingcount = $total;
				$itemscope_ratingvalue = 5;
				
				// WORK OUT GOOD PERCENTAGE
				if($total == 0 || $up == 0 ){
					$good_per = 0;					
				}else{
					$good_per = ($up*100)/$total;				
				}
				
				// STYLE RANGES
				if($good_per == 0 || $good_per > 0){
				$ratingstyle = "rt1";
				}
				if($good_per > 40){
				$ratingstyle = "rt2";
				}
				if($good_per > 70){
				$ratingstyle = "rt3";
				}
				if($good_per > 90){
				$ratingstyle = "rt4";
				}
				
				
				$STRING = '<div class="wlt_rating_box ratingbox'.$divID.'"> 
            
            	<div class="rating '.$ratingstyle.'"> 
                
                	<div class="b1">'.round($good_per,0).'<span>%</span></div>
                 
                 	<div class="b2">'.$CORE->_e(array('coupons','26')).'</div>            
            
             		<div class="b3">'.$total.' '.$CORE->_e(array('coupons','28')).'</div> 
           		
                </div> 
           
               <div class="thumbs"> 
                        
               <a href="javascript:void(0);" onclick="WLTSaveUpRating(\''.str_replace("http://","",get_home_url()).'\', \''.$post->ID.'\', \'up\', \'core_footer_ajax\');">
			   <span class="up" data-toggle="tooltip" data-placement="bottom" title="'.$CORE->_e(array('coupons','26')).'"><i class="fa fa-thumbs-up"></i></span>
			   </a>
               
			   <a href="javascript:void(0);" onclick="WLTSaveUpRating(\''.str_replace("http://","",get_home_url()).'\', \''.$post->ID.'\', \'down\', \'core_footer_ajax\');" class="'.$divID.'_db">
               <span class="down" data-toggle="tooltip" data-placement="bottom" title="'.$CORE->_e(array('coupons','27')).'"><i class="fa fa-thumbs-down"></i></span>
			   </a>
                        
               </div>         		
         
            </div>
			
			<script>
	jQuery(".ratingbox'.$divID.'").click(function(e){  
		jQuery(\'.ratingbox'.$divID.' .b1\').html("'.$CORE->_e(array('coupons','29')).'");
	});
	</script>
			';
				
			} break;
			
			default: {
			
				// GET THE RATING DATA
				$ratingT = get_post_meta($thisID, 'starrating_total', true);
				if($ratingT == ""){ $ratingT =0; }
				$ratingV = get_post_meta($thisID, 'starrating_votes', true);	
				if($ratingV == ""){ $ratingV = 0; }			
				$rating = get_post_meta($thisID, 'starrating', true);
				if($rating == ""){ $rating = "0"; }
				
				// ITEM SCOPE
				$itemscope_ratingcount = $ratingV;
				$itemscope_ratingvalue = $rating;
		
				$STRING = $before."<span id='wlt_star_".$divID."' class='wlt_starrating'></span>".$after."
		
				<script type='text/javascript'>jQuery(document).ready(function(){ 
				jQuery('#wlt_star_".$divID."').raty({
				path: '".FRAMREWORK_URI."img/rating/',
				score: ".$rating.",";
				
				if($readonly){ $STRING .= "readOnly: true, "; }
				
				if($small == 1 && $size != 16){
				$STRING .= "size: 16, ";
				}else{
				$STRING .= "size: 24,
				";
				}
				if(!$readonly){
				$STRING .= "click: function(score, evt) {			 
					WLTSaveRating('".str_replace("http://","",get_home_url())."', '".$post->ID."', score, 'wlt_star_".$divID."');
				}";
				}
				
				$STRING .= "}); }); </script>";
			} break;
		
		}// end switch
		
		
		
		// DISPLAY RESULTS
		if($results == 1){
		
		//if($itemscope_ratingcount == 1){ $txt = $CORE->_e(array('widgets','31'));  }else{ $txt = $CORE->_e(array('widgets','32')); }
		if($itemscope_ratingcount == 1){ $txt = $CORE->_e(array('widgets','33'));  }else{ $txt = $CORE->_e(array('widgets','34')); }
		
		
	 	$STRING .= "<span class='resultsbit'>(".$itemscope_ratingcount." ".$txt.")</span>";
		}
		


	// ITEM SCOPE RATING SECTION
	$RATINGSCOPE = "";
	if(isset($GLOBALS['CORE_THEME']['itemscope']) && $GLOBALS['CORE_THEME']['itemscope'] == '1' && $itemscope_ratingcount != ""){
	$RATINGSCOPE = '<div class="wlt_itemscope_ratingbox" itemprop="aggregateRating" itemscope="" itemtype="http://schema.org/AggregateRating">         
		<meta itemprop="ratingCount" content="'.$itemscope_ratingcount.'"> 
        <meta itemprop="ratingValue" content="'.$itemscope_ratingvalue.'"> 
        </div>';
	}
			 
		return $STRING.$RATINGSCOPE;
		
	}
	/* =============================================================================
		[ADVANCEDSEARCH] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_advancedsearch( $atts = "", $content = null ) {
	
	global $userdata, $CORE, $post, $shortcode_tags;
	
	extract( shortcode_atts( array('home' => "no"), $atts ) );
 
	if($home == "yes"){
	
	return core_search_form(null,'home');
	
	}else{
	
	return core_search_form(null,'wlt_shortcode_advancedsearch');
	
	}
	
	}
	/* =============================================================================
		[FILES] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_files( $atts, $content = null ) {
	
			global $userdata, $CORE, $post, $shortcode_tags; $STRING = "";  $default_options = 'all';
		
			extract( shortcode_atts( array('type' => $default_options, 'info' => true ), $atts ) );
			$options = explode("|",esc_attr($type));
			
			foreach($options as $op){	
				$STRING	 = $this->UPLOAD_GET($post->ID, 3, array("type" => esc_attr($type) ));
			}	
			
			return $STRING;	
	}
	/* =============================================================================
		[BUTTON] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_btn( $atts, $content = null ) {
		global $userdata, $CORE, $post, $shortcode_tags;  
		extract( shortcode_atts( array('text' => '', 'key' => '', 'link' => '', 'style' => 'btn btn-primary', 'nofollow' => true  ), $atts ) );
		
		// RETURN IF NO LINK AT ALL
		if(strlen($key) < 1 && strlen($link) < 1){ return;	}
		
		if(strlen($key) > 1){ $link = get_home_url()."/out/".$post->ID."/".$key."/"; }
		
		if(strlen($text) > 1){
		$text = esc_attr($text);
		}else{
		$text = $CORE->_e(array('button','12'));
		}
		
		// NOFOLLOW LINKS
		if($nofollow){
		$nf = "rel='nofollow'";
		}else{
		$nf = "";
		}	
		// RETURN			 
		return "<a href='".$link."' class='".$style."' ".$nf.">".$text."</a>";
	}
	/* =============================================================================
		[ATTACHMENTS] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_attachments( $atts, $content = null ) {
	
			global $userdata, $CORE, $post, $shortcode_tags; $STRING = "";  $default_options = 'all'; $top = "<div class='wlt_attachments'>"; $bottom = "</div>";
		
			extract( shortcode_atts( array('type' => $default_options, 'info' => true ), $atts ) );
			$options = explode("|",esc_attr($type));
			
			foreach($options as $op){	
				$STRING	 = $this->UPLOAD_GET($post->ID, 4, array("type" => esc_attr($type) ));
			}
			
			if(strlen($STRING) > 1){
			$top .= "<h4>".$CORE->_e(array('single','39'))."</h4>";
			}
			
			return $top.$STRING.$bottom;	
	}
	/* =============================================================================
		[VISITORCHART] - SHORTCODE
		========================================================================== */
	function wlt_shortcode_visitorchart( $atts, $content = null ) {
	
		global $userdata, $CORE, $post, $shortcode_tags; $STRING = ""; $DATASTRING = ""; $MAPSTRING = ""; $showWorldMap = true;
		extract( shortcode_atts( array('postid' => "" ), $atts ) );	
		// GET THE POST ID 
		$post_id = esc_attr($postid);
		if($post_id == ""){ $post_id = $post->ID; $showWorldMap = false; }
		// GET THE DAT
		$hits_data = get_post_meta($post->ID,'hits_array',true);
	 
		if(!is_array($hits_data)){ if(is_admin()){ return "<br />No Visitor Data Recordered"; }else{ return; } }
	 
		$country_a = array();
		foreach($hits_data as $date=>$date_data){
			$totalhits = 0;
			// FIRST LOOP THROUGH ALL OF THE DATA AND GET THE COUNTRY + HITS
			foreach($date_data as $dd){
				if($dd['country'] == ""){ continue; }
				$totalhits += $dd['hits'];
				if(!isset($country_a[$dd['country']])){ $country_a[$dd['country']] = 1; }else{ $country_a[$dd['country']]++; }		
			}
			
			$date_display = hook_date($date);
			$date_display = str_replace("12:00 am","",str_replace(", 2013","",str_replace(", 2014","",$date_display)));
			$DATASTRING .=  "['".trim($date_display)."',".count($date_data).", ".$totalhits."],";
			
			// LOOP COUNTRY
			foreach($country_a as $ck=>$kk){
			$MAPSTRING .=  "['".$ck."',  ".$kk."],";
			}
		}
		
		if(is_admin()){
		$txt1 = "Date";
		$txt2 = "Unique Visitors";
		$txt3 = "Visitors";
		$txt4 = "Visitor History";
		}else{
		$txt1 = $CORE->_e(array('graphs','2'));
		$txt2 = $CORE->_e(array('graphs','3'));
		$txt3 = $CORE->_e(array('graphs','4'));
		$txt4 = $CORE->_e(array('graphs','1'));	
		}
				
		// RETURN VALUE	
		$STRING .= '<script type="text/javascript" src="https://www.google.com/jsapi"></script>
		<script type="text/javascript">
		  google.load("visualization", "1", {packages:["corechart"]});
		  google.setOnLoadCallback(drawChart);
		  
		  function drawChart() {
			var data = google.visualization.arrayToDataTable([
			  [\''.$txt1.'\', \''.$txt2.'\', \''.$txt3.'\'],'.substr($DATASTRING,0,-1).']);
			var options = {title: \''.$txt4.'\',width:\'100%\',height:\'100%\'};
			var chart = new google.visualization.LineChart(document.getElementById(\'chart_div\'));
			chart.draw(data, options);	
			
		  }  
	 
		jQuery(document).ready(function () {	
	
			jQuery(window).resize(function(){
				drawChart();
				drawRegionsMap();
			});
		});
		</script><div id="chart_div"></div>';
		
		
	 	if($showWorldMap){
		$STRING .= "<script type='text/javascript'>
		 google.load('visualization', '1', {'packages': ['geochart']});
		 google.setOnLoadCallback(drawRegionsMap);
		  function drawRegionsMap() {
			var data = google.visualization.arrayToDataTable([
			  ['Country', '".$txt2."'],".substr($MAPSTRING,0,-1)."]);
				var options = {
			  width:'100%',
			  height:'100%',
			};
			var chart = new google.visualization.GeoChart(document.getElementById('chart1_div'));
			chart.draw(data, options);
		};	
	
		</script><div id='chart1_div'></div>";
		}
		
		
		return $STRING;  
	}	

}	
?>
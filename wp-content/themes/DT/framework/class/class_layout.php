<?php

class core_layout extends white_label_themes {

function core_layout(){
	
	// WP_HEADER
	add_filter('wp', array($this, 	'handle_header_template') );
	
	// TEMPLATE ADJUSTMENTS
	add_filter('page_template', array($this, 	'handle_page_template') );
	add_filter('single_template', array($this,	'handle_post_type_template') );
	add_filter('home_template', array($this,	'handle_home_template') );
	add_filter('search_template', array($this, 	'handle_search_template') );
	add_filter('archive_template', array($this, 'handle_search_template') );
	add_filter('author_template', array($this, 'handle_author_template') );
	 	 
		// PAGE FILTERS
		add_filter( 'the_content', array($this, 'my_the_content_filter' ) );
		
		// LOGIN PAGE
		add_action('hook_login_before', array($this, 'login_before' ) );
		add_action('login_form', array($this, 'login_form' ) );
		
		// REGISTER PAGE
		add_action('hook_register_before', array($this, 'register_before' ) );
		add_action('register_form', array($this, 'register_form' ) );
	
		// SEARCH RESULTS PAGE
		add_filter('hook_gallerypage_results_title', array($this, 'gallerypage_results_title' ) );		 
		add_action('hook_gallerypage_results_top', array($this, 'gallerypage_results_top' ) );
		
		// TPL-CALLBACK PAGE
		add_action('hook_callback_success',array($this,'_hook_callback_success') );
		
		// ITEM FILTERS
		//add_action('hook_content_listing',array($this, 'gallerypage_item') );
		add_action('hook_item_class', array($this,'gallerypage_item_class'), 1 );
		
		// IMAGE ADJUSTMENTS
		add_filter( 'get_avatar' , array($this, 'image_avatar' ) , 1 , 4 );
		
		// CONTENT FILTERS
		add_filter('hook_listing_templatename', array($this, 'hook_listing_templatename' ) );
		add_filter('hook_content_templatename', array($this, 'hook_content_templatename' ) );
}
function hook_listing_templatename($c){

	// MOBILE VIEW
	if(defined('IS_MOBILEVIEW')){
	return "listing-mobile";	
	}
 
	$c = str_replace("coupon_type","listing_type",$c);
	$c = str_replace("product_type","listing_type",$c);
	$c = str_replace("_type","",$c);
	if($c == "listing" && isset($GLOBALS['CORE_THEME']['single_layout'])){ $c = str_replace("content-","",$GLOBALS['CORE_THEME']['single_layout']); }
 
	return $c;
}
function hook_content_templatename($c){

	$c = str_replace("coupon_type","listing_type",$c);
	$c = str_replace("product_type","listing_type",$c);
	$c = str_replace("_type","",$c);
	if(isset($GLOBALS['CORE_THEME']['content_layout'])){ $c = $GLOBALS['CORE_THEME']['content_layout']; }
	 
	return $c;
}
	
function login_form(){ if(isset($_GET['redirect']) || isset($_GET['redirect_to']) ){ ?>
 <input type="hidden" name="redirect_to" value="<?php if(isset($_GET['redirect'])){  echo esc_attr($_GET['redirect']); }elseif(isset($_GET['redirect_to'])){  echo esc_attr($_GET['redirect_to']); }else{ echo $GLOBALS['CORE_THEME']['links']['myaccount']; } ?>" />
<?php    
} }
function register_form(){
     if(isset($_GET['redirect'])){ ?>
    <input type="hidden" name="redirect" value="<?php echo esc_attr($_GET['redirect']); ?>" /> 
    <?php }elseif($_GET['redirect_to']){ ?>
    <input type="hidden" name="redirect" value="<?php echo esc_attr($_GET['redirect_to']); ?>" /> 
    <?php }
}
function register_before(){	
	
	// SPAM PROTECTION BY MARK FAIL
	if($_SERVER['HTTP_REFERER'] == "" && !isset($_GET['stopspam']) && !isset($_GET['pid']) ){
	global $CORE;
	?>
	<p class="alert alert-warning"><?php echo str_replace("%a", get_home_url().'/wp-login.php?action=register&stopspam=1', $CORE->_e(array('login','22'))); ?></p>
	<?php 
	get_footer($CORE->pageswitch());
	die();
	}
}
function login_before(){
	
	if(defined('WLT_DEMOMODE')){ ?>
	<div class="bs-callout bs-callout-info">
				<button type="button" class="close" data-dismiss="alert">x</button>
				<h4 class="alert-heading">Demo Account Logins</h4>
				<p>You can login with the details below to test our the members and admin areas.</p>
				<p>
				  Username: <b>demo</b> / Password: <b>demo</b>
				</p>
				<p>Username: <b>admindemo</b> / Password: <b>admindemo</b> </p>
	</div>
	<?php }
}
function _hook_callback_success(){ global $payment_data;
           
   echo str_replace("[orderid]",$payment_data['orderid'],str_replace("[description]",$payment_data['description'],str_replace("[total]",$payment_data['total'],stripslashes(get_option('google_conversion'))))); 

}
function image_avatar($avatar, $id_or_email, $size, $default){ global $wpdb;
	 
	 	// GET USERID
		if(is_object($id_or_email)){
			if(isset($id_or_email->ID))
				$id_or_email = $id_or_email->ID;
			//Comment
			else if($id_or_email->user_id)
				$id_or_email = $id_or_email->user_id;
			else if($id_or_email->comment_author_email)
				$id_or_email = $id_or_email->comment_author_email;
		}
		
		$userid = false;
		if(is_numeric($id_or_email))
			$userid = (int)$id_or_email;
		else if(is_string($id_or_email))
			$userid = (int)$wpdb->get_var("SELECT ID FROM $wpdb->users WHERE user_email = '" . esc_sql($id_or_email) . "'");
		
		// FALLBACK IF NOT AVATAR
		if(!$userid){ return $avatar; }
		
		// CHECK IF ISSET
		$userphoto = get_user_meta($userid,'userphoto',true);
		 
		if(is_array($userphoto) && isset($userphoto['path'])){
			return "<img src='".$userphoto['img']."' class='avatar img-responsive' alt='image' />";
		}else{
			return str_replace('avatar ','avatar img-responsive ',$avatar);
		}
}
function handle_header_template($template_dir) { global $CORE;

	if(is_admin()){ return; }

	// LOAD IN COLUMN LAYOUTS
	$CORE->BODYCOLUMNS();
	
	// CUSTOM HEADER
	header('X-UA-Compatible: IE=edge,chrome=1');
}
function my_the_content_filter($content) { global $post, $CORE;
	  
	  if(isset($GLOBALS['flag-page'])){
	  
		// MEMBERSHIP ACCESS
		if(!$CORE->MEMBERSHIPACCESS($post->ID)){
		$content = stripslashes($GLOBALS['CORE_THEME']['noaccesscode']);
		}
	 
	  }
	 
	  return $content;
}	
function _hook_single1(){ $GLOBALS['flag_single_content'] = true; }
function _hook_single2(){ unset($GLOBALS['flag_single_content']); }
function _facebookmeta(){ global $post, $CORE; ?>

<meta property="og:title" content="<?php echo $post->post_title; ?>" />
<meta property="og:url" content="<?php echo get_permalink($post->ID); ?>" />
<meta property="og:image" content="<?php echo $CORE->GETIMAGE($post->ID, false, array('pathonly' => true) ); ?>" />
<meta property="og:type" content="article" />

<?php }
function handle_post_type_template($single_template) { global $post, $CORE;

  if ($post->post_type == THEME_TAXONOMY."_type") {
	  
		// SET FLAG
	 	$GLOBALS['flag-single'] = 1;
		
		// SINGLE PAGE FILTERS
		add_filter('hook_single_before', array($this, 'TOOLBOX') );
		add_filter('hook_single_before', array($this, '_hook_single1') );
		add_filter('hook_single_after', array($this, '_hook_single2') );
		
		// ADD ON FACEBOOK META
		add_action('wp_head',  array($this, '_facebookmeta') );
	 
		// ADD-ON SLIDER STYLES
		wp_enqueue_script('slider', get_template_directory_uri().'/framework/slider/jquery.flexslider-min.js');
		wp_enqueue_script('slider');
		
		wp_enqueue_script('prettyphoto', get_template_directory_uri().'/framework/slider/jquery.prettyPhoto.js');
		wp_enqueue_script('prettyphoto');
		
		wp_enqueue_style('slider', get_template_directory_uri().'/framework/slider/flexslider.css');
		wp_enqueue_style('slider');
	
		wp_enqueue_style('prettyphoto', get_template_directory_uri().'/framework/slider/prettyPhoto.css');
		wp_enqueue_style('prettyphoto');
			
		// UPDATE VIEW COUNTER
		$CORE->HITCOUNTER($post->ID);
		 	
		// CHECK FOR FORCED LOGIN
		if(isset($GLOBALS['CORE_THEME']['requirelogin']) && $GLOBALS['CORE_THEME']['requirelogin'] == 1){ $CORE->Authorize(); }
		
		// CHECK IF EXPIRED
		$CORE->EXPIRED();
			
		// CHECK FOR TIMEOUT ACCESS
		$canWatch = $CORE->TIMEOUTACCESS($post->ID);
		
		// EXTRA FOR FEEDBACK
		if(isset($_GET['ftyou'])){
		
			$GLOBALS['error_type'] 		= "success"; //ok,warn,error,info
			$GLOBALS['error_message'] 	= $CORE->_e(array('feedback','7'));
				
		}		
     
	 }else{
	 	
		// SET FLAG
		$GLOBALS['flag-blog'] = true; 
	 }
	 
	 //RETURN	 
     return str_replace("single-post.php","single.php",$single_template);
}
function handle_home_template($template_dir) { 
    
	// SET FLAG
	$GLOBALS['flag-home'] = 1;
	
	// MOBILE HOME PAGE
	if(defined('IS_MOBILEVIEW')){
	return str_replace("home.php","home-mobile.php",$template_dir);	
	}
		
	// ACTION
	add_action('hook_header_after', array($this, 'handle_home_template_object1') );
	
	// ACTION
	add_action('hook_core_columns_wrapper_inside_inside', array($this, 'handle_home_template_object2') );
	
	//RETURN
	return $template_dir;
}
function handle_home_template_object1(){ global $OBJECTS;

	// GET HOME PAGE OBJECTS
    if(isset($GLOBALS['CORE_THEME']['homepage']) && isset($GLOBALS['CORE_THEME']['homepage']['widgetblock1']) && strlen($GLOBALS['CORE_THEME']['homepage']['widgetblock1']) > 1){
		echo '<div id="core_homepage_underheader_wrapper">';
        echo $OBJECTS->WIDGETBLOCKS($GLOBALS['CORE_THEME']['homepage']['widgetblock1'], false, true);
		echo '</div>';
     }

}
function handle_home_template_object2(){ global $OBJECTS;

	// GET HOME PAGE OBJECTS
    if(isset($GLOBALS['CORE_THEME']['homepage']) && isset($GLOBALS['CORE_THEME']['homepage']['widgetblock1']) && strlen($GLOBALS['CORE_THEME']['homepage']['widgetblock1']) > 1){
		echo '<div id="core_homepage_fullwidth_wrapper">';
        echo $OBJECTS->WIDGETBLOCKS($GLOBALS['CORE_THEME']['homepage']['widgetblock1'],true, false );
		echo '</div>';
    }

}
function handle_search_template($template_dir) { 

	// SETUP PAGE GLOBALS
	global $wp_query, $post, $CORE, $category, $canShowExtras;
	
	// MOBILE VIEW
	if(defined('IS_MOBILEVIEW')){
	return THEME_PATH. "search-mobile.php";	
	}
 
	// EXTRAS
	if(is_object($post) && $post->post_type == THEME_TAXONOMY."_type"){
 	 	
		// SET FLAG JUST IN CASE WP DOESNT DO IT
		$GLOBALS['flag-search'] = 1; 
		
		// INCLUDE GOOGLE MAP
		//add_action('hook_core_columns_wrapper_inside', array($CORE, 'wlt_googlemap_search') ); 
		add_action('hook_header_after', array($CORE, 'wlt_googlemap_search') ); 
		
		// GLOBALS
		$category = $wp_query->get_queried_object();
		
		// SHOW EXTRAS
		$canShowExtras = true; 
		
		// EXTRA FOR LISTING CATEGORIES
		if($template_dir == ""){			
			$template_dir = THEME_PATH. "search.php";			
		} 
	
	}elseif(is_object($post) && $post->post_type == "post"){
	
		$GLOBALS['flag-blog'] = true; // FLAG FOR WIDGETS
	
	}
		
	//RETURN
	return $template_dir;
}

function gallerypage_item_class($c){ global $post, $CORE; $extra = "";
	 
	// DEFAULTS FOR GALLERY PAGE
	if(isset($GLOBALS['flag-search'])){ 
	 
		switch($GLOBALS['CORE_THEME']['default_gallery_perrow']){
		case "2": { $c = "col-md-6 col-sm-6"; } break;
		case "3": { $c = "col-md-4  col-sm-4"; } break;
		case "4": { $c = "col-md-3  col-sm-3"; } break;
		default: { $c = "col-md-4  col-sm-4"; } break;
		}
 
		// READJUST FOR 3 COLUMN LAYOUTS
		if( $GLOBALS['CORE_THEME']['layout_columns']['search'] == 4){ $c = "col-md-3  col-sm-6"; }
	
	}
	
	// EXTRAS FOR HOME PAGE OBJECTS
	if(isset($GLOBALS['item_class_size'])){ $c = $GLOBALS['item_class_size']; }
	
	// ADD-ON PENDING CLASS FOR VIEWING OWN LISTINGS
	if(isset($_GET['uid']) && ($post->post_status == "pending" || $post->post_status == "draft")){ $extra .= " pending"; }
	 
	// CHANGE SPAN SIZE FOR 3 COLUMN LAYOUTS
	if(isset($GLOBALS['CORE_THEME']['layout_columns']['3columns']) && $GLOBALS['CORE_THEME']['layout_columns']['3columns'] == "1"){ $c = str_replace("col-md-3","col-md-4",$c); }
	 
	//RETURN
	echo hook_content_listing_class($c." item-".$post->ID." col-xs-12".$extra.$CORE->FEATURED($post->ID));
	
}
function gallerypage_results_top(){ global $CORE, $post, $paged, $category, $canShowExtras;

if(!defined('WLT_CART')){ 
 
	if($canShowExtras && isset($category->slug) && ( !isset($paged) || $paged < 2 ) ){ 
	 	
			$top_category_results_string = "";	 $top_category_results_string_e = ""; $i=0; $c=0;
			if(is_object($category)){ 
			$args = array(
			'post_type' => THEME_TAXONOMY.'_type',
				'posts_per_page' => '10',
				'orderby' => 'rand',
				'tax_query' => array(
					array(
						'taxonomy' => THEME_TAXONOMY,
						 'field' => 'id',
						 'terms' => array( $category->term_id ),
					)
				),
				'meta_query' => array(
				   array(
					   'key' => 'topcategory',
					   'value' => 'yes',				 
				   )
			   ),
			);
			
			$my_query = new WP_Query($args);
		 
			while ( $my_query->have_posts() ) {
				$my_query->the_post();
				if(get_post_meta($post->ID,'topcategory',true) == "yes"){
				
				if($i%4){ $ff = ""; }else{ $ff = " butleft"; $i=1; }
				
					// CONTENT LISTING 
					$GLOBALS['item_class_size'] = 'col-md-4';
						
					ob_start();
					get_template_part( 'content', hook_content_templatename($post->post_type) );
					echo "<style>.wlt_search_results .itemid".$post->ID." { display:none; } #catoplist .wlt_search_results .itemid".$post->ID."  { display:block; }</style>";
					$top_category_results_string .= ob_get_contents();
					ob_end_clean();
				 
				
				if($c > 1){
				$top_category_results_string_e .='jQuery("#catoplist .wlt_search_results .item:gt('.$c.')").hide();';
				}
				$i++; $c++;
				}
			}
		}
		if(isset($top_category_results_string) && strlen($top_category_results_string) > 5){
		?> 
   
            <div id="catoplist">
                <div class="wlt_search_results row list_style">
                <?php echo $top_category_results_string; ?>		 
                </div>
            </div>
        <div class="clearfix"></div> 
        <hr />
			<?php if($c > 3){ ?>
            <script type="application/javascript">
            jQuery(document).ready(function() {
                var swapLast = function() {
                <?php echo $top_category_results_string_e; ?>
                    jQuery("#catoplist .wlt_search_results .item:last").delay(7000).slideUp('slow', function() {
                        jQuery(this).delay(5000).remove();
                        jQuery("#catoplist .wlt_search_results").delay(7000).prepend(jQuery(this));
                        jQuery(this).delay(7000).slideDown('slow', function() {
                            swapLast();
                        });
                    });
                }
                
                swapLast();
            });
            </script>
            <?php } ?>
        <?php }
		}		

}// end defined WLT_CART 

}
function gallerypage_results_before(){ global $CORE, $category, $canShowExtras;
  
	// PRINT OUR CATEGORY DESCRIPTION
	if(isset($category->description) && strlen($category->description) > 1 && $GLOBALS['CORE_THEME']['category_descrition'] == 1){ 
		echo "<div class='category_desc'>".nl2br(do_shortcode($category->description))."</div>"; 
	} 
	
	// print out sub categories
	if($GLOBALS['CORE_THEME']['subcategories'] == '1' && $canShowExtras && !isset($_GET['s']) ){ 
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		if ($term->parent == 0) {		 
			$cats = wp_list_categories('echo=0&taxonomy='.THEME_TAXONOMY.'&depth=1&hide_count=0&hide_empty=0&title_li=&child_of=' . $term->term_id);
			
			if(strpos(strtolower($cats), "no c") === false){
			echo '<div id="wlt_core_subcategories">'.str_replace("<li","<span",str_replace("</li>","</span>",$cats)).'<div class="clearfix"></div></div><hr />';
			}
		}	
	}
}

function gallerypage_results_title($c){ global $CORE, $category, $wp_query;
 
	// EXTRASD FOR ZIPCODE SEARCHES
	$title_extra = "";
	if(isset($_GET['zipcode']) && strlen($_GET['zipcode']) > 2){
			$saved_searches = get_option('wlt_saved_zipcodes');
			
			
			if(isset($saved_searches[$_GET['zipcode']]['log'])){
			$longitude 	= $saved_searches[$_GET['zipcode']]['log'];
			}else{ $longitude =0; }
			
			if(isset($saved_searches[$_GET['zipcode']]['lat'])){
			$latitude 	= $saved_searches[$_GET['zipcode']]['lat'];
			}else{ $latitude =0; }			
			
			 
			$title_extra 	= "(".$_GET['zipcode'].") <span class='right' style='text-decoration:underline;'><a href='https://www.google.com/maps/place/".$latitude.",".$longitude."/' rel='nofollow' target='_blank'>".$latitude.",".		$longitude."</a></span>";
		$GLOBALS['CORE_THEME']['default_gallery_map'] = 1;
	}elseif(isset($_GET['s'])){
			$title_extra = ": ".strip_tags($_GET['s']);
	}
		
	if(isset($category->name) && strlen($category->name) > 1){ 
			$c = $category->name; 
	}else{
			$c = $CORE->_e(array('gallerypage','0'))." ".$title_extra;
	} 
	 
return $c;
}
function handle_page_template($template_dir) { global $post, $userdata, $wp_query, $CORE;
 
	if ( is_page_template() ) {
		
		// EXTRAS FOR CALLBACK PAGE
		if(strpos($template_dir, "tpl-callback") !== false){
	  	
		// SET FLAG
		$GLOBALS['flag-callback'] = 1;
		
		// PAYMENT DATA GLOBAL
		global $payment_status, $payment_data;
	 
	 	// ADD HOOK FOR PAYPAL
		add_action('hook_callback','core_paypal_callback');
		add_action('hook_callback','core_usercredit_callback');
		
		// GET PAYMENT RESPONSDE
		$payment_status = hook_callback($_POST);
		$payment_data = $_POST['order_data_raw'];
		
		// AUTO FOR FORCING PAYMENT SUCCESS
		if(isset($_GET['auth'])){ $payment_status = "success"; } 
		 
		// EMAIL OPTIONS
		if(isset($payment_status) && $payment_status != ""){
			switch($payment_status){
				case "thankyou":
				case "success": { $CORE->SENDEMAIL($userdata->user_email,'order_new_sccuess'); } break;
				default: { 
				
				// CHECK FOR LAST EMAIL SENT
				$last_email_sent = get_option('email_order_failed');
				if($last_email_sent == ""){ $last_email_sent = date('Y-m-d H:i:s'); }
				
				if(strtotime(date('Y-m-d H:i:s')) > strtotime($last_email_sent) ) {
				
					// SEND EMAIL
					$CORE->SENDEMAIL($userdata->user_email,'order_new_failed');
					
					// UPDATE LAST SENT
					update_option('email_order_failed', date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s') . "+1 hour")) );
					 
				} 
				 
				} break;
			}
			
			// SEND NEW ORDER IF SUCCESSFUL
			if($payment_status == "success"){
				$CORE->SENDEMAIL('admin','admin_order_new');
			}
		}
		
			// REMOVE SESSIONS
			if(defined('WLT_CART')){
				session_start();
				session_destroy();
				// DELETE STORED SESSION COOKIE
				if (ini_get("session.use_cookies")) {
					$params = session_get_cookie_params();
					setcookie(session_name(), '', time() - 42000,
						$params["path"], $params["domain"],
						$params["secure"], $params["httponly"]
					);
				}
			}
			
		} // END IF CALLBACK
 
	 
	}else{
		
		// SET FLAG
		$GLOBALS['flag-page'] = 1;
		 
 		// CHECK FOR PAGE WIDGET
		$GLOBALS['page_width'] 	= get_post_meta($post->ID, 'width', true);
		if($GLOBALS['page_width'] =="full"){ $GLOBALS['nosidebar-right'] = true; $GLOBALS['nosidebar-left'] = true; }
		 
	}
	
	//RETURN
	return $template_dir;
}
function handle_author_template($template_dir) { global $post,$userdata, $authorID, $listingcount, $wp_query, $CORE;
   
	// SET FLAG 
	$GLOBALS['flag-author'] = 1;
	
	if(isset($_POST['action']) && $_POST['action'] !=""){

		switch($_POST['action']){
		
			case "delfeedback": {	
			 
			$my_post 				= array();
			$my_post['ID'] 			= $_POST['fid'];
			$my_post['post_status'] = "draft";
			wp_update_post( $my_post );	
			
			$GLOBALS['error_message'] 	= "Feedback Deleted";				
			
			} break;
		
		}	
	} 
  
	// GET THE AUTHOR ID 
	if(isset($_GET['author']) && is_numeric($_GET['author'])){
	$authorID = $_GET['author'];
	}else{	
	$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
	$authorID = $author->ID;
	}
		
	// GET LISTING COUNT
	$listingcount = $CORE->count_user_posts_by_type( $authorID, THEME_TAXONOMY."_type" );
	
	//RETURN
	return $template_dir;
}

}
?>
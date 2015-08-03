<?php
 
class wlt_admin {
 
function enqueue(){ global $pagenow;
 
	// ADD IN GLOBAL ADMIN STYLES
	wp_register_style( 'wlt_admin_styles', FRAMREWORK_URI.'admin/css/admin.css');
	wp_enqueue_style( 'wlt_admin_styles' );
	
	//COUNT DOWN TIMER
	wp_register_script( 'countdown',  FRAMREWORK_URI.'js/jquery.countdown.js');
	wp_enqueue_script( 'countdown' );
	
	// LOAD IN WP DIALOG MENU FOR IMAGE UPLOADS
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');	
	 
	if($pagenow == "themes.php" || $pagenow == "theme-install.php" ){
		
		// ADD IN EXTRAS
		wp_register_script( 'ex1',  FRAMREWORK_URI.'admin/js/extra1.js');
		wp_enqueue_script( 'ex1' );
	} 
	
	if($pagenow == "post.php" || $pagenow == "post-new.php" ){ 

		wp_enqueue_script('jquery'); 
	
		// JQUERY UI
		wp_enqueue_style('jquery-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css');
		 
		wp_enqueue_script('jquery-ui-core'); 
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('jquery-ui-tooltip'); 
				
		// DATE PICKER	
		wp_register_script( 'datetimepicker',  FRAMREWORK_URI.'js/bootstrap-datetimepicker.js');
		wp_enqueue_script( 'datetimepicker' );
		
		wp_register_style( 'datepicker1',  FRAMREWORK_URI.'css/css.dateextra.css');
		wp_enqueue_style( 'datepicker1' );
		
		wp_register_style( 'datetimepicker',  FRAMREWORK_URI.'css/css.datetimepicker.css');
		wp_enqueue_style( 'datetimepicker' );
	
	}
	
	// WIDGET ONLY INCLUDES
	if($pagenow == "widgets.php"){ 	 
			 
				wp_enqueue_script('wf_wn_common', THEME_URI .'/framework/widgets/js/wn-common.js', array(), '1.0');
				wp_enqueue_script('wf_wn_tipsy', THEME_URI .'/framework/widgets/js/jquery.tipsy.js', array(), '1.0');
				wp_enqueue_script('jquery-ui-dialog');
				
				wp_enqueue_style('wp-jquery-ui-dialog');
				wp_enqueue_style('wn-style', THEME_URI .'/framework/widgets/css/wn-style.css', array(), '1.0');
		
				// only for IE, no comment :(
				add_action('admin_head', array('wf_wn', 'admin_header'));
		
				// help content for tooltips
				add_action('admin_footer', array('wf_wn', 'admin_footer'));
				wp_register_style( 'extended-tags-widget', THEME_URI .'/framework/widgets/css/widget.css' );
				wp_enqueue_style( 'extended-tags-widget' );	 
				wp_enqueue_style( 'extended-tags-widget', THEME_URI .'/framework/widgets/css/widget-admin.css', false, 0.7, 'screen' );
			  
	} 


}

	function myformatTinyMCE($in) {
		$in['verify_html']=false;
		return $in;
	}	
 
  
   function childtheme_installation( $ggg ){   
	   if(isset($_GET['action']) &&  $_GET['action'] == "install-theme"){	   
	   die("<p>Child theme installed successfully.</p><p>Please activate the plugin <a href='".get_home_url()."/wp-admin/themes.php'>here</a></p>");	   
	   } 
   }
  	function wlt_admin() { global $pagenow, $OBJECTS, $CORE;
	 
	
	// HOOK THE THEME INSTALLATION
	 add_action('upgrader_post_install', array( $this, 'childtheme_installation' ));
	
	// STOP HTML BEING STRIPPED FROM THE EDITOR BOXES
	add_filter('tiny_mce_before_init', array( $this, 'myformatTinyMCE' ) );
	

	add_action( 'add_meta_boxes', array($this, '_meta_boxes' ) );
	add_action('admin_menu', array($this, '_custom_metabox' ) );
	
	// ADMIN SET POST FORM TO ACCEPT FILE UPLOADS
	add_action( 'admin_head', array($this, 'add_post_enctype' ) );
	add_action( 'admin_head', array($this, 'enqueue' ) );
	
	// EDITOR BUTTON
	//if(!isset($_GET['page'])){
	//add_action( 'init', array($this, 'wlt_editor_buttons' ) );
	//}
	
	// DOWNLAOD REPORT
	if(isset($_GET['page']) && $_GET['page'] == "13" && $_POST['runreportnow'] == "yes"){	
		$CORE->reports($_POST['date1'],$_POST['date2'],true);
	}
	
	// SUPPORT PAGE LINK
	if(isset($_GET['page']) && $_GET['page'] == "supportcenter"){
	header("location: http://www.premiumpress.com/forums/?theme=".$GLOBALS['CORE_THEME']['template']."&key=".get_option('wlt_license_key'));
	exit();
	}

	// SUPPORT PAGE LINK
	if(isset($_GET['page']) && $_GET['page'] == "videotutorials"){
	header("location: http://www.premiumpress.com/videos/?theme=".$GLOBALS['CORE_THEME']['template']."&key=".get_option('wlt_license_key'));
	exit();
	}	
	
	// SUPPORT PAGE LINK
	if(isset($_GET['page']) && $_GET['page'] == "childthemes"){
	header("location: http://childthemes.premiumpress.com/?responsive=1&theme=".$GLOBALS['CORE_THEME']['template']."&key=".get_option('wlt_license_key'));
	exit();
	}
	
	add_action('init', array( $this, 'prevent_admin_access' ), 0);
 	
	// ON THEME OVERVIEW PAGE
	if ( is_admin() && $pagenow == 'themes.php'  ) {
	$CORE->UPDATECHILDTHEME();
	}
	 
	// ON ACTIVATION 
	if ( is_admin() && ( isset($_GET['activated'] ) && $pagenow == 'themes.php' ) ) {
	 	
		// CHECK IF THE DEFAULTS HAVE ALREADY BEEN INCLUDED
		$dd = get_option("core_admin_values");
		
		if(!isset($dd['template'])){
		
		// LOAD FRAMEWORK DEFAULTS
		$default_values = array();
		$default_values['mailinglist']		= array("confirmation_title" => "Mailing List Confirmation", 
		"confirmation_message" => "Thank you for joining our mailing list.<br><br>Please click the link below to confirm your email address is valid:<br><br>(link)<br><br>Kind Regards<br><br>Management");
		$default_values['homepage'] 		= array("widgetblock1" => "");
		$default_values['widgetobject'] 	= array();
		$default_values['layout_columns'] 	= array('style' => 'fixed',  '2columns' => '0', 'homepage' => 1, 'search' => 1, 'single' => 1, 'page' => 1);
		$default_values['logo_url'] 		= "Website Logo";
		$default_values['colors'] 			= array('body_text' => '',  'button' => '', 'breadcrumbs' => '', 'breadcrumbs_text' => '', 'header' => '',  'menubar' => '', 'adsearch' => '', 'adsearch_text' => '' );
		$default_values['copyright'] 		= "&copy; Copyright ".date("Y")." - ".get_home_url();
		$default_values['custom'] 			= array('head' => '',  'footer' => '' );
		$default_values['language'] 		= "language_english";
		$default_values['itemcode'] 		= '[IMAGE]<div class="caption"><h1>[TITLE]</h1><div class="details"><span class="tagline">[tagline]</span><br /><div class="hidden_details">[EXCERPT]</div></div></div>'; 
		$default_values['noaccess'] 		= '<div class="well">
		<i class="fa fa-ban" style="color:red;font-size:100px;float:left; margin-right:40px;"></i>
		<div class="center"><h1 style="margin-top:0px;">No Access</h1><h4>Sorry your membership level prevents access to this listing.</h4>
		<p>Please upgrade your membership to gain access to this page.</p>
		</div></div>';  
		$default_values['listingcode']		= '<div class="panel panel-default"> 
			<div class="panel-heading"> [TITLE] </div>
			
				<div class="panel-body">
		 [TOOLBAR]
		[IMAGES]  
		 
		<ul class="nav nav-tabs" id="Tabs">
		  <li class="active"><a href="#t1" data-toggle="tab">{Description}</a></li>
		  <li><a href="#t2" data-toggle="tab">{Details}</a></li>
		  <li><a href="#t3" data-toggle="tab">{Contact}</a></li>
		  <li><a href="#t4" data-toggle="tab">{Comments}</a></li>
		</ul> 
		
		<div class="tab-content">
		  <div class="tab-pane active" id="t1">
		  [TOOLBOX]
		  <h5>[TITLE]</h5>
		  [CONTENT]  
		  [GOOGLEMAP] 
		  </div>
		  <div class="tab-pane" id="t2">
		  [FIELDS]
		  </div>
		  <div class="tab-pane" id="t3">
		  [CONTACT] 
		  </div> 
		  <div class="tab-pane" id="t4">
		  [COMMENTS] 
		  </div>  
		</div> 
		
		</div></div>';
		
		$default_values['fallback_image'] 	= FRAMREWORK_URI."img/img_fallback.jpg";
		$default_values['home'] 			= array('slider' => '0');
		$default_values['responsive'] 		= 1;
		$default_values['packages'] 		= 1;
		$default_values['currency'] 		= array('symbol' => '$', 'code' => 'USD');
		$default_values['custom']['add_text'] = "";
		update_option( "core_admin_values", $default_values); 
		update_option( "disablethemecss", "");		
		
		} // end if		
		
		// DISPLAY WELCOME POINTER
		wp_enqueue_style( 'wp-pointer' );
		wp_enqueue_script( 'jquery-ui' );
		wp_enqueue_script( 'wp-pointer' );
		wp_enqueue_script( 'utils' );
		add_action('admin_footer', array($this, 'pointer_welcome') );
	}
	
 	
	// LOAD IN BOOTSTRAP STYLES FOR EDITOR	
	add_editor_style( FRAMREWORK_URI.'/css/css.bootstrap.css' );
 		
	// SYSTEM RESET
	if(isset($_POST['core_system_reset']) && $_POST['core_system_reset'] == "new"){
			$userdata = wp_get_current_user(); 		
			
			if(user_can($userdata->ID, 'administrator')){
			
			// RESET ALL CORE VALUES
			update_option('wlt_license_key','');
			update_option('wlt_license_upgrade', '');
			update_option("core_theme_defaults_loaded","");
			update_option("core_admin_values","");
			// REDIRECT TO DASHBOARD
			header("location: ".get_home_url().'/wp-admin/index.php');
			exit();
			
			}
		}
				
		// SAVE ADMIN OPTIONS
		if(isset($_POST['submitted']) && $_POST['submitted'] == "yes" && !defined('WLT_DEMOMODE') ){
				
				$existing_values = get_option("core_admin_values");
			 		
				
				// NEW CUSTOM LAYOUT BITS
				if(isset($_POST['admin_values']['customlistingpage']) && $_POST['admin_values']['customlistingpage'] != 0 && $_POST['admin_values']['listingcode'] == ""){
				 
					switch($_POST['admin_values']['customlistingpage']){
						case "9": {
							$_POST['admin_values']['listingcode'] = get_option('wlt_reset_listingcode');
						} break;
						case "1": {							 
							$_POST['admin_values']['listingcode'] = '[DEFAULTLISTINGPAGE1]';
						} break;
						case "2": {						 
							$_POST['admin_values']['listingcode'] = '[DEFAULTLISTINGPAGE2]';							 
						} break;					  
					
					}				
				}
				
				// LOAD IN CUSTOM SEARCH PAGE STYLES
				if(isset($_POST['admin_values']['customsearchpage']) && $_POST['admin_values']['customsearchpage'] != 0 && $_POST['admin_values']['itemcode'] == "" ){
				
					switch($_POST['admin_values']['customsearchpage']){
						case "9": {						 
							$_POST['admin_values']['itemcode'] = get_option('wlt_reset_itemcode');
						} break;
						case "1": {
							$_POST['admin_values']['itemcode'] = "[IMAGE][RATING small=1]<h1>[TITLE]</h1><div class='hidden_details'>[EXCERPT]</div>";
						} break;
						case "2": {
							$_POST['admin_values']['itemcode'] = "[IMAGE][RATING small=1]<h1>[TITLE]</h1><div class='hidden_details'><p class='smallbits'>[DATE][AUTHOR][CATEGORY]</p>[EXCERPT]</div>";
						} break;
						case "3": {
							$_POST['admin_values']['itemcode'] = "[IMAGE right=1][RATING small=1]<h1>[TITLE]</h1><div class='hidden_details'><p class='smallbits'>[DATE][AUTHOR][CATEGORY]</p>[EXCERPT]</div>";
						} break;
						case "4": {
							$_POST['admin_values']['itemcode'] = "[IMAGE right=1][RATING small=1]<h1>[TITLE]</h1><div class='hidden_details'>[EXCERPT]</div>";
						} break;
						case "5": {
							$_POST['admin_values']['itemcode'] = "[IMAGEAUTHOR circle=1 size=100][RATING small=1]<h1>[TITLE]</h1><div class='hidden_details'>[EXCERPT]</div>";
						} break; 
						case "6": {
							$_POST['admin_values']['itemcode'] = "[IMAGEAUTHOR circle=1 size=100]
							<ul class='list-group'>
							<li class='list-group-item'><i class='glyphicon glyphicon-calendar'></i> [DATE]</li>
							<li class='list-group-item'><i class='glyphicon glyphicon-zoom-in'></i> [hits] Views</li>
							<li class='list-group-item'>[RATING]</li>
							</ul>
							<h1>[TITLE]</h1> <div class='hidden_details'>[EXCERPT]</div>";
						} break; 
						case "7": {
							$_POST['admin_values']['itemcode'] = "[IMAGE]
							<ul class='list-group'>
							<li class='list-group-item'><i class='glyphicon glyphicon-calendar'></i> [DATE]</li>
							<li class='list-group-item'><i class='glyphicon glyphicon-zoom-in'></i> [hits] Views</li>
							<li class='list-group-item'>[RATING]</li>
							</ul>
							<h1>[TITLE]</h1> <div class='hidden_details'>[EXCERPT]</div>";
						} break; 
						case "8": {
							$_POST['admin_values']['itemcode'] = "[IMAGE] [RATING small=1]
							<h1>[TITLE]</h1>
							<div class='hidden_details'>[EXCERPT]</div> 
							
							<div class='clearfix'></div>
							<div class='highlight' style='margin:10px -11px -11px -11px;'>
							<div class='col-md-9'>
							<i class='glyphicon glyphicon-calendar'></i> [DATE]
							</div>
							<div class='col-md-3'>
							<i class='glyphicon glyphicon-zoom-in'></i> [hits] Views
							</div>
							<div class='clearfix'></div>
							</div>";
						} break; 						
						case "10": {
						
						$_POST['admin_values']['itemcode'] = "[IMAGE] [RATING small=1]
						<div class='caption'><h1>[TITLE]</h1><div class='hidden_details'>
						<ul>
						<li>[ICON id='fa fa-group' fa=1] [hits] user views &nbsp; &nbsp;  &nbsp;  [ICON id='fa fa-comments' fa=1] [COMMENT_COUNT] reviews</li> 
						<li>  [LOCATION]  </li>
						<li> [DISTANCE]  </li> 
						</ul>  
						<hr />[EXCERPT size=150] <div class='clearfix'></div><hr />
						[BUTTON] <span class='right hidden-xs hidden-sm' style='padding-right:20px; line-height:40px;'>[FAVS]</span>
						[ICON id='fa fa-tags' fa=true] [CATEGORY] [TAGS]
						</div></div>";
						
						} break;
						
					}				
				}
			 
				// CHECK FOR TEMPLATE CHANGE AND ACTIVATE CHILD THEME HOOKS
				if(!isset($_POST['adminArray']['wlt_license_key']) && isset($_POST['admin_values']['template']) && $_POST['admin_values']['template'] != $GLOBALS['CORE_THEME']['template']){
				
					//if(file_exists(str_replace("functions/","",THEME_PATH)."/templates/".$_POST['admin_values']['template']."/_functions.php") ){		
					//include(str_replace("functions/","",THEME_PATH)."/templates/".$_POST['admin_values']['template'].'/_functions.php');
					//}
					// SET A FLAG SO WE KNOW WHAT THE THEME WAS
					$core_themes = array('template_coupon_theme','template_directory_theme','template_video_theme',
					'template_shop_theme','template_joboard_theme','template_realestate_theme','template_ideas_theme','template_classifieds_theme');
					if(in_array($GLOBALS['CORE_THEME']['template'],$core_themes)){
					update_option('wlt_base_theme',$GLOBALS['CORE_THEME']['template']);
					} 
				 								 
				}				
								
				if(isset($_POST['admin_values'])){	
				// GET THE CURRENT VALUES
				$existing_values = get_option("core_admin_values");
				// MERGE WITH EXISTING VALUES
				$new_result = array_merge((array)$existing_values, (array)$_POST['admin_values']);
				// UPDATE DATABASE 		
				update_option( "core_admin_values", $new_result);
				// LEAVE FRIENDLY MESSAGE
				$GLOBALS['error_message'] = "Changes Saved Successfully";
				} 
				
				// SAVE EXTRA DATA
				if(isset($_POST['adminArray'])){
				
					$update_options = $_POST['adminArray']; 
					 
					foreach($update_options as $key => $value){
						if(is_array($value)){			 
							update_option( trim($key), $value);			 
						}else{ 		
							update_option( trim($key), trim($value));
						}		
					}
				
				}
				
				// NEW INSTALL REDIRECT
				if(isset($_POST['newinstall']) && $_POST['newinstall'] == "premiumpress"){				
				header("location: ".get_home_url().'/wp-admin/admin.php?page=premiumpress');
				exit();
				} 
				 					
			}// end if
			 
 
			// CUSTOM CATEGORY EDITS 
			if( isset($_GET['taxonomy']) && isset($_GET['post_type']) && $_GET['post_type'] == THEME_TAXONOMY."_type"  && $_GET['taxonomy'] != "post_tag" ){			
			 
				// Load the pop-up for admin image uploads	
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
				wp_enqueue_style('thickbox');
			 
				add_filter($_GET['taxonomy'].'_edit_form_fields', array( $this, 'my_category_fields'  ) );				 				
				add_filter( 'manage_edit-'.$_GET['taxonomy'].'_columns', array( $this, 'category_id_head' ) );
				add_filter( 'manage_'.$_GET['taxonomy'].'_custom_column', array( $this, 'category_id_row' ), 10, 3 );			
			} // end if
			 
			
			// ADMIN ITEM HOOKS FOR OBJECT CLASS
			add_action('hook_item_cleanup', array($CORE,'ITEM_CLEANUP'));
			add_action('hook_object_list', array($OBJECTS,'DEFAULT_WIDGETBLOCKS_LIST'));	
			add_action('hook_object_settings', array($OBJECTS,'DEFAULT_WIDGETBLOCKS_SETTINGS'));			
			// UPDATE FIELD
			add_filter('edited_terms', array( $this, 'wlt_update_icon_field' )); 			
			// ADD IN FEATURED ITEM DISPLAY			
			add_action( 'post_submitbox_misc_actions', array( $this, 'wlt_metabox' ) );			 	
			// LOAD ALL PREMIUMPRESS ADMIN EDITING DATA	
			add_action('save_post',  array( $this,'wlt_save_post' ));				
				
			// ADD IN FILTERS FOR MANAGING LISTING_TYPE PAGE DISPLAY
			add_action('manage_posts_custom_column', '_admin_custom_column', 10, 2);
			add_filter('manage_posts_columns', '_admin_remove_columns');
			add_filter( 'manage_edit-'.THEME_TAXONOMY.'_type_sortable_columns', '_admin_column_register_sortable' );
			 add_filter( 'request', '_admin_column_orderby' );
			add_filter( 'manage_posts_columns', '_admin_custom_columns' );	
			add_action( 'admin_head', '_admin_extra_css' );
			///add_action('quick_edit_custom_box',  '_add_quick_edit', 10, 2); <-- TRY AGAIN LATER
			// CUSTOMIZE THE MANAGE USER PAGE TO DISPLAY CORRECT LISTING COUNT
			add_filter('manage_users_columns', array($this, 'contributes' ) );
			add_action('manage_users_custom_column', array($this, 'contributes_columns' ) , 10, 3);		
			add_filter( 'manage_users_sortable_columns', array($this, 'contributes_sortable_columns' ) );

	
			// ADMIN USER FIELDS
			add_filter('user_contactmethods', array($this,'userfields'),10,1); 
			add_action( 'show_user_profile', array($this,'extra_user_profile_fields') );
			add_action( 'edit_user_profile', array($this,'extra_user_profile_fields') );
			add_action( 'personal_options_update', array($this,'save_extra_user_profile_fields') );
			add_action( 'edit_user_profile_update', array($this,'save_extra_user_profile_fields') );					
			add_action('hook_edit_fields_metabox', array($this, 'wlt_default_metabox_fields' ));
		 	
			// QUICK EDIT LINKS
			add_filter('post_row_actions', array($this, 'extra_post_row_actions' ));
		  
			// CHECK FOR FIRST TIME INSTALLATION
			if(get_option("core_theme_defaults_loaded") == "" && isset($_POST['adminArray']['wlt_license_key']) ){			
				$GLOBALS['CORE_THEME']['template'] = $_POST['admin_values']['template'];
				if(!isset($_POST['adminArray']['wlt_license_key_error'])){				
				$this->FIRSTTIMEINSTALL();		 
				}
		 
				if($CORE->UPDATE_CHECK() == "0.0.0"){
					header("location: ".get_home_url().'/wp-admin/admin.php?page=premiumpress');
					exit();
				}else{
					header("location: ".get_home_url().'/wp-admin/admin.php?page=1&firstinstall=1');
					exit();
				}// END IF
			}// END IF
			
			// DISPLAY FIRST INSTALLATION POINTER
			if(isset($_GET['firstinstall'])){			
			wp_enqueue_style( 'wp-pointer' );
			wp_enqueue_script( 'jquery-ui' );
			wp_enqueue_script( 'wp-pointer' );
			wp_enqueue_script( 'utils' );
			add_action('admin_footer', array($this, 'pointer_intro') );
			}
			
			add_action('admin_footer', array($this, 'custom_permalinks') );
			// ADD OPTIONS TO PERMALINKS PAGE
			
			//CHILD THEME DOWNLOAD
			add_action('admin_init', array($this,'create_childtheme') );
			
			// VIEW ALL AUTHORD VIA THE ADMIN
			add_filter('wp_dropdown_users', array($this, 'MySwitchUser' ) );		


	} // end if is_admin()
	
/* =============================================================================
	DSPLAY SETTINGS FOR INSTALLATION
	========================================================================== */
function MySwitchUser($output)
{

    global $post, $wpdb;
    $users = get_users();

    $output = "<select id=\"post_author_override\" name=\"post_author_override\" class=\"\">";

    //Leave the admin in the list
    //$output .= "<option value=\"1\">Admin</option>";
	if(is_array( $users )){
    foreach($users as $user)
    {
        $sel = ($post->post_author == $user->ID)?"selected='selected'":'';
        $output .= '<option value="'.$user->ID.'"'.$sel.'>'.$user->user_login.'</option>';
    }
	}
    $output .= "</select>";

    return $output;
}	
/* =============================================================================
	DSPLAY SETTINGS FOR INSTALLATION
	========================================================================== */
//$CORE_ADMIN->FIRSTTIMEINSTALL('template_video_theme');	
function FIRSTTIMEINSTALL($test=false){ global $wpdb, $CORE; $CORE->taxonomies(); $GLOBALS['theme_defaults'] = array();
 
// SETUP A TEST ENVIROMENT FOR TESTING RESET TYPES
if(strlen($test) > 5){
	// RESET ALL CORE VALUES
	$_POST['admin_values']['template'] 		= $test;
	update_option('wlt_license_key','1234567');
	update_option("core_theme_defaults_loaded","");
	update_option("core_admin_values","");
}

// [MYSQL] DROP ALL OF THE TABLES LINKED TO OUR THEMES
$wpdb->query("delete a,b,c,d
			FROM ".$wpdb->prefix."posts a
			LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
			LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
			LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
			LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
			WHERE a.post_type ='".THEME_TAXONOMY."_type'");

// 2. DELETE ALL CATEGORIES
$terms = get_terms(THEME_TAXONOMY, 'orderby=count&hide_empty=0');	 
$count = count($terms);
if ( $count > 0 ){				
		foreach ( $terms as $term ) {
			wp_delete_term( $term->term_id, THEME_TAXONOMY );
		}
}

// [MYSQL] INSTALL MAILING LIST TABLE
$wpdb->query("DROP TABLE `".$wpdb->prefix."core_log`");
$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."core_log` (
	`autoid` INT( 10 ) NOT NULL AUTO_INCREMENT ,
	`datetime` DATETIME NOT NULL ,
	`userid` INT( 10 ) NOT NULL ,
	`postid` INT( 10 ) NOT NULL ,
	`link` VARCHAR( 255 ) NOT NULL ,
	`message` VARCHAR( 255 ) NOT NULL ,
	PRIMARY KEY (  `autoid` ))");
$wpdb->query("DROP TABLE `".$wpdb->prefix."core_mailinglist`");
$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."core_mailinglist` (
 `autoid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `email_hash` varchar(50) NOT NULL,
  `email_ip` varchar(50) NOT NULL,
  `email_date` datetime NOT NULL,
  `email_firstname` varchar(150) NOT NULL,
  `email_lastname` varchar(150) NOT NULL,
  `email_confirmed` int(11) NOT NULL,
  PRIMARY KEY (`autoid`),
  UNIQUE KEY `email` (`email`))");
// [MYSQL] INSTALL ORDERS TABLE
$wpdb->query("DROP TABLE `".$wpdb->prefix."core_orders`");
$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."core_orders` (
  `autoid` mediumint(10) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(10) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `order_ip` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `order_time` time NOT NULL,
  `order_data` longtext NOT NULL,
  `order_items` longtext NOT NULL,
  `order_email` varchar(255) NOT NULL,
  `order_shipping` varchar(10) NOT NULL,
  `order_tax` varchar(10) NOT NULL,
  `order_total` varchar(10) NOT NULL,
  `order_status` int(1) NOT NULL DEFAULT '0',
  `user_login_name` varchar(100) NOT NULL,
  `shipping_label` longtext NOT NULL,
  `payment_data` longtext NOT NULL,
  PRIMARY KEY (`autoid`))");
  // [MYSQL] INSTALL WITHDRAWAL TABLE
$wpdb->query("DROP TABLE `".$wpdb->prefix."core_withdrawal`");
$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."core_withdrawal` (
  `autoid` mediumint(10) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(10) NOT NULL, 
  `user_ip` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL,
  `withdrawal_comments` longtext NOT NULL,
  `withdrawal_status` int(1) NOT NULL DEFAULT '0', 
  `withdrawal_total` varchar(10) NOT NULL,  
  PRIMARY KEY (`autoid`))");
// [MYSQL] INSTALL SEARCH TABLE
$wpdb->query("DROP TABLE ".$wpdb->prefix."core_search");
$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."core_search` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `label` varchar(50) NULL,
            `description` varchar(100) NULL,
            `type` varchar(10) NULL,
            `operator` varchar(10) NULL,
            `compare` varchar(10) NULL,
            `values` text NULL,
            `key` varchar(20) NULL,
            `alias` varchar(20) NULL,
            `field_type` varchar(15) NULL,
            `order` smallint(2) NULL,
			`link` varchar(100),
            PRIMARY KEY (`id`)
            )");
// [MYSQL] INSTALL SESSION TABLE FOR CART
 $wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."core_sessions` (
  `session_key` varchar(255) NOT NULL,
  `session_date` datetime NOT NULL,
  `session_userid` int(10) NOT NULL,
  `session_data` text NOT NULL,
  PRIMARY KEY (`session_key`))");
 		
	// SAMPLE DATA
	if($_POST['admin_values']['template'] != "template_dating_theme"){
	$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (2, 'Keyword', '', 'search', '', '', '', '', '', '', 0, NULL);");
	$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (3, 'Category', '', 'taxonomy', '', 'IN', '', 'listing', 'yes', 'link', 5, '');");
	}
	
	
	$no_showa = array('template_directory_theme','template_docs_theme','template_coupon_theme','template_dating_theme');
		if(!in_array($_POST['admin_values']['template'],$no_showa) ){
$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (4, 'Min.Price', '', 'custom', 'NUMERIC', '>=', '', 'price', 'yes', 'text', 2, NULL);");
$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (5, 'Max.Price', '', 'custom', 'NUMERIC', '<=', '', 'price', 'yes', 'text', 3, NULL);"); 
} 

if($_POST['admin_values']['template'] == "templater_dealer_theme"){

$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (6, 'Make', '', 'taxonomy', '', 'IN', '', 'make', 'yes', '', 3, 'model');"); 
$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (7, 'Model', '', 'taxonomy', '', 'IN', '', 'model', 'yes', '', 3, '');");

$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (8, 'Year', '', 'custom', 'NUMERIC', '=', '', 'year', 'yes', 'select', 3, NULL);"); 

$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (9, 'Type', '', 'custom', 'NUMERIC', '=', '', 'ctype', 'yes', 'select', 3, NULL);"); 

$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (10, 'Status', '', 'custom', 'NUMERIC', '=', '', 'cstatus', 'yes', 'select', 3, NULL);"); 

} 

if($_POST['admin_values']['template'] == "template_dating_theme"){

$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (2, 'I\'m a', '', 'custom', 'NUMERIC', '=', '', 'daseeking', 'yes', 'select', 3, NULL);"); 
$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (3, 'Seeking a', '', 'custom', 'NUMERIC', '=', '', 'dagender', 'yes', 'select', 3, NULL);");

$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (4, 'Aged Between', '', 'custom', 'NUMERIC', '>=', '', 'daage', 'yes', 'select', 4, NULL);"); 

$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (5, 'And', '', 'custom', 'NUMERIC', '<=', '', 'daage', 'yes', 'select', 5, NULL);"); 

} 
  
// [WORDPRESS] DEFAULT MEDIA OPTIONS
update_option('thumbnail_size_w', 300);
update_option('thumbnail_size_h', 350);
update_option('thumbnail_crop', 0);	 
update_option('core_post_types', ''); 
update_option('posts_per_page', '12');
update_option('recent_searches','');

// [PAGES] CREATE DEFAULT THEME PAGES
$page_links = array();
$theme_pages = array( "My Account" => "tpl-account.php", "Blog" => "tpl-blog.php", "Callback" => "tpl-callback.php", "Sample CSS" => "tpl-elements.php", "Contact" => "tpl-contact.php" );

if($_POST['admin_values']['template'] == "template_shop_theme"){
$theme_pages = array_merge($theme_pages, array("Checkout" => "tpl-checkout.php", "Contact" => "tpl-contact.php"));
}elseif($_POST['admin_values']['template'] == "template_dating_theme"){
$theme_pages =  array("My Account" => "tpl-account.php", "Blog" => "tpl-blog.php", "Callback" => "tpl-callback.php", "Add Profile" => "tpl-add.php", "Chat Room" => "tpl-chatroom.php", "Contact" => "tpl-contact.php" );
}else{
$theme_pages = array_merge($theme_pages, array("Add Listing" => "tpl-add.php", "Members" => "tpl-members.php", "Contact" => "tpl-contact.php" ));
}


foreach($theme_pages as $ntitle => $nkey){

	$page = array();
	$page['post_title'] 	= $ntitle;
	$page['post_content'] 	= '';
	$page['post_status'] 	= 'publish';
	$page['post_type'] 		= 'page';
	$page['post_author'] 	= 1;
	$page_id = wp_insert_post( $page );
	update_post_meta($page_id , '_wp_page_template', $nkey);
	$page_links[$nkey] = get_permalink($page_id);

}
if($_POST['admin_values']['template'] == "template_shop_theme"){
$GLOBALS['theme_defaults']['links']  = array('blog' => $page_links['tpl-blog.php'], 'myaccount' => $page_links['tpl-account.php'], 'callback' => $page_links['tpl-callback.php'], 'checkout' => $page_links['tpl-checkout.php'], "contact" =>  $page_links['tpl-contact.php'] );
}else{
$GLOBALS['theme_defaults']['links']  = array('blog' => $page_links['tpl-blog.php'],'myaccount' => $page_links['tpl-account.php'], 'add' => $page_links['tpl-add.php'], 'callback' => $page_links['tpl-callback.php'], 'members' => $page_links['tpl-members.php'], "contact" => $page_links['tpl-contact.php']  );
}

// [WIDGETS]
update_option('sidebars_widgets',''); $addWidget = array();
   
// FOOTER WIDGETS
$addWidget[0]['name'] = 'text';
$addWidget[0]['sidebar'] = 'sidebar-3';
$addWidget[0]['defaults'] = array('title'=>'Example Footer Widget', 'text'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.');

$addWidget[1]['name'] = 'text';
$addWidget[1]['sidebar'] = 'sidebar-4';
$addWidget[1]['defaults'] = array('title'=>'Example Footer Widget', 'text'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.');

$addWidget[2]['name'] = 'text';
$addWidget[2]['sidebar'] = 'sidebar-5';
$addWidget[2]['defaults'] = array('title'=>'Example Footer Widget', 'text'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.');

// LEFT SIDEBAR WIDGET
$addWidget[3]['name'] = 'core_author';
$addWidget[3]['sidebar'] = 'sidebar-2';
$addWidget[3]['defaults'] = array('title'=>'Author Widget', 'p' => true, 'e' => true, 'f2' => true, 'f1' => true, 'f3' => true, 'f4' => true);		

/*
$addWidget[4]['name'] = 'core_widgets_listings';
$addWidget[4]['sidebar'] = 'sidebar-2';
$addWidget[4]['defaults'] = array('title'=>'Listings Widget', 'sq' => 'post_type=listing_type&posts_per_page=10', 'te' => '[TITLE]<div class="clearfix"></div>[EXCERPT size=60]', 'image' => true);		
*/

$addWidget[4]['name'] = 'advanced-search';
$addWidget[4]['sidebar'] = 'sidebar-2';
$addWidget[4]['defaults'] = array('title'=>'Advanced Search', 'submit' =>'Search');		


$addWidget[5]['name'] = 'core_widgets_categories';
$addWidget[5]['sidebar'] = 'sidebar-2';
$addWidget[5]['defaults'] = array('title'=>'Categories Widget', 'empty' => true);		


//$addWidget[7]['name'] = 'core_memberships';
//$addWidget[7]['sidebar'] = 'sidebar-2';
//$addWidget[7]['defaults'] = array('title'=>'Membership Widget');		
/*
$addWidget[8]['name'] = 'text';
$addWidget[8]['sidebar'] = 'sidebar-2';
$addWidget[8]['defaults'] = array('title'=>'Example Text Widget', 'text'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.');		

*/

$addWidget[6]['name'] = 'core_widgets_mailinglist';
$addWidget[6]['sidebar'] = 'sidebar-2';
$addWidget[6]['defaults'] = array('title'=>'Example Newsletter Widget', 'te' => 'Your own text here to entice users to signup.', 'ff' => 2);		

// RIGHT SIDEBAR WIDGETS 
$addWidget[7]['name'] = 'core_author';
$addWidget[7]['sidebar'] = 'sidebar-1';
$addWidget[7]['defaults'] = array('title'=>'Author Widget', 'p' => true, 'e' => true, 'f2' => true, 'f1' => true, 'f3' => true, 'f4' => true);		

/*
$addWidget[11]['name'] = 'core_widgets_listings';
$addWidget[11]['sidebar'] = 'sidebar-1';
$addWidget[11]['defaults'] = array('title'=>'Listings Widget', 'sq' => 'post_type=listing_type&posts_per_page=10', 'te' => '<b>[TITLE]</b><div class="clearfix"></div> [EXCERPT size=100]', 'image' => true);		

*/

$addWidget[8]['name'] = 'advanced-search';
$addWidget[8]['sidebar'] = 'sidebar-1';
$addWidget[8]['defaults'] = array('title'=>'Advanced Search', 'submit' =>'Search');		


$addWidget[9]['name'] = 'core_widgets_categories';
$addWidget[9]['sidebar'] = 'sidebar-1';
$addWidget[9]['defaults'] = array('title'=>'Categories Widget', 'empty' => true);		


//$addWidget[14]['name'] = 'core_memberships';
//$addWidget[14]['sidebar'] = 'sidebar-1';
//$addWidget[14]['defaults'] = array('title'=>'Membership Widget');		
/*
$addWidget[10]['name'] = 'text';
$addWidget[10]['sidebar'] = 'sidebar-1';
$addWidget[10]['defaults'] = array('title'=>'Example Text Widget', 'text'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.');		
*/

$addWidget[10]['name'] = 'core_widgets_mailinglist';
$addWidget[10]['sidebar'] = 'sidebar-1';
$addWidget[10]['defaults'] = array('title'=>'Example Newsletter Widget', 'te' => 'Your own text here to entice users to signup.', 'ff' => 2);		
 
	
	$sidebar_options = get_option('sidebars_widgets');
	
	$count=0;
	foreach($addWidget as $widget){    

		if(!isset($sidebar_options[$widget['sidebar']])){
			$sidebar_options[$widget['sidebar']] = array('_multiwidget'=>1);
		}
		$homepagewidget = get_option($widget['name']);
		
		if(!is_array($homepagewidget))$homepagewidget = array();
		$count = count($homepagewidget)+1;
		
		// add first widget to sidebar:
		$sidebar_options[$widget['sidebar']][] = $widget['name'].'-'.$count;
		
		$values[$count] = $widget['defaults'];
		
		update_option('widget_' .$widget['name'],$values);
		
		$count++;	
	}
	
	update_option('sidebars_widgets',$sidebar_options);
	
	// DEFAULT THEME SETUP
	
	/*** GEO LOCATION ***/
	$GLOBALS['theme_defaults']['geolocation'] = 1;
	
	/*** HEADER ***/
	$GLOBALS['theme_defaults']['header_welcometext']= "Your own text here.";
	$GLOBALS['theme_defaults']['logo_url'] 			= THEME_URI."/templates/".$_POST['admin_values']['template']."/img/logo.png";
	
	/*** FOOTER ***/
	$GLOBALS['theme_defaults']['copyright'] 		= "&copy; Copyright ".date("Y")." - ".get_home_url();
	$GLOBALS['theme_defaults']['language'] 			= "language_english";
	$GLOBALS['theme_defaults']['social'] 			= array('twitter' => '##', 'facebook' => '##', 'youtube' => '##', 'dribble' => '##', 'linkedin' => '##', 'rss' => '##');
	
	/*** SEARCH/LISTINGS ***/
	$GLOBALS['theme_defaults']['display'] = array();
	$GLOBALS['theme_defaults']['display']['orderby'] = 'system';
	$GLOBALS['theme_defaults']['category_descrition'] = 1;
	$GLOBALS['theme_defaults']['related_perpage'] = 3;
	$GLOBALS['theme_defaults']['showlistingdetails'] = 1;
	
	/*** ADDTHIS SOCIAL ***/
	$GLOBALS['theme_defaults']['addthis'] = 1;
	$GLOBALS['theme_defaults']['addthis_name'] = "premiumpress";
	
	/*** INVOICE ***/
	$GLOBALS['theme_defaults']['invoice'] = array("name" => "My Company Name", "address" => "My Comapny Address");
	
	/*** RATING ***/
	$GLOBALS['theme_defaults']['rating'] = 1;
	$GLOBALS['theme_defaults']['rating_as'] = 0;
	$GLOBALS['theme_defaults']['rating_type'] = 1;
	if(defined('WLT_COUPON')){
	$GLOBALS['theme_defaults']['rating_type'] = 9;
	}
	if(defined('WLT_CART')){
	$GLOBALS['theme_defaults']['rating'] = 0;
	}
	/*** BREADCRUMBS ***/
	$GLOBALS['theme_defaults']['breadcrumbs_inner'] = 1;
	$GLOBALS['theme_defaults']['breadcrumbs_home'] = 0;
	$GLOBALS['theme_defaults']['breadcrumbs_userlinks'] = 1;
	
	/*** USER ACCOUNT SETTINGS ***/	
	$GLOBALS['theme_defaults']['show_account_edit'] 	= 1;
	$GLOBALS['theme_defaults']['message_system'] 		= 1;
	$GLOBALS['theme_defaults']['show_account_create'] 	= 1;
	$GLOBALS['theme_defaults']['show_account_viewing'] 	= 1;
	$GLOBALS['theme_defaults']['show_account_membership'] = 0;
	$GLOBALS['theme_defaults']['show_account_favs'] 	= 1;
	
	/**** MOBILE WEB ****/
	$GLOBALS['theme_defaults']['mobileweb_logo'] = "<span>Mobile</span> Web";
	
	/*** FEEDBACK ***/
	$GLOBALS['theme_defaults']['feedback_enable'] 	= 1;
	
 	/*** ADMIN OPTIONS ***/
	$GLOBALS['theme_defaults']['wordpress_welcomeemail'] = 0;
	$GLOBALS['theme_defaults']['admin_liveeditor'] 	= 0;
	$GLOBALS['theme_defaults']['colors'] 			= array('body_text' => '',  'button' => '', 'breadcrumbs' => '', 'breadcrumbs_text' => '', 'header' => '',  'menubar' => '', 'adsearch' => '', 'adsearch_text' => '' );
	$GLOBALS['theme_defaults']['custom'] 			= array('head' => '',  'footer' => '' );
	$GLOBALS['theme_defaults']['itemcode'] 			= '';		  
	$GLOBALS['theme_defaults']['listingcode']		= '';		
	$GLOBALS['theme_defaults']['fallback_image'] 	= FRAMREWORK_URI."img/img_fallback.jpg";
	$GLOBALS['theme_defaults']['responsive'] 		= 1;
	$GLOBALS['theme_defaults']['packages'] 			= 1;
	$GLOBALS['theme_defaults']['currency'] 			= array('symbol' => '$', 'code' => 'USD');
	$GLOBALS['theme_defaults']['mailinglist']		= array("confirmation_title" => "Mailing List Confirmation", 
		"confirmation_message" => "Thank you for joining our mailing list.<br><br>Please click the link below to confirm your email address is valid:<br><br>(link)<br><br>Kind Regards<br><br>Management");
	
	/*** PACKAGES AND MEMBERSHIPS ***/
	if(!defined('WLT_CART')){
	$GLOBALS['theme_defaults']['google'] 					= 1;
	$GLOBALS['theme_defaults']['visitor_submission'] 		= 1;
	$GLOBALS['theme_defaults']['show_enhancements'] 		= 1;
	$GLOBALS['theme_defaults']['show_upgradeoptions'] 		= 1;
	$GLOBALS['theme_defaults']['default_listing_status'] 	= "publish";
	$GLOBALS['theme_defaults']['enhancement'] 		= array('1_price' => '10', '2_price' => '15', '3_price' => '10', '4_price' => '10', '5_price' => '5', '6_price' => '15');
	
	$GLOBALS['theme_defaults']['custom']['package_text'] 		= "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.";
	
	// ADD IN USERS
	$users = array( 
	"1" => array("n" => "Mark", 	"i" => "1.jpg"),
	"2" => array("n" => "Karen", 	"i" => "2.jpg"),
	"3" => array("n" => "Jane", 	"i" => "3.jpg"),
	"4" => array("n" => "Jake", 	"i" => "4.jpg"),
	"5" => array("n" => "Frank", 	"i" => "5.jpg"),
	"6" => array("n" => "Gary", 	"i" => "6.jpg"),
	"7" => array("n" => "Sophie", 	"i" => "7.jpg"),
	"8" => array("n" => "Jamie", 	"i" => "8.jpg"),
	);
	foreach($users as $nu){
	
		// CREATE USER
		$userID = wp_create_user( $nu['n'], 'password', $nu['n'].'@hotmail.com' );
 		
		// DEFAULTS
		update_user_meta($userID, 'login_lastdate', date("Y-m-d H:i:s"));
		update_user_meta($userID, 'login_ip', $CORE->get_client_ip());
		update_user_meta($userID, 'login_count', 0);
	
		// SOCIAL
		update_user_meta($userID, 'phone', '(000) 1234 12345');		
		update_user_meta($userID, 'url', 'http://www.premiumpress.com');
		update_user_meta($userID, 'facebook', 'http://www.premiumpress.com');
		update_user_meta($userID, 'twitter', 'http://www.premiumpress.com');
		update_user_meta($userID, 'linkedin', 'http://www.premiumpress.com');
		update_user_meta($userID, 'skype', 'premiumpress');
	}
	
 	
	$pdata = array(
	"0" => array ( "enable_text" => 1, "expires" => "30", "multiple_cats_amount" => "30", "max_uploads" => "30", "ID"=>"0", "order" => "1", "price" => "10", "name" =>"Example Package 1", "subtext" => "Special Offer!", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.", "multiple_cats" => "1", "multiple_images" => "1",
	 "image" => FRAMREWORK_URI."img/img_package.jpg" ),
	"1" => array ( "enable_text" => 1, "expires" => "30", "multiple_cats_amount" => "30", "max_uploads" => "30", "ID"=>"1", "order" => "2", "price" => "20", "name" =>"Example Package 2", "subtext" => "Most Popular", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.", "multiple_cats" => "1", "multiple_images" => "1", "image" => FRAMREWORK_URI."img/img_package.jpg"  ),
	 "2" => array ( "enable_text" => 1, "expires" => "30", "multiple_cats_amount" => "30", "max_uploads" => "30", "ID"=>"2", "order" => "3", "price" => "30", "name" =>"Example Package 3", "subtext" => "Great Value!", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.", "multiple_cats" => "1", "multiple_images" => "1", "image" => FRAMREWORK_URI."img/img_package.jpg"  ),
	 "3" => array ( "enable_text" => 1, "expires" => "30", "multiple_cats_amount" => "30", "max_uploads" => "30", "ID"=>"3", "order" => "4", "price" => "100", "name" =>"Example Package 4", "subtext" => "Big Savings!", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.", "multiple_cats" => "1", "multiple_images" => "1", "image" => FRAMREWORK_URI."img/img_package.jpg"  ),
	); 
	update_option('packagefields',$pdata);

	$mdata = array(
	"0" => array ( "submissionamount" => "10", "ID"=>"0", "order" => "1", "price" => "20.99", "name" =>"Example Membership 1", "subtext" => "30 Day Membership", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.", "multiple_cats" => "1", "multiple_images" => "1",
	 "image" => FRAMREWORK_URI."img/img_package.jpg", "expires" => "30" ),
	"1" => array ( "submissionamount" => "20", "ID"=>"1", "order" => "2", "price" => "149.99", "name" =>"Example Membership 2", "subtext" => "90 Day Membership", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.", "multiple_cats" => "1", "multiple_images" => "1", "image" => FRAMREWORK_URI."img/img_package.jpg", "expires" => "90"  ),
	 "2" => array ( "submissionamount" => "30", "ID"=>"2", "order" => "3", "price" => "200", "name" =>"Example Membership 3", "subtext" => "180 Day Membership", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.", "multiple_cats" => "1", "multiple_images" => "1", "image" => FRAMREWORK_URI."img/img_package.jpg", "expires" => "180"  ),
	 "3" => array ( "submissionamount" => "40", "ID"=>"3", "order" => "4", "price" => "299", "name" =>"Example Membership 4", "subtext" => "1 Year Membership", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.", "multiple_cats" => "1", "multiple_images" => "1", "image" => FRAMREWORK_URI."img/img_package.jpg", "expires" => "365"  ),
	); 
	update_option('membershipfields',$mdata); 
	}

	// LOAD IN CORE RESET OPTIONS 
	if(file_exists(str_replace("functions/","",THEME_PATH)."/templates/".$_POST['admin_values']['template']."/_reset.php") ){	
 
		// INCLUDE CUSTOM DATA FROM RESET FILE
		include(str_replace("functions/","",THEME_PATH)."/templates/".$_POST['admin_values']['template'].'/_reset.php');
		
		// LETS THE RESET FUNCTION HAPPEN
		do_action('hook_new_install'); 
 		
		// UPDATE BASE THEME
		update_option('wlt_base_theme',$GLOBALS['theme_defaults']['template']);
 		
	}// END IF	
	
	
	// FINALLY, SAVE IT ALL AND UPDATE DATABASE 		
	update_option( "core_admin_values",  array_merge((array)get_option("core_admin_values"), $GLOBALS['theme_defaults'])); 		
			
	$GLOBALS['error_message'] = "Example Information Installed";
 		
	 
}// END FUNCTION

 
	function wlt_editor_buttons() {
		add_filter( "mce_external_plugins", array($this, "wlt_editor_add_buttons" ) );
		add_filter( 'mce_buttons', array($this, 'wlt_editor_register_buttons' ) );
	}
	function wlt_editor_add_buttons( $plugin_array ) {
		$plugin_array['premiumpresseditor'] = get_template_directory_uri() . '/framework/js/core.editorbutton.js';
		return $plugin_array;
	}
	function wlt_editor_register_buttons( $buttons ) {
		array_push( $buttons, 'premiumpress'); 
		return $buttons;
	}
	function contributes_sortable_columns( $columns ) {
		$columns['c1'] = __("Listings", THEME_TAXONOMY);
		$columns['c2'] = __("Credit");
		return $columns;
	}
	function contributes($columns) {
			$columns['c1'] = __("Listings", THEME_TAXONOMY);
			$columns['c2'] = __("Credit");
			return $columns;
	}		
	function contributes_columns( $value, $column_name, $user_id ) { global $wp_query;
			
			if ( 'c1' != $column_name && 'c2' != $column_name ){ return $value; }
 			
			if($column_name == "c1"){
			
				$column_title = "Listings";
				$column_slug = THEME_TAXONOMY;
				$posts = query_posts('post_type='.$column_slug.'_type&author='.$user_id.'&order=ASC&posts_per_page=30');//Replace post_type=contribute with the post_type=yourCustomPostName
				$posts_count = "<a href='edit.php?post_type=".THEME_TAXONOMY."_type&author=".$user_id."' style='text-decoration:underline; font-weight:bold;'>".count($posts)."</a>";			 
				return $posts_count;
			
			}elseif($column_name == "c2"){
			
				$user_balance = get_user_meta($user_id,'wlt_usercredit',true);
				if($user_balance == ""){ $user_balance = 0; }
				return hook_price($user_balance);
			
			}
	}	
	function custom_permalinks(){ global $pagenow;
	
		if($pagenow == "options-permalink.php" ){  
		
		$default_perm = get_option('premiumpress_custompermalink');
		$default_perm1 = get_option('premiumpress_customcategorypermalink');
		if($default_perm == ""){
		$default_perm = THEME_TAXONOMY;
		}
		if($default_perm1 == ""){
		$default_perm1 = $default_perm."-category";
		}
	  
			echo "<script> 
			jQuery(document).ready(function(){
				jQuery('table.permalink-structure').prepend( '<tr><th><label><input type=\"hidden\" name=\"submitted\" value=\"yes\">PremiumPress Custom Slugs</label></th><td> <b> Listing Slug Name</b><br /><input name=\"adminArray[premiumpress_custompermalink]\" type=\"text\" value=\"".$default_perm."\" class=\"regular-text code\"><br><b> Category Slug Name</b><br /><input name=\"adminArray[premiumpress_customcategorypermalink]\" type=\"text\" value=\"".$default_perm1."\" class=\"regular-text code\"><p><p>IMPORTANT. This option will let you change the slug display name from /listing/ to your chosen value however doing so will change all of your existing listing permalinks. <br />This option is not recommend for established website as it will result in many 404 errors for existing listing.</p></td></tr>' );
			});
			</script>";		
		
		}
	}
	
	function create_childtheme(){global $userdata, $wpdb;
	
	if(isset($_GET['exportall']) && is_numeric($_GET['exportall']) ){
	 		
			$csv_output = ''; $ex  = ''; $dont_show_fields = array('autoid','payment_data','');
			
			if($_GET['exportall'] == 1){
				
				$file_name = "mailinglist";	
				$table = $wpdb->prefix."core_mailinglist";	  
				$RUNTHISSQL = "SELECT * FROM ". $wpdb->prefix."core_mailinglist";
			
			}elseif($_GET['exportall'] == 2){
						
				$file_name = "orderhistory";		
				$table = $wpdb->prefix."core_orders";	 
				$RUNTHISSQL = "SELECT * FROM ". $wpdb->prefix."core_orders GROUP BY order_id ORDER BY order_date";
			 
			}else{
				die("no table set");
			}			
	 
	 		// RUN QUERIES
			$headers = $wpdb->get_results("SHOW COLUMNS FROM ".$table."", ARRAY_A);
			$values = $wpdb->get_results($RUNTHISSQL, ARRAY_N);
			
			// GET HEADERS
			$csv_headers = array();
			if (!empty($headers)) {
				foreach($headers as $row){					
					$csv_headers[] =  $row['Field'];
				}				
			}
			
			// GET VALUES
			$csv_values = array();
			if (!empty($values)) {				
				foreach($values as $k => $row){				 			 
					$csv_values[] =  $row;					
				}				
			}			
			 
			// ADD-ON HEADERS
			foreach($csv_headers as $col_V){
				if(in_array($col_V,$dont_show_fields) ){ continue; }					 
				$csv_output .= str_replace("_"," ",$col_V).",";				 
			}
			
			// NEW LINE				
			$csv_output .= "\n";
			
			// ADD-ON VALUES
			foreach($csv_values as $vv){	
		 
				foreach($vv as $vk => $v){	
					if(in_array($csv_headers[$vk],$dont_show_fields)){ continue; }				 
					$csv_output .= $v.",";					
				}
				$csv_output .= "\n";
			}
			 
 
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Cache-Control: private", false);
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename=\"".$file_name.".csv\";" );
			header("Content-Transfer-Encoding: binary");
			echo $csv_output;
			die();
	} 
	
	if(isset($_POST['dsample']) && current_user_can( 'edit_user', $userdata->ID ) ){
		  
		  //1. INCLUDE ZIP FEATURE
		  include(TEMPLATEPATH."/framework/class/class_pclzip.php");
		  $uploads = wp_upload_dir();
		  $template_name = "template_".str_replace(" ","_",strip_tags($_POST['name']));		  
		  
		  // 2. REMOVE OLD FILES
		  if (file_exists($uploads['path']."/".$template_name.".zip")) {
			@unlink($uploads['path']."/".$template_name.".zip"); 
		  }
		  
		  // 3. CREATE NEW STYLE.CSS
$cssContent = "/*
Theme Name: ".strip_tags($_POST['name'])."
Theme URI: http://www.premiumpress.com
Description: PremiumPress Child Theme
Author: ".get_option('admin_email')."
Author URI: ".get_home_url()."
Template: [XXX]
Version: 1.0
*/

";	
		  
		  	//3a. add-on core theme css
			if(isset($_POST['e3']) && $_POST['e3'] == 1 && $GLOBALS['CORE_THEME']['template'] != "" ){
			$core_css = file_get_contents(str_replace("functions/","",THEME_PATH)."/templates/".$GLOBALS['CORE_THEME']['template'].'/style.css');
			$cssContent .= $core_css;			
			}
			//3b. add-on custom css
			if(isset($_POST['e2']) && $_POST['e2'] == 1){
			$cssContent .= stripslashes(get_option('custom_css'));			
			}
			
			// SAVE THE NEW STYLE FILE		   
			$handle = fopen($uploads['path']."/style.css", "w");
			if (fwrite($handle, $cssContent) === FALSE) {
				echo "Cannot write to styles";
				die();
			 } 
		 
		  fclose($handle);
		  
		  // ADD IN CUSTOM FUNCTIONS DATA
		  if(isset($_POST['e1']) && $_POST['e1'] == 1){
		  
			// LOAD IN MAIN DEFAULTS
			$core_admin_values = get_option("core_admin_values"); 
			// SETUP CONTENT FOR HOME PAGE OBJECTS
			$block1 	= explode(",",$core_admin_values['homepage']['widgetblock1']);
			$EXPORTSTRING = "";
			foreach($block1 as $key => $it){
			// BREAK UP THE STRING				
			$ff 		= explode("_",$it);						
			$gg 		= explode("-", $ff[1]);
			$nkey		= $ff[0];
			$nrefid 	= $gg[0];
			$nvalue 	= $gg[1];
			$innerda = $core_admin_values['widgetobject'][$nkey][$nrefid];
			if(is_array($innerda) && !empty($innerda)) {
				$EXPORTSTRING .= "\n&#36;core_admin_values['widgetobject']['".$nkey."']['".$nrefid."'] = array(\n";
				foreach($innerda as $kk => $jj){
				if(!is_object($jj)){
				$EXPORTSTRING .= "'".$kk."' => \"".trim(preg_replace('/\r|\n/', '',str_replace('"',"'",$jj)))."\",\n";
				}
				}
				$EXPORTSTRING .= ");";
				$EXPORTSTRING = str_replace("&#36;",'$',$EXPORTSTRING);
			}
			}
		  		
			$funContent = '<?php
// TELL THE CORE THIS IS A CHILD THEME
define("WLT_CHILDTHEME", true);

// CHILD THEME LAYOUT SETTINGS
function childtheme_designchanges(){
				
				// LOAD IN CORE STYLES AND UNSET THE LAYOUT ONES SO OUR CHILD THEME DEFAULT OPTIONS CAN WORK
				$core_admin_values = get_option("core_admin_values"); 
			 
					// SET HEADER
					$core_admin_values["layout_header"] = "'.$core_admin_values['layout_header'].'";
					// SET MENU
					$core_admin_values["layout_menu"] = "'.$core_admin_values['layout_menu'].'";
					// SET RESPONISVE DESIGN
					$core_admin_values["responsive"] = "'.$core_admin_values["responsive"].'";
					// SET COLUMN LAYOUTS
					$core_admin_values["layout_columns"] = array(\'homepage\' => \''.$core_admin_values["layout_columns"]["homepage"].'\', \'search\' => \''.$core_admin_values["layout_columns"]["search"].'\', \'single\' => \''.$core_admin_values["layout_columns"]["single"].'\', \'page\' => \''.$core_admin_values["layout_columns"]["page"].'\', \'footer\' => \''.$core_admin_values["layout_columns"]["footer"].'\', \'2columns\' => \''.$core_admin_values["layout_columns"]["2columns"].'\', \'style\' => \''.$core_admin_values["layout_columns"]["style"].'\', \'3columns\' => \''.$core_admin_values["layout_columns"]["3columns"].'\');
					// SET WELCOME TEXT
					$core_admin_values["header_welcometext"] = "'.str_replace('"',"'",$core_admin_values["header_welcometext"]).'";        
					// SET RATING
					$core_admin_values["rating"] 		= "'.$core_admin_values["rating"].'";
					$core_admin_values["rating_type"] 	= "'.$core_admin_values["rating_type"].'";
					// BREADCRUMBS
					$core_admin_values["breadcrumbs_inner"] 	= "'.$core_admin_values["breadcrumbs_inner"].'";
					$core_admin_values["breadcrumbs_home"] 		= "'.$core_admin_values["breadcrumbs_home"].'"; 
					// TURN OFF CATEGORY DESCRIPTION
					$core_admin_values["category_descrition"] 	= "'.$core_admin_values["category_descrition"].'";	
					// GEO LOCATION
					$core_admin_values["geolocation"] 	= "'.$core_admin_values["geolocation"].'";
					$core_admin_values["geolocation_flag"] 	= "'.$core_admin_values["geolocation_flag"].'";
					// FOOTER SOCIAL ICONS
					$core_admin_values["social"] 	= array(
					\'twitter\' => \''.$core_admin_values["social"]["twitter"].'\', \'twitter_icon\' => \''.$core_admin_values["social"]["twitter_icon"].'\', 
					\'facebook\' => \''.$core_admin_values["social"]["facebook"].'\', \'facebook_icon\' => \''.$core_admin_values["social"]["facebook_icon"].'\', 
					\'dribbble\' => \''.$core_admin_values["social"]["dribbble"].'\', \'dribbble_icon\' => \''.$core_admin_values["social"]["dribbble_icon"].'\', 
					\'linkedin\' => \''.$core_admin_values["social"]["linkedin"].'\', \'linkedin_icon\' => \''.$core_admin_values["social"]["linkedin_icon"].'\', 
					\'youtube\' => \''.$core_admin_values["social"]["youtube"].'\', \'youtube_icon\' => \''.$core_admin_values["social"]["youtube_icon"].'\', 
					\'rss\' => \''.$core_admin_values["social"]["rss"].'\', \'rss_icon\' => \''.$core_admin_values["social"]["rss_icon"].'\',         
					);
					// FOOTER COPYRIGHT TEXT
					$core_admin_values["copyright"] 	= "'.str_replace('"',"'",$core_admin_values["copyright"]).'";
					// HOME PAGE OBJECT SETUP
					$core_admin_values["homepage"]["widgetblock1"] = "'.$core_admin_values["homepage"]["widgetblock1"].'";	
					'.$EXPORTSTRING.'	
					// SET ITEMCODE
					$core_admin_values["itemcode"] 	= "'.trim(preg_replace('/\r|\n/', '',str_replace("\'","'",str_replace('"',"'",$core_admin_values["itemcode"])))).'";
					// SET LISTING PAGE CODE
					$core_admin_values["listingcode"] 	= "'.trim(preg_replace('/\r|\n/', '',str_replace("\'","'",str_replace('"',"'",$core_admin_values["listingcode"])))).'";
					// SET PRINT PAGE CODE
					$core_admin_values["printcode"]  = "'.trim(preg_replace('/\r|\n/', '',str_replace("\'","'",str_replace('"',"'",$core_admin_values["printcode"])))).'";						
					// RETURN VALUES
					return $core_admin_values;
}
// FUNCTION EXECUTED WHEN THE THEME IS CHANGED
function _after_switch_theme(){
	// SAVE VALUES
	update_option("core_admin_values",childtheme_designchanges());		
}
add_action("after_switch_theme","_after_switch_theme");
// DEMO MODE
if(defined("WLT_DEMOMODE")){ 
	$GLOBALS["CORE_THEME"] = childtheme_designchanges();
}?>';
	  
		  }else{
		  
			$funContent = '<?php
// TELL THE CORE THIS IS A CHILD THEME
define("WLT_CHILDTHEME", true);			
/*
			
Below are a handful of useful variables for you to use.
			
CHILD_THEME_NAME 		=  name of your theme
CHILD_THEME_PATH_URL 	= path to your child theme folder
CHILD_THEME_PATH_IMG 	= path to your child theme /img/ folder
CHILD_THEME_PATH_JS 	= path to your child theme /js/ folder
CHILD_THEME_PATH_CSS 	= path to your child theme /css/ folder
			
example usage;
			
<img src="<?php echo CHILD_THEME_PATH_URL; ?>screenshot.png" />
			 
			
// ADD ANY OF YOUR OWN FUNCTIONS BELOW
*/?>';
		  
		  }
		  
		  // SAVE CONTENT TO FUNCTIONS FILE
		   $handle = fopen($uploads['path']."/functions.php", "w");
			  if (fwrite($handle, $funContent) === FALSE) {
				echo "Cannot write to functions file";
				die();
			  } 
			  fclose($handle);	
 		
		  // 4. ZIP EVERYTHING TOGETHER	  
		  $zip = new PclZip($uploads['path']."/".$template_name.".zip");
		  $v_list = $zip->add($uploads['path']."/style.css,".$uploads['path']."/functions.php,".TEMPLATEPATH.'/framework/sampletheme/',PCLZIP_OPT_REMOVE_ALL_PATH, PCLZIP_OPT_ADD_PATH, $template_name);
		  
		  if ($v_list == 0) {
			die("Error : ".$zip->errorInfo(true));
		  } 
	
		$file = $uploads['path']."/".$template_name.".zip";
		$file_download = $uploads['url']."/".$template_name.".zip";
		?>
        <h1>Download Ready</h1>
        <p>Use the link below to download your child theme.</p>
        <p><a href="<?php echo $file_download; ?>"><?php echo $file_download; ?></a>
        <?php 
		die(); 
		if(file_exists($file)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename($file));
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file));
				ob_clean();
				flush();
				readfile($file);
				exit;
		}else{
		die("Theme file unavailable.");
		} 	 
	}


}
 


	/// PREVENT ADMIN ACCESS 	
	function prevent_admin_access() {
	
	global $pagenow, $userdata;
	
	if(isset($_GET['core_admin_aj']) && user_can($userdata->ID, 'administrator') ){
	
		if(isset($_GET['act']) && strlen($_GET['act']) > 1){
			 		
			update_post_meta($_GET['pid'],$_GET['act'],$_GET['value']);
			if($_GET['value'] == "yes"){
			echo "<a href='javascript:void(0);' onclick=\"WLTSaveAdminOp(".$_GET['pid'].",'no','".$_GET['act']."', '".$_GET['pid']."_yn');\"><img src='".get_template_directory_uri()."/framework/admin/img/yes.png' alt='' align='middle'></a>";
			}else{
			echo "<a href='javascript:void(0);' onclick=\"WLTSaveAdminOp(".$_GET['pid'].",'yes','".$_GET['act']."','".$_GET['pid']."_yn');\"><img src='".get_template_directory_uri()."/framework/admin/img/no.png' alt='' align='middle'></a>";
			}
			die();
			 
		}
	
	}
	
	 // FIX FOR ADMIN QUERY
	 if(isset($_GET['action'])){ return; }
	 
		if (strpos(strtolower($_SERVER['REQUEST_URI']), '/wp-admin') !== false && $userdata->ID)  {
			 
			$userdata = wp_get_current_user(); 
				
			if( !user_can($userdata->ID, 'administrator') &&  !user_can($userdata->ID, 'contributor') &&   !user_can($userdata->ID, 'editor')  ){
				  
			  wp_die(__('Oops! You do not have sufficient permissions to access this page.'));		 
				
			}
		}
	}
 
	
	function _meta_boxes() {
		global $_wp_post_type_features;
		if (isset($_wp_post_type_features[THEME_TAXONOMY.'_type']['editor']) && $_wp_post_type_features[THEME_TAXONOMY.'_type']['editor']) {
			unset($_wp_post_type_features[THEME_TAXONOMY.'_type']['editor']);	
			remove_meta_box('postexcerpt', THEME_TAXONOMY.'_type', 'normal');
			remove_meta_box('trackbacksdiv', THEME_TAXONOMY.'_type', 'normal');
			//remove_meta_box('postcustom', THEME_TAXONOMY.'_type', 'normal');
			//remove_meta_box('commentstatusdiv', THEME_TAXONOMY.'_type', 'normal');
			//remove_meta_box('commentsdiv', THEME_TAXONOMY.'_type', 'normal');
			remove_meta_box('revisionsdiv', THEME_TAXONOMY.'_type', 'normal');
			//remove_meta_box('authordiv', THEME_TAXONOMY.'_type', 'normal');
			//remove_meta_box('sqpt-meta-tags', THEME_TAXONOMY.'_type', 'normal'); 
		} 
	}
	
	function buildadminfields($full_list_of_fields){ global $post, $CORE, $wpdb; $tabbedarea = 0; $core_admin_values = get_option("core_admin_values"); 
	
	
	 ?>
    
    <table style="width:100%;">
	
<?php foreach($full_list_of_fields as $key=>$val){ $e_value = get_post_meta($post->ID,$key,true); 

// FIX FOR SKU
if($key == "sku" &&  $e_value == ""){ $e_value = get_post_meta($post->ID,"SKU",true);  }

// CHECK FOR DEFAULT FIELD VALUE
if($e_value == "" && isset($val['default'])){ $e_value = $val['default']; }  

// CHECK IF THIS IS A NEW TAB
if(isset($val['tab'])){ $tabbedarea = $key; ?>
<tr class="fieldset_<?php echo $tabbedarea; ?>">
    <td colspan="2">
     <div style='font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666;'><?php echo $val['title']; ?></div>
    </td>
</tr>

<?php }else{ ?>
<tr style="line-height:35px;" id="table_row_<?php echo $key; ?>" class="fieldset_<?php echo $tabbedarea; ?>">
    <td style="width:300px;"><img src="<?php echo THEME_URI; ?>/framework/admin/img/0/7.png" class="infoimg" role="button" aria-pressed="false" style="cursor:pointer;margin-right:10px;" align="absmiddle" title="<?php echo $val['desc']; ?>" /><label><?php echo $val['label']; ?></label>  </td>
    <td>
 
    <?php if(isset($val['combo'])){ ?>
    
    <link rel="stylesheet" type="text/css" href="<?php echo THEME_URI; ?>/framework/css/css.autocomplete.css" />
<script type="text/javascript" src="<?php echo THEME_URI; ?>/framework/js/jquery.autocomplete.js"></script>
<script>
jQuery(document).ready(function() {
  jQuery('#autocompleteme').smartSuggest({
    src: '<?php echo get_home_url(); ?>?boxid=field_<?php echo $key; ?>&option=1'
  });
});
</script>
    
  <input type="text" id="autocompleteme" style="width:300px;" placeholder="Enter product title here.." /> 
  
  <?php if($key != "related"){ ?>
  <!-- HERE WE GET AND SAVE THE OLD VALUES ENCASE THEY CHANGED -->
  <?php
	$options1 = get_post_meta($post->ID,$key,true); $oldIds = "";
	if(is_array($options1) && !empty($options1)){				
		foreach($options1 as $val1){
		$oldIds .= $val1.",";
		}			 				 
	}// end foreach
  ?>
   <input type="hidden" name="wlt_field[<?php echo $key; ?>_old]" value="<?php echo $oldIds; ?>" /> 
    <?php } ?>
	
	
	<?php } ?>
    
    
    <?php if(isset($val['values'])){ ?>
    <select name="wlt_field[<?php echo $key; ?>]<?php if(isset($val['multi'])){ ?>[]<?php }?>" id="field_<?php echo $key; ?>" <?php if(isset($val['multi'])){ ?>multiple="multiple" style="height:100px;width:300px;"<?php } ?>>
    
    
     <?php if(isset($val['combo'])){  ?><option value=""> </option><?php } ?>
    <?php if($key == "packageID"){ ?><option value="">----- no package assigned -----</option><?php } ?>
    <?php 
	
	if($key == "related"){
		foreach($val['values'] as $k=>$val){ 			
			$val = trim($val);
			if(strlen($val) > 0 && is_numeric($val)){
			echo '<option value="'.$val.'" selected=selected>'.get_the_title($val).'</option>';	
			}		
		}
	}else{
		foreach($val['values'] as $k=>$o){ 
		
		if(is_array($e_value) && isset($val['multi']) && in_array($k, $e_value) ){ $f = "selected=selected"; }elseif($e_value != "" && $e_value == $k){ $f = "selected=selected"; }else{ $f=""; }?>
		
		<?php if(is_array($o) && $key == "packageID"){ $o = $o['name']; } 
		if($o == ""){ continue; }
		?>
		<option value="<?php echo $k; ?>" <?php echo $f; ?>><?php echo $o; ?></option>
		<?php }?>
    
    <?php } ?>
    
    </select>
    <?php }else{ ?>
    
    <?php 
	 
	if(isset($val['dateitem'])){ 
			 $db = explode(" ",$e_value);
			echo '<script>jQuery(function(){ jQuery(\'#reg_field_'.$key.'_date\').datetimepicker(); }); </script>
			
			 
			<div style="width:30%; float:left;">
			
			
			 <div class="input-prepend date span6" id="reg_field_'.$key.'_date" data-date="'.$db[0].'" data-date-format="yyyy-MM-dd hh:mm:ss">
			<span class="add-on"><i class="icon-calendar"></i></span>
				<input type="text" name="wlt_field['.$key.']" value="'.$e_value.'" id="reg_field_'.$key.'"  data-format="yyyy-MM-dd hh:mm:ss" />
			 </div>
			 
			 
			 </div>';
			 
			 if($key == "expiry_date"){ 
			 
			 
			echo '<div style="width:70%; float:left; font-size:11px; text-align:left;">
			 
			 Time Now: '.current_time( 'mysql' ).' / '.$CORE->TimeDiff(get_post_meta($post->ID,'expiry_date',true)).'
			 
			 </div>';
			 
			 }
			 
			
			 
			 	
			 
	}elseif($key == "price" || isset($val['price'])){ echo $core_admin_values['currency']['symbol']; } ?>
    
    <?php if(!isset($val['dateitem'])){ ?>
    <input type="text" name="wlt_field[<?php echo $key; ?>]" value="<?php echo $e_value; ?>" id="<?php echo $key; ?>" /> 
    <?php } ?>
    
    <?php } ?>
    
    <?php if($key == "listing_expiry_date"){ ?>
    <a href="javascript:void(0);" onclick="jQuery('#reg_field_listing_expiry_date').val('<?php echo date('Y-m-d H:i:s', strtotime('+5 minutes', strtotime($CORE->DATETIME()))); ?>');" style="float:right;margin-top:5px;" class="button">Set Date Now (+5 mins)</a>  
    <?php } ?>
    
    
<?php if($key == "download_path"){ ?>
  <a href="javascript:void(0);" class="button" id="upload_logo">Select File</a>

<script type="text/javascript">

jQuery(document).ready(function() {

	var orig_send_to_editor = window.send_to_editor;
	
	jQuery('#upload_logo').click(function() {	
	 formfield = jQuery('#download_path').attr('name');
	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	 
	 window.send_to_editor = function(html) {	
	 imgurl = jQuery('img',html).attr('src'); 	
	 jQuery('#download_path').val(imgurl);	 
	 tb_remove();
	 
	 window.send_to_editor = orig_send_to_editor;
	 } 
	 
	 
	 return false;
	});	

});

</script>  
  



<?php  }// end if this field is a tab ?>
 
     
    </td>
</tr>
<?php } } ?>  
</table>


<script type="application/javascript">
jQuery(document).ready(function(){	

	jQuery( "#field_listing_status" ).change(function() {
		var sdt = jQuery( "#field_listing_status" ).val();
		if(sdt == 10){
			 jQuery( "#table_row_listing_status_msg" ).show(0);
		}else{
			 jQuery( "#table_row_listing_status_msg" ).hide(0);
		} 
	});	
	var sdt = jQuery( "#field_listing_status" ).val();
	if(sdt == 10){
		jQuery( "#table_row_listing_status_msg" ).show(0);
	}else{
		jQuery( "#table_row_listing_status_msg" ).hide(0);
	} 
	
});
</script>
<?php if(defined('WLT_CART')){ ?> 
<script type="application/javascript">
jQuery(document).ready(function(){	

	jQuery( "#field_tax_required" ).change(function() {
		var sdt = jQuery( "#field_tax_required" ).val();
		if(sdt == 0){
		 jQuery( ".fieldset_tab7" ).hide(0);
		}else if(sdt == 1){
		 jQuery( ".fieldset_tab7" ).show(0);
		} 
	});	 
	jQuery( "#field_type" ).change(function() {
		var sdt = jQuery( "#field_type" ).val();
		if(sdt == 0){
		jQuery( ".fieldset_tab4" ).hide(0);jQuery( ".fieldset_tab5" ).hide(0);jQuery( ".fieldset_tab6" ).show(0);
		}else if(sdt == 1){
		jQuery( ".fieldset_tab4" ).show(0);jQuery( ".fieldset_tab5" ).hide(0);jQuery( ".fieldset_tab6" ).hide(0);
		}else if(sdt == 2){
		jQuery( ".fieldset_tab4" ).hide(0);jQuery( ".fieldset_tab5" ).show(0);jQuery( ".fieldset_tab6" ).hide(0);
		}
	});
<?php
$selected_tax = get_post_meta($post->ID,'tax_required',true);
switch($selected_tax){
	case "1": {
	echo 'jQuery( ".fieldset_tab7" ).show(0);';
	} break;
 
	default: {
	echo 'jQuery( ".fieldset_tab7" ).hide(0);';
	} break;
}
$selected_type = get_post_meta($post->ID,'type',true);
switch($selected_type){
	case "1": {
	echo 'jQuery( ".fieldset_tab4" ).show(0);jQuery( ".fieldset_tab5" ).hide(0);jQuery( ".fieldset_tab6" ).hide(0);';
	} break;
	case "2": {
	echo 'jQuery( ".fieldset_tab4" ).hide(0);jQuery( ".fieldset_tab5" ).show(0);jQuery( ".fieldset_tab6" ).hide(0);';
	} break;
	default: {
	echo 'jQuery( ".fieldset_tab4" ).hide(0);jQuery( ".fieldset_tab5" ).hide(0);jQuery( ".fieldset_tab6" ).show(0);';
	} break;
}
?>
});
</script>

<?php } ?>


	
	<?php }
	
 
	function _custom_metabox(){ 
 	
	// LISTING DATA META BOX
	add_meta_box( 'wlt_listingdata', __( "Listing Information", 'sp' ), array($this, '_listing_details' ), THEME_TAXONOMY.'_type', 'normal', 'high' );
 	
	if(!defined('WLT_CART')){ 
	add_meta_box( 'wlt_pagedata', __( "Page Access", 'sp' ), array($this, '_page_details' ), 'page', 'normal', 'high' );
	}
	
	}
	function _page_details(){ global $post, $CORE; $core_admin_values = get_option("core_admin_values"); $packagefields = get_option("packagefields"); 
	
 ?>
<div id="tabs-1c">
    <?php 
	$membershipfields 	= get_option("membershipfields");	
	if(is_array($membershipfields) && !empty($membershipfields)){ 
	
	$current_access = get_post_meta($post->ID, "access", true);
	if(!is_array($current_access)){ $current_access = array(99); }	
	?>
    
 
   <p>Here you can restrict access to this page based on a users membership.</p>
   
   	<select name="wlt_field[access][]" size="2" style="font-size:14px;padding:5px; width:100%; height:150px; background:#e7fff3;" multiple="multiple"  > 
  	<option value="99" <?php if(in_array(99,$current_access)){ echo "selected=selected"; } ?>>All Membership Access</option>
    <?php 
	$i=0;
	
	foreach($membershipfields as $mID=>$package){	
		
		if(is_array($current_access) && in_array($package['ID'],$current_access)){ 
		echo "<option value='".$package['ID']."' selected=selected>".$package['name']."</option>";
		}else{ 
		echo "<option value='".$package['ID']."'>".$package['name']."</option>";		
		}
		
	$i++;		
	} // end foreach
	
    ?>
	</select>
    <br /><small>Hold CTRL to select multiple memberships.</small> 
   <?php } ?>
 
 <?php }
 
	
	function _listing_details(){ global $post, $CORE; $core_admin_values = get_option("core_admin_values"); $packagefields = get_option("packagefields"); $myPakID = get_post_meta($post->ID,'packageID',true); ?>
    
   
<style type="text/css">
#wlt_admin_itemattachments img { max-width:100px; }
.ui-tabs .ui-tabs-nav li.ui-tabs-active a { font-weight:bold; }
.ui-tabs .ui-tabs-nav li { height:32px; }
#post-body { margin-top:15px; }
.wrap h2, .icon32 { display:none; }
#gdsr-meta-box, #gdsr-meta-box-mur { display:none; }
#tabs-6 .postbox, #tabs-5 .postbox { background:#fff !important; }
	#wlt_extrafields .span3 { width:300px; float:left; }
	#wlt_extrafields .misc-pub-section { line-height:30px; }
	.ui-widget input { font-size:13px !important; }

#tabs-left { position: relative;     padding-left: 6.5em; } 
#tabs-left .ui-tabs-nav { position: absolute; left: 0; top: 0; bottom: 0;  width: 160px;	min-height: 300px;} 
#tabs-left .ui-widget-content , #tabs-left .ui-widget-header { border:0px !important; }
#tabs-left .ui-tabs-panel { margin-left:100px; }
#tabs-left .ui-tabs-nav li a {     float: right;     width: 100%;     text-align: right; } 
#tabs-left.ui-widget-content { border: 1px solid #ddd;border-top: 0px;border-radius: 0px; }
#tabs-left .ui-tabs .ui-tabs-nav { padding:0px; }
#tabs-left.ui-tabs .ui-tabs-panel { padding:0px !important; }
#tabs-left .ui-widget-content {background-color: transparent !important; min-height: 300px; }
#tabs-left .ui-widget-header { background: #f5f5f5; border-right: 1px solid #eaeaea; }
#tabs-left .ui-corner-all { border-bottom-right-radius: 0px !important;  border-bottom-left-radius: 0px !important; border-top-right-radius: 0px !important; border-top-left-radius: 0px !important;  }
#tabs-left .ui-tabs-nav li {   width: 100%; border-right: none; border-bottom-width: 1px !important;-moz-border-radius: 0px 0px 0px 0px;-webkit-border-radius: 0px 0px 0px 0px;     border-radius: 0px 0px 0px 0px;     overflow: hidden; 	margin-top:6px; 	right:-2px; } 
#tabs-left .ui-tabs-nav li.ui-tabs-selected, 
#tabs-left .ui-tabs-nav li.ui-state-active { border:1px solid #eaeaea; border-right: 1px solid transparent; background:#fff;  } 
#tabs-left .ui-state-default, #tabs-left .ui-widget-content .ui-state-default, #tabs-left .ui-widget-header .ui-state-default {background: transparent; border-bottom:1px solid #eaeaea; border:0px;}
.icon1 span:before {    font-family: "dashicons";    content: "\f464";	padding-right:10px;}
.icon2 span:before {    font-family: "dashicons";    content: "\f321";	padding-right:10px;}
.icon3 span:before {    font-family: "dashicons";    content: "\f109";	padding-right:10px;}
.icon4 span:before {    font-family: "dashicons";    content: "\f107";	padding-right:10px;}
.icon5 span:before {    font-family: "dashicons";    content: "\f160";	padding-right:10px;}
.icon6 span:before {    font-family: "dashicons";    content: "\f161";	padding-right:10px;}
.icon7 span:before {    font-family: "dashicons";    content: "\f204";	padding-right:10px;}
.icon8 span:before {    font-family: "dashicons";    content: "\f313";	padding-right:10px;}
.icon9 span:before {    font-family: "dashicons";    content: "\f110";	padding-right:10px;}
.icon5a span:before {    font-family: "dashicons";    content: "\f503";	padding-right:10px;}


#wlt_admin_itemattachments table {
width: 100%; 
}
#wlt_admin_itemattachments table thead {
display: table-header-group;
vertical-align: middle;
border-color: inherit;
}
#wlt_admin_itemattachments .table th, #wlt_admin_itemattachments .table td {
padding: 8px;
line-height: 20px;
text-align: left;
vertical-align: top;
border-top: 1px solid #dddddd;
}
</style>
 

<?php wp_editor($post->post_content,'post_content'); ?>   

<script>

jQuery(document).ready(function(){
 jQuery( "#tabs-left" ).tabs();
jQuery( ".mapmebox" ).click(function() {
  drawChart();
  drawRegionsMap();
}); 
 
    jQuery( document ).tooltip({
      position: {
        my: "center top",
        at: "center bottom+5",
      },
      show: {
        duration: "fast"
      },
      hide: {
        effect: "hide"
      }
    });
	
	
	
//jQuery('#tabs-left a.icon3').click(function (e) { setTimeout(function(){ initialize(); }, 1000); });

 }); 
		
 
</script>
 
<div id="tabs-left">
  <ul>
  
    <li><a href="#tabs-1" class="icon1"><span>Details</span></a></li>    
    <li><a href="#tabs-3" class="icon6"><span>Attachments</span></a></li>
    
    <?php if(defined('WLT_CART')){ ?>
    <li><a href="#tabs-5" class="icon7"><span>Attributes</span></a></li>
    <li><a href="#tabs-6" class="icon8"><span>Discount</span></a></li> 
    <?php }else{ ?>  
    <li><a href="#tabs-1b" class="icon2"><span>Expiry</span></a></li>
    <?php if($core_admin_values['google'] == '1'){ ?>
    <li><a href="#tabs-1a" class="icon3" onclick="loadGoogleMapsApi();"><span>Map Location</span></a></li>
    <?php } ?>
    <li><a href="#tabs-1d" class="icon4"><span>Enhancements</span></a></li> 
    <li><a href="#tabs-1c" class="icon5"><span>Page Access</span></a></li>
    <li><a href="#tabs-1e" class="icon5a"><span>Timeout Access</span></a></li>
    <?php } ?>
     
    <?php if(isset($_GET['action'])){ ?>
    <li><a href="#tabs-4" class="mapmebox icon9"><span>Visitors</span></a></li>
	<?php } ?>
    
        
    
</ul>
 
<?php if(isset($_GET['action'])){ ?>
<div id="tabs-4">
<div style='font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666;'>Visitor History</div>
<?php echo do_shortcode('[VISITORCHART postid="'.$post->ID.'"]'); ?>
</div>
<?php } ?>


<div id="tabs-3">
<?php if(isset($_GET['action']) ){ ?>
<div id="wlt_admin_itemattachments"><?php echo do_shortcode('[FILES]'); ?></div>

<hr />
<script>
function setdeleteattachment(fileid){
jQuery( "#deletefilediv" ).append( "<div class='updated below-h2'><b class='label'>Remeber</b> to save changes after deleting files.</div><input type='hidden' name='wlt_attachdelete[]' value='"+fileid+"'>" );
}
</script>
<?php } ?>
<div id="deletefilediv"></div>
<input name="wlt_attachfile[]" type="file" /><br />
<input name="wlt_attachfile[]" type="file" /><br />
<input name="wlt_attachfile[]" type="file" /><br />
<input name="wlt_attachfile[]" type="file" /><br />
<input name="wlt_attachfile[]" type="file" /><br />
</div>



<div id="tabs-1">

<div style="font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666;">Listing Excerpt</div>
<textarea name="post_excerpt" style="height:100px;width:99%;margin-top:10px;"><?php echo $post->post_excerpt; ?></textarea>
<p>This is a short description which will be displayed on the search results page. Leave this field blank if you want the system to take a snippet from the main listing description above.</p>

<?php

 
if(!is_array($packagefields)){ $packagefields = array(); }

$basic_list = array (
"tab10" => array("tab" => true, "title" => "Listing Package" ), 
"packageID" => array("label" => "Listing Package", "desc" => "This is the listing package value.", "values" => $packagefields ),  
); 
$full_list_of_fields = hook_fieldlist_0($basic_list);

$expiry_list = array (
 
"tab3" => array("tab" => true, "title" => "Claim Listing Feature" ),
	"claimme" => array("label" => "Hide Claim Option?", "desc" => "Set this value to no if you want to <u>hide</u> the claim listing button on this listing.",  "values" =>array("no"=>"no", "yes"=>"yes" ) ),
	
);
$full_list_of_fields = array_merge($full_list_of_fields,hook_fieldlist_1($expiry_list));

 
// REMOVE CLAIM LISTING IF NOT ENABLED WITHIN THE SYSTEM
if($core_admin_values['visitor_claimme'] != 1){
	unset($full_list_of_fields['tab3']);
	unset($full_list_of_fields['claimme']);
}

// DISPLAY OUTPPIT
$this->buildadminfields($full_list_of_fields);
?> 

<?php if(!defined('WLT_CART')){ ?>
 <div style='font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666;'> My Custom Fields <a href="admin.php?page=5"  target="_blank" style="color:blue;font-weight:normal;font-size:10px;">add more fields</a> </div> 
   
    <div id="wlt_extrafields">
    <?php do_action('hook_edit_fields_metabox');  ?>	
	</div>
<?php } ?>
    
</div><!-- end tab -->

<?php if(!defined('WLT_CART')){ ?>
<div id="tabs-1b">
<?php
$expiry_list = array (
"tab1" => array("tab" => true, "title" => "Listing Expiry Date" ),
	"listing_expiry_date" => array("label" => "Expiry Date", "desc" => "This is the date the listing will expire. Format: Y-m-d h:i:s", "dateitem" => true ), 
 );
// DISPLAY OUTPPIT
$this->buildadminfields($expiry_list); ?>
 
<?php
$e_value = get_post_meta($post->ID,'listing_expiry_date',true);
?>
<?php if(strlen($e_value) > 1){ ?>
    <div id="message" class="updated below-h2"><p>Listing Expires:  <?php  echo do_shortcode('[TIMELEFT postid="'.$post->ID.'" layout="1" text_before="" text_ended="Not Set" key="listing_expiry_date"]'); ?></p></div>
		<p>What happens when it expires?</p>
        <div id="message" class="error below-h2">
        <?php if(is_numeric($myPakID)){  
		 
		switch($packagefields[$myPakID]['action']){		
			case "0": { echo "Nothing Happens."; } break;
			case "1": { echo "Listing status changed to draft"; } break;
			case "3": { echo "Listing status changed to pending"; } break;
			case "2": { echo "Listing is deleted"; } break;
			default: { 
				foreach($packagefields as $field){ 
						if(!is_numeric($field['ID'])){ continue; } 
						if($packagefields[$myPakID]['action'] == "move-".$field['ID']){ echo "Listing package is changed to: ".$field['name']; }
				} // end foreach		
			}// end default
		}// end switch
		
		?>
        <p>Email Sent: <?php 
		$sentE = $core_admin_values['emails']['expired']; 
		if(is_numeric($sentE)){ $wlt_emails = get_option("wlt_emails"); echo $wlt_emails[$sentE]['subject']; 
		}else{ echo "<b style='color:red;'>No email set.</b>"; } 
		?></p>
        <?php }else{ ?>
        Nothing. (no package set)
        <?php } ?> 
        </div>       
<?php } ?>
        
</div><!-- end tab -->
<?php } // end if cart ?>

<?php if(!defined('WLT_CART')){ ?>
<div id="tabs-1a">
	<?php if($core_admin_values['google'] == '1'){ ?>
    
	<div style='font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666; margin-top:10px;margin-bottom:10px;'>Map Location </div>     
    
    <div id="wlt_map_location" style="height:300px;width:100%;"></div>
    <input type="text" onchange="getMapLocation(this.value);" style="width:100%;" name="wlt_field[map_location]" id="form_map_location" class="long" tabindex="14" value="<?php echo get_post_meta($_GET['eid'],'map_location',true); ?>">
 <input type="hidden" id="map-long" name="wlt_field[map-log]" value="<?php echo get_post_meta($_GET['eid'],'map-log',true); ?>">
 <input type="hidden" id="map-lat" name="wlt_field[map-lat]"  value="<?php echo get_post_meta($_GET['eid'],'map-lat',true); ?>"> 
 <input type="hidden" id="map-country" name="wlt_field[map-country]"  value="<?php echo get_post_meta($_GET['eid'],'map-country',true); ?>">
 <input type="hidden" id="map-address1" name="wlt_field[map-address1]"  value="<?php echo get_post_meta($_GET['eid'],'map-address1',true); ?>">
 <input type="hidden" id="map-address2" name="wlt_field[map-address2]"  value="<?php echo get_post_meta($_GET['eid'],'map-address2',true); ?>">
 <input type="hidden" id="map-address3" name="wlt_field[map-address3]"  value="<?php echo get_post_meta($_GET['eid'],'map-address3',true); ?>">
 <input type="hidden" id="map-zip" name="wlt_field[map-zip]"  value="<?php echo get_post_meta($_GET['eid'],'map-zip',true); ?>">
  <input type="hidden" id="map-state" name="wlt_field[map-state]"  value="<?php echo get_post_meta($_GET['eid'],'map-state',true); ?>">
 <input type="hidden" id="map-city" name="wlt_field[map-city]"  value="<?php echo get_post_meta($_GET['eid'],'map-city',true); ?>">
 
<script type="text/javascript"> 
var geocoder;var map;var marker = '';   var markerArray = [];    

function loadGoogleMapsApi(){
    if(typeof googlemap === "undefined"){
        var script = document.createElement("script");
        script.src = "https://maps.google.com/maps/api/js?sensor=false&callback=loadWLTGoogleMapsApiReady";
        document.getElementsByTagName("head")[0].appendChild(script);				
    } else {
        loadWLTGoogleMapsApiReady();
    }
}
function loadWLTGoogleMapsApiReady(){ 
	jQuery("body").trigger("gmap_loaded"); 
}
jQuery("body").bind("gmap_loaded", function(){

			<?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-log',true) !=""){ ?>
			var myLatlng = new google.maps.LatLng(<?php echo get_post_meta($_GET['eid'],'map-lat',true); ?>,<?php echo get_post_meta($_GET['eid'],'map-log',true); ?>);
			var myOptions = { zoom: 8,  center: myLatlng,  mapTypeId: google.maps.MapTypeId.ROADMAP}
			
			<?php }else{ ?>
			var myLatlng = new google.maps.LatLng(0,0);
			var myOptions = { zoom: 1,  center: myLatlng,  mapTypeId: google.maps.MapTypeId.ROADMAP}
			<?php } ?>
			 
			
            map = new google.maps.Map(document.getElementById("wlt_map_location"), myOptions);
			<?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-log',true) !=""){ ?>
			var marker = new google.maps.Marker({
					position: myLatlng,
					map: map				 
				});
			markerArray.push(marker);
			<?php } ?>
			
			google.maps.event.addListener(map, 'click', function(event){			
				document.getElementById("map-long").value = event.latLng.lng();	
				document.getElementById("map-lat").value =  event.latLng.lat();
				getMyAddress(event.latLng);	
				addMarker(event.latLng);			
			});

});
function addMarker(location) {

	jQuery(markerArray).each(function(id, marker) {	
        marker.setVisible(false);
    });
	
	marker = new google.maps.Marker({	position: location, 	map: map,	});
	markerArray.push(marker);
	map.panTo(marker.position); 
	map.setCenter(location);  
}	
function getMapLocation(location){
 
			document.getElementById("map-state").value = "";
			var geocoder = new google.maps.Geocoder();if (geocoder) {	geocoder.geocode({"address": location}, function(results, status) {	if (status == google.maps.GeocoderStatus.OK) {
		 
			map.setCenter(results[0].geometry.location);
			addMarker(results[0].geometry.location);
			getMyAddress(results[0].geometry.location,"no");		
			document.getElementById("map-long").value = results[0].geometry.location.lng();	
			document.getElementById("map-lat").value =  results[0].geometry.location.lat();
			map.setZoom(9);		
			}});}
			
}
function getMyAddress(location){var geocoder = new google.maps.Geocoder();if (geocoder) {geocoder.geocode({"latLng": location}, function(results, status) { 

	if (status == google.maps.GeocoderStatus.OK) {
			 
				for (var i = 0; i < results[0].address_components.length; i++) {
				
                          var addr = results[0].address_components[i];
						   
						  switch (addr.types[0]){
						  	
							case "street_number": {
								document.getElementById("map-address1").value = addr.long_name;
							} break;
							
							case "route": {
								document.getElementById("map-address2").value = addr.long_name;
							} break;
							
							case "locality": 
							case "postal_town": 
							{
								document.getElementById("map-address3").value = addr.long_name;
								document.getElementById("map-city").value = addr.long_name;
							} break;
							
							case "postal_code": {
								document.getElementById("map-zip").value = addr.short_name;
							} break;
							
							case "administrative_area_level_1": {							
								document.getElementById("map-state").value = addr.long_name;
							} break;
							
							case "administrative_area_level_2": {							 
								document.getElementById("map-state").value = addr.long_name;
							} break;
							
							case "administrative_area_level_3": {						
								document.getElementById("map-state").value = document.getElementById("map-state").value + addr.long_name;
							} break;
							
							case "country": {
								document.getElementById("map-country").value = addr.short_name;	
							} break;						  
						  
						  } // end switch
						  
                } // end for
				 
			
			//document.getElementById("form_map_location").value = results[0].formatted_address;
			map.setCenter(results[0].geometry.location);
			}
});	}}

</script>

<?php } ?>
 
</div>
<?php } // end if cart ?> 

<?php if(!defined('WLT_CART')){ ?>
<div id="tabs-1c">
    <?php 
	$membershipfields 	= get_option("membershipfields");	
	if(is_array($membershipfields) && !empty($membershipfields)){ 
	
	$current_access = get_post_meta($post->ID, "access", true);
	if(!is_array($current_access)){ $current_access = array(99); }	
	?>
    
   <div style='font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666;'> Membership Access </div> 
   <p>Here you can restrict access to this listing based on a users membership.</p>
   
   	<select name="wlt_field[access][]" size="2" style="font-size:14px;padding:5px; width:100%; height:150px; background:#e7fff3;" multiple="multiple"  > 
  	<option value="99" <?php if(in_array(99,$current_access)){ echo "selected=selected"; } ?>>All Membership Access</option>
    <?php 
	$i=0;
	
	foreach($membershipfields as $mID=>$package){	
		
		if(is_array($current_access) && in_array($package['ID'],$current_access)){ 
		echo "<option value='".$package['ID']."' selected=selected>".$package['name']."</option>";
		}else{ 
		echo "<option value='".$package['ID']."'>".$package['name']."</option>";		
		}
		
	$i++;		
	} // end foreach
	
    ?>
	</select>
    <br /><small>Hold CTRL to select multiple memberships.</small> 
   <?php } ?>
 
<div id="message" class="updated below-h2" style="margin-top:30px;"><b>Remember:</b> You can limit content based on membership access using the shortcode: [MEMBERSHIP] <br><br><b>Example:</b><br><textarea style="width:100%;height:50px;padding:10px;">[MEMBERSHIP ID="1,2,3"] Your content here will show only for membership ID 1,2 and 3[/MEMBERSHIP] </textarea> <br><br>Use ID 0 for non-registered users or non-members. </div>  
</div>
<?php } // end if cart ?> 



<?php if(!defined('WLT_CART')){ ?>
<div id="tabs-1d">
<?php
$features_list = array (
"tab2" => array("tab" => true, "title" => "Listing Enhancements" ),
	"frontpage" => array("label" => "Front Page Exposure", "desc" => "This will set a 'frontpage' flag on the listing so you can use it for custom home page object queries.",  "values" =>array("no"=>"no", "yes"=>"yes" ) ), 	
	"topcategory" => array("label" => "Top of category", "desc" => "This will place the listing at the top of its respective category.",  "values" =>array("no"=>"no", "yes"=>"yes" ) ), 	
	"featured" => array("label" => "Featured", "desc" => "This will highlight the listing in the search resilts page.",  "values" =>array("no"=>"no", "yes"=>"yes" ) ), 	
	"html" => array("label" => "HTML Listings", "desc" => "This will enable the listing to be edited using the HTML editor.",  "values" =>array("no"=>"no", "yes"=>"yes" ) ), 	
	"visitorcounter" => array("label" => "Show Visitor Graph", "desc" => "This will show a visitor graph at the bottom of the listing page for the author of the listing.",  "values" =>array("no"=>"no", "yes"=>"yes" ) ), 	
	"showgooglemap" => array("label" => "Google Map", "desc" => "This will show the Google map on the listing page if a valid map location is set below (see google map).",  "values" =>array("no"=>"no", "yes"=>"yes" ) ), 	
 	
);
 

$features_list  = hook_fieldlist_2($features_list);
// DISPLAY OUTPPIT
$this->buildadminfields($features_list);
?>
</div>

<div id="tabs-1e">

   <div style='font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666;'> Timeout Access </div> 
   <p>Timeout access lets you set a time period the listing can viewed for before being redirected elsewhere.</p>
   
<?php

$current_access = get_post_meta($post->ID, "timeaccess", true);
if(!is_array($current_access)){ $current_access = array(); }

?>
 <table  border="0" style="width:100%;text-align:left" class="table">
  <tr>
    <th>Name</th>
    <th>Timeout (seconds)</th>
    <th>Redirect (http://)</th>
  </tr>
  <tr>
    <td>Guest Access</td>
    <td><input name="wlt_field[timeaccess][99][time]" type="text" value="<?php if(is_array($current_access) && isset($current_access[99])){ echo $current_access[99]['time']; } ?>" /></td>
    <td><input name="wlt_field[timeaccess][99][link]" type="text" value="<?php if(is_array($current_access) && isset($current_access[99])){ echo $current_access[99]['link']; } ?>" /></td>
	</tr>
    <td>Member (no membership)</td>
    <td><input name="wlt_field[timeaccess][100][time]" type="text" value="<?php if(is_array($current_access) && isset($current_access[100])){ echo $current_access[100]['time']; } ?>" /></td>
    <td><input name="wlt_field[timeaccess][100][link]" type="text" value="<?php if(is_array($current_access) && isset($current_access[100])){ echo $current_access[100]['link']; } ?>" /></td>
	</tr>
    <?php 
	$i=0;
	if(is_array($membershipfields)){
	foreach($membershipfields as $mID=>$package){	
 
	?>
    <tr>
    <td><?php echo $package['name']; ?></td>
    <td><input name="wlt_field[timeaccess][<?php echo $package['ID']; ?>][time]" type="text" value="<?php if(is_array($current_access) && isset($current_access[$package['ID']]) ){ echo $current_access[$package['ID']]['time']; } ?>" /></td>
    <td><input name="wlt_field[timeaccess][<?php echo $package['ID']; ?>][link]" type="text" value="<?php if(is_array($current_access) && isset($current_access[$package['ID']])){ echo $current_access[$package['ID']]['link']; } ?>" /></td>
	</tr>
    <?php
		
	$i++;		
	} // end foreach
	}
    ?>

  
</table>

<hr />
<p><b class="label" style="background:#666;color:#fff;padding:4px;">Note</b> Use the value [ID] in your redirect string to include the listing ID. Redirecting to your registration page will display an image preview. </p>
<p>Example Link: <?php echo home_url(); ?>/wp-login.php?action=register&amp;pid=[ID]</p>
</div>
<?php } // end if cart ?> 





<?php if(defined('WLT_CART')){ ?>
<?php $current_data = get_post_meta($post->ID,"wlt_productattributes",true); $current_discount_data = get_post_meta($post->ID,"wlt_productdiscounts",true);

// FALLBACK FOR OLD CART ATTERIBUTES
$has_already_set = get_post_meta($post->ID,'has_already_set_attributes',true);
if($has_already_set == ""){
$ia = 1; $g = array();
while($ia < 8){
	$att = get_post_meta($post->ID,'customlist'.$ia,true);
	if($att != ""){
	// CHECK FOR CUSTOM TITLE
	$old_title = get_option('custom_field'.$ia);
	if(strlen($old_title) > 1){
	$current_data['name'][] 	=  $old_title;
	}else{
	$current_data['name'][] 	=  "Select Value";
	}
	$current_data['value'][] 	= str_replace(",","\n",$att);
	}
$ia++;
} 
echo '<input type="hidden" name="wlt_field[has_already_set_attributes]" value="1" />';
}

?>
<div id="tabs-5"> <!-- PRODUCT ATTRIBUTES --->

<div style='font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666;'>
<a href="javascript:void(0);" onClick="jQuery('#wlt_shop_attribute_fields').clone().appendTo('#wlt_shop_attributelist');" class="button">Add New Attribute</a>	
</div>

<div class="clear"></div>
<?php do_action('hook_admin_cartfields'); ?>  
<div  class="postbox meta-box-sortables ui-sortable" style="border:0px;">
<ul id="wlt_shop_attributelist">
<?php if(is_array($current_data)){ $i=0; foreach($current_data['name'] as $data){ if($current_data['name'][$i] !=""){ ?>
<li class="postbox closed" id="ff<?php echo $i; ?>" style="border-left: 4px solid #D03AB2;"><div title="Click to toggle" class="handlediv"></div>
    <h3 class="hndle"><?php echo $current_data['name'][$i]; ?></h3>
    <div class="inside">       
        <p><b>Display Text</b> <small>(e.g size)</small></p>
        <input type="text" name="wlt_productattributes[name][]" id="ff<?php echo $i; ?>_title" value="<?php echo $current_data['name'][$i]; ?>"  style="width:100%; font-size:11px;"  />  
        <p><b>Selection Values</b> (1 per line) <b>Special Formatting:</b> Name [value] - example: Extra Large[x-large]</p>
        <textarea name="wlt_productattributes[value][]" style="width:100%;height:100px;"><?php echo trim($current_data['value'][$i]); ?></textarea>  
        <hr />
        <p><input name="colorpick<?php echo $i; ?>" type="checkbox" onchange="changeboxme('colorpick<?php echo $i; ?>');" value="1" <?php if(isset($current_data['color'][$i]) && $current_data['color'][$i] == "1"){ echo "checked=checked"; } ?> /> Tick if this is a color selection.</p>        
        <input name="wlt_productattributes[color][]" type="hidden" id="colorpick<?php echo $i; ?>"  value="<?php if(isset($current_data['color'][$i]) && $current_data['color'][$i] == "1"){ echo 1; }else{ echo 0;} ?>" />
        
        <p><input name="requiredfield<?php echo $i; ?>" type="checkbox"  onchange="changeboxme('requiredfield<?php echo $i; ?>');" value="1" <?php if(isset($current_data['required'][$i]) && $current_data['required'][$i] == "1"){ echo "checked=checked"; } ?> /> Required?</p>
       
       <input name="wlt_productattributes[required][]" type="hidden" id="requiredfield<?php echo $i; ?>"  value="<?php if(isset($current_data['required'][$i]) && $current_data['required'][$i] == "1"){ echo 1; }else{ echo 0;} ?>" />
       
        <a href="javascript:void(0);" onClick="jQuery('#ff<?php echo $i; ?>_title').val('');jQuery('#ff<?php echo $i; ?>').hide();" style="background:#D03AB2;color:#fff;padding:3px;float:right">Remove Field</a>
        <div class="clear"></div>
    </div>    
    </li>
<?php }  $i++; } } ?>
</ul>
</div>
<script>
function changeboxme(id){

 var v = jQuery("#"+id).val();
 if(v == 1){
 jQuery("#"+id).val('0');
 }else{
 jQuery("#"+id).val('1');
 }
 
}
</script>

<div style="display:none"><div id="wlt_shop_attribute_fields">
    <li class="postbox"><div title="Click to toggle" class="handlediv"></div>
    <h3 class="hndle">New Attribute</h3>
    <div class="inside">       
        <p>Display Text <small>(e.g size)</small></p>
        <input type="text" name="wlt_productattributes[name][]" value=""  style="width:100%; font-size:11px;"  />  
        <p>Selection Values (1 per line)</p>
        <textarea name="wlt_productattributes[value][]" style="width:100%;height:100px;"></textarea>  
        <hr />
        <p><input name="wlt_productattributes[color][]" type="checkbox" value="1" /> Tick if this is a color section.</p>
         <p><input name="wlt_productattributes[required][]" type="checkbox" value="1" /> Required? </p>
    </div>
    </li>    
</div></div>
</div>
<div id="tabs-6"> <!-- DISCOUNTS -->

<div style='font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666;'>
<a href="javascript:void(0);" onClick="jQuery('#wlt_shop_discount_fields').clone().appendTo('#wlt_shop_discountlist');" class="button">Add New Discount</a>	
</div>

<div  class="postbox meta-box-sortables ui-sortable" style="border:0px;">
<ul id="wlt_shop_discountlist">
<?php if(is_array($current_discount_data)){ $i=0; foreach($current_discount_data['min'] as $data){ if($current_discount_data['min'][$i] !=""){ ?>
<li class="postbox closed" id="dff<?php echo $i; ?>" style="border-left: 4px solid #7ad03a;">
<div title="Click to toggle" class="handlediv"></div>

    <h3 class="hndle">Discount: <?php echo "Order more than <b>".$current_discount_data['min'][$i]."</b> and less than <b>".$current_discount_data['max'][$i]."</b> the new item price is: ".hook_price($current_discount_data['price'][$i]); ?></h3>
    <div class="inside">       
        <p>Min: Quantity <small>(e.g 1)</small></p>
        <input type="text" name="wlt_productdiscounts[min][]" id="dff<?php echo $i; ?>_d1" value="<?php echo $current_discount_data['min'][$i]; ?>"  style="width:50%; font-size:11px;"  />  
        <p>Max: Quantity (e.g 10)</p>
        <input type="text" name="wlt_productdiscounts[max][]" id="dff<?php echo $i; ?>_d2" value="<?php echo $current_discount_data['max'][$i]; ?>"  style="width:50%; font-size:11px;"  />  
        <p>New Price Per Item (e.g. $100)</p>
        <input type="text" name="wlt_productdiscounts[price][]" id="dff<?php echo $i; ?>_f3" value="<?php echo $current_discount_data['price'][$i]; ?>"  style="width:50%; font-size:11px;"  />  
       
    
        <a href="javascript:void(0);" onClick="jQuery('#dff<?php echo $i; ?>_d1').val('');jQuery('#dff<?php echo $i; ?>').hide();" style="background:#7ad03a;color:#fff;padding:3px;float:right">Remove Field</a>
        <div class="clear"></div>
    </div>    
 
</li>
<?php }  $i++; } } ?>
</ul>
</div>
<div style="display:none"><div id="wlt_shop_discount_fields">
    <li class="postbox"><div title="Click to toggle" class="handlediv"></div>
    <h3 class="hndle">New Product Discount</h3>
    <div class="inside">       
         <p>Min: Quantity <small>(e.g 1)</small></p>
        <input type="text" name="wlt_productdiscounts[min][]"   style="width:50%; font-size:11px;"  />  
        <p>Max: Quantity (e.g 10)</p>
        <input type="text" name="wlt_productdiscounts[max][]"  style="width:50%; font-size:11px;"  />  
        <p>New Price Per Item (e.g. $100)</p>
        <input type="text" name="wlt_productdiscounts[price][]"  style="width:50%; font-size:11px;"  />  
       
    </div>
    </li>    
</div></div>

</div>  







<div id="tabs-7"> <!-- DISCOUNTS -->


asdad

</div>








<?php } // if defined cart ?>





 


 

</div>

<input name="save" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="Save Changes" style="margin-top:10px;">   
<?php
	
	}














	
	function pointer_welcome(){
		global $CORE_ADMIN;
		 
		$id      = 'li.toplevel_page_premiumpress';
		$content = '<h3>' . __( 'Congratulations!', 'premiumpress' ) . '</h3>';
		$content .= '<p>' . __( 'You\'ve just activated your PremiumPress theme.', 'premiumpress' ) . '</p>';
		$opt_arr  = array(
					'content'  => $content,
					'position' => array( 'edge' => 'top', 'align' => 'center' )
				);
		$button2  = __( "Begin Setup", 'premiumpress' );
		$function = 'document.location="' . admin_url( 'admin.php?page=premiumpress' ) . '";';
		$this->print_scripts( $id, $opt_arr, __( "Close", 'premiumpress' ), $button2, $function );
	}
	
 	function pointer_intro(){
		global $CORE_ADMIN;
		$id      = '#gotobtn';
		$content = '<h3>' . __( 'Remember!', 'premiumpress' ) . '</h3>';
		$content .= '<p>' . __( 'Watch the video tutorial first then click here!', 'premiumpress' ) . '</p>';
		$opt_arr  = array(
					'content'  => $content,
					'position' => array( 'edge' => 'top', 'align' => 'center' )
				);
		$button2  = "";// __( "Begin Setup", 'premiumpress' );
		$function = 'document.location="' . admin_url( 'admin.php?page=premiumpress' ) . '";';
		$this->print_scripts( $id, $opt_arr, __( "Close", 'premiumpress' ), $button2, $function );
		
	} 	
    
    function extra_post_row_actions($actions){ global $post;

  		
	// LAST USER VISIT
	$lastv = get_post_meta($post->ID,'last_visitor', true);
	if(strlen($lastv) > 1){
	echo "<p><small style='color:grey;'><img src='".get_template_directory_uri()."/framework/admin/img/user_red.png' alt='' align='absmiddle'> Last Viewed ".hook_date($lastv)."</small>";
	} 
 
		if( $post->post_type == THEME_TAXONOMY.'_type' ){ 
		  
		  $ST1 = ""; $ST2 = ""; $ST3 = "";
		  
		  if(defined('WLT_CART')){
		  
		  
		  
		   }else{
		   if(isset($GLOBALS['CORE_THEME']['links']['add']) && strlen($GLOBALS['CORE_THEME']['links']['add']) > 1){
		    
		  		
			if(!isset($dontShowExtraData)){	
			  // 1. BUILD PACKAGE STRING
			  $gg = get_post_meta($post->ID,'packageID',true);
			  if(isset($GLOBALS['wlt_packages']) && is_array($GLOBALS['wlt_packages']) && !empty($GLOBALS['wlt_packages'])){
			  if(isset($GLOBALS['wlt_packages'][$gg]['name'])){
			  $ps = $GLOBALS['wlt_packages'][$gg]['name'];
			  }else{
			  $ps = "";
			  }
			  }else{
			  $ps = "";
			  }
			  if($ps == ""){ $ps = "None Set"; }
			  if(isset($GLOBALS['wlt_packages']) && is_array($GLOBALS['wlt_packages']) && !empty($GLOBALS['wlt_packages']) && $ps != ""){
			  $ST1 = "<span><b>Package:</b> ".$ps."</span>";
			  }
			  // 2. BUILD AMOUNT PAID
			  if(get_post_meta($post->ID,'listing_price_paid',true) != ""){
			  $ST2 = "<span><b>Amount Paid:</b> ".hook_price(get_post_meta($post->ID,'listing_price_paid',true))."</span>";
			  }
			  
			  // 3. ID		  
			  $ST3 = "<span><b>ID:</b> ".$post->ID."</span>".'';
			  			  
				$actions = array_merge($actions, 
				  array(
				'update' => 
				@sprintf('<a href="%s" target="_blank">Front-End Editor</a> | <a href="'.get_home_url().'/wp-admin/post.php?post='.$post->ID.'&action=edit&smalleditor=1" class="wlt_editpop">Pop-up Editor</a> | <a href="%s&mediaonly=1" class="wlt_editpop">Attachments</a> | <b><a href="'.get_home_url().'/wp-admin/edit.php?post_type='.THEME_TAXONOMY.'_type&author='.$post->post_author.'" style="text-decoration:underline;">'.get_the_author_meta('display_name', $post->post_author).'</a></b>'.do_shortcode('<div class="btdata">'.$ST3.' '.$ST1.' '.$ST2.' </div>').'<br/>',
					wp_nonce_url($GLOBALS['CORE_THEME']['links']['add'].'?eid='.$post->ID.'&adminedit=1',  'abc'), wp_nonce_url($GLOBALS['CORE_THEME']['links']['add'].'?eid='.$post->ID.'&adminedit=1&mediaonly=1',  'abc')
					)
				));	
				
				
			} // end dont show extra data
			
			}
			}
			 	
		}	
   		return $actions;      
    }
 
	
	// USER FIELDS FOR THE ADMIN TO EDIT
	function userfields( $contactmethods ) { global $wpdb, $CORE;
	
	$regfields = get_option("regfields");
	if(is_array($regfields)){
		//PUT IN CORRECT ORDER
		$regfields = $CORE->multisort( $regfields , array('order') );
		foreach($regfields as $field){
		
			// EXIST IF KEY DOESNT EXIST
			if($field['key'] == "" && $field['fieldtype'] !="taxonomy" ){ continue; }
			$contactmethods[$field['key']]             = $field['name'];
		}		
	}
    
    return $contactmethods;
   }
   
   function extra_user_profile_fields( $user ) { global $wpdb, $CORE; ?>
   
   <h3>User Login Information</h3>
   
   
   <table class="form-table">
	<tr>
	<th><label for="text">Login count</label></th>
	<td>

<?php echo get_user_meta($user->ID,'login_count',true); ?>
	</td>
	</tr> 
    
    <tr>
	<th><label for="text">Last Login Date</label></th>
	<td>

<?php echo get_user_meta($user->ID,'login_lastdate',true); ?>
	</td>
	</tr> 
    
    <tr>
	<th><label for="text">Last Login IP</label></th>
	<td>
<?php echo get_user_meta($user->ID,'login_ip',true); ?>

	</td>
	</tr> 
    
    
    
    </table>
   
   	
    
    <h3>Custom Text</h3>
    <p>This text will appear on the users account area.</p>
	<table class="form-table">
	<tr>
	<th><label for="text">Text</label></th>
	<td>
    <textarea name="customtext"><?php echo stripslashes(get_user_meta($user->ID,'wlt_customtext',true)); ?></textarea>
	</td>
	</tr> 
    
    
    <tr>
    <th><label>Phone</label></th>
    <td>
    <input type="text" name="phone" value="<?php echo get_user_meta($user->ID,'phone',true); ?>" class="regular-text" />     
    </td>
    </tr> 
    
    <tr>
    <th><label>Website </label></th>
    <td>
    <input type="text" name="url" value="<?php echo get_user_meta($user->ID,'url',true); ?>" class="regular-text" />     
    </td>
    </tr> 
    
    <tr>
    <th><label>Facebook</label></th>
    <td>
    <input type="text" name="facebook" value="<?php echo get_user_meta($user->ID,'facebook',true); ?>" class="regular-text" />     
    </td>
    </tr>  
    
    <tr>
    <th><label>Twitter</label></th>
    <td>
    <input type="text" name="twitter" value="<?php echo get_user_meta($user->ID,'twitter',true); ?>" class="regular-text" />     
    </td>
    </tr> 
    
    <tr>
    <th><label>LinkedIn</label></th>
    <td>
    <input type="text" name="linkedin" value="<?php echo get_user_meta($user->ID,'linkedin',true); ?>" class="regular-text" />     
    </td>
    </tr> 
    
    <tr>
    <th><label>Skype</label></th>
    <td>
    <input type="text" name="skype" value="<?php echo get_user_meta($user->ID,'skype',true); ?>" class="regular-text" />     
    </td>
    </tr>  
    
    
    
    
	</table>
    
    <?php 
	$membershipfields = get_option("membershipfields");
	if(is_array($membershipfields) && count($membershipfields) > 0 ){ 
	$membershipfields = $CORE->multisort( $membershipfields , array('order') );	 ?>
    
    
    
    <?php if(defined('WLT_CART')){ ?>
    <h3>Shipping Address</h3>
    
    <?php global $CORE_CART; $CORE->Language();	$CORE_CART->_userfields($user->ID); ?>
    
    <?php } ?>
 
    
    
        
    <h3>Membership Information</h3>
	<table class="form-table">
	<tr>
	<th><label for="membership">Membership</label></th>
	<td>
    <?php $current_membership = get_user_meta($user->ID,'wlt_membership',true); ?>
	<select name="membership">
    
	<?php 
	foreach($membershipfields as  $field){ if($current_membership == $field['ID']){ $sel = "selected='selected'"; }else{ $sel = ""; } ?>
	<option value="<?php echo $field['ID']; ?>" <?php echo $sel; ?>><?php echo $field['name']; ?></option>
	<?php } ?>
    <option value="" <?php if($current_membership == ""){ echo "selected='selected'"; } ?>>------ no membership -------</option>
	</select>
	</td>
	</tr> 
    
    <tr>
    <th><label for="expires">Membership Expiry Date</label></th>
    <td>
    <input type="text" name="wlt_membership_expires" id="field_expiry_date" value="<?php echo get_user_meta($user->ID,'wlt_membership_expires',true); ?>" class="regular-text" /> <a href="javascript:void(0);" onclick="jQuery('#field_expiry_date').val('<?php echo date('Y-m-d H:i:s'); ?>');">Set</a>
    
    <br />
    <span class="description">Enter the date which the membership will expire. Format: Y-m-d h:i:s</span>
    </td>
    </tr> 

	</table>
    <?php } ?>
    
    
    <h3>User Credit</h3>
    <p>Here you can set an amount in monies that will be credited to the users account. Options to contact you regarding withdrawal will appear if the amount below is positive.</p>
	<table class="form-table">
	<tr>
	<th><label for="text">Amount</label></th>
	<td>
    $ <input type="text" name="wlt_usercredit" id="field_expiry_date" value="<?php echo get_user_meta($user->ID,'wlt_usercredit',true); ?>" class="regular-text" style="width:100px;" /> 
	</td>
	</tr> 
 </table>
 
 
     <h3>User Photo</h3>
    <p>Users can upload and manage their photo via their members area. This section is for admins.</p>
	<table class="form-table">
	<tr>
	<th><label for="text">Current Photo</label></th>
	<td>
     <?php echo get_avatar( $user->ID, 180 ); ?>
	</td>
	</tr> 
    
    	<tr>
	<th><label for="text">Upload/Change Photo</label></th>
	<td>
    <input type="file" name="wlt_userphoto" />
	</td>
	</tr> 
 </table>
 	<script type="text/javascript">
	var form = document.getElementById('your-profile');
	//form.enctype = "multipart/form-data"; //FireFox, Opera, et al
	form.encoding = "multipart/form-data"; //IE5.5
	form.setAttribute('enctype', 'multipart/form-data'); //required for IE6 (is interpreted into "encType")
	</script>

	<?php  }
	
	
	function save_extra_user_profile_fields( $user_id ) {
	global $CORE;
	if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
	
		update_user_meta( $user_id, 'wlt_customtext',$_POST['customtext']);
		update_user_meta( $user_id, 'wlt_usercredit',$_POST['wlt_usercredit']);

		// CHECK EMAIL IS VALID			
		update_user_meta($user_id, 'url', strip_tags($_POST['url']));
		update_user_meta($user_id, 'phone', strip_tags($_POST['phone']));
			
		// SOCIAL
		update_user_meta($user_id, 'facebook', strip_tags($_POST['facebook']));
		update_user_meta($user_id, 'twitter', strip_tags($_POST['twitter']));
		update_user_meta($user_id, 'linkedin', strip_tags($_POST['linkedin']));
		update_user_meta($user_id, 'skype', strip_tags($_POST['skype']));
		
		// USER PHOTO		 
		if(isset($_FILES['wlt_userphoto']) && strlen($_FILES['wlt_userphoto']['name']) > 2 && in_array($_FILES['wlt_userphoto']['type'],$CORE->allowed_image_types) ){
				 
				// INCLUDE UPLOAD SCRIPTS
				if(!function_exists('wp_handle_upload')){
				$dir_path = str_replace("wp-content","",WP_CONTENT_DIR);
				require $dir_path . "/wp-admin/includes/file.php";
				}
				
				// GET WORDPRESS UPLOAD DATA
				$uploads = wp_upload_dir();
				
				// UPLOAD FILE 
				$file_array = array(
					'name' 		=> $_FILES['wlt_userphoto']['name'], //$userdata->ID."_userphoto",//
					'type'		=> $_FILES['wlt_userphoto']['type'],
					'tmp_name'	=> $_FILES['wlt_userphoto']['tmp_name'],
					'error'		=> $_FILES['wlt_userphoto']['error'],
					'size'		=> $_FILES['wlt_userphoto']['size'],
				);
				//die(print_r($file_array));
				$uploaded_file = wp_handle_upload( $file_array, array( 'test_form' => FALSE ));
	 	
				// CHECK FOR ERRORS
				if(isset($uploaded_file['error']) ){		
					$GLOBALS['error_message'] = $uploaded_file['error'];
				}else{
			 	 
				// NOW LETS SAVE THE NEW ONE	
				update_user_meta($user_id, "userphoto", array('img' => $uploads['url']."/".$file_array['name'], 'path' => $uploads['path']."/".$file_array['name'] ) );
				
				}
			}

	
	if(isset($_POST['membership'])){
	
	 $bits = explode("*",$_POST['membership']);	
	 if(!is_numeric($bits[1])){ $bits[1] = 30; }	 	 
	    update_user_meta( $user_id, 'wlt_membership', $bits[0] );
		if($_POST['wlt_membership_expires'] == "" && $bits[0] != ""){
		update_user_meta( $user_id, 'wlt_membership_expires', date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +".$bits[1]." days")) );
		}else{
		update_user_meta( $user_id, 'wlt_membership_expires',$_POST['wlt_membership_expires']);
		}
		
 	}
	
	// CART DELIVERY DATA
	 if(defined('WLT_CART')){
		 foreach($_POST['delivery'] as $kk => $vv){
		 update_user_meta( $user_id, $kk, $vv);
		 }     
     }
	
	}
   
   function parse_hook($name){
   
     ob_start();
		try {			 
			do_action($name); 		 
		}
		catch (Exception $e) {
			ob_end_clean();
			throw $e;
		}
		return ob_get_clean();
    }
	
	// FUNCTON TO DISPLAY ICON
	function category_id_row( $output, $column, $term_id ){
	
		global $wpdb; $icon ="";
 
		if( $column == 'id'){
		
			return $term_id;
		
		}elseif( $column == 'description'){
		
			return strip_tags(substr($output,0,100));
		
		}elseif( $column == 'icon'){	
			
			if(isset($GLOBALS['CORE_THEME']['category_icon_'.$term_id])){
			$imgPath = $GLOBALS['CORE_THEME']['category_icon_'.$term_id];
			}else{
			$imgPath = "";
			}
			
			if(strlen($imgPath) > 5){	 
			$icon = "<img src='".$imgPath."' style='max-width:50px; max-height:50px;' />";	
			}	 
			return $icon;
		
		}else{
		
			return $output;
		
		}
	 
	}
	
	// FUNCTION CALLED WHEN SAVING THE ICON
	function wlt_update_icon_field($term_id) {
		
		if(strpos($_POST['_wp_original_http_referer'], THEME_TAXONOMY."_type") != false){
		   
		   
		    if(defined('WLT_COUPON')){ 
		   $_POST['admin_values']['category_website_'.$term_id] = strip_tags($_POST['websitelink']);	
		    }
			$_POST['admin_values']['category_icon_'.$term_id] = strip_tags($_POST['caticon']);	
			$_POST['admin_values']['category_icon_small_'.$term_id] = strip_tags($_POST['caticon1']);		
			// GET THE CURRENT VALUES
			$existing_values = get_option("core_admin_values");
			// MERGE WITH EXISTING VALUES
			$new_result = array_merge((array)$existing_values, (array)$_POST['admin_values']);
			// UPDATE DATABASE 		
			update_option( "core_admin_values", $new_result);
			 
		} // end if
	}	
	
	// FUNCTION ADDS THE CATEGORY ICON TO THE ADMIN VIEW
	function category_id_head( $columns ) {	
		//$columns['description'] = __('Description');	
		//unset($columns['title']);	 
		unset($columns['description']);
		unset($columns['slug']);	
    	$columns['icon'] = __('Icon');		 
		$columns['id'] = __('ID');		 
    	return $columns;
		
	}	
	
	// FUNCTION ADDS IN AN EXTRA FIELD TO THE CATEGORY CREATION SO YOU CAN
	// ADD AN ICON
	function my_category_fields($tag) { global $wpdb;
	
		// LOAD IN MAIN DEFAULTS
		$core_admin_values = get_option("core_admin_values"); 
		
		?>
            <input type="hidden" value="" name="imgIdblock" id="imgIdblock" />
            
            <script type="text/javascript">
			
			function ChangeImgBlock(divname){ document.getElementById("imgIdblock").value = divname; }

            function ChangeCatIcon(){			
             ChangeImgBlock('caticon');
             formfield = jQuery('#caticon').attr('name');
             tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
             return false;             
            }
			
			jQuery(document).ready(function() {			 
						
			window.send_to_editor = function(html) {
			 imgurl = jQuery('img',html).attr('src'); 
			 jQuery('#'+document.getElementById("imgIdblock").value).val(imgurl);
			 tb_remove();
			} 
			
			});
            
            </script>
		
            <table class="form-table">
            
            
            <tr class="form-field">
                    
                    <?php if(defined('WLT_COUPON')){ ?>
                    
                       <th scope="row" valign="top"><label>Website Link</label></th>
                        <td><input name="websitelink" id="websitelink" type="text" size="40" style="width:300px;" aria-required="false" value="<?php echo $core_admin_values['category_website_'.$_GET['tag_ID']]; ?>" />   
                           </td>
                    </tr>
                    
                    <?php } ?>
            
                    <tr class="form-field">
                    
                       <th scope="row" valign="top"><label>CSS Icon (e.g: fa-cogs)</label></th>
                        <td><input name="caticon1" id="caticon1" type="text" size="40" style="width:300px;" aria-required="false" value="<?php echo $core_admin_values['category_icon_small_'.$_GET['tag_ID']]; ?>" />   
                        
                        <p>This icon is only used in the category widget list and only the icon name should be entered. e.g: fa-cogs</p> 
                        <p>Full icon list is found here: <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">http://fortawesome.github.io/Font-Awesome/icons/</a>                    
                          </td>
                    </tr>
                     
                    
                        <th scope="row" valign="top"><label>Big Icon Path (http://..)</label></th>
                        <td><input name="caticon" id="caticon" type="text" size="40" aria-required="false" value="<?php echo $core_admin_values['category_icon_'.$_GET['tag_ID']]; ?>" />                        
                       <input type="button" size="36" name="upload_caticon" value="Upload Icon" onclick="ChangeCatIcon();" class="button" style="width:100px;">                   
                        
                        <div style="background:#efefef;border:1px solid #ddd; padding:20px; margin-top:20px;">
                        <p>Click any of the icons below to use it as your category image;</p>
                        <p><b>Large Icons</b></p>
                        <hr />
                           <?php
						
						$i=1;
	while($i < 57){
	
	echo "<img src='".get_template_directory_uri()."/framework/img/icons/".$i.".png' style='float:left; border:1px solid #ddd; background:#fff; padding:3px; margin-right:10px; margin-bottom:10px; cursor:pointer;' onclick=\"document.getElementById('caticon').value='".get_template_directory_uri()."/framework/img/icons/".$i.".png'\">";
	$i++;
	}
						
						?>
                        <div style="clear:both;"></div>
                        <hr />
                        <p><b>Small Icons</b></p>
                        <hr />
                         <?php
						
						$i=1;
	while($i < 57){
	
	echo "<img src='".get_template_directory_uri()."/framework/img/icons/".$i."s.png' style='float:left; border:1px solid #ddd; background:#fff; padding:3px; margin-right:10px; margin-bottom:10px; cursor:pointer;' onclick=\"document.getElementById('caticon').value='".get_template_directory_uri()."/framework/img/icons/".$i."s.png'\">";
	$i++;
	}
						
						?>
                          <div style="clear:both;"></div>
                         <hr />
                        <p><b>General Icons Pack 1</b></p>
                        <hr />
                        <div style="position:relative;">
                         <?php
						
						$i=1;
		while($i < 85){
	
	echo "<img src='".get_template_directory_uri()."/framework/img/iconpack1/".$i.".png' style='float:left; border:1px solid #ddd; background:#fff; padding:3px; margin-right:10px; margin-bottom:10px; cursor:pointer;' onclick=\"document.getElementById('caticon').value='".get_template_directory_uri()."/framework/img/iconpack1/".$i.".png'\">";
	$i++;
	}
						
						?>
                        </div>
 
                        
                        
                         <div style="clear:both;"></div>
                        </div>
                        </td>
                    </tr>
                     
            </table>
		
			 
	<?php }	
 
	function add_post_enctype() {
        echo "<script type='text/javascript'>
                  jQuery(document).ready(function(){
                      jQuery('#post').attr('enctype','multipart/form-data');
                  });
              </script>";
    }
	
	function wlt_save_post(){
	
	global $wpdb, $post, $CORE;		
	 
		if(isset($_POST['post_type']) && ( $_POST['post_type'] == THEME_TAXONOMY."_type" || $_POST['post_type'] == "page" ) && isset($_POST['wlt_field']) && !empty($_POST['wlt_field']) ){
		 	
			// CHECK FOR FILE UPLOADS
			if(isset($_FILES['wlt_attachfile']) && is_array($_FILES['wlt_attachfile']) ){	 // && 
				$u=0;
				foreach($CORE->reArrayFiles($_FILES['wlt_attachfile']) as $file_upload){			
					if(strlen($file_upload['name']) > 1){
						 
						$responce = hook_upload($post->ID, $file_upload);
						 
						if(isset($responce['error'])){
							$canContinue = false;			
							$errorMsg = $responce['error'];
						}// end if
						$u++;
					} // end if			
				} // end foeach
			} // end if
			
			// CHECK FOR FILE DELETING
			if(isset($_POST['wlt_attachdelete']) && is_array($_POST['wlt_attachdelete'])){ 			
				foreach($_POST['wlt_attachdelete'] as $fileid){	
					$CORE->UPLOAD_DELETE($post->ID.'---'.$fileid);
				}			
			}
			
			// SAVE CUSTOM META DATA
			foreach($_POST['wlt_field'] as $key=>$val){
			update_post_meta($post->ID,$key,$val);	
			}
			
			
		}
		
		// UPDATE POST TYPE
		if(isset($_POST['hidden_post_type']) && $_POST['hidden_post_type'] != $_POST['hidden_post_type_old'] ){
		$SQL = "UPDATE ".$wpdb->prefix."posts SET ".$wpdb->prefix."posts.post_type='".$_POST['hidden_post_type']."' WHERE ID = '".$post->ID."' LIMIT 1";	
		$wpdb->query($SQL);		
		}
		
		// SEND OUT PENDING EMAIL IF SET
		if(isset($_POST['send_pending_email']) && $_POST['send_pending_email'] != ""){
		
		// ADD LOG ENTRY
		$CORE->ADDLOG('Admin sent an email regarding listing (<a href="(plink)"><b>['.$post->post_title.']</b></a>.', $userdate->ID,$post->ID,'label-info');
			
		$CORE->SENDEMAIL($post->post_author,  $_POST['send_pending_email']);
		
		}
	}

	
	function wlt_metabox(){  global $post;
 
	// Allow to be filtered, just incase you really need to switch between
	// those crazy types of posts
	$args =						apply_filters( 'pts_metabox', array( 'public' => true, 'show_ui' => true )  );

	// Get the post types based on the above arguments
	$post_types =				get_post_types( (array)$args );
 	// Populate necessary post_type values
	$cur_post_type =			$post->post_type;
	$cur_post_type_object =		get_post_type_object( $cur_post_type );

	// Make sure the currently logged in user has the power
	$can_publish =				current_user_can( $cur_post_type_object->cap->publish_posts );
	?>
	<script>
	jQuery(document).ready(function() { 
		 
			jQuery('#post-type-select').siblings('a.edit-post-type').click(function() {
						if (jQuery('#post-type-select').is(":hidden")) {
							jQuery('#post-type-select').slideDown("normal");
							jQuery(this).hide();
						}
						return false;
			});
		
			jQuery('.save-post-type', '#post-type-select').click(function() {
						jQuery('#post-type-select').slideUp("normal");
						jQuery('#post-type-select').siblings('a.edit-post-type').show();
						pts_updateText();
						return false;
			});
		
			jQuery('.cancel-post-type', '#post-type-select').click(function() {
						jQuery('#post-type-select').slideUp("normal");
						jQuery('#pts_post_type').val(jQuery('#hidden_post_type').val());
						jQuery('#post-type-select').siblings('a.edit-post-type').show();
						pts_updateText();
						return false;
			});
		
			function pts_updateText() {
						jQuery('#post-type-display').html( jQuery('#pts_post_type :selected').text() );
						jQuery('#hidden_post_type').val(jQuery('#pts_post_type').val());
						jQuery('#post_type').val(jQuery('#pts_post_type').val());
						return true;
			}
		});
	</script>
	<div class="misc-pub-section post-type-switcher">
	
		<label for="pts_post_type"><img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/m5.png" style="float:left; margin-right:5px;" /> Type:</label>
		
		<span id="post-type-display"><?php echo $cur_post_type_object->label; ?></span>
		
	<?php	if ( $can_publish ) : ?>
		<a href="javascript:void(0);" class="edit-post-type hide-if-no-js" onClick="jQuery('#post-type-select').show();">Edit</a>
		<div id="post-type-select" style="display:none;">
			<select name="pts_post_type" id="pts_post_type">
	<?php foreach ( $post_types as $post_type ) {
			
			if($post_type == "ppt_alert" || $post_type == "ppt_message"){ continue; }
				$pt = get_post_type_object( $post_type );
				if ( current_user_can( $pt->cap->publish_posts ) ) : ?>
				<option value="<?php echo $pt->name; ?>"<?php if ( $cur_post_type == $post_type ) : ?>selected="selected"<?php endif; ?>><?php echo $pt->label; ?></option>
	<?php endif; } ?>
			</select>
			<input type="hidden" name="hidden_post_type" id="hidden_post_type" value="<?php echo $cur_post_type; ?>" />
            <input type="hidden" name="hidden_post_type_old" value="<?php echo $cur_post_type; ?>" />
			<a href="#pts_post_type" class="save-post-type hide-if-no-js button" onClick="jQuery('#post-type-select').hide();alert('This will be updated when you save the post.')">OK</a>
			<a href="javascript:void(0);" onClick="jQuery('#post-type-select').hide();">Cancel</a>
	 
	
	<?php endif; ?></div></div>
    
    <?php 
if($post->post_type == THEME_TAXONOMY.'_type'){
$basic_list = array (
"tab10" => array("tab" => true, "title" => "Display Extras" ),
"listing_status" => array("label" => "Status", "desc" => "If set, this will display at the top of the listing page.", "values" => array(	
		"0" 		=> "----- dont show -----",
		"1" 		=> "Un-Available",
		"2" 		=> "Leased",
		"3" 		=> "Rented",		
		"4" 		=> "Pending Sale",
		"5" 		=> "Sold",		
		"6" 		=> "Finished",		
		"8" 		=> "Abandoned", 
		"10" 		=> "--- custom message ---", 
		"7" 		=> "Closed",		
	) ), 
"listing_status_msg" => array("label" => "Custom Message", "desc" => "Here you can enter your own custom message. This will only be displayed if the listing status is set to 10." ), 	
"listing_sticker" => array("label" => "Sticker", "desc" => "If set, this will place a red sticker icon on the search results page.", "values" =>  array(	
		"0" 		=> "----- dont show -----",
		"1" 		=> "Great Value",
		"2" 		=> "Available Soon",
		"3" 		=> "Ask For Details",		
		"4" 		=> "Deal of the Month",
		"5" 		=> "Amazing!",		
		"6" 		=> "Hot Item",		
		"7" 		=> "New",		
		"8" 		=> "Popular", 
		"9" 		=> "Under Review",
		"10" 		=> "Completed", 
	) ), 
 
); 
 
	// DISPLAY OUTPPIT
$this->buildadminfields($basic_list); 
}	
	
	
		if($post->post_type == "page"){ // end if post type == post  	
	
			$page_width 		= get_post_meta($post->ID, 'width', true);
			if($page_width == ""){ $a1 = 'selected'; $a2=""; }else{$a1 = ''; $a2="selected"; } 
	 
			echo '<style>#visibility { display:none; } </style>';
	 
			echo '<div class="misc-pub-section misc-pub-section-last"><img src="'.get_template_directory_uri().'/framework/admin/img/m5.png" style="float:left; margin-right:5px;margin-top:5px;" /> Page Width: </span>';
			echo '<select name="wlt_field[width]" style="font-size:11px;">
			<option value="" '.$a1.'>inherit from theme</option>
			<option value="full" '.$a2.'>full page</option></select></div>';
		
		}
    
	}	
	
	function wlt_default_metabox_fields(){ global $wpdb, $CORE, $post;
	
	$_GET['eid'] = $post->ID;
	
	echo str_replace("form-group clearfix wlt_fieldfield","misc-pub-section",str_replace("col-md-","span",str_replace("custom","wlt_field",$CORE->CORE_FIELDS(false,true))));
	
	}	
	
	
	function HEAD(){
	
	// LOAD IN TEMPLATE
	get_template_part('framework/admin/templates/admin', 'header' );	
	
	
	} // END ADMIN HEAD
	
	function FOOTER(){
	
	// LOAD IN TEMPLATE
	get_template_part('framework/admin/templates/admin', 'footer' );	 
	
	}

	
	
	
function print_scripts( $selector, $options, $button1, $button2 = false, $button2_function = '', $button1_function = '' ) {
		?>
	<script type="text/javascript">
		//<![CDATA[
		(function ($) {
			var premiumpress_pointer_options = <?php echo json_encode( $options ); ?>, setup;

            function premiumpress_store_answer( input, nonce ) {
				var premiumpress_tracking_data = {
					action : 'premiumpress_allow_tracking',
					allow_tracking : input,
					nonce: nonce
				}
				jQuery.post( ajaxurl, premiumpress_tracking_data, function() {
                    jQuery('#wp-pointer-0').remove();
				} );
			}

			premiumpress_pointer_options = $.extend(premiumpress_pointer_options, {
				buttons:function (event, t) {
					button = jQuery('<a id="pointer-close" style="margin-left:5px" class="button-secondary">' + '<?php echo $button1; ?>' + '</a>');
					button.bind('click.pointer', function () {
						t.element.pointer('close');
					});
					return button;
				},
				close:function () {
				}
			});

			setup = function () {
				$('<?php echo $selector; ?>').pointer(premiumpress_pointer_options).pointer('open');
				<?php if ( $button2 ) { ?>
					jQuery('#pointer-close').after('<a id="pointer-primary" class="button-primary">' + '<?php echo $button2; ?>' + '</a>');
					jQuery('#pointer-primary').click(function () {
						<?php echo $button2_function; ?>
					});
					jQuery('#pointer-close').click(function () {
						<?php if ( $button1_function == '' ) { ?>
							premiumpress_setIgnore("tour", "wp-pointer-0", "<?php echo wp_create_nonce( 'premiumpress-ignore' ); ?>");
							<?php } else { ?>
							<?php echo $button1_function; ?>
							<?php } ?>
					});
					<?php } ?>
			};

			if (premiumpress_pointer_options.position && premiumpress_pointer_options.position.defer_loading)
				$(window).bind('load.wp-pointers', setup);
			else
				$(document).ready(setup);
		})(jQuery);
		//]]>
	</script>
	<?php
	}	

} // END ADMIN CLASS


 





function _admin_head() { ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link href="<?php echo get_bloginfo('template_url')."/framework/admin/"; ?>js/chosen/chosen.css" rel="stylesheet">
<link href="<?php echo get_bloginfo('template_url')."/framework/admin/"; ?>css/base.css" rel="stylesheet"> 
<script src="<?php echo get_bloginfo('template_url')."/framework/admin/"; ?>js/chosen/chosen.jquery.min.js"></script> 
<script src="<?php echo get_bloginfo('template_url')."/framework/admin/"; ?>js/ajax.js"></script>
<script src="<?php echo get_bloginfo('template_url')."/framework/admin/"; ?>js/bootstrap.min.js"></script>
<script src="<?php echo get_bloginfo('template_url')."/framework/admin/"; ?>js/scripts.js"></script>
<script src="<?php echo get_bloginfo('template_url')."/framework/admin/"; ?>js/jquery.uniform.min.js"></script> 
<script type="text/javascript">
jQuery(document).ready(function () {
	jQuery(".checkbox-on, .radio-on ").uniform();         
	// Chosen select plugin
    jQuery(".chzn-select").chosen({
    disable_search_threshold: 10
    }); 
});
</script>  
<?php
}
	
// REMOVE MENU ITEMS FROM ADMIN 
function _admin_remove_menus() {
	global $menu;
		$restricted = array(__('Dashboard'),  __('Media'), __('Profile'), __('Links'), __('Pages'), __('Appearance'), __('Tools'), __('Users'), __('Settings'), __('Comments'), __('Plugins'), __('Tools'));
		end ($menu);
		while (prev($menu)){
			$value = explode(' ',$menu[key($menu)][0]);
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
		}
}

function _admin_menu() {
  
	global $wpdb, $user; $userdata = wp_get_current_user(); $license = get_option('wlt_license_key');

	$DEFAULT_STATUS = "edit_pages";
	
	// REMOVE CUSTOMIZE BUTTON
	remove_submenu_page( 'themes.php', 'customize.php' );
	
	if(defined('WLT_DEMOMODE')  && !user_can($userdata->ID, 'administrator') ){
		$DEFAULT_STATUS = "edit_posts";
		_admin_remove_menus();
	}
	
	// HIDE IF THIS IS THE INITIAL SETUP	 
	add_menu_page('premiumpress', "Theme Options", $DEFAULT_STATUS, 'premiumpress', '_admin_page_0', ''.get_bloginfo('template_url').'/framework/admin/img/0/4.png', 3); 
	
	if($license != ""){
		 
		/* remove duplicate menu hack */
		add_submenu_page(
			'premiumpress',        // parent slug, same as above menu slug
			'Overview',        // empty page title			 
			'<img src="'.get_bloginfo('template_url').'/framework/admin/img/m00.png" align="absmiddle"> Overview',        // empty menu title
			$DEFAULT_STATUS,        // same capability as above
			'premiumpress', 
			'_admin_page_0' // callback
		);
		
		if(defined('WLT_LISTING_TITLE')){ $_tt = WLT_LISTING_TITLE; }else{ $_tt = "Listing"; }
		
		/*add_submenu_page('premiumpress', "WLTHEMES", '------------------------------', $DEFAULT_STATUS, 'admin.php?page=premiumpress', '' );
		
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/add.png" align="absmiddle"> Add '.$_tt.'', $DEFAULT_STATUS, 'post-new.php?post_type='.THEME_TAXONOMY.'_type', '' );
		
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/manage.png" align="absmiddle"> Manage '.$_tt.'s', $DEFAULT_STATUS, 'edit.php?post_type='.THEME_TAXONOMY.'_type', '' );
		
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/members.png" align="absmiddle"> Members', $DEFAULT_STATUS, 'users.php', '' );
		
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/menu.png" align="absmiddle"> Menu Setup', $DEFAULT_STATUS, 'nav-menus.php?action=edit&menu=0', '' );
		
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/widgets.png" align="absmiddle"> Widgets', $DEFAULT_STATUS, 'widgets.php', '' );
		
		*/
		
		
		// CHECK WE DONT WANT TO HIDE ANY OF THESE
		if(!defined('WLT_HIDE_ADMIN_1')){		
		add_submenu_page('premiumpress', "WLTHEMES", '------------------------------', $DEFAULT_STATUS, 'admin.php?page=premiumpress', '' );
		
		
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/m4.png" align="absmiddle"> General Setup', $DEFAULT_STATUS, '1', '_admin_page_1' );
		}
		
		
		
		if(!defined('WLT_HIDE_ADMIN_2')){ 
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/m0.png" align="absmiddle"> Page Setup', $DEFAULT_STATUS, '2', '_admin_page_2' );
		}
		
		
		// SLIDER PLUGIN
		if(isset($GLOBALS['WLT_REVSLIDER'])  ){ 		
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/m14.png" align="absmiddle"> Slider', $DEFAULT_STATUS, 'revslider' ); 
		}
		
		if(!defined('WLT_HIDE_ADMIN_16')){ 
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/m16.png" align="absmiddle"> Language Setup', $DEFAULT_STATUS, '16', '_admin_page_16' );
		}		
		
		 
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/m8.png" align="absmiddle"> Design Setup', $DEFAULT_STATUS, '8', '_admin_page_8' );
		 
		
		if(!defined('WLT_HIDE_ADMIN_3')){ 
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/m3.png" align="absmiddle"> Email Setup', $DEFAULT_STATUS, '3', '_admin_page_3' );
		}
		
		if(!defined('WLT_HIDE_ADMIN_5') && isset($GLOBALS['CORE_THEME']['template']) && $GLOBALS['CORE_THEME']['template'] != "" && !defined('WLT_CART')){
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/m5.png" align="absmiddle"> Listing Setup', $DEFAULT_STATUS, '5', '_admin_page_5' );
		}
	 	
		
	 
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/m7.png" align="absmiddle"> Advertising Setup', $DEFAULT_STATUS, '7', '_admin_page_7' );
		 
		
	 	
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/m1.png" align="absmiddle"> Payment Setup', 
		$DEFAULT_STATUS, '6&tab=gateways', '_admin_page_6' );
	 
		
		if(defined('WLT_CART')){
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/m9.png" align="absmiddle"> Tax &amp; Shipping', $DEFAULT_STATUS, '9', '_admin_page_9' );
		}  
	 
	 	add_submenu_page('premiumpress', "WLTHEMES", '------------------------------', $DEFAULT_STATUS, 'admin.php?page=premiumpress', '' );
		
 	
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/m01.png" align="absmiddle"> Order Manager', 
		$DEFAULT_STATUS, '6', '_admin_page_6' ); 		
	 
		
	 
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/m13.png" align="absmiddle"> Reports', $DEFAULT_STATUS, '13', '_admin_page_13' );
		 
		
		 
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/m6.png" align="absmiddle"> Toolbox', $DEFAULT_STATUS, '4', '_admin_page_4' );
		 
		
		add_submenu_page('premiumpress', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/m14.png" align="absmiddle"> Create Child Theme', $DEFAULT_STATUS, '14', '_admin_page_14' );
 
		 
		add_submenu_page('premiumpress', "WLTHEMES", '------------------------------', $DEFAULT_STATUS, 'admin.php?page=premiumpress', '' ); 	
		
		
		
		// ADD-ON FOR NEW MENU ITEMS
		if(!defined('WLT_DEMOMODE') && isset($GLOBALS['new_admin_menu']) && is_array($GLOBALS['new_admin_menu']) ){
			foreach($GLOBALS['new_admin_menu'] as $men){
				foreach($men as $key=>$menu){
				add_submenu_page('premiumpress', "WLTHEMES", $menu['title'], $DEFAULT_STATUS, $key, $menu['function'] );
				}
			}
		}		
		
		 
		add_menu_page('premiumpress_addons', "Theme Plugins", $DEFAULT_STATUS, 'premiumpress_addons', '_admin_page_10', ''.get_bloginfo('template_url').'/framework/admin/img/m10.png', 62); 
	 
		 
		/* remove duplicate menu hack */
		add_submenu_page(
			'premiumpress_childthemes',        // parent slug, same as above menu slug
			'Child Themes',        // empty page title			 
			'<img src="'.get_bloginfo('template_url').'/framework/admin/img/m0.png" align="absmiddle"> Child Themes',        // empty menu title
			$DEFAULT_STATUS,        // same capability as above
			'premiumpress_childthemes', 
			'_admin_page_12' // callback
		);
		
		

	   	//add_submenu_page('premiumpress_childthemes', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/m14.png" align="absmiddle"> Create New', $DEFAULT_STATUS, '14', '_admin_page_14' );
		
	   	//add_submenu_page('premiumpress_childthemes', "WLTHEMES", '<img src="'.get_bloginfo('template_url').'/framework/admin/img/m15.png" align="absmiddle"> Share Child Theme', $DEFAULT_STATUS, '15', '_admin_page_15' );
		
		
	
	} 

}

add_action( 'admin_menu', 'my_URL_menu1' );
function my_URL_menu1() {
	add_menu_page( 'My_URL_menu', 'Child Themes', 'read', 'my_slug', ''.get_bloginfo('template_url').'/framework/admin/img/m0.png', ''.get_bloginfo('template_url').'/framework/admin/img/m0.png', 63 );
}

add_action( 'admin_menu' , 'my_function_name1' );
function my_function_name1() {
	global $menu;
	$menu[63][2] = home_url()."/wp-admin/theme-install.php?browse=premiumpress";
}


function _admin_page_0() 		{  			include(TEMPLATEPATH . '/framework/admin/_0.php');  }
function _admin_page_1() 		{  			include(TEMPLATEPATH . '/framework/admin/_1.php');  }
function _admin_page_2() 		{  			include(TEMPLATEPATH . '/framework/admin/_2.php');  }
function _admin_page_3() 		{  			include(TEMPLATEPATH . '/framework/admin/_3.php');  }
function _admin_page_4() 		{  			include(TEMPLATEPATH . '/framework/admin/_4.php');  }
function _admin_page_5() 		{  			include(TEMPLATEPATH . '/framework/admin/_5.php');  }
function _admin_page_6() 		{  			include(TEMPLATEPATH . '/framework/admin/_6.php');  }
function _admin_page_7() 		{  			include(TEMPLATEPATH . '/framework/admin/_7.php');  }
function _admin_page_8() 		{  			include(TEMPLATEPATH . '/framework/admin/_8.php');  }
function _admin_page_9() 		{  			include(TEMPLATEPATH . '/framework/admin/_9.php');  }
function _admin_page_10() 		{  			include(TEMPLATEPATH . '/framework/admin/_10.php');  }
function _admin_page_11() 		{  			include(TEMPLATEPATH . '/framework/admin/_11.php');  }
 
function _admin_page_13() 		{  			include(TEMPLATEPATH . '/framework/admin/_13.php');  }
function _admin_page_14() 		{  			include(TEMPLATEPATH . '/framework/admin/_14.php');  }
function _admin_page_15() 		{  			include(TEMPLATEPATH . '/framework/admin/_15.php');  }
function _admin_page_16() 		{  			include(TEMPLATEPATH . '/framework/admin/_16.php');  }
 
function _admin_support()		{  }

// ONLY LOAD IN OUR THEME OPTIONS WHEN REQUEST OUR PAGES
$admin_page_array = array('1','2','3','4','5','6','7','8','9','10','11','12', '13', '14','15', '16','revslider', 'premiumpress', 'premiumpress_childthemes', 'premiumpress_addons');
if(isset($_GET['page']) && in_array($_GET['page'],$admin_page_array) || isset($_GET['page']) && substr($_GET['page'],0,3) == "wlt"){
	if(!isset($_GET['view']) || ( isset($_GET['view']) && $_GET['view'] == "sliders" ) ){
	add_action('admin_head', '_admin_head');
	}
}

// LOAD IN ADMIN MENU
add_action( 'admin_menu', '_admin_menu' ); 

 

/* =============================================================================
	  ADMIN AREA DSPLAY SETTINGS FOR LISTING_TYPE
	========================================================================== */
// hook the translation filters
//add_filter(  'gettext',  '_change_post_to_article'  );
//add_filter(  'ngettext',  '_change_post_to_article'  );

function _change_post_to_article( $translated ) {
     $translated = str_ireplace(  'Post',  'Article/Blog',  $translated );  // ireplace is PHP5 only
	 return $translated;
}


function _admin_extra_css(){
global $post, $CORE, $pagenow;  
 

// REMOVE INVALID TEXT FOR CHILD THEME UPLOADS
if ( is_admin() && ( isset($_GET['action']) && $_GET['action'] == "upload-theme" )  && $pagenow == 'update.php'  ) { 	
	echo "<style>#wpbody-content p strong { display:none; }</style>";	
}

// ADD SHORTCODE FOR PAGE OPTIONS
if( ( isset($_GET['post_type']) && $_GET['post_type'] == "page") || (isset($post->post_type) && $post->post_type == "page" ) ){?>
    
    
<script language="javascript">
function wltpopup(linka){
tb_show("[WLT] Shortcode List",linka+"TB_iframe=true&height=600&width=900&modal=false", null);
			 return false;
}
jQuery(function(){

/*jQuery('.add_media').after('<a href="http://www.premiumpress.com/_v8/docs/5/#!/shortcodes" target="_blank" class="button wlt_shortcodes" data-editor="content" title="Add Shortcodes" style="border: 1px solid rgb(80, 148, 88);text-shadow: 0 0px 0 #fff;;background:rgb(84, 190, 80); color:#fff;">Shortcodes</a>');*/

});
</script>	
	
	<?php }elseif( ( isset($_GET['post_type']) && $_GET['post_type'] == THEME_TAXONOMY."_type") || (isset($post->post_type) && $post->post_type == THEME_TAXONOMY."_type" ) ){
	
	echo '<style type="text/css">';
	echo '.column-image { border-right:1px solid #ddd !important; border-left:1px solid #ddd !important; align:center; } 
	.column-image { width:105px !important; text-align:center !important; } 
	.column-image .comment-count { background:green; }
	.column-image .post-com-count:after {border-top: 5px solid green; }
	.column-image img { margin-left:auto; margin-right:auto; display:block; padding:1px; border:1px solid #ccc; background:#fff; max-height:100px;max-width:100px  }
	.column-hits { width:80px !important; text-align:center !important; border-left:1px solid #ddd !important; border-right:1px solid #ddd !important; }
	.column-clicks, .column-bids { width:80px; text-align:center !important; border-right:1px solid #ddd !important; }
	.column-featured { width:100px; text-align:center !important; border-right:1px solid #ddd !important; }
	.column-comments { border-left:1px solid #ddd !important; text-align:center !important; }
	.column-comments .post-com-count { padding-left:22px; }
	th.column-comments span { font-size:9px; }
	.fixed .column-comments { width: 5em; }
	.column-expires { width:90px; border-right:1px solid #ddd !important; text-align:center; font-size:12px; }
	
	.column-price { width:100px; text-align:center !important; border-right:1px solid #ddd !important; }';	
	
	//SKU
	echo '.column-ID, .column-SKU { width:60px; font-size:10px !important; text-align:center; } .column-found { text-align:center; }'; 
    echo '</style>';	

	?>
    
<script language="javascript">
jQuery(function(){
<?php if(!defined('WLT_CART')){ ?>

<?php if(isset($_GET['action'])){ 
// BUILD EDIT LINK // DELETE LINK
if(substr($GLOBALS['CORE_THEME']['links']['add'],-1) != "/"){ 
	$editlink = $GLOBALS['CORE_THEME']['links']['add']."&eid=".$post->ID;
}else{
	$editlink = $GLOBALS['CORE_THEME']['links']['add']."?eid=".$post->ID;
}
?>
jQuery('.add_media').after('<a href="<?php echo $editlink.'&adminedit=1'; ?>&mediaonly=1" target="_blank" class="wlt_editpop button" data-editor="content" style="border: 1px solid rgb(80, 148, 88);text-shadow: 0 0px 0 #fff;;background:rgb(84, 190, 80); color:#fff;">Attachment Manager</a>');
<?php } ?>
 
<?php } ?>
<?php if($post->post_status == "pending" && !defined('WLT_CART') ){ $wlt_emails = get_option("wlt_emails"); ?>
jQuery('#titlediv').before('<div id="message" class="updated below-h2" style="padding:10px;"><b style="font-size:18px;line-height:30px;">Listing Pending Approval</b><br /> If you are unhappy with this listing or require the user to provide more information, enter the reasons below;   <br><br><b>Comments:</b><br><textarea name="wlt_field[pending_message]" style="width:100%;height:50px;padding:5px;"><?php echo addslashes(get_post_meta($post->ID,'pending_message',true)); ?></textarea><br><br>Select an email to send to the lising author; <br> <select name="send_pending_email"><option value="">-- dont send any email --</option><?php 
	if(is_array($wlt_emails)){ 
		foreach($wlt_emails as $key=>$field){ 
			if(isset($core_admin_values['emails']) && $core_admin_values['emails'][$key1] == $field['ID']){	$sel = " selected=selected ";	}else{ $sel = ""; }
			echo '<option value="'.$field['ID'].'" '.$sel.'>'.stripslashes($field['subject']).'</option>'; 
		} 
	} 
	?></select> <input type="submit" name="save" id="save-post" value="Save as Pending" class="button" style="float:right;"></div>');
<?php } ?>

});
</script>

 
    <?php }
}
 	



function _add_quick_edit($column_name, $post_type) { global $post;

// ADD IN THE ACTIONS AFTER THE IMAGE TAG  
echo $GLOBALS['epostID']."<br />"; 
if ($column_name != 'image' || defined('WLT_CART') ) return;

?>
<div class="clear clearfix"></div>
<h4 class="inline-edit-col-left">Listing Ehancements (<?php echo $post->ID; ?>)</h4>
<div class="clear clearfix"></div>
<hr />
<?php
$earray = array(
	'1' => array('dbkey'=>'frontpage','text'=>'Front Page Exposure'),
	'2' => array('dbkey'=>'featured','text'=>'Featured Listing'),
	'3' => array('dbkey'=>'html','text'=>'HTML Listing Content'), 
	'4' => array('dbkey'=>'visitorcounter','text'=>'Visitor Counter'),
	'5' => array('dbkey'=>'topcategory','text'=>'Top of Category Results Page'),
	'6' => array('dbkey'=>'showgooglemap','text'=>'Google Map'),
);	
foreach($earray as $key=>$val){

$cValue = get_post_meta($post->ID,$val['dbkey'],true);
?>
	<fieldset class="inline-edit-col-left">
    <div class="inline-edit-col">
        <span class="title"><?php echo $val['text']; ?></span>
        
		<?php  
		
		echo "<span id='".$val['dbkey']."".$post->ID."_yn'>";
				if($cValue == "yes"){
				echo "<a href='javascript:void(0);' onclick=\"WLTSaveAdminOp(".$post->ID.",'no','".$val['dbkey']."','".$val['dbkey']."".$post->ID."_yn');\"><img src='".get_template_directory_uri()."/framework/admin/img/yes.png' alt='' align='middle'></a>";
				}else{
				echo "<a href='javascript:void(0);' onclick=\"WLTSaveAdminOp(".$post->ID.",'yes','".$val['dbkey']."','".$val['dbkey']."".$post->ID."_yn');\"><img src='".get_template_directory_uri()."/framework/admin/img/no.png' alt='' align='middle'></a>";
				}
			echo "</span>";
		
		
		?>
        
        
    </div>
    </fieldset>
<?php } ?>
    
<div class="clear clearfix"></div>
<hr />
<?php
}	
function _admin_remove_columns($defaults) {
	
	if(isset($_GET['post_type']) && $_GET['post_type'] == THEME_TAXONOMY."_type" ){  
	unset($defaults['tags']); 
	unset($defaults['title']); 
	unset($defaults['author']);
	unset($defaults['comments']);
	unset($defaults['date']);
	}
 
	return $defaults;
}
function _admin_custom_columns($defaults) { global $post;

	if(isset($_GET['post_type']) && $_GET['post_type'] == THEME_TAXONOMY."_type" ){  
		
		$defaults['hits'] 		= 'Views'; 
		
		if(defined('WLT_AUCTION')){
		
		$defaults['bids'] 		= 'Bids'; 
		
		}
		
		$defaults['featured'] 	= 'Featured';
		
		if(defined('WLT_COUPON')){
		
		$defaults['clicks'] 	= 'Clicks';
		
		}
		
		if(defined('WLT_CART') || defined('WLT_COMPARISON')){
		$defaults['price'] 		= 'Price';
		//$defaults['qty'] 		= 'Quantity';
		}else{
		$defaults['expires'] 	= 'Expires';
		}
		$defaults['title'] 		= 'Title';	
		
		$defaults['date'] 		= 'Date';	
		$defaults['comments'] 		= 'Comments';	
		if(!defined('WLT_DISABLE_ADMIN_EDIT_FILES')){	 
		$defaults['image'] 		= 'Files';
		}
	}
	
	return $defaults;
	
}
function _admin_custom_column($column_name, $post_id) {
 
global $wpdb, $CORE, $post; 
 
	switch($column_name){
 	
 	
		case "clicks": {
		$clicks = get_post_meta($post_id,"clicks",true);
		if($clicks == ""){ echo 0; }else{ echo $clicks; }
		} break;	
		
		case "bids": {
			$bidding_history = get_post_meta($post_id,'current_bid_data',true);
			if(is_array($bidding_history) && !empty($bidding_history) ){
				echo count($bidding_history);
			}else{
				echo 0;
			}
		} break;	
		case "qty": {
		echo get_post_meta($post_id,"qty",true);
		} break;	
		case "price": {
			$p = get_post_meta($post_id,"price",true);
			if($p == ""){
			echo "not set";
			}else{
			echo hook_price($p);
			}
		} break;
		
		case "expires": {
		 if(defined('WLT_COUPON')){
			$p = "expiry_date";
		}else{
			$p = "listing_expiry_date";
		}
		echo do_shortcode('[TIMELEFT postid="'.$post->ID.'" layout="2" text_before="" text_ended="Not Set" key="'.$p.'"]');
		 
		} break;
		case "featured": {
			$is_featured = get_post_meta($post_id,"featured",true);
		 
			echo "<span id='".$post_id."_yn'>";
				if($is_featured == "yes"){
				echo "<a href='javascript:void(0);' onclick=\"WLTSaveAdminOp(".$post_id.",'no','featured','".$post_id."_yn');\"><img src='".get_template_directory_uri()."/framework/admin/img/yes.png' alt='' align='middle'></a>";
				}else{
				echo "<a href='javascript:void(0);' onclick=\"WLTSaveAdminOp(".$post_id.",'yes','featured', '".$post_id."_yn');\"><img src='".get_template_directory_uri()."/framework/admin/img/no.png' alt='' align='middle'></a>";
				}
			echo "</span>";
			
		} break;
		case "image": {
			$img = hook_image_display(get_the_post_thumbnail($post_id, array(100,80), array('class'=> "img-polaroid")));
			if($img == ""){
			$img = hook_fallback_image_display($CORE->FALLBACK_IMAGE($post_id)); 
			}
			if($img != ""){
			if(!defined('WLT_CART')){
			echo '<a href="" class="post-com-count" style="margin-top:55px;margin-left:90px;position:absolute"><span class="comment-count">'.$CORE->UPLOADSPACE($post->ID).'</span></a>';
			}
			echo "<a href='post.php?post=".$post_id."&action=edit'>".$img."</a>";
			} 
			$GLOBALS['epostID'] = $post_id;
		} break;		
		case "hits": {
		$hits = get_post_meta($post_id,"hits",true);	
		if($hits == "" || !is_numeric($hits)){ $hits =0; }	
		echo number_format($hits);
		}	 	
	}	 // end switch
} 

function _admin_column_register_sortable( $columns ) {
	$columns['price'] 		= 'Price'; 
	$columns['featured'] 	= 'Featured'; 
	$columns['hits'] 		= 'Views'; 
 
	$columns['clicks'] 		= 'Clicks';
	$columns['qty'] 		= 'Quantity';
	$columns['expires'] 	= 'Expires';	
	return $columns;
}

function _admin_column_orderby( $vars ) {

	if ( isset( $vars['orderby'] ) ) {	
		if('Views' == $vars['orderby'] ){		
			$vars = array_merge( $vars, array(	'meta_key' => 'hits','orderby' => 'meta_value_num',	'order' => $_GET['order']) );	
		}elseif ( 'Price' == $vars['orderby'] ){		
			$vars = array_merge( $vars, array(	'meta_key' => 'price', 'orderby' => 'meta_value', 'order' => $_GET['order']) );				
		}elseif ( 'Clicks' == $vars['orderby'] ){		
			$vars = array_merge( $vars, array(	'meta_key' => 'clicks', 'orderby' => 'meta_value', 'order' => $_GET['order']) );				
		
		
		}elseif ( 'Featured' == $vars['orderby'] ){		
			//$vars = array_merge( $vars, array(	'meta_key' => 'featured','orderby' => 'meta_value',	'order' => $_GET['order']) );
		}elseif ( 'Quantity' == $vars['orderby'] ){		
			$vars = array_merge( $vars, array(	'meta_key' => 'qty','orderby' => 'meta_value_num',	'order' => $_GET['order']) );		
		}elseif ( 'Expires' == $vars['orderby'] ){	
			if(defined('WLT_COUPON')){
				$vars = array_merge( $vars, array(	'meta_key' => 'expiry_date','orderby' => 'meta_value',	'order' => $_GET['order']) );	
			}else{
				$vars = array_merge( $vars, array(	'meta_key' => 'listing_expiry_date','orderby' => 'meta_value',	'order' => $_GET['order']) );	
			}	
				
		}			
	}
 
	return $vars;
}
 
add_action('admin_head-edit.php', 'quick_add_script');
 function quick_add_script() { 
  
 // include globals for display elements
 if(isset($_GET['post_type']) && $_GET['post_type'] == THEME_TAXONOMY."_type"){
 $GLOBALS['wlt_packages'] = get_option("packagefields"); 
 }
 
 ?>
 	<script src="<?php echo FRAMREWORK_URI; ?>js/core.ajax.js" type="text/javascript"></script>
    <script type="text/javascript">
    jQuery(document).ready(function() {	
        jQuery('a.wlt_editpop').live('click', function() {
			 tb_show('', this.href+'&amp;TB_iframe=true');
			 return false;		   
        });
		
    });
	function WLTSaveAdminOp(postid,val,act,div){
	 
	CoreDo('<?php echo str_replace("https://","",str_replace("http://","",get_home_url())); ?>/wp-admin/edit.php?core_admin_aj=1&act='+act+'&pid='+postid+'&value='+val, div);
	}
    </script>
    
    <?php
}
add_action('admin_head', 'smalleditor_css');
function smalleditor_css(){
	if(isset($_GET['smalleditor'])){
		echo "<style>#adminmenuback, #adminmenuwrap,#wpadminbar,#screen-options-link-wrap,#message { display:none; } #wpcontent { margin-left:0px !important; padding-left:20px; background:#fff; }</style>";
	}
} 
 

// PREMIUMPRESS NEWS FEED
add_action('wp_dashboard_setup', 'wlt_my_dashboard_widgets');
function wlt_my_dashboard_widgets() {
     global $wp_meta_boxes;
     // remove unnecessary widgets
     // var_dump( $wp_meta_boxes['dashboard'] ); // use to get all the widget IDs
     unset(
          $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'],
          $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'],
          $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']		  
     );
	 //unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_incoming_links']);
     // add a custom dashboard widget
     wp_add_dashboard_widget( 'dashboard_custom_feed', 'PremiumPress Lastest News', 'wlt_dashboard_custom_feed_output' ); //add new RSS feed output
}
function wlt_dashboard_custom_feed_output() {
     echo '<div class="rss-widget">';
     wp_widget_rss_output(array(
          'url' => 'http://www.premiumpress.com/feed/?post_type=blog_type',  //put your feed URL here
          'title' => 'PremiumPress Lastest News',
          'items' => 4, //how many posts to show
          'show_summary' => 1,
          'show_author' => 0,
          'show_date' => 1
     ));
     echo "</div>";
}



	function IsNumericOnly($input)
	{
		/*  NOTE: The PHP function "is_numeric()" evaluates "1e4" to true
		 *        and "is_int()" only evaluates actual integers, not 
		 *        numeric strings. */

		return preg_match("/^[0-9]*$/", $input);
	}

	function GetAsRed($string, $inBold=false)
	{
		return GetAsColor($string, 'FF0000', $inBold);
	}

	function GetAsGreen($string, $inBold=false)
	{
		return GetAsColor($string, '279B00', $inBold);
	} 
	function GetAsColor($string, $colorHex, $inBold)
	{
		$string = ($string === false || $string === 0) ? '0' : $string;
		if($inBold) $string = '<b>'.$string.'</b>';
		return '<span style="color:#'.$colorHex.'">'.$string.'</span>';
	}
	function IsExtensionInstalled($moduleName)
	{
		// The faster "less-reliable" alternative which is not used because
		// a module (or extension) names could be in different casing, so
		// 'Mysql' should be approved even though only 'mysql' is loaded		
		## return extension_loaded($moduleName);

		// Set the module name to lower case and get all loaded extensions 
		$moduleName = strtolower($moduleName);
		$extensions = get_loaded_extensions();
		foreach($extensions as $ext)
		{
			if($moduleName == strtolower($ext))
				return true;
		}

		return false;
	}
	function wlt_system_check($echo = false, $extras=false){
	
	
		$php_extentions = array(
		'title'       =>  'PHP Requirements',
		'enabled'     =>  $extras,
		'extensions'  =>  array(
							'mysql'  => 'MySQL Databases',
							'mcrypt' => 'Encryption',
							'zlib'   => 'ZIP Archives',
							'GD'   => 'Image Editing',
							'ffmpeg'   => 'Video thumbnail Service',
							'cURL'   => 'Client URL Library', 
							'exif'   => 'Exchangeable image information',							  
							'Filter'   => 'Data Filtering', 
							'FTP'   => 'File Transfer Protocol', 
							'Hash'   => 'HASH Message Digest Framework', 
							'iconv'   => 'iconv', 
							'JSON'   => 'JavaScript Object Notation', 
							'libxml'   => 'libxml', 
							'mbstring'   => 'Multibyte String', 
							'OpenSSL'   => 'OpenSSL', 
							'PCRE'   => 'Regular Expressions (Perl-Compatible)', 
							'SimpleXML'   => 'SimpleXML', 
							'Sockets'   => 'Sockets', 
							'SPL'   => 'Standard PHP Library (SPL)', 
							'Tokenizer'   => 'Tokenizer', 
							 
		)
		);
	
		$php_directives = array
		(
			// --- BOOLEAN SETTINGS : On/Off ---
			array('title'  => 'Running Safe Mode',
				  'inikey' => 'safe_mode',
				  'mustbe' => 'Off',
				),
			array('title'  => 'Register Globals',
				  'inikey' => 'register_globals',
				  'mustbe' => 'Off',
				),
			array('title'  => 'Magic Quotes Runtime',
				  'inikey' => 'magic_quotes_runtime',
				  'mustbe' => 'Off',
				),
			 array('title'  => 'Display PHP Errors',
			 	  'inikey' => 'display_errors',
			 	  'mustbe' => 'On',
			 	),
			 //array('title'  => 'Short Open Tags',
			 //	  'inikey' => 'short_open_tag',
			 //	  'mustbe' => 'On',
			 //	),
			array('title'  => 'Automatic Session Start',
				  'inikey' => 'session.auto_start',
				  'mustbe' => 'Off',
				),
			array('title'  => 'File Uploading',
				  'inikey' => 'file_uploads',
				  'mustbe' => 'On',
				),
	
			// --- NUMERIC SETTINGS : Ints ---
			array('title'    => 'Maximum Upload File Size',
				  'inikey'   => 'upload_max_filesize',
				  'orhigher' => '10M',
				),
				
			array('title'    => 'Maximum Input Time',
				  'inikey'   => 'max_input_time',
				  'orhigher' => '60',
				),
								
			array('title'    => 'Max Simultaneous Uploads',
				  'inikey'   => 'max_file_uploads',
				  'orhigher'  => '2', 
				),
			array('title'    => 'Max Execution Time',
				  'inikey'   => 'max_execution_time',
				  'orhigher' => '100',
				),			
			array('title'    => 'Memory Capacity Limit',
				  'inikey'   => 'memory_limit',
				  'orhigher' => '32M',
				),
			array('title'    => 'POST Form Maximum Size',
				  'inikey'   => 'post_max_size',
				  'orhigher' => '16M',
				),
		);
		
	$output_string = ""; $passed_checks = true;	
	
	if($php_extentions['enabled']){
	foreach($php_extentions['extensions'] as $extKey=>$extTitle){
	
						$output_string .= '<tr>';
						$output_string .= '<td><strong>'.$extTitle.'</strong><br /><small>'.$extKey.'</small></td>';
						$output_string .= '<td>On</td>';
						if(IsExtensionInstalled($extKey)){
							$output_string .= '<td>'.GetAsGreen('On', true).'</td>';								
						}else{
							$output_string .= '<td>'.GetAsRed('Off', true).'</td>'; 
						}
						$output_string .= '</tr>';
	}
	}				
	foreach($php_directives as $idx=>$directive) {
	 
	// Prepair variables
							$current = ini_get($directive['inikey']);
							$required = '';
							$icon = 'okayico';
	
							// If this directive must be equal to something, works
							// with booleans, strings and numeric values
							if(isset($directive['mustbe']))
							{
								$required = $directive['mustbe']; 
								if($required == 'On' || $required == 'Off')
								{
									// Requirements are met
									if($current == '1' && $required == 'On')
										$current = GetAsGreen('On', true);
									else if($current != '1' && $required == 'Off')
										$current = GetAsGreen('Off', true);
	
									// Current switch is not correct
									else if($current == '1')
									{
										$current = GetAsRed('On', true);
										$icon = 'failico';
										$passed_checks = false;
									}
									else 
									{
										$current = GetAsRed('Off', true);
										$icon = 'failico';
										$passed_checks = false;
									}
								}
	
								// Any other value MUST be equal!
								else if($current == $required)
									$current = GetAsGreen($current, true);
								else
								{
									$current = GetAsRed($current, true);
									$icon = 'failico';
									$passed_checks = false;
								}
							}
	
							// or Higher/Lower only works with numeric values
							else if(isset($directive['orhigher']) || isset($directive['orlower']))
							{
							
								$current = ($current === '') ? 0 : $current;
								  
								$required = (isset($directive['orhigher'])) ? $directive['orhigher'] : $directive['orlower'];
								$reqInt = $required;
								$curInt = $current;
								settype($reqInt, 'integer');
								settype($curInt, 'integer');
	
								if(isset($directive['orhigher']))
								{
									$required = $required.' <span style="font-size:11px; color:#838383;">or more</span>';
									if($curInt >= $reqInt || $current == 0){
										$current = GetAsGreen($current, true);
									}else{								
										$current = GetAsRed($current, true);									
										$icon = 'failico';
										$passed_checks = false;
									}
								}
								else if(isset($directive['orlower']))
								{
									$required = $required.' <span style="font-size:11px; color:#838383;">or less</span>';
									if($curInt <= $reqInt){
									
										$current = GetAsGreen($current, true);
										
									}else{
									
										$current = GetAsRed($current, true);
										$icon = 'failico';
										$passed_checks = false;
									}
								}
							}
					
	
							
							$output_string .= '<tr>';
							$output_string .= '<td style="font-size:12px;"><strong title="'.$directive['inikey'].'">'.$directive['title'].'</strong><br /><small>'.$directive['inikey'].'</small></td>';
							$output_string .= '<td>'.$required.'</td>';
							$output_string .= '<td>'.$current.'</td>';	
							$output_string .= '</tr>';
									
	}	
	
	if($echo){
		echo '<table class="table table-bordered" style="background:#fff;">';
		echo '<tr><td><strong>Directive Title</strong></td><td>Required</td><td><span style="color:#279B00"><b>Current</b></span></td></tr>';
		echo $output_string;
		echo '</table>';
		if(!$passed_checks){
		echo "<p class='alert alert-warning'><b>Your hosting setup needs adjusting</b><br>Contact your webserver support (hosting service) to get the necessary PHP settings fixed.</p>";
		}
	}else{
		if($passed_checks){
		return true;
		}else{
		return false;
		}
	}
	}
	
	
	
class wlt_admin_paginator {
    var $items_per_page;
    var $items_total;
    var $current_page;
    var $num_pages;
    var $mid_range;
    var $low;
    var $high;
    var $limit;
    var $return;
	var $pagelink;
    var $default_ipp = 25;
 
    function Paginator()
    {
        $this->current_page = 1;
        $this->mid_range = 7;
        $this->items_per_page = (!empty($_GET['ipp'])) ? $_GET['ipp']:$this->default_ipp;
    }
 
    function paginate()
    {
		if(!isset($_GET['ipp'])){ $_GET['ipp'] = 20; }
		
        if(isset($_GET['ipp']) && $_GET['ipp'] == 'All')
        {
            $this->num_pages = ceil($this->items_total/$this->default_ipp);
            $this->items_per_page = $this->default_ipp;
        }
        else
        {
            if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;
            $this->num_pages = ceil($this->items_total/$this->items_per_page);
        }
		if(!isset($_GET['cpage'])){ $_GET['cpage'] =1; }
		
        $this->current_page = (int) $_GET['cpage']; // must be numeric > 0
        if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 1;
        if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
        $prev_page = $this->current_page-1;
        $next_page = $this->current_page+1;
 
        if($this->num_pages > 10)
        {
            $this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<a class=\"paginate\" href=\"".$this->pagelink."&cpage=$prev_page&ipp=$this->items_per_page\">Previous</a> ":"<a class=\"inactive\" href=\"#\">Previous</a>";
 
            $this->start_range = $this->current_page - floor($this->mid_range/2);
            $this->end_range = $this->current_page + floor($this->mid_range/2);
 
            if($this->start_range <= 0)
            {
                $this->end_range += abs($this->start_range)+1;
                $this->start_range = 1;
            }
            if($this->end_range > $this->num_pages)
            {
                $this->start_range -= $this->end_range-$this->num_pages;
                $this->end_range = $this->num_pages;
            }
            $this->range = range($this->start_range,$this->end_range);
 
            for($i=1;$i<=$this->num_pages;$i++)
            {
                if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= " ... ";
                // loop through all pages. if first, last, or in range, display
                if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))
                {
                    $this->return .= ($i == $this->current_page And $_GET['cpage'] != 'All') ? "<a title=\"Go to page $i of $this->num_pages\" class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" title=\"Go to page $i of $this->num_pages\" href=\"".$this->pagelink."&cpage=$i&ipp=$this->items_per_page\">$i</a> ";
                }
                if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return;
            }
            $this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($_GET['cpage'] != 'All')) ? "<a class=\"paginate\" href=\"".$this->pagelink."&cpage=$next_page&ipp=$this->items_per_page\">Next</a>\n":"<a class=\"inactive\" href=\"#\">Next</a>\n";
            $this->return .= ($_GET['cpage'] == 'All') ? "<a class=\"current\" style=\"margin-left:10px\" href=\"#\">All</a> \n":"<a class=\"paginate\" href=\"".$this->pagelink."&cage=1&ipp=All\">All</a> \n";
        }
        else
        {
            for($i=1;$i<=$this->num_pages;$i++)
            {
                $this->return .= ($i == $this->current_page) ? "<a class=\"current\" href=\"#\">$i</a>":"<a class=\"btn btn-default\" href=\"".$this->pagelink."&cpage=$i&ipp=$this->items_per_page\">$i</a>";
            }
            $this->return .= "<a class=\"paginate\" href=\"".$this->pagelink."&cpage=1&ipp=All\">All</a> \n";
        }
        $this->low = ($this->current_page-1) * $this->items_per_page;
        $this->high = ($_GET['ipp'] == 'All') ? $this->items_total:($this->current_page * $this->items_per_page)-1;
        $this->limit = ($_GET['ipp'] == 'All') ? "":" LIMIT $this->low,$this->items_per_page";
    }
 
    function display_items_per_page()
    {
        $items = '';
        $ipp_array = array(10,25,50,100,'All');
        foreach($ipp_array as $ipp_opt)    $items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n":"<option value=\"$ipp_opt\">$ipp_opt</option>\n";
        return "<span class=\"btn btn-default\">Items per page:</span><select class=\"paginate\" onchange=\"window.location='".$this->pagelink."&cpage=1&ipp='+this[this.selectedIndex].value;return false\">$items</select>\n";
    }
 
    function display_jump_menu()
    {
        for($i=1;$i<=$this->num_pages;$i++)
        {
            $option .= ($i==$this->current_page) ? "<option value=\"$i\" selected>$i</option>\n":"<option value=\"$i\">$i</option>\n";
        }
        return "<span class=\"paginate\">Page:</span><select class=\"paginate\" onchange=\"window.location='".$this->pagelink."&cpage='+this[this.selectedIndex].value+'&ipp=$this->items_per_page';return false\">$option</select>\n";
    }
 
    function display_pages()
    {
        return $this->return;
    }
}
?>
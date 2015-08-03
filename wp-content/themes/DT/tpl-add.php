<?php
/*
Template Name: [Add Listing]
*/
/* =============================================================================
   [PREMIUMPRESS FRAMEWORK] THIS FILE SHOULD NOT BE EDITED
   ========================================================================== */
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
/* ========================================================================== */

global $CORE, $userdata; // grabs the user info and puts into vars 
 
// CHECK IF WE ARE FORCING USERS TO REGISTER
if(get_option('users_can_register') != 1){ $CORE->Authorize(); }

 
// GET PACKAGES / MEMBERSHIP LIST DATA
$packagefields 		= get_option("packagefields"); if(!is_array($packagefields)){ $packagefields = array(); }
$membershipfields 	= get_option("membershipfields");
 
// CHECK IF WE HAVE ENABLED VISITOR SUBMISSIONS
if(isset($GLOBALS['CORE_THEME']['visitor_submission']) && ( $GLOBALS['CORE_THEME']['visitor_submission'] == 0 && isset($_POST['packageID']) || $GLOBALS['CORE_THEME']['visitor_submission'] == 0 && $CORE->_PACKNOTHIDDEN($packagefields) == 0 ) && !isset($_POST['pakid']) ){ $CORE->Authorize(); } 

//STOP MEMBERSHIPS NON-PAID FOR CREATING LISTINGS
if(isset($GLOBALS['CORE_THEME']['show_mem_registraion']) && $GLOBALS['CORE_THEME']['show_mem_registraion'] == '1' && !isset($_POST['membershipID']) ){
	$TEMPMEMID = get_user_meta($userdata->ID,'new_memID',true);
	if(isset($TEMPMEMID) && is_numeric($TEMPMEMID) && isset($membershipfields[$TEMPMEMID]['price']) && $membershipfields[$TEMPMEMID]['price'] > 0){
		wp_redirect( $GLOBALS['CORE_THEME']['links']['myaccount']."?submissionlimit=1" ); exit;	
	}
}

// SET FLAGS
$GLOBALS['tpl-add'] = true;  $data = array(); 

// DISABLE LEFT ANF RIGHT SIDEBARS
$GLOBALS['nosidebar-left'] = true; $GLOBALS['nosidebar-right'] = true;

wp_register_script( 'googlemap',  $CORE->googlelink());
wp_enqueue_script( 'googlemap' );

// ADD-ON PLAYER FILES ENCASE WE HAVE VIDEO
wp_enqueue_script('video', FRAMREWORK_URI.'player/mediaelement-and-player.min.js');
wp_enqueue_script('video');
 
  

	$GLOBALS['current_membership']			= get_user_meta($userdata->ID,'wlt_membership',true);
    $GLOBALS['current_membership_expires'] 	= get_user_meta($userdata->ID,'wlt_membership_expires',true);
 
// CHECK IF THE USER HAS REACHED THEIR SUBMISSION LIMIT
if($userdata->ID && !isset($_POST['eid']) && !isset($_GET['eid']) && isset($GLOBALS['current_membership']) && isset($membershipfields[$GLOBALS['current_membership']]['submissionamount']) && !isset($_POST['membershipID']) ){
	// COUNT USER SUBMISSIONS
	$current_submissions = $CORE->count_user_posts_by_type( $userdata->ID, THEME_TAXONOMY."_type" );
 
	if(!isset($_POST['eid']) && $current_submissions >= $membershipfields[$GLOBALS['current_membership']]['submissionamount']){	
	wp_redirect( $GLOBALS['CORE_THEME']['links']['myaccount']."?submissionlimit=1" ); exit;	
	}	 
}
 
// CHECK FOR CUSTOM LINKS
if(isset($_GET['pakid']) && is_numeric($_GET['pakid'])){ $_POST['packageID'] = $_GET['pakid']; }
 
/* =============================================================================
   USER ACTIONS
   ========================================================================== */ 
if(isset($_POST['action']) && $_POST['action'] !=""){
	switch($_POST['action']){	
		case "renewalfree": {
		
		// 1. GET PACKAGE DATA
		$packagefields = get_option("packagefields");
		
		// 2. FIND OUT EXISTING PACKAGE ID
		$packageID =  get_post_meta($_POST['pid'],'packageID',true);	
		$renewal_days 	= 30;
		
		// 3. GET PRICE AND DATE 
		if(isset($packagefields[$packageID]['expires']) && is_numeric($packagefields[$packageID]['expires']) ){	
			$renewal_days = $packagefields[$packageID]['expires'];	
			if($renewal_days == ""){ $renewal_days = 30; }
		}
		 
		// 3. UPDATE LISTING
		update_post_meta( $_POST['pid'], 'listing_expiry_date', date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +".$renewal_days." days")) );
		update_post_meta( $_POST['pid'], 'current_bid_data', '' );
		update_post_meta( $_POST['pid'], 'price_current', '0' );
		
		// UPDATE THE LISTING TO MAKE IT ACTIVE
		$my_post = array();
		$my_post['ID'] 			= $_POST['pid'];
		$my_post['post_status'] = "publish";
		wp_update_post( $my_post );	
 		
		// 4. LEAVE A MESSAGE
		$GLOBALS['error_message'] 	= $CORE->_e(array('account','74'));	
		
		} break;
	
		case "save": {
	  
	     // VALIDATION
		if(strlen($_POST['form']['post_title']) < 2){ 		
			$GLOBALS['error_message'] = $CORE->_e(array('add','23')); 		
		}else{
		
		// START FLAG 
		$canContinue = true; $packagefields = get_option("packagefields");
		
		// BLANK OUT THE PACKAGE PRICE FOR MEMBERSHIP LISTINGS
		if(isset($GLOBALS['current_membership']) && !is_string($GLOBALS['current_membership']) && is_numeric($GLOBALS['current_membership'])){
		
			$_POST['packageID'] = $membershipfields[$GLOBALS['current_membership']]['package'];
			$packagefields[$_POST['packageID']]['price'] = 0; // SET THE PRICE FOR THIS PACKAGE TO 0
		}		 
		
		// START BUILDING ARRAY OF DATA
		$my_post					= array(); 
		$my_post['post_type']		= THEME_TAXONOMY."_type";
		$my_post['post_title'] 		= esc_html($_POST['form']['post_title']);
		$my_post['post_modified'] 	= date("Y-m-d h:i:s");
		// STRIP TAGS FROM NON-HTML CONTENT LISTINGS
		 
		if( (isset($_GET['eid']) && get_post_meta($_GET['eid'],'html',true) == "yes" ) || 
		( isset($_POST['packageID']) && 
		is_array($packagefields) && 
		!empty($packagefields) && 
		isset($packagefields[$_POST['packageID']]['enhancement']['3']) && 
		$packagefields[$_POST['packageID']]['enhancement']['3'] == 1 ) || 
		( isset($_POST['enhancement'][3]) && $_POST['enhancement'][3] == "on")  ){
		
		$my_post['post_content'] 	= stripslashes($_POST['form']['post_content']);	
		}else{
		$my_post['post_content'] 	= stripslashes(strip_tags(str_replace("http://","",str_replace("https://","",$_POST['form']['post_content']))));	
		}
		 
  			
		// REMOVE OPTION GROUP
		$newca = array();
		if(is_array($_POST['form']['category'])){
		foreach($_POST['form']['category'] as $cat){
			if(!is_numeric($cat) ){ continue; }
			$newca[] = $cat;
		}
		}
			
		// SAVE	
		$my_post['post_category'] = $newca;	

		// WORK OUT PACKAGE PRICE AND SAVE THIS FOR LATER PAYMENT
		$total_price_due = 0;		
		if(is_array($_POST['enhancement'])){		
			foreach($_POST['enhancement'] as $key=>$val){
			 
				if($val == "on" && is_numeric($GLOBALS['CORE_THEME']['enhancement'][$key.'_price']) ){
					 
					// NOW CHECK ITS NOT INCLUDED IN THE PACKAGE PRICE
					if(isset($packagefields[$_POST['packageID']]['enhancement'][$key]) && 
					$packagefields[$_POST['packageID']]['enhancement'][$key] == "1"  ){}else{
					
					$total_price_due += $GLOBALS['CORE_THEME']['enhancement'][$key.'_price'];
					
					}
				}
			} // end foreach
		}// end if		 
		 
		// WORK OUT ANY ADDITIONAL PRICE PER CATEGORY ITEMS		
		$extra_price_due = 0; $total_price_removed = 0;  $current_catprices = get_option('wlt_catprices'); 
		if(is_array($current_catprices)){	 
			/** work out price before (with newly selected cats) ***/
			foreach($my_post['post_category'] as $kk=>$catID){ 
				if(isset($current_catprices[$catID]) 
					&& ( isset($current_catprices[$catID]) && is_numeric($current_catprices[$catID]) && $current_catprices[$catID] > 0 ) ){				
						$extra_price_due += $current_catprices[$catID];
				}
			}
			
			/*** if were editing we need to remove cats already paid for ***/
			if(isset($_POST['eid'])){		
				$term_list = wp_get_post_terms($_POST['eid'], THEME_TAXONOMY, array("fields" => "ids"));			
				/*** now remove existing ones ***/
				foreach($term_list as $k=>$pc) { 
					if(isset($current_catprices[$pc]) 
						&& ( isset($current_catprices[$pc]) && is_numeric($current_catprices[$pc]) && $current_catprices[$pc] > 0 ) ){
							$total_price_removed += $current_catprices[$pc];
					}
				/*** unset from array ***/
				unset($checkcatsArray[$pk]); 
				} // end foreach				
			}	 
			/*** update the total price with the new amount ***/
			$total_price_due += $extra_price_due;
			 //die("new price: ".$extra_price_due." // price removed:".$total_price_removed);					 
		}// end if
		
		// PACKAGE PRICE ON TOP
		if(isset($_POST['packageID']) && is_numeric($_POST['packageID']) && $_POST['packageID'] != 99){				
			// DONT ADD PRICE ON IF ITS IN MEMBERSHIP			 
			if($GLOBALS['current_membership'] != "" && is_numeric($GLOBALS['current_membership']) && is_array($membershipfields) ){	
				if($membershipfields[$GLOBALS['current_membership']]['package'] == $_POST['packageID']){					
				}else{
					$total_price_due += $packagefields[$_POST['packageID']]['price'];
				}				
			}else{			
			$total_price_due += $packagefields[$_POST['packageID']]['price'];			
			}
			
			// REDUNCE CATEGORIES IF EXCEEDING AMOUNT
			if($packagefields[$_POST['packageID']]['multiple_cats'] == 0){
			
			$my_post['post_category'] = array($my_post['post_category'][0]);
			
			}elseif(is_numeric($packagefields[$_POST['packageID']]['multiple_cats_amount']) && count($my_post['post_category']) > $packagefields[$_POST['packageID']]['multiple_cats_amount']){
			
				$ecats = $my_post['post_category']; $ncats = array(); $i =0;
				while($i < $packagefields[$_POST['packageID']]['multiple_cats_amount']){				
				$ncats[] = $ecats[$i];
				$i++;
				}			
				$my_post['post_category'] = $ncats;
			}				
		}
		 
		// CHECK AND SET POST STATUS
		if(!isset($_POST['eid'])){
			if( $total_price_due == "" || $total_price_due < 1 ){
			
				$admin_default_status = $GLOBALS['CORE_THEME']['default_listing_status'];
				if($admin_default_status == "pending"){
				$my_post['post_status'] 	= "pending";			
				}else{
				$my_post['post_status'] 	= "publish";
				}
				
			}else{
				$my_post['post_status'] 	= "pending";
			}
		}// end if no edit	
		
		 
		// IF WE ARE NOT LOGGED IN AND THIS IS A GUEST SUBMISSION
		// CREATE THEM AN ACCOUNT AND ASSIGN THE LISTING TO THEM
		if(!isset($_POST['adminedit'])){
			if( ( !isset($userdata) ) ||  ( isset($userdata) && !$userdata->ID ) ){
			
				// CHECK IF THE USER EXISTS ALREADy
				if ( email_exists($_POST['form']['email']) ){
							
						$user = get_user_by('email', $_POST['form']['email']);
						$user_ID = $user->data->ID;	
						$userdata = $user_ID;
						$canContinue = false;			
						$errorMsg	= $CORE->_e(array('add','52'));
				}else{
				
					// CHECK IF WE HAVE A VALID EMAIL OTHERWISE ASSIGN POST TO ADMIN
					$user_email = $_POST['form']['email'];				
					// CHECK IF USERNAME EXISTS
					$new_user_name = $_POST['form']['new_username']; 
					if ( username_exists( $new_user_name ) ){
					$new_user_name = $_POST['form']['new_username'].date('d'); 
					}				
					// SETUP NEW PASSWORD
					if(isset($_POST['form']['new_password']) && strlen($_POST['form']['new_password']) > 2	){
					$random_password = $_POST['form']['new_password'];
					}else{
					$random_password = wp_generate_password( 12, false );
					}			
				
					// CREATE NEW USER
					$user_ID = wp_create_user( $new_user_name, $random_password, $user_email );
			
					if (!is_wp_error($user_ID)){
						// AUTO LOGIN NEW USER
						$creds = array();
						$creds['user_login'] 	= $new_user_name;
						$creds['user_password'] = $random_password;
						$creds['remember'] 		= true;
						$userdata = wp_signon( $creds, false );	
						 
					}else{
						$errorMsg = $user_ID->get_error_message();
						$canContinue = false;
					}			
				}				
				$my_post['post_author'] 		= $user_ID;
				
				// SEND THE NEW USER THEIR LOGIN DETAILS
				wp_new_user_notification( $user_ID, $random_password );
				// SEND WELCOME EMAIL
				$_POST['password'] = $random_password;
				$CORE->SENDEMAIL($user_ID,'welcome');
				
			}else{
				$my_post['post_author'] 		= $userdata->ID;
			}
		}	// end if is not admin edit
 
		// SAVE THE DATA
		if(isset($_POST['eid'])){
 			$my_post['ID'] 			= $_POST['eid'];
			wp_update_post( hook_add_form_post_save_data($my_post) );	
			$POSTID 				= $_POST['eid'];
			$GLOBALS['PID'] 		= $POSTID;			
			// ADD LOG ENTRY
			$CORE->ADDLOG("<a href='(ulink)'>".$userdata->user_nicename.'</a> update their listing <a href="(plink)"><b>['.$my_post['post_title'].']</b></a>.', $userdate->ID,$_POST['eid'],'label-success');
			
			update_post_meta($POSTID,'pending_message',''); // CLEAR ANY ADMIN MESSAGES SINCE WE'VE EDITED				
			 
		}else{
			$POSTID 				= wp_insert_post( hook_add_form_post_save_data($my_post) );
			$GLOBALS['PID'] 		= $POSTID;
			// ADD IN DEFAULT ACCES IF SET
			if(isset($GLOBALS['CORE_THEME']['default_access']) && is_array($GLOBALS['CORE_THEME']['default_access'])){
			add_post_meta($POSTID, 'access', $GLOBALS['CORE_THEME']['default_access']);
			}
			// DEFAULT FOR NEW LISTINGS
			add_post_meta($POSTID, 'hits', 0);			
			// CREATE SHORTCODES FOR EMAIL			 
			$_POST['title'] 	= $_POST['form']['post_title'];
			$_POST['link'] 		= get_permalink($POSTID);
			$_POST['post_date'] = hook_date(date("Y-m-d h:i:s"));
			 				
			// SEND NEW LISTING EMAIL
			$CORE->SENDEMAIL($userdata->user_email,'newlisting');	
			$CORE->SENDEMAIL('admin','admin_newlisting');
			
			// CHECK FOR USER SUBSCRIPTION EMAILS
			if(is_array($my_post['post_category']) && $userdata->ID ){			 
			foreach($my_post['post_category'] as $kk=>$catID){
				$SQL = "SELECT user_id FROM ".$wpdb->prefix."usermeta WHERE meta_value LIKE ('%*".strip_tags($catID)."*%') AND meta_key='email_subscriptions'";				 		
				$sub_results = $wpdb->get_results($SQL);
				 
				if (!empty($sub_results) ) {				
					foreach($sub_results as $val){
						$user_info = get_userdata($val->user_id);
						$_POST['username'] = $user_info->first_name . ' ' . $user_info->last_name;				
						$CORE->SENDEMAIL($val->user_id,'subscription_email');				
					}				
				}
			}
			}
			
			// ADD LOG ENTRY
			$CORE->ADDLOG("<a href='(ulink)'>".$userdata->user_nicename.'</a> added a new listing <a href="(plink)"><b>['.$my_post['post_title'].']</b></a>.', $userdata->ID, $POSTID ,'label-info');					 		
		}
		
		// POST TAGS 
		wp_set_post_tags( $POSTID, strip_tags($_POST['custom']['post_tags']), false);		 
 
		// ADD HOOK FOR ANY PLUGIN OPTIONS
		hook_add_form_post_save_extra($POSTID);
		
		// UPDATE CAT LIST
		wp_set_post_terms( $POSTID, $my_post['post_category'], THEME_TAXONOMY );		
		
		// ADD IN CUSTOM FIELDS		
		update_post_meta($POSTID, 'packageID', $_POST['packageID']);
		update_post_meta($POSTID, 'listing_price', $total_price_due);
		
		// IF IS MEMBERSHIP THEN SET THE PRICE TO 0
		if(is_numeric($GLOBALS['current_membership']) && $total_price_due == 0){
		update_post_meta($POSTID, 'listing_price_paid', 0);
		}
		
		// MAKE THIS GLOBAL FOR BOTH EDIT AND NON-EDITS BELOW
		$earray = array(
				'1' => array('dbkey'=>'frontpage','text'=>'Front Page Exposure'),
				'2' => array('dbkey'=>'featured','text'=>'Highlighted Listing'),
				'3' => array('dbkey'=>'html','text'=>'HTML Listing Content'), 
				'4' => array('dbkey'=>'visitorcounter','text'=>'Visitor Counter'),
				'5' => array('dbkey'=>'topcategory','text'=>'Top of Category Results Page'),
				'6' => array('dbkey'=>'showgooglemap','text'=>'Google Map'),
		);	
	 
		// CUSTOM FIELDS FOR enhancementS
		if(!isset($_POST['eid'])){
			$onoff = array();
			if(is_array($_POST['enhancement']) && isset($_POST['enhancement'][1]) && $_POST['enhancement'][1] == "on" ){ $onoff[1] = "yes"; }else{ $onoff[1] = "no"; }
			if(is_array($_POST['enhancement']) && isset($_POST['enhancement'][2]) && $_POST['enhancement'][2] == "on" ){ $onoff[2] = "yes"; }else{ $onoff[2] = "no"; }
			if(is_array($_POST['enhancement']) && isset($_POST['enhancement'][3]) && $_POST['enhancement'][3] == "on" ){ $onoff[3] = "yes"; }else{ $onoff[3] = "no"; }
			if(is_array($_POST['enhancement']) && isset($_POST['enhancement'][4]) && $_POST['enhancement'][4] == "on" ){ $onoff[4] = "yes"; }else{ $onoff[4] = "no"; }
			if(is_array($_POST['enhancement']) && isset($_POST['enhancement'][5]) && $_POST['enhancement'][5] == "on" ){ $onoff[5] = "yes"; }else{ $onoff[5] = "no"; }
			if(is_array($_POST['enhancement']) && isset($_POST['enhancement'][6]) && $_POST['enhancement'][6] == "on" ){ $onoff[6] = "yes"; }else{ $onoff[6] = "no"; }
			// LETS CHECK TO SEE IF WE HAVE ANY ENABLED BY DEFAULT AND IF THE DISPLAY IT TURNED OFF
			if( $GLOBALS['CORE_THEME']['show_enhancements'] != '1' && isset($_POST['packageID']) ){ // display is off so we do it manually
				foreach($earray as $key=>$val){
					if(is_array($packagefields) && !empty($packagefields) && isset($packagefields[$_POST['packageID']]['enhancement'][$key]) && $packagefields[$_POST['packageID']]['enhancement'][$key] == "1"){ 
					$onoff[$key] = "yes";
					}elseif( is_numeric($GLOBALS['current_membership']) && isset($membershipfields[$GLOBALS['current_membership']]['enhancement'][$key]) && $membershipfields[$GLOBALS['current_membership']]['enhancement'][$key] == "1"){
					$onoff[$key] = "yes";
					}
				}
			}			
			// NOW LETS UPDATE THE POST FIELDS
			update_post_meta($POSTID, 'frontpage', 		$onoff[1]); // font page
			update_post_meta($POSTID, 'featured', 		$onoff[2]); // featured
			update_post_meta($POSTID, 'html', 			$onoff[3]); // html content
			update_post_meta($POSTID, 'visitorcounter', $onoff[4]); // visitor counter
			update_post_meta($POSTID, 'topcategory', 	$onoff[5]); // visitor counter
			update_post_meta($POSTID, 'showgooglemap', 	$onoff[6]); // visitor counter
			update_post_meta($POSTID, 'listing_price_due', $total_price_due);
			
		}else{
	 
			// UPDATING AND POSSIBLY ADDING EXTRA FEATURES TO AN EXISTING LISTING
			if(isset($_POST['upgradepakid']) && is_numeric($_POST['upgradepakid'])){
			$existing_total_due = $total_price_due;
			}else{
			$existing_total_due = get_post_meta($POSTID,'listing_price_due',true);
			// NOW REMOVE ANY CHANGES MADE BY THE USER
			$existing_total_due = $existing_total_due -$total_price_removed;	 
			// NOW LETS ADD-ON ANY CHANGES MADE BY THE USER
			$existing_total_due = $existing_total_due + $extra_price_due;				
			}	
							
			// LOOP PACKAGE DATA WHEN THE enhancement ARE VISIBLE
			// TO THE USER AND THEREFORE STORED IN POST DATA  
			if(is_array($_POST['enhancement']) && !isset($_POST['upgradepakid']) ){	 
				
				foreach($earray as $key=>$val){ 		
					if(is_array($_POST['enhancement']) && isset($_POST['enhancement'][$key]) && $_POST['enhancement'][$key] == "on" && get_post_meta($POSTID, $val['dbkey'], true) != "yes" ){ 
						update_post_meta($POSTID, $val['dbkey'], 'yes');
						$existing_total_due += $GLOBALS['CORE_THEME']['enhancement'][$key.'_price'];						
					}elseif( is_array($_POST['enhancement']) && isset($_POST['enhancement'][$key]) && $_POST['enhancement'][$key] == "on" && get_post_meta($POSTID, $val['dbkey'], true) == "yes" ){
										 
					}elseif( !isset($_POST['enhancement'][$key])  && get_post_meta($POSTID, $val['dbkey'], true) == "yes" ){ 
						update_post_meta($POSTID, $val['dbkey'], 'no');
						$existing_total_due -= $GLOBALS['CORE_THEME']['enhancement'][$key.'_price'];
					}
				} // end foreach				
			 
			 }elseif(isset($_POST['upgradepakid']) ){ //!is_array($_POST['enhancement']) && 
			  
			 	foreach($earray as $key=>$val){ 	
			 
					if($packagefields[$_POST['upgradepakid']]['enhancement'][$key] == 1){
					update_post_meta($POSTID, $val['dbkey'], 'yes');
					}else{
					update_post_meta($POSTID, $val['dbkey'], 'no');
					}
				} // end foreach				  
			 
			 }		
			 
			// JUST ENCASE
			if($existing_total_due < 0){ $existing_total_due = 0; }
			// SAVE NEW PRICE
			update_post_meta($POSTID, 'listing_price_due', $existing_total_due);			
			// SET LISTING TO PENDING PAYMENT
			 	 
			if(is_numeric($existing_total_due) && $existing_total_due > 0){
				$new_status = "pending";
			}else{
				if(get_post_status ( $_POST['eid'] ) == "pending"){
				$new_status = "pending";
				}else{
				$new_status = "publish";
				}
				
			}

			$my_post = array();
			$my_post['ID'] 					= $POSTID;
			$my_post['post_status']			= $new_status;		
			wp_update_post( $my_post  );			 
		}
		
		// SET EXPIRY DATE 
	
		if(isset($_POST['custom']['listing_expiry_date']) && is_numeric($_POST['custom']['listing_expiry_date'])){
		
		update_post_meta($POSTID, 'listing_expiry_date', date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +".$_POST['custom']['listing_expiry_date']." days")));
		update_post_meta($POSTID, 'listing_expiry_days', $_POST['custom']['listing_expiry_date']);
		
		}elseif($_POST['packageID'] != 99 && is_numeric($packagefields[$_POST['packageID']]['expires']) && !isset($_POST['eid']) ){
		update_post_meta($POSTID, 'listing_expiry_date', date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +".$packagefields[$_POST['packageID']]['expires']." days")));
		}		
 
 		// SAVE THE CUSTOM DATA
		if(isset($_POST['custom']) && is_array($_POST['custom'])){ 		 
			foreach($_POST['custom'] as $key=>$val){ if($key == "listing_expiry_date"){ continue; }
			
				// CLEAN SOME ATTRIBUTES
				if(substr($key,0,5) == "price"){
				$val = preg_replace('/[^\da-z.]/i', '', $val);
				}
				
				// SAVE DATA
				if(is_array($val)){
						update_post_meta($POSTID, strip_tags($key), $val);
				}else{
						update_post_meta($POSTID, strip_tags($key), esc_html(strip_tags($val)));
				}
			}
		}
		 
			
		// SAVE THE TAXONOMY DATA
		if(isset($_POST['tax']) && is_array($_POST['tax'])){ 		 
			foreach($_POST['tax'] as $key=>$val){
			
				// CHECK IF ITS A NEW VALUE
				if(substr($val,0,11) == "newtaxvalue" ){
			
					$newcatID = str_replace("newtaxvalue_","", $val);
				
					if ( is_term( $newcatID , $key ) ){				 
						 $term = get_term_by('name', str_replace("_"," ",$newcatID), $key);
						 $val = $term->term_id;						 
					}else{
					
						// FIX FOR MAKE/MODEL GET PARENT ID
						$parentID = 0;
						if($key == "model"){						
						$parentID = $_POST['tax']['make'];
						}
						
						$args = array('cat_name' => str_replace("_"," ",$newcatID), "parent" => $parentID  ); 
						$term = wp_insert_term( str_replace("_"," ",$newcatID), $key, $args);
						if(isset($term['term_id'])){
						$val = $term['term_id'];
						}else{
						$val = $term->term_id;
						}
					}					
										
				}			
				
				// SAVE DATA
				wp_set_post_terms( $POSTID, $val, $key );
			}
		}
	 
		// CHECK FOR FILE UPLOAD
		if(isset($_FILES['image']) && is_array($_FILES['image']) ){	 // && 
		 	$u=0;
			foreach($CORE->reArrayFiles($_FILES['image']) as $file_upload){			
				if(strlen($file_upload['name']) > 1){
					if(isset($_POST['eid']) || $u == 0){
					$responce = hook_upload($POSTID, $file_upload,true);
					}else{
					$responce = hook_upload($POSTID, $file_upload);
					}
					if(isset($responce['error'])){
						$canContinue = false;			
						$errorMsg = $responce['error'];
					}// end if
					$u++;
				} // end if			
			} // end foeach
		} // end if
		
		$GLOBALS['POSTID'] = $POSTID;
		do_action('hook_add_form_post_save');		
		
		// REDIRECT LINK 	
  		$redirect = get_permalink($POSTID);
				 
		// REDIRECT TO NEXT PAGE
 		if($canContinue && $redirect != ""){
		header("location: ".$redirect);
		exit();
		}else{
		
		$GLOBALS['error_message'] = $errorMsg;
		
		}
		
		} // end invalid listing 	
					
		} break;
	
	}

}// end switch

// CHECK IF WE ARE EDITING A LISTING
if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){

	// GET POST DATA	
	$edit_data = get_post($_GET['eid']);	
	
	// CHECK WE ARE THE AUTHOR
	if($edit_data->post_author != $userdata->ID && !current_user_can('administrator') ){
	die("Not your post!");
	}
 	// GET CATEGORY LIST FROM TERMS OBJEC
	$categories 	= wp_get_object_terms( $_GET['eid'], THEME_TAXONOMY );	
	// GET CUSTM FIELD DATA 
	$custom_fields 	= get_post_custom($_GET['eid']);
	foreach ( $custom_fields as $key => $value ){	
		$data[$key] =  $value[0];	
	}
	// STORE DATA IN ARRAY TO BE PASSED TO OUR CORE FUNCTIONS
	$data['post_title'] 	=  $edit_data->post_title;
	$data['post_excerpt'] 	=  $edit_data->post_excerpt;
	$data['post_content'] 	=  $edit_data->post_content;
	$data['cats'] 			=  $categories;	  
	// GET THE PACKAGE ID
	$_POST['packageID'] = get_post_meta($_GET['eid'], 'packageID', true);
	if($_POST['packageID'] == ""){ $_POST['packageID'] =- 1; }
	
	if(isset($_GET['upgradepakid']) && is_numeric($_GET['upgradepakid']) ){
	$_POST['packageID'] = $_GET['upgradepakid'];
	}	
 
} 


if(isset($_POST['membershipID'])){

	//DISPLAY HEADER
	get_header($CORE->pageswitch());
	// HOOK INTO THE PAYMENT GATEWAY ARRAY 
	$payment_due = $membershipfields[$_POST['membershipID']]['price'];
	// GET FINAL PRICE AFTER COUPONS ETC
	$final_payment_due = hook_payment_package_price($payment_due);
	
	$STRING = '<div class="panel panel-default"><div class="panel-heading">'.$CORE->_e(array('add','53')).' - '.hook_price($final_payment_due).'</div><div class="panel-body">';
	
	// EXPIRY DATES
	if($membershipfields[$_POST['membershipID']]['expires'] == ""){ $expire_days = 365;  }else{ $expire_days = $membershipfields[$_POST['membershipID']]['expires']; }
	
	// CHECK FOR PAYMENT
	if($final_payment_due > 0){
		$STRING .= "<h4>".$CORE->_e(array('add','53'))."</h4><hr />";
	}else{
		$STRING .= "<h4>".$CORE->_e(array('add','57'))."</h4><hr /><p>".$CORE->_e(array('add','58'))."</p>";	
		// UPGRADE USERS ACCOUNT
		if($membershipfields[$_POST['membershipID']]['expires'] == ""){ $expire_days = 30;  }else{ $expire_days = $membershipfields[$_POST['membershipID']]['expires']; }
		update_user_meta( $userdata->ID, 'wlt_membership', $_POST['membershipID'] );		
		update_user_meta( $userdata->ID, 'wlt_membership_expires', date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +".$expire_days." days")) );				
	}
	
	if($final_payment_due > 0){
	$STRING .= "<div class='row'>";
	 
	$gatway = hook_payments_gateways($GLOBALS['core_gateways']);
	if(is_array($gatway) && isset($membershipfields[$_POST['membershipID']]['price']) && $payment_due > 0 ){
		
		// CHECK FOR RECURRING PAYMENTS		 
		$GLOBALS['days_till_expire'] 	= $expire_days;		 
		
	 	// CREATE ORDER ID		
		$GLOBALS['total'] 		= number_format($final_payment_due,2);
		$GLOBALS['subtotal'] 	= 0;
		$GLOBALS['shipping'] 	= 0;
		$GLOBALS['tax'] 		= 0;
		$GLOBALS['discount'] 	= 0;
		$GLOBALS['items'] 		= "";
		
		$GLOBALS['orderid'] 	= "MEM-".$_POST['membershipID']."-".$userdata->ID."-".date("Ymd");
		$GLOBALS['description'] = $membershipfields[$_POST['membershipID']]['name'];
		  
		// LOOP AND DISPLAY GATEWAYS
		foreach($gatway as $Value){
			// GATEWAY IS ENABLED 		 
			if(get_option($Value['function']) == "yes" ){
				// TEXT ONLY
				if( $Value['function'] == "gateway_bank" ){ 
					echo wpautop(get_option('bank_info'));				
				// NOT BIG FORMS
				}elseif( !isset($Value['ownform']) ){					 
				   $STRING .= '
				  
				   <div class="col-md-8"><b>'.get_option($Value['function']."_name").'</b></div>
				   <div class="col-md-4">'.$Value['function']($_POST).'</div>
				   
				   <div class="clearfix"></div><hr />'; 
				// NORMAL FORMS	
				}else{					
					$STRING .= ''.$Value['function']($_POST).'<hr /><div class="clearfix"></div>';						
				}// END IF	 
					
			}// end if
		} // end foreach
	} // end if		
	
	$STRING .= $CORE->COUPONCODES(); 
	}// end if
	
	// ADD IN TEST FOR ADMIN
	if(user_can($userdata->ID, 'administrator')){
		$STRING .= $CORE->admin_test_checkout();
	}	
	echo $STRING."</div></div>";

}elseif(

( ( is_array($packagefields) && count($packagefields) > 0 && $CORE->_PACKNOTHIDDEN($packagefields) > 0 ) ||  ( is_array($membershipfields) && count($membershipfields) > 0 && $CORE->_PACKNOTHIDDEN($packagefields) > 0  ) ) && $GLOBALS['current_membership'] == "" && !isset($_POST['packageID']) 

){
 
$GLOBALS['nosidebar-right'] = true; $GLOBALS['nosidebar-left'] = true;

//DISPLAY HEADER
get_header($CORE->pageswitch());

// HOOK PACKAGES BEFORE
hook_packages_before();
// CHECK WE HAVE PACKAGES AVAILABLE 
 
?>

 
<!-- memberships form -->
<form method="post" name="MEMBERSHIPFORM" action="<?php echo $GLOBALS['CORE_THEME']['links']['add']; ?>" id="MEMBERSHIPFORM" style="margin:0px;padding:0px;">
<input type="hidden" name="membershipID" id="membershipID" value="-1" />
</form>
 
<?php function _core_display_packages_block(){ global $wpdb, $CORE; $packagefields = get_option("packagefields"); $membershipfields = get_option("membershipfields"); 

$STRING = '<!-- packages form -->
<form method="post" name="PACKAGESFORM" action="'.$GLOBALS['CORE_THEME']['links']['add'].'" id="PACKAGESFORM">
<input type="hidden" name="packageID" id="packageID" value="-1" />
<div class="panel panel-default" id="PACKAGEBLOCK">
<div class="panel-heading">'.$CORE->_e(array('add','1')).'</div>
<div class="panel-body"> 

<i class="fa fa-magic mainicon hidden-xs"></i>
<h2>'.$CORE->_e(array('add','26')).'</h2>
<p>'.$CORE->_e(array('add','27')).'</p> 
';  

if(isset($GLOBALS['CORE_THEME']['custom']['package_text'])){ $STRING .= wpautop(stripslashes($GLOBALS['CORE_THEME']['custom']['package_text'])); }  
    
    if(is_array($packagefields) && $CORE->_PACKNOTHIDDEN($packagefields) > 0){ 
    $STRING .='
	<div class="clearfix"></div> 
          
		  <hr />
          <div class="packagesblock row">
          '.$CORE->packageblock(3,'packagefields',20).'
          </div>  
      '; 
     } 
    if(is_array($membershipfields) && count($membershipfields) > 0 && isset($GLOBALS['CORE_THEME']['show_mem_listingpage']) && $GLOBALS['CORE_THEME']['show_mem_listingpage'] == 1){    
    $STRING .='
		  <div class="clearfix"></div> 
          <hr />
		  <h3 class="text-center">'.$CORE->_e(array('add','24')).'</h3>
          <p class="text-center">'.$CORE->_e(array('add','25')).'</p> 
		  <hr /> 
          <div class="packagesblock">   
          <ul class="packagelistitems">'.$CORE->packageblock(3,'membershipfields',10).'</ul>
          </div>
      ';
    }
 

$STRING .='<div class="clearfix"></div><hr /><p class="text-center"><i class="fa fa-history"></i> &nbsp;'.$CORE->_e(array('add','28')).'</p></div></div><!-- // END PACKAGELBOCK --> ';
$STRING .='</form><!-- end packages form --><br />';
return $STRING;
} 

echo hook_packages(_core_display_packages_block());

hook_packages_after(); ?>  




<?php }else{ // end if packageID  
 
// CHECK IF WE HAVE ASSIGNED A PACKAGE ID AS PART OF THE USERS MEMBERSHIP
if(!isset($_POST['packageID']) && is_numeric($GLOBALS['current_membership']) ){
	if(isset($membershipfields[$GLOBALS['current_membership']]['package']) && is_numeric($membershipfields[$GLOBALS['current_membership']]['package']) ){
	$_POST['packageID'] = $membershipfields[$GLOBALS['current_membership']]['package'];
	$packagefields[$_POST['packageID']]['price'] = 0; // SET THE PRICE FOR THIS PACKAGE TO 0
	}
}

//DISPLAY HEADER
get_header($CORE->pageswitch());

$total_price = 0; $total_days = 0; $total_packages_price = $GLOBALS['CORE_THEME']['enhancement']['1_price']+
$GLOBALS['CORE_THEME']['enhancement']['2_price']+
$GLOBALS['CORE_THEME']['enhancement']['3_price']+
$GLOBALS['CORE_THEME']['enhancement']['5_price']+
$GLOBALS['CORE_THEME']['enhancement']['6_price']+
$GLOBALS['CORE_THEME']['enhancement']['4_price'];

// ADD-ON PACKAGE PRICE
if(isset($_GET['eid']) && !isset($_GET['upgradepakid'])){ 
$total_price = get_post_meta($_GET['eid'],'listing_price_due',true);
}else{
$total_price += $packagefields[$_POST['packageID']]['price'];
}

// ADDED ADDITIONAL CLAUSE FOR PACKAGES BEING EMPTY
if(empty($packagefields)){ $_POST['packageID'] = 99; }

// ADJUST DEFAULT UPLOAD IF PACKAGES ARE ENABLED
if(isset($_POST['packageID']) && $_POST['packageID'] != "99" && $packagefields[$_POST['packageID']]['multiple_images'] == "1" && isset($packagefields[$_POST['packageID']]['max_uploads']) && is_numeric($packagefields[$_POST['packageID']]['max_uploads'])){
$GLOBALS['default_upload_space'] = $packagefields[$_POST['packageID']]['max_uploads'];
}elseif($CORE->_PACKNOTHIDDEN($packagefields) == 0 && $GLOBALS['CORE_THEME']['default_submission_fileuploads'] > 0){
$GLOBALS['default_upload_space'] = $GLOBALS['CORE_THEME']['default_submission_fileuploads'];
}elseif($GLOBALS['default_upload_space'] == 0){
$GLOBALS['default_upload_space'] = 0;
}else{
$GLOBALS['default_upload_space'] = 5;
} 
 

hook_add_before(); ?>





<?php if( isset($GLOBALS['CORE_THEME']['show_upgradeoptions']) && $GLOBALS['CORE_THEME']['show_upgradeoptions'] == 1){ ?>
<form method="get" action="<?php echo $GLOBALS['CORE_THEME']['links']['add']; ?>" name="upgradeform">
<input type="hidden" name="upgradepakid" id="upgradepakid" value="1" />
<input type="hidden" name="eid" value="<?php echo $_GET['eid']; ?>" />
</form>
<?php } ?>


<?php if(isset($_GET['eid'])){ echo $CORE->RENEW_TOOLBOX($_GET['eid'], true); } ?> 

<form action="<?php echo $GLOBALS['CORE_THEME']['links']['add']; ?>" method="post" enctype="multipart/form-data" onsubmit="return VALIDATE_FORM_DATA();" id="SUBMISSION_FORM" >
<input type="hidden" name="action" value="save" />
<input type="hidden" name="packageID" value="<?php if(!isset($_POST['packageID']) && !is_numeric($_POST['packageID'])){ echo "-1"; }else{ echo $_POST['packageID']; } ?>" />

<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ ?>
<input type="hidden" name="eid" value="<?php echo $_GET['eid']; ?>" />
<?php }elseif(isset($_POST['eid']) && is_numeric($_POST['eid']) ){ ?>
<input type="hidden" name="eid" value="<?php echo $_POST['eid']; ?>" />
<?php } ?>

<?php if(isset($_GET['adminedit']) && is_numeric($_GET['adminedit']) ){ ?>
<input type="hidden" name="adminedit" value="1" />
<?php } ?>
<?php if(isset($_GET['upgradepakid']) && is_numeric($_GET['upgradepakid']) ){ ?>
<input type="hidden" name="upgradepakid" value="<?php echo $_GET['upgradepakid']; ?>" />
<?php } ?>
 

<div class="row" >
<aside class="col-md-4" id="steps_left_column">
<div class="panel panel-default"><div class="panel-heading"><?php echo $CORE->_e(array('add','69')); ?></div>
<div class="panel-body"> 



 
<?php 
$canShowListingData = true;
 
if(isset($GLOBALS['CORE_THEME']['show_enhancements']) && $GLOBALS['CORE_THEME']['show_enhancements'] == '1'){
if(  ( !isset($_GET['eid']) && $total_packages_price+$total_price > 0 ) || ( isset($_GET['eid']) && ( get_post_meta($_GET['eid'], 'listing_price_paid',true) == "" || isset($_GET['upgradepakid']) ) && $total_packages_price+$total_price > 0 ) ){ ?>

<h4><?php echo $CORE->_e(array('add','7')); ?></h4>
<p class="info"><?php echo $CORE->_e(array('add','8')); ?></p>  
<hr />

<!-- how does it work? -->
<?php if($packagefields[$_POST['packageID']]['price'] > 0){ ?>
 
<?php } ?>
<?php 


if($packagefields[$_POST['packageID']]['price']+$total_packages_price > 0){  ?>     
    <?php if($total_packages_price > 0  ){  ?> 
    <h4><?php echo $CORE->_e(array('add','31')); ?></h4>
    <p><?php echo $CORE->_e(array('add','32')); ?></p>
    <?php echo $CORE->packageenhancements(); ?>
    <hr />
    <?php } ?> 
<?php } 





if(!is_numeric($total_price)){ $total_price = 0; }
$total_days += $packagefields[$_POST['packageID']]['expires'];  $canShowListingData = false; 
?>
<p><?php echo $CORE->_e(array('add','33')); ?>: </p>
<div class="alert alert-success text-center totalpayment"><?php echo $GLOBALS['CORE_THEME']['currency']['symbol']; ?><span id="listingprice"><?php echo number_format($total_price,2); ?></span>
<?php if($total_days > 0){ ?> <?php echo str_replace("%a",$total_days,$CORE->_e(array('add','34'))); ?><?php } ?>
</div>
   
<?php /* end NEW PACKAGE OPTIONS ADDED IN NEW VERSION */ ?>
<?php  }

}

if(isset($_GET['eid']) ){  $ff = get_post($_GET['eid']); ?>

<?php if($canShowListingData){ ?><hr /><?php } ?>

<div class="editinfo">
<ul>

<li><span><?php echo $CORE->_e(array('add','6')); ?></span> <?php 
if(isset($packagefields[$_POST['packageID']]['name']) && $packagefields[$_POST['packageID']]['name'] != ""){ 
echo $packagefields[$_POST['packageID']]['name']; 
}else{
 echo $CORE->_e(array('add','70')); 
} 

?> &nbsp; </li>

<li><span><?php echo $CORE->_e(array('single','17')); ?></span> <?php echo hook_date($ff->post_date); ?></li>
<?php if($ff->post_date != $ff->post_modified){ ?>
<li><span><?php echo $CORE->_e(array('single','18')); ?></span> <?php echo hook_date($ff->post_modified); ?></li>
<?php } ?>
<li><span><?php echo $CORE->_e(array('single','19')); ?></span> <?php echo get_post_meta($_GET['eid'],'hits',true).' '.$CORE->_e(array('single','33')); ?></li>
<?php $expires = get_post_meta($_GET['eid'], 'listing_expiry_date',true); if($expires != ""){ ?>
<li><span><?php echo $CORE->_e(array('single','20')); ?></span> <?php echo hook_date($expires); ?></li>
<?php } ?>
</ul>
</div>


<?php if(isset($GLOBALS['CORE_THEME']['renewlisting']) && $GLOBALS['CORE_THEME']['renewlisting'] == 1){  echo $CORE->RENEW_TOOLBOX($_GET['eid'], false); } ?> 

<?php } ?>

    </div>
</div>
        
</aside>

 
 
<?php

$steps = array(
'1' => array('title' => $CORE->_e(array('add','35')) ),  // ACCOUNT CREATION
'2' => array('title' => $CORE->_e(array('add','63')) ),   
'3' => array('title' => $CORE->_e(array('add','64')) ), 
'4' => array('title' => $CORE->_e(array('add','65')) ),  
'5' => array('title' => $CORE->_e(array('add','66')) ), 
'6' => array('title' => $CORE->_e(array('add','67')) ),
);
$steps = hook_add_listtitles($steps);
 
// REMOVE STEPS IF NOT NEEDED
if( ( !isset($userdata) ) ||  ( isset($userdata) && !$userdata->ID ) ){ }else{ unset($steps[1]); } 
if(isset($GLOBALS['CORE_THEME']['google']) && $GLOBALS['CORE_THEME']['google'] == 1){ }else{  unset($steps[6]);  }
if($GLOBALS['default_upload_space'] > 0 ){ }else{ unset($steps[4]);  }
if(isset($_GET['eid'])){ unset($steps[4]); }


?> 
 

<div class="<?php if(isset($_GET['mediaonly'])){ echo "col-md-12"; }else{ echo "col-md-8"; } ?>">

<?php do_action('hook_add_form_top'); /* HOOK */ ?> 


<div id="core_saving_wrapper" style="display:none;">
<div class="alert alert-warning">
<img src="<?php echo THEME_URI; ?>/framework/img/loading.gif" style="float:left; padding-right:30px;width:80px;" />
<h1 style="padding-top:0px;margin-top:0px;"><?php echo $CORE->_e(array('add','29')); ?></h1>
<p><?php echo $CORE->_e(array('add','30')); ?></p>
<div class="clearfix"></div>
</div>
</div>

<?php if(isset($GLOBALS['CORE_THEME']['custom']['add_text'])){ echo stripslashes($GLOBALS['CORE_THEME']['custom']['add_text']); } ?>


<div id="wlt_stepswizard" class="panel-group">


<?php 
// UPGRADE OPTIONS
if(isset($_GET['eid']) && $GLOBALS['CORE_THEME']['show_upgradeoptions'] == 1){ $showAmountUps = 0; ?>

<div class="bs-callout bs-callout-success" id="UpgradeOptionsBox">
    <div class="row">
    <div class="col-md-4"><h4><?php echo $CORE->_e(array('add','60')); ?></h4></div>
    <div class="col-md-7">
    <select onchange="jQuery('#upgradepakid').val(this.value);document.upgradeform.submit();" class="form-control">
    <option></option>
    <?php foreach($packagefields as $field){ if(!is_numeric($field['ID']) || $field['price'] == "" || $field['price'] == "0" || $field['ID'] == $_POST['packageID']){ continue; }  
	if($field['hidden'] == "yes"){ continue; }
	$showAmountUps++;
	?>
    <option value="<?php echo $field['ID']; ?>" <?php if(isset($_GET['upgradepakid']) && $_GET['upgradepakid'] == $field['ID']){ echo "selected=selected"; } ?>><?php echo $field['name']; ?> (<?php echo hook_price($field['price']); ?>)</option>
    <?php } ?>
    </select>
    </div>
    </div>
</div>

<?php if($showAmountUps == 0){ ?>
<style>#UpgradeOptionsBox { display:none; }</style>
<?php } ?>
    
<?php } ?>


<?php $i=1; foreach($steps as $k => $step){ ?>
<!--- STEP <?php echo $k; ?> --->
<div class="panel panel-default" <?php if(isset($_GET['mediaonly'])){ echo "style='display:none;'"; } ?> id="panel_section<?php echo $k; ?>">
            <div class="panel-heading">
               
                <span class="step-number"><?php echo $i; ?></span>
                <?php
				
				// ADD-ON TEXT FOR TOP BOX
				if($i == 1 && !isset($_GET['eid']) ){
				
				// TOTAL NUMBER OF SUBMISSIONS
				if(isset($current_submissions)){
				echo "<div class='pull-right'><span class='label label-info'>".$CORE->_e(array('add','94'))." ".$current_submissions."/".$membershipfields[$GLOBALS['current_membership']]['submissionamount']."</span></div>";
				}

				if(isset($packagefields[$_POST['packageID']]['name']) && $packagefields[$_POST['packageID']]['name'] != ""){ echo '<div class="pull-right"><span class="label label-default">'.strip_tags($packagefields[$_POST['packageID']]['name'])."</span></div>"; }
				
				}
				
				?>
                <a href="#step<?php echo $i; ?>" class="astep<?php echo $i; ?> <?php if($k == 6){ echo 'mapboxlink'; } ?>" data-parent="#wlt_stepswizard" data-toggle="collapse"><?php echo $step['title'] ?></a>
             
            </div>
            <div id="step<?php echo $i; ?>" class="stepblock<?php echo $k; ?> panel-collapse collapse <?php if($i ==1){ echo "in"; } ?>">
              <div class="panel-body">
              
              <?php 
			  
			  $field = array(); $o=0;
			  
			  // SWITCH CONTENT BASED ON STEP
			  switch($k){
			  
				case "1": { // USER REGISTRATION
				  
					echo "<div class='bs-callout' id='new_user_registration'> <p>".$CORE->_e(array('add','36'))."</p>";					
					$field[$o]['title'] 	= $CORE->_e(array('login','10'));
					$field[$o]['name'] 		= "new_username";
					$field[$o]['type'] 		= "text";
					$field[$o]['class'] 	= "form-control";
					$field[$o]['required'] 	= true;
					if(isset($GLOBALS['CORE_THEME']['visitor_password']) && $GLOBALS['CORE_THEME']['visitor_password'] == '1'){
					$o++;
					$field[$o]['title'] 	= $CORE->_e(array('account','10'));
					$field[$o]['name'] 		= "new_password";
					$field[$o]['type'] 		= "text";
					$field[$o]['class'] 	= "form-control";
					$field[$o]['required'] 	= true;
					$field[$o]['password'] 	= true;
					}
					$o++;
					$field[$o]['title'] 	= $CORE->_e(array('account','9'));
					$field[$o]['name'] 		= "email";
					$field[$o]['type'] 		= "text";
					$field[$o]['class'] 	= "form-control";
					$field[$o]['required'] 	= true;
					echo $CORE->BUILD_FIELDS($field,$data);
					echo '</div>'; 
				  
				  
				} break;
				case "2": { // LISTING DESCRIPTION
				   
					$field[$o]['title'] 	= $CORE->_e(array('add','10'));
					$field[$o]['name'] 		= "post_title";
					$field[$o]['type'] 		= "text";
					$field[$o]['class'] 	= "form-control";
					$field[$o]['required'] 	= true;
					$field[$o]['ontop'] 	= true;
					$field[$o]['placeholder'] = hook_add_post_title_text("");
					
					$o++;
					$field[$o]['title'] 	= $CORE->_e(array('add','12'));
					$field[$o]['name'] 		= "post_content";
					$field[$o]['type'] 		= "post_content";
					$field[$o]['class'] 	= "form-control";
					$field[$o]['ontop'] 	= true;
					
					$o++;
					$field[$o]['title'] 	= $CORE->_e(array('add','71'));
					$field[$o]['name'] 		= "post_tags";
					$field[$o]['type'] 		= "text";
					$field[$o]['help'] 		= $CORE->_e(array('add','73'));
					$field[$o]['class'] 	= "form-control";
					$field[$o]['ontop'] 	= true;
					$field[$o]['placeholder'] = $CORE->_e(array('add','71','flag_noedit')).", ".$CORE->_e(array('add','71','flag_noedit'));
					echo $CORE->BUILD_FIELDS($field,$data); 
									  
				} break;
				case "3": {// CATEGORY SELECTION				  
					
					$field[$o]['title'] 	= $CORE->_e(array('add','13'));
					$field[$o]['name'] 		= "category";
					$field[$o]['type'] 		= "category";
					$field[$o]['class'] 	= "form-control";
					if( isset($_POST['packageID']) &&  $packagefields[$_POST['packageID']]['multiple_cats'] == "1"   ){
					$field[$o]['multi'] 	= true;
					}
					// MAX CATEGORIES
					if(isset($packagefields[$_POST['packageID']]['multiple_cats_amount']) && is_numeric($packagefields[$_POST['packageID']]['multiple_cats_amount']) ){
					$field[$o]['max'] 	= $packagefields[$_POST['packageID']]['multiple_cats_amount'];
					}else{
					$field[$o]['max'] 	= 10;
					}
					echo $CORE->BUILD_FIELDS($field,$data); 
				  
				} break;				  
				case "4": { // LISTING ATTACHMENTS
				  
					$field[$o]['title'] 	= "";
					$field[$o]['name'] 		= "image";
					$field[$o]['type'] 		= "image";
					$field[$o]['class'] 	= "form-control";
					if($GLOBALS['CORE_THEME']['require_image'] == 1){
					$field[$o]['required'] 	= true;
					}
					$field[$o]['ontop'] 	= true;
					$o++;				 
					echo $CORE->BUILD_FIELDS($field,$data); 
				  
				} break;				
				case "5": { // LISTING ATTRIBUTES
				
				if(isset($_GET['eid']) && $GLOBALS['CORE_THEME']['field_listingstatus'] == 1){
				$field[$o]['title'] 	= $CORE->_e(array('listvalues','title'));
				$field[$o]['name'] 		= "listing_status";
				$field[$o]['type'] 		= "select";
				$field[$o]['listvalues'] = array("0" => $CORE->_e(array('listvalues','0')), "1" => $CORE->_e(array('listvalues','1')), "2" => $CORE->_e(array('listvalues','2')), "3" => $CORE->_e(array('listvalues','3')), "4" => $CORE->_e(array('listvalues','4')), "5" => $CORE->_e(array('listvalues','5')), "6" => $CORE->_e(array('listvalues','6')), "7" => $CORE->_e(array('listvalues','7')), "8" => $CORE->_e(array('listvalues','8')));
				$field[$o]['class'] 	= "form-control";
				$field[$o]['required'] 	= true;
					// EXCLUDE FOR NON-REAL ESTATE
					if(get_option('wlt_base_theme') != "template_realestate_theme"){
					unset($field[$o]['listvalues']['2']);
					unset($field[$o]['listvalues']['3']);
					}
				}
				 
				echo $CORE->BUILD_FIELDS(hook_add_fieldlist($field),$data);				
				echo $CORE->CORE_FIELDS(false,true); // CUSTOM FIELDS
				
				} break;
				
				case "6": { // GOOGLE MAP ?>
 
            <div id="showmapbox">
            
            <input name="custom[map_location]" id="form_map_location" class="controls" type="text" placeholder="<?php echo $CORE->_e(array('add','54','flag_noedit')); ?>" value="<?php if(isset($_GET['eid'])){ echo get_post_meta($_GET['eid'],'map_location',true); } ?>">
            <div id="wlt_map_location" style="height:300px;width:100%;"></div>
           
            <div class="well well-sm">
            <b><?php echo $CORE->_e(array('add','46')); ?></b>  
             <?php echo $CORE->_e(array('add','47')); ?>: <span id="wlt_dcountry" class="label label-primary"><?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-country',true) != ""){ echo get_post_meta($_GET['eid'],'map-country',true); }else{ echo '<i class="glyphicon glyphicon-remove"></i>'; } ?></span> 
             <?php echo $CORE->_e(array('add','48')); ?>: <span id="wlt_dstate" class="label label-primary"><?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-state',true) != ""){ echo get_post_meta($_GET['eid'],'map-state',true); }else{ echo '<i class="glyphicon glyphicon-remove"></i>'; } ?></span> 
             <?php echo $CORE->_e(array('add','49')); ?>: <span id="wlt_dcity" class="label label-primary"><?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-city',true) != ""){ echo get_post_meta($_GET['eid'],'map-city',true); }else{ echo '<i class="glyphicon glyphicon-remove"></i>'; } ?></span>
             </div>
            </div> 
            
             <input type="hidden" id="map-long" name="custom[map-log]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-log',true).'"'; } ?>>
             <input type="hidden" id="map-lat" name="custom[map-lat]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-lat',true).'"'; } ?>> 
             <input type="hidden" id="map-country" name="custom[map-country]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-country',true).'"'; } ?>>
             <input type="hidden" id="map-address1" name="custom[map-address1]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-address1',true).'"'; } ?>>
             <input type="hidden" id="map-address2" name="custom[map-address2]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-address2',true).'"'; } ?>>
             <input type="hidden" id="map-address3" name="custom[map-address3]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-address3',true).'"'; } ?>>
             <input type="hidden" id="map-zip" name="custom[map-zip]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-zip',true).'"'; } ?>>
             <input type="hidden" id="map-state" name="custom[map-state]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-state',true).'"'; } ?>>
             <input type="hidden" id="map-city" name="custom[map-city]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-city',true).'"'; } ?>>
 
          
          
<script type="text/javascript"> 

var geocoder;var map;var marker = ''; var markers = [];
	
function initialize() {

if(typeof(map) != "undefined"){ return; }
   
  // GET DEFAULT LOCATION
   <?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-log',true) !=""){   
   $DF_LOCATON = get_post_meta($_GET['eid'],'map-lat',true).",".get_post_meta($_GET['eid'],'map-log',true);
   }else{
   $DF_LOCATON = $GLOBALS['CORE_THEME']['google_coords'];   
   }
   
   if($DF_LOCATON == ""){ $DF_LOCATON ="0,0"; }
   $DF_ZOOM = $GLOBALS['CORE_THEME']['google_zoom'];
   if($DF_ZOOM == ""){ $DF_ZOOM = "5"; }
   ?>
   
  // CREATE MAP CANVUS
  var myOptions = {mapTypeId: google.maps.MapTypeId.ROADMAP, zoomControl: true, scaleControl: true }
  map = new google.maps.Map(document.getElementById("wlt_map_location"), myOptions); 
     
  // LOAD MAP LOCATIONS
  var defaultBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(<?php echo $DF_LOCATON; ?>) );
   map.fitBounds(defaultBounds);

  // ADD ON MARKER
  <?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-log',true) !=""){ ?>
  var marker = new google.maps.Marker({
  	position: new google.maps.LatLng(<?php echo get_post_meta($_GET['eid'],'map-lat',true); ?>,<?php echo get_post_meta($_GET['eid'],'map-log',true); ?>),
  	map: map,
  	animation: google.maps.Animation.DROP,	
	icon: new google.maps.MarkerImage('<?php echo get_template_directory_uri(); ?>/framework/img/map/icon.png'),			 
  });
  <?php } ?> 

  // ADD SEARCH BOX
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(document.getElementById('form_map_location'));
  var searchBox = new google.maps.places.SearchBox(document.getElementById('form_map_location'));

  // EVENT
  google.maps.event.addListener(searchBox, 'places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }
    for (var i = 0, marker; marker = markers[i]; i++) {
      marker.setMap(null);
    }
	
    // For each place, get the icon, place name, and location. 
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0, place; place = places[i]; i++) {
      var image = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      }; 
	  

        addMarker(place.geometry.location);
	    document.getElementById("map-long").value = place.geometry.location.lng();	
    	document.getElementById("map-lat").value =  place.geometry.location.lat();
	    getMyAddress(place.geometry.location,true)

      bounds.extend(place.geometry.location);
    }

    map.fitBounds(bounds);	
	map.setZoom(12);	 
  });

  // EVENT
  google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();
    searchBox.setBounds(bounds);
	
  });
  
  // EVENT
  google.maps.event.addListener(map, 'click', function(event){			
  	document.getElementById("map-long").value = event.latLng.lng();	
    document.getElementById("map-lat").value =  event.latLng.lat();
    getMyAddress(event.latLng,"yes");	
    addMarker(event.latLng);
  });
  
  // DEFAULT ZOOM LEVEL
  var listener = google.maps.event.addListener(map, "idle", function() { 
	  if (map.getZoom() != <?php echo $DF_ZOOM; ?>){ map.setZoom(<?php echo $DF_ZOOM; ?>);  } 
	  google.maps.event.removeListener(listener); 
  });
  
} // END INIT


jQuery("#form_map_location").focusout(function() {
setTimeout(function(){  getMapLocation(jQuery("#form_map_location").val()); }, 500);


});

function getMapLocation(location){
                        document.getElementById("map-state").value = "";
                        var geocoder = new google.maps.Geocoder();
                            if (geocoder) {	geocoder.geocode({"address": location}, function(results, status) {	if (status == google.maps.GeocoderStatus.OK) {
						 	 
                            map.setCenter(results[0].geometry.location);
                            addMarker(results[0].geometry.location);
                            getMyAddress(results[0].geometry.location,"no");			
                            document.getElementById("map-long").value = results[0].geometry.location.lng();	
                            document.getElementById("map-lat").value =  results[0].geometry.location.lat();
                            map.setZoom(<?php $default_zoom = $GLOBALS['CORE_THEME']['google_zoom']; if($default_zoom == ""){ $default_zoom = "9"; } echo $default_zoom; ?>);		
                            }});}			
}

 function getMyAddress(location,setaddress){
                         
                        jQuery('#showmapbox').show();
                        google.maps.event.trigger(map, 'resize');
                        var geocoder = new google.maps.Geocoder();
                        var country = "";
                        if (geocoder) {geocoder.geocode({"latLng": location}, function(results, status) { if (status == google.maps.GeocoderStatus.OK) {
                        
                        for (var i = 0; i < results[0].address_components.length; i++) {
				
							  var addr = results[0].address_components[i];
							  //alert(addr.types[0]);
							  switch (addr.types[0]){
								
								case "street_number": {
									document.getElementById("map-address1").value = addr.long_name;
								} break;
								
								case "route": {
									document.getElementById("map-address2").value = addr.long_name;
								} break;
								
								case "locality": 
								//case "postal_town": 
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
						
						// NOW SET THE DISPLAY VALUES
						jQuery('#wlt_dcity').html(document.getElementById("map-city").value);					
						jQuery('#wlt_dstate').html(document.getElementById("map-state").value);
             			jQuery('#wlt_dcountry').html(document.getElementById("map-country").value);
			 
                        if(setaddress == "yes"){
                        document.getElementById("form_map_location").value = results[0].formatted_address;
                        }
                        
                        map.setCenter(results[0].geometry.location);		
                        map.setZoom(15);	
                        
                        }		});	}} 
                        
                        
                        function addMarker(location) {
						if (marker=='') {	
						
						
						marker = new google.maps.Marker({	position: location, 	map: map, draggable:true,     animation: google.maps.Animation.DROP,	});
						
						
						google.maps.event.addListener (marker, 'dragend', function (event){
						document.getElementById("map-long").value = event.latLng.lng();	
                        document.getElementById("map-lat").value =  event.latLng.lat();
                        getMyAddress(event.latLng,"yes");	
                        addMarker(event.latLng);
						});
						
						
						}						
                        marker.setPosition(location);
						map.setCenter(location); 						
						}
						

// LOAD MAP BOX
jQuery(document).ready(function() {                         
	jQuery( ".mapboxlink" ).click(function() { 	 
		setTimeout(function(){  initialize(); }, 1000);
	});
});
</script>

 
             <?php  } break; 
 
			 
			 default: {
			 
			 hook_add_listdata($k);
			 
			 } break;
			  
			  } ?> 
              
              </div>
           </div>

</div>
<!--- STEP <?php echo $k; ?> ---> 
<?php $i++; } ?>

</form> <!-- END STEPS FORM DATA -->











 
<?php 
 
if(isset($_GET['eid'])){ 
// GET EXISTING UPLOAD COUNT
$EXISTING_UPLOAD_COUNT = $CORE->UPLOADSPACE($_GET['eid']);
 

if(  
(isset($_GET['mediaonly']) && current_user_can( 'edit_user', $userdata->ID )) ||
( isset($_POST['packageID']) &&  ( $packagefields[$_POST['packageID']]['multiple_images'] == "1" || ( ( count($packagefields) == 0 || count($packagefields) == 1 ) && $GLOBALS['CORE_THEME']['default_submission_fileuploads'] > 0) )  ) || 
( !isset($_POST['packageID']) && $GLOBALS['CORE_THEME']['default_submission_fileuploads'] > 0 )   
){ 

 

// QUICK FIX FOR ADIN UPLOADING
if( isset($_GET['mediaonly']) && current_user_can( 'edit_user', $userdata->ID)  ){ $GLOBALS['default_upload_space'] = 100; }
// CHECK THE USER HASNT ALREADY UPLOADED 1 IMAGE AS PART OF THE DEFAULT UPLOAD FORM
if($GLOBALS['default_upload_space'] == 1 && $EXISTING_UPLOAD_COUNT == 0 && !isset($_GET['eid'])){ /* blank me */ }else{
?>
 
<?php do_action('hook_add_before_media'); ?> 

<div class="panel panel-default"><div class="panel-heading"> <span class="step-number"><?php echo $i; ?></span> 
<a href="#step<?php echo $i; ?>" class="astep<?php echo $i; ?>" data-parent="#wlt_stepswizard" data-toggle="collapse">
<?php echo $CORE->_e(array('add','65')); ?> (<?php echo $EXISTING_UPLOAD_COUNT."/".$GLOBALS['default_upload_space']; ?>) 
</a>
</div>
<div id="step<?php echo $i; ?>" class="stepblockmedia panel-collapse collapse <?php if(isset($_GET['mediaonly'])){ echo "in"; } ?>"><div class="panel-body"> 


  
 
 
 
        <?php } ?>
        
        <script>
		function ShowThisType(type){
		
			jQuery(this).addClass('active');
			
			jQuery('#mediatablelist .item').hide();
			if(type == "all"){
				jQuery('#mediatablelist .item').show();
			}else{
				jQuery('#mediatablelist .ftype_'+type).show();
			}
		}
		 jQuery(document).ready(function() { 
            ShowThisType('image');
			//jQuery('#iconbar li:eq(2) a').tab('show')
        });
		</script>
 

<form id="fileupload" action="<?php echo get_home_url(); ?>/index.php" method="POST" enctype="multipart/form-data">
       
	   <?php if($EXISTING_UPLOAD_COUNT <= $GLOBALS['default_upload_space']){ ?>
       
       <!-- MASS UPLOAD FILE PROGRESS BAR --->
       <div class="fileupload-progress fade" id="fileuploaddisplayall" style="display:none;">
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="bar progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <div class="progress-extended">&nbsp;</div>
        <hr />
       </div>
        
       <!--- UPLOAD BUTTONS -->
       <div class="fileupload-loading"></div>
       <div class="fileupload-buttonbar">
           
                <button type="button" class="btn btn-info start pull-right"  onclick="jQuery('#fileuploaddisplayall').show();">
                    <i class="glyphicon glyphicon-upload glyphicon glyphicon-white"></i>
                    <span><?php echo $CORE->_e(array('add','19')); ?></span>
                </button>
            
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus glyphicon glyphicon-white"></i>
                    <span><?php echo $CORE->_e(array('add','18')); ?></span>
                    <input type="file" name="files[]" multiple >
                </span>
                
     <div class="clearfix"></div>        
     </div>
     
     <p><small><?php echo $CORE->_e(array('add','61')); ?></small></p>
     <hr />
     
     <!-- EDIT MEDIA BOX --->
     <div class="editbox" id="editmediabox" style="display:none;">
        <div class="bs-callout bs-callout-success">
            <div class="pull-right">
                <div class="btn btn-default" onclick="jQuery('#editmediabox').hide();">
                    <i class="glyphicon glyphicon-remove icon-white"></i>
                </div>
            </div>
            
            <h4><?php echo $CORE->_e(array('add','88')); ?></h4>
        	<hr />
            <div id="editmediaboxcontent"></div>
          	            
        </div>
     </div>
     <!-- END EDIT MEDIA BOX --->
 
        <ul class="nav nav-tabs nav-justified" role="tablist">           
            <li role="presentation"><a href="#t1" onClick="ShowThisType('all');" class="c1" role="tab" data-toggle="tab"><i class="fa fa-files-o"></i> <?php echo $CORE->_e(array('add','89')); ?></a></li>        
            <li role="presentation"  class="active"><a href="#t1" onClick="ShowThisType('image');" class="c1" role="tab" data-toggle="tab"><i class="fa fa-file-image-o"></i> <?php echo $CORE->_e(array('add','90')); ?></a></li>
            
            <?php if(isset($GLOBALS['CORE_THEME']['allow_video']) && $GLOBALS['CORE_THEME']['allow_video'] == 1){ ?>            
            <li role="presentation"><a href="#t1" onClick="ShowThisType('video');" class="c2" role="tab" data-toggle="tab"><i class="fa fa-file-video-o"></i> <?php echo $CORE->_e(array('add','91')); ?></a></li>            
            <?php } ?>
            
            <?php if(isset($GLOBALS['CORE_THEME']['allow_audio']) && $GLOBALS['CORE_THEME']['allow_audio'] == 1){ ?>
            <li role="presentation"><a href="#t1" onClick="ShowThisType('audio');" class="c3" role="tab" data-toggle="tab"><i class="fa fa-file-sound-o"></i> <?php echo $CORE->_e(array('add','92')); ?></a></li>
            <?php } ?>
            
            <?php if(isset($GLOBALS['CORE_THEME']['allow_docs']) && $GLOBALS['CORE_THEME']['allow_docs'] == 1){ ?>
            <li role="presentation"><a href="#t1" onClick="ShowThisType('appli');" class="c4" role="tab" data-toggle="tab"><i class="fa fa-file-word-o"></i> <?php echo $CORE->_e(array('add','93')); ?></a></li>   
            <?php } ?>
             
        </ul>
       
        
        <div id="mediatablelist" class="files">
        <?php echo $CORE->UPLOAD_GET($_GET['eid'],1,"all"); ?>
        <div class="clearfix"></div>
        </div>
        
</form>
 
 
   
 </div><!-- end panel-body -->
 
</div></div>
<!-- END  PANEL  -->

<form method="post" action="<?php echo get_home_url(); ?>/index.php" target="core_delete_attachment_iframe" name="core_delete_attachment" id="core_delete_attachment">
<input type="hidden"  name="core_delete_attachment" value="gogo" />
<input type="hidden" id="attachement_id" name="attachement_id" value="" />
</form>
<iframe frameborder="0" style="display:none;" scrolling="auto" name="core_delete_attachment_iframe" id="core_delete_attachment_iframe"></iframe>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
{% if (file.error) { %}
<div class="alert alert-danger"><b><?php echo $CORE->_e(array('add','22')); ?>:</b> {%=file.error%}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button></div> 
{% } else { %}
<div class="uploaditem template-upload fade">
    <div class="col-md-3 preview">
        <span class="fade"></span>
    </div>
    <div class="col-md-6">  
	<span class="fname">{%=file.name%}</span>  
<div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
<div class="bar progress-bar progress-bar-info" style="width:0%;"></div>
</div>
</div> 
<div class="col-md-3">    
{% if (!i) { %}
<span class="cancel">
            <button class="btn btn-danger">
                <i class="glyphicon glyphicon-remove glyphicon glyphicon-white"></i>              
            </button>
</span>
{% } %}        
{% if (!o.options.autoUpload) { %}
<span class="start">
                <button class="btn btn-success">
                    <i class="glyphicon glyphicon-upload glyphicon glyphicon-white"></i>
                    <span><?php echo $CORE->_e(array('add','20')); ?></span>
                </button>
</span>
{% } %}    
    </div>
<div class="clearfix"></div>	
</div>
{% } %}
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
{% if (file.error) { %}
<div class="alert alert-danger"><b><?php echo $CORE->_e(array('add','22')); ?>:</b> {%=file.error%}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button></div> 
{% } else { %}
<div class="uploaditem template-download fade {%=file.aid%}bb">
<div class="col-md-3 preview">
<a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
</div>
<div class="col-md-6">	 
<input type="text" value="{%=file.name%}" onchange="WLTSetImgText('<?php echo str_replace("http://","",get_home_url()); ?>', '{%=file.aid%}', this.value, 'core_ajax_callback');" class="form-input col-md-12" />
</div>
<div class="col-md-3">
	<span class="delete">
	<button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
	<i class="glyphicon glyphicon-trash glyphicon glyphicon-white"></i>            
	</button>
	</span>
</div>
<div class="clearfix"></div>	
</div>
{% } %}
{% } %}
</script>
<script>
jQuery(function () {
    // Initialize the jQuery File Upload widget:
    jQuery('#fileupload').fileupload({
        url: '<?php echo get_home_url(); ?>/index.php',
		type: 'POST',
		paramName: 'core_attachments',
		fileTypes: '/^image\/(gif|jpeg|png)$/',
		formData: {  name: 'core_post_id', value: <?php echo $_GET['eid']; ?>   },
		maxNumberOfFiles: <?php echo $GLOBALS['default_upload_space']-$EXISTING_UPLOAD_COUNT; ?>
	 
    });	
	jQuery('#fileupload').bind('fileuploaddestroy', function (e, data) {
		document.getElementById('attachement_id').value= data.url;
		document.core_delete_attachment.submit();	
	});
 
});	
</script> 
<script src="<?php echo FRAMREWORK_URI; ?>js/up/vendor/jquery.ui.widget.js" type="text/javascript"></script>
<script src="<?php echo FRAMREWORK_URI; ?>js/up/tmpl.min.js" type="text/javascript"></script>
<script src="<?php echo FRAMREWORK_URI; ?>js/up/load-image.min.js" type="text/javascript"></script>
<script src="<?php echo FRAMREWORK_URI; ?>js/up/canvas-to-blob.min.js" type="text/javascript"></script>
<script src="<?php echo FRAMREWORK_URI; ?>js/up/jquery.iframe-transport.js" type="text/javascript"></script>
<script src="<?php echo FRAMREWORK_URI; ?>js/up/jquery.fileupload.js" type="text/javascript"></script>
<script src="<?php echo FRAMREWORK_URI; ?>js/up/jquery.fileupload-fp.js" type="text/javascript"></script>
<script src="<?php echo FRAMREWORK_URI; ?>js/up/jquery.fileupload-ui.js" type="text/javascript"></script>

<?php /*
<script src="<?php echo FRAMREWORK_URI; ?>js/up/main.js" type="text/javascript"></script>
*/ ?>

<!--[if gte IE 8]><script src="<?php echo FRAMREWORK_URI; ?>js/up/cors/jquery.xdr-transport.js"></script><![endif]--> 
<?php  } } }// end media box  ?>





<?php 


// SAVE BUTTONS
if(!isset($_GET['mediaonly'])){ ?>
 
 

<?php do_action('hook_add_form_abovebutton'); /* HOOK */ ?>  
 
<hr />

<?php if(isset($_GET['eid'])){ $elink = get_permalink($_GET['eid']); }else{ $elink = $GLOBALS['CORE_THEME']['links']['add']; } ?>
<a class="btn btn-default pull-right" href="<?php echo $elink; ?>"><?php echo $CORE->_e(array('button','8')); ?></a>
<button class="btn btn-primary" type="submit" id="MainSaveBtn"><?php echo $CORE->_e(array('add','16')); ?></button>

<?php } ?>

</div> 


<?php do_action('hook_add_form_bottom'); /* HOOK */ ?>  
 

 
</div> </div> <!-- end row -->
<div class="clearfix"></div>  





<?php do_action('hook_add_after'); ?>


<?php } ?>

 
 
 
 
 
 
 
 
 
<script type="application/javascript">

function colAll(){
jQuery('#step1').removeClass("in");
jQuery('#step2').removeClass("in");
jQuery('#step3').removeClass("in");
jQuery('#step4').removeClass("in");
jQuery('#step5').removeClass("in");
jQuery('#step6').removeClass("in");
}
function VALIDATE_FORM_DATA(){
 
// USER REGISTRATION VALIDATION
<?php if(!$userdata->ID){ ?>
var de4 	= document.getElementById("form_email");
if(de4.value == ''){
	alert('<?php echo $CORE->_e(array('validate','0')); ?>');
	de4.style.border = 'thin solid red';
	de4.focus();
	colAll(); jQuery('.stepblock1').collapse('show');
	return false;
}
if( !isValidEmail( de4.value ) ) {	
	alert('<?php echo $CORE->_e(array('validate','23')); ?>');
	de4.style.border = 'thin solid blue';
	de4.focus();
	colAll(); jQuery('.stepblock1').collapse('show');
	return false;
}
var de42 	= document.getElementById("form_new_username");
if(de42.value == ''){
	alert('<?php echo $CORE->_e(array('validate','0')); ?>');
	de42.style.border = 'thin solid red';
	de42.focus();
	colAll(); jQuery('.stepblock1').collapse('show');
	return false;
}

<?php } ?>

<?php hook_tpl_add_field_validation(); ?>

// CATEGORY SELECTION
if(jQuery('.stepblock3').find(":checkbox:checked").length == 0){
	alert('<?php echo $CORE->_e(array('validate','0')); ?>'); 
	colAll(); jQuery('.stepblock3').collapse('show');
	return false;
}

// IMAGE UPLOADS
<?php if($GLOBALS['default_upload_space'] > 0 && $GLOBALS['CORE_THEME']['require_image'] == 1){ ?>
var de1 	= document.getElementById("fileupload");
if(de1.value == ''){
	alert('<?php echo $CORE->_e(array('validate','27')); ?>');
	de1.style.border = 'thin solid red';
	de1.focus();
	<?php if(isset($_GET['eid'])){ ?>
	colAll(); jQuery('.stepblockmedia').collapse('show');
	<?php }else{ ?>
	colAll(); jQuery('.stepblock4').collapse('show');
	<?php } ?>
	return false;
} 
<?php } ?>

// LISTING DESCRIPTION VALIDATION
var de1 	= document.getElementById("form_post_title");
if(de1.value == ''){
	alert('<?php echo $CORE->_e(array('validate','0')); ?>');
	de1.style.border = 'thin solid red';
	de1.focus();
	colAll(); jQuery('.stepblock2').collapse('show');
	return false;
}

<?php if( (isset($_GET['eid']) && get_post_meta($_GET['eid'],'html',true) == "yes" ) || ( isset($_POST['packageID']) && isset($packagefields[$_POST['packageID']]['enhancement']) &&  $packagefields[$_POST['packageID']]['enhancement']['3'] == 1 ) ){ ?>

<?php }else{ ?>
var de3 	= document.getElementById("form_post_content");
if(de3.value == ''){
	alert('<?php echo $CORE->_e(array('validate','0')); ?>');
	de3.style.border = 'thin solid red';
	de3.focus();
	colAll(); jQuery('.stepblock2').collapse('show');
	return false;
}
<?php } ?>
<?php 

/*** GOOGLE MAP ***/

if(isset($GLOBALS['CORE_THEME']['google_required']) && $GLOBALS['CORE_THEME']['google_required'] == 1){ ?> 

// CHECK IF THE COUNTRY FORM HAS A VALUE LONG/LATE VALUE
//if(document.getElementById("map-long").value == ""){
//getMapLocation(jQuery('#form_map_location').val());
// return false;
//}

var de4 	= document.getElementById("form_map_location");
if(de4.value == ''){
alert('<?php echo $CORE->_e(array('add','51')); ?>');
de4.style.border = 'thin solid red';
colAll(); jQuery('.stepblock6').collapse('show');
initialize();
return false;
}
<?php } ?>

jQuery('html,body').scrollTop(0);

// VALIDATE CUSTOM FIELDS
return ValidateCoreRegFields();

 
}
</script> 


<script type="text/javascript" src="<?php echo FRAMREWORK_URI; ?>js/nicEdit.js"></script>
<?php if( (isset($_GET['eid']) && get_post_meta($_GET['eid'],'html',true) == "yes" ) || ( isset($_POST['packageID']) && isset($packagefields[$_POST['packageID']]['enhancement']) && $packagefields[$_POST['packageID']]['enhancement']['3'] == 1) ){ ?>
<script type="application/javascript">
 jQuery(document).ready(function() { toggleHTML(); });
</script>
<?php } ?> 


<script type="application/javascript">


function listingenhancement(id,price){
  	
	// DISABLE CHECK
	jQuery("#"+id).attr("disabled", true);
	
	// CURRENT PRICE
	var current_amount_total = jQuery("#listingprice").text();	
	 
	var current_amount_total = current_amount_total.replace(".00", "");
	//var current_amount_total = current_amount_total.replace(".", "");
	var current_amount_total = current_amount_total.replace(",", "");
	
	// WORK OUT PRICES
	if(document.getElementById(id).checked == true){
		newtotal = parseFloat(current_amount_total)+price;
	}else{
		newtotal = parseFloat(current_amount_total)-price;
	}
	newtotal = Math.round(newtotal*100)/100;
	newtotal = newtotal.toFixed(2);	
	jQuery("#listingprice").text(newtotal);
	
		 
	if(id == 'exh3'){	 	
		toggleHTML();
	}
	
	// REMOVE DISABLE
	setTimeout(function(){ jQuery("#"+id).removeAttr("disabled");   }, 1000);	 
	 

}
 var area1, htmlenabled;
 function toggleHTML() {

        if(!area1) {
		
			area1 = new nicEditor({ buttonList : ['bold','italic',
'underline',
'left',
'center',
'right',
'justify',
'ol',
'ul',
'strikethrough',
'removeformat',
'indent',
'outdent',
'hr',
'image',
'forecolor',
'bgcolor',
'link' ,
'unlink' ,
'fontSize', 
'fontFamily', 
'fontFormat']}).panelInstance('form_post_content',{hasPanel : true});

htmlenabled = true;
	

 
        } else {
            // REMOVE
			area1.removeInstance('form_post_content');
            area1 = null;
						
			// STRIP HTML TAGS
			var html = jQuery("#form_post_content").text();
			var div = document.createElement("div");
			jQuery("#form_post_content").innerHTML = div;
						
        }
  	}  
	

jQuery(document).ready(function(){

    jQuery('.astep2, .astep1').live('click', function(e) {	
        	if(htmlenabled) { toggleHTML(); toggleHTML(); } 
    });
});
	
</script>

<script type="application/javascript">jQuery('video,audio').mediaelementplayer({audioWidth: 150});</script>


<?php if(isset($_GET['eid'])){   ?>
<form action="<?php echo $GLOBALS['CORE_THEME']['links']['add']; ?>?eid=<?php echo $_GET['eid']; ?>" method="post" name="renewalfree" id="renewalfree">
<input type="hidden" value="renewalfree" name="action"><input type="hidden" value="<?php echo $_GET['eid']; ?>" name="pid">
</form>

<?php $can_show_hitcounter = get_post_meta($_GET['eid'],'visitorcounter',true); if($can_show_hitcounter == "yes"){ ?>
<hr />
<?php echo do_shortcode('[VISITORCHART postid="'.$_GET['eid'].'"]'); ?>
<?php  } } ?>



<?php get_footer($CORE->pageswitch()); 
 
/* =============================================================================
   -- END FILE
   ========================================================================== */
?>
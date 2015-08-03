<?php
/*
Plugin Name: [MISC] - Expiry Options
Plugin URI: http://www.premiumpress.com
Description: This plugin lets you setup expiry options for your website.
Version: 1.2
Author: Mark Fail
Author URI: http://www.premiumpress.com
License:
*/ 
 
//1. LETS ADD IN NEW MENU OPTIONS TO THE GENERAL SETUP TAB
function wlt_expires_admin_tab($c){
return $c."<li><a href='#expiry' id='expiry_tab_sel' data-toggle='tab' onclick=\"document.getElementById('ShowTab').value='expiry';\">Expiry Setup</a></li>";
}
add_action('hook_admin_5_tabs','wlt_expires_admin_tab');

//2. ADD IN MAIN CONTENT
function wlt_expires_admin_content(){

global $wpdb, $CORE;  $core_admin_values = get_option("core_admin_values");  $wlt_expires = get_option('wlt_expires_package');

 
?>

 <input type="hidden" name="admin_values[wlt_expires][taxonomy]" value="<?php echo THEME_TAXONOMY; ?>" />
 
<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "expiry"){ echo "active in"; } ?>" id="expiry">
<div class="row-fluid">



      <div class="span6">
      
      
        <div class="box gradient">
          <div class="title"><h3><i class="icon-retweet"></i><span>Expiry Options</span></h3></div>
          <div class="content">
          
          <p>The expiry function will run every hour using the WordPress Cron system. All listing that are expired will then be altered based on your selections below;</p>
          
          <div class="well">
          
          		<label class="control-label"><b>1. Expiry <u>Date</u> Field</b></label>

                <small>Select the custom field used to store the expiry date.</small>
                            
                <select data-placeholder="Choose a value..." class="chzn-select" name="admin_values[wlt_expires][key]">
                <option value=""></option>
                <?php
                    echo $CORE->CUSTOMFIELDLIST(esc_attr( $core_admin_values['wlt_expires']['key'] ) );
                ?> 
                </select>
                
                <hr />
                
                <label class="control-label"><b>2. Expiry Action</b></label>
                
                <p>What happens when a listing expires?</p>
         
                
                
                   <select data-placeholder="Choose a value..." class="chzn-select" name="admin_values[wlt_expires][action]">
    <option value="">Do Nothing</option>
    <option value="delete" <?php if(isset( $core_admin_values['wlt_expires']['action'] ) &&  $core_admin_values['wlt_expires']['action']  == "delete"){ echo "selected=selected"; } ?>> Delete It</option>
    <option value="draft" <?php if(isset( $core_admin_values['wlt_expires']['action'] ) &&  $core_admin_values['wlt_expires']['action']  == "draft"){ echo "selected=selected"; } ?>> Set it to draft</option>
    </select>
                
                
                <hr />
   
   <label class="control-label"><b>3. Move Action</b></label>
   <p>Should the listing be moved?</p>
         
                
                
    <select data-placeholder="Choose a value..." class="chzn-select" name="admin_values[wlt_expires][move]">
    <option value="">Do Nothing</option>  
   
   <?php
   
   	// STORE IN DATA A LIST OF STORES
	$cats  = get_categories( array('taxonomy' => THEME_TAXONOMY,"hide_empty" => 0) ); 
	$store_data = array(); $cat_string = "";
	foreach($cats as $cat){
	 
	if($cat->term_id == $core_admin_values['wlt_expires']['move']){ $sel = "selected=selected"; }else{ $sel = "";  }
	
	echo "<option value='".$cat->term_id."' ".$sel.">".$cat->cat_name."</option>";
	}
	 
   ?>
    </select>        
                
                
         </div>
          </div>
          
          </div>
      
      
      </div>
      
      
      <div class="span6">
      
       <div class="box gradient">
          <div class="title"><h3><i class="icon-retweet"></i><span>Testing Options</span></h3></div>
          <div class="content">
          
          <a href="admin.php?page=5&runexpirytest=1" class="btn btn-primary">Run Now</a>
          
          </div>
          
          </div>
      
      
      
      </div>          


</div>
</div>
<?php 
}
add_action('hook_admin_5_content','wlt_expires_admin_content');





//3. SETUP EXPIRY CRON
if ( !wp_next_scheduled( 'wlt_expiry_event' ) ) {
		wp_schedule_event( time(), 'hourly', 'wlt_expiry_event');
}
add_action('wlt_expiry_event', 'wlt_expiry_cron_function');

// CORE EXPIRY FUNCTIONS
// 1. RUNS FROM A CRON JOB
// 2. WILL SEARCH THE POST_META DATABASE FOR ALL DATES CREATER THAN THE CURRENT ONE
// 3. THEN PERFORM CHECKS ON THOSE DATES

add_action('admin_init','_test_expiryopt');
function _test_expiryopt(){
	if(isset($_GET['runexpirytest'])  ){
	wlt_expiry_cron_function();
	$GLOBALS['error_message'] = "Test run complete";
	}
}
function wlt_expiry_cron_function(){

	global $wp_rewrite, $wpdb, $CORE;  $core_admin_values = get_option("core_admin_values");  $packagefields = get_option("packagefields"); $wlt_expires = get_option('wlt_expires_package');
 	 
	// MAKE SURE WE HAVE SETUP THE KEY
	if($core_admin_values['wlt_expires']['key'] != ""){ 
	
		// MAKE SQL CALL
		$SQL = "SELECT ".$wpdb->prefix."postmeta.post_id FROM ".$wpdb->prefix."postmeta
		INNER JOIN ".$wpdb->prefix."posts ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id )		
		 WHERE ".$wpdb->prefix."postmeta.meta_key = '".$core_admin_values['wlt_expires']['key']."' 
		 AND ".$wpdb->prefix."posts.post_status = 'publish'
		 AND ".$wpdb->prefix."posts.post_type = '".$core_admin_values['wlt_expires']['taxonomy']."_type'
		 AND DATE(".$wpdb->prefix."postmeta.meta_value) < NOW()"; 	
		$expired_posts = (array)$wpdb->get_results($SQL);	
		 
 
		if(is_array($expired_posts)){
			foreach($expired_posts as $ep){	
			// NOW WHAT ARE WE GOING TODO WITH THIS POST?
			if($core_admin_values['wlt_expires']['action'] != ""){
			switch($core_admin_values['wlt_expires']['action']){			
				case "delete": {
					wp_delete_post( $ep->post_id, true);
				} break;
				case "draft": {
					$my_post = array();
					$my_post['ID'] = $ep->post_id;
					$my_post['post_status'] = "draft";
					wp_update_post( $my_post );
				} break;			
			}	// end switch
			}
		  
			// MOVE LISTING TO A NEW CATEGORY
			if($core_admin_values['wlt_expires']['move'] != "" && $core_admin_values['wlt_expires']['move'] > 0){
				// UPDATE CAT LIST
				$f = wp_set_post_terms( $ep->post_id, array($core_admin_values['wlt_expires']['move']), $core_admin_values['wlt_expires']['taxonomy'] );
			}
			
						
			} // end if
		}// end if	
	} // END IF
	
	
	// NOW WE NEED TO LOOP THE PACKAGES
	foreach($packagefields as $field){
		if(isset($wlt_expires[$field['ID']]) && isset($wlt_expires[$field['ID']]['days']) && is_numeric($wlt_expires[$field['ID']]['days']) && $wlt_expires[$field['ID']]['action'] != ""){
		
			// MAKE SQL CALL 
			$SQL = "SELECT ".$wpdb->prefix."posts.ID, ".$wpdb->prefix."posts.post_date FROM ".$wpdb->prefix."postmeta  
			INNER JOIN ".$wpdb->prefix."posts ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id )
			WHERE ".$wpdb->prefix."postmeta.meta_key = 'packageID' AND ".$wpdb->prefix."postmeta.meta_value='".$field['ID']."'
			GROUP BY ".$wpdb->prefix."posts.ID"; 
			
			$expired_posts = (array)$wpdb->get_results($SQL);	 
			if(is_array($expired_posts)){
				foreach($expired_posts as $ep){	
				
				// CHECK IF THE LISTING HAS EXPIRED
				$expire_date = strtotime(date("Y-m-d H:i:s", strtotime($ep->post_date)) . " +".$wlt_expires[$field['ID']]['days']." days");
				if(strtotime("now") <  $expire_date){ continue; }
				 //die(print_r($ep)." --> days: ".$wlt_expires[$field['ID']]['days']);
				// NOW WHAT ARE WE GOING TODO WITH THIS POST?
				switch($wlt_expires[$field['ID']]['action']){			
					case "delete": {
						wp_delete_post( $ep->ID, true);
					} break;
					case "draft": {
						$my_post = array();
						$my_post['ID'] = $ep->ID;
						$my_post['post_status'] = "draft";
						wp_update_post( $my_post );
					} break;	
				
				}				
				} // end if
			}// end if
		
		}	
	}
}


?>
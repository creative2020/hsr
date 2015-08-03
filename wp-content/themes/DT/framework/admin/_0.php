<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $CORE_ADMIN, $userdata;
// LOAD IN MAIN DEFAULTS
$core_admin_values = get_option("core_admin_values"); $license = get_option('wlt_license_key');
// UPGRADE SYSTEM
if(isset($_POST['adminArray']['wlt_license_email'])){
	update_option("wlt_license_upgrade",""); // CLEAR
}
 
if(function_exists('current_user_can') && current_user_can('administrator')){
	// DELETE THE RECENT SEARCHES
	if(isset($_GET['delrs']) && isset($_GET['key']) ){
		$saved_searches_array = get_option('recent_searches');
		unset($saved_searches_array[str_replace(" ","_",$_GET['key'])]);
		update_option('recent_searches',$saved_searches_array);
	}elseif(isset($_GET['delrsall'])){
		update_option('recent_searches','');
	}
}// end if
 
// DATABASE UPDATE FOR VERSION 6.2
if(get_option('wlt_db_update_62') == ""){
	wp_schedule_event( time(), 'hourly', 'wlt_hourly_event_hook' );
	wp_schedule_event( time(), 'twicedaily', 'wlt_twicedaily_event_hook' );
	wp_schedule_event( time(), 'daily', 'wlt_daily_event_hook' );	
	update_option("wlt_db_update_62","complete");
}
if(get_option('wlt_db_update_65') == ""){
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
	update_option("wlt_db_update_65","complete");
}
// GOOGLE MAP UPDATES FOR 6.X+
//if(get_option('wlt_db_update_644') == ""){
 	
	//echo "UPDATE $wpdb->postmeta SET meta_value='US' WHERE meta_key='map_country' AND meta_value LIKE '%United States%'";
	
	foreach($GLOBALS['core_country_list'] as $key=>$val){
		//$wpdb->query("UPDATE $wpdb->postmeta SET meta_value='".$key."' WHERE meta_key='map_country' AND meta_value LIKE '%".$val."%'");
	}
	//update_option("wlt_db_update_644","complete");
//}


// LOAD IN HEADER
echo $CORE_ADMIN->HEAD(); ?>
 
    
    
     
<ul id="tabExample1" class="nav nav-tabs">

<?php
// HOOK INTO THE ADMIN TABS
function _0_tabs(){ $STRING = ""; global $wpdb; $core_admin_values = get_option("core_admin_values");
 	
	//$STRING .= '<li class="active"><a href="#home" data-toggle="tab">Dashboard</a></li>';
	//$STRING .= '<li><a href="#updates" data-toggle="tab">Framework Details</a></li>';
	 

	return $STRING;

}
if($license != ""){  echo hook_admin_0_tabs(_0_tabs()); }
// END HOOK
?>
 

<!--<li class=""><a href="#updates" data-toggle="tab">Theme Updates</a></li>-->

                 
</ul>   
 
<div class="tab-content" style="min-height:auto;">


<?php
// IF WE ARE ON THE LICENSE ENTERING PHASE

 if($license == ""){  ?> 
 
<?php if(get_option('wlt_license_upgrade') == 1){ ?>
<div class="alert alert-block alert-error fade in">
<h4 class="alert-heading" style="color:#b94a48; font-size:18px; font-weight:bold;">License Key Error</h4>
<p>The license key you entered during installation was either invalid or has expired. Please re-enter your license key below.</p>         
</div>
 <input type="hidden"  name="adminArray[wlt_license_key_error]"  value="1">
<?php } ?>
 
<div class="row-fluid">
<div class="span6">
<div class="box gradient">
<div class="title"><h3><i class="icon-lock"></i><span> License &amp; Account</span></h3>
</div>
<div class="content">
 
<p>Please enter your software licence key and PremiumPress customer login email below. These can be <a href="http://www.premiumpress.com/account/" style="text-decoration:underline;" target="_blank">found here.</a> </p>           
<hr /> 

<div class="form-row control-group row-fluid">
<label class="control-label span4" for="style"><b>License Key</b></label>
<div class="controls span7">
 <input type="text"  name="adminArray[wlt_license_key]" id="license_key" class="row-fluid"  value="">
</div>
</div>

<div class="form-row control-group row-fluid">
<label class="control-label span4" for="style"><b>Email Address</b></label>
<div class="controls span7">
 <input type="text"  name="adminArray[wlt_license_email]" class="row-fluid" id="license_email" value="">
</div>
</div>

 
		<?php

		$HandlePath = TEMPLATEPATH . '/templates/'; $TemplateString = "";
	    $count=1;
		if($handle1 = opendir($HandlePath)) {      
			while(false !== ($file = readdir($handle1))){			
				if(strpos($file,".") ===false && strpos($file,"basic_") ===false && ( strpos($file,strtolower("template")) !== false  ) ){	
			 					
					$TemplateString .= '<option value="'.$file.'">'; 
					$TemplateString .= str_replace("_"," ",str_replace("-"," ",str_replace(strtolower('template'),"",$file)));									
					$TemplateString.= "</option>";			
   
				}
			}
		}
		
?> 
<?php if(strlen($TemplateString) > 1){ ?>
<hr />
<div class="form-row control-group row-fluid">
<label class="control-label span4" for="default-select"><b>Template</b></label>
<div class="controls span7">
<?php $selected_template = ""; ?>
<select name="admin_values[template]" class="chzn-select">
<?php echo $TemplateString; ?>
<!--<option value="">Framework - No Template</option>-->
</select>
</div>           
</div> 

<div class="form-row control-group row-fluid">
<label class="control-label span4" for="style"><b>Sample Data</b></label>
<div class="controls span7">
<select name="core_system_reset" id="core_system_reset1" class="chzn-select">  
  <option value="yes">Yes - Install Sample Data</option> 
  <option <?php if(get_option('wlt_license_upgrade') == 1){ ?>selected=selected<?php } ?>>No Thanks</option>                                        
</select>
</div>
</div>
 
<?php } ?>
<hr />

  <div class="well">
             
             <textarea style="height:250px;width:100%;"><?php include("terms.txt"); ?></textarea>
             
             </div>
               <label class="checkbox" style="background:transparent;"><input type="checkbox" value="" onchange="UnDMe()" /> I agree to the terms of usage/disclaimer.</label>
 
<hr />
<div class="row-fluid">
<div class="span7 offset4"><button type="submit" class="btn btn-primary" id="installbtn">Save &amp; Continue</button></div>
</div> 
 


</div>   
 
 






            
        </div>
        <!-- End .box -->
        
        
        
      </div>
      <!-- End .span6 -->


    
      <div class="span6">
        <div class="box gradient">
          <div class="title">
            <h3><i class="icon-info-sign"></i><span>Hosting Check (Pre-Installation)</span></h3>
          </div>
          <div class="content">
             
             <?php wlt_system_check(true); ?> 
          
        </div>  
        
        <div class="form-actions row-fluid">
<div class="">


</div>
</div>   
          
            
        </div>
        <!-- End .box -->
        
      
     
<script type="text/javascript"> 
 
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
};
function VALIDATE_INSTALL_DATA(){
 
var de4 	= document.getElementById("license_key");
if(de4.value == ''){
	alert('License Key Missing');
	de4.style.border = 'thin solid red';
	de4.focus();
	return false;
}
 
if(de4.value.length  < 5){
	alert('Invalid License Key');
	de4.style.border = 'thin solid red';
	de4.focus();
	return false;
}
var de5 	= document.getElementById("license_email");
if( !isValidEmailAddress( de5.value ) ) {	
alert('Invalid Email Address');
de5.style.border = 'thin solid red';
de5.focus();
return false;
}

}
jQuery(document).ready(function() { 
jQuery('#installbtn').attr('disabled', true);  }); 
function UnDMe(){
if ( jQuery('#installbtn').is(':disabled') === false) { jQuery('#installbtn').attr('disabled', true);  
} else {jQuery('#installbtn').attr('disabled', false);  }}
</script>
























































<?php }else{






$setup_links = array(
"8" => array("title" => "Setup Permalinks (Set to Post name)", "link" =>"options-permalink.php", "desc" =>"Setup your permalinks for SEO and general usage.", ),

"0" => array("title" => "Setup Navigation Menu", "link" =>"nav-menus.php", "desc" =>"Setup and manage your navigation menu bar items.", ),
"1" => array("title" => "Setup Registration Fields", "link" =>"admin.php?page=1&tab=registration", "desc" =>"Create your own registration fields for users to fill in during registration.", ),
"2" => array("title" => "Setup Welcome Email", "link" =>"admin.php?page=3&tab=email", "desc" =>"Create a welcome email for your website.", ),
"3" => array("title" => "Setup Listing Pakages &amp; Fields", "link" =>"admin.php?page=5", "desc" =>"Setup free/paid listing packages for your website.", ),
"4" => array("title" => "Setup Home Page", "link" => "admin.php?page=2&tab=homepage", "desc" =>"Setup your home page display and slider images.", ), 
"5" => array("title" => "Setup Payment Options", "link" => "admin.php?page=6&tab=gateways", "desc" =>"Setup your desired payment gateways and curreny options.", ),
"6" => array("title" => "Setup Advanced Search Fields", "link" => "admin.php?page=1&tab=search", "desc" =>"Setup searchble fields for your visitors to find website content.", ),

);
if(defined('WLT_HIDE_ADMIN_5')){ unset($setup_links[3]); } $no_errors = true; $STRING = "";

foreach($setup_links as $key=>$link){  
$comple = wlt_checklist_checkme($key);
if($comple == "no"){ $no_errors = false; }

$STRING .= '<div class="media" style="border-bottom:1px solid #ddd; margin-bottom:5px;margin-left:10px;">
    <a class="pull-left" href="'.$link['link'].'">
    <img class="media-object" src="'.get_template_directory_uri().'/framework/admin/img/0/'.$comple.'.png">
    </a>
	<div class="media-body">
	<h4 class="media-heading" style="margin-top:-8px;"><a href="'.$link['link'].'"><b>'.$link['title'].'</b></a></h4>
	<p class="clearfix">'.$link['desc'].'</p>
	</div>
</div>'; 

} 
 

?> 
 


<h2><b>Welcome <?php echo $userdata->user_nicename; ?></b>, the server time now is <span class="label label-success" style="font-size:16px;padding:5px;"><?php echo hook_date(current_time( 'mysql' ));   ?></span> </h2>

<p>We've assembled some links to get you started: <a href="options-general.php" style="float:right; text-decoration:underline;color:blue;">change timezone settings here</a></p>
<hr />

<div class="tabbable tabs-left" >

<ul id="tabExample2" class="nav nav-tabs" style="height:770px">

<li <?php if($no_errors && !isset($_GET['delrs']) ){ ?>class="active"<?php } ?>><a href="#recentactivity" data-toggle="tab"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/0/3.png" align="absmiddle" style="float:left;padding-right:10px;"> Recent Activity</a></li>

<li <?php if(isset($_GET['delrs'])){ echo 'class="active"'; } ?>><a href="#recentsearchs" data-toggle="tab"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/0/9.png" align="absmiddle" style="float:left;padding-right:10px;"> Recent Searches</a></li>

<li <?php if(!$no_errors && !isset($_GET['delrs']) ){ ?>class="active"<?php } ?>><a href="#home" data-toggle="tab"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/0/1a.png" align="absmiddle" style="float:left;padding-right:10px;"> Setup Checklist</a></li>



<li><a href="#phpcheck" data-toggle="tab"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/0/8.png" align="absmiddle" style="float:left;padding-right:10px;"> PHP Check</a></li>
 
</ul>

<div class="tab-content"  style="background:#fff;height:780px">

<div class="tab-pane fade in" id="phpcheck">
<?php wlt_system_check(true,true); ?> 
</div>


<div class="tab-pane fade in <?php if(isset($_GET['delrs'])){ echo "active"; } ?>" id="recentsearchs">
<?php
$saved_searches_array = get_option('recent_searches');
if(is_array($saved_searches_array) && !empty($saved_searches_array) ){ 

$saved_searches_array = $CORE->multisort( $saved_searches_array, array('views') );
$saved_searches_array = array_reverse($saved_searches_array, true);
?>
<table class="table table-bordered table-striped">
<thead>
              <tr>
                <th>#</th>
                <th>Keyword</th>
                <th></th>
                 <th></th>
              </tr>
            </thead>
            <tbody>
<?php $f=1; foreach($saved_searches_array  as $key=>$searchdata){ ?>            
<tr>
<td style="width:30px;"><span class="label"><?php echo $f; ?></span></td>
<td><a href="<?php echo get_home_url(); ?>/?s=<?php echo str_replace("_"," ",$key); ?>" target="_blank"><?php echo str_replace("_"," ",$key); ?></a></td>
<td> <span class="label label-info"><?php echo $searchdata['views']; ?> Total Searches</span> / <small><?php echo hook_date($searchdata['first_view']); ?></small>
<!-- / Last Searched: <?php echo hook_date($searchdata['last_view']); ?> -->  </td>
<td> <a href="admin.php?page=premiumpress&delrs=1&key=<?php echo str_replace("_"," ",$key); ?>" class="btn">Delete</a>  </td>
</tr>
<?php $f++; } ?>
 
</tbody> </table>
<hr />
<a href="admin.php?page=premiumpress&delrsall" class="btn btn-info">Delete All Searches</a>
<?php }else{ ?>
No search data recorded.
<?php } ?>

</div>

<div class="tab-pane fade in <?php if($no_errors && !isset($_GET['delrs']) ){ ?>active<?php } ?>" id="recentactivity">

<table class="table table-bordered table-striped">
<thead>
              <tr>
                <th>#</th>
                <th>Log Entry Message</th>
              </tr>
            </thead>
            <tbody>
 
<?php
// COUNT HOW MANY MESSAGES USER HAS UNREAD
$SQL = "SELECT * FROM ".$wpdb->prefix."core_log ORDER BY autoid DESC LIMIT 30";
$result = $wpdb->get_results($SQL);
foreach( $result as $log ) {
?> 
 <tr><td style="width:30px;">
<span class="label <?php echo $log->link; ?>"><?php echo $log->autoid; ?></span>

</td>
<td>
<?php
$logmessage = ""; $plink = ""; $ulink = "";
if($log->postid != ""){ 	$plink = get_permalink($log->postid); }
if($log->userid != ""){ $ulink = 'user-edit.php?user_id='.$log->userid; }

$logmessage .= str_replace("(plink)",$plink, str_replace("(ulink)",$ulink,$log->message));
echo $logmessage." <small>(".hook_date($log->datetime).")</small>"; ?>
</td></tr>

<?php }  ?>
</tbody> </table> 



</div>

<div class="tab-pane fade in <?php if(!$no_errors && !isset($_GET['delrs']) ){ ?>active<?php } ?>" id="home">

<?php echo $STRING; ?>

</div>
 
 

</div>
</div>
              
             

<?php } ?>           
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
                            

                            
                        </div><!-- End .box -->
        </div> <!-- End span12 -->
</div>     
      
      
 







 
 
 
<?php hook_admin_0_content(); ?>

</div>  
      
<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); 

 
function wlt_checklist_checkme($id){ global $wpdb; $core_admin_values = get_option("core_admin_values"); 

	$returnID = 0;
	switch($id){
	 
		 // MENU
		case "0": {
		
			if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'mobile-menu' ] ) ) {				
				$menu = wp_get_nav_menu_object( $locations[ 'mobile-menu' ] );
				if(!empty($menu)){
				$returnID = 1;
				}			
			}
		} break;
		// REG FIELDS
		case "1": {
		
			$regfields = get_option("regfields");
			if(is_array($regfields) && !empty($regfields) ){
			$returnID = 1;
			}
		
		} break;
		// WELCOME EMAILS
		case "2": {
		
			$emails = get_option("wlt_emails");
			if(is_array($emails) && !empty($emails)){
			$returnID = 1;
			}
		
		} break;
		// LISTING FIELDS
		case "3": {
		
			$fields = get_option("submissionfields");
			if(is_array($fields) && !empty($fields)){
			$returnID = 1;
			}
		
		} break;		
		// HOME PAGE
		case "4": {
		
			$fields = $core_admin_values['homepage']['widgetblock1'];
			$a = explode("-",$fields);
			if(strlen($a[0]) > 1 ){
			$returnID = 1;
			}
		
		} break;
		
		// PAYENT
		case "5": {
		 
			if(strlen($core_admin_values['currency']['symbol']) > 0 && strlen($core_admin_values['currency']['code']) > 0){
			
				$gatways = hook_payments_gateways($GLOBALS['core_gateways']);
				 
				if(is_array($gatways)){
					foreach($gatways as $Value){ 
						if(get_option($Value['function']) == "yes"){
							$returnID = 1;
						}			
					}
				}
			}
		
		} break;	
		
		// SEARCH
		case "6": {
		 
			 $returnID = 1;	 
		
		} break;	
		
		// PLUGINS
		case "7": {
		
			// CHECK GD STAR IS INSTALLED
		 	if(function_exists('wp_gdsr_render_article')){ 
			 $returnID = 1;
			}else{
			 
			}
			 
		
		} break;
		// PERMALINKS
		case "8": {
		 	$PPLINK = get_option('permalink_structure');
			if (strpos($PPLINK, "postname") !== false) { 
			$returnID = 1;
			}else{
			
			} 
		
		} break;		
		default: { $returnID = 1; }
	
	}


return $returnID;
}
 
?>
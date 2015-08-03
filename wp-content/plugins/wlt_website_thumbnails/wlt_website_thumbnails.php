<?php
/*
Plugin Name: [MISC] - Website Thumbnails
Plugin URI: http://www.premiumpress.com
Description: This plugin will let you capture website thumbnails as a fallback for listings with a valid URL and no display image.
Version: 1.6
Author: Mark Fail
Author URI: http://www.premiumpress.com
License:
Updated: April 20th 2014
*/
// SETUP WORDPRESS SCHEDULES
 		
 //1. LETS ADD IN NEW MENU OPTIONS TO THE GENERAL SETUP TAB
function wlt_website_thumbnails_admin_tab($c){ echo '<li><a href="#wlt_thumbnails" data-toggle="tab"><span class="sh6">Website Thumbnails</span></a></li>';}
add_action('hook_admin_1_tab1_tablist','wlt_website_thumbnails_admin_tab');
  
// 3. BUILD DISPLAY
function wlt_website_thumbnails(){ global $wpdb, $CORE, $WLT_ADMIN;
 
// LOAD IN CORE VALUES
$core_admin_values = get_option("core_admin_values");
$wlt_website_thumbnails = get_option("wlt_website_thumbnails");  
$php_version = phpversion();
$openssl_ext = extension_loaded('openssl');
$php5_gd_ext = extension_loaded('gd');
$php_vars = explode(".", $php_version);
 
?>

 
<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "wlt_thumbnails"){ echo "active in"; } ?>" id="wlt_thumbnails">

<div class="heading1">Website Screenshot Settings</div>

<?php

if (@$php_vars[0] >= 5 && @$php_vars[1] >= 3) {} else {
    echo "<div class='alert'>Your PHP version is: $php_version , Please upgrade your PHP software</div>";
} 

if ($php5_gd_ext) {} else {
    echo "<div class='alert'>PHP GD library is not installed</div>";
} 

if ($openssl_ext) {} else {
    echo "<div class='alert'>PHP OpenSSL extension is not installed.</div>";
} 

?>

            <div class="form-row control-group row-fluid ">
                            <label class="control-label span4">Enable Feature </label>
                            <div class="controls span7">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('websitethumbnail_enable').value='1'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('websitethumbnail_enable').value='0'">
                                  </label>
                                  <div class="toggle <?php if($wlt_website_thumbnails['enable'] == '0'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="websitethumbnail_enable" name="adminArray[wlt_website_thumbnails][enable]" 
                             value="<?php echo $wlt_website_thumbnails['enable']; ?>">
            </div>
            

    <?php /* <div class="form-row control-group row-fluid ">
                            <label class="control-label span4">Debug Mode </label>
                            <div class="controls span7">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('websitethumbnail_debug').value='1'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('websitethumbnail_debug').value='0'">
                                  </label>
                                  <div class="toggle <?php if($wlt_website_thumbnails['debug'] == '0'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="websitethumbnail_debug" name="adminArray[wlt_website_thumbnails][debug]" 
                             value="<?php echo $wlt_website_thumbnails['debug']; ?>">
            </div>
			*/ ?>
            
<div class="form-row control-group row-fluid ">
<label class="span4">Website Custom Key</label>
<div class="controls span7">	
		
					
		<select data-placeholder="Choose a value..." class="chzn-select" name="adminArray[wlt_website_thumbnails][customkey]">
		<option value=""></option>
		<?php
		if($wlt_website_thumbnails['customkey'] == ""){ $wlt_website_thumbnails['customkey'] = "url"; }
			echo $CORE->CUSTOMFIELDLIST(esc_attr( $wlt_website_thumbnails['customkey'] ) );
		?> 
		</select>
        <small>Select the custom field which will be used to store website links.</small>
</div>				   
</div>  
            
<!-------------------- FIELD ---------------------->
<div class="form-row control-group row-fluid">
<label class="control-label span4">Google API Key <span class="label">See Below</span></label>
<div class="controls span7">
<input type="text" class="row-fluid required" name="adminArray[wlt_website_thumbnails][apikey]" value="<?php if(isset($wlt_website_thumbnails['apikey'])){ echo esc_attr( $wlt_website_thumbnails['apikey'] ); } ?>" />
</div>
</div>
 
 
<div class="heading1">Google API keys</div>

<p><b>Webpage thumbnails</b> are created using the Google pagespeed API. To use this service you must have a Google account and enable the option within your account settings.</p>

 
<p>Todo this simply visit the link below and click on <span class="fnam">Services</span> tab at left side panel.</p>

<a class="ahi" target="_blank"  href="https://code.google.com/apis/console/" style="text-decoration:underline;color:blue;">https://code.google.com/apis/console/</a>
<hr />
 
<img src="<?php echo  plugins_url()."/wlt_website_thumbnails/img/"; ?>console.homepage.png" alt="Google Console Homepage" title="Google Console Homepage" class="bbor">
<br><br>Turn on PageSpeed Insights API.<br><br>
<img src="<?php echo  plugins_url()."/wlt_website_thumbnails/img/"; ?>pagespeed.on.png" alt="Google Console Pagespeed TurnOn" title="Google Console Pagespeed TurnOn" class="bbor">
<br><br>Click on API access link on left side panel.<br><br>
<img src="<?php echo  plugins_url()."/wlt_website_thumbnails/img/"; ?>click.api.access.png" alt="API access" title="API access" class="bbor">
<br><br>Click on Create new server key.<br><br>
<img src="<?php echo  plugins_url()."/wlt_website_thumbnails/img/"; ?>create.server.key.png" alt="Create Server API key" title="Create Server API key" class="bbor">
<br><br>Now enter your server IP address (<span style="color:#9c0">If you don't know your server IP keep blank</span>) and click on <span class="fnam">Create</span> button.<br><br>
<img src="<?php echo  plugins_url()."/wlt_website_thumbnails/img/"; ?>gen.server.key.png" alt="Create Server API key" title="Create Server API key" class="bbor">
<br><br>Now get your Google API key.<br><br>
<img src="<?php echo  plugins_url()."/wlt_website_thumbnails/img/"; ?>google-api-key.png" alt="Get your Google API key" title="et your Google API key" />

  
 
</div> 
 

<?php }
add_action('hook_admin_1_tab1_newsubtab','wlt_website_thumbnails'); 


// ADD IN HOOK FOR FALLBACK IMAGE
function wlt_website_thumbnails_fallback_image($c){ global $post;

	// GET ID FROM NO-IMAGE STRING
	$b = explode('no-image-',$c);
	$b1 = explode('"',$b[1]);
	if(!is_numeric($b1[0])){ return $c; } 
	
	$wlt_website_thumbnails = get_option("wlt_website_thumbnails"); 
	if($wlt_website_thumbnails['customkey'] == ""){ return $c; }
	
	// CHECK IF THE LISTING HAS A URL ASSIGNED
	$url = get_post_meta($b1[0],$wlt_website_thumbnails['customkey'],true);
	if($url == ""){ return $c; }
	 
	// IF WE DO, LETS CREATE THE SCREENSHOT
	
	require_once (WP_PLUGIN_DIR."/wlt_website_thumbnails/class/class_screenshot.php");	
	if($wlt_website_thumbnails['apikey'] == ""){ return $c; }

	// GENERATE THUMBNAIL
	$shot = new Screenshot($wlt_website_thumbnails['apikey']); 
	$shot->cache("30 days");
	$url = $shot->format($url);
	$link = $shot->generate($url, "desktop");
  	
	//if($wlt_website_thumbnails['debug'] == 0){ echo "<pre>"; print_r($link); echo "</pre>"; }
	 
	//OUTPUT RETURNS
	if(is_array($link)){ return $c; }
	return '<img src="'.$link.'" class="img-responsive" alt="wlt_thumbnail-'.$b1[0].'">';
	
}
add_action('hook_fallback_image_display','wlt_website_thumbnails_fallback_image');

?>
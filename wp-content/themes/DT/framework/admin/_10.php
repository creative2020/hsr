<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;
// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

// LOAD IN HEADER
echo $CORE_ADMIN->HEAD(); ?>

<ul id="tabExample1" class="nav nav-tabs">
 
                     
</ul>

<div class="tab-content">

<iframe src="http://www.premiumpress.com/plugins/?l=<?php echo get_option('wlt_license_key'); ?>&admin=1&link=<?php echo get_home_url(); ?>" style="width:100%;height:1500px; background:#fbfbfb;"></iframe>
<p><b>Having a problem with the downloads?</b> <a href="http://www.premiumpress.com/plugins/" style="text-decoration:underline;color:blue;" target="_blank">View the plugins page here.</a></p>

</div><!-- end tab --> 

<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); ?>
<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;
// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

 
// LOAD IN HEADER
echo $CORE_ADMIN->HEAD(); ?>
  
 
 

<div class="alert alert-info">
<img src="<?php echo THEME_URI; ?>/framework/admin/img/f2.png" class="infoimg" style="float:left; padding-right:20px; margin-bottom:100px;" />
<h1 style="color:#206E94;font-weight:bold;">Share your designs with the community!</h1>

<h3>Share your PremiumPress child themes with the rest of the community.</h3>
<p>
This tool is designed to help you get started developing your own child theme.</p>
<p>It will help you generate the basic files/folders required to create a basic child theme.</p>
<p> You can then watch the video tutorials for additional ideas and suggestions to further develop your child theme and build in new functionality.</p>


<h4>Theme Upload Requirments</h4>

<hr />

<div style="text-align:center;"><a href="" class="btn btn-primary btn-large">Ok Lets Go!</a></div>

</div>

 

<?php /*<iframe src="http://childthemes.premiumpress.com/add/?l=123&bt=<?php echo get_option('wlt_base_theme'); ?>" style="border:0px;width:884px; height:1400px; background:#fbfbfb; " border=0></iframe>*/ ?>


 
 
<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); ?>
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
<?php
// HOOK INTO THE ADMIN TABS
function _9_tabs(){ $STRING = ""; global $wpdb;

	if(isset($_GET['tab'])){ $_POST['tab'] = $_GET['tab']; }	
	$pages_array = array( 
	//"1" => array("t" => "Home", "k"=>"home"),	 
 	);
	foreach($pages_array as $page){	
	if( ( isset($_POST['tab']) && $_POST['tab'] == $page['k'] ) || ( !isset($_POST['tab']) && $page['k'] == "regions" ) ){ $class = "active"; }else{ $class = ""; }	
		$STRING .= '<li class="'.$class.'"><a href="#'.$page['k'].'" onclick="document.getElementById(\'ShowTab\').value=\''.$page['k'].'\'" data-toggle="tab">'.$page['t'].'</a></li>';	
	} 
	return $STRING;
}
echo hook_admin_9_tabs(_9_tabs());
// END HOOK
?>  
                     
</ul>

<div class="tab-content"><?php do_action('hook_admin_9_content'); ?></div><!-- end tab --> 

<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); ?>
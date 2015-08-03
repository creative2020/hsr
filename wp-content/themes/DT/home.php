<?php
/* 
* Theme: PREMIUMPRESS CORE FRAMEWORK FILE
* Url: www.premiumpress.com
* Author: Mark Fail
*
* THIS FILE WILL BE UPDATED WITH EVERY UPDATE
* IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
*
* http://codex.wordpress.org/Child_Themes
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
 
?>

<?php get_header($CORE->pageswitch()); ?>

<?php
		// HOOK BEFORE OBJECT OUTPUT
		hook_homepage_before();
	
		// GET HOME PAGE OBJECTS FROM THE ADMIN
		if(isset($GLOBALS['CORE_THEME']['homepage']) && strlen($GLOBALS['CORE_THEME']['homepage']['widgetblock1']) > 1){
		echo $OBJECTS->WIDGETBLOCKS($GLOBALS['CORE_THEME']['homepage']['widgetblock1'], $fullwidth=false);
		}
				
		//HOOK AFTER OUTPUT
		hook_homepage_after();  

?>

<?php  get_footer($CORE->pageswitch()); ?>
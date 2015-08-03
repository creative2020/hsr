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

<?php global $CORE, $post; ?>
<div class="itemdata <?php hook_item_class(); ?>" <?php echo $CORE->ITEMSCOPE('itemtype'); ?>>

	<div class="thumbnail clearfix">

        <?php echo hook_item_cleanup(hook_content_listing($CORE->ITEM_CONTENT($post))); ?> 
         
	</div>
                 
</div>
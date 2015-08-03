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

<?php global $post, $CORE; ?>
<a name="toplisting"></a>
        
<div <?php echo $CORE->ITEMSCOPE('itemtype'); ?>>   
 
	<?php echo hook_item_cleanup(hook_content_single_listing($CORE->ITEM_CONTENT($post))); ?>
        
</div>
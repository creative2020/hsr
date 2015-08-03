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

<?php global $CORE; ?>
<aside class="<?php $CORE->CSS("columns-left"); ?> <?php if(isset($GLOBALS['CORE_THEME']['mobileview']['sidebars']) && $GLOBALS['CORE_THEME']['mobileview']['sidebars'] == '1'){ ?><?php }else{ ?>hidden-xs<?php } ?>" id="core_left_column">
        
	<?php hook_core_columns_left_top(); ?>
 
    <?php dynamic_sidebar('Left Column'); ?>
             
    <?php hook_core_columns_left_bottom(); ?>
            
</aside>
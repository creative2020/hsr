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


global $CORE, $post, $userdata;
ob_start();

    
    if($post->post_type ==  THEME_TAXONOMY."_type" ){
         
        // DISPLAY ERRORS
        if(isset($GLOBALS['flag-single']) && isset($GLOBALS['error_message']) && strlen($GLOBALS['error_message']) > 2){
        echo $CORE->ERRORCLASS($GLOBALS['error_message'],'info');
        } 
    ?>
       
    <?php echo hook_mobile_content_listing_output(); ?>
    
    <?php }else{ ?>
    
    <h1>[TITLE]</h1>
    <hr />
    
    [CONTENT]
    
    <?php }


$SavedContent = ob_get_clean(); 

echo hook_item_cleanup($CORE->ITEM_CONTENT($post, hook_mobile_content_listing($SavedContent))); ?>  
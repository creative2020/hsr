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


global $CORE, $post;
 
ob_start();
 
if($post->post_type ==  THEME_TAXONOMY."_type" ){
?>
<?php  if($GLOBALS['CORE_THEME']['show_account_favs'] == '1'){ ?>
<script>

jQuery(document).ready(function (){

	var panel<?php echo $post->ID; ?> = jQuery('#swipe<?php echo $post->ID; ?>_val div').scotchPanel({
		containerSelector: '.itemid<?php echo $post->ID; ?>', // As a jQuery Selector
		direction: 'left', // Make it toggle in from the left
		duration: 300, // Speed in ms how fast you want it to be
		transition: 'ease', // CSS3 transition type: linear, ease, ease-in, ease-out, ease-in-out, cubic-bezier(P1x,P1y,P2x,P2y)
		distanceX: '70%', // Size fo the toggle
		enableEscapeKey: true // Clicking Esc will close the panel
	});	
 
	
	jQuery(".itemid<?php echo $post->ID; ?>").bind('swipeone', function(e){
		panel<?php echo $post->ID; ?>.toggle();
		e.stopImmediatePropagation();
		return false;
	});		
			
});
</script>
<?php } ?>
 
<div class="itemid<?php echo $post->ID; ?> mobileweb">

    <div class="searchblock clearfix <?php hook_item_class(); ?>">
        <?php hook_mobile_content_output(); ?>
    </div>
	
    <?php  if($GLOBALS['CORE_THEME']['show_account_favs'] == '1'){ ?>
    <div id="swipe<?php echo $post->ID; ?>_val" style="height:100px; display:block;">
        <div class="text-center" style="height:100px;">            
         [FAVS]
        </div> 
    </div>
    <?php } ?>

</div>
     
    

<?php 

}else{ 

?>

    <div class="blogblock clearfix itemid<?php echo $post->ID; ?>">
    
    [IMAGE]
    
    <h2>[TITLE]</h2>
    
    [EXCERPT size=200]... 
    
    </div>

<?php

}

$SavedContent = ob_get_clean(); 

echo hook_item_cleanup($CORE->ITEM_CONTENT($post, hook_mobile_content($SavedContent))); ?>  
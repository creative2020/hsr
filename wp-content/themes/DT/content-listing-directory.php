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

<?php global $CORE, $post; 

if( get_post_meta($post->ID,'showgooglemap',true) == "yes"){  $canShowMap = true; }else{ $canShowMap = false; }

 
ob_start();

?>

<div class="itemdata default-content itemid<?php echo $post->ID; ?> <?php hook_item_class(); ?>" <?php echo $CORE->ITEMSCOPE('itemtype'); ?>>

<div class="thumbnail clearfix">

<div class="pull-right">

<?php if( $canShowMap == "yes"){ ?>

<div class="box1 tip" data-toggle="tooltip"  data-placement="left" title="<?php echo $CORE->_e(array('button','57')); ?>"><a href="#top" class="mapbtn"><i class="fa fa-map-marker"></i> </a></div>

<?php } ?>


<div class="box2 tip" data-toggle="tooltip"  data-placement="left" title="<?php echo $CORE->_e(array('button','32')); ?>">[FAVS]</div>
<div class="box3 tip" data-toggle="tooltip"  data-placement="left" title="<?php echo $CORE->_e(array('button','4')); ?>"><a href="[LINK]"><i class="fa fa-search"></i></a></div>
</div>
 

[IMAGE]   [DISTANCE text_before="" info=false] [/IMAGE]

<div class='caption'>

[RATING]

<h1>[TITLE]</h1>

<div class="lobits"> [LOCATION] [DATE] </div> 
 
[EXCERPT size=100] ...
 
</div>

</div>
</div>
 

<?php if( $canShowMap == "yes"){ ?>
<script>
jQuery(document).ready(function(){ 


	jQuery('.tip').tooltip();
	
	jQuery('.itemid<?php echo $post->ID; ?> .mapbtn').on('click', function(){ 		
		
		loadGoogleMapsApi();
		if(MapTriggered != "yes"){
			setTimeout(function(){ zoomItemMarker(<?php echo $post->ID; ?>); }, 2000); 
		}else{
			zoomItemMarker(<?php echo $post->ID; ?>);
 		}
		
	});

});
</script>
<?php } ?>
 
 
<?php 
$SavedContent = ob_get_clean(); 
?>
<?php echo hook_item_cleanup($CORE->ITEM_CONTENT($post, hook_content_listing($SavedContent))); ?>  
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

global $CORE; 

$i=1; while($i < 5){ 		 
			 
			 // LOAD IMAGE CONTENT
			 $content = $GLOBALS['CORE_THEME']['home']['slider_item_'.$i];
			 
			 // ADD IN SAMPLE IMAGES
			 if( $i == 1 && $content == ""){ $content = "http://placehold.it/1140x400"; }
	 
			 ?>
			 
			<div class="form-row control-group row-fluid">
					<label class="control-label span3">Slide <?php echo $i; ?></label>
					<div class="controls span7">
					<div class="input-append row-fluid">
					  <input type="text"  name="admin_values[home][slider_item_<?php echo $i; ?>]" id="upload_slideritem<?php echo $i; ?>" class="row-fluid" 
					  value="<?php echo $content; ?>">
					  <span class="add-on" id="aupload_slideritem<?php echo $i; ?>"><i class="gicon-search"></i></span>
					  </div>
					</div>
				</div>  
				
				
			 <div class="form-row control-group row-fluid">
					<label class="control-label span3">Link <?php echo $i; ?></label>
					<div class="controls span7">
					<div class="input-append row-fluid">
					  <input type="text"  name="admin_values[home][slider_link_<?php echo $i; ?>]" class="row-fluid" 
					  value="<?php echo $GLOBALS['CORE_THEME']['home']['slider_link_'.$i]; ?>">
					
					  </div>
					</div>
				</div>  
				
	<script type="text/javascript">
		jQuery(document).ready(function () {
			jQuery('#aupload_slideritem<?php echo $i; ?>').click(function() { 
			 
			 ChangeImgBlock('upload_slideritem<?php echo $i; ?>');
			 formfield = jQuery('#upload_slideritem<?php echo $i; ?>').attr('name');
			 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			 jQuery("div").remove('#TB_overlay');
			 return false;
			});
		});	
	</script>   
			 
<?php $i++; } ?>
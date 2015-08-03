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
<?php

	global $wpdb;

	switch($_GET['page']){
	
		case "premiumpress": { 	
			$license = get_option('wlt_license_key');
			if($license == ""){
				$title 	= "License Key";
				$img 	= get_template_directory_uri()."/framework/admin/img/license.png";	
			}else{
			$title 	= "Website Overview";
			$img 	= get_template_directory_uri()."/framework/admin/img/m00b.png";	
			}
			
		} break;
		 
		case "1": { 	
			$title 	= "General Settings";
			$img 	= get_template_directory_uri()."/framework/admin/img/m4b.png";	
		} break;
		
		case "2": { 	
			$title 	= "Page Setup";
			$img 	= get_template_directory_uri()."/framework/admin/img/m0b.png";	
		} break;
		
		case "3": { 	
			$title 	= "Email Management";
			$img 	= get_template_directory_uri()."/framework/admin/img/m3b.png";	
		} break;
		
		case "4": { 	
			$title 	= "Toolbox";
			$img 	= get_template_directory_uri()."/framework/admin/img/m6b.png";	
		} break;
			
		case "5": { 	
			$title 	= "Listing Setup";
			$img 	= get_template_directory_uri()."/framework/admin/img/m5b.png";	
		} break;
		
		case "6": { 	
			$title 	= "Order Manager";
			$img 	= get_template_directory_uri()."/framework/admin/img/m1b.png";	
		} break;
		
		case "7": { 	
			$title 	= "Advertising";
			$img 	= get_template_directory_uri()."/framework/admin/img/m7b.png";	
		} break;
		
		case "8": { 	
			$title 	= "Design Setup";
			$img 	= get_template_directory_uri()."/framework/admin/img/m8b.png";	
		} break;

		case "9": { 	
			$title 	= "Tax &amp; Shipping";
			$img 	= get_template_directory_uri()."/framework/admin/img/m9b.png";	
		} break;
		
		case "premiumpress_addons":
		case "10": { 	
			$title 	= "Theme Plugins";
			$img 	= get_template_directory_uri()."/framework/admin/img/m10b.png";	
		} break;
		
		case "11": { 	
			$title 	= "Responsive Video Tutorials";
			$img 	= get_template_directory_uri()."/framework/admin/img/youtube.png";	
		} break;
		case "premiumpress_childthemes":
		case "12": { 	
			$title 	= "Child Themes";
			$img 	= get_template_directory_uri()."/framework/admin/img/m12b.png";	
		} break;

		case "13": { 	
			$title 	= "Reports";
			$img 	= get_template_directory_uri()."/framework/admin/img/m13b.png";	
		} break;
 	
		case "14": { 	
			$title 	= "Create Child Theme";
			$img 	= get_template_directory_uri()."/framework/admin/img/m14b.png";	
		} break;		

		case "15": { 	
			$title 	= "Share Child Theme";
			$img 	= get_template_directory_uri()."/framework/admin/img/m15b.png";	
		} break;	
		
		case "16": { 	
			$title 	= "Language Setup";
			$img 	= get_template_directory_uri()."/framework/admin/img/m16b.png";	
		} break;	
		
		case "revslider": { 	
			$title 	= "Home Page Slider";
			$img 	= get_template_directory_uri()."/framework/admin/img/m14b.png";	
		} break;
								
		default: {
			if(isset($GLOBALS['admin_title'])){
			$title 	= $GLOBALS['admin_title'];
			$img 	= $GLOBALS['admin_image'];
			}	
		} break;
			
		
	} // end switch

?>

<script>
	jQuery(document).ready(function(){
    jQuery('.confirm').click(function(){
		var answer = confirm("Are you sure you want to delete this item?");
		if (answer){
				return true;
			} else {
				return false;
			}
		});
	});
	</script>
    
    <?php if(!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] != "revslider" ) ){ ?>
	<form method="post" name="admin_save_form" id="admin_save_form" <?php if(isset($license) && $license ==""){ ?>onsubmit="return VALIDATE_INSTALL_DATA();"<?php } ?> enctype="multipart/form-data">
	<input type="hidden" name="submitted" value="yes" />
	<input type="hidden" name="tab" id="ShowTab" value="<?php if(isset($_POST['tab'])){ echo $_POST['tab']; } ?>" />
	<input type="hidden" name="subtab" id="ShowSubTab" value="<?php if(isset($_POST['ShowSubTab'])){ echo $_POST['ShowSubTab']; } ?>" />
	<input type="hidden" name="subsubtab" id="ShowSubSubTab" value="<?php if(isset($_POST['ShowSubSubTab'])){ echo $_POST['ShowSubSubTab']; } ?>" />
	<?php } ?>
     
	<div id="main">
	  <div class="container">
	  
		<div class="container_top">
		  <div class="row-fluid ">
          
    
		  
			<!-- HEADER -->
			<div class="top_left to_hide_tablet">
            
             
           <a data-toggle="modal" href="admin.php?page=videotutorials" class="btn btn-danger" style="float:right;margin-top:10px; margin-right:15px;" target="_blank"><img src="<?php echo get_bloginfo('template_url'); ?>/framework/admin/img/youtube.png" align="absmiddle"> All Video Tutorials</a>
           
           <a data-toggle="modal" href="admin.php?page=supportcenter" class="btn btn-danger" style="float:right;margin-top:10px; margin-right:5px;" target="_blank">
           <img src="<?php echo get_bloginfo('template_url'); ?>/framework/admin/img/support.png" align="absmiddle">
           Support Center</a>
          
          
          
            
			<div style="float:right;color:#fff; margin-top:15px;margin-right:20px;">
            
            <label rel="tooltip" data-original-title="Updated <?php echo THEME_VERSION_DATE; ?> " data-placement="bottom">Version <?php echo THEME_VERSION; ?></label>
            </div>
            
            
					  <div class="stats">
                      <?php if(strlen($img) > 1){ ?>
					  <img src="<?php echo $img; ?>" style="float:left; margin-top:-5px;padding-right:10px;">
                      <?php } ?>
						<span class="title" style="font-size:24px;"><?php echo $title; ?></span> 
					  </div>
			</div>  
	 
			<!-- // HEADER -->
	
		   
		  </div>
		</div>
		
	<?php if(isset($GLOBALS['error_message'])){ ?>
	
	<div class="alert alert-success fade in">
	<button type="button" class="close" data-dismiss="alert">x</button>
	<?php echo $GLOBALS['error_message']; ?>
	</div>
    
    <?php } ?>
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

global $CORE, $payment_data;

?>
<div class="panel panel-default"> 

<div class="panel-heading"><?php echo $CORE->_e(array('callback','1')); ?></div>
		 
	<div class="panel-body">  
		  
	<h3><?php echo $CORE->_e(array('callback','2')); ?></h3>
            
	<p><?php echo $CORE->_e(array('callback','3')); ?></p>
    
    <!-- RETURN USER TO THE PURCHASED/PAID ITEM --->
    <?php if(isset($_POST['paid_item_id']) && is_numeric($_POST['paid_item_id'])){ ?>
    
    <a href="<?php echo get_permalink($_POST['paid_item_id']); ?>" style="text-decoration:underline"><?php echo $CORE->_e(array('callback','10')); ?></a>
    
    <?php } ?>
 			
	<?php hook_callback_success(); ?>
			
</div>

</div>
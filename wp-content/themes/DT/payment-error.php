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

<?php global $CORE, $payment_data; ?>
<div class="panel panel-default"> 

<div class="panel-heading"><?php echo $CORE->_e(array('callback','7')); ?></div>
		 
    <div class="panel-body">  
             
        <h3><?php echo $CORE->_e(array('callback','8')); ?></h3>
                
        <p><?php echo $CORE->_e(array('callback','9')); ?></p>
                
        <?php hook_callback_error(); ?>  
                
    </div>

</div>
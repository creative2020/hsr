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

<?php get_header($CORE->pageswitch()); ?>

<div class="panel panel-default"> 

<div class="panel-heading"><?php echo $CORE->_e(array('gallerypage','24')); ?></div>
		 
    <div class="panel-body">  
             
        <h3><?php echo $CORE->_e(array('gallerypage','25')); ?></h3>
                
        <p><?php echo $CORE->_e(array('gallerypage','26')); ?></p>
                 
    </div>

</div>

<?php get_footer($CORE->pageswitch()); ?>
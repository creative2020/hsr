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

<?php global $CORE, $errortext; ?>

<?php get_header($CORE->pageswitch()); ?>

<div class="panel panel-default">

<div class="panel-heading"><?php echo $CORE->_e(array('login','5')); ?></div>

	<div class="panel-body">
    
	<?php if(strlen($errortext) > 1){ ?>
     <div class="bs-callout bs-callout-danger">
      <button type="button" class="close" data-dismiss="alert">X</button>
      <?php echo $errortext; ?>
    </div>
    <?php } ?>
     
    <form class="lostpasswordform" name="lostpasswordform" id="lostpasswordform" action="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post'); ?>" method="post">
    
    <p><?php echo $CORE->_e(array('login','15')); ?></p> 
    
    <div class="form-group clearfix">
        <label for="name"><?php echo $CORE->_e(array('login','_zz3')); ?></label> 
        <input type="text"  name="user_login" id="user_login" value="<?php echo esc_attr(stripslashes($_POST['user_login'])); ?>" class="form-control"/>        
    </div>
    
    <?php do_action('lostpassword_form'); ?>
    
    <div class="clearfix"></div>
    
    <hr />
     
    <input type="submit" name="submit" id="submit" class="btn btn-primary" tabindex="15" value="<?php echo $CORE->_e(array('login','9')); ?>" /> 

    </form>  
    
</div> 

</div> 
 
<?php get_footer($CORE->pageswitch());  ?>
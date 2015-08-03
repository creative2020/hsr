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

<?php hook_login_before(); ?>

<div class="row"><div class="col-md-6">

<div class="panel panel-default">

<div class="panel-heading"><?php echo $CORE->_e(array('head','5')); ?></div>

	<div class="panel-body"> 
    
	<?php if(strlen($errortext) > 1){ ?>
     <div class="bs-callout bs-callout-danger">
      <button type="button" class="close" data-dismiss="alert">x</button>
      <?php echo $errortext; ?>
    </div>
    <?php } ?>
	 
    <form class="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post" > 
    <input type="hidden" name="testcookie" value="1" /> 
    <input type="hidden" name="rememberme" id="rememberme" value="forever" />
    
                <div class="form-group clearfix">
                  <label  for="inputEmail"><?php echo $CORE->_e(array('login','10')); ?></label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                       <input type="text" name="log" id="user_login" class="form-control" > 
                    </div>              
                </div>
    
                  <div class="form-group clearfix">
                  <label for="inputPassword"><?php echo $CORE->_e(array('account','10')); ?></label>
                  <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" name="pwd" id="user_pass" class="form-control">                  
                  </div>
                </div>
                
                <?php do_action('login_form'); ?>
                
                <hr />
                
                <a href="<?php echo get_home_url().'/wp-login.php?action=lostpassword'; ?>" class="btn btn-default pull-right"><?php echo $CORE->_e(array('login','29')); ?></a>
                
                <input type="submit" name="wp-submit" class="btn btn-primary" value="<?php echo $CORE->_e(array('head','5')); ?>">  
    </form>
          
	</div>
     
</div>    


</div><div class="col-md-6">

<?php if(get_option('users_can_register') == 1 || defined('WLT_DEMOMODE') ){ ?>

    <div class="panel panel-default" id="login_registerbox">
    
        <div class="panel-body text-center">
        
            <h3><?php echo $CORE->_e(array('login','25')); ?></h3>
            
            <p><?php echo $CORE->_e(array('login','26')); ?></p>
            
            <a href="<?php echo get_home_url().'/wp-login.php?action=register'; ?>" class="btn btn-large btn-primary"><?php echo $CORE->_e(array('head','6')); ?></a>
            
        </div>
        
    </div>
    
<?php } ?> 
    
</div>
</div>



<?php hook_login_after(); ?>
	
<?php get_footer($CORE->pageswitch()); ?>
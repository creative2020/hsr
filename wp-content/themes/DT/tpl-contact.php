<?php
/*
Template Name: [Contact Form]
*/
/* =============================================================================
   [PREMIUMPRESS FRAMEWORK] THIS FILE SHOULD NOT BE EDITED
   ========================================================================== */
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
/* ========================================================================== */
global  $userdata, $CORE; get_currentuserinfo();  $GLOBALS['flag-members'] = 1; 
/* =============================================================================
   LOAD PAGE TEMPLATE
   ========================================================================== */
   
// RANDOM NUMBERS
$email_nr1 = rand("0", "9");$email_nr2 = rand("0", "9");


/* =============================================================================
   PAGE ACTIONS // 
   ========================================================================== */

if(isset($_POST['action']) && $_POST['action'] == "singlecontactform"){ 
 
		$CORE->Language();
 
		
		if(	isset($_POST['form']['code']) && $_POST['form']['code'] == $_POST['form']['code_value']){
		
		
			$message = "<br> ".$CORE->_e(array('single','26'))." : " . strip_tags($_POST['form']['name']) . "
						<br> ".$CORE->_e(array('single','28'))." : " . strip_tags($_POST['form']['phone']) . "
						<br> ".$CORE->_e(array('single','27'))." : " . strip_tags($_POST['form']['email']) . "
						<br> ".$CORE->_e(array('single','29'))." : " . strip_tags($_POST['form']['message']) . "";
		
						
			if(isset($_POST['report']) && is_numeric($_POST['report']) ){
			
				$the_post = get_post($_POST['report']);
			
				$message .= "<p> ".$CORE->_e(array('button','53')).":  ".strip_tags($_POST['report'])."  <a href='" .get_permalink($_POST['report']) ."'>".$the_post->post_title."</a></p>";
			
			}
		
			// SEND EMAIL			 					 
			$CORE->SENDEMAIL("admin", 0, "Contact Form", $message);
			 
			// ERROR MESSAGE
			$GLOBALS['cerror_type'] 	= "success"; //ok,warn,error,info
			$GLOBALS['cerror_msg'] 	= $CORE->_e(array('single','8')); 
	 
				
		}else{

			$GLOBALS['cerror_type'] 	= "danger"; //ok,warn,error,info
			$GLOBALS['cerror_msg'] 	= $CORE->_e(array('contact','9'));		
			
		}

 
}

function NoFollowIndex(){

	echo '<META NAME="ROBOTS" CONTENT="NOINDEX, FOLLOW"><META NAME="ROBOTS" CONTENT="INDEX, NOFOLLOW"><META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';

}

// no index for report page
if(isset($_GET['report'])){add_filter('wp_head','NoFollowIndex');}

// LOAD HEADER   
get_header($CORE->pageswitch()); ?>

<?php if(isset($GLOBALS['cerror_type'])){ echo $CORE->ERRORCLASS($GLOBALS['cerror_msg'], $GLOBALS['cerror_type']); } ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  
	<!-- START CONTENT BLOCK -->
	<div class="panel panel-default">
	 
	 <div class="panel-heading"><?php the_title(); ?></div>
	 
	 <div class="panel-body">  
		 
	
		<?php the_content(); ?> 
        
     
        
<form class="contactform" role="form" method="post" action="" onsubmit="return CheckFormData();">
<input type="hidden" name="action" value="singlecontactform" />
<?php if(isset($_GET['report']) && is_numeric($_GET['report']) ){ ?><input type="hidden" name="report" value="<?php echo strip_tags($_GET['report']); ?>" /><?php } ?>
	 
		  
		<div class="form-group">
	        <label class="control-label"><?php echo $CORE->_e(array('single','26')); ?> <span class="required">*</span></label>
			<div class="controls">
			    <div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					<input type="text" class="form-control" name="form[name]" id="name" tabindex="10">
				</div>
			</div>
		</div>
		
		
		<div class="form-group">
	        <label class="control-label"><?php echo $CORE->_e(array('single','27')); ?> <span class="required">*</span></label>
			<div class="controls">
			    <div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
					<input type="text" class="form-control" id="email1" name="form[email]" tabindex="11">
				</div>
			</div>	
		</div>
		
		<div class="form-group ">
	        <label class="control-label"><?php echo $CORE->_e(array('single','28')); ?></label>
			<div class="controls">
			    <div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
					<input type="text" class="form-control" id="phone" name="form[phone]" tabindex="12" >
				</div>
			</div>
		</div>
 
		
		<div class="form-group ">
	        <label class="control-label"><?php echo $CORE->_e(array('single','29')); ?> <span class="required">*</span> </label>
			<div class="controls">
			    <div class="input-group">
				<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
					<textarea name="form[message]" class="form-control" rows="4" cols="78" id="message" tabindex="13"></textarea>

				</div>
			</div>
		</div>
        
        <hr />
        
          <label for="name"><?php echo str_replace("%a",$email_nr1,str_replace("%b",$email_nr2,$CORE->_e(array('validate','6')))); ?> <span class="required">*</span></label> 
            <input type="text" name="form[code]" value="" class="form-control"  id="code" tabindex="5" /> 
            <input type="hidden" name="form[code_value]" value="<?php echo $email_nr1+$email_nr2; ?>" />
        
        <hr />
		
		
		
	      <div class="controls text-center">
		  
	       <button type="submit" id="mybtn" class="btn btn-lg btn-primary"><?php echo $CORE->_e(array('widgets','21')); ?></button>
	        
	      </div>
		</form>     
        
        
<script language="javascript" type="text/javascript">

		function CheckFormData()
		{
 
 		
			var name 	= document.getElementById("name"); 
			var email1 	= document.getElementById("email1");
			var code = document.getElementById("code");
			var message = document.getElementById("message");	 
						
			if(name.value == '')
			{
				alert('<?php echo $CORE->_e(array('validate','0')); ?>');
				name.focus();
				name.style.border = 'thin solid red';
				return false;
			}
			if(email1.value == '')
			{
				alert('<?php echo $CORE->_e(array('validate','0')); ?>');
				email1.focus();
				email1.style.border = 'thin solid red';
				return false;
			}
 		

			if(code.value == '')
			{
				alert('<?php echo $CORE->_e(array('validate','0')); ?>');
				code.focus();
				code.style.border = 'thin solid red';
				return false;
			} 
			
			if(message.value == '')
			{
				alert('<?php echo $CORE->_e(array('validate','0')); ?>');
				message.focus();
				message.style.border = 'thin solid red';
				return false;
			} 			
			
			return true;
		}

 
</script>    
        
        
 
	 </div>
	 
	</div>  
 
	<?php endwhile; endif; ?>
    
<?php

get_footer($CORE->pageswitch());
	
// THAT'S ALL FOLKS! 
 
/* =============================================================================
   -- END FILE
   ========================================================================== */
?>
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

$user_info = get_userdata($authorID); 

// REGISTERED
$date = $CORE->TimeDiff($user_info->user_registered,'','',false, array('years','months','days','hours','seconds') );

// GET LAST LOGIN DATE
$lastlogin = get_user_meta($authorID, 'login_lastdate', true);
		
// USER COUNTRY
$selected_country = get_user_meta($authorID,'country',true);
		  
// GET LISTING COUNT
$listings = $CORE->count_user_posts_by_type( $authorID, THEME_TAXONOMY."_type" );
		
// SHOW PHONE NUMBER
$phone = get_user_meta( $authorID, 'phone', true);
		
// GET PROFILE BG STYLE
$pbg = get_user_meta($authorID,'pbg',true);
if($pbg == ""){ $pbg = 1; }

?>

<?php get_header($CORE->pageswitch()); ?>

<?php hook_author_before(); ?>
 

<div id="AuthorSingle">

<?php if($userdata->ID == $authorID && $GLOBALS['CORE_THEME']['links']['myaccount'] != ""){ ?><a href="<?php echo $GLOBALS['CORE_THEME']['links']['myaccount']; ?>" class="pull-right badge badge-success"><?php echo $CORE->_e(array('button','2')); ?></a><?php } ?> 

<div class="head" style="background:url('<?php echo FRAMREWORK_URI; ?>/img/profile/<?php echo $pbg; ?>.jpg'); background-size: 100% auto;"></div>

<div class="well profile">
 
    <div class="box1" style="margin-top:-120px;">
    
        <div class="col-xs-12 col-sm-8">
    
            <h1><?php echo get_the_author_meta( 'display_name', $authorID); ?></h1>
            
            <?php if(strlen($selected_country) > 0){ ?>
            
            <div class="desc"><div class="flag flag-<?php echo strtolower($selected_country); ?> wlt_locationflag"></div><?php echo $GLOBALS['core_country_list'][$selected_country]; ?> </div>
            
            <?php } ?> 
            
            <?php if(isset($GLOBALS['CORE_THEME']['feedback_enable']) && $GLOBALS['CORE_THEME']['feedback_enable'] == '1'){ ?>
            
            <hr />
            
            <?php echo _user_trustbar($authorID, 'inone'); ?>
            
            <?php } ?>
                         
            <hr />
            
            <p><strong><?php echo $CORE->_e(array('auction','61')); ?></strong> <?php echo hook_date($user_info->user_registered); ?></p>
        
        	<p><strong><?php echo $CORE->_e(array('widgets','26')); ?></strong> <?php echo hook_date($lastlogin); ?></p>
       
        
        </div>    
                             
         <div class="col-xs-12 col-sm-4 text-center">
                    
             <div class="text-center">
                               
             <?php echo str_replace("img-responsive","img-responsive img-circle", get_avatar( $authorID, 200 ) ); ?>
                              
             </div>
                        
        </div>
        
        <div class="clearfix"></div>
        
        <hr />
       
        <div class="linkbar">
        
        <ul class="list-inline">
            <?php 
			
			// MSG USER
			 echo "<li class='ee'><i class='fa fa-envelope'></i> <a href='".$GLOBALS['CORE_THEME']['links']['myaccount']."/?u=".$authorID."&tab=msg&show=1' rel='nofollow' target='_blank'>".$CORE->_e(array('single','7'))."</a></li> ";			
            
            // URL
            $data = get_user_meta( $authorID, 'url', true);
            if(strlen($data) > 0){ 
            echo "<li><i class='fa fa-globe'></i> <a href='".$data."' rel='nofollow' target='_blank'>".$CORE->_e(array('button','12'))."</a></li> "; 
            }           
                
            // FACEBOOK
            $data = get_user_meta( $authorID, 'facebook', true);
            if(strlen($data) > 0){ 
            echo "<li class='fb'><i class='fa fa-facebook-square'></i> <a href='".$data."' rel='nofollow' target='_blank'>Facebook</a></li>"; 
            }  	
            
            // TWITTER
            $data = get_user_meta( $authorID, 'twitter', true);
            if(strlen($data) > 0){ 
            echo "<li class='tw'><i class='fa fa-twitter-square'></i> <a href='".$data."' rel='nofollow' target='_blank'>Twitter</a></li> "; 
            }  		
            
            // LINKEDIN
            $data = get_user_meta( $authorID, 'linkedin', true);
            if(strlen($data) > 0){ 
            echo "<li class='in'><i class='fa fa-linkedin-square'></i> <a href='".$data."' rel='nofollow' target='_blank'>Linkedin</a></li>"; 
            } 	
    
            // SKYPE
            $data = get_user_meta( $authorID, 'skype', true);
            if(strlen($data) > 0){ 
            echo "<li class='sk'><i class='fa fa-skype'></i> <a href='skype:".$data."' rel='nofollow' target='_blank'>Skype</a> </li>"; 
            }
            
            ?>
           </ul> 
         </div> 
          
    <div class="clearfix"></div>   
    
    
  <?php 
		
		// DISPLAY USER DESCRIPTION
		$dee = get_the_author_meta( 'description', $authorID); if(strlen($dee) > 1){ ?>
        
        <hr />
         
        <div class="userdescription"><?php echo wpautop($dee); ?></div>
    
        
        <script>
            jQuery(document).ready(function(){
                jQuery('.userdescription').shorten({
                    moreText: '<?php echo $CORE->_e(array('feedback','3')); ?>',
                    lessText: '<?php echo $CORE->_e(array('feedback','4')); ?>',
                    showChars: '500',
                });
            });
            </script>
 		 
        <?php } ?>  
          
</div>
   
   
   
  

 



<?php if(isset($GLOBALS['CORE_THEME']['feedback_enable']) && $GLOBALS['CORE_THEME']['feedback_enable'] == '1'){ ?>

<hr />
	 
<h4><?php echo $CORE->_e(array('feedback','0')); ?></h4>

<hr />

<div class="clearfix box1"  id="AuthorSingleFeedback">
 
<?php WLT_FeedbackSystem($authorID); ?>
 
</div>

<?php } ?>

</div>


<?php hook_author_after(); ?>
 	 
<?php get_footer($CORE->pageswitch()); ?>
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

get_header($CORE->pageswitch());

// BUILD OUTPUT FOR HOME PAGE CONTENT
ob_start();

// HOME PAGE RECENT LISTINGS
if($GLOBALS['CORE_THEME']['mobileweb_homesetup'] == '1'){ 
?>
	<style>.home { background:#fff; }</style>    
    
    <a href="<?php echo home_url(); ?>/" id="logo1"><?php echo stripslashes($GLOBALS['CORE_THEME']['mobileweb_logo']); ?></a>
        
	<?php if(strlen($GLOBALS['CORE_THEME']['mobileweb_subtxt']) > 1){ ?>
    <div class="sublinetext"><?php echo stripslashes($GLOBALS['CORE_THEME']['mobileweb_subtxt']); ?></div>
    <?php } ?>
      
    <hr /> 
     
    <h4><?php echo $CORE->_e(array('mobile','1')); ?></h4>    
    
    <div class="search">
    
    <?php 
    $args = array(
        'post_type'=> THEME_TAXONOMY."_type",
        'orderby'    => 'post_date',
        'order'    => 'DESC'
    );
    query_posts( $args );
    ?>
    
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?> 
                 
            <?php get_template_part( 'content', 'mobile' ); ?>    
     
    <?php endwhile; endif; ?>
    </div>

<?php }elseif($GLOBALS['CORE_THEME']['mobileweb_homesetup'] == '2'){  ?>
   
    <a href="<?php echo home_url(); ?>/" id="logo1"><?php echo stripslashes($GLOBALS['CORE_THEME']['mobileweb_logo']); ?></a>
    
    <?php if(strlen($GLOBALS['CORE_THEME']['mobileweb_subtxt']) > 1){ ?>
    <div class="sublinetext"><?php echo stripslashes($GLOBALS['CORE_THEME']['mobileweb_subtxt']); ?></div>
    <?php } ?>
  	
 
    <div class="categorylist">
    <h4><?php echo $CORE->_e(array('homepage','3')); ?></h4>
    <?php echo do_shortcode('[D_CATEGORIES show_count=1]'); ?>
	</div>
    
<?php }else{ ?> 

    <div class="homemenu">
    
        <a href="<?php echo home_url(); ?>/" id="logo1"><?php echo stripslashes($GLOBALS['CORE_THEME']['mobileweb_logo']); ?></a>
        
		<?php if(strlen($GLOBALS['CORE_THEME']['mobileweb_subtxt']) > 1){ ?>
        <div class="sublinetext"><?php echo stripslashes($GLOBALS['CORE_THEME']['mobileweb_subtxt']); ?></div>
        <?php } ?>
    
        <div class="clearfix"></div>
    
        <ul>
            
        <li><a href="<?php echo home_url(); ?>/?s="><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> <?php echo $CORE->_e(array('mobile','1')); ?></a></li>    
        <li><a href="<?php echo $GLOBALS['CORE_THEME']['links']['myaccount']; ?>"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $CORE->_e(array('mobile','2')); ?></a></li>
        <li><a href="<?php echo home_url(); ?>/?s=&favs=1"><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <?php echo $CORE->_e(array('account','46')); ?></a></li>
        
        <?php if(isset($GLOBALS['CORE_THEME']['links']['blog']) && strlen($GLOBALS['CORE_THEME']['links']['blog']) > 1){ ?>
        <li><a href="<?php echo $GLOBALS['CORE_THEME']['links']['blog']; ?>"><span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span> <?php echo $CORE->_e(array('button','55')); ?></a></li>
        <?php } ?>
        
        <?php if(isset($GLOBALS['CORE_THEME']['links']['contact']) && strlen($GLOBALS['CORE_THEME']['links']['contact']) > 1){ ?>
        <li><a href="<?php echo $GLOBALS['CORE_THEME']['links']['contact']; ?>"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> <?php echo $CORE->_e(array('mobile','3')); ?></a></li>
        <?php } ?>
        
        </ul>
    
    </div>
    
    <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
    
     
        <a class="addthis_button_preferred_6"></a>
        <a class="addthis_button_preferred_5"></a>
        <a class="addthis_button_preferred_4"></a>
        <a class="addthis_button_preferred_3"></a>
        <a class="addthis_button_preferred_1"></a>
        <a class="addthis_button_preferred_2"></a> 
        <a class="addthis_button_compact"></a>
    
    </div>
    <script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=<?php echo $GLOBALS['CORE_THEME']['addthis_name']; ?>"></script>

<?php }

$SavedContent = ob_get_clean();
echo hook_mobile_content_homepage($SavedContent);
get_footer($CORE->pageswitch()); ?>
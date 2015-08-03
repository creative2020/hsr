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

<?php get_header($CORE->pageswitch()); ?>

<?php if ($wp_query->have_posts()) : ?>
 
<div class="searchpage">

<?php if($post->post_type ==  THEME_TAXONOMY."_type" ){ ?>
<div class="btn-group">

  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="width:100%;"><?php echo $CORE->_e(array('gallerypage','9')); ?> <span class="caret"></span></button>
  
  <ul class="dropdown-menu" role="menu"><?php echo $CORE->OrderBy(); ?></ul>
  
</div>
<?php } ?>

<div class="text-center resultstxt"><?php echo hook_gallerypage_results_text(str_replace("%a",number_format($wp_query->found_posts),$CORE->_e(array('gallerypage','1')))); ?></div>


	
<a name="topresults"></a>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?> 
                 
            <?php get_template_part( 'content', 'mobile' ); ?>    
     
    <?php endwhile; endif; ?>
    
    <div class="clearfix"></div>
    
    <?php echo $CORE->PAGENAV(); ?>
    
    </div>
    
    <?php else: ?>
    
    <div class="text-center">
    
    <span class="glyphicon glyphicon-remove" style="font-size:100px; color:#efefef;"></span>
    
    <h6><?php echo $CORE->_e(array('gallerypage','27')); ?></h6></div>
    
    <?php endif; ?>

</div>

<?php get_footer($CORE->pageswitch()); ?>
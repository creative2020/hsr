<?php
/*
Template Name: [Blog]
*/

if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

$GLOBALS['flag-blog'] = true;
?>

<?php get_header($CORE->pageswitch()); ?>
		
		<div class="panel panel-default"> 
		
			<div class="panel-heading"><?php the_title(); ?></div>
		  
            <ul class="list-group">
			<?php			 				 
			
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$posts = query_posts("paged=".$paged."&post_type=post"); 
				 
			if (have_posts()) : while (have_posts()) : the_post(); 
			 
			?>
            <li class="list-group-item">            
		 
			<?php get_template_part( 'content', 'post' ); ?>			 	
            	 
			</li>
			<?php endwhile; endif; ?>
           
            </ul>
		   
		</div>
		
		<?php echo $CORE->PAGENAV(); ?>
        
        <?php wp_reset_query(); ?>
		
<?php get_footer($CORE->pageswitch()); ?>
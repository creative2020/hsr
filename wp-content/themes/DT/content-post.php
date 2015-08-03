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

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope itemtype="http://schema.org/Blog">
		 
			<?php if ( has_post_thumbnail() ) { ?> <a  href="<?php the_permalink(); ?>" class="frame pull-right"> <?php the_post_thumbnail(array(150,150,'class'=> " img-thumbnail")); ?> </a><?php } ?>
				
			<h3><a href="<?php the_permalink(); ?>" title="<?php echo the_title(); ?>" rel="bookmark" itemprop="name"><?php echo the_title(); ?></a></h3>
			
			<blockquote>
				<div class="blogcats"><?php the_category(); ?></div>
				<small><?php the_date(); ?></small>
			</blockquote>
			
			<?php the_excerpt(); ?> 
            
</article>
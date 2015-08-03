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

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<div class="panel default-listing panel-default">

	<div class="panel-heading"><?php the_title(); ?></div>
    
    <div class="panel-body">
	
	<?php the_content(); ?>
    
    </div>

</div>

</article>

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

<?php global $CORE, $userdata; ?>
 	
        <?php if(!isset($GLOBALS['flag-custom-homepage'])): ?>
        
        <?php echo $CORE->BANNER('middle_bottom'); ?>
        
       </div></article>
        
 
        <?php if(!isset($GLOBALS['nosidebar-right'])): ?>
        
        <?php get_template_part( 'sidebar', 'right' ); ?>
        
        <?php endif; ?>       
        
        <?php hook_core_columns_after(); ?>  
    
    <?php endif; ?>
    
    </div>
    
	</div>

	</div> 

</div>

<?php hook_container_after(); ?> 

<?php hook_footer(_design_footer());?>
 
</div>

<?php hook_wrapper_after(); ?>
 
<div id="core_footer_ajax"></div>
  
<?php wp_footer(); ?>

</body> 

</html>


<?php 
/* =============================================================================
   [PREMIUMPRESS FRAMEWORK] THIS FILE SHOULD NOT BE EDITED
   ========================================================================== */
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
/* ========================================================================== */

global $CORE, $userdata; ?>
 	
        <?php if(!isset($GLOBALS['flag-custom-homepage'])){ ?>
        
        <?php echo $CORE->BANNER('middle_bottom'); ?>
        
        </article>
        
        <!-- [WLT] FRAMRWORK // RIGHT COLUMN -->    
        <?php if(!isset($GLOBALS['nosidebar-right'])){ ?>
        <aside class="<?php $CORE->CSS("columns-right"); ?> <?php if(isset($GLOBALS['CORE_THEME']['mobileview']['sidebars']) && $GLOBALS['CORE_THEME']['mobileview']['sidebars'] == '1'){ ?><?php }else{ ?>hidden-xs<?php } ?>" id="core_right_column">
         
        	<?php hook_core_columns_right_top(); /* HOOK */ ?>
            
       		<?php dynamic_sidebar('Right Column'); ?>
            
            <?php hook_core_columns_right_bottom(); /* HOOK */ ?>
         
        </aside>
        <?php } ?> 
       
        
        <?php hook_core_columns_after(); /* HOOK */ ?> 
 
    
    <?php } // end no custom home page ?>
    
</div> </div> 

</section> 

<?php hook_container_after(); /* HOOK */ ?>

<?php // 2020 added
echo do_shortcode('[tt_hsr_qsearch]');
?>

<?php hook_footer(_design_footer());?>
 
</div>

<?php hook_wrapper_after(); /* HOOK */ ?>

<?php echo $CORE->BANNER('footer'); ?>
 
<?php wp_footer(); ?>

<?php echo stripslashes(get_option('google_analytics')); ?>

<?php echo _design_mobilemenu();  ?><!-- [WLT] FRAMRWORK // MOBILE MENU -->

</body><!-- [WLT] FRAMRWORK // END BODY -->

</html>
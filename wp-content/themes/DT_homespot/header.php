<?php
/* =============================================================================
   [PREMIUMPRESS FRAMEWORK] THIS FILE SHOULD NOT BE EDITED
   ========================================================================== */
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
/* ========================================================================== */

global $CORE, $OBJECTS, $userdata; 


// LOAD IN COLUMN LAYOUTS
$CORE->BODYCOLUMNS();

header('X-UA-Compatible: IE=edge,chrome=1');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<!--[if lte IE 8 ]><html lang="en" class="ie ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="ie"><![endif]-->
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->
<?php if(!isset($GLOBALS['CORE_THEME']['responsive']) || ( isset($GLOBALS['CORE_THEME']['responsive']) && $GLOBALS['CORE_THEME']['responsive'] == 1 ) ){ ?>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php }else{ ?>
<meta name='viewport' content="width=1170" />
<?php } ?>
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title> 
<?php wp_head(); ?><?php hook_meta(); /* HOOK */ ?>
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <link rel='stylesheet' id='hsr-main-css'  href='/wp-content/themes/DT_homespot/tt-lib/css/tt-hsr-main.css?ver=1.0' type='text/css' media='all' />
</head>
<!-- [HSR] FRAMRWORK // BODY -->
<body class="container-fluid">

<!-- [HSR] FRAMRWORK // PAGE WRAPPER -->
<div class="row" id="">
 
<?php hook_wrapper_before(); /* HOOK */ ?>       
<div class="">
    <header id="header" class="col-md-10 col-md-offset-1"></header><div class=""><!-- [HSR] HEADER -->
</div>
<div class=""> <!-- main navigation [col-md-10 col-md-offset-1]-->
    
  
    
    
<?php 

echo    hook_topmenu(_design_topmenu()).
        hook_header(_design_header()).
        hook_menu(_design_menu(),1);

hook_container_before(); /* HOOK */ ?>

</div></div>

<?php hook_header_after(); /* HOOK */ ?>

<?php

	// HOME PAGE OBJECTS
	if(isset($GLOBALS['flag-home']) ){ 
    
     	// GET HOME PAGE OBJECTS
        if(isset($GLOBALS['CORE_THEME']['homepage']) && isset($GLOBALS['CORE_THEME']['homepage']['widgetblock1']) && strlen($GLOBALS['CORE_THEME']['homepage']['widgetblock1']) > 1){
			echo '<div id="row">';
            echo $OBJECTS->WIDGETBLOCKS($GLOBALS['CORE_THEME']['homepage']['widgetblock1'], false, true);
			echo '</div>';
        }
		
	 }	

?>

<!-- [WLT] FRAMRWORK // MAIN BODY -->  
<section id="page">

<div class="row"><div class="col-md-12">
 
<?php 

hook_breadcrumbs_before(); /* HOOK */

echo hook_breadcrumbs(_design_breadcrumbs());

hook_breadcrumbs_after(); /* HOOK */ ?>

<?php echo $CORE->BANNER('full_top'); ?> 

<?php //hook_core_columns_wrapper_inside(); /* HOOK */ ?>

<?php if(!isset($GLOBALS['flag-custom-homepage'])){ 

	// HOME PAGE OBJECTS
	if(isset($GLOBALS['flag-home']) ){ 
    
     	// GET HOME PAGE OBJECTS
        if(isset($GLOBALS['CORE_THEME']['homepage']) && isset($GLOBALS['CORE_THEME']['homepage']['widgetblock1']) && strlen($GLOBALS['CORE_THEME']['homepage']['widgetblock1']) > 1){
			echo '<div id="row">';
            echo $OBJECTS->WIDGETBLOCKS($GLOBALS['CORE_THEME']['homepage']['widgetblock1'],true, false );
			echo '</div>';
        }
		
	 }	 
	
	// LEFT SIDEBAR
	if(!isset($GLOBALS['nosidebar-left'])){ ?>
    <!-- [WLT] FRAMRWORK // LEFT COLUMN -->
	<aside class="<?php $CORE->CSS("columns-left"); ?> <?php if(isset($GLOBALS['CORE_THEME']['mobileview']['sidebars']) && $GLOBALS['CORE_THEME']['mobileview']['sidebars'] == '1'){ ?><?php }else{ ?>hidden-xs<?php } ?>" id="core_left_column">
    
    	<?php hook_core_columns_left_top(); /* HOOK */ ?>
             
    	<?php dynamic_sidebar('Left Column'); ?>
        
        <?php hook_core_columns_left_bottom(); /* HOOK */ ?>
        
    </aside>
    <?php } ?>
    
    <!-- [WLT] FRAMRWORK // MIDDLE COLUMN -->
	<article class="<?php $CORE->CSS("columns-middle"); ?>" id="core_middle_column"><?php echo $CORE->ERRORCLASS(); ?><div id="core_ajax_callback"></div><?php echo $CORE->BANNER('middle_top'); ?>  
    
<?php } // end no custom home page ?>
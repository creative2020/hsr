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
 
<?php global $CORE, $OBJECTS, $userdata;  ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<!--[if lte IE 8 ]><html lang="en" class="ie ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="ie"><![endif]-->
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge" /><![endif]-->

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title> 
<?php wp_head(); ?> 
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
 
<body <?php body_class(); ?> <?php echo $CORE->ITEMSCOPE('webpage'); ?>>
 
<div class="page-wrapper <?php $CORE->CSS("mode"); ?>" id="<?php echo THEME_TAXONOMY; ?>_styles">
 
<?php hook_wrapper_before(); ?>  
     
<div class="header_wrapper">

    <header id="header">
    
        <div class="overlay"> 
    
        <?php echo hook_topmenu(_design_topmenu()).hook_header(_design_header()).hook_menu(_design_menu(),1); ?>
    
        <?php hook_container_before(); ?>
    
        </div>
    
    </header>

	<?php hook_header_after(); ?>
 
</div> 

<div id="core_padding">

	<div class="<?php $CORE->CSS("container"); ?><?php $CORE->CSS("2columns"); ?> core_section_top_container">
    
    <?php echo $CORE->BANNER('full_top'); ?> 

		<div class="row core_section_top_row">
 
<?php hook_breadcrumbs_before(); ?>

<?php echo hook_breadcrumbs(_design_breadcrumbs()); ?>

<?php hook_breadcrumbs_after(); ?>

<?php hook_core_columns_wrapper_inside(); ?>

	<?php if(!isset($GLOBALS['flag-custom-homepage'])): ?>
 
 	<?php hook_core_columns_wrapper_inside_inside(); ?>	
	
		<?php if(!isset($GLOBALS['nosidebar-left'])): ?>
        
        <?php get_template_part( 'sidebar', 'left' ); ?> 
      
        <?php endif; ?>
        
    <div id="core_inner_wrap">   
 
	<article class="<?php $CORE->CSS("columns-middle"); ?>" id="core_middle_column"><div class="core_middle_wrap"><?php echo $CORE->ERRORCLASS(); ?><div id="core_ajax_callback"></div><?php echo $CORE->BANNER('middle_top'); ?>
	
	<?php hook_core_columns_wrapper_middle_inside();  ?> 
       
	<?php endif; ?>
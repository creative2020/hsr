<?php global $CORE, $post, $userdata; 

// GET MOBILE MENU
$nav_menu = wp_get_nav_menu_object($locations['mobile-menu']);
$menubar =  wp_nav_menu( array( 
'container' => '',
'container_class' => '',
'menu' => $nav_menu->term_id,
'menu_class' => 'mobilemenu',
'fallback_cb'     => '',
'echo'            => false,
'walker' => new Bootstrap_Walker(),	
) 
);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title> 

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
 
<?php wp_head(); ?>

<?php hook_mobile_header(); ?>

<script>
jQuery(document).ready(function(){

	jQuery('.mm').click(function(event){
		
		if (jQuery('#searchnav').is(":visible")){
			jQuery('#searchnav').hide(100);
		}
		
		if (jQuery('#mobilenav').is(":visible")){
			jQuery('#mobilenav').hide(100);
		}else{
			jQuery('#mobilenav').show(100);
		}
	});
	
	jQuery('.sb').click(function(event){
	
		if (jQuery('#mobilenav').is(":visible")){
			jQuery('#mobilenav').hide(100);
		}
		
		if (jQuery('#searchnav').is(":visible")){
			jQuery('#searchnav').hide(100);
		}else{
			jQuery('#searchnav').show(100);
		}
	});

});

</script>

</head>
<body <?php body_class(); ?>>

<div class="colorwrapper <?php if($GLOBALS['CORE_THEME']['mobileweb_color'] != ""){ echo $GLOBALS['CORE_THEME']['mobileweb_color']; }else{ echo "blue"; } ?>">

<section id="searchnav" style="display:none">

<form action="<?php echo home_url(); ?>/" method="get">
 	
    <h5>Search Terms</h5>
    
	<input type="search" name="s" placeholder="<?php echo $CORE->_e(array('homepage','7')); ?>" >
    
    <select name="cat1" >
    	<option value=""><?php echo $CORE->_e(array('button','31','flag_noedit')); ?></option>
		<?php if(!isset($_GET['cat1'])){ $selcat = ""; }else{ $selcat = $_GET['cat1']; } echo $CORE->CategoryList(array($selcat,false,0,THEME_TAXONOMY)); ?>
	</select>
    
    <input type="submit" class="btn btn-primary" value="<?php echo $CORE->_e(array('button','11')); ?>">

</form> 


</section>

<nav id="mobilenav" style="display:none">
    <div class="wrapper">
    	<?php echo $menubar; ?>
    </div>
</nav>

<header>

    <div class="menubtn mm">
        <a href="#"><img src="<?php echo FRAMREWORK_URI; ?>img/mobile/icon-toggle.png" alt=""></a>
    </div>
    
    <?php if(isset($GLOBALS['flag-home'])){ ?>
    <div class="menubtn sb">
      <a href="#"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
    </div>
    <?php } ?> 
 
    
    <ul>
        <li class="home <?php if(isset($GLOBALS['flag-home'])){ ?>active<?php } ?>"><a href="<?php echo home_url(); ?>/" title="Home"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <li class="user <?php if(isset($GLOBALS['flag-myaccount'])){ ?>active<?php } ?>"><a href="<?php echo $GLOBALS['CORE_THEME']['links']['myaccount']; ?>" title="Members Area"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></a></li>
        <?php  if($GLOBALS['CORE_THEME']['show_account_favs'] == '1'){ ?>
        <li class="contact <?php if(isset($_GET['favs'])){ ?>active<?php } ?>"><a href="<?php if(!$userdata->ID){ echo wp_login_url(); }else{ echo home_url(); ?>/?s=&favs=1<?php } ?>" title="Favorites"><span class="glyphicon glyphicon-star" aria-hidden="true"></span> <?php echo $CORE->FAVSCOUNT(); ?></a></li>
        <?php } ?>
        
        <?php if(isset($GLOBALS['CORE_THEME']['geolocation']) && $GLOBALS['CORE_THEME']['geolocation'] != ""){ 
		
		if(isset($_SESSION['mylocation'])){
				$country = $_SESSION['mylocation']['country'];
				$addresss = $_SESSION['mylocation']['address'];
			}else{
				$address = "";
				$country = $GLOBALS['CORE_THEME']['geolocation_flag'];
			}
		?>
        <li class="map"><a href="javascript:void(0);" onClick="GMApMyLocation();" data-toggle="modal" data-target="#MyLocationModal">
        <div class="flag flag-<?php echo strtolower($country); ?> wlt_locationflag"></div></a>
        </li>
        <?php } ?>
        
    </ul>

</header>

<?php if(!isset($GLOBALS['flag-home']) || ( isset($GLOBALS['flag-home']) && $GLOBALS['CORE_THEME']['mobileweb_recentlistings'] == '1' )){ ?>

<section id="subheader">

	<a href="<?php echo home_url(); ?>/" id="logo"><?php echo stripslashes($GLOBALS['CORE_THEME']['mobileweb_logo']); ?></a>
    
    <ul>
        <li class="sb"> <a href="#"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a></li>
    </ul>

</section>

<?php } ?>
            
 

<div id="wrapper">
 
    <div class="main-container">
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


<?php hook_gallerypage_before(); ?> 

<?php hook_gallerypage_results_before(); ?> 

<?php if(!defined('HIDE_SEARCHRESULTS_BOX')){ ?>

<div class="_searchresultsblock">

<?php if(!defined('HIDE_SEARCHRESULTS_HEAD')){ ?>

<h1><?php echo hook_gallerypage_results_title(''); ?></h1>

<h4><?php echo hook_gallerypage_results_text(str_replace("%a",number_format($wp_query->found_posts),$CORE->_e(array('gallerypage','1')))); ?></h4>

<hr /> 

<?php } ?>

<?php $LAYOUT->gallerypage_results_before(); ?>

<?php if(!isset($GLOBALS['CORE_THEME']['search_searchbar']) || isset($GLOBALS['CORE_THEME']['search_searchbar']) && $GLOBALS['CORE_THEME']['search_searchbar'] == 1){ ?>

<div class="row">

    <div class="col-md-6 col-sm-12 col-xs-12">
        
        <form action="<?php echo get_home_url(); ?>/" method="get" class="form-inline" role="search">
        
        <input type="text" class="form-control " name="s" placeholder="<?php echo $CORE->_e(array('homepage','7')); ?>">
        
        <button type="submit" class="btn btn-primary"><?php echo $CORE->_e(array('button','11')); ?></button> 
         
        </form>
    
    </div>
    
    <div class="col-md-6 col-sm-12 col-xs-12">
 
        <ul class="list-inline ext1">
        
        <li><a href="javascript:void(0);" onclick="jQuery('#s1').show(); ShowAdSearch('<?php echo str_replace("http://","",get_home_url()); ?>','advancedsearchformajax');" style=" text-decoration:underline;"><?php echo $CORE->_e(array('head','2')); ?></a></li>
        
        <?php if($GLOBALS['CORE_THEME']['show_account_favs'] == '1'){ ?>
                
        <li><a href="<?php echo home_url().'/?s=&amp;favs=1'; ?>" style=" text-decoration:underline;"><?php echo $CORE->_e(array('account','46')); ?> (<?php echo $CORE->FAVSCOUNT(); ?>)</a></li>
                
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
        
        <li><a href="javascript:void(0);" onclick="GMApMyLocation();" data-toggle="modal" data-target="#MyLocationModal" style=" text-decoration:underline;"><div class="flag flag-<?php echo strtolower($country); ?> wlt_locationflag"></div><?php echo $CORE->_e(array('widgets','16')); ?></a></li>
        
        <?php } ?>
        
        </ul>
    
    </div>
 
</div>

<div class="clearfix"></div>

<hr />

<?php } ?>

<div id="s1" style="display:none">
    <div class="box1" >
    <a href="javascript:void(0);" onclick="jQuery('#s1').hide();" class="badge pull-right" ><?php echo $CORE->_e(array('single','14')); ?></a>
  
   <div id="advancedsearchformajax"></div>
    </div>
    <hr />
</div>


<?php if ($wp_query->have_posts()) : ?>

<div>
<ul class="list-inline orderby">
    <li><strong><?php echo $CORE->_e(array('gallerypage','9')); ?>: </strong></li>
    <?php echo $CORE->OrderBy(); ?>
</ul>
</div>

 
<div class="changebtns">
        
          <a href="#" id="wlt_search_tab1" class="btn btn-default btn-sm <?php if($GLOBALS['CORE_THEME']['display']['default_gallery_style'] == "list"){ echo "active"; }?>">
                    <i class="fa fa-list"></i> <?php echo $CORE->_e(array('button','50')); ?></a>
                    
                    <?php if($GLOBALS['CORE_THEME']['display']['default_gallery_style'] != "listonly"){ ?>
                    <a href="#" id="wlt_search_tab2" class="btn btn-default btn-sm <?php if($GLOBALS['CORE_THEME']['display']['default_gallery_style'] == "grid"){ echo "active"; }?>">
                    <i class="fa fa-th-large"></i> <?php echo $CORE->_e(array('button','51')); ?></a>
                    <?php } ?>
                    
                    <?php if($GLOBALS['CORE_THEME']['display']['default_gallery_style'] != "listonly"){ ?>
                    <a href="#" id="wlt_search_tab3" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $CORE->_e(array('button','52')); ?></a>
                    <?php } ?> 
                    
                    <?php hook_gallerypage_results_btngroup(); ?>     
</div>

<hr />

<?php endif; ?>
 
<div class="clearfix"></div>  

</div>

<?php } ?>

<?php hook_gallerypage_results_after(); ?>








<?php if ($wp_query->have_posts()) : ?> 
 

<div class="_searchresultsdata"> 

	<?php hook_gallerypage_results_top(); ?>
 
	<a name="topresults"></a>

	<div class="wlt_search_results row <?php if($GLOBALS['CORE_THEME']['display']['default_gallery_style'] == "grid"){ echo "grid_style";  }else{ echo "list_style"; } ?>">

		<?php hook_items_before(); ?>
<?php wp_reset_query(); ?>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php  if($canShowExtras):
                    $maplong = get_post_meta($post->ID,'map-log',true);
                    if($maplong !=""):
						if(!isset($map_coords)){ $map_coords = ""; }
                        $map_coords .= "[".get_post_meta($post->ID,'map-lat',true).", ".$maplong.", '".get_permalink($post->ID)."','".str_replace(array("\r\n", "\r", "\n"), "<br>", 
						strip_tags(str_replace("'","",$post->post_title))."', '".strip_tags(trim(addslashes($CORE->ITEM_CONTENT($post, "[EXCERPT size=100]..")))))."','".$post->ID."', '".$CORE->ITEM_CONTENT($post, "[IMAGE pid='".$post->ID."' pathonly=true]")."'],";
                    endif;
                endif;
            ?>
             
        <?php get_template_part( 'content', hook_content_templatename($post->post_type) ); ?> 
        
        <?php wp_reset_postdata(); ?>
 
		<?php endwhile; ?>

		<?php hook_items_after(); ?>

	<script>var coords = [<?php if(isset($map_coords)){ echo substr($map_coords,0,-1); } ?>]; <?php if($map_coords == ""){ ?>jQuery('#wlt_search_tab3').hide();<?php } ?></script>

<div class="clearfix"></div>

</div>

<?php if( ( isset($GLOBALS['CORE_THEME']['default_gallery_map']) && $GLOBALS['CORE_THEME']['default_gallery_map'] == '1' && $canShowExtras) || isset($_GET['showmap']) ):  ?>

	<script>
    jQuery(document).ready(function() {
        loadGoogleMapsApi();
        jQuery('#wlt_search_tab2').removeClass('active');
        jQuery('#wlt_search_tab1').removeClass('active');
        jQuery('#wlt_search_tab3').addClass('active');
    });
    <?php endif; ?>
    </script>

<?php endif; ?> 

<?php echo $CORE->PAGENAV(); ?>
		
<?php hook_gallerypage_after(); ?>

<?php else: ?>

<?php get_template_part( 'page', 'noresults' ); ?>

<?php endif; ?>

<?php get_footer($CORE->pageswitch()); ?>
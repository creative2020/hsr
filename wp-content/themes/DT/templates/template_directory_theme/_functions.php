<?php

// TURN OFF DEFAULT PRICE SEARCH
define('DEFAULTS_PRICE_SEARCH',false);

// EMABLE ANIMATION CSS
//define('ANIMATION_CSS', true);

// TURN OFF DEFAULT PRICE SEARCH
define('DEFAULTS_ADMIN_COLOR_PRESETS',false);

//RIGHTSIDEBAR
add_action('init','rsb');
function rsb(){
			register_sidebar(array('name'=>'Listing Page',
				'before_widget' => '<div class="panel panel-default">',
				'after_widget' 	=> '<div class="clearfix"></div></div></div>',
				'before_title' 	=> '<div class="panel-heading">',
				'after_title' 	=> '</div><div class="panel-body widget">',
				'description' => '',
				'id'            => 'sidebar-7',
			));
}


add_action('wp_head','gf');
function gf(){ ?>
 
    <link href="http://fonts.googleapis.com/css?family=Raleway:400,100,500,600,700,800,900,300,200" rel="stylesheet" type="text/css">
     
<?php 

}

add_action('hook_core_columns_left_top','sb1');
function sb1(){ global $CORE;

if(!isset($GLOBALS['flag-search'])){ return; }
 
$count_posts = wp_count_posts(THEME_TAXONOMY."_type");
$published_posts = $count_posts->publish;
 
 ?>
 

<div class="filtertip">

	<div class="wrap">
                    
						<div class="text1"><strong><?php echo number_format($published_posts); ?>+</strong> <?php echo $CORE->_e(array('homepage','12')); ?></div>
                        
                         <?php if(isset($GLOBALS['CORE_THEME']['links']['add']) && strlen($GLOBALS['CORE_THEME']['links']['add']) > 1 ){ ?>
            
            			<a href="<?php echo $GLOBALS['CORE_THEME']['links']['add']; ?>" class="btn btn-primary">
            
                        <?php echo $CORE->_e(array('homepage','4')); ?>
                        
                        </a>
                        
                        <?php } ?>                         
                        
	</div>
                    
	<div class="tip-arrow" style="bottom: -9px;"></div>
                    
</div>
<?php }











function wlt_homecatsd_object($existing_objects){ $a = array();
	$a[0]['id'] 				= "homecatsd";
	$a[0]['name'] 				= "Category Block"; 
	$a[0]['desc'] 				= "home page categories"; 
	$a[0]['icon'] 				= get_template_directory_uri()."/templates/template_directory_theme/img/icon1.png";
	return array_merge($existing_objects,$a);
}
add_action('hook_object_list','wlt_homecatsd_object');

function wlt_homecatsd_output($item_data){ 	
	global $post, $CORE, $wpdb; $core_admin_values = get_option("core_admin_values"); 
	
	if($core_admin_values['widgetobject'][$item_data[0]][$item_data[2]]['title'] == ""){ $core_admin_values['widgetobject'][$item_data[0]][$item_data[2]]['title'] = "Have a Website?"; }
	if($core_admin_values['widgetobject'][$item_data[0]][$item_data[2]]['title1'] == ""){ $core_admin_values['widgetobject'][$item_data[0]][$item_data[2]]['title1'] = "Popular Website Categories"; }
	if($core_admin_values['widgetobject'][$item_data[0]][$item_data[2]]['title2'] == ""){ $core_admin_values['widgetobject'][$item_data[0]][$item_data[2]]['title2'] = "A collection of our most popular website categories;"; }
 
?>

 
 
<div id="categoriesblock" class="clearfix">

            <div class="container">
            
            <div class="addbtn">
            
            <?php if(isset($GLOBALS['CORE_THEME']['links']['add']) && strlen($GLOBALS['CORE_THEME']['links']['add']) > 1 ){ ?>
            
            <a href="<?php echo $GLOBALS['CORE_THEME']['links']['add']; ?>">
            
                <i class="fa fa-chevron-right"></i>
                
                <div class="wrap">
                
                	<h4><?php echo $core_admin_values['widgetobject'][$item_data[0]][$item_data[2]]['title']; ?></h4>                
                
                </div>
            
            </a>
            
            <?php } ?>
            
            </div>
            
<h2><?php echo $core_admin_values['widgetobject'][$item_data[0]][$item_data[2]]['title1']; ?></h2>
            
<h3><?php echo $core_admin_values['widgetobject'][$item_data[0]][$item_data[2]]['title2']; ?></h3>
            
<hr />

<div class="row">

<?php
		$i = 0;
		$args = array(
			  'taxonomy'     => THEME_TAXONOMY,
			  'orderby'      => 'count',
			  'order'		=> 'desc',
			  'show_count'   => 0,
			  'pad_counts'   => 1,
			  'hierarchical' => 0,
			  'title_li'     => '',
			  'hide_empty'   => 0,
			 
		);
$categories = get_categories($args);

foreach ($categories as $category) { 

	if($i > 11){ continue; }

	// hide none parents
	if($category->parent != 0){ continue; }	

	$LINK 	= get_term_link($category->slug, THEME_TAXONOMY);
	$NAME 	= $category->name;
	$IMG 	= $core_admin_values['category_icon_'.$category->term_id];
	if($IMG == ""){ $IMG = "http://placehold.it/265x180"; }
	$DESC 	= $category->category_description;	
		 
?>
<div class="col-sm-3 col-md-3 col-lg-3">
    <div class="categoriesbox">
        <div class="categoriesbox-content">
            <h3><a href="<?php echo $LINK; ?>"><?php echo $NAME; ?></a></h3>
            <p><?php echo $DESC; ?></p>
        </div> 
        <a href="<?php echo $LINK; ?>"><img src="<?php echo $IMG ; ?>" alt="<?php echo $NAME; ?>"></a>
    </div> 
</div> 
 
<?php $i++; if($i == 4){ echo "<div class='clearfix'></div>"; } } ?>

</div> 

</div> 

</div>

<?php
 
}

add_action('hook_object', 'wlt_homecatsd_output');	

function wlt_homecatsd_settings($bits){ 
	 
	$core_admin_values = get_option("core_admin_values"); 
 
	$bit = $bits[0];
	$eid = $bits[1];
	$i = $bits[2];
	if (strpos($bit, "homecatsd") !== false) { $ITEMKEY = "homecatsd"; 
 
	?>
    
    <label><b>Button Text</b></label>
	<input type="text"  name="admin_values[widgetobject][<?php echo $ITEMKEY; ?>][<?php echo $i; ?>][title]" class="row-fluid" value="<?php echo  $core_admin_values['widgetobject'][$ITEMKEY][$i]['title']; ?>">
	

<br />

    <label><b>Title 1</b></label>
	<input type="text"  name="admin_values[widgetobject][<?php echo $ITEMKEY; ?>][<?php echo $i; ?>][title1]" class="row-fluid" value="<?php echo  $core_admin_values['widgetobject'][$ITEMKEY][$i]['title1']; ?>">


<br />

    <label><b>Title 2</b></label>
	<input type="text"  name="admin_values[widgetobject][<?php echo $ITEMKEY; ?>][<?php echo $i; ?>][title2]" class="row-fluid" value="<?php echo  $core_admin_values['widgetobject'][$ITEMKEY][$i]['title2']; ?>">
    
	 
    
	<?php			 
		$GLOBALS['itemkey'] = $ITEMKEY;		
		return $ITEMKEY; 
	} 
}
add_action('hook_object_setup', 'wlt_homecatsd_settings', 10);





// HOOK ADMIN STYLES TO INCLUDE CHILD THEME STYLING
function _ct_new_styles($c){ global $CORE, $STRING;

		if(isset($_POST['shownewcode']) && $_POST['shownewcode'] == "save" && isset($GLOBALS['CORE_THEME']['colors']['header']) && strlen($GLOBALS['CORE_THEME']['colors']['header']) > 1){
		 
			/// KEEP THEME LAYOUT
			$STRING .= "#core_menu_wrapper .row, #core_padding .container { background:transparent !important; }
			.header_style2 .navbar-nav > li > a, #core_menu_wrapper .navbar-nav li > a { color:#000; }
			.home-features .icon-wrapper i, .core_widgets_listings ul li a { color:".$GLOBALS['CORE_THEME']['colors']['header']."}
			.wlt_search_results.list_style .box3 { background:".$GLOBALS['CORE_THEME']['colors']['header']." }
			.filtertip, .wlt_search_results.list_style .box2 { background:".$GLOBALS['CORE_THEME']['colors']['header']."  }
			 .core_widgets_listings ul li:nth-child(odd) { background:".$GLOBALS['CORE_THEME']['colors']['body']." }
			#wlt_google_map_after, .tip-arrow {display:none; }
			.panel-default>.panel-heading { border-color:".$GLOBALS['CORE_THEME']['colors']['body']." }
			";
			
		 
		}		 
		
return $c.$STRING;
}
add_action('hook_styles_code_filter','_ct_new_styles');

?>
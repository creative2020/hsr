<?php


function WLT_FeedbackSystem($authorID){  global $CORE, $wpdb, $userdata;

if(isset($GLOBALS['CORE_THEME']['feedback_enable']) && $GLOBALS['CORE_THEME']['feedback_enable'] == '1'){

// GET USER FEEDBACK
$query = new WP_Query('posts_per_page=200&post_type=wlt_feedback&meta_key=uid&meta_value='.$authorID); 
$posts = $query->posts;
 
// GET MY FEEDBACK
$query1 = new WP_Query('posts_per_page=200&post_type=wlt_feedback&meta_key=auid&meta_value='.$authorID); 
$posts1 = $query1->posts;
?>    

<ul class="nav nav-tabs feedbacktabs" role="tablist">
    
	<li class="active"><a href="#fb0" aria-controls="home" role="tab" data-toggle="tab"><?php echo $CORE->_e(array('feedback','0')); ?> (<?php echo $query->found_posts; ?>)</a></li>

	<li><a href="#fb1" aria-controls="profile" role="tab" data-toggle="tab"><?php echo $CORE->_e(array('feedback','24')); ?> (<?php echo $query1->found_posts; ?>)</a></li>
     
</ul>

<div class="tab-content">

<hr />

<?php $i = 0; while($i< 2){ 

// GET DATA QUERY
if($i == 0){ $data =  $posts; }else { $data = $posts1; }

// OUTPUT DISPLAY
?>

<div role="tabpanel" class="tab-pane <?php if($i == 0){ ?>active<?php } ?>" id="fb<?php echo $i; ?>"> 
 
	<?php if(!empty($data)){ ?> 
     
	<ul class="list-group">

		<?php foreach($data as $post){

		// GET LISTING ID
		$listingid = get_post_meta($post->ID,'pid',true);
		if(!is_numeric($listingid)){ continue; }
		
		// GET SCORE
		$score = get_post_meta($post->ID,'score',true);
		if($score == ""){ $score = 0; }
		
		// CHECK IF THIS USER HAS PURCHASED THIS ITEM
		$SQL1 = "SELECT count(*) AS total FROM `".$wpdb->prefix."core_orders` WHERE order_items LIKE ('%".$listingid."%') AND user_id='".$post->post_author."' LIMIT 1 ";
		$result1 = $wpdb->get_results($SQL1);
		
		?>
		<li class="list-group-item"> 
         
			<div class="row">
    
			<div class="col-xs-3 col-md-3">
        
       		<small><a href="<?php echo get_permalink($listingid); ?>"><?php echo $CORE->_e(array('feedback','22')); ?> <?php echo get_post_meta($post->ID,'pid',true); ?></a></small>
        
       		<script type='text/javascript'>jQuery(document).ready(function(){ 
				jQuery('#wlt_feedbackstar_<?php echo $post->ID; ?>').raty({
				readOnly:  true,
				path: '<?php echo FRAMREWORK_URI; ?>img/rating/',
				score: <?php echo $score; ?>,
				size: 24,
				
				 
				}); });
            </script>
             
            <div id="wlt_feedbackstar_<?php echo $post->ID; ?>" class="wlt_starrating"  style="margin-top:10px;"></div> 
                
			   <?php if($result1[0]->total == 1){ ?>
               
               <span class="label label-success"><?php echo $CORE->_e(array('feedback','23')); ?></span>
               
               <?php } ?>
                    
               <?php if($userdata->ID == $post->post_author  ){ // && $result1[0]->total == 0 ?>
             
                
                <form id="deletefeedbackfrom" name="deletefeedbackfrom" method="post" action="" style="margin-top:10px;">         
                <input type="hidden" name="action" value="delfeedback" />         
                <input type="hidden" name="fid" value="<?php echo $post->ID; ?>" />
                <button type="submit"><?php echo $CORE->_e(array('feedback','9')); ?></button>        
                <div class="clearfix"></div>         
                </form>
            
                <?php } ?> 
            
            </div>
             
             <div class="col-xs-9 col-md-9">
             
             <?php echo "<a href='".get_author_posts_url( $post->post_author )."' class='hidden-xs pull-right'>".str_replace("avatar ","avatar img-circle ",get_avatar($post->post_author,50))."</a>"; ?>
             
             <h4><?php echo $post->post_title; ?></h4>
             
               <div class="article<?php echo $post->ID; ?>"><?php echo $post->post_content; ?></div>
            
            <?php if(strlen($post->post_content) > 100){  ?>     
            <script>
            jQuery(document).ready(function(){
                jQuery('.article<?php echo $post->ID; ?>').shorten({
                    moreText: '<?php echo $CORE->_e(array('feedback','3')); ?>',
                    lessText: '<?php echo $CORE->_e(array('feedback','4')); ?>',
                    showChars: '280',
                });
            });
            </script>
            <?php } ?>
                             
      </div>
                        
      </div> 
       
      </li>
      
    <?php wp_reset_postdata(); } wp_reset_query(); ?>
    
    </ul>

<?php }else{ ?>

<h4 class="text-center"><?php echo $CORE->_e(array('feedback','21')); ?></h4>

<?php } ?>

</div>

<?php $i++; } ?>

</div>


<?php } // end feedback system 

}










if(!function_exists('_user_trustbar')){
function _user_trustbar($user_id, $size = "big"){ global $wpdb, $CORE;

// MAKE SURE ITS ENABLED
if(isset($GLOBALS['CORE_THEME']['feedback_trustbar']) && $GLOBALS['CORE_THEME']['feedback_trustbar'] == '1'){ }else{ return; }


// COUNT RATING FROM ALL LISTINGS
$SQL = "SELECT count(*) as total, sum(mt2.meta_value) AS total_score FROM ".$wpdb->prefix."posts 
	INNER JOIN ".$wpdb->prefix."postmeta AS mt1 ON (".$wpdb->prefix."posts.ID = mt1.post_id ) 
	INNER JOIN ".$wpdb->prefix."postmeta AS mt2 ON (".$wpdb->prefix."posts.ID = mt2.post_id ) 
	WHERE 1=1 	
	AND ".$wpdb->prefix."posts.post_status = 'publish'	
	AND mt1.meta_key = 'uid' AND mt1.meta_value = '".$user_id."'
	AND mt2.meta_key = 'score'";
 
$result = $wpdb->get_results($SQL);
 
// working out
$T_R = $result[0]->total;
$T_S = $result[0]->total_score;
if($T_S  == ""){ $T_S  = 0; }

if($T_R > 0){
	$barWidth = ( $T_S / ($T_R * 5 ) ) * 100;
}else{
	$barWidth = 100;
}
 
// BAR COLOR
if($barWidth > 0 && $barWidth < 50){ $barcolor = "info"; } 
if($barWidth > 49 && $barWidth < 80){ $barcolor = "warning"; } 
if($barWidth > 79){ $barcolor = "success"; } 


if($size == "big"){
?>

<div class="feedback_big"> 
  
<small><?php echo $CORE->_e(array('feedback','5')); ?></small>

<p> <?php echo $barWidth; ?>% <span class="pull-right"><?php echo $T_R; ?> <?php echo $CORE->_e(array('feedback','2')); ?></span>  </p>

<div class="progress" style="margin:0px;">
  <div class="progress-bar progress-bar-<?php echo $barcolor; ?> progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barWidth; ?>%">
    <span class="sr-only"><?php echo $barWidth; ?>%</span>
  </div>
</div> 
 
  
</div>

<?php }elseif($size == "inone"){ ?>

 
<div class="progress" style="margin:0px;">
  <div class="progress-bar progress-bar-<?php echo $barcolor; ?> progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barWidth; ?>%">
  
  <span><?php echo $T_R; ?> <?php echo $CORE->_e(array('feedback','2')); ?>  <strong><?php echo $barWidth; ?>%</strong> </span>
    
  </div>
</div> 
 
 

<?php }else{ ?>

<div class="feedback_small">

<div class="clearfix"></div>
<div class="progress" style="height:8px; margin:0px; border-radius:0px;">
  <div class="progress-bar progress-bar-<?php echo $barcolor; ?> progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barWidth; ?>%">
    <span class="sr-only"><?php echo $barWidth; ?>%</span>
  </div>
</div>
</div>

<?php } ?>


<?php

}
}

if(!function_exists('_design_header')){
function _design_header(){ global $CORE;

// LOAD IN USER STYLE
if(!isset($GLOBALS['CORE_THEME']['layout_header'])){ $style = 1; }else{ $style = $GLOBALS['CORE_THEME']['layout_header']; }
 
$STRING = '<div id="core_header"><div class="'.$CORE->CSS("container",true).' header_style'.$style.'">
<div class="row">'.hook_header_row_top('');
 
switch($style){

	case "6": { // LOGO LONG + TEXT
	
		// LOGO
		$STRING .= hook_header_style6(stripslashes($GLOBALS['CORE_THEME']['header_style_text']));	
	} break;

	case "5": { // LOGO LONG + TEXT
	
		// LOGO
		$STRING .= '<div class="col-md-4 col-sm-6 col-xs-12" id="core_logo"><a href="'.get_home_url().'/" title="'.get_bloginfo('name').'">'.hook_logo(true).'</a></div>';
		$STRING .= '<div class="col-md-8 col-sm-6 col-xs-12">';
		$STRING .= hook_header_style5(stripslashes($GLOBALS['CORE_THEME']['header_style_text']));		 
		$STRING .= '</div></div>';	
	} break;

	case "4": { // LOGO LONG + SEARCH
	
		// LOGO
		$STRING .= '<div class="col-md-4 col-sm-6 col-xs-12" id="core_logo"><a href="'.get_home_url().'/" title="'.get_bloginfo('name').'">'.hook_logo(true).'</a></div>';
		$STRING .= '<div class="col-md-8 col-sm-6 col-xs-12">';
		$STRING .= hook_header_searchbox('<form action="'.get_home_url().'/" method="get" id="wlt_searchbox_form">
			<div class="wlt_searchbox clearfix">
				<div class="inner">
					<div class="wlt_button_search"><i class="glyphicon glyphicon-search"></i></div>
					<input type="search" name="s" placeholder="'.$CORE->_e(array('button','11','flag_noedit')).'">
				</div>');
				
			if(!isset($GLOBALS['CORE_THEME']['addthis']) || ( isset($GLOBALS['CORE_THEME']['addthis']) && $GLOBALS['CORE_THEME']['addthis']  == 1 ) ){
			$STRING .= '<div class="addthis_toolbox addthis_default_style hidden-xs pull-right">
			<a class="addthis_button_pinterest_share"></a>
			<a class="addthis_button_google"></a>
			<a class="addthis_button_facebook"></a>
			<a class="addthis_button_twitter"></a>		
			<a class="addthis_button_favorites"></a>					
			<a class="addthis_button_compact"></a>
			<a class="addthis_counter addthis_bubble_style"></a>
			</div>
			<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
			<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid='.$GLOBALS['CORE_THEME']['addthis_name'].'"></script>';
			}
		 
			$STRING .= '</div></form></div></div>';
	
	} break;
	case "2": { // LOGO MENU SPLIT
		
		// LOGO
		$STRING .= '<div class="col-md-4 col-sm-12" id="core_logo"><a href="'.get_home_url().'/" title="'.get_bloginfo('name').'">'.hook_logo(true).'</a></div>';
		$STRING .= '<div class="col-md-8 col-sm-12">
			<nav class="navbar hidden-xs" role="navigation"><div class="container-fluid">'.		  
			wp_nav_menu( array( 
				'container' => 'div',
				'container_class' => '',
				'theme_location' => 'primary',
				'menu_class' => 'nav navbar-nav',
				'fallback_cb'     => '',
				'echo'            => false,
				'walker' => new Bootstrap_Walker(),									
				) )	.							
		'</div></nav></div>'; 
		 
	} break;
	case "3": {	 // FULL HEADER IMAGE
		// LOGO
		$STRING .= hook_logo_wrapper('<div class="col-md-12" id="core_logo"><a href="'.get_home_url().'/" title="'.get_bloginfo('name').'">'.hook_logo(true).'</a></div>');	
	} break;
	
	default: {	// LOGO BANNER SPLIT
		// LOGO
		$STRING .= hook_logo_wrapper('<div class="col-md-5 col-sm-5" id="core_logo"><a href="'.get_home_url().'/" title="'.get_bloginfo('name').'">'.hook_logo(true).'</a></div>');
		// BANNER
		$STRING .= hook_banner_header_wrapper('<div class="col-md-7 col-sm-7 hidden-xs" id="core_banner">'.hook_banner_header($CORE->BANNER('header')).'</div>'); 	
	} break;
}
	
$STRING .= hook_header_row_bottom('').'</div></div>';

return hook_header_layout($STRING);
}
}

// THIS IS THE CORE MENU HOOK
if(!function_exists('_design_menu')){
function _design_menu(){ global $CORE; $STRING = "";

// LOAD IN USER STYLE
if(!isset($GLOBALS['CORE_THEME']['layout_menu'])){ $style = 3; }else{ $style = $GLOBALS['CORE_THEME']['layout_menu']; }


switch($style){

	case "1": { // NO MENU	
	
	} break;
	
	case "2":
	default: {
	
		// GET MENU CONTENT
		$MENUCONTENT = wp_nav_menu( array( 
					'container' => 'div',
					'container_class' => 'navbar-collapse',
					'theme_location' => 'primary',
					'menu_class' => 'nav navbar-nav',
					'fallback_cb'     => '',
					'echo'            => false,
					'walker' => new Bootstrap_Walker(),									
					) );
					
		// DISPLAY MENU
		if(strlen($MENUCONTENT) > 1){
		$GLOBALS['flasg_smalldevicemenubar'] = true;
		$STRING = '<!-- [WLT] FRAMRWORK // MENU -->
				
		<div class="container" id="core_smallmenu"><div class="row">
			<div id="wlt_smalldevicemenubar">
			<a href="#" class="b1" data-toggle="collapse" data-target=".wlt_smalldevicemenu">'.$CORE->_e(array('mobile','4')).' <span class="glyphicon glyphicon-chevron-down"></span></a>
			 '.wp_nav_menu( array( 
			'container' => 'div',
			'container_class' => 'wlt_smalldevicemenu collapse',
			'theme_location' => 'primary',
			'menu_class' => '',
			'fallback_cb'     => '',
			'echo'            => false,
			'walker' => new Bootstrap_Walker(),									
			) ).'       
			</div>
		</div></div>
		
		
		<div id="core_menu_wrapper"><div class="'.$CORE->CSS("container", true).'"><div class="row"><nav class="navbar" role="navigation">';
		unset($GLOBALS['flasg_smalldevicemenubar']);
		
		// STYLE 2
		if($style == "2"){ 	  
			$STRING .= hook_menu_searchbox('<form action="'.get_home_url().'/" method="get" id="wlt_searchbox_form" class="hidden-sm hidden-xs">
			<div class="wlt_searchbox">
			
			<div class="input-group" style="max-width:300px;">
<input type="search" name="s" placeholder="'.$CORE->_e(array('button','11','flag_noedit')).'">
<div class="wlt_button_search"><i class="glyphicon glyphicon-search"></i></div>
   
</div>

 
			
		 
				
			</div>
			</form>');
		}
					
		$STRING .= $MENUCONTENT .'</nav></div></div></div>';
		
		}
	
	
	} break;

} // end switch 
	
			
return $STRING;

}
}

// THIS IS THE CORE BREADCRUMBS HOOK
if(!function_exists('_design_breadcrumbs')){
function _design_breadcrumbs(){ global $CORE, $userdata;  $showBreadcrumbs = true;
	

	if(!isset($GLOBALS['flag-home']) && $GLOBALS['CORE_THEME']['breadcrumbs_inner'] != '1'){
	$showBreadcrumbs = false;
	}elseif(isset($GLOBALS['flag-home']) && $GLOBALS['CORE_THEME']['breadcrumbs_home'] != '1'){
	$showBreadcrumbs = false;
	}
 	
	if( $showBreadcrumbs ){ 	
	$STRING = '<!-- FRAMRWORK // BREADCRUMBS --> 
	 
	<div id="core_main_breadcrumbs_wrapper" class="clearfix"><div class="col-md-12"><div class="breadcrumb_wrapper_inner clearfix">	
	 
	<div class="breadcrumb" id="core_main_breadcrumbs_left">  
	        
            '.hook_breadcrumbs_func($CORE->BREADCRUMBS('<li>','</li>')).'
    </div>	
	 
	
	<div class="pull-right btn-group btn-breadcrumb" id="core_main_breadcrumbs_right">';
 	
		if(isset($GLOBALS['CORE_THEME']['geolocation']) && $GLOBALS['CORE_THEME']['geolocation'] == "2"){
		
			if( isset($GLOBALS['CORE_THEME']['geolocation']) && $GLOBALS['CORE_THEME']['geolocation'] != "" ){
				
				if(isset($_SESSION['mylocation'])){
				$country = $_SESSION['mylocation']['country'];
				$addresss = $_SESSION['mylocation']['address'];
				}else{
				$address = "";
				$country = $GLOBALS['CORE_THEME']['geolocation_flag'];
				}
			}
		
		$STRING .= '<a class="wlt_mylocation" href="javascript:void(0);" onclick="GMApMyLocation();" data-toggle="modal" data-target="#MyLocationModal"><div class="flag flag-'.strtolower($country).' wlt_locationflag"></div> '.$CORE->_e(array('widgets','8')).'</a>';
		
		}
		
		$STRING .= _account_options(false);

	$STRING .= '</div></div></div></div>';	
 	return $STRING;
	}
}
function _account_options($isTop){ global $CORE, $userdata; $STRING = ""; $canShowBar = true; 

if($isTop){	 
	$linkclass = "";
	$b_f = "<li>"; $b_a = "</li>";
}else{
	if($GLOBALS['CORE_THEME']['header_accountdetails'] == 1 || $GLOBALS['CORE_THEME']['breadcrumbs_userlinks'] != 1 ){ $canShowBar = false; }
	$linkclass = "";
	$b_f = "<li>"; $b_a = "</li>";
	if(defined('WLT_DEMOMODE') && $GLOBALS['CORE_THEME']['header_accountdetails'] != 1){
		$canShowBar = true;
	}
}


if(!$isTop && ( isset($GLOBALS['CORE_THEME']['breadcrumbs_social']) && $GLOBALS['CORE_THEME']['breadcrumbs_social'] == 1) || (isset($GLOBALS['CORE_THEME']['breadcrumbs_addlisting']) && $GLOBALS['CORE_THEME']['breadcrumbs_addlisting'] == 1) ){    

$STRING .= "<ul class='socialicons1 list-inline pull-right hidden-xs'>";


// ADD LISTING BUTTON
if(!$isTop && isset($GLOBALS['CORE_THEME']['breadcrumbs_addlisting']) && $GLOBALS['CORE_THEME']['breadcrumbs_addlisting'] == 1){
	
		$STRING .= $b_f.'<a href="'.$GLOBALS['CORE_THEME']['links']['add'].'" class="btn btn-warning addlistingbtn" style="border-radius:0px;">'.$CORE->_e(array('button','30')).'</a>'.$b_a;	
}

// SOCIAL ICONS
if(!$isTop && isset($GLOBALS['CORE_THEME']['social']) && isset($GLOBALS['CORE_THEME']['breadcrumbs_social']) && $GLOBALS['CORE_THEME']['breadcrumbs_social'] == 1){               
         
		 
		 
		 	   
		if(strlen($GLOBALS['CORE_THEME']['social']['twitter']) > 1 && strlen($GLOBALS['CORE_THEME']['social']['twitter_icon']) > 1){ 
						$STRING .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['twitter']."' class='btn btn-default twitter' rel='nofollow'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['twitter_icon']."'></i>
						</a></li>"; 
		} 
        if(strlen($GLOBALS['CORE_THEME']['social']['dribbble']) > 1 && strlen($GLOBALS['CORE_THEME']['social']['dribbble_icon']) > 1){ 
						$STRING .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['dribbble']."' class='btn btn-default dribbble' rel='nofollow'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['dribbble_icon']."'></i>
						</a></li>";
		} 
        if(strlen($GLOBALS['CORE_THEME']['social']['facebook']) > 1 && strlen($GLOBALS['CORE_THEME']['social']['facebook_icon']) > 1){ 
						$STRING .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['facebook']."' class='btn btn-default facebook' rel='nofollow'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['facebook_icon']."'></i>
						</a></li>";
		} 
        if(strlen($GLOBALS['CORE_THEME']['social']['linkedin']) > 1 && strlen($GLOBALS['CORE_THEME']['social']['linkedin_icon']) > 1){ 
						$STRING .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['linkedin']."' class='btn btn-default linkedin' rel='nofollow'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['linkedin_icon']."'></i>
						</a></li>";
		} 
        if(strlen($GLOBALS['CORE_THEME']['social']['youtube']) > 1 && strlen($GLOBALS['CORE_THEME']['social']['youtube_icon']) > 1){ 
						$STRING .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['youtube']."' class='btn btn-default youtube' rel='nofollow'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['youtube_icon']."'></i>
						</a></li>";
		} 
        if(strlen($GLOBALS['CORE_THEME']['social']['rss']) > 1 && strlen($GLOBALS['CORE_THEME']['social']['rss_icon']) > 1){ 
						$STRING .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['rss']."' class='btn btn-default rss' rel='nofollow'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['rss_icon']."'></i>
						</a></li>";
		}    
		                 				   
}

$STRING .= "</ul>"; 

}


if( $canShowBar ){
	
	if(!$isTop){ $STRING .= "<div class='breadcrumb'>"; }

	$STRING .=  _accout_links();
			
	if(!$isTop){ $STRING .= "</div>"; }
}
 
		
return $STRING;
}

function _accout_links($b_f ='<li>', $b_a = '</li>'){ global $userdata, $CORE;

$STRING = "";

			if(isset($userdata) && $userdata->ID){
			 
				if(isset($GLOBALS['CORE_THEME']['links'])){				
				 
				// my account
				$STRING .= $b_f.'<a href="'.$GLOBALS['CORE_THEME']['links']['myaccount'].'" class="ua1 '.$linkclass.'">'.$CORE->_e(array('head','4')).'</a>'.$b_a;
				 		 	
				// notifications
				$NOTIFICATION_COUNT = $CORE->MESSAGECOUNT($userdata->user_login);
				if($NOTIFICATION_COUNT > 0){							
				$STRING .= $b_f.'<a href="'.$GLOBALS['CORE_THEME']['links']['myaccount'].'?notify=1" class="ua2 '.$linkclass.'">'.$CORE->_e(array('head','8')).' ('.$NOTIFICATION_COUNT.')</span></a>'.$b_a;
				}
				
				// favorites
				if($GLOBALS['CORE_THEME']['show_account_favs'] == '1'){
			 
						 
				$STRING .= $b_f.'<a href="'.home_url().'/?s=&amp;favs=1" class="hidden-sm hidden-xs ua3 '.$linkclass.'">'.$CORE->_e(array('account','46')).' ('.$CORE->FAVSCOUNT().')</a>'.$b_a;
				}
				
				// logout
				$STRING .= $b_f.'<a href="'.wp_logout_url().'" class="hidden-sm hidden-xs ua4 '.$linkclass.'">'.$CORE->_e(array('account','8')).'</a>'.$b_a;
							
				
				}
			}else{
				
				//login
				$STRING .= $b_f.'<a href="'.get_home_url().'/wp-login.php" class="ua5 '.$linkclass.'">'.$CORE->_e(array('head','5','flag_link')).'</a>'.$b_a;
				
				// register
				$STRING .= $b_f.'<a href="'.get_home_url().'/wp-login.php?action=register" class="ua6 '.$linkclass.'">'.$CORE->_e(array('head','6','flag_link')).'</a>'.$b_a; 
				       
			}// end if
return $STRING;

}

// THIS IS THE CORE TOP MENU FUNCTION
function _design_topmenu(){ global $CORE; $mylocatopntop = "";

	$topmenu = wp_nav_menu( array( 
            'container' => 'div',
            'container_class' => '',
            'theme_location' => 'top-navbar',
            'menu_class' => 'nav nav-pills',
			'fallback_cb'     => '',
			'echo'            => false,
            'walker' => new Bootstrap_Walker(),									
            ) );
			
 
	if(!defined('WLT_CART') && isset($GLOBALS['CORE_THEME']['geolocation']) && $GLOBALS['CORE_THEME']['geolocation'] == "1" ){
				
			if(isset($_SESSION['mylocation'])){
				$country = $_SESSION['mylocation']['country'];
				$addresss = $_SESSION['mylocation']['address'];
			}else{
				$address = "";
				$country = $GLOBALS['CORE_THEME']['geolocation_flag'];
			}
	
			$mylocatopntop = '<li class="MyLocationLi"> 
			
			<a href="javascript:void(0);" onclick="GMApMyLocation();" data-toggle="modal" data-target="#MyLocationModal"><div class="flag flag-'.strtolower($country).' wlt_locationflag"></div> '.$CORE->_e(array('widgets','8')).'</a> </li>';
			
			// ATTACH IT TO THE TOP MENU
			if($topmenu == ""){
			
				$topmenu = "<ul class='nav nav-pills'>".$mylocatopntop."</ul>";
			
			}else{
			
				$topmenu = str_replace('class="nav nav-pills">','class="nav nav-pills">'.$mylocatopntop,$topmenu);
			
			}
		}

	// ONLY SHOW IF WE'VE CREATED ONE	
	if(strlen($topmenu) > 0 ||  defined('WLT_CART') ){ 
 
 
	$topmenustring = '<div id="core_header_navigation" class="hidden-xs">
	<div class="'.$CORE->CSS("container", true).'">
			
	<div class="row"> 	';
	
	if(isset($GLOBALS['CORE_THEME']['header_accountdetails']) && $GLOBALS['CORE_THEME']['header_accountdetails'] == 1){
	
	$topmenustring .= '<ul class="nav nav-pills pull-right accountdetails">'._account_options(true).'</ul>';
	
	}else{
	
	$topmenustring .= '<span class="welcometext pull-right">'.hook_welcometext(stripslashes($GLOBALS['CORE_THEME']['header_welcometext'])).'</span>';
	
	}
			 
	$topmenustring .= '<div class="navbar-inner">'.$topmenu.'</div>
	
	</div>
	
	</div></div>';
 		
			return hook_header_navbar($topmenustring);	
	}	

} 
}
/* =============================================================================
	 MOBILE MENU DISPLSAY
	========================================================================== */
if(!function_exists('_design_mobilemenu')){
function _design_mobilemenu($type="inner"){ global $wpdb, $CORE; $STRING = "";  


	if(defined('IS_MOBILEVIEW')){
		return;	
	}

if(isset($GLOBALS['CORE_THEME']['responsive']) && $GLOBALS['CORE_THEME']['responsive'] == '1'){
	
 
	// GET MENU DATA
	$locations = get_nav_menu_locations();
	$menu_name = 'mobile-menu';		
	if ( ( $locations ) && isset( $locations[ $menu_name ] ) && $locations[ $menu_name ] != 0 ) {
	
	// BUTTONS
	$STRING .= '<nav class="navbar navbar-inverse navbar-fixed-top"  role="navigation" id="core_mobile_menu"> <div class="container-fluid">';
	
	if(defined('WLT_CART')){
	global $CORE_CART;
	$cart_data = $CORE_CART->GETCART(true); 
	}
		
		// ADD CSS
		
		$STRING .= '<style type="text/css" scoped> @media (min-width: 0px) and (max-width: 400px) { html {margin-top: 0px !important;}  		body { padding:0px !important; margin-top:50px !important; } }</style>';
	
		// GET ASSIGNED MENU ID
		$nav_menu = wp_get_nav_menu_object($locations['mobile-menu']);
		
		// START HEADER
		$STRING .= '<div class="navbar-header">
						
						  <button type="button" class="navbar-toggle menubtntop" data-toggle="collapse" data-target=".mmenu2">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						  </button>';
						  
		if($GLOBALS['CORE_THEME']['mobileview']['search'] == '1'){ 				 
			// SEARCH BUTTON
			$STRING .= '<button type="button" class="navbar-toggle searchbtntop" data-toggle="collapse" data-target=".mmenu1">
							<span class="sr-only">Toggle Search</span>
							<span class="glyphicon glyphicon-search"></span>
						  </button>';
		}
		
		// CART BUTTONS
		if(defined('WLT_CART')){
		$STRING .= '<script> 		 
		jQuery(document).ready(function(){
			if (jQuery(window).width() < 400) {
				jQuery("#wlt_cart_qty1").attr("id","wlt_cart_qty"); 
			}
		});
		jQuery(window).resize(function(){
			if (jQuery(window).width() < 400) {
				jQuery("#wlt_cart_qty1").attr("id","wlt_cart_qty"); 
			}	
		});		
		</script>';
				
		$STRING .= '<button type="button" class="navbar-toggle cartbtntop" data-toggle="collapse" data-target=".mmenu3">
							<span class="sr-only">Toggle Cart</span>
							<span class="glyphicon glyphicon-shopping-cart"></span>
							<span class="badge">'.hook_price('<i id="wlt_cart_total">'.$cart_data['total'].'</i>').'</span>
							 <span id="wlt_cart_qty1">'.$cart_data['qty'].'</span>							
						  </button>';
		}
		 
		 
		
						  
		// END BUTTONS			  
		$STRING .= '<a class="navbar-brand" href="'.get_home_url().'/">'.$CORE->_e(array('head','1')).'</a>
		
		</div>'; // END HEADER BUTTONS
		
		
						
		// ADD-ON FOR MOBILE SEARCH TOOL 
		if($GLOBALS['CORE_THEME']['mobileview']['search'] == '1'){ 				 
			 // WRAPPER  
			$STRING .= '<div class="collapse navbar-collapse  mmenu1">';
				if($GLOBALS['CORE_THEME']['mobileview']['adsearch'] == '1'){ 
					$STRING .= '<div class="padding">'.core_search_form(null,'mobile_advanced_search').'</div>';
				}else{
					$STRING .= '
					<div class="padding">
					<form  action="'.get_home_url().'/" method="get" style="margin-left:10px;">
						<input class="form-control" type="text" name="s" id="s">
						<button class="btn btn-default" type="submit">'.$CORE->_e(array('button','11')).'</button>
					</form>
					</div>';
				}
			// END WRAPPER
			$STRING .= '</div>';
		}
		
		if(defined('WLT_CART')){
		// ADD-ON CART MENU
		$STRING .= '<div class="collapse navbar-collapse mmenu3"><ul class="nav navbar-nav">';		
		if(isset($cart_data['items']) && is_array($cart_data['items'])){
		
			foreach($cart_data['items'] as $key=>$item){
				foreach($item as $mainitem){
				$STRING .= '<li>
				<a href="'.$mainitem['link'].'">'.str_replace("","",strip_tags($mainitem['image'], '<img>')).' '.$mainitem['name'].' 
				<div class="extrainfo badge right"><span class="pricetag">'.hook_price($mainitem['amount']).'</span> <span class="customtag">'.$mainitem['custom'].'&nbsp;<span> <div class="clearfix"></div></div></a>
				</li>';
				}
			}		
			$STRING .= '<li class="checkoutnow"><a href="'.$GLOBALS['CORE_THEME']['links']['checkout'].'"><span class="glyphicon glyphicon-shopping-cart"></span> '.$CORE->_e(array('checkout','14')).'</a></li>';
		}else{
			$STRING .= '<li class="emptybasket">'.$CORE->_e(array('checkout','46')).'</li>';
		}				
		$STRING .= '</ul></div>';
		}
		

		// ADD-ON NORMAL MENU
		$STRING .=  '<div class="collapse navbar-collapse mmenu2">'.wp_nav_menu( array( 
				'container' => '',
				'container_class' => '',
				'menu' => $nav_menu->term_id,
				'menu_class' => 'nav navbar-nav',
				'fallback_cb'     => '',
				'echo'            => false,
				'walker' => new Bootstrap_Walker(),									
				) ).'
				</div>';
	 
	// END WRAPPER
	$STRING .= '</div></nav>';  
	 
	} // has menu
	
}// is responsive

return $STRING; 

}
}

// THIS IS THE CORE HEADER HOOK
if(!function_exists('_design_footer')){
function _design_footer(){ global $CORE; 


	// LOAD IN CHILD THEME TEMPATE FILES
	if(defined('CHILD_THEME_NAME') && file_exists(WP_CONTENT_DIR."/themes/".CHILD_THEME_NAME."/_footer.php") ){
	
		include(WP_CONTENT_DIR."/themes/".CHILD_THEME_NAME."/_footer.php");
		
	}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/templates/".$GLOBALS['CORE_THEME']['template']."/_footer.php") ){
		
		include(str_replace("functions/","",THEME_PATH)."/templates/".$GLOBALS['CORE_THEME']['template'].'/_footer.php');
 		
	}else{
	

if(!isset($GLOBALS['CORE_THEME']['layout_columns']['footer'])){ $footerwidths = 0; }else{ $footerwidths = $GLOBALS['CORE_THEME']['layout_columns']['footer']; }
switch($footerwidths){
	case "1": {
	$col1 = "col-md-8";
	$col2 = "col-md-4";
	$col3 = "hide";		
	} break;
	case "2": {
	$col1 = "col-md-4";
	$col2 = "col-md-8";
	$col3 = "hide";		
	} break;
	case "3": {
	$col1 = "col-md-12";
	$col2 = "hide";
	$col3 = "hide";		
	} break;
	default: {	
	$col1 = "col-md-4";
	$col2 = "col-md-4";
	$col3 = "col-md-4";
	} break;
}// end switcj

?>
<!-- [WLT] FRAMRWORK // FOOTER -->

<p id="back-top"> <a href="#top"><span></span></a> </p>

<footer id="core_footer_wrapper" class="footer">

    <div class="<?php $CORE->CSS("container"); ?>" id="footer_content">
    
        <div class="row">
            
                <div class="<?php echo $col1; ?>"><?php dynamic_sidebar('Footer Left'); ?></div>
                
                <div class="<?php echo $col2; ?> hidden-xs"><?php dynamic_sidebar('Footer Middle'); ?></div>
                
                <div class="<?php echo $col3; ?> hidden-xs"><?php dynamic_sidebar('Footer Right'); ?></div>
            
                <div class="clearfix"></div>
            
        </div>
            
    </div>

	<div id="footer_bottom" class="clearfix">

		<div class="<?php $CORE->CSS("container"); ?>">
        
        	<div class="row">
      
                <?php echo stripslashes($GLOBALS['CORE_THEME']['copyright']); ?>                
              
                <?php
                $si = ""; $sb = "";
                if(isset($GLOBALS['CORE_THEME']['social'])){
                $si = "<ul class='socialicons list-inline pull-right'>";
                    
                        if(strlen($GLOBALS['CORE_THEME']['social']['twitter']) > 1){ 
						$sb .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['twitter']."' class='twitter' rel='nofollow' target='_blank'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['twitter_icon']."'></i>
						</a></li>"; } 
                        if(strlen($GLOBALS['CORE_THEME']['social']['dribbble']) > 1){ 
						$sb .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['dribbble']."' class='dribbble' rel='nofollow' target='_blank'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['dribbble_icon']."'></i>
						</a></li>"; } 
                        if(strlen($GLOBALS['CORE_THEME']['social']['facebook']) > 1){ 
						$sb .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['facebook']."' class='facebook' rel='nofollow' target='_blank'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['facebook_icon']."'></i>
						</a></li>"; } 
                        if(strlen($GLOBALS['CORE_THEME']['social']['linkedin']) > 1){ 
						$sb .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['linkedin']."' class='linkedin' rel='nofollow' target='_blank'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['linkedin_icon']."'></i>
						</a></li>"; } 
                        if(strlen($GLOBALS['CORE_THEME']['social']['youtube']) > 1){ 
						$sb .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['youtube']."' class='youtube' rel='nofollow' target='_blank'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['youtube_icon']."'></i>
						</a></li>"; } 
                        if(strlen($GLOBALS['CORE_THEME']['social']['rss']) > 1){ 
						$sb .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['rss']."' class='rss' rel='nofollow' target='_blank'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['rss_icon']."'></i>
						</a></li>"; } 
                        
                $si .= $sb."</ul>";
                if($sb == ""){ $si = ""; }
                }
                echo hook_footer_socialicons($si);
                ?>
                
           </div>
    
	</div>
        
</div>

</footer>
<div id="freeow" class="freeow freeow-top-right"></div>
<?php } }
}


if(!function_exists('DEFAULTLISTINGPAGE1')){
function DEFAULTLISTINGPAGE1(){ global $post, $CORE; $STRING = "";

// CAN WE DISPLAY THE GOOGLE MAP BOX ?
if( get_post_meta($post->ID,'showgooglemap',true) == "yes"){
	$my_long  			= get_post_meta($post->ID,'map-log',true);
	$my_lat  			= get_post_meta($post->ID,'map-lat',true);
	$GOOGLEMAPADDRESS 	= 'https://www.google.com/maps/dir/'.str_replace(",","",str_replace(" ","+",get_post_meta($post->ID,'map_location',true)))."/".$my_lat.",".trim($my_long);
}

$STRING .= '<div class="panel panel-default" id="DEFAULTLISTINGPAGE1">
<div class="panel-body">
 
<h1>[TITLE]</h1>

<ol class="breadcrumb">
  <li>[FAVS]</li>
  
  <li  class="pull-right">[RATING results=1]</li>
 
  <li class="pull-right hidden-xs"><i class="fa fa-area-chart"></i> [hits] views</li>
  <li class="pull-right hidden-xs">#[ID]</li>
  
</ol>

<small>[DATE]</small>

<div  class="pull-right">[SOCIAL]</div>

</div>  

 
<div class="col-md-6">
	[IMAGES]
</div>
<div class="col-md-6"> 
	[EXCERPT] 
	
	[FIELDS smalllist=1]
	
	[THEMEEXTRA]
 	 
	<div class="clearfix"></div>	
</div>

<div class="clearfix"></div> 



<div class="board">
	<div class="board-inner">
    
	<ul class="nav nav-tabs" id="Tabs">
    
	<div class="liner"></div>
					
    <li class="active"><a href="#home" data-toggle="tab" title="'.$CORE->_e(array('single','34')).'"><span class="round-tabs one"><i class="fa fa-file-text-o"></i></span></a></li>

    <li><a href="#t4" data-toggle="tab" title="'.$CORE->_e(array('single','37')).'"> <span class="round-tabs two"><i class="fa fa-comments-o"></i></span> </a></li>
				  
    <li><a href="#messages" data-toggle="tab" title="'.$CORE->_e(array('single','16')).'"><span class="round-tabs three"><i class="fa fa-bars"></i></span> </a></li>

    <li><a href="#settings" data-toggle="tab" title="'.$CORE->_e(array('single','36')).'"><span class="round-tabs four"><i class="glyphicon glyphicon-comment"></i></span></a></li>';
	
	if(isset($GOOGLEMAPADDRESS)){
	$STRING .='<li><a href="#doner" data-toggle="tab" title="'.$CORE->_e(array('button','52')).'" id="GoogleMapTab"><span class="round-tabs five"><i class="fa fa-map-marker"></i></span></a></li>';
   }
   
    $STRING .= '</ul></div>

	<div class="tab-content">
    
	<div class="tab-pane fade in active" id="home"> [THEMEEXTRA1] [CONTENT]</div>
    
	<div class="tab-pane fade" id="t4">[COMMENTS tab=0]</div>
    
	<div class="tab-pane fade" id="messages"><div class="well"><h3>'.$CORE->_e(array('single','16')).'</h3> <hr /> [FIELDS] </div> </div>
    
	<div class="tab-pane fade" id="settings">[CONTACT style="2"]</div>';
    
	if(isset($GOOGLEMAPADDRESS)){
	$STRING .= '<div class="tab-pane fade" id="doner">
	
		<div class="well">
		<a href="'.$GOOGLEMAPADDRESS.'" target="_blank" class="btn btn-default pull-right">
		'.$CORE->_e(array('button','56')).'</a>
		<h3>'.$CORE->_e(array('add','67')).'</h3>
		<hr />
		[GOOGLEMAP]	
		</div>
		<script>		
		jQuery( "#GoogleMapTab" ).click(function() {
		setTimeout(function () {google.maps.event.trigger(map, "resize"); }, 200);
		});
		</script>
	</div>';
	}else{
	$STRING .= '<style>.board .nav-tabs > li {width: 25%;}</style>';
	}
	
	$STRING .='<div class="clearfix"></div>
	
	</div>
</div></div>

<script>
jQuery(function(){jQuery(\'a[title]\').tooltip();});
</script>'; 

return $STRING;
}
}

if(!function_exists('DEFAULTLISTINGPAGE2')){
function DEFAULTLISTINGPAGE2(){ global $post, $CORE; $STRING = "";

// CAN WE DISPLAY THE GOOGLE MAP BOX ?
if( get_post_meta($post->ID,'showgooglemap',true) == "yes"){
	$my_long  			= get_post_meta($post->ID,'map-log',true);
	$my_lat  			= get_post_meta($post->ID,'map-lat',true);
	$GOOGLEMAPADDRESS 	= 'https://www.google.com/maps/dir/'.str_replace(",","",str_replace(" ","+",get_post_meta($post->ID,'map_location',true)))."/".$my_lat.",".trim($my_long);
}

$STRING .= '<div class="panel panel-default" id="DEFAULTLISTINGPAGE2">
<div class="panel-body">
 
<h1>[TITLE]</h1>

<ol class="breadcrumb">
  <li>[FAVS]</li>
  
  <li  class="pull-right">[RATING results=1]</li>
 
  <li class="pull-right hidden-xs"><i class="fa fa-area-chart"></i> [hits] views</li>
  <li class="pull-right hidden-xs">#[ID]</li>
  
</ol>

<small>[DATE]</small>

<div  class="pull-right">[SOCIAL]</div>

[IMAGES]

</div> 
 
[THEMEEXTRA]

<div class="clearfix"></div> 

<div class="board">
	<div class="board-inner">
    
	<ul class="nav nav-tabs" id="Tabs">
    
	<div class="liner"></div>
					
    <li class="active"><a href="#home" data-toggle="tab" title="'.$CORE->_e(array('single','34')).'"><span class="round-tabs one"><i class="fa fa-file-text-o"></i></span></a></li>

    <li><a href="#t4" data-toggle="tab" title="'.$CORE->_e(array('single','37')).'"> <span class="round-tabs two"><i class="fa fa-comments-o"></i></span> </a></li>
				  
    <li><a href="#messages" data-toggle="tab" title="'.$CORE->_e(array('single','16')).'"><span class="round-tabs three"><i class="fa fa-bars"></i></span> </a></li>

    <li><a href="#settings" data-toggle="tab" title="'.$CORE->_e(array('single','36')).'"><span class="round-tabs four"><i class="glyphicon glyphicon-comment"></i></span></a></li>';
	
	if(isset($GOOGLEMAPADDRESS)){
	$STRING .='<li><a href="#doner" data-toggle="tab" title="'.$CORE->_e(array('button','52')).'" id="GoogleMapTab"><span class="round-tabs five"><i class="fa fa-map-marker"></i></span></a></li>';
   }
   
    $STRING .= '</ul></div>

	<div class="tab-content">
    
	<div class="tab-pane fade in active" id="home">[THEMEEXTRA1] [CONTENT]</div>
    
	<div class="tab-pane fade" id="t4">[COMMENTS tab=0]</div>
    
	<div class="tab-pane fade" id="messages"><div class="well"><h3>'.$CORE->_e(array('single','16')).'</h3> <hr /> [FIELDS] </div> </div>
    
	<div class="tab-pane fade" id="settings">[CONTACT style="2"]</div>';
    
	if(isset($GOOGLEMAPADDRESS)){
	$STRING .= '<div class="tab-pane fade" id="doner">
	
		<div class="well">
		<a href="'.$GOOGLEMAPADDRESS.'" target="_blank" class="btn btn-default pull-right">
		'.$CORE->_e(array('button','56')).'</a>
		<h3>'.$CORE->_e(array('add','67')).'</h3>
		<hr />
		[GOOGLEMAP]	
		</div>
		<script>		
		jQuery( "#GoogleMapTab" ).click(function() {
		setTimeout(function () {google.maps.event.trigger(map, "resize"); }, 200);
		});
		</script>
	</div>';
	}else{
	$STRING .= '<style>.board .nav-tabs > li {width: 25%;}</style>';
	}
	
	$STRING .='<div class="clearfix"></div>
	
	</div>
</div></div>

<script>
jQuery(function(){jQuery(\'a[title]\').tooltip();});
</script>'; 

return $STRING;
}
}

?>
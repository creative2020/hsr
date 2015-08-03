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

global $CORE;
/*
$GLOBALS['object_name']
$GLOBALS['object_data']
$GLOBALS['object_id']
*/

// GET THE CORE OBJECT OPTIONS				
if($GLOBALS['object_data']['fullw'] == "yes"){ $spansize = "col-md-3 col-sm-3"; $stopcount = 4; }else{ $spansize= "col-md-4 col-sm-4"; $stopcount = 3;  }
$ranid 		= rand();
$taxonomy 	= $GLOBALS['object_data']['tax'];
$tttile 	= $GLOBALS['object_data']['title']; 
$arrows 	= $GLOBALS['object_data']['arrows'];
$query 		= $GLOBALS['object_data']['query'];	
$perrow 	= $GLOBALS['object_data']['perrow'];

// RUN QUERY FIRST
$i=1; $aset = "active";
if(isset($taxonomy) && $taxonomy != ""){		
		
	$terms = get_terms($taxonomy, 'orderby=count&hide_empty=0&number=50'); 
	
}else{

	$the_query = new WP_Query(hook_custom_queries('post_type='.THEME_TAXONOMY.'_type&'.$query."&posts_per_page=100")); 		
	if(count($the_query->posts) < 1 ){
		return;
	}	
	
}
 		
				
// START WRAPPER
echo "<div class='wlt_carsousel_main_wrapper'><div class='panel panel-default carousel_block'>";
				
		// ADD-ON ARROWS
			if( $arrows == "top" && strlen($tttile) != ""){
			echo '<a class="carousel-control1 right1" href="#wlt_carsousel_'.$ranid.'" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
			<a class="carousel-control1 left1" href="#wlt_carsousel_'.$ranid.'" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>';		 
			}
							
			// ADD-ON TITLE
			if(strlen($tttile) > 1){				
				echo '<div class="panel-heading">'.$tttile.'</div><div class="panel-body">';					
			}elseif($GLOBALS['object_data']['fullw'] == "yes"){			
					echo '<div class="carousel_block">';
					
			}else{
					echo '<div class="carousel_block">';
					
			} 	
			
			switch($perrow){
				case "2": { $spansize= "col-md-6 col-sm-6"; $stopcount = 2; } break;
				case "3": { $spansize= "col-md-4 col-sm-4"; $stopcount = 3; } break;
				case "5": { $spansize= "col-md-new5 col-sm-new5"; $stopcount = 5; } break;
				case "6": { $spansize= "col-md-2 col-sm-2"; $stopcount = 6; } break;
				default: { $spansize= "col-md-3 col-sm-3"; $stopcount = 4; }
			
			}	
			
			
			
			
			// START INNER WRAPPER
			echo '<div id="wlt_carsousel_'.$ranid.'" class="carousel slide '.$taxonomy.'_carouselblock" data-ride="carousel"><div class="carousel-inner">';
				
			if( $arrows == "top" && strlen($tttile) == ""){
					echo '<a class="carousel-control1 right1" href="#wlt_carsousel_'.$ranid.'" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
					<a class="carousel-control1 left1" href="#wlt_carsousel_'.$ranid.'" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a><div class="clearfix"></div>';		 
			}
		  
				
			// TAXONOMY SEARCH WITH ICON ONLY
			if(isset($taxonomy) && $taxonomy != ""){				
					 
				 
					 $count = count($terms);
					 
					 if ( $count > 0 ){
						 
						 foreach ( $terms as $term ) {
						 
							if($i == 1){ echo '<div class="item '.$aset.'"><div class="wlt_search_results row grid_style">'; $aset = ""; }
							if($i == $stopcount){ $ac =" lastitem"; }else{$ac =""; }
							
							$IMG_PATH = $core_admin_values['category_icon_'.$term->term_id];
							$LINK = get_term_link($term->slug, $taxonomy);
							 
							if($IMG_PATH != ""){
								$img = '<a href="'.$LINK.'" class="frame">
								<img src="'.$IMG_PATH.'" alt="' . $term->name . '" class="wlt_thumbnail" width="183" height="110"><div class="clearfix"></div></a>';
							}else{
								$img = $CORE->FALLBACK_IMAGE();
							} 
							
							if(is_string($term->name)){
							echo '<div class="'.$spansize.$ac.'">'.$img.'<a href="'.$LINK.'">' . $term->name . '</a></div>';
							}
						   
							$set=false;
							if($i == $stopcount){ echo '</div></div>'; $i=0; $set=true; }
							
						   $i++; 	
						 }// end foreach
						 
					 }							
				
			}else{ // not taxonomy					 
			
						
					foreach($the_query->posts as $post){	
						
							if($i == 1){ echo '<div class="item '.$aset.'"><div class="wlt_search_results row grid_style">'; $aset = ""; $hp = ""; }else { $hp = " hidden-xs"; } 

								// CONTENT LISTING 
								$GLOBALS['item_class_size'] = $spansize.$hp;
								get_template_part( 'content', hook_content_templatename($post->post_type) );
						 	
								$set=false;
							
								if($i == $stopcount){ echo '</div></div>'; $i=0; $set=true; }
								
								$i++;
					} // end foreach	
						
					echo '</div>';					
					
					wp_reset_postdata(); 
						 
			 	}// end if	
				
				if(!$set){ echo '</div></div>'; }	
				
				// ADD-ON LEFT RIGHT CONTROLS
				if($arrows == "" || $arrows == "default"){
					echo '<!-- Controls -->
					  <a class="left carousel-control" href="#wlt_carsousel_'.$ranid.'" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left"></span>
					  </a>
					  <a class="right carousel-control" href="#wlt_carsousel_'.$ranid.'" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right"></span>
					  </a> ';
				 }
				
								 
			if(strlen($tttile) > 1){
				echo '</div>';
				}
							
				echo '</div></div></div>'; // end wrapper
				
				// ADD IN CODE FOR AUTO SLIDE
if(isset($the_query) && count($the_query->posts) > 0 ){
	
	echo "<script>jQuery(document).ready(function() {	
				 jQuery('#wlt_carsousel_".$ranid."').carousel({	interval: 7501,		pause: 'hover'	});			 
	});</script>";
}		 
?>
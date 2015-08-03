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


/* check which width we should show at */
$stoplimit = 4; 
			 
if($GLOBALS['object_data']['fullw'] == "yes"){ $spansize= "col-md-3"; $extra1 = "fullwidthblock"; }else{ $spansize= "col-md-3"; $extra1 = ""; }
if($GLOBALS['object_data']['image'] == "yes"){ $showimage = "yes"; }else{ $showimage= "no"; }
if(!is_numeric($GLOBALS['object_data']['pcats'])){ $showpcats = "100"; }else{ $showpcats = $GLOBALS['object_data']['pcats']; }
	
if($GLOBALS['object_data']['catcount'] == "yes"){ $catcount = "yes"; }else{ $catcount = "no"; }
if($GLOBALS['object_data']['subcatcount'] == "yes"){ $subcatcount = "yes"; }else{ $subcatcount = "no"; }
if($GLOBALS['object_data']['btnview'] == "yes"){ $btnview = "yes"; }else{ $btnview = "no"; }
if($GLOBALS['object_data']['subcatempty'] == "yes"){ $subcatempty = "yes"; }else{ $subcatempty = "no"; }
if($GLOBALS['object_data']['iconsize'] == "yes"){ $smallicon = "yes"; }else{ $smallicon = "no"; }
$subcats = $GLOBALS['object_data']['subcats']; if($subcats == ""){ $subcats = 3; }else{ $subcats = $subcats-1; }
if($GLOBALS['object_data']['image'] == "yes-side"){ $showimage= "yes-side"; $spansize = "col-md-4"; $stoplimit = 3; $GLOBALS['object_id'] = "core_categoryblock_side_yes"; }
if($GLOBALS['object_data']['desc'] == "yes"){ $showdesc = true; }else{ $showdesc = false; }
 
				/* prepare for output */
				$STRING = ""; $COUNTER = 0;	 $MOBILE_CAT_LIST = "";		
				
				if(isset($GLOBALS['object_data']['selected'])){ $xcc = $GLOBALS['object_data']['selected']; }else{ $xcc=""; }
				
				$args = array(
				  'taxonomy'     => THEME_TAXONOMY,
				  'orderby'      => 'name',
				  'show_count'   => 0,
				  'pad_counts'   => 1,
				  'hierarchical' => 0,
				  'title_li'     => '',
				  'include'	=> $xcc,
				  'hide_empty'   => 0,
				 
				);			
				$btitle = $GLOBALS['object_data']['title'];
				
				if($btitle != ""){
				if($btnview == "yes"){ $btn1 = '<a class="pull-right" href="'.get_home_url().'/?s=" rel="nofollow">'.$CORE->_e(array('button','35')).'</a>'; }else{ $btn1 = ""; }
				
				$STRING .= '<div class="category_object_block '.$extra1.'" id="'.$GLOBALS['object_id'].'"><div class="panel panel-default"><div class="panel-heading hidden-xs">'.$btn1.''.$btitle.'</div><div class="panel-body"><div class="row">';
				}else{
				 
				$STRING .= '<div class="category_object_block '.$extra1.' row" id="'.$GLOBALS['object_id'].'">';
				}
				
				
				$categories = get_categories($args);  $nc = 1; $tc = 1;
				
				foreach ($categories as $category) { 
				
					if($showpcats < $tc){ continue; }
					// HIDE PARENT
					if($category->parent != 0){ continue; }
					
					
					if($nc == 1){ $STRING .= '<ul>';}	
					
					// CHECK IF IT HAS AN ICON
					$img_style = "";
					$img_style_class = '';
					if($GLOBALS['object_data']['image'] != "off"){
						
						$img_icon = false;
						if($GLOBALS['object_data']['iconsize'] != "noshow" && isset($GLOBALS['CORE_THEME']['category_icon_'.$category->term_id]) && strlen($GLOBALS['CORE_THEME']['category_icon_'.$category->term_id]) > 1){
						
							$img = $GLOBALS['CORE_THEME']['category_icon_'.$category->term_id];		
							$img_icon = true;	
							$img_style= 'style="background:url('.$img.') no-repeat;"';
							if($smallicon == "yes"){
							$img_style_class = 'hasicon';
							}else{
							$img_style_class = 'hasiconlarge';
							}
						
						}else{
						$img = FRAMREWORK_URI.'img/img_fallback.jpg';
												}
						
					}
					
					$LINK = get_term_link($category->slug, THEME_TAXONOMY);
					$NAME = $category->name;
					if($showimage == "yes-side"){
						 
						$STRING .= '<li class="col-xs-12 '.$spansize.' '.$spansize.'box'.$COUNTER.'">
						
						<div class="media">
				  <a class="pull-left" href="'.$LINK.'">
					<img class="media-object" alt="'.$NAME.'" src="'.$img.'">
				  </a>
				  <div class="media-body">
					<h4 class="media-heading"><a href="'.$LINK.'">'.$NAME.'</a></h4>';
					
					if($showdesc){
					
					$STRING .= '<p>'.substr(strip_tags($category->description),0,60).'</p>';
					
					}
					 
							
					}elseif($showimage == "yes"){
						 
						$STRING .= '<li class="col-xs-6 col-sm-4 '.$spansize.' '.$spansize.'box'.$COUNTER.'">';
						$STRING .= '<a class="headBox" href="'.$LINK.'"><img src="'.$img.'" alt="'.$NAME.'"><span>'.$NAME.'</span></a>'; 
							
					}else{				 
						
						if($catcount == "yes"){ $cco = '<span class="count">('.$category->count.')</span>'; }else{ $cco = ""; }
						$STRING .= '<li class="col-xs-6 col-sm-4 '.$spansize.' '.$spansize.'box'.$COUNTER.'">
							<a class="headBox1 '.$img_style_class.'" '.$img_style.' href="'.$LINK.'"><span>'.$NAME.'</span> '.$cco.'</a>';
					}
					
					// MOBILE OPTION
					$MOBILE_CAT_LIST .= '<option value="'.$LINK.'">'.$NAME.'</option>';
				
					
					 $cee = "";
					if($subcatcount == "yes"){ $cee .= '&show_count=1'; }else{ $cee .= ""; }
					if($subcatempty == "yes"){ $cee .= '&hide_empty=0'; }else{ $cee .= "&hide_empty=1"; }
					$s = wp_list_categories("echo=0&taxonomy=".THEME_TAXONOMY."&title_li=&hierarchical=0&child_of=".$category->term_id."".$cee);
					$showf = explode("</li>",$s);
					$MOBILE_CAT_LIST .=  str_replace('">','"> - ',str_replace("href","value",str_replace("<a","<option",str_replace("/a>","/option>",strip_tags($s, '<a>')))));
					 
					// CHECK FOR SUB CATEGORIES
					if(strlen($s) > 25 && strpos($s, "No categories") === false){
						$STRING .= '<ul class="categorysublist '.$img_style_class.'_catme visible-desktop">';
						$ss = 0;
						foreach($showf as $subcat){ 
							if($ss > $subcats){ continue; }
							$STRING .= trim($subcat."</li>");
							$ss++;
						}
						$STRING .= '</ul>';
					}
					
					if($showimage == "yes-side"){
					$STRING .= '</div></div>';
					}
					
					$STRING .= '</li>';
					
					$COUNTER++;	
					
					if($nc == $stoplimit){ $STRING .= '</ul><div class="clearfix"></div>'; $nc=0; }
					$nc++; $tc++;
				}
				if($nc != 1){ 
				$STRING .= '</ul> <div class="clearfix"></div>'; 
				}
				if($btitle !=""){	 
				$STRING .= '</div><div class="clearfix"></div></div></div></div>';
				}else{
				$STRING .= '</div><div class="clearfix"></div>';
				}
	 
				echo str_replace("</li></li>","</li>",trim($STRING));
 
 	 
?>
<?php

function wlt_ajax_calls(){ global $wpdb, $post, $userdata, $CORE;


if(isset($_POST['wlt_ajax'])){

	switch($_POST['wlt_ajax']){
		
		
		
		case "showmediabox": {
	 
	 	// CHECK THE POST AUTHOR AGAINST THE USER LOGGED IN
	 	$bg = explode("---",$_POST['mid']);		
		$media = get_post($bg[1]); 
 
		if($media->post_author == $userdata->ID){
	 
		// GET MEDIA
		if(in_array($media->post_mime_type, $CORE->allowed_video_types)){		
		$showme = $CORE->UPLOAD_GET($bg[0],2,array("type" => "video"),$bg[1]);	 $tt = "video_array";
		}elseif(in_array($media->post_mime_type, $CORE->allowed_music_types)){		
		$showme = $CORE->UPLOAD_GET($bg[0],2,array("type" => "music"),$bg[1]);	 $tt = "";
		}elseif(in_array($media->post_mime_type, $CORE->allowed_doc_types)){		
		$showme = $CORE->UPLOAD_GET($bg[0],2,array("type" => "doc"),$bg[1]); $tt = "doc_array";			
		}else{		 
		$showme = '<a href="'.str_replace(" ", "-",$media->guid).'" target="_blank"><img src="'.str_replace(" ", "-",$media->guid).'" class="img-responsive wlt_thumbnail"></a>'; $tt = "image_array";
		}
		
		// GET ORDER
		$ORDER = 0;
		$g = get_post_meta($bg[0],  $tt, true);							
		if(is_array($g) && !empty($g) ){	
			foreach($g as $img){
				if($img['id'] ==  $bg[1]){
				$ORDER = $img["order"];
				}
			}
		}
		
		// LOAD IN LANGUAGE
		$CORE->Language();
		
		ob_start();
		?>      
          <div class="row"> 
          <div class="col-md-4">
          <?=$showme; ?>
          </div>
          <div class="col-md-8">          
          <label><?php echo $CORE->_e(array('button','58')); ?></label><div class="clearfix"></div>
          <input type="text" 
          value="<?=$media->post_title; ?>" 
          onchange="WLTSetImgText('<?=str_replace("http://","",get_home_url());?>', '<?=$bg[1]; ?>', this.value, 'core_ajax_callback');" 
          class="form-input col-md-12 input-lg" />
           
          <div class="clearfix"></div>
          <hr />
          <label><?php echo $CORE->_e(array('add','74')); ?></label><div class="clearfix"></div>
          <input 
          style="width:100px;"
          type="text" 
          value="<?=$ORDER; ?>"  
          onchange="WLTSetImgOrder('<?=str_replace("http://","",get_home_url()); ?>', '<?=$bg[1]; ?>', '<?=$bg[0]; ?>', this.value, 'core_ajax_callback');"
          class="form-input input-lg">
          
          </div>
          </div> 
          <script type="application/javascript">jQuery('video,audio').mediaelementplayer({audioWidth: 210});</script>
           
        <?php		  
		die(trim(ob_get_clean()));
		}
		
		} break;
				
		/***
		
		desc: Category selection tool for listing page
		updated: 23rd July 2014
		
		***/
		case "cats": {
		
		$json = array();		
		if(!is_array($_POST['category']) || ( is_array($_POST['category']) && empty($_POST['category']) )){	
		$json[] = '{"id" : "hide"}'; 
		}else{
		
		// CATEGORY PRICE
		$current_catprices = get_option('wlt_catprices'); $price = "";
		
		foreach($_POST['category'] as $cat){
			// ARGS
			$args = array(
			'taxonomy'                 => THEME_TAXONOMY,
			'child_of'                 => $cat,
			'hide_empty'               => 0,
			'hierarchical'             => false,
			'exclude'                  => 0);
			// QUERY CATS
			$cats  = get_categories( $args ); 
			 
			// CHECK FOR VALID DATA
			if(is_array($cats) && !empty($cats)){		
				// SELECTED VALUES
				$selcats = explode(",",$_POST['selected']);
				// LOOP
				foreach($cats as $data){				
					//SKIP IF NOT SAME PARENT
					if($cat != $data->parent){ continue; }
					// SELECED
					if(in_array($data->term_id,$selcats)){ $sel = "selected=selected"; }else{ $sel = ""; }
					// SHOW PRICE
					if(isset($current_catprices[$data->term_id]) 
					&& ( isset($current_catprices[$data->term_id]) && is_numeric($current_catprices[$data->term_id]) && $current_catprices[$data->term_id] > 0 ) ){ 
						$price = " (".hook_price($current_catprices[$data->term_id]).')'; 
					}
					// BUILD JASON STRING
					$json[] = '{"id" : "'.$data->term_id.'", "text" : "'.$data->name.$price.'", "sel" : "'.$sel.'"}'; 
				}// end foreach	
			}else{		
				$json[] = '{"id" : "hide"}'; 		
			}
		}// end foreach	
		}	
		// OUTPUT	
		echo '[' . implode(',', $json) . ']'; 
		die();				  
      
		} break;
	
	
	
	
	} // end switch

}// end if


if(isset($_GET['core_aj']) && $_GET['core_aj'] == 1){
	
			switch($_GET['action']){
			
				case "showadvancedsearch": {
				
					// LOAD IN LANGUAGE
					$CORE->Language();	
				
				  $advance_search = Core_Advanced_Search::instance();
				  echo $advance_search->build_form( null, true ); 
				
				} break;
			
				case "ajaxvideobox": {
				
				if(isset($_GET['pid']) && is_numeric($_GET['pid']) ){
				
					
					if($_GET['f'] == "Youtube_link"){
					// CHECK IF YOUTUBE LINK IS PRESENT
					$youtubelink = get_post_meta($_GET['pid'],$_GET['f'],true);
					
					$youid = explode("v=",$youtubelink);
					$thisid = explode("&",$youid[1]);
					echo '<div id="wlt_videobox_ajax_'.$_GET['pid'].'_active">
					
					<div class="hidden-sm hidden-xs">
						<video width="640" height="360" preload="none" style="width: 100%; height: 100%;" autoplay="true">
						<source type="video/youtube" src="'.$youtubelink.'" />				 				 
						</video>
					</div>
					
					<div class="visible-sm visible-xs">
						<iframe style="width:100%; height:100%;" src="//www.youtube.com/embed/'.$thisid[0].'" frameborder="0" allowfullscreen></iframe>
					</div>
					
					</div>';
					
					}else{
					
					echo '<div id="wlt_videobox_ajax_'.$_GET['pid'].'_active"><video width="100%" height="300" style="width: 100%; height: 100%;" controls="controls" preload="none" autoplay="true">
					<source type="'.$_GET['t'].'" src="http://'.$_GET['f'].'" />
					<!-- Flash fallback for non-HTML5 browsers without JavaScript -->
						<object width="100%" height="300" style="width: 100%; height: 100%;" type="application/x-shockwave-flash" data="'.get_template_directory_uri().'/framework/slider/flashmediaelement.swf">
							<param name="movie" value="'.get_template_directory_uri().'/framework/slider/flashmediaelement.swf" />
							<param name="flashvars" value="controls=true&file=http://'.$_GET['f'].'" />	
						</object>
					</video>';
			
					}
				
				}
				
				} break;
				
				 	
				case "setimgorder": {
					// CHECK THE POST AUTHOR AGAINST THE USER LOGGED IN
					$post_data = get_post($_GET['aid']); 
					if($post_data->post_author == $userdata->ID || user_can($userdata->ID, 'administrator') ){
					
					$haschanged = false;
					
						foreach(array("image_array", "video_array", "doc_array", "music_array") as $switch){
						
						 	if($haschanged){ continue; }
							$t = array();
							$g = get_post_meta($_GET['pid'], $switch, true);							
							
							if(is_array($g) && !empty($g) ){	
								 					
								foreach($g as $img){
									if($img['id'] == $_GET['aid']){
										$haschanged = true;
										$img['order'] = $_GET['txt'];
									}
									$t[] = $img; 
								}
								
								if($haschanged){
								update_post_meta($_GET['pid'], $switch, $t);
								}
													
							} // end if
							
						}// end foreach	
						 
					}
					die("done:".$_GET['pid']."/".$switch);			
				} break;		 
				case "setimgtext": {
					// CHECK THE POST AUTHOR AGAINST THE USER LOGGED IN
					$post_data = get_post($_GET['aid']); 
					if($post_data->post_author == $userdata->ID){
					
						$the_post 				= array();
						$the_post['ID'] 		= $_GET['aid'];
						$the_post['post_title'] = strip_tags(strip_tags($_GET['txt']));
						wp_update_post( $the_post );
						 
					}				
				} break;
				case "setfeatured": {				
				set_post_thumbnail($_GET['pid'], $_GET['aid']);
				} break;
				case "validateexpiry": {
					$CORE->EXPIRED($_GET['pid']);				
				} break;
				case "suggest": { 
				if(!isset($_GET['qq'])){ return; }
				if(!current_user_can('administrator')){ return; }
				$querystr = "SELECT $wpdb->posts.* FROM $wpdb->posts, $wpdb->postmeta 
				WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
				AND ( $wpdb->posts.ID LIKE '%".strip_tags(trim(htmlentities($_GET['qq'])))."%'  OR
				 $wpdb->posts.post_title LIKE '%".strip_tags(trim(htmlentities($_GET['qq'])))."%' )
				AND $wpdb->posts.post_status = 'publish' 
				AND $wpdb->posts.post_type = '".THEME_TAXONOMY."_type'
				GROUP BY $wpdb->posts.ID LIMIT 5";
				$results = $wpdb->get_results($querystr, OBJECT);
				
				/* Get the data into a format that Smart Suggest will read (see documentation). */
				$data = array('header' => array(), 'data' => array());
				$data['header'] = array('title' => 'Matching Products',	'num' => 10,	'limit' => 5	);
				 
				foreach ($results as $result)
				{
					if(isset($_GET['option']) && $_GET['option'] == 1){
					$data['data'][] = array(
					'primary' => $result->post_title,																						
					'secondary' => substr($result->post_excerpt,0,80)."..",														
					'image' => $CORE->GETIMAGE($result->ID,false,array("pathonly" => true)),																			
					'onclick' => "var select = document.getElementById('".$_GET['boxid']."');select.options[select.options.length] = new Option('".htmlentities(strip_tags(str_replace("'","",$result->post_title)))."', '".$result->ID."',true,true);",	
					'fill_text' => ""	
					);
					}
					
				}
				$final = array($data);header('Content-type: application/json');echo json_encode($final);die();
				} break;
				case "SaveRating": {
				
					// LOAD IN LANGUAGE
					$CORE->Language();	
							
					if(is_numeric($_GET['pid']) && is_numeric($_GET['value'])){
					// GET RATING IPS AND STOP THE USER FROM VOTING MULTIPLE TIMES
					$rated_user_ips = get_option('rated_user_ips');  $user_ip = $CORE->get_client_ip();
					if(!is_array($rated_user_ips)){ $rated_user_ips = array(); }
					
						if(isset($rated_user_ips[$_GET['pid']]) && isset($rated_user_ips[$_GET['pid']]['ips']) && in_array($user_ip, $rated_user_ips[$_GET['pid']]['ips']) ){							
							echo '<i class="fa fa-times"></i> '.$CORE->_e(array('coupons','30'));
							die();
						}else{ 
							if( ( !isset($rated_user_ips[$_GET['pid']]) || !isset($rated_user_ips[$_GET['pid']]['ips']) ) ){ $rated_user_ips[$_GET['pid']]['ips'] = array(); }
							
							$rated_user_ips[$_GET['pid']]['ips'] = array_merge($rated_user_ips[$_GET['pid']]['ips'],array($user_ip));
							update_option('rated_user_ips', $rated_user_ips); 
						}
					// GET RATING IPS
					$rated_user_ips = get_option('rated_user_ips');  $user_ip = $CORE->get_client_ip();
					if(!is_array($rated_user_ips)){ $rated_user_ips = array(); }
					if(isset($rated_user_ips[$user_ip])){ return; }else{ update_option('rated_user_ips', array_merge($rated_user_ips,array($user_ip))); }					 
					// GET EXISTING DATA
					$totalvotes = get_post_meta($_GET['pid'], 'starrating_votes', true);
					$totalamount = get_post_meta($_GET['pid'], 'starrating_total', true);
					if(!is_numeric($totalamount)){ $totalamount = $_GET['value']; }else{ $totalamount += $_GET['value']; }
					if(!is_numeric($totalvotes)){ $totalvotes = 1; }else{ $totalvotes++; }
					// WORK OUT RATING
					$save_rating = round(($totalamount/$totalvotes),2);
					// SAVE RESULTS
					update_post_meta($_GET['pid'], 'starrating', $save_rating);
					update_post_meta($_GET['pid'], 'starrating_total', $totalamount);
					update_post_meta($_GET['pid'], 'starrating_votes', $totalvotes);
					
					echo '<i class="fa fa-check-square-o"></i> '.$CORE->_e(array('coupons','29'));
				 
					//echo $save_rating." <-- total votes:".$totalvotes." / total amount: ".$totalamount;
					}
				} break;
				case "SaveUpRating": {	
					
					// LOAD IN LANGUAGE
					$CORE->Language();	
				
					if(is_numeric($_GET['pid']) ){
						// GET RATING IPS AND STOP THE USER FROM VOTING MULTIPLE TIMES
						$rated_user_ips = get_option('rated_user_ips');  $user_ip = $CORE->get_client_ip();
						if(!is_array($rated_user_ips)){ $rated_user_ips = array(); }
					
						if(isset($rated_user_ips[$_GET['pid']]) && in_array($user_ip, $rated_user_ips[$_GET['pid']]['ips']) ){ 
							if($_GET['value'] == "up"){
								$result = get_post_meta($_GET['pid'], 'ratingup', true);
							}else{
								$result = get_post_meta($_GET['pid'], 'ratingdown', true);				
							}
							if($result == ""){ echo 0; }else{ 
								// REUTNR RATING BAR
								if($GLOBALS['CORE_THEME']['rating_type'] == 8 || $GLOBALS['CORE_THEME']['rating_type'] == 9){
									echo '<div class="progress">'.$CORE->_e(array('coupons','30')).'</div>';
								}else{
									 echo $result;
								}
							}
							die();
						}else{ 
							if(!isset($rated_user_ips[$_GET['pid']]['ips'])){ $rated_user_ips[$_GET['pid']]['ips'] = array(); }
							$rated_user_ips[$_GET['pid']]['ips'] = array_merge($rated_user_ips[$_GET['pid']]['ips'],array($user_ip));
							update_option('rated_user_ips', $rated_user_ips); 
						}
						// GET EXISTING DATA
						if($_GET['value'] == "up"){
							$result = get_post_meta($_GET['pid'], 'ratingup', true)+1;
							update_post_meta($_GET['pid'], 'ratingup', $result);
						}else{
							$result = get_post_meta($_GET['pid'], 'ratingdown', true)+1;
							update_post_meta($_GET['pid'], 'ratingdown', $result);					
						}
						// SAVE RESULTS					
						update_post_meta($_GET['pid'], 'rating_total', get_post_meta($_GET['pid'], 'rating_total', true)+1);
						
						// IF ITS THE PROGRESS BAR RETURN BAR RATING
						if($GLOBALS['CORE_THEME']['rating_type'] == 8 || $GLOBALS['CORE_THEME']['rating_type'] == 9){
							
							// CALCULATE TOTAL
							$up 	= get_post_meta($_GET['pid'], 'ratingup', true);
							$down 	= get_post_meta($_GET['pid'], 'ratingdown', true);	
							if($up == ""){ $up = 0; }
							if($down == ""){ $down =0; }				
							$total = $up+$down;
							// WORK OUT GOOD PERCENTAGE
							if($total == 0 || $up == 0 ){
								$good_per = 0;					
							}else{
								$good_per = ($up*100)/$total;				
							}
							// WORK OUT BAD PERCENTAGE
							if($total == 0 || $down == 0 ){
								$bad_per = 0;					
							}else{
								$bad_per = ($down*100)/$total;			
							}
							
							echo '<div class="progress" id="'.$divID.'_down"><div class="progress-bar progress-bar-success"  style="width: '.$good_per.'%">
							<span>('.round($good_per).'%)</span></div><div class="progress-bar progress-bar-danger" style="width: '.$bad_per.'%"><span>&nbsp;</span></div></div>';
						
						}else{						
					 		// OUTPUT
							echo $result;						
						}
					}
				} break;
				case "SaveSession": {
				
				global $CORE_CART;
				
				$table_data = $CORE_CART->GETCART();
				$wpdb->query("DELETE FROM ".$wpdb->prefix."core_sessions WHERE session_key = ('".session_id()."') LIMIT 1");	
				$wpdb->query("INSERT INTO ".$wpdb->prefix."core_sessions (`session_key` ,`session_date` ,`session_userid`, session_data) VALUES ('".session_id()."', '".date('Y-m-d H:i:s')."', '".$userdata->ID."', '".serialize($table_data)."')");
			 
				} break;			
				case "UpdateUserField": {
				if($_GET['id'] == "cartcomment"){
					// save comment
					$_SESSION['wlt_cart']['comment'] = stripslashes(strip_tags($_GET['value']));
					// leave output
					echo '<img src="'.FRAMREWORK_URI.'admin/img/yes.png">';
					
				}elseif($userdata->ID){		
					update_user_meta($userdata->ID, $_GET['id'], strip_tags($_GET['value']));
					//echo $userdata->ID."<--";
				}				
				} break;			
				case "CatUpdatePrice": {
				if(!is_numeric($_GET['cid'])){ die(); }
				if(is_numeric($_GET['p']) || $_GET['p'] == ""){
				$current_catprices = get_option('wlt_catprices');
				if(!is_array($current_catprices)){ $current_catprices = array(); }
				$current_catprices[$_GET['cid']] = $_GET['p'];
				update_option('wlt_catprices',$current_catprices);	
				echo "<div class='alert alert-success'>Price Updated Successfully</div>";	
				}
				die();		
				} break;
				case "CatPrice": {
				if(!is_numeric($_GET['cid'])){ die(); }
				$current_catprices = get_option('wlt_catprices'); $cprice = "";
				if(!is_array($current_catprices)){ $current_catprices = array(); }
				if(isset($current_catprices[$_GET['cid']])){  $cprice = $current_catprices[$_GET['cid']]; }
				echo '<input type="text" name="catprice" class="span8" style="margin-right:15px;text-align:right;" id="catprice" value="'.$cprice.'">';
				 
				} break;
				// MAILING LIST 			
				case "MailingList" : {	
				
				// LOAD IN LANGUAGE
				$CORE->Language();	
						 
				if( !preg_match("/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/i", $_GET['eid']) && $CORE->get_client_ip() != "error" ) {
					echo '<div class="msg">'.$CORE->_e(array('validate','23')).'</div>';
				}else{
				// ADD DATABASE ENTRY
				$hash = md5($_GET['eid'].rand());
				$SQL = "INSERT INTO ".$wpdb->prefix."core_mailinglist (`email`, `email_hash`, `email_ip`, `email_date`, `email_firstname`, `email_lastname`) 
				VALUES ('".strip_tags($_GET['eid'])."', '".$hash."', '".$CORE->get_client_ip()."', now(), '', '');";			
				$wpdb->query($SQL);
				// BUILD LINK FOR EMAIL
				$_POST['link'] = get_home_url()."/confirm/mailinglist/".$hash;			 
				// SEND OUT CONFIRMATION EMAIL
				$subject = stripslashes($GLOBALS['CORE_THEME']['mailinglist']['confirmation_title']);
				$message = stripslashes($GLOBALS['CORE_THEME']['mailinglist']['confirmation_message']);
				$CORE->SENDEMAIL($_GET['eid'],'custom', $subject, $message);
				// PROVIDE USER MESSAGE
				echo "<div class='msg'>".$CORE->_e(array('validate','24'))."</div>";			
				}
				
				} break;		
				// GOOGLE MAP
				case "MapData": {	
				
				// LOAD IN LANGUAGE
				$CORE->Language();	
							
				if(!is_numeric($_GET['postid'])){ die(); }				
				$pd = get_post($_GET['postid']);				
				echo "<h4>".$pd->post_title."</h4>";
				echo "<p style='max-height:240px;overflow:hidden;'>".preg_replace('/\[caption[^>]+\]/i', "", preg_replace('/\[gallery[^>]+\]/i', "", strip_tags($pd->post_content)) )."</p>";	
				
				echo "<p><a href='".get_permalink($pd->ID)."' style='color:#fff;'>".$CORE->_e(array('button','40'))."</a></p>";				
				} break;
				// FAVS OPTIONS
				case "ListObject": {
				// LOAD IN LANGUAGE
				$CORE->Language();					
					/** first make sure we are logged in **/
					if($userdata->ID && ( $_GET['type'] == "favorite" || $_GET['type'] == "wishlist" || $_GET['type'] == "blocked"  || $_GET['type'] == "friends"  ) && is_numeric($_GET['postid'])){					
						/** get existing user list ***/				
						$my_list = get_user_meta($userdata->ID, $_GET['type'].'_list',true);
						/** now lets check if we have an item already, if so delete it otherwise add one ***/	
						if(is_array($my_list) && in_array($_GET['postid'], $my_list) ){
							$result = $my_list;							
							unset($result[array_search($_GET['postid'], $result)]);						 						
							$error_message = $CORE->_e(array('validate','lo_a_'.$_GET['type']));
							$ac = "warning";
						}else{			 
							$result = array_merge((array)$my_list, array($_GET['postid']));
							$error_message = $CORE->_e(array('validate','lo_r_'.$_GET['type']));  
							$ac = "success";
						}
						/*** now cleanup array(); ***/
						if(is_array($result)){
						$newResult = array();
							foreach($result as $g){
								if(is_numeric($g)){
									$newResult[] = $g;
								}
							}
						}
						/** now lets update ***/				 
						update_user_meta($userdata->ID, $_GET['type'].'_list', $newResult);
						/** now lets display the message to the user ***/
						die($error_message."**".$ac);					 
					}else{  		 
					 die($CORE->_e(array('validate','25'))."**warning");
					}					
				} break;
				
				// VALIDATE USERNAME ON THE MESSAGES PAGE
				case "ValidateUsername": {				
					if(strlen($_GET['id']) > 3){
					$dd = get_userdatabylogin( str_replace("-"," ",strip_tags($_GET['id'])) );	
						if(isset($dd->ID)){
						echo '<img src="'.FRAMREWORK_URI.'admin/img/yes.png">';
						}else{
						echo '<img src="'.FRAMREWORK_URI.'admin/img/no.png">';
						}
					}							
				} break;					
				// CHANGE MESSAGE STATUS ONCLICK	
				case "ChangeMsgStatus": {	
					if(is_numeric($_GET['id'])){			
					update_post_meta($_GET['id'],"status","read");	
					}					 	
				} break;					
				// CHANGE THE STATE VALUE FOR OUNTRY/STATE/CITY	
				case "ChangeState": {				
				
				$selected = $_GET['sel']; $in_array = array();				
							
				if(strpos($_GET['div'],"core_state") !== false){
						$s1 = 'map-state'; $s2 = 'map-country';										
				}else{
						$s1 = 'map-city'; $s2 = 'map-state';	
				}				
				
				$SQL = "SELECT DISTINCT a.meta_value FROM ".$wpdb->postmeta." AS a				
				INNER JOIN ".$wpdb->postmeta." AS t ON ( t.meta_key = '".$s2."' AND t.meta_value= ('".strip_tags($_GET['val'])."') AND t.post_id = a.post_id )				
				WHERE a.meta_key = '".$s1."'";				
			 
				$results = $wpdb->get_results($SQL); 
				 				 
				if(count($results) > 0 && !empty($results) ){
				
					echo "<option value=''></option>";
					
					foreach ($results as $val){			
						
						$state = $val->meta_value;						
						if(!in_array($state,$in_array)){						
							
							// ADD TO ARRAY
							$in_array[] = $state;
							$statesArray[] .= $state;
						}// if in array					
					} // end while	
					
					// NOW RE-ORDER AND DISPLAY
					asort($statesArray);
					foreach($statesArray as $state){ 
							if(strlen($state) < 2){ continue; }
							if($selected != "" &&  $state == $selected){
							echo "<option selected=selected>". $state."</option>";
							}else{
							echo "<option>". $state."</option>";
							} // end if	
					} 
					
					
				}else{ // end if
				
				// LOAD IN LANGUAGE
				$CORE->Language();	
				
				echo "<option value=''>".$CORE->_e(array('validate','26'))."</option>";
				}							
				} break;
				
				case "ChangeSearchValues": { 
					
					$THIS_SLUG = "";
				 	
					// GET ALL PARENT TERMS AND FIND ONE THAT MATCHES THE SLUG
					 $bits = explode("__", $_GET['key']);
					 
					 // GET LIST OF ALL PARENTS FROM SUB MENU
					 $parent_terms = get_terms($bits[0] ,array(  'orderby'    => 'count', 	'hide_empty' => 0, 'parent' => 0 ));					 				 			
					 if ( !empty( $parent_terms ) && !is_wp_error( $parent_terms ) ){
					 
					 // VALIDATION FOR VALUE
					 if($_GET['val'] == ""){ die("<select id='novalueset'><option value=''></option></select>"); }	 
						 
						 // PASSED IN NUMERICAL VALUE INSTEAD OF SLUG
						if(is_numeric($_GET['val']) && isset($bits[1])){
							$found_term = get_term_by('id', $_GET['val'], $bits[1]);	
							 				 
							if(isset($found_term->slug)){
								$_GET['val'] = $found_term->slug;						 
							}					 
						}
						 
						// LOOP PARENT TERMS
						foreach ( $parent_terms as $term ) {
						 
						 	// CHECK FOR MATCH
							if (strpos($term->slug, $_GET['val']) !== false && $THIS_SLUG == "") {
								 
								if (strpos($_GET['val'], "-") === false && strpos($term->slug, "-") !== false){
								
								}else{
								$THIS_SLUG = $term->slug;
								}
							} 							
						}
						
						if($THIS_SLUG != ""){
						
							// GET THE PARENT ID
							$df_term = get_term_by('slug', $THIS_SLUG, $bits[0]);				 
					 		
							// CHECK IF TERM EXISTS
							if(isset($df_term->term_id)){
						
								$terms = get_terms($bits[0],'hide_empty=0&child_of='.$df_term->term_id);
								$selec = (isset( $_GET['pr'] )) ? $_GET['pr'] : '';
					 
								$count = count($terms);
						 
							if ( $count > 0 ){
							 echo "<select name='".$_GET['cl']."' class='form-control'>";
							 
							 if($_GET['add'] == 0){ echo "<option value=''></option>"; }
							 
							 foreach ( $terms as $term ) {
							 
								if($_GET['pr'] == "-1"){ $sv = $term->term_id; }else{ $sv = $term->slug;  }
								if($selec == $sv){ $a = "selected=selected"; }else{ $a = ""; }				   
								echo "<option value='".$sv."' ".$a.">" . $term->name . " (".$term->count.") </option>";							   				
							 }						  
							
							 echo "</select>";
							 }
							 }else{
							  echo "<select><option value=''></option></select>";
							 }
						 
						 } // end if
						
						 
					 }else{
					 	echo "<select><option value=''></option></select>";
					 }				  
				
				
				} break;
			}
		
			die();	
		}
		//////////////////////////////////////////////////////////////////////////////////////	

}

?>
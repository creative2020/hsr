<?php
/*
Plugin Name: [IMPORT] - CSV Import/Export
Plugin URI: http://www.premiumpress.com
Description: This plugin will let you import/export via CSV.
Version: 3.0
Author: Mark Fail
Author URI: http://www.premiumpress.com
License:
Updated: 25th April 2014
*/ 

if(!defined('MYSQL_CLIENT_FLAGS')){
define('MYSQL_CLIENT_FLAGS','128');
}

function CSV_INIT(){ global $wpdb; 

	if(isset($_POST['savecompare'])){
	
	// GET LIST OF COMPARED TABLES
	$compared_tables = get_option('wlt_comparedtables');
	if(!is_array($compared_tables)){ $compared_tables = array(); }
	
	// CHECK IF IT EXISTS
	if(in_array($_POST['savecompare_table'], $compared_tables)){
		
		if(!$_POST['savecompare_value']){
			// LOOP THROUGH AND REMOVE ALL ENTRIES
			foreach($compared_tables as $k=>$v){
				if($v == $_POST['savecompare_table']){
				unset($compared_tables[$k]);
				} // end if
			}// end foreach		
		}
	
	}else{
		if($_POST['savecompare_value'] == 1){
			$compared_tables[] = $_POST['savecompare_table'];
		}	
	}
	// SAVE THE DATA
	update_option("wlt_comparedtables",$compared_tables);	
	//die(print_r($_POST).);
	}

	if(isset($_GET['autofix']) && strlen($_GET['autofix']) > 4){
	
	// GET LIST OF HEADERS
	$result = mysql_query("SELECT * FROM (".$_GET['autofix'].") LIMIT 1");
	$row = mysql_fetch_assoc( $result ); 
	foreach($row as $key=>$val){ if($key == ""){ continue; }
		//echo $key."<br>";
		// SWITCH AND ALTER
		switch(strtolower($key)){
			case "image":
			case "imageurl": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `image` TEXT");			
			} break;
			case "product name":
			case "title":
			case "name": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `post_title` TEXT");			
			} break;
			case "product description":
			case "description": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `post_content` TEXT");			
			} break;
			case "title2":
			case "shortdescription": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `post_excerpt` TEXT");			
			} break;
			case "merchantcategoryname": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `category1` TEXT");			
			} break;
			case "product category":
			case "tdcategoryname": 
			case "category": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `category` TEXT");			
			} break;	
			case "url":
			case "link":
			case "producturl": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `buy_link` TEXT");			
			} break;
			case "merchant_name":
			case "programname": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `store` TEXT");			
			} break;		
			case "provider_logo":	
			case "programlogopath": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `store_logo` TEXT");			
			} break;
			case "price": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `price` TEXT");			
			} break;
			case "previousprice": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `old_price` TEXT");			
			} break;	
			case "shippingcost": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `shipping` TEXT");			
			} break;
			
			case "country": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `map-country` TEXT");			
			} break;			
			case "city": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `map-city` TEXT");			
			} break;
			case "address": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `map-location` TEXT");			
			} break;
			case "zipcode":
			case "postcode": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `map-zip` TEXT");			
			} break;	
			case "longitude": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `map-log` TEXT");			
			} break;
			case "latitude": {	
				mysql_query("ALTER TABLE ".$_GET['autofix']." CHANGE  `".$key."`  `map-lat` TEXT");			
			} break;	
							
			
		} // end switch	
	} // end foreach
	
	// UPDATE MESSAGE
	$GLOBALS['error_message'] = "Table Updated Successfully";

	}elseif(isset($_GET['action']) && $_GET['action'] == "dome"){	
	
	if(($_GET['p']*100) > $_GET['t']){ ?>
	<div class="alert alert-success">
    <h3 style="color:#097f14;font-weight:bold;">Import Completed</h3>
    </div>	
	<?php }else{ 
	$perc = ($_GET['p']*100)/$_GET['t']*100;
	$time_remaining = round($_GET['t']/100-$_GET['p'],0);
	
	?>
    <div class="alert alert-info">
    <h3 style="color:#0F5375;font-weight:bold;">CSV Import Progress</h3>
    <p>Importing rows <?php echo ($_GET['p']*100); ?> - <?php echo ($_GET['p']*100)+100; ?> of <?php echo $_GET['t']; ?></p>
    <div class="progress progress-striped active">
      <div class="bar" style="width: <?php echo $perc; ?>%;"></div>
    </div>
    <p style="font-size:11px;">estimated time remaining: <?php if($time_remaining == 0){ $time_remaining = 2; } echo $time_remaining; ?> minutes - <b>do not close this window or your import will stop.</b></p>
    </div> 
	<?php
	}	
	die();
	}	
}
add_action('init','CSV_INIT');


//1. ADD NEW ADMIN MENU ITEMS FOR YOUTUBE
$GLOBALS['new_admin_menu'][] = array("wlt_csv" => array("title" => "<img src='".plugins_url()."/wlt_csv/img/csv.png'> CSV Import","function" => "wlt_csv" ));

// 2. IMPORT
if(isset($_FILES['file_source'])){

  include( WP_PLUGIN_DIR . '/wlt_csv/class_csv.php' );
  $csv = new WLT_CSV_import();
 
  // UPLOAD THE FILE FIRST TO THE SERVER
  $uploads = wp_upload_dir();  
  copy($_FILES['file_source']['tmp_name'], $uploads['path']."/".$_FILES['file_source']['name']);

  // IF ITS COMPRESSED, UNZIP IT
  $lastthree = substr($_FILES['file_source']['name'],-3);
  if($lastthree == ".gz" || $lastthree == "zip"){
	  	$dir_path = str_replace("wp-content","",WP_CONTENT_DIR);
	  	require $dir_path . "/wp-admin/includes/file.php";
	  	WP_Filesystem();
	  	$zipresult = unzip_file( $uploads['path']."/".$_FILES['file_source']['name'], $uploads['path']."/unzipped/" );
	 	if ( is_wp_error($zipresult)){
		 	echo "<h1>The file could not be extracted.</h1><hr>";
			print_r($zipresult);
			die();
		 }else{		 	
			// READ THE FOLDER TO GET THE FILENAME THEN REMOVE THE FOLDER
			if ($handle = opendir($uploads['path']."/unzipped/")) {
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != ".." && ( substr($entry,-4) == ".csv" || substr($entry,-4) == ".txt") ) {
						$unzippedfilename = $entry;
					}
				}
				closedir($handle);
			}
			
			// CHECK WE FOUD IT
			if(!isset($unzippedfilename)){
			die("The file could not be extracted and found.");			
			}else{
			
				copy($uploads['path']."/unzipped/".$unzippedfilename, $uploads['path']."/".$unzippedfilename);				
				$csv->file_name = $uploads['path']."/".$unzippedfilename;
				// DELETE THE ZIP FOLDER AND FILE
				unlink($uploads['path']."/unzipped/".$unzippedfilename);
				unlink($uploads['path']."/".$_FILES['file_source']['name']);
				rmdir($uploads['path']."/unzipped/");				
			}			
		 
		 }		 
  }else{
  
  	$csv->file_name 				= $uploads['path']."/".$_FILES['file_source']['name'];  
  
  }
  
  //optional parameters
  $csv->use_csv_header 			= isset($_POST["use_csv_header"]);
  $csv->field_separate_char 	= $_POST["field_separate_char"][0];
  $csv->field_enclose_char 		= $_POST["field_enclose_char"][0];
  $csv->field_escape_char 		= $_POST["field_escape_char"][0];
  $csv->encoding 				= _get_php_encoding();
   
	//start import now
	$database = $csv->import();	
	$countrows = $csv->countrows($database);
 
	$new_values = array();
	$new_values[$database] = $countrows;  
	// GET THE CURRENT VALUES
	$existing_values = get_option("wlt_csv");
	// MERGE WITH EXISTING VALUES
	$new_result = array_merge((array)$existing_values, (array)$new_values);
	// UPDATE DATABASE 		
	update_option( "wlt_csv", $new_result);
	// CLEAN UP
	@unlink($csv->file_name);
	// LEAVE FRIENDLY MESSAGE
	$GLOBALS['error_message'] = "CSV Uploaded Successfully";
}


function _get_php_encoding() {
switch ( strtolower( DB_CHARSET ) ) {
                                case 'latin1':
                                        $encoding = 'ISO-8859-1';
                                        break;
                                case 'utf8':
                                case 'utf8mb4':
                                        $encoding = 'UTF-8';
                                        break;
                                case 'cp866':
                                        $encoding = 'cp866';
                                        break;
                                case 'cp1251':
                                        $encoding = 'cp1251';
                                        break;
                                case 'koi8r':
                                        $encoding = 'KOI8-R';
                                        break;
                                case 'big5':
                                        $encoding = 'BIG5';
                                        break;
                                case 'gb2312':
                                        $encoding = 'GB2312';
                                        break;
                                case 'sjis':
                                        $encoding = 'Shift_JIS';
                                        break;
                                case 'ujis':
                                        $encoding = 'EUC-JP';
                                        break;
                                case 'macroman':
                                        $encoding = 'MacRoman';
                                        break;
                                default:
                                        $encoding = 'UTF-8';                                        
                        }
             
                return $encoding;
}
function wlt_csv_init(){ global $wpdb;

	if(isset($_POST['wlt_csv_action'])){
		switch($_POST['wlt_csv_action']){	
			case "startimport": { set_time_limit(0); 		
			
			if($_POST['csv_key'] == ""){ die("database table missing"); }
			
			// GET A LIST OF ALL TAXONOMIES
			$current_taxonomies = get_taxonomies(); 
			 
			$start_num = $_POST['csv_pagenumber'];
			if($start_num > 0){ $start_num = $start_num*100; }
			// STOP IF THE PAGE NUMBER IS GREATER THANK TOTAL
			if( $start_num > $_POST['csv_total']){ die("import completed (".$start_num." = ".$_POST['csv_total'].")"); }
			
				// POST FIELDS
				$post_fields = array('SKU','post_author','post_date','post_date_gmt','post_content','post_title','post_excerpt','post_status',
				'comment_status','ping_status','post_password','post_name','to_ping','pinged','post_modified','post_modified_gmt','post_content_filtered',
				'post_parent','guid','menu_order','post_type','post_mime_type','comment_count');	  
				
				// OK LETS LOOP THE TABLE X TIMES THEN 	
				if(isset($_POST['runall'])){
				$QUERYSTRING  = "SELECT * FROM ".$_POST['csv_key']."";
				}else{
				$QUERYSTRING  = "SELECT * FROM ".$_POST['csv_key']." LIMIT ".$start_num.",100";
				}	
				
				  
				$results = $wpdb->get_results($QUERYSTRING, OBJECT);
			 	if(is_array($results)){
				foreach($results as $new_post){
				 	
						// IMPORT NEW POST DATA
						$my_post = array(); $my_post['post_excerpt'] = ""; $customdata = array(); $catsarray = array(); $update=false;
						 
						foreach($new_post as $key=>$val){
							
							switch($key){
								case "ID":
								case "SKU":
								case "sku":
								case "post_id": { 
									// CHECK IF POST EXISTS
									if(!$update && $val != ""){
									
										if($key == "SKU" || $key == "sku"){
										$post_exists = $wpdb->get_row("SELECT $wpdb->postmeta.post_id AS ID FROM $wpdb->postmeta WHERE 
										( meta_value = '" . $val . "' AND meta_key='SKU' OR meta_value = '" . $val . "' AND meta_key='sku' )
										LIMIT 1", 'ARRAY_A');										
										}else{										
										$post_exists = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE ID = '" . $val . "' LIMIT 1", 'ARRAY_A');	
										}
										 						 
										if(isset($post_exists['ID'])){
										  $my_post['ID'] = $post_exists['ID']; 
										  $update = true; 										   									  
										}elseif($key == "SKU"){										
											$customdata["SKU"] = $val; 
										}
									}
								 	$customdata["SKU"] = $val; 
								} break;								 
								case "post_author": { $my_post['post_author'] = $val; } break;
								//case "post_date": { $my_post['post_date'] = $val; } break;
								//case "post_date_gmt": { $my_post['post_date_gmt'] = $val; } break;
								case "post_content": { $my_post['post_content'] = $val; } break;
								case "post_title": { $my_post['post_title'] = $val;  } break;
								case "post_excerpt": { $my_post['post_excerpt'] = $val; } break;
								case "post_status": { $my_post['post_status'] = $val; } break;
								case "comment_status": { $my_post['comment_status'] = $val; } break;
								case "store_logo": { $my_post['store_logo'] = $val; } break;
								case "post_type": { if(strlen($val) > 2){$my_post['post_type'] = $val;}else { $my_post['post_type'] = THEME_TAXONOMY."_type"; } } break;
								case "category1":
								case "category": {
								
									$cats_array = explode(",",$val); 
									foreach($cats_array as $catname){
									 
										// CHECK IF THE CATEGORY ALREADY EXISTS
										if ( is_term( $catname, THEME_TAXONOMY ) ){
											$term = get_term_by('name', str_replace("_"," ",$catname), THEME_TAXONOMY);										 
											$catID = $term->term_id;
										}else{										
											$args = array('cat_name' => str_replace("_"," ",$catname) ); 
											$term = wp_insert_term(str_replace("_"," ",$catname), THEME_TAXONOMY, $args); 
											if(is_array($term) && isset($term['term_id']) && !isset($term['errors'][0]) ){
											$catID = $term['term_id'];
											}elseif(isset($term->term_id)){
											$catID = $term->term_id;
											}					 
										}
										
										$catsarray[] = $catID;
										
									} 
								
								} break;
								default: { 	
								
								if(in_array($key,$current_taxonomies)){
								
										$vals = explode(",",$val);										
										$catIDArray = array();
										foreach($vals as $val1){
										 	
											// TRIM VALUE
											$val1 = trim($val1);
											// CHECK IF THE CATEGORY ALREADY EXISTS
											if ( is_term( $val1, $key ) ){
												$term = get_term_by('name', str_replace("_"," ",$val1), $key);										 
												$catID = $term->term_id;												
											}else{										
												$args = array('cat_name' => str_replace("_"," ",$val1) ); 
												$term = wp_insert_term(str_replace("_"," ",$val1), $key, $args); 
																							
												if(is_array($term) && isset($term['term_id']) && !isset($term['errors'][0]) ){
													$catID = $term['term_id'];
												}elseif(isset($term->term_id)){
													$catID = $term->term_id;
												}					 
											}
											
											// SAVE ID
											if(is_numeric($catID)){
											$catIDArray[] = $catID;
											}										
										}
										 
										$taxarray[$key] = $catIDArray;
								
								}else{
									$customdata[$key] = $val;								
								}
								 
								
								 } break;
							
							}// end switch				
						}// end foreach
						
							
						// CHECK IF NOT SET
						if(!isset($my_post['post_type'])){
						$my_post['post_type'] 		= THEME_TAXONOMY."_type";
						}
						
						// SET POST STATUS
						if(!isset($my_post['post_status'])){
						$my_post['post_status'] = "publish";
						}
						
						// WORK ON CUSTOM ENCODING						
						if(function_exists('utf8_encode')){ 
							$np = array();
							foreach($my_post as $key=>$val){
								if(is_string($val)){
									if(function_exists('mb_convert_encoding')){									
										$np[$key] = mb_convert_encoding($val, _get_php_encoding(),'auto');
									}else{
										$np[$key] = utf8_encode($val);
									}								 
								}else{
									$np[$key] = $val;
								}
								
							}
							$my_post = $np;
						}
						
						// ADD OR UPDATE ISTING
						if($update){
						$POSTID = wp_update_post( $my_post );
						}else{
						$POSTID = wp_insert_post( $my_post );
						}
						
						// SAVE ANY CUSTOM TAXONOMIES
						if(is_array($taxarray)){				 
							foreach($taxarray as $k=>$v){
								wp_set_post_terms( $POSTID, $v, $k, true);
							}
						} 
						
						// SET POST CATEGOIRY FOR POST TYPE
						if(is_array($catsarray) && !empty($catsarray)){
						wp_set_post_terms( $POSTID, $catsarray, THEME_TAXONOMY );
						}	
						 
										
						// NOW ADD IN THE CUSTOM FIELDS
						if(is_array($customdata)){
							foreach($customdata as $key=>$val){
								update_post_meta($POSTID,$key,$val);
							}
						}
						
						// EXTRA FOR STORE LOGO
						if (taxonomy_exists('store') && isset($taxarray['store'])){
						 
							$_POST['admin_values']['category_icon_'.$taxarray['store']] = $my_post['store_logo'];			
							// GET THE CURRENT VALUES
							$existing_values = get_option("core_admin_values");
							// MERGE WITH EXISTING VALUES
							$new_result = array_merge((array)$existing_values, (array)$_POST['admin_values']);
							// UPDATE DATABASE 		
							update_option( "core_admin_values", $new_result);
						}															 
							
					}// forwach loop
				}
			$GLOBALS['error_message'] = "Import Completed Successfully";
			} break;
		}	
	}// end if

	if(isset($_GET['wlt_csv_action'])){
	
		switch($_GET['wlt_csv_action']){
		
			case "export": {
			
			include( WP_PLUGIN_DIR . '/wlt_csv/class_csv.php' );
			
			// GET ALL CUSTOM FIELDS
			$CFT = $wpdb->get_results("SELECT DISTINCT meta_key FROM ".$wpdb->prefix."postmeta",ARRAY_A);
			$FF = array();	
			foreach($CFT as $k=>$v){		 
				if(substr($v['meta_key'],0,1) == "_"){ // DONT INCLUDE FIELDS THAT BEGIN WITH _		
				}else{		
				$FF[$v['meta_key']] ="";		
				}
			}
			
			// START AND END
			if(isset($_GET['s'])){ $start = $_GET['s']; }else{ $start = 0; }
			if(isset($_GET['e'])){ $end = $_GET['e']; }else{ $end = 1000; }
			
			// GET ALL POSTS
			$allposts = array();
			$SQL = "SELECT * FROM $wpdb->posts WHERE post_type='".THEME_TAXONOMY."_type' LIMIT $start,$end ";
			$PPO = $wpdb->get_results($SQL,ARRAY_A);
			foreach ( $PPO as $dat ){
			
				// CLEAN ANY COLUMNS WE DONT WANT
				unset($dat['comment_count']);	
				unset($dat['post_mime_type']);
				unset($dat['menu_order']);	 
				unset($dat['post_date_gmt']);
				unset($dat['ping_status']);
				unset($dat['post_password']);
				unset($dat['post_name']);
				unset($dat['to_ping']);
				unset($dat['pinged']);
				unset($dat['post_modified']);
				unset($dat['post_modified_gmt']);
				unset($dat['post_content_filtered']);
				unset($dat['post_parent']);
				unset($dat['guid']);
				unset($dat['_edit_last']);
				unset($dat['_wp_page_template']);
				unset($dat['_edit_lock']);
				unset($dat['post_status']);
				unset($dat['comment_status']); 
			 
		
				// GET CATEGORY
				$cs = ""; 
				$categories = get_the_terms($dat['ID'], THEME_TAXONOMY);				
				if(is_array($categories)){foreach($categories as $cat){ $cs .= $cat->name. ","; } }
				$dat['category'] = substr($cs,0,-1); //$category[0]			
 				
				// GET ALL THE POST DATA FOR THIS LISTING
				$cf = get_post_custom($dat['ID']);
				
				 // LOOP THROUGH AND DELETE UNUSED ONES
				 if(is_array($cf)){
				 foreach($cf as $k=>$c){	 	 
					if(substr($k,0,1) == "_"){ unset($cf[$k]); }else{  } 
				  //if( == ""){  }	 // unset($dat[$k]);	 
				 } } 
			 
				 // CLEAN OUT DEFAULT CUSTOM FIELDS WHICH WE DONT WANT
				 unset($cf['_wp_page_template']);
				 unset($cf['_wp_attachment_metadata']);
				 unset($cf['_wp_attached_file']);
				 unset($cf['_wp_trash_meta_status']);
				 unset($cf['_wp_trash_meta_time']);
				 unset($cf['_edit_lock']);
				 unset($cf['_edit_last']);				 
				 unset($cf['post_title']);
				 unset($FF['post_title']);			
				 unset($cf['post_excerpt']);
				 unset($FF['post_excerpt']);				 
				 unset($cf['post_content']);
				 unset($FF['post_content']);
				 unset($cf['id']);
				 
				// ADD ON THE CUSTOM FIELDS TO THE OUTPUT DATA
				if(is_array($FF)){
					 foreach($FF as $key=>$val){
					 if($key == "post_id" || $key == "ID"){ continue; } 
						if(isset($cf[$key])){
						$dat[$key] = $cf[$key][0];
						}else{
						$dat[$key] = "";
						}
					 }
				 } 
				
				// ADD IN SKU
			 	if(!isset($dat['post_id'])){	$dat['post_id'] = $dat['ID'];	}	
		 
				//die(print_r($dat));
				// SAVE DATA INTO ARRAY
				if(strlen(trim($dat['post_title'])) > 2){
				$allposts[] = $dat; 
				}	
			
			}
   			if(is_array($allposts) && !empty($allposts)){
			header("Content-Type: text/csv");
			header("Content-Disposition: attachment; filename=CSV-".date('l jS \of F Y h:i:s A')." .csv"); 

			$export = new data_export_helper($allposts);
			$export->set_mode(data_export_helper::EXPORT_AS_CSV);
			$export->export($export);
			
			echo $export;
			die();
			}else{
			die("<h1>There is no data to export</h1>"."Query run: ".$SQL);
			}
			
			} break;
		
			case "delete": { 
			
				// DELETE DATABASE TABLE
				$wpdb->query("DROP TABLE ".$_GET['id']);				
				// GET THE CURRENT VALUES
				$existing_values = get_option("wlt_csv");
				unset($existing_values[$_GET['id']]);		
				// UPDATE DATABASE 		
				update_option( "wlt_csv", $existing_values);
				
				// REMOVE FILE NAME FROM LIST
				$csv_files = get_option("wlt_csv_filenames");
				if(!is_array($csv_files)){ $csv_files = array(); }
				unset($csv_files[$_GET['id']]);
				update_option("wlt_csv_filenames", $csv_files);

				// LEAVE FRIENDLY MESSAGE
				$GLOBALS['error_message'] = "Deleted Successfully";
			
			
			} break;
			
			case "deleteall_posts": { 
		 
			$wpdb->query("delete a,b,c,d
			FROM ".$wpdb->prefix."posts a
			LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
			LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
			LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
			LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
			WHERE a.post_type = 'post' OR a.post_type = 'listing_type' OR a.post_type = 'coupon_type' ");
			
			echo "<h1>Action Successfull</h1>";
			die();
			
			} break;	
 
		
		}// end switch
	} // end if


}
add_action('admin_init','wlt_csv_init');

 
 
// 3. BUILD DISPLAY
function wlt_csv(){ global $wpdb, $CORE, $WLT_ADMIN;
// DISPLAY THE PAGE TITLE FOR ADMIN INTERFACE
$GLOBALS['admin_title'] = "CSV Import Tool";
$GLOBALS['admin_image'] = plugins_url()."/wlt_csv/img/csvb.png";

if(isset($_GET['wlt_csv_action'])){
$GLOBALS['error_message'] = "Import Completed";
}
/*
if(isset($_GET['autocleanupt'])){
	$csv_values = get_option("wlt_csv");
	if(is_array($csv_values)){ foreach($csv_values as $key=>$row){  if($key == "0"){ continue; } 
	
		$industry_identify = array('upc','mpn','isbn','ean','sku');
		$sql = "DELETE FROM $key WHERE";
		foreach($industry_identify as $j){
			$sql .= " $j = '' AND";
			$i++;
		}
		$sql .= "";
		$GLOBALS['error_message'] = "Tables Modified";
		die($sql);
	} }
}
*/
if(isset($_POST['database_table']) && $_POST['database_table'] !=""){
//die(print_r($_POST['table1']).print_r($_POST['table2']));
	foreach($_POST['table1'] as $key=>$val){
	
		if($val != $_POST['table2'][$key]){
		
			$SQL = "ALTER TABLE ".$_POST['database_table']." CHANGE  `".$val."`  `".$_POST['table2'][$key]."` TEXT";
		 
			mysql_query($SQL); // CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL
		
			$GLOBALS['error_message'] = "Table Changes Completed";
		}
	}
}
// LOAD IN CORE VALUES
$csv_values = get_option("wlt_csv");

// GET FILE NAMES
$csv_files = get_option("wlt_csv_filenames");

// GET LIST OF COMPARED TABLES
$compared_tables = get_option('wlt_comparedtables');
if(!is_array($compared_tables)){ $compared_tables = array(); }

// DISPLAY ADMIN TEMPLATE
echo $WLT_ADMIN->HEAD();  

?>
</form>
 
<div class="tab-pane fade active in" id="home">
<div class="row-fluid"><div class="span8">

<?php

if (get_magic_quotes_gpc()) { ?>
<div class="alert alert-block alert-error fade in">           
            <h4 class="alert-heading">Magic Quotes Detected</h4>
            <p>Please disable PHP magic quotes on your hosting account before running any imports otherwise it will fail.</p>
          </div>

<?php }

if(strpos(phpversion(),'5.3') !== false){ ?>
<div class="alert alert-block alert-error fade in">           
<h4 class="alert-heading">PHP Version <?php echo phpversion(); ?> Detected</h4>
<p>Your hosting is running PHP version <?php echo phpversion(); ?> which may prevent local CSV files from being imported. If you cannot upload CSV files please ask your hosting to upgrade your PHP version to 5.4+.</p>
</div>     
<?php } ?>      
      
<div class="box gradient"><div class="title">
 
 
<a data-toggle="modal" href="#myModal" class="btn btn-success" style="float:right;margin-right:10px;margin-top:5px;" >Upload CSV File</a>
 
<h3><i class="icon-th-list"></i><span>Saved CSV Files</span></h3></div>

<div class="content">



<!--- START AUTO REFRESH OF IMPORTED CONTENTS --->
<div class="CSVCOREUPDATEID" id="CSVCOREUPDATEID"></div>
<form method="post" action="<?php echo get_home_url(); ?>/wp-admin/admin.php?page=wlt_csv&t=456" name="runnextimport" id="runnextimport" target="csvimportframe">
<input type="hidden" name="wlt_csv_action" value="startimport"  />
<input type="hidden" name="csv_key" id="csv_key" value="0" />
<input type="hidden" name="csv_total" id="csv_total" value="0" />
<input type="hidden" name="csv_pagenumber" id="csv_pagenumber" value="0" />
</form>
<iframe name="csvimportframe" id="csvimportframe" src="#" style="display:none;"></iframe>
<script type="text/javascript">
function WLTUpdateImport(){
	// GET VALUES
    var total = jQuery('#csv_total').val();
    var key = jQuery('#csv_key').val();
    var page = jQuery('#csv_pagenumber').val();
	// RUN IMPORT
	jQuery('#runnextimport').submit(); 
	// SHOW USER OUTPUT
    CoreDo('<?php echo str_replace("http://","",str_replace("https://","",get_home_url())); ?>/wp-admin/admin.php?page=wlt_csv&action=dome&k='+key+'&p='+page+'&t='+total, 'CSVCOREUPDATEID');
	// UPDATE WITH NEW PAGE VALUES
	jQuery('#csv_pagenumber').val(parseFloat(page)+1);
}
function StartImportCSV(key,total){
	jQuery('#CSVCOREUPDATEID').html('Please Wait...');
	jQuery('#csv_key').val(key);
	jQuery('#csv_total').val(total);
	jQuery('#csv_imports').hide();
	// START IMPORT THE FIRST TIME
	WLTUpdateImport();
	// THEN WAIT EVERY 2 MINUTES
	 setInterval( "WLTUpdateImport()", 30000 );
}
</script>
<script src="<?php echo FRAMREWORK_URI.'js/core.ajax.js'; ?>" type="text/javascript"></script>
 <script>
function changeboxme(id){

 var v = jQuery("#"+id).val();
 if(v == 1){
 jQuery("#"+id).val('0');
 }else{
 jQuery("#"+id).val('1');
 }
 
}
</script>
<!---------- END AUTO REFRESH SYSTEM ------------->



  <table id="csv_imports" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
            <thead>
            <tr>
              <th class="no_sort">Stored Table</th>
              <th class="no_sort" style="width:150px;text-align:center;">Rows</th>   
             
              <th class="no_sort" style="width:42px;text-align:center;">Delete</th>
            </thead>
            <tbody>
            
       <?php 
	   $o=1;
	   if(is_array($csv_values)){
	   foreach($csv_values as $key=>$row){  if($key == "0"){ continue; }  $o++;
	   ?>
		<tr>
         <td>
		 
		 <?php if(isset($csv_files[$key])){ echo $csv_files[$key]['name']; }else{ echo $key; } ?>
         
         <hr style="margin:5px;" />
         

<?php if(defined('WLT_COMPARISON')){ ?>
<form method="post" name="savecomparetable<?php echo $o; ?>">
<input type="hidden" name="savecompare" value="1" />
<label class="checkbox" style="background:transparent; width:130px; float:right; margin-top:-5px; font-size:12px;"> 
<input type="checkbox" <?php if(in_array($key, $compared_tables)){ echo 'checked=checked'; } ?>  onchange="changeboxme('box<?php echo $o; ?>');" onclick="document.savecomparetable<?php echo $o; ?>.submit();" value="1"  /> <span>Enable Compare</span>
<input type="hidden" name="savecompare_value" <?php if(in_array($key, $compared_tables)){ echo 'value="1"'; }else{ echo 'value="0"';} ?> id="box<?php echo $o; ?>" />
<input type="hidden" name="savecompare_table" value="<?php echo $key; ?>"  />
</label>
</form>
<?php } ?>

<a class="btn btn-small" rel="tooltip" data-toggle="modal" href="#myModal1" data-placement="left" data-original-title="import" 
onclick="jQuery('#csv_key1').val('<?php echo $key; ?>');jQuery('#csv_row1').val('<?php echo $row; ?>');"><i class="gicon-edit"></i> Import File</a> 


         </td>
         <td style="text-align:Center;"><?php echo number_format($row); ?> <br /><a href="javascript:void(0);" onclick="jQuery('#sample_<?php echo $key; ?>').show();" class="label" style="color:#fff;">preview</a></td>
        
         <td class="ms">
                 <div class="btn-group1">
                <a style="margin-right:3px;" class="btn btn-inverse btn-small" rel="tooltip" data-placement="bottom" 
                  data-original-title="Remove"
                  href="admin.php?page=wlt_csv&wlt_csv_action=delete&id=<?php echo $key; ?>"
                  ><i class="gicon-remove icon-white"></i></a> 
                </div>
         </td>
         </tr>
         <tr>
         <td colspan="3"  id="sample_<?php echo $key; ?>" style="display:none;">
         
         <p><b>Sample Saved Data</b> This is a sample of the first row of the imported CSV file.</p>
         
  
  
  <form method="post" enctype="multipart/form-data">
  <input type="hidden" name="database_table" value="<?php echo $key; ?>" />
  
         <table class="table table-bordered table-striped">
            <colgroup>
              <col class="span1">
              <col class="span7">
            </colgroup>
            <thead>
              <tr>
                <th>Database Key</th>
                <th>Column Value</th>
              </tr>
            </thead>
            <tbody>
<?php
$check_headers = array();
$row = $wpdb->get_results("SELECT * FROM ".$key." LIMIT 1", OBJECT);
foreach($row[0] as $key1=>$val){ if($key1 == ""){ continue; } 
$check_headers[$key1] = $key1;

?>
<tr><td>
<code><?php echo $key1; ?></code><small> - <a href="javascript:void(0);" onclick="jQuery('#changeme_<?php echo $key1; ?>').show();">rename</a></small>
<input type="hidden" name="table1[]" value="<?php echo $key1; ?>" />
<input type="text" style="display:none;" name="table2[]" id="changeme_<?php echo $key1; ?>" value="<?php echo $key1; ?>" />

</td><td><div style="max-width:300px;"><?php echo $val; ?></div></td></tr>

      
<?php } ?>        
              
            </tbody>
          </table>
          
          
          <hr />
          
          <button type="submit" class="btn">Save Changes</button>
         <a href="javascript:void(0);" onclick="jQuery('#sample_<?php echo $key; ?>').hide();" class="label label-info" style="color:#fff;float:right;">hide preview</a>
         
         </td>
         </tr>
        <?php } } ?> 
        

<?php 

// CHECK THE HEADERS OTHERWISE SHOW WARNING
$showError = false; $showErrMsg = "";
$check_these_headers = array('post_title','post_content');
if(is_array($check_headers)){
foreach( $check_these_headers as $h){
	if(!in_array($h,$check_headers)){
		$showError = true;
		$showErrMsg .= "Missing Column Header: <b>".$h."</b><br />";
	}
}
}

if($showError){ ?> 
<tbody>     
<tr><td colspan="2">
<div class="alert alert-error">
<b>Warning!</b> Your CSV file is missing default columns headers. Any attempt to import will result in errors.
<hr /><?php echo $showErrMsg; ?>
<hr />
<?php if(is_array($row[0])){ ?>
<a href="<?php echo get_home_url(); ?>/wp-admin/admin.php?page=wlt_csv&autofix=<?php echo $key; ?>" class="btn btn-error">Run Auto Fix</a>
<hr />
<?php } ?>
<a href="http://s.premiumpress.com/index.php?/Knowledgebase/Article/View/27/0/using-excel-spreadsheets-csv" target="_blank" style="color:#b94a48; text-align:center; text-decoration:underline">click here to see this knowledgebase article.</a>

</div>
</td><td>
</tbody> 
 
<?php } ?>         
            

</tbody>  </table> 

</form>

</div>

</div>
<!-- End .box -->




</div><div class="span4">


    
  
    

   
           
           
 
 
 
 
 <!-- SETTINGS ---->
 
 <div class="box gradient"><div class="title"><h3><i class="icon-share-alt"></i><span>Plugin Settings</span></h3></div>
 <div class="padding" style="padding:10px;">


<div class="well">

<b>Export Settings</b> 
 <hr />
<ul>
 <?php
 
$t	= $wpdb->get_row("SELECT count(*) as count FROM $wpdb->posts WHERE post_type='".THEME_TAXONOMY."_type'");
 if($t->count != 0){ 
 $rows= round($t->count/1000,1);
 } 
  
 echo '<li><a href="admin.php?page=wlt_csv&wlt_csv_action=export" class="btn">Export All ('.$t->count.' Listings)</a></li>';
   
 if($rows > 0){
  
   		$i=0; 
	   while($i < $rows){
	    $csv_s = $i*1000;
	    $csv_e = 1000;
		echo '<li>- <a href="admin.php?page=wlt_csv&wlt_csv_action=export&s='.$csv_s.'&e='.$csv_e.'" style="text-decoration:underline;">Export Records '.$csv_s.' - '.($csv_s+$csv_e).'</a></li>';
		$i++;
	   }
    } 
	
	?> 
</ul>
</div>



<div class="well">

<b>Cleanup Settings</b> 
 <hr />
 
 <a href="admin.php?page=wlt_csv&wlt_csv_action=deleteall_posts" class="btn confirm">Delete all posts</a>   
        
 
 
 </div>


</div></div></div>  


          
           
           
           
           
           
           
                 
        </div> 
        
         
        <!-- End .box -->
      </div>
  
    
  </form>
  
    
</div>


 


<form method="post" action="<?php echo get_home_url(); ?>/wp-admin/admin.php?page=wlt_csv" name="savechartset">
<input type="hidden" name="charset" value="" id="charset" />

</form>
  
 
 <form method="post" enctype="multipart/form-data" action="<?php echo get_home_url(); ?>/wp-admin/admin.php?page=wlt_csv">
 

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3 id="myModalLabel">Import CSV File</h3>
            </div>
            <div class="modal-body" style="min-height:350px;">
            
             Please ensure your .csv file is correctly formatted before uploading. If you are unsure how to format your files, please see this link: <b><a href="http://s.premiumpress.com/index.php?/Knowledgebase/Article/View/27/0/using-excel-spreadsheets-csv" target="_blank" style="text-decoration:underline;color:blue;">Formatting CSV Files</a></b> 
            <hr  />
            
            <b>What to import an XML file?</b> All you need todo is convert it to CSV format using this free online tool: <a href="http://www.luxonsoftware.com/converter/xmltocsv" target="_blank" style="text-decoration:underline;color:blue;">XML to CSV convertor</a>
              
               <hr  />
                
  
  
  <input type="hidden" name="use_csv_header" id="use_csv_header" value="1" />
  
  
  
  <table class="table table-bordered table-striped">
          
         
            <tbody>
              <tr>
                <td>
                  <code>CSV File</code>
                </td>
                <td>   <div class="controls">
                  <div class="input-append row-fluid">
                    <input type="file"  name="file_source" id="file_source"> 
                    
                    <script>
jQuery(document).ready(function () {
jQuery.uniform.restore('input:file');
jQuery('#file_source').removeAttr( 'style' );
});
</script>
<style>
#file_source { opacity: 1; }
</style>
                     
                  </div>
                </div>
               
                </td>
              </tr>
              <tr>
                <td>
                  <code>Column Separator</code>
                </td>
                <td><input type="text" name="field_separate_char" id="field_separate_char" class="edt_30"  maxlength="1" value=","/></td>
              </tr>
              <tr>
                <td>
                  <code>Text qualifier /Enclose</code>
                </td>
                <td><input type="text" name="field_enclose_char" id="field_enclose_char" class="edt_30"  maxlength="1" value="<?php echo htmlspecialchars("\""); ?>"/></td>
              </tr>
              <tr>
                <td>
                  <code>Text Escape</code>
                </td>
                <td><input type="text" name="field_escape_char" id="field_escape_char" class="edt_30"  maxlength="1" value="<?php echo htmlspecialchars("\\"); ?>"/></td>
              </tr>
             
            </tbody>
          </table>
             
            </div>
            
            <div class="modal-footer">
              <button class="btn" data-dismiss="modal">Close</button>
              <button class="btn btn-primary" type="submit">Save File</button>
            </div>
</div>

</form> 


<div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModal1Label" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3 id="myModalLabel">Import Options</h3>
            </div>
            <div class="modal-body" style="min-height:400px; text-align:center;" id="modal-body1">
            
            
            <h2 style="margin:0px;">Slow Import</h2> 
            <p>This is the recommended option for users on shared hosting accounts. It will take longer to import but has a better success rate for server setups with limitations on script execution times.
            </p>
             <a class="btn btn-large" rel="tooltip" 
                  href="javascript:void(0);" onclick="StartImportCSV(jQuery('#csv_key1').val(),jQuery('#csv_row1').val());"
                  data-placement="left" data-original-title="start import" data-dismiss="modal"><i class="gicon-edit"></i> Start Slow Import</a> 
                  
                  <hr />
                  
                  <h2 style="margin:0px;">Quick Import</h2>
                  <p>This will attempt to import all items in one go. If you have a small amount of items to import this will run fine however if your file contains alot of data many hosting settings will timeout after a few minutes and so the slow import is recommended.
                  </p>
                  
<form method="post" action="<?php echo get_home_url(); ?>/wp-admin/admin.php?page=wlt_csv&t=456" onsubmit="document.getElementById('modal-body1').innerHTML='Please Wait...<br><br>(this could take some time!)';">
<input type="hidden" name="wlt_csv_action" value="startimport"  />
<input type="hidden" name="csv_key" id="csv_key1" value="0" />
<input type="hidden" name="csv_total" id="csv_total1" value="0" />
<input type="hidden" name="csv_row" id="csv_row1" value="0" />
<input type="hidden" name="csv_pagenumber" id="csv_pagenumber1" value="0" />
<input type="hidden" name="runall" value="yes" />
<button type="submit" class="btn btn-large"  rel="tooltip" data-placement="left" data-original-title="start import">Start Quick Import</button>
</form>
            
            </div>
</div>

<?php
// LOAD IN FOOTER
echo $WLT_ADMIN->FOOTER(); }
 
?>
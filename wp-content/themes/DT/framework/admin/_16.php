<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;

if(!defined('WLT_DEMOMODE')){

	if(isset($_GET['delete_file']) && is_numeric($_GET['delete_file'] )){
	
		// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
		$wlt_languagefiles = get_option("wlt_languagefiles");
		if(!is_array($wlt_languagefiles)){ $wlt_languagefiles = array(); }
		
		// LOOK AND SEARCH FOR DELETION
		foreach($wlt_languagefiles as $key=>$pak){
			if($key == $_GET['delete_file']){
				unset($wlt_languagefiles[$key]);
				
				// DELTE FILE ITSEFl
				if(file_exists($pak['path'])){
					@unlink($pak['path']);
				}	 
			}
		}
		
		// SAVE ARRAY DATA
		update_option( "wlt_languagefiles", $wlt_languagefiles);
		
		$_POST['tab'] = "files";
		$GLOBALS['error_message'] = "File Deleted Successfully";
	
	}
	
	if(isset($_POST['action']) && $_POST['action'] == "upload"){

 
  	// UPLOAD THE FILE FIRST TO THE SERVER
  	$uploads = wp_upload_dir();  
	copy($_FILES['langfile']['tmp_name'], $uploads['path']."/".$_FILES['langfile']['name']);

	  // IF ITS COMPRESSED, UNZIP IT
	  $lastthree = substr($_FILES['langfile']['name'],-3);
	  if($lastthree == ".gz" || $lastthree == "zip"){
			$dir_path = str_replace("wp-content","",WP_CONTENT_DIR);
			require $dir_path . "/wp-admin/includes/file.php";
			WP_Filesystem();
			$zipresult = unzip_file( $uploads['path']."/".$_FILES['langfile']['name'], $uploads['path']."/unzipped/" );
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
					$file_name = $uploads['path']."/".$unzippedfilename;
					// DELETE THE ZIP FOLDER AND FILE
					unlink($uploads['path']."/unzipped/".$unzippedfilename);
					unlink($uploads['path']."/".$_FILES['langfile']['name']);
					rmdir($uploads['path']."/unzipped/");				
				}			
			 
			 }		 
	  }else{
	  
		$file_name 				= $uploads['path']."/".$_FILES['langfile']['name'];  
	  
	  }
	  
	$newfile = array("name" => $_FILES['langfile']['name'], "path" => $file_name, "date" => date('Y-m-d H:i:s') );
	// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
	$wlt_languagefiles = get_option("wlt_languagefiles");
	if(!is_array($wlt_languagefiles)){ $wlt_languagefiles = array(); }
	// ADD ONE NEW FIELD 
	if(!isset($_POST['eid'])){
		array_push($wlt_languagefiles, $newfile);		
		$GLOBALS['error_message'] = "Email Created Successfully";
	}else{
		$wlt_languagefiles[$_POST['eid']] = $newfile;		
		$GLOBALS['error_message'] = "Email Updated Successfully";
	}
	// SAVE ARRAY DATA		 
	update_option( "wlt_languagefiles", $wlt_languagefiles);

 
	}
	// DOWNLOAD LANGUAGE FILE
	if(isset($_GET['downloadfile'])){
		$file = str_replace("//","/",THEME_PATH . "/framework/_language.php");
		include(TEMPLATEPATH."/framework/class/class_pclzip.php");
		  $uploads = wp_upload_dir();
		  $template_name = "language_file";		  
		  
		  // 2. REMOVE OLD FILES
		  if (file_exists($uploads['path']."/".$template_name.".zip")) {
			@unlink($uploads['path']."/".$template_name.".zip"); 
		  } 	  
		
		  // 4. ZIP EVERYTHING TOGETHER	  
		  $zip = new PclZip($uploads['path']."/".$template_name.".zip");
		   
		  $v_list = $zip->add($file,PCLZIP_OPT_REMOVE_ALL_PATH, PCLZIP_OPT_ADD_PATH, $template_name);
		  $v_list = $zip->add(str_replace("//","/",THEME_PATH . "/framework/_language_FR.php") ,PCLZIP_OPT_REMOVE_ALL_PATH, PCLZIP_OPT_ADD_PATH, $template_name);
		  
		  if ($v_list == 0) {
			die("Error : ".$zip->errorInfo(true));
		  }
	 
		$file = $uploads['url']."/".$template_name.".zip";
		echo "<h1>Language File Ready</h1>";
		echo "<p>click the link below to download your language file</p>";
		echo "<a href='".$file."'>Download File</a>";
		die(); 
	
	}

	// SAVE LANGUAGE FILE MODIFICATIONS
	if(isset($_POST['pplang']) && is_array($_POST['pplang']) ){
		update_option("core_language",$_POST['pplang']);
	}
}

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

// LOAD IN LANGUAGE FILES
$wlt_languagefiles = get_option("wlt_languagefiles");
if(!is_array($wlt_languagefiles)){ $wlt_languagefiles = array(); }
	   
// LOAD IN HEADER
echo $CORE_ADMIN->HEAD(); ?>
  
<ul id="tabExample1" class="nav nav-tabs">
<?php
// HOOK INTO THE ADMIN TABS
function _16_tabs(){ $STRING = ""; global $wpdb; $core_admin_values = get_option("core_admin_values");
	
	if(isset($_GET['tab'])){ $_POST['tab'] = $_GET['tab']; }
	
	$pages_array = array(  
	"1" => array("t" => "Text Translations", "k"=>"home", "d" => true), 
	"2" => array("t" => "Language Files", "k"=>"files", ), 
	);
	foreach($pages_array as $page){	
	if( ( isset($_POST['tab']) && $_POST['tab'] == $page['k']  ) || ( !isset($_POST['tab']) && $page['k'] == "home" )  ){ $class = "active"; }else{ $class = ""; }	
		if(isset($_POST['tab']) && $_POST['tab'] == "" && isset($page['d']) ){ $class = "active"; }
		$STRING .= '<li class="'.$class.'"><a href="#'.$page['k'].'"  onclick="document.getElementById(\'ShowTab\').value=\''.$page['k'].'\'" data-toggle="tab">'.$page['t'].'</a></li>';		
	} 
	return $STRING;

}
echo hook_admin_16_tabs(_16_tabs());
// END HOOK
?>                         
</ul>
 
 
<div class="tab-content"> 

<?php do_action('hook_admin_16_content'); ?>



<!--------------------------- FILES TAB ---------------------------->

<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "files"){ echo "active in"; } ?>" id="files">

<div class="row-fluid">
<div class="span6">

 

   <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
            <thead>
            <tr>
              <th class="no_sort">Filename </th>
                            
              <th class="no_sort" style="width:110px;text-align:center;">Actions</th>
              
            </thead>
            <tbody>
            
        <?php foreach($wlt_languagefiles as $key=>$field){ ?>
		<tr>
         <td>
         
		 <p><?php echo stripslashes($field['name']); ?></p>
		 <small>added <?php echo hook_date($field['name']); ?></small>
         
         </td>         
        
         <td class="ms">
         <center>
                <div class="btn-group1">
                                    
                  <a class="btn btn-inverse btn-small confirm" rel="tooltip" data-placement="bottom" 
                  data-original-title="Remove"
                  href="admin.php?page=16&delete_file=<?php echo $key; ?>"
                  ><i class="gicon-remove icon-white"></i></a> 
                </div>
            </center>
            </td>
            </tr>
            <?php  }   ?> 

            </tbody>
            </table>
<hr /> 

<a data-toggle="modal" href="#EmailModal" class="btn btn-success">Upload Language File</a>


</div>
<div class="span6">

<div class="box gradient">
<div class="title">

<a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('lkuP0JEsbjY','videoboxplayer','479','350');" style="float:right;margin-top:5px; margin-right:5px;">Watch Video</a>

<div class="row-fluid"><h3><i class="icon-wrench"></i> Settings</h3></div></div><div class="content">


<?php if(defined('CUSTOM_LANGUAGE_FILE')){ ?>
<p class="alert alert-info">The child theme your running has a custom language file enabled therefore this section has been disabled.</p>
<?php }else{ ?>
<br />
<label class="control-label span4" for="default-select">Display Language</label>
<div class="controls span7">
<select name="admin_values[language]"  id="language">
<option>English</option>

		<?php
		
		$HandlePath = TEMPLATEPATH . '/templates/'.$core_admin_values['template'].'/';	
	 
	    $count=1;
		if($handle1 = opendir($HandlePath)) {
      
	  	while(false !== ($file = readdir($handle1))){	

		if(substr($file,-4) ==".php" && substr($file,0,8) == "language"){
		$file = str_replace(".php","",$file); 
		$name = explode("_",$file);
		?>
			<option <?php if ($core_admin_values['language'] == $file) { echo ' selected="selected"'; } ?> value="<?php echo $file; ?>"><?php echo $name[1]." ".$name[0]; ?></option>
		<?php
		} }}


		$HandlePath = TEMPLATEPATH . '/framework/';	
	 
	    $count=1;
		if($handle1 = opendir($HandlePath)) {
      
	  	while(false !== ($file = readdir($handle1))){	

		if(substr($file,-4) ==".php" && substr($file,0,10) == "_language_"){
		$file = str_replace(".php","",$file); 
		$name = explode("_",$file);
		?>
			<option <?php if ($core_admin_values['language'] == $file) { echo ' selected="selected"'; } ?> value="<?php echo $file; ?>"><?php echo $name[0]." ".$name[2]; ?></option>
		<?php
		} }} 
		
		// CHECK IF CHILD THEME HAS A LANGUAGE FILE 
		
		?>
        
<?php foreach($wlt_languagefiles as $key=>$field){ ?>
<option value="<?php echo $key; ?>" <?php if (is_numeric($core_admin_values['language']) && $core_admin_values['language'] == $key) { echo "selected=selected"; } ?>><?php echo $field['name']." (".$field['date'].")"; ?></option>
<?php } ?>
</select>
</div>
<?php } ?> 

<div class="clearfix"></div>

<div class="well">

<b>Note</b> additional language files provided are for example purposes only. We do not guarantee the language file transaction accuracy.
</div>

<hr />

<div style="text-align:center;padding:20px;">
<a href="admin.php?page=16&downloadfile=1" style="padding: 20px;border-radius: 10px;background: #ddd;text-align: Center;">Download Core Language File</a>
</div>

<div class="clearfix"></div>
 
</div> <!-- End .content --> 
</div><!-- End .box --> 



</div>
</div></div>



<!--------------------------- LANGUAGE TAB ---------------------------->
 
 	
<div class="tab-pane fade <?php if(!isset($_POST['tab']) || ( isset($_POST['tab']) && ( $_POST['tab'] =="" || $_POST['tab'] =="home" ) )){ echo "active in"; } ?>" id="home">

 
<div class="row-fluid">
<div class="box gradient span8">
 

<div class="title">
 	
<div style="float:right;width:320px;">
<input type="text" id="searchtextquery" name="searchtextquery" class="blur" placeholder="Keyword.." style="height: 30px;margin-top: 7px;">
<input type="button" value="Search Text" class="btn btn-info" onclick="jQuery('#searchtextquery1').val(jQuery('#searchtextquery').val());document.gosearchtext.submit();return false;">
</div>	



<h3><i class="icon-font"></i><span>Text</span></h3></div><div class="content">
         
 

<div class="accordion" id="accordion5">
<?php  $CORE->Language(); $sl = get_option("core_language"); 

 
// GET ARRAY KEYS
$i=0; $STRING = ""; 
 

$titles = array(

 		"button" 		=> "Button Translations",
		"date" 			=> "Date &amp; Time Translations",
		"validate"		=> "Validation, Warning/Message Alert Translations",		
		
		"widgets" 		=> "Widget Text",
		"mobile" 		=> "Mobile Text",
		"order_status" 	=> "Order Status",		
		"head"			=> "Header (header.php) Translations ",	
		"homepage" 		=> "Home Page (index.php) Translations",
		"single" 		=> "Listing Page (single.php) Translations",
		"gallerypage" 	=> "Gallery Page (index.php) Translations",
		"add"			=> "Submission Page (tpl_add.php) Translations",
		"checkout"		=> "Checkout Page (tpl_checkout.php) Translations",	
		"account"		=> "My Account Page (tpl_account.php) Translations",
		"callback"		=> "Callback Page (tpl_callback.php) Translations", 
		"author" 		=> "Author Page (author.php)",
		"comment" 		=> "Comment Form Translations", 		
		"login" 		=> "Login Page Translations",		
		"listvalues"	=> "Listing Values",		
		"graphs"		=> "Graphs",
		"feedback"		=> "Feedback System",
		"mobile"		=> "New Mobile Website",		
		"coupons"		=> "Coupon Theme",
		"auction"		=> "Auction theme",
		"job"			=> "Job Board Theme",
		"dealer"		=> "Car Dealer Theme",
		"dating"		=> "Dating Theme",
		"software"		=> "Software Theme",
		"mjob"			=> "Mico Jobs Theme",
	 
);
 
// GET THE KEY NAME FROM THE LANGUAGE FILE
$dlang = array_keys($GLOBALS['_LANG']); 

$dlang = $dlang[1];

// LOOP ALL TITLES ABOVE
foreach($titles as $tkey => $tdesc){
  			
		$STRING .= '<div class="accordion-group"><div class="accordion-heading"><a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapseOne'.$i.'">
		<span class="label label-success">'.$i.'</span> '.$tdesc.' </a></div>		
		 <div id="collapseOne'.$i.'" class="accordion-body collapse">';
		 
		$STRING .= '<div class="accordion-inner"><table width="100%" border="0"><th>Current Text</th><th>Your Translation Here</th>';
	 
		foreach($GLOBALS['_LANG'][$dlang][$tkey] as $key => $val){		 
		
			 if(isset($_GET['searchtextquery1']) && strlen($_GET['searchtextquery1']) > 1 && strpos(strtolower($val), strtolower($_GET['searchtextquery1']) ) !== false){ 
				$STRING = str_replace('id="collapseOne'.$i.'" class="accordion-body collapse"', 'id="collapseOne'.$i.'" class="accordion-body"', $STRING); 
				$bull = " "; 
				$rowhighlighted = "style='border:1px solid red;'"; 
			 }else{		 
				$bull = "";
				$rowhighlighted = "";
			 } 
		
		  	$STRING .=' <tr>
			<td>'.$bull.'<input name="" type="text" class="row-fluid" value="'.$val.'" style="background:#dfdfdf;" /></td>
			<td>'.$bull.'<input name="pplang['.$dlang.']['.$tkey.']['.$key.']" type="text" class="row-fluid"
			value="';
			if(isset($sl[$dlang][$tkey][$key])){ $STRING .= stripslashes($sl[$dlang][$tkey][$key]); }
			$STRING .='" '.$rowhighlighted.' /></td></tr>'; // style="width:350px;"
		
		}
		
		// clean up 
		$STRING = str_replace("activateme".$i,"", $STRING); 
		
		$STRING .= '</table></div></div>';
	 
	
		$STRING .= '</div>';
		$i++;
	
	
}// end foreach

 
echo $STRING; 
?>
 
 </div></div>
          
 <?php do_action('hook_admin_1_tab3_left'); ?>
          
 
<div class="clearfix"></div>

    </div><!-- End .box -->

<div class="box gradient span4"><div class="title">

<a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('epkGjAKtOv8','videoboxplayer','479','350');" style="float:right;margin-top:5px; margin-right:5px;">Watch Video</a>

<div class="row-fluid"><h3><i class="icon-wrench"></i> Settings</h3></div></div><div class="content">

<div class="form-row control-group row-fluid">

 

			<div class="form-row row-fluid span11 ">
                            <label class="control-label span7" rel="tooltip" data-original-title="This will allow you to edit text and titles live via the front end of your website." data-placement="top">Admin Live Editor</label>
                            <div class="controls span5">
                              <div class="row-fluid">                              
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('admin_liveeditor').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('admin_liveeditor').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['admin_liveeditor'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                            
                             
                             <input type="hidden" class="row-fluid" id="admin_liveeditor" name="admin_values[admin_liveeditor]" 
                             value="<?php echo $core_admin_values['admin_liveeditor']; ?>">
            </div>
            
            
            
         <div class="clearfix"></div>

       <div class="form-row control-group row-fluid " style="margin-top:10px; padding-top:15px; border-top:1px solid #ddd;">
                            <label class="control-label span7" rel="tooltip" data-original-title="Enabling this will check your available languages and try to display one that's based on the users location." data-placement="top">GEO Languages</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('geolanguage').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('geolanguage').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['geolanguage'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="geolanguage" name="admin_values[geolanguage]" 
                             value="<?php echo $core_admin_values['geolanguage']; ?>">
            </div> 





</div>

 
 <?php do_action('hook_admin_1_tab3_right'); ?>
       
      
        </div> <!-- End .content --> 
    </div><!-- End .box --> 

    
 </div> </div> 
 
 
 




</div>



<!-- start save button -->
<div class="form-actions row-fluid">
<div class="span7 offset5">
<button type="submit" class="btn btn-primary">Save Changes</button> 
</div>
</div> 
<!-- end save button -->
 
</div>
</form>

<form method="GET" action="admin.php" style="width:300px;float:right;" name="gosearchtext" id="gosearchtext">
<input type="hidden" name="page" value="16" />
<input type="hidden" name="tab" value="home" />
<input type="hidden" name="searchtextquery1" value="" id="searchtextquery1" />
</form>




<form method="post" name="admin_email" id="admin_email" action="admin.php?page=16" enctype="multipart/form-data">
<input type="hidden" name="action" value="upload" />
<input type="hidden" name="tab" value="files" />
 
<div id="EmailModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="EmailModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3 id="myModalLabel">New Language File</h3>
            </div>
            <div class="modal-body">
              
                
          	 
             <p><input name="langfile" type="file" /></p>
              
           
           
              
            </div>
            
            <div class="modal-footer">
              <a class="btn" href="admin.php?page=3">Close</a>
              <button class="btn btn-primary">Upload</button>
            </div>
</div>
</form>

<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); ?>
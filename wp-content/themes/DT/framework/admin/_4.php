<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;
// LOAD IN MAIN DEFAULTS
$core_admin_values = get_option("core_admin_values"); 


if(!defined('WLT_DEMOMODE')){

	if(isset($_POST['action']) && $_POST['action'] == "padupload"){
	 	 
		$i=0;
		foreach($_FILES['file'] as $fileUpload){
		
		$xml = new SimpleXMLElement(file_get_contents($_FILES['file']['tmp_name'][$i]));
		
		// SAVE THE PRODUCT INTO OUR SYSTE,	
		$my_post = array();
		$my_post['post_title'] 		= str_replace("!!%%%","",$xml->Program_Info->Program_Name);
		$my_post['post_content'] 	= str_replace("!!%%%","",$xml->Program_Descriptions->English->Char_Desc_2000);
		//$my_post['post_excerpt'] 	= str_replace("!!%%%","",$xml->Program_Descriptions->English->Char_Desc_80);
		$my_post['post_author'] 	= 1;
		$my_post['post_type'] 		= THEME_TAXONOMY."_type";
		$my_post['post_status'] 	= "publish";
		
		if($my_post['post_title'] == ""){
		die("<h1>Invalid PAD File. No title found.</h1>");		
		}
	 
		$POSTID = wp_insert_post( $my_post );
		
		// POST TAGS 
		$tags 		= str_replace("!!%%%","",$xml->Program_Descriptions->English->Keywords);
		if(strlen($tags) > 1){
		wp_set_post_tags( $POSTID, explode(",",$tags), false);	
		}
		
		// POST CUSTOM FIELDS
		$dataArray = array(
		
		"price"	=> 			$xml->Program_Info->Program_Cost_Dollars,
		"price_currency" => $xml->Program_Info->Program_Cost_Other_Code,
	
		"dl_appid"	=> 		$xml->Program_Info->Program_Version,
		"dl_version" =>  	$xml->Program_Info->Program_Version,
		"dl_released" => 	$xml->Program_Info->Program_Release_Year."-".$xml->Program_Info->Program_Release_Month."-".$xml->Program_Info->Program_Release_Day,
		"dl_license" =>  	strtolower(str_replace("!!%%%","",$xml->Program_Info->Program_Type)),
		"dl_requirments" => $xml->Program_Info->Program_System_Requirements,
		"dl_pad_file" 	=>  $xml->Web_Info->Application_URLs->Application_XML_File_URL,
		"dl_system"	=>  $xml->Program_Info->Program_OS_Support,
		"dl_filesize"	=>  $xml->Program_Info->File_Info->File_Size_MB,
	 
		
		"image" => $xml->Web_Info->Application_URLs->Application_Screenshot_URL,
		
		"url" => $xml->Web_Info->Application_URLs->Application_Info_URL,
		
		"download_path" => $xml->Web_Info->Download_URLs->Primary_Download_URL,
		
		"email" => $xml->Company_Info->Contact_Info->Contact_Email,
		
		);
		
		foreach($dataArray as $k=>$d){
			add_post_meta($POSTID,$k,str_replace("!!%%%","",$d));
		}
		
		$savecats = array();
		$programCats = str_replace("!!%%%","",$xml->Program_Info->Program_Categories);
		$cats = explode("::",$programCats);
		$i=0;
		foreach($cats as $catme){
			$catss = explode(",",$catme);
			if($i > 0){ continue; }
			$term1 = wp_insert_term(trim($catss[0]), THEME_TAXONOMY);
					
				if(isset($term1->error_data['term_exists'])){
					$subtaxID = $term1->error_data['term_exists'];
				}else{		
					$subtaxID = $term1['term_id'];	
				}
				
				$savecats[] = $subtaxID;
				$i++;		
		}
		
		// UPDATE CAT LIST
		wp_set_post_terms( $POSTID, $savecats, THEME_TAXONOMY );//$_POST['cat']				
 	
	
		// SETUP DEFAULT DOWNLOAD OPTIONS		
		add_post_meta($POSTID,'download_ops',$core_admin_values['dl_theme_default_ops']);
		
		$i++;
		}
		
		die("done");
 
	}


/* =============================================================================
WALKER CLASSES
========================================================================== */

class Walker_CategorySelection2 extends Walker_Category {  

     function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) { global $CORE; 
	 	
		$GLOBALS['thiscatitemid'] = $item->term_id; 
		  
		// CHECK IF WE HAVE AN ICONS
		$image = "";		
		if(isset($GLOBALS['CORE_THEME']['category_icon_small_'.$item->term_id]) && strlen($GLOBALS['CORE_THEME']['category_icon_small_'.$item->term_id]) > 1){			
			$image = "<i class='fa ".$GLOBALS['CORE_THEME']['category_icon_small_'.$item->term_id]."'></i>"; 
		}		 
		
        
		// CHECK IF PARENT CAT IS DISABLED
		$disableParent = "";
		if( $item->parent == 0 ){	
			$output .= "";
		}else{
				$output .= "-";
		}
  	
		// DISPLAY
		$output .= " ".esc_attr( $item->name )."\n";	 
		 
		
    }  

    function end_el(&$output, $item, $depth=0, $args=array(), $id = 0) {  
        $output .= "";  
    }  
	
	function start_lvl( &$output,  $depth = 0, $args = array(), $id = 0 ) { global $item;
 	 
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);		
		
 
	}
	
	function end_lvl( &$output, $depth = 0, $args = array(), $id = 0 ) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent";
	}
	
	
} 

	if(isset($_GET['task']) && $_GET['task'] != "" && current_user_can('administrator')){

	switch($_GET['task']){
	

		case "getcats": {		
		
		$cats = wp_list_categories(array('walker'=> new Walker_CategorySelection2, 'taxonomy' => THEME_TAXONOMY, 'show_count' => 0, 'hide_empty' => 0, 'echo' => 0, 'title_li' =>  false  ) ); 
		
		echo "<h4>Category List</h4><hr>";
		echo "<textarea style='width:500px;height:700px;'>".$cats."</textarea>";
		die();
		} break;

		case "set1": {		
		$wpdb->query("UPDATE ".$wpdb->prefix."postmeta SET meta_value='yes' WHERE meta_key='featured'");		
		echo "<h1>Listings Updated</h1>";
		die();
		} break;
		
		case "set2": {		
		$wpdb->query("UPDATE ".$wpdb->prefix."postmeta SET meta_value='no' WHERE meta_key='featured'");		
		echo "<h1>Listings Updated</h1>";
		die();
		} break;	
		
		case "set3": {		
		
		$SQL = "SELECT ".$wpdb->posts.".ID FROM ".$wpdb->posts." WHERE ".$wpdb->posts.".post_type = ('".THEME_TAXONOMY."_type') LIMIT 0,200";			 
		$result = mysql_query($SQL, $wpdb->dbh) or die(mysql_error().' on line: '.__LINE__);					 
		if (mysql_num_rows($result) > 0) {while ($val = mysql_fetch_object($result)){
			update_post_meta($val->ID,'tax_required',1);		
		} }
			
		echo "<h1>Products Updated</h1>";
		die();
		} break;
		
		case "set4": {		
		
		$SQL = "SELECT ".$wpdb->posts.".ID FROM ".$wpdb->posts." WHERE ".$wpdb->posts.".post_type = ('".THEME_TAXONOMY."_type') ORDER BY ".$wpdb->posts.".ID DESC LIMIT 0,600";		
		$posts = $wpdb->get_results($SQL);
		foreach($posts as $post){ 
			update_post_meta($post->ID,'tax_required',0);	
		}		
					
		echo "<h1>Products Updated</h1>";
		die();
		} break;	
		
		
		case "set5": {		
		
		$SQL = "SELECT ".$wpdb->posts.".ID FROM ".$wpdb->posts." WHERE ".$wpdb->posts.".post_type = ('".THEME_TAXONOMY."_type') ORDER BY ".$wpdb->posts.".ID DESC LIMIT 0,600";	
		$posts = $wpdb->get_results($SQL);
		foreach($posts as $post){ 
			update_post_meta($post->ID,'ship_required',1);	
		}		
					
		echo "<h1>Products Updated</h1>";
		die();
		} break;
		
		case "set6": {		
		
		$SQL = "SELECT ".$wpdb->posts.".ID FROM ".$wpdb->posts." WHERE ".$wpdb->posts.".post_type = ('".THEME_TAXONOMY."_type') LIMIT 0,200";			 
		$result = mysql_query($SQL, $wpdb->dbh) or die(mysql_error().' on line: '.__LINE__);					 
		if (mysql_num_rows($result) > 0) {while ($val = mysql_fetch_object($result)){
			update_post_meta($val->ID,'ship_required',0);		
		} }
					
		echo "<h1>Products Updated</h1>";
		die();
		} break;

		case "set7": {		
		
		$SQL = "SELECT ".$wpdb->posts.".ID FROM ".$wpdb->posts." WHERE ".$wpdb->posts.".post_type = ('".THEME_TAXONOMY."_type') LIMIT 0,200";			 
		$result = mysql_query($SQL, $wpdb->dbh) or die(mysql_error().' on line: '.__LINE__);					 
		if (mysql_num_rows($result) > 0) {while ($val = mysql_fetch_object($result)){
			update_post_meta($val->ID,'type',0);		
		} }
					
		echo "<h1>Products Updated</h1>";
		die();
		} break;		

		case "set8": {		
		
		$SQL = "SELECT ".$wpdb->posts.".ID FROM ".$wpdb->posts." WHERE ".$wpdb->posts.".post_type = ('".THEME_TAXONOMY."_type') LIMIT 0,200";			 
		$result = mysql_query($SQL, $wpdb->dbh) or die(mysql_error().' on line: '.__LINE__);					 
		if (mysql_num_rows($result) > 0) {while ($val = mysql_fetch_object($result)){
			update_post_meta($val->ID,'type',2);		
		} }
					
		echo "<h1>Products Updated</h1>";
		die();
		} break;
		
		case "set9": {
		
		$SQL = "UPDATE ".$wpdb->posts." SET ".$wpdb->posts.".post_status = 'publish' WHERE ".$wpdb->posts.".post_status = 'draft' ";	
				 
		$result = mysql_query($SQL, $wpdb->dbh) or die(mysql_error().' on line: '.__LINE__);
		
		echo "<h1>Listing Updated</h1>";
		die();
		
		} break;	
			
		case "delete2": { // DELETE CATEGORIES 
	 
		$terms = get_terms(THEME_TAXONOMY, 'orderby=count&hide_empty=0');	 
		$count = count($terms);
		if ( $count > 0 ){
		
			 foreach ( $terms as $term ) {
				wp_delete_term( $term->term_id, THEME_TAXONOMY );
				$_POST['admin_values']['category_icon_'.$term->term_id] = "";
			 }
		 }		  		
		// GET THE CURRENT VALUES
		$existing_values = get_option("core_admin_values");
		// MERGE WITH EXISTING VALUES
		$new_result = array_merge((array)$existing_values, (array)$_POST['admin_values']);
		// UPDATE DATABASE 		
		update_option( "core_admin_values", $new_result);
		  
		
		echo "<h1>Categories Deleted Successfull</h1>";
		die();
		} break;
		
		case "delete3": { 
	 
		$terms = get_terms('post_tag', 'orderby=count&hide_empty=0');	 
		$count = count($terms);
		if ( $count > 0 ){
		
			 foreach ( $terms as $term ) {
				wp_delete_term( $term->term_id, 'post_tag' );
			 }
		 }
		
		echo "<h1>Tags Deleted Successfull</h1>";
		die();
		} break;		
		
		case "delete4": { 
	 
		$wpdb->query("delete a,b,c,d
		FROM ".$wpdb->prefix."posts a
		LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
		LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
		LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
		LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
		WHERE a.post_type ='post'");
		
		echo "<h1>All Posts Successfull</h1>";
		die();
		} break;	
		
		
		case "delete5": { 
	 
		$wpdb->query("delete a,b,c,d
		FROM ".$wpdb->prefix."posts a
		LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
		LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
		LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
		LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
		WHERE a.post_type = 'revision'");
		
		echo "<h1>Action Successfull</h1>";
		die();
		} break;			
		
		case "delete6": { // PAGES 
	 
		$wpdb->query("delete a,b,c,d
		FROM ".$wpdb->prefix."posts a
		LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
		LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
		LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
		LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
		WHERE a.post_type = 'page'");
		
		echo "<h1>All Pages Successfull</h1>";
		die();
		} break;
		
		
		case "delete7": { 
	 
		$wpdb->query("delete a,b,c,d
		FROM ".$wpdb->prefix."posts a
		LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
		LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
		LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
		LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
		WHERE a.post_type = '".THEME_TAXONOMY."_type'");
		
		echo "<h1>All Listings Successfull</h1>";
		die();
		} break;	
		
		case "delete8": { 
	 
		$wpdb->query("delete a,b,c,d
		FROM ".$wpdb->prefix."posts a
		LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
		LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
		LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
		LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
		WHERE a.post_type = 'faq_type'");
		
		echo "<h1>Action Successfull</h1>";
		die();
		} break;
		
		case "delete9": { 
	 
		$wpdb->query("delete a,b,c,d
		FROM ".$wpdb->prefix."posts a
		LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
		LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
		LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
		LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
		WHERE a.post_type = 'wlt_message'");
		
		echo "<h1>Action Successfull</h1>";
		die();
		} break;	
		
		case "delete10": { 
	 
		$wpdb->query("delete a,b,c,d
		FROM ".$wpdb->prefix."posts a
		LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
		LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
		LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
		LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
		WHERE a.post_type = 'alert_type'");
		
		echo "<h1>Action Successfull</h1>";
		die();
		} break;	
				
		case "delete11": { 
	 
		$wpdb->query("TRUNCATE TABLE ".$wpdb->prefix."core_orders");
		
		echo "<h1>Orders Deleted Successfull</h1>";
		die();
		} break;
		
		
		case "delete12": { // DELETE PACKAGES
			 
		update_option( "packagefields", "");
		echo "<h1>Packages Deleted Successfull</h1>";
		die();
		} break;
		
		case "delete13": { // DELETE MEMEBRSHIPS
	 
		 update_option( "membershipfields", "");
		echo "<h1>Memberships Deleted Successfull</h1>";
		die();
		} break;
		
		case "delete14": { // DELETE MEMEBRSHIPS
		$wpdb->query("TRUNCATE TABLE ".$wpdb->prefix."comments");
		 
		echo "<h1>Comments Deleted Successfull</h1>";
		die();
		} break;
		
		case "delete15": { // DELETE MEMEBRSHIPS
		update_option( "submissionfields", ""); 
		echo "<h1>Custom Fields Deleted Successfull</h1>";
		die();
		} break;
		
		case "delete15": { // DELETE REGISTRATION FIELDS
		update_option( "regfields", ""); 
		echo "<h1>Registration Fields Deleted Successfull</h1>";
		die();
		} break;		
}
}
}

// ACTIONS
if(!defined('WLT_DEMOMODE')){
if(isset($_POST['action'])){

	switch($_POST['action']){
	
		case "importcats": {
 		
		$cats = explode(PHP_EOL,$_POST['cat_import']);
		if(is_array($cats)){
		
			$taxType = THEME_TAXONOMY; 
			foreach($cats as $catme){ if($catme == ""){ continue; }
			
				if(substr($catme,0,1) == "-" && substr($catme,0,2) != "--"){				
				
					$term1 = wp_insert_term(substr($catme,1), $taxType, array( 'parent' => $taxID ));
					
					if(isset($term1->error_data['term_exists'])){
						$subtaxID = $term1->error_data['term_exists'];
					}else{		
						$subtaxID = $term1['term_id'];	
					}
									
				}elseif(substr($catme,0,1) == "-" && substr($catme,0,2) == "--"){
				
				wp_insert_term(substr($catme,2), $taxType, array( 'parent' => $subtaxID ));
					
				}else{					
				
					if ( is_term( $catme , $taxType ) ){
						$term = get_term_by('name', str_replace("_"," ",$catme), $taxType );
						$taxID = $term->term_id;
					}else{
						 
						$term = wp_insert_term(str_replace("_"," ",$catme), $taxType,  array('cat_name' => str_replace("_"," ",$catme) ));
						
						if(isset($term->error_data['term_exists'])){
						$taxID = $term->error_data['term_exists'];
						}else{	
						 
						$taxID = $term['term_id'];	
						}	
						 
					}
				}
				
			} //end foreach
		}// end if
		
		$GLOBALS['error_message'] = "Category Setup Complete";
		
		} break;
	
	}
} 
}


// LOAD IN HEADER
echo $CORE_ADMIN->HEAD();?>


<ul id="tabExample1" class="nav nav-tabs">

<?php
// HOOK INTO THE ADMIN TABS
function _4_tabs(){ $STRING = ""; global $wpdb; $core_admin_values = get_option("core_admin_values");

	if(isset($_GET['tab'])){ $_POST['tab'] = $_GET['tab']; }
	
	$pages_array = array( 
	"1" => array("t" => "Cleaup Tools", "k"=>"setuptools"),
	"2" => array("t" => "Bulk Import", 	"k"=>"catimport"),	
 	"3" => array("t" => "PAD File Upload", 	"k"=>"padupload"),	 
	
 	);
	
	if(!defined('WLT_DOWNLOADTHEME')){	
	unset($pages_array[3]);
	}
	
	foreach($pages_array as $page){
	
	if( ( isset($_POST['tab']) && $_POST['tab'] == $page['k'] ) || ( !isset($_POST['tab']) && $page['k'] == "setuptools" ) ){ $class = "active"; }else{ $class = ""; }
	
		$STRING .= '<li class="'.$class.'"><a href="#'.$page['k'].'" onclick="document.getElementById(\'ShowTab\').value=\''.$page['k'].'\'" data-toggle="tab">'.$page['t'].'</a></li>';		
	}
 
	return $STRING;

}
echo hook_admin_4_tabs(_4_tabs());
// END HOOK
?>  
                     
</ul>

<div class="tab-content">

<?php do_action('hook_admin_4_content'); ?> 


<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "catimport"){ echo "active in"; } ?>" id="catimport">

    <div class="row-fluid">
    
        <div class="span6">
    
        <input type="hidden" name="action" value="importcats" />    
        <div class="box gradient">
        <div class="title"><h4><i class="icon-tags"></i><span>Bulk Category Import</span></h4></div>
            <div class="content top">       
                       
            <p>Enter a list of category items below, separate each category with a new line and start sub categories with a dash (-).</p>
            <textarea class="row-fluid" id="default-textarea" style="height:400px;" name="cat_import"></textarea>        
            </div>
             
            <div class="form-actions row-fluid"><div class="span7 offset4"><button type="submit" class="btn btn-primary">Start Import</button></div></div>     
        </div>
          
        </div>
        
        <div class="span6">
        
        Download Existing Categories
        
        <a href="admin.php?page=4&amp;task=getcats&amp;TB_iframe=true&amp;width=640&amp;height=100" class="button right" >Get Categories</a> 
        
        
        </div>
        
    </div>
</div> 

</form>


 


<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "padupload"){ echo "active in"; } ?>" id="padupload">


 

 <form method="post" enctype="multipart/form-data" action="">
  <input type="hidden" name="action" value="padupload" /> 
  
  
  <table class="table table-bordered table-striped">
          
         
            <tbody>
              <tr>
                <td>
                  <code>PAD (.xml) File</code>
                </td>
                <td>   <div class="controls">
                  <div class="input-append row-fluid">
                    <input type="file"  name="file[]"> <br />
                     <input type="file"  name="file[]"><br /> 
                      <input type="file"  name="file[]"> <br />
                       <input type="file"  name="file[]"> <br />
                        <input type="file"  name="file[]"> 
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
                  <code>Category</code>
                </td>
                <td>
                
                <select name="cat" class="chzn-select" id="style" multiple="multiple">
                   <?php echo $CORE->CategoryList(array(0,false,0,THEME_TAXONOMY)); ?>                  
                  </select>
                
                </td>
              </tr>
            
             
            </tbody>
          </table>
          
          <button type="submit">Upload</button>
 
</form> 


</div>


<div class="tab-pane fade <?php if(!isset($_POST['tab']) || ( isset($_POST['tab']) && ( $_POST['tab'] =="" || $_POST['tab'] =="setuptools" ) )){ echo "active in"; } ?>" id="setuptools">

<div class="row-fluid">

    <div class="span6">
    
        <div class="box gradient">
        <div class="title">
          <h4><i class="icon-tags"></i><span>System Reset</span></h4>
        </div>
            <div class="content top">
            
            <p>Use this tool to reset your website and delete everything.</p>
            
             <hr />
                
<div class="well">	
<b class="label label-important">Reset Entire Website!</b>	 
<a href="javascript:void(0);" onclick="jQuery('#UpdateModal').modal('show');" class="button right" >Delete All Listings + Content</a>
<div class="clearfix"></div>
</div>    
            
            
              
                       
          </div>
           
        </div>
        
        
        
        
        
            <div class="box gradient">
        <div class="title">
          <h4><i class="icon-refresh"></i><span>Listing Changes</span></h4>
        </div>
            <div class="content top">
            
            <p>Use this tool to mass update listing data.</p>
            
<hr />                
<div class="well">	
<b>Set All Listings Featured</b>	 
 <a href="admin.php?page=4&amp;task=set1&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Update All Listings</a> 
<div class="clearfix"></div>
</div>

<hr />                
<div class="well">	
<b>Set All Listings Non-Featured</b>	 
 <a href="admin.php?page=4&amp;task=set2&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Update All Listings</a> 
<div class="clearfix"></div>
</div>


<hr />                
<div class="well">	
<b>Set All Listings Published</b>	 
 <a href="admin.php?page=4&amp;task=set9&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Update All Listings</a> 
<div class="clearfix"></div>
</div>


<?php if(defined('WLT_CART')){ ?>
<hr />                
<div class="well">	
<b>Set All Products Taxable</b>	 
 <a href="admin.php?page=4&amp;task=set3&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Update All Listings</a> 
<div class="clearfix"></div>
</div>

<hr />                
<div class="well">	
<b>Set All Products Non-Taxable</b>	 
 <a href="admin.php?page=4&amp;task=set4&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Update All Listings</a> 
<div class="clearfix"></div>
</div>

<hr />                
<div class="well">	
<b>Set All Products Shipable</b>	 
 <a href="admin.php?page=4&amp;task=set5&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Update All Listings</a> 
<div class="clearfix"></div>
</div>

<hr />                
<div class="well">	
<b>Set All Products Non-Shipable</b>	 
 <a href="admin.php?page=4&amp;task=set6&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Update All Listings</a> 
<div class="clearfix"></div>
</div>

<hr />                
<div class="well">	
<b>Set All Product Type (Normal Product)</b>	 
 <a href="admin.php?page=4&amp;task=set7&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Update All Listings</a> 
<div class="clearfix"></div>
</div>

<hr />                
<div class="well">	
<b>Set All Product Type (Affiliate Product)</b>	 
 <a href="admin.php?page=4&amp;task=set8&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Update All Listings</a> 
<div class="clearfix"></div>
</div>
<?php } ?>

            
            
              
                       
          </div>
           
        </div>    
        
        
        
        
        
 
    
     
    </div><div class="span6">
    
<script type="text/javascript" language="javascript">
jQuery(window).load(function(){
jQuery('.alertme').click(function(e)
{
    if(confirm("Are you sure?"))
    {
       
	
    }
    else
    {
		 alert('Phew! That was close!');
        e.preventDefault();
    }
});
});
</script>            
     <div class="box gradient">
    <div class="title"><h4><i class="icon-ban-circle"></i><span>System Cleanup Modules</span></h4></div>
        <div class="content top ">
    
    <p>Using any of the options below will instantly delete content from your website. <b>Please take care!</b> </p>
    
   

     
<hr />
<div class="well">	
<b>Listings Only</b>	 
<a href="admin.php?page=4&amp;task=delete7&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Delete All Listings</a>
<div class="clearfix"></div>
</div>

<div class="well">	
<b>Listing Categories Only</b>	 
<a href="admin.php?page=4&amp;task=delete2&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Delete All Categories</a>
<div class="clearfix"></div>
</div>


<div class="well">	
<b>Tags Only</b> 
 <a href="admin.php?page=4&amp;task=delete3&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Delete All Tags</a>
<div class="clearfix"></div>
</div>

<div class="well">	
<b>Posts Only</b> 
 <a href="admin.php?page=4&amp;task=delete4&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Delete All Posts</a>
<div class="clearfix"></div>
</div>

<div class="well">	
<b>Comments Only</b>	 
 <a href="admin.php?page=4&amp;task=delete14&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Delete All Comments</a> 
<div class="clearfix"></div>
</div>

 
<div class="well">	
<b>Pages Only</b> 
 <a href="admin.php?page=4&amp;task=delete6&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Delete All Pages</a> 
<div class="clearfix"></div>
</div>

<div class="well">	
<b>Saved Revisions Only</b>	 
<a href="admin.php?page=4&amp;task=delete5&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Delete All Revisions</a>
<div class="clearfix"></div>
</div>

<div class="well">	
<b>Orders Only</b>	 
 <a href="admin.php?page=4&amp;task=delete11&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Delete All Orders</a> 
<div class="clearfix"></div>
</div>

<div class="well">	
<b>Listing Packages Only</b>	 
 <a href="admin.php?page=4&amp;task=delete12&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Delete All Packages</a> 
<div class="clearfix"></div>
</div>

<div class="well">	
<b>Registration Fields Only</b>	 
 <a href="admin.php?page=4&amp;task=delete16&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Delete All Fields</a> 
<div class="clearfix"></div>
</div>

<div class="well">	
<b>Memberships Only</b>	 
 <a href="admin.php?page=4&amp;task=delete13&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Delete All Memberships</a> 
<div class="clearfix"></div>
</div>

<div class="well">	
<b>Custom Fields Only</b>	 
 <a href="admin.php?page=4&amp;task=delete15&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Delete All Custom Fields</a> 
<div class="clearfix"></div>
</div>


<div class="well">	
<b>Notifications Only</b>	 
 <a href="admin.php?page=4&amp;task=delete9&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme button right" >Delete All Notifications</a> 
<div class="clearfix"></div>
</div>


    </div> 
    
    
</div>

     


</div>


</div>



</form>

		<div id="UpdateModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					  <div class="modal-header">                
						<h3>Website Reset</h3>
					  </div>
					  <div class="modal-body">                      
					    
                        <p style="font-weight:bold;">Would you like to reset your website to the default factory settings?</p>
                        
                        <p style="font-size:11px;"><label class="label label-warning">Warning</label> resetting your website will delete all of your existing listing and admin changes.</p>
                         					             
					  </div>
                      <form method="post" action="">
                      <input type="hidden" name="submitted" value="yes" />
                      <input type="hidden" name="core_system_reset" id="core_system_reset" value="new" />
					  <div class="modal-footer">
						<a class="btn" data-dismiss="modal" aria-hidden="true">No Thanks!</a>                       
						<button type="submit" class="btn btn-primary">Yes, Reset Now</button>
                       
					  </div>
                      </form>
		</div>


</div>

<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); 
?>
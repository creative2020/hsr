<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;
// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  
 
// REMOVE FIELD
if(isset($_POST['newbanner'])  && current_user_can( 'edit_user', $userdata->ID )){
			
	// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
	$wlt_banners = get_option("wlt_banners");
	if(!is_array($wlt_banners)){ $wlt_banners = array(); }
	// ADD ONE NEW FIELD 
	if(!isset($_POST['eid'])){
		$_POST['wlt_banner']['ID'] = count($wlt_banners);
		array_push($wlt_banners, $_POST['wlt_banner']);
		
		$GLOBALS['error_message'] = "Banner Created Successfully";
	}else{
		$wlt_banners[$_POST['eid']] = $_POST['wlt_banner'];
		
		$GLOBALS['error_message'] = "Banner Updated Successfully";
	}
	// SAVE ARRAY DATA		 
	update_option( "wlt_banners", $wlt_banners);
				
}elseif(isset($_GET['delete_banner']) && is_numeric($_GET['delete_banner'] )  && current_user_can('administrator')){

	// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
	$wlt_banners = get_option("wlt_banners");
	if(!is_array($wlt_banners)){ $wlt_banners = array(); }
	// LOOK AND SEARCH FOR DELETION
	foreach($wlt_banners as $key=>$pak){
		if($key == $_GET['delete_banner']){
			unset($wlt_banners[$key]);		 
		}
	}
	// SAVE ARRAY DATA
	update_option( "wlt_banners", $wlt_banners);

	$GLOBALS['error_message'] = "Banner Deleted Successfully";
}

// LOAD IN HEADER
echo $CORE_ADMIN->HEAD();
 
?>


<ul id="tabExample1" class="nav nav-tabs">

<?php
// HOOK INTO THE ADMIN TABS
function _7_tabs(){ $STRING = ""; global $wpdb; $core_admin_values = get_option("core_admin_values");

	if(isset($_GET['tab'])){ $_POST['tab'] = $_GET['tab']; }
	
	$pages_array = array( 
	"1" => array("t" => "Banners", "k"=>"banner"),
	 
 	);
	foreach($pages_array as $page){
	
	if( ( isset($_POST['tab']) && $_POST['tab'] == $page['k'] ) || ( !isset($_POST['tab']) && $page['k'] == "banner" ) ){ $class = "active"; }else{ $class = ""; }
	
		$STRING .= '<li class="'.$class.'"><a href="#'.$page['k'].'" onclick="document.getElementById(\'ShowTab\').value=\''.$page['k'].'\'" data-toggle="tab">'.$page['t'].'</a></li>';		
	}
 
	return $STRING;

}
echo hook_admin_7_tabs(_7_tabs());
// END HOOK
?>  
                     
</ul>

<div class="tab-content">

<?php do_action('hook_admin_7_content'); ?> 


<div class="tab-pane fade <?php if(!isset($_POST['tab']) || ( isset($_POST['tab']) && ( $_POST['tab'] =="" || $_POST['tab'] =="banner" ) )){ echo "active in"; } ?>" id="banner">

 
<div class="row-fluid">
<div class="box gradient span6"> 
 
          <div class="title">
            <h3>
            <i class="icon-bullhorn"></i>
           <a data-toggle="modal" href="#bannerModal" class="btn btn-success" style="float:right;margin-top:4px; margin-right:10px;">Add Banner</a>
            <span>Banners</span>
            </h3>
          </div>
  		<div class="content">
        <div class="accordion" id="accordion5">
         
 <?php $wlt_banners = get_option("wlt_banners");  
		 
		 // update_option("wlt_banners","");
		if(is_array($wlt_banners) && count($wlt_banners) > 0 ){  ?>
        
        
            <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
            <thead>
            <tr>
              <th class="no_sort">Subject</th>
               <th class="no_sort">Views</th>
                            
              <th class="no_sort" style="width:110px;text-align:center;">Actions</th>
              
            </thead>
            <tbody>
            
        <?php
 	  
		foreach($wlt_banners as $key=>$field){  if(!is_numeric($key)){ continue; }  ?>
		<tr>
         <td>
		 <b style="font-weight:bold;"><?php echo stripslashes($field['subject']); ?></b>
        
         <p>Category: <?php
		 if(isset($field['category']) && is_array($field['category'])){ 
		 foreach($field['category'] as $k=>$p){
		 	$v = get_term_by('id', $p, THEME_TAXONOMY);
			if(!is_wp_error($v)){
				$l = get_term_link($v->slug, THEME_TAXONOMY);
				if(!is_wp_error($l)){
		 		echo " <a href='".$l."' target='_blank'>".$v->name. "</a>";
				}
			}
		 }
		 }else{
		 echo "All Categories";
		 }
		 ?></p>
    
         </td>         
        <td class="ms" style="text-align:center;"><?php if($field['views'] == ""){ echo 0; }else{ echo number_format($field['views']); } ?>
        </td>
         <td class="ms">
         <center>
                <div class="btn-group1">
                  <a class="btn btn-small" rel="tooltip" 
                  href="admin.php?page=7&edit_banner=<?php echo $key; ?>"
                  data-placement="left" data-original-title=" edit "><i class="gicon-edit"></i></a>                   
                  <a class="btn btn-inverse btn-small confirm" rel="tooltip" data-placement="bottom" 
                  data-original-title="Remove"
                  href="admin.php?page=7&delete_banner=<?php echo $key; ?>"
                  ><i class="gicon-remove icon-white"></i></a> 
                </div>
            </center>
            </td>
            </tr>
            <?php  }   ?> 
 
            </tbody>
            </table>
             
         <?php } ?>        
         
 <?php do_action('hook_admin_1_tab5_left'); ?>  
 
 </div></div>
          
 
          
 
<div class="clearfix"></div>

    </div><!-- End .box -->
    
    

    <div class="box gradient span6">

      <div class="title">
            <div class="row-fluid">
                <h3><i class="icon-check"></i>Banner Assignment</h3>
            </div>
        </div><!-- End .title -->
        <div class="content">
        
        <p>Select a banner to be used for each of the areas below.</p>


<?php

$default_banner_array = array(

"header" => array('name' => 'Header',  'shortcodes' => '(468 x 60)', 'label'=>'label-success'),
"footer" => array('name' => 'Footer',  'shortcodes' => '(any size)', 'label'=>'label-success'),

"full_top" => array('name' => 'Full Wrapper Top',  'shortcodes' => '(1000 x any size)', 'label'=>'label-success'),


"middle_top" => array('name' => 'Middle Column Top',  'shortcodes' => '(650 x any size)', 'label'=>'label-success'),
"middle_bottom" => array('name' => 'Middle Column Bottom',  'shortcodes' => '(650 x any size)', 'label'=>'label-success'),
 
/*
"n" => array('break' => 'Listing Expiry banners'),
	"reminder_30" => array('name' => '30 day renewal reminder',   'shortcodes' => 'title = (title) \n link = (link) \n excerpt = (post_excerpt) \n date = (post_date) \n expired = (expired)', 'label'=>'label-info'),
	"reminder_15" => array('name' => '15 day renewal reminder',   'shortcodes' => 'title = (title) \n link = (link) \n excerpt = (post_excerpt) \n date = (post_date) \n expired = (expired)', 'label'=>'label-info'),
	"reminder_1" => array('name' => '1 day renewal reminder',   'shortcodes' => 'title = (title) \n link = (link) \n excerpt = (post_excerpt) \n date = (post_date) \n expired = (expired)', 'label'=>'label-info'),
	"expired" => array('name' => 'Listing Expired',   'shortcodes' => 'title = (title) \n link = (link) \n excerpt = (post_excerpt) \n date = (post_date) \n expired = (expired)', 'label'=>'label-info'),
*/

 

);

$default_banner_array = hook_advertising_list_filter($default_banner_array);

?>
<?php if(is_array($default_banner_array)){ ?> 
        <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Action</th>
                <th>Assigned Banner</th>
              </tr>
            </thead>
            <tbody>
            
        
<!------------ FIELD -------------->      
<?php 
 
foreach($default_banner_array as $key1=>$val1){ 

 
if(isset($val1["break"])){ ?>
</tr> </tbody> </table>
<table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th rowspan="2"><?php echo $val1["break"]; ?></th>
              </tr>
            </thead>
            <tbody
<?php }else{ ?>
<tr><td>
<span class="label <?php echo $val1['label']; ?>"><?php echo $val1['name']; ?></span>
<br /><small><?php echo $val1['shortcodes']; ?></small> 
</td>
<td>

<select data-placeholder="Choose a an banner..." class="chzn-select" name="admin_values[banners][<?php echo $key1; ?>][]" multiple="multiple">   
    <option value=""> ---- none ---- </option>
	<?php 
	if(is_array($wlt_banners)){ 
		foreach($wlt_banners as $key=>$field){ 
			if(isset($core_admin_values['banners']) && is_array($core_admin_values['banners']) && in_array("banner_".$key,$core_admin_values['banners'][$key1])){	$sel = " selected=selected ";	}else{ $sel = ""; }
			
			echo "<option value='banner_".$key."' ".$sel.">".stripslashes($field['subject'])."</option>"; 
		} 
	} 
	?> 
     
</select>  
</td></tr>    
<?php } ?>
<?php } ?>
</div>
<!------------ END FIELD -------------->  
 </tr> </tbody> </table>       
<?php } ?>
 
       
       
        </div> <!-- End .content --> 
    </div><!-- End .box -->
 </div> 

</div>


<!--------------------------- END ALL TABs ---------------------------->
</div><!-- end LANGUAGE tab 2 -->



<!-- start save button -->
<div class="form-actions row-fluid">
<div class="span7 offset5">
<button type="submit" class="btn btn-primary">Save Changes</button> 
</div>
</div> 
<!-- end save button -->


</div><!-- end tab -->



</form>












 <?php if(isset($_GET['edit_banner']) && is_numeric($_GET['edit_banner']) ){ 
$wlt_banners = get_option("wlt_banners");

?>
<script type="text/javascript">
jQuery(document).ready(function () { jQuery('#bannerModal').modal('show'); })
</script>
<?php } ?>

<form method="post" name="admin_banner" id="admin_banner" action="admin.php?page=7">
<input type="hidden" name="newbanner" value="yes" />
<input type="hidden" name="tab" value="banner" />
<?php if(isset($_GET['edit_banner'])){ ?>
<input type="hidden" name="eid" value="<?php echo $_GET['edit_banner']; ?>" />
<input type="hidden" name="wlt_banner[views]" value="<?php echo $wlt_banners[$_GET['edit_banner']]['views']; ?>" />
<input type="hidden" name="wlt_banner[ID]" value="<?php echo $wlt_banners[$_GET['edit_banner']]['ID']; ?>" />
<?php }

if(isset($_GET['edit_banner']) && isset($wlt_banners[$_GET['edit_banner']]['category'])){ $dcatid = $wlt_banners[$_GET['edit_banner']]['category']; }else{  $dcatid = 0; }
 ?>

<div id="bannerModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="bannerModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3 id="myModalLabel">Banner Settings</h3>
            </div>
            <div class="modal-body">
              
               
          	 <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field"><b>Title</b></label>
                <div class="controls span7">
                  <input type="text"  name="wlt_banner[subject]" class="row-fluid" value="<?php if(isset($_GET['edit_banner'])){ echo stripslashes($wlt_banners[$_GET['edit_banner']]['subject']); }?>">
                   
                </div>
              </div> 
              
              
              <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field"><b>Display Category</b></label>
                <div class="controls span7">
                    <select name="wlt_banner[category][]" class="chzn-select" id="style" multiple="multiple" data-placeholder="">                   
                   <?php echo $CORE->CategoryList(array($dcatid,false,0,THEME_TAXONOMY)); ?>                  
                  </select>  
                </div>
                
              </div> 
              <p style="padding-left:130px;">Leave blank to display on all pages/categories.</p>
              
              <div class="form-row control-group row-fluid">
                <label class="control-label " for="normal-field"><b>Banner Code</b></label>
                 
                  <textarea name="wlt_banner[code]" class="row-fluid" style="min-height:200px;" ><?php if(isset($_GET['edit_banner'])){ echo stripslashes($wlt_banners[$_GET['edit_banner']]['code']); }?></textarea>                  
                
              </div> 
              
               
           
              
            </div>
            
            <div class="modal-footer">
              <a class="btn" href="admin.php?page=7">Close</a>
              <button class="btn btn-primary">Save changes</button>
            </div>
</div>
</form>

<?php echo $CORE_ADMIN->FOOTER(); ?>
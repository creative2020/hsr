<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;

if(!defined('WLT_DEMOMODE') && current_user_can('administrator')){

if(isset($_POST['TransferFormMemberships']) && is_numeric($_POST['from']) && is_numeric($_POST['to'])){
 
 if($_POST['from'] == "-2"){
 
 	$SQL = "SELECT mt1.ID FROM ".$wpdb->prefix."users AS mt1
	LEFT JOIN ".$wpdb->prefix."usermeta AS mt2 ON (mt1.ID = mt2.user_id AND mt2.meta_key = 'wlt_membership')
	WHERE mt2.meta_key IS NULL 
	GROUP BY mt1.ID";
	$result = mysql_query($SQL, $wpdb->dbh);					 
		if (mysql_num_rows($result) > 0) {
			while ($val = mysql_fetch_object($result)){
			update_user_meta($val->ID,'wlt_membership',$_POST['to']);
			}
		}
 
 }elseif($_POST['from'] == "-1"){
 $gg = explode(",",$_POST['all']); $ext = "";
 foreach($gg  as $gh){
 $ext .= "AND ".$wpdb->prefix."usermeta.meta_value != '".$gh."' ";
 }
 $SQL = "UPDATE ".$wpdb->prefix."usermeta SET ".$wpdb->prefix."usermeta.meta_value = '".$_POST['to']."' WHERE ".$wpdb->prefix."usermeta.meta_key = 'wlt_membership' AND ".$wpdb->prefix."usermeta.meta_value != '".$_POST['from']."' ". $ext;
 
 mysql_query($SQL);
 }else{
 $SQL = "UPDATE ".$wpdb->prefix."usermeta SET ".$wpdb->prefix."usermeta.meta_value = '".$_POST['to']."' WHERE ".$wpdb->prefix."usermeta.meta_key = 'wlt_membership' AND ".$wpdb->prefix."usermeta.meta_value = '".$_POST['from']."'";
 mysql_query($SQL);
 }
 
 $GLOBALS['error_message'] = "Memberships Transfered Successfully";
 
}


if(isset($_POST['TransferFormListings']) && is_numeric($_POST['from']) && is_numeric($_POST['to'])){
 
 if($_POST['from'] == "-2"){
 
 	$SQL = "SELECT ".$wpdb->prefix."posts.ID, mt2.meta_value FROM ".$wpdb->prefix."posts 
	LEFT JOIN ".$wpdb->prefix."postmeta AS mt2 ON (".$wpdb->prefix."posts.ID = mt2.post_id AND mt2.meta_key = 'packageID')
	WHERE ".$wpdb->prefix."posts.post_type = '".THEME_TAXONOMY."_type' 
	AND ( ".$wpdb->prefix."posts.post_status = 'draft' OR ".$wpdb->prefix."posts.post_status = 'publish' )  
	AND mt2.meta_key IS NULL 
	GROUP BY ".$wpdb->prefix."posts.ID";
	$result = mysql_query($SQL, $wpdb->dbh);					 
		if (mysql_num_rows($result) > 0) {
			while ($val = mysql_fetch_object($result)){
			update_post_meta($val->ID,'packageID',$_POST['to']);
			}
		}
 
 }elseif($_POST['from'] == "-1"){
 $gg = explode(",",$_POST['all']); $ext = "";
 foreach($gg  as $gh){
 $ext .= "AND ".$wpdb->prefix."postmeta.meta_value != '".$gh."' ";
 }
 $SQL = "UPDATE ".$wpdb->prefix."postmeta SET ".$wpdb->prefix."postmeta.meta_value = '".$_POST['to']."' WHERE ".$wpdb->prefix."postmeta.meta_key = 'packageID' AND ".$wpdb->prefix."postmeta.meta_value != '".$_POST['from']."' ". $ext;
 mysql_query($SQL);
 }else{
 $SQL = "UPDATE ".$wpdb->prefix."postmeta SET ".$wpdb->prefix."postmeta.meta_value = '".$_POST['to']."' WHERE ".$wpdb->prefix."postmeta.meta_key = 'packageID' AND ".$wpdb->prefix."postmeta.meta_value = '".$_POST['from']."'";
 mysql_query($SQL);
 }
 
 $GLOBALS['error_message'] = "Listing Transfered Successfully";
 
}

if(isset($_POST['newmembershipfield']) ){
			
	// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
	$membershipfields = get_option("membershipfields");
	if(!is_array($membershipfields)){ $membershipfields = array(); }
	// ADD ONE NEW FIELD 
	if(!isset($_POST['eid'])){
		$_POST['membershipfield']['ID'] = count($membershipfields);
		array_push($membershipfields, $_POST['membershipfield']);
		
		$GLOBALS['error_message'] = "Membership Added Successfully";
	}else{
		$membershipfields[$_POST['eid']] = $_POST['membershipfield'];
		
		$GLOBALS['error_message'] = "Membership Updated Successfully";
	}
	
	// UPDATE ALL FIELD IDS
	$newA = array();
	
	foreach($membershipfields as $fk => $fp){
		if(isset($newA[$fp['ID']])){
			$newA[$fp['ID']+10] = $fp;	
			$newA[$fp['ID']+10]['ID'] = $fp['ID']+10;
		}else{
			$newA[$fp['ID']] = $fp;	
		}		 
	}
	
	// SAVE ARRAY DATA		 
	update_option( "membershipfields", $newA);
	$_POST['tab'] = "memberships";
				
}elseif(isset($_GET['delete_membership_field']) && is_numeric($_GET['delete_membership_field'] )){

	// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
	$membershipfields = get_option("membershipfields");
	if(!is_array($membershipfields)){ $membershipfields = array(); }
 	
	// DELETE SELECTED VALUE
	unset($membershipfields[$_GET['delete_membership_field']]);	
  	
	// SAVE ARRAY DATA
	update_option( "membershipfields", $membershipfields);
	
	$_POST['tab'] = "memberships";
	$GLOBALS['error_message'] = "Membership Removed Successfully";

}elseif(isset($_POST['newpackagefield'])){
			
	// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
	$packagefields = get_option("packagefields");
	if(!is_array($packagefields)){ $packagefields = array(); }
	
 	// ADD ONE NEW FIELD 
	if(!isset($_POST['eid'])){
		$_POST['packagefield']['ID'] = count($packagefields);
		array_push($packagefields, $_POST['packagefield']);		
		$GLOBALS['error_message'] = "Package Added Successfully";
	}else{
		if(isset($_POST['eid']) && is_numeric($_POST['eid'])){
		$packagefields[$_POST['eid']] = $_POST['packagefield'];	
		}else{
		$packagefields[count($packagefields)] = $_POST['packagefield'];	
		}	
		$GLOBALS['error_message'] = "Package Updated Successfully";
	}
	
	// UPDATE ALL FIELD IDS
	$newA = array();
	foreach($packagefields as $fk => $fp){
		if(isset($newA[$fp['ID']])){
			$newA[$fp['ID']+10] = $fp;	
			$newA[$fp['ID']+10]['ID'] = $fp['ID']+10;
		}else{
			$newA[$fp['ID']] = $fp;	
		}		 
	}	
 
	// SAVE ARRAY DATA		 
	update_option( "packagefields", $newA);
				
}elseif(isset($_GET['delete_package_field']) && is_numeric($_GET['delete_package_field'] )){

	// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
	$packagefields = get_option("packagefields");
	if(!is_array($packagefields)){ $packagefields = array(); }

	// DELETE SELECTED VALUE
	unset($packagefields[$_GET['delete_package_field']]);
	
	// SAVE ARRAY DATA
	update_option( "packagefields", $packagefields);
	
	$_POST['tab'] = "packages";
	$GLOBALS['error_message'] = "Package Removed Successfully";

} 
}
	// SORT TABBING
	if(isset($_GET['edit_membership_field']) && is_numeric($_GET['edit_membership_field']) ){ 
	$_POST['tab'] = "memberships";
	}elseif(isset($_GET['edit_package_field']) && is_numeric($_GET['edit_package_field']) ){ 
	$_POST['tab'] = "packages";
	}

if(!defined('WLT_DEMOMODE') && current_user_can('administrator')){
	// REMOVE PACKAGE FIELD
	if(isset($_POST['newsubmissionfield'])){
	
		// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
		$submissionfields = get_option("submissionfields");
		
	// FIX FOR TAX 	
	if($_POST['submissionfield']['fieldtype'] == "taxonomy"){
		$_POST['submissionfield']['key'] = "tax_".date('dmyhis');
	}
 
		if(!is_array($submissionfields)){ $submissionfields = array(); }
		// ADD ONE NEW FIELD 
		if(!isset($_POST['eid'])){
			$_POST['submissionfield']['ID'] = count($submissionfields);
			array_push($submissionfields, $_POST['submissionfield']);
			
			$GLOBALS['error_message'] = "Package Added Successfully";
		}else{
			$submissionfields[$_POST['eid']] = $_POST['submissionfield'];
			
			$GLOBALS['error_message'] = "Package Updated Successfully";
		}
		// SAVE ARRAY DATA		 
		update_option( "submissionfields", $submissionfields);
					
	}elseif(isset($_GET['delete_submission_field']) && is_numeric($_GET['delete_submission_field'] )){
	
		// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
		$submissionfields = get_option("submissionfields");
		if(!is_array($submissionfields)){ $submissionfields = array(); }	
		
		// DELETE SELECTED VALUE
		unset($submissionfields[$_GET['delete_submission_field']]);
		
		// SAVE ARRAY DATA
		update_option( "submissionfields", $submissionfields);
		
		$_POST['tab'] = "submission";
		$GLOBALS['error_message'] = "Package Removed Successfully";
	
	// SAVE LANGUAGE FILE MODIFICATIONS
	}elseif(isset($_POST['pplang']) && is_array($_POST['pplang']) ){			 
	
		update_option("core_language",$_POST['pplang']);
	}
}

// SORT TABBING
if(isset($_GET['edit_submission_field']) && is_numeric($_GET['edit_submission_field']) ){ 
$_POST['tab'] = "submission";
}





$core_admin_values = get_option("core_admin_values");
 
// LOAD IN HEADER
echo $CORE_ADMIN->HEAD();

?>

 
    <a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('yO5jmcUdlUw','videoboxplayer','479','350');" style="float:right;margin-top:5px;margin-right:5px;">Watch Video</a>
<ul id="tabExample1" class="nav nav-tabs">

<?php
// HOOK INTO THE ADMIN TABS
function _5_tabs(){ $STRING = ""; global $wpdb; $core_admin_values = get_option("core_admin_values");

	if(isset($_GET['tab'])){ $_POST['tab'] = $_GET['tab']; }
	
	$pages_array = array( 
	"1" => array("t" => "Custom Fields", 		"k"=>"submission"),
	"2" => array("t" => "Listing Packages", 	"k"=>"packages"),
	"3" => array("t" => "Membership Packages", 	"k"=>"memberships"),
 	);
	foreach($pages_array as $page){
	
	if( ( isset($_POST['tab']) && $_POST['tab'] == $page['k'] ) || ( !isset($_POST['tab']) && $page['k'] == "submission" ) ){ $class = "active"; }else{ $class = ""; }
	
		$STRING .= '<li class="'.$class.'"><a href="#'.$page['k'].'" onclick="document.getElementById(\'ShowTab\').value=\''.$page['k'].'\'" data-toggle="tab">'.$page['t'].'</a></li>';		
	}
 
	return $STRING;

}
echo hook_admin_5_tabs(_5_tabs());
// END HOOK
?>  
                     
</ul>
           
           
<div class="tab-content">

<?php do_action('hook_admin_5_content'); ?>

<!--------------------------- LANGUAGE TAB ---------------------------->
<div class="tab-pane fade <?php if(!isset($_POST['tab']) || ( isset($_POST['tab']) && $_POST['tab'] =="" ) || ( isset($_POST['tab']) && $_POST['tab'] == "submission" ) ){ echo "active in"; } ?>" id="submission">

<div class="row-fluid">
 
    <div class="box gradient span8">

      <div class="title">
            <div class="row-fluid">
            <a href="admin.php?page=4" class="btn btn-info" style="float:right;margin-top:4px; margin-right:10px;">Delete All</a>
            <a data-toggle="modal" href="<?php echo get_home_url(); ?>/wp-admin/admin.php?page=5#submissionModal" class="btn btn-success" style="float:right;margin-top:4px; margin-right:10px;">Add New Field</a>
            <h3><i class="icon-list"></i>Fields</h3></div>
        </div><!-- End .title -->
        
        <div class="content" style="min-height:500px;">
   
        
       <?php 
	   $submissionfields = get_option("submissionfields"); 
	   if(is_array($submissionfields) && count($submissionfields) > 0 ){ 
	    ?>
 
            <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
            <thead>
            <tr>
              <th class="no_sort">Description</th>                
              <th class="no_sort" style="text-align:center;" ><span rel="tooltip" data-original-title="This is the custom field key WordPress will assign to this field." data-placement="top">Db Key</span></th>
              <th class="no_sort" style="width:110px;text-align:center;">Required?</th>
              <th class="no_sort" style="width:110px;text-align:center;">Actions</th>
            </thead>
            <tbody>
            
        <?php 
		
		//PUT IN CORRECT ORDER
		$ordered_submissionfields = $CORE->multisort( $submissionfields , array('order') );				 
		foreach($ordered_submissionfields as $key => $field){ if(!is_numeric($field['ID'])){ continue; } ?>
        
		<tr>
         <td><?php echo $field['name']; ?> </td>
         <td><center><span class="label"><?php if($field['fieldtype'] == "taxonomy"){ echo "Taxonomy"; 
		  
		 }else{ echo $field['key']; } ?></span>
         
         <?php if($field['fieldtype'] == "taxonomy" && strlen($field['taxonomy_link']) > 2){ echo "<br /><small style='font-size:10px; color:#444;'>linked with: ".$field['taxonomy_link']."</small>";  } ?>
         
         </center></td>
         <td><center><span class="label label-<?php echo $field['required']; ?>"><?php echo $field['required']; ?></span></center></td>
         <td class="ms">
                 <div class="btn-group1">
                  <a class="btn btn-small" rel="tooltip" 
                  href="admin.php?page=5&edit_submission_field=<?php echo $CORE->multisortkey($submissionfields, 'key', $field['key']); ?>"
                  data-placement="left" data-original-title=" edit "><i class="gicon-edit"></i></a>                   
                  <a class="btn btn-inverse btn-small confirm" rel="tooltip" data-placement="bottom" 
                  data-original-title="Remove"
                  href="admin.php?page=5&delete_submission_field=<?php echo $CORE->multisortkey($submissionfields, 'key', $field['key']); ?>"
                  ><i class="gicon-remove icon-white"></i></a> 
                </div>
         </td>
         </tr>
         
         <?php  } ?>
            
        </tbody>
        </table>
            
        <?php } ?>
                 
        </div> <!-- End .content -->
        
        
        <p style="font-size:11px;padding:10px;"><span class="label label-warning">Note</span> Adding a field with the database key <span class="label label-ok">country</span> or <span class="label label-ok">state</span> will create a populated list of values for you.</p> 
        
         <p style="font-size:11px;padding:10px;"><span class="label label-info">Info</span> Adding a field with the database key <span class="label label-ok">youtube</span> will display the YouTube video link as an embedded video.</p> 
        
        <?php do_action('hook_admin_5_tab1_left'); ?> 
 
        
    </div><!-- End .box -->

    <div class="box gradient span4">

      <div class="title">
            <div class="row-fluid">
                <h3><i class="icon-wrench"></i>Settings</h3>
            </div>
        </div><!-- End .title -->
        <div class="content">
        
   <div class="form-row control-group row-fluid ">
             <label><b>Custom Page Text</b></label>
             <small>Here you can add your own text under the header on the add listing page.</small>
            
             
  <textarea class="row-fluid" id="default-textarea" style="height:140px;" name="admin_values[custom][add_text]"><?php echo stripslashes($core_admin_values['custom']['add_text']); ?></textarea> 
                     
            </div> 
            
            
             <?php do_action('hook_admin_5_tab1_right'); ?> 
       
        </div> <!-- End .content -->        
        
     
 
    </div><!-- End .box -->
 

</div>          


</div><!--------------------------- REGISTRATION TAB ---------------------------->








<?php  $membershipfields = get_option("membershipfields"); ?>
<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "memberships"){ echo "active in"; } ?>" id="memberships">


<ul id="tabExample1" class="nav nav-tabs">
<li class="active"><a href="#mem_item1" data-toggle="tab" onclick="document.getElementById('ShowSubTab').value='home_layout1';">Membership Setup</a></li>  
<li><a href="#mem_item2" data-toggle="tab" onclick="document.getElementById('ShowSubTab').value='home_slider';delayredraw1();">Statistics</a></li>     
</ul>
<div class="tab-content">

<div class="tab-pane fade in" id="mem_item2">
<div class="row-fluid"> 
    <div class="box gradient span8">
   
   
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart1);
      function drawChart1() {
        var data = google.visualization.arrayToDataTable([
		['Task', 'Hours per Day'],
		<?php if(is_array($membershipfields) && count($membershipfields) > 0 ){  
		$membershipfields = $CORE->multisort( $membershipfields , array('order') );	
		foreach($membershipfields as $field){ if(!is_numeric($field['ID'])){ continue; } ?>
          
          ['<?php echo stripslashes($field['name']); ?>', <?php echo $CORE->COUNTUSER('wlt_membership',$field['ID']); ?>],
     
		 <?php } ?>
		<?php } ?>
        ]);

        var options = { 	
		  width: '99%',
		  height: '500px',
		  legend: 'bottom',
		  chartArea:{ top:20 }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
		
        chart.draw(data, options);
      }
	  jQuery(window).resize(function(){
			drawChart1();
			
	});
	function delayredraw1(){
	setTimeout(function(){drawChart1(); },1000);
	}
    </script> 
   <div id="piechart2" style="width: 566px; height: 500px;"></div>
   
    </div>
    <div class="span4">
        
        <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Package</th>
                  <th>Count</th>
                 
                </tr>
              </thead>
              <tbody>
                <?php 
				 $ppck = 0; 
				if(is_array($membershipfields) && count($membershipfields) > 0 ){ 
				$mk1 = array();
		$membershipfields = $CORE->multisort( $membershipfields , array('order') );	
		foreach($membershipfields as $field){ if(!is_numeric($field['ID'])){ continue; } ?> 
                <tr>
                  
                  <td><?php echo stripslashes($field['name']); ?></td>
                  <td><?php $thisc = $CORE->COUNTUSER('wlt_membership',$field['ID']); $ppck += $thisc; echo $thisc; ?></td>
                </tr>
                 <?php array_push($mk1,$field['ID']);} ?>
		<?php } ?>
        
        
        <tr>
                  
                  <td>Not Assigned <a href="javascript:void(0);" rel="tooltip" data-original-title="This count includes members which have a membership assigned but are not covered by those above." data-placement="top"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/0/7.png" align="absmiddle" style="float:right;padding-right:10px;"></a></td>
                  <td><?php echo $CORE->COUNTUSER('wlt_membership',$mk1,false); ?></td>
                </tr>
                
                 <tr>
                  
                  <td>Everything Else <a href="javascript:void(0);" rel="tooltip" data-original-title="This count includes all users without a membership assigned." data-placement="top"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/0/7.png" align="absmiddle" style="float:right;padding-right:10px;"></a></td>
                  <td><?php $g = $result = count_users(); echo $g['total_users']-$ppck; ?></td>
                </tr>
        
              </tbody>
            </table>
            
            <hr />
            
        <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Transfer Memberships </th>
                  </tr>
              </thead>
              <tbody>
          
        
        <tr> <td>
        
        <select onchange="jQuery('#fromM').val(this.value);">
        <option></option>
          <?php if(is_array($membershipfields) && count($membershipfields) > 0 ){  $membershipfields = $CORE->multisort( $membershipfields , array('order') );	
		foreach($membershipfields as $field){ if(!is_numeric($field['ID'])){ continue; } ?> 
                <option value="<?php echo $field['ID']; ?>">From: <?php echo stripslashes($field['name']); ?></option>
          <?php } } ?>
           <option value="-1">Not Assigned</option>
          <option value="-2">Everything Else</option>
          
        </select>
        
        </td> </tr>
       
        <tr> <td>
          
        <select onchange="jQuery('#toM').val(this.value);">
        <option></option>
          <?php if(is_array($membershipfields) && count($membershipfields) > 0 ){  $membershipfields = $CORE->multisort( $membershipfields , array('order') );	
		foreach($membershipfields as $field){ if(!is_numeric($field['ID'])){ continue; } ?> 
                <option value="<?php echo $field['ID']; ?>">To: <?php echo stripslashes($field['name']); ?></option>
          <?php } } ?>
        </select>
        </td> </tr>
        
            <tr> <td style="text-align:center">
          
        <button class="btn btn-primary" type="button" onclick="document.TransferFormMembership.submit();">Start Transfer</button>
        </td> </tr>
            
        
              </tbody>
            </table>
    
    </div>
</div>

</div>
<div class="tab-pane active" id="mem_item1">

<div class="row-fluid">
 
    <div class="box gradient span8">

      <div class="title">
            <div class="row-fluid">
            <a href="admin.php?page=4" class="btn btn-info" style="float:right;margin-top:4px; margin-right:10px;">Delete All</a>
              <a data-toggle="modal" href="#membershipModal" class="btn btn-success" style="float:right;margin-top:4px; margin-right:10px;">Add Membership</a>
            <h3><i class="icon-list-alt"></i>Memberships</h3></div>
        </div><!-- End .title -->
        
        <div class="content" style="min-height:500px;">
       <?php
	   if(is_array($membershipfields) && count($membershipfields) > 0 ){ 
	  
	    ?>
 
            <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
            <thead>
            <tr>
              <th class="no_sort" style="width:30px;text-align:center;">ID</th>
              <th class="no_sort">Title</th>
               <th class="no_sort">Length</th> 
              <th class="no_sort" style="width:110px;text-align:center;">Price</th>
              <th class="no_sort" style="width:110px;text-align:center;">Actions</th>
            </thead>
            <tbody>
            
        <?php 
		$membershipfields = get_option("membershipfields");	
		$ordered_membershipfields = $CORE->multisort( $membershipfields , array('order') );		
		foreach($ordered_membershipfields as $mkey => $field){ ?>
        
		<tr>
        <td><?php echo $field['ID']; ?></td>
         <td><?php echo $field['name']; ?>
         
         <?php if(isset($field['hidden']) && $field['hidden'] == "yes"){ echo "<div class='label label-info'>hidden package</div>"; } ?>
         </td>
         <td><?php echo $field['expires']; ?> Days</td>
         <td><center><?php echo hook_price($field['price']); ?></center></td>
         <td class="ms">
                 <div class="btn-group1">
                  <a class="btn btn-small" rel="tooltip" 
                  href="admin.php?page=5&edit_membership_field=<?php echo $CORE->multisortkey($membershipfields, 'name', $field['name']); ?>"
                  data-placement="left" data-original-title=" edit "><i class="gicon-edit"></i></a>                   
                  <a class="btn btn-inverse btn-small confirm" rel="tooltip" data-placement="bottom" 
                  data-original-title="Remove"
                  href="admin.php?page=5&delete_membership_field=<?php echo $CORE->multisortkey($membershipfields, 'name', $field['name']); ?>"
                  ><i class="gicon-remove icon-white"></i></a> 
                </div>
         </td>
         </tr>
         
         <?php  } ?>
            
        </tbody>
        </table>
            
        <?php } ?>
         
        </div> <!-- End .content -->
      
      <?php do_action('hook_admin_5_tab3_left'); ?> 
 
        
    </div><!-- End .box -->
    
    
    <div class="box gradient span4">
      <div class="title">
            <div class="row-fluid">
                <h3><i class="icon-cog"></i>Extra Settings</h3>
            </div>
        </div><!-- End .title -->
        <div class="content">
       
       
      <div class="form-row row-fluid ">
                            <label class="control-label span7" rel="tooltip" data-original-title="Turn ON to show membership package options on the listing packages form." data-placement="top">Show On Submission</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('show_mem_listingpage').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('show_mem_listingpage').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['show_mem_listingpage'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="show_mem_listingpage" name="admin_values[show_mem_listingpage]" 
                             value="<?php echo $core_admin_values['show_mem_listingpage']; ?>">
            </div>
       
       
      <div class="form-row row-fluid ">
                            <label class="control-label span7" rel="tooltip" data-original-title="Turn ON to show membership package options on the registration form." data-placement="top">Show On Registration</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('show_mem_registraion').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('show_mem_registraion').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['show_mem_registraion'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="show_mem_registraion" name="admin_values[show_mem_registraion]" 
                             value="<?php echo $core_admin_values['show_mem_registraion']; ?>">
            </div>
            
            <hr /> 
         
            <b> Restricted Access Text</b>
            
             <div class="form-row control-group row-fluid ">
           
             <small>You can restrict page/post content based on membership package access using the [MEMBERSHIP] shortcode. Enter the display text below that users see if they stumble upon restricted content.</small>
            
             
  <textarea class="row-fluid" id="default-textarea" style="height:200px;" name="admin_values[membership_restrictedtext]"><?php echo stripslashes($core_admin_values['membership_restrictedtext']); ?></textarea> 
                     
            </div> 
            example shortcode usage;
            <p class="label label-success" style="margin-top:10px;"> [MEMBERSHIP ID="1,2,3"] <br /> text here <br /> [/MEMBERSHIP] </p>  
            
            
             <?php do_action('hook_admin_5_tab3_right'); ?> 
       
       
        </div> <!-- End .content -->
   
 
    </div><!-- End .box -->
   
    
    
    
    </div>


</div>
</div></div>
<!--------------------- END MEMBERSHIPS ------------------->














 








<?php

$packagefields = get_option("packagefields");
?>
<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "packages"){ echo "active in"; } ?>" id="packages">



<ul id="tabExample1" class="nav nav-tabs">
<li class="active"><a href="#pak_item1" data-toggle="tab" onclick="document.getElementById('ShowSubTab').value='home_layout1';">Package Setup</a></li>  
<li><a href="#pak_item2" data-toggle="tab" onclick="document.getElementById('ShowSubTab').value='home_slider';delayredraw();">Statistics</a></li>     
</ul>
<div class="tab-content">

<div class="tab-pane fade in" id="pak_item2">


<div class="row-fluid"> 
    <div class="box gradient span8">
   
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart2);
      function drawChart2() {
        var data = google.visualization.arrayToDataTable([
		['Task', 'Hours per Day'],
		<?php if(is_array($packagefields) && count($packagefields) > 0 ){  
		$packagefields = $CORE->multisort( $packagefields , array('order') );	
		foreach($packagefields as $field){ if(!is_numeric($field['ID'])){ continue; } ?>
          
          ['<?php echo stripslashes($field['name']); ?>', <?php echo $CORE->COUNT('packageID',$field['ID']); ?>],
     
		 <?php } ?>
		<?php } ?>
        ]);

        var options = { 	
		  width: '99%',
		  height: '500px',
		  legend: 'bottom',
		  chartArea:{ top:20 }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
		
        chart.draw(data, options);
      }
	  jQuery(window).resize(function(){
			drawChart2();
			
	});
	function delayredraw(){
	setTimeout(function(){drawChart2(); },1000);
	}
    </script> 
   <div id="piechart" style="width: 566px; height: 500px;"></div>
   
    </div>
    <div class="span4">
        
        <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Package</th>
                  <th>Count</th>
                 
                </tr>
              </thead>
              <tbody>
                <?php 
				 $ppck = 0; 
				if(is_array($packagefields) && count($packagefields) > 0 ){ 
				$pk1 = array();
		$packagefields = $CORE->multisort( $packagefields , array('order') );	
		foreach($packagefields as $field){ if(!is_numeric($field['ID'])){ continue; } ?> 
                <tr>
                  
                  <td><?php echo stripslashes($field['name']); ?></td>
                  <td><?php $thisc = $CORE->COUNT('packageID',$field['ID']); $ppck += $thisc; echo $thisc; ?></td>
                </tr>
                 <?php array_push($pk1,$field['ID']);} ?>
		<?php } ?>
        
        
        <tr>
                  
                  <td>Not Assigned <a href="javascript:void(0);" rel="tooltip" data-original-title="This count includes listing which have a package assigned but are not covered by those above. Such packages usually refer to ones which have been deleted and/or no longer exist." data-placement="top"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/0/7.png" align="absmiddle" style="float:right;padding-right:10px;"></a></td>
                  <td><?php echo $CORE->COUNT('packageID',$pk1,false); ?></td>
                </tr>
                
                 <tr>
                  
                  <td>Everything Else <a href="javascript:void(0);" rel="tooltip" data-original-title="This count includes listings (published and drafted) which have not been assigned a listing package." data-placement="top"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/0/7.png" align="absmiddle" style="float:right;padding-right:10px;"></a></td>
                  <td><?php $g = wp_count_posts( THEME_TAXONOMY."_type" ); echo ($g->publish+$g->draft)-$ppck; ?></td>
                </tr>
        
              </tbody>
            </table>
            
            <hr />
            
        <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Transfer Listings </th>
                  </tr>
              </thead>
              <tbody>
          
        
        <tr> <td>
        
        <select onchange="jQuery('#fromL').val(this.value);">
        <option></option>
          <?php if(is_array($packagefields) && count($packagefields) > 0 ){  $packagefields = $CORE->multisort( $packagefields , array('order') );	
		foreach($packagefields as $field){ if(!is_numeric($field['ID'])){ continue; } ?> 
                <option value="<?php echo $field['ID']; ?>">From: <?php echo stripslashes($field['name']); ?></option>
          <?php } } ?>
           <option value="-1">Not Assigned</option>
          <option value="-2">Everything Else</option>
          
        </select>
        
        </td> </tr>
       
        <tr> <td>
          
        <select onchange="jQuery('#toL').val(this.value);">
        <option></option>
          <?php if(is_array($packagefields) && count($packagefields) > 0 ){  $packagefields = $CORE->multisort( $packagefields , array('order') );	
		foreach($packagefields as $field){ if(!is_numeric($field['ID'])){ continue; } ?> 
                <option value="<?php echo $field['ID']; ?>">To: <?php echo stripslashes($field['name']); ?></option>
          <?php } } ?>
        </select>
        </td> </tr>
        
            <tr> <td style="text-align:center">
          
        <button class="btn btn-primary" type="button" onclick="document.TransferFormListing.submit();">Start Transfer</button>
        </td> </tr>
            
        
              </tbody>
            </table>
    
    </div>
</div>


</div>
<div class="tab-pane active" id="pak_item1">

                                        
<div class="row-fluid"> 
    <div class="box gradient span8">

      <div class="title">
            <div class="row-fluid">
            <a href="admin.php?page=4" class="btn btn-info" style="float:right;margin-top:4px; margin-right:10px;">Delete All</a>
              <a data-toggle="modal" href="#packageModal" class="btn btn-success" style="float:right;margin-top:4px; margin-right:10px;">Add Package</a>
            <h3><i class="icon-list-alt"></i>Listing Packages</h3></div>
        </div><!-- End .title -->
        
        <div class="content" style="min-height:500px;">
       <?php 
	   if(is_array($packagefields) && count($packagefields) > 0 ){ 
	   
	    ?>
 
            <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
            <thead>
            <tr>
              <th class="no_sort" style="width:30px;text-align:center;">ID</th>
              <th class="no_sort">Title</th>
              <th class="no_sort">Length</th>   
              <th class="no_sort" style="width:90px;text-align:center;">Price</th>
              <th class="no_sort" style="width:150px;text-align:center;">Actions</th>
            </thead>
            <tbody>
            
        <?php 
		$packagefields = get_option("packagefields");
		$ordered_packagefields = $CORE->multisort( $packagefields , array('order') );	
		foreach($ordered_packagefields as $field){ if(!is_numeric($field['ID'])){ continue; } ?>
        
		<tr>
         <td><?php echo $field['ID']; ?></td>
         <td><?php echo stripslashes($field['name']); ?> 
		 <br /><div style='font-size:11px;'>categories: <?php if($field['multiple_cats_amount'] == ""){ echo "not set"; }else{ echo $field['multiple_cats_amount']; } ?> / uploads: <?php if($field['max_uploads'] == ""){ echo "not set"; }else{ echo $field['max_uploads']; } ?> </div>
		 <?php if(isset($field['hidden']) && $field['hidden'] == "yes"){ echo "<div class='label label-info'>hidden package</div>"; } ?></td>
         <td><?php echo $field['expires']; ?> Days</td>
         <td><center><?php echo hook_price($field['price']); ?></center></td>
         <td class="ms">
                 <div class="btn-group1">
                 
                 <a class="btn btn-small" href="javascript:void(0);" onclick="jQuery('#extradata<?php echo $field['ID']; ?>').show();"><i class="gicon-plus"></i></a>                   
                  
                  
                  <a class="btn btn-small" rel="tooltip" 
                  href="admin.php?page=5&edit_package_field=<?php echo $CORE->multisortkey($packagefields, 'name', $field['name']); ?>"
                  data-placement="left" data-original-title=" edit "><i class="gicon-edit"></i></a>                   
                  
                  <a class="btn btn-inverse btn-small confirm" rel="tooltip" data-placement="bottom" 
                  data-original-title="Remove"
                  href="admin.php?page=5&delete_package_field=<?php echo $CORE->multisortkey($packagefields, 'name', $field['name']); ?>"
                  ><i class="gicon-remove icon-white"></i></a> 
                </div>
         </td>
         </tr>
         
         <tr>
         <td colspan="5" style="padding-bottom:0px; margin-bottom:0px; display:none;" id="extradata<?php echo $field['ID']; ?>">
         <?php
		 $fflink = $GLOBALS['CORE_THEME']['links']['add']."?pakid=".$field['ID'];
		 ?>
        <div class="row-fluid" style="padding-bottom:0px; margin-bottom:0px;">
        <div class="span2" style="line-height:30px;">Direct Link</div>
        <div class="span10"><input class="span9" type="text" style="font-size:12px;" value="<?php echo $fflink; ?>"/> <a href="<?php echo $fflink; ?>" target="_blank">[+]</a> <a class="label" href="javascript:void(0);" onclick="jQuery('#extradata<?php echo $field['ID']; ?>').hide();" style="color:#fff;">hide</a>     </div>
        </div>
         </td>
         </tr>
         
         <?php  } ?>
            
        </tbody>
        </table>
            
        <?php }else{ ?>
        
        
        <h5><b>No Packages Created</b></h5>
        <p>Enter default values below for newly created listings without any packages assigned.</p>
        <table class="table table-bordered table-striped"><thead><tr>
        <th>Listing Defaults</th>
        <th></th>
        </tr></thead><tbody>
        
        <tr><td>
        <span class="label">Media File Uploads</span>
        <p style="font-size:10px;">This is the number of files a user can upload as part of their listings.</p>
        </td>
        <td>
        <div class="input-prepend row-fluid span6">
        <input type="text" name="admin_values[default_submission_fileuploads]" style="width:100px;text-align:right;" class="row-fluid" value="<?php echo $core_admin_values['default_submission_fileuploads']; ?>">
        <span class="add-on "> Files:  #</span>
    	</div>
        </td>
        </tr>
        
 
        </tr></tbody></table>
        
        <?php } ?>
                 
        </div> <!-- End .content -->
        
        
        
             <div class="title"><div class="row-fluid"><h3><i class="icon-cog"></i>Custom Page Text</h3></div></div><!-- End .title -->      
      <div class="content">     
      
      <hr />

      <div class="form-row row-fluid ">
                            <label class="control-label span7" rel="tooltip" data-original-title="Turn ON to allow users to upgrade their listing packages." data-placement="top">Show Upgrade Options</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('show_upgradeoptions').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('show_upgradeoptions').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['show_upgradeoptions'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="show_upgradeoptions" name="admin_values[show_upgradeoptions]" 
                             value="<?php echo $core_admin_values['show_upgradeoptions']; ?>">
            </div> 
             
             <div class="form-row control-group row-fluid ">           
             <small>Here you can add your own text under the header on the packages page.</small>
  <textarea class="row-fluid" id="default-textarea" style="height:123px;" name="admin_values[custom][package_text]"><?php echo stripslashes($core_admin_values['custom']['package_text']); ?></textarea>
            </div>       
        </div> <!-- End .content -->
      
      <?php do_action('hook_admin_5_tab2_left'); ?> 
 
        
    </div><!-- End .box -->

    <div class="box gradient span4">
    
    
    
    
     <div class="title">
            <div class="row-fluid">
                <h3><i class="icon-wrench"></i>Listing Enhancements</h3>
            </div>
     </div><!-- End .title -->
     <div class="content">
     
     <p style="font-size:12px;">Listing Enhancements let you charge an extra fee for additional features.</p><span class="label"> Set the price to 0 to disable feature.</span>
        
<hr />
 
<div class="row-fluid">
<div class="span6" style="font-size:11px;" rel="tooltip" data-original-title="Set a custom field 'fontpage' so you can use it with widgets or plugins." data-placement="top">Front Page Exposure</div>
<div class="span6">
    <div class="input-prepend row-fluid span6">
        <input type="text" name="admin_values[enhancement][1_price]" style="width:100px;text-align:right;" class="row-fluid" value="<?php echo $core_admin_values['enhancement']['1_price']; ?>">
        <span class="add-on ">$</span>
    </div>
	</div>
</div>
        
<div class="row-fluid">
<div class="span6" style="font-size:11px;" rel="tooltip" data-original-title="Listings will be seperated and displayed at the top when viewing categories." data-placement="top">Top of Category Results</div>
<div class="span6">
    <div class="input-prepend row-fluid span6">
        <input type="text" name="admin_values[enhancement][5_price]" style="width:100px;text-align:right;" class="row-fluid" value="<?php echo $core_admin_values['enhancement']['5_price']; ?>">
        <span class="add-on ">$</span>
    </div>
	</div>
</div>        
 
<div class="row-fluid">
<div class="span6" style="font-size:11px;" rel="tooltip" data-original-title="Listings will show up with a colored bacground in search results." data-placement="top">Highlighted Listing</div>
<div class="span6">
    <div class="input-prepend row-fluid span6">
        <input type="text" name="admin_values[enhancement][2_price]" style="width:100px;text-align:right;" class="row-fluid" value="<?php echo $core_admin_values['enhancement']['2_price']; ?>">
        <span class="add-on ">$</span>
    </div>
	</div>
</div>        
        
        
 
<div class="row-fluid">
<div class="span6" style="font-size:11px;" rel="tooltip" data-original-title="Will allow the user to access the HTML editor." data-placement="top">HTML Listing Content</div>
<div class="span6">
    <div class="input-prepend row-fluid span6">
        <input type="text" name="admin_values[enhancement][3_price]" style="width:100px;text-align:right;" class="row-fluid" value="<?php echo $core_admin_values['enhancement']['3_price']; ?>">
        <span class="add-on ">$</span>
    </div>
	</div>
</div>        
        
 
<div class="row-fluid">
<div class="span6" style="font-size:11px;" rel="tooltip" data-original-title="Will display a visitor counter at the bottom of the users page. (author view only)" data-placement="top">Visitor Counter</div>
<div class="span6">
    <div class="input-prepend row-fluid span6">
        <input type="text" name="admin_values[enhancement][4_price]" style="width:100px;text-align:right;" class="row-fluid" value="<?php echo $core_admin_values['enhancement']['4_price']; ?>">
        <span class="add-on ">$</span>
    </div>
	</div>
</div>   

<div class="row-fluid">
<div class="span6" style="font-size:11px;" rel="tooltip" data-original-title="Will display a map on the users listing page." data-placement="top">Google Map</div>
<div class="span6">
    <div class="input-prepend row-fluid span6">
        <input type="text" name="admin_values[enhancement][6_price]" style="width:100px;text-align:right;" class="row-fluid" value="<?php echo $core_admin_values['enhancement']['6_price']; ?>">
        <span class="add-on ">$</span>
    </div>
	</div>
</div>


<hr />

      <div class="form-row row-fluid ">
                            <label class="control-label span7" rel="tooltip" data-original-title="Turn ON to show the display of feature enhancements on your submission page." data-placement="top">Show Enhancements</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('show_enhancements').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('show_enhancements').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['show_enhancements'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="show_enhancements" name="admin_values[show_enhancements]" 
                             value="<?php echo $core_admin_values['show_enhancements']; ?>">
            </div> 

</div>
<div class="clearfix"></div>

<div class="title"><div class="row-fluid"><h3><i class="icon-refresh"></i>Extra Price Per Category</h3></div></div><!-- End .title -->
<div class="content"> 


<select class="span12" multiple="multiple" style="height:200px;" onclick="jQuery('#updatedcatalert').html('');jQuery('#catid').val(this.value); WLTCatPrice('<?php echo str_replace("http://","",get_home_url()); ?>', this.value, 'currentpricebox');">
<?php echo $CORE->CategoryList(array(0,false,0,THEME_TAXONOMY,0,0,true)); ?>
</select>
<div class="row-fluid">
<span id="updatedcatalert"></span>
<div class="controls span12">         
     <div class="input-prepend">
      <span class="add-on"><?php echo $core_admin_values['currency']['code']; ?></span>
      <span id="currentpricebox"><input type="text" name="catprice" class="span8" style="margin-right:15px;text-align:right;" id="catprice"></span> 
      <a href="javascript:void(0);" onclick="SaveCatPrice();" class="btn">save</a>  
      <input type="hidden" name="catid" value="" id="catid"> 
    </div>        
</div>
</div>   
</div> 
<script>
function SaveCatPrice(){
var catid = jQuery('#catid').val();
var price = jQuery('#catprice').val();
WLTCatPriceUpdate('<?php echo str_replace("http://","",get_home_url()); ?>', catid, price, 'updatedcatalert');
}
</script>
<script src="<?php echo FRAMREWORK_URI.'js/core.ajax.js'; ?>" type="text/javascript"></script>


<?php do_action('hook_admin_5_tab2_right'); ?>

 
   
 
    </div><!-- End .box -->
 

</div>          


</div>  </div> <!-- end innbox content box -->
</div> <!-------------------- PACKAGES ---------------->



















                                   
                                   
 
 
 
 
</div>

     
<!-- start save button -->
<div class="form-actions row-fluid">
<div class="span7 offset5">
<button type="submit" class="btn btn-primary">Save Changes</button> 
</div>
</div> 
<!-- end save button -->      
</form> 






<?php 
 
if(isset($_GET['edit_submission_field']) && is_numeric($_GET['edit_submission_field'])  && !isset($_POST['submitted']) ){ 
$submissionfields = get_option("submissionfields");
//$submissionfields = $CORE->multisort( $submissionfields , array('order') );
?>
<script type="text/javascript">
jQuery(document).ready(function () { jQuery('#submissionModal').modal('show'); })
</script>
<?php } ?>

<form method="post" name="admin_submission_field" id="admin_submission_field" action="admin.php?page=5" onsubmit="return ValidateSubmissionFields();">
<input type="hidden" name="newsubmissionfield" value="yes" />
<input type="hidden" name="tab" value="submission" />
<?php if(isset($_GET['edit_submission_field'])){ ?>
<input type="hidden" name="eid" value="<?php echo $_GET['edit_submission_field']; ?>" />
<input type="hidden" name="submissionfield[ID]" value="<?php echo $submissionfields[$_GET['edit_submission_field']]['ID']; ?>" />
<?php } ?>
      
<script type="text/javascript"> 
function ValidateSubmissionFields(){ 
	var cus3 	= document.getElementById("submissionfield_key");
	var cus4 	= document.getElementById("ttval");
	 
	if(jQuery('#reg_new_1').val() == 'title'){ return true; }
 
	if(cus3.value == '' && cus4.value == ''){
		alert('Please enter a unique database key.');
		cus3.style.border = 'thin solid red';
		cus3.focus();
		return false;
	}
	return true;					
}
function removeWhitespace(){
 var nst = jQuery("#submissionfield_key").val();
 var st1 = nst.split(' ').join('');
 jQuery("#submissionfield_key").val(st1); 
  
}
</script>  
<div id="submissionModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
              <h3 id="myModalLabel">Submission Field</h3>
            </div>
            <div class="modal-body" style="min-height:400px;">
        
           <div class="form-row control-group row-fluid">
                <label class="control-label span4" for="normal-field"><b>Display Caption</b></label>
                <div class="controls span7">
                  <input type="text"  name="submissionfield[name]" class="row-fluid" value="<?php if(isset($_GET['edit_submission_field'])){ echo stripslashes($submissionfields[$_GET['edit_submission_field']]['name']); }?>">
                   
                </div>
              </div> 
              
           <div class="form-row control-group row-fluid">
                <label class="control-label span4" for="normal-field">Description</label>
                <div class="controls span7">
                  <input type="text"  name="submissionfield[help]" class="row-fluid" value="<?php if(isset($_GET['edit_submission_field'])){ echo stripslashes($submissionfields[$_GET['edit_submission_field']]['help']); }?>">
                   
                </div>
           </div> 	
              
            <div class="form-row control-group row-fluid">
                <label class="control-label span4" for="normal-field">Field Type</label>
                <div class="controls span7">
                  <select name="submissionfield[fieldtype]" id="reg_new_1" class="chzn-select" onchange="showhideextrafield(this.value)">
                  
                    <option value="input" <?php if(isset($_GET['edit_submission_field'])){ if($submissionfields[$_GET['edit_submission_field']]['fieldtype'] == "input"){echo "selected=selected"; } }?>>Input Field</option>
                    <option value="textarea" <?php if(isset($_GET['edit_submission_field'])){ if($submissionfields[$_GET['edit_submission_field']]['fieldtype'] == "textarea"){echo "selected=selected"; } }?>>Text Area</option>
                    <option value="checkbox" <?php if(isset($_GET['edit_submission_field'])){ if($submissionfields[$_GET['edit_submission_field']]['fieldtype'] == "checkbox"){echo "selected=selected"; } }?>>Checkbox</option>
                    <option value="radio" <?php if(isset($_GET['edit_submission_field'])){ if($submissionfields[$_GET['edit_submission_field']]['fieldtype'] == "radio"){echo "selected=selected"; } }?>>Radio Button</option>
                     <option value="select" <?php if(isset($_GET['edit_submission_field'])){ if($submissionfields[$_GET['edit_submission_field']]['fieldtype'] == "select"){echo "selected=selected"; } }?>>Selection</option>
                     <option value="taxonomy" <?php if(isset($_GET['edit_submission_field'])){ if($submissionfields[$_GET['edit_submission_field']]['fieldtype'] == "taxonomy"){echo "selected=selected"; } }?>>Taxonomy</option>  
                      <option value="date" <?php if(isset($_GET['edit_submission_field'])){ if($submissionfields[$_GET['edit_submission_field']]['fieldtype'] == "date"){echo "selected=selected"; } }?>>Date</option>  
                    
                     <option value="title" <?php if(isset($_GET['edit_submission_field'])){ if($submissionfields[$_GET['edit_submission_field']]['fieldtype'] == "title"){echo "selected=selected"; } }?>>Display Caption (Title Only)</option>  
                    
                                      
                    </select>
     
                </div>
            </div>
   
            <script>
			
			function showhideextrafield(val){
			
				if(val == "title" ){
				jQuery('#dbkey').val('title');			
				jQuery('#dbkey').hide();
				jQuery('.checkbox').hide();				
				
				}else if(val == "checkbox" || val =="radio" || val =="select" ){
				jQuery('#extrafieldvalues').show();
				
				}else if(val == "taxonomy" ){
				jQuery('#taxvalues').show();
				jQuery('#tax_link').show();				
				jQuery('#dbkey').hide();
				
				
				} else {
				jQuery('#extrafieldvalues').hide();
				}			
			}
			 
			</script>     
            
           <div class="form-row control-group row-fluid" id="extrafieldvalues" 
		   <?php if(isset($_GET['edit_submission_field'])){ if($submissionfields[$_GET['edit_submission_field']]['fieldtype'] == "select" || $submissionfields[$_GET['edit_submission_field']]['fieldtype'] == "radio" || $submissionfields[$_GET['edit_submission_field']]['fieldtype'] == "checkbox"){ }else{ echo 'style="display:none;"'; } }else{ echo 'style="display:none;"'; } ?>>
                <label class="control-label span4" for="normal-field">Field Values</label>
                <div class="controls span7">
                   
                 <textarea class="row-fluid"  name="submissionfield[values]" placeholder="One value per line" style="border:1px solid orange;height:100px;"><?php if(isset($_GET['edit_submission_field'])){ echo $submissionfields[$_GET['edit_submission_field']]['values']; }?></textarea>
                   
                </div>
              </div>
            
            
            <div class="form-row control-group row-fluid" id="taxvalues" <?php if(isset($_GET['edit_submission_field'])){ if( $submissionfields[$_GET['edit_submission_field']]['fieldtype'] == "taxonomy"){ }else{ echo 'style="display:none;"'; } }else{ echo 'style="display:none;"'; } ?>>
                <label class="control-label span4">Taxonomy</label>
                <div class="controls span7">
                  
                 <select name="submissionfield[taxonomy]" class="row-fluid" id="ttval">
                 <option value=""></option>
                        <?php
						if(isset($_GET['edit_submission_field'])){
						$select_tax = $submissionfields[$_GET['edit_submission_field']]['taxonomy'];
						}else{
						$select_tax = "";
						}
						$taxs = get_taxonomies();
						$not_wanted = array('nav_menu','post_tag','post_format');
                        foreach ($taxs as $tax) {
							if(in_array($tax,$not_wanted)){ continue; }
							if($tax == "category"){ $display_text = "Blog Category"; }elseif($tax == "listing"){ $display_text = "Listing Categories"; }else{ $display_text = $tax; }
							
                            printf( '<option value="%1$s"%2$s>%3$s</option>', $tax, selected( $select_tax , $tax, false ), $display_text );
                        }
                        ?>
                    </select>
                </div>
            </div>
            
            
            
            <div class="form-row control-group row-fluid" id="tax_link" <?php if(isset($_GET['edit_submission_field'])){ if( $submissionfields[$_GET['edit_submission_field']]['fieldtype'] == "taxonomy"){ }else{ echo 'style="display:none;"'; } }else{ echo 'style="display:none;"'; } ?>>
                <label class="control-label span4">Linked With:</label>
                <div class="controls span7">
                  
                 <select name="submissionfield[taxonomy_link]" class="row-fluid" id="ttval">
                 <option value="0">Not Linked</option>
                        <?php
						if(isset($_GET['edit_submission_field'])){
						$select_tax = $submissionfields[$_GET['edit_submission_field']]['taxonomy_link'];
						}else{
						$select_tax = "";
						}
						$taxs = get_taxonomies();
						$not_wanted = array('nav_menu','post_tag','post_format');
                        foreach ($taxs as $tax) {
							if(in_array($tax,$not_wanted)){ continue; }
							if($tax == "category"){ $display_text = "Blog Category"; }elseif($tax == "listing"){ $display_text = "Listing Categories"; }else{ $display_text = $tax; }
							
                            printf( '<option value="%1$s"%2$s>%3$s</option>', $tax, selected( $select_tax , $tax, false ), $display_text );
                        }
                        ?>
                    </select>
                </div>
            </div>
                   
               
           <?php if(is_array($packagefields) && count($packagefields) > 0){ ?>   
           <div class="form-row control-group row-fluid">
                <label class="control-label span4">Assign To Package</label>
                <div class="controls span7">
                  <select name="submissionfield[package][]" id="assign_package_id" class="chzn-select" multiple="">
                  <option></option>
                   <?php
				   
				   foreach($packagefields as $field){
				   
				   $ee = "";
				   if(isset($submissionfields[$_GET['edit_submission_field']]['package']) && in_array($field['ID'], $submissionfields[$_GET['edit_submission_field']]['package']) ){
				   	
						$ee = "selected=selected";
				   }
				   
				   echo "<option value='".$field['ID']."' ".$ee.">".$field['name']."</option>";
				   
				   }
				   
				   ?>                    
                                                             
                    </select>
                </div>
              </div> 
             <?php } ?> 
             
             <?php /* if(is_array($membershipfields) && count($membershipfields) > 0){ ?>   
           <div class="form-row control-group row-fluid">
                <label class="control-label span4">Assign To Membership</label>
                <div class="controls span7">
                  <select name="submissionfield[membership][]" id="assign_membership_id" class="chzn-select" multiple="">
                  <option></option>
                   <?php
				   
				   foreach($membershipfields as $field){
				   
				   $ee = "";
				   if(isset($submissionfields[$_GET['edit_submission_field']]['membership']) && in_array($field['ID'], $submissionfields[$_GET['edit_submission_field']]['membership']) ){
				   	
						$ee = "selected=selected";
				   }
				   
				   echo "<option value='".$field['ID']."' ".$ee.">".$field['name']."</option>";
				   
				   }
				   
				   ?>                    
                                                             
                    </select>
                </div>
              </div> 
             <?php } */ ?>            
             
             
           <div class="form-row control-group row-fluid" id="dbkey" <?php if(isset($_GET['edit_submission_field'])){ if( $submissionfields[$_GET['edit_submission_field']]['fieldtype'] == "taxonomy"){  echo 'style="display:none;"'; } } ?>>
                <label class="control-label span4" for="normal-field">Database Key</label>
                <div class="controls span7">
                  <input type="text" onchange="removeWhitespace();"  name="submissionfield[key]" id="submissionfield_key" class="row-fluid" value="<?php if(isset($_GET['edit_submission_field'])){ echo $submissionfields[$_GET['edit_submission_field']]['key']; }?>">
                   
                </div>
              </div>  
         
              
              
           <div class="form-row control-group row-fluid">
                <label class="control-label span4" for="normal-field">Display Order</label>
                <div class="controls span7">
                
                <div class="span3" style="margin-left: 0px;">
                  <input type="text" name="submissionfield[order]" class="row-fluid" style="width:50px;" value="<?php if(isset($_GET['edit_submission_field'])){ echo $submissionfields[$_GET['edit_submission_field']]['order']; }?>">
                 </div> 
                 
                    
                </div>
            </div>
            
            <?php hook_admin_5_customfields_edit(); ?>
            
            

           
    <label class="checkbox">
      <input type="checkbox" onchange="ChangeTickValue('sf1');" <?php if(isset($_GET['edit_submission_field'])){ if($submissionfields[$_GET['edit_submission_field']]['required'] == "yes"){echo "checked=checked"; } }?>> Required Field - <small> The user will be prompted to select/enter a value.</small>
    </label>
     <input type="hidden" name="submissionfield[required]" id="sf1" value="<?php if(isset($_GET['edit_submission_field'])){ echo $submissionfields[$_GET['edit_submission_field']]['required']; }else{ echo "no";}?>" />
    
    <hr />
    
     <label class="checkbox">
      <input type="checkbox" onchange="ChangeTickValue('sf2');" <?php if(isset($_GET['edit_submission_field'])){ if($submissionfields[$_GET['edit_submission_field']]['hideme'] == "yes"){echo "checked=checked"; } }?>> Hide Me - <small> Enable if you want this value to be hidden from the listing display page.</small>
    </label>
    
    
     <input type="hidden" name="submissionfield[hideme]" id="sf2" value="<?php if(isset($_GET['edit_submission_field'])){ echo $submissionfields[$_GET['edit_submission_field']]['hideme']; }else{ echo "no";}?>" />
    <hr />
    
    
      <label class="checkbox">
      <input type="checkbox" onchange="ChangeTickValue('sf4');" <?php if(isset($_GET['edit_submission_field'])){ if($submissionfields[$_GET['edit_submission_field']]['smalllist'] == "yes"){echo "checked=checked"; } }?>> Show Small List - <small> Enable if this will be displayed in the small [FIELDLIST] shortcode on the listing page.</small>
    </label>
    
    
     <input type="hidden" name="submissionfield[smalllist]" id="sf4" value="<?php if(isset($_GET['edit_submission_field'])){ echo $submissionfields[$_GET['edit_submission_field']]['smalllist']; }else{ echo "no";}?>" />
    <hr />
   
    <?php /*
    <label class="checkbox">
      <input type="checkbox" onchange="ChangeTickValue('sf2');" <?php if(isset($_GET['edit_submission_field'])){ if($submissionfields[$_GET['edit_submission_field']]['alert'] == "yes"){echo "checked=checked"; } }?>> Display as Alert - <small>The value provided by the user with be displayed at the top of the listing in an alert box.</small>
    </label>
            
     <input type="hidden" name="submissionfield[alert]" id="sf2" value="<?php if(isset($_GET['edit_submission_field'])){ echo $submissionfields[$_GET['edit_submission_field']]['alert']; }else{ echo "no";}?>" />
           
        */?>   
                       
            
              
            </div>
            
            <div class="modal-footer">
              <button class="btn" data-dismiss="modal">Close</button>
              <button class="btn btn-primary">Save changes</button>
            </div>
</div>
      
</form>      
      
      
      
      
      
      
      
      
      
<input type="hidden" value="" name="imgIdblock" id="imgIdblock" />
<script type="text/javascript">

function ChangeImgBlock(divname){
document.getElementById("imgIdblock").value = divname;
} 


jQuery(document).ready(function() {
 
window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src'); 
 jQuery('#'+document.getElementById("imgIdblock").value).val(imgurl);
 tb_remove();
 jQuery('#packageModal').modal('show');
} 

});

</script>       
      
      
      
      
      
      
      
 
      
<?php if(isset($_GET['edit_package_field']) && is_numeric($_GET['edit_package_field'])  && !isset($_POST['submitted']) ){ 
$packagefields = get_option("packagefields");
?>
<script type="text/javascript">
jQuery(document).ready(function () { jQuery('#packageModal').modal('show'); })
</script>
<?php } ?>

<form method="post" name="admin_package_field" id="admin_package_field" action="admin.php?page=5" onsubmit="return ValidatePackageFields();">
<input type="hidden" name="newpackagefield" value="yes" />
<input type="hidden" name="tab" value="packages" />
<?php if(isset($_GET['edit_package_field'])){ ?>
<input type="hidden" name="eid" value="<?php echo $_GET['edit_package_field']; ?>" />
<input type="hidden" name="packagefield[ID]" value="<?php echo $packagefields[$_GET['edit_package_field']]['ID']; ?>" />
<?php } ?>
<script type="text/javascript"> 
function ValidatePackageFields(){ 

	var cus0 	= document.getElementById("pprice");
	if(cus0.value == ''){
		alert('Please enter a package price.');
		cus0.style.border = 'thin solid red';
		cus0.focus();
		return false;
	}

	var cus1 	= document.getElementById("multiple_cats_amount");
	if(cus1.value == ''){
		alert('Please enter a value for the Max # categories.');
		cus1.style.border = 'thin solid red';
		cus1.focus();
		return false;
	}
	
	var cus2 	= document.getElementById("max_uploads");
	if(cus2.value == ''){
		alert('Please enter a value for the Max # images.');
		cus2.style.border = 'thin solid red';
		cus2.focus();
		return false;
	}	
	
	var cus3 	= document.getElementById("expiryd");
	if(cus3.value == ''){
		alert('Please enter a value for the number of days before expiry.');
		cus3.style.border = 'thin solid red';
		cus3.focus();
		return false;
	}
	return true;					
}
</script> 
<div id="packageModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
              <h3 id="myModalLabel">Package Field</h3>
            </div>
            <div class="modal-body" style="min-height:400px;">
            
            
    <div class="accordion" id="accordion1">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#packagedetails1">
       1. Listing Package Details
      </a>
    </div>
    <div id="packagedetails1" class="accordion-body collapse">
      <div class="accordion-inner">
            
  
           <!--
            <div class="form-row row-fluid">
                <label class="span3">Image</label>
                <div class="controls span7">
                <div class="input-append row-fluid">
                  <input type="text"  name="packagefield[image]" id="upload_pak" class="row-fluid" value="<?php if(isset($_GET['edit_package_field'])){ echo $packagefields[$_GET['edit_package_field']]['image']; }?>">
                  <span class="add-on" id="upload_pakimage"><i class="icon-globe"></i></span>
                  </div>
                </div>
            </div>  
            
            -->
            
<script type="text/javascript">
    jQuery(document).ready(function () {
      	jQuery('#upload_pakimage').click(function() { 
		
		jQuery('#packageModal').modal('hide');
		
		 ChangeImgBlock('upload_pak');
		 formfield = jQuery('#upload_pak').attr('name');
		 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		 return false;
		});
    });	
</script>            
                   
          
           <div class="form-row row-fluid">
                <label class="span3">Title</label>
                <div class="controls span8">
                  <input type="text"  name="packagefield[name]" class="row-fluid" value="<?php if(isset($_GET['edit_package_field'])){ echo stripslashes($packagefields[$_GET['edit_package_field']]['name']); }?>">
                </div>
            </div>
              
           <div class="form-row row-fluid">
                <label class="span3">Sub Caption</label>
                <div class="controls span8">
                  <input type="text"  name="packagefield[subtext]" class="row-fluid" value="<?php if(isset($_GET['edit_package_field'])){ echo stripslashes($packagefields[$_GET['edit_package_field']]['subtext']); }?>">
                </div>
            </div>  
                        
              
  
          
            <div class="form-row row-fluid">
               <div class="input-prepend row-fluid" style="margin-left:20px;">
                    <span class="add-on" rel="tooltip" data-original-title="The display order." data-placement="top">Display Order</span>
                    <input type="text" name="packagefield[order]" style="width:200px;text-align:right;" class="row-fluid" value="<?php if(isset($_GET['edit_package_field'])){ echo $packagefields[$_GET['edit_package_field']]['order']; }?>">         
                	</div>     
            </div>      
              
              
         <div class="form-row row-fluid">
               <div style="padding-left:10px;">Description</div>
                <div style="padding:10px;">
              <textarea class="row-fluid" name="packagefield[description]" style="height:100px;"><?php if(isset($_GET['edit_package_field'])){ echo stripslashes($packagefields[$_GET['edit_package_field']]['description']); }?></textarea> </div>
            </div>
            
            
            <div class="form-row row-fluid">
              <label class="checkbox" style="margin-top:-9px;">
      <input type="checkbox" onchange="ChangeTickValue('pf1');" <?php if(isset($_GET['edit_package_field'])){ if($packagefields[$_GET['edit_package_field']]['hidden'] == "yes"){echo "checked=checked"; } }?>> Hide Me - <small> This will hide the package from display.</small>
    </label>
     <input type="hidden" name="packagefield[hidden]" id="pf1" value="<?php if(isset($_GET['edit_package_field']) && $packagefields[$_GET['edit_package_field']]['hidden'] !=""){ echo $packagefields[$_GET['edit_package_field']]['hidden']; }else{ echo "no";}?>" />
    
            </div>
            
            
      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#packagedetails2">
        2. Listing Package Features
      </a>
    </div>
    <div id="packagedetails2" class="accordion-body collapse">
      <div class="accordion-inner">
            
            
            
           
             <div class="form-row row-fluid">
             
                <label class="span4">Multiple Categories</label>   
                
                <div class="span4 content"> 
               
                            <div class="span7 controls">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle"  id="toggle1-off"
                                  value="off" onchange="document.getElementById('enable_cats').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle" id="toggle1-on"
                                  value="on" onchange="document.getElementById('enable_cats').value='1'">
                                  </label>
                                  <div class="toggle 
								  <?php if(isset($_GET['edit_package_field'])){ if($packagefields[$_GET['edit_package_field']]['multiple_cats'] == "1"){ echo "on"; } }?> ">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="enable_cats" name="packagefield[multiple_cats]" 
                             value="<?php if(isset($_GET['edit_package_field'])){ echo $packagefields[$_GET['edit_package_field']]['multiple_cats']; }?>">              
                
                </div>              
				<div class="span3"> 
                
                <div class="input-prepend row-fluid span6">
                    
                    Max: <input type="text" name="packagefield[multiple_cats_amount]" id="multiple_cats_amount" class="row-fluid" style="width:100px;text-align:right;" value="<?php if(isset($_GET['edit_package_field'])){ echo $packagefields[$_GET['edit_package_field']]['multiple_cats_amount']; }?>">
                    <span class="add-on ">Max #</span>
                  </div> 
                 
                
              </div>
              
              </div>
            
              
               <div class="form-row row-fluid">
                <label class="span4">User Uploads</label>   
                
                <div class="span4 content"> 
                
                            <div class="span7 controls">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle"  id="toggle2-off"
                                  value="off" onchange="document.getElementById('enable_images').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle" id="toggle2-on"
                                  value="on" onchange="document.getElementById('enable_images').value='1'">
                                  </label>
                                  <div class="toggle 
								  <?php if(isset($_GET['edit_package_field'])){ if($packagefields[$_GET['edit_package_field']]['multiple_images'] == "1"){ echo "on"; } }?> ">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="enable_images" name="packagefield[multiple_images]" 
                             value="<?php if(isset($_GET['edit_package_field'])){ echo $packagefields[$_GET['edit_package_field']]['multiple_images']; }?>">    
                
                </div>              
			
                
                  <div class="controls span3">                                
                <div class="input-prepend row-fluid span6">
                    
                    Max: <input type="text"  name="packagefield[max_uploads]" id="max_uploads" style="width:100px;text-align:right;" class="row-fluid" value="<?php if(isset($_GET['edit_package_field'])){ echo $packagefields[$_GET['edit_package_field']]['max_uploads']; }?>">
                    <span class="add-on ">Max #</span>
                  </div> 
                </div> 
                
           
              
              </div>              
               
              
              <div class="row-fluid" style="padding:10px;">
              <div class="span6">
              <p>Listing Enhancements </p>
              <p style="font-size:11px;">Tick to enable. Enabled enhancements will automatically be included as part of the listing price.</p>
              </div>
              <div class="span6">
              
               <?php
				$earray = array(
				'1' => array('dbkey'=>'frontpage','text'=>'Front Page Exposure'),
				'2' => array('dbkey'=>'featured','text'=>'Highlighted Listing'),
				'3' => array('dbkey'=>'html','text'=>'HTML Listing Content'), 
				'4' => array('dbkey'=>'visitorcounter','text'=>'Visitor Counter'),
				'5' => array('dbkey'=>'topcategory','text'=>'Top of Category Results Page'),
				'6' => array('dbkey'=>'showgooglemap','text'=>'Google Map'),
				);
				 
				foreach($earray as $key=>$val){ 
				$checked = "";
				if(isset($_GET['edit_package_field'])){ if($packagefields[$_GET['edit_package_field']]['enhancement'][$key] == "1"){ $checked = "checked=checked"; } }
				
				echo '<input name="packagefield[enhancement]['.$key.']" type="checkbox" value="1" '.$checked.'/> '.$val['text']." <br />";
				
				}			
				?>
              </div>
              </div>
                          
                           
         	<hr />
            
           
        <?php hook_admin_5_packages_edit(); ?>
            
         
           
           
      </div>  </div>    </div> 
   <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#packagedetails3">
        3. Listing Expiry Options
      </a>
    </div>
    <div id="packagedetails3" class="accordion-body collapse">
      <div class="accordion-inner">
            
  
  
	<div class="form-row row-fluid">
    	 <label class="span6">Days Before Expire</label>   
         <div class="row-fluid span4">       
        <div class="input-append">
        <input type="text"  name="packagefield[expires]" id="expiryd" style="text-align:left;" class="row-fluid" value="<?php if(isset($_GET['edit_package_field'])){ echo $packagefields[$_GET['edit_package_field']]['expires']; }?>">
        <span class="add-on">Days</span>
        </div>
        </div>
	</div> 
    
    <div class="form-row row-fluid">
    <label class="span6">What happens when it expires?</label> 
    <div class="row-fluid span5">
    
    <select name="packagefield[action]">
    <option value="0" <?php if(isset($_GET['edit_package_field'])){ if($packagefields[$_GET['edit_package_field']]['action'] == "0"){ echo "selected=selected"; }}?>>Nothing</option>
    <option value="1" <?php if(isset($_GET['edit_package_field'])){ if($packagefields[$_GET['edit_package_field']]['action'] == "1"){ echo "selected=selected"; }}?>>Set as draft</option>
    <option value="3" <?php if(isset($_GET['edit_package_field'])){ if($packagefields[$_GET['edit_package_field']]['action'] == "3"){ echo "selected=selected"; }}?>>Set as pending</option>
    <option value="2" <?php if(isset($_GET['edit_package_field'])){ if($packagefields[$_GET['edit_package_field']]['action'] == "2"){ echo "selected=selected"; }} ?>>Delete</option>
    <?php  
		foreach($packagefields as $field){ if(!is_numeric($field['ID'])){ continue; } ?>
        <option value="move-<?php echo $field['ID']; ?>" <?php if(isset($_GET['edit_package_field'])){ if($packagefields[$_GET['edit_package_field']]['action'] == "move-".$field['ID']){ echo "selected=selected"; }} ?>>Move to: <?php echo $field['name']; ?></option>
    <?php } ?>
   
    </select>
    
    </div>
    
    </div>   
       
   
  </div>
  
  
  
  
   </div>    </div> 
   <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#packagedetails4">
        4. Package Table Text
      </a>
    </div>
    <div id="packagedetails4" class="accordion-body collapse">
      <div class="accordion-inner">
  
  
  
  
    <div class="form-row row-fluid">
                <label class="span4">Show Default Text</label>   
                
                <div class="span4 content"> 
                
                            <div class="span7 controls">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle"  id="toggle2-off"
                                  value="off" onchange="document.getElementById('enable_text').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle" id="toggle2-on"
                                  value="on" onchange="document.getElementById('enable_text').value='1'">
                                  </label>
                                  <div class="toggle 
								  <?php if(isset($_GET['edit_package_field'])){ if($packagefields[$_GET['edit_package_field']]['enable_text'] == "1"){ echo "on"; } }?> ">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="enable_text" name="packagefield[enable_text]" 
                             value="<?php if(isset($_GET['edit_package_field'])){ echo $packagefields[$_GET['edit_package_field']]['enable_text']; }?>">    
                
                </div>
  </div>
<?php $i=1; while($i < 10){ ?> 
<div class="form-row row-fluid">
    <label class="span2">#<?php echo $i; ?></label>   
    <div class="row-fluid span10">       
    <input type="text"  name="packagefield[etext<?php echo $i; ?>]"   style="text-align:left;" class="row-fluid" value="<?php if(isset($_GET['edit_package_field'])){ echo $packagefields[$_GET['edit_package_field']]['etext'.$i]; }?>">    
    </div>
</div> 
<?php $i++; } ?>
  
  
  
  
  
  
    
            
 </div>  </div>    </div>
 
 
   <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion5" href="#packagedetails5">
        5. Listing Price
      </a>
    </div>
    <div id="packagedetails5" class="accordion-body collapse">
      <div class="accordion-inner">
 
 
 
  <div class="form-row row-fluid"> 
            
                <div class="span6">             
                 
                 <div class="input-prepend row-fluid" style="margin-left:20px;">
                    <span class="add-on">Listing Price: <?php echo $core_admin_values['currency']['symbol']; ?></span>
                    <input type="text"  name="packagefield[price]" id="pprice" style="width:200px;text-align:right;" class="row-fluid" value="<?php if(isset($_GET['edit_package_field'])){ echo $packagefields[$_GET['edit_package_field']]['price']; }?>">
                	</div> 
                    
                                         
                </div><div class="span6">                                     
                           
                	                  
                    
                </div>                  
              </div> 
 
 
 
 
 
     </div>  </div>  </div>  </div>  
              
            </div>
            
            <div class="modal-footer">
              <button class="btn" data-dismiss="modal">Close</button>
              <button class="btn btn-primary">Save changes</button>
            </div>
</div>



</form>

















<?php if(isset($_GET['edit_membership_field']) && is_numeric($_GET['edit_membership_field'])  && !isset($_POST['submitted']) ){ 
$membershipfields = get_option("membershipfields");

?>
<script type="text/javascript">
jQuery(document).ready(function () { jQuery('#membershipModal').modal('show'); })
</script>
<?php } ?>

<form method="post" name="admin_membership_field" id="admin_membership_field" action="admin.php?page=5" onsubmit="return ValidateMembershipFields();">
<input type="hidden" name="newmembershipfield" value="yes" />
<input type="hidden" name="tab" value="memberships" />
<?php if(isset($_GET['edit_membership_field'])){ ?>
<input type="hidden" name="eid" value="<?php echo $_GET['edit_membership_field']; ?>" />
<input type="hidden" name="membershipfield[ID]" value="<?php echo $membershipfields[$_GET['edit_membership_field']]['ID']; ?>" />
<?php } ?>
<script type="text/javascript"> 
function ValidateMembershipFields(){ 

	var cus0 	= document.getElementById("mprice");
	if(cus0.value == ''){
		alert('Please enter a membership price.');
		cus0.style.border = 'thin solid red';
		cus0.focus();
		return false;
	}
	var cus1 	= document.getElementById("submissionamount");
	if(cus1.value == ''){
		alert('Please enter an amount for the number of listings the user can create.');
		cus1.style.border = 'thin solid red';
		cus1.focus();
		return false;
	}	
	
	
 	
	return true;					
}
</script> 
<div id="membershipModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
              <h3 id="myModalLabel">Membership Package</h3>
            </div>
            <div class="modal-body" style="min-height:400px;">
 
    <div class="accordion" id="accordion2">
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#membershipdetails1">
       1. Membership Display Options
      </a>
    </div>
    <div id="membershipdetails1" class="accordion-body collapse">
      <div class="accordion-inner">
          
          <!--
            <div class="form-row row-fluid">
                <label class="span3">Image</label>
                <div class="controls span7">
                <div class="input-append row-fluid">
                  <input type="text"  name="membershipfield[image]" id="upload_pak1" class="row-fluid" value="<?php if(isset($_GET['edit_membership_field'])){ echo $membershipfields[$_GET['edit_membership_field']]['image']; }?>">
                  <span class="add-on" id="upload_pakimage1"><i class="icon-globe"></i></span>
                  </div>
                </div>
            </div> 
            
            --> 
            
<script type="text/javascript">
    jQuery(document).ready(function () {
      	jQuery('#upload_pakimage1').click(function() { 
		
		jQuery('#membershipModal').modal('hide');
		
		 ChangeImgBlock('upload_pak1');
		 formfield = jQuery('#upload_pak1').attr('name');
		 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
		 return false;
		});
    });	
</script>                  
            
            
                   
          
           <div class="form-row row-fluid">
                <label class="span3">Title</label>
                <div class="controls span7">
                  <input type="text"  name="membershipfield[name]" class="row-fluid" value="<?php if(isset($_GET['edit_membership_field'])){ echo stripslashes($membershipfields[$_GET['edit_membership_field']]['name']); }?>">
                </div>
            </div>
              
           <div class="form-row row-fluid">
                <label class="span3">Sub Caption</label>
                <div class="controls span7">
                  <input type="text"  name="membershipfield[subtext]" class="row-fluid" value="<?php if(isset($_GET['edit_membership_field'])){ echo stripslashes($membershipfields[$_GET['edit_membership_field']]['subtext']); }?>">
                </div>
            </div>  
                        
            
            <div class="form-row row-fluid"> 
                <div class="span4">             
                 
                 <div class="input-prepend row-fluid span6">
                    <span class="add-on" rel="tooltip" data-original-title="Membership price" data-placement="top">Price: <?php echo $core_admin_values['currency']['symbol']; ?></span>
                    <input type="text"  name="membershipfield[price]" id="mprice" style="width:120px;text-align:right;" class="row-fluid" value="<?php if(isset($_GET['edit_membership_field'])){ echo $membershipfields[$_GET['edit_membership_field']]['price']; }?>">
                	</div>                                         
                </div><div class="span4" style="margin-left:0px;"> 
                                    
                    <div class="input-prepend row-fluid span6">
                    
                      <input type="text"  name="membershipfield[expires]" style="width:150px;text-align:right;" class="row-fluid" value="<?php if(isset($_GET['edit_membership_field'])){ echo $membershipfields[$_GET['edit_membership_field']]['expires']; }?>">
                    <span class="add-on" rel="tooltip" data-original-title="Membership length in days." data-placement="top">Length: Days</span>
                  </div> 
                                        
                </div><div class="span4">                                     
                           
                	 <div class="input-prepend row-fluid span6">
                    <span class="add-on" rel="tooltip" data-original-title="The display order." data-placement="top">Order</span>
                    <input type="text" name="membershipfield[order]" style="width:100px;text-align:right;" class="row-fluid" value="<?php if(isset($_GET['edit_membership_field'])){ echo $membershipfields[$_GET['edit_membership_field']]['order']; }?>">         
                	</div>                     
                    
                </div>                  
              </div>
              
              
              
         <div class="form-row row-fluid">
                <div style="padding-left:10px;">Description</div>
                <div style="padding:10px;">
              <textarea class="row-fluid" name="membershipfield[description]" style="height:100px;"><?php if(isset($_GET['edit_membership_field'])){ echo stripslashes($membershipfields[$_GET['edit_membership_field']]['description']); }?></textarea>
              </div>
            </div>
          
    
     <label class="checkbox">
      <input type="checkbox" onchange="ChangeTickValue('mmf2');" <?php if(isset($_GET['edit_membership_field'])){ if($membershipfields[$_GET['edit_membership_field']]['hidden'] == "yes"){echo "checked=checked"; } }?>> Hide Me - <small> Enable if you want this to be hidden from user display.</small>
    </label>
    
      <input type="hidden" name="membershipfield[hidden]" id="mmf2" value="<?php if(isset($_GET['edit_membership_field'])){ if($membershipfields[$_GET['edit_membership_field']]['hidden'] == ""){ echo "no"; }else{ echo $membershipfields[$_GET['edit_membership_field']]['hidden']; } }else{ echo "no"; }?>" />
            
            
            <?php //hook_admin_5_memberships_edit(); ?>
            
         
              
              
      </div>
    </div>
  </div>
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#membershipdetails2">
        2. Membership Submission Options
      </a>
    </div>
    <div id="membershipdetails2" class="accordion-body collapse">
      <div class="accordion-inner">
              
 
              <div style="padding:10px;border-bottom:1px solid #ddd;">As part of the users membership you can allow them to create multiple listings. <br /><small><b>Set the package and submission limit below.</b></small></div>
     
   
    <div class="form-row row-fluid">
              <div class="span6">
              <label>Which Package? </label>
 
              </div>
              <div class="span6"> 
           
                  <select name="membershipfield[package]" id="assign_package_id1" class="chzn-select">
                  <option></option>
                   <?php
				   
				   foreach($packagefields as $key => $field){
				   
				   $ee = "";
				   if(isset($membershipfields[$_GET['edit_membership_field']]['package']) && $field['ID'] == $membershipfields[$_GET['edit_membership_field']]['package']  ){
				   	
						$ee = "selected=selected";
				   }
				   
				   echo "<option value='".$CORE->multisortkey($packagefields, 'name', $field['name'])."' ".$ee.">".$field['name']."</option>";
				   
				   }
				   
				   ?>                    
                                                             
                    </select>
                
               </div> 
             
              </div>
              
              
              
  <div class="form-row row-fluid">
              
              	<label class="span6">Can read messages</label>   
                     
				<div class="span6">                                
                <div class="row-fluid span6">                    
                      <select name="membershipfield[can_read]" class="row-fluid">
                      <option value="yes" <?php if(isset($_GET['edit_membership_field'])){ if($membershipfields[$_GET['edit_membership_field']]['can_read'] == "yes"){ echo "selected=selected"; } }?>> Yes </option>
                      <option value="no" <?php if(isset($_GET['edit_membership_field'])){ if($membershipfields[$_GET['edit_membership_field']]['can_read'] == "no"){ echo "selected=selected"; } }?>> No </option>
                      </select>
                     
                  </div> 
                </div> 
                   <div class="clearfix"></div> 
                
             </div> 
              
              
                <div class="form-row row-fluid">
              
              	<label class="span6">Max. number of listings</label>   
                     
				<div class="span6">                                
                <div class="input-prepend row-fluid span6">                    
                      <input type="text"  name="membershipfield[submissionamount]" id="submissionamount" style="width:100px;text-align:right;" class="row-fluid" value="<?php if(isset($_GET['edit_membership_field'])){ echo $membershipfields[$_GET['edit_membership_field']]['submissionamount']; }?>">
                    <span class="add-on ">#</span>
                  </div> 
                </div> 
                   <div class="clearfix"></div> 
               <div style="padding:10px;">
               <small><span class="label">Note</span> Listing enhancements, media space, listing expiry period and category limits will be taken from the listing package set above. The listing price (minus any additional enhancements) will be free.</small>
               </div>
             </div>  
               
             
       </div>
    </div>
  </div>
 



  
   <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#membershipdetails4">
       3. Package Table Text
      </a>
    </div>
    <div id="membershipdetails4" class="accordion-body collapse">
      <div class="accordion-inner">
  
   
    <div class="form-row row-fluid">
                <label class="span4">Show Default Text</label>   
                
                <div class="span4 content"> 
                
                            <div class="span7 controls">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle"  id="toggle2-off"
                                  value="off" onchange="document.getElementById('enable_text1').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle" id="toggle2-on"
                                  value="on" onchange="document.getElementById('enable_text1').value='1'">
                                  </label>
                                  <div class="toggle 
								  <?php if(isset($_GET['edit_membership_field'])){ if($membershipfields[$_GET['edit_membership_field']]['enable_text'] == 1){ echo "on"; } }?> ">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="enable_text1" name="membershipfield[enable_text]" value="<?php if(isset($_GET['edit_membership_field'])){ echo $membershipfields[$_GET['edit_membership_field']]['enable_text']; }?>">    
                
                </div>
  </div>
<?php $i=1; while($i < 10){ ?> 
<div class="form-row row-fluid">
    <label class="span2">#<?php echo $i; ?></label>   
    <div class="row-fluid span10">       
    <input type="text"  name="membershipfield[etext<?php echo $i; ?>]"   style="text-align:left;" class="row-fluid" value="<?php if(isset($_GET['edit_membership_field'])){ echo $membershipfields[$_GET['edit_membership_field']]['etext'.$i]; }?>">    
    </div>
</div> 
<?php $i++; } ?>
  
  
  
  
  
  
    
            
 </div>  </div>   </div>    </div>   
              
              
              
            </div>
            
            <div class="modal-footer">
              <button class="btn" data-dismiss="modal">Close</button>
              <button class="btn btn-primary">Save changes</button>
            </div>
</div>
</form>

<form id="TransferFormListing" name="TransferFormListing" method="post" action="">
<input type="hidden" name="TransferFormListings" id="go" />
<input type="hidden" name="tab" id="ShowTab" value="packages">
<input type="hidden" name="from" id="fromL" value="" />
<input type="hidden" name="to" id="toL" value="" />
<input type="hidden" name="all"  value="<?php if(is_array($pk1) && !empty($pk1)){ $ff =""; foreach($pk1 as $kk){ $ff .= $kk.","; } echo substr($ff,0,-1); } ?>" />
</form>

<form id="TransferFormMembership" name="TransferFormMembership" method="post" action="">
<input type="hidden" name="TransferFormMemberships" id="go" />
<input type="hidden" name="tab" id="ShowTab" value="memberships">
<input type="hidden" name="from" id="fromM" value="" />
<input type="hidden" name="to" id="toM" value="" />
<input type="hidden" name="all"  value="<?php if(is_array($mk1) && !empty($mk1)){ $ff =""; foreach($mk1 as $kk){ $ff .= $kk.","; } echo substr($ff,0,-1); } ?>" />
</form>

  <script language="javascript"> 
 function ChangeTickValue(div){ 
	 if(document.getElementById(div).value=='no'){
	 document.getElementById(div).value= 'yes';
	 }else{
	 document.getElementById(div).value= 'no';
	 } 
 } 
 </script> 
<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); ?>
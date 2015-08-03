<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $CORE_ADMIN;
// LOAD IN OPTIONS FOR ADVANCED SEARCH
wp_enqueue_script( 'jquery-ui-sortable' );
wp_register_script( 'PPT4', FRAMREWORK_URI.'js/core.search.js');
wp_enqueue_script( 'PPT4' );


if(!defined('WLT_DEMOMODE')){

	if(isset($_GET['delrating'])){
	
	$wpdb->query("DELETE FROM ".$wpdb->prefix."postmeta WHERE meta_key='starrating' ");
	$wpdb->query("DELETE FROM ".$wpdb->prefix."postmeta WHERE meta_key='starrating_total' ");
	$wpdb->query("DELETE FROM ".$wpdb->prefix."postmeta WHERE meta_key='starrating_votes' ");
	$wpdb->query("DELETE FROM ".$wpdb->prefix."postmeta WHERE meta_key='ratingup' ");
	$wpdb->query("DELETE FROM ".$wpdb->prefix."postmeta WHERE meta_key='ratingdown' ");
	$wpdb->query("DELETE FROM ".$wpdb->prefix."postmeta WHERE meta_key='rating_total' ");
	
	update_option('rated_user_ips','');
	$GLOBALS['error_message'] = "Rating Data Removed";
	}

	if(isset($_POST['newregfield'])){				
		// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
		$regfields = get_option("regfields");
		if(!is_array($regfields)){ $regfields = array(); }
		// ADD ONE NEW FIELD 
		if(!isset($_POST['eid'])){
			$_POST['regfield']['ID'] = count($regfields);
			array_push($regfields, $_POST['regfield']);
			
			$GLOBALS['error_message'] = "Registration Field Added Successfully";
		}else{
			$regfields[$_POST['eid']] = $_POST['regfield'];
			
			$GLOBALS['error_message'] = "Registration Field Updated Successfully";
		}
		// SAVE ARRAY DATA		 
		update_option( "regfields", $regfields);					
	}elseif(isset($_GET['delete_reg_field']) && is_numeric($_GET['delete_reg_field'] )){	
		// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
		$regfields = get_option("regfields");
		if(!is_array($regfields)){ $regfields = array(); }
 		
		// DELETE SELECTED VALUE
		unset($regfields[$_GET['delete_reg_field']]);	
 	
		// SAVE ARRAY DATA
		update_option( "regfields", $regfields);		
		$_POST['tab'] = "registration";
		$GLOBALS['error_message'] = "Registration Field Removed Successfully";	
 
	} 
}
// SORT TABBING
if(isset($_GET['edit_reg_field']) && is_numeric($_GET['edit_reg_field']) ){ 
$_POST['tab'] = "registration";
}

// RESET
if(isset($_POST['admin_values']['google_coords']) && $_POST['admin_values']['google_coords'] != "0,0"){
delete_option('wlt_saved_zipcodes');
}

// SEARCH FUNCTIONALITY
$SS = new Core_Advanced_Search; 
if(isset($_POST['searchform']) && !defined('WLT_DEMOMODE') ){
$SS->save_options();
}
// LOAD IN THE CORE CONTENT
$core_admin_values = get_option("core_admin_values"); 
// LOAD IN HEADER
$CORE_ADMIN->HEAD();

?>

<?php if(isset($_GET['firstinstall']) && !isset($_POST['adminArray']) ){ 

$link = "http://www.premiumpress.com/videos/?responsive=1&theme=".$GLOBALS['CORE_THEME']['template']."&key=".get_option('wlt_license_key')."&welcomevideo=1";
?>

<div class="alert alert-block">

<div class="row-fluid">
<div class="span7">

<h4 style="color: #c09853;font-size:20px;font-weight:bold;margin-top:20px;">New Installation - Welcome to your new website!</h4>
<p><b class="label label-warning">You will only see this once! Don't miss it!</b> </p>  
<p>Please take a few moments to watch the introductory video tutorial opposite. <br/> 
It will help you understand the admin layout, options and general work flow so you can get started as quick as possible without any unnecessary set backs.</p>

<p>Should you require any further help or support, use the 'support center' option on the top menu bar to be redirected to the theme support and information pages.</p>

<p>Thank you and good luck!</p>

<button type="submit" class="btn btn-warning"  onclick="document.getElementById('ShowTab').value='home';alert('It\'s all you now! Good luck!');">Click here to continue</button><span id="gotobtn"></span>

<p></p>
</div>
<div class="span5"><a href="<?php echo $link; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/video/v1.jpg" /></a></div>
</div>
</div>
<input type="hidden" name="newinstall" value="premiumpress" />
<?php } ?>

            
<ul id="tabExample1" class="nav nav-tabs">
<?php
// HOOK INTO THE ADMIN TABS
function _1_tabs(){ $STRING = ""; global $wpdb; $core_admin_values = get_option("core_admin_values");
	
	if(isset($_GET['tab'])){ $_POST['tab'] = $_GET['tab']; }
	
	$pages_array = array( 
	"1" => array("t" => "General Settings", "k"=>"home", "d" => true),
	"2" => array("t" => "Registration", 	"k"=>"registration"),	 
	"3" => array("t" => "Advanced Search",  "k"=>"search"),
 
	);
	foreach($pages_array as $page){	
	if( ( isset($_POST['tab']) && $_POST['tab'] == $page['k']  ) || ( !isset($_POST['tab']) && $page['k'] == "home" )  ){ $class = "active"; }else{ $class = ""; }	
		if(isset($_POST['tab']) && $_POST['tab'] == "" && isset($page['d']) ){ $class = "active"; }
		$STRING .= '<li class="'.$class.'"><a href="#'.$page['k'].'"  onclick="document.getElementById(\'ShowTab\').value=\''.$page['k'].'\'" data-toggle="tab">'.$page['t'].'</a></li>';		
	} 
	return $STRING;

}
echo hook_admin_1_tabs(_1_tabs());
// END HOOK
?>                         
</ul>
           
          
<div class="tab-content"> 

<?php do_action('hook_admin_1_content'); ?>

 

<!--------------------------- SEARCH TAB ---------------------------->
  

<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "search"){ echo "active in"; } ?>" id="search">

<?php $SS->plugin_page(); ?>

</div>

<!--------------------------- REGISTRATION TAB ---------------------------->

<style>
#home .form-row {
margin-top: 0px;
padding-bottom:5px;
border-bottom: 1px dotted #dfdfdf;
}

</style> 
<div class="tab-pane fade <?php if(!isset($_POST['tab']) || ( isset($_POST['tab']) && ( $_POST['tab'] =="" || $_POST['tab'] =="home" ) )){ echo "active in"; } ?>" id="home">

 
<div class="tabbable tabs-left" >
<ul id="tabExample3" class="nav nav-tabs" style="height:1200px">
<li class="active"><a href="#set1" data-toggle="tab"><span class="sh1">General Settings</span></a></li>


<?php do_action('hook_admin_1_tab1_tablist'); ?> 


<?php if( $GLOBALS['CORE_THEME']['template'] != ""){ ?><li><a href="#set2" data-toggle="tab"><span class="sh2">Page &amp; Button Links</span></a></li><?php } ?>
<?php if(defined('WLT_ENABLE_MOBILEWEB')){ ?>
<li><a href="#set3" data-toggle="tab"><span class="sh3">Mobile Display <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/new.png"></span></a></li>
<?php } ?>
<li><a href="#set8" data-toggle="tab"><span class="sh8">Footer &amp; Analytics</span></a></li>


<li><hr /></p>
</li>

<li><a href="#set5" data-toggle="tab"><span class="sh5">My Account Page</span></a></li>

<?php if(!defined('WLT_HIDE_ADMIN_5')){ ?><li><a href="#set4" data-toggle="tab"><span class="sh4">Add Listing Page</span></a></li><?php } ?>
<li><a href="#set9" data-toggle="tab"><span class="sh9">Search Results Page</span></a></li>
<li><a href="#set9a" data-toggle="tab"><span class="sh9">Listing Page</span></a></li>


<li><hr /></li>


<li><a href="#set7" data-toggle="tab"><span class="sh7">Star Rating Settings</span></a></li>
<li><a href="#set11" data-toggle="tab"><span class="sh11">Feedback Settings <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/new.png"></span></a></li>




<li><a href="#set10" data-toggle="tab"><span class="sh10">Breadcrumbs</span></a></li>


<li><a href="#set12" data-toggle="tab"><span class="sh12">GEO Locations/ Maps <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/new.png"></span></a></li>

<li><a href="#set6" data-toggle="tab"><span class="sh6">Misc</span></a></li>


</ul>
<div class="tab-content content"  style="background:#fff;height:1200px">

	 <?php do_action('hook_admin_1_tab1_newsubtab'); ?>  
     
 
  
<div class="tab-pane fade in" id="set12">


  <?php if(!defined('WLT_CART')){ ?>
            
        <div class="heading1">GEO Location</div>  
             
             
       <div class="form-row control-group row-fluid">
        <label class="control-label span5" for="style">Display GEO Change Location</label>
        <div class="controls span6">
        <select name="admin_values[geolocation]" class="chzn-select" id="geo1">

          <option value="" <?php if($core_admin_values['geolocation'] == ""){ echo "selected=selected"; } ?>>Disable</option>
          <option value="1" <?php if($core_admin_values['geolocation'] == "1"){ echo "selected=selected"; } ?>>Enable in Top Menu</option> 
          <option value="2" <?php if($core_admin_values['geolocation'] == "2"){ echo "selected=selected"; } ?>>Enable in Breadcrumbs</option> 
         
         
        </select>
        </div>
        </div> 
        
        <div class="form-row control-group row-fluid">
        <label class="control-label span5" for="style">Display GEO Flag</label>
        <div class="controls span6">
        <select name="admin_values[geolocation_flag]" class="chzn-select" id="geo2">

         <?php
		 
		  $selected = $core_admin_values['geolocation_flag'];
				 
                 foreach ($GLOBALS['core_country_list'] as $key=>$option) {				 				
                 	printf( '<option value="%1$s"%3$s>%2$s</option>', trim( $key  ), $option, selected( $selected, $key, false ) );
                 }
		 
		 ?> 
         
        </select>
        </div>
        </div> 
        
        
        <div class="form-row control-group row-fluid">
        <label class="control-label span5" for="style">Distance Unit</label>
        <div class="controls span6">
        <select name="admin_values[geolocation_unit]" class="chzn-select" id="geo3">

          <option value="" <?php if($core_admin_values['geolocation_unit'] == ""){ echo "selected=selected"; } ?>>Miles</option>
          <option value="K" <?php if($core_admin_values['geolocation_unit'] == "K"){ echo "selected=selected"; } ?>>Kilometers</option> 
          <option value="N" <?php if($core_admin_values['geolocation_unit'] == "N"){ echo "selected=selected"; } ?>>Nautical Miles</option> 
         
         
        </select>
        </div>
        </div> 
        
        
        <?php }else{ ?>

<input name="admin_values[geolocation]" value="" type="hidden">
		<?php } ?>

<div class="heading1">Google Map Displays</div>  
       

       <div class="form-row control-group row-fluid ">
                            <label class="control-label span7" rel="tooltip" data-original-title="Turn ON this feature to display a Google map on submission pages to collect long/lat data for mapping user listings. *recommended*" data-placement="top">Google Maps</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('google').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('google').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['google'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="google" name="admin_values[google]" 
                             value="<?php echo $core_admin_values['google']; ?>">
            </div>  

             
<div class="heading1"> Add/Listing Page</div>     
             
 
            
            
     <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="Turn ON to require the user to select a map location otherwise it can be ignored." data-placement="top">Google Map Required</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('google_required').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('google_required').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['google_required'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="google_required" name="admin_values[google_required]" 
                             value="<?php echo $core_admin_values['google_required']; ?>">
            </div>  
            
            
            
  
            <?php 
			
			if($core_admin_values['google_region'] == ""){ $core_admin_values['google_region'] = "us"; } 
			if($core_admin_values['google_lang'] == ""){ $core_admin_values['google_lang'] = "en"; }
			?>
            
            <!------------ FIELD -------------->          
            <div class="row-fluid" style="padding-bottom: 5px; border-bottom: 1px dotted #dfdfdf; padding-top:5px;">
          
                <label class="control-label span4 offset3">Region Code <br /><small>list at bottom <a href="http://en.wikipedia.org/wiki/CcTLD" target="_blank">here</a></small></label>
                <div class="controls span4">         
                
                  <input type="text"  name="admin_values[google_region]" value="<?php echo $core_admin_values['google_region']; ?>" style="width:100%">
                       
                </div>
             
            </div>
            <!------------ END FIELD -------------->
            
        
            
            <!------------ FIELD -------------->          
            <div class="row-fluid" style="padding-bottom: 5px; border-bottom: 1px dotted #dfdfdf; padding-top:5px;">
                <label class="control-label span4 offset3">Language Code <br /><small>list found <a href="https://spreadsheets.google.com/pub?key=p9pdwsai2hDMsLkXsoM05KQ&gid=1" target="_blank">here</a></small></label>
                <div class="controls span4">         
                
                  <input type="text"  name="admin_values[google_lang]" value="<?php echo $core_admin_values['google_lang']; ?>" style="width:100%">
                       
                </div>
            </div>
            <!------------ END FIELD -------------->
         
             
            
            <?php 
			
			if($core_admin_values['google_coords'] == ""){ $core_admin_values['google_coords'] = "0,0"; } 
			if($core_admin_values['google_zoom'] == ""){ $core_admin_values['google_zoom'] = 8; }
			?>
            
            <!------------ FIELD -------------->          
            <div class="row-fluid" style="padding-bottom: 5px; border-bottom: 1px dotted #dfdfdf; padding-top:5px;">
                <label class="control-label span4 offset3">Map Zoom <br /><small>value between 0 - 20</small> </label>
                <div class="controls span4">         
                 <div class="input-prepend">
                  <span class="add-on">#</span>
                  <input type="text"  name="admin_values[google_zoom]" value="<?php echo $core_admin_values['google_zoom']; ?>" style="width:60px;">
                </div>        
                </div>
            </div>
            <!------------ END FIELD -------------->
            
        
            
            <!------------ FIELD -------------->          
            <div class="row-fluid" style="padding-bottom: 5px; border-bottom: 1px dotted #dfdfdf; padding-top:5px;">
                <label class="control-label span4 offset3">Map Cords <br /><small>numeric values only</small></label>
                <div class="controls span3">         
                 <div class="input-prepend">
                  <span class="add-on">lat,long</span>
                  <input type="text"  name="admin_values[google_coords]" value="<?php echo $core_admin_values['google_coords']; ?>" style="width:250px; text-align:right">
                </div>        
                </div>
            </div>
            <!------------ END FIELD -------------->
            
           
            
              <div class="heading1"> Search Results Page</div>     
    
        
           <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="This will display the map view at the top of results where listings have mappable locations." data-placement="top">Show Map Open</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('default_gallery_map').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('default_gallery_map').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['default_gallery_map'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="default_gallery_map" name="admin_values[default_gallery_map]" 
                             value="<?php echo $core_admin_values['default_gallery_map']; ?>">
            </div> 
           
     
            
            <?php 
			
			if($core_admin_values['google_coords1'] == ""){ $core_admin_values['google_coords1'] = "0,0"; } 
			if($core_admin_values['google_zoom1'] == ""){ $core_admin_values['google_zoom1'] = 8; }
			?>
            
            <!------------ FIELD -------------->          
            <div class="row-fluid">
                <label class="control-label span4 offset3">Map Zoom (0-20)</label>
                <div class="controls span4">         
                 <div class="input-prepend">
                  <span class="add-on">#</span>
                  <input type="text"  name="admin_values[google_zoom1]" value="<?php echo $core_admin_values['google_zoom1']; ?>" style="width:60px;">
                </div>        
                </div>
            </div>
            <!------------ END FIELD -------------->
      
            
            <!------------ FIELD -------------->          
            <div class="row-fluid">
                <label class="control-label span4 offset3">Map Cords <br /><small>numeric values only</small></label>
                <div class="controls span3">         
                 <div class="input-prepend">
                  <span class="add-on">lat,long</span>
                  <input type="text"  name="admin_values[google_coords1]" value="<?php echo $core_admin_values['google_coords1']; ?>" style="width:250px; text-align:right">
                </div>        
                </div>
            </div>
            <!------------ END FIELD -------------->
     
            
            
            <div class="well">
            <b>Finding Map Cords</b>
            <p>To get your own long/lat values, view the link below to Google maps. Right-click on the desired spot on the map and, from the menu, choose "What's here?". Click on the green marker to get the lat/long coordinates/</p>
            <p><a href="https://maps.google.com/maps?f=q&hl=en&q=&ie=UTF8&ll=34.019968,-118.289988&spn=0.001205,0.001714&t=k&z=1" target="_blank" style="text-decoration:underline;color:blue;">https://maps.google.com/</a>

            </div> 
            
            
            
            
                   
             
</div>
  
<div class="tab-pane fade in" id="set11">
             <div class="heading1">Feedback Settings</div>
             
             <div class="well">
             
             
             <p>The feedback system allows members to leave feedback about other members listings.</p>
             
             <p>Members can leave 1 feedback per listing and the listing author can delete the feedback at any time.</p>
             
             <p>Feedback is displayed on the users profile page.</p>
             
             </div>
             
             
               <div class="form-row control-group row-fluid ">
                                <label class="control-label span7" data-placement="top">Enable Feedback System</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('feedback_enable').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('feedback_enable').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['feedback_enable'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="feedback_enable" name="admin_values[feedback_enable]" 
                                 value="<?php echo $core_admin_values['feedback_enable']; ?>">
         </div>
         
         
        
               <div class="form-row control-group row-fluid ">
                                <label class="control-label span7" data-placement="top">Show Trust Bar</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('feedback_trustbar').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('feedback_trustbar').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['feedback_trustbar'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="feedback_trustbar" name="admin_values[feedback_trustbar]" 
                                 value="<?php echo $core_admin_values['feedback_trustbar']; ?>">
         </div>


</div>
  
     
<div class="tab-pane fade in" id="set10">
             <div class="heading1">Breadcrumbs</div>
             
             
           <div class="form-row control-group row-fluid">
        <label class="control-label span5" for="style">Breadcrumbs Display</label>
        <div class="controls span6">
        <select name="admin_values[breadcrumbs_inner]" class="chzn-select" id="bdc">

          <option value="0" <?php if($core_admin_values['breadcrumbs_inner'] == "0"){ echo "selected=selected"; } ?>>Disable</option>
          <option value="1" <?php if($core_admin_values['breadcrumbs_inner'] == "1"){ echo "selected=selected"; } ?>>Under Header</option> 
          <option value="2" <?php if($core_admin_values['breadcrumbs_inner'] == "2"){ echo "selected=selected"; } ?>>Above Search Results</option> 
         
         
        </select>
        </div>
        </div> 
        
      
        
              <div class="form-row control-group row-fluid ">
                                <label class="control-label span7" data-placement="top">Show Breadcrumbs on Home Page?</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('breadcrumbs_home').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('breadcrumbs_home').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['breadcrumbs_home'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="breadcrumbs_home" name="admin_values[breadcrumbs_home]" 
                                 value="<?php echo $core_admin_values['breadcrumbs_home']; ?>">
         </div>
         
         <?php if(!defined('WLT_CART')){ ?>
           <div class="form-row control-group row-fluid ">
                                <label class="control-label span7" data-placement="top">Show Add Listing Button</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('breadcrumbs_addlisting').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('breadcrumbs_addlisting').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['breadcrumbs_addlisting'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="breadcrumbs_addlisting" name="admin_values[breadcrumbs_addlisting]" 
                                 value="<?php echo $core_admin_values['breadcrumbs_addlisting']; ?>">
         </div>
         <?php } ?>
         
         <div class="form-row control-group row-fluid ">
                                <label class="control-label span7" data-placement="top">Show Social Buttons</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('breadcrumbs_social').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('breadcrumbs_social').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['breadcrumbs_social'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="breadcrumbs_social" name="admin_values[breadcrumbs_social]" 
                                 value="<?php echo $core_admin_values['breadcrumbs_social']; ?>">
         </div>
         
          <div class="form-row control-group row-fluid ">
                                <label class="control-label span7" data-placement="top">Show Login/Register/Account Links</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('breadcrumbs_userlinks').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('breadcrumbs_userlinks').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['breadcrumbs_userlinks'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="breadcrumbs_userlinks" name="admin_values[breadcrumbs_userlinks]" 
                                 value="<?php echo $core_admin_values['breadcrumbs_userlinks']; ?>">
         </div>        
         
         
</div>


<div class="tab-pane fade in" id="set9a">


 <div class="heading1">Listing Page Settings</div> 
   
         
  
               <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="Turn ON to display a claim listing button on all admin created listings." data-placement="top">Allow Claim Listings</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('visitor_claimme').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('visitor_claimme').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['visitor_claimme'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="visitor_claimme" name="admin_values[visitor_claimme]" 
                             value="<?php echo $core_admin_values['visitor_claimme']; ?>">
            </div>
         
       
            <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="This will stop the theme from performing any expiry functions." data-placement="top">Disable Expired Actions <span class="label label-important">(warning)</span></label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('stop_expired').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('stop_expired').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['stop_expired'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="stop_expired" name="admin_values[stop_expired]" 
                             value="<?php echo $core_admin_values['stop_expired']; ?>">
            </div>
            
            
       
         <div class="form-row control-group row-fluid">
        <label class="control-label span4 offset3" for="style" rel="tooltip" data-original-title="This refers to the number of related items to display on the listing page if your using the related shortcode." data-placement="top">Related Items</label>       
        <div class="controls span3 input-append">        
        <input type="text"  name="admin_values[related_perpage]" class="row-fluid"  style="width:50px;" value="<?php echo $core_admin_values['related_perpage']; ?>">
        <span class="add-on">items per page</span>        
        </div>
        </div> 
        
        
                <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="Enable this to force visitors to login to view the listing page." data-placement="top">Require Login To View</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('requirelogin').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('requirelogin').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['requirelogin'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="requirelogin" name="admin_values[requirelogin]" 
                             value="<?php echo $core_admin_values['requirelogin']; ?>">
            </div>


</div>

   
<div class="tab-pane fade in" id="set9">

  <div class="heading1">
    
     <a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('kZPr-0Nd3W8','videoboxplayer','479','350');" style="float:right;margin-top:-5px;">Watch Video</a>
    
    Search Results Settings
    
    </div> 
	
   
        <div class="form-row control-group row-fluid">
        <label class="control-label span4 offset3" for="style">Display</label>       
        <div class="controls span3 input-append">        
        <input type="text"  name="adminArray[posts_per_page]" class="row-fluid"  style="width:50px;" value="<?php echo get_option('posts_per_page'); ?>">
        <span class="add-on">items per page</span>        
        </div>
        </div> 
        
        <div class="form-row control-group row-fluid">
        <label class="control-label span4 offset3" for="style">Display Order</label>
        <div class="controls span5">
        <select name="admin_values[display][orderby]" class="chzn-select" id="default_orderby">
        <option value=""></option>     
        <option value="system" <?php if($core_admin_values['display']['orderby'] == "system"){ echo "selected=selected"; } ?>>System Set (no default order)</option>
        <option value="post_date*desc" <?php if($core_admin_values['display']['orderby'] == "post_date*desc"){ echo "selected=selected"; } ?>>Date (Newest First)</option>
        <option value="post_date*asc" <?php if($core_admin_values['display']['orderby'] == "post_date*asc"){ echo "selected=selected"; } ?>>Date (Newest Last)</option>
        <option value="post_author*asc" <?php if($core_admin_values['display']['orderby'] == "post_author*asc"){ echo "selected=selected"; } ?>>Author (A-z) </option>
        <option value="post_author*desc" <?php if($core_admin_values['display']['orderby'] == "post_author*desc"){ echo "selected=selected"; } ?>>Author (Z-a)</option>
        <option value="post_title*asc" <?php if($core_admin_values['display']['orderby'] == "post_title*asc"){ echo "selected=selected"; } ?>>Product Title (A-z)</option>
        <option value="post_title*desc" <?php if($core_admin_values['display']['orderby'] == "post_title*desc"){ echo "selected=selected"; } ?>>Product Title (Z-a)</option>
        <option value="post_modified*asc" <?php if($core_admin_values['display']['orderby'] == "post_modified*asc"){ echo "selected=selected"; } ?>>Date Modified (Newest Last)</option>
        <option value="post_modified*desc" <?php if($core_admin_values['display']['orderby'] == "post_modified*desc"){ echo "selected=selected"; } ?>>Date Modified (Newest First)</option>
        <option value="ID*asc" <?php if($core_admin_values['display']['orderby'] == "ID*asc"){ echo "selected=selected"; } ?>>Wordpress POST ID (0 - 1)</option>
        <option value="ID*desc" <?php if($core_admin_values['display']['orderby'] == "ID*desc"){ echo "selected=selected"; } ?>>Wordpress POST ID (1 - 0)</option>
        
        <option>------------------</option>
         <option value="meta&featured*desc" <?php if($core_admin_values['display']['orderby'] == "meta&featured*desc"){ echo "selected=selected"; } ?>>Featured Listings (top)</option>
        <option value="meta&featured*asc" <?php if($core_admin_values['display']['orderby'] == "meta&featured*asc"){ echo "selected=selected"; } ?>>Featured Listings (bottom)</option>
 
        
        
        <?php if(defined('WLT_IDEAS')){ ?>
        <option value="meta&votes*desc" <?php if($core_admin_values['display']['orderby'] == "meta&votes*desc"){ echo "selected=selected"; } ?>>Votes(hig - low)</option>
        <option value="meta&votes*asc" <?php if($core_admin_values['display']['orderby'] == "meta&votes*asc"){ echo "selected=selected"; } ?>>Votes (low - hig)</option>
        <?php }elseif(defined('WLT_AUCTION')){	?>
          <option value="meta&price_current*desc" <?php if($core_admin_values['display']['orderby'] == "meta&price_current*desc"){ echo "selected=selected"; } ?>>Price (hig - low)</option>
        <option value="meta&price_current*asc" <?php if($core_admin_values['display']['orderby'] == "meta&price_current*asc"){ echo "selected=selected"; } ?>>Price (low - hig)</option>
        <?php }else{ ?>
        <option value="meta&price*desc" <?php if($core_admin_values['display']['orderby'] == "meta&price*desc"){ echo "selected=selected"; } ?>>Price (hig - low)</option>
        <option value="meta&price*asc" <?php if($core_admin_values['display']['orderby'] == "meta&price*asc"){ echo "selected=selected"; } ?>>Price (low - hig)</option>
        <?php } ?>
          </select>
        </div>
        </div>
        
        
             <script type="application/javascript">
			jQuery(document).ready(function(){
				jQuery('#default_orderby').on('change', function(e){
				
					var oval = jQuery('#default_orderby').val();
					if(oval == "meta&featured*desc" || oval == "meta&featured*asc"){
					alert("Notice: Setting the order by value to 'Featured' will exclude ALL listings which do not have a 'featured' custom field set. If your search results are missing listings this will be why.");
					}
					if(oval == "meta&price*desc" || oval == "meta&price*asc"){
					alert("Notice: Setting the order by value to 'Price' will exclude ALL listings which do not have a 'price' custom field set. If your search results are missing listings this will be why.");
					}
					
				});
				 
				
			});
			</script>
    
        <div class="form-row control-group row-fluid">
        <label class="control-label span4 offset3" for="style">Default Display View</label>
        <div class="controls span5">
        <select name="admin_values[display][default_gallery_style]" class="chzn-select" id="default_gallery_style">
          <option value=""></option>
          <option value="grid" <?php if($core_admin_values['display']['default_gallery_style'] == "grid"){ echo "selected=selected"; } ?>>Grid</option>
          <option value="list" <?php if($core_admin_values['display']['default_gallery_style'] == "list"){ echo "selected=selected"; } ?>>List</option> 
     
          <option value="listonly" <?php if($core_admin_values['display']['default_gallery_style'] == "listonly"){ echo "selected=selected"; } ?>>List Only (hide others)</option>
        </select>
        </div>
        </div>  
   
        
         <div class="form-row control-group row-fluid">
        <label class="control-label span4 offset3" for="style">Items Per Row</label>
        <div class="controls span5">
        <select name="admin_values[default_gallery_perrow]" class="chzn-select" id="default_gallery_perrow">
          <option value=""></option>
          <option value="2" <?php selected( $core_admin_values['default_gallery_perrow'], "2" );  ?>>2 Items</option>
           <option value="3" <?php selected( $core_admin_values['default_gallery_perrow'], "3" );  ?>>3 Items</option>
          <option value="4" <?php selected( $core_admin_values['default_gallery_perrow'], "4" );  ?>>4 Items</option>
          
        </select>
        </div>
        </div>
        
          <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="Turn on/off the inner search bar on your search results page." data-placement="top">Show Search Bar <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/new.png"></label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('search_searchbar').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('search_searchbar').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['search_searchbar'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="search_searchbar" name="admin_values[search_searchbar]" value="<?php echo $core_admin_values['search_searchbar']; ?>">
            </div>


           <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="Turn on if you want the category/taxonomy description to be displayed at the top of the search results page." data-placement="top">Category Description</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('category_descrition').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('category_descrition').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['category_descrition'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="category_descrition" name="admin_values[category_descrition]" 
                             value="<?php echo $core_admin_values['category_descrition']; ?>">
            </div>
            
           <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="Turn on if you want to display sub categories on at the top of category pages." data-placement="top">Sub Categories</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('subcategories').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('subcategories').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['subcategories'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="subcategories" name="admin_values[subcategories]" 
                             value="<?php echo $core_admin_values['subcategories']; ?>">
            </div> 
            
            
            
       
            
            
                    <?php if(!defined('WLT_CART')){ ?>
            
              <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="This will hide all listings with a blank or invalid listing expiry date." data-placement="top">Hide Expired <span class="label label-important">(warning)</span></label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('hide_expired').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('hide_expired').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['hide_expired'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="hide_expired" name="admin_values[hide_expired]" 
                             value="<?php echo $core_admin_values['hide_expired']; ?>">
            </div>   
    <?php } ?>       
 
  
</div>
     
<div class="tab-pane fade in" id="set8">
    
<div class="heading1">Footer Social Networking Links</div>   
<p>You can change the icon and use alternative social networks by using a different icon. Icons can be found here; </p>
<p><a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank" style="color:blue; text-decoration:underline;">http://fortawesome.github.io/Font-Awesome/icons/</a></p> 
<hr />
 <div class="row-fluid">
 <?php $type = array(
 "twitter" => array("n" => "Twitter", "icon" => "fa-twitter"),
 "dribbble" => array("n" => "Google", "icon" => "fa-google-plus"),
 "facebook" => array("n" => "Facebook", "icon" => "fa-facebook"),
 "linkedin" => array("n" => "Linked-in", "icon" => "fa-linkedin"),
 "youtube" => array("n" => "Youtube", "icon" => "fa-youtube"),
 "rss" => array("n" => "RSS Feed", "icon" => "fa-rss"), 
  ); 
 
foreach($type as $k1=>$v1){ ?>
 <div class="span6" style="margin-left:0px;">
   <!------------ FIELD -------------->          
<div class="form-row control-group row-fluid" id="myaccount_page_select">
	<label class="control-label span4" for="normal-field"><?php echo $v1['n']; ?></label>
    <div class="controls span6">         
     <div class="input-prepend">
      <span class="add-on">#</span>
      <input type="text"  name="admin_values[social][<?php echo $k1; ?>]" value="<?php echo $core_admin_values['social'][$k1]; ?>" class="span11">
    </div>  
    <input type="text"  name="admin_values[social][<?php echo $k1; ?>_icon]" value="<?php if($core_admin_values['social'][$k1.'_icon'] == ""){ 
	echo $v1['icon'];
	}else{ echo $core_admin_values['social'][$k1.'_icon']; } ?>" class="span11" style="height:25px;">      
    </div>
</div>
<!------------ END FIELD -------------->
</div>
<?php } ?> 
</div>

<div class="heading1">Footer Copyright Text</div> 
<!------------ FIELD -------------->          
<div class="form-row control-group row-fluid">
	<label class="control-label">Copyright Text</label>   
    <div class="controls">    
    <textarea class="row-fluid" style="height:100px; font-size:11px;" name="admin_values[copyright]"><?php echo stripslashes($core_admin_values['copyright']); ?></textarea>    	 
    </div>
</div> 
    
    
    
    
   <div class="heading1">Website Analytics</div>   
        <div class="well" style="font-size:12px;padding:10px;">Google analytics is a free web analytics tool from Google that allows you to track your website visitors and statistics.
         <a href="http://www.google.com/analytics/" target="_blank" style="text-decoration:underline;">Signup free here.</a></div>
 
			<div class="form-row row-fluid span11 ">
                            <label class="control-label span7" rel="tooltip" data-original-title="This will allow Google analytics to track your website visitor click history to see which listings are most popular. This is strongly recommended for all website owners." data-placement="top">Google Event Tracking</label>
                            <div class="controls span5">
                              <div class="row-fluid">                              
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('google_tracking').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('google_tracking').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['google_tracking'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                            
                             
                             <input type="hidden" class="row-fluid" id="google_tracking" name="admin_values[google_tracking]" 
                             value="<?php echo $core_admin_values['google_tracking']; ?>">
            </div>
            
<!-- end WEBSITE SCREENSHOT PREVIEWER -->
  
    
    <textarea class="row-fluid" style="height:100px; font-size:11px;" placeholder="Analytics Code Here" name="adminArray[google_analytics]"><?php echo stripslashes(get_option('google_analytics')); ?></textarea>
    
    
    
    <div class="heading1">Conversion Tracking Code</div> 
    <p>The code you enter here will be displayed on your callback page for successful orders.</p>
    
    <p>Shortcodes: [total] [orderid] [description] </p>  
      
    <textarea class="row-fluid" style="height:100px; font-size:11px;" placeholder="Analytics Code Here" name="adminArray[google_conversion]"><?php echo stripslashes(get_option('google_conversion')); ?></textarea>
    
    <?php /*
    <div class="heading1">PremiumPress Powered By Link</div> 
    <p>This will display a link back to PremiumPress in your footer. </p>
    
    
    <div class="form-row row-fluid span11 ">
                            <label class="control-label span7" rel="tooltip" data-original-title="Enable this to disable the powered by text." data-placement="top">Disable Feature</label>
                            <div class="controls span5">
                              <div class="row-fluid">                              
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('poweredby').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('poweredby').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['poweredby'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                            
                             
                             <input type="hidden" class="row-fluid" id="poweredby" name="admin_values[poweredby]" 
                             value="<?php echo $core_admin_values['poweredby']; ?>">
            </div>
    
    
    */ ?>
    </div>     
     
     
    <div class="tab-pane fade in" id="set7">
     
    <div class="heading1">
      <a href="admin.php?page=1&delrating=1" class="btn btn-info" style="float:right;margin-top:-4px;">Delete All Rating Data</a>
    
    Star Rating Settings</div>
    
    
 
                  <div class="form-row control-group row-fluid ">
                            <label class="control-label span6" rel="tooltip" data-original-title="Turn on/off if you want the star rating to appear on your website." data-placement="top">Enable Star Rating</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('rating').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('rating').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['rating'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="rating" name="admin_values[rating]" 
                             value="<?php echo $core_admin_values['rating']; ?>">
            </div> 
            
            
            
               <div class="form-row control-group row-fluid ">
                            <label class="control-label span6"  data-placement="top">Show In Advanced Search</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('rating_as').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('rating_as').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['rating_as'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="rating_as" name="admin_values[rating_as]" 
                             value="<?php echo $core_admin_values['rating_as']; ?>">
            </div> 
            
            
        <div class="form-row control-group row-fluid">
        <label class="control-label span5" for="style">Rating Display Type</label>
        <div class="controls span6">
        <select name="admin_values[rating_type]" class="chzn-select" id="rt1">
          <option value=""></option>
          <option value="1" <?php if($core_admin_values['rating_type'] == "1"){ echo "selected=selected"; } ?>>Stars</option>
          <option value="2" <?php if($core_admin_values['rating_type'] == "2"){ echo "selected=selected"; } ?>>Thumbs Basic (Horizontal)</option> 
          <option value="4" <?php if($core_admin_values['rating_type'] == "4"){ echo "selected=selected"; } ?>>Thumbs Basic (Vertical)</option> 
          <option value="5" <?php if($core_admin_values['rating_type'] == "5"){ echo "selected=selected"; } ?>>Thumbs Icon (Vertical)</option> 
         <option value="6" <?php if($core_admin_values['rating_type'] == "6"){ echo "selected=selected"; } ?>>Thumbs Icon (Horizontal)</option> 
         
          
      <option value="3" <?php if($core_admin_values['rating_type'] == "3"){ echo "selected=selected"; } ?>>Vote Up/ Vote Down</option>
      <option value="3a" <?php if($core_admin_values['rating_type'] == "3a"){ echo "selected=selected"; } ?>>Vote Up/ Vote Down with icon</option> 
      <option value="7" <?php if($core_admin_values['rating_type'] == "7"){ echo "selected=selected"; } ?>>Text Only</option> 
      <option value="8" <?php if($core_admin_values['rating_type'] == "8"){ echo "selected=selected"; } ?>>Success Meter (big)</option> 
      <option value="9" <?php if($core_admin_values['rating_type'] == "9"){ echo "selected=selected"; } ?>>Success Meter (small)</option> 
        </select>
        </div>
        </div> 
        
              
     
    </div>
     
    <div class="tab-pane fade in active" id="set1">
    
    <?php do_action('hook_admin_1_tab1_subtab1'); ?>
    
    
    <!--------------------- END WEBSITE LOGO ------------------------->             
 		<?php
		$selected_template = $core_admin_values['template']; 
		$HandlePath = TEMPLATEPATH . '/templates/';
	    $count=1; $TemplateString = "";
		if($handle1 = opendir($HandlePath)) {      
			while(false !== ($file = readdir($handle1))){			
				if(strpos($file,".") ===false && ( strpos($file,strtolower('template')) !== false  ) ){	
			 					
					$TemplateString .= "<option "; 
					if ($selected_template == $file) { $TemplateString .= ' selected="selected"'; }   
					$TemplateString .= 'value="'.$file.'">'; 					
					$TemplateString .= str_replace("basic","[CHILD]",str_replace("_"," ",str_replace("-"," ",str_replace(strtolower('template'),"",$file)))); 										
					$TemplateString.= "</option>";			
   
				}
			}
			
		}
if(strlen($TemplateString) > 2){ 	
?>          
<!-- WEBSITE SCREENSHOT // PREVIEW -->          
<script type="text/javascript">
jQuery(document).ready(function() { 
   jQuery("#themepreview").change(function() {
     jQuery("#imagePreview").empty();
	 if(jQuery("#themepreview").val() != ""){
	 jQuery('#previewbox').show();
        jQuery("#imagePreview").append("<img src=\"<?php echo get_template_directory_uri(); ?>/templates/" + jQuery("#themepreview").val()  + "/screenshot.png\" />");	
	} else {
		jQuery('#previewbox').hide();
	}
   });   
 }); 
</script>   

<div class="row-fluid">
    <div class="span6">
   
   <div style=" padding-bottom: 12px;border-bottom: 1px dotted #dfdfdf; margin-bottom:10px;">
   <h3 style="margin-top: 0px; margin-bottom:0px;">Quick Help Links</h3>
   <small>Useful links to our support website.</small>
   </div>
     
   <style>
   
   .nalist li { padding:10px; border:1px solid #ddd; background:#efefef; font-size:20px; margin-bottom:10px; }
    .nalist li i { float:right }
   .nalist li a { color:#e52424; text-shadow:1px 1px 1px #fff; }
   </style>
   
   <ul class="nalist">
   <li><a href="http://www.premiumpress.com/videos/" target="_blank"><i class="gicon-search"></i> Video Tutorials</a>   </li>
   <li><a href="http://www.premiumpress.com/docs/" target="_blank"><i class="gicon-search"></i> Documentation</a>  </li>
   <li><a href="http://www.premiumpress.com/forums/" target="_blank"><i class="gicon-search"></i> Community Forum</a></li>
   <li><a href="http://www.premiumpress.com/submit/" target="_blank"><i class="gicon-search"></i> Technical Support</a> </li>
   </ul>
   
   <?php if(!defined('WLT_DEMOMODE')){ ?>
   <div style="text-align:right"><p>License Key: <?php echo get_option('wlt_license_key'); ?></p></div>
   <?php } ?>
   
   
    </div>
    <div class="span6">
   
        <div class="form-row control-group row-fluid">
        <label  for="default-select">Current Theme</label>
    
         
        <select name="admin_values[template]" class="chzn-select" id="themepreview">
        <option value="">None</option>
        <?php echo $TemplateString; ?>
        </select>
        <input type="hidden" name="current_template_save" value="<?php echo $selected_template; ?>" />
         
        </div>
        
         
        <div class="span12 well  pagination-centered" id="previewbox" style="margin:0px;width:100%">
            
            <div id="imagePreview"><?php if($core_admin_values['template'] != ""){ ?><img src="<?php echo get_template_directory_uri(); ?>/templates/<?php echo $core_admin_values['template']; ?>/screenshot.png" /><?php } ?></div>
        
        </div>
   
   
    </div>
</div>
      

 
<div class="clearfix"></div>  
<?php    } ?> 

<hr />
 
    
     
    
    
     <div class="heading1">Website Logo</div> 
                <div class="form-row control-group row-fluid">
                     <label class="control-label span4">Image  or Text </label>
                     
                     <div class="controls span7"> 
                     <div class="input-append color row-fluid">
                     <input name="admin_values[logo_url]" id="logo" type="text" value="<?php echo stripslashes($core_admin_values['logo_url']); ?>" class="row-fluid">
                     <span class="add-on" style="margin-right: -30px;" id="upload_logo"><i class="gicon-search"></i></span>                  
                     </div>
                     <p style="font-size:11px;">Enter text for non-graphic logos or click the zoom icon to upload your own.</p>   
                     </div>
                </div>
                
                <?php 	if(strpos($core_admin_values['logo_url'], "http") !== false){ ?>
                
                 <div style="text-align:center; border:1px solid #ddd; padding:20px; margin-left:100px;margin-bottom:30px;margin-right:100px;">
                <?php if(strlen($core_admin_values['logo_url']) > 10){ echo '<img src="'.$core_admin_values['logo_url'].'" style="max-width:250px; max-height:250px;" /> '; }else{ echo "<h1>".$core_admin_values['logo_url']."</h1>";  }?>
                </div> 
                
                <?php } ?>
                
                
                
    
<input type="hidden" value="" name="imgIdblock" id="imgIdblock" />

<script type="text/javascript">

function ChangeImgBlock(divname){
	document.getElementById("imgIdblock").value = divname;
}

jQuery('#upload_logo').click(function() {
 ChangeImgBlock('logo');
 formfield = jQuery('#logo').attr('name');
 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
 return false;
}); 



jQuery(document).ready(function() {
 
	window.send_to_editor = function(html) {

	 imgurl = jQuery('img',html).attr('src');
	 
	 jQuery('#'+document.getElementById("imgIdblock").value).val(imgurl);
	 tb_remove();
	}
});
 
</script>    


    

    
  

     <div class="heading1">Image Display Settings</div> 

        <div class="form-row control-group row-fluid">
                <label class="control-label span4" rel="tooltip" data-original-title="This image is used when no image has been assined to a listing." data-placement="top">'No Image' Icon</label>
                <div class="controls span7">
                <div class="input-append row-fluid">
                  <input type="text"  name="admin_values[fallback_image]" id="upload_pak" class="row-fluid" 
                  value="<?php echo $core_admin_values['fallback_image']; ?>">
                  <span class="add-on" id="upload_pakimage" style="cursor:pointer;"><i class="gicon-search"></i></span>
                  </div>
                </div>
       </div> 
       
       
       <div style="text-align:center; border:1px solid #ddd; padding:20px; margin-left:100px;margin-bottom:30px;margin-right:100px;">
                <?php if(strlen($core_admin_values['fallback_image']) > 10){ echo '<img src="'.$core_admin_values['fallback_image'].'" style="max-width:250px; max-height:250px;" /> '; }else{ echo "<h1>".$core_admin_values['fallback_image']."</h1>";  }?>
                </div> 
        
    
			<script type="text/javascript">
            
                jQuery(document).ready(function () {
                    jQuery('#upload_pakimage').click(function() { 
                     
                     ChangeImgBlock('upload_pak');
                     formfield = jQuery('#upload_pak').attr('name');
                     tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
                     return false;
                    });
					
					window.send_to_editor = function(html) {
 imgurl = jQuery('img',html).attr('src'); 
 jQuery('#'+document.getElementById("imgIdblock").value).val(imgurl);
 tb_remove();
} 

                });	
				
            </script>  
 
    
     <?php do_action('hook_admin_1_tab1_subtab1_bottom'); ?> 
     
    </div>
    <div class="tab-pane fade in" id="set2"> 
    
	 <?php if( $GLOBALS['CORE_THEME']['template'] != ""){ ?>
     	
         
     		<div class="heading1">
            <a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('ff0sStPqJVs','videoboxplayer','479','350');" style="float:right;margin-top:-5px;">Watch Video</a>
            
            Page &amp; Button Links</div>
        
             <div class="well" style="font-size:12px;padding:10px;">
              <p>The theme has a number of <a href="http://codex.wordpress.org/Pages" target="_blank" style="text-decoration:underline;">page templates</a> such as the 'account area' and 'add listing' pages which need to created first before button links will work.</p>
               First <a href="edit.php?post_type=page" style="text-decoration:underline;">create a new page</a> for each of the fields below, assign the correct page template then select the link to the newly created page below. 
             </div>
      		
            <?php
	
			
			$default_page_links = array(
			"myaccount" => array("name" => "My Account"),
			"callback" => array("name" => "Callback"),
			"add" => array("name" => "Add Listing"),
			"contact" => array("name" => "Contact Form"),
			"blog" => array("name" => "Blog"),
			);
			$default_page_links = hook_admin_1_tab1_subtab2_pagelist($default_page_links);
			
			$pages = get_pages();  foreach($default_page_links as $k=>$v){ ?>         
            <!------------ FIELD -------------->          
            <div class="form-row control-group row-fluid" id="myaccount_page_select">
            <label class="control-label span4" for="normal-field">        
            <?php if(!isset($core_admin_values['links'][$k]) || $core_admin_values['links'][$k] == ""){ ?><img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/no.png"><?php } ?> 
            <?php echo $v['name']; ?> = </label>
            <div class="controls span8">             
            <select data-placeholder="Choose a page..." class="chzn-select" name="admin_values[links][<?php echo $k; ?>]">
            <option></option>
            <?php foreach ( $pages as $page ) {      
            $link = get_page_link( $page->ID );
			
			if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") { 
			$link = str_replace("http://","https://",$link);
			}
            $option = '<option value="'. $link.'"';
            if(isset($core_admin_values['links']) && $core_admin_values['links'][$k] == $link){ $option .= " selected=selected "; } 
            $option .= '>';
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
            } ?>
          </select></div></div>
          <!------------ END FIELD -------------->  
        <?php } // end foreach 
		
		} // end if is template ?>
     
    
    <?php do_action('hook_admin_1_tab1_subtab2'); ?> 
    
    </div>  
    <div class="tab-pane fade in" id="set3">
    
    <?php do_action('hook_admin_1_tab1_subtab3'); ?> 
    
    <div class="heading1">Responsive Design Mobile Settings</div>
    
      <div class="form-row control-group row-fluid ">
                                <label class="control-label span4 offset3" data-placement="top">Search Box</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('mobile_search').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('mobile_search').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['mobileview']['search'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="mobile_search" name="admin_values[mobileview][search]" 
                                 value="<?php echo $core_admin_values['mobileview']['search']; ?>">
         </div>
         
      <div class="form-row control-group row-fluid ">
                                <label class="control-label span4 offset3" data-placement="top">Use Advanced Search</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('mobile_adsearch').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('mobile_adsearch').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['mobileview']['adsearch'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="mobile_adsearch" name="admin_values[mobileview][adsearch]" 
                                 value="<?php echo $core_admin_values['mobileview']['adsearch']; ?>">
         </div>
         
       
    
         <div class="form-row control-group row-fluid ">
                                <label class="control-label span4 offset3" data-placement="top">Show Sidebars (if available)</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('sidebars').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('sidebars').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['mobileview']['sidebars'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="sidebars" name="admin_values[mobileview][sidebars]" 
                                 value="<?php echo $core_admin_values['mobileview']['sidebars']; ?>">
        
                
    </div> 
    
    
    
    
      <div class="heading1">Mobile Website (beta)</div>
      
      
      <div>
      
      <img src="<?php echo get_template_directory_uri(); ?>/framework/img/mobile/screen.png" style="float:left; padding-right:50px;" />
      
      
      <h3>Mobile Website Design</h3>
      
      <p>This new feature will display a completely different layout and design optimized for mobile users to provide a better viewing experience.</p>
      
      <p>The mobile website design has been optimized for mobile browsers with faster page loading, easy access options and a simplified user interface. </p>
      
      <p>Although this design has limited features due to mobile browser limitations it offers a unique, user friendly experience for your visitors.</p>
      
      </div>
      
      <div class="clearfix"></div>
      
   
     <div class="form-row control-group row-fluid " style="padding-bottom: 5px; border-top: 1px dotted #dfdfdf; padding-top:15px;">
                                <label class="control-label span4 offset3" data-placement="top">Enable Mobile Website</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('mobileweb').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('mobileweb').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['mobileweb'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="mobileweb" name="admin_values[mobileweb]" 
                                 value="<?php echo $core_admin_values['mobileweb']; ?>">
        
    </div>  
    
    
 <div class="form-row control-group row-fluid">
                <label class="control-label span4 offset3"  >Home Setup</label>
                <div class="controls span3">
                 <select name="admin_values[mobileweb_homesetup]" class="chzn-select" id="mobileweb_homesetup">
                    <option <?php selected( $core_admin_values['mobileweb_homesetup'], "0" );  ?> value="0">Welcome List</option>
                     <option <?php selected( $core_admin_values['mobileweb_homesetup'], "1" );  ?> value="1">Recent Listings</option>
                    <option <?php selected( $core_admin_values['mobileweb_homesetup'], "2" );  ?> value="2">Website Categories</option>
                    <?php hook_admin_1_tab1_mobile_homelist(); ?>
                  </select>
                              
                </div>
                
</div>
    
    
 
    
<div class="form-row control-group row-fluid">
                <label class="control-label span4 offset3"  >Color Scheme</label>
                <div class="controls span3">
                  <select name="admin_values[mobileweb_color]" class="chzn-select" id="mobileweb_color">
                    <option value=""></option>
                    <option value="" <?php if($core_admin_values['mobileweb_color'] == ""){ echo "selected=selected"; } ?>>Default (Blue)</option>
                    <option value="red" <?php if($core_admin_values['mobileweb_color'] == "red"){ echo "selected=selected"; } ?>>Red</option>   
                     <option value="green" <?php if($core_admin_values['mobileweb_color'] == "green"){ echo "selected=selected"; } ?>>Green</option>   
                     <option value="orange" <?php if($core_admin_values['mobileweb_color'] == "orange"){ echo "selected=selected"; } ?>>Orange</option>   
                     <option value="purple" <?php if($core_admin_values['mobileweb_color'] == "purple"){ echo "selected=selected"; } ?>>Purple</option>                 
                  </select>
                </div>
                
</div>
    
    
          <!------------ FIELD -------------->    
                
            <div class="row-fluid" style="padding-bottom: 5px; border-bottom: 1px dotted #dfdfdf; padding-top:5px;">
          
                <label class="control-label span4 offset3">Mobile Logo (text only) <br /><small>use span tags to &lt;span&gt;highlight&lt;/span&gt;</small></label>
                <div class="controls span4"> 
                        
                 <textarea class="row-fluid" name="admin_values[mobileweb_logo]"><?php echo stripslashes($core_admin_values['mobileweb_logo']); ?></textarea>
         
                       
                </div>
             
            </div>
            <!------------ END FIELD -------------->  
    
             <div class="row-fluid" style="padding-bottom: 5px; border-bottom: 1px dotted #dfdfdf; padding-top:5px;">
          
                <label class="control-label span4 offset3">Subline Text <br /><small>home page display only</small> </label>
                <div class="controls span4"> 
                        
                 <textarea class="row-fluid" name="admin_values[mobileweb_subtxt]"><?php echo stripslashes($core_admin_values['mobileweb_subtxt']); ?></textarea>
         
                       
                </div>
             
            </div>
            <!------------ END FIELD -------------->     
    
    
    </div>
    
    
    <?php if(!defined('WLT_HIDE_ADMIN_5')){ ?> 
    <div class="tab-pane fade in" id="set4"> 
     
     <?php do_action('hook_admin_1_tab1_subtab4'); ?> 
     
     <div class="heading1">
     
     <a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('2QjP3kHUmwQ','videoboxplayer','479','350');" style="float:right;margin-top:-5px;">Watch Video</a>
     
     Add Listing Page Options</div>     
      
     
               <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="Turn OFF if you want all users to register before submitting listings otherwise the system will auto create a new account for the visitor based on their email address." data-placement="top">Allow Visitor Submissions</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('visitor_submit').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('visitor_submit').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['visitor_submission'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="visitor_submit" name="admin_values[visitor_submission]" 
                             value="<?php echo $core_admin_values['visitor_submission']; ?>">
            </div>
            
                           <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="Turn OFF if you do not want users to renew their listings." data-placement="top">Allow Listing Renewals</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('renewlisting').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('renewlisting').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['renewlisting'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="renewlisting" name="admin_values[renewlisting]" 
                             value="<?php echo $core_admin_values['renewlisting']; ?>">
            </div>
            
            
            
            
               <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="Turn ON to allow users to set a status for their listing after its been created." data-placement="top">Allow Listing Status</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('field_listingstatus').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('field_listingstatus').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['field_listingstatus'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="field_listingstatus" name="admin_values[field_listingstatus]" 
                             value="<?php echo $core_admin_values['field_listingstatus']; ?>">
            </div>
            
            
               <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="Turn ON to stop users from select the parent category as a listing option." data-placement="top">Disable Parent Category</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('disablecategory').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('disablecategory').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['disablecategory'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="disablecategory" name="admin_values[disablecategory]" 
                             value="<?php echo $core_admin_values['disablecategory']; ?>">
            </div>
            
            
<div class="form-row control-group row-fluid">
                <label class="control-label span4 offset3"  rel="tooltip" data-original-title="Here you can set the default status for free listings." data-placement="top">New Listing Status</label>
                <div class="controls span4">
                  <select name="admin_values[default_listing_status]" class="chzn-select" id="default_listing_status">
                    <option value=""></option>
                    <option value="publish" <?php if($core_admin_values['default_listing_status'] == "publish"){ echo "selected=selected"; } ?>>Active (Live)</option>
                    <option value="pending" <?php if($core_admin_values['default_listing_status'] == "pending"){ echo "selected=selected"; } ?>>Pending Admin Review</option>   
                                   
                  </select>
                </div>
                
                <div class="clearfix"></div>
                
                <p style="margin-left:160px;"><small><span class="label label-success" style="background:green;">Note</span> if the user pays for a listing, it will go live straight away.</small></p>  
            
                
</div> 
                
                        
                    
                    
  <div class="heading1">  Media Uploading </div>     
        
                    
                    
                    
        <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="Turn ON if you want to force the users to upload an image with their listing." data-placement="top">Require Image Upload</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('require_image').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('require_image').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['require_image'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="require_image" name="admin_values[require_image]" value="<?php echo $core_admin_values['require_image']; ?>">
            </div>    
            
            
                    
        <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="Turn ON to allow video uploads." data-placement="top">Allow Video Files</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('allow_video').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('allow_video').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['allow_video'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="allow_video" name="admin_values[allow_video]" value="<?php echo $core_admin_values['allow_video']; ?>">
            </div>                  
                    
        <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="Turn ON to allow doc uploads." data-placement="top">Allow Document Files</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('allow_docs').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('allow_docs').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['allow_docs'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="allow_docs" name="admin_values[allow_docs]" value="<?php echo $core_admin_values['allow_docs']; ?>">
            </div>                  
                     
                    
                    
        <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="Turn ON to allow audio uploads." data-placement="top">Allow Audio Files</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('allow_audio').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('allow_audio').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['allow_audio'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="allow_audio" name="admin_values[allow_audio]" value="<?php echo $core_admin_values['allow_audio']; ?>">
            </div>                  
                     
            
            
    <?php 
	$membershipfields 	= get_option("membershipfields");	
	if(is_array($membershipfields) && !empty($membershipfields)){ 
	
	$current_access = $core_admin_values['default_access'];
	if(!is_array($current_access)){ $current_access = array(99); }	
	?>
    
   <div style='font-weight:bold; padding:10px; border:1px solid #ddd; background:#F8F8F8; color:#666;'> Membership Access </div> 
   <p style="margin-top:10px;">Here you can set the default access for newly created listings added by <b>users</b>.</p>
   
   	<select name="admin_values[default_access][]" size="2" style="font-size:14px;padding:5px; width:100%; height:150px; background:#e7fff3;" multiple="multiple"  > 
  	<option value="99" <?php if(in_array(99,$current_access)){ echo "selected=selected"; } ?>>All Membership Access</option>
    <?php 
	$i=0;
	
	foreach($membershipfields as $mID=>$package){	
		
		if(is_array($current_access) && in_array($package['ID'],$current_access)){ 
		echo "<option value='".$package['ID']."' selected=selected>".$package['name']."</option>";
		}else{ 
		echo "<option value='".$package['ID']."'>".$package['name']."</option>";		
		}
		
	$i++;		
	} // end foreach
	
    ?>
	</select>
    <p style="margin-bottom:10px;">Hold CTRL to select multiple memberships.</p>
   <?php } ?>
            
            
            
            
            
            
            
            
            
            
            
            
             
          
    
    </div>  
    <?php } ?> 
    <div class="tab-pane fade in" id="set5">
    
	<?php do_action('hook_admin_1_tab1_subtab5'); ?> 
    
    <div class="heading1">User Account Options</div> 
    
    <?php
	
	if($core_admin_values['show_account_edit'] == ""){ 		$core_admin_values['show_account_edit'] = 1; }
	if($core_admin_values['show_account_create'] == ""){ 	$core_admin_values['show_account_create'] = 1; }
 
	?>
    
    <div class="form-row control-group row-fluid ">
                                <label class="control-label span4 offset3" rel="tooltip" data-original-title="This will turn on/off the display block for my account section of the users account page." data-placement="top">Display My Account Details</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_edit').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_edit').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_edit'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_edit" name="admin_values[show_account_edit]" 
                                 value="<?php echo $core_admin_values['show_account_edit']; ?>">
    </div>  
    
    <?php if(!defined('WLT_CART')){ ?>	
    <div class="form-row control-group row-fluid ">
                                <label class="control-label span4 offset3" rel="tooltip" data-original-title="This will allow users to send messages to each other." data-placement="top">Private Message System</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('message_system').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('message_system').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['message_system'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="message_system" name="admin_values[message_system]" 
                                 value="<?php echo $core_admin_values['message_system']; ?>">
    </div>  
     
    <div class="form-row control-group row-fluid ">
                                <label class="control-label span4 offset3" rel="tooltip" data-original-title="This will turn on/off the display block for creating a new listing." data-placement="top">Display Create Listing</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_create').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_create').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_create'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_create" name="admin_values[show_account_create]" 
                                 value="<?php echo $core_admin_values['show_account_create']; ?>">
    </div>  
    
    <div class="form-row control-group row-fluid ">
                                <label class="control-label span4 offset3" rel="tooltip" data-original-title="This will turn on/off the display block for viewing existing listings." data-placement="top">Display My Website Listing</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_viewing').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_viewing').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_viewing'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_viewing" name="admin_values[show_account_viewing]" 
                                 value="<?php echo $core_admin_values['show_account_viewing']; ?>">
    </div> 
    
        <div class="form-row control-group row-fluid ">
                                <label class="control-label span4 offset3" rel="tooltip" data-original-title="This will turn on/off the display block for creating a new listing." data-placement="top">Display Membership Packages</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_membership').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_membership').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_membership'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_membership" name="admin_values[show_account_membership]" 
                                 value="<?php echo $core_admin_values['show_account_membership']; ?>">
    </div>  
    
     
    
    <div class="form-row control-group row-fluid ">
                                <label class="control-label span4 offset3" rel="tooltip" data-original-title="This will turn on/off the display block for subscriptions" data-placement="top">Display Email Subscriptions</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_subscriptions').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_subscriptions').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_subscriptions'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_subscriptions" name="admin_values[show_account_subscriptions]" 
                                 value="<?php echo $core_admin_values['show_account_subscriptions']; ?>">
    </div>
    
     
    
    <?php } ?> 
     <div class="form-row control-group row-fluid ">
                                <label class="control-label span4 offset3" rel="tooltip" data-original-title="This will turn on/off the display block for favorites" data-placement="top">Display Favorites</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_favs').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_favs').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_favs'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_favs" name="admin_values[show_account_favs]" 
                                 value="<?php echo $core_admin_values['show_account_favs']; ?>">
    </div> 
    

    
    
    <div class="heading1">My Details Tab</div> 
    
      <div class="form-row control-group row-fluid ">
                                <label class="control-label span4 offset3" rel="tooltip" data-original-title="This will turn on/off the display of the default first and last name field boxes." data-placement="top">Show First/Last Name Fields</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_names').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_names').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_names'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_names" name="admin_values[show_account_names]" 
                                 value="<?php echo $core_admin_values['show_account_names']; ?>">
    </div>   
    
    
    
    
      <div class="form-row control-group row-fluid ">
                                <label class="control-label span4 offset3" rel="tooltip" data-original-title="This will turn on/off the display of the default first and last name field boxes." data-placement="top">Show User Photo Upload</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_photo').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_photo').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_photo'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_photo" name="admin_values[show_account_photo]" 
                                 value="<?php echo $core_admin_values['show_account_photo']; ?>">
    </div>  
    
    
          <div class="form-row control-group row-fluid ">
                                <label class="control-label span4 offset3" rel="tooltip" data-original-title="This will turn on/off the display of the social media input boxes." data-placement="top">Show Social Media Options</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_social').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_social').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_social'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_social" name="admin_values[show_account_social]" 
                                 value="<?php echo $core_admin_values['show_account_social']; ?>">
    </div>  
    
    
    
    </div> 
    <div class="tab-pane fade in" id="set6">
    
    <?php do_action('hook_admin_1_tab1_subtab6'); ?> 
    
       
    
            
            
          <div class="heading1">Main Navigation Display</div>  
          
          
               			<div class="form-row row-fluid span11 ">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="This will add the parent category icon to your menu item." data-placement="top">Add Category Icon</label>
                            <div class="controls span5">
                              <div class="row-fluid">                              
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('menucategoryicon').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('menucategoryicon').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['menucategoryicon'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                            
                             
                             <input type="hidden" class="row-fluid" id="menucategoryicon" name="admin_values[menucategoryicon]" 
                             value="<?php echo $core_admin_values['menucategoryicon']; ?>">
            </div>
            
            <div class="clearfix"></div>
            
                			<div class="form-row row-fluid span11 " style="margin-top:10px;">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="This will hide the text displayed next to your icons." data-placement="top">Hide Text With Icons</label>
                            <div class="controls span5">
                              <div class="row-fluid">                              
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('menucategoryiconnotext').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('menucategoryiconnotext').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['menucategoryiconnotext'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                            
                             
                             <input type="hidden" class="row-fluid" id="menucategoryiconnotext" name="admin_values[menucategoryiconnotext]" 
                             value="<?php echo $core_admin_values['menucategoryiconnotext']; ?>">
            </div> 
            
            
          <div class="heading1">Addthis.com Social Icons</div>  
          
          
              <div class="clearfix"></div>
            
                			<div class="form-row row-fluid span11 " style="margin-top:10px;">
                            <label class="control-label span4 offset3" rel="tooltip" data-original-title="This will turn on/off the AddThis social icons features." data-placement="top">Enable</label>
                            <div class="controls span5">
                              <div class="row-fluid">                              
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('addthis').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('addthis').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['addthis'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                            
                             
                             <input type="hidden" class="row-fluid" id="addthis" name="admin_values[addthis]" 
                             value="<?php echo $core_admin_values['addthis']; ?>">
            </div>
             <div class="clearfix"></div>
            
                     <!------------ FIELD -------------->          
            <div class="form-row control-group row-fluid" style="margin-top:10px;">
                <label class="control-label span4 offset3">Username</label>
                <div class="controls span4">         
            
              
                  <input type="text"  name="admin_values[addthis_name]" value="<?php echo $core_admin_values['addthis_name']; ?>">
                       
                </div>
            </div>
            <!------------ END FIELD -------------->
            
           
        
        
        
        <div class="heading1">ItemScope (http://schema.org/)</div>  
        
        <p>Here you can enable/disable ItemScope tags from being added to your website markup.</p>
          
          
              <div class="clearfix"></div>
            
                			<div class="form-row row-fluid span11 " style="margin-top:10px;">
                            <label class="control-label span4 offset3" data-placement="top">Enable</label>
                            <div class="controls span5">
                              <div class="row-fluid">                              
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('itemscope').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('itemscope').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['itemscope'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                            
                             
                             <input type="hidden" class="row-fluid" id="itemscope" name="admin_values[itemscope]" 
                             value="<?php echo $core_admin_values['itemscope']; ?>">
            </div>
             <div class="clearfix"></div>
        
         
          
     
     
    </div>  
    <div class="tab-pane fade in" id="set7">
    
    </div> 
    <div class="tab-pane fade in" id="set8">
    
    </div>  
</div>
</div>  
 

</div> 

<!--------------------------- LANGUAGE TAB ---------------------------->


<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "registration"){ echo "active in"; } ?>" id="registration">

<div class="row-fluid">


    <div class="box gradient span8">

      <div class="title">
            <div class="row-fluid">
             <a data-toggle="modal" href="<?php echo get_home_url(); ?>/wp-admin/admin.php?page=1#myModal" class="btn btn-success" style="float:right;margin-top:4px; margin-right:10px;">Add New Field</a>
            <h3><i class="icon-list"></i>Fields</h3></div>
        </div><!-- End .title -->
        
        <div class="content" style="min-height:500px;">
       
 		<?php 
		
		$regfields = get_option("regfields");
		if(is_array($regfields) && count($regfields) > 0 ){  ?>
        
        
            <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
            <thead>
            <tr>
              <th class="no_sort">Description</th>
              <th class="no_sort" style="width:110px;text-align:center;">Required?</th>
              <th class="no_sort" style="width:110px;text-align:center;">Editable?</th>
              <th class="no_sort" style="width:110px;text-align:center;">Actions</th>
              
            </thead>
            <tbody>
            
        <?php 		
		//PUT IN CORRECT ORDER
		$ordered_regfields = $CORE->multisort( $regfields , array('order') ); 
		$a = 0; foreach($ordered_regfields as $key=>$field){ ?>
		<tr>
         <td><?php echo stripslashes($field['name']); ?></td>         
         <td><center><span class="label label-<?php echo $field['required']; ?>"><?php echo $field['required']; ?></span></center></td>
         <td><center><span class="label label-<?php echo $field['display_profile']; ?>"><?php echo $field['display_profile']; ?></span></center></td>
         <td class="ms">
         <center>
                <div class="btn-group1">
                  <a class="btn btn-small" rel="tooltip" 
                  href="admin.php?page=1&edit_reg_field=<?php echo $CORE->multisortkey($regfields, 'key', $field['key']); ?>"
                  data-placement="left" data-original-title=" edit "><i class="gicon-edit"></i></a>                   
                  <a class="btn btn-inverse btn-small confirm" rel="tooltip" data-placement="bottom" 
                  data-original-title="Remove"
                  href="admin.php?page=1&delete_reg_field=<?php echo $CORE->multisortkey($regfields, 'key', $field['key']); ?>"
                  ><i class="gicon-remove icon-white"></i></a> 
                </div>
            </center>
            </td>
            </tr>
            <?php  $a++; }   ?>
            
            <?php do_action('hook_admin_1_tab2_left'); ?> 
            
            </tbody>
            </table>
            
         <?php } ?>
                 
        </div> <!-- End .content -->
        
        
    </div><!-- End .box -->
    
    

    <div class="box gradient span4">

      <div class="title">
            <div class="row-fluid">
                <h3><i class="icon-wrench"></i>Settings</h3>
            </div>
        </div><!-- End .title -->
        <div class="content">
       
    
    <?php if(!defined('WP_ALLOW_MULTISITE')){ ?>
       <div class="form-row control-group row-fluid">
                            <label class="control-label span7">Allow Visitors to Register Accounts</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('can_reg').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('can_reg').value='1'">
                                  </label>
                                  <div class="toggle <?php if(get_option('users_can_register') == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="can_reg" name="adminArray[users_can_register]" 
                             value="<?php echo get_option('users_can_register'); ?>">
            </div>
            <?php }else{ ?>
            <p class="alert">Registration on/off options are part of <a href="<?php echo get_home_url(); ?>/wp-admin/network/settings.php" style="text-decoration:underline;">WordPress Network settings.</a></p>
            
             <input type="hidden" class="row-fluid" id="can_reg" name="adminArray[users_can_register]" 
                             value="1">
            <?php } ?>
            
            
          <div class="form-row control-group row-fluid ">
                            <label class="control-label span7" rel="tooltip" data-original-title="Enable this option if you prefer users to create their own password instead of being emailed one." data-placement="top">Allow Visitors to Create Passwords</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('visitor_password').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('visitor_password').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['visitor_password'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="visitor_password" name="admin_values[visitor_password]" 
                             value="<?php echo $core_admin_values['visitor_password']; ?>">
            </div>  
            
     
 
 <b>Additional Registration Page Text</b>
 <p><small>Here you can add your own text which will be displayed on your registration page. </small></p>
        <textarea class="row-fluid" id="default-textarea" style="height:100px;" name="admin_values[register_text]"><?php echo stripslashes($core_admin_values['register_text']); ?></textarea>
        
        <small style="color:#666;">HTML &amp; WordPress Shortcodes accepted</small>
        
        <hr />
        
        
               <div class="form-row control-group row-fluid">
                            <label class="control-label span7">Disable Theme Security Code</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('register_securitycode').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('register_securitycode').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['register_securitycode'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="register_securitycode" name="admin_values[register_securitycode]" 
                             value="<?php echo $core_admin_values['register_securitycode']; ?>">
            </div> 
        
        
        <?php do_action('hook_admin_1_tab2_right'); ?>
       
       
        </div> <!-- End .content -->
        
     
 
    </div><!-- End .box -->
 

</div>          


	</div>


</div>


<!--------------------------- EMAIL TAB ---------------------------->




<!-- start save button -->
<div class="form-actions row-fluid">
<div class="span7 offset5">
<button type="submit" class="btn btn-primary">Save Changes</button> 
</div>
</div> 
<!-- end save button -->

 
 </div> 
      
      
</form> 

<?php if(isset($_GET['edit_reg_field']) && is_numeric($_GET['edit_reg_field']) ){ 
$regfields = get_option("regfields");
?>
<script type="text/javascript">
jQuery(document).ready(function () { jQuery('#myModal').modal('show'); })
</script>
<?php } ?>

<form method="post" name="admin_reg_field" id="admin_reg_field" action="admin.php?page=1" onsubmit="return ValidateRegFields();">
<input type="hidden" name="newregfield" value="yes" />
<input type="hidden" name="tab" value="registration" />
<?php if(isset($_GET['edit_reg_field'])){ ?>
<input type="hidden" name="eid" value="<?php echo $_GET['edit_reg_field']; ?>" />
<input type="hidden" name="regfield[ID]" value="<?php echo $regfields[$_GET['edit_reg_field']]['ID']; ?>" />
<?php } ?>


<script type="text/javascript"> 
function ValidateRegFields(){ 

	var cus0 	= document.getElementById("dbkey1");
	if(cus0.value == ''){
		alert('Please enter a unique database key. (lowecase, no spaces)');
		cus0.style.border = 'thin solid red';
		cus0.focus();
		return false;
	} 
 	
	return true;					
}
</script> 

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3 id="myModalLabel">Registration Field</h3>
            </div>
            <div class="modal-body" style="min-height:350px;">
              
               
           <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field"><b>Display Caption</b></label>
                <div class="controls span7">
                  <input type="text"  name="regfield[name]" class="row-fluid" value="<?php if(isset($_GET['edit_reg_field'])){ echo $regfields[$_GET['edit_reg_field']]['name']; }?>">
                   
                </div>
              </div>
           

            
            
           <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field">Field Type</label>
                <div class="controls span7">
                  <select name="regfield[fieldtype]" id="reg_new_1" class="chzn-select" onchange="showhideextrafield(this.value)">
                  
                    <option value="input" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['fieldtype'] == "input"){echo "selected=selected"; } }?>>Input Field</option>
                    <option value="textarea" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['fieldtype'] == "textarea"){echo "selected=selected"; } }?>>Text Area</option>
                    <option value="checkbox" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['fieldtype'] == "checkbox"){echo "selected=selected"; } }?>>Checkbox</option>
                    <option value="radio" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['fieldtype'] == "radio"){echo "selected=selected"; } }?>>Radio Button</option> 
                    <option value="select" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['fieldtype'] == "select"){echo "selected=selected"; } }?>>Selection Box</option>                                          
                    </select>
     
                </div>
            </div>
            
            <script>
			
			function showhideextrafield(val){
				if(val == "checkbox" || val =="radio" || val =="select" ){
				jQuery('#extrafieldvalues').show();
				} else {
				jQuery('#extrafieldvalues').hide();
				}			
			}
			 
			</script>
            
            
           <div class="form-row control-group row-fluid" id="extrafieldvalues" 
		   <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['fieldtype'] == "select" || $regfields[$_GET['edit_reg_field']]['fieldtype'] == "radio" || $regfields[$_GET['edit_reg_field']]['fieldtype'] == "checkbox"){ }else{ echo 'style="display:none;"'; } }else{ echo 'style="display:none;"'; } ?>>
                <label class="control-label span3" for="normal-field">Field Values</label>
                <div class="controls span7">
                   
                 <textarea class="row-fluid"  name="regfield[values]" placeholder="One value per line" style="border:1px solid orange;height:100px;"><?php if(isset($_GET['edit_reg_field'])){ echo $regfields[$_GET['edit_reg_field']]['values']; }?></textarea>
                   
                </div>
              </div>

          <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field">Database Key <small>(lowecase, no spaces)</small></label>
                <div class="controls span7">
                  <input type="text" name="regfield[key]" class="row-fluid" id="dbkey1" value="<?php if(isset($_GET['edit_reg_field'])){ echo $regfields[$_GET['edit_reg_field']]['key']; }?>">
                </div>
            </div> 
           
             
            
           <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field">Display Order</label>
                <div class="controls span7">
                
                <div class="span3" style="margin-left: 0px;">
                  <input type="text" name="regfield[order]" class="row-fluid" style="width:50px;" value="<?php if(isset($_GET['edit_reg_field'])){ echo $regfields[$_GET['edit_reg_field']]['order']; }?>">
                 </div> 
                 <div class="span7">
                 Required? 
                 <select name="regfield[required]"  style="width:100px;">
                    <option value="yes" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['required'] == "yes"){echo "selected=selected"; } }?>>yes</option>
                    <option value="no" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['required'] == "no"){echo "selected=selected"; } }?>>no</option>                   </select>
                 </div>
                    
                </div>
            </div> 
                        
            
           <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field">User Can Edit?</label>
                <div class="controls span7">
                  <select name="regfield[display_profile]" id="reg_new_2" class="chzn-select">
               
                   <option value="yes" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['display_profile'] == "yes"){echo "selected=selected"; } }?>>yes</option>
                    <option value="no" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['display_profile'] == "no"){echo "selected=selected"; } }?>>no</option>                      
                    </select>
     
                </div>
                <div class="clearfix"></div>
                <small style="padding-left:130px;">Allow user to edit this on their 'my account' screen.</small>
            </div> 
           
              
            </div>
            
            <div class="modal-footer">
              <button class="btn" data-dismiss="modal">Close</button>
              <button class="btn btn-primary">Save changes</button>
            </div>
</div>

</form> 

 
  
<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); ?>
<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $OBJECTS, $SHORTCODES, $CORE_ADMIN;

// LOAD IN OPTIONS FOR ADVANCED SEARCH
wp_enqueue_script( 'jquery-ui-sortable' );
wp_enqueue_script( 'jquery-ui-draggable' );
wp_enqueue_script( 'jquery-ui-droppable' );

// LOAD IN BOOTSTRAP STYLES FOR EDITOR	
add_editor_style( FRAMREWORK_URI.'/css/css.core.css' );
 
// LOAD IN MAIN DEFAULTS
$core_admin_values = get_option("core_admin_values"); 
 
if(isset($_GET['prelayout']) && !defined('WLT_DEMOMODE') && current_user_can('administrator')&& !isset($_POST['tab']) ){

	$lay = array();
	
	// GET THE CURRENT VALUES
	$lay = $core_admin_values;
	$cc = get_option('wlt_objectscounter');
	$BLOCKSTRING = "";
	$cc++;
	switch($_GET['prelayout']){
	
		case "1": {
		
		$lay['widgetobject']["carsousel"][$cc] = array(		
				"title" => "Popular Listings",
				"query" => "",	
				"fullw" => "yes",
				"arrows" => "top",	
		);
			
		$BLOCKSTRING .= "carsousel_".$cc.","; $cc++;
		
		$lay['widgetobject']["text"][$cc] = array(		
				"text" => "<div class='block'><div class='block-content'><h1>Welcome to our website</h1><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p></div></div>",					
				"fullw" => "no",					
		);
		
		$BLOCKSTRING .= "text_".$cc.","; $cc++;
			
		$lay['widgetobject']["recentlisting"][$cc] = array(
				"style" => "list",
				"title" => "Recently Added Listings", 
				"fullw" => "no",
		); 	
		
		$BLOCKSTRING .= "recentlisting_".$cc.","; $cc++;
		
		$lay['homepage'] 		= array("widgetblock1" => $BLOCKSTRING);
				
		$lay['layout_columns']['homepage'] = 1;		
	
		
		} break;
		
		case "2": {
		
			$lay['widgetobject']["categoryblock"][$cc] 	= array(
					"image" => "no",
					"title" => "Website Categories", 
					"fullw" => "no",
					"subcats" => "3",
					"subcatcount" => "yes",
					"btnview" => "yes",
					"subcatempty" => "yes",
			);
			
			$BLOCKSTRING .= "categoryblock_".$cc.","; $cc++;
		 
			$lay['widgetobject']["recentlisting"][$cc] 	= array(
				"style" => "list",
				"title" => "Recently Added Listings", 
				"fullw" => "no",
			); 	
			
			$BLOCKSTRING .= "recentlisting_".$cc.","; $cc++;
		
			$lay['homepage'] 		= array("widgetblock1" => $BLOCKSTRING);
				
			$lay['layout_columns']['homepage'] = 1;	
		
		} break;
		
		case "3": {
		
			$lay['widgetobject']["text"][$cc] = array(		
					"text" => "<div class='block'><div class='block-content'><h1>Welcome to our website</h1><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p></div></div>",					
					"fullw" => "no",					
			);
			
			$BLOCKSTRING .= "text_".$cc.","; $cc++;
			
			$lay['widgetobject']["tabs"][$cc] = array(
					"title1" => "Popular",
					"query1" => "&order=asc&posts_per_page=8",
					"style1" => "list",
					
					"title2" => "Recently Added",
					"query2" => "&order=desc",
					"style2" => "list",
					
					"fullw" => "no",
			);
			
			$BLOCKSTRING .= "tabs_".$cc.","; $cc++;
		
			$lay['homepage'] 		= array("widgetblock1" => $BLOCKSTRING);
				
			$lay['layout_columns']['homepage'] = 1;			
		
		} break;
		
		
		case "4": {
		
			$lay['widgetobject']["carsousel"][$cc] = array(		
					"title" => "Popular Listings",
					"query" => "",	
					"fullw" => "yes",
					"arrows" => "top",	
			);
			
			$BLOCKSTRING .= "carsousel_".$cc.","; $cc++;
			
			$lay['widgetobject']["3columns"][$cc] = array(		
					"col1" => "<div class='block'><div class='block-content'><h1>Headline</h1><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p></div></div>",					
					"col2" => "<div class='block'><div class='block-content'><h1>Headline</h1><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p></div></div>",					
					"col3" => "<div class='block'><div class='block-content'><h1>Headline</h1><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p></div></div>",					
					
					"fullw" => "yes",
			);
			
			$BLOCKSTRING .= "3columns_".$cc.","; $cc++;
			
			$lay['widgetobject']["recentlisting"][$cc] = array(	

				"style" => "list",
				"title" => "Recently Added Listings", 
				"fullw" => "no",
			);
			
			$BLOCKSTRING .= "recentlisting_".$cc.","; $cc++;
		
			$lay['homepage'] 		= array("widgetblock1" => $BLOCKSTRING);
				
			$lay['layout_columns']['homepage'] = 1;			
		
		} break;
		
		
	
	}// end switch

	// UPDATE DATABASE 		
	update_option( "core_admin_values", $lay);
	// MESSAGE
	$GLOBALS['error_message'] = "New Settings Saved";
	// RELOAD NEW DATA
	$core_admin_values = get_option("core_admin_values"); 
}

 

// DISPLAY
echo $CORE_ADMIN->HEAD();
?>
     
<ul id="tabExample1" class="nav nav-tabs">

<?php
// HOOK INTO THE ADMIN TABS
function _2_tabs(){ $STRING = ""; global $wpdb; $core_admin_values = get_option("core_admin_values");

	if(isset($_GET['tab'])){ $_POST['tab'] = $_GET['tab']; }
	
	$pages_array = array( 
	"1" => array("t" => "General Layout", "k"=>"home"),
	"3" => array("t" => "Home Page",  "k"=>"homepage"),		
  	"2" => array("t" => "Content Pages",  "k"=>"listing"),
	
	);
	
	if(defined('ADMIN_HIDE_HOMEPAGE')){ unset($pages_array[3]); }
	
	foreach($pages_array as $page){
	
	if( ( isset($_POST['tab']) && $_POST['tab'] == $page['k'] ) || ( !isset($_POST['tab']) && $page['k'] == "home" ) || ( isset($_POST['tab']) && $_POST['tab'] == "" && $page['k'] == "home" )  ){ $class = "active"; }else{ $class = ""; }
	
		$STRING .= '<li class="'.$class.'"><a href="#'.$page['k'].'" onclick="document.getElementById(\'ShowTab\').value=\''.$page['k'].'\'" data-toggle="tab">'.$page['t'].'</a></li>';		
	}
 
	return $STRING;

}
echo hook_admin_2_tabs(_2_tabs());
// END HOOK
?>    
 

</ul>
 

 <div class="tab-content"> 
 
<?php do_action('hook_admin_2_content'); ?>

 
 
 <div class="tab-pane fade <?php if(!isset($_POST['tab']) || ( isset($_POST['tab']) && $_POST['tab'] =="" ) || ( isset($_POST['tab']) && $_POST['tab'] =="home" ) ){ echo "active in"; } ?>" id="home">  
    

 
   <div class="row-fluid">
      <div class="span6">
        <div class="box gradient">
          <div class="title">
            <h3>
            <i class="icon-eye-open"></i>
            <span>Website Layout</span>
            </h3>
          </div>
          <div class="content">
 

 

 <!--  RESPONSIVE -->
 
  <hr style="margin-top:5px;margin-bottom:5px;"/>     
  <b>Layout Adjustments</b>           
  <hr style="margin-top:5px;margin-bottom:15px;"/>
      
            <div class="form-row control-group row-fluid ">
                            <label class="control-label span6" rel="tooltip" data-original-title="Enable this option if you want the website to become fluid and resizable. This option is recommended if you want your site to appear resized for mobile and tablet devices." data-placement="top">Responsive Design</label>
                            <div class="controls span6">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('display_responsive').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('display_responsive').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['responsive'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="display_responsive" name="admin_values[responsive]" 
                             value="<?php echo $core_admin_values['responsive']; ?>">
            </div>
            
<!-- end WEBSITE SCREENSHOT PREVIEWER -->
  
     
<div class="form-row control-group row-fluid">
                <label class="control-label span5" for="style">Template Width</label>
                <div class="controls span7">
                  <select name="admin_values[layout_columns][style]" class="chzn-select" id="style">
                    <option value=""></option>
                    <option value="fixed" <?php if(isset($core_admin_values['layout_columns']) && $core_admin_values['layout_columns']['style'] == "fixed"){ echo "selected=selected"; } ?>>Boxed Layout (1170px)</option>
                    <option value="fluid" <?php if(isset($core_admin_values['layout_columns']) && $core_admin_values['layout_columns']['style'] == "fluid"){ echo "selected=selected"; } ?>>Wide Layout (100%)</option>                     
                  </select>
                </div>
</div>


<!-- end WEBSITE SCREENSHOT PREVIEWER -->


     <hr style="margin-top:5px;margin-bottom:5px;"/>     
     <b>Header Layout Adjustments</b>           
     <hr style="margin-top:5px;margin-bottom:15px;"/>      
     <div class="row-fluid">
      
            <div class="span6 well  pagination-centered">
            <a href="javascript:void(0);" onclick="document.getElementById('layout_header').value='1';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/h1.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_header'] == "1"){ echo "border:2px solid red;";} ?>" />
            </a>
                 
            </div>

            <div class="span6 well pagination-centered"> 
            <a href="javascript:void(0);" onclick="document.getElementById('layout_header').value='2';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/h2.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_header'] == "2"){ echo "border:2px solid red;";} ?>" />
            </a>
            
            </div>
            
  </div><div class="row-fluid"> 

            <div class="span6 well pagination-centered">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_header').value='3';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/h3.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_header'] == "3"){ echo "border:2px solid red;";} ?>" />
            </a>  
             </div>
             
            <div class="span6 well pagination-centered">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_header').value='4';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/h4.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_header'] == "4"){ echo "border:2px solid red;";} ?>" />
            </a> 
            
            </div>
            
            
            
                      
  </div><div class="row-fluid"> 

            <div class="span6 well pagination-centered">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_header').value='5';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/h5.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_header'] == "5"){ echo "border:2px solid red;";} ?>" />
            </a>  
             </div>
             
          
            <div class="span6 well pagination-centered">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_header').value='6';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/h6.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_header'] == "6"){ echo "border:2px solid red;";} ?>" />
            </a> 
		 
            
            </div>
            
            
            
                      
      </div>
      
      
  <?php if($core_admin_values['layout_header'] == "5" || $core_admin_values['layout_header'] == "6"){ ?>
  
     <hr style="margin-top:5px;margin-bottom:5px;"/>     
     <b>Header Text (Accepts HTML)</b>           
     <hr style="margin-top:5px;margin-bottom:15px;"/>  
            <!------------ FIELD -------------->          
            <div class="row-fluid">
                             
                  <textarea  name="admin_values[header_style_text]" style="width:100%;"><?php echo stripslashes($core_admin_values['header_style_text']); ?></textarea>
              </div>    
  
  <?php } ?>    
      
      
      <?php if(!defined('WLT_CART')){ ?>
      <hr style="margin-top:5px;margin-bottom:5px;"/>     
     <b>Header - Show Member Login/Logout Buttons</b>           
     <hr style="margin-top:5px;margin-bottom:15px;"/> 
     
    <div class="form-row control-group row-fluid ">
                                <label class="control-label span7" data-placement="top">Enable</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('header_accountdetails').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('header_accountdetails').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['header_accountdetails'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="header_accountdetails" name="admin_values[header_accountdetails]" 
                                 value="<?php echo $core_admin_values['header_accountdetails']; ?>">
         </div>
         
     <p><b class="label label-info">Note</b> this will disable the welcome text below. </p>
      
      
     <hr style="margin-top:5px;margin-bottom:5px;"/>     
     <b>Header Text (requires a top navigation menu)</b>           
     <hr style="margin-top:5px;margin-bottom:15px;"/>  
            <!------------ FIELD -------------->          
            <div class="row-fluid">
                             
                  <textarea  name="admin_values[header_welcometext]" style="width:100%;"><?php echo stripslashes($core_admin_values['header_welcometext']); ?></textarea>
                  
            </div>
            <!------------ END FIELD -------------->
      <?php }else{ ?>
      <input type="hidden" name="admin_values[header_welcometext]" value="">
      <input type="hidden" name="admin_values[header_accountdetails]" value="0">
      <?php } ?>
      
  <input type="hidden" name="admin_values[layout_header]" id="layout_header" value="<?php echo $core_admin_values['layout_header']; ?>" />     
   
<div class="clear"></div> 

     <hr style="margin-top:5px;margin-bottom:5px;"/>     
     <b>Menu Layout Adjustments</b>           
     <hr style="margin-top:5px;margin-bottom:15px;"/>      
     <div class="row-fluid fluid">
      
            <div class="span4 well  pagination-centered">
            <a href="javascript:void(0);" onclick="document.getElementById('layout_menu').value='1';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/tm1.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_menu'] == "1"){ echo "border:2px solid red;";} ?>" />
            </a>
                 
            </div>

            <div class="span4 well pagination-centered"> 
            <a href="javascript:void(0);" onclick="document.getElementById('layout_menu').value='2';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/tm2.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_menu'] == "2"){ echo "border:2px solid red;";} ?>" />
            </a>
            
            </div>

            <div class="span4 well pagination-centered">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_menu').value='3';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/tm3.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_menu'] == "3"){ echo "border:2px solid red;";} ?>" />
            </a>                               
                
            </div>
            
                      
      </div>
  <input type="hidden" name="admin_values[layout_menu]" id="layout_menu" value="<?php echo $core_admin_values['layout_menu']; ?>" />     
      
<div class="clear"></div> 
 

<!-- START WEBSITE COLUMN LAYOUTS -->  
      
    <div class="clear"></div>   
    </div>   
</div>

<?php do_action('hook_admin_2_tab1_left'); ?> 
      

 </div> <div class="span6"> 





<!-- start navigation styles -->
<div class="box gradient">
<div class="title">

<a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('TfM2-R5azgQ','videoboxplayer','479','350');" style="float:right;margin-top:5px; margin-right:5px;">Watch Video</a>
<h3><i class="icon-pencil"></i><span>Website Column Layout</span></h3>
</div>
<div class="content">

   <p>Here you can set the column layout for your website pages.</p>
 
 <?php 
 // DONT SHOW HOME PAGE OPTIONS IF ALREADY SET WITHIN CHILD THEME
 if(file_exists(THEME_PATH."/templates/".$core_admin_values['template']."/_homepage.php") ){ }else{
	 ?>
       <hr style="margin-top:5px;margin-bottom:5px;"/>     
     <b>Home Page</b>           
     <hr style="margin-top:5px;margin-bottom:15px;"/>      
     <div class="row-fluid fluid">
      
            <div class="span3 well  pagination-centered">
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body0').value='1';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l1.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['homepage'] == "1"){ echo "border:2px solid red;";} ?>" />
            </a>
                 
            </div>

            <div class="span3 well pagination-centered"> 
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body0').value='2';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l2.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['homepage'] == "2"){ echo "border:2px solid red;";} ?>" />
            </a>
            
            </div>

            <div class="span3 well pagination-centered">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body0').value='3';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l3.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['homepage'] == "3"){ echo "border:2px solid red;";} ?>" />
            </a>                               
                
            </div>
            
             <div class="span3 well pagination-centered">
             <a href="javascript:void(0);" onclick="document.getElementById('layout_body0').value='4';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l4.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['homepage'] == "4"){ echo "border:2px solid red;";} ?>" />
            </a>                             
                
            </div> 
                      
      </div>
  <input type="hidden" name="admin_values[layout_columns][homepage]" id="layout_body0" value="<?php echo $core_admin_values['layout_columns']['homepage']; ?>" />   
 <?php } ?>
 
 
<div class="row-fluid">
<div class="span6"> 
     
<div class="form-row control-group row-fluid">
                <label class="control-label span12" for="style">2 Column Width</label>
                <div class="controls span12">
                  <select name="admin_values[layout_columns][homepage_2columns]" class="chzn-select" id="2stylehomepage">
                    <option value=""></option>
                    <option value="0" <?php selected( $core_admin_values['layout_columns']['homepage_2columns'], 0 ); ?>>
                    363px X 757px</option>
                    <option value="1" <?php selected( $core_admin_values['layout_columns']['homepage_2columns'], 1 ); ?>>
                    265px X 885px</option>                     
                  </select>
                </div>
</div>

</div>
<div class="span6">

<div class="form-row control-group row-fluid">
                <label class="control-label span12" for="style">3 Column Width</label>
                <div class="controls span12">
                  <select name="admin_values[layout_columns][homepage_3columns]" class="chzn-select" id="3stylehomepage">
                    <option value=""></option>
                    <option value="0" <?php selected( $core_admin_values['layout_columns']['homepage_3columns'], 0 ); ?>>
                    250px / 500px / 250px </option>
                    <option value="1" <?php selected( $core_admin_values['layout_columns']['homepage_3columns'],1 ); ?>>
                    150px / 700px / 150px </option>                     
                  </select>
                </div>
</div>

</div>               
</div>
 
 
  
     <hr style="margin-top:5px;margin-bottom:5px;"/>     
     <b>Search Results Page</b>           
     <hr style="margin-top:5px;margin-bottom:15px;"/>      
     <div class="row-fluid fluid">
      
            <div class="span3 well  pagination-centered">
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body4').value='1';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l1.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['search'] == "1"){ echo "border:2px solid red;";} ?>" />
            </a>
                 
            </div>

            <div class="span3 well pagination-centered"> 
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body4').value='2';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l2.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['search'] == "2"){ echo "border:2px solid red;";} ?>" />
            </a>
            
            </div>

            <div class="span3 well pagination-centered">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body4').value='3';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l3.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['search'] == "3"){ echo "border:2px solid red;";} ?>" />
            </a>                               
                
            </div>
            
             <div class="span3 well pagination-centered">
             <a href="javascript:void(0);" onclick="document.getElementById('layout_body4').value='4';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l4.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['search'] == "4"){ echo "border:2px solid red;";} ?>" />
            </a>                             
                
            </div> 
                      
      </div>
  <input type="hidden" name="admin_values[layout_columns][search]" id="layout_body4" value="<?php echo $core_admin_values['layout_columns']['search']; ?>" />     
      
      
      
 <div class="row-fluid">
<div class="span6"> 
     
<div class="form-row control-group row-fluid">
                <label class="control-label span12" for="style">2 Column Width</label>
                <div class="controls span12">
                  <select name="admin_values[layout_columns][search_2columns]" class="chzn-select" id="2stylesearch">
                    <option value=""></option>
                    <option value="0" <?php selected( $core_admin_values['layout_columns']['search_2columns'], 0 ); ?>>
                    363px X 757px</option>
                    <option value="1" <?php selected( $core_admin_values['layout_columns']['search_2columns'], 1 ); ?>>
                    265px X 885px</option>                     
                  </select>
                </div>
</div>

</div>
<div class="span6">

<div class="form-row control-group row-fluid">
                <label class="control-label span12" for="style">3 Column Width</label>
                <div class="controls span12">
                  <select name="admin_values[layout_columns][search_3columns]" class="chzn-select" id="3stylesearch">
                    <option value=""></option>
                    <option value="0" <?php selected( $core_admin_values['layout_columns']['search_3columns'], 0 ); ?>>
                    250px / 500px / 250px </option>
                    <option value="1" <?php selected( $core_admin_values['layout_columns']['search_3columns'],1 ); ?>>
                    150px / 700px / 150px </option>                     
                  </select>
                </div>
</div>

</div>               
</div>     
      
      
      
      
      
<div class="clear"></div>   
  
  
     <hr style="margin-top:5px;margin-bottom:5px;"/>     
     <b>Listing Display Page</b>           
     <hr style="margin-top:5px;margin-bottom:15px;"/>      
     <div class="row-fluid fluid">
      
            <div class="span3 well  pagination-centered">
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body1').value='1';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l1.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['single'] == "1"){ echo "border:2px solid red;";} ?>" />
            </a>
                 
            </div>

            <div class="span3 well pagination-centered"> 
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body1').value='2';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l2.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['single'] == "2"){ echo "border:2px solid red;";} ?>" />
            </a>
            
            </div>

            <div class="span3 well pagination-centered">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body1').value='3';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l3.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['single'] == "3"){ echo "border:2px solid red;";} ?>" />
            </a>                               
                
            </div>
            
             <div class="span3 well pagination-centered">
             <a href="javascript:void(0);" onclick="document.getElementById('layout_body1').value='4';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l4.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['single'] == "4"){ echo "border:2px solid red;";} ?>" />
            </a>                             
                
            </div> 
                      
      </div>
  <input type="hidden" name="admin_values[layout_columns][single]" id="layout_body1" value="<?php echo $core_admin_values['layout_columns']['single']; ?>" />     
     
     
     
     
  <div class="row-fluid">
<div class="span6"> 
     
<div class="form-row control-group row-fluid">
                <label class="control-label span12" for="style">2 Column Width</label>
                <div class="controls span12">
                  <select name="admin_values[layout_columns][single_2columns]" class="chzn-select" id="2stylesingle">
                    <option value=""></option>
                    <option value="0" <?php selected( $core_admin_values['layout_columns']['single_2columns'], 0 ); ?>>
                    363px X 757px</option>
                    <option value="1" <?php selected( $core_admin_values['layout_columns']['single_2columns'], 1 ); ?>>
                    265px X 885px</option>                     
                  </select>
                </div>
</div>

</div>
<div class="span6">

<div class="form-row control-group row-fluid">
                <label class="control-label span12" for="style">3 Column Width</label>
                <div class="controls span12">
                  <select name="admin_values[layout_columns][single_3columns]" class="chzn-select" id="3stylesingle">
                    <option value=""></option>
                    <option value="0" <?php selected( $core_admin_values['layout_columns']['single_3columns'], 0 ); ?>>
                    250px / 500px / 250px </option>
                    <option value="1" <?php selected( $core_admin_values['layout_columns']['single_3columns'],1 ); ?>>
                    150px / 700px / 150px </option>                     
                  </select>
                </div>
</div>

</div>               
</div>     
     
     
     
     
     
      
<div class="clear"></div>  


     <hr style="margin-top:5px;margin-bottom:5px;"/>     
     <b>Normal Page + Fallback (Everything Else) </b>           
     <hr style="margin-top:5px;margin-bottom:15px;"/>      
     <div class="row-fluid fluid">
      
            <div class="span3 well  pagination-centered">
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body2').value='1';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l1.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['page'] == "1"){ echo "border:2px solid red;";} ?>" />
            </a>
                 
            </div>

            <div class="span3 well pagination-centered"> 
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body2').value='2';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l2.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['page'] == "2"){ echo "border:2px solid red;";} ?>" />
            </a>
            
            </div>

            <div class="span3 well pagination-centered">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body2').value='3';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l3.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['page'] == "3"){ echo "border:2px solid red;";} ?>" />
            </a>                               
                
            </div>
            
             <div class="span3 well pagination-centered">
             <a href="javascript:void(0);" onclick="document.getElementById('layout_body2').value='4';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l4.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['page'] == "4"){ echo "border:2px solid red;";} ?>" />
            </a>                             
                
            </div> 
                      
      </div>
  <input type="hidden" name="admin_values[layout_columns][page]" id="layout_body2" value="<?php echo $core_admin_values['layout_columns']['page']; ?>" />    
  
  
  
  <div class="row-fluid">
<div class="span6"> 
     
<div class="form-row control-group row-fluid">
                <label class="control-label span12" for="style">2 Column Width</label>
                <div class="controls span12">
                  <select name="admin_values[layout_columns][page_2columns]" class="chzn-select" id="2stylepage">
                    <option value=""></option>
                    <option value="0" <?php selected( $core_admin_values['layout_columns']['page_2columns'], 0 ); ?>>
                    363px X 757px</option>
                    <option value="1" <?php selected( $core_admin_values['layout_columns']['page_2columns'], 1 ); ?>>
                    265px X 885px</option>                     
                  </select>
                </div>
</div>

</div>
<div class="span6">

<div class="form-row control-group row-fluid">
                <label class="control-label span12" for="style">3 Column Width</label>
                <div class="controls span12">
                  <select name="admin_values[layout_columns][page_3columns]" class="chzn-select" id="3stylepage">
                    <option value=""></option>
                    <option value="0" <?php selected( $core_admin_values['layout_columns']['page_3columns'], 0 ); ?>>
                    250px / 500px / 250px </option>
                    <option value="1" <?php selected( $core_admin_values['layout_columns']['page_3columns'],1 ); ?>>
                    150px / 700px / 150px </option>                     
                  </select>
                </div>
</div>

</div>               
</div>    
  
  
  
  
  
  
  
  
   <hr style="margin-top:5px;margin-bottom:5px;"/>     
     <b>Footer</b>           
     <hr style="margin-top:5px;margin-bottom:15px;"/>      
     <div class="row-fluid fluid">
      
            <div class="span3 well  pagination-centered">
            <a href="javascript:void(0);" onclick="document.getElementById('layout_footer').value='1';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l1.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['footer'] == "1"){ echo "border:2px solid red;";} ?>" />
            </a>
                 
            </div>

            <div class="span3 well pagination-centered"> 
            <a href="javascript:void(0);" onclick="document.getElementById('layout_footer').value='2';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l2.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['footer'] == "2"){ echo "border:2px solid red;";} ?>" />
            </a>
            
            </div>

            <div class="span3 well pagination-centered">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_footer').value='3';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l3.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['footer'] == "3"){ echo "border:2px solid red;";} ?>" />
            </a>                               
                
            </div>
            
             <div class="span3 well pagination-centered">
             <a href="javascript:void(0);" onclick="document.getElementById('layout_footer').value='4';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l4.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['footer'] == "4"){ echo "border:2px solid red;";} ?>" />
            </a>                             
                
            </div> 
                      
      </div>
  <input type="hidden" name="admin_values[layout_columns][footer]" id="layout_footer" value="<?php echo $core_admin_values['layout_columns']['footer']; ?>" />     
      
<div class="clear"></div> 
  
   
      
<div class="clear"></div>
<!-- END  WEBSITE COLUMN LAYOUTS -->
</div>
</div>

<?php do_action('hook_admin_2_tab1_right'); ?>   
      
          
        
        <!-- End .box -->
      </div>      
</div> <!-- End .span6 --> 

</div><!-- end LANGUAGE tab 2 --> 
 
 <!--------------------------- LANGUAGE TAB ---------------------------->






  
<!--------------------------- LANGUAGE TAB ---------------------------->
<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "listing"){ echo "active in"; } ?>" id="listing">
<script>
function AddthisShortC(code, box){		   
	jQuery('#'+box).val('['+ code +']'+jQuery('#'+box).val()); 
}
</script>


<div class="tabbable tabs-left" >
    <ul class="nav nav-tabs" style="height:900px">
    <?php if(!defined('WLT_HIDE_ADMIN_2_SEARCH')){ ?>
    <li <?php if(!isset($_POST['subsubtab']) || $_POST['subsubtab'] == ""){ echo "class='active'"; } ?>><a href="#pptab1" data-toggle="tab">Search Results Layout</a></li> 
    <li <?php if(isset($_POST['subsubtab']) && $_POST['subsubtab'] == "pptab5"){ echo "class='active'"; } ?>><a href="#pptab5" data-toggle="tab" onclick="document.getElementById('ShowSubSubTab').value='pptab5'">Fallback Results Layout</a></li> 
    <?php } ?>
    <li <?php if(defined('WLT_HIDE_ADMIN_2_SEARCH') || ( isset($_POST['subsubtab']) && $_POST['subsubtab'] == "pptab2" ) ){ echo "class='active'"; } ?>><a href="#pptab2" data-toggle="tab" onclick="document.getElementById('ShowSubSubTab').value='pptab2'">Listing Page Layout</a></li> 
    <li><a href="#pptab3" data-toggle="tab" onclick="document.getElementById('ShowSubSubTab').value='pptab3'">Print Page Layout</a></li> 
    <?php if(!defined('WLT_CART')){ $membershipfields 	= get_option("membershipfields"); if(is_array($membershipfields) && !empty($membershipfields)){ ?> 
    <li <?php if(isset($_POST['subsubtab']) && $_POST['subsubtab'] == "pptab4"){ echo "class='active'"; } ?>><a href="#pptab4" data-toggle="tab" onclick="document.getElementById('ShowSubSubTab').value='pptab4'">No Access Layout</a></li> 
    <?php } } ?>
    </ul>
    
    <div class="tab-content"  style="background:#fff;height:900px">
    
 	<?php if(!defined('WLT_HIDE_ADMIN_2_SEARCH')){ ?>
    
    <div class="tab-pane fade in <?php if(isset($_POST['subsubtab']) && $_POST['subsubtab'] == "pptab5"){ echo "active"; } ?>" id="pptab5">
    
    		<div class="heading1">Fallback Results Layout</div>
    
             <p>Fallback - used for all non-<?php echo THEME_TAXONOMY."_type"; ?> listings.</p>
             
            <textarea class="row-fluid" id="default-textarea"  style="height:100px;background:#E8FDE9" name="admin_values[itemcode_fallback]"><?php 
            
            if($core_admin_values['itemcode_fallback'] == ""){ echo '[IMAGE]<h1>[TITLE]</h1>[EXCERPT]'; }else{ echo stripslashes($core_admin_values['itemcode_fallback']); } ?></textarea>
            
            <small><span class="label label-no">Note</span> Supports HTML &amp; WordPress Shortcodes.</small>
           
    </div><!-- end blog layout -->
    
    <div class="tab-pane fade in <?php if(!isset($_POST['subsubtab']) || $_POST['subsubtab'] == ""){ echo "active"; } ?>" id="pptab1">
    

       <?php
	 
		$selected_template = $core_admin_values['template']; 
		$HandlePath = TEMPLATEPATH;
	    $count=1; $TemplateString = "";
		if($handle1 = opendir($HandlePath)) {      
			while(false !== ($file = readdir($handle1))){			
				if(strpos($file,"content-listing-") !== false ){	
			 		
					$file_name = str_replace(".php","",str_replace("content-","",$file));
					$TemplateString .= "<option "; 
					if ($core_admin_values['content_layout'] == $file_name) { $TemplateString .= ' selected="selected"'; }   
					$TemplateString .= 'value="'.$file_name.'">'; 					
					$TemplateString .= $file; 										
					$TemplateString.= "</option>";			
   
				}
			}
			
		}
		
if(strlen($TemplateString) > 5){
?> 
<div class="well">
<h2>Choose a display file;</h2>

<div class="form-row control-group row-fluid">
                <label class="control-label span5">Search Results Display File</label>
                <div class="controls span6">
                  <select name="admin_values[content_layout]" class="chzn-select" id="default_listing_status">
                    <option value=""></option>                    
                    <option value="listing" <?php if(!isset($core_admin_values['content_layout']) || $core_admin_values['content_layout'] == "listing"){ echo "selected=selected"; } ?>>Use Custom Layout</option>   
                     
                         <?php echo $TemplateString; ?>          
                  </select>
                </div>                
</div>
</div>
<?php } ?>

<div <?php if($core_admin_values['content_layout'] != "listing" && $core_admin_values['content_layout'] != ""){ ?>style="display:none;" <?php } ?>>
            
            <div class="heading1">
             <?php if(get_option('wlt_reset_itemcode') != ""){ ?>
            <a href="javascript:void(0);" onclick="document.getElementById('itemcode').value='';document.getElementById('customsearchpage').value='9';document.admin_save_form.submit();" 
            class="btn btn-info" style="float:right; margin-top:-5px;"> Reset to default layout </a> 
            <?php } ?> 
            
            <div class="btn-group" style="float:right; margin-top:-5px; margin-right:15px;">
              <button class="btn">Extra Options</button>
              <button class="btn dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
              <li><a href="javascript:void(0);" onclick="jQuery('#spre').show();">Show Predefined Layouts</a></li>
               <li><a href="javascript:void(0);" onclick="jQuery('#spbuts').show();">Show Shortcodes</a></li>
               <li><a href="#SearchEditMod" data-toggle="modal"> How does it work?</a></li>
              </ul>
            </div> 
            
            Custom Layout - Search Results</div>
            
            <p>Enter your own combination of html and shortcodes to customize the display of your search results.</p>
            
           
           <div style="display:none;" id="spbuts">
            <div class='well'>
			   <?php 
			   
			   
			   $btnArray =  $SHORTCODES->shortcodelist();
			   
			   array(
               'ID' =>'post ID',
               'IMAGE' =>'display image',		   
               'TITLE' =>'title with link to listing page',
               'TITLE-NOLINK' =>'title without link',
               'EXCERPT' =>'short content',
               'BUTTON' =>'more info button',
               'DATE' =>' listing creation date',
               'AUTHOR' =>'author',
               'CATEGORY' =>'category',
               'LISTINGSTATUS' =>'listing status',
               'LOCATION' =>'listing location',
               'AUTHORIMAGE' =>'author image',
               'AUTHORIMAGE-CIRCLE' =>'author image with circular background',
               'TIMESINCE' =>'',
               'RATING' =>'star rating',
               ); 
			   
			   if(defined('WLT_COUPON')){			   
			   //$btnArray = array_merge($btnArray,array('COUPON' => 'displays the coupon with click to copy','CBUTTON' => 'shows pop-up button','COUPON_START' => 'shows start date of the coupon', 'COUPON_END' =>'shows expiry date of coupon', 'STORE' => 'shows store name and link'));
			   }
               foreach( $btnArray as $k => $b){
			   if(isset($b['singleonly'])){ continue; }
			   if(!isset($b['desc'])){ $b['desc'] = ""; }
                echo "<a href='javascript:void(0);' onclick=\"AddthisShortC('".$k."','itemcode');\" class='btn' style='margin-right:10px; margin-bottom:5px;' rel='tooltip' data-original-title='".$b['desc']."' data-placement='bottom'>".$k."</a>";
               }               
               ?>
               
               <?php do_action('hook_admin_2_tags_search'); ?>
           
           </hr>
           <a href="javascript:void(0);" onclick="jQuery('#spbuts').hide();" class="label">Hide Shortcodes</a>
           </div>
           </div>
 
           
           
             
            <textarea class="row-fluid" id="itemcode" name="admin_values[itemcode]" style="height:300px;background:#E8FDE9;"><?php echo stripslashes($core_admin_values['itemcode']); ?></textarea>
            <input type="hidden" name="admin_values[customsearchpage]" id="customsearchpage" value="<?php echo $core_admin_values['customsearchpage']; ?>" /> 
            <small><span class="label label-no">Note</span> Supports HTML &amp; WordPress Shortcodes.</small>
            
            <hr />
            
            
            <div id="spre" style="display:none;">
            <p><b class="label label-info">Predefined Layouts</b> Click any layout below to setup the search results with the selected layout.</p>
            <hr />
			<div class="row-fluid">
                <div class="span4 well  pagination-centered">
                <a href="javascript:void(0);" onclick="document.getElementById('itemcode').value='';document.getElementById('customsearchpage').value='1';document.admin_save_form.submit();">
                <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/s1.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['customsearchpage'] == "1"){ echo "border:2px solid red;";} ?>">
                </a> 
                </div>
                <div class="span4 well pagination-centered"> 
                <a href="javascript:void(0);" onclick="document.getElementById('itemcode').value='';document.getElementById('customsearchpage').value='2';document.admin_save_form.submit();">
                <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/s2.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['customsearchpage'] == "2"){ echo "border:2px solid red;";} ?>">
                </a>
                </div>
                 
                <div class="span4 well pagination-centered">   
                <a href="javascript:void(0);" onclick="document.getElementById('itemcode').value='';document.getElementById('customsearchpage').value='3';document.admin_save_form.submit();">
                <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/s3.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['customsearchpage'] == "3"){ echo "border:2px solid red;";} ?>">
                </a>
                </div>
         
         </div>
         <div class="row-fluid">

                <div class="span4 well pagination-centered">
                 <a href="javascript:void(0);" onclick="document.getElementById('itemcode').value='';document.getElementById('customsearchpage').value='4';document.admin_save_form.submit();">
                <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/s4.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['customsearchpage'] == "4"){ echo "border:2px solid red;";} ?>">
                </a>
                </div>
                
                
  				<div class="span4 well pagination-centered">
                 <a href="javascript:void(0);" onclick="document.getElementById('itemcode').value='';document.getElementById('customsearchpage').value='5';document.admin_save_form.submit();">
                <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/s5.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['customsearchpage'] == "5"){ echo "border:2px solid red;";} ?>">
                </a>
                </div>               
                
                
  				<div class="span4 well pagination-centered">
                 <a href="javascript:void(0);" onclick="document.getElementById('itemcode').value='';document.getElementById('customsearchpage').value='6';document.admin_save_form.submit();">
                <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/s6.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['customsearchpage'] == "6"){ echo "border:2px solid red;";} ?>">
                </a>
                </div>                     
                
                 
            </div>
         <div class="row-fluid">

                <div class="span4 well pagination-centered">
                 <a href="javascript:void(0);" onclick="document.getElementById('itemcode').value='';document.getElementById('customsearchpage').value='7';document.admin_save_form.submit();">
                <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/s7.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['customsearchpage'] == "7"){ echo "border:2px solid red;";} ?>">
                </a>
                </div>
                
                <div class="span4 well pagination-centered">
                 <a href="javascript:void(0);" onclick="document.getElementById('itemcode').value='';document.getElementById('customsearchpage').value='8';document.admin_save_form.submit();">
                <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/s8.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['customsearchpage'] == "8"){ echo "border:2px solid red;";} ?>">
                </a>
                </div>                          
                
                
                <div class="span4 well pagination-centered">
                 <a href="javascript:void(0);" onclick="document.getElementById('itemcode').value='';document.getElementById('customsearchpage').value='10';document.admin_save_form.submit();">
                <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/s9.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['customsearchpage'] == "10"){ echo "border:2px solid red;";} ?>">
                </a>
                </div>   
                    </div>  
            </div>   
            
</div>        
            
        
          <?php do_action('hook_admin_2_tab4_left'); ?>
        </div>
        
        <?php } // hide admin search ?>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        <div class="tab-pane fade in <?php if(defined('WLT_HIDE_ADMIN_2_SEARCH') || (isset($_POST['subsubtab']) && $_POST['subsubtab'] == "pptab2" )){ echo "active"; }  ?>" id="pptab2">
        
        
        
    <?php
		$canShowListing = false;
		$selected_template = $core_admin_values['template']; 
		$HandlePath = TEMPLATEPATH;
	    $count=1; $TemplateString = "";
		if($handle1 = opendir($HandlePath)) {      
			while(false !== ($file = readdir($handle1))){			
				if(strpos($file,"single-listing-") !== false ){	
			 		
					$file_name = str_replace(".php","",str_replace("single-","",$file));
					$TemplateString .= "<option "; 
					if ($core_admin_values['single_layout'] == $file_name) { $TemplateString .= ' selected="selected"'; }   
					$TemplateString .= 'value="'.$file_name.'">'; 					
					$TemplateString .= $file; 										
					$TemplateString.= "</option>";			
   
				}
			}
			
		}
		
		if(strlen($TemplateString) > 5){
		?>      
<div class="well">
<h2>Choose a display file;</h2>

<div class="form-row control-group row-fluid">
                <label class="control-label span5">Listing Display File</label>
                <div class="controls span6">
                  <select name="admin_values[single_layout]" class="chzn-select" id="default_listing_status1">
                    <option value=""></option>                    
                    <option value="listing" <?php if(!isset($core_admin_values['single_layout']) || $core_admin_values['single_layout'] == "listing"){ echo "selected=selected"; } ?>>Use Custom Layout</option>   
                    
                  <?php echo $TemplateString; ?>
                                   
                  </select>
                </div>                
</div>
</div>

<?php } ?>  
        
        
<div <?php if($core_admin_values['single_layout'] != "listing" && $core_admin_values['single_layout'] != ""){ ?>style="display:none;" <?php } ?>>
 
        
        
           <div class="heading1">
           <?php if(get_option('wlt_reset_listingcode') != ""){ ?>
        <a href="javascript:void(0);" onclick="document.getElementById('listingcode').value='';document.getElementById('customlistingpage').value='9';document.admin_save_form.submit();" class="btn btn-info" style="float:right; margin-top:-5px;">
        Reset to default layout
        </a> 
        <?php } ?>
        
         <div class="btn-group" style="float:right; margin-top:-5px; margin-right:15px;">
              <button class="btn">Extra Options</button>
              <button class="btn dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu">
               <li><a href="javascript:void(0);" onclick="jQuery('#spbuts4').show();">Show Shortcodes</a></li>
              
               <li><a href="#SearchEditMod" data-toggle="modal"> How does it work?</a></li>
              </ul>
            </div> 
           
           Listing Page Layout</div>          
                                
           <p>Enter your own combination of html and shortcodes to customize the display of your listing page.</p>
           
           
           
           
               <div style="display:none;" id="spbuts4">
            <div class='well'>
			   <?php $btnArray = array(
               'ID' =>'post ID',
               'IMAGE' =>'display image',	
			   'IMAGES' =>'display image gallery', 
			   'TAB_IMAGES' =>'display image gallery within a tab', 
			   'FILES' =>'all media files', 
               'TITLE' =>'title with link to listing page',
               'TITLE-NOLINK' =>'title without link',
               'EXCERPT' =>'short content',
               'BUTTON' =>'more info button',
               'DATE' =>' listing creation date',
               'AUTHOR' =>'author',
               'CATEGORY' =>'category',
               'LISTINGSTATUS' =>'listing status',
               'LOCATION' =>'listing location',
               'AUTHORIMAGE' =>'author image',
               'AUTHORIMAGE-CIRCLE' =>'author image with circular background',
               'TIMESINCE' =>'',
               'RATING' =>'star rating',
			   
			   'SOCIAL' =>'social buttons',
			   'GOOGLEMAP' =>'Google Map',
			   'RATING' =>'Star Rating',
			   'FAVS' =>'Add/Remove from favourites',
			   'FIELDS' =>'custom fields',
			   'TOOLBOX' =>'small box with a few items',
			   'TOOLBAR' =>'bar with category and tags',
			   'RELATED' =>'related items',
			   'CONTACT' =>'contact form',
			   'COMMENTS' =>'comments form',						     
				   
               ); 
			   
			   if(defined('WLT_COUPON')){			   
			   $btnArray = array_merge($btnArray,array('COUPON' => 'displays the coupon with click to copy','CBUTTON' => 'shows pop-up button','COUPON_START' => 'shows start date of the coupon', 'COUPON_END' =>'shows expiry date of coupon', 'STORE' => 'shows store name and link'));
			   }
			   
               foreach( $btnArray as $k => $b){
                echo "<a href='javascript:void(0);' onclick=\"AddthisShortC('".$k."','listingcode');\" class='btn' style='margin-right:10px; margin-bottom:5px;' rel='tooltip' data-original-title='".$b."' data-placement='bottom'>".$k."</a>";
               }
               
               ?>
               
               <?php do_action('hook_admin_2_tags_listing'); ?>
               
           <hr />
           <a href="javascript:void(0);" onclick="jQuery('#spbuts4').hide();" class="label">Hide Shortcodes</a>
           </div>
           </div>
        
           
          
        <textarea class="row-fluid" id="listingcode" style="height:300px;background:#E8FDE9" name="admin_values[listingcode]"><?php echo stripslashes($core_admin_values['listingcode']); ?></textarea>
        <input type="hidden" name="admin_values[customlistingpage]" id="customlistingpage" value="<?php echo $core_admin_values['customlistingpage']; ?>" />
        
    
            
            
            </div> 
        
        
        
        </div>
        
        
        <!--------- -->
        <div class="tab-pane fade in <?php if(isset($_POST['subsubtab']) && $_POST['subsubtab'] == "pptab3"){ echo "active"; } ?>" id="pptab3">       
        <div class="heading1">Print Page Layout</div>
        <p>Enter your own combination of html and PremiumPress shortcodes to achieve your desired layout.</p>  
          <?php  if(!isset($core_admin_values['printcode']) || (isset($core_admin_values['printcode']) && $core_admin_values['printcode'] == "") ){  
          $core_admin_values['printcode'] = '<div class="center">
            <p id="postTitle">[TITLE-NOLINK]</p>
            <p id="postMeta">Date:<strong>[DATE]</strong>  </p>
            <p id="postLink">[LINK]</p>   
            <div id="postContent">[CONTENT]</div>     
            <div id="postFields">[FIELDS]</div>
            <p id="printNow"><a href="#print" onClick="window.print(); return false;" title="Click to print">Print</a></p>
            </div>';}?>
        <textarea class="row-fluid" id="printpagecode" name="admin_values[printcode]" style="height:400px;background:#E8FDE9"><?php echo stripslashes($core_admin_values['printcode']); ?></textarea>
        </div>
        
        
        <!--------- -->
        <div class="tab-pane fade in" id="pptab4">
         <div class="heading1">No Access Layout</div>
         <p>Here you can enter your own combination of html and PremiumPress shortcodes to create the display a user will see when they do not membership access to view a listing.</p>          
          <?php  if(!isset($core_admin_values['noaccesscode']) || (isset($core_admin_values['noaccesscode']) && $core_admin_values['noaccesscode'] == "") ){
          $core_admin_values['noaccesscode'] = '<div class="well">
<i class="fa fa-ban" style="color:red;font-size:100px;float:left; margin-right:40px;"></i>
<div class="center"><h1 style="margin-top:0px;">No Access</h1><h3>Sorry your membership level prevents access to this listing.</h3>
<p>Please upgrade your membership to gain access to this page.</p>
</div></div>';}?>
          <textarea class="row-fluid" id="printpagecode" name="admin_values[noaccesscode]" style="height:400px;background:#E8FDE9"><?php echo stripslashes($core_admin_values['noaccesscode']); ?></textarea>        
        </div>
        <!--------- -->
        
    </div>
</div> 
    

</div>
<!--------------------------- LANGUAGE TAB ---------------------------->


 <?php if(!defined('ADMIN_HIDE_HOMEPAGE')){ ?>
  <script type="application/javascript">

jQuery(function() {
 	
	 	
	jQuery( "#dragable_col1" ).droppable({
			accept: "#wlt_widget_list li",
            drop: function( event, ui ) {		
			
			// MAKE A UNIQUE REFERENCE ID FOR THIS OBJECT
			var refid = jQuery('#wlt_objectscounter').val();
			jQuery('#wlt_objectscounter').val(parseFloat(refid)+1);

			// LETS ADD THE ITEM ID TO THE COLUMN HIDDEN FIELD
			jQuery( "<li class='external-event widget' id='"+ui.draggable.attr("id")+"_"+refid+"'></li>" ).html( '<i class="icon-signin"></i>'+ui.draggable.text() ).appendTo( this );
	 
			// NOW LETS GET A LIST OF IDS FROM THE COLUMN BOX AND SAVE IT
			UpdateFieldObject();
            }
     });
	 
	 jQuery( "#dragable_col1" ).sortable({ 
		revert: true ,	
		update: function (event, ui) {
            var currPos2 = ui.item.index();
			UpdateFieldObject();
        }
	});
	
	 	
	jQuery("#wlt_widget_list li" ).draggable({
           // containment: "#containment-wrapper",
            revert: "invalid", // when not dropped, the item will revert back to its initial position
            containment: "document",
            cursor: "move",
			connectToSortable: "#dragable_col",
            helper: "clone",
     });	
	
	
	// REMOVE ITEM WHEN DRAGGED BACK TO THE MAIN LIST
	jQuery( "#wlt_widget_list_remove" ).droppable({	
		accept: "#dragable_col1 li",
	 	drop: function( event, ui ) {		
         		ui.draggable.fadeOut();				
				jQuery("#dragable_col1_hidden").val(jQuery("#dragable_col1_hidden").val().replace(ui.draggable.attr('id'), ''));				
           }	
	}); 
	
	function UpdateFieldObject(){
	
		var liIds = jQuery('#dragable_col1 li').map(function(i,n) { 
		 
			if( jQuery(n).attr('id') == "undefined" ){				 
				return "";
			} else {
				return jQuery(n).attr('id')+'-'+jQuery(n).text();
			}
		}).get().join(',');				 
		
		jQuery("#dragable_col1_hidden").val(liIds);
	
	} 
	 
});
function AddObj(oid, text){

	// MAKE A UNIQUE REFERENCE ID FOR THIS OBJECT
	var refid = jQuery('#wlt_objectscounter').val();
	jQuery('#wlt_objectscounter').val(parseFloat(refid)+1);

	// LETS ADD THE ITEM ID TO THE COLUMN HIDDEN FIELD
	jQuery( "<li class='external-event widget' id='"+oid+"_"+refid+"'></li>" ).html( '<i class="icon-signin"></i>'+text ).appendTo( '#dragable_col1' );
	
	// NOW LETS GET A LIST OF IDS FROM THE COLUMN BOX AND SAVE IT
	var liIds = jQuery('#dragable_col1 li').map(function(i,n) { 		 
			if( jQuery(n).attr('id') == "undefined" ){				 
					return "";
			} else {
				return jQuery(n).attr('id'); //-'+jQuery(n).text()
			}
		}).get().join(',');				 
		
		jQuery("#dragable_col1_hidden").val(liIds);	
		document.admin_save_form.submit();
	}
function objRemoveMe(me){
	jQuery("#dragable_col1_hidden").val(jQuery("#dragable_col1_hidden").val().replace(me, ''));
	document.admin_save_form.submit();
	
	}
</script>


































<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "homepage"){ echo "active in"; } ?>" id="homepage">

<div class="row-fluid">
<div class="span12"> 

<div class="content">

<ul id="tabExample1" class="nav nav-tabs">
<li class="active"><a href="#home_layout1" data-toggle="tab" onclick="document.getElementById('ShowSubTab').value='home_layout1';">Display Setup</a></li>         

 <li><a href="#home_popular" data-toggle="tab" onclick="document.getElementById('ShowSubTab').value='home_popular';">Popular Layouts</a></li>        

</ul>

<div class="tab-content" style="min-height:500px;">
<?php 
 // DONT SHOW HOME PAGE OPTIONS IF ALREADY SET WITHIN CHILD THEME
 if(file_exists(THEME_PATH."/templates/".$core_admin_values['template']."/_homepage.php") || file_exists(WP_CONTENT_DIR."/themes/".CHILD_THEME_NAME."/_homepage.php")){ 

?>


<div class="alert alert-info">
<h4 style="color:#206E94;font-weight:bold;">Child theme home page detected</h4>
<p>Your child theme has its own _homepage.php file and therefore the core theme functions are disabled. </p>
<p> If you wish to use the core theme homepage functionality, please delete the _homepage.php file from your child theme.</p>
</div>

<?php }else{ ?>
<?php do_action('hook_admin_2_homepage_subcontent'); ?> 



<div class="tab-pane fade in <?php if(isset($_POST['tab']) && $_POST['tab'] == "home_popular"){ echo "active in"; } ?>" id="home_popular">
  
	<p><b class="label label-info">Popular Layouts</b> Click any layout below to setup the home page with the selected layout.</p> 
 
   <div class="row-fluid">
          <div class="span3 well  pagination-centered">
            <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=2&prelayout=1&tab=homepage">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/a1.png" style="border:1px solid #ccc; padding:4px;background:#fff;">
            </a>                 
            </div>
            <div class="span3 well pagination-centered"> 
            <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=2&prelayout=2&tab=homepage">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/a2.png" style="border:1px solid #ccc; padding:4px;background:#fff;">
            </a>           
            </div>      
            <div class="span3 well pagination-centered">   
            <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=2&prelayout=3&tab=homepage">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/a3.png" style="border:1px solid #ccc; padding:4px;background:#fff;">
            </a>
            </div>            
            <div class="span3 well pagination-centered">   
            <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=2&prelayout=4&tab=homepage">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/a4.png" style="border:1px solid #ccc; padding:4px;background:#fff;">
            </a>
            </div>             
		</div>


    <hr />
    <button type="button" class="btn btn-info" onclick="jQuery('#widgetobject11').attr('name','widgetobject');document.getElementById('dragable_col1_hidden').value='';document.getElementById('widgetblock1_backup').value='';document.admin_save_form.submit();">Reset All Objects</button>

 
</div><!-- end tab -->


<div class="tab-pane fade in <?php if(isset($_POST['tab']) && $_POST['tab'] == "home_object"){ echo "active in"; } ?>" id="home_reset">


</div>


<div class="tab-pane fade in <?php if(!isset($_POST['subtab']) || ( isset($_POST['subtab']) && $_POST['subtab'] == "" ) ||( isset($_POST['subtab']) && $_POST['subtab'] == "home_layout1" )){ echo "active"; } ?>" id="home_layout1">
 
 <a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('yP3e5krJIW8','videoboxplayer','479','350');" style="float:right; margin-right:5px;">Watch Video</a>
<p><span class="label label-info">Remember</span> Click or drag any object below to add it to your home page.</p>
<hr />
 
<?php do_action('hook_object_settings'); ?>
 
<div class="row-fluid">
 
<div class="span7">





<style>

.accordion-heading { border-color: #dddddd;  
 background: #f7f7f7;
border: 1px solid transparent;
border-radius: 4px;
-webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05); }

.accordion-heading a { color:#269ccb; font-weight:bold; }
   
.collapse.in {
height: auto;
overflow:visible !important;
}

 
</style>  


<!-- WIDGET LIST BOX -->
<div  id="wlt_widget_list">

<?php 

$object_listtypes = hook_object_listtypes(
array(

//'section' => array("n" => "Section Blocks"),


'slider' => array("n" => "Sliders"),

'head' => array("n" => "Top Elements"),

'content' => array("n" => "Content Elements"),

'text' => array("n" => "Text Blocks"),

'cols2' => array("n" => "2 Column Text Blocks"),

'cols3' => array("n" => "3 Column Text Blocks"),

'cols4' => array("n" => "4 Column Text Blocks"),

'search' => array("n" => "Search Blocks"),

'footer' => array("n" => "Bottom Elements"),

'image' => array("n" => "Image Placement Blocks"),

'' => array("n" => "Everything Else"),



));
$object_items = hook_object_list(array()); 

foreach($object_listtypes as $tk => $type){ ?>


  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#wlt_widget_list" href="#collapse<?php echo $tk; ?>">
      <img src="<?php echo get_template_directory_uri(); ?>/framework/img/a3.png" style="float:right;margin-top:3px;">
        <?php echo $type['n']; ?>
      </a>
    </div>
    <div id="collapse<?php echo $tk; ?>" class="accordion-body collapse">
      <div class="accordion-inner">
      <ul>
      <?php
 
	foreach($object_items as $item){
	
	// ADD IN SLIDER
	if($tk == "slider" && !isset($REVSERT) ){ 
		$REVSERT = true;
		if(isset($GLOBALS['WLT_REVSLIDER'])  ){ 	
		
		}else{	
		
		echo '<li class="external-event1 span6" style="background:#fff; border:1px dashed #666;">
	
		<a href="'.home_url().'/wp-admin/plugin-install.php?tab=plugin-information&plugin=wlt_revslider&TB_iframe=true&width=640&height=799" target="_blank"> <span class="title">Revolution Slider</span> <span class="desc">Download this plugin here.</span></a> 
		
		</li> ';
		
		}
	}// END SLIDER
	
	
	
	
	if($item['type'] !=  $tk){ continue; } 
	 	 
		if(strpos($item['icon'],"http") !== false){ 
		$iig = $item['icon'];
		}else{
		$iig = FRAMREWORK_URI."/admin/img/core/preview/".$item['icon'];
		}
		echo "<li id='".$item['id']."' class='external-event1 span6'> 
		<img src='".$iig."' class='previewobject'>
		<a href=\"javascript:void(0);\" onclick=\"AddObj('".$item['id']."', '".$item['name']."');\">  <span class='title'>".$item['name']."</span> <span class='desc'>".$item['desc']."</span> </a>
		</li>"; 
	$newrefid++;
	} 
	
	
	?>
    </ul>
    <div class="clearfix"></div>
    
     </div>
    </div>
  </div>
    <?php
	
}
?>
 

</ul><div class="clearfix"></div>
</div> 
<!-- END WIDGET LIST BOX -->
</div>
 
<div class="span5">

<?php
function getObjectName($object_items, $key ){
	foreach($object_items as $obj){
		if($obj['id'] == $key){ return $obj['name']; }
	}
}
// CALCULATE THE DEFAULT ITEMS WITHIN EACH ARRAY
$block1 	= explode(",",$core_admin_values['homepage']['widgetblock1']);
$blockdata 	= $core_admin_values['widgetobject'];
$EXPORTSTRING = "";
$block1_string = "";
$block1_string_formatted = ""; 
$v=1; 
 
foreach($block1 as $key => $it){
	
	// BREAK UP THE STRING				
	$ff 		= explode("_",$it);						
	$gg 		= explode("-", $ff[1]);
	$nkey		= $ff[0];
	$nrefid 	= $gg[0];
	$nvalue 	= $gg[1];
	
	// CHECK IF ITS INLINE OR FULL WITH
	$kk = $blockdata[$nkey][$nrefid]['fullw'];
	if($kk == "yes"){ 
	$fwt = "<i class='gicon-align-justify' rel='tooltip' data-original-title='Full Width' data-placement='top'></i>"; 
	}elseif($kk == "no"){ 
	$fwt = "<i class='gicon-indent-left' rel='tooltip' data-original-title='Inline' data-placement='top'></i>"; 	
	}elseif($kk == "underheader"){ 
	$fwt = "<i class='gicon-fullscreen' rel='tooltip' data-original-title='Under Header' data-placement='top'></i>"; 	
	
	
	}else{ 
	$fwt = "<i class='gicon-flag' rel='tooltip' data-original-title='Object Not Setup' data-placement='top'></i>";   
	}
	// MAKE SURE THE OBJECT IS VALID BY CHECKING ITS NAME
	$objectName = getObjectName($object_items,$nkey);

	if($objectName != ""){ 
	
	$block1_string .= "<li id='".$nkey."_".$nrefid."' class='external-event widget objid".$nkey.$v."'><a href=\"javascript:void(0);\" onclick=\"objRemoveMe('".$nkey."_".$nrefid."');jQuery('.objid".$nkey.$v."').hide();\" class='removesobg'>&nbsp;&nbsp;</a>".$fwt."
	<a href=\"JavaScript:void(0);\" onclick=\"jQuery('#ObjOptions_".$nrefid."').show();\"><span class='settingsobg'>&nbsp;&nbsp;</span></a>".$objectName."</li>"; 
	
	// FORMAT FOR SAVING
	$block1_string_formatted .= $nkey."_".$nrefid.","; 
	
	
		
	
	}// end if
	$v++;
}// end foreach
$block1_string_formatted = rtrim(preg_replace("/[^[:space:]a-zA-Z0-9-,_-]/e", "",$block1_string_formatted));
 
?>         
<div class="row-fluid">          
<img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/mm.png" />                    
<ul id="dragable_col1" class=" span12" style="min-height:300px;width:347px;border:1px solid #ddd;margin-left:0px;padding:20px;margin-bottom:20px;background:#fff;"><?php echo $block1_string; ?></ul>  
</div>

<p><i class='gicon-flag'></i> Objects Not Setup<br />
<i class='gicon-indent-left'></i> Inline <br />
<i class='gicon-align-justify'></i> Full Width  <br />
<i class='gicon-fullscreen'></i> Under Header
</p>  
 
 
</div>
 
</div>
<hr />
<p><label class="label label-warning">Remember</label> Full width objects will always appear above inline content on your home page. <label class="label label-info">Info</label> For all HTML codes visit the <a href="http://getbootstrap.com/" target="_blank" style="text-decoration:underline;">bootstrap website.</a></p>

 
<textarea style="display:none;" name="admin_values[homepage][widgetblock1]" type="hidden" id="dragable_col1_hidden" /><?php echo $block1_string_formatted; ?></textarea> 
<input name="widgetblock1_backup" type="hidden" id="widgetblock1_backup" value="<?php echo $block1_string_formatted; ?>" /> 
<input name="widgetobject11" id="widgetobject11" type="hidden" value="" /> 
<input name="adminArray[wlt_objectscounter]" id="wlt_objectscounter" type="hidden" value="<?php $cc = get_option('wlt_objectscounter'); if($cc == ""){ echo 0; }else{ echo $cc; } ?>" />  
 
 
 </div><!-- end inner tab 1 -->
 
 
</div><!-- end inner tab 1 -->



<?php }// END IF HOME PAGE IS PRESENT ?>


 




</div>



  


</div>

  

    </div>
</div>
 <?php } ?>
 
  <!--------------------------- EXPORT ALL DATA END ---------------------------->
 

 
</div>

<!-- start save button -->
<div class="form-actions row-fluid">
<div class="span7 offset5">
<button type="submit" class="btn btn-primary">Save Changes</button> 
</div>
</div> 
<!-- end save button -->
</div><!-- end home page panel -->
  
 <!--------------------------- LANGUAGE TAB ---------------------------->
 



 
</div> <!-- end all tabs -->
     
    
      
 <input type="hidden" value="" name="imgIdblock" id="imgIdblock" />
<script type="text/javascript">

function ChangeImgBlock(divname){
document.getElementById("imgIdblock").value = divname;
} 


jQuery(document).ready(function() {
	
	window.restore_send_to_editor = window.send_to_editor;
	
	jQuery('.gicon-search').click(function() {
		window.send_to_editor = function(html) {	 
		 imgurl = jQuery('img',html).attr('src'); 
		 jQuery('#'+document.getElementById("imgIdblock").value).val(imgurl);
		 tb_remove();	 
		  window.send_to_editor = window.restore_send_to_editor;		  
		} 
	});
	
	jQuery('#insert-media-button').click(function() {
	window.send_to_editor = window.restore_send_to_editor;	
	});
	
});


</script>     
<script language="javascript" type="text/javascript" src="<?php echo get_bloginfo('template_url')."/framework/admin/"; ?>js/bootstrap-colorpicker.js"></script>      
      
 



<div id="SearchEditMod" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
              <h3 id="myModalLabel">Help</h3>
            </div>
            <div class="modal-body" style="min-height:400px;">
            
            
            <div class="accordion" id="accordion4">
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion4" href="#collapseOne2">
                     <span class="label label-success">How does this work?</span>
                    </a>
                  </div>
                  <div id="collapseOne2" class="accordion-body collapse in" >
                    <div class="accordion-inner" style="padding:10px;">
                    
                      <p>This great feature lets you customize the display content of your search results and listing page layouts.</p>
                      
                      <p>By entering your own combination of field codes, you can customize the display.</p>
                      
                      <p>Example: [IMAGE] [TITLE]  [EXCERPT]  [BUTTON] </p>
                      
                      
                    </div>
                  </div>
                </div>
               
                <div class="accordion-group">
                  <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion4" href="#collapseThree2">
                      <span class="label label-success">List of available custom fields</span>
                    </a>
                  </div>
                  <div id="collapseThree2" class="accordion-body collapse" style="height: 0px; ">
                    <div class="accordion-inner" style="padding:10px;">
                    
                      <p>Here is a list of all available wordpress custom fields;</p>
                     
                      
                      <?php echo $CORE->CUSTOMFIELDLIST('nono'); ?> 
                       
                    </div>
                  </div>
                </div> 
                  
</div>            
</div>
<style>
.colorpicker, #TB_window {
  z-index: 9999;
}
.mce_fullscreen { background:rgb(236, 168, 168); color:#fff; }
.wp-switch-editor, .tmce-active .switch-tmce, .html-active .switch-html { height:27px !important; }

.wp-editor-container iframe, .wp-editor-container textarea { min-height:500px !important;}
 

.previewobject { color:red; }
#preview{
	position:absolute;
	border:1px solid #ccc;
	background:#333;
	padding:5px;
	display:none;
	color:#fff;
	}
 
</style>
<script>

this.imagePreview = function(){	
	/* CONFIG */
		
		xOffset = 10;
		yOffset = 30;
		
		// these 2 variable determine popup's distance from the cursor
		// you might want to adjust to get the right result
		
	/* END CONFIG */
	jQuery(".previewobject").hover(function(e){	 
		
		jQuery("body").append("<p id='preview'><img src='"+ this.src +"' alt='Image preview' /></p>");								 
		jQuery("#preview")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("fast");						
    },
	function(){	
		jQuery("#preview").remove();
    });	
	jQuery("a.preview").mousemove(function(e){
		jQuery("#preview")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});			
};
// starting the script on page load
jQuery(document).ready(function(){
	imagePreview();
	
	
});


</script>
      
<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); ?>
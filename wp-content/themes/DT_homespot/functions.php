<?php
/* =============================================================================
  [BLUE PLANET] //  FUNCTIONS CHILD THEME
   ========================================================================== */

// TELL THE CORE THIS IS A CHILD THEME
define('WLT_CHILDTHEME',true);

// TT Functions
require_once('tt-lib/tt-functions.php');

// INCLUDE GOOGLE FONT
function _gf(){
echo "<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>";
}
add_action('wp_head','_gf');
 

// ADD IN NEW BREADCRUMNS
function _blank($c){ return ""; }
add_action('hook_breadcrumbs','_blank');

function _hook_header_after(){
echo "<div class='nbc'><div class='container'><div class='row'>"._design_breadcrumbs()."</div></div></div>";
}
add_action('hook_header_after','_hook_header_after');

// CHILD THEME ACTIVATION

function childtheme_designchanges(){
		$defaultcode = '<div class="panel panel-default">
            <div class="panel-heading"><h3>Box Headline</h3></div>
            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis pharetra varius quam sit amet vulputate. 
            Quisque mauris augue, molestie tincidunt condimentum vitae, gravida a libero. Aenean sit amet felis 
            dolor, in sagittis nisi. Sed ac orci quis tortor imperdiet venenatis. Duis elementum auctor accumsan. 
            Aliquam in felis sit amet augue.
            </div></div>'; 
	
	// LOAD IN CORE STYLES AND UNSET THE LAYOUT ONES SO OUR CHILD THEME DEFAULT OPTIONS CAN WORK
	$core_admin_values = get_option("core_admin_values"); 
		
		// SET HEADER
		$core_admin_values['layout_header'] = 1;
		// SET MENU
		$core_admin_values['layout_menu'] = 2;
		// SET COLUMNS
		$core_admin_values['layout_columns'] = array('homepage' => '2', 'search' => '2', 'single' => '2', 'page' => '2', 'footer' => '3');
		// ADD IN CUSTOM WIDGET BLOCK
		$core_admin_values['widgetobject']["slider2"]["0"] = array(
			"fullw" => "yes",
		);
		$core_admin_values['slider2'] = array(
		"slider_item_1" => CHILD_THEME_PATH_IMG."demo1.jpg", /* 772 x 369 */
			"b2" => 'Headline',
			"b3" => 'my subtitle here',
				"b5" => 'Headline',
				"b6" => 'my subtitle here',
					"b8" => 'Headline',
					"b9" => 'my subtitle here'
		);			
		$core_admin_values['widgetobject']["3columns"]["1"] = array(
			"fullw" => "yes",
			"col1" => $defaultcode,
			"col2" => $defaultcode,
			"col3" => $defaultcode,
		);
		$core_admin_values['widgetobject']["recentlisting"]["2"] = array(
			"fullw" => "no",
			"title" => "Recently Added Listings",
			"query" => "orderby=rand&posts_per_page=8",
			"style" => "list"
		);
		$core_admin_values['homepage']['widgetblock1'] = 'slider2_0,3columns_1,recentlisting_2';
		// RETURN VALUES
		return $core_admin_values;
}
// FUNCTION EXECUTED WHEN THE THEME IS CHANGED
function _after_switch_theme(){
// GET DESIGN FROM FUNCTION
$core_admin_values = childtheme_designchanges();
// SAVE VALUES
update_option('core_admin_values',$core_admin_values);	
}
add_action('after_switch_theme','_after_switch_theme');

// DEMO MODE
if(defined('WLT_DEMOMODE')){
$GLOBALS['CORE_THEME'] = childtheme_designchanges();
}

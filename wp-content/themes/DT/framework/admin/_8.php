<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $CORE_ADMIN;
// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");
// DOWNLOAD SAMPLE CHILD THEME


// AUTO SAVE
if(!defined('WLT_DEMOMODE') && isset($_POST['shownewcode']) && $_POST['shownewcode'] == "save"){
update_option("custom_css", get_option("custom_css").DISPLAY_CUSTOM_COLORS()); 
} 

// LOAD IN GOOGLE FONTS
$fontsA = array(); 
$fontsA["anton"]['google'] = true;
$fontsA["anton"]['name'] = '"Anton", arial, serif';
$fontsA["arial"]['google'] = false;
$fontsA["arial"]['name'] = 'Arial, "Helvetica Neue", Helvetica, sans-serif'; 
$fontsA["arial_black"]['google'] = false;
$fontsA["arial_black"]['name'] = '"Arial Black", "Arial Bold", Arial, sans-serif';	 
$fontsA["arial_narrow"]['google'] = false;
$fontsA["arial_narrow"]['name'] = '"Arial Narrow", Arial, "Helvetica Neue", Helvetica, sans-serif'; 
$fontsA["cabin"]['google'] = true;
$fontsA["cabin"]['name'] = 'Cabin, Arial, Verdana, sans-serif'; 
$fontsA["cantarell"]['google'] = true;
$fontsA["cantarell"]['name'] = 'Cantarell, Candara, Verdana, sans-serif'; 
$fontsA["cardo"]['google'] = true;
$fontsA["cardo"]['name'] = 'Cardo, "Times New Roman", Times, serif'; 
$fontsA["courier_new"]['google'] = false;
$fontsA["courier_new"]['name'] = 'Courier, Verdana, sans-serif'; 
$fontsA["crimson_text"]['google'] = true;
$fontsA["crimson_text"]['name'] = '"Crimson Text", "Times New Roman", Times, serif'; 
$fontsA["cuprum"]['google'] = true;
$fontsA["cuprum"]['name'] = '"Cuprum", arial, serif'; 
$fontsA["dancing_script"]['google'] = true;
$fontsA["dancing_script"]['name'] = '"Dancing Script", arial, serif'; 
$fontsA["droid_sans"]['google'] = true;
$fontsA["droid_sans"]['name'] = '"Droid Sans", "Lucida Grande", Tahoma, sans-serif'; 
$fontsA["droid_mono"]['google'] = true;
$fontsA["droid_mono"]['name'] = '"Droid Sans Mono", Consolas, Monaco, Courier, sans-serif'; 
$fontsA["droid_serif"]['google'] = true;
$fontsA["droid_serif"]['name'] = '"Droid Serif", Calibri, "Times New Roman", serif'; 
$fontsA["georgia"]['google'] = false;
$fontsA["georgia"]['name'] = 'Georgia, "Times New Roman", Times, serif'; 
$fontsA["im_fell_dw_pica"]['google'] = true;
$fontsA["im_fell_dw_pica"]['name'] = '"IM Fell DW Pica", "Times New Roman", serif'; 
$fontsA["im_fell_english"]['google'] = true;
$fontsA["im_fell_english"]['name'] = '"IM Fell English", "Times New Roman", serif'; 
$fontsA["inconsolata"]['google'] = true;
$fontsA["inconsolata"]['name'] = '"Inconsolata", Consolas, Monaco, Courier, sans-serif'; 
$fontsA["inconsolata"]['google'] = true;
$fontsA["inconsolata"]['name'] = '"Josefin Sans Std Light", "Century Gothic", Verdana, sans-serif'; 
$fontsA["kreon"]['google'] = true;
$fontsA["kreon"]['name'] = "kreon, georgia,serif"; 
$fontsA["lato"]['google'] = true;
$fontsA["lato"]['name'] = '"Lato", arial, serif'; 
$fontsA["lobster"]['google'] = true;
$fontsA["lobster"]['name'] = 'Lobster, Arial, sans-serif'; 
$fontsA["lora"]['google'] = true;
$fontsA["lora"]['name'] = '"Lora", georgia, serif'; 
$fontsA["merriweather"]['google'] = true;
$fontsA["merriweather"]['name'] = 'Merriweather, georgia, times, serif'; 
$fontsA["molengo"]['google'] = true;
$fontsA["molengo"]['name'] = 'Molengo, "Trebuchet MS", Corbel, Arial, sans-serif';	 
$fontsA["nobile"]['google'] = true;
$fontsA["nobile"]['name'] = 'Nobile, Corbel, Arial, sans-serif'; 
$fontsA["ofl_sorts_mill_goudy"]['google'] = true;
$fontsA["ofl_sorts_mill_goudy"]['name'] = '"OFL Sorts Mill Goudy TT", Georgia, serif'; 
$fontsA["old_standard"]['google'] = true;
$fontsA["old_standard"]['name'] = '"Old Standard TT", "Times New Roman", Times, serif'; 
$fontsA["reenie_beanie"]['google'] = true;
$fontsA["reenie_beanie"]['name'] = '"Reenie Beanie", Arial, sans-serif'; 
$fontsA["tangerine"]['google'] = true;
$fontsA["tangerine"]['name'] = 'Tangerine, "Times New Roman", Times, serif'; 
$fontsA["times_new_roman"]['google'] = false;
$fontsA["times_new_roman"]['name'] = '"Times New Roman", Times, Georgia, serif'; 
$fontsA["trebuchet_ms"]['google'] = false;
$fontsA["trebuchet_ms"]['name'] = '"Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Arial, sans-serif'; 
$fontsA["verdana"]['google'] = false;
$fontsA["verdana"]['name'] = 'Verdana, sans-serif'; 
$fontsA["vollkorn"]['google'] = true;
$fontsA["vollkorn"]['name'] = 'Vollkorn, Georgia, serif'; 
$fontsA["yanone"]['google'] = true;
$fontsA["yanone"]['name'] = '"Yanone Kaffeesatz", Arial, sans-serif'; 
$fontsA["american_typewriter"]['google'] = false;
$fontsA["american_typewriter"]['name'] = '"American Typewriter", Georgia, serif'; 
$fontsA["andale"]['google'] = false;
$fontsA["andale"]['name'] = '"Andale Mono", Consolas, Monaco, Courier, "Courier New", Verdana, sans-serif'; 
$fontsA["baskerville"]['google'] = false;
$fontsA["baskerville"]['name'] = 'Baskerville, "Times New Roman", Times, serif'; 
$fontsA["bookman_old_style"]['google'] = false;
$fontsA["bookman_old_style"]['name'] = '"Bookman Old Style", Georgia, "Times New Roman", Times, serif'; 
$fontsA["calibri"]['google'] = false;
$fontsA["calibri"]['name'] = 'Calibri, "Helvetica Neue", Helvetica, Arial, Verdana, sans-serif'; 
$fontsA["cambria"]['google'] = false;
$fontsA["cambria"]['name'] = 'Cambria, Georgia, "Times New Roman", Times, serif'; 
$fontsA["candara"]['google'] = false;
$fontsA["candara"]['name'] = 'Candara, Verdana, sans-serif'; 
$fontsA["century_gothic"]['google'] = false;
$fontsA["century_gothic"]['name'] = '"Century Gothic", "Apple Gothic", Verdana, sans-serif'; 
$fontsA["century_schoolbook"]['google'] = false;
$fontsA["century_schoolbook"]['name'] = '"Century Schoolbook", Georgia, "Times New Roman", Times, serif'; 
$fontsA["consolas"]['google'] = false;
$fontsA["consolas"]['name'] = 'Consolas, "Andale Mono", Monaco, Courier, "Courier New", Verdana, sans-serif'; 
$fontsA["constantia"]['google'] = false;
$fontsA["constantia"]['name'] = 'Constantia, Georgia, "Times New Roman", Times, serif'; 
$fontsA["Corbel"]['google'] = false;
$fontsA["Corbel"]['name'] = 'Corbel, "Lucida Grande", "Lucida Sans Unicode", Arial, sans-serif'; 
$fontsA["franklin_gothic"]['google'] = false;
$fontsA["franklin_gothic"]['name'] = '"Franklin Gothic Medium", Arial, sans-serif'; 
$fontsA["garamond"]['google'] = false;
$fontsA["garamond"]['name'] = 'Garamond, "Hoefler Text", "Times New Roman", Times, serif'; 
$fontsA["gill_sans"]['google'] = false;
$fontsA["gill_sans"]['name'] = '"Gill Sans MT", "Gill Sans", Calibri, "Trebuchet MS", sans-serif'; 
$fontsA["helvetica"]['google'] = false;
$fontsA["helvetica"]['name'] = '"Helvetica Neue", Helvetica, Arial, sans-serif'; 
$fontsA["hoefler"]['google'] = false;
$fontsA["hoefler"]['name'] = '"Hoefler Text", Garamond, "Times New Roman", Times, sans-serif'; 
$fontsA["lucida_bright"]['google'] = false;
$fontsA["lucida_bright"]['name'] = '"Lucida Bright", Cambria, Georgia, "Times New Roman", Times, serif'; 
$fontsA["lucida_grande"]['google'] = false;
$fontsA["lucida_grande"]['name'] = '"Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif'; 
$fontsA["palatino"]['google'] = false;
$fontsA["palatino"]['name'] = '"Palatino Linotype", Palatino, Georgia, "Times New Roman", Times, serif'; 
$fontsA["rockwell"]['google'] = false;
$fontsA["rockwell"]['name'] = 'Rockwell, "Arial Black", "Arial Bold", Arial, sans-serif'; 
$fontsA["tahoma"]['google'] = false;
$fontsA["tahoma"]['name'] = 'Tahoma, Geneva, Verdana, sans-serif';
$GLOBALS['fontsA'] = $fontsA;
	

function DISPLAY_CUSTOM_COLORS(){ $STRING = ""; global $CORE; $GLOBALS['CORE_THEME'] = get_option("core_admin_values"); 
 
	// LOAD IN CUSTOMIZED ADMIN OPTIONS
	if(isset($GLOBALS['CORE_THEME']['colors'])){
	
	// GENERAL WEBSITE STYLES
	if(isset($GLOBALS['CORE_THEME']['colors']['font-family']) && strlen($GLOBALS['CORE_THEME']['colors']['font-family']) > 1){
	
	
$fontsA = array(); 
$fontsA["anton"]['google'] = true;
$fontsA["anton"]['name'] = '"Anton", arial, serif';
$fontsA["arial"]['google'] = false;
$fontsA["arial"]['name'] = 'Arial, "Helvetica Neue", Helvetica, sans-serif'; 
$fontsA["arial_black"]['google'] = false;
$fontsA["arial_black"]['name'] = '"Arial Black", "Arial Bold", Arial, sans-serif';	 
$fontsA["arial_narrow"]['google'] = false;
$fontsA["arial_narrow"]['name'] = '"Arial Narrow", Arial, "Helvetica Neue", Helvetica, sans-serif'; 
$fontsA["cabin"]['google'] = true;
$fontsA["cabin"]['name'] = 'Cabin, Arial, Verdana, sans-serif'; 
$fontsA["cantarell"]['google'] = true;
$fontsA["cantarell"]['name'] = 'Cantarell, Candara, Verdana, sans-serif'; 
$fontsA["cardo"]['google'] = true;
$fontsA["cardo"]['name'] = 'Cardo, "Times New Roman", Times, serif'; 
$fontsA["courier_new"]['google'] = false;
$fontsA["courier_new"]['name'] = 'Courier, Verdana, sans-serif'; 
$fontsA["crimson_text"]['google'] = true;
$fontsA["crimson_text"]['name'] = '"Crimson Text", "Times New Roman", Times, serif'; 
$fontsA["cuprum"]['google'] = true;
$fontsA["cuprum"]['name'] = '"Cuprum", arial, serif'; 
$fontsA["dancing_script"]['google'] = true;
$fontsA["dancing_script"]['name'] = '"Dancing Script", arial, serif'; 
$fontsA["droid_sans"]['google'] = true;
$fontsA["droid_sans"]['name'] = '"Droid Sans", "Lucida Grande", Tahoma, sans-serif'; 
$fontsA["droid_mono"]['google'] = true;
$fontsA["droid_mono"]['name'] = '"Droid Sans Mono", Consolas, Monaco, Courier, sans-serif'; 
$fontsA["droid_serif"]['google'] = true;
$fontsA["droid_serif"]['name'] = '"Droid Serif", Calibri, "Times New Roman", serif'; 
$fontsA["georgia"]['google'] = false;
$fontsA["georgia"]['name'] = 'Georgia, "Times New Roman", Times, serif'; 
$fontsA["im_fell_dw_pica"]['google'] = true;
$fontsA["im_fell_dw_pica"]['name'] = '"IM Fell DW Pica", "Times New Roman", serif'; 
$fontsA["im_fell_english"]['google'] = true;
$fontsA["im_fell_english"]['name'] = '"IM Fell English", "Times New Roman", serif'; 
$fontsA["inconsolata"]['google'] = true;
$fontsA["inconsolata"]['name'] = '"Inconsolata", Consolas, Monaco, Courier, sans-serif'; 
$fontsA["inconsolata"]['google'] = true;
$fontsA["inconsolata"]['name'] = '"Josefin Sans Std Light", "Century Gothic", Verdana, sans-serif'; 
$fontsA["kreon"]['google'] = true;
$fontsA["kreon"]['name'] = "kreon, georgia,serif"; 
$fontsA["lato"]['google'] = true;
$fontsA["lato"]['name'] = '"Lato", arial, serif'; 
$fontsA["lobster"]['google'] = true;
$fontsA["lobster"]['name'] = 'Lobster, Arial, sans-serif'; 
$fontsA["lora"]['google'] = true;
$fontsA["lora"]['name'] = '"Lora", georgia, serif'; 
$fontsA["merriweather"]['google'] = true;
$fontsA["merriweather"]['name'] = 'Merriweather, georgia, times, serif'; 
$fontsA["molengo"]['google'] = true;
$fontsA["molengo"]['name'] = 'Molengo, "Trebuchet MS", Corbel, Arial, sans-serif';	 
$fontsA["nobile"]['google'] = true;
$fontsA["nobile"]['name'] = 'Nobile, Corbel, Arial, sans-serif'; 
$fontsA["ofl_sorts_mill_goudy"]['google'] = true;
$fontsA["ofl_sorts_mill_goudy"]['name'] = '"OFL Sorts Mill Goudy TT", Georgia, serif'; 
$fontsA["old_standard"]['google'] = true;
$fontsA["old_standard"]['name'] = '"Old Standard TT", "Times New Roman", Times, serif'; 
$fontsA["reenie_beanie"]['google'] = true;
$fontsA["reenie_beanie"]['name'] = '"Reenie Beanie", Arial, sans-serif'; 
$fontsA["tangerine"]['google'] = true;
$fontsA["tangerine"]['name'] = 'Tangerine, "Times New Roman", Times, serif'; 
$fontsA["times_new_roman"]['google'] = false;
$fontsA["times_new_roman"]['name'] = '"Times New Roman", Times, Georgia, serif'; 
$fontsA["trebuchet_ms"]['google'] = false;
$fontsA["trebuchet_ms"]['name'] = '"Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Arial, sans-serif'; 
$fontsA["verdana"]['google'] = false;
$fontsA["verdana"]['name'] = 'Verdana, sans-serif'; 
$fontsA["vollkorn"]['google'] = true;
$fontsA["vollkorn"]['name'] = 'Vollkorn, Georgia, serif'; 
$fontsA["yanone"]['google'] = true;
$fontsA["yanone"]['name'] = '"Yanone Kaffeesatz", Arial, sans-serif'; 
$fontsA["american_typewriter"]['google'] = false;
$fontsA["american_typewriter"]['name'] = '"American Typewriter", Georgia, serif'; 
$fontsA["andale"]['google'] = false;
$fontsA["andale"]['name'] = '"Andale Mono", Consolas, Monaco, Courier, "Courier New", Verdana, sans-serif'; 
$fontsA["baskerville"]['google'] = false;
$fontsA["baskerville"]['name'] = 'Baskerville, "Times New Roman", Times, serif'; 
$fontsA["bookman_old_style"]['google'] = false;
$fontsA["bookman_old_style"]['name'] = '"Bookman Old Style", Georgia, "Times New Roman", Times, serif'; 
$fontsA["calibri"]['google'] = false;
$fontsA["calibri"]['name'] = 'Calibri, "Helvetica Neue", Helvetica, Arial, Verdana, sans-serif'; 
$fontsA["cambria"]['google'] = false;
$fontsA["cambria"]['name'] = 'Cambria, Georgia, "Times New Roman", Times, serif'; 
$fontsA["candara"]['google'] = false;
$fontsA["candara"]['name'] = 'Candara, Verdana, sans-serif'; 
$fontsA["century_gothic"]['google'] = false;
$fontsA["century_gothic"]['name'] = '"Century Gothic", "Apple Gothic", Verdana, sans-serif'; 
$fontsA["century_schoolbook"]['google'] = false;
$fontsA["century_schoolbook"]['name'] = '"Century Schoolbook", Georgia, "Times New Roman", Times, serif'; 
$fontsA["consolas"]['google'] = false;
$fontsA["consolas"]['name'] = 'Consolas, "Andale Mono", Monaco, Courier, "Courier New", Verdana, sans-serif'; 
$fontsA["constantia"]['google'] = false;
$fontsA["constantia"]['name'] = 'Constantia, Georgia, "Times New Roman", Times, serif'; 
$fontsA["Corbel"]['google'] = false;
$fontsA["Corbel"]['name'] = 'Corbel, "Lucida Grande", "Lucida Sans Unicode", Arial, sans-serif'; 
$fontsA["franklin_gothic"]['google'] = false;
$fontsA["franklin_gothic"]['name'] = '"Franklin Gothic Medium", Arial, sans-serif'; 
$fontsA["garamond"]['google'] = false;
$fontsA["garamond"]['name'] = 'Garamond, "Hoefler Text", "Times New Roman", Times, serif'; 
$fontsA["gill_sans"]['google'] = false;
$fontsA["gill_sans"]['name'] = '"Gill Sans MT", "Gill Sans", Calibri, "Trebuchet MS", sans-serif'; 
$fontsA["helvetica"]['google'] = false;
$fontsA["helvetica"]['name'] = '"Helvetica Neue", Helvetica, Arial, sans-serif'; 
$fontsA["hoefler"]['google'] = false;
$fontsA["hoefler"]['name'] = '"Hoefler Text", Garamond, "Times New Roman", Times, sans-serif'; 
$fontsA["lucida_bright"]['google'] = false;
$fontsA["lucida_bright"]['name'] = '"Lucida Bright", Cambria, Georgia, "Times New Roman", Times, serif'; 
$fontsA["lucida_grande"]['google'] = false;
$fontsA["lucida_grande"]['name'] = '"Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif'; 
$fontsA["palatino"]['google'] = false;
$fontsA["palatino"]['name'] = '"Palatino Linotype", Palatino, Georgia, "Times New Roman", Times, serif'; 
$fontsA["rockwell"]['google'] = false;
$fontsA["rockwell"]['name'] = 'Rockwell, "Arial Black", "Arial Bold", Arial, sans-serif'; 
$fontsA["tahoma"]['google'] = false;
$fontsA["tahoma"]['name'] = 'Tahoma, Geneva, Verdana, sans-serif';
	$GLOBALS['fontsA'] = $fontsA;
		 
			$FName = explode(",",$GLOBALS['fontsA'][$GLOBALS['CORE_THEME']['colors']['font-family']]['name']);
			
			if(isset($GLOBALS['fontsA'][$GLOBALS['CORE_THEME']['colors']['font-family']]['google'])){
			$STRING .= '</style><style type="text/css" id="dynamic-css">@import url(\'http://fonts.googleapis.com/css?v2&family='.str_replace('"',"",str_replace(' ',"+",$FName[0])).'\');
			h1, h2, h3, h4, h5, h6, #core_menu_wrapper .navbar-nav li > a, .header_style2 .navbar-nav > li > a { font-family:'.str_replace('"',"",$GLOBALS['fontsA'][$GLOBALS['CORE_THEME']['colors']['font-family']]['name']).' !important;} }</style><style type="text/css">';
			
			}else{
			 
			$STRING .= 'h1, h2, h3, h4, h5, h6, #core_menu_wrapper .navbar-nav li > a, .header_style2 .navbar-nav > li > a { font-family:'.$GLOBALS['fontsA'][$GLOBALS['CORE_THEME']['colors']['font-family']]['name'].' !important; }';
			
			}
		}
		 
		// GLOBAL STYLES
		if(isset($GLOBALS['CORE_THEME']['colors']['body']) && strlen($GLOBALS['CORE_THEME']['colors']['body']) > 1){
			$STRING .= "body { background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['body'])."; border:0px; }";	
			$STRING .= "\n";	
		}
		
		// core_padding
		if(isset($GLOBALS['CORE_THEME']['colors']['core_padding']) && strlen($GLOBALS['CORE_THEME']['colors']['core_padding']) > 1){
			$STRING .= "#core_padding .container { background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['core_padding'])."; }";	
			$STRING .= "\n";	
		}
		
		
		// GLOBAL STYLES
		if(isset($GLOBALS['CORE_THEME']['colors']['body_text']) && strlen($GLOBALS['CORE_THEME']['colors']['body_text']) > 1){
			$STRING .= "body,a { color:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['body_text']).";}";
			$STRING .= "\n";
		}
		if(isset($GLOBALS['CORE_THEME']['colors']['button']) && strlen($GLOBALS['CORE_THEME']['colors']['button']) > 1){
			$STRING .= ".btn-primary, .core_advanced_search_form .btn, .btn-primary:focus, .btn-primary:hover, .wlt_search_results.list_style .btn, .wlt_search_results.grid_style .btn, .btn.btn-primary { background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['button'])."; border-color:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['button']).";";
			
			if(isset($GLOBALS['CORE_THEME']['colors']['button_text']) && strlen($GLOBALS['CORE_THEME']['colors']['button_text']) > 1){
			$STRING .= " color: ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['button_text'])." !important;";
			}else{
			$STRING .= " color: #fff;";			
			}
			$STRING .= " text-shadow: 0 0px 0px #fff;}";
			$STRING .= "\n";
		}
		
		
		// BREADCRUMBS
		if(isset($GLOBALS['CORE_THEME']['colors']['breadcrumbs']) && strlen($GLOBALS['CORE_THEME']['colors']['breadcrumbs']) > 1){
			$STRING .= "#core_main_breadcrumbs_wrapper .btn-default,  { background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['breadcrumbs']).";}";
			$STRING .= ".btn-breadcrumb .btn.btn-default:not(:last-child):after {border-left: 10px solid ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['breadcrumbs']).";}";	
			$STRING .= "\n";
		}	 
		if(isset($GLOBALS['CORE_THEME']['colors']['breadcrumbs_text']) && strlen($GLOBALS['CORE_THEME']['colors']['breadcrumbs_text']) > 1){
			$STRING .= "#core_main_breadcrumbs_wrapper .btn-default, #core_main_breadcrumbs_wrapper .btn-default a { color:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['breadcrumbs_text']).";} .breadcrumb li {text-shadow: 0 0px 0 white;}";
			$STRING .= "\n";
		}	
		if(isset($GLOBALS['CORE_THEME']['colors']['header']) && strlen($GLOBALS['CORE_THEME']['colors']['header']) > 1){
			$STRING .= "header { background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['header'])."; border:0px; } #core_header { background:transparent; }";
			$STRING .= "\n";
		}
		
		// NAVIGATION STYLES 
		if(isset($GLOBALS['CORE_THEME']['colors']['topnav']) && strlen($GLOBALS['CORE_THEME']['colors']['topnav']) > 1){
			$STRING .= "#core_header_navigation { background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['topnav'])."; border:0px; }";
			$STRING .= "\n";
		}
		if(isset($GLOBALS['CORE_THEME']['colors']['topnav_link']) && strlen($GLOBALS['CORE_THEME']['colors']['topnav_link']) > 1){
			$STRING .= "#core_header_navigation .nav > li a { color:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['topnav_link']).";}";
			$STRING .= "\n";
		}
		if(isset($GLOBALS['CORE_THEME']['colors']['topnav_welcome']) && strlen($GLOBALS['CORE_THEME']['colors']['topnav_welcome']) > 1){
			$STRING .= "#core_header_navigation .welcometext { color:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['topnav_welcome']).";}";
			$STRING .= "\n";
		}
		if(isset($GLOBALS['CORE_THEME']['colors']['menubar']) && strlen($GLOBALS['CORE_THEME']['colors']['menubar']) > 1){
			$STRING .= "#core_menu_wrapper .row, #wlt_smalldevicemenubar a.b1 { background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['menubar'])."; } ";		
			$STRING .= "\n";
		}
		if(isset($GLOBALS['CORE_THEME']['colors']['menubar_small']) && strlen($GLOBALS['CORE_THEME']['colors']['menubar_small']) > 1){
			$STRING .= "#wlt_smalldevicemenubar a.b1 { background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['menubar_small'])."; } ";		
			$STRING .= "\n";
		}	
		
		if(isset($GLOBALS['CORE_THEME']['colors']['menubar_hover']) && strlen($GLOBALS['CORE_THEME']['colors']['menubar_hover']) > 1){
			$STRING .= "#core_menu_wrapper .navbar-nav li:hover { background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['menubar_hover'])."; } ";		
			$STRING .= "\n";
		}		
		if(isset($GLOBALS['CORE_THEME']['colors']['menubar_link']) && strlen($GLOBALS['CORE_THEME']['colors']['menubar_link']) > 1){
			$STRING .= ".header_style2 .navbar-nav > li > a, #core_menu_wrapper .navbar-nav li > a { color:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['menubar_link']).";}";
			$STRING .= "\n";
		}
		if(isset($GLOBALS['CORE_THEME']['colors']['menubar_br']) && strlen($GLOBALS['CORE_THEME']['colors']['menubar_br']) > 1){
			$STRING .= "#core_menu_wrapper .navbar-nav > li { border-right: 1px solid ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['menubar_br']).";}";
			$STRING .= "\n";
		}
		if(isset($GLOBALS['CORE_THEME']['colors']['menubar_bl']) && strlen($GLOBALS['CORE_THEME']['colors']['menubar_bl']) > 1){
			$STRING .= "#core_menu_wrapper .navbar-nav > li { border-left: 1px solid ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['menubar_bl']).";}";
			$STRING .= "\n";
		}		
		if(isset($GLOBALS['CORE_THEME']['colors']['menubar_linksub']) && strlen($GLOBALS['CORE_THEME']['colors']['menubar_linksub']) > 1){
			$STRING .= ".header_style2 .navbar-nav > li .dropdown-menu > li > a, #core_menu_wrapper .navbar-nav .dropdown-menu > li > a { color:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['menubar_linksub'])."; }";
			$STRING .= "\n";
		}
		if(isset($GLOBALS['CORE_THEME']['colors']['menubar_searchbg']) && strlen($GLOBALS['CORE_THEME']['colors']['menubar_searchbg']) > 1){
			$STRING .= ".wlt_searchbox input { background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['menubar_searchbg'])."; }";
			$STRING .= "\n";
		}		
		if(isset($GLOBALS['CORE_THEME']['colors']['menubar_searchicon']) && strlen($GLOBALS['CORE_THEME']['colors']['menubar_searchicon']) > 1){
			$STRING .= ".wlt_searchbox .wlt_button_search { color:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['menubar_searchicon'])."; }";
			$STRING .= "\n";
		}			
		
				
		// ADVANCED SEARCH
		if(isset($GLOBALS['CORE_THEME']['colors']['adsearch']) && strlen($GLOBALS['CORE_THEME']['colors']['adsearch']) > 1){
			$STRING .= "#HomeMainBanner, #core_advanced_search_widget_box .block-title,#core_advanced_search_widget_box .block-content,#core_advanced_search { background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['adsearch']).";}";
			$STRING .= "\n";
		}
		if(isset($GLOBALS['CORE_THEME']['colors']['adsearch_text']) && strlen($GLOBALS['CORE_THEME']['colors']['adsearch_text']) > 1){
			$STRING .= "#HomeSearchForm, #HomeSearchForm h3, #core_advanced_search_widget_box .block-title,#core_advanced_search_widget_box .block-content,#core_advanced_search, #core_advanced_search_form {color:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['adsearch_text']).";}";
			$STRING .= "\n";
		}	
				
		// FOOTER STYLES
		if(isset($GLOBALS['CORE_THEME']['colors']['footer']) && strlen($GLOBALS['CORE_THEME']['colors']['footer']) > 1){
			$STRING .= "#core_footer_wrapper, #footer_content { background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['footer'])."; border:0px; }";
			$STRING .= "\n";
		}
		if(isset($GLOBALS['CORE_THEME']['colors']['footer_text']) && strlen($GLOBALS['CORE_THEME']['colors']['footer_text']) > 1){
			$STRING .= "#core_footer_wrapper, #footer_content, #core_footer_wrapper h3 { color:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['footer_text']).";}";
			$STRING .= "\n";
		}		
 
		if(isset($GLOBALS['CORE_THEME']['colors']['copyright']) && strlen($GLOBALS['CORE_THEME']['colors']['copyright']) > 1){
			$STRING .= "#footer_bottom, #footer_bottom .container { background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['copyright'])."; border:0px; }";
			$STRING .= "\n";
		}	
		if(isset($GLOBALS['CORE_THEME']['colors']['copyright_text']) && strlen($GLOBALS['CORE_THEME']['colors']['copyright_text']) > 1){
			$STRING .= "#footer_bottom .container, #footer_bottom .container a { color:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['copyright_text']).";}";
			$STRING .= "\n";
		}		
		// CONTENT STYLES
		if(isset($GLOBALS['CORE_THEME']['colors']['box_bg']) && strlen($GLOBALS['CORE_THEME']['colors']['box_bg']) > 1){
			$STRING .= ".panel-default > .panel-heading { border:0px; background-color:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['box_bg']).";}";
			$STRING .= "\n";
		}
		if(isset($GLOBALS['CORE_THEME']['colors']['box_bg_text']) && strlen($GLOBALS['CORE_THEME']['colors']['box_bg_text']) > 1){
			$STRING .= ".panel-default > .panel-heading {text-shadow: 0 0px 0 white; color:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['box_bg_text']).";}";
			$STRING .= "\n";
		}	 			
		if(isset($GLOBALS['CORE_THEME']['colors']['box_body']) && strlen($GLOBALS['CORE_THEME']['colors']['box_body']) > 1){
			$STRING .= ".panel  { background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['box_body']).";}";
			$STRING .= "\n";
		}
		if(isset($GLOBALS['CORE_THEME']['colors']['box_body_text']) && strlen($GLOBALS['CORE_THEME']['colors']['box_body_text']) > 1){
			$STRING .= ".panel, .panel a {color:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['box_body_text']).";}";
			$STRING .= "\n";
		} 
		if(isset($GLOBALS['CORE_THEME']['colors']['box_border']) && strlen($GLOBALS['CORE_THEME']['colors']['box_border']) > 1){
			$STRING .= ".panel-default, #map_carousel {border: 1px solid ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['box_border']).";}";
			$STRING .= "\n";
		} 	
		
		// FEATURED LISTINGS
		if(isset($GLOBALS['CORE_THEME']['colors']['featured']) && strlen($GLOBALS['CORE_THEME']['colors']['featured']) > 1){
		$STRING .= ".itemdata.featured .thumbnail { color: ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['featured_text'])."; background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['featured'])." !important; border-color: #d6e9c6; }
		.itemdata.featured .thumbnail .caption { color: ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['featured_text'])."; }";
		if(isset($GLOBALS['CORE_THEME']['colors']['featured_text']) && strlen($GLOBALS['CORE_THEME']['colors']['featured_text']) > 1){
		$STRING .= ".itemdata.featured .thumbnail a { color: ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['featured_text'])."; }";
		$STRING .= ".itemdata.featured .thumbnail h1 a { color: ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['featured_text'])."; }";
		}
		if(isset($GLOBALS['CORE_THEME']['colors']['featured_btn']) && strlen($GLOBALS['CORE_THEME']['colors']['featured_btn']) > 1){
		$STRING .= ".itemdata.featured .thumbnail .btn-primary, .itemdata.featured .thumbnail .btn { background: ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['featured_btn'])."; color:#fff; }";
		}
		$STRING .= "\n";
		}
		
		
		// MOBILE MENU
		if(isset($GLOBALS['CORE_THEME']['colors']['mobilemenu']) && strlen($GLOBALS['CORE_THEME']['colors']['mobilemenu']) > 1){
		$STRING .= "#core_mobile_menu.navbar-inverse, #core_mobile_menu .nav > li:hover { background:".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['mobilemenu'])." !important; }";
		
		if(isset($GLOBALS['CORE_THEME']['colors']['mobilemenu_text']) && strlen($GLOBALS['CORE_THEME']['colors']['mobilemenu_text']) > 1){
		$STRING .= "body > .navbar .brand, #core_mobile_menu, #core_mobile_menu ul a { color: ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['mobilemenu_text'])."; }";
		}
		if(isset($GLOBALS['CORE_THEME']['colors']['mobilemenu_btn']) && strlen($GLOBALS['CORE_THEME']['colors']['mobilemenu_btn']) > 1){
		$STRING .= "#core_mobile_menu .navbar-inverse .navbar-toggle {color: #fff; background: ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['mobilemenu_btn'])." !important;  }";
		}
		$STRING .= "\n";
		}

		
		
		// ADD ON DATE
		if(strlen($STRING) > 5){
		$STRING = "\n\n/*** Styles Added ".date('l jS \of F Y h:i:s A')." ***/\n\n".$STRING;
		}	
 		
	}
	return hook_styles_code_filter($STRING);
} 


$default_color_array = array(

 
"body" => array('name' => 'Background + Contact Blocks',   'desc' => '', 'upload'=>true, 
	"blue" => "#ecf7ff",
	"orange" => "#fff0e0",	
	"green" => "#f6ffe7",
	"purple" => "#faeaff",
	"red" => "#ffeeee",
	"pink" => "#ffe8f0",
	"navey" => "#f1f7ff",
	
	"inner" => array(
		"body_text" => array('name' => 'Text &amp; Link Color',  'desc' => '', 
		"blue" => "#2875a6",
		"orange" => "#f07215",	
		"green" => "#78ab28",
		"purple" => "#804792",
		"red" => "#770e11",
		"pink" => "#9f3b5a",
		"navey" => "#20334c", ),
		"font-family" => array('name' => 'Font Family',   'desc' => '', 'font' => true),
		
		"core_padding" => array('name' => 'Page Content Background',  'desc' => '', 
		"blue" => "#fff",
		"orange" => "#fff",	
		"green" => "#fff",
		"purple" => "#fff",
		"red" => "#fff",
		"pink" => "#fff",
		"navey" => "#fff", ),
		
	),
	
	
	
		
),
"topnav" => array('name' => 'Top Menu (if enabled)',   'desc' => '',
	"blue" => "#2875a6",
	"orange" => "#f07215",	
	"green" => "#78ab28",
	"purple" => "#804792",
	"red" => "#770e11",
	"pink" => "#9f3b5a",
	"navey" => "#20334c",	
	"inner" => array(
		"topnav_link" => array('name' => 'Top Menu Links',   'desc' => '' ,
	
		"blue" => "#fff",
		"orange" => "#fff",	
		"green" => "#fff",
		"purple" => "#fff",
		"red" => "#fff",
		"pink" => "#fff",
		"navey" => "#fff",	
	
		),
		
		"topnav_welcome" => array('name' => 'Welcome Text',   'desc' => '' ,
	
		"blue" => "#fff",
		"orange" => "#fff",	
		"green" => "#fff",
		"purple" => "#fff",
		"red" => "#fff",
		"pink" => "#fff",
		"navey" => "#fff",	
	
		),
	),
),
"header" => array('name' => 'Header Background',   'desc' => '', 'upload'=>true,
	"blue" => "#278ece",
	"orange" => "#f49021",	
	"green" => "#8bbf37",
	"purple" => "#9646b1",
	"red" => "#940102",
	"pink" => "#bb3f69",
	"navey" => "#294160",
),
"menubar" => array('name' => 'Menu Bar (if enabled)',   'desc' => '',
	"blue" => "#2875a6",
	"orange" => "#f07215",	
	"green" => "#78ab28",
	"purple" => "#804792",
	"red" => "#770e11",
	"pink" => "#9f3b5a",
	"navey" => "#20334c",	
 	"inner" => array(
	"menubar_link" => array('name' => 'Menu Link Color',   'desc' => '', 
		"blue" => "#ffffff",
		"orange" => "#ffffff",	
		"green" => "#ffffff",
		"purple" => "#ffffff",
		"red" => "#ffffff",
		"pink" => "#ffffff",
		"navey" => "#ffffff",
		),
		"menubar_hover" => array('name' => 'Menu Hover Color',   'desc' => '', 
		
		
		
		),
		"menubar_br" => array('name' => 'Border Right',   'desc' => '' ),
		"menubar_bl" => array('name' => 'Border Left',   'desc' => '' ),
		"menubar_linksub" => array('name' => 'Dropdown Link',   'desc' => '',
		
		"blue" => "#000",
		"orange" => "#000",	
		"green" => "#000",
		"purple" => "#000",
		"red" => "#000",
		"pink" => "#000",
		"navey" => "#000",
		),		
		
		
		"menubar_searchbg" => array('name' => 'Search Box',   'desc' => ''), 
		"menubar_searchicon" => array('name' => 'Search Box Icon',   'desc' => ''), 

		"menubar_small" => array('name' => 'Small Menu Bar',   'desc' => ''), 
 
		
		
	),
),

"breadcrumbs" => array('name' => 'Breadcrumbs Background',  'desc' => '', 
	"inner" => array(
		"breadcrumbs_text" => array('name' => 'Text Color',  'desc' => '' ),
	),
),
"box_body" => array('name' => 'Content Box Background',  'desc' => '', 'upload' => true,

	"inner" => array(
		"box_bg" => array('name' => 'Title Background',  'desc' => '',  ),
 		"box_bg_text" => array('name' => 'Title Text Color',  'desc' => '',  ),	   
  		"box_body_text" => array('name' => 'Body Text Color',  'desc' => '',  ),
		"box_border" => array('name' => 'Border Color',  'desc' => '',  ),
	),
), 
  	
	

"footer" => array('name' => 'Footer Background',   'desc' => '', 'upload'=>true,
	"blue" => "#2875a6",
	"orange" => "#f07215",	
	"green" => "#78ab28",
	"purple" => "#804792",
	"red" => "#770e11",
	"pink" => "#9f3b5a",
	"navey" => "#20334c",	
	
	"inner" => array(
		"footer_text" => array('name' => 'Text Color',   'desc' => '', 
	"blue" => "#ffffff",
	"orange" => "#ffffff",	
	"green" => "#ffffff",
	"purple" => "#ffffff",
	"red" => "#ffffff",
	"pink" => "#ffffff",
	"navey" => "#ffffff",		
		
		),
	),
),
"copyright" => array('name' => 'Copyright Background',   'desc' => '',
	"blue" => "#278ece",
	"orange" => "#f49021",	
	"green" => "#8bbf37",
	"purple" => "#9646b1",
	"red" => "#940102",
	"pink" => "#bb3f69",
	"navey" => "#294160",
	"inner" => array(
	 "copyright_text" => array('name' => 'Copyright Text Color',   'desc' => '',
	 	"blue" => "#ffffff",
	"orange" => "#ffffff",	
	"green" => "#ffffff",
	"purple" => "#ffffff",
	"red" => "#ffffff",
	"pink" => "#ffffff",
	"navey" => "#ffffff",	
	 
	  ),
	),
),

"button" => array('name' => 'Button Color',  'desc' => '',
	"blue" => "#278ece",
	"orange" => "#f49021",	
	"green" => "#8bbf37",
	"purple" => "#9646b1",
	"red" => "#940102",
	"pink" => "#bb3f69",
	"navey" => "#294160",
	
		"inner" => array(
		"button_text" => array('name' => 'Text Color',  'desc' => '',  ),
 		 
	),
),

"featured" => array('name' => 'Featured Listing Background',   'desc' => '',
	"blue" => "#ecf7ff",
	"orange" => "#fff0e0",	
	"green" => "#f6ffe7",
	"purple" => "#faeaff",
	"red" => "#ffeeee",
	"pink" => "#ffe8f0",
	"navey" => "#f1f7ff",
	"inner" => array(
	 "featured_text" => array('name' => 'Featured Listing Text Color',   'desc' => '',
	 "blue" => "#ffffff",
	"orange" => "#ffffff",	
	"green" => "#ffffff",
	"purple" => "#ffffff",
	"red" => "#ffffff",
	"pink" => "#ffffff",
	"navey" => "#ffffff",
	  ),
	 "featured_btn" => array('name' => 'Featured Listing Button Color',   'desc' => '',
	"blue" => "#278ece",
	"orange" => "#f49021",	
	"green" => "#8bbf37",
	"purple" => "#9646b1",
	"red" => "#940102",
	"pink" => "#bb3f69",
	"navey" => "#294160",
	  ),	  
	  
	  
	),
),


"mobilemenu" => array('name' => 'Mobile Menu Background',   'desc' => '',
	"blue" => "#278ece",
	"orange" => "#f49021",	
	"green" => "#8bbf37",
	"purple" => "#9646b1",
	"red" => "#940102",
	"pink" => "#bb3f69",
	"navey" => "#294160",
	"inner" => array(
	 "mobilemenu_text" => array('name' => 'Mobile Menu Text Color',   'desc' => '',
	 "blue" => "#ffffff",
	"orange" => "#ffffff",	
	"green" => "#ffffff",
	"purple" => "#ffffff",
	"red" => "#ffffff",
	"pink" => "#ffffff",
	"navey" => "#ffffff",
	  ),
	 "mobilemenu_btn" => array('name' => 'Mobile Menu Button Color',   'desc' => '',
	"blue" => "#278ece",
	"orange" => "#f49021",	
	"green" => "#8bbf37",
	"purple" => "#9646b1",
	"red" => "#940102",
	"pink" => "#bb3f69",
	"navey" => "#294160",
	  ),	  
	  
	  
	),
),
 
);
$default_color_array = hook_styles_list_filter($default_color_array);
	
// LOAD IN HEADER
echo $CORE_ADMIN->HEAD();

?> 


<ul id="tabExample1" class="nav nav-tabs">

<?php
// HOOK INTO THE ADMIN TABS
function _8_tabs(){ $STRING = ""; global $wpdb; $core_admin_values = get_option("core_admin_values");

	if(isset($_GET['tab'])){ $_POST['tab'] = $_GET['tab']; }
	
	$pages_array = array( 
	"1" => array("t" => "Basic Colors", "k"=>"colors"),
	 	
	"4" => array("t" => "Custom Meta Data", "k"=>"css"),
 	);
	foreach($pages_array as $page){
	
	if( ( isset($_POST['tab']) && $_POST['tab'] == $page['k'] ) || ( !isset($_POST['tab']) && $page['k'] == "colors" ) ){ $class = "active"; }else{ $class = ""; }
	
		$STRING .= '<li class="'.$class.'"><a href="#'.$page['k'].'" onclick="document.getElementById(\'ShowTab\').value=\''.$page['k'].'\'" data-toggle="tab">'.$page['t'].'</a></li>';		
	}
 
	return $STRING;

}
echo hook_admin_8_tabs(_8_tabs());
// END HOOK
?>  
                     
</ul>

<div class="tab-content" style="background:#fff;">
<?php do_action('hook_admin_8_content'); ?> 

 

<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] =="css"){ echo "active in"; } ?>" id="css"> 
      
    <div class="box gradient">
    <div class="title">
    
    <h4><i class="icon-tags"></i><span>Header Styles (wp_head)</span></h4></div>
    <div class="content top ">
    <p>Here you can enter your own custom CSS/meta data that will appear between your &lt;HEAD&gt; tags.</p>
    <textarea class="row-fluid" id="default-textarea" style="height:400px;font-size:11px;" name="adminArray[custom_head]"><?php echo stripslashes(get_option('custom_head')); ?></textarea>
    <small><span class="label label-no">Note</span> If your adding CSS please remember to include the &lt;style&gt; tags ... &lt;/style&gt; tags</small>
    </div>     
    </div>
     
    <div class="box gradient">
    <div class="title"><h4><i class="icon-tags"></i><span>Footer Styles (wp_footer)</span></h4></div>
    <div class="content top ">
    <p>Here you can enter any custom JAVASCRIPT/meta data that will appear after your &lt;BODY&gt; tags.</p>
    <textarea  class="row-fluid" id="default-textarea" style="height:400px;font-size:11px;" name="adminArray[custom_footer]"><?php echo stripslashes(get_option('custom_footer')); ?></textarea>
    </div>  
    </div> 
    <div class="clearfix"></div> <div class="form-actions row-fluid"><div class="span7 offset5"><button type="submit" class="btn btn-primary">Save Changes</button></div></div> 
</div>





<div class="tab-pane fade <?php if(!isset($_POST['tab']) || ( isset($_POST['tab']) && ( $_POST['tab'] =="" || $_POST['tab'] =="colors" ) )){ echo "active in"; } ?>" id="colors">
 

 
<p><b class="label label-success">Pre-Defined Colors</b> Click on any of the color icons options below to apply them to your theme.</p>
<div class="row-fluid">
	<div class="span12 well" style="margin-bottom:0px;">   
     
    <img src="<?php echo get_template_directory_uri(); ?>/framework/img/colors/orange.jpg" style="border: 1px solid #C2C2C2; padding: 1px; margin-right:40px;cursor:pointer;" class="img-circle" onclick="DisplayFormValues('colororange');">
    <img src="<?php echo get_template_directory_uri(); ?>/framework/img/colors/blue.jpg" style="border: 1px solid #C2C2C2; padding: 1px; margin-right:40px;cursor:pointer;" class="img-circle" onclick="DisplayFormValues('colorblue');">
    <img src="<?php echo get_template_directory_uri(); ?>/framework/img/colors/pink.jpg" style="border: 1px solid #C2C2C2; padding: 1px; margin-right:40px;cursor:pointer;" class="img-circle" onclick="DisplayFormValues('colorpink');">
    <img src="<?php echo get_template_directory_uri(); ?>/framework/img/colors/green.jpg" style="border: 1px solid #C2C2C2; padding: 1px; margin-right:40px;cursor:pointer;" class="img-circle" onclick="DisplayFormValues('colorgreen');">
    <img src="<?php echo get_template_directory_uri(); ?>/framework/img/colors/purple.jpg" style="border: 1px solid #C2C2C2; padding: 1px; margin-right:40px;cursor:pointer;" class="img-circle" onclick="DisplayFormValues('colorpurple');">
    <img src="<?php echo get_template_directory_uri(); ?>/framework/img/colors/red.jpg" style="border: 1px solid #C2C2C2; padding: 1px; margin-right:0px;cursor:pointer;" class="img-circle" onclick="DisplayFormValues('colorred');">    
 
         
    </div>
    <div class="clearfix"></div>
   <hr />
</div>
 
 

<div class="row-fluid">
<div class="span6">


<div class="accordion" id="accordion2"> 
	<?php echo colorblock($default_color_array); ?>  
</div>
<a href="javascript:void(0);" style="float:right;" class="btn" onclick="DisplayFormValues('colorreset');">reset all colors</a>
 
<button type="button" class="btn btn-info" onclick="jQuery('#shownewcode').val('save');document.admin_save_form.submit();">Save Changes</button>

</div>
<div class="span6">
<input type="hidden" name="shownewcode" id="shownewcode" value="" />
<textarea id="codeTextarea1" name="adminArray[custom_css]" style="width:100%;"><?php echo stripslashes(get_option('custom_css')); ?></textarea>
     
    <div style="text-align:center;"><button type="submit" class="btn btn-success" onclick="jQuery('#ShowSubSubTab').val('rawcss');">Save CSS Changes ONLY</button></div>

</div>
</div>


 

</form> 




 
</div><!-- end tab --> 






























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
}
});

 

function DisplayFormValues(type){
	var elem = document.getElementById(type).elements;
	for(var i = 0; i < elem.length; i++){
		jQuery("#up_"+elem[i].name).val(elem[i].value);
	}
	 
	jQuery('#codeTextarea1').val('');
	jQuery('#shownewcode').val('save');	
	document.admin_save_form.submit(); 
}
 
</script>
<script language="javascript" type="text/javascript" src="<?php echo get_bloginfo('template_url')."/framework/admin/"; ?>js/bootstrap-colorpicker.js"></script> 

<?php 

$colorarrays = array('reset','blue','orange','pink','green','purple','red');
foreach($colorarrays as $cc){ ?>
<form name="color<?php echo $cc; ?>" id="color<?php echo $cc; ?>">
	<?php foreach($default_color_array as $key=>$val){ if(!isset($val["end"]) && !isset($val["break"]) ){ ?>    
    <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $val[$cc]; ?>" />
    <?php  } 
	if(is_array($val["inner"])){ foreach($val["inner"] as $kk=>$vv){?><input type="hidden" name="<?php echo $kk; ?>" value="<?php echo $vv[$cc]; ?>" /><?php }} 
	} ?>
</form>
<?php } ?>

 

<style type="text/css">
  
.accordion-heading { border-color: #dddddd;  
 background: #f7f7f7;
border: 1px solid transparent;
border-radius: 4px;
-webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05); }

.accordion-heading a { color:#269ccb; font-weight:bold; }
   
  
   .table hr  { margin:5px; }
   #codeTextarea, #codeTextarea1 {
      width:390px;
      height:510px;
	  font-size:12px;
	  color:#eb54f4;
	  font-weight:bold;
	 
   }
   .textAreaWithLines{
      font-family:courier;      
      border:1px solid #666;
	  margin-bottom:30px;
      
   }
   .textAreaWithLines textarea,.textAreaWithLines div{
      border:0px;
      line-height:120%;
      font-size:12px;
   }
   .lineObj{
      color:#fff;
	  background:#666;	  padding-top:5px; padding-right:5px;
   }
   </style>
   

<?php echo $CORE_ADMIN->FOOTER(); ?>

<?php  function colorblock($vals){ global $post, $CORE; $core_admin_values = get_option("core_admin_values"); 

foreach($vals as $key => $val){ 
if(!isset($val)){ return; }  
if($val['name'] == ""){ return; }?>


  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $key; ?>">
      <img src="<?php echo get_template_directory_uri(); ?>/framework/img/a3.png" style="float:right;margin-top:3px;">
        <?php echo $val['name']; ?>
      </a>
    </div>
    <div id="collapse<?php echo $key; ?>" class="accordion-body collapse">
      <div class="accordion-inner">
 

 
<div class="form-row control-group row-fluid">
<label class="control-label span6"><?php echo $val['name']; ?></label>
<div class="controls span6"> 
             
             


    <div class="input-append color row-fluid" data-color="<?php echo $core_admin_values['colors'][$key]; ?>" data-color-format="hex" id="colorpicker_<?php echo $key; ?>" <?php if(isset($val['upload']) && $val['upload'] ){ ?>style="width:180px;"<?php } ?>>
    
    <input name="admin_values[colors][<?php echo $key; ?>]" type="text" id="up_<?php echo $key; ?>" value="<?php echo $core_admin_values['colors'][$key]; ?>" class="row-fluid">
    
    <span class="add-on"><i style="background-color:<?php echo $core_admin_values['colors'][$key]; ?>;"></i></span>
    <?php if(isset($val['upload']) && $val['upload'] ){ ?>
    <span class="add-on" style="margin-right: -30px;" id="upload_<?php echo $key; ?>"><i class="gicon-search"></i></span>   
    <?php } ?>
    </div>
    
</div> </div>     
    <script type="text/javascript">
        jQuery(document).ready(function () {
           jQuery('#colorpicker_<?php echo $key; ?>').colorpicker();            
           <?php if(isset($val['upload']) && $val['upload'] ){ ?>
           jQuery('#upload_<?php echo $key; ?>').click(function() {           
            jQuery('#colorpicker_<?php echo $key; ?>').colorpicker('hide'); // hide colorpicker
             ChangeImgBlock('up_<?php echo $key; ?>');
             formfield = jQuery('#up_<?php echo $key; ?>').attr('name');
             tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
             return false;
            });
            <?php } ?>
            
        });	
    </script>    
    

<?php 

if(is_array($val["inner"])){  echo '<div style="">'; foreach($val["inner"] as $kkk=>$vvv){ ?>    	
        
        <div class="form-row control-group row-fluid">
        <label class="control-label span6"><?php echo $vvv['name']; ?></label>
        <div class="controls span6">        
			 <?php if(isset($vvv['font']) && $vvv['font'] ){ ?>     	
                <select name="admin_values[colors][<?php echo $kkk; ?>]" style="width:200px;font-size:12px;" id="up_<?php echo $kkk; ?>">
                <option value="">--------------</option>
                <?php foreach($GLOBALS['fontsA'] as $k=>$v){   ?>
                <option value="<?php echo $k; ?>" <?php if($core_admin_values['colors'][$kkk] == $k){ echo "selected=selected"; }; ?>><?php echo $v['name']; ?></option>
                <?php   } ?>   
                </select>
            <?php }else{ ?>
            
                <div class="input-append color row-fluid" data-color="<?php echo $core_admin_values['colors'][$kkk]; ?>" data-color-format="hex" id="inner_colorpicker_<?php echo $kkk; ?>">
                <input name="admin_values[colors][<?php echo $kkk; ?>]" type="text" id="up_<?php echo $kkk; ?>" value="<?php echo $core_admin_values['colors'][$kkk]; ?>" class="row-fluid">
                <span class="add-on"><i style="background-color:<?php echo $core_admin_values['colors'][$kkk]; ?>;"></i></span>
					<?php if(isset($vvv['upload']) && $vvv['upload'] ){ ?>
                    <span class="add-on" style="margin-right: -30px;" id="upload_<?php echo $kkk; ?>"><i class="gicon-search"></i></span>   
                    <?php } ?>
                </div>               
                
                <script type="text/javascript">
                    jQuery(document).ready(function () {
                       jQuery('#inner_colorpicker_<?php echo $kkk; ?>').colorpicker();              
                    });	
                </script>
            <?php } ?>
        </div>
        </div>
        
    <?php }  echo '</div>'; } // end if  
	
	?>
    
          </div>
    </div>
  </div><?php

} }


?>
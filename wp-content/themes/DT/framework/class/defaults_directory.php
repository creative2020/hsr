<?php

class core_directory extends white_label_themes {

	function mobilelistingcotent(){}	
	function mobilesearchcontent(){}	
	function mobile_header(){}
	function mobile_footer(){}
	function core_directory(){ global $wpdb;
 		
		// MOBILE FUNCTIONS
		add_action('hook_mobile_content_listing_output', array($this, 'mobilelistingcotent' ) );
		add_action('hook_mobile_content_output', array($this, 'mobilesearchcontent' ) );	
		add_action('hook_mobile_header', array($this, 'mobile_header' ) );
		add_action('hook_mobile_footer', array($this, 'mobile_footer' ) );
	
	}// end function

}

?>
<?php
/* 
* Theme: PREMIUMPRESS CORE FRAMEWORK FILE
* Url: www.premiumpress.com
* Author: Mark Fail
*
* THIS FILE WILL BE UPDATED WITH EVERY UPDATE
* IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
*
* http://codex.wordpress.org/Child_Themes
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
?>

<?php

	global $wpdb, $CORE, $pagenow;
	 
	// HERE WE HANDLE FRAMEWORK UPDATES
	// WE WILL CHECK THE DATABASE EVERY 24 HOURS AS NOT TO OVERLOAD THE QUERY
	$key = get_option("wlt_license_key");
	$core_admin_values = get_option("core_admin_values"); 
 	
	?>
    </div></div></div><!-- End #container --></div><!-- End #main --></form><div class="clearfix"></div>
    
    
    <!-- VIDEO BOX --->
    
   <div id="VideoModelBox" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myVideoLabel" aria-hidden="true">
					  <div class="modal-header">                
						<h3>PremiumPress Video Tutorial</h3>
					  </div>
					  <div class="modal-body">                      
						<div id="videoboxplayer" style="text-align:center;"></div>                      			             
					  </div>
           
					  <div class="modal-footer">
						<a class="btn" data-dismiss="modal" aria-hidden="true">Close</a>
					  </div>
	</div> 
    <script type="application/javascript">
	function PlayPPTVideo(videoname,div,s1,s2){
	document.getElementById( div ).innerHTML = '<iframe width="'+s1+'" height="'+s2+'" src="http://www.youtube.com/embed/'+videoname+'?rel=0" frameborder="0" allowfullscreen></iframe>';
	}
	</script>
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


// MAKE SURE WE HAVE SLIDER ITEMS
if(isset($GLOBALS['CORE_THEME']['home']['slider_item_1']) && strlen($GLOBALS['CORE_THEME']['home']['slider_item_1']) > 0 ){

// DEFAULTS
$i=1; $f=1; $set="active";

?>
 
<div class="hidden-xs" id="HomeMainBanner">		 

    <div id="myCarousel" class="carousel slide">				
    
    <div class="carousel-inner">          
    
    <?php while($i < 5){		  
    
    if(isset($GLOBALS['CORE_THEME']['home']['slider_item_'.$i]) && strlen($GLOBALS['CORE_THEME']['home']['slider_item_'.$i]) > 5){   
    
        if(!isset($GLOBALS['CORE_THEME']['home']['slider_link_'.$i])){ $GLOBALS['CORE_THEME']['home']['slider_link_'.$i] = ""; }     
        
        	echo '<div class="item '.$set.'">';	
                      
            if(strlen($GLOBALS['CORE_THEME']['home']['slider_link_'.$i]) > 1){ echo '<a href="'.str_replace("&","&amp;",$GLOBALS['CORE_THEME']['home']['slider_link_'.$i]).'">'; }
            
            echo '<img src="'.$GLOBALS['CORE_THEME']['home']['slider_item_'.$i].'" alt="&nbsp;" />';
            
            if(strlen($GLOBALS['CORE_THEME']['home']['slider_link_'.$i]) > 1){ echo'</a>'; }
            
            echo '</div>';          
    
    $set=""; $f++; } $i++; } 
                                               
            echo '</div>';
            
            if($f>2){
            
            echo ' <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a><a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>';
            
            }
    ?>

    <div class="clearfix"></div>		 
    </div> 

</div>			
<script type="text/javascript">jQuery(window).load(function() {jQuery('.carousel').carousel({interval: 4500});});</script>						
					 
								   
<?php } // END CHECK ?>
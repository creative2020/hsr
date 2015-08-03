<?php

/* =============================================================================
	0.  TABS
	========================================================================== */
class core_widgets_accountbox extends WP_Widget {  
    function core_widgets_accountbox() {
        // widget actual processes		
		$opts = array(
			'classname' => 'core_widgets_accountbox',
			'description' => __( 'Account Box' )
		);
		parent::__construct( 'core_widgets_accountbox', __( '&#9658; Account Box' ), $opts );		
    }
    function form($instance) {	
 		$defaults = array(
	 
		);		
		$instance = wp_parse_args( $instance, $defaults );  	
	 ?>
 
  
  	<?php
  	 
    }

	function update( $new, $old )	{	
	
		$clean = $old;		
		
 
 
		return $clean;
	}

    function widget($args, $instance) { global $CORE, $wpdb, $userdata;
 	 
	 ?>
     
     
<div class="panel panel-default" id="wlt_widgets_accountbox">

<div class="panel-body">
<div class="row text-center">
 

    <?php if(!$userdata->ID){ ?>
     
    <div class="col-md-6 col-sm-12 lo"><a class="btn btn-lg btn-primary" href="<?php echo get_home_url(); ?>/wp-login.php"><?php echo $CORE->_e(array('head','5','flag_link')); ?></a></div>
    
    <div class="col-md-6 col-sm-12 lo"><a class="btn btn-lg btn-primary" href="<?php echo get_home_url(); ?>/wp-login.php?action=register"><?php echo $CORE->_e(array('head','6','flag_link')); ?></a> </div>
      
    <?php }else{ ?>      
    
    <div class="col-md-6 col-sm-12 li"><a class="btn btn-lg btn-primary" href="<?php echo $GLOBALS['CORE_THEME']['links']['myaccount']; ?>"><?php echo $CORE->_e(array('head','4','flag_link')); ?></a> </div>   
 
     <div class="col-md-6 col-sm-12 li"><a class="btn btn-lg btn-primary" href="<?php echo wp_logout_url(); ?>"><?php echo $CORE->_e(array('account','8')); ?></a> </div>
 
 	<?php } ?> 
 
</div>
</div>
</div>
     
 
        <?php 		
			
	 	
 
    }

}

/* =============================================================================
	0.  TABS
	========================================================================== */
class core_widgets_tabs extends WP_Widget {  
    function core_widgets_tabs() {
        // widget actual processes		
		$opts = array(
			'classname' => 'core_widgets_tabs',
			'description' => __( 'Empty Tab Content' )
		);
		parent::__construct( 'core_widgets_tabssearch', __( '&#9658; Tabs Widget' ), $opts );		
    }
    function form($instance) {	
 		$defaults = array(
			'tab1'		=> 'Tab Title 1',
			'tab2'	=> 'Tab Title 2',
			'zoom'		=> "8",		
		);		
		$instance = wp_parse_args( $instance, $defaults );  	
	 ?>
 
<p><b>Tab Title 1</b></p>
<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'tab1' ); ?>" name="<?php echo $this->get_field_name( 'tab1' ); ?>" value="<?php echo esc_attr( $instance['tab1'] ); ?>" />
    
<br /><b>Tab 1 Content</b> 

<textarea class="widefat" rows="16" cols="20" style="height:150px;" id="<?php echo $this->get_field_id( 'tab1c' ); ?>" name="<?php echo $this->get_field_name( 'tab1c' ); ?>"><?php echo esc_attr( $instance['tab1c'] ); ?></textarea></p>

<p><b>Tab Title 2</b></p>
<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'tab2' ); ?>" name="<?php echo $this->get_field_name( 'tab2' ); ?>" value="<?php echo esc_attr( $instance['tab2'] ); ?>" />
    
<br /><b>Tab 2 Content</b> 

<textarea class="widefat" rows="16" cols="20" style="height:150px;" id="<?php echo $this->get_field_id( 'tab2c' ); ?>" name="<?php echo $this->get_field_name( 'tab2c' ); ?>"><?php echo esc_attr( $instance['tab2c'] ); ?></textarea></p>
  
  	<?php
  	 
    }

	function update( $new, $old )	{	
	
		$clean = $old;		
		
		$clean['tab1'] = isset( $new['tab1'] ) ? strip_tags( esc_html( $new['tab1'] ) ) : '';
		if (current_user_can('unfiltered_html')) {
		  $clean['tab1c'] = $new['tab1c'];
		} else {
		  $clean['tab1c'] = stripslashes(wp_filter_post_kses(addslashes($new['tab1c'])));
		}
		
		$clean['tab2'] = isset( $new['tab2'] ) ? strip_tags( esc_html( $new['tab2'] ) ) : '';
		if (current_user_can('unfiltered_html')) {
		  $clean['tab2c'] = $new['tab2c'];
		} else {
		  $clean['tab2c'] = stripslashes(wp_filter_post_kses(addslashes($new['tab2c'])));
		}
	 
 
		return $clean;
	}

    function widget($args, $instance) {

		global $CORE, $wpdb, $category; $STRING = ""; @extract($args); 
		
	 	
	 
	 ?>
     
     
<div role="tabpanel" class="wlt_widget_tabs">

   
  <ul class="nav nav-tabs" role="tablist">
  
    <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"><?php echo $instance['tab1']; ?></a></li>
    <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"><?php echo $instance['tab2']; ?></a></li>
 
  </ul>
 
  <div class="tab-content">
  
    <div role="tabpanel" class="tab-pane active" id="tab1">
    <?php echo wpautop($instance['tab1c']); ?>
    </div>
    
    <div role="tabpanel" class="tab-pane" id="tab2">
    <?php echo wpautop($instance['tab2c']); ?>
    </div>
 
  </div>

</div>
     
 
        <?php 		
			
	 	
 
    }

}

/* =============================================================================
	0.  GOOGLE MAPS BOX WIDGET
	========================================================================== */
class core_widgets_googlemap extends WP_Widget { // UPDATED 6TH JULY
    function core_widgets_googlemap() {
        // widget actual processes		
		$opts = array(
			'classname' => 'core_widgets_googlemap',
			'description' => __( 'A price search widget box.' )
		);
		parent::__construct( 'core_widgets_googlemapsearch', __( '&#9658; Google Map' ), $opts );		
    }
    function form($instance) {	
 		$defaults = array(
			'title'		=> 'Find us on the map',
			'address'	=> 'London',
			'zoom'		=> "8",		
		);		
		$instance = wp_parse_args( $instance, $defaults );  	
	 ?>
 
  	<p><b>Title</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    
 	<p><b>Enter Map Address</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'address' ); ?>" name="<?php echo $this->get_field_name( 'address' ); ?>" value="<?php echo esc_attr( $instance['address'] ); ?>" />
 	<br />
    <p><b>Zoom Level (0 - 20)</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'zoom' ); ?>" name="<?php echo $this->get_field_name( 'zoom' ); ?>" value="<?php echo esc_attr( $instance['zoom'] ); ?>"  style="width:30px;"/>
  
  
  	<?php
  	 
    }

	function update( $new, $old )	{	
	
		$clean = $old;		
		$clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';
		$clean['address'] = isset( $new['address'] ) ? strip_tags( esc_html( $new['address'] ) ) : 'London';
		$clean['zoom'] = isset( $new['zoom'] ) ? strip_tags( esc_html( $new['zoom'] ) ) : 8;
 
		return $clean;
	}

    function widget($args, $instance) {

		global $CORE, $wpdb, $category; $STRING = ""; @extract($args); 
		
	 	
		echo "<div class='core_widgets_googlemap'>".$before_widget.$before_title.$instance['title'].$after_title; 
	 ?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
<script> 
var geocoder;
var map;
function initializeMapWidget() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(0,0);
  var mapOptions = {
    zoom: <?php echo $instance['zoom']; ?>,
    center: latlng
  }
  map = new google.maps.Map(document.getElementById('wlt_mapwidget1-canvas'), mapOptions);
  
  codeAddress("<?php echo $instance['address']; ?>");
}

function codeAddress(address) {
  
  geocoder.geocode( { 'address': address}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      map.setCenter(results[0].geometry.location);
      var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location
      });
    } else {
      alert('Geocode was not successful for the following reason: ' + status);
    }
  });
}

jQuery( document ).ready(function() { initializeMapWidget(); });
 
 </script>
 <div id="wlt_mapwidget1-canvas" style="height:250px; width:100%"></div>
 
 
        <?php 		
			
		echo $after_widget."</div>";		
 
    }

}

/* =============================================================================
	0.  PRICE WIDGET BOX
	========================================================================== */
class core_widgets_pricesearch extends WP_Widget { // UPDATED 6TH JULY
    function core_widgets_pricesearch() {
        // widget actual processes		
		$opts = array(
			'classname' => 'core_widgets_pricesearch',
			'description' => __( 'A price search widget box.' )
		);
		parent::__construct( 'core_widgets_pricesearch', __( '&#9658; Price Search' ), $opts );		
    }
    function form($instance) {	
 		$defaults = array(
			'title'		=> 'Price',		
		);		
		$instance = wp_parse_args( $instance, $defaults );  	
	 ?>
     
 	<p><b>Title</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
  
  	<?php
  	 
    }

	function update( $new, $old )	{	
	
		$clean = $old;		
		$clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';
 
		return $clean;
	}

    function widget($args, $instance) {

		global $CORE, $wpdb, $category; $STRING = ""; @extract($args); 
		
		wp_register_style( 'bootstrap-slider',  FRAMREWORK_URI.'slider/bootstrap-slider.css');
		wp_enqueue_style( 'bootstrap-slider' ); 
		wp_register_script( 'bootstrap-slider',  FRAMREWORK_URI.'slider/bootstrap-slider.js');
		wp_enqueue_script( 'bootstrap-slider' ); 
		
		// FIND THE MAX PRICE OF ITEMS IN OUR DATABASE
		$SQL = "SELECT meta_value FROM ".$wpdb->prefix."postmeta WHERE meta_key = 'price' AND meta_value != '' ORDER BY CAST(meta_value as SIGNED INTEGER) DESC LIMIT 1"; 
		$result = $wpdb->get_results($SQL);
		if(empty($result)){
		$maxValue = "1000";
		}else{
		$maxValue = $result[0]->meta_value;
		}
	 
		if(isset($_GET['price1'])){ $price1 = esc_attr($_GET['price1']); }else{ $price1 = 0; }
		
		if(isset($_GET['price2'])){ $price2 = esc_attr($_GET['price2']); }else{ $price2 = $maxValue; }
	  	  
		echo "<div class='core_widgets_pricesearch'>".$before_widget.$before_title.$instance['title'].$after_title; 
 		
		
		if($GLOBALS['CORE_THEME']['layout_columns']['3columns'] == "1"){ $ss = "col-md-12 col-sm-12"; }else{ $ss = "col-md-5 col-sm-12"; }
		 
		?>
         
        <form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" name="core_widgets_pricesearch_form" id="core_widgets_pricesearch_form">
        <input type="hidden" name="s" value="<?php if(isset($_GET['s'])){ echo  esc_attr($_GET['s']); } ?>" />
        <?php if(isset($_GET['cat1']) && is_numeric($_GET['cat1']) ){ ?>
        <input type="hidden" name="cat1" value="<?php echo  esc_attr($_GET['cat1']);  ?>" />
        <?php }elseif(isset($category->term_id)){ ?>
        <input type="hidden" name="cat1" value="<?php echo $category->term_id;  ?>" />
        <?php } ?>
        
              <div class="row" style="margin-bottom:10px;">
              <div class="<?php echo $ss; ?>"><input type="text" placeholder="<?php echo hook_price(10); ?>" class="form-control" id="price_bar_val1" name="price1" 
              value="<?php echo $price1; ?>"></div>
              <div class="col-md-2"><span><?php echo $CORE->_e(array('widgets','27')); ?></span></div>
              <div class="<?php echo $ss; ?>"><input type="text" placeholder="<?php echo hook_price($maxValue); ?>" class="form-control" id="price_bar_val2" name="price2" 
              value="<?php echo $price2; ?>"></div>
             </div>          
            <input id="ex2" type="text" class="col-md-12 hidden-xs hidden-sm" value="" data-slider-min="0" data-slider-max="<?php echo $maxValue; ?>" data-slider-step="5" data-slider-value="[<?php echo $price1; ?>,<?php echo $price2; ?>]"/> 
		</form>
		<script>
        
        jQuery( document ).ready(function() {
        
            jQuery("#ex2").slider({             
                formatter: function(value) { 
                return value;
                }            
            });
            
            jQuery("#ex2").on("slide", function(slideEvt) {
                var bb = jQuery("#ex2").val().split(',');
                jQuery('#price_bar_val1').val(bb[0]);
                jQuery('#price_bar_val2').val(bb[1]); 	
        
            });
            jQuery("#ex2").on("slideStop", function(slideEvt) {
				var bb = jQuery("#ex2").val().split(',');
                jQuery('#price_bar_val1').val(bb[0]);
                jQuery('#price_bar_val2').val(bb[1]); 
               document.core_widgets_pricesearch_form.submit();        
            });
 			
			// CHANGES TO VALUES BY USER
			jQuery("#price_bar_val1").on("change", function(slideEvt) {
				 document.core_widgets_pricesearch_form.submit();  
            });
			jQuery("#price_bar_val2").on("change", function(slideEvt) {
				 document.core_widgets_pricesearch_form.submit();  
            });
        });
        
        </script>
        
        <?php 		
			
		echo $after_widget."</div>";		
 
    }

}
/* =============================================================================
	 1.  AUTHOR WIDGET CLASS
	========================================================================== */
class core_widgets_author extends WP_Widget {
    function core_widgets_author() {
        // widget actual processes		
		$opts = array(
			'classname' => 'core_author',
			'description' => __( 'Author details box for listing page only.' ),
			
		);
		parent::__construct( 'core_author', __( '&#9658; Author' ), $opts );		
    }
    function form($instance) {   
		$instance = wp_parse_args( $instance, $defaults );
		$defaults = array(
			'title' => 'About the author',	
		);	
	 ?>
     <p><b>Box Title</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
  	<?php 
	 $out = '<br /><br /><p>
	 
	 
	 
	 	<input id="' . $this->get_field_id('f5') . '" name="' . $this->get_field_name('f5') . '" type="checkbox" ' . checked(isset($instance['f5'])? $instance['f5']: 0, true, false) . ' /> Show Joined Dates <br />

<input id="' . $this->get_field_id('f1') . '" name="' . $this->get_field_name('f1') . '" type="checkbox" ' . checked(isset($instance['f1'])? $instance['f1']: 0, true, false) . ' /> Show View Profile Button <br />
	
<input id="' . $this->get_field_id('f6') . '" name="' . $this->get_field_name('f6') . '" type="checkbox" ' . checked(isset($instance['f6'])? $instance['f6']: 0, true, false) . ' /> Show User Rating  (boxed) <br />
<input id="' . $this->get_field_id('f7') . '" name="' . $this->get_field_name('f7') . '" type="checkbox" ' . checked(isset($instance['f7'])? $instance['f7']: 0, true, false) . ' /> Show User Rating  (top) <br />

	<input id="' . $this->get_field_id('p') . '" name="' . $this->get_field_name('p') . '" type="checkbox" ' . checked(isset($instance['p'])? $instance['p']: 0, true, false) . ' /> Show Phone Number <br />
	<input id="' . $this->get_field_id('e') . '" name="' . $this->get_field_name('e') . '" type="checkbox" ' . checked(isset($instance['e'])? $instance['e']: 0, true, false) . ' /> Show Contact Form <br />
	<input id="' . $this->get_field_id('f2') . '" name="' . $this->get_field_name('f2') . '" type="checkbox" ' . checked(isset($instance['f2'])? $instance['f2']: 0, true, false) . ' /> Show User Description <br />

	 
	
		<input id="' . $this->get_field_id('f3') . '" name="' . $this->get_field_name('f3') . '" type="checkbox" ' . checked(isset($instance['f3'])? $instance['f3']: 0, true, false) . ' /> Show Recent Listing<br />

	
	</p>';
	echo  $out; 
    }
	function update( $new, $old )
	{	
		$clean = $old;		
		$clean['title'] 	= isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';
	 
		$clean['p'] 		= isset( $new['p'] ) ? '1' : '0';
		$clean['e'] 		= isset( $new['e'] ) ? '1' : '0';
		$clean['f1'] 		= isset( $new['f1'] ) ? '1' : '0';
		$clean['f2'] 		= isset( $new['f2'] ) ? '1' : '0';
		$clean['f3'] 		= isset( $new['f3'] ) ? '1' : '0';
		$clean['f4'] 		= isset( $new['f4'] ) ? '1' : '0';
		$clean['f5'] 		= isset( $new['f5'] ) ? '1' : '0';
		$clean['f6'] 		= isset( $new['f6'] ) ? '1' : '0';
		$clean['f7'] 		= isset( $new['f7'] ) ? '1' : '0';
		return $clean;
	}
    function widget($args, $instance) {  
	
		 // outputs the content of the widget		
		global $PPT, $post, $CORE; $STRING = ""; @extract($args);
		
		if(!isset($GLOBALS['flag-single']) || ( isset($GLOBALS['flag-single']) && $post->post_type != THEME_TAXONOMY."_type" )){  return; }
		
		//  GET USER DATA
		$userid = $post->post_author; $user_info = get_userdata($userid); 
		
		// GET LAST LOGIN DATE
		$lastlogin = get_user_meta($userid, 'login_lastdate', true);
		
		// USER COUNTRY
		$selected_country = get_user_meta($userid,'country',true);
		
		// JOINED
		$date_joined = $CORE->TimeDiff($user_info->user_registered,'','',false, array('years','months','days','hours','seconds') );
		
		// GET LISTING COUNT
		$listings = $CORE->count_user_posts_by_type( $userid, THEME_TAXONOMY."_type" );
		
		// SHOW PHONE NUMBER
		$phone = get_user_meta( $userid, 'phone', true);
		
		// GET PROFILE BG STYLE
		$pbg = get_user_meta($userid,'pbg',true);
		if($pbg == ""){ $pbg = 1; }
		
		?>
        
 
<div class="wlt_widget_authorbox_wrapper">
<div class="wlt_widget_authorbox hoverwlt_widget_authorbox">
    <div class="wlt_widget_authorboxheader" style="background:url('<?php echo FRAMREWORK_URI; ?>/img/profile/<?php echo $pbg; ?>.jpg');background-size: 100% auto; ">

    </div>
    <div class="avatar">
        <?php echo str_replace("avatar img-responsive","",get_avatar( $userid, 150 )); ?>
    </div>
    
    <div class="box1">
    
    <div class="info">
    
        <h3><?php echo $user_info->data->display_name; ?></h3>
       
          <?php if(strlen($selected_country) > 0){ ?>
            <div class="desc"><div class="flag flag-<?php echo strtolower($selected_country); ?> wlt_locationflag"></div><?php echo $GLOBALS['core_country_list'][$selected_country]; ?> </div>
          <?php } ?> 
          
          <?php if($instance['f7'] == "1"){ ?>
          <hr />
          <?php echo _user_trustbar($post->post_author, 'inone'); ?>
          
		  <?php } ?>
           
           
          <?php if($instance['f5'] == "1"){ ?>
          <hr />
        
        <div class="desc small"><?php echo $CORE->_e(array('auction','61')); ?> <?php echo hook_date($user_info->user_registered); ?></div>
        
        <div class="desc small"> <?php echo $CORE->_e(array('widgets','26')); ?> <?php echo hook_date($lastlogin); ?> </div>
        
        <?php } ?>
        
         <?php 	
	// SHOW PROFILE BUTTON
	if($instance['f1'] == "1"){ ?>
    <hr />
	<a href="<?php echo get_author_posts_url( $post->post_author ); ?>" class="btn btn-lg btn-success"><?php echo $CORE->_e(array('widgets','24')); ?></a> 
	<?php } ?>
    
    <?php 
		
		if(strlen($phone) > 1 && $instance['p'] == "1"){ ?>
        <hr />
        <div class="desc big"><i class='fa fa-phone'></i>  <?php echo $phone; ?> </div>
        <?php } ?>
         
         </div> 
          
        
    </div> 
    
 

<?php if($instance['f2'] == "1" && strlen($user_info->user_description) > 2){ ?> 

<div class="box1"> 
<div class="userdescription"><?php echo wpautop(strip_tags($user_info->user_description)); ?></div>
</div>       
<script>
            jQuery(document).ready(function(){
                jQuery('.userdescription').shorten({
                    moreText: '<?php echo $CORE->_e(array('feedback','3')); ?>',
                    lessText: '<?php echo $CORE->_e(array('feedback','4')); ?>',
                    showChars: '180',
                });
            });
            </script>
            
<?php } ?>
                
 
<?php if($instance['f6'] == "1" && isset($GLOBALS['CORE_THEME']['feedback_enable']) && $GLOBALS['CORE_THEME']['feedback_enable'] == '1' && isset($GLOBALS['CORE_THEME']['feedback_trustbar']) && $GLOBALS['CORE_THEME']['feedback_trustbar'] == '1'){ ?>
 
<div class="box1">   

<h4><?php echo $CORE->_e(array('feedback','47')); ?></h4> 

<?php echo _user_trustbar($post->post_author, 'inone'); ?>

</div>  

<?php } ?> 


 <?php 
// CONTACT FORM
if($instance['e'] == "1"){ ?>
<div class="box1">  

<?php echo do_shortcode('[CONTACT style=3]'); ?>

</div>
<?php } ?>



</div>
 
 
<?php

// SHOW TOP 5 OTHER LISTINGS
if($instance['f3'] == "1"){ 
		
 
?>
<div class="more">
 
    <h4><?php echo str_replace("%a", $listings, $CORE->_e(array('author','1'))); ?>;</h4>
    <hr />
    
    <?php
    
    $authors_posts = get_posts( array( 'author' => $userid, 'post__not_in' => array( $post->ID ), 'posts_per_page' => 1, 'post_type' => THEME_TAXONOMY."_type", "orderby" => "rand" ) );
    foreach ( $authors_posts as $p ) {
    ?> 
    <div class="row clearfix">
        <div class="col-md-4 hidden-sm hidden-xs">
        <a href="<?php echo get_permalink( $p->ID ); ?>" class="frame">
      
        <?php echo $CORE->GETIMAGE($p->ID); ?>
        </a>
        </div>
        <div class="col-md-8 col-sm-12 col-xs-12">
        
        <div class="title">
        <a href="<?php echo get_permalink( $p->ID ); ?>"> <?php echo apply_filters( 'the_title', $p->post_title, $p->ID ); ?> </a>
        </div>
       
        <span class="wlt_shortcode_excerpt"><?php echo substr(strip_tags(apply_filters( 'the_content', $p->post_content, $p->ID )), 0, 80); ?>...</span>
        </div>
    </div>
    
    <?php } ?>
    <hr />
    
    <div class="bot"><a href="<?php echo get_home_url(); ?>/?s=&uid=<?php echo $post->post_author; ?>"><?php echo $CORE->_e(array('account','15')); ?></a></div>

</div>

<?php } ?>

</div>
                  
         
<?php
    }

}

/* =============================================================================
	2.  CATEGORIES WIDGET CLASS
	========================================================================== */
class core_widgets_categories extends WP_Widget { // UPDATED 6TH JULY
    function core_widgets_categories() {
        // widget actual processes		
		$opts = array(
			'classname' => 'core_widgets_categories',
			'description' => __( 'A list of listing categories.' )
		);
		parent::__construct( 'core_widgets_categories', __( '&#9658; Categories' ), $opts );		
    }
    function form($instance) {	
 		$defaults = array(
			'title'		=> 'Website Categories',		
		);		
		$instance = wp_parse_args( $instance, $defaults );  	
	 ?>
     
 	<p><b>Title</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
  
     <?php
  	$out = '<br /><br /><p>
	<input id="' . $this->get_field_id('f') . '" name="' . $this->get_field_name('f') . '" type="checkbox" ' . checked(isset($instance['f'])? $instance['f']: 0, true, false) . ' /> Show Count &nbsp;&nbsp;&nbsp; <br>
	<input id="' . $this->get_field_id('ff') . '" name="' . $this->get_field_name('ff') . '" type="checkbox" ' . checked(isset($instance['ff'])? $instance['ff']: 0, true, false) . ' /> Show Full List (expanded) <br>
	<input id="' . $this->get_field_id('empty') . '" name="' . $this->get_field_name('empty') . '" type="checkbox" ' . checked(isset($instance['empty'])? $instance['empty']: 0, true, false) . ' /> Include Empty Categories
	
	</p>';
	echo  $out; 
    }

	function update( $new, $old )	{	
	
		$clean = $old;		
		$clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';
		$clean['f'] = isset( $new['f'] ) ? '1' : '0';
		$clean['ff'] = isset( $new['ff'] ) ? '1' : '0';	
		$clean['empty'] = isset( $new['empty'] ) ? '1' : '0';	
		return $clean;
	}

    function widget($args, $instance) {

		global $CORE; $STRING = ""; @extract($args); 
		/*** get the menu items **/
		if($instance['empty']){ $hideempty = 0; }else { $hideempty = 1; }
		
		// CHECK FOR COUNT
		if(isset($instance['f']) && $instance['f']){ $show_count = 1; }else{ $show_count = 0; }
		
		$cats = wp_list_categories(array('walker'=> new Walker_Simple_Example1, 'taxonomy' => THEME_TAXONOMY, 'show_count' => $show_count, 'hide_empty' => $hideempty, 'echo' => 0, 'title_li' =>  false, 'show_image' => true) ); 
	 
	 	if(strlen($instance['title']) == 0){ 
		echo "<div class='core_widgets_categories_list normallayout'>".$before_widget; 
		 
		}else{
		echo "<div class='core_widgets_categories_list normallayout'>".$before_widget.$before_title.$instance['title']."</div>"; 
		
		}
		echo '<ul class="list-group clearfix">';
		//<li><a href=""> a aaaa </a></li>
		/*** show full list ***/
		if(isset($instance['ff']) && $instance['ff']){
		$cats = str_replace("children","list-group clearfix children openall",$cats);
		}
		$cats = str_replace("cat-item","list-group-item",$cats);
		/*** display output ***/
		echo $cats;
		echo '</ul>';	
			
		echo $after_widget;		
 
    }

}
class Walker_Simple_Example1 extends Walker_Category {  

     function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) { 
	 	
		$count = "";
	 	if ( ! empty( $args['show_count'] ) ) {
			$count = ' (' . number_format_i18n( $item->count ) . ')';
		} 
 	 	
		$image = ""; $image_style = "";
	 	if ( ! empty( $args['show_image'] ) ) {
		
			// CHECK IF WE HAVE AN ICONS		
			if(isset($GLOBALS['CORE_THEME']['category_icon_small_'.$item->term_id]) && strlen($GLOBALS['CORE_THEME']['category_icon_small_'.$item->term_id]) > 1){	
					
				// CHECK IF ITS A LARGE IMAGE
				if(strpos($GLOBALS['CORE_THEME']['category_icon_small_'.$item->term_id],"http") !== false){
				
				$image = "<img src='".$GLOBALS['CORE_THEME']['category_icon_small_'.$item->term_id]."' />"; $image_style = " withimg48";
				
				}else{
				
				$image = "<i class='fa ".$GLOBALS['CORE_THEME']['category_icon_small_'.$item->term_id]."'></i>"; $image_style = " withimg";
			
				}
			
			
			}
		}
		
        $output .= "<li class=\"list-group-item".$image_style."\"><a href='".esc_url( get_term_link( $item ) )."'>".$image." ".esc_attr( $item->name )."</a>".$count;
    }  

    function end_el(&$output, $item, $depth=0, $args=array(), $id = 0) {  
        $output .= "</li>\n";  
    }  
} 

/* =============================================================================
  [FRAMEWORK] BOOTSTRAP MENU WALKER FOR WORDPRESS
   ========================================================================== */
class Bootstrap_Walker extends Walker_Nav_Menu {     
     
        /* Start of the <ul> 
         * 
         * Note on $depth: Counterintuitively, $depth here means the "depth right before we start this menu".  
         *                   So basically add one to what you'd expect it to be 
         */         
        function start_lvl(&$output, $depth = 0, $args = array()) 
        {
		
            $tabs = str_repeat("\t", $depth); 
            // If we are about to start the first submenu, we need to give it a dropdown-menu class 
			if(!isset($GLOBALS['flasg_smalldevicemenubar'])){ $mname = "dropdown-menu"; } else { $mname = "smalldevice_dropmenu"; }
			
				if ( ( $depth == 0 || $depth == 1 ) ) { //really, level-1 or level-2, because $depth is misleading here (see note above) 
					$output .= "\n{$tabs}<ul class=\"".$mname."\">\n"; 
				} else { 
					$output .= "\n{$tabs}<ul>\n"; 
				}
			 
            return;
        } 
         
        /* End of the <ul> 
         * 
         * Note on $depth: Counterintuitively, $depth here means the "depth right before we start this menu".  
         *                   So basically add one to what you'd expect it to be 
         */         
        function end_lvl(&$output, $depth = 0, $args = array())  
        {
		
            if ($depth == 0) { // This is actually the end of the level-1 submenu ($depth is misleading here too!) 
                 
                // we don't have anything special for Bootstrap, so we'll just leave an HTML comment for now 
                $output .= '<!--.dropdown-->'; 
            } 
            $tabs = str_repeat("\t", $depth); 
            $output .= "\n{$tabs}</ul>\n"; 
            return; 
        }
                 
        /* Output the <li> and the containing <a> 
         * Note: $depth is "correct" at this level 
         */         
        function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)  
        {    
            global $wp_query;
			 
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : ''; 
            $class_names = $value = ''; 
            $classes = empty( $item->classes ) ? array() : (array) $item->classes; 

            /* If this item has a dropdown menu, add the 'dropdown' class for Bootstrap */ 
			
            if ($item->hasChildren) { 
                $classes[] = 'dropdown'; 
                // level-1 menus also need the 'dropdown-submenu' class 
                if($depth == 1) { 
                    $classes[] = 'dropdown-submenu'; 
                } 
            } 
			

            /* This is the stock Wordpress code that builds the <li> with all of its attributes */ 
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ); 
            $class_names = ' class="' . esc_attr( $class_names ) . '"'; 
            $output .= $indent . '<li ' . $value . $class_names .'>';  //id="menu-item-'. $item->ID . '"    
			         
            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : ''; 
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : ''; 
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : ''; 
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : ''; 
            $item_output = $args->before; 
			
			// CUSTOM ICON
			$customicon = "";
			if($item->post_excerpt != "" && strpos($item->post_excerpt,"fa") !== false){
			$customicon = $item->post_excerpt." ";
			}
                    
            /* If this item has a dropdown menu, make clicking on this link toggle it */ 
            if ($item->hasChildren && $depth == 0 && !isset($GLOBALS['flasg_smalldevicemenubar']) ) { 
                $item_output .= '<a '. $attributes .' class="dropdown-toggle" data-hover="dropdown" data-delay="500" data-close-others="false">';	 //  data-toggle="dropdown"			
				 
            } else { 
                $item_output .= '<a'. $attributes .'>'; 
            }
	  		$iconpack = false;	
			// ADD ON CATEGORY ICON
			if($item->type == "taxonomy" && $item->object == THEME_TAXONOMY && $GLOBALS['CORE_THEME']['menucategoryicon'] == '1' && !isset($GLOBALS['flasg_smalldevicemenubar']) ){  
				
				$IMG_PATH = $GLOBALS['CORE_THEME']['category_icon_'.$item->object_id];
				if(strlen($IMG_PATH) > 1){		
					if(strpos($IMG_PATH,"iconpack1") !== false){ 
						$f = explode("iconpack1/",$IMG_PATH);	
						$iconpack = true;					 						
						$item_output .="<span class='iconpack1 iconpack_".str_replace(".png","",$f[1])."'>".$item->title."</span>";
					
					}else{ 
					$item_output .= "<img src='".$IMG_PATH."' alt='cat icon' class='menucaticon' />";	
					} 		
							 
				}
								
				if( $GLOBALS['CORE_THEME']['menucategoryiconnotext'] == '1' && !isset($GLOBALS['flasg_smalldevicemenubar']) ){
				
				}else{
				if(strlen($IMG_PATH) > 1){ if($iconpack){ $ec = " class='withicon1'"; }else{ $ec = " class='withicon'"; } }else{ $ec = "";  }
				$item_output .= $args->link_before . apply_filters( 'the_title', "<span".$ec.">".$item->title."</span>", $item->ID ) . $args->link_after; 
				} 
				
			}else{
			$item_output .= $args->link_before . apply_filters( 'the_title', "<span>".$customicon.$item->title."</span>", $item->ID ) . $args->link_after; 
			}
		 
            /* Output the actual caret for the user to click on to toggle the menu */             
            if ($item->hasChildren && $depth == 0) { 
				 
				$item_output .= '</a>'; //
			 
				//$item_output .= ' <b class="caret"></b></a>'; //
				 
                
            } else { 
                $item_output .= '</a>'; 
            } 

            $item_output .= $args->after; 
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args ); 
            return; 
        }
        
        /* Close the <li> 
         * Note: the <a> is already closed 
         * Note 2: $depth is "correct" at this level 
         */         
        function end_el (&$output, $item, $depth  = 0, $args = array() )
        {
            $output .= '</li>'; 
            return;
        } 
         
        /* Add a 'hasChildren' property to the item 
         * Code from: http://wordpress.org/support/topic/how-do-i-know-if-a-menu-item-has-children-or-is-a-leaf#post-3139633  
         */ 
        function display_element ($element, &$children_elements, $max_depth, $depth = 0, $args = array(), &$output) 
        { 
            // check whether this item has children, and set $item->hasChildren accordingly 
            $element->hasChildren = isset($children_elements[$element->ID]) && !empty($children_elements[$element->ID]); 

            // continue with normal behavior 
            return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output); 
        }         
}
/* =============================================================================
RECENT BLOG POSTS
========================================================================== */
class core_widgets_blogposts extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     */
    function core_widgets_blogposts() {
        $widget_ops = array('classname' => 'wlt-blogposts', 'description' => 'This will display a list of blog posts.');
        $this->WP_Widget( 'wlt-blogposts', '&#9658; Blog Posts', $widget_ops );
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array $args An array of standard parameters for widgets in this theme
     * @param array $instance An array of settings for this widget instance
     * @return void Echoes it's output
     */
    function widget( $args, $instance ) { global $wpdb, $CORE;
        extract( $args, EXTR_SKIP );

        $title = apply_filters( 'widget_title', $instance['title'] );

        extract( $instance );
        echo str_replace('panel-default','panel-default core_widgets_blogposts',$before_widget);
        if ( $title ) {
            echo $before_title . $title ."</div>";
        }

     	$SQL = "SELECT * FROM ".$wpdb->prefix."posts WHERE post_type='post' and post_status='publish' ORDER BY ID DESC LIMIT ".$instance['num'];	
 
		$result = $wpdb->get_results($SQL);
		if(!empty($result)){
		
		 	echo '<ul class="list-group clearfix">';
			$tc = count($result); $i = 1;			
			
			// WORK OUT IMAGE SIZE
			$imgSize = 75;			 
			
			foreach($result as $comment){
		 			
								
				// GET POST
				$p = get_post($comment->ID);
				
				// IMAGE
				$image = hook_image_display(get_the_post_thumbnail($p->ID, 'thumbnail', array('class'=> "wlt_thumbnail img-responsive")));			
				if($image == ""){$image = hook_fallback_image_display($CORE->FALLBACK_IMAGE($p->ID)); }	
			  
				echo '<li class="list-group-item"><div class="row clearfix">
				
				<div class="col-md-3"><a href="'.get_permalink($p->ID).'" class="title">'.$image.'</a></div>
				<div class="col-md-9">
				
				<a href="'.get_permalink($p->ID).'" class="title">'.$p->post_title.'</a>
				  
				 <div class="clearfix"></div>
				 <small>'.hook_date($p->post_date).'</small> 
				 
				 </div></div></li>'; 
			 $i++;
			}
		 echo '</ul>';
		}
		
		if ( $title ) {
		echo "</div>";
		}else{
        echo $after_widget;
        }
    }

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array $new_instance An array of new settings as submitted by the admin
     * @param array $old_instance An array of the previous settings
     * @return array The validated and (if necessary) amended settings
     */
    function update( $new_instance, $old_instance ) {
        // update logic goes here
        $updated_instance = $new_instance;
        return $updated_instance;
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array $instance An array of the current settings for this widget
     * @return void Echoes it's output
     */
    function form( $instance ) {
	
        $default = array(
            'title' => 'Recent Blog Posts',
            'num' => '5',             
        );

        $instance = wp_parse_args( (array) $instance, $default );
        extract( $instance );
        ?>
        <p>
            <label>Title: </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p> 
      
        <p>
            <label>Display #: </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'num' ); ?>" name="<?php echo $this->get_field_name( 'num' ); ?>" type="text" value="<?php echo $num; ?>" />
        </p>       
        <?php
    }

}
/* =============================================================================
USER COMMENTS WIDGET
========================================================================== */
class core_widgets_comments extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     */
    function core_widgets_comments() {
        $widget_ops = array('classname' => 'wlt-comments', 'description' => 'This will display a list of user comments.');
        $this->WP_Widget( 'wlt-comments', '&#9658; User Comments', $widget_ops );
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array $args An array of standard parameters for widgets in this theme
     * @param array $instance An array of settings for this widget instance
     * @return void Echoes it's output
     */
    function widget( $args, $instance ) { global $wpdb;
        extract( $args, EXTR_SKIP );

        $title = apply_filters( 'widget_title', $instance['title'] );

        extract( $instance );
        echo str_replace('panel panel-default','panel panel-default core_widgets_comments',$before_widget);
        if ( $title ) {
            echo $before_title . $title . "</div>";
        }

     	$SQL = "SELECT * FROM ".$wpdb->prefix."comments WHERE comment_approved=1 ORDER BY comment_ID DESC LIMIT ".$instance['num'];	
 
		$result = $wpdb->get_results($SQL);
		if(!empty($result)){
		 	echo '<ul class="list-group clearfix">';
			$tc = count($result); $i = 1;			
			
			// WORK OUT IMAGE SIZE
			if(isset($GLOBALS['3COLUMNS_FLAG'])){
				$imgSize = 50;
			}else{
				$imgSize = 75;
			}
			
			foreach($result as $comment){				
								
				// GET POST
				$p = get_post($comment->comment_post_ID);
			 	 
				echo '<li class="list-group-item"><div class="row clearfix">
				<div class="col-md-4 hidden-sm hidden-xs"><a href="'.get_permalink($p->ID).'" class="title">'.get_avatar( $comment->user_id, $imgSize ).'</a></div>
				<div class="col-md-8 col-sm-12">
				<p><strong><a href="'.get_permalink($p->ID).'" class="title">'.$p->post_title.'</a></strong></p>
				<div class="clearfix"></div>
				<i class="fa fa-quote-left"></i><span class="quote"> '.substr(strip_tags($comment->comment_content),0,200).' </span><i class="fa fa-quote-right"></i> 
				<div class="clearfix"></div>
				<span class="author">- '.get_the_author_meta( 'display_name', $comment->user_id).'</span> </div>
				</div></li>'; 
			 $i++;
			}
		 echo '</ul>';
		}
		
		if ( $title ) {
		echo "</div>";
		}else{
        echo $after_widget;
		}
        
    }

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array $new_instance An array of new settings as submitted by the admin
     * @param array $old_instance An array of the previous settings
     * @return array The validated and (if necessary) amended settings
     */
    function update( $new_instance, $old_instance ) {
        // update logic goes here
        $updated_instance = $new_instance;
        return $updated_instance;
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array $instance An array of the current settings for this widget
     * @return void Echoes it's output
     */
    function form( $instance ) {
	
        $default = array(
            'title' => 'User Comment',
            'num' => '5',             
        );

        $instance = wp_parse_args( (array) $instance, $default );
        extract( $instance );
        ?>
        <p>
            <label>Title: </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p> 
      
        <p>
            <label>Display #: </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'num' ); ?>" name="<?php echo $this->get_field_name( 'num' ); ?>" type="text" value="<?php echo $num; ?>" />
        </p>       
        <?php
    }

}
/* =============================================================================
ADVANCED SEARCH WIDGET
========================================================================== */
class Core_Advanced_Search_Widget extends WP_Widget {

    /**
     * Constructor
     *
     * @return void
     */
    function Core_Advanced_Search_Widget() {
        $widget_ops = array('classname' => 'advanced-search', 'description' => 'Advanced search widget');
        $this->WP_Widget( 'advanced-search', '&#9658; Advance Search', $widget_ops );
    }

    /**
     * Outputs the HTML for this widget.
     *
     * @param array $args An array of standard parameters for widgets in this theme
     * @param array $instance An array of settings for this widget instance
     * @return void Echoes it's output
     */
    function widget( $args, $instance ) {
        extract( $args, EXTR_SKIP );

        $title = apply_filters( 'widget_title', $instance['title'] );

        extract( $instance );
        echo str_replace('panel panel-default"','panel panel-default" id="core_advanced_search_widget_box"',$before_widget);
        if ( $title ) {
            echo $before_title . $title . "</div>";
        }

        $advance_search = Core_Advanced_Search::instance();
        echo $advance_search->build_form( null, $submit );
		
		 if ( $title ) {
		 echo "</div>";
		 }else{
         echo $after_widget;
		 }
        
    }

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array $new_instance An array of new settings as submitted by the admin
     * @param array $old_instance An array of the previous settings
     * @return array The validated and (if necessary) amended settings
     */
    function update( $new_instance, $old_instance ) {
        // update logic goes here
        $updated_instance = $new_instance;
        return $updated_instance;
    }

    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array $instance An array of the current settings for this widget
     * @return void Echoes it's output
     */
    function form( $instance ) {
        $default = array(
            'title' => 'Advanced Search',
            'submit' => 'Search',             
        );

        $instance = wp_parse_args( (array) $instance, $default );
        extract( $instance );
        ?>
        <p>
            <label><?php _e( 'Title:', 'wedevs' ); ?> </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
        </p> 
      
        <p>
            <label><?php _e( 'Submit Button', 'wedevs' ); ?> </label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'submit' ); ?>" name="<?php echo $this->get_field_name( 'submit' ); ?>" type="text" value="<?php echo $submit; ?>" />
        </p>
        <?php
    }

}
 
/* =============================================================================
	  LISTINGS WIDGET CLASS
	========================================================================== */
class core_widgets_listings extends WP_Widget { // UPDATED 6TH JULY
    function core_widgets_listings() {
        // widget actual processes		
		$opts = array(
			'classname' => 'core_widgets_listings',
			'description' => __( 'A custom list of website listings.' )
		);
		parent::__construct( 'core_widgets_listings', __( '&#9658; Listings' ), $opts );	
    }
    function form($instance) {	
 		$defaults = array(
			'title'		=> 'Featured Listing',	
			'sq'		=> 'post_type='.THEME_TAXONOMY.'_type&posts_per_page=10',
			'te'		=> '<b>[TITLE]</b> [EXCERPT size=100]',	
			'image'		=> false,		
		);		
		$instance = wp_parse_args( $instance, $defaults ); 
	?>     
 	<p><b>Title</b></p>
	<p><input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>
 	
    
    <p><b>Custom Query (<a href="http://codex.wordpress.org/Function_Reference/query_posts" target="_blank">example info</a>)</b></p>
        <select onChange="jQuery('#<?php echo $this->get_field_id( 'sq' ); ?>').val(this.value);">
        <option value="">--- sample query strings ---</option>
        <option value="meta_key=featured&amp;meta_value=yes&post_type=<?php echo THEME_TAXONOMY; ?>_type&amp;posts_per_page=10">Only Featured Listings</option>
        <option value="meta_key=frontpage&amp;meta_value=yes&post_type=<?php echo THEME_TAXONOMY; ?>_type&amp;posts_per_page=10">Only Frontpage Enhanced Listings</option>
        <option value="orderby=IDorder=desc&post_type=<?php echo THEME_TAXONOMY; ?>_type&amp;posts_per_page=10">Latest Listings</option>
        <option value="orderby=rand&post_type=<?php echo THEME_TAXONOMY; ?>_type&amp;posts_per_page=10">Random Listings</option>
        <option value="meta_key=hits&amp;orderby=meta_value_num&amp;order=desc&amp;post_type=<?php echo THEME_TAXONOMY; ?>_type&amp;posts_per_page=10">Popular Listings</option>
        </select>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'sq' ); ?>" name="<?php echo $this->get_field_name( 'sq' ); ?>" value="<?php echo esc_attr( $instance['sq'] ); ?>" /> <br /> 	
    <p><br /><b>Custom Content</b> <textarea class="widefat" rows="16" cols="20" style="height:70px;" id="<?php echo $this->get_field_id( 'te' ); ?>" name="<?php echo $this->get_field_name( 'te' ); ?>"><?php echo esc_attr( $instance['te'] ); ?></textarea></p>
 <?php 
 	$out = '<p><input id="' . $this->get_field_id('image') . '" name="' . $this->get_field_name('image') . '" type="checkbox" ' . checked(isset($instance['image'])? $instance['image']: 0, true, false) . ' /> Show listing image </p><hr />';
	$out .= '<br /><p>
	<input id="' . $this->get_field_id('f') . '" name="' . $this->get_field_name('f') . '" type="checkbox" ' . checked(isset($instance['f'])? $instance['f']: 0, true, false) . ' /> Featured Only &nbsp;&nbsp;&nbsp;
	<input id="' . $this->get_field_id('ff') . '" name="' . $this->get_field_name('ff') . '" type="checkbox" ' . checked(isset($instance['ff'])? $instance['ff']: 0, true, false) . ' /> Front Page Only 
	</p>';
	echo  $out; 	
	
    }
	function update( $new, $old )
	{	
	
		$clean = $old;		
		$clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';
		$clean['sq'] = isset( $new['sq'] ) ?  esc_html( $new['sq'] )  : '';	
  		$clean['image'] = isset( $new['image'] ) ? '1' : '0';
		$clean['f'] = isset( $new['f'] ) ? '1' : '0';
		$clean['ff'] = isset( $new['ff'] ) ? '1' : '0';		
		if (current_user_can('unfiltered_html')) {
		  $clean['te'] = $new['te'];
		} else {
		  $clean['te'] = stripslashes(wp_filter_post_kses(addslashes($new['te'])));
		}
		return $clean;
	}

    function widget($args, $instance) {

		global $CORE, $post, $wp_query; $STRING = ""; $image = ""; @extract($args);  
		if(!isset($instance['sq'])){ $instance['sq']=""; } 
		
		// BUILD QUERY
		$qstring = str_replace("&amp;","&",$instance['sq']); 
		$qstring = str_replace("&&","&",$qstring);
		if(isset($instance['f']) && $instance['f']){ $qstring .= "&post_type=".THEME_TAXONOMY."_type&meta_key=featured&meta_value=yes"; }
		if(isset($instance['ff']) && $instance['ff']){ $qstring .= "&post_type=".THEME_TAXONOMY."_type&meta_key=frontpage&meta_value=yes"; }
 
 		$args = hook_custom_queries($qstring);
		 
		$the_query = new WP_Query($args);	 
 		// CHECK WE HAVE RESULTS
		if(count($the_query->posts) > 0 ){ //meta_value_num
		
			// 1. DISPLAY TITLE
			echo "<div class='core_widgets_listings'>".$before_widget.$before_title.$instance['title'];
			
			// 2. AFTER TITLE
			echo "</div>";
			
			// 3. LISTINGS
			echo "<ul class='list-group'>";
			
			$GLOBALS['IS_WIDGET'] = TRUE;			
			foreach($the_query->posts as $post){
			
			if($post->post_type != THEME_TAXONOMY."_type"){ continue; }
		 		
				global $post;			 		
											
				if(isset($instance['image']) && $instance['image'] == 1){
					$image = hook_image_display(get_the_post_thumbnail($post->ID, 'thumbnail', array('class'=> "wlt_thumbnail img-responsive")));			
					if($image == ""){$image = hook_fallback_image_display($CORE->FALLBACK_IMAGE($post->ID)); }							 
					echo "<li class='list-group-item'><div class='row clearfix'><div class='col-md-4 hidden-sm hidden-xs'><a href='".get_permalink($post->ID)."' class='frame'>".$image."</a></div>
					<div class='col-md-8 col-sm-12 col-xs-12'>".$CORE->ITEM_CONTENT($post, str_replace("[ID]",$post->ID,$instance['te']))."</div></div></li>";
				}else{
					echo "<li class='list-group-item'>".$CORE->ITEM_CONTENT($post, $instance['te'])."</li>";	
				}// end if
				 
				
			}// end foreach			 
			unset($GLOBALS['IS_WIDGET']);
			
			// END LISTINGS
			echo "</ul>";
			echo $after_widget; 
		}
		wp_reset_postdata();		 
		 
    }
}

/* =============================================================================
	 BLANK WIDGET CLASS
	========================================================================== */
class core_widgets_blank extends WP_Widget {

    function core_widgets_blank() {
        // widget actual processes		
		$opts = array(
			'classname' => 'core_blank',
			'description' => __( 'A blank space for custom Text/HTML code.' )
		);
		parent::__construct( 'core_blank', __( '&#9658; Blank Widget Area' ), $opts );		
    }
    function form($instance) {   
		$instance = wp_parse_args( $instance, $defaults );		
	 ?>
     <p><b>Content:</b></p>  
  	 <p><textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'te' ); ?>" name="<?php echo $this->get_field_name( 'te' ); ?>"><?php echo esc_attr( $instance['te'] ); ?></textarea></p>
     <?php

		$out = '<p><label for="' . $this->get_field_id('filter') . '">Automatically add paragraphs to text</label>&nbsp;&nbsp;';
		$out .= '<input id="' . $this->get_field_id('filter') . '" name="' . $this->get_field_name('filter') . '" type="checkbox" ' . checked(isset($instance['filter'])? $instance['filter']: 0, true, false) . ' /></p>';
		echo $out;
    }
	function update( $new, $old )
	{	
		$clean = $old;
		if (current_user_can('unfiltered_html')) {
		  $clean['te'] = $new['te'];
		} else {
		  $clean['te'] = stripslashes(wp_filter_post_kses(addslashes($new['te'])));
		}
		
		$clean['filter'] = isset($new['filter']);		
		return $clean;
	}
    function widget($args, $instance) {
        // outputs the content of the widget
		
	global $PPT,$CORE; $STRING = ""; @extract($args);
	  
	if ($instance['filter']) {
      $instance['te'] = wpautop($instance['te']);
    }
		echo do_shortcode(stripslashes($instance['te'])); 
 
    }

}
 
/* =============================================================================
	  MAILING LIST WIDGET CLASS
	========================================================================== */
class core_widgets_mailinglist extends WP_Widget {

    function core_widgets_mailinglist() {
        // widget actual processes		
		$opts = array(
			'classname' => 'core_widgets_mailinglist',
			'description' => __( 'Email form for joining your mailing list.' )
		);
		parent::__construct( 'core_widgets_mailinglist', __( '&#9658; Mailing List' ), $opts );		
    }

    function form($instance) {   
		$instance = wp_parse_args( $instance, $defaults );		
	 ?>
     <p><b>Title</b></p>
	<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    
    <br /><p><b>Extra Content (Message/HTML/Shortcodes):</b></p>  
  	<p><textarea class="widefat" style="height:50px;" id="<?php echo $this->get_field_id( 'te' ); ?>" name="<?php echo $this->get_field_name( 'te' ); ?>"><?php echo esc_attr( $instance['te'] ); ?></textarea></p>
  
     <?php

		$out = '<p><label for="' . $this->get_field_id('filter') . '">Automatically add paragraphs to text</label>&nbsp;&nbsp;';
		$out .= '<input id="' . $this->get_field_id('filter') . '" name="' . $this->get_field_name('filter') . '" type="checkbox" ' . checked(isset($instance['filter'])? $instance['filter']: 0, true, false) . ' /></p>';
		
		$out .= '<br /> <b>Display Format</b> <hr />
		
		<input name="' . $this->get_field_name('ff') . '" type="radio" value="1" ' . checked(isset($instance['ff'])? $instance['ff']: 1, 1, false) . ' /> Normal Form <hr /> 
		
		<input name="' . $this->get_field_name('ff') . '" type="radio" value="2" ' . checked(isset($instance['ff'])? $instance['ff']: 2, 2, false) . ' />		
		<img src="'.get_bloginfo('template_url').'/framework/img/forms/mailinglist1.png" style="max-height:100px; max-width:150px;">
		<hr />

		<input name="' . $this->get_field_name('ff') . '" type="radio" value="3" ' . checked(isset($instance['ff'])? $instance['ff']: 3, 3, false) . ' />		
		<img src="'.get_bloginfo('template_url').'/framework/img/forms/mailinglist2.png" style="max-height:100px; max-width:150px;">
		<hr />
		
		<input name="' . $this->get_field_name('ff') . '" type="radio" value="4" ' . checked(isset($instance['ff'])? $instance['ff']: 4, 4, false) . ' />		
		<img src="'.get_bloginfo('template_url').'/framework/img/forms/mailinglist3.png" style="max-height:100px; max-width:150px;">
		<hr />	
		
		<input name="' . $this->get_field_name('ff') . '" type="radio" value="5" ' . checked(isset($instance['ff'])? $instance['ff']: 5, 5, false) . ' />		
		<img src="'.get_bloginfo('template_url').'/framework/img/forms/mailinglist4.png" style="max-height:100px; max-width:150px;">
		<hr />	
		
		<input name="' . $this->get_field_name('ff') . '" type="radio" value="6" ' . checked(isset($instance['ff'])? $instance['ff']: 6, 6, false) . ' />		
		<img src="'.get_bloginfo('template_url').'/framework/img/forms/mailinglist5.png" style="max-height:100px; max-width:150px;">
		<hr />	
		
		
		<input name="' . $this->get_field_name('ff') . '" type="radio" value="7" ' . checked(isset($instance['ff'])? $instance['ff']: 7, 7, false) . ' />		
		<img src="'.get_bloginfo('template_url').'/framework/img/forms/mailinglist6.png" style="max-height:100px; max-width:150px;">
		<hr />	
		
		
		<input name="' . $this->get_field_name('ff') . '" type="radio" value="8" ' . checked(isset($instance['ff'])? $instance['ff']: 8, 8, false) . ' />		
		<img src="'.get_bloginfo('template_url').'/framework/img/forms/mailinglist7.png" style="max-height:100px; max-width:150px;">
		<hr />	
		
		<input name="' . $this->get_field_name('ff') . '" type="radio" value="9" ' . checked(isset($instance['ff'])? $instance['ff']: 9, 9, false) . ' />		
		<img src="'.get_bloginfo('template_url').'/framework/img/forms/mailinglist8.png" style="max-height:100px; max-width:150px;">
		<hr />	
		
		
		<input name="' . $this->get_field_name('ff') . '" type="radio" value="10" ' . checked(isset($instance['ff'])? $instance['ff']: 10, 10, false) . ' />		
		<img src="'.get_bloginfo('template_url').'/framework/img/forms/mailinglist9.png" style="max-height:100px; max-width:150px;">
		<hr />			
					
		</p>';
		echo $out;


    }

	function update( $new, $old )
	{	
		$clean = $old;		
		if (current_user_can('unfiltered_html')) {
		  $clean['te'] = $new['te'];
		} else {
		  $clean['te'] = stripslashes(wp_filter_post_kses(addslashes($new['te'])));
		}
		$clean['ff'] 		= $new['ff'];
		$clean['filter'] 	= isset($new['filter']);
		$clean['title'] 	= isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';		
		return $clean;
	}

    function widget($args, $instance) {
        // outputs the content of the widget
		
	global $PPT,$CORE; $STRING = ""; @extract($args); 
	
	// FILTER TEXT
	if (isset($instance['filter']) && $instance['filter']) { $instance['te'] = wpautop($instance['te']); }
		
		if(isset($instance['ff']) && $instance['ff'] != 1){ ?>
		
        <div id="mailinglist<?php echo $instance['ff']; ?>" class="wlt_widget_mailinglist">
        
        <h2><?php echo $instance['title']; ?></h2>
         <div class="msg"><?php echo $instance['te']; ?></div>
         <form class="form-search" id="mailinglist-form" name="mailinglist-form" method="post" onSubmit="return IsEmailMailinglist();">
         
        
        <div class="input-group">
 <input type="text" class="form-control" name="wlt_mailme" id="wlt_mailme" placeholder="<?php echo $CORE->_e(array('button','29','flag_noedit')); ?>">
            
  <span class="input-group-addon"> <button  type="submit"><?php echo $CORE->_e(array('widgets','19','flag_noedit')); ?></button>  </span>
</div>

 <div class="clearfix"></div>  
         
        </form>        
        </div>
		
		<?php }else{	
		echo "<div id='core_widgets_mailinglist' class='hidden-sm hidden-xs'>".$before_widget.$before_title.$instance['title'].$after_title;		  
		
		echo do_shortcode($instance['te']); 
		?>
        <form class="form-search" id="mailinglist-form" name="mailinglist-form" method="post" onSubmit="return IsEmailMailinglist();">
          <input type="text" class="form-control input-sm" name="wlt_mailme" id="wlt_mailme" placeholder="<?php echo $CORE->_e(array('button','29','flag_noedit')); ?>">
          <input type="submit" class="btn btn-default" value="<?php echo $CORE->_e(array('button','28')); ?>">
        </form>
        <?php echo $after_widget."</div>";		
		}// END OF FORMS ?>
        
        <script type="application/javascript">
		function IsEmailMailinglist(){
		var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
			var de4 	= document.getElementById("wlt_mailme");
			if(de4.value == ''){
			alert('<?php echo $CORE->_e(array('validate','0')); ?>');
			de4.style.border = 'thin solid red';
			de4.focus();
			return false;
			}
			if( !pattern.test( de4.value ) ) {	
			alert('<?php echo $CORE->_e(array('validate','0')); ?>');
			de4.style.border = 'thin solid blue';
			de4.focus();
			return false;
			}
			
			WLTMailingList('<?php echo str_replace("http://","",get_home_url()); ?>', this.wlt_mailme.value, 'mailinglist-form');	 
		  	return false;
		}		
		 </script>
		<?php 
    }	
}
/* =============================================================================
	  MEMBERSHIPS WIDGET CLASS
	========================================================================== */
class core_widgets_memberships extends WP_Widget {

    function core_widgets_memberships() {
        // widget actual processes		
		$opts = array(
			'classname' => 'core_memberships',
			'description' => __( 'A list of membership packages.' )
		);
		parent::__construct( 'core_memberships', __( '&#9658; Membership List' ), $opts );
		
    }

    function form($instance) {
   
		$instance = wp_parse_args( $instance, $defaults );
		
	 ?>
<p><b>Title</b></p>
<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    
     
<p><b>Additional Content (shown before the list):</b></p>
<p><textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id( 'te' ); ?>" name="<?php echo $this->get_field_name( 'te' ); ?>"><?php echo esc_attr( $instance['te'] ); ?></textarea></p>
  
     <?php
	
		$out = '<p><label for="' . $this->get_field_id('filter') . '">Automatically add paragraphs to text</label>&nbsp;&nbsp;';
		$out .= '<input id="' . $this->get_field_id('filter') . '" name="' . $this->get_field_name('filter') . '" type="checkbox" ' . checked(isset($instance['filter'])? $instance['filter']: 0, true, false) . ' /></p>';
		
		echo $out;


    }

	function update( $new, $old )
	{	
		$clean = $old;		
		  
		 
		if (current_user_can('unfiltered_html')) {
		  $clean['te'] = $new['te'];
		} else {
		  $clean['te'] = stripslashes(wp_filter_post_kses(addslashes($new['te'])));
		}
		
		$clean['filter'] = isset($new['filter']);
		$clean['title'] = isset( $new['title'] ) ? strip_tags( esc_html( $new['title'] ) ) : '';
		
		return $clean;
	}

    function widget($args, $instance) {
	  
		global $CORE; $STRING = ""; @extract($args); $membershipfields = get_option("membershipfields");
		
		if ($instance['filter']) {
		  $instance['te'] = wpautop($instance['te']);
		}
		
		if($userdata->ID && !isset($GLOBALS['current_membership'])){$GLOBALS['current_membership'] = get_user_meta($userdata->ID,'wlt_membership',true);}
		
		if($GLOBALS['current_membership'] > 0){ return; }
		
		echo "<div id='core_widgets_membershiplist'>".$before_widget.$before_title.$instance['title']."</div>";		
		
		if(strlen($instance['te']) > 2){
		echo "<div class='panel-body'>".$instance['te']."</div>";
		}
		
	    if(is_array($membershipfields) && count($membershipfields) > 0 ){ 
		
	   		echo "<ul class='list-group'>";
			$membershipfields = $CORE->multisort( $membershipfields , array('order') );	
			foreach($membershipfields as $field){
			
			if(isset($field['hidden']) && $field['hidden'] == "yes"){ continue; }
					
				echo "<li class='list-group-item'>";
				echo "<strong>".$field['name']."</strong>";
				echo "<div class='mcontent'>";
				echo "<p> ".str_replace("%a",$field['expires'],$CORE->_e(array('widgets','1')))."</p>";
				echo "<div class='row'><div class='col-md-6'><a class='btn btn-default' href='javascript:void(0);' onclick=\"document.getElementById('membershipID1').value='".$field['ID']."';document.MEMBERSHIPFORM1.submit();\">".$CORE->_e(array('add','3'))."</a></div>";
				echo '<div class="col-md-6"><a class="btn btn-default" href="#myModal'.$field['ID'].'" role="button"  data-toggle="modal">'.$CORE->_e(array('add','2')).'</a></div>';
				echo "</div><div class='clearfix'></div></div>";
		 			
	 
		echo '<!----------------------- MODULA WINDOW ------------------------->
		<div id="myModal'.$field['ID'].'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog"><div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h4 id="myModalLabel">'.$field['name'].' ('.hook_price($field['price']).')</h4>
		  </div>
		  <div class="modal-body">
			<p>'.stripslashes($field['description']).'</p>			
		  </div>
		  <div class="modal-footer">
			<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">'.$CORE->_e(array('add','4')).'</button>
		  </div>
		</div>
		</div></div>
		<!----------------------- MODULA WINDOW -------------------------> ';  
				
				
				
				echo "</li>";
			}
			echo "</ul>";	
				
	    }  
		echo $after_widget;
		
		echo '<!-- memberships payment form -->
		<form method="post" name="MEMBERSHIPFORM1" action="'.$GLOBALS['CORE_THEME']['links']['add'].'" id="MEMBERSHIPFORM" style="margin:0px;padding:0px;">
		<input type="hidden" name="membershipID" id="membershipID1" value="-1" />
		</form>'; 
		
 
    }

}
/* =============================================================================
	  WIDGET CLASS FOR SELECTIVE WIDGET AREAS
	========================================================================== */
class wf_wn {
  static $debug_output = '';

  // add hooks and filters
  public static function init() {
    // admin area
    if (is_admin()) {
      // widget related hooks
      add_action('sidebar_admin_setup',    array('wf_wn', 'modify_controls'));
      add_action('in_widget_form',         array('wf_wn', 'form'), 10, 3);
      add_action('widgets_admin_page',     array('wf_wn', 'dialog_container'));
      add_filter('widget_update_callback', array('wf_wn', 'update'), 10, 3);
     
      // server-side AJAX callback
      add_action('wp_ajax_wf_wn_dialog', array('wn_ajax', 'dialog'));
  
    } else { // frontend
      add_filter('widget_display_callback', array('wf_wn', 'widget_display'), 10, 3);
      add_filter('wp_footer', array('wf_wn', 'footer_debug'));
    }
  } // init 
 

  // check if debugging is enabled
  public static function is_debug() {
    if (isset($_GET['wn-debug']) && current_user_can('manage_options')) {
      return true;
    } else {
      return false;
    }
  } // is_debug


  // display debug info in footer
  public static function footer_debug() {
    if (self::is_debug()) {
      echo '<div id="wn_debug" style="clear: both; font-family: monospace; padding: 10px; margin: 10px; border: 1px solid black; background-color: #F9F9F9; color: black;">';
      echo '<b>debug data</b><br />' . self::$debug_output . '</div>';
    }
  } // footer_debug


  // check if widget is enabled on the current page
  // main plugin function, only one used on frontend
  public static function widget_display($instance, $obj, $args) { global $wp_query;
    if (self::is_debug()) {
      self::$debug_output .= '<br />Widget: ' . $obj->name . ($instance['title']? ' (' . $instance['title'] . ')': '') . '; WN operator: ' . ($instance['wn_show']? $instance['wn_show']: 'off') . '<br />';
    }
	
if(!isset($instance['wn_active_hooks'])){ $instance['wn_active_hooks']=""; $instance['wn_show']=""; }

    parse_str($instance['wn_active_hooks'], $ac_hooks);
    $show = strtolower($instance['wn_show']);

    // is Ninja enabled for this widget?
    if (empty($ac_hooks) || empty($show) || !is_array($ac_hooks)) {
      if (self::is_debug()) {
        self::$debug_output .= 'Widget is <b>visible</b><br />';
      }
      return $instance;
    }
 

    foreach($ac_hooks as $condition => $params) {

      // remove 0 from params list
      if ($params[0] == '0') {
        // no aditional params for this conditional
        $params = null;
      } else {
        // explode string by "," so we can get an array of selected items (pages, posts, categories, ...)
        $params = explode(',', $params[0]);
      }
	  
	  	
	  
      if(sizeof($params) == 1) {
        $params = $params[0];
      }

      // if debugging is enabled log each conditional tag call
      if (self::is_debug()) {
        self::$debug_output .= '&nbsp;&nbsp;' . $condition;
        self::$debug_output .= '(' . (is_null($params)? '': print_r($params, true)) . ') == ';
        self::$debug_output .= (call_user_func($condition, $params)? 'true': 'false') . '<br />';
      }
 
      // OR condition
      if ($show == 'or') {
	  
        $show_it = false;
		
		
		// CUSTOM TAXONOMY FOR RESPONSIVE FRAMEWORK
		if($condition == "in_category"){   
		
			$ca = $wp_query->get_queried_object();
		  
			if(isset($ca->term_id) && ( $params == $ca->term_id || (is_array($params) && in_array($ca->term_id,$params)) )){
				$show_it = true;
				break;
			} 
		
		} 
		 
		if($condition == "is_wlt_home_page"){ // CUSOTOM ELEMENTS ADDED BY MARK
		
			if(isset($GLOBALS['flag-home'])){
				$show_it = true;
				break;
			}
			
		}elseif($condition == "is_callback_page"){ // CUSOTOM ELEMENTS ADDED BY MARK
		
			if(isset($GLOBALS['tpl-callback'])){
				$show_it = true;
				break;
			}
			
		}elseif($condition == "is_wlt_blog_page"){ // CUSOTOM ELEMENTS ADDED BY MARK
		
			if(isset($GLOBALS['flag-blog'])){
				$show_it = true;
				break;
			}
					 
        // show widget as soon as one criteria is met
        }elseif (call_user_func($condition, $params)) {		
		 
          $show_it = true;
          break;
        }
		
		
      } elseif ($show == 'and') { // AND condition
	  

        $show_it = true;
		
		// ADDED BY MARK TO STOP HOME PAGE SHOWING INAEGORY 
		if(isset($GLOBALS['flag-home']) && $condition == "in_category"){
		
		 $show_it = false; 
          break;

		} 
		
        // hide widget as soon as one criteria is not met
        if (!call_user_func($condition, $params)) {
          $show_it = false; 
          break;
        }
		//die($GLOBALS['premiumpress']['catID']);
		//die($show_it.print_r($params).$condition);
		
      } elseif ($show == 'not') { // NOT condition
        $show_it = true; 
		
		
        // hide widget as soon as one criteria is met
        if (call_user_func($condition, $params)) {
          $show_it = false;
          break;
        }
      } else { // should never happen but if it does show widget
        $show_it = true;
      }
    } // foreach hook

    if ($show_it) {
      if (self::is_debug()) {
        self::$debug_output .= 'Widget is <b>visible</b><br />';
      }
      return $instance;
    } else {
      if (self::is_debug()) {
        self::$debug_output .= 'Widget is <b>not visible</b><br />';
      }
      return false;
    }
  } // widget_display


  // modify widget controls; force min width to fit WN GUI
  public static function modify_controls() {
    global $wp_registered_widgets, $wp_registered_widget_controls;

    foreach ($wp_registered_widgets as $id => $widget) {
      // check if default widget width is bigger then our custom width
      if ($wp_registered_widget_controls[$id]['width'] < 400) {
        $wp_registered_widget_controls[$id]['width'] = 400;
      }
    } // foreach widget
  } // modify_controls


 // inject help content
  public static function admin_footer() {
  ?>
<div id="wn-help-container" style="display: none;">
  <div id="wn-help-options">
  <ul>
    <li>the widget will be shown on all pages</li>
    <li>logical "or" operator will show the widget if any tag returns <i>true</i></li>
    <li>logical "and" operator will show the widget only if all tags return <i>true</i></li>
    <li>last option, logical "not" displays the widget only if all tags return <i>false</i></li>
  </ul>
  </div>
  
  <div id="wn-help-is_wlt_listing_category">
  <p>Checks if the page being displayed is the search results page.</p>
  </div>

  <div id="wn-help-is_wlt_listing">
  <p>Checks if the page being displayed is a listing description page.</p>
  </div>
  
  <div id="wn-help-is_wlt_blog_page">
  <p>Checks if the page being displayed is the blog page template.</p>
  </div>
  
  <div id="wn-help-is_wlt_home_page">
  <p>Checks if the page being displayed is the home page.</p>
  </div>  
  
  <div id="wn-help-is_page">
  <p>Checks if the page being displayed is the one selected.</p>
  </div>    
  
     
</div>
  <?php
  } // admin_footer

  // generate Widget Ninja GUI
  public static function form($instance, $widget, $widget_option) {
    $active_hooks = array(); 
    $widget_id = $instance->id;
	
	if(!isset($widget_option['wn_show'])){ $widget_option['wn_show'] = ""; }
	if(!isset($widget_option['wn_active_hooks'])){ $widget_option['wn_active_hooks'] = ""; }
	 

    echo '<div class="widget-control-actions">
    <div class="alignright">
      <img alt="" title="" class="ajax-feedback " src="' . admin_url() .'images/wpspin_light.gif" style="visibility: hidden;">
      <input type="submit" value="' . __('Save') . '" class="button-primary widget-control-save" id="savewidget" name="savewidget">
    </div>
    <br class="clear">
    </div>';

    echo '<br /><p><b>Widget Display Options</b></p>';

    // WN status options
    $wn_status[] = array('val' => '',    'label' => 'Show Widget.');
    $wn_status[] = array('val' => 'or',  'label' => 'Show widget if ANY active conditional tag returns TRUE (logical OR)');
    $wn_status[] = array('val' => 'and', 'label' => 'Show widget if ALL active conditional tags return TRUE (logical AND)');
    $wn_status[] = array('val' => 'not', 'label' => 'Show widget if ALL active conditional tags return FALSE');

    echo '<select name="' . $instance->get_field_name('wn_show') . '" id="' . $instance->get_field_id('wn_show') . '" class="wn_status ' . $instance->get_field_id('wn_show') . '">';
    wf_wn_common::create_select_options($wn_status, $widget_option['wn_show']);
    echo '</select>';
    echo ' <a href="#" wn-help="options" class="help" title="Click to show help"><img alt="Click to show help" title="Click to show help" src="' . get_bloginfo('template_url').'/framework/widgets/images/help.png" /></a>';

    // check if widget ninja is enabled for this widget
    if ($widget_option['wn_show'] != '') {
      $display = 'display: block;';
    } else {
      $display = 'display: none;';
    }
    // list available hook options
    echo '<div class="hook_options ' . $instance->get_field_id('wn_show') . '" style="' . $display . '">';

    // conditional tags, WP built-in and custom
    // $hooks[] = array('wnfn' => 'is_home:0', 'label' => 'is_home');
    //$hooks[] = array('wnfn' => 'is_front_page:0', 'label' => 'is_front_page');

    $hooks[] = array('wnfn' => 'is_wlt_home_page:0', 'label' => 'HOME PAGE', "helptext" => "is_wlt_home_page");
	$hooks[] = array('wnfn' => 'is_wlt_blog_page:0', 'label' => 'BLOG PAGE', "helptext" => "is_wlt_blog_page");
	$hooks[] = array('wnfn' => 'is_wlt_listing_category:0', 'label' => 'SEARCH RESULTS PAGE', "helptext" => "is_wlt_listing_category");
	$hooks[] = array('wnfn' => 'is_page:0', 'dialog' => 'pages', 'label' => 'IS PAGE', "helpertext" => "is_page");
	$hooks[] = array('wnfn' => 'is_wlt_listing:0', 'label' => 'LISTING PAGE', "helptext" => "is_wlt_listing");
	
	
	
 	
	//$hooks[] = array('wnfn' => 'is_category:0', 'dialog' => 'categories', 'label' => 'is_category');
    $hooks[] = array('wnfn' => 'in_category:0', 'dialog' => 'categories',  'label' => 'in_category');

    //$hooks[] = array('wnfn' => 'is_tag:0', 'dialog' => 'tags', 'label' => 'is_tag');
    //$hooks[] = array('wnfn' => 'has_tag:0', 'dialog' => 'tags', 'label' => 'has_tag');

    
    $hooks[] = array('wnfn' => 'is_single:0', 'dialog' => 'posts',  'label' => 'IS BLOG POST');
    $hooks[] = array('wnfn' => 'is_singular:0', 'label' => 'IS POST_TYPE', 'dialog' => 'post_types');
    //$hooks[] = array('wnfn' => 'is_sticky:0', 'label' => 'is_sticky');
    $hooks[] = array('wnfn' => 'is_author:0', 'dialog' => 'authors',  'label' => 'IS AUTHOR');

    $hooks[] = array('wnfn' => 'is_404:0', 'label' => '404 PAGE');
    $hooks[] = array('wnfn' => 'is_search:0', 'label' => 'is_search');
    $hooks[] = array('wnfn' => 'is_archive:0', 'label' => 'is_archive');
    //$hooks[] = array('wnfn' => 'is_preview:0', 'label' => 'is_preview');
    // works only on WP >= v3.1
     

    $hooks[] = array('wnfn' => 'is_paged:0', 'label' => 'is_paged');
	
   
	//$hooks[] = array('wnfn' => 'is_callback_page:0', 'label' => 'CALLBACK PAGE');

    //$hooks[] = array('wnfn' => 'comments_open:0', 'label' => 'comments_open');
   //$hooks[] = array('wnfn' => 'has_excerpt:0', 'label' => 'has_excerpt');

    $hooks[] = array('wnfn' => 'wn_is_user_guest:0', 'label' => 'IS GUEST');
    $hooks[] = array('wnfn' => 'is_user_logged_in:0', 'label' => 'IS MEMBER');
    $hooks[] = array('wnfn' => 'current_user_can:manage_options', 'label' => 'IS ADMIN');

    // check which hooks are active
    parse_str($widget_option['wn_active_hooks'], $ac_hooks);

    // if there are any active hooks
    if (is_array($ac_hooks)) {
      // foreach available hook see if it's active
      $tmp_hooks = $hooks;
      foreach ($hooks as $hook_key => $hook_value){
        $clean_id = explode(':', $hook_value['wnfn']);

        if (isset($ac_hooks[$clean_id[0]]) && is_array($ac_hooks[$clean_id[0]])) { //??
          // check if our hook has any parameters defined
          $hook_attachments = $ac_hooks[$hook_value['label']];
          if (is_array($hook_attachments)) {
            $attachments = $hook_attachments[0];
            $hook_value['wnfn'] = $hook_value['label'] . ':' . $attachments;
          }
          // add used hooks to active array and remove them from available array
          $active_hooks[] = $hook_value;
          unset($tmp_hooks[$hook_key]);
        } // if (is_array($ac_hooks))
      } // foreach ($hooks)
      $hooks = $tmp_hooks;
    } // if (is_array($ac_hooks))

    // active hooks
    echo '<h4 class="wn-title"><span class="extra-vis active">Active</span> conditional tags</h4>';
    echo '<div class="wn-drag-description">Only active tags determine widget\'s visibility. Drag tags here to create complex conditional statements based on <a target="_blank" href="http://codex.wordpress.org/Conditional_Tags">conditional tags</a>.</div>';
    echo '<ul id="' . $instance->get_field_id('wn_active_hooks') . '" class="wn_Connected active_tags">';
    wf_wn_common::create_list($instance->get_field_id('wn_active_hooks'), $active_hooks, 'active', $widget_id);
    echo '</ul>';

    // available/unactive hooks
    echo '<h4 class="wn-title"><span class="extra-vis inactive">Inactive</span> conditional tags</h4>';
    echo '<div class="wn-drag-description">Drag tags you want to disable to this area.</div>';
    echo '<ul id="' . $instance->get_field_id('wn_available_hooks') . '" class="wn_Connected inactive_tags">';
    wf_wn_common::create_list($instance->get_field_id('wn_available_hooks'), $hooks, 'available', $widget_id);
    echo '</ul>';

    // hidden input field for remembering active conditions
    echo '<input type="hidden" name="' . $instance->get_field_name('wn_active_hooks') . '" id="' . $instance->get_field_id('wn_active_hooks') . '" class="serialized_tags" value="" />';
    echo '</div>';
    echo '<br class="clear" />';

    echo '<div id="wn-info-message"><p>Please remember to click <strong>Save</strong> after making any changes to widget\'s settings.</p></div>';
    echo '<br class="clear" />';
  } // form


  // update widget options
 public static  function update($instance, $new_instance, $old_instance) {
    $instance['wn_show'] = $new_instance['wn_show'];
    $instance['wn_active_hooks'] = $new_instance['wn_active_hooks'];

    return $instance;
  } // update


  // dialog box container
  public static function dialog_container() {
    echo '<div class="dialog_loading_container" style="display: none;">
           <div class="dialog_loading" id="loading">
            <img src="' . get_bloginfo('template_url').'/framework/widgets/images/loading.gif" alt="Loading dialog, please wait!" title="Loading dialog, please wait!" />
           </div>
          </div>';
    echo '<div class="dialog" id="dialog"></div>';
  } // dialog_container


  // CSS fixes for IE 7 and 8
  public static function admin_header() {
    echo '<!--[if IE 8]> ';
    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_url').'/framework/widgets/css/wn-ie8.css" />';
    echo " <![endif]-->\n";

    echo '<!--[if IE 7]> ';
    echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_url').'/framework/widgets/css/wn-ie7.css" />';
    echo ' <![endif]-->';
  } // admin_header
 
} // class wf_wn

class wf_wn_common extends wf_wn {
  // helper function for creating select's options
  function create_select_options($options, $selected = null, $output = true) {
    $out = "\n";

    foreach ($options as $tmp) {
      if ($selected == $tmp['val']) {
        $out .= "<option selected=\"selected\" value=\"{$tmp['val']}\">{$tmp['label']}&nbsp;</option>\n";
      } else {
        $out .= "<option value=\"{$tmp['val']}\">{$tmp['label']}&nbsp;</option>\n";
      }
    }

    if($output) {
      echo $out;
    } else {
      return $out;
    }
  } // create_select_options

  // helper function for $_POST checkbox handling
  function check_var_isset(&$values, $variables) {
    foreach ($variables as $key => $value) {
      if (!isset($values[$key])) {
        $values[$key] = $value;
      }
    }
  } // check_var_isset

  // helper function for displaying LI elements
  function create_list($list_id, $options, $class, $widget_id, $output = true) {
    $out = "\n";

    if (is_array($options)) {
      foreach ($options as $sub_array) {
        if (is_array($sub_array) && trim($sub_array['label'])) {
          $out .= '<li wnfn="' . $sub_array['wnfn'] . '" id="wn_' . $widget_id . '_' . $sub_array['label'] . '" class="' . $class . '">' . $sub_array['label'] . "\n";
          if (isset($sub_array['dialog'])) {
            $out .= '<a href="#" class="promptID" id="' . $sub_array['dialog'] . '"><img title="Options" alt="Options" src="' . get_bloginfo('template_url').'/framework/widgets/images/attach.gif" /></a>';
          }
          $out .= '<a wn-help="' . $sub_array['helptext'] . '" href="#" class="help" title="Click to show help"><img alt="Click to show help" title="Click to show help" src="' . get_bloginfo('template_url').'/framework/widgets/images/help.png" /></a>';
          $out .= '</li>';
        }
      }
    }

    if ($output) {
      echo $out;
    } else {
      return $out;
    }
  } // create_list
} // class wf_wn_common

class wn_ajax extends wf_wn {
  // create dialog content
  function dialog() {
    if (!$_POST || !isset($_POST['params'])) {
      die('Bad request.');
    }

    // prevent browsers from caching the request
    header('Cache-Control: no-cache, must-revalidate');
    header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

    // Fetch posted params
    $conditional = explode(':', @$_POST['params']);
    $dialog_name = @$_POST['dialog_name'];
    $selected = explode(',', $conditional[1]);

    call_user_func(array('wn_ajax', $dialog_name), $selected);

    // WP bug workaround
    die();
  } // dialog

  // Function for marking selected items
  function is_selected($item, $haystack) {
    // If item is in array then it's selected
    if (is_array($haystack)) {
      if (in_array($item, $haystack)) {
        // Item is selected
        $selected['class'] = 'wn-selected';
        return $selected;
      } else {
        // Item isn't selected
        return '';
      }
    }
  } // function is_selected

  // list categories
  function categories($params) {
      // Set categories arguments
      $categories_args = array('hide_empty' => '0', 'taxonomy' => THEME_TAXONOMY);
      $out .= '<ul id="wn_selectable_categories" title="Select categories you want to attach">';

      // Get categories from table
      $categories = get_categories($categories_args);

      if ($categories) {
        foreach ($categories as $category) {
          $selected = self::is_selected($category->cat_ID, $params);
		  if(!isset($selected['class'])){ $selected['class'] =""; }
          $out .= '<li class="' . $selected['class'] . '">';
          $out .= '<a href="#" id="' . $category->cat_ID . '">' . $category->cat_name . '</a>' . $selected['img'];
          $out .= '</li>';
         } // end foreach $categories
      } else {
          $out .= '<li>';
          $out .= 'Sorry there are no categories available!';
          $out .= '</li>';
      }

      $out .= '</ul>';
      echo $out;

  } // categories

  // list tags
  function tags($params) {
    $out .= '<ul id="wn_selectable_tag" title="Select tags you want to attach">';

    // Fetch all tags
    $tags = get_tags(array('hide_empty'=>'0'));

    if ($tags) {
      foreach ($tags as $tag ) {
        $selected = self::is_selected($tag->slug, $params);
        $out .= '<li class="' . $selected['class'] . '">';
        $out .= '<a href="#" id="' . $tag->slug . '">' . $tag->name . '</a>' . $selected['img'];
        $out .= '</li>';
      }
    } else {
      $out .= '<li>';
      $out .= 'Sorry there are no tags available!';
      $out .= '</li>';
    }

    $out .= '</ul>';
    echo $out;
  } // tags

  // list pages
  function pages($params) {
    $out .= '<ul id="wn_selectable_pages" title="Select pages you want to attach">';
    // Fetch all pages
    $pages = get_pages();

    if ($pages) {
      foreach ($pages as $page) {
        $selected = self::is_selected($page->ID, $params);
		if(!isset($selected['class'])){ $selected['class'] = ""; }
        $out .= '<li class="' . $selected['class'] . '">';
        $out .= '<a href="#" id="' . $page->ID . '">' . $page->post_title . '</a>' . $selected['img'];
        $out .= '</li>';
      }
    } else {
      $out .= '<li>';
      $out .= 'Sorry there are no pages available!';
      $out .= '</li>';
    }

    $out .= '</ul>';
    echo $out;
  } // pages

  // list posts
  function posts($params) {
    $out .= '<ul id="wn_selectable_posts" title="Select posts you want to attach">';

    // Fetch all posts
    $posts = get_posts();

    if ($posts) {
      foreach ($posts as $post) {
        $selected = self::is_selected($post->ID, $params);
		if(!isset($selected['class'])){ $selected['class'] = ""; }
        $out .= '<li class="' . $selected['class'] . '">';
        $out .= '<a href="#" id="' . $post->ID . '">' . $post->post_title . '</a>' . $selected['img'];
        $out .= '</li>';
      }
    } else {
      $out .= '<li>';
      $out .= 'Sorry there are no posts available!';
      $out .= '</li>';
    }

    $out .= '</ul>';
    echo $out;
  } // list_posts

  // list authors
  function authors($params) {
    global $wpdb;
    $out .= '<ul id="wn_selectable_authors" title="Select authors you want to attach">';

    // Fetch all authors
    $args = array('echo' => '0', 'exclude_admin' => false, 'style'=>'none');
    $authors = $wpdb->get_results("SELECT ID, user_nicename from $wpdb->users ORDER BY display_name");

    if ($authors) {
      foreach ($authors as $author) {
        $selected = self::is_selected($author->ID, $params);
		if(!isset($selected['class'])){ $selected['class'] = ""; }
        $out .= '<li class="' . $selected['class'] . '">';
        $out .= '<a href="#" id="' . $author->ID . '">' . $author->user_nicename . '</a>' . $selected['img'];
        $out .= '</li>';
      }
    } else {
      $out .= '<li>';
      $out .= 'Sorry there are no authors available!';
      $out .= '</li>';
      }

    $out .= '</ul>';
    echo $out;
  } // list_authors

  // list post types
  function post_types($params) {
    $out .= '<ul id="wn_selectable_post_types" title="Select post types you want to attach">';

    // Fetch all post types
    $post_types = get_post_types('','objects');
    // Array of post types to exclude
    $exclude = array('nav_menu_item', 'revision');

    if ($post_types) {
      foreach ($post_types as $post_type) {
        $selected = self::is_selected($post_type->name, $params);
        if (!in_array($post_type->name, $exclude)) {
			if(!isset($selected['class'])){ $selected['class'] = ""; }
          $out .= '<li class="' . $selected['class'] . '">';
          $out .= '<a href="#" id="' . $post_type->name . '">' . $post_type->name . '</a>' . $selected['img'];
          $out .= '</li>';
        }
      }
    } else {
      $out .= '<li>';
      $out .= 'Sorry there are no post types available!';
      $out .= '</li>';
    }

    $out .= '</ul>';
    echo $out;
  } // pages

  // list page templates
  function page_templates($params) {
    $out .= '<ul id="wn_selectable_page_templates" title="Select page templates you want to attach">';

    // Fetch templates list
    $templates = get_page_templates();
    ksort($templates);

    if ($templates) {
      foreach ($templates as $template_name => $template_file) {
        $selected = self::is_selected($template_file, $params);
		if(!isset($selected['class'])){ $selected['class'] = ""; }
          $out .= '<li class="' . $selected['class'] . '">';
          $out .= '<a href="#" id="' . $template_file . '">' . $template_name . '</a>' . $selected['img'];
          $out .= '</li>';
      }
    }

    $out .= '</ul>';
    echo $out;
  } // page_templates
} // class wn_ajax

// checks if user is a guest; not logged in
// moved outside class so it's accessible to other plugins
function wn_is_user_guest() {
  if (is_user_logged_in()) {
    return false;
  } else {
    return true;
  }
} // wn_is_user_guest

function is_wlt_home_page(){ // CUSOTOM ELEMENTS ADDED BY MARK
		
	if(isset($GLOBALS['flag-home'])){
		return true;
	}
	return false;
}

function is_wlt_listing_category(){

	if(isset($GLOBALS['flag-search'])){
		return true;
	}
	return false;
}

function is_wlt_listing(){

	if(isset($GLOBALS['flag-single'])){
		return true;
	}
	return false;
}
function is_wlt_blog_page(){

	if(isset($GLOBALS['flag-blog'])){
		return true;
	}
	return false;
}

?>
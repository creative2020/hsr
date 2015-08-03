<?php
/* =============================================================================
   USER ACTIONS
   ========================================================================== */
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $CORE_ADMIN;
if(!is_object($CORE_ADMIN)){
$CORE_ADMIN	 			= new wlt_admin;
}
// LOAD IN OPTIONS FOR ADVANCED SEARCH
wp_enqueue_script( 'jquery-ui-sortable' );
wp_enqueue_script( 'jquery-ui-draggable' );
wp_enqueue_script( 'jquery-ui-droppable' );

// DATE PICKER
wp_register_script( 'datetimepicker',  FRAMREWORK_URI.'js/bootstrap-datetimepicker.js');
wp_enqueue_script( 'datetimepicker' );
 
wp_register_style( 'datetimepicker',  FRAMREWORK_URI.'css/css.datetimepicker.css');
wp_enqueue_style( 'datetimepicker' );

// LOAD IN MAIN DEFAULTS
if(function_exists('current_user_can') && current_user_can('administrator')){


// COUPON CODE SETTINGS
if(isset($_POST['newcoupon']) && strlen($_POST['newcoupon']) > 0){
			
	// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
	$wlt_coupons = get_option("wlt_coupons");
	if(!is_array($wlt_coupons)){ $wlt_coupons = array(); }
	// ADD ONE NEW FIELD 
	if(!isset($_POST['eid'])){
		array_push($wlt_coupons, $_POST['wlt_coupon']);		
		$GLOBALS['error_message'] = "Coupon Created Successfully";
	}else{
		$wlt_coupons[$_POST['eid']] = $_POST['wlt_coupon'];		
		$GLOBALS['error_message'] = "Coupon Updated Successfully";
	}
	// SAVE ARRAY DATA		 
	update_option( "wlt_coupons", $wlt_coupons);
	$_POST['tab'] = "coupons";
				
}elseif(isset($_GET['delete_coupon']) && is_numeric($_GET['delete_coupon'] )){

	// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
	$wlt_coupons = get_option("wlt_coupons");
	if(!is_array($wlt_coupons)){ $wlt_coupons = array(); }
	
	// LOOK AND SEARCH FOR DELETION
	foreach($wlt_coupons as $key=>$pak){
		if($key == $_GET['delete_coupon']){
			unset($wlt_coupons[$key]);	 
		}
	}
	
	// SAVE ARRAY DATA
	update_option( "wlt_coupons", $wlt_coupons);
	
	$_POST['tab'] = "coupons";
	$GLOBALS['error_message'] = "Coupon Deleted Successfully";
	
}

if(isset($_POST['coupon_import']) && strlen($_POST['coupon_import']) > 2 ){
	
	$wlt_coupons = get_option("wlt_coupons"); $new_coupons = array();
	if(!is_array($wlt_coupons)){ $wlt_coupons = array(); }
	$coupons = explode(PHP_EOL,$_POST['coupon_import']);
	if(is_array($coupons)){ $i=0; $g = count($wlt_coupons); $g++;
		foreach($coupons as $c){
		
			$ns = explode("[",$c);
			 
			if(strpos($ns[1],"%") === false){
				$pd = ""; $fd = $ns[1];
			}else{
				$pd = $ns[1]; $fd = "";
			}
			
			$new_coupons[$g] = array("code" => $ns[0], "discount_fixed" => str_replace("]","",$fd), "discount_percentage" => str_replace("%","",str_replace("]","",$pd)));
			$i++; $g++;
		}	
	 
		update_option( "wlt_coupons", array_merge($wlt_coupons,$new_coupons));	
	}	
	
	$_POST['tab'] = "coupons";
	$GLOBALS['error_message'] =  $i." Coupons Imported Successfully";
	
}
 
 	// SAVE ORDER SETTINGS
	if(isset($_GET['dwid']) && is_numeric($_GET['dwid'] )){
	
		$wpdb->query("DELETE FROM ".$wpdb->prefix."core_withdrawal WHERE autoid='".$_GET['dwid']."' LIMIT 1");
		 
		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
		$GLOBALS['error_message'] 	= "Widthdrawal Deleted Successfully";
		
	}
	
	if(isset($_POST['savewidthdrawal']) && strlen($_POST['savewidthdrawal']) > 1){
	
		$SQL = "UPDATE `".$wpdb->prefix."core_withdrawal` SET 
			user_id='".$_POST['user_id']."',
			  	
		  	withdrawal_comments = '".mysql_real_escape_string($_POST['comments'])."',
			withdrawal_status = '".$_POST['status']."',
			withdrawal_total = '".$_POST['amount']."'
			
			WHERE autoid='".$_POST['autoid']."' LIMIT 1";
		 
			$wpdb->query($SQL);
			
			// REMOVE CREDIT FROM USERS ACCOUNT
			if($_POST['oldstatus'] == 0 && $_POST['status'] == 1){			
			update_user_meta($_POST['user_id'],'wlt_usercredit', get_user_meta($_POST['user_id'],'wlt_usercredit',true)-$_POST['amount']);
			}
		 
			
		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
		$GLOBALS['error_message'] 	= "Widthdrawal Data Updated";
		
	// SAVE ORDER SETTINGS
	}elseif(isset($_POST['saveorder']) && strlen($_POST['saveorder']) > 1){
	 
		$SQL = "UPDATE ".$wpdb->prefix."core_orders SET 
			user_id='".$_POST['user_id']."',
			order_id='".$_POST['order_id']."',
			order_data='".mysql_real_escape_string($_POST['order_data'])."',		
		  	order_status='".mysql_real_escape_string($_POST['order_status'])."',
			order_tax='".mysql_real_escape_string($_POST['order_tax'])."',
			order_shipping='".mysql_real_escape_string($_POST['order_shipping'])."',
			order_total='".mysql_real_escape_string($_POST['order_total'])."',
			order_email = '".mysql_real_escape_string($_POST['order_email'])."',			
			shipping_label='".mysql_real_escape_string($_POST['shipping_label'])."',
			
			payment_data='".mysql_real_escape_string($_POST['payment_data'])."'
			WHERE autoid='".$_POST['autoid']."' LIMIT 1";
		 
			$wpdb->query($SQL);
			
		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
		$GLOBALS['error_message'] 	= "Order Updated";
 	 
	}elseif(isset($_GET['doid']) && strlen($_GET['doid']) > 0){
  	 
		$wpdb->query("DELETE FROM ".$wpdb->prefix."core_orders WHERE autoid='".$_GET['doid']."' LIMIT 1");
		 
		$GLOBALS['error'] 		= 1;
		$GLOBALS['error_type'] 	= "ok"; //ok,warn,error,info
		$GLOBALS['error_message'] 	= "Order Deleted Successfully";
		$_GET['tab'] = "home";
	}
}

 
$core_admin_values = get_option("core_admin_values");
 

// LOAD IN HEADER
if(is_object($CORE_ADMIN)){
echo $CORE_ADMIN->HEAD();
}

?>
</form> <!-- end core form -->

 

<ul id="tabExample1" class="nav nav-tabs">

<?php
// HOOK INTO THE ADMIN TABS
function _6_tabs(){ $STRING = ""; global $wpdb; $core_admin_values = get_option("core_admin_values");

	if(isset($_GET['tab'])){ $_POST['tab'] = $_GET['tab']; }

	$pages_array = array( 
	"1" => array("t" => "Overview"			,"k"=>"home"),
	"3" => array("t" => "Payment Gateways"	,"k"=>"gateways"),
	"5" => array("t" => "Widthdrawal Requests", "k" => "widthdrawal"),
	"4" => array("t" => "Coupons"			,"k"=>"coupons"),
 	);
	foreach($pages_array as $page){
	 
	if( ( isset($_POST['tab']) && $_POST['tab'] == $page['k'] ) || ( !isset($_POST['tab']) && $page['k'] == "home" ) ){ $class = "active"; }else{ $class = ""; }
	
		$STRING .= '<li class="'.$class.'"><a href="#'.$page['k'].'" onclick="document.getElementById(\'ShowTab\').value=\''.$page['k'].'\'" data-toggle="tab">'.$page['t'].'</a></li>';		
	}
 
	return $STRING;

}
echo hook_admin_6_tabs(_6_tabs());
// END HOOK
?>  
          
</ul>
           
           
<div class="tab-content">
      

<?php do_action('hook_admin_6_content'); ?>

<div class="tab-pane fade <?php if(!isset($_POST['tab']) || ( isset($_POST['tab']) && ( $_POST['tab'] =="" || $_POST['tab'] =="home" ) )){ echo "active in"; } ?> in" id="home">

<?php

if(isset($_GET['oid'])  ){  

	get_template_part('framework/admin/templates/admin', '6-orders-data' ); 

}else{ 

	get_template_part('framework/admin/templates/admin', '6-orders' ); 

}

?>  
    
</div><div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "gateways"){ echo "active in"; } ?>" id="gateways">
  
<?php get_template_part('framework/admin/templates/admin', '6-gateways' ); ?>
 
</div><div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "widthdrawal"){ echo "active in"; } ?>" id="widthdrawal">
 
<?php  

if(isset($_GET['wid']) && is_numeric($_GET['wid'])){ 

	get_template_part('framework/admin/templates/admin', '6-withdrawal-data' ); 

}else{

	get_template_part('framework/admin/templates/admin', '6-withdrawal' ); 

}

?>

</div><div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "coupons"){ echo "active in"; } ?>" id="coupons">

<?php get_template_part('framework/admin/templates/admin', '6-coupons' ); ?>

</div>











  <?php if(isset($_GET['edit_coupon']) && is_numeric($_GET['edit_coupon']) ){ 
$wlt_coupons = get_option("wlt_coupons");
?>
<script type="text/javascript">
jQuery(document).ready(function () { jQuery('#CouponModal').modal('show'); })
</script>

<?php } ?>    

<?php // LOAD IN FOOTER

echo $CORE_ADMIN->FOOTER(); ?>
<form method="post" name="admin_coupon" id="admin_coupon" action="admin.php?page=6">
<input type="hidden" name="newcoupon" value="yes" />
<input type="hidden" name="tab" value="coupons" />
<?php if(isset($_GET['edit_coupon'])){ ?>
<input type="hidden" name="eid" value="<?php echo $_GET['edit_coupon']; ?>" />
<input type="hidden" name="wlt_coupon[ID]" value="<?php echo $_GET['edit_coupon']; ?>" />
<?php } ?>

<div id="CouponModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="CouponModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3 id="myModalLabel">Coupon Settings</h3>
            </div>
            <div class="modal-body">
              
         
            
              	 <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field"><b>Code</b></label>
                <div class="controls span7">
                  <input type="text"  name="wlt_coupon[code]" class="row-fluid" value="<?php if(isset($_GET['edit_coupon'])){ echo stripslashes($wlt_coupons[$_GET['edit_coupon']]['code']); }?>">
                   
                </div>
              </div> 
              
              <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field"><b>Discount:</b></label>
                <div class="controls span9">
                <div class="row-fluid">
                    <div class="span5">
                    
                    <div class="controls  input-prepend">  
          <span class="add-on">%</span>                     
         <input type="text"  name="wlt_coupon[discount_percentage]" class="row-fluid" value="<?php if(isset($_GET['edit_coupon'])){ echo $wlt_coupons[$_GET['edit_coupon']]['discount_percentage']; }?>" placeholder="Percentage Value">   
        </div>
                    
                    
                    
                   
                    </div>                
                    <div class="span5">
                    
                    <div class="controls  input-prepend">  
          <span class="add-on"><?php echo $core_admin_values['currency']['symbol']; ?></span>   
                    <input type="text"  name="wlt_coupon[discount_fixed]" class="row-fluid" value="<?php if(isset($_GET['edit_coupon'])){ echo $wlt_coupons[$_GET['edit_coupon']]['discount_fixed']; }?>" placeholder="Fixed Amount">
                    </div>
                    </div>
                </div> 
                   
                </div>
              </div> 
           
              
            </div>
            
            <div class="modal-footer">
              <a class="btn" href="admin.php?page=6">Close</a>
              <button class="btn btn-primary">Save changes</button>
            </div>
</div>
</form>
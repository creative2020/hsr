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
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; } global $CORE;



 
	$currency_symbol = get_option("currency_symbol");
	$order   = array("\r\n", "\n", "\r");
	$replace = '<br />'; 
	$SQL = "SELECT DISTINCT * FROM ".$wpdb->prefix."core_orders 
	WHERE ".$wpdb->prefix."core_orders.autoid = ('".$_GET['oid']."') GROUP BY order_id LIMIT 1"; 
	
	$orderdata = $wpdb->get_results($SQL, OBJECT);
	$order = $orderdata[0];
	
	$tt = "";
	if (strpos($order->order_id, "SUB") !== false) {
		$tt = "<span class='label'> Subscription Payment </span>";
			
	}elseif (strpos($order->order_id, "LST") !== false) {
		$tt = "<span class='label label-info'> New Listing </span>";
		
	}elseif (strpos($order->order_id, "REW") !== false) {
		$tt = "<span class='label label-warning'> Renewal </span>";
	 
	}elseif (strpos($order->order_id, "MEM") !== false) {
		$tt = "<span class='label label-important'> Membership </span>";			
 	}
 	 
?>
    
<form method="post" target="_self">
<input name="saveorder" type="hidden" value="yes" />
<input type="hidden" name="autoid" value="<?php echo $order->autoid ?>">
<input type="hidden" name="order_id" value="<?php echo $order->order_id ?>">

<h3 class="pull-right"><?php echo hook_date($order->order_date." ".$order->order_time); ?></h3>

<h1>#<?php echo $order->order_id ?> <?php echo $tt; ?></h1>

<p>This order was placed from a the IP address: <?php echo $order->order_ip ?></p>

<hr />



<div class="tabbable tabs-left">

<ul class="nav nav-tabs" id="OrderDataTab">
  <li class="active"><a href="#od1">Purchase Data</a></li>
  <li><a href="#od2">Buyer Details</a></li>
  <li><a href="#od3">Raw Payment Data</a></li>
</ul>
 
<div class="tab-content" style="background:#fff; min-height:500px;">
  <div class="tab-pane active" id="od1">
  
  
		<?php 	// ADD IN EXTRAS FOR SHOP THEMES
                if(defined('WLT_CART')){ global $CORE_CART;
                     
                    $obits = explode("-",$order->order_id); 
                    $SQL = "SELECT session_data	FROM ".$wpdb->prefix."core_sessions WHERE session_key LIKE ('%".strip_tags($obits[1])."%') LIMIT 1";
                    $hassession = $wpdb->get_results($SQL, OBJECT);
                    if(!empty($hassession)){
                        // RESTORE THE CART DATA
                        $cart_data = unserialize($hassession[0]->session_data);		 
                        // NOW WE LOOP ALL ITEMS AND REMOVE THE QTY IF REQUIRED
                            if(isset($cart_data['items']) && is_array($cart_data['items'])){
                                $GLOBALS['global_cart_data'] = $cart_data;
                            }// end if
                    }// end if
                    
                }
            
        ?>
                
                
        <h3> Purchase Information</h3>
        
        <?php  if(isset($GLOBALS['global_cart_data'])){ global $CORE_CART; $CORE->Language();  ?>
        <style>
        table#cart_summary img {max-width:40px; max-height:40px; border:1px solid #ddd; float:left; margin-right:10px; }
        table#cart_summary { margin-bottom:5px; }
        .emptycart { font-size:12px; text-decoration:underline; }
        table#cart_summary th {font-size: 14px;text-transform: uppercase;background: #F2F2F2;}
        table#cart_summary a.cart_quantity_up { display:none; }
        table#cart_summary a.cart_quantity_down { display:none; }
        
        </style>
        <?php echo $CORE_CART->_CHECKOUT(); ?>
        
        <?php if(strlen($GLOBALS['global_cart_data']['comments']) > 0 ){ echo  "<hr> <p> User Comments</p> <div class='well'>".$GLOBALS['global_cart_data']['comments']."</div>"; } ?>
        
        <?php }else{ ?>
        <textarea style="height:150px; width:100%" name="order_data"><?php echo strip_tags(str_replace("<br/>","\r\n\r\n",$order->order_data)); ?></textarea>
        
        <?php } ?>
        
<?php if(defined('WLT_CART')){ global $CORE_CART; ?>
<h3> Delivery Details</h3> 
<style>
.col-md-6 {
width: 50%; float: left;
}.col-md-11 {
width: 91.66666667%; float: left;
}.col-md-8 {
width: 66.66666667%; float: left;
}
.row { margin:0px; }
.form-control { width:90%; }
</style>

<?php 

// CHECK IF THIS IS A GUEST CHECKOUT
if(strtolower($order->user_login_name) == "guest"){

	$SQL = "SELECT session_data	FROM ".$wpdb->prefix."core_sessions WHERE session_key LIKE ('%".strip_tags($obits[1])."%') LIMIT 1";
	$hassession = $wpdb->get_results($SQL, OBJECT);
	if(!empty($hassession)){
		// RESTORE THE CART DATA
		$cart_data = unserialize($hassession[0]->session_data);
		$customdata = $cart_data['guest_data'];
	}
}

echo  $CORE_CART->_userfields($order->user_id, $customdata); ?> 

<hr />
<?php } ?>

<?php if(strlen(strip_tags(str_replace("<br/>","\r\n\r\n",trim($order->shipping_label)))) > 10){ ?>
<h3> Shipping Label</h3>
<textarea style="height:100px; width:100%" name="shipping_label"><?php echo strip_tags(str_replace("<br/>","\r\n\r\n",trim($order->shipping_label))); ?></textarea>
<hr />
<?php } ?>


<?php if(!defined('WLT_CART')){ ?>
    <div class="row-fluid">
    <div class="span4">
    <b>Order Tax</b><br />
    <input type="text" class="txt" name="order_tax" value="<?php echo $order->order_tax ?>" style="width:100%;">
    </div>
    <div class="span4">
    <b>Order Shipping</b><br />
    <input type="text" class="txt" name="order_shipping" value="<?php echo $order->order_shipping ?>" style="width:100%;">
    </div>
    <div class="span4">
    <b>Order Total</b><br />
    <input type="text" class="txt" name="order_total" value="<?php echo $order->order_total ?>" style="width:100%;">
    </div>
    </div>
<?php }else{ ?>
<input type="hidden" class="txt" name="order_tax" value="<?php echo $order->order_tax ?>" style="width:100%;">
<input type="hidden" class="txt" name="order_shipping" value="<?php echo $order->order_shipping ?>" style="width:100%;">
<input type="hidden" class="txt" name="order_total" value="<?php echo $order->order_total ?>" style="width:100%;">
<?php } ?>          
<hr />
<b>Email</b><br />
<input type="text" class="txt" name="order_email" value="<?php echo $order->order_email ?>" style="width:100%;">
<hr />
<b>Order Status</b><br />
				<select name="order_status" style="font-size:14px; width:100%;">
                <option value="1" <?php if($order->order_status ==1){ echo "selected=selected"; } ?>>Paid  </option>
                <option value="2" <?php if($order->order_status ==2){ echo "selected=selected"; } ?>>Refunded </option>            
                <option value="3" <?php if($order->order_status ==3){ echo "selected=selected"; } ?>>Incomplete </option>
                <option value="4" <?php if($order->order_status ==4){ echo "selected=selected"; } ?>>Failed </option>
                <option value="5" <?php if($order->order_status ==5){ echo "selected=selected"; } ?>>Paid &amp; Completed </option>
               
                </select>
  
  
  
  
  </div>
  <div class="tab-pane" id="od2">
		<input type="text" style="width:50px; float:right;" name="user_id" value="<?php echo $order->user_id ?>">

        <h3>Buyer Details</h3>
        
        

        <div class="well">
        
        <div class="row-fluid">
            <div class="span4">
            <?php echo get_avatar($order->user_id); ?>
            <style>.span4 .avatar { min-width:200px; min-height:200px; border:1px solid #ddd; padding:2px; background:#fff; }</style>
            </div>
            <div class="span7">
            <?php $uf = get_userdata($order->user_id);  ?>
            <h3><?php echo $uf->user_login; ?></h3>
            <p>Name: <?php echo $uf->first_name." ".$uf->last_name; ?></p>
            <p>Email: <?php echo $uf->user_email; ?></p>
            <p>Phone: <?php echo get_user_meta($order->user_id,'phone',true); ?></p>
            <p>Registered: <?php echo $uf->user_registered; ?></p>
            <p>Profile Link: <a href="<?php echo get_author_posts_url( $order->user_id ); ?>" target="_blank"><?php echo get_author_posts_url( $order->user_id ); ?></a> </p>
            
            </div>
        </div>
        </div>
  
  </div>
  
  
  <div class="tab-pane" id="od3">
  
    <h3> Payment Information (Saved for review only.)</h3>
    <textarea style="height:400px; width:100%" name="payment_data"><?php echo strip_tags(str_replace("<br/>","\r\n\r\n",$order->payment_data)); ?></textarea>
     
  
  </div>
  
</div>

</div>


 <hr /> 
               
<button class="btn btn-primary" type="submit">Update Order</button>


<a href="<?php echo THEME_URI; ?>/_invoice.php?invoiceid=<?php echo $order->autoid; ?>" class="btn btn-info">View Invoice</a>


<a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=6" class="pull-right btn btn-default">Go Back</a>

</form>



<script>
jQuery('#OrderDataTab a').click(function (e) {
  e.preventDefault();
  jQuery(this).tab('show');
})
</script>
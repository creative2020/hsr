<?php 
 
if(!isset($_GET['invoiceid'])){ header('HTTP/1.0 403 Forbidden'); exit;  }

	// TRY TO GENERATE THE CORRECT SERVER PATH FROM THE FILE LOCATION
	// IF YOUR HERE TO EDIT THE SERVER PATH, EDIT THE VALUE BELOW

 	$te = explode("wp-content",$_SERVER['SCRIPT_FILENAME']);
	$SERVER_PATH_HERE = $te[0];// <-- EDIT THE VALUE HERE.  $SERVER_PATH_HERE = "/my/server/path/here/";
	
	if(file_exists($SERVER_PATH_HERE.'/wp-config.php')){
				 
		require( $SERVER_PATH_HERE.'/wp-config.php' );
	
	}else{
	
		die('<h1>Invoice Path Incorrect</h1>
		<p>The script could not generate the correct server path to your invoice file.</p>
		<p>Please edit the file below and manually set the correct server path.</p>
		<p>'.$_SERVER['SCRIPT_FILENAME'].'</p>');
	
	}
	
	// START MAIN INVOICE CONTENT	
	global $wpdb, $userdata; get_currentuserinfo();
	
	 
 	// GET THE ORDER DATA FROM THE DATABSE
	$SQL = "SELECT DISTINCT * FROM ".$wpdb->prefix."core_orders WHERE ".$wpdb->prefix."core_orders.autoid = ('".strip_tags($_GET['invoiceid'])."') GROUP BY order_id LIMIT 1";
	$posts = $wpdb->get_results($SQL, OBJECT);

	foreach($posts as $order){
	
	$GLOBALS['orderdata'] = $order;
 

	// GET THE CLIENT DATA
	$user = get_userdata($order->user_id);
	
	// VALIDATE THIS USER CAN VIEW THE ORDER
	if($userdata->ID != $order->user_id){ 
		if(!current_user_can( 'administrator' )){
		header("location: ".site_url('wp-login.php', 'login_post'));
		exit();	
		}
	}
	
	// GET ORDER STATUS
	switch($order->order_status){
	case "1": { 	$O1 = "Paid";		$O2 = "green"; 	} break;							
	case "2": { 	$O1 = "Refunded";	$O2 = "purple";	} break;	
	case "3": { 	$O1 = "Incomplete";	$O2 = "red"; 	} break;
	case "4": { 	$O1 = "Failed";		$O2 = "black";  } break;
	}
	 
	// LOAD IN THE CORE CONTENT
	$core_admin_values = get_option("core_admin_values"); 
	
		// ADJUSTMENTS FOR CART
		if(defined('WLT_CART')){
		 
			global $CORE_CART; $CORE->Language();
			 
			$obits = explode("-",$order->order_id); 		 
			$SQL = "SELECT * FROM ".$wpdb->prefix."core_sessions WHERE session_key LIKE ('%".strip_tags($obits[1])."%') LIMIT 1";
			$hassession = $wpdb->get_results($SQL, OBJECT);
			if(!empty($hassession)){
			 	// RESTORE THE CART DATA
				$cart_data = unserialize($hassession[0]->session_data);		 
				// NOW WE LOOP ALL ITEMS AND REMOVE THE QTY IF REQUIRED
					if(isset($cart_data['items']) && is_array($cart_data['items'])){
						$GLOBALS['global_cart_data'] = $cart_data;
					}// end if
			}// end if			
		}// END IF CART
		
	} 
$order = $GLOBALS['orderdata'];
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Invoice</title>
<!-- Latest compiled and minified CSS  -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<style>
@import url(http://fonts.googleapis.com/css?family=Bree+Serif);
body, h1, h2, h3, h4, h5, h6{
		font-family: 'Bree Serif', serif;
}
#logo { max-height:120px; max-width:300px; }
#logo img { max-height:110px; }
.wlt_thumbnail { max-width:50px; max-height:50px; padding-right:10px; }
.printbutton { text-align:center; font-size:16px; background:#fafafa; border:1px solid #ddd; color:#2b2b2b; width:200px; padding:10px; margin:auto auto;  }
@media print{      .no-print, .no-print *{        display: none !important;} a[href]:after {   content: none !important;}}
/*** extras for cart ***/
table#cart_summary  .img-circle {max-width:40px; max-height:40px; border:1px solid #ddd; float:left; margin-right:10px; }
table#cart_summary { margin-bottom:5px; }
.emptycart { font-size:12px; text-decoration:underline; }
table#cart_summary th {font-size: 14px;text-transform: uppercase;background: #F2F2F2;}
table#cart_summary a.cart_quantity_up { display:none; }
table#cart_summary a.cart_quantity_down { display:none; }
.glyphicon { display:none; }
</style>
</head>

<body>

 

	<div class="container">

		<div class="row">
			<div class="col-xs-6">
            
			  <div id="logo"><?php echo hook_logo(true); ?></div>
              
			</div>
			<div class="col-xs-6 text-right">
			  <h1>INVOICE</h1>
		 
			</div>
		</div>

		  <div class="row">
		    <div class="col-xs-5">
		      <div class="panel panel-default">
		              <div class="panel-heading">
		                <h4>From: <a href="<?php echo home_url(); ?>/"><?php echo $core_admin_values['invoice']['name']; ?></a></h4>
		              </div>
		              <div class="panel-body">
		                
		                <?php echo wpautop($core_admin_values['invoice']['address']); ?>
		                
		              </div>
		            </div>
		    </div>
            
            
		    <div class="col-xs-5 col-xs-offset-2 text-right">
		      <div class="panel panel-default">
		              <div class="panel-heading">
		                <h4>To : <a href="<?php echo home_url(); ?>/author/<?php echo $user->display_name; ?>/"><?php echo $user->display_name; ?> </a> (User ID #<?php if(defined('WLT_CART')){ echo $order->user_id; }else{  echo $order->user_id; } ?>) </h4>
		              </div>
		              <div class="panel-body">
                      
                      <?php  if(defined('WLT_CART')){ 
					 
					  $order_data_description = "";
					  if(isset($cart_data['guest_data']) && !empty($cart_data['guest_data']) && strtolower($order->user_login_name) == "guest" ){
							$order_data_description .= "".$cart_data['guest_data']["billing_fname"]." ".$cart_data['guest_data']["billing_lname"]."<BR />";
							$order_data_description .= "".$cart_data['guest_data']["billing_email"]."<BR />";
							$order_data_description .= "".$cart_data['guest_data']["billing_phone"]."<BR />";
							$order_data_description .= "".$cart_data['guest_data']["billing_address"]."<BR />";
							$order_data_description .= "".$cart_data['guest_data']["billing_address2"]."<BR />";
							$order_data_description .= "".$cart_data['guest_data']["billing_city"]."<BR />";
							$order_data_description .= "".$cart_data['guest_data']["billing_state"]."<BR />";
							$order_data_description .= "".$cart_data['guest_data']["billing_country"]."<BR />";
							$order_data_description .= "".$cart_data['guest_data']["billing_zip"]."<BR />"; 
							}else{							
							$order_data_description .= "".get_user_meta($order->user_id, "billing_fname",true)." ".get_user_meta($order->user_id, "billing_lname",true)."<BR />";
							$order_data_description .= "".get_user_meta($order->user_id, "billing_email",true)."<BR />";
							$order_data_description .= "".get_user_meta($order->user_id, "billing_phone",true)."<BR />";
							$order_data_description .= "".get_user_meta($order->user_id, "billing_address",true)."<BR />";
							$order_data_description .= "".get_user_meta($order->user_id, "billing_address2",true)."<BR />";
							$order_data_description .= "".get_user_meta($order->user_id, "billing_city",true)."<BR />";
							$order_data_description .= "".get_user_meta($order->user_id, "billing_state",true)."<BR />";
							$order_data_description .= "".get_user_meta($order->user_id, "billing_country",true)."<BR />";
							$order_data_description .= "".get_user_meta($order->user_id, "billing_zip",true)."<BR />";
							}
							if(strlen($order_data_description) < 80 &&  strlen(trim($order->shipping_label)) > 27 ){
							
							echo $order->shipping_label;
							
							}else{
							
							echo $order_data_description;
							
					  		}
							
					  }elseif(strlen(trim($order->shipping_label)) > 27){ ?>
		                <p><?php echo $order->shipping_label; ?></p>
                       <?php } ?>
                       
                        
		                </p>
		              </div>
		            </div>
		    </div>
            
		  </div>
          
 
        <p><?php echo hook_date($order->order_date);  ?> <span style="float:right;">Invoice #<?php echo str_replace("CART-","",$order->order_id); ?></span> </p>
        
<?php 	// ADD IN EXTRAS FOR SHOP THEMES
 
if(defined('WLT_CART')){
 		 
 echo $CORE_CART->_CHECKOUT()."<hr />"; 

}else{
 
$postdata = get_post($order->order_items);
 
?>
 
       
        <table class="table table-bordered">
        <thead>
          <tr>
            <th><h4>Package</h4></th>
            <th><h4>Description</h4></th>
          
           
            <th><h4>Sub Total</h4></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo $order->order_data; ?></td>
            <td><a href="<?php echo get_permalink($postdata->ID); ?>"><?php echo $postdata->post_title; ?></a> 
            <?php if(get_post_meta($postdata->ID,'sku',true) != ""){ echo "(".get_post_meta($postdata->ID,'sku',true).")"; } ?>
            <?php if(get_post_meta($postdata->ID,'SKU',true) != ""){ echo "(".get_post_meta($postdata->ID,'SKU',true).")"; } ?>
             </td>
      		<td class="text-right"><?php echo hook_price($order->order_total); ?></td>
          </tr>
 
        </tbody>
      </table>

		<div class="row text-right">
         
			<div class="col-xs-2 col-xs-offset-8">
            
            
				<p>
					<strong>
					 
                    <?php if($order->order_shipping > 0){ ?>  Shipping : <br /><?php } ?>
					<?php if($order->order_tax > 0){ ?>  TAX : <br /><?php } ?>
					Total : <br />
                    
					</strong>
				</p>
			</div>
			<div class="col-xs-2">
				<strong>
					
                    <?php if($order->order_shipping > 0){ echo hook_price($order->order_shipping)."<br />"; } ?>  
					<?php if($order->order_tax > 0){ echo hook_price($order->order_tax)."<br />"; } ?>  
					<?php echo hook_price($order->order_total); ?> <br>
				</strong>
			</div>
		</div>

<?php } // end else ?>
        
      
        
<div class="panel panel-info">
<div class="panel-heading"><h4>Invoice Status: <?php echo $O1; ?> </h4></div>

<h2 style="text-align:center;"> Thank You!</h2>
</div>   
        
<hr />
<div class="printbutton no-print" ><a href="javascript:void(0);" onClick="window.print()">Print Invoice</a></div>
        

</div>

 
</body>
</html>
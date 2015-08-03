<?php
$core_gateways = array();
$core_gateways[1]['name'] 		= "Paypal Standard";
$core_gateways[1]['function'] 	= "gateway_paypal";
$core_gateways[1]['website'] 	= "http://www.paypal.com";
$core_gateways[1]['logo'] 		= "paypal.png";
$core_gateways[1]['callback'] 	= "yes";
$core_gateways[1]['fields'] 	= array(
'1' => array('name' => 'Gateway', 'type' => 'listbox', 'fieldname' => 'gateway_paypal','list' => array('yes'=>'Enable','no'=>'Disable')),
'2' => array('name' => 'Use Sandbox', 'type' => 'listbox', 'fieldname' => 'paypal_sandbox','list' => array('yes'=>'Yes (i am testing)','no'=>'No (my website is live)')),					 

'3' => array('name' => 'Paypal Email', 'type' => 'text', 'fieldname' => 'paypal_email'),
'4' => array('name' => 'Currency Code', 'type' => 'text', 'fieldname' => 'paypal_currency'),
'5' => array('name' => 'Display Name', 'type' => 'text', 'fieldname' => 'gateway_paypal_name', 'default' => 'Pay Now with PayPal') ,
'6' => array('name' => 'Recurring Payments', 'type' => 'listbox', 'fieldname' => 'paypal_recurring','list' => array('yes'=>'Yes (where possible)','no'=>'Disable')),					 
'7' => array('name' => 'Language', 'type' => 'text', 'fieldname' => 'paypal_language', 'default' => 'US'),
);
$core_gateways[1]['notes'] 	= "A list of country codes for paypal languages can be <a href='https://developer.paypal.com/webapps/developer/docs/classic/api/country_codes/' style='text-decoration:underline;'>found here.</a>";
$GLOBALS['core_gateways'] = $core_gateways;
// ---------------------------- GATEWAY FIELD CODE ------------------------

function MakeField($type, $name, $value, $list="", $default=""){
if($value ==""){ $value = $default; }
	switch($type){	
		case "checkbox": { return  "<input type='checkbox' class='checkbox' name='".$name."' value='".$value."'> "; } break;	
		case "text": { return  "<input type='text' name='adminArray[".$name."]' value='".$value."' class='row-fluid'>"; } break;
		case "textarea": { return "<textarea name='adminArray[".$name."]' type='text' class='row-fluid'>".stripslashes($value)."</textarea>"; } break;
		case "listbox": { 
			$r ="<select name='adminArray[".$name."]' class='CORE-forminput'>";
			foreach($list as $key => $val){
				if($value==$key){ $sel="selected"; }else{ $sel=""; }
				$r .="<option value='".$key."' ".$sel.">".$val."</option>";
			}
			$r .="</select>";
			return $r;
		} break;
	}
}

function MakePayButton($link){
	global $CORE;
	$STRING = '<a href="'.$link.'" class="btn btn-primary" style="min-width:100px;">'.$CORE->_e(array('button','21')) .'</a>';
	return $STRING;
}

// ---------------------------- GATEWAY CODE ------------------------
function gateway_paypal($data=""){

	global $CORE, $wpdb;
  
	$gatewaycode = "";	
	
	if(get_option('paypal_sandbox') == "yes"){
	$gatewaycode .= '<form method="post" style="margin:0px !important;" action="https://www.sandbox.paypal.com/cgi-bin/webscr" name="checkout_paypal">';
	}else{
	$gatewaycode .= '<form method="post" style="margin:0px !important;" action="https://www.paypal.com/cgi-bin/webscr" name="checkout_paypal">';
	}	
 	// CALLBACK LINKS
	$gatewaycode .= '
	<input type="hidden" name="rm" value="2">
	<input type="hidden" name="lc" value="'.get_option('paypal_language').'">
	<input type="hidden" name="return" value="'.$GLOBALS['CORE_THEME']['links']['callback'].'?auth=1">
	<input type="hidden" name="cancel_return" value="'.$GLOBALS['CORE_THEME']['links']['callback'].'">
	<input type="hidden" name="notify_url" value="'.$GLOBALS['CORE_THEME']['links']['callback'].'">';
	
	
	if(isset($GLOBALS['shipping']) && is_numeric($GLOBALS['shipping']) && $GLOBALS['shipping'] > 0){		
		$gatewaycode .= '<input type="hidden" name="shipping_1" value="'.trim($GLOBALS['shipping']).'">';
	}
	if(isset($GLOBALS['tax']) && is_numeric($GLOBALS['tax']) && $GLOBALS['tax'] > 0){
		$gatewaycode .= '<input type="hidden" name="tax_cart" value="'.round(trim($GLOBALS['tax']),2).'">';
	}
	if(isset($GLOBALS['weight']) && $GLOBALS['weight'] != ""){
		$gatewaycode .= '<input type="hidden" name="weight_cart" value="'.trim($GLOBALS['weight']).'">';
	}
	if(isset($GLOBALS['discount']) && strlen($GLOBALS['discount']) > 0){
		$gatewaycode .= '<input type="hidden" name="discount_amount_cart" value="'.trim($GLOBALS['discount']).'">';
	}
	// CHECK IF WE ARE GOING TO BE USING THE PAYPAL CART OR SINGLE 
	// PAYMENT OPTIONS
	if(isset($GLOBALS['items']) && is_array($GLOBALS['items'])){
		// BUILD PAYPAL CART DATA
		$i=1; 
		foreach($GLOBALS['items'] as $key=>$inneritem){
			foreach($inneritem as $item){		
			
			$name = $item['name'];
			if(strlen($item['custom']) > 1){ $name .= "-".$item['custom']; }	 
			$gatewaycode .='<input type="hidden" name="item_name_'.$i.'" value="'.trim(strip_tags($name)).'">
			<input type="hidden" name="amount_'.$i.'" value="'.trim($item['amount']).'">
			<input type="hidden" name="quantity_'.$i.'" value="'.$item['qty'].'">';
			$i++;
			}			
		}	
	
	$gatewaycode .= '<input type="hidden" name="upload" value="1">';
	$gatewaycode .= '<input type="hidden" name="cmd" value="_cart">';
	}else{
 
if(get_option('paypal_recurring') == "yes" && isset($GLOBALS['days_till_expire']) && is_numeric($GLOBALS['days_till_expire']) ){
 
		$gatewaycode .= '<input type="hidden" name="cmd" value="_xclick-subscriptions">
		<input type="hidden" name="a3" value="'.strip_tags($GLOBALS['total']).'">';

		if($GLOBALS['days_till_expire'] < 14){

			$gatewaycode .= '<input type="hidden" name="a3" value="'.strip_tags($GLOBALS['total']).'">		
			<input type="hidden" name="p3" value="'.$GLOBALS['days_till_expire'].'">
			<input type="hidden" name="t3" value="D">
			<input type="hidden" name="src" value="1">
			<input type="hidden" name="sra" value="1">';

			}elseif($GLOBALS['days_till_expire'] < 30){

			$numweeks = $GLOBALS['days_till_expire']/7;
			$gatewaycode .= '<input type="hidden" name="a3" value="'.strip_tags($GLOBALS['total']).'">
			<input type="hidden" name="p3" value="'.$numweeks.'">
			<input type="hidden" name="t3" value="W">
			<input type="hidden" name="src" value="1">
			<input type="hidden" name="sra" value="1">';

			}elseif($GLOBALS['days_till_expire'] < 370){

			$nummonths = $GLOBALS['days_till_expire']/30;							 							  	
			$gatewaycode .= '<input type="hidden" name="a3" value="'.strip_tags($GLOBALS['total']).'">	
			<input type="hidden" name="p3" value="'.$nummonths.'">	
			<input type="hidden" name="t3" value="M">
			<input type="hidden" name="src" value="1">
			<input type="hidden" name="sra" value="1">';		
			}
		
	}else{
		$gatewaycode .= '<input type="hidden" name="cmd" value="_xclick">';
	}	
 	
	
	
	$gatewaycode .= '<input type="hidden" name="amount" value="'.strip_tags($GLOBALS['total']).'" id="paypalAmount">';
	$gatewaycode .= '<input type="hidden" name="item_name" value="'.strip_tags($GLOBALS['description']).'">';
	 
	}
	
 
	if(defined('WLT_CART') && isset($GLOBALS['flag-checkout']) ){
	 // SELLER PROTECTION
	/*$gatewaycode .= '
	<input type="hidden" name="first_name" value="">
	<input type="hidden" name="last_name" value="">
	<input type="hidden" name="email" value="">
	<input type="hidden" name="address1" value="">
	<input type="hidden" name="address2" value="">
	<input type="hidden" name="city" value="">
	<input type="hidden" name="country" value="">
	<input type="hidden" name="zip" value="">
	<input type="hidden" name="state" value="">
	<input type="hidden" name="address_override" value="1">';
	*/
	}
 	
	$gatewaycode .= '
	<input type="hidden" name="item_number" value="'.$GLOBALS['orderid'].'">
	<input type="hidden" name="business" value="'.get_option('paypal_email').'">
	<input type="hidden" name="currency_code" value="'.hook_price_currencycode(get_option('paypal_currency')).'">
	<input type="hidden" name="charset" value="utf-8">
	<input type="hidden" name="custom" value="'.$GLOBALS['orderid'].'">
	<input type="hidden" name="bn" value="PREMIUMPRESSLIMITED_SP">
	'.MakePayButton('javascript:document.checkout_paypal.submit();').'</form>';

	return $gatewaycode;

}

function core_generic_gateway_callback($orderid, $orderdata ){ global $wpdb, $CORE, $userdata; $order_data_description = "";
	
	if(is_array($orderid)){ return; }
	
	$obits = explode("-",$orderid);
  	
	// GENERATE NEW ORDER ID AND MAKE IT GLOBAL
	$saveme_orderdata = array();
	$saveme_orderdata['orderid'] 		= $orderid;//$_POST['txn_id'];
	$GLOBALS['orderid'] 				= $saveme_orderdata['orderid']; // important
	
	// INCORRECT VALUE FOR PRICE
	if($orderdata['total'] == ""){ $orderdata['total'] = 1; }
 
	
	// ITEM DESCRIPTION
	$saveme_orderdata['description'] 	= $orderdata['description'];			
	// USER DATA
	// we try to get the user data from the users email
	// if no email is found, we create a new account for the user
	if(isset($obits[2]) && is_numeric($obits[2]) && ( $obits[2] != 0 && strlen($obits[2]) != 8 )  ){	
		$saveme_orderdata['userid'] 	= $obits[2];				
		$saveme_orderdata['username'] 	= get_the_author_meta('user_login', $obits[2]);	
	}elseif($userdata->ID){			
		$saveme_orderdata['userid'] 	= $userdata->ID;
		$saveme_orderdata['username'] 	= $userdata->user_login; 
	
	}elseif ( strlen($orderdata['email']) > 1 && email_exists($orderdata['email']) ){				
		$author_id = email_exists($orderdata['email']);		
		$saveme_orderdata['userid'] = $author_id;				
		$saveme_orderdata['username'] = get_the_author_meta('user_login', $author_id);	
	
	} elseif(strlen($orderdata['email']) > 1) {			
		$user_email = $orderdata['email'];
		$user_name = explode("@",$user_email);
		$new_user_name = $user_name[0].date('d');
		$random_password = wp_generate_password( 12, false );
		$user_ID = wp_create_user( $new_user_name, $random_password, $user_email );			 
		// SEND USER PASSWORD
		wp_new_user_notification( $user_ID, $random_password );				
		$saveme_orderdata['userid'] 	= $user_ID;
		$saveme_orderdata['username'] = $new_user_name;	
				
	}else{
		$saveme_orderdata['userid'] = 1;
		$saveme_orderdata['username'] 	= "Guest";
	}
 
	// VERIFY CUSTOM FIELD DATA
	if(isset($obits[1]) && ( is_numeric($obits[1]) || substr($obits[0],0,4) == "CART" ) ){
	  
		// FOR SHOPPING CART
		if(substr($obits[0],0,4) == "CART"){
		
			// ADD IN EXTRAS FOR SHOP THEMES
			if(defined('WLT_CART') && strlen($obits[1]) > 4 ){		
				
				$SQL = "SELECT * FROM ".$wpdb->prefix."core_sessions WHERE session_key = ('".strip_tags($obits[1])."') LIMIT 1";
				$hassession = $wpdb->get_results($SQL, OBJECT);
				if(!empty($hassession)){
					// RESTORE THE CART DATA
					$cart_data = unserialize($hassession[0]->session_data);	
					 
					// NOW WE LOOP ALL ITEMS AND REMOVE THE QTY IF REQUIRED
						if(isset($cart_data['items']) && is_array($cart_data['items'])){
							  
							$order_data_description .= "\n\n\n********** Order Information **********\n\n";
							$order_data_description .= "Date : ".hook_date(date('Y-m-d H:i:s'))."\n";
							$order_data_description .= "Order ID : ".$orderid."\n";
							$order_data_description .= "User ID : ".$hassession[0]->session_userid."\n";	
							$order_data_description .= "Comments : ".$cart_data['comments']."\n";
							$order_data_description .= "Shipping : ".hook_price($cart_data['shipping'])."\n";
							$order_data_description .= "Tax : ".hook_price($cart_data['tax'])."\n";
							$order_data_description .= "Discount : ".$cart_data['discount']."\n";
							$order_data_description .= "Weight : ".$cart_data['weight']."\n";
							$order_data_description .= "Items : ".count($cart_data['items'])."\n";												
							$order_data_description .= "Order Total : ".hook_price($cart_data['total'])."\n";								 
														
							// GET ORDER SHIPPING DATA
							$order_data_description .= "\n\n\n********** Shipping Information **********\n\n";
							if(isset($cart_data['guest_data']) && !empty($cart_data['guest_data'])){
							$order_data_description .= "Name : ".$cart_data['guest_data']["billing_fname"]." ".$cart_data['guest_data']["billing_lname"]."\n";
							$order_data_description .= "Email : ".$cart_data['guest_data']["billing_email"]."\n";
							$order_data_description .= "Phone : ".$cart_data['guest_data']["billing_phone"]."\n";
							$order_data_description .= "Address 1 : ".$cart_data['guest_data']["billing_address"]."\n";
							$order_data_description .= "Address 2 : ".$cart_data['guest_data']["billing_address2"]."\n";
							$order_data_description .= "City : ".$cart_data['guest_data']["billing_city"]."\n";
							$order_data_description .= "State : ".$cart_data['guest_data']["billing_state"]."\n";
							$order_data_description .= "Country : ".$cart_data['guest_data']["billing_country"]."\n";
							$order_data_description .= "Zip/Postal Code : ".$cart_data['guest_data']["billing_zip"]."\n"; 
							}else{							
							$order_data_description .= "Name : ".get_user_meta($hassession[0]->session_userid, "billing_fname",true)." ".get_user_meta($userid, "billing_lname",true)."\n";
							$order_data_description .= "Email : ".get_user_meta($hassession[0]->session_userid, "billing_email",true)."\n";
							$order_data_description .= "Phone : ".get_user_meta($hassession[0]->session_userid, "billing_phone",true)."\n";
							$order_data_description .= "Address 1 : ".get_user_meta($hassession[0]->session_userid, "billing_address",true)."\n";
							$order_data_description .= "Address 2 : ".get_user_meta($hassession[0]->session_userid, "billing_address2",true)."\n";
							$order_data_description .= "City : ".get_user_meta($hassession[0]->session_userid, "billing_city",true)."\n";
							$order_data_description .= "State : ".get_user_meta($hassession[0]->session_userid, "billing_state",true)."\n";
							$order_data_description .= "Country : ".get_user_meta($hassession[0]->session_userid, "billing_country",true)."\n";
							$order_data_description .= "Zip/Postal Code : ".get_user_meta($hassession[0]->session_userid, "billing_zip",true)."\n";
							}
							
							// PRODUCTS
							
							$order_data_description .= "\n\n********** Ordered Products **********\n\n";
							
							foreach($cart_data['items'] as $key=>$item){
								foreach($item as $mainitem){
								
									// UPDATE STOCK COUNT
									if(get_post_meta($key,'stock_remove',true) == "1"){
										update_post_meta($key,'qty',get_post_meta($key,'qty',true)-$mainitem['qty']);
									}									 
									 
									// CREATE DESCRIPTION
									$order_data_description .= "Product #: ".$key."\n";
									$order_data_description .= "Product Name: ".$mainitem['name']."\n";									
									$order_data_description .= "Quantity: ".$mainitem['qty']."\n";
									$order_data_description .= "Unit Price: ".get_post_meta($key,'price',true)."\n";
									$order_data_description .= "Shipping: ".hook_price($mainitem['shipping'])."\n";
									$order_data_description .= "Attributes: ".$mainitem['custom']."\n";
									$order_data_description .= "Product Link: ".$mainitem['link']."\n";
									$order_data_description .= "Total: ".hook_price($mainitem['amount'])."\n\n";	
									 
								}// end foreach
							}// end foreach
						}// end if
				}// end if
				
			} 
		
		
			// ADD IN EXTRAS FOR AUCTION THEMES
			if(defined('WLT_AUCTION')){				
				// UPDATE POST DATA
				update_post_meta($obits[1],'auction_price_paid', $orderdata['total']);
				update_post_meta($obits[1],'auction_price_paid_date',date("Y-m-d H:i:s"));			
			}	
		
		}
		
		 
		// CHECK FOR RENEWAL PAYMENT
		if(substr($obits[0],0,3) == "REW" || substr($obits[0],0,3) == "SUB"){
			 
			// FIND LISTING EXPIRY DATE AND ADD TOO IT
			$d = $CORE->RENEWAL($obits[1]);	
			// get current date
			$current_date = get_post_meta($obits[1],'listing_expiry_date',true);
			// make sure its not blank and/or an older date
			if($current_date == "" || ( strtotime($current_date) < strtotime(date("Y-m-d H:i:s")) )){ $current_date = date("Y-m-d H:i:s"); }				
			//update the listing expiry date
			update_post_meta( $obits[1], 'listing_expiry_date', date("Y-m-d H:i:s", strtotime($current_date . " +".$d['days']." days")) );
			// UPDATE LISTING WITH DEFAULT LISTING ENHANCEMENTS
			$packageID = get_post_meta($obits[1],'packageID', true);
		 
			if(is_numeric($packageID)){
			$packagefields 		= get_option("packagefields");
			
				$i=1;
				foreach(array('frontpage', 'featured', 'html', 'visitorcounter', 'topcategory', 'showgooglemap') as $n){
				
					if($packagefields[$packageID]['enhancement'][$i] == 1){
						$value = "yes";
					}else{
						$value = "no";
					}
				
					update_post_meta($obits[1], $n, $value);
					$i++;
					
				}// end foreach		 
	 
			}		
			// ADD IN CHECK FOR USER ID
			$post_b = get_post($obits[1]); 
			$CHECKUSERID = $post_b->post_author;
			
		// CHECK IF THIS IS A MEMBERSHIP PAYMENT
		}elseif(substr($obits[0],0,3) == "MEM"){
		
			// UPDATE USER ACCOUNT WITH NEW MEMBERSHIP DETAILS
			$membershipfields 	= get_option("membershipfields");
			update_user_meta( $obits[2], 'wlt_membership', $obits[1] );
					
			if($membershipfields[$obits[1]]['expires'] == ""){ $expire_days = 30;  }else{ $expire_days = $membershipfields[$obits[1]]['expires']; }
			update_user_meta( $obits[2], 'wlt_membership_expires', date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +".$expire_days." days")) );	
			
			// ADD ON START DATE
			update_user_meta( $obits[2], 'wlt_membership_started', date("Y-m-d H:i:s") );
			
			// ADD IN CHECK FOR USER ID
			$CHECKUSERID = $obits[2];
			
		// CHECK IF THIS IS A MEMBERSHIP PAYMENT
		}elseif(substr($obits[0],0,3) == "PAY"){
		
			update_user_meta($obits[1],'wlt_usercredit',0);
 		 
		// CHECK IF THIS IS A DOWNLOAD PAYMENT
		}elseif(substr($obits[0],0,2) == "DL"){ 
		
			// UPDATE USERS ACCOUNT WITH DOWNLOAD OPTION
			update_user_meta($obits[2],$obits[1].'-paid','yes');			
					
		// CHECK FOR USER PAYMENT
		}elseif(substr($obits[0],0,11) == "USERPAYMENT"){
		
			// ADD IN EXTRAS FOR AUCTION THEMES
			if(defined('WLT_AUCTION')){				
				// UPDATE POST DATA
				update_post_meta($obits[1],'auction_price_paid', $orderdata['total']);
				update_post_meta($obits[1],'auction_price_paid_date',date("Y-m-d H:i:s"));
			}	
		
		// CHECK IF THIS IS A LISTING PAYMENT
		}elseif(substr($obits[0],0,3) == "LST"){ 
		 
			$my_post = array();
			if(is_numeric($obits[1])){
				$my_post['ID'] 			= $obits[1];
				$my_post['post_status'] = "publish";
				wp_update_post( $my_post );	
				
				// ADD IN CHECK FOR USER ID
				$post_b = get_post($obits[1]); 
				$CHECKUSERID = $post_b->post_author;
				 
				// UPDATE POST DATA
				update_post_meta($obits[1],'listing_price_due','0');
				update_post_meta($obits[1],'listing_price_paid',$orderdata['total']);				
				update_post_meta($obits[1],'listing_price_paid_date',date("Y-m-d-H:i:s"));				
				
				// FIND LISTING EXPIRY DATE AND ADD TOO IT
				$d = $CORE->RENEWAL($obits[1]);	
				// get current date
				$current_date = get_post_meta($obits[1],'listing_expiry_date',true);
  			
				if($current_date != "" && is_numeric($d['days']) && $d['days'] > 0){			
				//update the listing expiry date
				$renewset = true;
				update_post_meta( $obits[1], 'listing_expiry_date', date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +".$d['days']." days")) );
				}
				
				// IF THIS IS A SUBSCRIPTION LETS SET THE FLAG
				if ($_POST['txn_type'] == "subscr_signup" || $_POST['txn_type'] == "subscr_payment") { 
					update_post_meta($obits[1],'subscription','yes');
					$order_id = str_replace("LST","SUB",$order_id);
					
					// MIN 30 DAYS
					if(!isset($renewset)){
					update_post_meta( $obits[1], 'listing_expiry_date', date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +30 days")) );
					}
					
				} // end if
			} // end if
		}// end if
		
		hook_callback_process_orderid($obits);
	
	} //  end check of order id
	
	
	// FINAL CHECK FOR USER ID
	if(isset($CHECKUSERID) && is_numeric($CHECKUSERID) && $CHECKUSERID > 0){
		$saveme_orderdata['userid'] 	= $CHECKUSERID;				
		$saveme_orderdata['username'] 	= get_the_author_meta('user_login', $CHECKUSERID);
	} 
	
	// ORDER DATA FOR NON-CART THEMES
	if(!defined('WLT_CART')){
	
	$order_data_description .= "\n\n\n********** Order Information **********\n\n";
	$order_data_description .= "Date : ".hook_date(date('Y-m-d H:i:s'))."\n";
	$order_data_description .= "Order ID : ".$orderid."\n";
	$order_data_description .= "User ID : ".$user_ID."\n";	
	$order_data_description .= "Email : ".$orderdata['email']."\n";
	$order_data_description .= "Tax : ".hook_price($orderdata['tax'])."\n"; 
	$order_data_description .= "Order Total : ".hook_price($orderdata['total'])."\n";
	
	$order_data_description .= "\n\n\n********** Delivery Information **********\n\n";
	$order_data_description .= "Shipping : ".$orderdata['shipping_label']."\n";
	
	}	
				 
	// ORDER DATA			
	$saveme_orderdata['items']			= $obits[1];
	$saveme_orderdata['shipping']		= $orderdata['shipping'];
	$saveme_orderdata['tax']			= $orderdata['tax'];
	$saveme_orderdata['total']			= $orderdata['total'];
	$saveme_orderdata['status']			= 1;	
	$saveme_orderdata['email']			= $orderdata['email'];
	$saveme_orderdata['shipping_label'] = $orderdata['shipping_label'];	
	
	// SAVE ALL ORDER DATA
	$pstring = "";
	foreach($_POST as $k=>$v){$pstring .= $k.":".$v."\n"; }		
	$saveme_orderdata['paydata']		= $pstring;
 
	// ADD NEW ORDER
	$CORE->ORDER('add',$saveme_orderdata);
	
	// MAKE GLOBAL VALUES FOR CALLBACK
	$_POST['user_id'] 			= $user_ID;
	$_POST['username'] 			= $saveme_orderdata['username'];
	$_POST['order_data_raw'] 	= $saveme_orderdata;
	$_POST['order_data'] 		= $order_data_description;
	$_POST['orderid'] 			= $orderid;
	$_POST['paid_item_id'] 		= $obits[1];
}

function core_paypal_callback($c){
 
global $wpdb, $CORE, $userdata;
 
// CHECK WE HAVE RECIEVED DATA FROM PAYPAL
if(isset($_POST['custom'])  && isset($_POST['payment_status']) && strlen($_POST['payment_status']) > 1 ){
 	
	// NOW WE CHECK THE STATUS
	$order_id = trim($_POST['custom']);
	
	if( isset($_POST['txn_type']) && ( $_POST['txn_type'] == "subscr_cancel" || $_POST['txn_type'] == "subscr_eot" ) ) { 
		
		$obits = explode("-",$order_id);
		update_post_meta($obits[1],'subscription','cancelled');
		
	}elseif ($_POST['payment_status'] == "Completed" || $_POST['payment_status'] =="Pending"){
				
		// BUILD ORDER DATA FROM PAYPAL CALLBACK DATA
		$order_desc = "";
		if(isset($_POST['item_name'])){		$order_desc .= $_POST['item_name'];	}
		if(isset($_POST['item_name1'])){	$order_desc .= $_POST['item_name1']; }
		if(isset($_POST['item_name_1'])){	$order_desc .= $_POST['item_name_1']; }		
		// INFORMATION ABOUT THE BUYER
		$first_name 				= $_POST['first_name'];
		$last_name 					= $_POST['last_name'];
		$address_city 				= $_POST['address_city'];
		$address_country 			= $_POST['address_country'];
		$address_country_code 		= $_POST['address_country_code'];
		$address_name 				= $_POST['address_name'];
		$address_state 				= $_POST['address_state'];
		$address_status 			= $_POST['address_status'];
		$address_street 			= $_POST['address_street'];
		$address_zip 				= $_POST['address_zip'];				
		// BUILD SHIPPING LABEL
		$LABEL = $first_name." ".$last_name." <BR> ".$address_street." <BR> ".$address_city." <BR> ".$address_state." ".$address_zip." <BR> ".$address_country."(".$address_country_code.")";	
		// SUCCESS AND PASS IN DATA
		core_generic_gateway_callback($order_id, array('description' =>  $order_desc, 'email' => $_POST['payer_email'], 'shipping' => $_POST['mc_shipping'], 'shipping_label' => $LABEL, 'tax' => $_POST['tax'], 'total' => $_POST['mc_gross'] ) );
 	
		return "success";

	} elseif ( isset($_POST['txn_type']) &&  $_POST['txn_type'] == "subscr_payment"  ){
	
		return "success"; 
 					
	} elseif ( isset($_POST['payment_status']) && ($_POST['payment_status'] == 'Reversed') || ($_POST['payment_status'] == 'Refunded') ) {
						
		return "error";				
	}	

}

	// CATCH FALLBACK FOR TEST API AND NON POST RETURNS
	if(isset($_GET['status']) && $_GET['status'] == "thankyou"){	
		return "success";			
	}
	
	// ELSE RETURN EXISTING VALUE FROM OTHER GATEWAYS
	return $c;
	 
}




function core_usercredit_callback($c){

	global $wpdb, $CORE, $userdata;
	 
	// CHECK WE HAVE RECIEVED DATA FROM PAYPAL
	if(isset($_POST['credit_total'])  && strlen($_POST['credit_total']) > 0 && $CORE->ORDEREXISTS($_POST['custom']) == false ){
	
		$usercredit = get_user_meta($userdata->ID,'wlt_usercredit',true);
		if(isset($usercredit) && is_numeric($usercredit) && $usercredit >= $_POST['credit_total']){ 
			
			update_user_meta($userdata->ID,'wlt_usercredit', get_user_meta($userdata->ID,'wlt_usercredit',true) - $_POST['credit_total'] );
			
			// SUCCESS AND PASS IN DATA
		core_generic_gateway_callback($_POST['custom'], array('description' =>  $_POST['item_name'], 'email' => $userdata->user_email, 'shipping' => '', 'shipping_label' => $LABEL, 'tax' => 0, 'total' => $_POST['credit_total'] ) );
			
			return "success";	
			
		}else{
		
		return "error";	
		
		}	
	}
	
	// ELSE RETURN EXISTING VALUE FROM OTHER GATEWAYS
	return $c;

}


?>
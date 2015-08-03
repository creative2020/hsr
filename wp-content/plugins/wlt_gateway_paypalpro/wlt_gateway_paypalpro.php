<?php
/*
Plugin Name: [PAYMENT GATEWAY] - PayPal Pro
Plugin URI: http://www.premiumpress.com
Description: This plugin will add PayPalPro to your PremiumPress payment gateways list.
Version: 1.0
Author: Mark Fail
Author URI: http://www.premiumpress.com
Updated: 17th July 2013
License:
*/

//1. HOOK INTO THE GATEWAY ARRAY
function wlt_gateway_PayPalPro_admin($gateways){
	$nId = count($gateways)+1;
	$gateways[$nId]['name'] 		= "PayPal Pro";
	$gateways[$nId]['logo'] 		= plugins_url()."/wlt_gateway_paypalpro/img/logo.jpg";
	$gateways[$nId]['function'] 	= "wlt_gateway_PayPalPro_form";
	$gateways[$nId]['website'] 		= "http://www.PayPalPro.com";
	$gateways[$nId]['callback'] 	= "yes";
	$gateways[$nId]['ownform'] 		= "yes";
	$gateways[$nId]['fields'] 		= array(
	'1' => array('name' => 'Enable Gateway', 'type' => 'listbox','fieldname' => $gateways[$nId]['function'],'list' => array('yes'=>'Enable','no'=>'Disable',) ),
	
								
	'2' => array('name' => 'Username', 'type' => 'text', 'fieldname' => 'paypalpro_username' ),
	'3' => array('name' => 'Password', 'type' => 'text', 'fieldname' => 'paypalpro_password', ),
	'4' => array('name' => 'Signature', 'type' => 'text', 'fieldname' => 'paypalpro_sig', ),
 
	'5' => array('name' => 'Currency Code', 'type' => 'text', 'fieldname' => 'paypalpro_currency', 'default' => 'USD'),	
	'6' => array('name' => 'Display Name', 'type' => 'text', 'fieldname' => $gateways[$nId]['function'].'_name', 'default' => 'Pay Now with PayPalPro'),
	);
	$gateways[$nId]['notes'] 	= "";
	return $gateways;
}
add_action('hook_payments_gateways','wlt_gateway_PayPalPro_admin');

//2. BUILD THE PAYMENT FORM DATA
function wlt_gateway_PayPalPro_form($data=""){

	global $wpdb;
	
    /* DATA AVAILABLE
   
	$GLOBALS['total'] 	 
	$GLOBALS['subtotal'] 	 
	$GLOBALS['shipping'] 	 
	$GLOBALS['tax'] 		 
	$GLOBALS['discount'] 	 
	$GLOBALS['items'] 		 
	$GLOBALS['orderid'] 	 
	$GLOBALS['description'] 
    
    */
	
$gatewaycode = '<form method="POST" action="">
<input type="hidden" name="payment_gateway_paypal_pro" value="1" />

<input type="hidden" name="paymentType" value="instant" />
<input type="hidden" name="gateway" value="paypalpro" />
<input type="hidden" name="pro[amount]" value="'.$GLOBALS['total'].'">
<input type="hidden" value="'.$GLOBALS['orderid'].'" name="paypal_order_id">
<input type="hidden" value="0" name="recurring"> 
<input type="hidden" value="'.$GLOBALS['description'].'" name="description"> 

 

<div class="row-fluid">
 
	<div class="span6"> 
	  <label class="col1">First Name:</label>    
	  <input  class="mid2" type=text size=30 maxlength=32 name="firstName" value=""> 
	</div>
	
	<div class="span6"> 
			<label class="col1">Last Name:</label> 
			<input class="mid2"  type=text size=30 maxlength=32 name=lastName value="">
	</div> 

</div><div class="row-fluid"> 

<div class="span6"> 
<label class="col1">Card Type:</label> 
<span class="col2"><select  class="mid2" name=creditCardType onchange="javascript:generateCC(); return false;">
				<option value=Visa selected>Visa</option>
				<option value=MasterCard>MasterCard</option>
				<option value=Discover>Discover</option>
				<option value=Amex>American Express</option>
			</select></span>      
</div>

<div class="span6"> 
    <label class="col1">Card Number:</label> 
<span class="col2"><input  class="mid2" type=text size=19 maxlength=19 name="creditCardNumber"></span>    
</div>

</div><div class="row-fluid"> 
 

<div class="span6"> 
<label class="col1">Expiration Date:</label>

<div class="row-fluid">
	<div class="span4">	  
	<select name="expDateMonth" style="width:100px;">
					<option value=1>01</option>
					<option value=2>02</option>
					<option value=3>03</option>
					<option value=4>04</option>
					<option value=5>05</option>
					<option value=6>06</option>
					<option value=7>07</option>
					<option value=8>08</option>
					<option value=9>09</option>
					<option value=10>10</option>
					<option value=11>11</option>
					<option value=12>12</option>
	</select>
			
	</div><div class="span6">
	
				<select name="expDateYear" style="width:100px;">
					 
					<option value=2013>2013</option>
					<option value=2014>2014</option>
					<option value=2015>2015</option>
					<option value=2016>2016</option>
					<option value=2017>2017</option>
					<option value=2018>2018</option>
					<option value=2019>2019</option>
					<option value=2020>2020</option>
					<option value=2021>2021</option>
					<option value=2022>2022</option>
				</select>
	</div>		 
</div>
</div>

<div class="span6"> 
      <label class="col1">Card Verification Number:</label>
<span class="col2"><input type="text" maxlength=4 name="cvv2Number" style="width:100px;"></span>  
</div>


</div> 

<h3>Billing Address:</h3>
<hr style="margin-top:0px;" />

<div class="row-fluid"> 
 
	<div class="span6"> 
	<label class="col1">Address 1 </label>
	<span class="col2"><input  class="mid2" type=text size=25 maxlength=100 name=address1 value=""></span>
	</div>
	
	<div class="span6">
	<label class="col1">Address 2 (optional)</label>
	<span class="col2"><input  class="mid2" type=text  size=25 maxlength=100 name=address2 value=""></span> 
	</div>

</div><div class="row-fluid"> 

	 
	<div class="span6"> 
	<label class="col1">Country:</label>
	
	<span class="col2">
	<select name="country" id="country"  class="short" tabindex="10">';
	
	foreach($GLOBALS['core_country_list'] as $key=>$value){
	$gatewaycode .= '<option value="'.$key.'">'.$value.'</option>';
	}
				
	$gatewaycode .= '</select>
	</span>	
	</div>
	
	<div class="span6"> 
	<label class="col1">City:</label>
	<span class="col2">
	<input  class="mid2" type=text size=25 maxlength=40 name=city value="">
	<input type="hidden"  class="mid2" id=state name=state value=""> </span>
	</div>

</div><div class="row-fluid"> 


<div class="span6"> 
<label class="col1">State:</label>
<select  class="mid2" id=state name=state>
				<option value="AK">Other (outside USA)</option>
				<option value=AK>AK</option>
				<option value=AL>AL</option>
				<option value=AR>AR</option>
				<option value=AZ>AZ</option>
				<option value=CA selected>CA</option>
				<option value=CO>CO</option>
				<option value=CT>CT</option>
				<option value=DC>DC</option>
				<option value=DE>DE</option>
				<option value=FL>FL</option>
				<option value=GA>GA</option>
				<option value=HI>HI</option>
				<option value=IA>IA</option>
				<option value=ID>ID</option>
				<option value=IL>IL</option>
				<option value=IN>IN</option>
				<option value=KS>KS</option>
				<option value=KY>KY</option>
				<option value=LA>LA</option>
				<option value=MA>MA</option>
				<option value=MD>MD</option>
				<option value=ME>ME</option>
				<option value=MI>MI</option>
				<option value=MN>MN</option>
				<option value=MO>MO</option>
				<option value=MS>MS</option>
				<option value=MT>MT</option>
				<option value=NC>NC</option>
				<option value=ND>ND</option>
				<option value=NE>NE</option>
				<option value=NH>NH</option>
				<option value=NJ>NJ</option>
				<option value=NM>NM</option>
				<option value=NV>NV</option>
				<option value=NY>NY</option>
				<option value=OH>OH</option>
				<option value=OK>OK</option>
				<option value=OR>OR</option>
				<option value=PA>PA</option>
				<option value=RI>RI</option>
				<option value=SC>SC</option>
				<option value=SD>SD</option>
				<option value=TN>TN</option>
				<option value=TX>TX</option>
				<option value=UT>UT</option>
				<option value=VA>VA</option>
				<option value=VT>VT</option>
				<option value=WA>WA</option>
				<option value=WI>WI</option>
				<option value=WV>WV</option>
				<option value=WY>WY</option>
				<option value=AA>AA</option>
				<option value=AE>AE</option>
				<option value=AP>AP</option>
				<option value=AS>AS</option>
				<option value=FM>FM</option>
				<option value=GU>GU</option>
				<option value=MH>MH</option>
				<option value=MP>MP</option>
				<option value=PR>PR</option>
				<option value=PW>PW</option>
				<option value=VI>VI</option>
			</select>

</div>
<div class="span6"> 
<label class="col1">Postal/ZIP Code (5 or 9 digits)</label>
<span class="col2"><input  class="mid2" type=text size=10 maxlength=10 name=zip value=""> </span>
</div>


</div>
 
<div class="clear"></div>
<hr />

<div style="text-align:center;"><input type="submit" value="Process Payment" class="btn btn-primary"></div>

 </div>
</form>
 
 
<script language="javascript">
	generateCC();
</script>';

 

return $gatewaycode;

}

// 3. HANDLE THE CALLBACK FROM PAYPAL PRO
function _process_paypal_pro(){ global $CORE, $wpdb, $userdata;
	// PROCESS THE PAYMENT
	if(isset($_POST['payment_gateway_paypal_pro']) && $_POST['pro']['amount'] > 0){	
 
			// DEFINE API DETAILS
			define('API_USERNAME', get_option('paypalpro_username'));
			define('API_PASSWORD', get_option('paypalpro_password'));
			define('API_SIGNATURE', get_option('paypalpro_sig'));
			require_once (WP_PLUGIN_DIR."/wlt_gateway_paypalpro/class/class_paypal_pro.php");	 
		
			$firstName 			= urlencode( $_POST['firstName']);
			$lastName 			= urlencode( $_POST['lastName']);
			$creditCardType 	= urlencode( $_POST['creditCardType']);
			$creditCardNumber 	= urlencode($_POST['creditCardNumber']);
			$expDateMonth 		= urlencode( $_POST['expDateMonth']);
			$padDateMonth 		= str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);
			$expDateYear 		= urlencode( $_POST['expDateYear']);
			$cvv2Number 		= urlencode($_POST['cvv2Number']);
			$address1 			= urlencode($_POST['address1']);
			$address2 			= urlencode($_POST['address2']);
			$city 				= urlencode($_POST['city']);
			$state 				= urlencode( $_POST['state']);
			$zip 				= urlencode($_POST['zip']);
			$amount 			= urlencode($_POST['pro']['amount']);
			$currencyCode		= get_option('paypalpro_currency');
			$paymentAction 		= urlencode("Sale");
		
			if($_POST['recurring'] == 1) // For Recurring
			{
				$profileStartDate = urlencode(date('Y-m-d h:i:s'));
				$billingPeriod = urlencode($_POST['billingPeriod']);// or "Day", "Week", "SemiMonth", "Year"
				$billingFreq = urlencode($_POST['billingFreq']);// combination of this and billingPeriod must be at most a year
				$initAmt = $amount;
				$failedInitAmtAction = urlencode("ContinueOnFailure");
				$desc = urlencode("Recurring $".$amount);
				$autoBillAmt = urlencode("AddToNextBilling");
				$profileReference = urlencode("Anonymous");
				$methodToCall = 'CreateRecurringPaymentsProfile';
				$nvpRecurring ='&BILLINGPERIOD='.$billingPeriod.'&BILLINGFREQUENCY='.$billingFreq.'&PROFILESTARTDATE='.$profileStartDate.'&INITAMT='.$initAmt.'&FAILEDINITAMTACTION='.$failedInitAmtAction.'&DESC='.$desc.'&AUTOBILLAMT='.$autoBillAmt.'&PROFILEREFERENCE='.$profileReference;
			}
			else
			{
				$nvpRecurring = '';
				$methodToCall = 'doDirectPayment';
			}
		
			$nvpstr='&PAYMENTACTION='.$paymentAction.'&AMT='.$amount.'&CREDITCARDTYPE='.$creditCardType.'&ACCT='.$creditCardNumber.'&EXPDATE='.         $padDateMonth.$expDateYear.'&CVV2='.$cvv2Number.'&FIRSTNAME='.$firstName.'&LASTNAME='.$lastName.'&STREET='.$address1.'&CITY='.$city.'&STATE='.$state.'&ZIP='.$zip.'&COUNTRYCODE=US&CURRENCYCODE='.$currencyCode.$nvpRecurring;
			$paypalPro = new paypal_pro(API_USERNAME, API_PASSWORD, API_SIGNATURE, '', '', FALSE, FALSE );
			$resArray = $paypalPro->hash_call($methodToCall,$nvpstr);
			$ack = strtoupper($resArray["ACK"]);
		
			if($ack != "SUCCESS"){ // ERROR
				  
				$GLOBALS['error_message'] ="<b>Payment Failed</b> ".$resArray['L_LONGMESSAGE0']."";
		
			}else{
 
				// SUCCESS AND PASS IN DATA
				core_generic_gateway_callback($_POST['paypal_order_id'], array('description' =>  $_POST['description'], 'email' => $userdata->user_email, 'shipping' => 0, 'shipping_label' => '', 'tax' => 0, 'total' => $_POST['pro']['amount'] ) );
 	
				// REDIRECT USER ON SUCCESSFUL PAYMENT
				header("location:".$GLOBALS['CORE_THEME']['links']['callback']."?status=thankyou");
				return "thankyou";
			
			}
	
	}
}
add_action('init','_process_paypal_pro');
?>
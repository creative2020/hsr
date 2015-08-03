// JavaScript Document
function addProduct(SessionID, siteurl, clickparts, go_to_link) {
// ASSIGN DEFAULTS
productextraprice = 0;
productprice = 0;
productqty   = 1;
productshipping =0;

// CHECK FOR EXTRAS
var productextras = jQuery("#wlt_shop_custom_data").val();				

// SPLIT THE INPUT DATA
prodparts 		= clickparts.split("|");			
productid 		= prodparts[0];
productprice 	= prodparts[1]; 
product_existing_id 	= prodparts[2]; 

// UPDATE THE CART TOTALS
current_amount_total = jQuery("#wlt_cart_total").text();
	current_amount_total = current_amount_total.replace(',', '');
	newtotal = parseFloat(current_amount_total)+ ( parseFloat(productprice) * parseFloat(productqty) + parseFloat(productextraprice) );
	newtotal = Math.round(newtotal*100)/100;
	newtotal = newtotal.toFixed(2);		
	// OUTPUT
	jQuery("#wlt_cart_total").text(newtotal);
	  
// UPDATE THE CART QTY VALUE
var FindQty = jQuery("#wlt_shop_qty_data").val();
if(FindQty != ""){ productqty = FindQty; }

	current_amount_qty = jQuery("#wlt_cart_qty").text();     
	newqty = parseFloat(current_amount_qty)+parseFloat(productqty);
	// OUTPUT
	jQuery("#wlt_cart_qty").text(newqty);

// SAVE CHANGES
jQuery.get(siteurl, {  sid: SessionID,  cart_action: "addproduct", id: productid, qty: productqty, ship:productshipping, extras:productextras, existingID:product_existing_id   } ); 
  
} // END FUNCTION
  
  
 
 function removeAll(SessionID,siteurl,productid, innerid, amounttoremove, go_to_link, qty) {
 	
	// UPDATE THE CART QTY DISPLAY
	varcartqty = jQuery("#wlt_cart_qty").text();

	newqty = parseFloat(varcartqty)-qty;	
	//protect against going below zero.
	if(newqty < 0) newqty = 0;	
	jQuery("#wlt_cart_qty").text(newqty);
	
	// UPDATE THE CART PRICE DISPLAY		
	var current_amount_total = jQuery("#wlt_cart_total").text();   
	newtotal =  parseFloat(current_amount_total) - parseFloat(amounttoremove);
	//protect against going below zero.
	if(parseFloat(newtotal) < 0) newtotal = 0;  
	jQuery("#wlt_cart_total").text(newtotal);
	
	// SAVE CHANGES
	jQuery.get(siteurl, { sid: SessionID, cart_action: "removeall", pid: productid, nid: innerid } ); 
	
	// REFRESH THE CHECKOUT PAGE
	setTimeout(function(){ rdirectmehere(go_to_link);}, 1000);
}  
function removeProduct(SessionID,siteurl,productid, innerid, amounttoremove, go_to_link) {
 	
	// UPDATE THE CART QTY DISPLAY
	varcartqty = jQuery("#wlt_cart_qty").text();

	newqty = parseFloat(varcartqty)-1;	
	//protect against going below zero.
	if(newqty < 0) newqty = 0;	
	jQuery("#wlt_cart_qty").text(newqty);
	
	// UPDATE THE CART PRICE DISPLAY		
	var current_amount_total = jQuery("#wlt_cart_total").text();   
	newtotal =  parseFloat(current_amount_total) - parseFloat(amounttoremove);
	//protect against going below zero.
	if(parseFloat(newtotal) < 0) newtotal = 0;  
	jQuery("#wlt_cart_total").text(newtotal);
	
	// SAVE CHANGES
	jQuery.get(siteurl, { sid: SessionID, cart_action: "removeproduct", pid: productid, nid: innerid } ); 
	
	// REFRESH THE CHECKOUT PAGE
	setTimeout(function(){ rdirectmehere(go_to_link);}, 1000);
} 

function rdirectmehere(go_to_link){	
window.location.href = go_to_link;
}  
  
  
/*
This function takes care of formatting the custom field values for
products and setting them ready for adding to basket
*/
function HandleCustomSelection(val, txt, old_div, df){
	 
 
	if(val == "" || val == 0){ 
		jQuery('#wlt_shop_required').val(0);
		jQuery("#wlt_listingpage_pricetag").text(df);
		return false; 
	}
	
	// GET CURRENT AMOUNT
	cm = jQuery("#wlt_listingpage_pricetag").text();
	if(cm == ""){
	current_amount_total = jQuery("#wlt_listingpage_default_price").val();	
	}else {
	current_amount_total = cm;	
	}
	
	// SET THE CUSTOM FORMAT
	var customformat = txt+'|'+val+',';
	// REMOVE THE OLD ONE IF THERE IS ANY
	jQuery("#wlt_shop_custom_data").val(jQuery("#wlt_shop_custom_data").val().replace(''+jQuery("#"+old_div).val()+'', ''));  
	// NOW SET THE OLD ONE TO THE NEW ONE
	jQuery("#"+old_div).val(customformat);
	// NOW ADD THE NEW VALUE TO THE SAVED DATA LIST
	jQuery("#wlt_shop_custom_data").val(jQuery("#wlt_shop_custom_data").val()+customformat);
	// NOW IF ITS A NUMERICAL VALUE, INCREASE THE DISPLAY PRICE
	if(jQuery.isNumeric(val)){ 
		productqty = 1;
		
		current_amount_total = current_amount_total.replace(',', '');
		newtotal = parseFloat(current_amount_total)+ ( parseFloat(val) * parseFloat(productqty) );
		newtotal = Math.round(newtotal*100)/100;
		newtotal = newtotal.toFixed(2);	
		newtotal = newtotal.replace(".00", "");
		// OUTPUT
		jQuery("#wlt_listingpage_pricetag").text(newtotal);
	
	}
}
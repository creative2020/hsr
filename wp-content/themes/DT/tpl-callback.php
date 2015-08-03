<?php
/*
Template Name: [Payment Callback]
*/
?>
 
<?php get_header($CORE->pageswitch()); ?>

<?php 
	
	switch($payment_status){ 
	
		case "success": { 
		
			get_template_part( 'payment', 'thankyou' );
		
		} break;
		
		default: {
		
		 get_template_part( 'payment', 'error' );
		 
		} 
	
	}
?>    
		
<?php get_footer($CORE->pageswitch()); ?>
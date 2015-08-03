<?php
/* =============================================================================
[FRAMEWORK] LIST OF ALL HOOKS AND FILTERS
========================================================================== */

// REDIRECT HOOK
function hook_redirectlink($c){   return  apply_filters('hook_redirectlink', $c);   }


// OLD HOOKED NO LONGER USED BY THE CORE
function hook_gallerypage_item($c){   return  apply_filters('hook_gallerypage_item', $c);   }

// MOBILE HOOKS
function hook_mobile_header(){  do_action('hook_mobile_header');  } 
function hook_mobile_footer(){  do_action('hook_mobile_footer');  } 

function hook_mobile_content_homepage($c){   return  apply_filters('hook_mobile_content_homepage', $c);   }

function hook_mobile_content_output(){  do_action('hook_mobile_content_output');  } 
function hook_mobile_content_listing_output(){  do_action('hook_mobile_content_listing_output');  } 

function hook_mobile_content($c){   return  apply_filters('hook_mobile_content', $c);   }
function hook_mobile_content_listing($c){   return  apply_filters('hook_mobile_content_listing', $c);   }

// CONTENT LAYOUT FILTERS
function hook_listing_templatename($c){ return  apply_filters('hook_listing_templatename', $c);  }
function hook_content_templatename($c){ return  apply_filters('hook_content_templatename', $c);  }
 
	// PAGE WRAPPER
	function hook_wrapper_before(){  do_action('hook_wrapper_before');  } 
	function hook_wrapper_after(){  do_action('hook_wrapper_after');  }  

	// CONTENT	
	function hook_container_before(){  do_action('hook_container_before');  } 
	function hook_container_after(){  do_action('hook_container_after');  } 
	function hook_core_columns_after(){  do_action('hook_core_columns_after');  }	
	function hook_core_columns_wrapper_inside(){  do_action('hook_core_columns_wrapper_inside');  }
	function hook_core_columns_wrapper_inside_inside(){  do_action('hook_core_columns_wrapper_inside_inside');  }
	function hook_core_columns_wrapper_middle_inside(){  do_action('hook_core_columns_wrapper_middle_inside');  }
	
	
		function hook_core_columns_left_top(){  do_action('hook_core_columns_left_top');  }
	 	function hook_core_columns_left_bottom(){  do_action('hook_core_columns_left_bottom');  }
 		function hook_core_columns_right_top(){  do_action('hook_core_columns_right_top');  }
	 	function hook_core_columns_right_bottom(){  do_action('hook_core_columns_right_bottom');  }
		
	// HEADER
	function hook_meta(){  do_action('hook_meta');  }	
	function hook_custom_css($c){   return  apply_filters('hook_custom_css', $c);   }
	function hook_topmenu($c){ return  apply_filters('hook_topmenu', $c);  }	
	function hook_header($c){ return  apply_filters('hook_header', $c);  }	
	function hook_header_navbar($c){ return  apply_filters('hook_header_navbar', $c);  }
		function hook_header_row_top($c){ return  apply_filters('hook_header_row_top', $c);  }
		function hook_header_row_bottom($c){ return  apply_filters('hook_header_row_bottom', $c);  }
	function hook_header_after(){  do_action('hook_header_after');  }		
	function hook_logo($c){ return  apply_filters('hook_logo', $c);  }
	function hook_logo_wrapper($c){ return  apply_filters('hook_logo_wrapper', $c);  } 		 
	function hook_menu($c){ return  apply_filters('hook_menu', $c);  }	
	function hook_menu_mobile($c){ return  apply_filters('hook_menu_mobile', $c);  }
	function hook_menu_searchbox($c){ return  apply_filters('hook_menu_searchbox', $c);  }	
	function hook_header_searchbox($c){ return  apply_filters('hook_header_searchbox', $c);  }	
	function hook_header_layout($c){ return  apply_filters('hook_header_layout', $c);  }	
	function hook_welcometext($c){ return  apply_filters('hook_welcometext', $c);  }
	function hook_header_style5($c){ return  apply_filters('hook_header_style5', $c);  }
	function hook_header_style6($c){ return  apply_filters('hook_header_style6', $c);  }
	
	

	// BREADCRUMBS
	function hook_breadcrumbs($c){ return  apply_filters('hook_breadcrumbs', $c);  }		 
	function hook_breadcrumbs_func($c){ return  apply_filters('hook_breadcrumbs_func', $c);  }	
	function hook_breadcrumbs_before(){  do_action('hook_breadcrumbs_before');  }		 
	function hook_breadcrumbs_after(){  do_action('hook_breadcrumbs_after');  }		
	
	// BANNERS
	function hook_banner_header($c){ return  apply_filters('hook_banner_header', $c);  }	
		function hook_banner_header_wrapper($c){ return  apply_filters('hook_banner_header_wrapper', $c);  }
	function hook_banner_footer($c){ return  apply_filters('hook_banner_footer', $c);  }
	
	// LOGIN PAGE
	function hook_login_before(){  do_action('hook_login_before');  } 
	function hook_login_after(){  do_action('hook_login_after');  } 


	// REGISTER PAGE
	function hook_register_before(){  do_action('hook_register_before');  } 
	function hook_register_after(){  do_action('hook_register_after');  } 
 	
	// FOOTER
	function hook_includes($c){ return  apply_filters('hook_includes', $c);  } // CORE JAVASCRIPT INCLUDES
	function hook_footer($c){ return  apply_filters('hook_footer', $c);  } 	
 	function hook_footer_socialicons($c){ return  apply_filters('hook_footer_socialicons', $c);  } 	
 
	// HOME PAGE
	function hook_homepage_before(){  do_action('hook_homepage_before');  }  
	function hook_homepage_after(){  do_action('hook_homepage_after');  } 
   	
	// SINGLE LISTING PAGE
	function hook_content_single_listing($c){   return  apply_filters('hook_content_single_listing', $c);   }
	function hook_content_single_listing_print($c){   return  apply_filters('hook_content_single_listing_print', $c);   }
	
	function hook_single_before(){  do_action('hook_single_before');  }  
	function hook_single_after(){  do_action('hook_single_after');  }  
 	
 	function hook_single_images($c){   return  apply_filters('hook_single_images', $c); } 
	function hook_single_toolbox($c){   return  apply_filters('hook_single_toolbox', $c);   }
	function hook_single_javascript($c){   return  apply_filters('hook_single_javascript', $c);   }	
	function hook_shortcode_comments($c){ return  apply_filters('hook_shortcode_comments', $c); }
	
	// PAGE
	function hook_page_before(){  do_action('hook_page_before');  }  
	function hook_page_after(){  do_action('hook_page_after');  } 

	// PAGE
	function hook_author_before(){  do_action('hook_author_before');  }  
	function hook_author_after(){  do_action('hook_author_after');  } 
	function hook_author_inner_bottom(){  do_action('hook_author_inner_bottom');  } 
 	
	// ACCOUNT PAGE
	function hook_account_before(){  do_action('hook_account_before');  }  
	function hook_account_after(){  do_action('hook_account_after');  }  
	function hook_account_menu(){  do_action('hook_account_menu');  }	
	function hook_account_save(){  do_action('hook_account_save');  }
	function hook_account_update(){  do_action('hook_account_update');  }
	
	function hook_account_mydetails_after(){ do_action('hook_account_mydetails_after'); }  
	
	function hook_account_pagelist($c){   return  apply_filters('hook_account_pagelist', $c);   }	

	
	
	function hook_account_orders_after(){ do_action('hook_account_orders_after'); }  
	function hook_account_orders_table($c){   return  apply_filters('hook_account_orders_table', $c);   }	
	

	// ADD PAGE
	function hook_tpl_add_field_validation(){  do_action('hook_tpl_add_field_validation');  }  
	
	function hook_packages($c){   return  apply_filters('hook_packages', $c);   }
	function hook_packages_before(){  do_action('hook_packages_before');  }  
	function hook_packages_after(){  do_action('hook_packages_after');  } 
 	function hook_packages_block($c){   return  apply_filters('hook_packages_block', $c);   }
	
	function hook_add_before(){  do_action('hook_add_before');  }  
	function hook_add_after(){  do_action('hook_add_after');  }
	function hook_add_before_media(){  do_action('hook_add_before_media');  }	 
	
	function hook_add_form_top(){  do_action('hook_add_form_top');  } 
 	function hook_add_form_bottom(){  do_action('hook_add_form_bottom');  } 
  	function hook_add_form_abovebutton(){  do_action('hook_add_form_abovebutton');  } 
	
		function hook_add_form_post_content($c, $val){   $s = apply_filters('hook_add_form_post_content', array($c, $val) ); return $s[0];   }
		function hook_add_form_post_save_data($val){   return apply_filters('hook_add_form_post_save_data', $val );   }
		function hook_add_form_post_save_extra($postID){   return apply_filters('hook_add_form_post_save_extra', $postID );   }
		function hook_add_fieldlist($c){ return apply_filters('hook_add_fieldlist', $c );   }
 		function hook_add_build_field($string){ return apply_filters('hook_add_build_field', $string );   }
		function hook_custom_fields_filter($c){ return apply_filters('hook_custom_fields_filter', $c );   }
		function hook_add_post_title_text($c){ return apply_filters('hook_add_post_title_text', $c );   }
		
		
		function hook_add_listdata($c){ return apply_filters('hook_add_listdata', $c );   }
		function hook_add_listtitles($c){ return apply_filters('hook_add_listtitles', $c );   }
		
		
	// GALLERY PAGE
	function hook_content_listing($c){   return  apply_filters('hook_content_listing', $c);   }	
	function hook_content_listing_class($c){ return  apply_filters('hook_content_listing_class', $c);  }
	
	function hook_gallerypage_before(){  do_action('hook_gallerypage_before');  }  
	function hook_gallerypage_after(){  do_action('hook_gallerypage_after');  }  
	function hook_items_before(){  do_action('hook_items_before');  } 
	function hook_items_after(){  do_action('hook_items_after');  }
	function hook_item_class(){   do_action('hook_item_class');   }	
 	
	function hook_item_cleanup($c){   return  apply_filters('hook_item_cleanup', $c);   } 
	function hook_item_pre_code($c){   return  apply_filters('hook_item_pre_code', $c);   }
	function hook_item_pre_code_out($c){   return  apply_filters('hook_item_pre_code_out', $c);   } 
	function hook_orderby_list($c){   return  apply_filters('hook_orderby_list', $c);   } 
	function hook_item_hover_content($c){   return  apply_filters('hook_item_hover_content', $c);   } 	
	function hook_gallerypage_results_before(){  do_action('hook_gallerypage_results_before');  } 
	function hook_gallerypage_results_after(){  do_action('hook_gallerypage_results_after');  } 
	function hook_gallerypage_results_btngroup(){  do_action('hook_gallerypage_results_btngroup');  } 
	function hook_gallerypage_results_text($c){   return  apply_filters('hook_gallerypage_results_text', $c);   } 
	function hook_gallerypage_results_title($c){   return  apply_filters('hook_gallerypage_results_title', $c);   }
  	function hook_gallerypage_results_top(){  do_action('hook_gallerypage_results_top');  } 
 	
	// CALLBACK PAGE
	function hook_payments_gateways($gateways){ return  apply_filters('hook_payments_gateways', $gateways);  }		 
	function hook_callback($c){ return  apply_filters('hook_callback',$c);  }	 
	function hook_callback_success(){  do_action('hook_callback_success');  }  
	function hook_callback_error(){  do_action('hook_callback_error');  }  
	function hook_callback_process_orderid($c){ return  apply_filters('hook_callback_process_orderid', $c); }
	
	// IMAGE EDITING HOOKS
	function hook_upload_delete($post_id,$imagename,$user_id){return apply_filters('hook_upload_delete',array($post_id, $imagename,$user_id));}
	function hook_upload_edit($post_id){   return  apply_filters('hook_upload_edit', $post_id);   }
	function hook_upload($postID, $file, $featured = false){  return  apply_filters('hook_upload',array($postID, $file, $featured) );   } 	
	function hook_upload_return($file){   return  apply_filters('hook_upload_return', $file);   }	
	function hook_image_display($c){   return  apply_filters('hook_image_display', $c);   }	 	
	function hook_fallback_image_display($c){   return  apply_filters('hook_fallback_image_display', $c);   }
	
	// CART
	function hook_cart_data($c){   return  apply_filters('hook_cart_data', $c);   }
	function hook_addcart_small($c){   return  apply_filters('hook_addcart_small', $c);   }
	function hook_addcart_big($c){   return  apply_filters('hook_addcart_big', $c);   }
	
	function hook_checkout_paymentoptions($c){   return  apply_filters('hook_checkout_paymentoptions', $c);   }
	function hook_checkout_before_paymentoptions(){ do_action('hook_checkout_before_paymentoptions'); }
	function hook_checkout_after_paymentoptions(){ do_action('hook_checkout_after_paymentoptions'); }
	
	// WIDGET BLOCKS - CUSTOM OBJECTS NOT WORDPRESS
	function hook_object($c =array()){   return  apply_filters('hook_object', $c);   } // FORMATS THE OUTPUT FRONTEND
	function hook_object_list($c){   return  apply_filters('hook_object_list', $c);   } // FORMATS ARRAY LIST BACKEND
	function hook_object_listtypes($c){   return  apply_filters('hook_object_listtypes', $c);   } // FORMATS ARRAY LIST BACKEND
	function hook_object_settings(){ do_action('hook_object_settings'); }
	 function hook_object_setup($c){ return  apply_filters('hook_object_setup', $c); }
	 
	 // SHORTCODE LIST
	function hook_shortcodelist($c){ return  apply_filters('hook_shortcodelist', $c); }
	function hook_shortcode_fields_show($c){ return  apply_filters('hook_shortcode_fields_show', $c); }
 	
	// ADMIN 0
	function hook_admin_0_tabs($c){   return  apply_filters('hook_admin_0_tabs', $c);   }
  	function hook_admin_0_content(){  do_action('hook_admin_0_content');  } 
		 
	// ADMIN 1
	function hook_admin_1_tabs($c){   return  apply_filters('hook_admin_1_tabs', $c);   }
  	function hook_admin_1_content(){  do_action('hook_admin_1_content');  } 
	
	
	function hook_admin_1_tab1_tablist(){  do_action('hook_admin_1_tab1_tablist');  }	
	function hook_admin_1_tab1_newsubtab(){  do_action('hook_admin_1_tab1_newsubtab');  }
	function hook_admin_1_tab1_subtab1(){  do_action('hook_admin_1_tab1_subtab1');  }
	function hook_admin_1_tab1_subtab1_bottom(){  do_action('hook_admin_1_tab1_subtab1_bottom');  }
	function hook_admin_1_tab1_subtab2(){  do_action('hook_admin_1_tab1_subtab2');  }
		function hook_admin_1_tab1_mobile_homelist(){  do_action('hook_admin_1_tab1_mobile_homelist');  }
		function hook_admin_1_tab1_subtab2_pagelist($c){  return  apply_filters('hook_admin_1_tab1_subtab2_pagelist', $c);  }
	function hook_admin_1_tab1_subtab3(){  do_action('hook_admin_1_tab1_subtab3');  }
	function hook_admin_1_tab1_subtab4(){  do_action('hook_admin_1_tab1_subtab4');  }
	function hook_admin_1_tab1_subtab5(){  do_action('hook_admin_1_tab1_subtab5');  }
	function hook_admin_1_tab1_subtab6(){  do_action('hook_admin_1_tab1_subtab6');  }
 
	
	function hook_admin_1_tab2_left(){  do_action('hook_admin_1_tab2_left');  }
	function hook_admin_1_tab2_right(){  do_action('hook_admin_1_tab2_right');  }
	
	function hook_admin_1_tab3_left(){  do_action('hook_admin_1_tab3_left');  }
	function hook_admin_1_tab3_right(){  do_action('hook_admin_1_tab3_right');  }
	
	function hook_admin_1_tab4_left(){  do_action('hook_admin_1_tab4_left');  }
	function hook_admin_1_tab4_right(){  do_action('hook_admin_1_tab4_right');  }
	
	// ADMIN 2 	
	function hook_admin_2_tabs($c){   return  apply_filters('hook_admin_2_tabs', $c);   }
  	function hook_admin_2_content(){  do_action('hook_admin_2_content');  }	
	
	function hook_admin_2_tab1_left(){  do_action('hook_admin_2_tab1_left');  }
	function hook_admin_2_tab1_right(){  do_action('hook_admin_2_tab1_right');  }
	
	//function hook_admin_2_tab2_left(){  do_action('hook_admin_2_tab2_left');  }
	//function hook_admin_2_tab2_right(){  do_action('hook_admin_2_tab2_right');  }
	
	function hook_admin_2_tab3_left(){  do_action('hook_admin_2_tab3_left');  }
	function hook_admin_2_tab3_right(){  do_action('hook_admin_2_tab3_right');  }	
	
	function hook_admin_2_tab4_left(){  do_action('hook_admin_2_tab4_left');  }
	function hook_admin_2_tab4_right(){  do_action('hook_admin_2_tab4_right');  }	
 	
	function hook_admin_2_tab5_left(){  do_action('hook_admin_2_tab5_left');  }
	function hook_admin_2_tab5_right(){  do_action('hook_admin_2_tab5_right');  }		
	
  		function hook_admin_2_tags_listing(){  do_action('hook_admin_2_tags_listing');  } 
  		function hook_admin_2_tags_search(){  do_action('hook_admin_2_tags_search');  } 
		
		function hook_admin_2_homepage_settings(){  do_action('hook_admin_2_homepage_settings');  } 
		
		function hook_admin_2_homepage_subtabs(){  do_action('hook_admin_2_homepage_subtabs');  }
		function hook_admin_2_homepage_subcontent(){  do_action('hook_admin_2_homepage_subcontent');  }	 

	// ADMIN 3
	function hook_admin_3_tabs($c){   return  apply_filters('hook_admin_3_tabs', $c);   }
  	function hook_admin_3_content(){  do_action('hook_admin_3_content');  } 
	function hook_email_list(){  do_action('hook_email_list');  } 
	function hook_email_list_filter($c){   return  apply_filters('hook_email_list_filter', $c);   }
		
	// ADMIN 4	
	function hook_admin_4_tabs($c){   return  apply_filters('hook_admin_4_tabs', $c);   }
  	function hook_admin_4_content(){  do_action('hook_admin_4_content');  }		
		
	// ADMIN 5		 
	function hook_admin_5_tabs($c){   return  apply_filters('hook_admin_5_tabs', $c);   }
  	function hook_admin_5_content(){  do_action('hook_admin_5_content');  }
	
	function hook_admin_5_tab1_left(){  do_action('hook_admin_5_tab1_left');  }
	function hook_admin_5_tab1_right(){  do_action('hook_admin_5_tab1_right');  }
	
	function hook_admin_5_tab2_left(){  do_action('hook_admin_5_tab2_left');  }
	function hook_admin_5_tab2_right(){  do_action('hook_admin_5_tab2_right');  }	
	
	function hook_admin_5_tab3_left(){  do_action('hook_admin_5_tab3_left');  }
	function hook_admin_5_tab3_right(){  do_action('hook_admin_5_tab3_right');  }
		
		function hook_admin_5_packages_edit(){  do_action('hook_admin_5_packages_edit');  }
		function hook_admin_5_customfields_edit(){  do_action('hook_admin_5_customfields_edit');  } 
	
	// ADMIN 6
	function hook_admin_6_tabs($c){   return  apply_filters('hook_admin_6_tabs', $c);   }
  	function hook_admin_6_content(){  do_action('hook_admin_6_content');  } 
	
	// ADMIN 7
	function hook_admin_7_tabs($c){   return  apply_filters('hook_admin_7_tabs', $c);   }
  	function hook_admin_7_content(){  do_action('hook_admin_7_content');  } 
	function hook_advertising_list_filter($c){   return  apply_filters('hook_advertising_list_filter', $c);   }

	// ADMIN 8
	function hook_admin_8_tabs($c){   return  apply_filters('hook_admin_8_tabs', $c);   }
  	function hook_admin_8_content(){  do_action('hook_admin_8_content');  } 
	function hook_styles_list_filter($c){   return  apply_filters('hook_styles_list_filter', $c);   }
	function hook_styles_code_filter($c){   return  apply_filters('hook_styles_code_filter', $c);   }
	
	// ADMIN 9
	function hook_admin_9_tabs($c){   return  apply_filters('hook_admin_9_tabs', $c);   }
  	function hook_admin_9_content(){  do_action('hook_admin_9_content');  } 

	// ADMIN 10
	function hook_admin_13_tabs($c){   return  apply_filters('hook_admin_13_tabs', $c);   }
  	function hook_admin_13_content(){  do_action('hook_admin_13_content');  } 


	// ADMIN 0
	function hook_admin_16_tabs($c){   return  apply_filters('hook_admin_16_tabs', $c);   }
  	function hook_admin_16_content(){  do_action('hook_admin_16_content');  } 

	
	// MISC
	function hook_price($c){ return  apply_filters('hook_price', $c);  }
	function hook_price_filter($c){ return  apply_filters('hook_price_filter', $c);  }
	function hook_price_currencycode($c){ return  apply_filters('hook_price_currencycode', $c);  }
		
	function hook_shortcode_toolbox_item($c){ return  apply_filters('hook_shortcode_toolbox_item', $c);  }
	function hook_shortcode_timeleft_ended($c){ return  apply_filters('hook_shortcode_timeleft_ended', $c);  }	
		
	function hook_date($c){ return  apply_filters('hook_date', $c);  }
	function hook_admin_videotutorials(){  do_action('hook_admin_videotutorials');  } 
	function hook_payment_package_price($c){ return  apply_filters('hook_payment_package_price', $c);  }
	function hook_language_array($c){ return  apply_filters('hook_language_array', $c);  }
	function hook_css_featured($c){ return  apply_filters('hook_css_featured', $c);  }
	function hook_outbound_link($c){ return  apply_filters('hook_outbound_link', $c);  }
	function hook_new_install(){ do_action('hook_childtheme_activation'); }
 	function hook_custom_queries($c){ return  apply_filters('hook_custom_queries', $c);  }
	
	function hook_wlt_core_search(){ do_action('hook_wlt_core_search'); }	
	
	function hook_shortcode_image_output($c){ return  apply_filters('hook_shortcode_image_output', $c);  }
	function hook_core_fields_switch($c){ return  apply_filters('hook_core_fields_switch', $c);  }
	
	function hook_userphoto_after(){ do_action('hook_userphoto_after'); }
	
 	
	// EDIT LISTING
	function hook_edit_fields_metabox(){  do_action('hook_edit_fields_metabox');  } 
 		
	// CART EXTRAS
	function hook_tag_addbig($c){ return  apply_filters('hook_tag_addbig', $c);  } 
	function hook_admin_cartfields(){  do_action('hook_admin_cartfields');  }	
	function hook_order_status($c){ return  apply_filters('hook_order_status', $c);  }
	function hook_admin_shipping_tablist(){  do_action('hook_admin_shipping_tablist');  } 
	function hook_admin_shipping_tabcontent(){  do_action('hook_admin_shipping_tabcontent');  }	
	function hook_admin_tax_tablist(){  do_action('hook_admin_tax_tablist');  }
	function hook_admin_tax_tabcontent(){  do_action('hook_admin_tax_tabcontent');  }	
	function hook_shop_breadcrumbs($c){ return  apply_filters('hook_shop_breadcrumbs', $c);  }
	
	// EXPIRY FUNCTIONS
	function hook_expiry_listing(){  do_action('hook_expiry_listing');  }
		function hook_expiry_listing_action($c){ return  apply_filters('hook_expiry_listing_action', $c);  }
	function hook_expiry_membership(){  do_action('hook_expiry_membership');  }	 
	
	// ADMIN EDITING LISTING HOOKS
	function hook_fieldlist_0($c){ return  apply_filters('hook_fieldlist_0', $c);  } // basic info
	function hook_fieldlist_1($c){ return  apply_filters('hook_fieldlist_1', $c);  } // expiry
	function hook_fieldlist_2($c){ return  apply_filters('hook_fieldlist_2', $c);  } // features

?>
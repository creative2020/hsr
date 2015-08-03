<?php
/*
* @@ White-label Themes
* @ Developed By Mark Fail
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*
*/

if(!defined('WLT_CART')){
define('WLT_ENABLE_MOBILEWEB', true);
}
/*
*
=============================================================================
   LOAD IN FRAMEWORK
============================================================================*/ 
$GLOBALS['wlt_start_time'] = microtime(true);
require_once TEMPLATEPATH ."/framework/class/class_widgets.php";
require_once TEMPLATEPATH ."/framework/class/class_core.php";
require_once TEMPLATEPATH ."/framework/class/class_layout.php";
require_once TEMPLATEPATH ."/framework/class/class_hooks_filters.php";
require_once TEMPLATEPATH ."/framework/class/class_shortcodes.php";
require_once TEMPLATEPATH ."/framework/class/class_objects.php";
require_once TEMPLATEPATH ."/framework/class/class_design.php";
require_once TEMPLATEPATH ."/framework/class/class_ajax.php";
 
$CORE		= new white_label_themes;  
$SHORTCODES	= new core_shortcodes;  
$OBJECTS	= new core_objects;
$LAYOUT		= new core_layout;


/*=============================================================================
   LOAD IN ADMIN FRAMEWORK
============================================================================*/

if(is_admin()){
	require_once (TEMPLATEPATH ."/framework/class/class_admin.php");
	$CORE_ADMIN	 			= new wlt_admin;
	$WLT_ADMIN 				= $CORE_ADMIN;
}else{
	add_action('init', array( $CORE, 'INIT') );
}
/*
*
*
*
*
*
*
*
*/ 
	// CHECK FOR EMPTY CART
	if(isset($_GET['emptycart']) && !headers_sent() ){ 
	session_start(); 
	session_destroy();  
	// DELETE STORED SESSION COOKIE
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}
	
	}else{ if(!isset($_SESSION) && !headers_sent()){ session_start(); } }


if(defined('WLT_MICROJOB')){
	// LOAD IN DEFAULTS
	if(file_exists(TEMPLATEPATH .'/framework/class/defaults_microjobs.php')){
	require_once TEMPLATEPATH .'/framework/class/defaults_microjobs.php';
	$CORE_MICROJOB	= new core_microjobs;
	}
}
if(defined('WLT_CART')){
	// LOAD IN CART DEFAULTS
	if(file_exists(TEMPLATEPATH .'/framework/class/defaults_cart.php')){
	require_once TEMPLATEPATH .'/framework/class/defaults_cart.php';
	$CORE_CART	= new shopping_cart;
	}
}
if(defined('WLT_COUPON')){
	// LOAD IN COUPON DEFAULTS
	if(file_exists(TEMPLATEPATH .'/framework/class/defaults_coupon.php')){
	require_once TEMPLATEPATH .'/framework/class/defaults_coupon.php';
	$CORE_COUPON	= new core_coupons;
	}
} //end if
if(defined('WLT_IDEAS')){	
	// LOAD IN COUPON DEFAULTS
	if(file_exists(TEMPLATEPATH .'/framework/class/defaults_ideas.php')){
	require_once TEMPLATEPATH .'/framework/class/defaults_ideas.php';
	$CORE_IDEAS	= new core_ideas;
	}
} //end if
if(defined('WLT_AUCTION')){		
	// LOAD IN COUPON DEFAULTS
	if(file_exists(TEMPLATEPATH .'/framework/class/defaults_auction.php')){
	require_once TEMPLATEPATH .'/framework/class/defaults_auction.php';
	$CORE_AUCTION	= new core_auctions;
	}
} //end if
if(defined('WLT_COMPARISON')){		
	// LOAD IN COUPON DEFAULTS
	if(file_exists(TEMPLATEPATH .'/framework/class/defaults_comparison.php')){
	require_once TEMPLATEPATH .'/framework/class/defaults_comparison.php';
	$CORE_COMPARISON	= new core_comparison;
	}
} //end if
if(defined('WLT_JOBS')){		
	// LOAD IN COUPON DEFAULTS
	if(file_exists(TEMPLATEPATH .'/framework/class/defaults_jobs.php')){
	require_once TEMPLATEPATH .'/framework/class/defaults_jobs.php';
	$CORE_JOBS	= new core_jobs;
	}
} //end if
if(defined('WLT_DOCS')){		
	// LOAD IN COUPON DEFAULTS
	if(file_exists(TEMPLATEPATH .'/framework/class/defaults_docs.php')){
	require_once TEMPLATEPATH .'/framework/class/defaults_docs.php';
	$CORE_DOCS	= new core_docs;
	}
} //end if
if(defined('WLT_DEALER')){		
	// LOAD IN COUPON DEFAULTS
	if(file_exists(TEMPLATEPATH .'/framework/class/defaults_dealer.php')){
	require_once TEMPLATEPATH .'/framework/class/defaults_dealer.php';
	$CORE_DEALER	= new core_dealer;
	}
} //end if
if(defined('WLT_DATING')){		
	// LOAD IN COUPON DEFAULTS
	if(file_exists(TEMPLATEPATH .'/framework/class/defaults_dating.php')){
	require_once TEMPLATEPATH .'/framework/class/defaults_dating.php';
	$CORE_DATING	= new core_dating;
	}
} //end if
if(defined('WLT_DOWNLOADTHEME')){		
	// LOAD IN COUPON DEFAULTS
	if(file_exists(TEMPLATEPATH .'/framework/class/defaults_download.php')){
	require_once TEMPLATEPATH .'/framework/class/defaults_download.php';
	$CORE_DOWNLOAD	= new core_download;
	}
} //end if
if(defined('WLT_DIRECTORY')){		
	// LOAD IN COUPON DEFAULTS
	if(file_exists(TEMPLATEPATH .'/framework/class/defaults_directory.php')){
	require_once TEMPLATEPATH .'/framework/class/defaults_directory.php';
	$CORE_DIRECTORY	= new core_directory;
	}
} //end if
if(defined('WLT_BUSINESS')){		
	// LOAD IN COUPON DEFAULTS
	if(file_exists(TEMPLATEPATH .'/framework/class/defaults_business.php')){
	require_once TEMPLATEPATH .'/framework/class/defaults_business.php';
	$CORE_BUSINESS	= new core_business;
	}
} //end if
if(defined('WLT_CLASSIFIEDS')){		
	// LOAD IN COUPON DEFAULTS
	if(file_exists(TEMPLATEPATH .'/framework/class/defaults_classifieds.php')){
	require_once TEMPLATEPATH .'/framework/class/defaults_classifieds.php';
	$CORE_CLASSIFIEDS	= new core_classifieds;
	}
} //end if
if(defined('WLT_REALTOR')){		
	// LOAD IN COUPON DEFAULTS
	if(file_exists(TEMPLATEPATH .'/framework/class/defaults_realtor.php')){
	require_once TEMPLATEPATH .'/framework/class/defaults_realtor.php';
	$CORE_REALTOR	= new core_realtor;
	}
} //end if
if(defined('WLT_BOOKING')){		
	// LOAD IN COUPON DEFAULTS
	if(file_exists(TEMPLATEPATH .'/framework/class/defaults_booking.php')){
	require_once TEMPLATEPATH .'/framework/class/defaults_booking.php';
	$CORE_BOOKING	= new core_booking;
	}
} //end if
if(defined('WLT_REVIEW')){		
	// LOAD IN COUPON DEFAULTS
	if(file_exists(TEMPLATEPATH .'/framework/class/defaults_review.php')){
	require_once TEMPLATEPATH .'/framework/class/defaults_review.php';
	$CORE_REVIEW	= new core_review;
	}
} //end if
?>
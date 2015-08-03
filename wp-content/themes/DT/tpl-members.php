<?php
/*
Template Name: [Members]
*/
/* =============================================================================
   [PREMIUMPRESS FRAMEWORK] THIS FILE SHOULD NOT BE EDITED
   ========================================================================== */
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
/* ========================================================================== */
global  $userdata, $CORE; get_currentuserinfo();  $GLOBALS['flag-members'] = 1; 
/* =============================================================================
   LOAD PAGE TEMPLATE
   ========================================================================== */
get_header($CORE->pageswitch()); ?>

<div class="panel panel-default">

<div class="panel-body">
  
<form id="member-search" action="" method="get" class="well">
            
            <div class="col-md-5">
            <input type="text" name="uk" class="form-control" value="<?php if(isset($_GET['uk'])){ echo strip_tags($_GET['uk']); } ?>" >
            </div>
            
            <div class="col-md-5">
            <select name="uv" class="form-control">
            <option value="user_login,user_email">--- search all --</option>
			<option value="user_login">Username</option>
            <option value="user_email">Email</option>
			</select>
            </div> 
            
            <div class="col-md-2">
            	<input type="submit" value="<?php echo $CORE->_e(array('button','11','flag_noedit')); ?>" class="btn btn-primary">
            </div> 
			
			<div class="clearfix"></div>

</form>
<hr />

<?php

// sEARCH dEFAULTS
if(!isset($_GET['uk'])){ $_GET['uk'] = ""; }
if(!isset($_GET['uv'])){ $ff = explode(",","user_login,user_email"); }else{ $ff = explode(",", $_GET['uv']); }

// TOTAL COUNT QUERY
$count_args  = array(
    //'role'      => 'Subscriber',
	'search'         => $_GET['uk'],
    'fields'    => 'all_with_meta',
    'number'    => 999999      
);
$user_count_query = new WP_User_Query($count_args);
$user_count = $user_count_query->get_results();

// count the number of users found in the query
$total_users = $user_count ? count($user_count) : 1;

// grab the current page number and set to 1 if no page number is set
$page = isset($_GET['show']) ? $_GET['show'] : 1;

// how many users to show per page
$users_per_page = 10;

// calculate the total number of pages.
$total_pages = 1;
$offset = $users_per_page * ($page - 1);
$total_pages = ceil($total_users / $users_per_page);


// main user query
$args  = array(
	'search'         => $_GET['uk'],
    // search only for Authors role
    //'role'      => 'Subscriber',
    // order results by display_name
    'orderby'   => 'display_name',
    // return all fields
    'fields'    => 'all_with_meta',
    'number'    => $users_per_page,
    'offset'    => $offset // skip the number of users that we have per page  
);

// Create the WP_User_Query object
$wp_user_query = new WP_User_Query($args);

// Get the results
$authors = $wp_user_query->get_results();

// check to see if we have users
if (!empty($authors))
{
    echo ' <ul class="memberlist">'; 
    // loop trough each author
	$i=0;
    foreach ($authors as $author)    {
		
		
        $user = get_userdata($author->ID); 
		
		$listings = $CORE->count_user_posts_by_type( $user->ID, THEME_TAXONOMY."_type" );
	
	echo "<li>
		<div class='row'>
			<div class='col-md-3'><a href='".get_author_posts_url( $user->ID )."'>".str_replace("avatar ","avatar img-responsive ",get_avatar( $user->ID, 180 ))."</a> </div>
			<div class='col-md-9'>
			
			<span class='pull-right'><a href='".get_home_url()."/?s=&amp;uid=".$user->ID."'>".str_replace("%a", $listings, $CORE->_e(array('author','1')))."</a></span>
			
			<a href='".get_author_posts_url( $user->ID )."'><h2>" . $user->display_name . "</h2></a> 
			
			
			<div class='linkbar'>";
			
			
		// URL
		$data = get_user_meta( $user->ID, 'url', true);
		if(strlen($data) > 0){ 
        echo "<span><i class='fa fa-globe'></i> <a href='".$data."' rel='nofollow' target='_blank'>".$CORE->_e(array('button','12'))."</a></span> "; 
        }           
			
		// FACEBOOK
		$data = get_user_meta( $user->ID, 'facebook', true);
		if(strlen($data) > 0){ 
        echo "<span><i class='fa fa-facebook-square'></i> <a href='".$data."' rel='nofollow' target='_blank'>Facebook</a></span>"; 
        }  	
		
		// TWITTER
		$data = get_user_meta( $user->ID, 'twitter', true);
		if(strlen($data) > 0){ 
        echo "<span><i class='fa fa-twitter-square'></i> <a href='".$data."' rel='nofollow' target='_blank'>Twitter</a></span> "; 
        }  		
		
		// LINKEDIN
		$data = get_user_meta( $user->ID, 'linkedin', true);
		if(strlen($data) > 0){ 
        echo "<span><i class='fa fa-linkedin-square'></i> <a href='".$data."' rel='nofollow' target='_blank'>Linkedin</a></span>"; 
        } 	

		// SKYPE
		$data = get_user_meta( $user->ID, 'skype', true);
		if(strlen($data) > 0){ 
        echo "<span><i class='fa fa-skype'></i> <a href='skype:".$data."' rel='nofollow' target='_blank'>Skype</a> </span>"; 
        } 
					
		echo "</div>
			
		<div class='desc'>".get_the_author_meta( 'description', $user->ID)."</div>";			

			
		echo "<div class='linkbar bottom'>";
		
		// SHOW PHONE NUMBER
		$phone = get_user_meta( $user->ID, 'phone', true);
		if(strlen($phone) > 1){ 
        echo "<span><i class='fa fa-phone'></i> ".$phone."</span>"; 
        }
		
		
		// LAST LOGIN
		echo "<span><i class='fa fa-calendar-o'></i> Last Logged in ".hook_date(get_user_meta($user->ID, 'login_lastdate', true))."</span>";
		
		echo "</div>"; 
		
		
		echo "</div></div>	
		
		 </li>"; 
	
    }
    echo '</ul>';
} else {
    echo 'No authors found';
}

// grab the current query parameters
$query_string = $_SERVER['QUERY_STRING'];

$base = get_permalink( get_the_ID() ) . '?' . remove_query_arg('show', $query_string) . '%_%';
 
 
echo '<ul class="pagination">'.str_replace("<span","<li><span",str_replace("span/>","span/></li>",str_replace("a/>","a/></li>",str_replace("<a","<li><a rel='nofollow'",paginate_links( array(
    'base' => $base, // the base URL, including query arg
    'format' => 'show=%#%', // this defines the query parameter that will be used, in this case "p"
    'prev_text' => __('&laquo; Previous'), // text for previous page
    'next_text' => __('Next &raquo;'), // text for next page
    'total' => $total_pages, // the total number of pages we have
    'current' => $page, // the current page
    'end_size' => 1,
    'mid_size' => 5,
	
)).'</ul>'))));



?>
<style>
.pagination .current { background:#ddd; }
</style> 
</div></div>
<?php

get_footer($CORE->pageswitch());
	
// THAT'S ALL FOLKS! 
 
/* =============================================================================
   -- END FILE
   ========================================================================== */
?>
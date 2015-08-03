<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;
// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  
// REMOVE REGISTRATION FIELD
if(!defined('WLT_DEMOMODE')){

if(isset($_GET['delm']) && is_numeric($_GET['delm']) ){
mysql_query("DELETE FROM ".$wpdb->prefix."core_mailinglist WHERE autoid = ('".$_GET['delm']."') LIMIT 1");
$GLOBALS['error_message'] = "Mailing List Updated";

}elseif(isset($_GET['delall']) && is_numeric($_GET['delall']) ){
mysql_query("DELETE FROM ".$wpdb->prefix."core_mailinglist");
$GLOBALS['error_message'] = "Mailing List Updated";
}


// DEFAULT CORE EMAILS
$default_email_array = array(

"welcome" => array('name' => 'Welcome Email',  'shortcodes' => array( 'email' => 'user_email', 'password' => 'password') , 'label'=>'label-success', 'desc' => 'This email is sent to the user when they register on your website.'),
"newlisting" => array('name' => 'New Listing',  'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date'), 'label'=>'label-success', 'desc' => 'This email is sent to the user after they create a new listing.'),
"contact" => array('name' => 'Listing Contact Form',   'shortcodes' => array('name' => 'name', 'email' => 'email', 'phone' => 'phone', 'link' => 'link', 'message' => 'message'), 'label'=>'label-success', 'desc' => 'This email is sent to the listing author when someone uses the listing page contact form.'),
"subscription_email" => array('name' => 'Email Subscription', 'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date'), 'label'=>'label-success', 'desc' => 'This email is sent to members who have subscribed to a category and a new listing has just been created within that category.'),

"newfeedback" => array('name' => 'New Feedback', 'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date'), 'label'=>'label-success', 'desc' => 'This email is sent to members who recieve new feedback.'),



"n1" => array('break' => 'Listing Expiry Emails'),
	"reminder_30" => array('name' => '30 day renewal reminder',   'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date','expired' => 'expired'), 'label'=>'label-info'),
	"reminder_15" => array('name' => '15 day renewal reminder',   'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date','expired' => 'expired'), 'label'=>'label-info'),
	"reminder_1" => array('name' => '1 day renewal reminder',   'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date','expired' => 'expired'), 'label'=>'label-info'),
	"expired" => array('name' => 'Listing Expired',   'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date','expired' => 'expired'), 'label'=>'label-info'),


"n2" => array('break' => 'Membership Expiry Emails'),
	"mem_reminder_30" => array('name' => '30 day renewal reminder',   'shortcodes' => array('expired' => 'expired'), 'label'=>'label-important'),
	"mem_reminder_15" => array('name' => '15 day renewal reminder',   'shortcodes' => array('expired' => 'expired'), 'label'=>'label-important'),
	"mem_reminder_1" => array('name' => '1 day renewal reminder',   'shortcodes' => array('expired' => 'expired'), 'label'=>'label-important'),
	"mem_expired" => array('name' => 'Listing Expired',  'shortcodes' => array('expired' => 'expired'), 'label' =>'label-important'),

"n3" => array('break' => 'Admin Emails'),
	"admin_welcome" => array('name' => 'User Registration',  'shortcodes' => array('username' => 'user_login','email' => 'user_email','password' => 'password'), 'label'=>'label-warning'),
	"admin_newlisting" => array('name' => 'New Listing',  'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date'), 'label'=>'label-warning'),
	"admin_newclaim" => array('name' => 'New Listing Claim',  'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date'), 'label'=>'label-warning'),
	"admin_order_new" => array('name' => 'New Order',  'shortcodes' => array('order status' => 'payment_status','order ID' => 'orderid','order data' => 'order_data'), 'label'=>'label-warning'),
	 

"n4" => array('break' => 'Message System'),
	"msg_new" => array('name' => 'New Message',  'shortcodes' => array('to username' => 'username','from username' => 'from_username','subject' => 'subject','message' => 'message'), 'label'=>'label-inverse'),

"n5" => array('break' => 'New Order'),
 	"order_new_sccuess" => array('name' => 'New Successful Order',  'shortcodes' => array('username' => 'username'), 'label'=>'label-info'),
	"order_new_failed" => array('name' => 'New Failed Order',  'shortcodes' => array('username' => 'username'), 'label'=>'label-info'),


);


if(defined('WLT_CART')){

unset($default_email_array['newlisting']);
unset($default_email_array['subscription_email']);
unset($default_email_array['n1']);
unset($default_email_array['reminder_30']);
unset($default_email_array['reminder_15']);
unset($default_email_array['reminder_1']);
unset($default_email_array['expired']);
unset($default_email_array['n2']);
unset($default_email_array['mem_reminder_30']);
unset($default_email_array['mem_reminder_15']);
unset($default_email_array['mem_reminder_1']);
unset($default_email_array['mem_expired']);
unset($default_email_array['n4']);
unset($default_email_array['msg_new']);
unset($default_email_array['admin_newclaim']);
unset($default_email_array['admin_newlisting']);
unset($default_email_array['contact']);
}

// TURN OFF EMAILS IF NOT USED
if($core_admin_values['show_account_subscriptions'] != '1'){ 
unset($default_email_array['subscription_email']);
}

$default_email_array = hook_email_list_filter($default_email_array);
 

if(isset($_POST['action'])){

	switch($_POST['action']){
	
	case "testemail": {
 
	$CORE->SENDEMAIL($_POST['toemail'],'custom', $_POST['subject'], $_POST['message']);
 	
	} break;
	
	case "sendemail": {
	if(strlen($_POST['subject']) > 2){
		$mailinglist = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."core_mailinglist WHERE email_confirmed=1"); 
		if ( $mailinglist ) {
			foreach ( $mailinglist as $maild ) {
				if(strlen($maild->email) > 1){
				$CORE->SENDEMAIL($maild->email,'custom',$_POST['subject'],$_POST['message']);
				}
			}
		}
		$GLOBALS['error_message'] = "Email sent.";
	}
	} break;
	
	case "importemails": {
 		 
		$emails = explode(PHP_EOL,$_POST['import_emails_data1']);
	  
		if(is_array($emails)){
			foreach($emails as $email){			 
			 $bits = explode("[",$email); 
			 $fname = ""; $lname = "";
			 if(strpos($bits[1], "]") !== false){
			 	$ib = explode(" ",$bits[1]);
				$fname = str_replace("]","",$ib[0]); 
				$lname = str_replace("]","",$ib[1]);
			 }			 
			// ADD DATABASE ENTRY
			if(strlen($bits[0]) > 2){
			$hash = md5($_GET['eid'].rand());
			$SQL = "INSERT INTO ".$wpdb->prefix."core_mailinglist (`email`, `email_hash`, `email_ip`, `email_date`, `email_firstname`, `email_lastname`, email_confirmed) 
			VALUES ('".strip_tags(trim($bits[0]))."', '".$hash."', '".$CORE->get_client_ip()."', now(), '".trim($fname)."', '".trim($lname)."','1');";			
			$wpdb->query($SQL);
			
			}
				
			} // end foreach
		}// end if
		
		$GLOBALS['error_message'] = "Mailing List Updated";
		
		} break;
	
	}
} 


if(isset($_POST['newemail'])){
			
	// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
	$wlt_emails = get_option("wlt_emails");
	if(!is_array($wlt_emails)){ $wlt_emails = array(); }
	// ADD ONE NEW FIELD 
	if(!isset($_POST['eid'])){
		array_push($wlt_emails, $_POST['wlt_email']);		
		$GLOBALS['error_message'] = "Email Created Successfully";
	}else{
		$wlt_emails[$_POST['eid']] = $_POST['wlt_email'];		
		$GLOBALS['error_message'] = "Email Updated Successfully";
	}
	// SAVE ARRAY DATA		 
	update_option( "wlt_emails", $wlt_emails);
				
}elseif(isset($_GET['delete_email']) && is_numeric($_GET['delete_email'] )){

	// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
	$wlt_emails = get_option("wlt_emails");
	if(!is_array($wlt_emails)){ $wlt_emails = array(); }
	
	// LOOK AND SEARCH FOR DELETION
	foreach($wlt_emails as $key=>$pak){
		if($key == $_GET['delete_email']){
			unset($wlt_emails[$key]);	 
		}
	}
	
	// SAVE ARRAY DATA
	update_option( "wlt_emails", $wlt_emails);
	
	$_POST['tab'] = "email";
	$GLOBALS['error_message'] = "Email Deleted Successfully";

}
}


// LOAD IN HEADER
echo $CORE_ADMIN->HEAD(); ?>

 <a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('_Ntvv6weim4','videoboxplayer','479','350');" style="float:right;margin-top:5px;margin-right:5px;">Watch Video</a>
<ul id="tabExample1" class="nav nav-tabs">

<?php
// HOOK INTO THE ADMIN TABS
function _3_tabs(){ $STRING = ""; global $wpdb; $core_admin_values = get_option("core_admin_values");

	if(isset($_GET['tab'])){ $_POST['tab'] = $_GET['tab']; }
	
	$pages_array = array( 
	"1" => array("t" => "Setup", 		"k"=>"email"),
	"2" => array("t" => "Mailing List", "k"=>"mailinglist"),
 	);
	foreach($pages_array as $page){
	
	if( ( isset($_POST['tab']) && $_POST['tab'] == $page['k'] ) || ( !isset($_POST['tab']) && $page['k'] == "email" ) ){ $class = "active"; }else{ $class = ""; }
	
		$STRING .= '<li class="'.$class.'"><a href="#'.$page['k'].'" onclick="document.getElementById(\'ShowTab\').value=\''.$page['k'].'\'" data-toggle="tab">'.$page['t'].'</a></li>';		
	}
 
	return $STRING;

}
echo hook_admin_3_tabs(_3_tabs());
// END HOOK
?>  
                     
</ul>

<div class="tab-content">







<?php if(isset($_GET['edit_email']) && is_numeric($_GET['edit_email']) ){ 
$wlt_emails = get_option("wlt_emails");

?>
 
</form>


<form method="post" name="admin_email" id="admin_email" action="admin.php?page=3" class="well">
<input type="hidden" name="newemail" value="yes" />
<input type="hidden" name="tab" value="email" />
<?php if(isset($_GET['edit_email']) && $_GET['edit_email'] != -1){ ?>
<input type="hidden" name="eid" value="<?php echo $_GET['edit_email']; ?>" />
<input type="hidden" name="wlt_email[ID]" value="<?php echo $_GET['edit_email']; ?>" />
<?php } ?>

               
          	 <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field"><b>Subject</b></label>
                <div class="controls span9">
                  <input type="text"  name="wlt_email[subject]" class="row-fluid" value="<?php if(isset($_GET['edit_email'])){ echo stripslashes($wlt_emails[$_GET['edit_email']]['subject']); }?>">
                   
                </div>
              </div> 
              
              
              <div class="form-row control-group row-fluid">
                <style>
				.wp-switch-editor, .tmce-active .switch-tmce, .html-active .switch-html { height:27px !important; }
				</style>
                 
                 
                 <?php
				 
				 // LOAD UP EDITOR
	if(isset($_GET['edit_email']) && $_GET['edit_email'] != -1 ){ $content = stripslashes($wlt_emails[$_GET['edit_email']]['message']); }else{ $content = ""; }
	echo wp_editor( $content, 'wlt_email', array( 'textarea_name' => 'wlt_email[message]') ); 
				 
				 ?>
                             
                
              </div> 
              
<hr />
              
<div id="wlt_email_extras">
 
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#wlt_email_extras" href="#col1"> 
      <img src="<?php echo get_template_directory_uri(); ?>/framework/img/a3.png">
      Global Email Shortcodes    </a>
    </div>
    <div id="col1" class="accordion-body collapse" style="height: 0px;">
      <div class="accordion-inner">
    
      <p>These are email shortcodes that are available for all emails.</p>
              
              <div class="well" style="background: #fff;">
              <?php
			  
			  $btnArray = array(
			  
			  "link" 		=> "Website Link",
			  "blog_name" 	=> "Blog Name",
			  "date" 		=> "Date & Time",
			  "time" 		=> "Time",
			  "username" 	=> "Username",
			  "user_email" 	=> "User Email",
			  "user_registered" => "User Registered Date"
			  
			  );
			  foreach( $btnArray as $k => $b){
			   echo "<a href='javascript:void(0);' onclick=\"AddthisShortC('".$k."','wlt_email');\" class='btn' style='margin-right:10px; margin-bottom:5px;'>(".$k.")</a>";
			   }
			  
			  ?>
              </div>
              
        
    
     </div>
    </div>
  </div>
  
  
   <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#wlt_email_extras" href="#col3"> 
      <img src="<?php echo get_template_directory_uri(); ?>/framework/img/a3.png">
      Special Email Shortcodes  </a>
    </div>
    <div id="col3" class="accordion-body collapse" style="height: 0px;">
      <div class="accordion-inner">
    
      <p>These shortcodes are only available when a set email is sent such as the welcome email or the renewal email.</p>
      
      
<?php foreach($default_email_array as $key1=>$val1){ 


if(isset($val1["break"])){ }else{ 
	echo '<div class="well" style="background: #fff;"><span class="label '.$val1['label'].'">'.$val1['name']."</span> - ";
		if(is_array($val1['shortcodes'])){
			foreach( $val1['shortcodes'] as $k => $b){
			echo "<a href='javascript:void(0);' onclick=\"AddthisShortC('".$b."','wlt_email');\" class='btn' style='margin-right:10px; margin-bottom:5px;'>(".$b.")</a>";
			}
		}
	echo "</div>";
}}
?>

 
    
     </div>
    </div>
  </div>
  
  
  
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#wlt_email_extras" href="#col2"> 
       <img src="<?php echo get_template_directory_uri(); ?>/framework/img/a3.png">
      Email Headers  </a>
    </div>
    <div id="col2" class="accordion-body collapse" style="height: 0px;">
      <div class="accordion-inner">
    
 <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field"><b>Email From</b></label>
                <div class="controls span9">
                <div class="row-fluid">
                    <div class="span5">
                    <input type="text"  name="wlt_email[from_name]" class="row-fluid" value="<?php if(isset($_GET['edit_email'])){ echo $wlt_emails[$_GET['edit_email']]['from_name']; }?>" placeholder="Name">
                    </div>                
                    <div class="span5">
                    <input type="text"  name="wlt_email[from_email]" class="row-fluid" value="<?php if(isset($_GET['edit_email'])){ echo $wlt_emails[$_GET['edit_email']]['from_email']; }?>" placeholder="Email">
                    </div>
                </div> 
                   
                </div>
              </div> 
            
              
              
              <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field"><b>BCC:</b></label>
                <div class="controls span9">
                <div class="row-fluid">
                    <div class="span5">
                    <input type="text"  name="wlt_email[bcc_name]" class="row-fluid" value="<?php if(isset($_GET['edit_email'])){ echo $wlt_emails[$_GET['edit_email']]['bcc_name']; }?>" placeholder="Your Name">
                    </div>                
                    <div class="span5">
                    <input type="text"  name="wlt_email[bcc_email]" class="row-fluid" value="<?php if(isset($_GET['edit_email'])){ echo $wlt_emails[$_GET['edit_email']]['bcc_email']; }?>" placeholder="Your Email">
                    </div>
                </div> 
                   
                </div>
              </div> 
    
     </div>
    </div>
  </div>     

<div class="clearfix"></div>
</div>
              
           <script>
function AddthisShortC(code, box){		   
	jQuery('#'+box).val(jQuery('#'+box).val()+'('+ code +')'); 
}
</script>          
        
              
              
           
           
              <hr />
              <button class="btn btn-primary" type="submit">Save Email</button>
</form>
<?php } ?>


















<?php do_action('hook_admin_3_content'); ?> 

<div class="tab-pane fade <?php if( ( isset($_POST['tab']) &&  $_POST['tab'] =="mailinglist"   )){ echo "active in"; } ?>" id="mailinglist">

<div class="tabbable tabs-left" >
<ul id="tabExample4" class="nav nav-tabs" style="height:680px">
<li class="active"><a href="#shiptab1" data-toggle="tab">Confirmed Users</a></li>
<li><a href="#shiptab2" data-toggle="tab">Email Settings</a></li>
<li><a href="#shiptab3" data-toggle="tab">Import Subscribers</a></li>
<li><a href="#shiptab4" data-toggle="tab">Send Email</a></li> 
</ul>
<div class="tab-content"  style="background:#fff;height:680px">
    <div class="tab-pane fade in active" id="shiptab1">
    
    <div class="well">
        
        <a href="javascript:void(0);" onclick="jQuery('table .unconfirmed').hide();" style="text-decoration:underline;">Hide</a> / <a href="javascript:void(0);" onclick="jQuery('table .unconfirmed').show();" style="text-decoration:underline;">Show</a> Un-confirmed Emails (<span class="label label-warning"><i class="icon-remove"></i></span>) |  
        
        
      <a href="javascript:void(0);" onclick="jQuery('table .confirmed').hide();" style="text-decoration:underline;">Hide</a> / <a href="javascript:void(0);" onclick="jQuery('table .confirmed').show();" style="text-decoration:underline;">Show</a> Confirmed Emails <span class="label label-success"><i class="icon-ok"></i></span>
        
    </div>
    
    <?php 
	
	$mailinglist = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."core_mailinglist" );  // WHERE email_confirmed=1
	 
	
	if ( $mailinglist ) { ?>
     <table class="table table-hover">
                  <thead>
                    <tr>
                      <th> </th>
                      <th>Email</th>
                      <th>Date</th>
                      <th>Name</th>
                    </tr>
                  </thead>
                  <tbody>              
    <?php  foreach ( $mailinglist as $maild ) {  ?>
                    <tr class="<?php if($maild->email_confirmed == 1){ echo "confirmed"; }else{ echo "unconfirmed"; } ?>">
                      <td><a href="admin.php?page=3&delm=<?php echo $maild->autoid;?>" class="label label-important" style="color:#fff;">Delete</a></td>
                      <td><?php echo $maild->email." "; if($maild->email_confirmed == 1){ echo '<span class="label label-success"><i class="icon-ok"></i></span>'; }else{ echo '<span class="label label-warning"><i class="icon-remove"></i></span>'; } ?></td>
                      <td><?php echo $CORE->format_date($maild->email_date);?></td>
                      <td><?php echo $maild->email_firstname." ".$maild->email_lastname;?></td>
                    </tr>
    <?php }   ?>
                  </tbody>
                </table>   
                
              <hr />
              
             <a href="admin.php?page=3&delall=1" class="btn btn-info confirm" style="float:right;">Delete All Emails</a>
              <a href="admin.php?page=3&exportall=1" class="btn btn-success">Export All Emails</a>
             
            
              
    <?php }else{ ?>
    <div class="alert">You have no confirmed users in your mailing list. Try using the mailing list widget to generate new subscribers.</div>
    <?php } ?>
    
    </div>
    
    <div class="tab-pane fade in" id="shiptab2">
    
    	<div class="box gradient">
        <div class="title"><h4><i class="icon-email"></i><span>Confirmation  Email</span></h4></div>
            <div class="content top">
            <p>This email is sent to the user once they subscribe to your mailing list and requires them to confirm their email address.</p>
            <hr />
             <input type="text" class="span7"  name="admin_values[mailinglist][confirmation_title]" value="<?php echo stripslashes($core_admin_values['mailinglist']['confirmation_title']); ?>">  
            <textarea class="row-fluid" style="height:200px; font-size:12px;" name="admin_values[mailinglist][confirmation_message]"><?php echo stripslashes($core_admin_values['mailinglist']['confirmation_message']); ?></textarea>   	 
    <p><span class="label">Remember</span> use (link) for the confirmation link in your email.</p>
    
     <hr />
            <label>&nbsp;&nbsp; Thank You Page Link (user is sent to after they confirm email)</label>
              <input type="text"  class="span8" name="adminArray[mailinglist_confirmation_thankyou]" placeholder="http://mywebiste.com/thankyou" value="<?php echo get_option('mailinglist_confirmation_thankyou'); ?>">
            <hr />
            <label>&nbsp;&nbsp; Unsubscribe Page Link (user is sent to after they unsubscribe from your mailing list)</label>
              <input type="text"  class="span8" name="adminArray[mailinglist_unsubscribe_thankyou]" placeholder="http://mywebiste.com/thankyou" value="<?php echo get_option('mailinglist_unsubscribe_thankyou'); ?>">
             
            </div>             
            
               
            
            
            <div class="form-actions row-fluid"><div class="span7 offset4"><button type="submit" class="btn btn-primary">Save Email</button></div></div>     
        </div>  
    
    </div>
    
    <div class="tab-pane fade in" id="shiptab3">
    <div class="row-fluid">    
        <div class="span12">    
          
        <div class="box gradient">
        <div class="title"><h4><i class="icon-user"></i><span>Bulk Import Subscribers</span></h4></div>
            <div class="content top">
            <p>Enter email addresses below, each on a new line with optional name values. <br /> Import format is: <b> example@hotmail.com [John Doe]</b></p>
            <textarea class="row-fluid" id="import_emails_data" style="height:400px;" name="import_emails"></textarea>        
            </div>             
            <div class="form-actions row-fluid"><div class="span7 offset4"><button type="button" class="btn btn-success" onclick="jQuery('#import_emails_data1').val(jQuery('#import_emails_data').val());document.importemails_email.submit();">Start Import</button></div></div>     
        </div>          
        </div>        
    </div>
    </div>
    
    <div class="tab-pane fade in" id="shiptab4">
    <div class="row-fluid">    
        <div class="span12">    
        <input type="hidden" name="action" value="sendemail" />    
        <div class="box gradient">
        <div class="title"><h4><i class="icon-user"></i><span>Send Email</span></h4></div>
            <div class="content top">
            <p>The message you send below will be emailed to ALL of your active subscribers.</p>
            <input type="text" name="subject" class="span12" placeholder="Subject Here" />
            <textarea class="row-fluid span12" style="height:350px;" name="message" placeholder="Message Here"></textarea> 
            <p>Use (unsubscribe) to include an unsubscribe link in your email.</p>     
            </div>             
            <div class="form-actions row-fluid"><div class="span7 offset4"><button type="submit" class="btn btn-primary">Send Email</button></div></div>     
        </div>          
        </div>        
    </div>
	</div>
    
</div>
</div>
</div>

<div class="tab-pane fade <?php if(!isset($_POST['tab']) || ( isset($_POST['tab']) && ( $_POST['tab'] =="" || $_POST['tab'] =="email" ) )){ echo "active in"; } ?>" id="email">

 
<div class="row-fluid">
<div class="box gradient span6"> 
 
          <div class="title">
            <h3>
            <i class="icon-envelope"></i>
           <a href="admin.php?page=3&edit_email=-1" class="btn btn-success" style="float:right;margin-top:4px; margin-right:10px;">Create New Email</a>
            <span>System Emails</span>
            </h3>
          </div>
  		<div class="content">
        <div class="accordion" id="accordion5">
         
 <?php 
		
		$wlt_emails = get_option("wlt_emails");
		 
		 // update_option("wlt_emails","");
		if(is_array($wlt_emails) && count($wlt_emails) > 0 ){  ?>
        
        
            <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
            <thead>
            <tr>
              <th class="no_sort">Subject</th>
                            
              <th class="no_sort" style="width:110px;text-align:center;">Actions</th>
              
            </thead>
            <tbody>
            
        <?php
 	  
		foreach($wlt_emails as $key=>$field){ ?>
		<tr>
         <td><?php echo stripslashes($field['subject']); ?></td>         
        
         <td class="ms">
         <center>
                <div class="btn-group1">
                  <a class="btn btn-small" rel="tooltip" 
                  href="admin.php?page=3&edit_email=<?php echo $key; ?>"
                  data-placement="left" data-original-title=" edit "><i class="gicon-edit"></i></a>                   
                  <a class="btn btn-inverse btn-small confirm" rel="tooltip" data-placement="bottom" 
                  data-original-title="Remove"
                  href="admin.php?page=3&delete_email=<?php echo $key; ?>"
                  ><i class="gicon-remove icon-white"></i></a> 
                </div>
            </center>
            </td>
            </tr>
            <?php  }   ?> 
 
            </tbody>
            </table>
            
         <?php } ?>        
         
 <?php do_action('hook_admin_1_tab5_left'); ?>  
 
 
 </div>
 <hr /> 



 
  <b style="font-size:18px;">Default Email Settings</b>
  <hr />
        <div class="form-row control-group row-fluid">
        <label class="control-label span5">From Email</label>
        <div class="controls span6">
        <input type="text"  name="adminArray[admin_email]" class="row-fluid"  value="<?php echo get_option('admin_email'); ?>">            
        </div>
        </div>
    
        <div class="form-row control-group row-fluid">
        <label class="control-label span5" rel="tooltip" data-original-title="This will display as the sender on all emails sent from your website." data-placement="top">From Name</label>
        <div class="controls span6">
        <input type="text"  name="adminArray[emailfrom]" class="row-fluid"  value="<?php echo get_option('emailfrom'); ?>">            
        </div>
        </div> 
        
           
<hr />

<div class="form-row control-group row-fluid ">
<label class="control-label span9" rel="tooltip" data-original-title="Turn off if you dont want WordPress to send new users a welcome email." data-placement="top">Send WordPress Registration Email</label>
<div class="controls span2">
 <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('wordpress_welcomeemail').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('wordpress_welcomeemail').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['wordpress_welcomeemail'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="wordpress_welcomeemail" name="admin_values[wordpress_welcomeemail]" 
                             value="<?php echo $core_admin_values['wordpress_welcomeemail']; ?>">
            </div>
    
          
  </div>
          
 
<div class="clearfix"></div>

    </div><!-- End .box -->
    
    

    <div class="box gradient span6">

      <div class="title">
            <div class="row-fluid">
                <h3><i class="icon-ok"></i>Email Assignment</h3>
            </div>
        </div><!-- End .title -->
        <div class="content">
        
        <p>Select an email to be used for each of the actions below.</p>
     
        <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th >Action</th>
                <th>Assigned Email</th>
              </tr>
            </thead>
            <tbody>
            
        
<!------------ FIELD -------------->      
<?php if(is_array($default_email_array)){ foreach($default_email_array as $key1=>$val1){ 


if(isset($val1["break"])){ ?>
</tr> </tbody> </table>
<hr />
<table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th><?php echo $val1["break"]; ?></th>
                <th>&nbsp;</th>
              </tr>
            </thead>
            <tbody
<?php }else{ ?>
<tr><td>
<span class="label <?php echo $val1['label']; ?>"><?php echo $val1['name']; ?></span>

<?php if(isset($val1['desc'])){ ?><a href="javascript:void(0);" rel="tooltip" data-original-title="<?php echo $val1['desc']; ?>" data-placement="top"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/0/7.png" align="absmiddle" style="float:right;padding-right:10px;"></a><?php }?>


<br />  
<?php if(isset($core_admin_values['emails'][$key1]) && is_numeric($core_admin_values['emails'][$key1])){ ?>
<a style="font-size:11px;" href="admin.php?page=3&test_email=<?php echo $key1; ?>&emailid=<?php echo $core_admin_values['emails'][$key1]; ?>"><i class="icon-plus-sign"></i> send test email</a>
<?php } ?>
</td>
<td>
<select data-placeholder="Choose a an email..." class="chzn-select" name="admin_values[emails][<?php echo $key1; ?>]">

	<?php 
	if(is_array($wlt_emails)){ 
		foreach($wlt_emails as $key=>$field){ 
			if(isset($core_admin_values['emails']) && $core_admin_values['emails'][$key1] == $key){	$sel = " selected=selected ";	}else{ $sel = ""; }
			echo "<option value='".$key."' ".$sel.">".stripslashes($field['subject'])."</option>"; 
		} 
	} 
	?> 
    
     <option value="" <?php if($core_admin_values['emails'][$key1] == ""){ echo " selected=selected "; } ?>>--- do not send --- </option>
</select>  
</td></tr>    
<?php } ?>
<?php } } ?>
</div>
<style>
.chzn-container { font-size:10px; width:180px !important; }
</style>
<!------------ END FIELD -------------->  
 </tr> </tbody> </table>       
        
 
       <?php do_action('hook_email_list');  ?>
       
        </div> <!-- End .content --> 
        
        
        
    </div><!-- End .box -->
 </div>
 
  

</div>


<!--------------------------- END ALL TABs ---------------------------->
</div><!-- end LANGUAGE tab 2 -->



<!-- start save button -->
<div class="form-actions row-fluid">
<div class="span7 offset5">
<button type="submit" class="btn btn-primary">Save Changes</button> 
</div>
</div> 
<!-- end save button -->


</div><!-- end tab -->



</form>





<form method="post" name="importemails_email" id="importemails_email" action="admin.php?page=3">
<input type="hidden" name="tab" value="mailinglist" />
<input type="hidden" name="import_emails_data1" id="import_emails_data1" />
<input type="hidden" name="action" value="importemails" />  
</form>





<?php if(isset($_GET['test_email']) && strlen($_GET['test_email']) > 3 ){ 
$wlt_emails = get_option("wlt_emails");

?>
<script type="text/javascript">
jQuery(document).ready(function () { jQuery('#TestEmailModal').modal('show'); })
</script>
<?php } ?>

<form method="post" name="admin_email" id="admin_email" action="admin.php?page=3" >
<input type="hidden" name="action" value="testemail" />
<input type="hidden" name="tab" value="email" />
<input type="hidden" name="emailid" value="<?php echo $_GET['emailid']; ?>" />
<input type="hidden" name="locationid" value="<?php echo $_GET['test_email']; ?>" />

<div id="TestEmailModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="TestEmailModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3 id="myModalLabel">Test Email</h3>
            </div>
            <div class="modal-body">
            
              
               <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field"><b>To</b></label>
                <div class="controls span9">
                  <input type="text"  name="toemail" class="row-fluid" value="<?php echo get_option('admin_email'); ?>">
                   
                </div>
              </div> 
               
          	 <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field"><b>Subject</b></label>
                <div class="controls span9">
                  <input type="text"  name="subject" class="row-fluid" value="<?php if(isset($_GET['emailid'])){ echo stripslashes($wlt_emails[$_GET['emailid']]['subject']); }?>">
                   
                </div>
              </div> 
              
              
              <div class="form-row control-group row-fluid">
                <style>
				.wp-switch-editor, .tmce-active .switch-tmce, .html-active .switch-html { height:27px !important; }
				 
				#TestEmailModal .wp-editor-area { height:250px; }
                </style>
                 
                 
                 <?php
				 
				 // LOAD UP EDITOR
	if(isset($_GET['emailid'])){ $content = stripslashes($wlt_emails[$_GET['emailid']]['message']); }else{ $content = ""; }
	echo wp_editor( $content, 'message' ); 
				 
				 ?>
                             
                
              </div> 
              

            </div>
            
            <div class="modal-footer">
              <a class="btn" href="admin.php?page=3">Close</a>
              <button class="btn btn-primary">Send Test</button>
            </div>
</div>
</form>


<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); ?>
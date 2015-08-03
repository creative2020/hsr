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
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; } ?>
<?php

// GET DATA
$wdata1 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."core_withdrawal WHERE autoid='".$_GET['wid']."' ORDER BY autoid DESC LIMIT 1", OBJECT);
$wdata = $wdata1[0];

?>


<div class="box gradient">

<div class="title">
<div class="row-fluid"><h3>

<div class="pull-right">IP: <?php echo $wdata->user_ip; ?> </div>

<i class=" icon-bar-chart"></i>Widthdrawal Information</h3></div>
</div> 

<div class="content">
   
	<input name="savewidthdrawal" type="hidden" value="yes">
	<input type="hidden" name="autoid" value="<?php echo $wdata->autoid; ?>">	 
	<input type="hidden" name="user_id" value="<?php echo $wdata->user_id; ?>">
        
        
<h3>User Comments / Payment Preferences</h3>

<textarea style="height:150px; width:100%" name="comments"><?php echo $wdata->withdrawal_comments; ?></textarea>

<h4>Amount Requested <div class="pull-right">(Total Account Amount <?php echo hook_price(get_user_meta($wdata->user_id,'wlt_usercredit',true)); ?>)</div> </h4>
<input type="text" name="amount" class="row-fluid" value="<?php echo $wdata->withdrawal_total; ?>">
 

<div class="well">

<div class="row-fluid">
	<div class="span4">
	<?php echo get_avatar($wdata->user_id); ?>
    <style>.span4 .avatar { min-width:200px; min-height:200px; border:1px solid #ddd; padding:2px; background:#fff; }</style>
    </div>
	<div class="span7">
    <?php $uf = get_userdata($wdata->user_id);  ?>
    <h3><?php echo $uf->user_login; ?></h3>
	<p>Name: <?php echo $uf->first_name." ".$uf->last_name; ?></p>
 	<p>Email: <?php echo $uf->user_email; ?></p>
    <p>Phone: <?php echo get_user_meta($wdata->user_id,'phone',true); ?></p>
    <p>Registered: <?php echo $uf->user_registered; ?></p>
    <p>Profile Link: <a href="<?php echo get_author_posts_url( $wdata->user_id ); ?>" target="_blank"><?php echo get_author_posts_url( $wdata->user_id ); ?></a> </p>
    
    </div>
</div>
</div>

<h4>Status</h4>

<p>Note changing this to paid will remove the requested ammount from this users account total.</p>

<input type="hidden" name="oldstatus" value="<?php echo $wdata->withdrawal_status; ?>" />
<select name="status" style="font-size:14px; width:100%;">
<option value="0" <?php if($wdata->withdrawal_status == 0){ echo "selected=selected"; } ?>>Pending</option>
<option value="1" <?php if($wdata->withdrawal_status == 1){ echo "selected=selected"; } ?>>Paid</option>            
</select>

<hr> 
               
<button class="btn btn-primary" type="submit">Update Order</button>



</div> <!-- End .content -->

</div>
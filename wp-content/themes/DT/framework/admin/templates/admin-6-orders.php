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
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
 

// GET ITESM PER PAGE
if(isset($_GET['ipp']) && is_numeric($_GET['ipp']) && $_GET['tab'] == "home"){
	$ITEMSPERPAGE = $_GET['ipp'];
}elseif(isset($_GET['ipp']) && $_GET['ipp'] == "All" && $_GET['tab'] == "home"){
	$ITEMSPERPAGE = 500;
}else{
	$ITEMSPERPAGE = 20;
}

// GET ROWS
if(isset($_GET['cpage']) && $_GET['cpage'] > 1 && $_GET['tab'] == "home"){
	$pstop = $ITEMSPERPAGE;
	$pint = $_GET['cpage']-1;
	$pstart = ($ITEMSPERPAGE*$pint);
}else{
	$pstop = $ITEMSPERPAGE;
	$pstart =0;
}

// GET SEARCH RESULTS AND FILTERS
$SQL_WHERE = "";
if(isset($_GET['s_k']) && strlen($_GET['s_k']) > 1 && $_GET['tab'] == "home" ){
	$SQL_WHERE .= " WHERE ( user_login_name LIKE ('%".$_GET['s_k']."%') OR order_email LIKE ('%".$_GET['s_k']."%') OR order_id LIKE ('%".$_GET['s_k']."%') )";
}

if(isset($_GET['s_d1']) && $_GET['s_d1'] > 1 && $_GET['tab'] == "home"){
	if($SQL_WHERE == ""){ $SQL_WHERE .= "WHERE "; }else{ $SQL_WHERE .= " AND "; }
	$SQL_WHERE .= "order_date >= '".$_GET['s_d1']."' AND order_date <= '".$_GET['s_d2']."' ";
}

// GET DATA
$sql = "SELECT * FROM ".$wpdb->prefix."core_orders ".$SQL_WHERE." ORDER BY autoid DESC LIMIT ".$pstart.",".$pstop."";
$ROWDATA = $wpdb->get_results($sql, OBJECT);

// GET TOTAL AMOUNT
$TOTALROWDATA = $wpdb->get_results("SELECT count(*) AS total, sum(order_total) AS order_total FROM ".$wpdb->prefix."core_orders ".$SQL_WHERE." ORDER BY autoid DESC", OBJECT);
$TOTALITEMS = $TOTALROWDATA[0]->total;
$TOTALORDERVALUE = $TOTALROWDATA[0]->order_total;
if(!is_numeric($TOTALORDERVALUE)){ $TOTALORDERVALUE = 0; }
// TOTAL PAGES
$TOTALPAGES = round($TOTALITEMS/$ITEMSPERPAGE);
 
?> 

<div class="box gradient ">

<div class="title"><h3><i class=" icon-bar-chart"></i><span> Orders Table</span></h3></div>

<div class="content top">

 
<form action="" method="get" style="margin-bottom:0px; margin-top:10px;">
<input type="hidden" name="submitted" value="no">
<input type="hidden" name="page" value="6">
<input type="hidden" name="tab" id="ShowTab" value="home">
 <script>jQuery(function(){ jQuery('#orders_date1').datetimepicker({pickTime: false}); jQuery('#orders_date2').datetimepicker({pickTime: false});}); </script>

   
<div class="row-fluid">
 
  <div class="span3">
  
	 <input placeholder="Keyword.." name="s_k" />
     
 </div>
 
 <div class="span3">
  
	 <div class="input-prepend date span6" id="orders_date1" data-date-format="yyyy-MM-dd">
                    <span class="add-on" style="height: 32px;"><i class="gicon-calendar"></i></span>
                    <input type="text" name="s_d1" value="<?php if(!isset($_GET['s_d1'])){ echo date('Y-m-d' , strtotime('-7 days')); }else{ echo $_GET['s_d1']; } ?>" id="date1"  data-format="yyyy-MM-dd" style="text-align:center;" />
     </div>  
 </div>
 <div class="span4">
  
 	<div class="input-prepend date span6" id="orders_date2" data-date-format="yyyy-MM-dd">
                    <span class="add-on" style="height: 32px;"><i class="gicon-calendar"></i></span>
                    <input type="text" name="s_d2" value="<?php if(!isset($_GET['s_d2'])){ echo date('Y-m-d' , strtotime('+1 days'));  }else{ echo $_GET['s_d2']; } ?>" id="date2"  data-format="yyyy-MM-dd" style="text-align:center;" />
                    </div> 
 
 </div>
 
  <div class="span2"><button class="btn btn-primary" type="submit">Filter Results</button></div> 
 
 </div>
 
 
 </form>

 
<p style="font-size:14px;">Sales Total:  <?php echo hook_price($TOTALORDERVALUE); ?></p>

<table  class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
            <thead>
            <tr>
              <th class="no_sort">               
              </th>
              <th class="no_sort">
                 
              </th>
              <th class="no_sort">
                Username
              </th>
              <th class="no_sort" style="text-align:center;">
                Amount
              </th>
              <th class="no_sort">
                Date
              </th>
 			 <th class="ms no_sort " style="text-align:center;">
                Status
              </th>
              <th class="ms no_sort" style="text-align:center;">
                Actions
              </th>
            </tr>
            </thead>
            <tbody>
            
<?php  
if ($ROWDATA): 
foreach ($ROWDATA as $wd): 

	$tt = "";
	if (strpos($wd->order_id, "SUB") !== false) {
		$tt = "<span class='label'> Subscription Payment </span><br />";
		
	}elseif (strpos($wd->order_id, "LST") !== false) {
		$tt = "<span class='label label-info'> New Listing </span><br />";
		
	}elseif (strpos($wd->order_id, "REW") !== false) {
		$tt = "<span class='label label-warning'> Renewal </span><br />";
	
	}elseif (strpos($wd->order_id, "MEM") !== false) {
		$tt = "<span class='label label-important'> Membership </span><br />";			
 	}


?>
<tr class="<?php if($wd->withdrawal_status == 1){ ?>completed<?php } ?>">
<td>
	#<?php echo $wd->autoid; ?>	 
</td>
<td>
	<a href="<?php echo home_url()."/wp-admin/"; ?>user-edit.php?user_id=<?php echo $wd->user_id; ?>" target="_blank"><?php echo get_avatar($wd->user_id); ?></a>
</td>
<td>
	<a href="<?php echo home_url()."/wp-admin/"; ?>user-edit.php?user_id=<?php echo $wd->user_id; ?>" target="_blank"><small><?php echo $wd->user_login_name; ?></small></a>
</td>
<td style="text-align:center;">
	<?php echo hook_price($wd->order_total); ?>          
</td>
<td>
	<?php echo $tt; ?> <small><?php echo hook_date($wd->order_date." ".$wd->order_time); ?> </small>
</td>
<td>

<?php

// ORDER STATUS
switch($wd->order_status){

	case 1: {
		$text = "Paid";
		$color = "orange";
	} break;
	case 2: {
		$text = "Refunded";
		$color = "#000000";
	} break;
	case 3: {
		$text = "Incomplete";
		$color = "#929292";
	} break;
	case 4: {
		$text = "Failed";
		$color = "red";
	} break;
	case 5: {
		$text = "Completed";
		$color = "green";
	} break;

}


?>
   
<div style="padding:15px; background:<?php echo $color; ?>; color:#fff; text-align:center; font-size:14px; text-transform:uppercase"><?php echo $text; ?></div>
 

</td>              
<td class="ms" style="text-align:center;">
                <div class="btn-group1">
                
                <a class="btn btn-inverse btn-small" href="<?php echo THEME_URI; ?>/_invoice.php?invoiceid=<?php echo $wd->autoid; ?>" target="_blank" rel="tooltip" data-original-title="Show Invoice" data-placement="top">
<i class="gicon-th-list icon-white"></i></a>
                  
                  <a href="admin.php?page=6&tab=home&oid=<?php echo $wd->autoid; ?>" class="btn btn-small" rel="tooltip" data-placement="top" data-original-title="View"><i class="gicon-eye-open"></i></a>
                  
                  <a href="admin.php?page=6&tab=home&doid=<?php echo $wd->autoid; ?>" class="btn btn-inverse btn-small" rel="tooltip" data-placement="bottom" data-original-title="Delete"><i class="gicon-remove icon-white"></i></a>
                  
                </div>
              </td>
            </tr>
            
<?php endforeach; ?>
 

<?php  endif; ?>            
              
             
            </tbody>
            </table>

<div class="clearfix"></div>  

<hr /> 

<div class="pull-left"> 

<p><small>Total Items: <?php echo $TOTALITEMS; ?></small></p> <div class="clearfix"></div> 

Showing Page <?php if(!isset($_GET['cpage'])){ echo 1; }else{ echo $_GET['cpage']; } ?> of <?php if($TOTALPAGES == 0){ echo 1; }else{ echo $TOTALPAGES; } ?> 

</div>
           
        
<div class="pagination pull-right ">

<ul>
<?php
$pages = new wlt_admin_paginator;
$pages->items_total = $TOTALITEMS;
$pages->items_per_page = $ITEMSPERPAGE;
$pages->mid_range = $ITEMSPERPAGE/2;
$pages->pagelink = home_url()."/wp-admin/admin.php?tab=home&".$_SERVER['QUERY_STRING'];
$pages->paginate();
echo $pages->display_pages();
?>
</ul>
</div>

<div class="clearfix"></div>
        
         
</div>
</div>

<hr />
<a href="admin.php?page=6&amp;exportall=2" class="btn btn-success" style="margin-left:10px;">Export All Orders</a>
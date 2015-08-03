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
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; } $core_admin_values = get_option("core_admin_values"); ?> 
 


<div class="row-fluid">
<div class="span8">

<div class="box gradient"> 
 
          <div class="title">
            <h3>
            <i class="icon-envelope"></i>
           <a data-toggle="modal" href="#CouponModal" class="btn btn-success" style="float:right;margin-top:4px; margin-right:10px;">Create New Coupon</a>
            <span>Coupon Codes</span>
            </h3>
          </div>
  		<div class="content">
        <div class="accordion" id="accordion5">
         
 <?php 
		
		$wlt_coupons = get_option("wlt_coupons");
		 
		 // update_option("wlt_emails","");
		if(is_array($wlt_coupons) && count($wlt_coupons) > 0 ){  ?>
        
        
            <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
            <thead>
            <tr>
              <th class="no_sort">Code</th>
                <th class="no_sort">Discount</th>
                <th class="no_sort">Uses</th>            
              <th class="no_sort" style="width:110px;text-align:center;">Actions</th>
              
            </thead>
            <tbody>
            
        <?php
 	  
		foreach($wlt_coupons as $key=>$field){ ?>
		<tr>
         <td><?php echo stripslashes($field['code']); ?></td>         
        <td style="width:50px; text-align:center"><?php 
		$discount = $field['discount_percentage'];
		if($discount != ""){
		
			echo $discount."%"; 
		
		}else{
			echo hook_price($field['discount_fixed']); 
		}
		
		 ?></td>         
        <td style="width:50px; text-align:center"><?php
		$ff = $field['used'];
		if($ff == ""){
		$ff = 0;
		}
		echo $ff;
		 ?></td>         
        
         <td class="ms">
         <center>
                <div class="btn-group1">
                  <a class="btn btn-small" rel="tooltip" 
                  href="admin.php?page=6&edit_coupon=<?php echo $key; ?>"
                  data-placement="left" data-original-title=" edit "><i class="gicon-edit"></i></a>                   
                  <a class="btn btn-inverse btn-small confirm" rel="tooltip" data-placement="bottom" 
                  data-original-title="Remove"
                  href="admin.php?page=6&delete_coupon=<?php echo $key; ?>"
                  ><i class="gicon-remove icon-white"></i></a> 
                </div>
            </center>
            </td>
            </tr>
            <?php  }   ?> 
 
            </tbody>
            </table>
            
         <?php } ?> 



</div></div></div></div>
<div class="span4">

<div class="box gradient"> 

<div class="title"><h3> <i class="icon-envelope"></i><span>Settings</span></h3></div>
<div class="content">
        
<div class="form-row control-group row-fluid ">
                                <label class="control-label span7" data-placement="top">Enable Coupons</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off" style="display: none;">
                                      <input type="radio" name="toggle" value="off" onchange="document.getElementById('couponcodes').value='0'">
                                      </label>
                                      <label class="radio on" style="display: none;">
                                      <input type="radio" name="toggle" value="on" onchange="document.getElementById('couponcodes').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['couponcodes'] == '1'){  ?>on<?php } ?>" style="display: block;">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="couponcodes" name="admin_values[couponcodes]" value="">
         </div>

</div>

<div class="form-actions row-fluid">
                <div class="span7 offset4">
                  <button type="submit" class="btn btn-primary">Save changes</button> 
                </div>
              </div>
              
</div>
   
   
   <div class="box gradient">
        <div class="title"><h4><i class="icon-tags"></i><span>Bulk Import Coupons</span></h4></div>
            <div class="content top">       
                       
            <p>Enter a list of coupons items below, separate each coupon with a new line.</p>
            <p>Fixed Format: <label class="label">Code[discount]</label></p>
            <p>Percentage Format: <label class="label">Code[%discount]</label></p>
            <textarea class="row-fluid" id="default-textarea" style="height:200px;" name="coupon_import"></textarea>        
            </div>
             
            <div class="form-actions row-fluid"><div class="span7 offset4"><button type="submit" class="btn btn-primary">Start Import</button></div></div>     
        </div>
   
   
     
    
    </div>    
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
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; } $core_admin_values = get_option("core_admin_values");
 
?>

    <div class="row-fluid">


    <div class="box gradient span8">

      <div class="title">
            <div class="row-fluid"><h3><i class="icon-folder-open"></i>Installed Payment Gateways</h3></div>
        </div><!-- End .title -->
        
        <div class="content" >
        
<div class="accordion" id="accordion2">
 
 
            
      
              
                     
<?php 
 
$gatways = hook_payments_gateways($GLOBALS['core_gateways']);

$i=1;$p=1; if(is_array($gatways)){foreach($gatways as $Value){ ?>


 <div class="accordion-group">
                  <div class="accordion-heading" style="background:#fff;">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $i; ?>">
                      
					  
					  <?php if(strpos($Value['logo'], "http") === false){ ?>
<img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/gateways/<?php echo $Value['logo'] ?>"  style="max-width:140px; max-height:60px; float:right;">
<?php }else{ ?>
<img src="<?php echo $Value['logo'] ?>"  class="merchantlogo " style="max-width:140px; max-height:60px; float:right;">
<?php } ?>
					  <h4 style="margin:0xp;font-weight:bold;"><?php echo $Value['name'] ?> <span style="font-size:12px;">(view/hide settings)</span></h4> 
                      
                   
                    </a>
                  </div>
                  <div id="collapse<?php echo $i; ?>" class="accordion-body collapse" style="height: 0px; ">
                    <div class="accordion-inner">
 







 
<div class="clearfix"></div>
 
<form method="post"  target="_self"  id="g_<?php echo $i ?>">
    <input name="submitted" type="hidden" value="yes" />
    <input type="hidden" name="tab" value="gateways" />
     
           
    <?php foreach($Value['fields'] as $key => $field){ 
    if(!isset($field['list'])){ $field['list'] = ""; }
    if(!isset($field['default'])){ $field['default'] =""; } ?>
   <div class="form-row control-group row-fluid">
   <label class="control-label span4" for="normal-field"><?php echo $field['name'] ?></label>	 
   <div class="controls span7"> <?php echo MakeField($field['type'], $field['fieldname'],get_option($field['fieldname']),$field['list'], $field['default']) ?>  </div>
    <div class="clearfix"></div>
    </div>
    <?php } ?>
    <input class="btn btn-primary" type="submit" value="<?php _e('Save changes','cp')?>"/>	
</form> 

<?php if(isset($Value['notes']) && strlen($Value['notes']) > 1){ ?>
<div class="well"><?php echo $Value['notes']; ?></div>
<?php } ?>



 
     </div>
                  </div>
                </div>
                
 
        
 <?php $i++; } }  ?>       
</div>     
        
        <div class="alert alert-info"><b>Note:</b> More payment gateways can be found on the <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=premiumpress_addons" style="text-decoration:underline;"> theme plugins page here</a></div>
        
        </div>
        
        
    </div>
  
  
<div class="span4"> 


     
 
        <div class="box gradient">
          <div class="title"><h3><i class="icon-wrench"></i><span>Currency Settings</span> </h3></div>
          <div class="content">
          
<!----------------- FIELD -------->
 <div class="form-row control-group row-fluid">
	<label class="control-label span4" for="normal-field">Symbol ($)</label>
    <div class="controls span7">
    	<input type="text" name="admin_values[currency][symbol]" class="row-fluid" value="<?php echo $core_admin_values['currency']['symbol']; ?>">
    </div>
</div>      
<!-----------------END  FIELD -------->

<!----------------- FIELD -------->
 <div class="form-row control-group row-fluid">
	<label class="control-label span4" for="normal-field">Code (USD)</label>
    <div class="controls span7">
    	<input type="text" name="admin_values[currency][code]" class="row-fluid" value="<?php echo $core_admin_values['currency']['code']; ?>">
    </div>
</div>      
<!-----------------END  FIELD -------->
 
<!----------------- FIELD -------->
 <div class="form-row control-group row-fluid">
	<label class="control-label">Currency Positon</label>
    <div class="controls">
    
    	<select class="row-fluid" name="admin_values[currency][position]">
        <option value="left" <?php if($core_admin_values['currency']['position'] == "left"){ echo "selected=selected"; } ?>>Left (e.g $100) </option>
        <option value="right" <?php if($core_admin_values['currency']['position'] == "right"){ echo "selected=selected"; } ?>>Right (e.g 100$)</option>
        </select>
    </div>
</div>      
<!-----------------END  FIELD -------->

			</div>
  
            <div class="form-actions row-fluid">
                <div class="span7 offset4">
                  <button type="submit" class="btn btn-primary">Save changes</button> 
                </div>
              </div>  
         
        </div>
        <!-- End .box -->
        
        
        
<div class="box gradient">
          <div class="title"><h3><i class="icon-tasks"></i><span>Invoice Settings</span> </h3></div>
          <div class="content">
          
 <div class="form-row control-group row-fluid">
	<label class="control-label" for="normal-field">Company Name</label>
    <div class="controls">
    	<input type="text" name="admin_values[invoice][name]" class="row-fluid" value="<?php echo $core_admin_values['invoice']['name']; ?>">
    </div>
</div>    
         
         
          
 <div class="form-row control-group row-fluid">
	<label class="control-label" for="normal-field">Company Address</label>
    <div class="controls">
    	<textarea name="admin_values[invoice][address]" class="row-fluid"><?php echo stripslashes($core_admin_values['invoice']['address']); ?></textarea>
    </div>
</div>         
         
          
     </div>
  
            <div class="form-actions row-fluid">
                <div class="span7 offset4">
                  <button type="submit" class="btn btn-primary">Save changes</button> 
                </div>
              </div>  
         
        </div>
        <!-- End .box -->     
    
 
 </div>  
    
 

</div> 
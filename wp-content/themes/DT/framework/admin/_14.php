<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;
// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

 
// LOAD IN HEADER
echo $CORE_ADMIN->HEAD(); ?>
  
 
 

<div class="alert alert-info">
<img src="<?php echo THEME_URI; ?>/framework/admin/img/f1.png" class="infoimg" style="float:left; padding-right:20px;" />
<h1 style="color:#206E94;font-weight:bold;">Creating your own child theme</h1>

<h2 style="color:#206E94;">Getting started with PremiumPress child themes</h2>

<p>This tool is designed to help you get started developing your own child theme.</p>
<p>It will help you generate the basic files/folders required to create a basic child theme.</p>
<p> You can then watch the video tutorials for additional ideas and suggestions to further develop your child theme and build in new functionality.</p>

<p><a href="http://www.premiumpress.com/childthemes/" style="font-size:14px; color:blue; text-decoration:underline;" target="_blank">Video Tutorials - Creating Child Themes</a></p>
</div>

<div class="clearfix"></div>

<div class="tabbable tabs-left" >
    <ul id="tabExample3" class="nav nav-tabs" style="height:680px">
    <li class="active"><a href="#taxtab0" data-toggle="tab">Download Child Theme</a></li>
   <!-- <li><a href="#taxtab1" data-toggle="tab">Helpful Resources</a></li>
    <li><a href="admin.php?page=11" class="youtube" style="padding-left:35px;background-position:10px;">Video Tutorials</a></li>-->
     
     
    </ul>
    <div class="tab-content"  style="background:#fff;height:680px">
    
    	<div class="tab-pane fade in" id="taxtab1"> 
         

        
        </div>
        
        <div class="tab-pane fade in active" id="taxtab0">  
        <form method="post" action="">
        <input type="hidden" name="dsample" value="123" />     
        <div class="well">        
           <!------------ FIELD -------------->          
            <div class="form-row control-group row-fluid" id="myaccount_page_select">
                <label class="control-label span4" for="normal-field">Child Theme Name</label>
                <div class="controls span6">         
                 
                  <input type="text"  name="name" value="My New Child Theme" class="span11">
                        
                </div>
            </div>   
            
            <hr />
            
           <p> <input name="e1" type="checkbox" value="1" class="checkbox" /> Include my custom settings (functions.php)</p>
            
           <p> <input name="e2" type="checkbox" value="1" class="checkbox" /> Include my custom styles (style.css)</p>   
             
           <p> <input name="e3" type="checkbox" value="1" class="checkbox" /> Include core framework theme styles (style.css)</p>      
            
            <hr />
             
            <!------------ FIELD --------------> 
            <div style="text-align:center;"><button type="submit" class="btn btn-primary">Download Child Theme</button></div>
            
            </form>
            </div> 


        </div>
         
     
    </div>
</div>

 
 
<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); ?>
<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;
// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

// DATE PICKER
wp_register_script( 'datetimepicker',  FRAMREWORK_URI.'js/bootstrap-datetimepicker.js');
wp_enqueue_script( 'datetimepicker' );
	
wp_register_style( 'wlt_wp_admin_css',  FRAMREWORK_URI.'admin/css/admin.css');
wp_enqueue_style( 'wlt_wp_admin_css' );
	
wp_register_style( 'datepicker1',  FRAMREWORK_URI.'css/css.dateextra.css');
wp_enqueue_style( 'datepicker1' );
	
wp_register_style( 'datetimepicker',  FRAMREWORK_URI.'css/css.datetimepicker.css');
wp_enqueue_style( 'datetimepicker' );



function createDateRangeArray($strDateFrom,$strDateTo) {

 $aryRange=array();

  $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
  $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

  if ($iDateTo>=$iDateFrom) {
    array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry

    while ($iDateFrom<$iDateTo) {
      $iDateFrom+=86400; // add 24 hours
      array_push($aryRange,date('Y-m-d',$iDateFrom));
    }
  }
  return $aryRange;
}
 
function wlt_chartdata($query=0,$return=false){ global $wpdb; $STRING = "";
	 
	$DATE1 = date("Y-m-d",mktime(0, 0, 0, date("m")-1  , date("d")+10, date("Y")));
	$DATE2 = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")));	
	
	$dates = createDateRangeArray($DATE1,$DATE2); 
	$newdates = array();
	foreach($dates as $date){	  
	 $newdates[''.$date.''] = 0;
	}
 
	if($return){ return $newdates; }
 
	// GET ALL DATA FOR THE LAST 31 DAYS
	if($query == 0){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date from ".$wpdb->prefix."posts where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' GROUP BY ID";
	}elseif($query == 1){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='1' GROUP BY ID";
	}elseif($query == 2){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='2' GROUP BY ID";
	}elseif($query == 3){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='3' GROUP BY ID";
	}elseif($query == 4){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='4' GROUP BY ID";
	}elseif($query == 5){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='5' GROUP BY ID";
	}elseif($query == 6){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='6' GROUP BY ID";
	}elseif($query == 7){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='7' GROUP BY ID";
	}elseif($query == 8){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='8' GROUP BY ID";
	}elseif($query == 9){
	$SQL1 = "SELECT order_date AS post_date FROM ".$wpdb->prefix."core_orders LEFT JOIN ".$wpdb->users." ON (".$wpdb->users.".ID = ".$wpdb->prefix."core_orders.user_id) WHERE ".$wpdb->prefix."core_orders.order_date >= '".$DATE1."' and ".$wpdb->prefix."core_orders.order_date < '".$DATE2."'";
	}
	
	 
	$result = $wpdb->get_results($SQL1);
 	if(!$result){ return 0; }
	
	foreach($result as $value){	 
	  $postDate = explode(" ",$value->post_date);	 
		$newdates[$postDate[0]] ++;
	}	 
	 
	// FORMAT RESULTS FOR CHART	
	$i=1;  
	foreach($newdates as $key=>$val){
		$a = $key; 
		if(!is_numeric($val)){$val=0; }
		 	
		$STRING .= '['.$i.','.$val.'], ';
		$i++;		 
	}
	// RETURN DATA	
	return $STRING;
 
}
 
// LOAD IN HEADER
echo $CORE_ADMIN->HEAD(); ?>



<ul id="tabExample1" class="nav nav-tabs">

<?php
// HOOK INTO THE ADMIN TABS
function _13_tabs(){ $STRING = ""; global $wpdb; $core_admin_values = get_option("core_admin_values");

	if(isset($_GET['tab'])){ $_POST['tab'] = $_GET['tab']; }

	$pages_array = array( 
	
	"1" => array("t" => "Website Performance"	,"k"=>"per"),
	"2" => array("t" => "Live Reports"	,"k"=>"home"),
	"3" => array("t" => "Email Reports"	,"k"=>"email"),
 
 	);
	foreach($pages_array as $page){
	 
	if( ( isset($_POST['tab']) && $_POST['tab'] == $page['k'] ) || ( !isset($_POST['tab']) && $page['k'] == "per" ) ){ $class = "active"; }else{ $class = ""; }
	
		$STRING .= '<li class="'.$class.'"><a href="#'.$page['k'].'" onclick="document.getElementById(\'ShowTab\').value=\''.$page['k'].'\'" data-toggle="tab">'.$page['t'].'</a></li>';		
	}
 
	return $STRING;

}
echo hook_admin_13_tabs(_13_tabs());
// END HOOK
?>  
          
</ul>

<div class="tab-content">


	<div class="tab-pane fade <?php if(!isset($_POST['tab']) || ( isset($_POST['tab']) && ( $_POST['tab'] =="" || $_POST['tab'] =="per" ) )){ echo "active in"; } ?>" id="per">


<div class="row-fluid">

<h4><b>Website Performance Overview</b></h4>
<p>The chart below shows the number of new listings and orders received during the last 30 days.</p>
<div class="well">
<div id="placeholder" style="height:300px; margin-left:20px; margin-bottom:20px; margin-top:10px;"></div>
 
<script type="text/javascript">
jQuery(function () {
        
    var datasets = {
        "a": {
            label: "New Listings",
            data: [<?php echo wlt_chartdata(0); ?>],
			color: "#8EC252"
        },
		 					
        "j": {
            label: "New Orders",
            data: [<?php echo wlt_chartdata(9); ?>],
			color: "#333"
        },
		 	
		 };
          
            // insert checkboxes 
            var choiceContainer =jQuery("#choices");
    jQuery.each(datasets, function(key, val) {
        choiceContainer.append('<div style="float:left;width:150px; margin-bottom:10px;"><input style="float:left; margin-top:8px; margin-right:4px;" type="checkbox" name="' + key +
                               '" checked="checked" id="id' + key + '">' +
                               '<label for="id' + key + '">'
                                + val.label + '</label></div>');
    });
            choiceContainer.find("input").click(plotAccordingToChoices);

            
            function plotAccordingToChoices() {
                var data = [];

                choiceContainer.find("input:checked").each(function () {
                    var key =jQuery(this).attr("name");
                    if (key && datasets[key])
                        data.push(datasets[key]);
                });

                if (data.length > 0)
                   jQuery.plot(jQuery("#placeholder"), data, {
                        shadowSize: 0,
                        yaxis: {   },
                        xaxis: {   ticks: [0, <?php $s = wlt_chartdata(0,true); $i=1;foreach($s as $val=>$da){ echo '['.$i.', "'.substr($val,5,5).'"],'; $i++;  } ?>  ],  
						lines: { show: true },
						label: 'string' },						
						selection: { mode: "xy" },
                                                grid: { hoverable: true, clickable: true },
                                                bars: { show: true,lineWidth:3,autoScale: true, fillOpacity: 1 },
                                        points: { show: true },
                                        legend: {container:jQuery("#LegendContainer")    }
             
                                


                        
                    });
            }
       var previousPoint = null;
   	   jQuery("#placeholder").bind("plothover", function (event, pos, item) {
       jQuery("#x").text(pos.x.toFixed(2));
       jQuery("#y").text(pos.y.toFixed(2));

       
            if (item) {
                if (previousPoint != item.datapoint) {
                    previousPoint = item.datapoint;
                    
                   jQuery("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1];
                    if (y==1)
                    {
                    showTooltip(item.pageX, item.pageY, y + " " + item.series.label );
                    }
                    else
                    {
                    showTooltip(item.pageX, item.pageY, y + " " + item.series.label );
                    }
                }
                }
                else {
               jQuery("#tooltip").remove();
                previousPoint = null;            
            
            
        }
    });
function showTooltip(x, y, contents) {
       jQuery('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fff',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }
            plotAccordingToChoices();
        });
</script>
<script language="javascript" type="text/javascript" src="<?php echo get_bloginfo('template_url')."/framework/admin/"; ?>js/jquery.flot.js"></script> 
<div id="LegendContainer" style="float:right; margin-right:20px;margin-top:-10px;"></div>
<div id="choices" style="padding:10px;">&nbsp;</div>
<div class="clearfix"></div>
</div> 
</div>
</div>
      
    
    <div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "home"){ echo "active in"; } ?> in" id="home">
    
    
     
 <script>jQuery(function(){ jQuery('#reg_field_1_date').datetimepicker(); jQuery('#reg_field_2_date').datetimepicker();}); </script>
</form>
 <form action="" method="get">
<input type="hidden" name="submitted" value="no">
<input type="hidden" name="page" value="13">
<input type="hidden" name="tab" id="ShowTab" value="home">



 <div class="well">     
 <div class="row-fluid">

 <div class="span2">Time Period</div>
 <div class="span4">
  
	 <div class="input-prepend date span6" id="reg_field_1_date" data-date-format="yyyy-MM-dd hh:mm:ss">
                    <span class="add-on" style="height: 32px;"><i class="icon-calendar"></i></span>
                    <input type="text" name="date1" value="<?php if(!isset($_GET['date1'])){ echo date('Y-m-d H:i:s' , strtotime('-7 days')); }else{ echo $_GET['date1']; } ?>" id="date1"  data-format="yyyy-MM-dd hh:mm:ss" />
     </div>  
 </div>
 <div class="span4">
  
 	<div class="input-prepend date span6" id="reg_field_2_date" data-date-format="yyyy-MM-dd hh:mm:ss">
                    <span class="add-on" style="height: 32px;"><i class="icon-calendar"></i></span>
                    <input type="text" name="date2" value="<?php if(!isset($_GET['date2'])){ echo date('Y-m-d H:i:s');  }else{ echo $_GET['date2']; } ?>" id="date2"  data-format="yyyy-MM-dd hh:mm:ss" />
                    </div> 
 
 </div>
 
  <div class="span2"><button class="btn btn-primary" type="submit">Update</button></div> 
 
 </div>  
 </div>
 
 </form>
 
 <hr />

 <div class="row-fluid">
  
     
<?php

if(!isset($_GET['date1'])){
$date1 = date('Y-m-d H:i:s' , strtotime('-7 days'));
$date2 = date('Y-m-d H:i:s');
}else{
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
}

$SQL = $CORE->reports($date1, $date2,true, true);
		// LOOP THROUGH AND RUN THE SQL QUERIES
		if(is_array($SQL)){ $STRING = "";
			
			foreach($SQL as $querystr){
				 
				if($querystr['sql'] == "none"){
				 						
				}else{ 
					$results = $wpdb->get_results($querystr['sql']);
					
				?>
                  
            <table id="datatable_example" class="responsive table table-striped table-bordered">
            <thead>
            <tr>
              <th class="no_sort"><?php echo $querystr['title']; ?></th>
              <th class="no_sort" style="width:70px;text-align:center;"></th>
            </tr></thead>
            <tbody>
            <?php
											
					if(!empty($results)){ ?>
                    
            
                             <?php
								foreach ( $results as $r ) {
									 $hits = "";
									if($querystr['hits']){
										$hits = get_post_meta($r->ID,'hits',true);
										if($hits == ""){ $hits = "0 views"; }else{ $hits = $hits." views"; }
									}
									if($querystr['date']){
										$hits = hook_date($r->post_date);
									}
									if($querystr['rating']){
										$hits = $r->meta_value ." votes";
									}
									if($querystr['users']){
										$hits = $r->meta_value ." listings";
										$link = get_home_url()."/?s=&uid=".$r->post_author;
									}elseif($querystr['orders']){
										$hits = $GLOBALS['CORE_THEME']['currency']['symbol']."".$r->meta_value ."";
										$link = get_home_url()."/wp-admin/admin.php?page=6&tab=home&oid=".$r->meta_value1;
									}else{
										$link = get_permalink($r->ID);
									}
									?>
                                    
                                      <tr>
            
         <td><a href='<?php echo $link; ?>' style="color:blue; text-decoration:underline;"><?php echo $r->post_title; ?></a></td>         
         <td><center><span class="label label-yes"><?php echo $hits; ?></span></center></td>
         
            </tr> 
                                    <?php
									
								 
								} // end foreach
						
					}else{
					?>
					 <tr>
            
         <td colspan=2>No Results Found</td>
         
            </tr> 
					<?php
					}		
					
									
							?>
                            </tbody></table>
                             
                            <?php
					
				} // end if	
			}// end foreach	
	
}
			echo $STRING;

?>
    
   </div>
  
 
   
    
 
    
    
    
    
    
    
    
    
    
    
    
    
    </div>

	<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "email"){ echo "active in"; } ?>" id="email">

<form method="post" name="admin_save_form" id="admin_save_form" enctype="multipart/form-data">
	<input type="hidden" name="submitted" value="yes">
	<input type="hidden" name="tab"  value="email">
	 
<style>
.ah {  
 background: #f7f7f7;
border: 1px solid #dddddd;
border-radius: 4px;
-webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05); 
display: block;
padding: 8px 15px;
color: #269ccb;
font-weight: bold;
margin-bottom:10px;
}
.cb { margin-right:10px !important; }
</style>
<div class="tab-content" style="border-top: 1px solid #cdcdcd;">

 
 <script>
function changeboxme(id){

 var v = jQuery("#"+id).val();
 if(v == 1){
 jQuery("#"+id).val('0');
 }else{
 jQuery("#"+id).val('1');
 }
 
}
</script>
<div class="row-fluid">
    <div class="span6">
    
    <h3>Report Features</h3>
    <p>Tick the features below you want to include in your report.</p>
    
    <div class="ah">    
    <input name="" type="checkbox" value="1" class="cb" onchange="changeboxme('box1');" <?php if($core_admin_values['wlt_report']['f1'] == 1){ ?>checked="checked"<?php } ?>  /> 10 Most Recent Listings
    <input type="hidden" name="admin_values[wlt_report][f1]" value="<?php echo $core_admin_values['wlt_report']['f1']; ?>" id="box1" />   
    </div>
    
     <div class="ah">    
    <input name="" type="checkbox" value="1" class="cb" onchange="changeboxme('box2');" <?php if($core_admin_values['wlt_report']['f2'] == 1){ ?>checked="checked"<?php } ?> /> 10 Most Popular Listings
    <input type="hidden" name="admin_values[wlt_report][f2]" value="<?php echo $core_admin_values['wlt_report']['f2']; ?>" id="box2" />   
    </div>   
    
    <div class="ah">    
    <input name="" type="checkbox" value="1" class="cb" onchange="changeboxme('box3');" <?php if($core_admin_values['wlt_report']['f3'] == 1){ ?>checked="checked"<?php } ?> /> 10 Most User Rated Listings
    <input type="hidden" name="admin_values[wlt_report][f3]" value="<?php echo $core_admin_values['wlt_report']['f3']; ?>" id="box3" />   
    </div>  
      
    <div class="ah">    
    <input name="" type="checkbox" value="1" class="cb" onchange="changeboxme('box4');" <?php if($core_admin_values['wlt_report']['f4'] == 1){ ?>checked="checked"<?php } ?> /> 10 Most Recent Orders
    <input type="hidden" name="admin_values[wlt_report][f4]" value="<?php echo $core_admin_values['wlt_report']['f4']; ?>" id="box4" />   
    </div>
    
    <div class="ah">    
    <input name="" type="checkbox" value="1" class="cb" onchange="changeboxme('box5');" <?php if($core_admin_values['wlt_report']['f5'] == 1){ ?>checked="checked"<?php } ?> /> 10 Most User Search Terms
    <input type="hidden" name="admin_values[wlt_report][f5]" value="<?php echo $core_admin_values['wlt_report']['f5']; ?>" id="box5" />   
    </div>    
    
    <div class="ah">    
    <input name="" type="checkbox" value="1" class="cb" onchange="changeboxme('box6');" <?php if($core_admin_values['wlt_report']['f6'] == 1){ ?>checked="checked"<?php } ?> /> 10 Most Recent Comments
    <input type="hidden" name="admin_values[wlt_report][f6]" value="<?php echo $core_admin_values['wlt_report']['f6']; ?>" id="box6" />   
    </div>  
      
    <div class="ah">    
    <input name="" type="checkbox" value="1" class="cb" onchange="changeboxme('box7');" <?php if($core_admin_values['wlt_report']['f7'] == 1){ ?>checked="checked"<?php } ?> /> 10 Most Active Listing Authors
    <input type="hidden" name="admin_values[wlt_report][f7]" value="<?php echo $core_admin_values['wlt_report']['f7']; ?>" id="box7" />   
    </div>  
    
    <hr />
    
    <button type="submit" class="btn btn-primary" onclick="jQuery('#runreportnow').val('');">Save Changes</button>
       
           
    </div>
    
    <div class="span6">
    
        <h3>Email Daily Report</h3>
    	<p>Enter your email below to recieve the report daily via email;</p> 
    
    	<div style="background:#fff; padding:30px; border:1px solid #ddd;">
       
            <div class="form-row control-group row-fluid">
                <label class="control-label span4" for="normal-field">Email Report To</label>
                <div class="controls span7">
                <input type="text" name="admin_values[wlt_report][email]" class="row-fluid" value="<?php echo $core_admin_values['wlt_report']['email']; ?>">
                </div>
            </div>
 
            
            <hr />
            
            <button type="submit" class="btn btn-primary" onclick="jQuery('#runreportnow').val('');">Save Changes</button>
       
        </div>
        
        
        <h3>Download Report Now</h3>
    	<p>Select the date range to download the report now.</p> 
    
    	<div style="background:#fff; padding:30px; border:1px solid #ddd;">
       
       
       
       <script>jQuery(function(){ jQuery('#reg_field_1_date1').datetimepicker();  jQuery('#reg_field_2_date1').datetimepicker();}); </script>
	     
            <div class="form-row control-group row-fluid">
                <label class="control-label span4" for="normal-field">Date From</label>
                <div class="controls span7">
                	<div class="input-prepend date span6" id="reg_field_1_date1" data-date-format="yyyy-MM-dd hh:mm:ss">
                    <span class="add-on" style="height: 32px;"><i class="icon-calendar"></i></span>
                    <input type="text" name="date1" value="<?php echo date('Y-m-d H:i:s' , strtotime('-7 days')); ?>" id="date1"  data-format="yyyy-MM-dd hh:mm:ss" />
                    </div>               
                </div>
            </div>
            
            <div class="form-row control-group row-fluid">
                <label class="control-label span4" for="normal-field">Date To</label>
                <div class="controls span7">
                	<div class="input-prepend date span6" id="reg_field_2_date1" data-date-format="yyyy-MM-dd hh:mm:ss">
                    <span class="add-on" style="height: 32px;"><i class="icon-calendar"></i></span>
                    <input type="text" name="date2" value="<?php echo date('Y-m-d H:i:s'); ?>" id="date2"  data-format="yyyy-MM-dd hh:mm:ss" />
                    </div>               
                </div>
            </div>  
            
            <hr />
            
            <div style="text-align:center;"><button class="btn btn-info" onclick="jQuery('#runreportnow').val('yes');">Generate Report</button> </div> 
    
    <input name="runreportnow" value="" id="runreportnow" type="hidden" />
            
       
        </div> 
        
   
    
</div> 
 
 </div> </div> 
 
<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); ?>
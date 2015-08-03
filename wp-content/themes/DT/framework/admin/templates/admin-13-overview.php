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
?>

<div class="row-fluid">
<a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('wFemiamA6ds','videoboxplayer','479','350');" style="float:right;margin-top:5px;margin-right:5px;">Watch Video</a>
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
<div id="LegendContainer" style="float:right; margin-right:20px;margin-top:-10px;"></div>
<div id="choices" style="padding:10px;">&nbsp;</div>
<div class="clearfix"></div>
</div> 
</div>
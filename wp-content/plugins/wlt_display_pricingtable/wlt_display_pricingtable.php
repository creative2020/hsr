<?php
/*
Plugin Name: [DISPLAY] - Pricing Table
Plugin URI: http://www.premiumpress.com
Description: This plugin will change the package style display.
Version: 1.3
Author: Mark Fail
Author URI: http://www.premiumpress.com
License:

change log
----------------------
1.3 removed need for package price
*/
 

function ppt_wlt_new_style1($c){ global $CORE, $wpdb; ?>

<style>
#PACKAGESFORM .line-top {
	position: static;
	top: 0;
	background: #d90000;
	height: 5px;
	width: 100%;
	border-bottom: 1px solid #ba0000;
}
#PACKAGESFORM .title {
	font-size: 18px;
	padding: 40px 0;
}
#PACKAGESFORM .line {
	margin-bottom: 40px;
	border-top: 5px solid #d90000;
	border-bottom: 5px solid #ffffff;
	-webkit-box-shadow: 0 0 1px #000000;
	   -moz-box-shadow: 0 0 1px #000000;
	        box-shadow: 0 0 1px #000000;
} 
#PACKAGESFORM .pricing-table {
	font: 13px "PT Sans", "Helvetica Neue", arial, sans-serif;
	margin-bottom: 20px;
	-webkit-border-radius: 5px;
	   -moz-border-radius: 5px;
	        border-radius: 5px;
}
#PACKAGESFORM .pricing-table ul {
	margin: 0;
	padding: 0;
	list-style: none;
}
#PACKAGESFORM .pricing-header-row-1 {
	text-align: center;
	height: 40px;
	padding: 3px 0 0;
	-webkit-border-radius: 4px 4px 0 0;
	   -moz-border-radius: 4px 4px 0 0;
	        border-radius: 4px 4px 0 0;
	-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .3);
	   -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .3);
	        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .3);
}
#PACKAGESFORM .pricing-header-row-2 {
	text-align: center;
	height: 50px;
	margin-top: -1px;
	padding: 10px 0 0;
	border-bottom: none;	
	-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .3);
	   -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .3);
	        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .3);
}
.package-title h2 {
	color: #f9f9f9;
	margin: 0;
	font-size: 16px;
	line-height: 40px;
	text-shadow: -1px -1px 0 rgba(0, 0, 0, .3), 1px 1px 0 rgba(255, 255, 255, .2);
	text-align:center;
}

.package-price h1 {
	color: #f9f9f9;
	margin: 0;
	font-size: 35px;
	line-height: 40px;
	text-shadow: -1px -1px 0 rgba(0, 0, 0, .3), 1px 1px 0 rgba(255, 255, 255, .2);
}

.cents {
	font-size: 16px;
	position: relative;
	top: -20px;
}

.pricing-content-row-odd {
	font-size: 14px;
	background-color: #f3f3f3;
	padding: 10px 15px;
	border-left: 1px solid #aaaaaa;
	border-right: 1px solid #aaaaaa;
}

.pricing-content-row-even {
	font-size: 14px;
	background-color: #fcfcfc;
	padding: 10px 15px;
	border-left: 1px solid #aaaaaa;
	border-right: 1px solid #aaaaaa;
}

#PACKAGESFORM .acc-inner {
	display: block;
	padding: 10px 15px;
	border-left: 1px solid #aaaaaa;
	border-right: 1px solid #aaaaaa;
	-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .2), inset 0 -1px 1px rgba(0, 0, 0, .2);
	   -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .2), inset 0 -1px 1px rgba(0, 0, 0, .2);
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, .2), inset 0 -1px 1px rgba(0, 0, 0, .2);
}

#PACKAGESFORM .pricing-footer {	text-align: center;	height: 50px;padding: 10px 0 0;	-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .3);   -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, .3);	        box-shadow: inset 0 1px 0 rgba(255, 255, 255, .3);	-webkit-border-radius: 0 0 4px 4px;	   -moz-border-radius: 0 0 4px 4px;	      border-radius: 0 0 4px 4px;}
#PACKAGESFORM.animate, .animate .pricing-content-row-odd, .pricing-content-row-even, .acc-inner {	-webkit-transition: all .3s ease-in-out;	   -moz-transition: all .3s ease-in-out;    -o-transition: all .3s ease-in-out;	    -ms-transition: all .3s ease-in-out;	        transition: all .3s ease-in-out;}
#PACKAGESFORM .animate.add-shadow:hover {box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);-moz-box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);-webkit-box-shadow: 0 0 15px rgba(0, 0, 0, 0.4);}
#PACKAGESFORM .btn, .btn:hover {
	background:#53CC13;
	/*	Firefox	*/
	background-image: -moz-linear-gradient(top, #53CC13 0%, #4CBF10 49%, #3FBA00 50%, #3BB000 100%);
	/*	Webkit (Safari 3+, Chrome)	*/
	background-image: -webkit-gradient(linear, left top, left bottom, from(#53CC13), to(#3BB000), color-stop(.49,#4CBF10),color-stop(.5,#3FBA00));
	/*	IE8+:	*/
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#53CC13, endColorstr=#3BB000)";	
	color: #fff;
	font-size: 18px;
	font-weight: bold;
	text-shadow: 0 1px 0 #2A6000;
	text-align: center;
	line-height: 30px;
	border: solid 1px #43B300;
	-moz-box-shadow: 1px 2px 2px #319300, inset 0 1px 1px #6ED731;
	-moz-box-shadow: 1px 2px 2px #319300, inset 0 1px 1px rgba(149,234,89,0.48);
	-webkit-box-shadow: 1px 2px 2px #319300, inset 0 1px 1px #6ED731;
	-webkit-box-shadow: 1px 2px 2px #319300, inset 0 1px 1px rgba(149,234,89,0.48);	
	box-shadow: 1px 2px 3px #319300, inset 0 1px 1px #6ED731;
	box-shadow: 1px 2px 2px #319300, inset 0 1px 1px rgba(149,234,89,0.48);	
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
}
#PACKAGESFORM .acc {cursor: pointer;}
#PACKAGESFORM .no-bold {font-weight: normal;}
#PACKAGESFORM .pricing-header-row-1{
	border: 1px solid #000;
	background:#363636;
	/*	Firefox	*/
	background-image: -moz-linear-gradient(top, #363636, #282828);
	/*	Webkit (Safari 3+, Chrome)	*/
	background-image: -webkit-gradient(linear, left top, left bottom, from(#363636), to(#282828));
	/*	IE8+:	*/
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#363636, endColorstr=#282828)";
}
#PACKAGESFORM .pricing-header-row-2 { 

	border-left: 1px solid #005594;
	border-right: 1px solid #005594;
	border-bottom: 1px solid #003054;
	/*	Grid Header Gradient	*/
	background: #0056AF;
	/*	Firefox	*/
	background-image: -moz-linear-gradient(top, #006E9C, #0056AF);
	/*	Webkit (Safari 3+, Chrome)	*/
	background-image: -webkit-gradient(linear, left top, left bottom, from(#006E9C), to(#0056AF));
	/*	IE8+:	*/
	-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#006E9C, endColorstr=#0056AF)";
}
#PACKAGESFORM .pricing-header-row-2 {border-bottom: none;}
#PACKAGESFORM .pricing-footer {	background-color: #e5e5e5;	border: 1px solid #ccc;} 

</style>


<form method="post" name="PACKAGESFORM" action="<?php echo $GLOBALS['CORE_THEME']['links']['add']; ?>" id="PACKAGESFORM">
<input type="hidden" name="packageID" id="packageID" value="-1" />
<div class="clearfix"></div>
<div class="row-fluid">
<?php
$a=0;
// PACKAGE /MEMEBERSHIP DATA
$packagefields 		= get_option('packagefields');
$packagefields = $CORE->multisort( $packagefields , array('order') );	
foreach($packagefields as $field){

if(isset($field['hidden']) && $field['hidden'] == "yes"){ continue; }

/* animate change-bg animate go-up animate add-shadow */
?>
<div class="span3 pricing-table animate add-shadow">
					
                    <ul>
						<li class="pricing-header-row-1">
							<div class="package-title">
								<h2 class="no-bold"><?php echo stripslashes($field['name']); ?></h2>
							</div>
						</li>
						<li class="pricing-header-row-2">
							<div class="package-price">
								<h1 class="no-bold"><?php if( $field['price'] == "0" || $field['price'] == "" ){ echo $CORE->_e(array('button','19')); }else{ echo hook_price($field['price']); } ?></h1>
							</div>
						</li>
                        
                        
						<li class="pricing-content-row-even acc" <?php if(strlen($field['description']) > 1){ ?>data-toggle="collapse" data-target="#acc-<?php echo $a; ?>"<?php } ?>>
                        
                        <?php if($field['expires'] == "" || $field['expires'] == "0"){
						echo $CORE->_e(array('add','59'));
						}else{
						echo str_replace("%a",$field['expires'],$CORE->_e(array('add','34'))); 
						}
						?>
						   
						<?php if(strlen($field['description']) > 1){ ?><span style="float: right"><i class="icon-plus"></i></span><?php } ?>
						</li>
                        
                        <?php if(strlen($field['description']) > 1){ ?>
						<li id="acc-<?php echo $a; ?>" class="accordion-body collapse">
							<span class="acc-inner">
								<?php echo stripslashes($field['description']); ?>
							</span>
						</li>
                        <?php } ?>
                        
                        <?php
	$i=0;				
	$earray = array(
	'1' => array('dbkey'=>'frontpage',		'text'=>$CORE->_e(array('add','40')),'desc'=>$CORE->_e(array('add','40d')),  ),
	'2' => array('dbkey'=>'featured',		'text'=>$CORE->_e(array('add','41')),'desc'=>$CORE->_e(array('add','41d')) ),
	'3' => array('dbkey'=>'html',			'text'=>$CORE->_e(array('add','42')),'desc'=>$CORE->_e(array('add','42d')) ), 
	'4' => array('dbkey'=>'visitorcounter',	'text'=>$CORE->_e(array('add','43')),'desc'=>$CORE->_e(array('add','43d')) ),
	'5' => array('dbkey'=>'topcategory',	'text'=>$CORE->_e(array('add','44')),'desc'=>$CORE->_e(array('add','44d')) ),
	'6' => array('dbkey'=>'showgooglemap',	'text'=>$CORE->_e(array('add','45')),'desc'=>$CORE->_e(array('add','45d')) ),
	);
	foreach($earray as $key=>$enhance){
		// CHECK WE ARE USING THIS FEATURE
		//if($GLOBALS['CORE_THEME']['enhancement'][$key.'_price'] > 0){
			// NOW CHECK IF ITS PART OF THE PACKAGE
			if($field['enhancement'][$key] == "1"){
			?>
			<li class="pricing-content-row-<?php if($i%2){?>even<?php }else{ ?>odd<?php } ?>"><i class="icon-ok"></i> <?php echo $enhance['text']; ?> </li>
			<?php 
			}else{ ?>
			<li class="pricing-content-row-<?php if($i%2){?>even<?php }else{ ?>odd<?php } ?>"><i class="icon-remove"></i> <?php echo $enhance['text']; ?> </li>
			<?php 
			}// END IF
			$i++;
		//} // END IF		
	} // END FOREACH
						
						?>
						
					 
						<li class="pricing-footer">
							<button class="btn" type="button" onclick="document.getElementById('packageID').value='<?php echo $field['ID']; ?>';document.PACKAGESFORM.submit();"><?php echo $CORE->_e(array('button','10')); ?></button>
						</li>
					</ul>
</div>
<?php $a++; } ?>
 	
</div>
</form>
<?php
}
add_action('hook_packages','ppt_wlt_new_style1');


// RESET THE ENTIRE DEFAULT/PRE-DEFINED COLOR OPTIONS

function _new_packageblock_styles($c){

// UNSET THE END FLAG SO WE CAN ADD-ON NEW STYLE BOXES
unset($c['e1']);
// CREATE NEW ARRAY FOR STYLES
$c["packageblock1"] = array(
'name' => 'Package Block Background', 
	 "inner" => array(
		"packageblock1_border" => array('name' => 'Border Color' ), 
		"packageblock1_txt" => array('name' => 'Heading Text Color' ),
		"packageblock1_btn" => array('name' => 'Button Background Color' ),
		"packageblock1_btntxt" => array('name' => 'Button Text Color' ),
		
		"packageblock1_odd" => array('name' => 'Feature Background (Odd Row)' ),
		"packageblock1_even" => array('name' => 'Feature Background (Even Row)' ),
	), 
);
$c["e1"] = array('end' => '');

return $c;
}
add_action('hook_styles_list_filter','_new_packageblock_styles');

// HOOK ADMIN STYLES TO INCLUDE CHILD THEME STYLING
function _new_packageblock_savecode($c){ global $CORE, $STRING;

		if(isset($GLOBALS['CORE_THEME']['colors']['packageblock1']) && strlen($GLOBALS['CORE_THEME']['colors']['packageblock1']) > 1){
			$STRING .= "
			.pricing-header-row-1, .pricing-header-row-2, .pricing-footer { 
			background-color: ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['packageblock1'])." !important;
			border: 1px solid ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['packageblock1_border'])."!important; }";			 
			$STRING .= "\n";
		} 
		if(isset($GLOBALS['CORE_THEME']['colors']['packageblock1_txt']) && strlen($GLOBALS['CORE_THEME']['colors']['packageblock1_txt']) > 1){
			$STRING .= ".package-price h1, .package-title h2 { color: ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['packageblock1_txt'])." !important;  }";			 
			$STRING .= "\n";
		} 		
		if(isset($GLOBALS['CORE_THEME']['colors']['packageblock1_btn']) && strlen($GLOBALS['CORE_THEME']['colors']['packageblock1_btn']) > 1){
			$STRING .= ".pricing-footer .btn { background: ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['packageblock1_btn'])."; 
			color: ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['packageblock1_btntxt'])." !important;  }";			 
			$STRING .= "\n";
		} 		
		if(isset($GLOBALS['CORE_THEME']['colors']['packageblock1_even']) && strlen($GLOBALS['CORE_THEME']['colors']['packageblock1_even']) > 1){
			$STRING .= ".pricing-content-row-even { background-color: ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['packageblock1_even'])." !important;  }";			 
			$STRING .= "\n";
		} 
		if(isset($GLOBALS['CORE_THEME']['colors']['packageblock1_odd']) && strlen($GLOBALS['CORE_THEME']['colors']['packageblock1_odd']) > 1){
			$STRING .= ".pricing-content-row-odd { background-color: ".$CORE->ValidateCSS($GLOBALS['CORE_THEME']['colors']['packageblock1_odd'])." !important;  }";			 
			$STRING .= "\n";
		} 
				
		
return $c.$STRING;
}
add_action('hook_styles_code_filter','_new_packageblock_savecode');

?>
function AjaxRequest()
{
	this.mRequest = this.getHttpRequest();
	this.mHandlers = new Array();
	var self = this;
	
	this.mRequest.onreadystatechange = function()
	{
		if(	self.mHandlers[ self.mRequest.readyState ] != undefined )
		{
			for( i = 0 ; i < self.mHandlers[ self.mRequest.readyState ].length ; i++ )
			{
				self.mHandlers[ self.mRequest.readyState ][ i ]( self );				
			}
		}
	}
}

AjaxRequest.prototype.addEventListener = function( pEventType, pFunction )
{
	if(	this.mHandlers[ pEventType ] == undefined )
	{
		this.mHandlers[ pEventType ] = new Array();
	}
	
	this.mHandlers[ pEventType ].push( pFunction );
}

AjaxRequest.prototype.getHttpRequest = function()
{
	// List of Microsoft XMLHTTP versions - newest first

	var MSXML_XMLHTTP_PROGIDS = new Array
	(
		'MSXML2.XMLHTTP.5.0',
		'MSXML2.XMLHTTP.4.0',
		'MSXML2.XMLHTTP.3.0',
		'MSXML2.XMLHTTP',
		'Microsoft.XMLHTTP'
	);

	// Do we support the request natively (eg, Mozilla, Opera, Safari, Konqueror)

	if( window.XMLHttpRequest != null )
	{
		return new XMLHttpRequest();
	}
	else
	{
		// Look for a supported IE version

		for( i = 0 ; MSXML_XMLHTTP_PROGIDS.length > i ; i++ )
		{
			try
			{
				return new ActiveXObject( MSXML_XMLHTTP_PROGIDS[ i ] );
			}
			catch( e )
			{
			}
		}
	}
	
	return( null );
}

function CoreDo( fileName, div )
{	 
	var Ajax = new AjaxRequest();

	if( Ajax.mRequest )
	{				
	
	if ("https:" == document.location.protocol) {
		if(fileName.indexOf("https:") > -1){ // true
			
		}else{
			fileName = "https://"+fileName; 
		}
		
	} else {
		fileName = "http://"+fileName; 
	}
	
		Ajax.mFileName 	=  fileName;	
		var obj = document.getElementById(div);				

		Ajax.mRequest.open( "GET", fileName);
		Ajax.mRequest.onreadystatechange = function() {
			if(Ajax.mRequest.readyState == 4 && Ajax.mRequest.status == 200){
				obj.innerHTML = Ajax.mRequest.responseText;
			}
		}		
	}
	Ajax.mRequest.send( null );
}

function httpshash(){
return 'http';
}
/* =============================================================================
  VIDEOBOX FOR PLAYING VIDEO FILES
  ========================================================================== */
function WLTAjaxVideobox(l, id, field, type, div){
	
	jQuery.ajax({
         type: "GET",
         url: l+'/?core_aj=1&action=ajaxvideobox&pid='+id+'&f='+field+'&t='+type,
          success: function (result) {
		  	
			var obj = document.getElementById(div);
			obj.innerHTML = result;
			
           jQuery('#wlt_videobox_ajax_'+id+'_active video').mediaelementplayer();
		   
          },
          error: function (error) {
              alert(error);
          }
        });

}
/* =============================================================================
   FAVORITES
   ========================================================================== */
function WLTAddF(l,type, id, div){
	
	jQuery.ajax({
         type: "GET",
         url: l+'/?core_aj=1&action=ListObject&postid='+id+'&type='+type,
          success: function (result) {
			  
			 var res = result.split("**");

			jQuery().toastmessage('showToast', {
				 text     : res[0],
				 sticky   : true,
				 position : 'top-right',
				 type     : res[1],
				 closeText: '',
				 close    : function () {console.log("toast is closed ...");}
			});
		   
          },
          error: function (error) {
              alert(error);
          }
        });

} 

 /* =============================================================================
   SET FEATURED
   ========================================================================== */
function ShowAdSearch(l, div){
CoreDo(l+'/?core_aj=1&action=showadvancedsearch', div);
}
 /* =============================================================================
   SET FEATURED
   ========================================================================== */
function WLTSetImgText(l, aid, text, div){
CoreDo(l+'/?core_aj=1&action=setimgtext&aid='+aid+'&txt='+text, div);
}
function WLTSetFeatured(l, pid, aid, div){
jQuery(".table tr").removeClass("bs-callout");
CoreDo(l+'/?core_aj=1&action=setfeatured&pid='+pid+'&aid='+aid, div);
}
function WLTSetImgOrder(l, aid, pid, text, div){
CoreDo(l+'/?core_aj=1&action=setimgorder&aid='+aid+'&pid='+pid+'&txt='+text, div);
}
 
function WLTEDITMEDIA(ulink, mid, div){
	
	jQuery.ajax({
         type: "POST",
         url: ulink,		 
		 data: {'core_aj' : 1, 'wlt_ajax': 'showmediabox', 'mid': mid  },
          success: function (result) {
			  
			jQuery('#editmediabox').show();
		   	jQuery('#'+div).html(result);
          },
          error: function (error) {
              alert(error);
          }
        });

} 
/* =============================================================================
   STAR RATING
   ========================================================================== */
function WLTSaveRating(l, pid, value, div){
CoreDo(l+'/?core_aj=1&action=SaveRating&pid='+pid+'&value='+value, div);
}
function WLTSaveUpRating(l, pid, value, div){
CoreDo(l+'/?core_aj=1&action=SaveUpRating&pid='+pid+'&value='+value, div);
}
/* =============================================================================
   UPDATE USER FIELD
   ========================================================================== */
function WLTUpdateUserField(l, id, value, div){
CoreDo(l+'/?core_aj=1&action=UpdateUserField&id='+id+'&value='+value, div);
}
/* =============================================================================
   PRICE PER CATEGORY
   ========================================================================== */
function WLTCatPrice(l, id, div){
CoreDo(l+'/?core_aj=1&action=CatPrice&cid='+id, div);
}
function WLTCatPriceUpdate(l, id, price, div){
CoreDo(l+'/?core_aj=1&action=CatUpdatePrice&cid='+id+'&p='+price, div);
}
/* =============================================================================
   MAILING LIST
   ========================================================================== */
function WLTMailingList(l, id, div){
CoreDo(l+'/?core_aj=1&action=MailingList&eid='+id, div);
}
/* =============================================================================
   MAPOBJECT
   ========================================================================== */
function WLTMapData(l, id, div){
CoreDo(l+'/?core_aj=1&action=MapData&postid='+id, div);
}

 /* =============================================================================
   MESSAGES
   ========================================================================== */
function WLTChangeMsgStatus(l,id, div){
CoreDo(l+'/?core_aj=1&action=ChangeMsgStatus&id='+id, div);
}
function WLTValidateUsername(l,id, div){
CoreDo(l+'/?core_aj=1&action=ValidateUsername&id='+id, div);
}
 /* =============================================================================
   SEARCH AJAX SELECTION
   ========================================================================== */
function WLTChangeState(l,val, div,sel){
CoreDo(l+'/?core_aj=1&action=ChangeState&val='+val+'&sel='+sel+'&div='+div, div);
}
function ChangeSearchValues(l,val,key,cl, pr, add, div){
CoreDo(l+'/?core_aj=1&action=ChangeSearchValues&val='+val+'&key='+key+'&cl='+cl+'&pr='+pr+'&add='+add, div);
}
 /* =============================================================================
   EMAIL VALIDATE
   ========================================================================== */
function isValidEmail(emailAddress) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
};
 /* =============================================================================
   USER SESSION
   ========================================================================== */
function WLTSaveSession(l,div){
CoreDo(l+'/?core_aj=1&action=SaveSession', div);
}

// EQUAL HIGHT FOR CONTENT PAGES
equalheight = function(container){
var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 jQuery(container).each(function() {

   $el = jQuery(this);
   jQuery($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}
 /* =============================================================================
   DOCUMENT READY
   ========================================================================== */
jQuery(document).ready(function(){ 

jQuery('#wlt_search_tab1').on( "click", function() {
	jQuery('#wlt_google_map_wrapper').hide();
	jQuery('.wlt_search_results').addClass('list_style').removeClass('grid_style');
	jQuery('#wlt_search_tab2').removeClass('active'); 
	jQuery('#wlt_search_tab3').removeClass('active'); 
	jQuery('#wlt_search_tab1').addClass('active');
	jQuery('.item .thumbnail').removeAttr( 'style' );
	setTimeout(function(){ jQuery('.itemdata .thumbnail').removeAttr( 'style' );  }, 2000); 
	
});

jQuery('#wlt_search_tab3').on( "click", function() {
	loadGoogleMapsApi(); 
	jQuery('#wlt_search_tab1').removeClass('active');
	jQuery('#wlt_search_tab2').removeClass('active');
	jQuery('#wlt_search_tab3').addClass('active');
});

jQuery('#wlt_search_tab2').on( "click", function() {
	jQuery('#wlt_google_map_wrapper').hide();
	jQuery('.wlt_search_results').removeClass('list_style').addClass('grid_style');
	jQuery('#wlt_search_tab1').removeClass('active');
	jQuery('#wlt_search_tab3').removeClass('active');
	jQuery('#wlt_search_tab2').addClass('active');
	 setTimeout(function(){equalheight('.grid_style .thumbnail');  }, 2000); 
});

jQuery('.wlt_runeditor').click(function(e){    
 
	var editid = jQuery(this).attr( 'alt' );	
	jQuery.fn.editable.defaults.mode = 'popup';
	jQuery('#'+editid).editable();
	 jQuery('#'+editid).unwrap();
});

jQuery('.wlt_searchbox .wlt_button_search').click(function(e){  
jQuery('#wlt_searchbox_form').submit();
}); 

});


function TaxNewValue(div, text){
	
	var mt=prompt(text,"");
	if (mt!= null){ 
	
	jQuery('#'+div).append(jQuery("<option selected=selected></option>").attr("value",'newtaxvalue_'+ mt).text(mt)).attr("selected", "selected");
 					
	}
 
}

function GMApMyLocation(){

    if(typeof google === "undefined"){
        var script = document.createElement("script");
        script.src = "https://maps.google.com/maps/api/js?sensor=false&callback=loadMyLocationReady";
        document.getElementsByTagName("head")[0].appendChild(script);
    } else {
        loadMyLocationReady();
    }
}

var marker = ""; var map1;
function loadMyLocationReady(){  setTimeout(function(){ jQuery("body").trigger("gmap_location_loaded"); }, 2000);  }

jQuery("body").bind("gmap_location_loaded", function(){ 
 
	// CHECK FOR EXISTING COORDS
	if(document.getElementById("mylog").value != ""){
	
	 var options = {center: new google.maps.LatLng(document.getElementById("mylat").value,document.getElementById("mylog").value), mapTypeId: google.maps.MapTypeId.ROADMAP, zoom: 7, panControl: true, zoomControl: true, scaleControl: true    };	
	
	} else {
		
	 var options = {center: new google.maps.LatLng(0,0), mapTypeId: google.maps.MapTypeId.ROADMAP, zoom: 2, panControl: true, zoomControl: true, scaleControl: true    };	
	}
	
	// SET THE MAP OPTIONS
    map1 = new google.maps.Map(document.getElementById('wlt_google_mylocation_map'), options);
	
	// SET MARKER
	var CurrentLang = jQuery("#mylat").val();
	if(CurrentLang != ""){
		var marker = new google.maps.Marker({
		  position: new google.maps.LatLng(jQuery("#mylat").val(), jQuery("#mylog").val()),
		  map: map1,
		  draggable: true,
		});
	}
	
	// ON MAP CLICK EVENT
	google.maps.event.addListener(map1, 'click', function(event){			
    
		document.getElementById("mylog").value = event.latLng.lng();	
		document.getElementById("mylat").value =  event.latLng.lat();	
		
		// SAVE DATA
		SaveMyLocation(event.latLng);
		
		// SET MARKER
		SaveMyMarker(event.latLng);
	
	}); 

});

function SaveMyMarker(location){

	if(marker == ""){
	marker = new google.maps.Marker({	position: location, 	map: map1,  draggable:true,     animation: google.maps.Animation.DROP,	}); 
	}
	
	google.maps.event.addListener (marker, 'dragend', function (event){
																
		document.getElementById("mylog").value = event.latLng.lng();	
		document.getElementById("mylat").value =  event.latLng.lat();	
		
		// SAVE DATA
		SaveMyLocation(event.latLng);
		
		// SET MARKER
		SaveMyMarker(event.latLng)
	});
	
	marker.setPosition(location);
	
	// SHOW SAVE BUTTON
	jQuery('#savemylocationbox').show();
	
}

function SaveMyLocation(location){

	var geocoder = new google.maps.Geocoder();
	if (geocoder) {geocoder.geocode({"latLng": location}, function(results, status) { 
	
		if (status == google.maps.GeocoderStatus.OK) {
					
					// SET FORMATTED ADDRESS
					document.getElementById("myaddress").value = results[0].formatted_address;
                        
                    for (var i = 0; i < results[0].address_components.length; i++) {
				
							  var addr = results[0].address_components[i];
							  
							  switch (addr.types[0]){
								
								case "street_number": {
									//document.getElementById("map-address1").value = addr.long_name;
								} break;
								
								case "route": {
									//document.getElementById("map-address2").value = addr.long_name;
								} break;
								
								case "locality": {
									//document.getElementById("map-address3").value = addr.long_name;
									//document.getElementById("map-city").value = addr.long_name;
								} break;
								
								case "postal_code": {
									document.getElementById("myzip").value = addr.short_name;
								} break;
								
								case "administrative_area_level_1": {								
									//document.getElementById("map-state").value = addr.long_name;
								} break;
								
								case "administrative_area_level_2": {								
									//document.getElementById("map-state").value = addr.long_name;
								} break;
								
								case "administrative_area_level_3": {								
									//document.getElementById("map-state").value = document.getElementById("map-state").value + addr.long_name;
								} break;
								
								case "country": {
									document.getElementById("myco").value = addr.short_name;
								} break;						  
							  
							  } // end switch						  
     			} // end for			
				
	}  // end if
	
	});
	
	}
	
}
 
 
function getAddressLocation(location){

	var geocoder = new google.maps.Geocoder();
	if (geocoder) {	
		geocoder.geocode({"address": location}, function(results, status) {	if (status == google.maps.GeocoderStatus.OK) {		
			
			// SAVE LOCATION
			SaveMyLocation(results[0].geometry.location,"no");
			
			// SET LONG/LAT
			document.getElementById("mylog").value = results[0].geometry.location.lng();	
			document.getElementById("mylat").value =  results[0].geometry.location.lat();	
		 
			// SET MARKER
			SaveMyMarker(results[0].geometry.location);
						
			// ZOOM IN
			map1.setZoom(9);
			
			// SET CENTER 
			map1.setCenter(results[0].geometry.location);
			
		}});
	}// END IF GEOCODER			
}


function getCurrentLocation() {
      if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(savePosition, positionError, {timeout:10000});
      } else {
          //Geolocation is not supported by this browser
		  jQuery('.wlt_mylocation').click();
      }
  }

  // handle the error here
  function positionError(error) {
      var errorCode = error.code;
      var message = error.message;
	  console.log(message);
  }

  function savePosition(position) {
	  
	  jQuery.getJSON('http://maps.googleapis.com/maps/api/geocode/json?latlng='+ position.coords.latitude +','+position.coords.longitude+'&sensor=true',{
        sensor: false,
        latlng: position.coords.latitude + ","+ position.coords.longitude,
		},
		function( data, textStatus ) {			
			
			console.log(data.results[0].formatted_address);	
			jQuery("#myaddress").val(data.results[0].formatted_address);
			
			for (var i = 0; i < data.results[0].address_components.length; i++) {
				
							  var addr = data.results[0].address_components[i];
							  
							  switch (addr.types[0]){
																
								case "postal_code": {									 
									jQuery("#myzip").val(addr.short_name);
								} break;								
								case "country": {									 
									jQuery("#myco").val(addr.short_name);
								} break;						  
							  
							  } // end switch						  
     			} // end for	
				
			 
			jQuery("#mylog").val(position.coords.longitude);
	  		jQuery("#mylat").val(position.coords.latitude); 			
			
			document.mylocationsform.submit();
		}
	 );
	  
	  console.log("Position Set:" + position.coords.longitude + ", " + position.coords.latitude);	  
             
  }
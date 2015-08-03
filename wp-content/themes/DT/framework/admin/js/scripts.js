;(function($) {	   
	
 
    $(function() {
		
		// tooltip
		$('[rel=tooltip]').tooltip();
		
 		// Toggle
		var off = false;

		var toggle = $('.toggle');

		toggle.siblings().hide();
		toggle.show();
 
		$('.content').on('click', '.toggle', function() {
			var self = $(this);

			if (self.hasClass('on')) {
				self.siblings('.off').click();
				self.removeClass('on').addClass('off');
			} else {
				self.siblings('.on').click();
				self.removeClass('off').addClass('on');
			}
		});

	});
	

})(jQuery);

/*
LAYER TOGGLE FUNCTION
*/
function toggleLayer( whichLayer )
{
  var elem, vis;
  if( document.getElementById ) 
    elem = document.getElementById( whichLayer );
  else if( document.all ) 
      elem = document.all[whichLayer];
  else if( document.layers ) 
    elem = document.layers[whichLayer];
  vis = elem.style;
 
  if(vis.display==''&&elem.offsetWidth!=undefined&&elem.offsetHeight!=undefined)    vis.display = (elem.offsetWidth!=0&&elem.offsetHeight!=0)?'block':'none';  vis.display = (vis.display==''||vis.display=='block')?'none':'block';
}
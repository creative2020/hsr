jQuery(document).ready(function(){ 
							
	jQuery(".filter-links li").eq(0).hide();
	jQuery(".filter-links li").eq(1).hide();
	jQuery(".filter-links li").eq(2).hide();
	jQuery(".filter-links li").eq(3).hide();
	
	jQuery(".add-new-h2").prop("href", "theme-install.php?browse=premiumpress");
	
	
	jQuery(".drawer-toggle").hide();
	jQuery("#wp-filter-search-input").hide();
	
	
	jQuery(".filter-links").append('<li><a href="#" data-sort="premiumpress" class="ppt">PremiumPress Child Themes</a></li>');						
});
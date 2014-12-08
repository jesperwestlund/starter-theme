// jquery.noConflict(); is run automatically by WordPress
jQuery(function($){

	// Responsive Menu
	$("<select />").appendTo("#menu-mobile");
	$("<option />", {
		"selected" : "selected",
		"value"    : "",
		"text"     : starter_localize.MenuItemGoto 
	}).appendTo("#menu-mobile select");

	// Responsive Select Menu Options
	$("#menu a").each(function() {
		var el = $(this);
		var n = el.parentsUntil("#menu", "ul").length; // Ancestors
		var strHyphens = "";
		
		// Depth
		for( var i=1; i < n; i++ )
			strHyphens += "-";
		strHyphens += " ";

		// Content
		$("<option />", {
			"value" : el.attr("href"),
			"text"  : strHyphens + el.text()
		}).appendTo("#menu-mobile select");
	});

	// Redirect
	$("#menu-mobile select").change(function() {
		window.location = $(this).find("option:selected").val();
	});

	// Superfish Menu
	$('ul.menu').supersubs({
		minWidth: 15,
		maxWidth: 27,
		extraWidth: 1
	}).superfish({
		animation: {opacity:'show',height:'show'},
		cssArrows: true,
		speed: 150,
		speedOut: 'fast',
		delay: 0
	});

});
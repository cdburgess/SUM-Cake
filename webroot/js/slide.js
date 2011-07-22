$(document).ready(function() {
	
	// Expand Panel
	$("#slider_open").click(function(){
		$("div#slider_panel").slideDown("slow");
	});	
	
	// Collapse Panel
	$("#slider_close").click(function(){
		$("div#slider_panel").slideUp("slow");	
	});		
	
	// Switch buttons from "Log In | Register" to "Close Panel" on click
	$("#slider_toggle a").click(function () {
		$("#slider_toggle a").toggle();
	});		
		
});
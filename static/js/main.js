$(document).ready(function() {

	$(".sub-nav").click(function() {
		$("#sub-menu").slideDown(400);
		
		var subMenuId = $(this).attr("id");
		FillSubMenu(subMenuId);
	});

});
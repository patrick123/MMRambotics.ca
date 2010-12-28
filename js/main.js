function MenuAppear(withAnimation, elm) {
	if (elm == false)
		var subMenuId = readCookie("current_menu");
	else
		var subMenuId = $(elm).attr("id");
		
	FillSubMenu(subMenuId);
	
	if (subMenuId != "") {
		if (withAnimation) {
			$("#sub-menu").show();
			$("#sub-menu").animate({ 
				width: "520px", 
				height: "25px"
			}, 600);
		} else {
			$("#sub-menu").show();
			$("#sub-menu").css({ "width": "520px", "height": "25px" });
		}
	}
}

function MenuInitialize() {
	$("#sub-menu").css({ 'width': '0px', 'height': '0px' });
}

$(document).ready(function() {

  // Menu
  	MenuInitialize();

	MenuAppear(false, false);

	$(".sub-nav").click(function() {
		MenuAppear(true, $(this));
		writeCookie("current_menu", $(this).attr("id"));
	});

});

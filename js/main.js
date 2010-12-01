function MenuAppear(withAnimation, elm) {
	if (elm == false)
		var subMenuId = readCookie("current_menu");
	else
		var subMenuId = $(elm).attr("id");
		
	FillSubMenu(subMenuId);
	
	if (subMenuId != "") {
		if (withAnimation) 
			$("#sub-menu").slideDown(400);
		else
			$("#sub-menu").slideDown(0);
	}
}

$(document).ready(function() {

  // Menu
	MenuAppear(false, false);

	$(".sub-nav").click(function() {
		MenuAppear(true, $(this));
		writeCookie("current_menu", $(this).attr("id"));
	});

	// Contact form:
  $("form#main-contact-form input, form#main-contact-form textarea").onkeyup(function() {
  }); 

});

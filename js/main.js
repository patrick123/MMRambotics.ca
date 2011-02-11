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

function ShowPlaylistLightbox(playlistName) {
  $.ajax({
    url: '/lib/playlist_request.php',
    type: 'POST',
    dataType: 'json',
    data: {
      name: playlistName
    },
    error: function() {
      alert("Unable to get playlist.");
    },
    success: function(data) {
      $("#playlist-carousel").html(data.carousel);
      $("#playlist-ribbonbar").html(data.ribbon);

      $("#lightbox-container").fadeIn(500);
      $.lightboxOpen = true;
    }
  });
}

function RemoveAllCurrentClasses() {
  $("ul#video-ribbon-bar").children().each(function() {
    $(this).removeClass("current");
  });
}

$(document).ready(function() {

  $.lightboxOpen = false;
  // Menu
  MenuInitialize();

	MenuAppear(false, false);

	$(".sub-nav").click(function() {
		MenuAppear(true, $(this));
		writeCookie("current_menu", $(this).attr("id"));
	});

  // Playlist Lightbox
  $(".playlist-link").click(function() {
    var playlistName = $(this).children(".playlist-name").text();  
    ShowPlaylistLightbox(playlistName);
  });

  $(".video-ribbon-bar-item").live('click', function() {
    RemoveAllCurrentClasses();
    $("div#video-carousel").html($(this).children(".video-content").attr("value"));
    $(this).addClass("current");
  });

  $("#close").click(function() {
    if ($.lightboxOpen) {
      $(".video-carousel-youtube").hide();
      $("#lightbox-container").fadeOut(500);
      $(".video-carousel-youtube").show(); 
      $.lightboxOpen = false;
    }
  });

  $("body").click(function(mouse) {
    var width  = $("#playlist-lightbox").width();
    var c      = $("#playlist-lightbox").offset();
    var height = $("#playlist-lightbox").height();
    if (mouse.pageX < c.left || mouse.pageX > c.left + width || mouse.pageY < c.top || mouse.pageY > c.top + height) {
      if ($.lightboxOpen) {
        $(".video-carousel-youtube").hide();
        $("#lightbox-container").fadeOut(500);
        $(".video-carousel-youtube").show(); // Small hack due to Flash content not fading out.
        $.lightboxOpen = false;
      }
    }
  });

});

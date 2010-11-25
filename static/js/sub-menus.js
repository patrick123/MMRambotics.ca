$.subMenus = $.parseJSON('\
{ \
	"about": \
		[ \
			{ \
				"text": "About FIRST", \
				"title": "About FIRST | MMRambotics FRC 2200", \
				"link": "about_first.html" \
			}, \
			{ \
				"text": "About The Site", \
				"title": "About The Site | MMRambotics FRC 2200", \
				"link": "about_the_site.html" \
			}, \
			{ \
				"text": "About The Technology", \
				"title": "Technology | MMRambotics FRC 2200", \
				"link": "about_the_technology" \
			} \
		], \
	"history": \
		[ \
			{ \
				"text": "Team History", \
				"title": "Team History | MMRambotics FRC 2200", \
				"link": "team_history.html" \
			}, \
			{ \
				"text": "Past FRC Games", \
				"title": "Past FRC Games | MMRambotics FRC 2200", \
				"link": "past_frc_games.html" \
			}, \
			{ \
				"text": "Our Past Robots", \
				"title": "Our Past Robots | MMRambotics FRC 2200", \
				"link": "our_past_robots.html" \
			} \
		], \
	"sponsors": \
		[ \
			{ \
				"text": "Current Sponsors", \
				"title": "Current Sponsors | MMRambotics FRC 2200", \
				"link": "current_sponsors.html" \
			}, \
			{ \
				"text": "Past Sponsors", \
				"title": "Past Sponsors | MMRambotics FRC 2200", \
				"link": "past_sponsors.html" \
			} \
		], \
	"media": \
		[ \
			{ \
				"text": "Photos", \
				"title": "Photos | MMRambotics FRC 2200", \
				"link": "mmrambotics_photos.html" \
			}, \
			{ \
				"text": "Videos", \
				"title": "Videos | MMRambotics FRC 2200", \
				"link": "mmrambotics_videos.html" \
			} \
		], \
	"resources": \
		[ \
			{ \
				"text": "Helpful Links", \
				"title": "Helpful Links | MMRambotics FRC 2200", \
				"link": "mmrambotics_helpful_links.html" \
			} \
		], \
	"contact-us": \
		[ \
			{ \
				"text": "Contact Us", \
				"title": "Contact MMRambotics FRC 2200", \
				"link": "contact_mmrambotics.html", \
			}, \
			{ \
				"text": "Contact Sponsors", \
				"title": "Contact Sponsors | MMRambotics FRC 2200", \
				"link": "contact_mmrambotics_sponsors.html" \
			} \
		] \
}');
	
function FillSubMenu(subMenuId) {
	var subMenuSet = $.subMenus[subMenuId];
	if (subMenuSet) {
		var subNavText = "";
		var setLength  = subMenuSet.length;
		for (var i = 0; i < setLength; ++i) {
			var curLink = subMenuSet[i];
			subNavText += '<a href="' + curLink.link + '" title="' + curLink.title + '">' + curLink.text + '</a>';
			if (i < setLength - 1)
				subNavText += "&nbsp;&nbsp;";
		}
		$("#sub-menu").html(subNavText);
	}
}
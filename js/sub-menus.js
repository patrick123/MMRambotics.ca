$.subMenus = $.parseJSON('\
{ \
	"about": \
		[ \
			{ \
				"text": "About FIRST", \
				"title": "About FIRST | MMRambotics FRC 2200", \
				"link": "about_first.php" \
			}, \
			{ \
				"text": "About The Site", \
				"title": "About The Site | MMRambotics FRC 2200", \
				"link": "about_the_site.php" \
			}, \
			{ \
				"text": "About The Technology", \
				"title": "Technology | MMRambotics FRC 2200", \
				"link": "about_the_technology.php" \
			} \
		], \
	"history": \
		[ \
			{ \
				"text": "Team History", \
				"title": "Team History | MMRambotics FRC 2200", \
				"link": "team_history.php" \
			}, \
			{ \
				"text": "Past FRC Games", \
				"title": "Past FRC Games | MMRambotics FRC 2200", \
				"link": "past_frc_games.php" \
			}, \
			{ \
				"text": "Our Past Robots", \
				"title": "Our Past Robots | MMRambotics FRC 2200", \
				"link": "our_past_robots.php" \
			} \
		], \
	"sponsors": \
		[ \
			{ \
				"text": "Current Sponsors", \
				"title": "Current Sponsors | MMRambotics FRC 2200", \
				"link": "current_sponsors.php" \
			}, \
			{ \
				"text": "Past Sponsors", \
				"title": "Past Sponsors | MMRambotics FRC 2200", \
				"link": "past_sponsors.php" \
			} \
		], \
	"media": \
		[ \
			{ \
				"text": "Photos", \
				"title": "Photos | MMRambotics FRC 2200", \
				"link": "mmrambotics_photos.php" \
			}, \
			{ \
				"text": "Videos", \
				"title": "Videos | MMRambotics FRC 2200", \
				"link": "mmrambotics_videos.php" \
			} \
		], \
	"resources": \
		[ \
			{ \
				"text": "Helpful Links", \
				"title": "Helpful Links | MMRambotics FRC 2200", \
				"link": "mmrambotics_helpful_links.php" \
			} \
		], \
	"contact-us": \
		[ \
			{ \
				"text": "Contact Us", \
				"title": "Contact MMRambotics FRC 2200", \
				"link": "contact_mmrambotics.php" \
			}, \
			{ \
				"text": "Contact Sponsors", \
				"title": "Contact Sponsors | MMRambotics FRC 2200", \
				"link": "contact_mmrambotics_sponsors.php" \
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

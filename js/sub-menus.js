$.subMenus = $.parseJSON('\
{ \
	"about": \
		[ \
			{ \
				"text": "About FIRST", \
				"title": "About FIRST | MMRambotics FRC 2200", \
				"link": "http://mmrambotics.ca/rambotics/about_first" \
			}, \
			{ \
				"text": "About The Site", \
				"title": "About The Site | MMRambotics FRC 2200", \
				"link": "http://mmrambotics.ca/rambotics/about_the_site" \
			}, \
			{ \
				"text": "About The Technology", \
				"title": "Technology | MMRambotics FRC 2200", \
				"link": "http://mmrambotics.ca/rambotics/about_the_technology" \
			} \
		], \
	"history": \
		[ \
			{ \
				"text": "Team History", \
				"title": "Team History | MMRambotics FRC 2200", \
				"link": "http://mmrambotics.ca/rambotics/team_history" \
			}, \
			{ \
				"text": "Past FRC Games", \
				"title": "Past FRC Games | MMRambotics FRC 2200", \
				"link": "http://mmrambotics.ca/rambotics/past_frc_games" \
			}, \
			{ \
				"text": "Our Past Robots", \
				"title": "Our Past Robots | MMRambotics FRC 2200", \
				"link": "http://mmrambotics.ca/rambotics/our_past_robots" \
			} \
		], \
	"sponsors": \
		[ \
			{ \
				"text": "Current Sponsors", \
				"title": "Current Sponsors | MMRambotics FRC 2200", \
				"link": "http://mmrambotics.ca/rambotics/current_sponsors" \
			}, \
			{ \
				"text": "Past Sponsors", \
				"title": "Past Sponsors | MMRambotics FRC 2200", \
				"link": "http://mmrambotics.ca/rambotics/past_sponsors" \
			} \
		], \
	"media": \
		[ \
			{ \
				"text": "Photos", \
				"title": "Photos | MMRambotics FRC 2200", \
				"link": "http://mmrambotics.ca/rambotics/mmrambotics_photos" \
			}, \
			{ \
				"text": "Videos", \
				"title": "Videos | MMRambotics FRC 2200", \
				"link": "http://mmrambotics.ca/rambotics/mmrambotics_videos" \
			} \
		], \
	"resources": \
		[ \
			{ \
				"text": "Helpful Links", \
				"title": "Helpful Links | MMRambotics FRC 2200", \
				"link": "http://mmrambotics.ca/rambotics/mmrambotics_helpful_links" \
			}, \
			{ \
				"text": "Twitter", \
				"title": "MMRambotics FRC 2200 Twitter", \
				"link": "http://twitter.com/mmrambotics" \
			}, \
			{ \
				"text": "YouTube", \
				"title": "MMRambotics FRC 2200 YouTube", \
				"link": "http://www.youtube.com/mmrambotics" \
			}, \
			{ \
				"text": "GitHub Code", \
				"title": "MMRambotics FRC 2200 GitHub Code Repository", \
				"link": "http://www.github.com/mmrambotics" \
			}, \
			{ \
				"text": "Facebook", \
				"title": "MMRambotics FRC 2200 Facebook", \
				"link": "http://www.facebook.com/MMRambotics.FRC2200" \
			} \
		], \
	"contact-us": \
		[ \
			{ \
				"text": "Contact Us", \
				"title": "Contact MMRambotics FRC 2200", \
				"link": "http://mmrambotics.ca/rambotics/contact_mmrambotics" \
			}, \
			{ \
				"text": "Contact Sponsors", \
				"title": "Contact Sponsors | MMRambotics FRC 2200", \
				"link": "http://mmrambotics.ca/rambotics/contact_mmrambotics_sponsors" \
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

function writeCookie(name, contents, daysUntilExpiry) {
	if (daysUntilExpiry == undefined)
		daysUntilExpiry = 15;
		
	var expiryDate = new Date();
	expiryDate.setDate(expiryDate.getDate() + daysUntilExpiry);
	
	document.cookie = escape(name) + "=" + escape(contents) + ";expires=" + expiryDate.toUTCString();
}

function readCookie(name) {
	var start = document.cookie.indexOf(escape(name) + "=");
	var end   = 0;
	if (start != -1) {
		start = start + escape(name).length + 1;
		end   = document.cookie.indexOf(";", start);
		if (end == -1)	
			end = document.cookie.length;
			
		return unescape(document.cookie.substring(start, end));
	}
	return false;
}

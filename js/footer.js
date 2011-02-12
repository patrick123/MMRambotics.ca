/*
 * @author: Andrew Horsman
 * @team: MMRambotics FRC #2200
 * @description: Loads footer widgets.
 */

var footer = new Object();
footer.widgets = new Array();
footer.elm = $("#footer-container");
footer.parentElm = $("#footer-large");

footer.recheckWindowSize = function() {
  if (footer.previousWidth != $(window).width() || footer.previousHeight != $(window).height()) {
    footer.previousWidth = $(window).width();
    footer.previousHeight = $(window).height();

    footer.checkAndGo();
  }
}

footer.checkAndGo = function() {
  if ($(window).width() >= 600 && $(window).height() >= 200) {
    footer.addWidgets();
    setTimeout('footer.recheckWindowSize();', 400);
  }
}

footer.clear = function() {
  footer.elm.html("");
}

footer.addWidgets = function() {
  footer.clear();
  var availableWidth  = $(window).width();
  var addedWidgets = 0;
  for (var i = 0; i < footer.widgets.length; ++i) {
    var widget = footer.widgets[i];
    if (availableWidth - widget.width > 0) {
      availableWidth -= widget.width;
      footer.elm.append(widget.markup);
      addedWidgets++;
    }
  }
  return addedWidgets;
}

function length(hash) {
  var length = 0;
  for (var name in hash)
    length++;

  return length;
}

footer.initializeFooter = function() {
  $.get('http://mmrambotics.ca/rambotics/footer_meta', function(data) {
    footer.widgets[0] = {
      width: '100',
      markup: data
    }
  });
  $("#closeFooter").click(function() { $("#footer-large").fadeOut(500); });
  setTimeout('footer.start();', 1000);
}

footer.start = function() {
  footer.addWidgets();
  footer.previousHeight = $(window).height();
  footer.previousWidth  = $(window).width();
  footer.parentElm.css("position", "absolute");
  footer.parentElm.css("top", $("div#container").height() + 80);
  footer.parentElm.css("backgroundColor", "#222");
  footer.elm.css("color", "#fff");
  footer.elm.css("width", $(window).width() - footer.availableWidth);
  footer.parentElm.css("width", "100%");
  footer.elm.css("margin", "0 auto");
  footer.elm.css("height", $(window).height() - $("div#container").height());
  setTimeout('footer.recheckWindowSize();', 400);
}

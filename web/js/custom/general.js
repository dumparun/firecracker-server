jQuery(document).ready(function() {
	jQuery(".errorclosebutton").click(function() {
		$("#errordiv").hide("slow");
	});

	setTimeout(function(d) {
		$("#errordiv").hide("slow");
	}, 30000);

});

function getServerURL() {
	/*
	 * var loc = window.location; var pathName = loc.pathname.substring(0,
	 * loc.pathname.indexOf('/', 1) + 1); return loc.href .substring( 0,
	 * loc.href.length - ((loc.pathname + loc.search + loc.hash).length -
	 * pathName.length));
	 */

	if (!window.location.origin) {
		// IE FIX
		window.location.origin = window.location.protocol + "//"
				+ window.location.hostname
				+ (window.location.port ? ':' + window.location.port : '');
	}
	// return window.location.origin + "/";
	return "http://localhost:8083/geometribox-server/";

}

function getResourceURL() {
	/*
	 * var loc = window.location; var pathName = loc.pathname.substring(0,
	 * loc.pathname.indexOf('/', 1) + 1); return loc.href .substring( 0,
	 * loc.href.length - ((loc.pathname + loc.search + loc.hash).length -
	 * pathName.length));
	 */
	return "http://cdn.geometribox.com/";
}

function getPathName() {

	var loc = window.location;
	return loc.pathname + loc.search;
	// var s = loc.pathname + loc.search;
	// return s.replace("/buildmantra/", '');
}

function showAlert(msg) {
	jQuery.msgBox({
		title : "geometribox",
		content : msg,
		type : "warning"
	});
}

function showInfo(msg) {
	jQuery.msgBox({
		title : "geometribox",
		content : msg,
		type : "info"
	});
}

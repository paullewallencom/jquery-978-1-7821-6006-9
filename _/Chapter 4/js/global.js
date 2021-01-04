var _gaq = _gaq || [];
var GAID = 'UA-27098764-1';
$(document).ready(function(e) {
	(function() {
	  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + 
			  '.google-analytics.com/ga.js';
	  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
}); 

// JavaScript Document
$("[data-role='page']").live('pageinit', function (event, ui) {
	$page = $(this);
	
	$page.find("[data-pageview]").click(function(){
		var $eventTarget = $(this);
		if($eventTarget.attr("data-pageview") == "href"){
			_gaq.push(['_trackPageview', $eventTarget.attr("href")]);
		}else{
			_gaq.push(['_trackPageview', $eventTarget.attr("data-pageview")]);
		}
	});
	
	$page.find("a.fullSiteLink").click(function(){
		$.cookie("fullSiteClicked","true", {path: "/", expires:3600});
	});
	
	//Any form that might need validation
	$("form.validateMe").each(function(index, element) {
		var $form = $(this);
		var v = $form.validate({
			errorPlacement: function(error, element) {
				var dataErrorAt = element.attr("data-error-at");
				if (dataErrorAt)
					$(dataErrorAt).html(error);
				else
					error.insertBefore(element);
			}
		});
    });

	$page.find(".validateContinue").click(function(){
		if($(this).closest("form").data("validator").form()){
			return true;
		}else{
			event.stopPropagation();
			event.preventDefault();
			return false;
		}
	});
	
});


$("[data-role='page']").live('pageshow', function (event, ui) {
	try {
		_gaq.push(['_setAccount', GAID]);

		if ($.mobile.activePage.attr("data-url")) {
			_gaq.push(['_trackPageview', $.mobile.activePage.attr("data-url")]);
		} else {
			_gaq.push(['_trackPageview']);
		}
	} catch(err) {}

});

$.validator.addMethod("pageRequired", function(value, element) { 
	var $element = $(element); 
	if ( $element.closest("."+$.mobile.subPageUrlKey).hasClass($.mobile.activePageClass)) { 
			return !this.optional(element); 
	}
	return "dependency-mismatch"; 
}, $.validator.messages.required);

function getDistance(lat1, lon1, lat2, lon2){ //great-circle distances between the two points
	var R = 6371; // km
	var dLat = (lat2-lat1).toRad();
	var dLon = (lon2-lon1).toRad();
	var lat1 = lat1.toRad();
	var lat2 = lat2.toRad();
	
	var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
			Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
	var d = R * c; //distance in km
	var m = d * 0.621371;  //distance in miles
	return m;
}
if (typeof(Number.prototype.toRad) === "undefined") {
  Number.prototype.toRad = function() {
	return this * Math.PI / 180;
  }
}

function compareDistances(a,b) {
  if (a.distance < b.distance)
	 return -1;
  if (a.distance > b.distance)
	return 1;
  return 0;
}



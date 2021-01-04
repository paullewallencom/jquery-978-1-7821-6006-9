$("html").removeClass("no-js").addClass("js");
var _gaq = _gaq || [];
var GAID = 'UA-27098764-3';
$(document).bind("mobileinit", function(){
	$.mobile.defaultPageTransition = "slide";
});
		
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


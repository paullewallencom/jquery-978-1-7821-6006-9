// JavaScript Document

var conditionalAppleMapsSwitcher = {
	appleMapsAltAttribute:"data-appleMapsUrl",
	forceAppleMapsConversionIfNoAlt:true,
	iPhoneAgent:"iPhone OS ",
	iPadAgent:"iPad; CPU OS ",
	process: function(){
		try{
			var agent = navigator.userAgent;
			if(window.localStorage && localStorage.getItem("replaceWithAppleMaps")){
				if(localStorage.getItem("replaceWithAppleMaps") == "true"){
					this.assimilateMapLinks();
				}
			}else{
				var iOSAgent = null;
				if(agent.indexOf(this.iPhoneAgent) > 0){
					iOSAgent = this.iPhoneAgent
				}
				else if(agent.indexOf(this.iPadAgent) > 0){	
					iOSAgent = this.iPadAgent
				}
				if(iOSAgent){
					var endOfAgentStringIndex = (agent.indexOf(iOSAgent)+iOSAgent.length);
					var version = agent.substr(endOfAgentStringIndex, agent.indexOf(" " , endOfAgentStringIndex));
					var majorVersion = Number(version.substr(0, version.indexOf("_")));
					if(majorVersion > 5){
						localStorage.setItem("replaceWithAppleMaps", "true");
						this.assimilateMapLinks();
					}
				}
			}
		}catch(e){}
	},
	assimilateMapLinks:function(){
		try{
			var switcher = this;
			$("a[href^='http://maps.google.com']").each(function(index, element) {
				var $link = $(element);
				if($link.attr(switcher.appleMapsAltAttribute)){
					$link.attr("href", $link.attr(switcher.appleMapsAltAttribute));
				}else if(switcher.forceAppleMapsConversionIfNoAlt){
					$link.attr("href", $link.attr("href").replace(/maps\.google\.com\/maps/,"maps.apple.com/"));
				}
			});
		}catch(e){}
	}
}

var _gaq = _gaq || [];

$(document).ready(function(e) {
	(function() {
	  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + 
			  '.google-analytics.com/ga.js';
	  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
}); 

$(document).on('pageinit', function (event, ui) {
	conditionalAppleMapsSwitcher.process();	
	$("a.fullSiteLink").click(function(){
		$.cookie("fullSiteClicked","true", {path: "/", expires:3600});
	});
});

$(document).on('pageshow', function (event, ui) {
	$("a.fullSiteLink").click(function(){
		$.cookie("fullSiteClicked","true", {path: "/"});
	});
	
	try {
		_gaq.push(['_setAccount', 'UA-27098764-2']);

		if ($.mobile.activePage.attr("data-url")) {
			_gaq.push(['_trackPageview', $.mobile.activePage.attr("data-url")]);
		} else {
			_gaq.push(['_trackPageview']);
		}
	} catch(err) {}

});


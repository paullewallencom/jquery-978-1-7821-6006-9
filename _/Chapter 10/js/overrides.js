// JavaScript Document

/*******************
 * The Application
 *******************/
var floodApp = {
	settings:{
		initialized:false,
		geolocation:{
			latitude:null,
			longitude:null,
			timestamp:null,
			isHome:false
		},
		regionalChoice:null,
		lastStation:null
	},
	getStarted:function(){
		location.replace("#initialize");
	},
	fireCustomEvent:function(){
		var $clicked = $(this);
		var eventValue = $clicked.attr("data-appEventValue");
		var event = new jQuery.Event($(this).attr("data-appEvent"));
		if(eventValue){ event.val = eventValue; }
		$(window).trigger(event);		
	},
	otherMethodsBlahBlahBlah:function(){}
}
/*******************
 * The Events
 *******************/

/*******************
 * The Model
 *******************/
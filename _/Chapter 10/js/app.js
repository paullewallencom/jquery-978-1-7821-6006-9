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
	getLocation:function(){
		navigator.geolocation.getCurrentPosition(
		
			function(position){ //success
				floodApp.settings.geolocation.latitude = position.coords.latitude;
				floodApp.settings.geolocation.longitude = position.coords.longitude;
				floodApp.settings.geolocation.timestamp = position.timestamp;
				localStorage.setItem("floodSettings",floodApp.settings);
				location.replace("#geoSuccess"); 
			},
			function(error){ //error 
				
				switch(error.code) 
				{
					case error.TIMEOUT:
						alert("Unable to get your position: Timeout");
						break;
					case error.POSITION_UNAVAILABLE:
						alert("Unable to get your position: Position unavailable");
						break;
					case error.PERMISSION_DENIED:
						alert("Unable to get your position: \nPermission denied. You may want to check your settings.");
						break;
					case error.UNKNOWN_ERROR:
						alert("Unkonwn error while trying to access your position.");
						break;
				}
			},
			{maximumAge:600000}
		)
	},
	
	setHomeLocation:function(){
		floodApp.settings.geolocation.isHome = true;
		location.replace("#stations_by_genre");
	},
	
	setNotHomeLocation:function(){
		floodApp.settings.geolocation.isHome = false;
		location.replace("#stations_by_genre");
	},
	
	playStation:function(event){
		alert("play station: "+event.val);
		var source   = $("#player-template").html();
		var template = Handlebars.compile(source);
		var context = {title: "Shadows", image: "images/shadows.jpg", mp3:"audio/shadows.mp3", ogg:"audio/shadows.ogg"}
		var html    = template(context);
		$("#player").html(html);
		$.mobile.changePage("#player");
	},
	
	initialize:function(){
		var storedSettings = null;
		try{
			$.parseJSON(localStorage.getItem("floodSettings"));
		}catch(e){}
		
		if(storedSettings != null){
			this.settings = storedSettings;
			if(storedSettings.lastStation){
				$(window).trigger("playStation");
				return;
			}else{
				$.mobile.changePage("#home");	
			}
		}
	},
	universalPageBeforeShow:function(){
		
	},
	universalPageBeforeCreate:function(){
		var $page = $(this);
		if($page.find(".bottomNavBar").length == 0){
			$page.append($("#globalComponents .bottomNavBar").clone());
		}
	}
}

/*******************
 * The Events
 *******************/
//Interface Events
$(document).on("click", "[data-appEvent]", floodApp.fireCustomEvent);
$(document).on('pagebeforeshow', "[data-role='page']",floodApp.universalPageBeforeShow);
$(document).on('pagebeforecreate', "[data-role='page']",floodApp.universalPageBeforeCreate);
$(document).on("pageshow", "#initialize", floodApp.getLocation);
$(document).on("pagebeforeshow", "#welcome", floodApp.initialize);

//Application Events
$(window).on("getStarted", floodApp.getStarted);
$(window).on("setHomeLocation", floodApp.setHomeLocation);
$(window).on("setNotHomeLocation", floodApp.setNotHomeLocation);
$(window).on("playStation", floodApp.playStation);

/*******************
 * The Model
 *******************/


<?php 
	$documentTitle = "Dickinson Theaters";
	
	$headerLeftHref = "/";
	$headerLeftLinkText = "Home";
	$headerLeftIcon = "home";
	
	$headerTitle = "";

	$headerRightHref = "tel:8165555555";
	$headerRightLinkText = "Call";
	$headerRightIcon = "grid";
	
	$fullSiteLinkHref = "http://dtmovies.com/now_showing.aspx";
	
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("includes/meta.php"); ?> 
    <style type="text/css">
		.logoContainer{
			display:block;
			height:84px;
			background-image:url(images/header.png); 
			background-position:top center;  
			background-size:885px 84px;
			background-repeat:no-repeat;
		}

	</style>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCDVuW8zmZ6L2RxCn9djN3hCqE3AS54SBk&sensor=true"></script>
</head>

<body>
<div id="qrfindclosest" data-role="page">
    <div class="logoContainer ui-shadow"></div>
    <div data-role="content">
	   	<div style="margin-top:-5px; margin-bottom:30px;" id="latLong">
			<form id="findTheaterForm" action="fullshowtimes.php" method="get" class="validateMe">
            	<p><label for="zip">Enter Zip Code</label><input type="tel" name="zip" id="zip" class="required number"/></p>
                <p><input type="submit" value="Go"></p> 
            </form>
        </div>
        <p>
        	<ul id="showing" data-role="listview" class="movieListings" data-dividertheme="g"></ul>
        </p>
    </div>
    
    <?php include("includes/footer.php"); ?>
</div>

<div id="directions" data-role="page">
	<div data-role="header">
        <h3>Directions</h3>
    </div>
    <div data-role="footer">		
        <div data-role="navbar" class="directionsBar">
            <ul>
                <li><a href="#" id="drivingButton" onClick="showDirections('DRIVING')"><div class="icon driving"></div></a></li>
                <li><a href="#" id="transitButton" onClick="showDirections('TRANSIT')"><div class="icon transit"></div></a></li>
                <li><a href="#" id="bicycleButton" onClick="showDirections('BICYCLING')"><div class="icon bicycle"></div></a></li>
                <li><a href="#" id="walkingButton" onClick="showDirections('WALKING')"><div class="icon walking"></div></a></li>
            </ul>
        </div>
    </div>
    <div id="map_canvas"></div>
    <div data-role="content" id="directions-panel"></div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script type="text/javascript">
	//declare our global variables
	var theaterData = null;
	var timestamp = null;
	var latitude = null;
	var longitude = null;
	var closestTheater = null;
	var directionData = null;
	var directionDisplay;
	var directionsService = new google.maps.DirectionsService();
	var map;
			
	//Once the page is initialized, hide the manual zip code form
	//and place a message saying that we’re attempting to find 
	//their location.
	$(document).on("pageinit", "#qrfindclosest", function(){
		if(navigator.geolocation){
			$("#findTheaterForm").hide();
			$("#latLong").append("<p id='finding'>Finding your location...</p>");
		}
	});
	
	$(document).on("pageshow", "#qrfindclosest", function(){
		theaterData = $.getJSON("js/theaters.js", function(data){
			theaterData = data;
			selectClosestTheater();
			
		});
	});
	
	function showDirections(travelMode){
		var request = {
			origin:latitude+","+longitude,
			destination:closestTheater.geo.lat+","+closestTheater.geo.long,
			travelMode: travelMode
		};
		
		directionsService.route(request, function(response, status) {
			if (status == google.maps.DirectionsStatus.OK) {
				directionsDisplay.setDirections(response);
			}
		});
	}

	$(document).on("pageshow", "#directions",function(){
			directionsDisplay = new google.maps.DirectionsRenderer();
			var userLocation = new google.maps.LatLng(latitude, longitude);
			var mapOptions = {
				zoom:14,
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				center: userLocation
			}
			map = new google.maps.Map(document.getElementById('map_canvas'), mapOptions);
			directionsDisplay.setMap(map);
			directionsDisplay.setPanel(document.getElementById('directions-panel'));
			showDirections(google.maps.DirectionsTravelMode.DRIVING);
			$("#drivingButton").click();
	});	
	
	
	function selectClosestTheater(){
		navigator.geolocation.getCurrentPosition(function(position){ //success
			latitude = position.coords.latitude;
			longitude = position.coords.longitude;
			timestamp = position.timestamp;
			//alert("Location aquired:\n"+latitude+" "+longitude+"\n@ "+timestamp);
			for(var x = 0; x < theaterData.theaters.length; x++){
				var theater = theaterData.theaters[x];
				var distance = getDistance(latitude, longitude, theater.geo.lat, theater.geo.long);
				theaterData.theaters[x].distance = distance;
			}
			theaterData.theaters.sort(compareDistances);
			closestTheater = theaterData.theaters[0];
			_gaq.push(['_trackEvent', "qr", "ad_scan", (""+latitude+","+longitude) ]);  
			var dt = new Date();
			dt.setTime(timestamp);
			$("#latLong").html("<div class='theaterName'>"+closestTheater.name+"</div><p class='theaterAddress'><a href='#directions'>"+closestTheater.address+"<br/>"+closestTheater.city+", "+closestTheater.state+" "+closestTheater.zip+"</a></p><p class='theaterPhone'><a href='tel:"+closestTheater.phone+"'>"+closestTheater.phone+"</a></p>");
			$("#showing").load("fullshowtimes.php #showing li", function(){
				$("#showing").listview('refresh');
			});
		},
		function(error){ //error 
			$("#findTheaterForm").show();
			$("#finding").hide();
			switch(error.code) 
			{
				case error.TIMEOUT:
					$("#latLong").prepend("<div class='ui-bar-e'>Unable to get your position: Timeout</div>");
					break;
				case error.POSITION_UNAVAILABLE:
					$("#latLong").prepend("<div class='ui-bar-e'>Unable to get your position: Position unavailable</div>");
					break;
				case error.PERMISSION_DENIED:
					$("#latLong").prepend("<div class='ui-bar-e'>Unable to get your position: Permission denied. You may want to check your settings.</div>");
					break;
				case error.UNKNOWN_ERROR:
					$("#latLong").prepend("<div class='ui-bar-e'>Unkonwn error while trying to access your position.</div>");
					break;
			}	
		},{maximumAge:600000});
	}

	
</script>
</body>
</html>
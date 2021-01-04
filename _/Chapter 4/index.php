<?php 
	$documentTitle = "Dickinson Theaters";
	
	$headerLeftHref = "/";
	$headerLeftLinkText = "Home";
	$headerLeftIcon = "home";
	
	$headerTitle = "";

	$headerRightHref = "tel:8165077438";
	$headerRightLinkText = "Call";
	$headerRightIcon = "grid";
	
	$fullSiteLinkHref = "/";
	
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
		.movieListings .ui-li-link-alt .ui-btn{ 
			display:none; 
		}
		.movieListings .ui-li-link-alt .ui-btn-inner{ 
			background-image:url(icons/icons-gray/46-movie-2.png);
			background-repeat:no-repeat;
			background-size:20px 25px;
			background-position:10px center;
			border-radius:none;
		}
		.theaterName{font-size:120%; font-weight:bold;}
	</style>
</head>

<body>
<div data-role="page">
    <div class="logoContainer ui-shadow"></div>
    <a href="moviedetails.php?id=194335"><img width="100%" src="images/DKR_VENUE.jpeg" ></a>
    <div data-role="content">
    	<div style="margin-top:-5px; margin-bottom:30px;" id="latLong">
    	<p><a href="javascript://" onClick="selectClosestTheater();" data-role="button">Find Show Times</a></p>
        </div>
        <p>
        	<ul id="showing" data-role="listview" class="movieListings" data-dividertheme="g">
            	<li data-role="list-divider"><h2>Opening This Week</h2></li>
            	<li>
                	<a href="movie.php?id=193818">
                    	<img src="images/darkknightrises.jpeg">
                		<h3>Dark Knight Rises</h3>
                        <p>PG-13 - 2h 20m</p>
                	</a>
                    <a href="http://www.youtube.com/watch?v=J9DlV9qwtF0"></a>
                </li>
            	<li>
                	<a href="moviedetails.php?id=193812">
                    	<img src="images/iceagecontinentaldrift.jpeg">
                		<h3>Ice Age 4: Continental Drift</h3>
                        <p>PG - 1h 56m</p>
                	</a>
                    <a href="http://www.youtube.com/watch?v=J9DlV9qwtF0"></a>
                </li>
                <li data-role="list-divider"><h2>Also in Theaters</h2></li>
            	<li>
                	<a href="moviedetails.php?id=194103">
                    	<img src="images/savages.jpeg">
                		<h3>Savages</h3>
                        <p>R - 7/6/2012</p>
                	</a>
                    <a href="http://www.youtube.com/watch?v=J9DlV9qwtF0"></a>
                </li>
            	<li>
                	<a href="moviedetails.php?id=194226">
                    	<img src="images/katyperrypartofme.jpeg">
                		<h3>Katy Perry: Part of Me</h3>
                        <p>PG - 7/5/2012</p>
                	</a>
                    <a href="http://www.youtube.com/watch?v=J9DlV9qwtF0"></a>
                </li>
            	<li>
                	<a href="moviedetails.php?id=193807">
                    	<img src="images/amazingspiderman.jpeg">
                		<h3>Amazing Spider-Man</h3>
                        <p>PG-13 - 7/5/2012</p>
                	</a>
                    <a href="http://www.youtube.com/watch?v=J9DlV9qwtF0"></a>
                </li>
            </ul>
        </p>
    </div>
    
    <?php include("includes/footer.php"); ?>
</div>
<script type="text/javascript">
	// Request a position. We accept positions whose age is not
    // greater than 10 minutes. If the user agent does not have a
    // fresh enough cached position object, it will automatically
    // acquire a new one.
	var theaterData = $.getJSON("js/theaters.js", function(data){
		theaterData = data;
	});
	
	var timestamp = null;
	var latitude = null;
	var longitutde = null;
	var closestTheater = null;
	
	
	function selectClosestTheater(){
		navigator.geolocation.watchPosition(function(position){
			latitude = position.coords.latitude;
			longitutde = position.coords.longitude;
			timestamp = position.timestamp;
			for(var x = 0; x < theaterData.theaters.length; x++){
				var theater = theaterData.theaters[x];
				var distance = getDistance(latitude, longitutde, theater.geo.lat, theater.geo.long);
				theaterData.theaters[x].distance = distance;
			}
			theaterData.theaters.sort(compareDistances);
			closestTheater = theaterData.theaters[0];
			var dt = new Date();
			dt.setTime(timestamp);
			$("#latLong").html("<div class='theaterName'>"+closestTheater.name+"</div><strong>"+closestTheater.distance.toFixed(2)+" miles</strong><br/>"+closestTheater.address+"<br/>"+closestTheater.city+", "+closestTheater.state+" "+closestTheater.zip+"<br/><a href='tel:"+closestTheater.phone+"'>"+closestTheater.phone+"</a>");
			$.ajax({
				url:"showtimes.php", 
				success: function(data, textStatus, jqXHR){
					$("#showing").html(data).listview('refresh');
				}
			});
		},
		function(error){
			switch(error.code) 
			{
				case error.TIMEOUT:
					//alert ('Timeout');
					break;
				case error.POSITION_UNAVAILABLE:
					//alert ('Position unavailable');
					break;
				case error.PERMISSION_DENIED:
					//alert ('Permission denied');
					break;
				case error.UNKNOWN_ERROR:
					alert ('Unknown error');
					break;
			}		
		},{maximumAge:600000});
	}
	

	

	
</script>
</body>
</html>

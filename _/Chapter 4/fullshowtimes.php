<?php 
	$documentTitle = "Showtimes | Northglen 16 Theatre";
	
	$headerLeftHref = "/";
	$headerLeftLinkText = "Home";
	$headerLeftIcon = "home";
	
	$headerTitle = "";

	$headerRightHref = "tel:8165555555";
	$headerRightLinkText = "Call";
	$headerRightIcon = "grid";
	
	$fullSiteLinkHref = "/";
	
?>
<!DOCTYPE html>
<html>
<head>
	<?php include("includes/meta.php"); ?> 
</head>

<body>
<div id="qrfindclosest" data-role="page">
    <div class="logoContainer ui-shadow"></div>
    <div data-role="content">
	   	<h3>Northglen 14 Theatre</h3>
        
        <p><a href="https://maps.google.com/maps?q=Northglen+14+Theatre,+Northeast+80th+Street,+Kansas+City,+MO&hl=en&sll=38.304661,-92.437099&sspn=7.971484,8.470459&oq=northglen+&t=h&hq=Northglen+14+Theatre,&hnear=NE+80th+St,+Kansas+City,+Clay,+Missouri&z=15">4900 N.E. 80th Street<br>
        Kansas City, MO 64119</a></p>
        
        <p><a href="tel:8164681100">816-468-1100</a></p>
        
        <p>
        	<ul id="showing" data-role="listview" class="movieListings" data-dividertheme="g">
            	<?php include("showtimes.php"); ?>
            </ul>
        </p>
    </div>
    <?php include("includes/footer.php"); ?>
</div>
</body>
</html>
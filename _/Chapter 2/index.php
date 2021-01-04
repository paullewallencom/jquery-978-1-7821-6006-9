<?php 
	$documentTitle = "Nicky's Pizza";
	
	$headerLeftHref = "/";
	$headerLeftLinkText = "Home";
	$headerLeftIcon = "home";
	
	$headerTitle = "Boilerplate";

	$headerRightHref = "tel:8165077438";
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
<div data-role="page">
    <div data-role="content">
    	
    	<div class="logoContainer"><img src="images/LogoMobile.png" alt="Logo" width="290" style="margin:0" /></div>

        <div class="homeMenu">
            <a class="glyphishIcon" href="http://maps.google.com/maps?q=9771+N+Cedar+Ave,+Kansas+City,+MO+64157&hl=en&sll=39.20525,-94.526954&sspn=0.014499,0.033002&hnear=9771+N+Cedar+Ave,+Kansas+City,+Missouri+64157&t=m&z=17&iwloc=A" data-role="button" data-icon="directions" data-inline="true" data-iconpos="top">Map it</a>
            <a class="glyphishIcon" href="tel:+18167816500" data-role="button" data-inline="true" data-icon="iphone" data-iconpos="top">Call Us</a>
            <a class="glyphishIcon" href="https://touch.facebook.com/nickyspizzanickyspizza" data-role="button" data-icon="facebook" data-iconpos="top" data-inline="true">Like Us</a>
            <a class="glyphishIcon" href="menu.php" data-role="button" data-inline="true" rel="external" data-icon="utensils" data-iconpos="top">Menu</a>
        </div>

        <h3>What customers are saying:</h3>
        <div class="testimonials">
            <ul class="curl">
                <li><img class="facebook" src="images/fb2.jpg" alt="facebook photo" width="60" height="60" align="left" />I recommend the Italian Sausage Sandwich. Awesome!! Will be back soon!</li>
                <li><img class="facebook" src="images/fb0.jpg" alt="facebook photo" width="60" height="60" align="left" />LOVED your veggie pizza friday night and the kids devoured the cheese with jalapenos!!! salad was fresh and yummy with your house dressing!!</li>
                <li><img class="facebook" src="images/fb1.jpg" alt="facebook photo" width="60" height="60" align="left" />The Clarkes love Nicky's pizza! So happy you are here in liberty.</li>
            </ul>
        </div>
        
    </div>
    
    <?php include("includes/footer.php"); ?>
</div>

</body>
</html>

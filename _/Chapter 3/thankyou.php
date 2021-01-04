<!DOCTYPE html>
<html>
<?php 
	$documentTitle = "Menu | Nicky's Pizza";
	
	$headerLeftHref = "index.php";
	$headerLeftLinkText = "Home";
	$headerLeftIcon = "home";

	$headerRightHref = "tel:8165077438";
	$headerRightLinkText = "Call";
	$headerRightIcon = "grid";
	
	$fullSiteLinkHref = "/index.php";
?>
<head>
	<?php include("includes/meta.php"); ?>
</head>

<body>
<div data-role="page" id="orderthankyou">
	<?php 
		$headerTitle = "Thank you"; 
		include("includes/header.php"); 
	?>
    <div data-role="content" >
        <h2>Thank you for your order. </h2>
        <p>In a few minutes, you should receive an email confirming your order with an estimated delivery time.</p>
        
        <script type="text/javascript">
			$("#orderthankyou").live('pageshow', function(){
				_gaq.push(['_addTrans',
					'1234',            // order ID - required
					'Mobile Checkout', // affiliation or store name
					'21.99',           // total - required
					'1.29',            // tax
					'',                // shipping
					'Kansas City',     // city
					'MO',              // state or province
					'USA'              // country
				]);
				_gaq.push(['_trackTrans']); //submits transaction to the Analytics servers
			});
        </script>
    </div>
    <?php include("includes/footer.php"); ?>
</div>

</body>
</html>

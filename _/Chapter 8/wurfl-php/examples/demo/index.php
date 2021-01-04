<?php
// Move the configuration and initialization to the tip so you can use it in the head.

// Include the configuration file
include_once './inc/wurfl_config_standard.php';

$wurflInfo = $wurflManager->getWURFLInfo();

if (isset($_GET['ua']) && trim($_GET['ua'])) {
	$ua = $_GET['ua'];
	$requestingDevice = $wurflManager->getDeviceForUserAgent($_GET['ua']);
} else {
	$ua = $_SERVER['HTTP_USER_AGENT'];
	// This line detects the visiting device by looking at its HTTP Request ($_SERVER)
	$requestingDevice = $wurflManager->getDeviceForHttpRequest($_SERVER);
}
?>
<html>
<head>
	<title>WURFL PHP API Example</title>
    <?php if($requestingDevice->getCapability('mobile_browser') !== ""){ ?>
	    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
        <script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
	<?php } ?>
</head>
<body>
<div data-role="page">
    <div data-role="header">
    	<h1>WURFL XML INFO</h1>
    </div>
	<div data-role="content" id="content">
		<h4>VERSION: <?php echo $wurflInfo->version; ?> </h4>
		<p>User Agent: <b> <?php echo htmlspecialchars($ua); ?> </b></p>
		<ul data-role="listview">
        	<li data-role="list-divider">
        	  <h2>Very Useful</h2></li>
			<li>Brand Name: <?php echo $requestingDevice->getCapability('brand_name'); ?> </li>
			<li>Model Name: <?php echo $requestingDevice->getCapability('model_name'); ?> </li>
            <li>Is Wireless Device: <?php echo $requestingDevice->getCapability('is_wireless_device'); ?></li>
            <li>Mobile: <?php if($requestingDevice->getCapability('mobile_browser') !== ""){
				echo "true";
			}else{
				echo "false";
			}; ?></li>
            <li>Tablet: <?php echo $requestingDevice->getCapability('is_tablet'); ?> </li>
            <li>Pointing Method: <?php echo $requestingDevice->getCapability('pointing_method'); ?> </li>
			<li>Resolution Width: <?php echo $requestingDevice->getCapability('resolution_width'); ?> </li>
			<li>Resolution Height: <?php echo $requestingDevice->getCapability('resolution_height'); ?> </li>
			<li>Marketing Name: <?php echo $requestingDevice->getCapability('marketing_name'); ?> </li>
			<li>Preferred Markup: <?php echo $requestingDevice->getCapability('preferred_markup'); ?> </li>
			<li data-role="list-divider"><h2>All Capabilities</h2></li>
        <?php foreach(array_keys($requestingDevice->getAllCapabilities()) as $capabilityName){ ?>
        	<li><?php echo "<h3>".$capabilityName."</h3><p>".$requestingDevice->getCapability($capabilityName)."</p>"; ?></li>
        <?php } ?>
        </ul>
		<p><b>Query WURFL by providing the user agent:</b></p>
		<form method="get" action="index.php">
			<div>User Agent: <input type="text" name="ua" size="100" value="<?php echo isset($_GET['ua'])? htmlspecialchars($_GET['ua']): ''; ?>" />
			<input type="submit" value="submit" /></div>
		</form>
	</div>
</div>
</body>
</html>
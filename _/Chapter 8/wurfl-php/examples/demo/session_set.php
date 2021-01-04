<?php
session_start();

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

// store session data
$_SESSION['wurflData']=$requestingDevice;
$_SESSION['modernizrData']=$_POST['modernizrData'];
	
$i = 0;
$capabilities = $requestingDevice->getAllCapabilities();
$countCapabilities = count($capabilities);
?>
{ "wurflData":
<?php 
	//echo json_encode($capabilities);
	foreach(array_keys($capabilities) as $capabilityName){ 
		$capability = $requestingDevice->getCapability($capabilityName);
		$isString = true;
		if($capability == "true" || $capability == "false" || is_numeric($capability)){
			$isString = false;
		}
		echo "\"".$capabilityName."\":".(($isString)?"\"":"").$requestingDevice->getCapability($capabilityName).(($isString)?"\"":""); 
		if(($i + 1) < $countCapabilities){
			echo ",\n"; 
		}
		$i++;
	} 
		
?>
}
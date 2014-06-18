<?php
//Mobile Detection
require_once 'mobileDetect.php';
$mobileDetect = new Mobile_Detect;

if ( $mobileDetect->isMobile() ) {
	$_SESSION['is_mobile'] = "True";	
} else {
	$_SESSION['is_mobile'] = "False";	
}

//FileSystem Location
if (!isset($systemFileRoot)) {
	$systemFileRoot = $_SERVER['DOCUMENT_ROOT'];
	$SYSTEM['system_fileroot'] = $systemFileRoot;
}



//UI Renderering
function renderUIHeader() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	if ($_SESSION['is_mobile'] = "True") { 
		include($SYSTEM['system_fileroot'].'/ikiosk/includes/gui/mobileHeader.php'); 
	} else {
		include($SYSTEM['system_fileroot'].'/ikiosk/includes/gui/desktopHeader.php'); 
	}
}

function renderUIFooter() {
	if ($_SESSION['is_mobile'] = "True") { 
		include($SYSTEM['system_fileroot'].'/ikiosk/includes/gui/mobileFooter.php'); 
	} else {
		include($SYSTEM['system_fileroot'].'/ikiosk/includes/gui/desktopFooter.php'); 
	}	
}
?>
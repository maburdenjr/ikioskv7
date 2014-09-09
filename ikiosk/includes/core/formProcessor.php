<?php
$PAGE['track'] = "No";
$PAGE['application_code'] = isset($_POST['appCode']) ? $_POST['appCode'] : $_GET['appCode'];
require('../../includes/core/ikiosk.php');

$refresh = 'var iLocation = location.hash.replace(/^#/, ""); ';
$refresh .= 'var iContainer = $("#content"); ';
$refresh .= 'loadURL(iLocation, iContainer); ';

$ajaxRefresh = "var a = location.hash.replace(/^#/, \"\");\r\n";
$ajaxRefresh .= "loadURL(a, $('#content'));\r\n";
$ajaxRefresh .= "$('.modal').modal('hide');\r\n";
$ajaxRefresh .= "$('.modal-backdrop').remove(); \r\n";


$app_ajax = array();
//Get All Master Applications
mysql_select_db($database_ikiosk, $ikiosk);
$query_mainMenu = "SELECT * FROM sys_applications WHERE application_type = 'Application' AND application_status = 'Active' AND deleted = '0' ORDER BY application_title";
$mainMenu = mysql_query($query_mainMenu, $ikiosk) or sqlError(mysql_error());
$row_mainMenu = mysql_fetch_assoc($mainMenu);
$totalRows_mainMenu = mysql_num_rows($mainMenu);

do {
mysql_select_db($database_ikiosk, $ikiosk);
$query_securityMatch = "SELECT * FROM sys_permissions WHERE user_id = '".$_SESSION['user_id']."'";
$securityMatch = mysql_query($query_securityMatch, $ikiosk) or sqlError(mysql_error());
$row_securityMatch = mysql_fetch_assoc($securityMatch);
$totalRows_securityMatch = mysql_num_rows($securityMatch);	

$gpsMatrix = $row_mainMenu['application_code'];
if ($row_securityMatch[$gpsMatrix] >= $row_mainMenu['application_clearance']) {
	
	$menufile = $SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root'].$row_mainMenu['application_root']."/ajaxHandler.php";
	
	if (file_exists($menufile)) {require($menufile);}
}
} while ($row_mainMenu  = mysql_fetch_assoc($mainMenu));
?>

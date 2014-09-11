<?php
$PAGE['track'] = "No";
$PAGE['application_code'] = isset($_POST['appCode']) ? $_POST['appCode'] : $_GET['appCode'];
require('ikiosk-tmp-core'); // Load iKiosk Core Files

$SITE['site_id'] = "ikiosk_tmp_site";

//Load Site Properties
mysql_select_db($database_ikiosk, $ikiosk);
$query_getSite = "SELECT * FROM sys_sites WHERE site_id = '".$SITE['site_id']."' AND deleted = '0'";
$getSite = mysql_query($query_getSite, $ikiosk) or sqlError(mysql_error());
$SITE =  mysql_fetch_assoc($getSite);
$totalRows_getSite = mysql_num_rows($getSite);

$_SESSION['site_id'] = $SITE['site_id'];
if (empty($_SESSION['user_id'])) {
	$USER['user_timezone'] = $SITE['site_timezone'];
	$USER['user_dateformat'] = $SITE['site_dateformat'];
}

// Begin AJAX Post Wrapper ###########################################################################
if ((isset($_POST["iKioskForm"])) && ($_POST["iKioskForm"] == "Yes")) {

//Begin Login
if ((isset($_POST["formID"])) && ($_POST["formID"] == "cmsUILogin")) {
	
	$formlogin = addslashes($_POST['login_email']);
	$formpassword = addslashes(md5($_POST['password']));
			
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_checkpermissions = "SELECT * FROM sys_users WHERE login_email = '".$formlogin."' AND login_password_hash = '".$formpassword."' AND deleted = '0'";
	$checkpermissions = mysql_query($query_checkpermissions, $ikiosk) or sqlError(mysql_error());
	$row_checkpermissions = mysql_fetch_assoc($checkpermissions);
	$totalRows_checkpermissions = mysql_num_rows($checkpermissions);
	
	if ($totalRows_checkpermissions == "0") {
			displayAlert("danger", "Your login and password combination is invalid. Please try again.");
			exit;
	}
	if (($row_checkpermissions['user_status'] != "Active") && ($totalRows_checkpermissions != "0"))  {
			displayAlert("danger", "We're sorry but your account has been deactivated.");
			exit;
	}
	if (($row_checkpermissions['user_status'] == "Active") && ($totalRows_checkpermissions != "0"))  {
			$_SESSION['user_id'] = $row_checkpermissions['user_id'];
			$_SESSION['site_id'] = $_POST['site_id'];
			$js = "window.location = \"/index.html\";\r\n";
			insertJS($js);
			exit;
	}
	
} // End Login	

} // End Post WRAP
?>
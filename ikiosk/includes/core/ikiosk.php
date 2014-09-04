<?php
//Start Sessions
ob_start();
session_start();
error_reporting(E_ERROR | E_PARSE);

//Default System Variables
$SYSTEM = array();
$SITE = array();
$USER = array(); 
$APPLICATION = array();

//Load Core Functions
require('db_conn.php');  
require('coreFunctions.php'); 
require('cms.php'); 

//Load System Properties
mysql_select_db($database_ikiosk, $ikiosk);
$query_sysConfig = "SELECT * FROM sys_config";
$sysConfig = mysql_query($query_sysConfig, $ikiosk) or sqlError(mysql_error());
$SYSTEM = mysql_fetch_assoc($sysConfig);
$totalRows_sysConfig = mysql_num_rows($sysConfig);

$SYSTEM['ikiosk_docroot'] = $SYSTEM['ikiosk_filesystem_root']."/ikiosk";

//Extend Libraries
require($SYSTEM['ikiosk_docroot'].'/includes/ext/phpmailer/class.phpmailer.php'); // PHP Mailer
require($SYSTEM['ikiosk_docroot'].'/includes/ext/google/library/api/src/apiClient.php'); // Google API
require($SYSTEM['ikiosk_docroot'].'/includes/ext/google/library/api/src/contrib/apiAnalyticsService.php'); 

//System Assets
$iKioskPos = strpos($_SERVER['PHP_SELF'], "/ikiosk/");
$iKioskAssetRoot = substr($_SERVER['PHP_SELF'], 0, $iKioskPos); 
$SYSTEM['html_root'] = $SYSTEM['system_url'];

// Set Default Page
$init_currentpage = $_SERVER['PHP_SELF'];
if (!empty($_SERVER['QUERY_STRING'])) { 
$SYSTEM['current_page'] = $init_currentpage."?".$_SERVER['QUERY_STRING'];
$SYSTEM['ajax_url'] = "index.php?".$_SERVER['QUERY_STRING']."#".str_replace("/ikiosk/", "", $init_currentpage);
} else {
$SYSTEM['current_page'] = $init_currentpage."?v=0";
}

//Set MySQL Time
$mySQLDate = strtotime(date("Y-m-d G:i:s"));
$SYSTEM['mysql_datetime'] = date("Y-m-d H:i:s", $mySQLDate);

//IntelliKiosk Cloud URL
$SYSTEM['ikiosk_cloud'] = "http://apps.ikioskcloudapps.com";
$SYSTEM['ikiosk_resource_cloud'] = "http://shared.ikioskcloudapps.com";
$SYSTEM['active_users'] = userCount();
$SYSTEM['active_sites'] = siteCount();

//Testing
if (($_SERVER['HTTP_HOST'] == "http://10.33.66.213:81") || ($_SERVER['HTTP_HOST'] == "testsite")) {
$SYSTEM['ikiosk_cloud'] = "http://10.33.66.213:81";	
$SYSTEM['ikiosk_resource_cloud']  = "http://10.33.66.213:81/ikiosk/library";
}

//User Login Handling
if ((isset($_POST["ikioskSubmit"])) && ($_POST["ikioskSubmit"] == "MasterLogin")) {
	
	$formlogin = addslashes($_POST['loginemail']);
	$formpassword = addslashes(md5($_POST['password']));
			
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_checkpermissions = "SELECT * FROM sys_users WHERE login_email = '".$formlogin."' AND login_password_hash = '".$formpassword."' AND deleted = '0'";
	$checkpermissions = mysql_query($query_checkpermissions, $ikiosk) or sqlError(mysql_error());
	$row_checkpermissions = mysql_fetch_assoc($checkpermissions);
	$totalRows_checkpermissions = mysql_num_rows($checkpermissions);
	
	if ($totalRows_checkpermissions == "0") {
				header("Location: ".$SYSTEM['html_root']."/ikiosk/error.php?error=4");
				exit;
	}
	if (($row_checkpermissions['user_status'] != "Active") && ($totalRows_checkpermissions != "0"))  {
				header("Location: ".$SYSTEM['html_root']."/ikiosk/error.php?error=5");
				exit;
	}
	if (($row_checkpermissions['user_status'] == "Active") && ($totalRows_checkpermissions != "0"))  {
		$_SESSION['user_id'] = $row_checkpermissions['user_id'];
				header("Location: ".$SYSTEM['html_root']."/ikiosk/index.php");
				exit;
	}
	
	ikiosk_db_update();
	
	if(!empty($_POST['redirect'])) {
			header("Location:".$SYSTEM['html_root']."/ikiosk".$_POST['redirect']);
			exit;
	}
	
}

//Load Application Properties
mysql_select_db($database_ikiosk, $ikiosk);
$query_applicationCheck = "SELECT * FROM sys_applications WHERE application_code = '".$PAGE['application_code']."' AND deleted = '0' AND application_status = 'Active'";
$applicationCheck = mysql_query($query_applicationCheck, $ikiosk) or sqlError(mysql_error());
$APPLICATION = mysql_fetch_assoc($applicationCheck);
$totalRows_applicationCheck = mysql_num_rows($applicationCheck);

if (($totalRows_applicationCheck == "0") && ($PAGE['application_code'] != "IKIOSK")) {
	header("Location: ".$SYSTEM['html_root']."/ikiosk/error.php?error=1");
	exit;
}

//Defaults for Public Applications
if ($PAGE['application_code'] == "IKIOSK") {
	$APPLICATION['application_code'] = "IKIOSK";
	$APPLICATION['application_title'] = "IntelliKiosk";
	$APPLICATION['application_security'] = "public";
	$APPLICATION['application_clearance'] = "100";	
}

//Security Defaults
$_SESSION['gpsControl'] = "100";
$teamFilter = " team_id = '1' ";
$siteFilter = " site_id = '1' ";

//Load User Profile
if (!empty($_SESSION['user_id'])) {
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_userProfile = "SELECT * FROM sys_users WHERE user_id = '".$_SESSION['user_id']."'";
	$userProfile = mysql_query($query_userProfile, $ikiosk) or sqlError(mysql_error());
	$USER = mysql_fetch_assoc($userProfile);
	$totalRows_userProfile = mysql_num_rows($userProfile);
    
	if ($totalRows_userProfile == "0") {
		$USER = array();
	} else {
		
		//Load User Security Profile
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_moduleSecurity = "SELECT * FROM sys_permissions WHERE user_id = '".$_SESSION['user_id']."'";
		$moduleSecurity = mysql_query($query_moduleSecurity, $ikiosk) or sqlError(mysql_error());
		$row_moduleSecurity = mysql_fetch_assoc($moduleSecurity);
		$totalRows_moduleSecurity = mysql_num_rows($moduleSecurity);
		
		$_SESSION['gpsControl'] = $row_moduleSecurity[$APPLICATION['application_code']];	
		
		//Team Security Profile
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_teamSecurity = "SELECT * FROM sys_users2teams WHERE user_id = '".$_SESSION['user_id']."' AND deleted = '0'";
		$teamSecurity = mysql_query($query_teamSecurity, $ikiosk) or sqlError(mysql_error());
		$row_teamSecurity = mysql_fetch_assoc($teamSecurity);
		$totalRows_teamSecurity = mysql_num_rows($teamSecurity);
		
		if ($totalRows_teamSecurity != "0") {
			$messageFilter_team = "((recipient_type = 'team' AND (recipient_id = '1'";
			do {
			$teamFilter .= " OR team_id = '".$row_teamSecurity['team_id']."' ";
			$messageFilter_team .= " OR recipient_id = '".$row_teamSecurity['team_id']."' "; 
			} while ($row_teamSecurity = mysql_fetch_assoc($teamSecurity));
			$messageFilter_team .= "))";
		}
		$SYSTEM['message_filter'] .= $messageFilter_team;
		
		//Site Security Profile
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_siteSecurity = "SELECT * FROM sys_users2sites WHERE user_id = '".$_SESSION['user_id']."' AND deleted = '0'";
		$siteSecurity = mysql_query($query_siteSecurity, $ikiosk) or sqlError(mysql_error());
		$row_siteSecurity = mysql_fetch_assoc($siteSecurity);
		$totalRows_siteSecurity = mysql_num_rows($siteSecurity);
	
		if ($totalRows_siteSecurity != "0") {
			$messageFilter_site = " OR (recipient_type = 'site' AND (recipient_id = '1'";
			do {
			$siteFilter .= " OR site_id = '".$row_siteSecurity['site_id']."' ";
			$messageFilter_site .= " OR recipient_id = '".$row_siteSecurity['site_id']."' "; 
			} while ($row_siteSecurity = mysql_fetch_assoc($siteSecurity));
			$messageFilter_site .= "))";
		}
		$SYSTEM['message_filter'] .= $messageFilter_site;
	}
	
} else {
	$USER['user_id'] = "ikiosk-visitor";
	$USER['display_name'] = "Visitor";
	$USER['is_admin'] = "No";
	$USER['user_timezone'] = getUserData("sys-admin", "user_timezone");
	$USER['user_dateformat'] = getUserData("sys-admin", "user_dateformat");
	
}


# Set accessControl for Team-Regulated Data
$_SESSION['team_filter'] = " (".$teamFilter.") ";
$_SESSION['site_filter'] = " (".$siteFilter.") ";

//Modifiy message filter 
$SYSTEM['message_filter'] .= " OR (recipient_type = 'user' AND recipient_id = '".$_SESSION['user_id']."') OR (recipient_type = 'system'))";

//Process Application Security

//Registerd Users
if (($APPLICATION['application_security'] == "registered") && ($USER['user_id'] == "ikiosk-visitor")) {
	header ("Location: ".$SYSTEM['html_root']."/ikiosk/login.php");
	exit;	
}

//Admin User
if (($APPLICATION['application_security'] == "admin") && ($USER['is_admin'] == "No")) {
	header ("Location: ".$SYSTEM['html_root']."/ikiosk/error.php?error=7&redirect=".$SYSTEM['current_page']);
	exit;	
}

//Application Clearance
if ($_SESSION['gpsControl'] < $APPLICATION['application_clearance']) {
	header ("Location: ".$SYSTEM['html_root']."/ikiosk/error.php?error=8");
	exit;
}

if (((empty($_SESSION['gpsControl'])) || ($_SESSION['gpsControl'] == "000") || ($_SESSION['gpsControl'] == "00") || ($_SESSION['gpsControl'] == "0"))){
	header ("Location: ".$SYSTEM['html_root']."/ikiosk/error.php?error=8");
	exit;
}

//Rapid Site Switching
if (($_GET['switchSite'] = "1") && (!empty($_GET['site_id']))) {
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_siteProfile = "SELECT * FROM sys_sites WHERE site_id = '".$_GET['site_id']."' AND ".$_SESSION['site_filter']." AND deleted = '0'";
	$siteProfile = mysql_query($query_siteProfile, $ikiosk) or sqlError(mysql_error());
	$row_siteProfile = mysql_fetch_assoc($siteProfile);
	$totalRows_siteProfile = mysql_num_rows($siteProfile);
	
	if ($totalRows_siteProfile != "0") {
		$_SESSION['site_id'] = $_GET['site_id'];
		$SYSTEM['alert_message'] = "<div class=\"notification success\">Active site changed to: ".$row_siteProfile['site_name']."</div>";
	} else {
		$SYSTEM['alert_message'] = "<div class=\"notification error\">Unable to switch to desired site.  Please contact your system administrator for additional information.</div>";
	}
	
	//Remove Extra Variables
	$SYSTEM['current_page'] = str_replace("&switchSite=1", "", $SYSTEM['current_page']);
	$SYSTEM['current_page'] = str_replace("&site_id=".$_GET['site_id'], "", $SYSTEM['current_page']);
	
}

//Load Default Site Profile
if (empty($_SESSION['site_id'])) {
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_siteProfile = "SELECT * FROM sys_sites WHERE site_id != '' AND ".$_SESSION['site_filter']." AND deleted = '0'";
	$siteProfile = mysql_query($query_siteProfile, $ikiosk) or sqlError(mysql_error());
	$SITE = mysql_fetch_assoc($siteProfile);
	$totalRows_siteProfile = mysql_num_rows($siteProfile);
		
	if ($totalRows_siteProfile == "0") {
		$SITE = array();
	} else {
		$_SESSION['site_id'] = $SITE['site_id'];	
	}
}


//Load Active Site Profile
if (!empty($_SESSION['site_id'])) {
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_siteProfile = "SELECT * FROM sys_sites WHERE site_id = '".$_SESSION['site_id']."' AND ".$_SESSION['site_filter']." AND deleted = '0'";
	$siteProfile = mysql_query($query_siteProfile, $ikiosk) or sqlError(mysql_error());
	$SITE = mysql_fetch_assoc($siteProfile);
	$totalRows_siteProfile = mysql_num_rows($siteProfile);
	
	if ($totalRows_siteProfile == "0") {
		$SITE = array();
	}
	$SITE['file_root'] = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root'];
}

$appStatus = checkApp("CMS");
if ($appStatus == "Active") {
	//Load CMS Properties
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_cmsSettings = "SELECT * FROM cms_config WHERE site_id = '".$_SESSION['site_id']."' AND deleted = '0'";
	$cmsSettings = mysql_query($query_cmsSettings, $ikiosk) or sqlError(mysql_error());
	$CMS = mysql_fetch_assoc($cmsSettings);
	$totalRows_cmsSettings = mysql_num_rows($cmsSettings);
}


//Active Site Filter
$SYSTEM['active_site_filter'] = $_SESSION['team_filter']." AND ".$_SESSION['site_filter']." AND site_id = '".$_SESSION['site_id']."'";


//Force SSL Connection
if ($SITE['force_ssl'] == "Yes") {
	if($_SERVER['SERVER_PORT'] == 80) { 
	header("Location:https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."");
	exit;
	}
}

//Access Log
if ( $PAGE['track'] != "No") {
	accessLog("System");	
}

//Inline Debugging
if ($USER['user_type'] == "iKiosk Admin") {
	$SYSTEM['debug'] = "Yes";	
}

//License Expired
if (isset($_SESSION['license_expired']) && ($_SESSION['license_expired'] == "Yes")  && ($PAGE['application_code'] != "IKIOSK")  && ($_SESSION['user_id'] != "sys-admin")) {
	header ("Location: ".$SYSTEM['html_root']."/ikiosk/error.php?error=3");
	exit;	
}

//Automated 24hr Backups
auto_backup();

//Version Overide
$SYSTEM['ikiosk_version'] = "7.0.0";

//Site Assets
$sitePos = strpos($_SERVER['PHP_SELF'], "/sites/");
$siteAssetRoot = substr($_SERVER['PHP_SELF'], 0, $sitePos); 
if ($sitePos != 0) {
	$SYSTEM['site_html_root'] = $siteAssetRoot."/sites".$SITE['site_root'];
}

if ($_GET['sys_action'] == "dbupdate") {
	ikiosk_db_update();	
}

?>
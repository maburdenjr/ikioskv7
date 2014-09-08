<?php
/* 
IntelliKiosk 6.x Core 
Copyright (C) 2011 Interactive Remix, LLC.
*/

$PAGE['application_code'] = "IKIOSK";
$PAGE['include_header']  = "No"; 

require('../../ikiosk/includes/core/ikiosk.php'); // Load iKiosk Core Files


if (isset($_GET['ikiosk_id']) && isset($_GET['ikiosk_license_key']) && isset($_GET['template_id'])) {
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM ikioskcloud_licenses WHERE deleted = '0' AND status = 'Active' AND ikiosk_id = '".$_GET['ikiosk_id']."' AND ikiosk_license_key = '".$_GET['ikiosk_license_key']."'";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);	
	
	
	
	if ($totalRows_getRecord != 0) {

	//Get Template Information
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getTemplates = "SELECT * FROM ikioskcloud_templates WHERE status='Active' AND deleted = '0' AND license_type = 'Site Builder' and template_id='".$_GET['template_id']."'";
	$getTemplates = mysql_query($query_getTemplates, $ikiosk) or sqlError(mysql_error());
	$row_getTemplates = mysql_fetch_assoc($getTemplates);
	$totalRows_getTemplates = mysql_num_rows($getTemplates);
	
		if ($_GET['option'] == "setupFile") {
			$setupFile = urlFetch($SYSTEM['ikiosk_cloud']."/system32/cms_templates/".$row_getTemplates['local_folder']."/templateSetup.txt");
			echo $setupFile;
			exit;
		}
		
		if ($_GET['option'] == "setupForm") {
			$setupFile = urlFetch($SYSTEM['ikiosk_cloud']."/system32/cms_templates/".$row_getTemplates['local_folder']."/formSetup.txt");
			echo $setupFile;
			exit;
		}
	
	}
	
}
?>
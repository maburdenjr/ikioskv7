<?php
/* 
IntelliKiosk 6.x Core 
Copyright (C) 2011 Interactive Remix, LLC.
*/


$PAGE['application_code'] = "IKIOSK";
$PAGE['include_header']  = "No"; 

require('../../ikiosk/includes/core/ikiosk.php'); // Load iKiosk Core Files

//Returns a list of Downloadable Templates 

$templateList = "";

if (isset($_GET['ikiosk_id']) && isset($_GET['ikiosk_license_key'])) {
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM ikioskcloud_licenses WHERE deleted = '0' AND status = 'Active' AND ikiosk_id = '".$_GET['ikiosk_id']."' AND ikiosk_license_key = '".$_GET['ikiosk_license_key']."'";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);	
	
	//Get Template List
	if ($totalRows_getRecord != 0) {
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getTemplates = "SELECT * FROM ikioskcloud_templates WHERE status='Active' AND deleted = '0' AND license_type = '".$row_getRecord['license_type']."'";
		$getTemplates = mysql_query($query_getTemplates, $ikiosk) or sqlError(mysql_error());
		$row_getTemplates = mysql_fetch_assoc($getTemplates);
		$totalRows_getTemplates = mysql_num_rows($getTemplates);	
		
		//Get Template Details
		if ($totalRows_getTemplates != 0) {	
			$i = 1;
			do {
				
			$tmpThumbnail = displayImage($row_getTemplates['screenshot'], "image_thumbnail", "return");
			$tmpScreenshot = displayImage($row_getTemplates['screenshot'], "image_resized", "return");
			$siteID = displayImage($row_getTemplates['screenshot'], "site_id", "return");
			$siteRoot = getSiteData($siteID, "site_root");

			$templateList .= $row_getTemplates['template_id']."|".$row_getTemplates['template_title']."|".$row_getTemplates['description']."|".$row_getTemplates['category']."|".$row_getTemplates['version']."|".$row_getTemplates['date_created']."|".$row_getTemplates['date_modified']."|".$tmpThumbnail."|".$tmpScreenshot."|".$siteRoot;
			if ($i < $totalRows_getTemplates) { $templateList .= "[iKiosk]";}	
			$i++;
			} while ($row_getTemplates = mysql_fetch_assoc($getTemplates));			
		}
		
		echo $templateList;
	}
	
}
?>

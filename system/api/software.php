<?php
/* 
IntelliKiosk 6.x Core 
Copyright (C) 2011 Interactive Remix, LLC.
/index.php 

System Router
*/
$PAGE['application_code'] = "IKIOSK";
$PAGE['include_header']  = "No"; 

require('../../ikiosk/includes/core/ikiosk.php'); // Load iKiosk Core Files

$softwareList = "";

if (isset($_GET['ikiosk_id']) && isset($_GET['ikiosk_license_key'])) {
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM ikioskcloud_licenses WHERE deleted = '0' AND status = 'Active' AND ikiosk_id = '".$_GET['ikiosk_id']."' AND ikiosk_license_key = '".$_GET['ikiosk_license_key']."'";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);	
	
	//Get Software List
	if ($totalRows_getRecord != 0) {
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getSoftware = "SELECT * FROM ikioskcloud_license2software WHERE deleted = '0' AND cloud_id = '".$row_getRecord['cloud_id']."'";
		$getSoftware = mysql_query($query_getSoftware, $ikiosk) or sqlError(mysql_error());
		$row_getSoftware = mysql_fetch_assoc($getSoftware);
		$totalRows_getSoftware = mysql_num_rows($getSoftware);	
		
		//Get Software Details
		if ($totalRows_getSoftware != 0) {
			$i = 1;
			do {	
			mysql_select_db($database_ikiosk, $ikiosk);
			$query_softwareDetail = "SELECT * FROM ikioskcloud_software WHERE deleted = '0' AND status = 'Active' AND software_id = '".$row_getSoftware['software_id']."'";
			$softwareDetail = mysql_query($query_softwareDetail, $ikiosk) or sqlError(mysql_error());
			$row_softwareDetail = mysql_fetch_assoc($softwareDetail);
			$totalRows_softwareDetail = mysql_num_rows($softwareDetail);
			
			if ($totalRows_getSoftware != 0) {
				$softwareList .= $row_softwareDetail['software_id']."|".$row_softwareDetail['software_title']."|".$row_softwareDetail['description']."|".$row_softwareDetail['version']."|".$row_softwareDetail['build']."|".$row_softwareDetail['app_code']."|".$row_softwareDetail['software_type']."|".$row_softwareDetail['software_scope']."|".$row_softwareDetail['date_created']."|".$row_softwareDetail['date_modified'];
			}
			if ($i < $totalRows_getSoftware) { $softwareList .= "[iKiosk]";}
			$i++;
			 } while ($row_getSoftware = mysql_fetch_assoc($getSoftware));		
		}
		
		echo $softwareList;
	}
}

?>

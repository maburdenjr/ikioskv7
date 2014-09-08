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

if (isset($_GET['ikiosk_id']) && isset($_GET['ikiosk_license_key'])) {
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM ikioskcloud_licenses WHERE deleted = '0' AND status = 'Active' AND ikiosk_id = '".$_GET['ikiosk_id']."' AND ikiosk_license_key = '".$_GET['ikiosk_license_key']."'";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);	
	
	if ($totalRows_getRecord == 0) {
		echo "ikiosk-demo|customer-id|ikiosk-id|iKiosk Demo|Demo Account|http://www.intellikiosk.com|Demo|2020-01-01 12:00:00|1|20|Active|2011-01-01 12:00:00|2011-01-01 12:00:00";
	} else {
		echo $row_getRecord['cloud_id']."|".$row_getRecord['customer_id']."|".$row_getRecord['ikiosk_id']."|".$row_getRecord['ikiosk_license_key']."|".$row_getRecord['site_name']."|".$row_getRecord['site_url']."|".$row_getRecord['license_type']."|".$row_getRecord['expiration_date']."|".$row_getRecord['max_users']."|".$row_getRecord['max_sites']."|".$row_getRecord['status']."|".$row_getRecord['date_created']."|".$row_getRecord['date_modified'];
	}
}

?>

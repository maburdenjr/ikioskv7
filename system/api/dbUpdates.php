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

$dbQueries = "";

if (isset($_GET['ikiosk_id']) && isset($_GET['ikiosk_license_key'])) {
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM ikioskcloud_licenses WHERE deleted = '0' AND status = 'Active' AND ikiosk_id = '".$_GET['ikiosk_id']."' AND ikiosk_license_key = '".$_GET['ikiosk_license_key']."'";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);	
	
	//Get Software List
	if ($totalRows_getRecord != 0) {
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getQueries = "SELECT * FROM ikioskcloud_db_update WHERE deleted = '0' AND status = 'Active'";
		$getQueries = mysql_query($query_getQueries, $ikiosk) or sqlError(mysql_error());
		$row_getQueries = mysql_fetch_assoc($getQueries);
		$totalRows_getQueries = mysql_num_rows($getQueries);	
		
		//Get Software Details
		if ($totalRows_getQueries != 0) {
			$i = 1;
			do {	
			
			$dbQueries  .= $row_getQueries['update_id']."|".$row_getQueries['sql_query'];

			if ($i < $totalRows_getQueries) { $dbQueries .= "[iKiosk]";}
			$i++;
			 } while ($row_getQueries = mysql_fetch_assoc($getQueries));		
		}
		
		echo $dbQueries;
	}
}

?>

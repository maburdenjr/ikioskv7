<?php
//Begin AJAX Get Wrapper ###############################################################################
if (isset($_GET['ajaxAction'])) {
	
} // End AJAX Get Wrapper



// Begin AJAX Post Wrapper ###########################################################################

if ((isset($_POST["iKioskForm"])) && ($_POST["iKioskForm"] == "Yes")) {
	
// Software Packages: Edit -------------------------------------------
if ((isset($_POST["formID"])) && ($_POST["formID"] == "edit-IkioskcloudSoftware")) {
	
	$_POST['local_folder'] = trim(str_replace("/", "", $_POST['local_folder']));
	$_POST['local_folder'] = str_replace(" ", "", $_POST['local_folder']);
	
	$updateSQL = sprintf("UPDATE ikioskcloud_software SET software_title=%s, description=%s, version=%s, app_code=%s, software_type=%s, software_scope=%s, local_folder=%s, setup_file=%s, status=%s, folder_map=%s, date_modified=%s, modified_by=%s WHERE software_id=%s",
					GetSQLValueString($_POST['software_title'], "text"),
					GetSQLValueString($_POST['description'], "text"),
					GetSQLValueString($_POST['version'], "text"),
					GetSQLValueString($_POST['app_code'], "text"),
					GetSQLValueString($_POST['software_type'], "text"),
					GetSQLValueString($_POST['software_scope'], "text"),
					GetSQLValueString($_POST['local_folder'], "text"),
					GetSQLValueString($_POST['setup_file'], "text"),		
					GetSQLValueString($_POST['status'], "text"),
					GetSQLValueString($_POST['folder_map'], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"),
					GetSQLValueString($_POST['software_id'], "text"));
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($updateSQL);
	
	//Create Dir
	$softwareDIR = $SYSTEM['ikiosk_filesystem_root']."/system32/software_apps/".$_POST['local_folder'];
	createDIR($softwareDIR);
	
	$updateJS = "$('.page-title').html('".$_POST['software_title']."');\r\n";
	insertJS($updateJS);
	displayAlert("success", "Changes saved.");
	exit;
}
	
// Database Updates: Edit -------------------------------------------
if ((isset($_POST["formID"])) && ($_POST["formID"] == "edit-IkioskcloudDbUpdate")) {
    $updateSQL = sprintf("UPDATE ikioskcloud_db_update SET 
`title`=%s, `status`=%s, `sql_query`=%s, `date_modified`=%s, `modified_by`=%s WHERE update_id=%s",
        GetSQLValueString($_POST['title'], "text"),
        GetSQLValueString($_POST['status'], "text"),
        GetSQLValueString($_POST['sql_query'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($_POST['update_id'], "text"));

    mysql_select_db($database_ikiosk, $ikiosk);
    $Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
    sqlQueryLog($updateSQL);
		
		$updateJS = "$('.page-title').html('".$_POST['title']."');\r\n";
		insertJS($updateJS);
    displayAlert("success", "Changes saved.");
		exit;
}	

// Software Packages: Create -------------------------------------------
if ((isset($_POST["formID"])) && ($_POST["formID"] == "create-IkioskcloudSoftware")) {
	
	$generateID = create_guid();
	$_POST['local_folder'] = trim(str_replace("/", "", $_POST['local_folder']));
	$_POST['local_folder'] = str_replace(" ", "", $_POST['local_folder']);
	
	$insertSQL = sprintf("INSERT INTO ikioskcloud_software (software_id, software_title, description, version, app_code, software_type, software_scope, local_folder, setup_file, status, folder_map, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					GetSQLValueString($generateID , "text"),
					GetSQLValueString($_POST['software_title'], "text"),
					GetSQLValueString($_POST['description'], "text"),
					GetSQLValueString($_POST['version'], "text"),
					GetSQLValueString($_POST['app_code'], "text"),
					GetSQLValueString($_POST['software_type'], "text"),
					GetSQLValueString($_POST['software_scope'], "text"),
					GetSQLValueString($_POST['local_folder'], "text"),
			GetSQLValueString($_POST['setup_file'], "text"),
					GetSQLValueString($_POST['status'], "text"),
					GetSQLValueString($_POST['folder_map'], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"));
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($insertSQL);
	
	//Create Dir
	$softwareDIR = $SYSTEM['ikiosk_filesystem_root']."/system32/software_apps/".$_POST['local_folder'];
	createDIR($softwareDIR);
		$hideModal= "$('.modal-backdrop').remove(); \r\n";
		insertJS($hideModal." ".$refresh);
  exit;
}

//Create DB Update	
if ((isset($_POST["formID"])) && ($_POST["formID"] == "create-IkioskcloudDbUpdate")) {
	
	$generateID = create_guid();
	$insertSQL = sprintf("INSERT INTO ikioskcloud_db_update (update_id, title, sql_query, status, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($generateID, "text"),
			GetSQLValueString($_POST['title'], "text"),
			GetSQLValueString($_POST['sql_query'], "text"),
			GetSQLValueString($_POST['status'], "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"));
	
			mysql_select_db($database_ikiosk, $ikiosk);
			$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
			sqlQueryLog($insertSQL);
			
			$hideModal= "$('.modal-backdrop').remove(); \r\n";
			insertJS($hideModal." ".$refresh);
			exit;
	}
	

//Edit iKioskCloudSite  -------------------------------------------
if ((isset($_POST["formID"])) && ($_POST["formID"] == "edit-IkioskcloudSites")) {
	
	$updateSQL = sprintf("UPDATE ikioskcloud_sites SET system_name=%s, db_host=%s, db_name=%s, db_user=%s, db_password=%s, date_modified=%s, modified_by=%s WHERE site_id=%s",
        GetSQLValueString($_POST['system_name'], "text"),
        GetSQLValueString($_POST['db_host'], "text"),
        GetSQLValueString($_POST['db_name'], "text"),
        GetSQLValueString($_POST['db_user'], "text"),
        GetSQLValueString($_POST['db_password'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($_POST['site_id'], "text"));

	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($updateSQL);
	
	$updateJS = "$('.page-title').html('".$_POST['system_name']."');\r\n";
	insertJS($updateJS);
	displayAlert("success", "Changes saved.");
	exit;
	
}

//Create New iKioskCloudSite  -------------------------------------------
if ((isset($_POST["formID"])) && ($_POST["formID"] == "create-IkioskcloudSites")) {
	
	$requiredArray = array("system_name","system_url", "ikiosk_cloud_root", "ikiosk_filesystem_root", "ikiosk_root", "db_host", "db_name", "db_user", "db_password", "expiration_date", "max_users", "max_sites", "site_name", "site_url", "site_root");
	$fieldsCompleted = "Yes";
	foreach($requiredArray as $key => $value) {
			if ($_POST[$value] == "") { $fieldsCompleted = "No";}
	}
	
	if ($fieldsCompleted == "No") { // Fields Not Completed
	displayAlert("danger", "All fields on this form are required.  Please review all tabs and check your field entries.");
	} else { //Fields are Completed, Begin Processing Form
	
		$site_id = create_guid();
		$ikiosk_id = create_guid();
		$license_id = create_guid();
		$cloud_id = create_guid();
		
		//Create Site Record
		$insertSQL = sprintf("INSERT INTO ikioskcloud_sites (site_id, ikiosk_id, cloud_id, system_name, ikiosk_cloud_root, local_folder,  ikiosk_filesystem_root, ikiosk_root, db_host, db_name, db_user, db_password, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					GetSQLValueString($site_id, "text"),
					GetSQLValueString($ikiosk_id, "text"),
			GetSQLValueString($cloud_id, "text"),
					GetSQLValueString($_POST['system_name'], "text"),
					GetSQLValueString($_POST['ikiosk_filesystem_root']."/".$_POST['ikiosk_cloud_root'], "text"),
					GetSQLValueString($_POST['ikiosk_cloud_root'], "text"),
			GetSQLValueString("/sites/".$_POST['ikiosk_cloud_root'], "text"),
					GetSQLValueString($_POST['ikiosk_root'], "text"),
					GetSQLValueString($_POST['db_host'], "text"),
					GetSQLValueString($_POST['db_name'], "text"),
					GetSQLValueString($_POST['db_user'], "text"),
					GetSQLValueString($_POST['db_password'], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"));
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);
		
		//Create License
		$expirationDate = smartDates($_POST['expiration_date']);
		$insertSQL = sprintf("INSERT INTO ikioskcloud_licenses (cloud_id, customer_id, ikiosk_id, ikiosk_license_key, site_name, site_url, license_type, expiration_date, max_users, max_sites, status, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
				GetSQLValueString($cloud_id, "text"),
				GetSQLValueString($_POST['customer_id'], "text"),
				GetSQLValueString($ikiosk_id, "text"),
				GetSQLValueString($license_id, "text"),
				GetSQLValueString($_POST['system_name'], "text"),
				GetSQLValueString($_POST['system_url'], "text"),
				GetSQLValueString($_POST['license_type'], "text"),
				GetSQLValueString($expirationDate, "text"),
				GetSQLValueString($_POST['max_users'], "text"),
				GetSQLValueString($_POST['max_sites'], "text"),
				GetSQLValueString($_POST['status'], "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"));
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);
		
		//Create Site Directory
		$siteDirectory = $_POST['ikiosk_filesystem_root']."/".$_POST['ikiosk_cloud_root'];
		createDIR($siteDirectory);
		
		//Copy Package Files
		$packageSource = $_SERVER['DOCUMENT_ROOT'];
		$packageSource = str_replace("apps/intellikiosk/v7", "packages/ikioskv7", $packageSource);
		copyr($packageSource, $siteDirectory);
		
		if (!$icloud) { 
		
			//Connection Failed
			errorLog("Unable to create connect to database host: ".$hostname_icloud." for iKioskCloud site installation.", "System Error", $redirect);	
		
		} else {
	
			//Create Database
			$sqlQuery = urlFetch("http://apps.ikioskcloudapps.com/system32/sql/ikiosk_v6.sql");	
			$sqlQuery = explode("[iKiosk]", $sqlQuery);
			mysql_select_db($database_icloud, $icloud);
			foreach ($sqlQuery as $key => $value) {
				$result =  mysql_query($value, $icloud) or  die(mysql_error());
		
			//Create System Properties
			$systemSQL = "INSERT INTO `sys_config` (`ikiosk_id`, `ikiosk_license_key`, `system_name`, `ikiosk_filesystem_root`, `ikiosk_root`, `ikiosk_version`) VALUES ('".$ikiosk_id."', '".$license_id."', '".$_POST['system_name']."', '".$siteDirectory."', '".$_POST['ikiosk_root']."', '6.0');";
			$result =  mysql_query($systemSQL, $icloud) or  die(mysql_error());
			
			//Create Site Properties
			$siteSQL = "INSERT INTO `sys_sites` (`site_id`, `site_name`, `site_status`, `site_url`, `site_root`,  `support_email`, `site_timezone`, `date_created`, `created_by`, `date_modified`, `modified_by`) VALUES ('sys-default', '".$_POST['site_name']."', 'Active', '".$_POST['site_url']."', '/".$_POST['site_root']."', '".$_POST['admin_loginemail']."', '".$_POST['site_timezone']."', '".$SYSTEM['mysql_datetime']."', 'sys-admin', '".$SYSTEM['mysql_datetime']."', 'sys-admin')";
			$result =  mysql_query($siteSQL, $icloud) or  die(mysql_error());
			
			//Create Root Directory for Default Site
			$defaultDIR = $siteDirectory."/sites/".$_POST['site_root']."";
			mkdir($defaultDIR);
			
			//Create DB Connection File
			$dbConn = $siteDirectory.$_POST['ikiosk_root']."/includes/core/db_conn.php";
			$dbConnFile = "<?php\r\n"; 
			$dbConnFile .= "//Database Connection\r\n\r\n";
			$dbConnFile .= "\$hostname_ikiosk = \"".$_POST['db_host']."\";\r\n";
			$dbConnFile .= "\$database_ikiosk = \"".$_POST['db_name']."\";\r\n";
			$dbConnFile .= "\$username_ikiosk = \"".$_POST['db_user']."\";\r\n";
			$dbConnFile .= "\$password_ikiosk = \"".$_POST['db_password']."\";\r\n";
			$dbConnFile .= "\$ikiosk = mysql_pconnect(\$hostname_ikiosk, \$username_ikiosk, \$password_ikiosk) or trigger_error(mysql_error(),E_USER_ERROR);\r\n"; 
			$dbConnFile .= "// FileSystem Configuration\r\n\r\n";
			$dbConnFile .= "\$systemRoot = \"".$_POST['ikiosk_root']."\";\r\n";
			$dbConnFile .= "\$systemFileRoot = \"".$siteDirectory."\";\r\n";
			$dbConnFile .= "?>";
			
			$fh = fopen($dbConn, 'w') or errorLog("Unable to create iKiosk Configuration File.", "System Error", $redirect);
			fwrite($fh, $dbConnFile);
			fclose($fh);
			
			$hideModal= "$('.modal-backdrop').remove(); \r\n";
			insertJS($hideModal." ".$refresh);
			
			} // End DB Creations
				
		} // End Fields Created
		
	}
	exit; // End New Site 
	
}

	
} // End AJAX Post Wrapper

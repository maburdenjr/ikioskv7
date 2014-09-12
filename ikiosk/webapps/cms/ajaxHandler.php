<?php
$pageRefresh = "location.reload();\r\n";
$hideModal = "$('.modal').modal('hide');\r\n";

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

// Begin AJAX Action Wrapper ###########################################################################
if (isset($_GET['ajaxAction'])) {
	switch($_GET['ajaxAction']) {
		case "editPageProperties":
			$actionFile = "admin-pageProperties.php";
			break;
		case "createPage":
			$actionFile = "admin-createPage.php";
			break;
	}
	include($SYSTEM['ikiosk_filesystem_root']."/ikiosk/webapps/cms/".$actionFile);
}

// Begin AJAX Post Wrapper ###########################################################################
if ((isset($_POST["iKioskForm"])) && ($_POST["iKioskForm"] == "Yes")) {
	
	
	//Edit Page Properties-----------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "cms-editPageProperties")) {
		
		$generateID = create_guid();
		if ($_POST['status'] == "Published") {
			//Update Page Status
			$updateSQL = sprintf("UPDATE cms_page_versions SET status = 'Draft' WHERE page_id=%s",
				GetSQLValueString($_POST['page_id'], "text"));
		
			mysql_select_db($database_ikiosk, $ikiosk);
			$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
			sqlQueryLog($updateSQL);
			unlink($SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root'].$_POST['original_file']);
		}
		
		//Update Page Parent
		$updateSQL = sprintf("UPDATE cms_pages SET parent_id=%s, date_modified=%s, modified_by=%s WHERE page_id=%s",
        GetSQLValueString($_POST['parent_id'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($_POST['page_id'], "text"));

		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($updateSQL);
		
		if ($_POST['version'] != 0.00) {
			$version = $_POST['version'] + 0.05;
		} else {
			$version = $_POST['version'] + 1.00;	
		}
		
		//Create New Version
		$publishDate = smartDates($_POST['publish_date']);
		$expirationDate = smartDates($_POST['expire_date']);
		
		$insertSQL = sprintf("INSERT INTO cms_page_versions (page_version_id, site_id, page_id, template_id, version, title, content_id, content, static_folder, static_file, menu_display, menu_display_order, menu_custom_class, mobile_enabled, mobile_template_id, meta_author, meta_cache_control, meta_description, meta_keywords, meta_robots, publish_date, auto_expire, expiration_date, status, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($generateID, "text"),
        GetSQLValueString($_SESSION['site_id'], "text"),
        GetSQLValueString($_POST['page_id'], "text"),
        GetSQLValueString($_POST['template_id'], "text"),
        GetSQLValueString($version, "text"),
        GetSQLValueString($_POST['title'], "text"),
        GetSQLValueString($_POST['content_id'], "text"),
        GetSQLValueString($_POST['content'], "text"),
        GetSQLValueString($_POST['static_folder'], "text"),
        GetSQLValueString($_POST['static_file'], "text"),
        GetSQLValueString($_POST['menu_display'], "text"),
        GetSQLValueString($_POST['menu_display_order'], "text"),
        GetSQLValueString($_POST['menu_custom_class'], "text"),
        GetSQLValueString($_POST['mobile_enabled'], "text"),
        GetSQLValueString($_POST['mobile_template_id'], "text"),
        GetSQLValueString($_POST['meta_author'], "text"),
        GetSQLValueString($_POST['meta_cache_control'], "text"),
        GetSQLValueString($_POST['meta_description'], "text"),
        GetSQLValueString($_POST['meta_keywords'], "text"),
        GetSQLValueString($_POST['meta_robots'], "text"),
        GetSQLValueString($publishDate, "text"),
        GetSQLValueString($_POST['auto_expire'], "text"),
        GetSQLValueString($expirationDate, "text"),
				GetSQLValueString($_POST['status'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"));
				
				mysql_select_db($database_ikiosk, $ikiosk);
				$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
				sqlQueryLog($insertSQL);
				
				v7publishPage($_POST['page_id']);	
				$js = "window.location=\"".$_POST['static_folder'].$_POST['static_file']."\"\r\n";
				insertJS($hideModal.$js);
				exit;
	}
	
	//Save Page Edits-----------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "iKioskCMS-editContent")) {
		
		//Grab Existing Page Details
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getRecord = "SELECT * FROM cms_page_versions WHERE page_version_id = '".$_POST['page_version_id']."' AND deleted = '0' AND ".$SYSTEM['active_site_filter'];
		$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
		$row_getRecord = mysql_fetch_assoc($getRecord);
		$totalRows_getRecord = mysql_num_rows($getRecord);
		
		if ($totalRows_getRecord != 0) {
			//Update Version
			if ($row_getRecord['version'] != 0.00) {
				$version = $row_getRecord['version'] + 0.05;
			} else {
				$version = $row_getRecord['version'] + 1.00;	
			}
			
			$generateID = create_guid();
			$insertSQL = sprintf("INSERT INTO cms_page_versions (page_version_id, site_id, page_id, template_id, version, title, content_id, content, static_folder, static_file, menu_display, menu_display_order, menu_custom_class, mobile_enabled, mobile_template_id, meta_author, meta_cache_control, meta_description, meta_keywords, meta_robots, publish_date, auto_expire, expiration_date, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						GetSQLValueString($generateID, "text"),
						GetSQLValueString($row_getRecord['site_id'], "text"),
						GetSQLValueString($row_getRecord['page_id'], "text"),
						GetSQLValueString($row_getRecord['template_id'], "text"),
						GetSQLValueString($version, "text"),
						GetSQLValueString($row_getRecord['title'], "text"),
						GetSQLValueString($row_getRecord['content_id'], "text"),
						GetSQLValueString($_POST['content'], "text"),
						GetSQLValueString($row_getRecord['static_folder'], "text"),
						GetSQLValueString($row_getRecord['static_file'], "text"),
						GetSQLValueString($row_getRecord['menu_display'], "text"),
						GetSQLValueString($row_getRecord['menu_display_order'], "text"),
						GetSQLValueString($row_getRecord['menu_custom_class'], "text"),
						GetSQLValueString($row_getRecord['mobile_enabled'], "text"),
						GetSQLValueString($row_getRecord['mobile_template_id'], "text"),
						GetSQLValueString($row_getRecord['meta_author'], "text"),
						GetSQLValueString($row_getRecord['meta_cache_control'], "text"),
						GetSQLValueString($row_getRecord['meta_description'], "text"),
						GetSQLValueString($row_getRecord['meta_keywords'], "text"),
						GetSQLValueString($row_getRecord['meta_robots'], "text"),
						GetSQLValueString($row_getRecord['publish_date'], "text"),
						GetSQLValueString($row_getRecord['auto_expire'], "text"),
						GetSQLValueString($row_getRecord['expire_date'], "text"),
						GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
						GetSQLValueString($_SESSION['user_id'], "text"),
						GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
						GetSQLValueString($_SESSION['user_id'], "text"));
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);
		}
		
		v7publishPage($row_getRecord['page_id']);	

		$updateSQL = sprintf("UPDATE cms_page_versions SET status = 'Draft' WHERE page_id=%s",
			GetSQLValueString($row_getRecord['page_id'], "text"));
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($updateSQL);
		
		$updateSQL = sprintf("UPDATE cms_page_versions SET status=%s, date_modified=%s, modified_by=%s WHERE page_version_id=%s",
			GetSQLValueString("Published", "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"),
			GetSQLValueString($generateID, "text"));
			
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($updateSQL);
		
		$js = "$('#iKioskCMSeditor').fadeOut();\r\n";
		$js .= "$('#iKioskCMSheader a').removeClass('active');\r\n";
		insertJS($js.$pageRefresh);
		exit;
	}
	
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
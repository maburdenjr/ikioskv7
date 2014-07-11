<?php
$PAGE['application_code'] = isset($_POST['appCode']) ? $_POST['appCode'] : $_GET['appCode'];
require('../../includes/core/ikiosk.php');

$refresh = 'var iLocation = location.hash.replace(/^#/, ""); ';
$refresh .= 'var iContainer = $("#content"); ';
$refresh .= 'loadURL(iLocation, iContainer); ';

//Record Action Wrapper ###############################################################################

if (isset($_GET['ajaxAction'])) {

// Delete Records --------------------------------------------------------------------------------	
	
	if($_GET['ajaxAction'] == "deleteRecord") {
		$status = deleteRecordv7($_GET['table'], $_GET['field'], $_GET['record']);
		displayAlert($status[0], $status[1]);
		if ($status[0] == "success") {
			insertJS("$('.".$_GET['record']."').fadeOut();");
		}
	}

// AppCode Check --------------------------------------------------------------------------------	
	
	if($_GET['ajaxAction'] == "appCodeCheck") {
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_listView = "SELECT * FROM sys_applications WHERE deleted = '0' AND application_code = '".$_GET['application_code']."'";
		$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
		$row_listView = mysql_fetch_assoc($listView);
		$totalRows_listView = mysql_num_rows($listView);
		
		if($totalRows_listView == 0) {
			echo "true";
		} else {
			echo "false";
		}
	}

} // End AJAX Get Wrapper



// Begin AJAX Post Wrapper ###########################################################################

if ((isset($_POST["iKioskForm"])) && ($_POST["iKioskForm"] == "Yes")) {
	
// Applications: Edit --------------------------------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "editApplication")) {
			$updateSQL = sprintf("UPDATE sys_applications SET application_title=%s, application_root=%s, application_type=%s, application_description=%s, application_security=%s, application_clearance=%s, application_version=%s, application_status=%s, date_modified=%s, modified_by=%s WHERE application_id=%s",
					GetSQLValueString($_POST['application_title'], "text"),
					GetSQLValueString($_POST['application_root'], "text"),
					GetSQLValueString($_POST['application_type'], "text"),
					GetSQLValueString($_POST['application_description'], "text"),
					GetSQLValueString($_POST['application_security'], "text"),
					GetSQLValueString($_POST['application_clearance'], "text"),
					GetSQLValueString($_POST['application_version'], "text"),
					GetSQLValueString($_POST['application_status'], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"),
					GetSQLValueString($_POST['application_id'], "text"));
	
			mysql_select_db($database_ikiosk, $ikiosk);
			$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
			sqlQueryLog($updateSQL);
			
			insertJS("$('.".$_POST['application_id']." a').hide().text('".$_POST['application_title']."').fadeIn()");
			displayAlert("success", "Changes saved.");
			exit;
	}
	// Applications: Create --------------------------------------------------------------------------------
	
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "createApplication")) {
		
		//GPS Mod
		$sqlMod = "ALTER TABLE `sys_permissions` ADD `".$_POST['application_code']."` VARCHAR(5) DEFAULT '".$_POST['default_application_clearance']."' NOT NULL AFTER `USER`";
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($sqlMod, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($sqlMod);
		
		$generateID = create_guid();
		$insertSQL = sprintf("INSERT INTO sys_applications (application_id, application_code, application_title, application_root, application_type, application_description, application_security, application_clearance, application_version, application_status, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($generateID, "text"),
        GetSQLValueString($_POST['application_code'], "text"),
        GetSQLValueString($_POST['application_title'], "text"),
        GetSQLValueString($_POST['application_root'], "text"),
        GetSQLValueString($_POST['application_type'], "text"),
        GetSQLValueString($_POST['application_description'], "text"),
        GetSQLValueString($_POST['application_security'], "text"),
        GetSQLValueString($_POST['application_clearance'], "text"),
        GetSQLValueString($_POST['application_version'], "text"),
        GetSQLValueString($_POST['application_status'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"));
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);
		insertJS($refresh);
		exit;
	}
	
} // End AJAX Post Wrapper
?>

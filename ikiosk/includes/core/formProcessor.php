<?php
$PAGE['application_code'] = isset($_POST['appCode']) ? $_POST['appCode'] : $_GET['appCode'];
require('../../includes/core/ikiosk.php');

$refresh = 'var iLocation = location.hash.replace(/^#/, ""); ';
$refresh .= 'var iContainer = $("#content"); ';
$refresh .= 'loadURL(iLocation, iContainer); ';

//Record Action Wrapper ###############################################################################

if (isset($_GET['ajaxAction'])) {

// Return DB Fileds in Table  ------------------------------------------------------------------------
	if($_GET['ajaxAction'] == "dbFields") {
		
		$response = "";
		$restricted = array("date_created", "created_by", "modified_by", "date_modified", "deleted");
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_showColumns = "SHOW COLUMNS FROM ".$_GET['table']."";
		$showColumns = mysql_query($query_showColumns, $ikiosk) or sqlError(mysql_error());
		$row_showColumns = mysql_fetch_assoc($showColumns);
		$totalRows_showColumns = mysql_num_rows($showColumns);
		
		if ($_GET['option'] == "select") {
				do {
					if (!in_array($row_showColumns['Field'], $restricted)) {
						$response .= "<option value='".$row_showColumns['Field']."'>".$row_showColumns['Field']."</option>";
					}
				} while ($row_showColumns = mysql_fetch_assoc($showColumns));
		}
		
		if ($_GET['option'] == "list") {
				do {
					if (!in_array($row_showColumns['Field'], $restricted)) {
						$label = str_replace("_", " ", $row_showColumns['Field']);
						$label = ucwords($label);
						$response .= "<tr><td><label class='checkbox'><input type='checkbox' name='include_field[]' value='".$row_showColumns['Field']."'><i></i></label></td>";
						$response .="<td>".$row_showColumns['Field']."</td>";
						$response .="<td><label class='input'><input type='text' name='".$row_showColumns['Field']."[label]' value='".$label."'></label></td>";
						$response .="<td><label class='select'><select name='".$row_showColumns['Field']."[type]'><option value='input'>Text Input</option><option value='select'>Select</option><option value='select-multiple'>Multiple Select</option><option value='textarea'>Textarea</option><option value='radio'>Radio</option><option value='checkbox'>Checkbox</option></select><i></i></label></td>";
						$response .="<td><label class='toggle'><input type='checkbox' name='".$row_showColumns['Field']."[required]' value='Yes'><i data-swchon-text='YES' data-swchoff-text='NO'></i></label></td></tr>";
					}
				} while ($row_showColumns = mysql_fetch_assoc($showColumns));
		} 
		 
		
		echo $response;
		exit;	
	}


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
	
// Code Generator --------------------------------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "codeSnippet")) {
		
		$response = "<div class='well'>";
		$response .= "Oh Hi";
		$response .="</div>";	
		displayAlert("success", "Code snippets successfully generated");	
		$js = "$('#codeResponse').html('".addslashes($response)."')";
		insertJS($js);
		exit;
	}
	
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

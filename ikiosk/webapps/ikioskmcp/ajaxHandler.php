<?php
//Begin AJAX Get Wrapper ###############################################################################
if (isset($_GET['ajaxAction'])) {
	
		//Build Software Package
		if ($_GET['ajaxAction'] == "buildPackage") {
			
			mysql_select_db($database_ikiosk, $ikiosk);
			$query_ikioskcloud_software = "SELECT * FROM ikioskcloud_software WHERE software_id = '".$_GET['recordID']."' AND deleted = '0' AND ".$_SESSION['team_filter']."";
			$ikioskcloud_software = mysql_query($query_ikioskcloud_software, $ikiosk) or sqlError(mysql_error());
			$row_ikioskcloud_software = mysql_fetch_assoc($ikioskcloud_software);
			$totalRows_ikioskcloud_software = mysql_num_rows($ikioskcloud_software);
			
			
			$fileBase = $SYSTEM['ikiosk_filesystem_root']."/system/software_apps/".$row_ikioskcloud_software['local_folder']."/";
			mysql_select_db($database_ikiosk, $ikiosk);
			$query_listView = "SELECT * FROM ikioskcloud_software_map WHERE software_id = '".$_GET['recordID']."' AND deleted = '0' ORDER BY destination_file ASC";
			$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
			$row_listView = mysql_fetch_assoc($listView);
			$totalRows_listView = mysql_num_rows($listView);
			
			//Copy Files in List
			if ($totalRows_listView != "0") {
				do {
					$destinationFile = $fileBase.$row_listView['package_file'];
					copy($row_listView['source_file'], $destinationFile);
				} while ($row_listView = mysql_fetch_assoc($listView));
			}
			
			$buildVersion = $row_ikioskcloud_software['build'] + 10;
			
			//Update Build Version
			$insertSQL = sprintf("UPDATE ikioskcloud_software SET build=%s, date_modified=%s WHERE software_id=%s",
				GetSQLValueString($buildVersion, "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
						GetSQLValueString($row_ikioskcloud_software['software_id'], "text"));
		
			mysql_select_db($database_ikiosk, $ikiosk);
			$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
			sqlQueryLog($insertSQL);

			displayAlert("success", "Package build complete.");
			exit;
		}
	  
		//Add Files to Package
		if ($_GET['ajaxAction'] == "softwareFileBrowser") {
			if (empty($_GET['directory'])) {
				$activeDir = "/";
				$activeSystemDir = $SYSTEM['ikiosk_filesystem_root'];
				$activeLocalDir = "/";
			} else {
				$activeDir = "/".$_GET['directory'];
				$activeSystemDir = $SYSTEM['ikiosk_filesystem_root']."/".$_GET['directory'];
				$activeLocalDir = "/".$_GET['directory'];
				$activeLocalDir = str_replace("//", "/", $activeLocalDir);
				$activeFolder = "/".substr(strrchr($activeDir, "/"), 1);
				$parentFolder = str_replace($activeFolder, "", $activeDir);
				$parentFolder = substr($parentFolder, "1");
			}
			
			$dh  = opendir($activeSystemDir);
			while (false !== ($filename = readdir($dh))) {
					$fileArray[] = $filename;
			}
			
			$response = "<section>";
			$response .= "<form id = \"softwareFileSelection\" class=\"smart-form\" method=\"post\"><div class=\"form-response inline\"></div>";
			$response .= "<table class=\"table table-striped table-hover table-bordered no-margin no-border\" width=\"100%\">";
			$response .="<thead><th width=\"20\"><label class=\"checkbox\"><input type=\"checkbox\" class=\"checkall\"><i></i></label></th><th>Name</th><th width=\"50\">Size</th><th>Last Modified</th></thead>";
			$response .="<tbody>";
			
			if ($activeDir != "/") {
					$response .="<tr><td></td><td><i class=\"fa fa-arrow-up\"></i> <a data-directory=\"".$parentFolder."\" data-record=\"".$_GET['recordID']."\" class=\"browserLink\"> Up One Folder</a> - Browsing: ".$activeLocalDir." </td><td></td><td></td></tr>";	
			}
			
			foreach ($fileArray as $key => $value) { 
				if (($value != ".") && ($value != "..") && ($value != ".svn") && ($value != "_notes")) { 
				$activeFile = $activeSystemDir."/".$value;
				$modDate = (filemtime($activeFile));
				$modDate = date("m/d/Y g:i:s a", $modDate);
				
				if(is_dir($activeFile)) {
					$fileCheckBox = "";
					$iconLink = "<i class=\"fa fa-folder\"></i>&nbsp;&nbsp;";
					$fileSize = "";
					$fileName = "<a data-directory=\"".$_GET['directory']."/".$value."\" data-record=\"".$_GET['recordID']."\" class=\"browserLink\">".$value."</a>";
				} else {
					$fileCheckBox = "<label class=\"checkbox\"><input type=\"checkbox\" name=\"fileID[]\" value=\"".$activeFile."\" class=\"checktag\"><i></i></label>";
						$iconLink = "<i class=\"fa fa-file\"></i>&nbsp;&nbsp;";
						$fileSize = filesize($activeFile);
						$fileName = $value;
		
				}
				$response .= "<tr>";
				$response .= "<td>".$fileCheckBox."</td>";
				$response .= "<td width=\"100%\">".$iconLink.$fileName."</td>";
				$response .= "<td align=\"right\">".$fileSize."</td>";
				$response .= "<td nowrap>".$modDate."</td>";
				$response .="</tr>";
				
				}} 
 
			$response .= "</tbody>";
			$response .="</table>";
			$response .= "<footer>
                <button type=\"submit\" class=\"btn btn-primary btn-ajax-submit\" data-form=\"softwareFileSelection\"> <i class=\"fa fa-plus\"></i> Add Files</button>
                <input type=\"hidden\" name=\"software_id\" value=\"".$_GET['recordID']."\" />
                <input type=\"hidden\" name=\"formID\" value=\"softwareFileSelection\">
                <input type=\"hidden\" name=\"iKioskForm\" value=\"Yes\" />
                <input type=\"hidden\" name=\"appCode\" value=\"".$APPLICATION['application_code']."\" />
              </footer>
            </form>";
						
						$response .= "<script type=\"text/javascript\">
						$(\"#softwareFileSelection\").validate({
           errorPlacement : function(error, element) {
               error.insertAfter(element.parent());
           },
           submitHandler: function(form) {
               var targetForm = $(this.currentForm).attr(\"id\");
               submitAjaxForm(targetForm);
           }
			 });
			 
			 $('.checkall').on(\"click\", function () {
					var checkBoxes = $('.checktag');
					checkBoxes.prop(\"checked\", !checkBoxes.prop(\"checked\"));
				});
			 </script>\r\n";			
			$response .= "</form>";
			$response .= "<section>";

			
			echo $response;
			exit;
		}
		 
		//Manage Package Files
		if ($_GET['ajaxAction'] == "managePackageFiles") {
			
			mysql_select_db($database_ikiosk, $ikiosk);
			$query_listView = "SELECT * FROM ikioskcloud_software_map WHERE software_id = '".$_GET['recordID']."' AND deleted = '0' ORDER BY destination_file ASC";
			$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
			$row_listView = mysql_fetch_assoc($listView);
			$totalRows_listView = mysql_num_rows($listView);
			
			$response = "<section><table id=\"dt-SoftwareMap\" class=\"table table-striped table-hover table-bordered no-margin no-border\" width=\"100%\">";
			$response .= "<thead><tr><th>Source File</th><th></th></tr></thead>";
			$response .= "<tbody>";
			if ($totalRows_listView != 0) {
			do {
				$response .="<tr class=\"".$row_listView['filemap_id']."\">";
				$response .="<td class=\"truncate\">".$row_listView['destination_file']."</td>";
				$response .="<td class=\"icon\"><a class=\"delete-record\" data-table=\"ikioskcloud_software_map\" data-record=\"".$row_listView['filemap_id']."\" data-code=\"".$APPLICATION['application_code']."\" data-field=\"filemap_id\"><i class=\"fa fa-trash-o\"></i></a></td>";
				$response .="</tr>";
				} while ($row_listView = mysql_fetch_assoc($listView));		
			}
			$response .= "</tbody>";
			$response .= "</table></section>";
			$response .="<script type=\"text/javascript\">\r\n";
			$response .="var listView = $('#dt-SoftwareMap').dataTable({\"iDisplayLength\": 5});\r\n";
			$response .="$('.dataTables_length').before('<a class=\"btn btn-primary btn-add icon-action\" data-code=\"IKMCP\" data-type=\"buildPackage\" data-record=\"".$_GET['recordID']."\"><i class=\"fa fa-cog\"></i> Build Package</a> <button class=\"btn btn-default btn-add delete-record\" data-table=\"ikioskcloud_software_map\" data-record=\"".$_GET['recordID']."\" data-code=\"".$APPLICATION['application_code']."\" data-field=\"software_id\"><i class=\"fa fa-trash-o\"></i> Delete All</span></button> ');";
			$response .="</script>";
			echo $response;
			exit;
		}
	
} // End AJAX Get Wrapper



// Begin AJAX Post Wrapper ###########################################################################

if ((isset($_POST["iKioskForm"])) && ($_POST["iKioskForm"] == "Yes")) {
	
	// Software Licenses: Create -------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "create-IkioskcloudLicenses")) {
		
	$transformTime = smartDates($_POST['expiration_date']);
	$generateID = create_guid();
	$license = create_guid();
	
	$insertSQL = sprintf("INSERT INTO ikioskcloud_licenses (cloud_id, customer_id, ikiosk_id, ikiosk_license_key, site_name, site_url, license_type, expiration_date, max_users, max_sites, status, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($generateID, "text"),
			GetSQLValueString($_POST['customer_id'], "text"),
			GetSQLValueString($_POST['ikiosk_id'], "text"),
			GetSQLValueString($license, "text"),
			GetSQLValueString($_POST['site_name'], "text"),
			GetSQLValueString($_POST['site_url'], "text"),
			GetSQLValueString($_POST['license_type'], "text"),
			GetSQLValueString($transformTime, "text"),
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
			
			$hideModal= "$('.modal-backdrop').remove(); \r\n";
			insertJS($hideModal." ".$refresh);
		
		exit;
	}
	
	// Software Licenses: Edit -------------------------------------------

if ((isset($_POST["formID"])) && ($_POST["formID"] == "edit-IkioskcloudLicenses")) {
	$transformTime = smartDates($_POST['expiration_date']);
	$updateSQL = sprintf("UPDATE ikioskcloud_licenses SET ikiosk_id=%s, site_name=%s, site_url=%s, license_type=%s, expiration_date=%s, max_users=%s, max_sites=%s, status=%s, date_modified=%s, modified_by=%s WHERE cloud_id=%s",
					GetSQLValueString($_POST['ikiosk_id'], "text"),
					GetSQLValueString($_POST['site_name'], "text"),
					GetSQLValueString($_POST['site_url'], "text"),
					GetSQLValueString($_POST['license_type'], "text"),
					GetSQLValueString($transformTime, "text"),
					GetSQLValueString($_POST['max_users'], "text"),
					GetSQLValueString($_POST['max_sites'], "text"),
					GetSQLValueString($_POST['status'], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"),
					GetSQLValueString($_POST['cloud_id'], "text"));
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($updateSQL);
	
	$updateJS = "$('.page-title').html('".$_POST['site_name']."');\r\n";
	insertJS($updateJS);
	displayAlert("success", "Changes saved.");
	exit;

	
}

//Add Files to Package	  -------------------------------------------
if ((isset($_POST["formID"])) && ($_POST["formID"] == "softwareFileSelection")) {
	
	if (!empty($_POST['fileID'])) {
		foreach ($_POST['fileID'] as $key => $value) {
			
			$sourceFile = $value;
			$destinationFile = str_replace($SYSTEM['ikiosk_filesystem_root'], "", $sourceFile);
			$destinationFile = str_replace("//", "/", $destinationFile);
			
			$dirPointer = strrchr($sourceFile, "/");
			
			$file_id = create_guid();
			$packageFile = $file_id.".txt";
			$packageFile = str_replace("-", "", $packageFile);
			$insertSQL = sprintf("INSERT INTO ikioskcloud_software_map (filemap_id, software_id, source_file, package_file, destination_file) VALUES (%s, %s, %s, %s, %s)",
			GetSQLValueString($file_id, "text"),
			GetSQLValueString($_POST['software_id'], "text"),
			GetSQLValueString($sourceFile, "text"),
			GetSQLValueString($packageFile, "text"),
			GetSQLValueString($destinationFile, "text"));
	
			mysql_select_db($database_ikiosk, $ikiosk);
			$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
			sqlQueryLog($insertSQL);			
		}

	
		displayAlert("success", "Files successfully added to package.");
		$js = "$('#editCtn-IkioskcloudSoftware-manageFiles .jarviswidget-refresh-btn').click();\r\n";
		insertJS($js);
		exit;
	}
}


//Add Folder to Package	  -------------------------------------------
if ((isset($_POST["formID"])) && ($_POST["formID"] == "edit-IkioskcloudSoftware-AddFolder")) {
	
	$sourceFolder = $_POST['ikiosk_folder'];
	$fileList = getFileList($sourceFolder);
	
	foreach($fileList as $k2 => $v2) {
		$file_id = create_guid();
		$insertSQL = sprintf("INSERT INTO ikioskcloud_software_map (filemap_id, software_id, source_file, package_file, destination_file) VALUES (%s, %s, %s, %s, %s)",
				GetSQLValueString($file_id, "text"),
				GetSQLValueString($_POST['software_id'], "text"),
				GetSQLValueString($fileList[$k2]['source'], "text"),
				GetSQLValueString($fileList[$k2]['package'], "text"),
				GetSQLValueString($fileList[$k2]['destination'], "text"));
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);
	}
	
	displayAlert("success", "All files and subdirectories successfully added to package.");
	$js = "$('#editCtn-IkioskcloudSoftware-manageFiles .jarviswidget-refresh-btn').click();\r\n";
	insertJS($js);
	exit;

}

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

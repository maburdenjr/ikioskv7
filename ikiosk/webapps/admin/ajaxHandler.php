<?php
//Record Action Wrapper ###############################################################################

if (isset($_GET['ajaxAction'])) {
	
	// List of Team Members for a Specific Team
	if($_GET['ajaxAction'] == "teamMemberSelect") {

		$response = "<form id = \"edit-AddUserToTeam\" class=\"smart-form\" method=\"post\">
              <fieldset>
              <div class=\"form-response\"></div>
                <section>
                  <label class=\"select\">
                    <select name=\"add_user\">
                      <option value=\"\">Select User</option>
                      ".addUser2Team($_GET['recordID'])."</select><i></i>
                  </label>
                </section>
              </fieldset>
              <footer>
                <button type=\"submit\" class=\"btn btn-default btn-ajax-submit\" data-form=\"edit-AddUserToTeam\"> <i class=\"fa fa-plus\"></i> Add </button>
                <input type=\"hidden\" name=\"team_id\" value=\"".$_GET['recordID']."\" />
                <input type=\"hidden\" name=\"formID\" value=\"edit-AddUserToTeam\">
                <input type=\"hidden\" name=\"iKioskForm\" value=\"Yes\" />
                <input type=\"hidden\" name=\"appCode\" value=\"".$APPLICATION['application_code']."\" />
              </footer>
            </form>";
						
						$response .= "<script type=\"text/javascript\">
						$(\"#edit-AddUserToTeam\").validate({
           errorPlacement : function(error, element) {
               error.insertAfter(element.parent());
           },
           submitHandler: function(form) {
               var targetForm = $(this.currentForm).attr(\"id\");
               submitAjaxForm(targetForm);
           }
			 });
			 </script>";
						echo $response;
						exit;
	}
	
	// List of Team Members for a Specific Team
	if($_GET['ajaxAction'] == "teamMembers") {
		$response = "";
		
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_listView = "SELECT * FROM sys_users2teams WHERE team_id='".$_GET['recordID']."' AND deleted='0'";
	$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
	$row_listView = mysql_fetch_assoc($listView);
	$totalRows_listView = mysql_num_rows($listView);
	
		
		$response = "<table id=\"dt-SysTeams-Members\" class=\"table table-striped table-bordered table-hover\" width=\"100%\"><thead><tr><th>User</th><th>Status</th><th></th></tr></thead>";
		if ($totalRows_listView != 0) {
			do {
				$userCheck = getUserData($row_listView['user_id'], 'display_name');
				if ($userCheck != "") {
					$response .="<tr class=\"".$row_listView['join_id']."\">";
					$response .="<td>".getUserData($row_listView['user_id'], 'display_name')."</td>";
					$response .="<td>".getUserData($row_listView['user_id'], 'user_status')."</td>";
					$response .="<td class=\"icon\"><a class=\"delete-record\" data-table=\"sys_users2teams\" data-record=\"".$row_listView['join_id']."\" data-code=\"".$APPLICATION['application_code']."\" data-field=\"join_id\"><i class=\"fa fa-trash-o\"></i></a></td>";
					$response .= "</tr>";
				}
			} while ($row_listView = mysql_fetch_assoc($listView));
		}
		$response .= "</table>\r\n";
		$response .="<script type=\"text/javascript\">\r\n";
		$response .="var listView = $('#dt-SysTeams-Members').dataTable();\r\n";
		$response .="</script>";
		echo $response;
		exit;
	}

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
	
	// AppCode Check --------------------------------------------------------------------------------	
	
	if($_GET['ajaxAction'] == "siteRootCheck") {
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_listView = "SELECT * FROM sys_sites WHERE deleted = '0' AND site_root = '/".$_GET['site_root']."'";
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
	
	//Users : Edit -------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "edit-SysUsers")) {
		$updateSQL = sprintf("UPDATE sys_users SET login_password=%s, login_password_hash=%s, display_name=%s, first_name=%s, last_name=%s, is_admin=%s, user_type=%s, user_timezone=%s, user_dateformat=%s, user_cms_level=%s, user_homepage=%s, user_status=%s, date_modified=%s, modified_by=%s WHERE user_id=%s",
        GetSQLValueString($_POST['login_password'], "text"),
        GetSQLValueString(md5($_POST['login_password']), "text"),
        GetSQLValueString($_POST['display_name'], "text"),
        GetSQLValueString($_POST['first_name'], "text"),
        GetSQLValueString($_POST['last_name'], "text"),
        GetSQLValueString($_POST['is_admin'], "text"),
        GetSQLValueString($_POST['user_type'], "text"),
        GetSQLValueString($_POST['user_timezone'], "text"),
        GetSQLValueString($_POST['user_dateformat'], "text"),
        GetSQLValueString($_POST['user_cms_level'], "text"),
        GetSQLValueString($_POST['user_homepage'], "text"),
        GetSQLValueString($_POST['user_status'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($_POST['user_id'], "text"));

				mysql_select_db($database_ikiosk, $ikiosk);
				$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
				sqlQueryLog($updateSQL);
				
				$updateJS = "$('.page-title').html('".$_POST['display_name']."');\r\n";
				$updateJS .= "$('#editUser-tabs li:first-child a').click();\r\n";
				insertJS($updateJS);
				displayAlert("success", "Changes saved.");
				exit;
		
	}
	
	// Teams: Add Member -------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "edit-AddUserToTeam")) {
		$generateID = create_guid();
		$insertSQL = sprintf("INSERT INTO sys_users2teams (`user_id`, `date_created`, `created_by`, `date_modified`, `modified_by`, `team_id`) VALUES (%s, %s, %s, %s, %s, %s)",
        GetSQLValueString($_POST['add_user'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
				GetSQLValueString($_POST['team_id'], "text"));

    mysql_select_db($database_ikiosk, $ikiosk);
    $Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
    sqlQueryLog($insertSQL);
		
		$js = "$('.jarviswidget-refresh-btn').click();\r\n";
		insertJS($js);
		exit;
	}
	
	// Teams: Create -------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "create-SysTeams")) {
		
		$generateID = create_guid();
$insertSQL = sprintf("INSERT INTO sys_teams (team_id, title, description, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($generateID, "text"),
		GetSQLValueString($_POST['title'], "text"),
        GetSQLValueString($_POST['description'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($_POST['dated_modified'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"));

		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);
		
		//Link Users 2 New Site
		$insertSQL = sprintf("INSERT INTO sys_users2teams (team_id, user_id, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s)",
						GetSQLValueString($generateID, "text"),
						GetSQLValueString($_SESSION['user_id'], "text"),
						GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
						GetSQLValueString($_SESSION['user_id'], "text"),
						GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
						GetSQLValueString($_SESSION['user_id'], "text"));
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		
		if ($_SESSION['user_id'] != "sys-admin") {
		$insertSQL = sprintf("INSERT INTO sys_users2teams (team_id, user_id, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s)",
						GetSQLValueString($generateID, "text"),
						GetSQLValueString("sys-admin", "text"),
						GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
						GetSQLValueString($_SESSION['user_id'], "text"),
						GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
						GetSQLValueString($_SESSION['user_id'], "text"));
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());	
		}
		
		$hideModal= "$('.modal-backdrop').remove(); \r\n";
		insertJS($hideModal." ".$refresh);
		exit;	
	}
	
	// Teams: Edit -------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "edit-SysTeams")) {
			$updateSQL = sprintf("UPDATE sys_teams SET 
	`title`=%s, `description`=%s, `date_modified`=%s, `modified_by`=%s WHERE team_id=%s",
					GetSQLValueString($_POST['title'], "text"),
					GetSQLValueString($_POST['description'], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"),
					GetSQLValueString($_POST['team_id'], "text"));
	
			mysql_select_db($database_ikiosk, $ikiosk);
			$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
			sqlQueryLog($updateSQL);
	
			$updateJS = "$('.page-title').html('".$_POST['title']."');\r\n";
			insertJS($updateJS);
			displayAlert("success", "Changes saved.");
			exit;
	}
	
	include('ajaxCodeGen.php'); // Code Generator
	
	//SysConfig : Edit -------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "edit-SysConfig")) {
	
	$updateSQL = sprintf("UPDATE sys_config SET ikiosk_license_key=%s, system_name=%s, system_url=%s, ikiosk_theme=%s, sys_message_status=%s, sys_message=%s, facebook_app_url=%s, facebook_key=%s, facebook_secret=%s, facebook_app_id=%s, twitter_api=%s, twitter_consumer_key=%s, twitter_consumer_secret=%s, flickr_api_key=%s, flickr_api_secret=%s, flickr_api_permissions=%s, google_site_verification=%s, google_consumer_key=%s, google_consumer_secret=%s, google_analytics_key=%s, google_analytics_profile=%s, youtube_app_url=%s, youtube_client_id=%s, youtube_developer_key=%s, photobucket_key=%s, photobucket_secret=%s, instagram_key=%s, instagram_secret=%s WHERE ikiosk_id=%s",
        GetSQLValueString($_POST['ikiosk_license_key'], "text"),
        GetSQLValueString($_POST['system_name'], "text"),
        GetSQLValueString($_POST['system_url'], "text"),
		GetSQLValueString($_POST['ikiosk_theme'], "text"),
		GetSQLValueString($_POST['sys_message_status'], "text"),
		GetSQLValueString($_POST['sys_message'], "text"),
		GetSQLValueString($_POST['facebook_app_url'], "text"),
        GetSQLValueString($_POST['facebook_key'], "text"),
        GetSQLValueString($_POST['facebook_secret'], "text"),
        GetSQLValueString($_POST['facebook_app_id'], "text"),
        GetSQLValueString($_POST['twitter_api'], "text"),
        GetSQLValueString($_POST['twitter_consumer_key'], "text"),
        GetSQLValueString($_POST['twitter_consumer_secret'], "text"),
        GetSQLValueString($_POST['flickr_api_key'], "text"),
        GetSQLValueString($_POST['flickr_api_secret'], "text"),
        GetSQLValueString($_POST['flickr_api_permissions'], "text"),
        GetSQLValueString($_POST['google_site_verification'], "text"),
        GetSQLValueString($_POST['google_consumer_key'], "text"),
        GetSQLValueString($_POST['google_consumer_secret'], "text"),
        GetSQLValueString($_POST['google_analytics_key'], "text"),
        GetSQLValueString($_POST['google_analytics_profile'], "text"),
        GetSQLValueString($_POST['youtube_app_url'], "text"),
        GetSQLValueString($_POST['youtube_client_id'], "text"),
        GetSQLValueString($_POST['youtube_developer_key'], "text"),
		GetSQLValueString($_POST['photobucket_key'], "text"),
        GetSQLValueString($_POST['photobucket_secret'], "text"),
        GetSQLValueString($_POST['instagram_key'], "text"),
        GetSQLValueString($_POST['instagram_secret'], "text"),		
        GetSQLValueString($_POST['ikiosk_id'], "text"));
				
				mysql_select_db($database_ikiosk, $ikiosk);
				$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
				sqlQueryLog($updateSQL);
				
				displayAlert("success", "Changes saved.");
				exit;
		
	}
	
	// Sites : Edit -------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "edit-SysSites")) {
		
		$updateSQL = sprintf("UPDATE sys_sites SET site_name=%s, site_status=%s, site_status_message=%s, public_home=%s, ikiosk_home=%s, site_url=%s, support_email=%s, site_timezone=%s, site_dateformat=%s, site_css=%s, image_mini_thumbnailX=%s, image_mini_thumbnailY=%s, image_thumbnailX=%s, image_thumbnailY=%s, image_inline=%s, image_resized=%s, force_ssl=%s, facebook_app_url=%s, facebook_key=%s, facebook_secret=%s, facebook_app_id=%s, facebook_permissions=%s, twitter_api=%s, twitter_consumer_key=%s, twitter_consumer_secret=%s, flickr_api_key=%s, flickr_api_secret=%s, flickr_api_permissions=%s, google_site_verification=%s, google_consumer_key=%s, google_consumer_secret=%s, google_analytics_key=%s, google_analytics_profile=%s, google_api_client_id=%s, google_api_client_secret=%s, google_api_redirect_url=%s, google_api_key=%s, youtube_app_url=%s, youtube_client_id=%s, youtube_developer_key=%s, photobucket_key=%s, photobucket_secret=%s, instagram_key=%s, instagram_secret=%s, date_modified=%s, modified_by=%s WHERE site_id=%s",
        GetSQLValueString($_POST['site_name'], "text"),
        GetSQLValueString($_POST['site_status'], "text"),
        GetSQLValueString($_POST['site_status_message'], "text"),
        GetSQLValueString($_POST['public_home'], "text"),
        GetSQLValueString($_POST['ikiosk_home'], "text"),
        GetSQLValueString($_POST['site_url'], "text"),
        GetSQLValueString($_POST['support_email'], "text"),
        GetSQLValueString($_POST['site_timezone'], "text"),
        GetSQLValueString($_POST['site_dateformat'], "text"),
        GetSQLValueString($_POST['site_css'], "text"),
        GetSQLValueString($_POST['image_mini_thumbnailX'], "text"),
        GetSQLValueString($_POST['image_mini_thumbnailY'], "text"),
        GetSQLValueString($_POST['image_thumbnailX'], "text"),
        GetSQLValueString($_POST['image_thumbnailY'], "text"),
        GetSQLValueString($_POST['image_inline'], "text"),
        GetSQLValueString($_POST['image_resized'], "text"),
        GetSQLValueString($_POST['force_ssl'], "text"),
        GetSQLValueString($_POST['facebook_app_url'], "text"),
        GetSQLValueString($_POST['facebook_key'], "text"),
        GetSQLValueString($_POST['facebook_secret'], "text"),
        GetSQLValueString($_POST['facebook_app_id'], "text"),
        GetSQLValueString($_POST['facebook_permissions'], "text"),
        GetSQLValueString($_POST['twitter_api'], "text"),
        GetSQLValueString($_POST['twitter_consumer_key'], "text"),
        GetSQLValueString($_POST['twitter_consumer_secret'], "text"),
        GetSQLValueString($_POST['flickr_api_key'], "text"),
        GetSQLValueString($_POST['flickr_api_secret'], "text"),
        GetSQLValueString($_POST['flickr_api_permissions'], "text"),
        GetSQLValueString($_POST['google_site_verification'], "text"),
        GetSQLValueString($_POST['google_consumer_key'], "text"),
        GetSQLValueString($_POST['google_consumer_secret'], "text"),
        GetSQLValueString($_POST['google_analytics_key'], "text"),
        GetSQLValueString($_POST['google_analytics_profile'], "text"),
				GetSQLValueString($_POST['google_api_client_id'], "text"),
				GetSQLValueString($_POST['google_api_client_secret'], "text"),
				GetSQLValueString($_POST['google_api_redirect_url'], "text"),
				GetSQLValueString($_POST['google_api_key'], "text"),
        GetSQLValueString($_POST['youtube_app_url'], "text"),
        GetSQLValueString($_POST['youtube_client_id'], "text"),
        GetSQLValueString($_POST['youtube_developer_key'], "text"),
				 GetSQLValueString($_POST['photobucket_key'], "text"),
        GetSQLValueString($_POST['photobucket_secret'], "text"),
        GetSQLValueString($_POST['instagram_key'], "text"),
        GetSQLValueString($_POST['instagram_secret'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($_POST['site_id'], "text"));

				mysql_select_db($database_ikiosk, $ikiosk);
				$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
				sqlQueryLog($updateSQL);
				
				$updateJS = "$('.page-title').html('".$_POST['site_name']."');\r\n";
				insertJS($updateJS);
				displayAlert("success", "Changes saved.");
				exit;

		
	}
	
	// Sites : Create -------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "create-SysSites")) {
			$rootFolder = $SYSTEM['ikiosk_filesystem_root']."/sites/".$_POST['site_root'];
			if (!file_exists($rootFolder)) {
					createDIR($rootFolder);	
					createDIR($rootFolder."/blog");
					createDIR($rootFolder."/static");
					createDIR($rootFolder."/admin");
					createDIR($rootFolder."/static/resources");
					createDIR($rootFolder."/static/resources/userfiles");
					createDIR($rootFolder."/static/resources/userphotos");
					
					$generateID = create_guid();
					
					$insertSQL = sprintf("INSERT INTO sys_sites (site_id, site_name, site_url, site_status, public_home, ikiosk_home, site_root, support_email, site_timezone, force_ssl, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($generateID, "text"),
        GetSQLValueString($_POST['site_name'], "text"),
        GetSQLValueString($_POST['site_url'], "text"),
        GetSQLValueString("Active", "text"),
        GetSQLValueString("/index.htm", "text"),
        GetSQLValueString("/webapps/index.php", "text"),
        GetSQLValueString("/".$_POST['site_root'], "text"),
        GetSQLValueString($_POST['support_email'], "text"),
        GetSQLValueString($_POST['site_timezone'], "text"),
        GetSQLValueString($_POST['force_ssl'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"));

				mysql_select_db($database_ikiosk, $ikiosk);
				$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
				sqlQueryLog($insertSQL);
				
				//Link Users 2 New Site
				$insertSQL = sprintf("INSERT INTO sys_users2sites (site_id, user_id, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s)",
								GetSQLValueString($generateID, "text"),
								GetSQLValueString($_SESSION['user_id'], "text"),
								GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
								GetSQLValueString($_SESSION['user_id'], "text"),
								GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
								GetSQLValueString($_SESSION['user_id'], "text"));
				
				mysql_select_db($database_ikiosk, $ikiosk);
				$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
				sqlQueryLog($insertSQL);
				
				
				if ($_SESSION['user_id'] != "sys-admin") {
				$insertSQL = sprintf("INSERT INTO sys_users2sites (site_id, user_id, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s)",
								GetSQLValueString($generateID, "text"),
								GetSQLValueString("sys-admin", "text"),
								GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
								GetSQLValueString($_SESSION['user_id'], "text"),
								GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
								GetSQLValueString($_SESSION['user_id'], "text"));
						
				
				mysql_select_db($database_ikiosk, $ikiosk);
				$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
				sqlQueryLog($insertSQL);
				}
					
				$hideModal= "$('.modal-backdrop').remove(); \r\n";
				insertJS($hideModal." ".$refresh);
   			exit;
			} else {
				displayAlert("danger", "It appears that this site already exists.  Please try again.");	
			}
	}
	
	// Error Codes: Create -------------------------------------------

if ((isset($_POST["formID"])) && ($_POST["formID"] == "create-SysErrors")) {
    $generateID = create_guid();
    $insertSQL = sprintf("INSERT INTO sys_errors (`error_title`, `error_description`) VALUES (%s, %s)",
        GetSQLValueString($_POST['error_title'], "text"),
        GetSQLValueString($_POST['error_description'], "text"));

    mysql_select_db($database_ikiosk, $ikiosk);
    $Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
    sqlQueryLog($insertSQL);
    insertJS($refresh);
    exit;
}

// Error Codes: Edit -------------------------------------------

if ((isset($_POST["formID"])) && ($_POST["formID"] == "edit-SysErrors")) {
    $updateSQL = sprintf("UPDATE sys_errors SET 
`error_title`=%s, `error_description`=%s WHERE error_id=%s",
        GetSQLValueString($_POST['error_title'], "text"),
        GetSQLValueString($_POST['error_description'], "text"),
        GetSQLValueString($_POST['error_id'], "text"));

    mysql_select_db($database_ikiosk, $ikiosk);
    $Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
    sqlQueryLog($updateSQL);

		$updateJS = "$('.page-title').html('".$_POST['error_title']."');\r\n";
		insertJS($updateJS);
    displayAlert("success", "Changes saved.");
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
			
			$updateJS = "$('.page-title').html('".$_POST['application_title']."');\r\n";
	
			insertJS("$('.".$_POST['application_id']." a').hide().text('".$_POST['application_title']."').fadeIn();\r\n"." ".$updateJS);
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
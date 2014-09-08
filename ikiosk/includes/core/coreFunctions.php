<?php
//System Assets
$iKioskPos = strpos($_SERVER['PHP_SELF'], "/ikiosk/");
$iKioskAssetRoot = substr($_SERVER['PHP_SELF'], 0, $iKioskPos); 
$SYSTEM['html_root'] = $iKioskAssetRoot;

//Get Widget Template
function htmlWidget($app, $dir, $templateID, $recordID) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	$response = urlFetch($SYSTEM['system_url']."/ikiosk/webapps/".$dir."/widgetTemplates.php?templateID=".$templateID."&code=".$app."&recordID=".$recordID);
	return $response;
	exit;
}

function tab($count) {
	$response = "";
	$x = 1;
	do {
	$response .="\t";
	$x++;
	} while ($x <= $count); 
	return($response);
}

//New Record Deletion
function deleteRecordv7($table, $field, $record) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	$restrictedID = array("sys-admin", "sys-user", "sys-ikiosk", "sys-cms", "sys-default", "sys-core");
	$byPass = "Yes";
	if ($table == "sys_errors" && $record <= 13) {$byPass = "No";}
	if ($table == "sys_teams" && $record == 1) {$byPass = "No";}
	if ($table == "sys_users" && $record == "sys-admin") {$byPass = "No";}
	if (!in_array($record, $restrictedID) && $byPass == "Yes") {
		$response = array("success", "Item deleted");
		$updateSQL = "UPDATE ".$table." SET deleted = '1' WHERE ".$field." = '".$record."'";
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($updateSQL);
	} else {
		$response = array("danger", "The item you selected is part of the IntelliKiosk core framework and cannot be deleted.");
	}
	return $response;
}

//Write Javascript
function insertJS($script) {
		global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
		$js = "<script type='text/javascript'>".$script."</script>";
		echo $js;
}

//Display Alerts
function displayAlert($type, $message) {
		global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
		$alert = "<div class='alert alert-".$type." fade in'><button class='close' data-dismiss='alert'>×</button>".$message."</div>";
		echo $alert;
}

//Delete Site
function deleteSite($site_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	//Get Site Root
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_sites WHERE site_id = '".$site_id."'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	$siteDir = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getRecords['site_root'];
	recursive_remove_directory($siteDir);
}

//Create New CMS Cloud Account
function cmscloud_createAccount($signupData) {
	
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$cmsCreateAccount = array();
	
	$account_id = create_guid();
	$account_id = preg_replace('[\D]', '', $account_id);
	$account_id = chunk_split($account_id, 4, '-');
	$account_id = substr($account_id, 0, 19);
	
	$user_id = create_guid();
	
	//Create Account
	$insertSQL = sprintf("INSERT INTO cmscloud_accounts (`account_id`, `user_id`, `template_id`, `date_created`, `created_by`, `date_modified`, `modified_by`) VALUES (%s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($account_id, "text"),
			GetSQLValueString($user_id, "text"),
			GetSQLValueString($signupData['template_id'], "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"));
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($insertSQL);
	
	//Create User
	$insertSQL = sprintf("INSERT INTO sys_users (`user_id`, `login_email`, `login_password`, `login_password_hash`, `display_name`, `first_name`, `last_name`, `is_admin`, `user_type`, `user_timezone`, `user_dateformat`, `user_cms_level`, `user_homepage`, `user_status`, `user_photo_id`, `facebook_id`, `youtube_id`, `twitter_id`, `flickr_id`, `date_created`, `created_by`, `date_modified`, `modified_by`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($user_id, "text"),
        GetSQLValueString($signupData['login_email'], "text"),
        GetSQLValueString($signupData['login_password'], "text"),
        GetSQLValueString(md5($signupData['login_password']), "text"),
        GetSQLValueString($signupData['first_name']." ".$signupData['last_name'], "text"),
        GetSQLValueString($signupData['first_name'], "text"),
        GetSQLValueString($signupData['last_name'], "text"),
        GetSQLValueString("No", "text"),
        GetSQLValueString("Standard", "text"),
        GetSQLValueString("6", "text"),
        GetSQLValueString("m/d/y g:i a", "text"),
        GetSQLValueString("112", "text"),
        GetSQLValueString("/ikiosk/webapps/cms/index.php", "text"),
        GetSQLValueString("Active", "text"),
        GetSQLValueString("profile-default", "text"),
        GetSQLValueString($_POST['facebook_id'], "text"),
        GetSQLValueString($_POST['youtube_id'], "text"),
        GetSQLValueString($_POST['twitter_id'], "text"),
        GetSQLValueString($_POST['flickr_id'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"));

		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);

	//Create Team Link
	$insertSQL = sprintf("INSERT INTO sys_users2teams (team_id, user_id, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s)",
	GetSQLValueString("1", "text"),
	GetSQLValueString($user_id, "text"),
	GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
	GetSQLValueString($_SESSION['user_id'], "text"),
	GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
	GetSQLValueString($_SESSION['user_id'], "text"));

	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($insertSQL);
	
	//Create App Permissions
	$insertSQL = sprintf("INSERT INTO sys_permissions (user_id, SYS, IKIOSK, USER, CMS, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
	GetSQLValueString($user_id, "text"),
	GetSQLValueString("000", "text"),
	GetSQLValueString("111", "text"),
	GetSQLValueString("111", "text"),
	GetSQLValueString("112", "text"),
	GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
	GetSQLValueString($_SESSION['user_id'], "text"),
	GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
	GetSQLValueString($_SESSION['user_id'], "text"));

	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($insertSQL);
	
	//Create New Site
	$rootFolder = $SYSTEM['ikiosk_filesystem_root']."/sites/".$signupData['site_name'];
	createDIR($rootFolder);
	createDIR($rootFolder."/static");
	createDIR($rootFolder."/static/resources");
	createDIR($rootFolder."/static/resources/userfiles");
	createDIR($rootFolder."/static/resources/userphotos");
	createDIR($rootFolder."/calendar");
	createDIR($rootFolder."/blog");
	createDIR($rootFolder."/store");
	createDIR($rootFolder."/socialnet");
	createDIR($rootFolder."/api");
	
	
	$site_id = create_guid();
	$site_url = $SYSTEM['system_url']."/sites/".$signupData['site_name'];
	
	$insertSQL = sprintf("INSERT INTO sys_sites (site_id, site_name, site_url, site_status, public_home, ikiosk_home, site_root, support_email, site_timezone, force_ssl, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($site_id, "text"),
        GetSQLValueString($signupData['site_name'], "text"),
        GetSQLValueString($site_url, "text"),
        GetSQLValueString("Active", "text"),
        GetSQLValueString("/index.htm", "text"),
        GetSQLValueString("/webapps/index.php", "text"),
        GetSQLValueString("/".$signupData['site_name'], "text"),
        GetSQLValueString($signupData['login_email'], "text"),
        GetSQLValueString("6", "text"),
        GetSQLValueString("No", "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"));
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($insertSQL);
	
	
	//Default Users
	$insertSQL = sprintf("INSERT INTO sys_users2sites (site_id, user_id, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s)",
			GetSQLValueString($site_id, "text"),
			GetSQLValueString($user_id, "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"));
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($insertSQL);
	
	$insertSQL = sprintf("INSERT INTO sys_users2sites (site_id, user_id, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s)",
			GetSQLValueString($site_id, "text"),
			GetSQLValueString("sys-admin", "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"));
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($insertSQL);
	
	//Create Home & 404
	cmsCreateDefaults($site_id);
	
	//Create Dummy Pages
	cmsCloudDefaults($site_id);
	
	//Download Template
	downloadTemplate($site_id, "/".$signupData['site_name'], $signupData['template_id']);
	
	$cmsCreateAccount['account_id'] = $account_id;
	$cmsCreateAccount['user_id'] = $user_id;
	$cmsCreateAccount['site_id'] = $site_id;
	$cmsCreateAccount['site_url'] = $site_url;
	$cmsCreateAccount['login_email'] = $signupData['login_email'];
	
	return $cmsCreateAccount;
}


//Automatically Update DB
function ikiosk_db_update() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$updateList = urlFetch($SYSTEM['ikiosk_cloud']."/system/api/dbUpdates.php?ikiosk_id=".$SYSTEM['ikiosk_id']."&ikiosk_license_key=".$SYSTEM['ikiosk_license_key']."");
	$updateList = explode("[iKiosk]", $updateList);
	
	foreach($updateList as $key => $value) {
		if (!empty($value[0])) {
		$updateKey = explode("|", $value);
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getRecords = "SELECT * FROM sys_db_update WHERE update_id = '".$updateKey[0]."'";
		$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
		$row_getRecords = mysql_fetch_assoc($getRecords);
		$totalRows_getRecords = mysql_num_rows($getRecords);
		
		if ($totalRows_getRecords == 0) {
			
			//Execute Query	
			mysql_select_db($database_ikiosk, $ikiosk);
			$Result1 = mysql_query($updateKey[1], $ikiosk) or sqlError(mysql_error());
			sqlQueryLog($updateKey[1]);	
			
			
			//Log DB Update
			$insertSQL = sprintf("INSERT INTO sys_db_update (`update_id`, `sql_query`, `date_created`, `created_by`, `date_modified`, `modified_by`) VALUES (%s, %s, %s, %s, %s, %s)",
					GetSQLValueString($updateKey[0], "text"),
					GetSQLValueString($updateKey[1], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"));
			
			mysql_select_db($database_ikiosk, $ikiosk);
			$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
			sqlQueryLog($insertSQL);			
		}
		
	}
	
	}
	
}


//Mobile Functionality
function mobileNavigation() {
	global $ikiosk, $database_ikiosk,  $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
		
	//Get All Master Applications
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_mainMenu = "SELECT * FROM sys_applications WHERE application_type = 'Application' AND application_status = 'Active' AND deleted = '0' ORDER BY application_title";
	$mainMenu = mysql_query($query_mainMenu, $ikiosk) or sqlError(mysql_error());
	$row_mainMenu = mysql_fetch_assoc($mainMenu);
	$totalRows_mainMenu = mysql_num_rows($mainMenu);
	
	do {
		
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_securityMatch = "SELECT * FROM sys_permissions WHERE user_id = '".$_SESSION['user_id']."'";
	$securityMatch = mysql_query($query_securityMatch, $ikiosk) or sqlError(mysql_error());
	$row_securityMatch = mysql_fetch_assoc($securityMatch);
	$totalRows_securityMatch = mysql_num_rows($securityMatch);	
	
	$gpsMatrix = $row_mainMenu['application_code'];
	if ($row_securityMatch[$gpsMatrix] >= $row_mainMenu['application_clearance']) {
		
		$appIcon = "/mobile/library/images/icons/ios/glyphish/19-gear.png";
		switch ($row_mainMenu['application_code']) {
			case "CMS":
				$appIcon = "/mobile/library/images/icons/ios/glyphish/42-photos.png";
				break;
			case "DRBX":
				$appIcon = "/mobile/library/images/icons/ios/glyphish/33-cabinet.png";
				break;
			case "CRM":
				$appIcon = "/mobile/library/images/icons/ios/glyphish/112-group.png";
				break;	
			case "USER":
				$appIcon = "/mobile/library/images/icons/ios/glyphish/111-user.png";
				break;			
			
		}
		
		echo "<li class=\"icon\"><a href=\"".$SYSTEM['html_root']."/ikiosk".$row_mainMenu['application_root']."/index.php\" class=\"outlink\"><img src=\"".$SYSTEM['html_root'].$appIcon."\" />".$row_mainMenu['application_title']."</a></li>";	
	}
		
	} while ($row_mainMenu  = mysql_fetch_assoc($mainMenu));
	
}



//Is App Installed
function checkApp($appCode) {
	global $ikiosk, $database_ikiosk,  $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SHOW COLUMNS FROM sys_permissions WHERE Field = 'CMS'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if ($totalRows_getRecords > 0) {
		return "Active";	
		} else {
		return "Inactive";	
		}
}

//Search Entire Codebase
function codeSyncDir($dir, $prefix = '') {
  ini_set('memory_limit','500M');
  $dir = rtrim($dir, '\\/');
  $result = array();

    $h = opendir($dir);
    while (($f = readdir($h)) !== false) {
      if ($f !== '.' and $f !== '..' and $f !== 'backups' and $f != 'logs' and $f != 'templates' and $f != 'db_conn.php' and $f != 'sql' and $f != 'sandbox'and $f != 'software_apps'and $f != 'cms_templates' and $f != 'sites' and $f != '.git' and $f != '.idea') {
        if (is_dir("$dir/$f")) {
          $result = array_merge($result, codeSyncDir("$dir/$f", "$prefix$f/"));
        } else {
          $result[] = $prefix.$f;
        }
      }
    }
    closedir($h);

  return $result;
}

function codeSyncDirCreate($directory, $recursive) {
	$array_items = array();
		if ($handle = opendir($directory)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if (is_dir($directory. "/" . $file)) {
						if ($file != "system" && $file != "sandbox" && $file != "app_template" && $file != "crm" && $file != "dropbox" && $file != "ikioskmcp" && $file != "itrac"  && $file != "cms_templates" && $file != "store" && $file != "cms" && $file != "clientportal" && $file != ".git" && $file != ".idea") {
							$array_items = array_merge($array_items, codeSyncDirCreate($directory. "/" . $file, $recursive));
							$file = $directory . "/" . $file;
							$array_items[] = preg_replace("/\/\//si", "/", $file);
						}
					} else {
					}
				}
			}
			closedir($handle);
		}
		return $array_items;
}

//Smart Select
function smartSelect($name, $emptylabel, $query, $label, $label2,  $value, $selected, $async) {
	global $ikiosk, $database_ikiosk,  $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	if($async == "yes") {$mod = " class=\"async\" ";}
	
	$smartSelect = "<select name=\"".$name."\" id=\"".$name."\"".$mod.">\r\n";
	$smartSelect .= "<option value=\"\" class=\"inactive\">".$emptylabel."</option>";
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = $query;
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if ($totalRows_getRecords != "0") {
		do {
			$smartSelect .= "<option value = \"".$row_getRecords[$value]."\"";
			if ($row_getRecords[$value] == $selected) {$smartSelect .= " selected ";}
			$smartSelect .= ">".$row_getRecords[$label];
			if (!empty($label2)) {$smartSelect .= " - ".$row_getRecords[$label2];}
			$smartSelect .="</option>";	
		} while ($row_getRecords = mysql_fetch_assoc($getRecords));		
	}
	
	$smartSelect .="</select>";
	
	echo $smartSelect;
}

//Check File Upload
function validFile($sExtension) {
	global $ikiosk, $database_ikiosk,  $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	if (($sExtension != "exe") && ($sExtension != "bat") && ($sExtension != "com") && ($sExtension != "dll") && ($sExtension != "vbs") && ($sExtension != "cgi") && ($sExtension != "htaccess") && ($sExtension != "asis"))  {
	return "valid";	
	} else {
	return "invalid";	
	}
	
}

//Check DB Tables
function checkDBField($table, $field, $query) {
	global $ikiosk, $database_ikiosk,  $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$fieldExists = "No";
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_showColumns = "SHOW COLUMNS FROM ".$table;
	$showColumns = mysql_query($query_showColumns, $ikiosk) or sqlError(mysql_error());
	$row_showColumns = mysql_fetch_assoc($showColumns);
	$totalRows_showColumns = mysql_num_rows($showColumns);
	
	do {
		if ($row_showColumns['Field'] == $field) { $fieldExists = "Yes"; } 
	 } while ($row_showColumns = mysql_fetch_assoc($showColumns));
	
	//Add New Field
	if ($fieldExists == "No") {
		$insertSQL = $query;
		$result = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);
	}
}

//Recurse File List 
  function getFileList($dir, $recurse=true) {
	
	global $ikiosk, $database_ikiosk,  $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	  
    // array to hold return value
    $retval = array();

    // add trailing slash if missing
    if(substr($dir, -1) != "/") $dir .= "/";

    // open pointer to directory and read list of files
    $d = @dir($dir) or die("getFileList: Failed opening directory $dir for reading");
    while(false !== ($entry = $d->read())) {
      // skip hidden files
      if($entry[0] == ".") continue;
      if(is_dir("$dir$entry")) {
        /*$retval[] = array(
          "name" => "$dir$entry/",
          "type" => filetype("$dir$entry"),
          "size" => 0,
          "lastmod" => filemtime("$dir$entry")
        );*/
        if($recurse && is_readable("$dir$entry/")) {
			if ($entry != "_notes" && $entry != "fckeditor" && $entry != "dir_browser" && $entry != "phpmyadmin" && $entry != "logs" && $entry != "backups" && $entry != "system" && $entry != "sites") {
			  $retval = array_merge($retval, getFileList("$dir$entry/", true));
			}
        }
      } elseif(is_readable("$dir$entry")) {
		  
	    $destinationFile = str_replace($SYSTEM['ikiosk_filesystem_root'], "", $dir.$entry);
		$destinationFile = str_replace("//", "/", $destinationFile); 
		
		$file_id = create_guid();
		$packageFile = $file_id.".txt";
		$packageFile = str_replace("-", "", $packageFile);
        
		$sExtension = substr($dir.$entry, ( strrpos($dir.$entry, '.') + 1 ) ) ;
		$sExtension = strtolower($sExtension);
		
		if ($sExtension != "exe")  {
		
			$retval[] = array(
			  "source" => "$dir$entry",
			  "package" => $packageFile,
			  "destination" => $destinationFile
			);
			
		}
      }
    }
    $d->close();

    return $retval;
  } 


//Set Google oAuth Token
function set_googleToken($token) {
	global $ikiosk, $database_ikiosk,  $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$updateSQL = "UPDATE sys_config SET google_api_oauth_token = '".$token."' WHERE ikiosk_id = '".$SYSTEM['ikiosk_id']."'";
	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($updateSQL);
}

//Automated Purge
function auto_purge() {
	global $ikiosk, $database_ikiosk,  $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	//Find Most Recent Backup
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_listView = "SELECT * FROM sys_db_purge WHERE deleted = '0' ORDER BY date_created DESC";
	$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
	$row_listView = mysql_fetch_assoc($listView);
	$totalRows_listView = mysql_num_rows($listView);	
	
	if ($totalRows_listView  != 0) {
		
		$lastupdate = strtotime($row_listView['date_created']);
		$currentdate = time();
		$elapsedtime = $currentdate - $lastupdate;
		
		if ($elapsedtime >= 1209600) {
			ikiosk_purge(); //Standard 14 Day Purge		
		}
		
	} else {
		
		ikiosk_purge(); //First Purge	
	}
	
}

function ikiosk_purge() {
	global $ikiosk, $database_ikiosk,  $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_listView = "SHOW TABLES";
	$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
	$row_listView = mysql_fetch_assoc($listView);
	$totalRows_listView = mysql_num_rows($listView);

	//get all of the tables
	$tables = array();	
	$databaseMAP = "Tables_in_".$database_ikiosk;
	
	do {
		$tables[] = $row_listView[$databaseMAP];	
	} while ($row_listView = mysql_fetch_assoc($listView)); 
	
	ikiosk_backup();
	
	foreach($tables as $table) {
		
		if ($table != "sys_config") {
			$purgeSQL = "DELETE FROM `".$table."` WHERE `deleted` = '1'";
			mysql_select_db($database_ikiosk, $ikiosk);
			$Result1 = mysql_query($purgeSQL, $ikiosk) or sqlError(mysql_error());
			sqlQueryLog($purgeSQL);
		}
	}
	
	//Add to Database
	$generateID = create_guid();
	
	$insertSQL = sprintf("INSERT INTO sys_db_purge (purge_id, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s)",
			GetSQLValueString($generateID, "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"));
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($insertSQL);
}

//Automated Backup
function auto_backup() {
	global $ikiosk, $database_ikiosk,  $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	//Find Most Recent Backup
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_listView = "SELECT * FROM sys_backups WHERE deleted = '0' ORDER BY date_created DESC";
	$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
	$row_listView = mysql_fetch_assoc($listView);
	$totalRows_listView = mysql_num_rows($listView);	
	
	if ($totalRows_listView  != 0) {
		
		$lastupdate = strtotime($row_listView['date_created']);
		$currentdate = time();
		$elapsedtime = $currentdate - $lastupdate;
		
		if ($elapsedtime >= 86400) {
			ikiosk_backup(); //Standard 24hr Backup		
		}
		
	} else {
		
		ikiosk_backup(); //First Backup	
	}
	
}

//Create Database Backup
function ikiosk_backup() {
	
	global $ikiosk, $database_ikiosk,  $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;

	mysql_select_db($database_ikiosk, $ikiosk);
	$query_listView = "SHOW TABLES";
	$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
	$row_listView = mysql_fetch_assoc($listView);
	$totalRows_listView = mysql_num_rows($listView);

	

	//get all of the tables
	$tables = array();	
	$databaseMAP = "Tables_in_".$database_ikiosk;

	do {
		$tables[] = $row_listView[$databaseMAP];	
	} while ($row_listView = mysql_fetch_assoc($listView)); 

	 
  //cycle through
  foreach($tables as $table)
  {
	  
	$return .= "TRUNCATE TABLE `".$table."`;\r\n\r\n";
	  
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_tableData = "SELECT * FROM ".$table."";
	$tableData = mysql_query($query_tableData, $ikiosk) or sqlError(mysql_error());
	$row_tableData = mysql_fetch_assoc($tableData);
	$totalRows_tableData = mysql_num_rows($tableData);
	
			
	do {
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_showColumns = "SHOW COLUMNS FROM ".$table."";
		$showColumns = mysql_query($query_showColumns, $ikiosk) or die(mysql_error());
		$row_showColumns = mysql_fetch_assoc($showColumns);
		$totalRows_showColumns = mysql_num_rows($showColumns);	
		$return .= "INSERT INTO `".$table."` ("; 

		$columnList = "";
		$valueList = "";
		
		do {
			$columnList .= "`".$row_showColumns['Field']."`, ";	
			$valueList  .= "'".addslashes($row_tableData[$row_showColumns['Field']])."', ";
		} while ($row_showColumns = mysql_fetch_assoc($showColumns)); 
		
		$return .= substr($columnList, 0, -2).") VALUES (".substr($valueList, 0, -2).");\r\n\r\n";
	} while ($row_tableData = mysql_fetch_assoc($tableData)); 
	  	
   
  }
  
  $physicalFile = $SYSTEM['ikiosk_filesystem_root']."/backups/".$database_ikiosk."-backup-".date("Y-m-d-gis").".sql";
  $fileName = $database_ikiosk."-backup-".date("Y-m-d-gis").".sql";
  
  //Write To File
	$fh = fopen($physicalFile, 'w+');
	fwrite($fh, $return);
	fclose($fh);
	chmod($physicalFile, 0777);
	
	//Add to Database
	$generateID = create_guid();
	
	$insertSQL = sprintf("INSERT INTO sys_backups (backup_id, backup_file, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s)",
			GetSQLValueString($generateID, "text"),
			GetSQLValueString($fileName, "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"));
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($insertSQL);	
}


//Team Specific User List
function userList($select_name, $team_id, $selected) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_users2teams WHERE team_id = '".$team_id."' AND deleted = '0'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	$userArray = array();
	
	$myTeamOutput = "<select name=\"".$select_name."\" id=\"".$select_name."\">";
	do {
		$user_name = getUserData($row_getRecords['user_id'], "display_name");
		$user_id = getUserData($row_getRecords['user_id'], "user_id");
		$user_row = "<option value=\"".$user_id."\" ";
		if ($user_id == $selected) {$user_row .= " selected ";}
		$user_row .=" >".$user_name."</option>\r\n";
		$userArray[] = $user_row;
	} while ($row_getRecords = mysql_fetch_assoc($getRecords));
	
	asort($userArray);
	$myTeamOutput .= "<option value=\"\"></option>";
		foreach ($userArray as $key => $value) {
			$myTeamOutput .= $value;	
		}
	$myTeamOutput .= "</select>";
	
	echo $myTeamOutput;
	
}

//Display Team Name
function displayTeam($team_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;

	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_teams WHERE team_id = '".$team_id."' AND deleted = '0'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	echo $row_getRecords['title']; 	
}

#Generate Drop Down Menu for Team Selection
function myTeams($name, $selected) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_teamMatrix = "SELECT * FROM sys_users2teams WHERE user_id = '".$_SESSION['user_id']."' AND deleted = '0'";
	$teamMatrix = mysql_query($query_teamMatrix, $ikiosk) or sqlError(mysql_error());
	$row_teamMatrix = mysql_fetch_assoc($teamMatrix);
	$totalRows_teamMatrix = mysql_num_rows($teamMatrix);
	
	if ($totalRows_teamMatrix != "0") {
	$myTeamOutput = "<select name=\"".$name."\">";
	do {
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_teamSync = "SELECT * FROM sys_teams WHERE team_id = '".$row_teamMatrix['team_id']."' AND deleted = '0'";
	$teamSync = mysql_query($query_teamSync, $ikiosk) or sqlError(mysql_error());
	$row_teamSync = mysql_fetch_assoc($teamSync);
	$totalRows_teamSync = mysql_num_rows($teamSync);
	if ($totalRows_teamSync != "0") {
	$myTeamOutput .= "<option value = \"".$row_teamSync['team_id']."\"";
	if ($row_teamSync['team_id'] == $selected) { $myTeamOutput .=" selected "; }
	$myTeamOutput .= ">".$row_teamSync['title']."</option>\r\n";
	}
	} while ($row_teamMatrix = mysql_fetch_assoc($teamMatrix));
	$myTeamOutput .= "</select>";
	}
	echo $myTeamOutput;
}

//Recursive Copy
function copyr($source, $dest) {
    // Check for symlinks
    if (is_link($source)) {
        return symlink(readlink($source), $dest);
    }
 
    // Simple copy for a file
    if (is_file($source)) {
        return copy($source, $dest);
    }
 
    // Make destination directory
    if (!is_dir($dest)) {
        mkdir($dest, 0777);
    }
 
    // Loop through the folder
    $dir = dir($source);
    while (false !== $entry = $dir->read()) {
        // Skip pointers
        if ($entry == '.' || $entry == '..' || $entry == '.svn' || $entry == '.DS_Store' ) {
            continue;
        }
 
        // Deep copy directories
        copyr("$source/$entry", "$dest/$entry");
    }
 
    // Clean up
    $dir->close();
    return true;
}
//Total Sites
function siteCount() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_listView = "SELECT * FROM sys_sites WHERE deleted = '0' AND site_status = 'Active'";
	$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
	$row_listView = mysql_fetch_assoc($listView);
	$totalRows_listView = mysql_num_rows($listView);
	
	return $totalRows_listView;
}


//Total Users
function userCount() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_listView = "SELECT * FROM sys_users WHERE deleted = '0' AND user_type = 'Internal' AND user_status = 'Active'";
	$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
	$row_listView = mysql_fetch_assoc($listView);
	$totalRows_listView = mysql_num_rows($listView);
	
	return $totalRows_listView;
}

//Get License Information 
function getLicense() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	$licenseData = urlFetch($SYSTEM['ikiosk_cloud']."/system/api/license.php?ikiosk_id=".$SYSTEM['ikiosk_id']."&ikiosk_license_key=".$SYSTEM['ikiosk_license_key']."");
	$licenseData = explode("|", $licenseData);
	$_SESSION['license_cloud_id'] = $licenseData[0];
	$_SESSION['license_type'] = $licenseData[6];
	$_SESSION['license_account'] = $licenseData[4];
	$_SESSION['license_url'] = $licenseData[5];
	$_SESSION['license_expire'] = timezoneProcess($licenseData[7], "return");
	$_SESSION['license_users'] = $licenseData[8];
	$_SESSION['license_sites'] = $licenseData[9];
	$_SESSION['license_status'] = $licenseData[10];
	$_SESSION['license_issue'] = timezoneProcess($licenseData[11], "return");
	
	//License Expiration
	if ($licenseData[7] <= $SYSTEM['mysql_datetime']) {
		$_SESSION['license_expired'] = "Yes";	
	} else {
		$_SESSION['license_expired'] = "No";
	}
	
	//Max Users
	if ($licenseData[8] <= $SYSTEM['active_users']) {
		$_SESSION['license_user_max'] = "Yes";	
	} else {
		$_SESSION['license_user_max'] = "No";
	}
	
	//Max Sites
	if ($licenseData[9] <= $SYSTEM['active_sites']) {
		$_SESSION['license_site_max'] = "Yes";	
	} else {
		$_SESSION['license_site_max'] = "No";
	}
}

//Get Remote URL File
function urlFetch($remoteURL) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	$content = file_get_contents($remoteURL);
	if ($content == "") {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $remoteURL); 
		curl_setopt($ch, CURLOPT_HEADER, 0); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$content = curl_exec($ch); 
		curl_close($ch); 
	}
   return $content;	
}

//Convert Form Dates
function smartDates($thisDate) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	if (!empty($thisDate)) {
		$thisDate = strtotime($thisDate);
		$transformTime = date("Y-m-d H:i:s", $thisDate);
	}
	return $transformTime;
	
}
//Messaging Smart Recipients
function selectRecipient($type, $display, $field, $unique_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$recipientOutput = "";
	
	if ($type == "team") {
	$query_getRecords = "SELECT * FROM sys_teams WHERE deleted = '0' AND ".$_SESSION['team_filter']." ORDER BY title ASC";
	}
	
	if ($type == "site") {
	$query_getRecords = "SELECT * FROM sys_sites WHERE deleted = '0' AND ".$_SESSION['team_filter']." AND ".$_SESSION['site_filter']." ORDER BY site_name ASC";
	}
	
	if ($type == "user") {
	$query_getRecords = "SELECT * FROM sys_users WHERE deleted = '0' AND user_type = 'Internal' ORDER BY display_name ASC";
	}
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if ($totalRows_getRecords != "0") {
		do {
		$recipientOutput .="<tr><td class=\"chk_box\"><input type=\"checkbox\" name=\"".$field."[]\" value=\"".$row_getRecords[$unique_id]."\" /></td><td>".$row_getRecords[$display]."</td></tr>\r\n";
		} while ($row_getRecords  = mysql_fetch_assoc($getRecords));	
	}
	
	echo $recipientOutput;

}

//Get Recipient Type 
function getRecipent($recipient_id, $recipient_type) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$recipient = "";
	
	//User
	if ($recipient_type == "user") {
		$recipient = getUserData($recipient_id, "display_name");	
	}
	
	//Site
	if ($recipient_type == "site") {
		$recipient = "[Site: ".getSiteData($recipient_id, "site_name")."]";	
	}

	//Team
	if ($recipient_type == "team") {
		$recipient = "[Team: ".getTeamData($recipient_id, "title")."]";	
	}
	
	//System
	if ($recipient_type == "system") {
		
		
		$recipient = "All Users";
	}
	
	return $recipient;
	
	
}
// Only Returns User Avatar for Messaging
function smartAvatar($user_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$photo_id = getUserData($user_id, "user_photo_id");
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_photos WHERE photo_id = '".$photo_id."' AND ".$_SESSION['team_filter']." AND deleted = '0'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	$avatar =  $SYSTEM['ikiosk_root'].$row_getRecords['image_mini_thumbnail'];
	return $avatar;
	
}

//Displays User Avatar
function displayAvatar($user_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$photo_id = getUserData($user_id, "user_photo_id");
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_photos WHERE photo_id = '".$photo_id."' AND ".$_SESSION['team_filter']." AND deleted = '0'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	$avatar =  "<img src=\"".$SYSTEM['ikiosk_root'].$row_getRecords['image_mini_thumbnail']."\" />";
	return $avatar;
}

function getAvatar($user_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$photo_id = getUserData($user_id, "user_photo_id");
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_photos WHERE photo_id = '".$photo_id."' AND ".$_SESSION['team_filter']." AND deleted = '0'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	$avatar =  $SYSTEM['ikiosk_root'].$row_getRecords['image_mini_thumbnail'];
	echo $avatar;
}

//Check to See If Site Exists
function checkSite($shortname) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$siteExists = "No";
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_sites WHERE site_root = '/".$shortname."' AND deleted = '0'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if ($totalRows_getRecords == 0) {
		$siteExists = "No";
	} else {
		$siteExists = "Yes";
	}
	
	return $siteExists;
}


//Check to See If User Exists
function checkUser($login_email) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$userExists = "No";
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_users WHERE login_email = '".$login_email."' AND deleted = '0'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if ($totalRows_getRecords == 0) {
		$userExists = "No";
	} else {
		$userExists = "Yes";
	}
	
	return $userExists;
}


function addSite2User($user_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$siteList = "";
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_sites WHERE deleted = '0' ORDER BY site_name ASC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	do {
		$siteLink = checkSiteLink($row_getRecords['site_id'], $user_id);
		if ($siteLink == "No") {
		$siteList .= "<option value=\"".$row_getRecords['site_id']."\">".$row_getRecords['site_name']."</option>\r\n";	
		}
	} while ($row_getRecords  = mysql_fetch_assoc($getRecords));
	
	return $siteList;

}


//Add Software to License
function addSoftware2License($cloud_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$teamList = "";
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM ikioskcloud_software WHERE deleted = '0' ORDER BY software_title ASC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	do {
		$teamLink = checkSoftwareLink($row_getRecords['software_id'], $cloud_id);
		if ($teamLink == "No") {
		$teamList .= "<option value=\"".$row_getRecords['software_id']."\">".$row_getRecords['software_title']."</option>\r\n";	
		}
	} while ($row_getRecords  = mysql_fetch_assoc($getRecords));
	
	return $teamList;

}

//Check Software Link
function checkSoftwareLink($software_id, $cloud_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$teamLink = "No";
	
	//Get Site Image Properties
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM ikioskcloud_license2software WHERE deleted = '0' AND cloud_id = '".$cloud_id."' AND software_id='".$software_id."' AND deleted = '0'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if ($totalRows_getRecords != "0") {
		$teamLink = "Yes";	
	}
	return $teamLink;
}


// Add Team to User
function addTeam2User($user_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$teamList = "";
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_teams WHERE deleted = '0' ORDER BY title ASC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	do {
		$teamLink = checkTeamLink($row_getRecords['team_id'], $user_id);
		if ($teamLink == "No") {
		$teamList .= "<option value=\"".$row_getRecords['team_id']."\">".$row_getRecords['title']."</option>\r\n";	
		}
	} while ($row_getRecords  = mysql_fetch_assoc($getRecords));
	
	return $teamList;

}

//Add Users to Site
function addUser2Site($site_id) { //Excludes this Team

	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$userList = "";
	
	//Get Site Image Properties
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_users WHERE deleted = '0' ORDER BY display_name ASC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	do {
		$siteLink = checkSiteLink($site_id, $row_getRecords['user_id']);
		if ($siteLink == "No") {
		$userList .= "<option value=\"".$row_getRecords['user_id']."\">".$row_getRecords['display_name']."</option>\r\n";	
		}
	} while ($row_getRecords  = mysql_fetch_assoc($getRecords));
	
	return $userList;
}

function checkSiteLink($site_id, $user_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$siteLink = "No";
	
	//Get Site Image Properties
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_users2sites WHERE deleted = '0' AND user_id = '".$user_id."' AND site_id='".$site_id."' AND deleted = '0'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if ($totalRows_getRecords != "0") {
		$siteLink = "Yes";	
	}
	return $siteLink;
}

//Select Users 
function addUser2Team($team_id) { //Excludes this Team

	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$userList = "";
	
	//Get Site Image Properties
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_users WHERE deleted = '0' ORDER BY display_name ASC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	do {
		$teamLink = checkTeamLink($team_id, $row_getRecords['user_id']);
		if ($teamLink == "No") {
		$userList .= "<option value=\"".$row_getRecords['user_id']."\">".$row_getRecords['display_name']."</option>\r\n";	
		}
	} while ($row_getRecords  = mysql_fetch_assoc($getRecords));
	
	return $userList;
}

//Checks to See if Users is member of team
function checkTeamLink($team_id, $user_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$teamLink = "No";
	
	//Get Site Image Properties
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_users2teams WHERE deleted = '0' AND user_id = '".$user_id."' AND team_id='".$team_id."' AND deleted = '0'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if ($totalRows_getRecords != "0") {
		$teamLink = "Yes";	
	}
	return $teamLink;
}

//Photo Upload Function
function uploadPhoto($site_id, $album_id, $team_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	
	if (!empty($_FILES['Image']['name'])) {
	if ($_FILES['Image']['error'] == UPLOAD_ERR_OK) {
	
	//Get Site Image Properties
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_sites WHERE site_id = '".$site_id."' AND ".$_SESSION['team_filter']." AND deleted = '0'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	
	//Image Resize Definitions
	$photoThumbSizeX = $row_getRecords['image_thumbnailX'];
	$photoThumbSizeY = $row_getRecords['image_thumbnailY'];
	$photoInlineSize = $row_getRecords['image_inline'];
	$photoFullSize = $row_getRecords['image_resized'];
	$photoMiniThumbSizeX = $row_getRecords['image_mini_thumbnailX'];
	$photoMiniThumbSizeY = $row_getRecords['image_mini_thumbnailY'];
	
	//Generate ID
	$generateID = create_guid();
	$generateID = str_replace("-", "", $generateID);
	
	$siteFileRoot = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getRecords['site_root'];
	
	$fileID = $siteFileRoot."/static/resources/userphotos/".$generateID;
	$fileurl = $_FILES['Image']['name'];
	$sExtension = substr( $fileurl, ( strrpos($fileurl, '.') + 1 ) ) ;
	$sExtension = strtolower( $sExtension );
	$fileID = $fileID.".".$sExtension;
	$fileLocation = "/static/resources/userphotos/".$generateID.".".$sExtension;
	$baseFile = $generateID.".".$sExtension;
	
	//Check Extension & Process Upload
	if (($sExtension == "jpg") || ($sExtension == "jpeg") || ($sExtension == "png"))  {
		
	//Move Image File for Processing
	move_uploaded_file($_FILES['Image']['tmp_name'], $fileID);
	chmod($fileID, 0777);
	
	//Get Image Original File Size
	$imagesize = getimagesize($fileID);
	$width = $imagesize[0];
	$height = $imagesize [1];
	
	//Create Mini Image
	$mini_thumbnail_ID = create_guid();
	$mini_thumbnail_ID = str_replace("-", "", $mini_thumbnail_ID); 
	$imageEditor = new ImageEditor($baseFile, $siteFileRoot."/static/resources/userphotos/");
							
	//Find Crop Controller
	if ($width >= $height) {
	$thumbDif =  $photoMiniThumbSizeY/$height;
	$thumbX =  $width*$thumbDif;
	$thumbY = $photoMiniThumbSizeY;
	}
	
	if ($width <= $height) {
	$thumbDif =  $photoMiniThumbSizeX/$width;
	$thumbX =  $photoMiniThumbSizeX;
	$thumbY = $height*$thumbDif;
	} 
							
	$imageEditor->resize($thumbX, $thumbY);				
	$imageEditor->crop(0, 0, $photoMiniThumbSizeX, $photoMiniThumbSizeY);

	$mini_thumbnail = $mini_thumbnail_ID.".".$sExtension;
	$imageEditor->outputFile($mini_thumbnail, $siteFileRoot."/static/resources/userphotos/");
	$mini_thumbnail_url = "/static/resources/userphotos/".$mini_thumbnail;
	
	//Create Thumbnail Image
	$thumbnail_ID = create_guid();
	$thumbnail_ID = str_replace("-", "", $thumbnail_ID); 
	$imageEditor = new ImageEditor($baseFile, $siteFileRoot."/static/resources/userphotos/");
							
	//Find Crop Controller
	if ($width >= $height) {
	$thumbDif =  $photoThumbSizeY/$height;
	$thumbX =  $width*$thumbDif;
	$thumbY = $photoThumbSizeY;
	}
	if ($width <= $height) {
	$thumbDif =  $photoThumbSizeX/$width;
	$thumbX =  $photoThumbSizeX;
	$thumbY = $height*$thumbDif;
	} 
							
	$imageEditor->resize($thumbX, $thumbY);				
	$imageEditor->crop(0, 0, $photoThumbSizeX, $photoThumbSizeY);

	$thumbnail = $thumbnail_ID.".".$sExtension;
	$imageEditor->outputFile($thumbnail, $siteFileRoot."/static/resources/userphotos/");
	$thumbnail_url = "/static/resources/userphotos/".$thumbnail;
							
	//Create Inline Image
	$imageinline_ID = create_guid();
	$imageinline_ID = str_replace("-", "", $imageinline_ID);
	if ($width > $photoInlineSize) {
	$sizeDifference  = $photoInlineSize/$width;
	$newwidth = $photoInlineSize;
	$newheight = $height*$sizeDifference;
	$imageEditor = new ImageEditor($baseFile, $siteFileRoot."/static/resources/userphotos/");
	$imageEditor->resize($newwidth, $newheight);
	$imageinline = $imageinline_ID.".".$sExtension;
	$imageEditor->outputFile($imageinline, $siteFileRoot."/static/resources/userphotos/");
	$imageInline_url = "/static/resources/userphotos/".$imageinline;
	}
							
	if ($width <= $photoInlineSize) {
	$sizeDifference  = $width/$width;
	$newwidth = $width;
	$newheight = $height*$sizeDifference;
	$imageEditor = new ImageEditor($baseFile, $siteFileRoot."/static/resources/userphotos/");
	$imageEditor->resize($newwidth, $newheight);
	$imageinline = $imageinline_ID.".".$sExtension;
	$imageEditor->outputFile($imageinline, $siteFileRoot."/static/resources/userphotos/");
	$imageInline_url = "/static/resources/userphotos/".$imageinline;
	}
							
	//Create Fullsized Image
	$resizedID = create_guid();
	$resizedID = str_replace("-", "", $resizedID);
	if ($width > $photoFullSize) {
	$sizeDifference  = $photoFullSize/$width;
	$newwidth = $photoFullSize;
	$newheight = $height*$sizeDifference;
	$imageEditor = new ImageEditor($baseFile, $siteFileRoot."/static/resources/userphotos/");
	$imageEditor->resize($newwidth, $newheight);
	$image_resized = $resizedID.".".$sExtension;
	$imageEditor->outputFile($image_resized, $siteFileRoot."/static/resources/userphotos/");
	$imageResized_url = "/static/resources/userphotos/".$image_resized;
	}
							
	if ($width <= $photoFullSize) {
	$sizeDifference  = $width/$width;
	$newwidth = $width;
	$newheight = $height*$sizeDifference;
	$imageEditor = new ImageEditor($baseFile, $siteFileRoot."/static/resources/userphotos/");
	$imageEditor->resize($newwidth, $newheight);
	$image_resized = $resizedID.".".$sExtension;
	$imageEditor->outputFile($image_resized, $siteFileRoot."/static/resources/userphotos/");
	$imageResized_url = "/static/resources/userphotos/".$image_resized;
	}
	
	//Insert into Database	
	$generateID = create_guid();

$insertSQL = sprintf("INSERT INTO sys_photos (photo_id, site_id, album_id, title, description, file_name, file_size, image_mini_thumbnail, image_thumbnail, image_inline, image_resized, image_original, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($generateID, "text"),
        GetSQLValueString($site_id, "text"),
        GetSQLValueString($album_id, "text"),
        GetSQLValueString($_POST['title'], "text"),
        GetSQLValueString($_POST['description'], "text"),
		GetSQLValueString($_FILES['Image']['name'], "text"),
		GetSQLValueString($_FILES['Image']['size'], "text"),
		GetSQLValueString($mini_thumbnail_url, "text"),
		GetSQLValueString($thumbnail_url, "text"),
		GetSQLValueString($imageInline_url, "text"),
		GetSQLValueString($imageResized_url, "text"),
		GetSQLValueString($fileLocation, "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"));

	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($insertSQL);
	
	return $generateID;
	
	} else {
	header("Location: ".$SYSTEM['html_root'].$SYSTEM['ikiosk_root']."/error.php?error=11");
	exit;
	}
	
	}
	}
}

//Create Directory
function createDIR($dirPath) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	if (!file_exists($dirPath)) {
		if (!mkdir($dirPath, 0777)) {
			errorLog("Unable to create directory: ".$dirPath, "System Error", $redirect);	
		}
	}
}

//Display Image
function displayImage($photo_id, $display_type, $outputType) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_photos WHERE photo_id = '".$photo_id."' AND ".$_SESSION['team_filter']." AND deleted = '0'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
		
	if ($totalRows_getRecords != "0") {
		if ($outputType == "return") {
		 return $row_getRecords[$display_type];
		}
		if ($outputType == "print") {
		 echo $row_getRecords[$display_type];
		}
	}
}

//CrossQuery Data
function crossReference($table, $unique_key, $unique_id, $subQuery, $teamFilter, $siteFilter, $returnField, $outputType) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$smartQuery = "SELECT * FROM ".$table." WHERE ".$unique_key." = '".$unique_id."' AND deleted = '0'";
	if (!empty($subQuery)){ $smartQuery .= " AND ".$subQuery; } //SubQuery
	if ($teamFilter == "Yes") { $smartQuery .= " AND ".$_SESSION['team_filter']; } //Team Filter
	if ($siteFilter == "Yes") { $smartQuery .= " AND ".$_SESSION['site_filter']; } //Site Filter
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = $smartQuery;
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if ($totalRows_getRecords != "0") {
		if ($outputType == "return") {
		 return $row_getRecords[$returnField];
		}
		if ($outputType == "print") {
		 echo $row_getRecords[$returnField];
		}
	}

}

//Mass Update
function massUpdate($table, $unique_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	if (!empty($_POST['iKioskMassUpdate']) && ($_POST['iKioskMassUpdate'] == "Yes")) {
	
	//Special Functions ***************************
	
	//Add Team Member
	if (($_POST['addTeamMember'] == "Yes") && ($_POST['add_user'] != "")) { 
		$user_id = $_POST['add_user'];
		$team_id = $_POST['add_team'];
		$insertSQL = "INSERT INTO `sys_users2teams` (`team_id`, `user_id`, `date_created`, `created_by`, `date_modified`, `modified_by`) VALUES
('".$team_id."', '".$user_id."', '".$SYSTEM['mysql_datetime']."', '".$_SESSION['user_id']."', '".$SYSTEM['mysql_datetime']."', '".$_SESSION['user_id']."')";
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);
		
		$systemMessage = "<div class=\"notification success\">Team members updated...</div>";	
	}
	
	//Add Site Member
	if (($_POST['addSiteMember'] == "Yes") && ($_POST['add_user'] != "")) { 
		$user_id = $_POST['add_user'];
		$site_id = $_POST['add_site'];
		$insertSQL = "INSERT INTO `sys_users2sites` (`site_id`, `user_id`, `date_created`, `created_by`, `date_modified`, `modified_by`) VALUES
('".$site_id."', '".$user_id."', '".$SYSTEM['mysql_datetime']."', '".$_SESSION['user_id']."', '".$SYSTEM['mysql_datetime']."', '".$_SESSION['user_id']."')";
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);
		
		$systemMessage = "<div class=\"notification success\">User access list updated...</div>";	
	}		
	
	
	//Mass Update Functions ***************************
	if (!empty($_POST['recordID'])) {
	foreach ($_POST['recordID'] as $key=>$value) {
	//Delete Record
	if ($_POST['listview_action'] == "delete") {
			
		$deleteByPass = "Yes";
		
		//Record Checks
		if (($table == "sys_teams") && ($value == "sys-core" || $value == "1")) { // Core Teams
			$deleteByPass = "No";			
		}
		
		if (($table == "sys_applications") && ($value == "sys-user" || $value == "sys-admin")) { // Core App
			$deleteByPass = "No";
		}
		
		if (($table == "sys_errors") && ($value <= 13)) { // Error Codes
			$deleteByPass = "No";
		}
		
		if (($table == "sys_sites") && ($value == "sys-default")) { // Default Site
			$deleteByPass = "No";
		}
		
		$protected = substr($value, 0, 6);
		if ($protected == "ikiosk") {
			$deleteByPass = "No";
		}
		
		//Process Delete
		if ($deleteByPass == "Yes") {
			if ($table == "sys_sites") { deleteSite($unique_id); }
			$systemMessage = deleteRecord($table, $unique_id, $value);
			} else {
			$systemMessage = "<div class=\"notification error\">The records that you are attempting to delete are part of the IntelliKiosk system core and cannot be deleted.</div>";	
			}
	} // End Delete
	} // End ForEach
	} // End If Filter
	}
	
	return $systemMessage;
}

//Delete Records
function deleteRecord($table, $unique_id, $record_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$updateSQL = "UPDATE ".$table." SET deleted = '1' WHERE ".$unique_id." = '".$record_id."'";
	
	$systemMessage = "<div class=\"notification success\">Records deleted...</div>";
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($updateSQL);

	return $systemMessage;
}

//Mobile Feature
function iKioskMobile() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$mobileFile = str_replace("/ikiosk/", "/mobile/", $_SERVER['SCRIPT_NAME']);
	$mobileFileRoot = $SYSTEM['ikiosk_filesystem_root'].$mobileFile;
	
	if ((file_exists($mobileFileRoot)) && ($mobileFile != $_SERVER['SCRIPT_NAME'])) {
		if (!empty($_SERVER['QUERY_STRING'])) { 
			$mobileRedirect = $mobileFile."?".$_SERVER['QUERY_STRING'];
			} else {
			$mobileRedirect = $mobileFile."?v=0";
		}
		header("Location: ".$mobileRedirect."");
		exit;
	}
}

//Display Logo
function displayLogo($site_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_sites WHERE site_id = '".$site_id."' AND ".$_SESSION['team_filter']." AND deleted = '0'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if (empty($SITE['ikiosk_home'])) {
		$SITE['ikiosk_home'] = $SYSTEM['html_root'].$SYSTEM['ikiosk_root']."/webapps/users/index.php";	
	}
	
	if (empty($row_getRecords['site_logo'])) {
	$logoDisplay = "<a href=\"".$SYSTEM['html_root'].$USER['user_homepage']."\"><img src=\"".$SYSTEM['html_root'].$SYSTEM['ikiosk_root']."/library/images/ui/logo.png\" border=\"0\" /></a>";	
	} else {
	$logoImage = displayImage($row_getRecords['site_logo'], "image_inline", "return");
	$logoDisplay = "<a href=\"".$SYSTEM['html_root'].$USER['user_homepage']."\"><img src=\"".$SYSTEM['html_root']."/sites".$row_getRecords['site_root']."".$logoImage."\" border=\"0\" /></a>";	
	}
	echo $logoDisplay;
}

//Global Navigation
function globalNavigation() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	//Get All Master Applications
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_mainMenu = "SELECT * FROM sys_applications WHERE application_type = 'Application' AND application_status = 'Active' AND deleted = '0' ORDER BY application_title";
	$mainMenu = mysql_query($query_mainMenu, $ikiosk) or sqlError(mysql_error());
	$row_mainMenu = mysql_fetch_assoc($mainMenu);
	$totalRows_mainMenu = mysql_num_rows($mainMenu);
	
	do {
		
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_securityMatch = "SELECT * FROM sys_permissions WHERE user_id = '".$_SESSION['user_id']."'";
	$securityMatch = mysql_query($query_securityMatch, $ikiosk) or sqlError(mysql_error());
	$row_securityMatch = mysql_fetch_assoc($securityMatch);
	$totalRows_securityMatch = mysql_num_rows($securityMatch);	
	
	$gpsMatrix = $row_mainMenu['application_code'];
	if ($row_securityMatch[$gpsMatrix] >= $row_mainMenu['application_clearance']) {
		
		$menufile = $SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root'].$row_mainMenu['application_root']."/globalnav.php";
		
		if (file_exists($menufile)) {require($menufile);}
	}
		
	} while ($row_mainMenu  = mysql_fetch_assoc($mainMenu));
	
}

//Get Websites List
function getWebsites() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getSites = "SELECT * FROM sys_sites WHERE deleted = '0' AND ".$_SESSION['site_filter']." ORDER BY site_name ASC";
	$getSites = mysql_query($query_getSites, $ikiosk) or sqlError(mysql_error());
	$row_getSites = mysql_fetch_assoc($getSites);
	$totalRows_getSites = mysql_num_rows($getSites);
	
	$messageOutput = "";
	
	if ($totalRows_GetSites != "0") {
		do {	
		
		//Identify Active SIte
		if ($row_getSites['site_id'] == $_SESSION['site_id']) {
			$activeSite = " activeSite";
			} else {
			$activeSite = "";
			}
		
		$messageOutput .= "<div class=\"message\">";
		$messageOutput .="<div class=\"sitename".$activeSite."\"><a href=\"".$SYSTEM['current_page']."&switchSite=1&site_id=".$row_getSites['site_id']."\">".$row_getSites['site_name']."</a></div>";
		$messageOutput .="<div class=\"sitelinks\"><a href=\"".$row_getSites['site_url']."\" target=\"_blank\">view website</a> ";
		
		if ($SYSTEM['is_basic'] == "No") {
		$messageOutput .="| <a href=\"".$SYSTEM['html_root']."/ikiosk/webapps/administration/editSite.php?recordID=".$row_getSites['site_id']."\">admin</a>";
		}
		
		$messageOutput .="</div>";

		$messageOutput .="</div>";
		} while ($row_getSites = mysql_fetch_assoc($getSites));	
	}
	
	echo $messageOutput;

}

//Get Message Status
function getMessageStatus($message_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getMessage = "SELECT * FROM sys_message_tracker WHERE deleted = '0' AND message_id = '".$message_id."' AND user_id = '".$_SESSION['user_id']."'";
	$getMessage = mysql_query($query_getMessage, $ikiosk) or sqlError(mysql_error());
	$row_getMessage = mysql_fetch_assoc($getMessage);
	$row_getMessage['count'] = mysql_num_rows($getMessage);
	
	if ($row_getMessage['count'] == "0") {
		$messageStatus = "New";	
	} else {
		$messageStatus = "Read";		
	}
	
	return $messageStatus;
}

//Add Message Tracker 
function markMessageRead($message_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$insertSQL = sprintf("INSERT INTO sys_message_tracker (message_id, user_id, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s)",
        GetSQLValueString($message_id, "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"));

	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
	
}

//Get Message Specific Data
function getMessageData($message_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getMessage = "SELECT * FROM sys_messages WHERE deleted = '0' AND message_id = '".$message_id."'";
	$getMessage = mysql_query($query_getMessage, $ikiosk) or sqlError(mysql_error());
	$row_getMessage = mysql_fetch_assoc($getMessage);
	$row_getMessage['count'] = mysql_num_rows($getMessage);
	
	return $row_getMessage;
}


//Get Message of Type and Return Array
function getMessageList($type) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	if ($type == "user") { $modQuery = " AND recipient_type = 'user' "; }
	if ($type == "site") { $modQuery = " AND recipient_type = 'site' "; }
	if ($type == "team") { $modQuery = " AND recipient_type = 'team' "; }
	if ($type == "system") { $modQuery = " AND recipient_type = 'system' "; }
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getMessages = "SELECT * FROM sys_message_recipients WHERE deleted = '0' AND ".$SYSTEM['message_filter'].$modQuery." ORDER BY date_created DESC";
	$getMessages = mysql_query($query_getMessages, $ikiosk) or sqlError(mysql_error());
	$row_getMessages = mysql_fetch_assoc($getMessages);
	$row_getMessages['count'] = mysql_num_rows($getMessages);
	
	$messages = array();
	$messageCount = 0;
	do {
		foreach ($row_getMessages as $key => $value) {
			$messages[$messageCount][$key] = $value;	
		}
		$messageCount++;
	} while ($row_getMessages = mysql_fetch_assoc($getMessages));
	
	return $messages;
}

//Messaging System
function getMessages($type, $dataReturn) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$totalMessages = 0;	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getMessages = "SELECT * FROM sys_message_recipients WHERE deleted = '0' AND ".$SYSTEM['message_filter']." ORDER BY date_created DESC";
	$getMessages = mysql_query($query_getMessages, $ikiosk) or sqlError(mysql_error());
	$row_getMessages = mysql_fetch_assoc($getMessages);
	$totalRows_getMessages = mysql_num_rows($getMessages);
	$row_getMessage['count'] = $totalRows_getMessages;
	
	if ($dataReturn == "count") {
		if ($totalRows_getMessages != 0) {
			do {
				$status = getMessageStatus($row_getMessages['message_id']);
				if ($status == "New") {$totalMessages++;}	
			} while ($row_getMessages = mysql_fetch_assoc($getMessages));
		}
		
		$messageOutput = $totalMessages;
	}
		
	if ($dataReturn == "quicklist") {
		if ($totalRows_getMessages != "0") {
			do {
				$status = getMessageStatus($row_getMessages['message_id']);
				$messageData = getMessageData($row_getMessages['message_id']);
				if ($status == "New") {
					$messageOutput .= "<div class=\"message\">";
					$messageOutput .= "<div class=\"author\">".getUserData($row_getMessages['sender_id'], "display_name")."</div>";
					$messageOutput .= "<div class=\"content\"><a href=\"".$SYSTEM['html_root'].$SYSTEM['ikiosk_root']."/webapps/users/viewMessage.php?recordID=".$row_getMessages['message_id']."\">".$messageData['subject']."</a></div>";
					$messageOutput .= "<div class=\"datetime\">".timezoneProcess($messageData['date_created'], "return")."</div>";
					$messageOutput .= "</div>";
				}
				
			} while ($row_getMessages = mysql_fetch_assoc($getMessages));
		} else {
				$messageOutput = "<div>No new messages...</div>";
		}
	}
	
	echo $messageOutput; 
	
}


//Timezone Processor
function timezoneProcessDate($timeCode, $dataProcess) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	if (!empty($timeCode)) {
		$timeCode = strtotime($timeCode);
		$convertDate = "";
	if ($USER['user_timezone'] == "1") {$convertDate = date("m/d/Y", $timeCode - 18000);}
	if ($USER['user_timezone'] == "2") {$convertDate = date("m/d/Y", $timeCode - 14400);}
	if ($USER['user_timezone'] == "3") {$convertDate = date("m/d/Y", $timeCode - 10800);}
	if ($USER['user_timezone'] == "4") {$convertDate = date("m/d/Y", $timeCode - 7200);}
	if ($USER['user_timezone'] == "5") {$convertDate = date("m/d/Y", $timeCode - 3600);}
	if ($USER['user_timezone'] == "6") {$convertDate = date("m/d/Y", $timeCode);}
	if ($USER['user_timezone'] == "7") {$convertDate = date("m/d/Y", $timeCode + 3600);}
	if ($USER['user_timezone'] == "8") {$convertDate = date("m/d/Y", $timeCode + 7200);}
	if ($USER['user_timezone'] == "9") {$convertDate = date("m/d/Y", $timeCode + 10800);}
	if ($USER['user_timezone'] == "10") {$convertDate = date("m/d/Y", $timeCode + 14400);}
	if ($USER['user_timezone'] == "11") {$convertDate = date("m/d/Y", $timeCode + 18000);}
		
		if ($dataProcess == "return") {
			return $convertDate;	
		} 
		if ($dataProcess == "print") {
			echo $convertDate;	
		}
	}
}


//Timezone Processor
function timezoneProcess($timeCode, $dataProcess) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	if (!empty($timeCode)) {
		$timeCode = strtotime($timeCode);
		$convertDate = "";
	if ($USER['user_timezone'] == "1") {$convertDate = date($USER['user_dateformat'], $timeCode - 18000);}
	if ($USER['user_timezone'] == "2") {$convertDate = date($USER['user_dateformat'], $timeCode - 14400);}
	if ($USER['user_timezone'] == "3") {$convertDate = date($USER['user_dateformat'], $timeCode - 10800);}
	if ($USER['user_timezone'] == "4") {$convertDate = date($USER['user_dateformat'], $timeCode - 7200);}
	if ($USER['user_timezone'] == "5") {$convertDate = date($USER['user_dateformat'], $timeCode - 3600);}
	if ($USER['user_timezone'] == "6") {$convertDate = date($USER['user_dateformat'], $timeCode);}
	if ($USER['user_timezone'] == "7") {$convertDate = date($USER['user_dateformat'], $timeCode + 3600);}
	if ($USER['user_timezone'] == "8") {$convertDate = date($USER['user_dateformat'], $timeCode + 7200);}
	if ($USER['user_timezone'] == "9") {$convertDate = date($USER['user_dateformat'], $timeCode + 10800);}
	if ($USER['user_timezone'] == "10") {$convertDate = date($USER['user_dateformat'], $timeCode + 14400);}
	if ($USER['user_timezone'] == "11") {$convertDate = date($USER['user_dateformat'], $timeCode + 18000);}
	
	if ($USER['user_timezone'] == "12") {$convertDate = date($USER['user_dateformat'], $timeCode - 43200);}
	if ($USER['user_timezone'] == "13") {$convertDate = date($USER['user_dateformat'], $timeCode - 39600);}
	if ($USER['user_timezone'] == "14") {$convertDate = date($USER['user_dateformat'], $timeCode - 36000);}
	if ($USER['user_timezone'] == "15") {$convertDate = date($USER['user_dateformat'], $timeCode - 32400);}
	if ($USER['user_timezone'] == "16") {$convertDate = date($USER['user_dateformat'], $timeCode - 28800);}
	if ($USER['user_timezone'] == "17") {$convertDate = date($USER['user_dateformat'], $timeCode - 25200);}
	if ($USER['user_timezone'] == "18") {$convertDate = date($USER['user_dateformat'], $timeCode - 21600);}
	if ($USER['user_timezone'] == "19") {$convertDate = date($USER['user_dateformat'], $timeCode + 21600);}
	if ($USER['user_timezone'] == "20") {$convertDate = date($USER['user_dateformat'], $timeCode + 25200);}
	if ($USER['user_timezone'] == "21") {$convertDate = date($USER['user_dateformat'], $timeCode + 28800);}
	if ($USER['user_timezone'] == "22") {$convertDate = date($USER['user_dateformat'], $timeCode + 32400);}
	if ($USER['user_timezone'] == "23") {$convertDate = date($USER['user_dateformat'], $timeCode + 36000);}
	if ($USER['user_timezone'] == "24") {$convertDate = date($USER['user_dateformat'], $timeCode + 39600);}
	if ($USER['user_timezone'] == "25") {$convertDate = date($USER['user_dateformat'], $timeCode + 43200);}
		
		if ($dataProcess == "return") {
			return $convertDate;	
		} 
		if ($dataProcess == "print") {
			echo $convertDate;	
		}
	}
}

//Get User Data
function getUserData($user_id, $field) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;	
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getUser = "SELECT * FROM sys_users WHERE user_id = '".$user_id."'";
	$getUser = mysql_query($query_getUser, $ikiosk) or sqlError(mysql_error());
	$row_getUser = mysql_fetch_assoc($getUser);
	$totalRows_getUser = mysql_num_rows($getUser);
	
	if ($totalRows_getUser != "0") {
		return $row_getUser[$field];	
	}
}

//Get Team Data
function getTeamData($team_id, $field) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;	
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getTeam = "SELECT * FROM sys_teams WHERE team_id = '".$team_id."'";
	$getTeam = mysql_query($query_getTeam, $ikiosk) or sqlError(mysql_error());
	$row_getTeam = mysql_fetch_assoc($getTeam);
	$totalRows_getTeam = mysql_num_rows($getTeam);
	
	if ($totalRows_getTeam != "0") {
		return $row_getTeam[$field];	
	}
}

//Get Site Data
function getSiteData($site_id, $field) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;	
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getSite = "SELECT * FROM sys_sites WHERE site_id = '".$site_id."'";
	$getSite = mysql_query($query_getSite, $ikiosk) or sqlError(mysql_error());
	$row_getSite = mysql_fetch_assoc($getSite);
	$totalRows_getSite = mysql_num_rows($getSite);
	
	if ($totalRows_getSite != "0") {
		return $row_getSite[$field];	
	}
}

//Get Application Data
function getApplicationData($application_id, $field) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;	
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getApplication = "SELECT * FROM sys_applications WHERE application_id = '".$application_id."' AND deleted = '0'";
	$getApplication = mysql_query($query_getApplication, $ikiosk) or sqlError(mysql_error());
	$row_getApplication = mysql_fetch_assoc($getApplication);
	$totalRows_getApplication = mysql_num_rows($getApplication);
	
	if ($totalRows_getApplication != "0") {
		return $row_getApplication[$field];	
	}
}


//Debugger Overlay
function displayDebug() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $STORE, $CMS;
	
	$debug =  "<div id=\"ikioskDebug\">";
	$debug .= "<div class=\"debug-header\">IntelliKiosk Debug Console</div>";
	$debug .= "<div class=\"debug-container\">";
	
	$debug .= "<h3>System Variables</h3>";
	$debug .="<table class=\"debug-table\">";
	foreach ($SYSTEM as $key => $value) {$debug .= "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";}
	$debug .="</table>";
	
	$debug .= "<h3>Session Variables</h3>";
	$debug .="<table class=\"debug-table\">";
	foreach ($_SESSION as $key => $value) {$debug .= "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";}
	$debug .="</table>";	
	
	$debug .= "<h3>User Variables</h3>";
	$debug .="<table class=\"debug-table\">";
	foreach ($USER as $key => $value) {$debug .= "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";}
	$debug .="</table>";			
	
	$debug .= "<h3>Application Variables</h3>";
	$debug .="<table class=\"debug-table\">";
	foreach ($APPLICATION as $key => $value) {$debug .= "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";}
	$debug .="</table>";	
	
	$debug .= "<h3>Page Variables</h3>";
	$debug .="<table class=\"debug-table\">";
	foreach ($PAGE as $key => $value) {$debug .= "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";}
	$debug .="</table>";
	
	$debug .= "<h3>Site Variables</h3>";
	$debug .="<table class=\"debug-table\">";
	foreach ($SITE as $key => $value) {$debug .= "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";}
	$debug .="</table>";
	
	$debug .= "<h3>CMS Variables</h3>";
	$debug .="<table class=\"debug-table\">";
	foreach ($CMS as $key => $value) {$debug .= "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";}
	$debug .="</table>";

	if ($PAGE['application_code'] == "STORE") {
	$debug .= "<h3>Store Variables</h3>";
	$debug .="<table class=\"debug-table\">";
	foreach ($STORE as $key => $value) {$debug .= "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";}
	$debug .="</table>";
	}
	
	$debug .= "<h3>Server Variables</h3>";
	$debug .="<table class=\"debug-table\">";
	foreach ($_SERVER as $key => $value) {$debug .= "<tr><td class=\"debug-variable\">".$key."</td><td class=\"debug-value\">".$value."</tr>";}
	$debug .="</table>";
		
	$debug .= "</div>";
	$debug .= "</div>";	
	
	echo $debug;
}

//Process SQL Errors
function sqlError($message) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $USER;
	$type = "mySQL";
	$redirect = $SYSTEM['html_root'].$SYSTEM['ikiosk_root']."/error.php?error=9";
	errorLog($message, $type, $redirect);	
}

//Check IP Ban System
function checkIPBan() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $USER;
	
	//Check IP Ban System
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_ipBan = "SELECT * FROM sys_ipban WHERE ip_address = '".$_SERVER['REMOTE_ADDR']."' AND deleted = '0'";
	$ipBan = mysql_query($query_ipBan, $ikiosk) or sqlError(mysql_error());
	$row_ipBan = mysql_fetch_assoc($ipBan);
	$totalRows_ipBan = mysql_num_rows($ipBan);
	
	if ($totalRows_ipBan != "0") {
		header("Location: ".$SYSTEM['html_root'].$SYSTEM['ikiosk_root']."error.php?error=2");
		exit;
	}
}

// Installation Functions
function verifyInstallation() { 
	
	$installation = "No";
	$d = "";
	$file = "ikiosk/includes/core/db_conn.php";
	for($i = 0; $i < 10; $i++){
	  if(!is_file($d.$file)){
	   $d.="../";
	  } else {
	  $installation = "Yes";
	  break;
	  }
	}
	
	if (($installation == "No") && ($_SERVER['PHP_SELF'] != "/ikiosk/install/index.php")) {
		$file = "ikiosk/install/index.php";
		$d = "";
		for($i = 0; $i < 10; $i++){
		  if(!is_file($d.$file)){
		   $d.="../";
		  } else {
			header("Location: ".$d.$file."");
			exit;
		  }
		}
	}
}

//Prevent users from access intall page directly
function installationLockOut() {  
	$d = "";
	$file = "ikiosk/includes/core/db_conn.php";
	for($i = 0; $i < 10; $i++){
	  if(!is_file($d.$file)){
	   $d.="../";
	  } else {
	  header("Location: /index.php");
	  exit;
	  }
	}
	
}

//Error Handler
//$old_error_handler = set_error_handler("userErrorHandler");
function userErrorHandler ($errno, $errmsg, $filename, $linenum,  $vars)  {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE;
   // Get the error type from the error number 
   $errortype = array (1    => "Error",
                       2    => "Warning",
                       4    => "Parsing Error",
                       8    => "Notice",
                       16   => "Core Error",
                       32   => "Core Warning",
                       64   => "Compile Error",
                       128  => "Compile Warning",
                       256  => "User Error",
                       512  => "User Warning",
                       1024 => "User Notice");
    $errlevel=$errortype[$errno];
	
	//Write to iKiosk Error File
   $errorMessage = "PHP ".$errlevel.": on line ".$linenum." in file ".$filename."<br>".$errmsg;
	errorLog($errorMessage, "PHP", $redirect);
 }
 
//Access Log
function accessLog($type) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $USER;	
	
	//Location of Access Log
	$accessFile = $SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root']."/logs/access.log";
	
	if ($type == "System") {
		//Compose Log Message
		$accessLog = $SITE['site_id']."|".$PAGE['application_code']."|".$SYSTEM['mysql_datetime']."|".$_SERVER['REMOTE_ADDR']."|".$_SERVER['HTTP_HOST']."|".$SYSTEM['current_page']."|".$USER['user_id']."|".$_SESSION['gpsControl'];
		$accessLog .="[iKioskLog]\n"; 
	}
	
	if ($type == "Page") {
		//Compose Log Message
		$accessLog = $row_getSite['site_id']."|".$PAGE['application_code']."|".$SYSTEM['mysql_datetime']."|".$_SERVER['REMOTE_ADDR']."|".$_SERVER['HTTP_HOST']."|"."http://".$_SERVER['HTTP_HOST'].$SYSTEM['current_page']."|".$USER['user_id']."|".$_SESSION['gpsControl'];
		$accessLog .="[iKioskLog]\n"; 
	}
	
	//Write to Log File
	$fh = fopen($accessFile, 'a');
	fwrite($fh, $accessLog);
	fclose($fh);
	
	//Rotate Logs based on Size - Max 5242880 bytes
	$logFileSize = filesize($accessFile);
	if ($logFileSize > 2097152) {
	$newLogFile = $SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root']."/logs/archives/access-".	time().".log";
	copy($accessFile, $newLogFile);
	//Clear existing File
	$fh = fopen($accessFile, 'w');
	fwrite($fh, "");
	fclose($fh);
	}
	
}

//SQL Query Log
function sqlQueryLog($query) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $USER;
	
	//Location of Error Log
	$logFile = $SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root']."/logs/queries.log";
	
	//Compose Error Message
	$query = str_replace("|",":", $query);
	$mysqlLog = $SITE['site_id']."|".$PAGE['application_code']."|".$SYSTEM['mysql_datetime']."|".$_SERVER['REMOTE_ADDR']."|".$SYSTEM['current_page']."|".$query."|".$USER['user_id'];
	$mysqlLog .="[iKioskLog]\n";
		

	//Write to Error File
	$fh = fopen($logFile, 'a');
	fwrite($fh, $mysqlLog);
	fclose($fh);
	
	//Rotate Logs based on Size - Max 5242880 bytes
	$logFileSize = filesize($logFile);
	if ($logFileSize > 2097152) {
	$newLogFile = $SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root']."/logs/archives/queries-".	time().".log";
	copy($logFile, $newLogFile);
	//Clear existing File
	$fh = fopen($logFile, 'w');
	fwrite($fh, "");
	fclose($fh);
	}
}

//Error Log
function errorLog($errorMessage, $type, $redirect) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $USER;
	
	//Location of Error Log
	$errorFile = $SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root']."/logs/error.log";
	
	//Compose Error Message
	$errorMessage = str_replace("|","", $errorMessage);
	$errorLog = $SITE['site_id']."|".$type."|".$PAGE['application_code']."|".$SYSTEM['mysql_datetime']."|".$_SERVER['REMOTE_ADDR']."|".$SYSTEM['current_page']."|".$errorMessage."|".$USER['user_id'];
	$errorLog .="[iKioskLog]\n";
		
	if ($PAGE['application_code'] != "INSTALL") {
	//Write to Error File
	$fh = fopen($errorFile, 'a');
	fwrite($fh, $errorLog);
	fclose($fh);
	}
	
	//Rotate Logs based on Size - Max 5242880 bytes
	$logFileSize = filesize($errorFile);
	if ($logFileSize > 2097152) {
	$newLogFile = $SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root']."/logs/archives/error-".	time().".log";
	copy($errorFile, $newLogFile);
	//Clear existing File
	$fh = fopen($errorFile, 'w');
	fwrite($fh, "");
	fclose($fh);
	}
	
	//Redirect if defined
	if (!empty($redirect)) {
	header("Location: ".$redirect."");
	exit;	
	}
	
}

//Error Popup
function errorAlert($message) {
if (!empty($message)) {
$alert = "<script type=\"text/javascript\"> window.alert(\"".$message."\") </script>";
echo $alert;
}
}

//Create Spinner With Message
function loadingResults($header, $message) {
	global $ikiosk, $database_ikiosk, $SITE;
	$loading .="<div class=\"ikiosk-loading\">";
	$loading .= "<h4>".$header."</h4>";
	if (!empty($message)) {
	$loading .= $message;	
	}
	$loading .= "<img src=\"/ikiosk/library/images/ui/loading.gif\" />";
	$loading .= "</div>";
	echo $loading;
}
	
//TimeZone Dropdown
function selectTimeZone($default) {
$timeZone = "";
if ($default == "12") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"12\" ".$selected." >".date("m/d/Y - h:i a", time()-43200)."</option>";
if ($default == "13") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"13\" ".$selected." >".date("m/d/Y - h:i a", time()-39600)."</option>";
if ($default == "14") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"14\" ".$selected." >".date("m/d/Y - h:i a", time()-36000)."</option>";
if ($default == "15") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"16\" ".$selected." >".date("m/d/Y - h:i a", time()-32400)."</option>";
if ($default == "16") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"16\" ".$selected." >".date("m/d/Y - h:i a", time()-28800)."</option>";
if ($default == "17") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"17\" ".$selected." >".date("m/d/Y - h:i a", time()-25200)."</option>";
if ($default == "18") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"18\" ".$selected." >".date("m/d/Y - h:i a", time()-21600)."</option>";

if ($default == "1") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"1\" ".$selected." >".date("m/d/Y - h:i a", time()-18000)."</option>";
if ($default == "2") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"2\" ".$selected." >".date("m/d/Y - h:i a", time()-14400)."</option>";
if ($default == "3") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"3\" ".$selected." >".date("m/d/Y - h:i a", time()-10800)."</option>";
if ($default == "4") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"3\" ".$selected." >".date("m/d/Y - h:i a", time()-7200)."</option>";
if ($default == "5") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"5\" ".$selected." >".date("m/d/Y - h:i a", time()-3600)."</option>";
if ($default == "6") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"6\" ".$selected." >".date("m/d/Y - h:i a")." [Local Server Time] </option>";
if ($default == "7") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"7\" ".$selected." >".date("m/d/Y - h:i a", time()+3600)."</option>";
if ($default == "8") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"8\" ".$selected." >".date("m/d/Y - h:i a", time()+7200)."</option>";
if ($default == "9") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"9\" ".$selected." >".date("m/d/Y - h:i a", time()+10800)."</option>";
if ($default == "10") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"10\" ".$selected." >".date("m/d/Y - h:i a", time()+14400)."</option>";
if ($default == "11") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"11\" ".$selected." >".date("m/d/Y - h:i a", time()+18000)."</option>";

if ($default == "19") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"19\" ".$selected." >".date("m/d/Y - h:i a", time()+21600)."</option>";
if ($default == "20") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"20\" ".$selected." >".date("m/d/Y - h:i a", time()+25200)."</option>";
if ($default == "21") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"21\" ".$selected." >".date("m/d/Y - h:i a", time()+28800)."</option>";
if ($default == "22") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"22\" ".$selected." >".date("m/d/Y - h:i a", time()+32400)."</option>";
if ($default == "23") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"23\" ".$selected." >".date("m/d/Y - h:i a", time()+36000)."</option>";
if ($default == "24") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"24\" ".$selected." >".date("m/d/Y - h:i a", time()+39600)."</option>";
if ($default == "25") {$selected = " selected=\"selected\" "; } else {$selected="";}
$timeZone .="<option value=\"25\" ".$selected." >".date("m/d/Y - h:i a", time()+43200)."</option>";

echo $timeZone;	
}

//Load Custom jQuery and Javascript Functions
function jqueryCustom($module_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $USER;

$jQueryData = "";
switch($module_id) {
	case "install":  // Installation Form
	$jQueryData = "<script type=\"text/javascript\" src=\"".$SYSTEM['html_root']."/ikiosk/library/js/forms/install.js\"></script>";
	break;
	case "login":  // Login Form
	$jQueryData = "<script type=\"text/javascript\" src=\"".$SYSTEM['html_root']."/ikiosk/library/js/forms/login.js\"></script>";
	break;
	case "signup":  // Signup Form
	$jQueryData = "<script type=\"text/javascript\" src=\"".$SYSTEM['html_root']."/ikiosk/library/js/forms/signup.js\"></script>";
	break;
}
echo $jQueryData;
}

#SQL Injection Protection
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

#AutoCreate Unique Guids for Record Indexing
function create_guid()
{
    $microTime = microtime();
	list($a_dec, $a_sec) = explode(" ", $microTime);

	$dec_hex = sprintf("%x", $a_dec* 1000000);
	$sec_hex = sprintf("%x", $a_sec);

	ensure_length($dec_hex, 5);
	ensure_length($sec_hex, 6);

	$guid = "";
	$guid .= $dec_hex;
	$guid .= create_guid_section(3);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= create_guid_section(4);
	$guid .= '-';
	$guid .= $sec_hex;
	$guid .= create_guid_section(6);

	return $guid;

}

function create_guid_section($characters)
{
	$return = "";
	for($i=0; $i<$characters; $i++)
	{
		$return .= sprintf("%x", mt_rand(0,15));
	}
	return $return;
}

function ensure_length(&$string, $length)
{
	$strlen = strlen($string);
	if($strlen < $length)
	{
		$string = str_pad($string,$length,"0");
	}
	else if($strlen > $length)
	{
		$string = substr($string, 0, $length);
	}
}

function microtime_diff($a, $b) {
   list($a_dec, $a_sec) = explode(" ", $a);
   list($b_dec, $b_sec) = explode(" ", $b);
   return $b_sec - $a_sec + $b_dec - $a_dec;
}



########################################################
# Script Info
# ===========
# File: ImageEditor.php
# Created: 05/06/03
# Modified: 16/05/04
# Author: Ash Young (ash@evoluted.net)
# Website: http://evoluted.net/php/image-editor.htm
# Requirements: PHP with the GD Library


class ImageEditor {
  var $x;
  var $y;
  var $type;
  var $img;  
  var $font;
  var $error;
  var $size;

  ########################################################
  # CONSTRUCTOR
  ########################################################
  function ImageEditor($filename, $path, $col=NULL) 
  {
    $this->font = false;
    $this->error = false;
    $this->size = 25;
    if(is_numeric($filename) && is_numeric($path))
    ## IF NO IMAGE SPECIFIED CREATE BLANK IMAGE
    {
      $this->x = $filename;
      $this->y = $path;
      $this->type = "jpg";
      $this->img = imagecreatetruecolor($this->x, $this->y);
      if(is_array($col)) 
      ## SET BACKGROUND COLOUR OF IMAGE
      {
        $colour = ImageColorAllocate($this->img, $col[0], $col[1], $col[2]);
        ImageFill($this->img, 0, 0, $colour);
      }
    }
    else
    ## IMAGE SPECIFIED SO LOAD THIS IMAGE
    {
      ## FIRST SEE IF WE CAN FIND IMAGE
      if(file_exists($path . $filename))
      {
        $file = $path . $filename;
      }
      else if (file_exists($path . "/" . $filename))
      {
        $file = $path . "/" . $filename;
		
      }
      else
      {
 
        $this->errorImage("File Could Not Be Loaded");
      }
      
      if(!($this->error)) 
      {
        ## LOAD OUR IMAGE WITH CORRECT FUNCTION
        $this->type = strtolower(end(explode('.', $filename)));
        if ($this->type == 'jpg' || $this->type == 'jpeg') 
        {
          $this->img = @imagecreatefromjpeg($file);
        } 
        else if ($this->type == 'png') 
        {
          $this->img = @imagecreatefrompng($file);
        } 
        else if ($this->type == 'gif') 
        {
          $this->img = @imagecreatefrompng($file);
        }
        ## SET OUR IMAGE VARIABLES
        $this->x = imagesx($this->img);
        $this->y = imagesy($this->img);
      }
    }
  }

  ########################################################
  # RESIZE IMAGE GIVEN X AND Y
  ########################################################
  function resize($width, $height) 
  {
    if(!$this->error) 
    {
      $tmpimage = imagecreatetruecolor($width, $height);
      imagecopyresampled($tmpimage, $this->img, 0, 0, 0, 0,
                           $width, $height, $this->x, $this->y);
      imagedestroy($this->img);
      $this->img = $tmpimage;
      $this->y = $height;
      $this->x = $width;
    }
  }
  
  ########################################################
  # CROPS THE IMAGE, GIVE A START CO-ORDINATE AND
  # LENGTH AND HEIGHT ATTRIBUTES
  ########################################################
  function crop($x, $y, $width, $height) 
  {
    if(!$this->error) 
    {
      $tmpimage = imagecreatetruecolor($width, $height);
      imagecopyresampled($tmpimage, $this->img, 0, 0, $x, $y,
                           $width, $height, $width, $height);
      imagedestroy($this->img);
      $this->img = $tmpimage;
      $this->y = $height;
      $this->x = $width;
    }
  }
  
  ########################################################
  # ADDS TEXT TO AN IMAGE, TAKES THE STRING, A STARTING
  # POINT, PLUS A COLOR DEFINITION AS AN ARRAY IN RGB MODE
  ########################################################
  function addText($str, $x, $y, $col)
  {
    if(!$this->error) 
    {
      if($this->font) {
        $colour = ImageColorAllocate($this->img, $col[0], $col[1], $col[2]);
        if(!imagettftext($this->img, $this->size, 0, $x, $y, $colour, $this->font, $str)) {
          $this->font = false;
          $this->errorImage("Error Drawing Text");
        }
      }
      else {
        $colour = ImageColorAllocate($this->img, $col[0], $col[1], $col[2]);
        Imagestring($this->img, 5, $x, $y, $str, $colour);
      }
    }
  }
  
  function shadowText($str, $x, $y, $col1, $col2, $offset=2) {
   $this->addText($str, $x, $y, $col1);
   $this->addText($str, $x-$offset, $y-$offset, $col2);   
  
  }
  
  ########################################################
  # ADDS A LINE TO AN IMAGE, TAKES A STARTING AND AN END
  # POINT, PLUS A COLOR DEFINITION AS AN ARRAY IN RGB MODE
  ########################################################
  function addLine($x1, $y1, $x2, $y2, $col) 
  {
    if(!$this->error) 
    {
      $colour = ImageColorAllocate($this->img, $col[0], $col[1], $col[2]);
      ImageLine($this->img, $x1, $y1, $x2, $y2, $colour);
    }
  }

  ########################################################
  # RETURN OUR EDITED FILE AS AN IMAGE
  ########################################################
  function outputImage() 
  {
     if ($this->type == 'jpg' || $this->type == 'jpeg') 
    {
      header("Content-type: image/jpeg");
      imagejpeg($this->img);
    } 
    else if ($this->type == 'png') 
    {
      header("Content-type: image/png");
      imagepng($this->img);
    } 
    else if ($this->type == 'gif') 
    {
      header("Content-type: image/png");
      imagegif($this->img);
    }
  }

  ########################################################
  # CREATE OUR EDITED FILE ON THE SERVER
  ########################################################
  function outputFile($filename, $path) 
  {
    if ($this->type == 'jpg' || $this->type == 'jpeg') 
    {
      imagejpeg($this->img, ($path . $filename));
    } 
    else if ($this->type == 'png') 
    {
      imagepng($this->img, ($path . $filename));
    } 
    else if ($this->type == 'gif') 
    {
      imagegif($this->img, ($path . $filename));
    }
  }


  ########################################################
  # SET OUTPUT TYPE IN ORDER TO SAVE IN DIFFERENT
  # TYPE THAN WE LOADED
  ########################################################
  function setImageType($type)
  {
    $this->type = $type;
  }
  
  ########################################################
  # ADDS TEXT TO AN IMAGE, TAKES THE STRING, A STARTING
  # POINT, PLUS A COLOR DEFINITION AS AN ARRAY IN RGB MODE
  ########################################################
  function setFont($font) {
    $this->font = $font;
  }

  ########################################################
  # SETS THE FONT SIZE
  ########################################################
  function setSize($size) {
    $this->size = $size;
  }
  
  ########################################################
  # GET VARIABLE FUNCTIONS
  ########################################################
  function getWidth()                {return $this->x;}
  function getHeight()               {return $this->y;} 
  function getImageType()            {return $this->type;}

  ########################################################
  # CREATES AN ERROR IMAGE SO A PROPER OBJECT IS RETURNED
  ########################################################
  function errorImage($str) 
  {
    $this->error = false;
    $this->x = 235;
    $this->y = 50;
    $this->type = "jpg";
    $this->img = imagecreatetruecolor($this->x, $this->y);
    $this->addText("AN ERROR OCCURED:", 10, 5, array(250,70,0));
    $this->addText($str, 10, 30, array(255,255,255));
    $this->error = true;
  }
}

//Mobile Device Redirect
function mobile_device_detect($iphone=true,$ipad=false,$android=true,$opera=true,$blackberry=true,$palm=true,$windows=true,$mobileredirect=false,$desktopredirect=false){

  $mobile_browser   = false; // set mobile browser as false till we can prove otherwise
  $user_agent       = $_SERVER['HTTP_USER_AGENT']; // get the user agent value - this should be cleaned to ensure no nefarious input gets executed
  $accept           = $_SERVER['HTTP_ACCEPT']; // get the content accept value - this should be cleaned to ensure no nefarious input gets executed

  switch(true){ // using a switch against the following statements which could return true is more efficient than the previous method of using if statements

    case (preg_match('/ipad/i',$user_agent)); // we find the word ipad in the user agent
      $mobile_browser = $ipad; // mobile browser is either true or false depending on the setting of ipad when calling the function
      $status = 'Apple iPad';
      if(substr($ipad,0,4)=='http'){ // does the value of ipad resemble a url
        $mobileredirect = $ipad; // set the mobile redirect url to the url value stored in the ipad value
      } // ends the if for ipad being a url
    break; // break out and skip the rest if we've had a match on the ipad // this goes before the iphone to catch it else it would return on the iphone instead

    case (preg_match('/ipod/i',$user_agent)||preg_match('/iphone/i',$user_agent)); // we find the words iphone or ipod in the user agent
      $mobile_browser = $iphone; // mobile browser is either true or false depending on the setting of iphone when calling the function
      $status = 'Apple';
      if(substr($iphone,0,4)=='http'){ // does the value of iphone resemble a url
        $mobileredirect = $iphone; // set the mobile redirect url to the url value stored in the iphone value
      } // ends the if for iphone being a url
    break; // break out and skip the rest if we've had a match on the iphone or ipod

    case (preg_match('/android/i',$user_agent));  // we find android in the user agent
      $mobile_browser = $android; // mobile browser is either true or false depending on the setting of android when calling the function
      $status = 'Android';
      if(substr($android,0,4)=='http'){ // does the value of android resemble a url
        $mobileredirect = $android; // set the mobile redirect url to the url value stored in the android value
      } // ends the if for android being a url
    break; // break out and skip the rest if we've had a match on android

    case (preg_match('/opera mini/i',$user_agent)); // we find opera mini in the user agent
      $mobile_browser = $opera; // mobile browser is either true or false depending on the setting of opera when calling the function
      $status = 'Opera';
      if(substr($opera,0,4)=='http'){ // does the value of opera resemble a rul
        $mobileredirect = $opera; // set the mobile redirect url to the url value stored in the opera value
      } // ends the if for opera being a url 
    break; // break out and skip the rest if we've had a match on opera

    case (preg_match('/blackberry/i',$user_agent)); // we find blackberry in the user agent
      $mobile_browser = $blackberry; // mobile browser is either true or false depending on the setting of blackberry when calling the function
      $status = 'Blackberry';
      if(substr($blackberry,0,4)=='http'){ // does the value of blackberry resemble a rul
        $mobileredirect = $blackberry; // set the mobile redirect url to the url value stored in the blackberry value
      } // ends the if for blackberry being a url 
    break; // break out and skip the rest if we've had a match on blackberry

    case (preg_match('/(pre\/|palm os|palm|hiptop|avantgo|plucker|xiino|blazer|elaine)/i',$user_agent)); // we find palm os in the user agent - the i at the end makes it case insensitive
      $mobile_browser = $palm; // mobile browser is either true or false depending on the setting of palm when calling the function
      $status = 'Palm';
      if(substr($palm,0,4)=='http'){ // does the value of palm resemble a rul
        $mobileredirect = $palm; // set the mobile redirect url to the url value stored in the palm value
      } // ends the if for palm being a url 
    break; // break out and skip the rest if we've had a match on palm os

    case (preg_match('/(iris|3g_t|windows ce|opera mobi|windows ce; smartphone;|windows ce; iemobile)/i',$user_agent)); // we find windows mobile in the user agent - the i at the end makes it case insensitive
      $mobile_browser = $windows; // mobile browser is either true or false depending on the setting of windows when calling the function
      $status = 'Windows Smartphone';
      if(substr($windows,0,4)=='http'){ // does the value of windows resemble a rul
        $mobileredirect = $windows; // set the mobile redirect url to the url value stored in the windows value
      } // ends the if for windows being a url 
    break; // break out and skip the rest if we've had a match on windows

    case (preg_match('/(mini 9.5|vx1000|lge |m800|e860|u940|ux840|compal|wireless| mobi|ahong|lg380|lgku|lgu900|lg210|lg47|lg920|lg840|lg370|sam-r|mg50|s55|g83|t66|vx400|mk99|d615|d763|el370|sl900|mp500|samu3|samu4|vx10|xda_|samu5|samu6|samu7|samu9|a615|b832|m881|s920|n210|s700|c-810|_h797|mob-x|sk16d|848b|mowser|s580|r800|471x|v120|rim8|c500foma:|160x|x160|480x|x640|t503|w839|i250|sprint|w398samr810|m5252|c7100|mt126|x225|s5330|s820|htil-g1|fly v71|s302|-x113|novarra|k610i|-three|8325rc|8352rc|sanyo|vx54|c888|nx250|n120|mtk |c5588|s710|t880|c5005|i;458x|p404i|s210|c5100|teleca|s940|c500|s590|foma|samsu|vx8|vx9|a1000|_mms|myx|a700|gu1100|bc831|e300|ems100|me701|me702m-three|sd588|s800|8325rc|ac831|mw200|brew |d88|htc\/|htc_touch|355x|m50|km100|d736|p-9521|telco|sl74|ktouch|m4u\/|me702|8325rc|kddi|phone|lg |sonyericsson|samsung|240x|x320|vx10|nokia|sony cmd|motorola|up.browser|up.link|mmp|symbian|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|psp|treo)/i',$user_agent)); // check if any of the values listed create a match on the user agent - these are some of the most common terms used in agents to identify them as being mobile devices - the i at the end makes it case insensitive
      $mobile_browser = true; // set mobile browser to true
      $status = 'Mobile matched on piped preg_match';
    break; // break out and skip the rest if we've preg_match on the user agent returned true 

    case ((strpos($accept,'text/vnd.wap.wml')>0)||(strpos($accept,'application/vnd.wap.xhtml+xml')>0)); // is the device showing signs of support for text/vnd.wap.wml or application/vnd.wap.xhtml+xml
      $mobile_browser = true; // set mobile browser to true
      $status = 'Mobile matched on content accept header';
    break; // break out and skip the rest if we've had a match on the content accept headers

    case (isset($_SERVER['HTTP_X_WAP_PROFILE'])||isset($_SERVER['HTTP_PROFILE'])); // is the device giving us a HTTP_X_WAP_PROFILE or HTTP_PROFILE header - only mobile devices would do this
      $mobile_browser = true; // set mobile browser to true
      $status = 'Mobile matched on profile headers being set';
    break; // break out and skip the final step if we've had a return true on the mobile specfic headers

    case (in_array(strtolower(substr($user_agent,0,4)),array('1207'=>'1207','3gso'=>'3gso','4thp'=>'4thp','501i'=>'501i','502i'=>'502i','503i'=>'503i','504i'=>'504i','505i'=>'505i','506i'=>'506i','6310'=>'6310','6590'=>'6590','770s'=>'770s','802s'=>'802s','a wa'=>'a wa','acer'=>'acer','acs-'=>'acs-','airn'=>'airn','alav'=>'alav','asus'=>'asus','attw'=>'attw','au-m'=>'au-m','aur '=>'aur ','aus '=>'aus ','abac'=>'abac','acoo'=>'acoo','aiko'=>'aiko','alco'=>'alco','alca'=>'alca','amoi'=>'amoi','anex'=>'anex','anny'=>'anny','anyw'=>'anyw','aptu'=>'aptu','arch'=>'arch','argo'=>'argo','bell'=>'bell','bird'=>'bird','bw-n'=>'bw-n','bw-u'=>'bw-u','beck'=>'beck','benq'=>'benq','bilb'=>'bilb','blac'=>'blac','c55/'=>'c55/','cdm-'=>'cdm-','chtm'=>'chtm','capi'=>'capi','cond'=>'cond','craw'=>'craw','dall'=>'dall','dbte'=>'dbte','dc-s'=>'dc-s','dica'=>'dica','ds-d'=>'ds-d','ds12'=>'ds12','dait'=>'dait','devi'=>'devi','dmob'=>'dmob','doco'=>'doco','dopo'=>'dopo','el49'=>'el49','erk0'=>'erk0','esl8'=>'esl8','ez40'=>'ez40','ez60'=>'ez60','ez70'=>'ez70','ezos'=>'ezos','ezze'=>'ezze','elai'=>'elai','emul'=>'emul','eric'=>'eric','ezwa'=>'ezwa','fake'=>'fake','fly-'=>'fly-','fly_'=>'fly_','g-mo'=>'g-mo','g1 u'=>'g1 u','g560'=>'g560','gf-5'=>'gf-5','grun'=>'grun','gene'=>'gene','go.w'=>'go.w','good'=>'good','grad'=>'grad','hcit'=>'hcit','hd-m'=>'hd-m','hd-p'=>'hd-p','hd-t'=>'hd-t','hei-'=>'hei-','hp i'=>'hp i','hpip'=>'hpip','hs-c'=>'hs-c','htc '=>'htc ','htc-'=>'htc-','htca'=>'htca','htcg'=>'htcg','htcp'=>'htcp','htcs'=>'htcs','htct'=>'htct','htc_'=>'htc_','haie'=>'haie','hita'=>'hita','huaw'=>'huaw','hutc'=>'hutc','i-20'=>'i-20','i-go'=>'i-go','i-ma'=>'i-ma','i230'=>'i230','iac'=>'iac','iac-'=>'iac-','iac/'=>'iac/','ig01'=>'ig01','im1k'=>'im1k','inno'=>'inno','iris'=>'iris','jata'=>'jata','java'=>'java','kddi'=>'kddi','kgt'=>'kgt','kgt/'=>'kgt/','kpt '=>'kpt ','kwc-'=>'kwc-','klon'=>'klon','lexi'=>'lexi','lg g'=>'lg g','lg-a'=>'lg-a','lg-b'=>'lg-b','lg-c'=>'lg-c','lg-d'=>'lg-d','lg-f'=>'lg-f','lg-g'=>'lg-g','lg-k'=>'lg-k','lg-l'=>'lg-l','lg-m'=>'lg-m','lg-o'=>'lg-o','lg-p'=>'lg-p','lg-s'=>'lg-s','lg-t'=>'lg-t','lg-u'=>'lg-u','lg-w'=>'lg-w','lg/k'=>'lg/k','lg/l'=>'lg/l','lg/u'=>'lg/u','lg50'=>'lg50','lg54'=>'lg54','lge-'=>'lge-','lge/'=>'lge/','lynx'=>'lynx','leno'=>'leno','m1-w'=>'m1-w','m3ga'=>'m3ga','m50/'=>'m50/','maui'=>'maui','mc01'=>'mc01','mc21'=>'mc21','mcca'=>'mcca','medi'=>'medi','meri'=>'meri','mio8'=>'mio8','mioa'=>'mioa','mo01'=>'mo01','mo02'=>'mo02','mode'=>'mode','modo'=>'modo','mot '=>'mot ','mot-'=>'mot-','mt50'=>'mt50','mtp1'=>'mtp1','mtv '=>'mtv ','mate'=>'mate','maxo'=>'maxo','merc'=>'merc','mits'=>'mits','mobi'=>'mobi','motv'=>'motv','mozz'=>'mozz','n100'=>'n100','n101'=>'n101','n102'=>'n102','n202'=>'n202','n203'=>'n203','n300'=>'n300','n302'=>'n302','n500'=>'n500','n502'=>'n502','n505'=>'n505','n700'=>'n700','n701'=>'n701','n710'=>'n710','nec-'=>'nec-','nem-'=>'nem-','newg'=>'newg','neon'=>'neon','netf'=>'netf','noki'=>'noki','nzph'=>'nzph','o2 x'=>'o2 x','o2-x'=>'o2-x','opwv'=>'opwv','owg1'=>'owg1','opti'=>'opti','oran'=>'oran','p800'=>'p800','pand'=>'pand','pg-1'=>'pg-1','pg-2'=>'pg-2','pg-3'=>'pg-3','pg-6'=>'pg-6','pg-8'=>'pg-8','pg-c'=>'pg-c','pg13'=>'pg13','phil'=>'phil','pn-2'=>'pn-2','pt-g'=>'pt-g','palm'=>'palm','pana'=>'pana','pire'=>'pire','pock'=>'pock','pose'=>'pose','psio'=>'psio','qa-a'=>'qa-a','qc-2'=>'qc-2','qc-3'=>'qc-3','qc-5'=>'qc-5','qc-7'=>'qc-7','qc07'=>'qc07','qc12'=>'qc12','qc21'=>'qc21','qc32'=>'qc32','qc60'=>'qc60','qci-'=>'qci-','qwap'=>'qwap','qtek'=>'qtek','r380'=>'r380','r600'=>'r600','raks'=>'raks','rim9'=>'rim9','rove'=>'rove','s55/'=>'s55/','sage'=>'sage','sams'=>'sams','sc01'=>'sc01','sch-'=>'sch-','scp-'=>'scp-','sdk/'=>'sdk/','se47'=>'se47','sec-'=>'sec-','sec0'=>'sec0','sec1'=>'sec1','semc'=>'semc','sgh-'=>'sgh-','shar'=>'shar','sie-'=>'sie-','sk-0'=>'sk-0','sl45'=>'sl45','slid'=>'slid','smb3'=>'smb3','smt5'=>'smt5','sp01'=>'sp01','sph-'=>'sph-','spv '=>'spv ','spv-'=>'spv-','sy01'=>'sy01','samm'=>'samm','sany'=>'sany','sava'=>'sava','scoo'=>'scoo','send'=>'send','siem'=>'siem','smar'=>'smar','smit'=>'smit','soft'=>'soft','sony'=>'sony','t-mo'=>'t-mo','t218'=>'t218','t250'=>'t250','t600'=>'t600','t610'=>'t610','t618'=>'t618','tcl-'=>'tcl-','tdg-'=>'tdg-','telm'=>'telm','tim-'=>'tim-','ts70'=>'ts70','tsm-'=>'tsm-','tsm3'=>'tsm3','tsm5'=>'tsm5','tx-9'=>'tx-9','tagt'=>'tagt','talk'=>'talk','teli'=>'teli','topl'=>'topl','hiba'=>'hiba','up.b'=>'up.b','upg1'=>'upg1','utst'=>'utst','v400'=>'v400','v750'=>'v750','veri'=>'veri','vk-v'=>'vk-v','vk40'=>'vk40','vk50'=>'vk50','vk52'=>'vk52','vk53'=>'vk53','vm40'=>'vm40','vx98'=>'vx98','virg'=>'virg','vite'=>'vite','voda'=>'voda','vulc'=>'vulc','w3c '=>'w3c ','w3c-'=>'w3c-','wapj'=>'wapj','wapp'=>'wapp','wapu'=>'wapu','wapm'=>'wapm','wig '=>'wig ','wapi'=>'wapi','wapr'=>'wapr','wapv'=>'wapv','wapy'=>'wapy','wapa'=>'wapa','waps'=>'waps','wapt'=>'wapt','winc'=>'winc','winw'=>'winw','wonu'=>'wonu','x700'=>'x700','xda2'=>'xda2','xdag'=>'xdag','yas-'=>'yas-','your'=>'your','zte-'=>'zte-','zeto'=>'zeto','acs-'=>'acs-','alav'=>'alav','alca'=>'alca','amoi'=>'amoi','aste'=>'aste','audi'=>'audi','avan'=>'avan','benq'=>'benq','bird'=>'bird','blac'=>'blac','blaz'=>'blaz','brew'=>'brew','brvw'=>'brvw','bumb'=>'bumb','ccwa'=>'ccwa','cell'=>'cell','cldc'=>'cldc','cmd-'=>'cmd-','dang'=>'dang','doco'=>'doco','eml2'=>'eml2','eric'=>'eric','fetc'=>'fetc','hipt'=>'hipt','http'=>'http','ibro'=>'ibro','idea'=>'idea','ikom'=>'ikom','inno'=>'inno','ipaq'=>'ipaq','jbro'=>'jbro','jemu'=>'jemu','java'=>'java','jigs'=>'jigs','kddi'=>'kddi','keji'=>'keji','kyoc'=>'kyoc','kyok'=>'kyok','leno'=>'leno','lg-c'=>'lg-c','lg-d'=>'lg-d','lg-g'=>'lg-g','lge-'=>'lge-','libw'=>'libw','m-cr'=>'m-cr','maui'=>'maui','maxo'=>'maxo','midp'=>'midp','mits'=>'mits','mmef'=>'mmef','mobi'=>'mobi','mot-'=>'mot-','moto'=>'moto','mwbp'=>'mwbp','mywa'=>'mywa','nec-'=>'nec-','newt'=>'newt','nok6'=>'nok6','noki'=>'noki','o2im'=>'o2im','opwv'=>'opwv','palm'=>'palm','pana'=>'pana','pant'=>'pant','pdxg'=>'pdxg','phil'=>'phil','play'=>'play','pluc'=>'pluc','port'=>'port','prox'=>'prox','qtek'=>'qtek','qwap'=>'qwap','rozo'=>'rozo','sage'=>'sage','sama'=>'sama','sams'=>'sams','sany'=>'sany','sch-'=>'sch-','sec-'=>'sec-','send'=>'send','seri'=>'seri','sgh-'=>'sgh-','shar'=>'shar','sie-'=>'sie-','siem'=>'siem','smal'=>'smal','smar'=>'smar','sony'=>'sony','sph-'=>'sph-','symb'=>'symb','t-mo'=>'t-mo','teli'=>'teli','tim-'=>'tim-','tosh'=>'tosh','treo'=>'treo','tsm-'=>'tsm-','upg1'=>'upg1','upsi'=>'upsi','vk-v'=>'vk-v','voda'=>'voda','vx52'=>'vx52','vx53'=>'vx53','vx60'=>'vx60','vx61'=>'vx61','vx70'=>'vx70','vx80'=>'vx80','vx81'=>'vx81','vx83'=>'vx83','vx85'=>'vx85','wap-'=>'wap-','wapa'=>'wapa','wapi'=>'wapi','wapp'=>'wapp','wapr'=>'wapr','webc'=>'webc','whit'=>'whit','winw'=>'winw','wmlb'=>'wmlb','xda-'=>'xda-',))); // check against a list of trimmed user agents to see if we find a match
      $mobile_browser = true; // set mobile browser to true
      $status = 'Mobile matched on in_array';
    break; // break even though it's the last statement in the switch so there's nothing to break away from but it seems better to include it than exclude it

    default;
      $mobile_browser = false; // set mobile browser to false
      $status = 'Desktop / full capability browser';
    break; // break even though it's the last statement in the switch so there's nothing to break away from but it seems better to include it than exclude it

  } // ends the switch 

  // tell adaptation services (transcoders and proxies) to not alter the content based on user agent as it's already being managed by this script, some of them suck though and will disregard this....
	// header('Cache-Control: no-transform'); // http://mobiforge.com/developing/story/setting-http-headers-advise-transcoding-proxies
	// header('Vary: User-Agent, Accept'); // http://mobiforge.com/developing/story/setting-http-headers-advise-transcoding-proxies

  // if redirect (either the value of the mobile or desktop redirect depending on the value of $mobile_browser) is true redirect else we return the status of $mobile_browser
  if($redirect = ($mobile_browser==true) ? $mobileredirect : $desktopredirect){
    header('Location: '.$redirect); // redirect to the right url for this device
    exit;
  }else{ 
		// a couple of folkas have asked about the status - that's there to help you debug and understand what the script is doing
		if($mobile_browser==''){
			return $mobile_browser; // will return either true or false 
		}else{
			return array($mobile_browser,$status); // is a mobile so we are returning an array ['0'] is true ['1'] is the $status value
		}
	}

} // ends function mobile_device_detect

function recursive_remove_directory($directory, $empty=FALSE)
{
	// if the path has a slash at the end we remove it here
	if(substr($directory,-1) == '/')
	{
		$directory = substr($directory,0,-1);
	}

	// if the path is not valid or is not a directory ...
	if(!file_exists($directory) || !is_dir($directory))
	{
		// ... we return false and exit the function
		return FALSE;

	// ... if the path is not readable
	}elseif(!is_readable($directory))
	{
		// ... we return false and exit the function
		return FALSE;

	// ... else if the path is readable
	}else{

		// we open the directory
		$handle = opendir($directory);

		// and scan through the items inside
		while (FALSE !== ($item = readdir($handle)))
		{
			// if the filepointer is not the current directory
			// or the parent directory
			if($item != '.' && $item != '..')
			{
				// we build the new path to delete
				$path = $directory.'/'.$item;

				// if the new path is a directory
				if(is_dir($path)) 
				{
					// we call this function with the new path
					recursive_remove_directory($path);

				// if the new path is a file
				}else{
					// we remove the file
					unlink($path);
				}
			}
		}
		// close the directory
		closedir($handle);

		// if the option to empty is not set to true
		if($empty == FALSE)
		{
			// try to delete the now empty directory
			if(!rmdir($directory))
			{
				// return false if not possible
				return FALSE;
			}
		}
		// return success
		return TRUE;
	}
}
?>
<?php
/* IntelliKiosk 7.0 Tiger */

//Smart Content Processor
function v7ContentProcessor($content) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $row_getPage, $row_getTemplate, $row_getCMS;	
	
	$dynamicTable = array("cms_page_versions", "cms_template_versions", "sys_sites");
	foreach ($dynamicTable as $key=>$value) {
			mysql_select_db($database_ikiosk, $ikiosk);
			$query_showColumns = "SHOW COLUMNS FROM ".$value."";
			$showColumns = mysql_query($query_showColumns, $ikiosk) or sqlError(mysql_error());
			$row_showColumns = mysql_fetch_assoc($showColumns);
			$totalRows_showColumns = mysql_num_rows($showColumns);
			
			switch($value) {
				case "cms_page_versions":
					$prefix = "page";
					$activeRecord = $row_getPage;
					break;
				case "cms_template_versions":
					$prefix = "template";
					$activeRecord = $row_getTemplate;
					break;
				case "sys_sites":
					$prefix = "site";
					$activeRecord = $row_getCMS;
					break;
			}
			
			do {
				$search = $prefix.":".$row_showColumns['Field'];
				$replace = $activeRecord[$row_showColumns['Field']];
				$content = str_replace($search, $replace, $content);
			} while ($row_showColumns = mysql_fetch_assoc($showColumns));	
		}	
		echo $content;
}

//Create Defaults 
function v7InitSite($site_id) {
		global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;	
	
		 mysql_select_db($database_ikiosk, $ikiosk);
		 $query_getSite = "SELECT * FROM sys_sites WHERE deleted = '0' AND site_id = '".$site_id."' ";
		 $getSite = mysql_query($query_getSite, $ikiosk) or sqlError(mysql_error());
		 $row_getSite = mysql_fetch_assoc($getSite);
		 $totalRows_getSite = mysql_num_rows($getSite);
		 
		 $rootFolder = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSite['site_root'];
			if (!file_exists($rootFolder)) {
					createDIR($rootFolder);	
					createDIR($rootFolder."/blog");
					createDIR($rootFolder."/static");
					createDIR($rootFolder."/cms");
					createDIR($rootFolder."/static/resources");
					createDIR($rootFolder."/static/resources/userfiles");
					createDIR($rootFolder."/static/resources/userphotos");
				
					//Create Index.html
					$pageID = "ikiosk-".create_guid();
					$insertSQL = sprintf("INSERT INTO cms_pages (page_id, site_id, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s)",
							GetSQLValueString($pageID, "text"),
							GetSQLValueString($site_id, "text"),
							GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
							GetSQLValueString($_SESSION['user_id'], "text"),
							GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
							GetSQLValueString($_SESSION['user_id'], "text"));
					
					mysql_select_db($database_ikiosk, $ikiosk);
					$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
					sqlQueryLog($insertSQL);
	
					//Create Page Version
					$pageVersionID = create_guid();
					$insertSQL = sprintf("INSERT INTO cms_page_versions (page_version_id, page_id, site_id, title, version, status, auto_expire, menu_display_order, static_folder, static_file, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
								GetSQLValueString($pageVersionID, "text"),
								GetSQLValueString($pageID, "text"),
								GetSQLValueString($site_id, "text"),
								GetSQLValueString("Home", "text"),
								GetSQLValueString("0.0", "text"),
								GetSQLValueString("Published", "text"),
								GetSQLValueString("No", "text"),
								GetSQLValueString("0.00", "text"),
								GetSQLValueString("/", "text"),
								GetSQLValueString("index.html", "text"),
								GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
								GetSQLValueString($_SESSION['user_id'], "text"),
								GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
								GetSQLValueString($_SESSION['user_id'], "text"));
						
					mysql_select_db($database_ikiosk, $ikiosk);
					$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
					sqlQueryLog($insertSQL);
					
					v7quickPublish($site_id, $pageID, "/", "index.html");
					
					//Create System Album
					mysql_select_db($database_ikiosk, $ikiosk);
					$query_getRecord = "SELECT * FROM sys_photo_albums WHERE deleted = '0' AND site_id = '".$site_id."' AND album_id = '".$site_id."'";
					$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
					$row_getRecord = mysql_fetch_assoc($getRecord);
					$totalRows_getRecord = mysql_num_rows($getRecord);
				
					if ($totalRows_getRecord == 0) {
						$generateID = create_guid();
						$insertSQL = sprintf("INSERT INTO sys_photo_albums (`album_id`, `site_id`, `album_cover_id`, `title`, `description`, `parent_id`, `date_created`, `created_by`, `date_modified`, `modified_by`, `status`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
								GetSQLValueString($site_id, "text"),
								GetSQLValueString($site_id, "text"),
								GetSQLValueString($_POST['album_cover_id'], "text"),
								GetSQLValueString("Image Uploads", "text"),
								GetSQLValueString($_POST['description'], "text"),
								GetSQLValueString($_POST['parent_id'], "text"),
								GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
								GetSQLValueString($_SESSION['user_id'], "text"),
								GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
								GetSQLValueString($_SESSION['user_id'], "text"),
								GetSQLValueString("Active", "text"));
						
						mysql_select_db($database_ikiosk, $ikiosk);
						$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
						sqlQueryLog($insertSQL);
					}
					
					//Create System Album
					mysql_select_db($database_ikiosk, $ikiosk);
					$query_getRecord = "SELECT * FROM cms_config WHERE deleted = '0' AND site_id = '".$site_id."'";
					$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
					$row_getRecord = mysql_fetch_assoc($getRecord);
					$totalRows_getRecord = mysql_num_rows($getRecord);
				
					if ($totalRows_getRecord == 0) {
						$generateID = create_guid();

						$insertSQL = sprintf("INSERT INTO cms_config (config_id, site_id, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s)",
								GetSQLValueString($generateID, "text"),
								GetSQLValueString($site_id, "text"),
								GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
								GetSQLValueString($_SESSION['user_id'], "text"),
								GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
								GetSQLValueString($_SESSION['user_id'], "text"));
						
						mysql_select_db($database_ikiosk, $ikiosk);
						$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
						sqlQueryLog($insertSQL);
					}
					
					
					//Create .htaccess file in Site Root
					$siteHost = strpos($_SERVER['DOCUMENT_ROOT'], "kunden");
					if ($siteHost === false) {
						$htaccess = "AddType application/x-httpd-php .html .htm\r\n";
					} else {
						$htaccess = "AddHandler x-mapp-php5 .html .htm\r\n";
					}
					$htaccess .= "ErrorDocument 400 ".$row_getRecord['site_url']."/400.htm\r\n";
					$htaccess .= "ErrorDocument 403 ".$row_getRecord['site_url']."/403.htm\r\n";
					$htaccess .= "ErrorDocument 404 ".$row_getRecord['site_url']."/404.htm\r\n";
					$htaccess .= "ErrorDocument 500 ".$row_getRecord['site_url']."/500.htm\r\n";
					
					$htaccessFile = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSite['site_root']."/.htaccess";
					$fh = fopen($htaccessFile, 'w') or errorLog("Unable to create .htaccess file");
					fwrite($fh, $htaccess);
					fclose($fh);
					
			}
			
			//Grab Compile CSS UI Css File
			$fileContents = urlFetch($SYSTEM['ikiosk_filesystem_root']."/ikiosk/smartui/css/ikioskUI.css");
			$destinationFile = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSite['site_root']."/cms/iKioskUI.css";
			$fh = fopen($destinationFile, 'w') or errorLog("Unable to create create: ".$destinationFile, "System Error", $redirect);	
			fwrite($fh, $fileContents);
			fclose($fh);
						
			//Copy CMS Admin Files
			$cmsAdmin = array("editPage.php", "displayPage.php", "index.php", "login.php", "iKioskCMS.js", "ajaxHandler.php", "logout.php");
			foreach ($cmsAdmin as $key => $value) {
					$fileContent = 	urlFetch($SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root']."/webapps/cms/".$value);
					$ikioskCore = $SYSTEM['ikiosk_docroot']."/includes/core/ikiosk.php";
					$fileContent = str_replace("ikiosk-tmp-core", $ikioskCore, $fileContent);
					$fileContent = str_replace("ikiosk_tmp_site", $site_id, $fileContent);
					
					$adminFile = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSite['site_root']."/cms/".$value;
					$fh = fopen($adminFile, 'w') or errorLog("Unable to create ".$adminFile);
					fwrite($fh, $fileContent);
					fclose($fh);
			}
}

//Quickly Creates Blank Page
function v7quickPublish($site_id, $page_id, $page_folder, $page_file) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	//Get Site Properties
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getSiteInfo = "SELECT * FROM sys_sites WHERE site_id = '".$site_id."' AND deleted = '0'";
	$getSiteInfo = mysql_query($query_getSiteInfo, $ikiosk) or sqlError(mysql_error());
	$row_getSiteInfo = mysql_fetch_assoc($getSiteInfo);
	$totalRows_getSiteInfo = mysql_num_rows($getSiteInfo);
	
	$physicalFile = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSiteInfo['site_root'].$page_folder.$page_file;
	$pageContent = urlFetch($SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root']."/webapps/cms/pageTemplate.php");
	
	//Page Specific Replace
	$ikioskCore = $SYSTEM['ikiosk_docroot']."/includes/core/ikiosk.php";
	$page_id = $page_id;
	
	$pageContent = str_replace("ikiosk-tmp-core", $ikioskCore, $pageContent);
	$pageContent = str_replace("ikiosk-tmp-page", $page_id, $pageContent);

	//Write File
	$fh = fopen($physicalFile, 'w+');
	fwrite($fh, $pageContent);
	fclose($fh);
}


//Create 404 and Index.html
function cmsCreateDefaults($site_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;

	//Get Site Information
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getSite = "SELECT * FROM sys_sites WHERE deleted = '0' AND site_id = '".$site_id."'";
	$getSite = mysql_query($query_getSite, $ikiosk) or sqlError(mysql_error());
	$row_getSite = mysql_fetch_assoc($getSite);
	$totalRows_getSite = mysql_num_rows($getSite);
	
	if ($totalRows_getSite != 0) {
		
	//Analytics Settings for Shared Server
	if ($SYSTEM['system_url'] == "http://cms.ikioskapps.com") {
	
		$updateSQL = sprintf("UPDATE sys_sites SET google_api_client_id=%s, google_api_client_secret=%s, google_api_redirect_url=%s, google_api_key=%s, date_modified=%s, modified_by=%s WHERE site_id=%s",
		GetSQLValueString("525085631154.apps.googleusercontent.com", "text"),
		GetSQLValueString("S_u_wYK1tw4slpWiglWmJSfe", "text"),
		GetSQLValueString("http://cms.ikioskapps.com/ikiosk/webapps/cms/index.php", "text"),
		GetSQLValueString("AIzaSyCuVIyhoWZ0kI2uHPuBGjaXMLb6dmkMg-A", "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($site_id, "text"));

		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($updateSQL);
		
	}
		
	//Create Index.html
	$pageID = "ikiosk-".create_guid();
	$insertSQL = sprintf("INSERT INTO cms_pages (page_id, site_id, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s)",
			GetSQLValueString($pageID, "text"),
			GetSQLValueString($site_id, "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"));
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($insertSQL);
	
	//Create Page Version
	$pageVersionID = create_guid();
	$insertSQL = sprintf("INSERT INTO cms_page_versions (page_version_id, page_id, site_id, title, version, status, auto_expire, menu_display_order, static_folder, static_file, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
				GetSQLValueString($pageVersionID, "text"),
				GetSQLValueString($pageID, "text"),
				GetSQLValueString($site_id, "text"),
				GetSQLValueString("Home", "text"),
				GetSQLValueString("0.0", "text"),
				GetSQLValueString("Published", "text"),
				GetSQLValueString("No", "text"),
				GetSQLValueString("0.00", "text"),
				GetSQLValueString("/", "text"),
				GetSQLValueString("index.html", "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"));
		
	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($insertSQL);	
	
	quickPublish($site_id, $pageID, "/", "index.html");
	
	
	//Create 404 page
	$pageID = "ikiosk-".create_guid();
	$insertSQL = sprintf("INSERT INTO cms_pages (page_id, site_id, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s)",
			GetSQLValueString($pageID, "text"),
			GetSQLValueString($site_id, "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"));
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($insertSQL);
	
	//Create Page Version
	$pageVersionID = create_guid();
	$insertSQL = sprintf("INSERT INTO cms_page_versions (page_version_id, page_id, site_id, title, version, status, auto_expire, menu_display_order, static_folder, static_file, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
				GetSQLValueString($pageVersionID, "text"),
				GetSQLValueString($pageID, "text"),
				GetSQLValueString($site_id, "text"),
				GetSQLValueString("Page Not Found", "text"),
				GetSQLValueString("0.0", "text"),
				GetSQLValueString("Published", "text"),
				GetSQLValueString("No", "text"),
				GetSQLValueString("0.00", "text"),
				GetSQLValueString("/", "text"),
				GetSQLValueString("404.htm", "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"));
		
	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($insertSQL);
	
	quickPublish($site_id, $pageID, "/", "404.htm");
	
	//Create System Album
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM sys_photo_albums WHERE deleted = '0' AND site_id = '".$site_id."' AND album_id = '".$site_id."'";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);
	
	if ($totalRows_getRecord == 0) {
		$generateID = create_guid();
		$insertSQL = sprintf("INSERT INTO sys_photo_albums (`album_id`, `site_id`, `album_cover_id`, `title`, `description`, `parent_id`, `date_created`, `created_by`, `date_modified`, `modified_by`, `status`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
				GetSQLValueString($site_id, "text"),
				GetSQLValueString($site_id, "text"),
				GetSQLValueString($_POST['album_cover_id'], "text"),
				GetSQLValueString("Image Uploads", "text"),
				GetSQLValueString($_POST['description'], "text"),
				GetSQLValueString($_POST['parent_id'], "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"),
				GetSQLValueString("Active", "text"));
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);
	}
	
	//Create .htaccess file in Site Root
	if(!file_exists($SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSite['site_root']."/.htaccess")) {
		$htaccess = "AddHandler x-mapp-php5 .html .htm\r\n";
		$htaccess .= "ErrorDocument 400 ".$row_getRecord['site_url']."/400.htm\r\n";
		$htaccess .= "ErrorDocument 403 ".$row_getRecord['site_url']."/403.htm\r\n";
		$htaccess .= "ErrorDocument 404 ".$row_getRecord['site_url']."/404.htm\r\n";
		$htaccess .= "ErrorDocument 500 ".$row_getRecord['site_url']."/500.htm\r\n";
		
		$htaccessFile = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSite['site_root']."/.htaccess";
		$fh = fopen($htaccessFile, 'w') or errorLog("Unable to create .htaccess file");
		fwrite($fh, $htaccess);
		fclose($fh);
	}
	
	//Map Blog FIles
	$blog[0]['source'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/blog_index.tpl.php"; $blog[0]['destination'] = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSite['site_root']."/blog/index.php"; $blog[0]['compile'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/blog_index.php";
	
	$blog[1]['source'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/blog_post.tpl.php"; $blog[1]['destination'] = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSite['site_root']."/blog/post.php";  $blog[1]['compile'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/blog_post.php";
	
	$blog[2]['source'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/blog_category.tpl.php"; $blog[2]['destination'] = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSite['site_root']."/blog/category.php";  $blog[2]['compile'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/blog_category.php";
	
	$blog[3]['source'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/blog_preview.tpl.php"; $blog[3]['destination'] = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSite['site_root']."/blog/preview.php";  $blog[3]['compile'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/blog_preview.php";
	
	//API Files
	
	$blog[4]['source'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/channel.php"; $blog[4]['destination'] = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSite['site_root']."/api/channel.html";  $blog[4]['compile'] = $SYSTEM['ikiosk_docroot']."/api/channel.html";
	
	$blog[5]['source'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/api_index.tpl.php"; $blog[5]['destination'] = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSite['site_root']."/api/index.php";  $blog[5]['compile'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/api_index.php";	
	
	$blog[6]['source'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/api_index.tpl.php"; $blog[6]['destination'] = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSite['site_root']."/api/login.php";  $blog[6]['compile'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/api_login.php";	
	
	//CMS Async Calls
$blog[7]['source'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/cms_async.tpl.php"; $blog[7]['destination'] = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSite['site_root']."/api/cms_async_selectors.php";  $blog[7]['compile'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/async_selectors.php";		
	
	$ikioskCore = $SYSTEM['ikiosk_docroot']."/includes/core/ikiosk.php";
	
	//Copy Site Setup Files
	foreach ($blog as $key => $value) {
		if((!file_exists($blog[$key]['destination'])) || ($_GET['option'] == "update")) {
			$blogContents = urlFetch($blog[$key]['source']);
			$blogContents = str_replace("ikiosk-tmp-core", $ikioskCore, $blogContents);
			$blogContents = str_replace("ikiosk_tmp_site", $row_getSite['site_id'], $blogContents);
			
			$page_compile = $blog[$key]['compile'];
			$blogContents = str_replace("ikiosk-tmp-compiler", $page_compile, $blogContents);
	
			$fh = fopen($blog[$key]['destination'], 'w+');
			fwrite($fh, $blogContents);
			fclose($fh);
		}
	}
		
	}
}

//Absolute URL
function absolute_url($txt, $base_url){ 
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
  $needles = array('href="', 'src="', 'background="'); 
  $new_txt = ''; 
  if(substr($base_url,-1) != '/') $base_url .= '/'; 
  $new_base_url = $base_url; 
  $base_url_parts = parse_url($base_url); 

  foreach($needles as $needle){ 
    while($pos = strpos($txt, $needle)){ 
      $pos += strlen($needle); 
      if(substr($txt,$pos,7) != 'http://' && substr($txt,$pos,8) != 'https://' && substr($txt,$pos,6) != 'ftp://' && substr($txt,$pos,7) != 'mailto:' && substr($txt,$pos,1) != '#' && substr($txt,$pos,2) != './' && substr($txt,$pos,3) != '../' && substr($txt,$pos,2) != '//' ){ 
        if(substr($txt,$pos,1) == '/') $new_base_url = $SITE['site_url'];
        $new_txt .= substr($txt,0,$pos).$new_base_url; 
      } else { 
        $new_txt .= substr($txt,0,$pos); 
      } 
      $txt = substr($txt,$pos); 
    } 
    $txt = $new_txt.$txt; 
    $new_txt = '';
  } 
  return $txt; 
}  

//Create System Album for Uploads
function systemAlbum() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM sys_photo_albums WHERE deleted = '0' AND site_id = '".$SITE['site_id']."' AND album_id = '".$SITE['site_id']."'";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);
	
	if ($totalRows_getRecord == 0) {
	
		$generateID = create_guid();
		
		$insertSQL = sprintf("INSERT INTO sys_photo_albums (`album_id`, `site_id`, `album_cover_id`, `title`, `description`, `parent_id`, `date_created`, `created_by`, `date_modified`, `modified_by`, `status`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
				GetSQLValueString($SITE['site_id'], "text"),
				GetSQLValueString($SITE['site_id'], "text"),
				GetSQLValueString($_POST['album_cover_id'], "text"),
				GetSQLValueString("Image Uploads", "text"),
				GetSQLValueString($_POST['description'], "text"),
				GetSQLValueString($_POST['parent_id'], "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"),
				GetSQLValueString("Active", "text"));
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);
		
	}
	
}

//Generate Custom CSS
function generateCSS($type) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM cms_styles WHERE deleted = '0' AND site_id = '".$SITE['site_id']."' AND team_id = '1' ORDER BY display_order ASC";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_showColumns = "SHOW COLUMNS FROM cms_styles";
	$showColumns = mysql_query($query_showColumns, $ikiosk) or sqlError(mysql_error());
	$row_showColumns = mysql_fetch_assoc($showColumns);
	$totalRows_showColumns = mysql_num_rows($showColumns);

	do {
		if (($row_showColumns['Field'] != "site_id") && ($row_showColumns['Field'] != "style_id") && ($row_showColumns['Field'] != "display_order") && ($row_showColumns['Field'] != "selector_name") && ($row_showColumns['Field'] != "date_created") && ($row_showColumns['Field'] != "created_by") && ($row_showColumns['Field'] != "date_modified") && ($row_showColumns['Field'] != "modified_by") && ($row_showColumns['Field'] != "team_id")  && ($row_showColumns['Field'] != "deleted")) {
		
		$Columns[$row_showColumns['Field']] = $row_showColumns['Field'];
		
		}
		
	} while ($row_showColumns = mysql_fetch_assoc($showColumns));


	$cssContent = "";
	
	if ($totalRows_getRecord != 0) {
		do {
			
			$cssContent .= trim($row_getRecord['selector_name'])." {\r\n";
			
				foreach($Columns as $key => $value) {
					if ($row_getRecord[$value] != "") {
						
					$cssContent .= "\t".$value.": ";
					
					//Colors
					if (($value == "color") || ($value == "background-color") || ($value == "border-bottom-color") || ($value == "border-top-color") || ($value == "border-left-color") || ($value == "border-right-color")) {
						$cssContent .= "#";	
					}
					
					//Images
					if (($value == "background-image")) {
						$cssContent .= "url(";	
					}
					
					$cssContent .= $row_getRecord[$value];
					
					//Images
					if (($value == "background-image")) {
						$cssContent .= ")";	
					}
					
					//Pixel Sizes
					if (($value == "font-size") || ($value == "line-height") || ($value == "height") || ($value == "width") || ($value == "padding-left") || ($value == "padding-right") || ($value == "padding-top") || ($value == "padding-bottom") || ($value == "margin-left") || ($value == "margin-right") || ($value == "margin-top") || ($value == "margin-bottom") || ($value == "border-top-width") || ($value == "border-left-width") || ($value == "border-bottom-width") || ($value == "border-right-width") || ($value == "top") || ($value == "left") || ($value == "bottom") || ($value == "right") || ($value == "word-spacing") || ($value == "letter-spacing") || ($value == "text-indent") || ($value == "border-top-left-radius") || ($value == "border-top-right-radius") || ($value == "border-bottom-left-radius") || ($value == "border-bottom-right-radius")) {
						
						$cssContent .= "px";			
					}
					
					$cssContent .= ";\r\n";
					}
				}
							
			$cssContent .= "}\r\n\r\n";
		
		} while ($row_getRecord = mysql_fetch_assoc($getRecord));	
	}
	
	if ($type == "live") {
		$cssFile = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/static/resources/styles-prod.css";
	} else {
		$cssFile = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/static/resources/styles-stage.css";
	}
	$fh = fopen($cssFile, 'w') or errorAlert("Unable to create CSS file");
	fwrite($fh, $cssContent);
	fclose($fh);
}
//Display Map Hiearchy
function displaySiteMap() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$filters = " AND a.site_id = '".$SITE['site_id']."'";
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT *, b.parent_id FROM cms_page_versions a INNER JOIN cms_pages b ON a.page_id = b.page_id WHERE (b.parent_id = '' OR b.parent_id IS NULL) AND b.deleted = '0' AND a.deleted = '0'".$filters." AND a.status = 'Published' ORDER BY title ASC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	
	if ($totalRows_getRecords != "0") {
		
		$menu = "<ul id=\"site_map\">";
		
		do {
			$menu .= "<li><a href=\"editPage.php?recordID=".$row_getRecords['page_version_id']."\">".$row_getRecords['title']."</a> <span class=\"file_link\"> - ".$row_getRecords['static_folder'].$row_getRecords['static_file']."</span>";
			$menu .= displaySiteChildren($row_getRecords['page_id']);
			$menu .= "</li>\r\n";
		} while ($row_getRecords = mysql_fetch_assoc($getRecords));	
		
		$menu .= "</ul>";
	}
	
	echo $menu;
	
}

function displaySiteChildren($parent_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$filters = " AND a.site_id = '".$SITE['site_id']."'";
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT *, b.parent_id FROM cms_page_versions a INNER JOIN cms_pages b ON a.page_id = b.page_id WHERE (b.parent_id = '".$parent_id."') AND b.deleted = '0' AND a.deleted = '0' AND a.status = 'Published' ".$filters." ORDER BY title ASC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if ($totalRows_getRecords != "0") {
		$menu = "<ul>";
		do {
			$menu .= "<li><a href=\"editPage.php?recordID=".$row_getRecords['page_version_id']."\">".$row_getRecords['title']."</a> <span class=\"file_link\"> - ".$row_getRecords['static_folder'].$row_getRecords['static_file']."</span>";
			$menu .= displaySiteChildren($row_getRecords['page_id']);
			$menu .= "</li>\r\n";
			} while ($row_getRecords = mysql_fetch_assoc($getRecords));	
		$menu .="</ul>";
	}

	return $menu;
}

//Check for Category Link
function cmsCategoryCheck($article_id, $category_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $row_getPage;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM cms_blog_links WHERE article_id = '".$article_id."' AND category_id = '".$category_id."' AND deleted = '0' AND site_id = '".$row_getPage['site_id']."' AND team_id = '1'";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);	
	
	$match = "No";
	
	if ($totalRows_getRecord != "0") {
		$match = "Yes";	
	}
	
	return $match;
}

//Blog Category List
function cmsBlogCatList($article_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $row_getPage;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM cms_blog_links WHERE article_id = '".$article_id."' AND deleted = '0' AND site_id = '".$row_getPage['site_id']."' AND team_id = '1'";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);
	
	if ($totalRows_getRecord != "0") {
		do {
		$catList .= " <a href=\"".$SITE['site_url']."/blog/category.php?id=".$row_getRecord['category_id']."\">";
		$catList .= crossReference("cms_categories", "category_id", $row_getRecord['category_id'], " site_id ='".$row_getPage['site_id']."'", $teamFilter, $siteFilter, "title", "return");
		$catList .= "</a>,";	
		} while ($row_getRecord = mysql_fetch_assoc($getRecord));				
	}
	$catList = substr($catList, 0, -1);
	return $catList;
}

//Build Blog Front End
function blogUI() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	//Create System Album
	systemAlbum();
	
	//Create .htaccess file in Site Root
	if((!file_exists($SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/.htaccess")) || ($_GET['option'] == "update")) {
		$htaccess = "AddHandler x-mapp-php5 .html .htm\r\n";
		$htaccess .= "ErrorDocument 400 ".$SITE['site_url']."/400.htm\r\n";
		$htaccess .= "ErrorDocument 403 ".$SITE['site_url']."/403.htm\r\n";
		$htaccess .= "ErrorDocument 404 ".$SITE['site_url']."/404.htm\r\n";
		$htaccess .= "ErrorDocument 500 ".$SITE['site_url']."/500.htm\r\n";
		
		$htaccessFile = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/.htaccess";
		$fh = fopen($htaccessFile, 'w') or errorLog("Unable to create .htaccess file");
		fwrite($fh, $htaccess);
		fclose($fh);
		
	}
	
	//Map Blog FIles
	$blog[0]['source'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/blog_index.tpl.php"; $blog[0]['destination'] = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/blog/index.php"; $blog[0]['compile'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/blog_index.php";
	
	$blog[1]['source'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/blog_post.tpl.php"; $blog[1]['destination'] = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/blog/post.php";  $blog[1]['compile'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/blog_post.php";
	
	$blog[2]['source'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/blog_category.tpl.php"; $blog[2]['destination'] = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/blog/category.php";  $blog[2]['compile'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/blog_category.php";
	
	$blog[3]['source'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/blog_preview.tpl.php"; $blog[3]['destination'] = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/blog/preview.php";  $blog[3]['compile'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/blog_preview.php";
	
	//API Files
	
	$blog[4]['source'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/channel.php"; $blog[4]['destination'] = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/api/channel.html";  $blog[4]['compile'] = $SYSTEM['ikiosk_docroot']."/api/channel.html";
	
	$blog[5]['source'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/api_index.tpl.php"; $blog[5]['destination'] = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/api/index.php";  $blog[5]['compile'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/api_index.php";	
	
	$blog[6]['source'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/api_index.tpl.php"; $blog[6]['destination'] = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/api/login.php";  $blog[6]['compile'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/api_login.php";	
	
	//CMS Async Calls
$blog[7]['source'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/cms_async.tpl.php"; $blog[7]['destination'] = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/api/cms_async_selectors.php";  $blog[7]['compile'] = $SYSTEM['ikiosk_docroot']."/webapps/cms/async_selectors.php";		
	
	
	$ikioskCore = $SYSTEM['ikiosk_docroot']."/includes/core/ikiosk.php";

	//Copy Blog Files
	foreach ($blog as $key => $value) {
		if((!file_exists($blog[$key]['destination'])) || ($_GET['option'] == "update")) {
			$blogContents = urlFetch($blog[$key]['source']);
			$blogContents = str_replace("ikiosk-tmp-core", $ikioskCore, $blogContents);
			$blogContents = str_replace("ikiosk_tmp_site", $SITE['site_id'], $blogContents);
			
			$page_compile = $blog[$key]['compile'];
			$blogContents = str_replace("ikiosk-tmp-compiler", $page_compile, $blogContents);
	
			$fh = fopen($blog[$key]['destination'], 'w+');
			fwrite($fh, $blogContents);
			fclose($fh);
		}
	}
}

//CMS System Tags
function sysTagCMS($systemTag) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $row_getPage, $facebook;

	//Navigation Menu
	if ($systemTag[1] == "navmenu") {navMenu();}
	if ($systemTag[1] == "search-results") {cmsSearch();}
	if ($systemTag[1] == "breadcrumbs") {cmsBreadcrumbs();}
	if ($systemTag[1] == "related") {cmsRelated();}
	if ($systemTag[1] == "more-info") {cmsMoreInfo();}
	if ($systemTag[1] == "php-script") {cmsPHP($systemTag[2]);}
	if ($systemTag[1] == "properties") {cmsProperties($systemTag[2]);}
	if ($systemTag[1] == "gallery") {cmsMultimediaGallery($systemTag[2]);}
	if ($systemTag[1] == "twitter") {cmsTwitter($systemTag[2]);}
	if ($systemTag[1] == "slideshow") {cmsSlideshow($systemTag);}
	if ($systemTag[1] == "photogallery") {cmsPhotoGallery($systemTag[2]);}
	if ($systemTag[1] == "masonrygallery") {cmsMasonryGallery($systemTag[2]);}
	if ($systemTag[1] == "blog") {cmsBlogTag($systemTag[2]);}
	if ($systemTag[1] == "template-section") {cmsTemplateSection($systemTag[2]);}
}

//CMS Template Sections
function cmsTemplateSection($section_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $row_getPage, $facebook;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM cms_page_elements a INNER JOIN cms_elements2pages b on a.page_element_id = b.page_element_id WHERE a.template_section_id = '".$section_id."' AND b.page_id = '".$row_getPage['page_id']."' AND b.deleted = '0' AND b.site_id = '".$SITE['site_id']."'  AND a.deleted = '0' AND a.site_id = '".$SITE['site_id']."' AND a.team_id = '1' ORDER BY a.display_order ASC";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);
	
	if ($totalRows_getRecord != "0") {
		do {
			contentProcessor($row_getRecord['content']);	
		} while ($row_getRecord = mysql_fetch_assoc($getRecord));	
	}
}

//Blog Tag
function cmsBlogTag($blogTag) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $row_getPage, $facebook;

	//Category List
	if ($blogTag == "category-list") {
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getRecord = "SELECT * FROM cms_categories WHERE category_type = 'blog' AND deleted = '0' AND site_id = '".$SITE['site_id']."' AND team_id = '1' ORDER BY title ASC";
		$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
		$row_getRecord = mysql_fetch_assoc($getRecord);
		$totalRows_getRecord = mysql_num_rows($getRecord);
		
		if ($totalRows_getRecord != "0") {
			echo "<div class=\"cms-category-list\">\r\n";
			echo "<h3>Categories</h3>\r\n";
			echo "<ul>\r\n";
			do {
				
				mysql_select_db($database_ikiosk, $ikiosk);
				$query_getCategory = "SELECT * FROM cms_blog_links WHERE category_id = '".$row_getRecord['category_id']."' AND deleted = '0' AND site_id = '".$SITE['site_id']."'";
				$getCategory = mysql_query($query_getCategory, $ikiosk) or sqlError(mysql_error());
				$row_getCategory = mysql_fetch_assoc($getCategory);
				$totalRows_getCategory = mysql_num_rows($getCategory);	
				
				if ($totalRows_getCategory != "0") {
				
					echo "<li><a href=\"".$SITE['site_url']."/blog/category.php?id=".$row_getRecord['category_id']."\">".$row_getRecord['title']."</a></li>";
				}
				
					
			} while ($row_getRecord = mysql_fetch_assoc($getRecord));	

			echo "</ul></div>\r\n";
		}
		
	}
	
	//Recent Posts
	if ($blogTag == "recent-posts") {
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getRecord = "SELECT * FROM cms_blog_article_versions a INNER JOIN cms_blog_articles b ON a.article_id = b.article_id WHERE a.site_id = '".$SITE['site_id']."' AND a.status = 'Published' AND a.deleted = '0' AND b.deleted = '0' ORDER BY a.display_order DESC, b.date_created DESC";
		$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
		$row_getRecord = mysql_fetch_assoc($getRecord);
		$totalRows_getRecord = mysql_num_rows($getRecord);		
		
		if ($totalRows_getRecord != "0") {
		$i = 1;
		$displayPage = 	cmsPublishCheckBlog($row_getRecord['article_version_id']);
		
		echo "<div class=\"cms-recent-list\">\r\n";
		echo "<h3>Recent Articles</h3>\r\n";
		echo "<ul>\r\n";
	
		if ($displayPage == "Yes"){
				do {
					if ($i <= 5) {
					echo "<li><a href=\"".$SITE['site_url']."/blog/post.php?id=".$row_getRecord['article_id']."\">".$row_getRecord['title']."</a></li>";	
	
					}
				$i++;	
				} while ($row_getRecord = mysql_fetch_assoc($getRecord));	
			}
		echo "</ul></div>\r\n";

		}
		
	}
	
	//Archive List
	if ($blogTag == "archive-list") {
		
		$i = 0;
		$todaysDate = mktime(0,0,0,date('m'), date('d'), date('Y'));

		$day = "1";
		$month = date('m', $todaysDate);
		$year = date('Y', $todaysDate);
		
		echo "<div class=\"cms-recent-list\">\r\n";
		echo "<h3>Archives</h3>\r\n";
		echo "<ul>\r\n";
		
		do {
			
			$dateController =  mktime(0,0,0,($month +1),1,$year);
			$dateController = date("Y-m-d H:i:s", $dateController);
			$dateController2 = mktime(0,0,0,($month),1,$year);
			$dateController2 = date("Y-m-d H:i:s", $dateController2);
			$dateController3 = mktime(0,0,0,$month,1,$year);
			$dateController3 = date("Y-m-d", $dateController3);
			
			mysql_select_db($database_ikiosk, $ikiosk);
			$query_getRecord = "SELECT * FROM cms_blog_article_versions a INNER JOIN cms_blog_articles b ON a.article_id = b.article_id WHERE a.site_id = '".$SITE['site_id']."' AND a.status = 'Published' AND a.deleted = '0' AND b.deleted = '0' AND b.date_created >= '".$dateController2."' AND b.date_created < '".$dateController."' ORDER BY a.display_order DESC, b.date_created DESC";
			$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
			$row_getRecord = mysql_fetch_assoc($getRecord);
			$totalRows_getRecord = mysql_num_rows($getRecord);	
		
			if ($totalRows_getRecord != "0") { 	
			
			$thisMonth = strtotime($dateController2);
			$thisMonth = date("M Y", $thisMonth);
			
			echo "<li><a href=\"".$SITE['site_url']."/blog/index.php?archiveDate=".$dateController2."\">".$thisMonth."</a> (".$totalRows_getRecord.")</li>";
			}
			
			$i++;
			$month = $month - 1;
		} while ($i <= 11); 
		
		echo "</ul></div>\r\n";

		
	}
}

//Display Twitter Feed
function cmsTwitter($feed_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $row_getPage;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM cms_twitter_feeds WHERE feed_id = '".$feed_id."' AND deleted = '0' AND site_id = '".$SITE['site_id']."' AND team_id = '1'";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);
	
	$SYSTEM['active_site_filter'] = " (team_id = '1') AND (site_id = '".$row_getPage['site_id']."') ";
	
	if ($totalRows_getRecord != "0") {
	include($SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root']."/webapps/cms/twitter_base.php"); 
	}
}

//Display Slideshow
function cmsSlideshow($album_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $row_getPage;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM sys_photo_albums WHERE album_id = '".$album_id[2]."' AND deleted = '0' AND site_id = '".$row_getPage['site_id']."' AND team_id = '1'";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);
	
	$SYSTEM['active_site_filter'] = " (team_id = '1') AND (site_id = '".$row_getPage['site_id']."') ";
	
	if ($totalRows_getRecord != "0") {
	include($SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root']."/webapps/cms/slideshow_base.php"); 
	}
	
}

//Display Photo Album us Masonry
function cmsMasonryGallery($album_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $row_getPage;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM sys_photo_albums WHERE album_id = '".$album_id."' AND deleted = '0' AND site_id = '".$row_getPage['site_id']."' AND team_id = '1'";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);
	
	$SYSTEM['active_site_filter'] = " (team_id = '1') AND (site_id = '".$row_getPage['site_id']."') ";
	
	if ($totalRows_getRecord != "0") {
	include($SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root']."/webapps/cms/masonryGallery_base.php"); 
	}
	
}

//Display Photo Album 
function cmsPhotoGallery($album_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $row_getPage;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM sys_photo_albums WHERE album_id = '".$album_id."' AND deleted = '0' AND site_id = '".$row_getPage['site_id']."' AND team_id = '1'";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);
	
	$SYSTEM['active_site_filter'] = " (team_id = '1') AND (site_id = '".$row_getPage['site_id']."') ";
	
	if ($totalRows_getRecord != "0") {
	include($SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root']."/webapps/cms/photoGallery_base.php"); 
	}
	
}

//Display Multimedia Gallery
function cmsMultimediaGallery($gallery_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $row_getPage;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_cms_galleries = "SELECT * FROM cms_galleries WHERE gallery_id = '".$gallery_id."' AND deleted = '0' AND site_id = '".$row_getPage['site_id']."'";
	$cms_galleries = mysql_query($query_cms_galleries, $ikiosk) or sqlError(mysql_error());
	$row_cms_galleries = mysql_fetch_assoc($cms_galleries);
	$totalRows_cms_galleries = mysql_num_rows($cms_galleries);
	
	$SYSTEM['active_site_filter'] = " (team_id = '1') AND (site_id = '".$row_getPage['site_id']."') ";
	
	if ($totalRows_cms_galleries != "0") {
	include($SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root']."/webapps/cms/gallery_base.php"); 
	}
	

}
//CMS Properties
function cmsProperties($field) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $row_getPage;
	
	$data = $row_getPage[$field];
	if ($field == "date_modified") {
		$data = timezoneProcess($row_getPage[$field], "return");
	}
	echo $data;
}

//More Info
function cmsMoreInfo() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $row_getPage;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getChildren = "SELECT *, b.parent_id FROM cms_page_versions a INNER JOIN cms_pages b ON a.page_id = b.page_id WHERE b.deleted = '0' AND a.deleted = '0' AND a.status = 'Published' AND b.parent_id = '".$row_getPage['page_id']."' AND a.site_id = '".$row_getPage['site_id']."' ORDER BY title ASC";
	$getChildren = mysql_query($query_getChildren, $ikiosk) or sqlError(mysql_error());
	$row_getChildren = mysql_fetch_assoc($getChildren);
	$totalRows_getChildren = mysql_num_rows($getChildren);		
	
	if ($totalRows_getChildren != "0") {
	
	$related = "<ul class=\"cms-more-info\">";
	do {
	$displayPage = 	cmsPublishCheck($row_getChildren['page_version_id']);
		if ($displayPage == "Yes") {
			$related .= "<li><a href=\"".$row_getChildren['static_folder'].$row_getChildren['static_file']."\">".$row_getChildren['title']."</a></li>";	
		}
	} while ($row_getChildren = mysql_fetch_assoc($getChildren));	
	$related .= "</ul>";
	echo $related;	
		
	}
}

//Related Pages
function cmsRelated() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $row_getPage;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT *, b.parent_id FROM cms_page_versions a INNER JOIN cms_pages b ON a.page_id = b.page_id WHERE b.deleted = '0' AND a.deleted = '0' AND a.status = 'Published' AND a.page_id = '".$row_getPage['page_id']."' AND a.site_id = '".$row_getPage['site_id']."'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);	
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getSiblings = "SELECT *, b.parent_id FROM cms_page_versions a INNER JOIN cms_pages b ON a.page_id = b.page_id WHERE b.deleted = '0' AND a.deleted = '0' AND a.status = 'Published' AND b.parent_id = '".$row_getRecords['parent_id']."' AND a.site_id = '".$row_getPage['site_id']."' ORDER BY title ASC";
	$getSiblings = mysql_query($query_getSiblings, $ikiosk) or sqlError(mysql_error());
	$row_getSiblings = mysql_fetch_assoc($getSiblings);
	$totalRows_getSiblings = mysql_num_rows($getSiblings);	
	
	if ($totalRows_getSiblings != 0) {
	
	$related = "<ul class=\"cms-related\">";
	do {
	$displayPage = 	cmsPublishCheck($row_getSiblings['page_version_id']);
		if ($displayPage == "Yes") {
			if ($row_getPage['page_version_id'] == $row_getSiblings['page_version_id']) {
				$class = " class=\"active\" ";	
			} else {
				$class = "";
			}
			$related .= "<li ".$class." ><a href=\"".$row_getSiblings['static_folder'].$row_getSiblings['static_file']."\">".$row_getSiblings['title']."</a></li>";	
		}
	} while ($row_getSiblings = mysql_fetch_assoc($getSiblings));	
	$related .= "</ul>";
	echo $related;	
	}
	
}

//CMS Breadcrumbs Feature
function cmsBreadcrumbs() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $row_getPage;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT *, b.parent_id FROM cms_page_versions a INNER JOIN cms_pages b ON a.page_id = b.page_id WHERE b.deleted = '0' AND a.deleted = '0' AND a.status = 'Published' AND a.page_id = '".$row_getPage['page_id']."' AND a.site_id = '".$row_getPage['site_id']."'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);	
	
	$breadcrumbs = "";
	$breadcrumbs .= cmsGetBreadcrumbs($row_getRecords['parent_id'])." ".$row_getPage['title'];
	$breadcrumbs =  "<div class=\"cms-breadcrumbs\"><a href=\"".$SITE['public_home']."\">Home</a> &gt; ".$breadcrumbs." ";
	$breadcrumbs .= "</div>";
	
	$breadcrumbs = str_replace("&gt; &gt;", "&gt;", $breadcrumbs);
	echo $breadcrumbs;
}

//Get Breadcrumbs
function cmsGetBreadcrumbs($parent_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $row_getPage;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT *, b.parent_id FROM cms_page_versions a INNER JOIN cms_pages b ON a.page_id = b.page_id WHERE b.deleted = '0' AND a.deleted = '0' AND a.status = 'Published' AND a.page_id = '".$parent_id."'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	$currentDate = time();
	$displayPage = "Yes";
		
	//Publish Date
	if ((empty($_GET['page'])) && (!empty($row_getRecords['publish_date']))) {
		$publishDate = strtotime($row_getRecords['publish_date']);	
		if ($currentDate < $publishDate) { $displayPage = "No"; }
	}
	
	//Auto Expire
	if ((empty($_GET['page'])) && (!empty($row_getRecords['expiration_date'])) && ($row_getRecords['auto_expire'] == "Yes")) {
		$expireDate = strtotime($row_getRecords['expiration_date']);	
		if ($currentDate > $expireDate) { $displayPage = "No"; }
	}
		
	//Display Results
	if (($displayPage == "Yes") && ($parent_id != "")) {
		if (!empty($row_getRecords['parent_id'])) {
		$breadcrumbsLink .= cmsGetBreadcrumbs($row_getRecords['parent_id']);
		}
		
		$breadcrumbs = $breadcrumbsLink." <a href=\"".$row_getRecords['static_folder'].$row_getRecords['static_file']."\">".$row_getRecords['title']."</a> &gt; ".$breadcrumbs;
	}
	
	return $breadcrumbs;
	
}

//CMS Search Feature
function cmsSearch() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	if (!empty($_GET['cmsSearch'])) {
		echo "<div class=\"cms-search-notice\">Search results for '<strong>".$_GET['cmsSearch']."</strong>'</div>\r\n";	
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getRecords = "SELECT * FROM cms_page_versions WHERE deleted = '0' AND status = 'Published' AND (content LIKE '%{$_GET['cmsSearch']}%' OR title LIKE '%{$_GET['cmsSearch']}%') AND site_id = '".$SITE['site_id']."' ORDER BY date_modified DESC";
		$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
		$row_getRecords = mysql_fetch_assoc($getRecords);
		$totalRows_getRecords = mysql_num_rows($getRecords);
		
		if ($totalRows_getRecords != "0") {
		echo "<div class=\"cms-search-results\">";
		
		do {
		$currentDate = time();
		$displayPage = "Yes";
		
		//Publish Date
		if ((empty($_GET['page'])) && (!empty($row_getRecords['publish_date']))) {
			$publishDate = strtotime($row_getRecords['publish_date']);	
			if ($currentDate < $publishDate) { $displayPage = "No"; }
		}
	
		//Auto Expire
		if ((empty($_GET['page'])) && (!empty($row_getRecords['expiration_date'])) && ($row_getRecords['auto_expire'] == "Yes")) {
			$expireDate = strtotime($row_getRecords['expiration_date']);	
			if ($currentDate > $expireDate) { $displayPage = "No"; }
		}
		
		//Display Results
		if ($displayPage == "Yes") {
			echo "<div class=\"search-item\">\r\n";
			echo "<div class=\"search-title\"><a href=\"".$row_getRecords['static_folder'].$row_getRecords['static_file']."\">".$row_getRecords['title']."</a></div>\r\n";
			echo "<div class=\"search-summary\">".first_sentence($row_getRecords['content'])."</div>\r\n";
			echo "<div class=\"search-link\"><a href=\"".$row_getRecords['static_folder'].$row_getRecords['static_file']."\">".$_SERVER['HTTP_HOST'].$row_getRecords['static_folder'].$row_getRecords['static_file']."</a></div>\r\n";
			echo "<div class=\"search-time\">Last Updated: ".timezoneProcess($row_getRecords['date_modified'], "return")."</div>\r\n";
			echo "</div>\r\n";	
		}
			
		echo "</div>";	
		} while ($row_getRecords = mysql_fetch_assoc($getRecords));	

		}
	}
}

//Auto Publish & Expiration
function cmsPublishCheckBlog($blog_version_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_blog_article_versions WHERE deleted = '0' AND status = 'Published' AND site_id = '".$SITE['site_id']."' AND article_version_id = '".$blog_version_id."'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);	
	
	$currentDate = time();
	$displayPage = "Yes";
		
	//Publish Date
	if ((empty($_GET['page'])) && (!empty($row_getRecords['publish_date']))) {
		$publishDate = strtotime($row_getRecords['publish_date']);	
		if ($currentDate < $publishDate) { $displayPage = "No"; }
	}
	
	//Auto Expire
	if ((empty($_GET['page'])) && (!empty($row_getRecords['expiration_date'])) && ($row_getRecords['auto_expire'] == "Yes")) {
		$expireDate = strtotime($row_getRecords['expiration_date']);	
		if ($currentDate > $expireDate) { $displayPage = "No"; }
	}
	
	return $displayPage;
			
}

//Auto Publish & Expiration
function cmsPublishCheck($page_version_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_page_versions WHERE deleted = '0' AND status = 'Published' AND site_id = '".$SITE['site_id']."' AND page_version_id = '".$page_version_id."'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);	
	
	$currentDate = time();
	$displayPage = "Yes";
		
	//Publish Date
	if ((empty($_GET['page'])) && (!empty($row_getRecords['publish_date']))) {
		$publishDate = strtotime($row_getRecords['publish_date']);	
		if ($currentDate < $publishDate) { $displayPage = "No"; }
	}
	
	//Auto Expire
	if ((empty($_GET['page'])) && (!empty($row_getRecords['expiration_date'])) && ($row_getRecords['auto_expire'] == "Yes")) {
		$expireDate = strtotime($row_getRecords['expiration_date']);	
		if ($currentDate > $expireDate) { $displayPage = "No"; }
	}
	
	return $displayPage;
			

}

//Include Remote PHP File
function cmsPHP($file_path) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $facebook;
	
	$include_file = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root'].$file_path;
	if (is_file($include_file)) {
		include($include_file);
	}
}

//Build Navigation Menu 
function navMenu() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $page_id;
		
	$filters = " AND a.site_id = '".$SITE['site_id']."'";
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT *, b.parent_id FROM cms_page_versions a INNER JOIN cms_pages b ON a.page_id = b.page_id WHERE (b.parent_id = '' OR b.parent_id IS NULL) AND b.deleted = '0' AND a.deleted = '0' AND a.status = 'Published' AND a.menu_display ='Yes' ".$filters." ORDER BY menu_display_order, title ASC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if ($totalRows_getRecords != "0") {
		$menu = "<nav class=\"main-nav\">\r\n<ul>\r\n";	
		$currentDate = time();
		//Start Loop (Check for Publish & Expiration)
		do {
			
			// Publish Date
			$displayPage = "Yes";
			$customClass = "";
			if ((empty($_GET['page'])) && (!empty($row_getRecords['publish_date']))) {
				$publishDate = strtotime($row_getRecords['publish_date']);	
				if ($currentDate < $publishDate) { $displayPage = "No"; }
			}
			
			//Auto Expire
			if ((empty($_GET['page'])) && (!empty($row_getRecords['expiration_date'])) && ($row_getRecords['auto_expire'] == "Yes")) {
				$expireDate = strtotime($row_getRecords['expiration_date']);	
				if ($currentDate > $expireDate) { $displayPage = "No"; }
			}
			
			//Display Menu Item
			if ($displayPage == "Yes") {
				if (!empty($row_getRecords['menu_custom_class'])) {$customClass = " class=\"".$row_getRecords['menu_custom_class']."\" "; }
				$menu .= "<li".$customClass."><a href=\"".$SITE['site_url'].$row_getRecords['static_folder'].$row_getRecords['static_file']."\">".$row_getRecords['title']."</a>";
				$menu .= navMenuChildren($row_getRecords['page_id']);
				$menu .= "</li>\r\n";
				
			}
			
		} while ($row_getRecords = mysql_fetch_assoc($getRecords));	
		
		$menu .="</ul>\r\n</nav>";
	}
	echo $menu;
}

//First Sentence
function first_sentence($content) {

    $content = (strip_tags($content));
    $pos = strpos($content, '.');
	$pos2 = strpos($content, '!');	 
	
	if (($pos < $pos2) || ($pos2 == "")) {
		$pos = $pos;
		} else {
		$pos = $pos2;
		}
	 
    if($pos == "") {
        return $content;
    }
    else {
        return substr($content, 0, $pos+1);
    }
   
}

//Nav Menu Children
function navMenuChildren($parent_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $page_id;
	
	$filters = " AND a.site_id = '".$SITE['site_id']."'";
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT *, b.parent_id FROM cms_page_versions a INNER JOIN cms_pages b ON a.page_id = b.page_id WHERE (b.parent_id = '".$parent_id."') AND b.deleted = '0' AND a.deleted = '0' AND a.status = 'Published' AND a.menu_display ='Yes' ".$filters." ORDER BY menu_display_order, title ASC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
if ($totalRows_getRecords != "0") {
		$menu = "\r\n<ul>\r\n";	
		$currentDate = time();
		//Start Loop (Check for Publish & Expiration)
		do {
			
			// Publish Date
			$displayPage = "Yes";
			$customClass = "";
			if ((empty($_GET['page'])) && (!empty($row_getRecords['publish_date']))) {
				$publishDate = strtotime($row_getRecords['publish_date']);	
				if ($currentDate < $publishDate) { $displayPage = "No"; }
			}
			
			//Auto Expire
			if ((empty($_GET['page'])) && (!empty($row_getRecords['expiration_date'])) && ($row_getRecords['auto_expire'] == "Yes")) {
				$expireDate = strtotime($row_getRecords['expiration_date']);	
				if ($currentDate > $expireDate) { $displayPage = "No"; }
			}
			
			//Display Menu Item
			if ($displayPage == "Yes") {
				if (!empty($row_getRecords['menu_custom_class'])) {$customClass = " class=\"".$row_getRecords['menu_custom_class']."\" "; }
				$menu .= "<li".$customClass."><a href=\"".$row_getRecords['static_folder'].$row_getRecords['static_file']."\">".$row_getRecords['title']."</a>";
				$menu .= navMenuChildren($row_getRecords['page_id']);
				$menu .= "</li>\r\n";
			}
			
		} while ($row_getRecords = mysql_fetch_assoc($getRecords));	
		
		$menu .="</ul>\r\n";
	}
	return $menu;	

}


//Process Content
function contentProcessor($content, $type, $id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER, $facebook;
	
	$content  = explode("[IKIOSK]", $content);
	
	$inlineEdit = cmsInlineCheck();
	/* if ($inlineEdit == "Yes" && $type == "page_content") {
		echo "<div class=\"cms-inline-link cms-edit\"><a href=\"#\" class=\"cms-editor\" rel=\"".$id."\">Edit Content</a></div>";
		echo "<div class=\"cms-inline-edit cms-edit ".$id."\"></div>";
		echo "<div id=\"".$id."\" class=\" cms-inline-container\">";
	} */
	
	//Loop Through Content
	foreach ($content as $key => $value) {
	
		//Look for System Tags
		$startTag = substr($value, 0, 8);
		$endTag = substr($value, -8);
		
		if ($startTag == "[sysTag]" && $endTag == "[sysTag]") {
			// Strip Out System Tags
			$systemTag = str_replace("[sysTag]", "", $value);	
			$systemTag = explode("|", $systemTag);	
			
			
			//Begin Processing Dynamic Code Based on Tag Prefix
			if ($systemTag[0] == "CMS"){sysTagCMS($systemTag);}
			
		} else {
			
			$content = cleanHTML(stripslashes($value));
			$content = templateHelper($content);
			$content = absolute_url($content, $SITE['site_url']);
			
			/* Parse absolute links 
			if ($SYSTEM['ikiosk_id'] == "ikiosk-cms-shared") {
				$content = preg_replace("#(<\s*a\s+[^>]*href\s*=\s*[\"'])(?!http)([^\"'>]+)([\"'>]+)#", '$1'.$SITE['site_url'].'$2$3', $content);
				$content = preg_replace("#(<\s*img\s+[^>]*src\s*=\s*[\"'])(?!http)([^\"'>]+)([\"'>]+)#", '$1'.$SITE['site_url'].'$2$3', $content);
				$content = preg_replace("#(<\s*link\s+[^>]*href\s*=\s*[\"'])(?!http)([^\"'>]+)([\"'>]+)#", '$1'.$SITE['site_url'].'$2$3', $content);
				$content = preg_replace("#(<\s*script\s+[^>]*src\s*=\s*[\"'])(?!http)([^\"'>]+)([\"'>]+)#", '$1'.$SITE['site_url'].'$2$3', $content);
			}*/
			echo $content;		
		}
				
	}
	/*
	if ($inlineEdit == "Yes" && $type == "page_content") {echo "</div>";}
	*/
	
}

//Can User Access
function cmsInlineCheck() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$allowEdit = "No";
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM  sys_users2sites WHERE user_id = '".$_SESSION['user_id']."' AND site_id = '".$_SESSION['site_id']."' AND deleted = '0'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if ($totalRows_getRecords != "0") {
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getApp = "SELECT * FROM  sys_permissions WHERE user_id = '".$_SESSION['user_id']."' AND CMS >= 112 AND deleted = '0'";
		$getApp = mysql_query($query_getApp, $ikiosk) or sqlError(mysql_error());
		$row_getApp = mysql_fetch_assoc($getApp);
		$totalRows_getApp = mysql_num_rows($getApp);
		
		if ($totalRows_getApp != "0") {
		$allowEdit = "Yes";	
		}
	}
	
	return $allowEdit;
	
}

//Calendar Day Display
function cmsCalendarDay($timeCode, $calendar_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$dayDisplay = "";
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_calendar_events WHERE calendar_id = '".$calendar_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY start_datetime ASC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);	
	
	//Find All Events for This Date
	if ($totalRows_getRecords != 0) {
		$i = 1;
		$total = 0;
		$dayOverlay = "<div class=\"dayOverlay\" id=\"".$timeCode."-ext\" />";
		$dayOverlay .="<div class=\"dayOverlayTitle\">";
		$dayOverlay .=  date("M d, Y", $timeCode);
		$dayOverlay .="</div>";
		
		do {
		$eventStartDate = timezoneProcess($row_getRecords['start_datetime'], "return");
		$eventStartDate = strtotime($eventStartDate);
		$eventStartDate = date("Y-m-d", $eventStartDate);
		$eventStartDate = strtotime($eventStartDate);
		
		$eventEndDate = timezoneProcess($row_getRecords['end_datetime'], "return");
		$eventEndDate = strtotime($eventEndDate);
		
		
		//Show Event Information
		if (($eventStartDate == $timeCode) || (($eventStartDate <= $timeCode) && ($eventEndDate >= $timeCode)))  { 
			$category = smartCMSQuery("SELECT * FROM cms_categories WHERE category_id = '".$row_getRecords['category_id']."' ");
			
			if ($i <= 3) {
			$dayDisplay .="<div class=\"dayEntry\" style=\"border: 1px solid #".$category['border_color']."; background-color: #".$category['display_color']."; \">";

				//Time Block
				if ($eventStartDate == $timeCode) {
					$eventTime = timezoneProcess($row_getRecords['start_datetime'], "return");
					$eventTime = strtotime($eventTime);
					$eventTime = date("g:ia", $eventTime);	
					$dayDisplay .= "<strong>".$eventTime."</strong> ";
				} else {
				}
			$i++;
			$dayDisplay .= "<a href=\"editEvent.php?recordID=".$row_getRecords['event_id']."\">".$row_getRecords['title']."</a>";	
			$dayDisplay .= "</div>";
			}

			$total++;
			
			// Day Overlay
			$dayOverlay .="<div class=\"dayEntry\" style=\"border: 1px solid #".$category['border_color']."; background-color: #".$category['display_color']."; \">";
			//Time Block
				if ($eventStartDate == $timeCode) {
					$eventTime = timezoneProcess($row_getRecords['start_datetime'], "return");
					$eventTime = strtotime($eventTime);
					$eventTime = date("g:ia", $eventTime);	
					$dayOverlay .= "<strong>".$eventTime."</strong> ";
				} else {
				}
			$dayOverlay .= "<a href=\"editEvent.php?recordID=".$row_getRecords['event_id']."\">".$row_getRecords['title']."</a>";	
			$dayOverlay .="</div>";
		}	
		} while ($row_getRecords = mysql_fetch_assoc($getRecords)); 
			$dayOverlay .= "</div>";

		//Overflow
		if ($total > 3) {
			$balance = $total - 3;	
			$dayDisplay .="<div class=\"dayEntry\" style=\"background-color: #F2F2F2; \">";
			$dayDisplay .="<a id=".$timeCode." class=\"dayDetail overlayTrigger\">+".$balance." more</a>";
			$dayDisplay .= "</div>";
			$dayDisplay .= $dayOverlay;
		}
	}
	return $dayDisplay;
}

//Quick Queries
function smartCMSQuery($query) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = $query." AND deleted = '0' AND ".$SYSTEM['active_site_filter'];
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$queryResult = mysql_fetch_assoc($getRecords);
	$queryResult['count'] = mysql_num_rows($getRecords);	
	
	return $queryResult;
}

//Display Location List
function calCategoryList($select_name, $selected) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_categories WHERE category_type = 'calendar' AND deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY title ASC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);	
	
			
		$dropdownList = "<select name=\"".$select_name."\">\r\n";
		$dropdownList .= "<option value=\"\"></option>\r\n";

		if 	($totalRows_getRecords != "0") { 
		do {
			$dropdownList .= "<option value=\"".$row_getRecords['category_id']."\" ";
			if ($row_getRecords['category_id'] == $selected) {$dropdownList .= " selected ";}
			$dropdownList .=" >".$row_getRecords['title']."</option>\r\n";
		} while ($row_getRecords = mysql_fetch_assoc($getRecords));	
		}
		
		$dropdownList .= "</select>\r\n";
		echo $dropdownList;			
		
}



//Display Location List
function locationList($select_name, $selected) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_calendar_locations WHERE deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY title ASC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);	
	

			
		$dropdownList = "<select name=\"".$select_name."\">\r\n";
		$dropdownList .= "<option value=\"\"></option>\r\n";

		if 	($totalRows_getRecords != "0") { 
		do {
			$dropdownList .= "<option value=\"".$row_getRecords['location_id']."\" ";
			if ($row_getRecords['location_id'] == $selected) {$dropdownList .= " selected ";}
			$dropdownList .=" >".$row_getRecords['title']."</option>\r\n";
		} while ($row_getRecords = mysql_fetch_assoc($getRecords));	
		}
		
		$dropdownList .= "</select>\r\n";
		echo $dropdownList;			
		
}

//Display Calendar List
function calendarList($select_name, $selected) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_calendars WHERE deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY title ASC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);	
	

	if 	($totalRows_getRecords != "0") { 
			
		$dropdownList = "<select name=\"".$select_name."\">\r\n";
	
		do {
			$dropdownList .= "<option value=\"".$row_getRecords['calendar_id']."\" ";
			if ($row_getRecords['calendar_id'] == $selected) {$dropdownList .= " selected ";}
			$dropdownList .=" >".$row_getRecords['title']."</option>\r\n";
		} while ($row_getRecords = mysql_fetch_assoc($getRecords));	
		
		
		$dropdownList .= "</select>\r\n";
		echo $dropdownList;			
	}	
	
}

//Publish Blog Permalink
function publishBlog($article_version_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_blog_article_versions WHERE deleted = '0' AND ".$SYSTEM['active_site_filter']." AND article_version_id = '".$article_version_id."' ORDER BY title ASC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	
	if ($totalRows_getRecords != 0) {
		
		//Get Site Properties
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getSiteInfo = "SELECT * FROM sys_sites WHERE site_id = '".$row_getRecords['site_id']."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']."";
		$getSiteInfo = mysql_query($query_getSiteInfo, $ikiosk) or sqlError(mysql_error());
		$row_getSiteInfo = mysql_fetch_assoc($getSiteInfo);
		$totalRows_getSiteInfo = mysql_num_rows($getSiteInfo);
		
		$physicalDir = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSiteInfo['site_root'].$row_getRecords['permalink_folder'];
		$physicalFile = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSiteInfo['site_root'].$row_getRecords['permalink_folder'].$row_getRecords['permalink_filename'];
		$pageContent = urlFetch($SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root']."/webapps/cms/blog_template.php");
		
		
		//Page Specific Replace
		$ikioskCore = $SYSTEM['ikiosk_docroot']."/includes/core/ikiosk.php";
		$page_id = $row_getRecords['article_id'];
		$page_compile = $SYSTEM['ikiosk_docroot']."/webapps/cms/blog_base.php";
		
		$pageContent = str_replace("ikiosk-tmp-core", $ikioskCore, $pageContent);
		$pageContent = str_replace("ikiosk-tmp-page", $page_id, $pageContent);
		$pageContent = str_replace("ikiosk-tmp-compiler", $page_compile, $pageContent);
		$pageContent = str_replace("ikiosk_tmp_site", $row_getSiteInfo['site_id'], $pageContent);
		
		//Create Directory
		mkdir($physicalDir, 0777, true);
		
		//Write File
		$fh = fopen($physicalFile, 'w+');
		fwrite($fh, $pageContent);
		fclose($fh);

	}

}

//Get Category
function getCategory($category_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_categories WHERE category_id = '".$category_id."' AND ".$SYSTEM['active_site_filter']."";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$category = mysql_fetch_assoc($getRecords);
	$category['count'] = mysql_num_rows($getRecords);
	
	return $category;
	
}

//Check Category Assignment for Articles
function checkCategoryAssignment($category_id, $article_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_blog_links WHERE category_id = '".$category_id."' AND article_id = '".$article_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']."";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if ($totalRows_getRecords == 0) {
		$assigned = "No";	
	} else {
		$assigned = "Yes";	
	}
	
	return $assigned;	
}

//CMS Categories
function selectCMSCategory($type, $select_name, $selected) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_categories WHERE deleted = '0' AND ".$SYSTEM['active_site_filter']." AND category_type = '".$type."' ORDER BY title ASC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if 	($totalRows_getRecords != "0") { 
			
		$dropdownList = "<select name=\"".$select_name."\">\r\n";
	
		do {
			$dropdownList .= "<option value=\"".$row_getRecords['category_id']."\" ";
			if ($row_getRecords['category_id'] == $selected) {$templateList .= " selected ";}
			$dropdownList .=" >".$row_getRecords['title']."</option>\r\n";
		} while ($row_getRecords = mysql_fetch_assoc($getRecords));	
		
		
		$dropdownList .= "</select>\r\n";
		echo $dropdownList;			
	}
	
}

//Get Blog Article
function getBlogArticle($article_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_blog_articles WHERE article_id = '".$article_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY date_modified DESC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if 	($totalRows_getRecords != "0") { 
		
		$page = array();
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getPages = "SELECT * FROM cms_blog_article_versions WHERE article_id = '".$article_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY date_created DESC";
		$getPages = mysql_query($query_getPages, $ikiosk) or sqlError(mysql_error());
		$page = mysql_fetch_assoc($getPages);
		$page['count'] = mysql_num_rows($getPages);
		
	}
	
	return $page;
}

//Check Page Assignment for Elements
function checkPageAssignment($page_element_id, $page_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_elements2pages WHERE page_element_id = '".$page_element_id."' AND page_id = '".$page_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']."";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if ($totalRows_getRecords == 0) {
		$assigned = "No";	
	} else {
		$assigned = "Yes";	
	}
	
	return $assigned;	
}

//Selecte Template Section
function selectTemplateSection($select_name, $selected) {
		global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getRecords = "SELECT * FROM cms_template_sections WHERE deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY date_modified DESC";
		$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
		$row_getRecords = mysql_fetch_assoc($getRecords);
		$totalRows_getRecords = mysql_num_rows($getRecords);
	
		if 	($totalRows_getRecords != "0") { 
			
			$templateList = "<select name=\"".$select_name."\">\r\n";
			$templateList .= "<option value=\"\"></option>\r\n";
			
			do {
				$templateList .= "<option value=\"".$row_getRecords['template_section_id']."\" ";
				if ($row_getRecords['template_section_id'] == $selected) {$templateList .= " selected ";}
				$templateList .=" >".$row_getRecords['title']."</option>\r\n";
			} while ($row_getRecords = mysql_fetch_assoc($getRecords));	
			
			$templateList .="</select>";
			echo $templateList;
		}
}


//Template Section
function getTemplateSection($template_section_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$template = array();
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getPages = "SELECT * FROM cms_template_sections WHERE template_section_id = '".$template_section_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']."";
	$getPages = mysql_query($query_getPages, $ikiosk) or sqlError(mysql_error());
	$template = mysql_fetch_assoc($getPages);
	$template['count'] = mysql_num_rows($getPages);
	
	return $template;
	
}

//Template
function getTemplate($template_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$template = array();
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getPages = "SELECT * FROM cms_template_versions WHERE template_id = '".$template_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY date_created DESC";
	$getPages = mysql_query($query_getPages, $ikiosk) or sqlError(mysql_error());
	$template = mysql_fetch_assoc($getPages);
	$template['count'] = mysql_num_rows($getPages);
	
	return $template;
}

//Page Publish Routine
function publishPage($page_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	//Get Page Index
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getPageIndex = "SELECT * FROM cms_pages WHERE page_id = '".$page_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY date_modified DESC";
	$getPageIndex = mysql_query($query_getPageIndex, $ikiosk) or sqlError(mysql_error());
	$row_getPageIndex = mysql_fetch_assoc($getPageIndex);
	$totalRows_getPageIndex = mysql_num_rows($getPageIndex);
	
	//Get Page Detail
	$page = getContentPage($row_getPageIndex['page_id']);
	
	//Get Site Properties
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getSiteInfo = "SELECT * FROM sys_sites WHERE site_id = '".$row_getPageIndex['site_id']."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']."";
	$getSiteInfo = mysql_query($query_getSiteInfo, $ikiosk) or sqlError(mysql_error());
	$row_getSiteInfo = mysql_fetch_assoc($getSiteInfo);
	$totalRows_getSiteInfo = mysql_num_rows($getSiteInfo);
	
	$physicalFile = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSiteInfo['site_root'].$page['static_folder'].$page['static_file'];
	$pageContent = urlFetch($SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root']."/webapps/cms/page_template.php");
	
	//Page Specific Replace
	$ikioskCore = $SYSTEM['ikiosk_docroot']."/includes/core/ikiosk.php";
	$page_id = $page['page_id'];
	$page_compile = $SYSTEM['ikiosk_docroot']."/webapps/cms/page_base.php";
	
	$pageContent = str_replace("ikiosk-tmp-core", $ikioskCore, $pageContent);
	$pageContent = str_replace("ikiosk-tmp-page", $page_id, $pageContent);
	$pageContent = str_replace("ikiosk-tmp-compiler", $page_compile, $pageContent);

	
	if ($page['static_file'] != "") {
		//Write File
		$fh = fopen($physicalFile, 'w+');
		fwrite($fh, $pageContent);
		fclose($fh);
	}
}


//Get Template
function templateList($select_name, $selected) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;

	$templateList = "<select name=\"".$select_name."\">\r\n";
	$templateList .= "<option value=\"\"></option>\r\n";
	
	//Get Page Index
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getTemplate = "SELECT * FROM cms_templates WHERE site_id = '".$SITE['site_id']."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY date_modified DESC";
	$getTemplate = mysql_query($query_getTemplate, $ikiosk) or sqlError(mysql_error());
	$row_getTemplate = mysql_fetch_assoc($getTemplate);
	$totalRows_getTemplate = mysql_num_rows($getTemplate);
	
	do {
		$template = getTemplate($row_getTemplate['template_id']);
		$templateList .= "<option value=\"".$row_getTemplate['template_id']."\" ";
		if ($row_getTemplate['template_id'] == $selected) {$templateList .= " selected ";}
		$templateList .=" >".$template['title']."</option>\r\n";
	} while ($row_getTemplate = mysql_fetch_assoc($getTemplate));	
	
	$templateList .= "</select>";
	
	echo $templateList;

}

//Get Template
function templateListiCloud($select_name, $selected) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;

	$templateList = "<select name=\"".$select_name."\">\r\n";
	$templateList .= "<option value=\"\"></option>\r\n";
	
	//Get Page Index
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getTemplate = "SELECT * FROM ikioskcloud_templates WHERE deleted = '0' ORDER BY date_modified DESC";
	$getTemplate = mysql_query($query_getTemplate, $ikiosk) or sqlError(mysql_error());
	$row_getTemplate = mysql_fetch_assoc($getTemplate);
	$totalRows_getTemplate = mysql_num_rows($getTemplate);
	
	do {
		$templateList .= "<option value=\"".$row_getTemplate['template_id']."\" ";
		if ($row_getTemplate['template_id'] == $selected) {$templateList .= " selected ";}
		$templateList .=" >".$row_getTemplate['template_title']."</option>\r\n";
	} while ($row_getTemplate = mysql_fetch_assoc($getTemplate));	
	
	$templateList .= "</select>";
	
	echo $templateList;

}

//Display Directory Browser
function displayDirBrowser($select_name, $selected) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	compileDirList();
	$dirFile = $SYSTEM['ikiosk_docroot']."/webapps/cms/dir_browser/".$SITE['site_id'].".txt";
	$dirList = urlFetch($dirFile);
	$dirList = explode("[iKiosk]", $dirList);
	
	$dirOutput = "<select name=\"".$select_name."\">\r\n";
	foreach ($dirList as $key => $value) {
		$keypair = explode("|", $value);
		if (($keypair[0] != "/api/") && ($keypair[0] != "/blog/") && ($keypair[0] != "/calendar/") && ($keypair[0] != "/store/") && ($keypair[0] != "/socialnet/") && ($keypair[0] != "/static/") && ($keypair[0] != "/static/resources/") && ($keypair[0] != "/static/resources/userphotos/") && ($keypair[0] != "/static/resources/userfiles/") && ($keypair[0] != "/library/") && ($keypair[0] != "/ishare/") && ($keypair[0] != "/system/")) {
 		$dirOutput .=  "<option value=\"".$keypair[0]."\" ";
		if ($keypair[0] == $selected) {$dirOutput .= " selected=\"selected\" ";}
		$dirOutput .=  ">".$keypair[1]."</option>\r\n";
		}
	}
	
	$dirOutput .="</select>";
	echo $dirOutput;
}

//Clean up HTML
function cleanHTML($html) {
	$html = preg_replace("#<(/)?(font|del|ins)[^>]*>#","",$html);
	$html = preg_replace("#<([^>]*)(lang|size|face)=(\"[^\"]*\"|'[^']*'|[^>]+)([^>]*)>#","<\\1>",$html);
	$html = preg_replace("#<([^>]*)(lang|size|face)=(\"[^\"]*\"|'[^']*'|[^>]+)([^>]*)>#","<\\1>",$html);
	return $html;
}

//Recurse Get Child Pages
function selectChildPage($page_id, $selected, $level, $ignore) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;

	$subSections = "";

	//Add Spacing for Display
	$tiers = $level;
	$tierSpace = " ";
	do {
	$tierSpace .= "--";
		$tiers = $tiers - 1;
	} while ($tiers > 0);
	$tierSpace .= " ";
	$level++;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_pages WHERE parent_id = '".$page_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']."ORDER BY date_modified DESC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if 	($totalRows_getRecords != "0") { 
		do {
		if  ($row_getRecords['page_id'] != $ignore) {

		    $page = getContentPage($row_getRecords['page_id']);	
			$subSections .=  "<option value=\"".$row_getRecords['page_id']."\" ";
			if ($row_getRecords['page_id'] == $selected) {$subSections .= " selected ";}
			$subSections .=  ">".$tierSpace.$page['title']." </option>\r\n";
			$subSections .= selectChildPage($row_getRecords['page_id'], $selected, $level, $ignore);
		}
		} while ($row_getRecords = mysql_fetch_assoc($getRecords));		
	}
	
	return $subSections;
}


//Parent Pages Dropdown
function selectParentPage($page_id, $select_name, $selected) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_pages WHERE parent_id IS NULL AND deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY date_modified DESC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if 	($totalRows_getRecords != "0") { 
	
	$selectParent = "<select name=\"".$select_name."\">\r\n";
	$selectParent .= "<option value=\"\"></option>\r\n";
	
	do {

		if  ($row_getRecords['page_id'] != $page_id) {
			
		    $page = getContentPage($row_getRecords['page_id']);	
			$selectParent .=  "<option value=\"".$row_getRecords['page_id']."\" ";
			if ($row_getRecords['page_id'] == $selected) {$selectParent .= " selected=\"selected\" ";}
			$selectParent .=  ">".$page['title']."</option>\r\n";
			$selectParent .= selectChildPage($row_getRecords['page_id'], $selected, 1, $page_id);
		}
	
	} while ($row_getRecords = mysql_fetch_assoc($getRecords));	}	
	
	$selectParent .= "</select>";
	echo $selectParent;
}

// Get Template By Version 
function getTemplateVersion($template_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_templates WHERE template_id = '".$template_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY date_modified DESC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if 	($totalRows_getRecords != "0") { 
		
		$page = array();
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getPages = "SELECT * FROM cms_template_versions WHERE template_id = '".$template_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY date_created DESC";
		$getPages = mysql_query($query_getPages, $ikiosk) or sqlError(mysql_error());
		$page = mysql_fetch_assoc($getPages);
		$page['count'] = mysql_num_rows($getPages);
		
	}
	
	return $page;
}

// Get Content Page by Version
function getContentPage($page_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_pages WHERE page_id = '".$page_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY date_modified DESC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if 	($totalRows_getRecords != "0") { 
		
		$page = array();
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getPages = "SELECT * FROM cms_page_versions WHERE page_id = '".$page_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY date_created DESC";
		$getPages = mysql_query($query_getPages, $ikiosk) or sqlError(mysql_error());
		$page = mysql_fetch_assoc($getPages);
		$page['count'] = mysql_num_rows($getPages);
		
	}
	
	return $page;
}

//Create Site Config File
function createSiteConfig() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_config WHERE site_id = '".$_SESSION['site_id']."' AND deleted = '0' AND ".$SYSTEM['active_site_filter'];
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if 	($totalRows_getRecords == "0") { 
	
	$generateID = create_guid();

	$insertSQL = sprintf("INSERT INTO cms_config (config_id, site_id, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s)",
			GetSQLValueString($generateID, "text"),
			GetSQLValueString($_SESSION['site_id'], "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"));
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($insertSQL);
	}
	
}

//Get Twitter Feed
function getTwitterFeed($feed_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$timestamp = time();
	$date_time_array = getdate($timestamp);
	
	$hours = $date_time_array['hours'];
	$minutes = $date_time_array['minutes'];
	$seconds = $date_time_array['seconds'];
	$month = $date_time_array['mon'];
	$day = $date_time_array['mday'];
	$year = $date_time_array['year'];
	
	// use mktime to recreate the unix timestamp
	// adding 19 hours to $hours
	$timestamp = mktime($hours + 0,$minutes,$seconds,$month,$day,$year);
	$theDate = strftime('%Y-%m-%d %H:%M:%S',$timestamp);
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_twitter_feeds WHERE feed_id = '".$feed_id."' AND deleted = '0' AND site_id = '".$SITE['site_id']."'";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if 	($totalRows_getRecords != "0") { 
		$tweets = array();
		
		// User Feed
		if ($row_getRecords['type'] == "User Feed") {
			$twitterAPI = "https://api.twitter.com/1/statuses/user_timeline.json?screen_name=".urlencode($row_getRecords['query'])."&exclude_replies=false&include_rts=true&count=".$row_getRecords['count'];
		}
		if ($row_getRecords['type'] == "Custom Search") {
			$twitterAPI = "http://search.twitter.com/search.json?q=".urlencode($row_getRecords['query'])."&result_type=recent&count=".$row_getRecords['count'];
		}
		$tweetObject = urlFetch($twitterAPI);
		$tweetFeed = json_decode($tweetObject, true);
		
		//User Feed
		if ($row_getRecords['type'] == "User Feed") {
			foreach ($tweetFeed as $key => $value) {
				$date =  strtotime($value['created_at']);
				$dayMonth = date('d M', $date);
				$year = date('y', $date);
				$datediff = date_diffTW($theDate, $date);
				
				$tweets[$key]['user_name'] = $value['user']['name'];
				$tweets[$key]['user_url'] = $value['user']['url'];
				$tweets[$key]['user_screen_name'] = $value['user']['screen_name'];
				$tweets[$key]['user_profile_image'] = $value['user']['profile_image_url'];	
				$tweets[$key]['created_at'] = $value['created_at'];
				$tweets[$key]['date_diff'] = $datediff;
				
				$tweetText = twitterify($value['text']);
				$tweets[$key]['text'] = $tweetText;
			}
		} // End User Feed
		
		//Custom Search
		if ($row_getRecords['type'] == "Custom Search") {
			foreach ($tweetFeed['results'] as $key => $value) {
				$date =  strtotime($value['created_at']);
				$dayMonth = date('d M', $date);
				$year = date('y', $date);
				$datediff = date_diffTW($theDate, $date);
				
				$tweets[$key]['user_name'] = $value['from_user'];
				$tweets[$key]['user_url'] = $value['user']['url'];
				$tweets[$key]['user_screen_name'] = $value['from_user_name'];
				$tweets[$key]['user_profile_image'] = $value['profile_image_url'];	
				$tweets[$key]['created_at'] = $value['created_at'];
				$tweets[$key]['date_diff'] = $datediff;
				
				$tweetText = twitterify($value['text']);
				$tweets[$key]['text'] = $tweetText;
			}
		} // End Custom Search
	}
	return $tweets;	
}



//Format Tweets
function twitterify($ret) {
  $ret = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $ret);
  $ret = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $ret);
  $ret = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $ret);
  $ret = preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $ret);
return $ret;
}

//Recursive Remove Videos and Photos from Albums
function removeMultimedia($type, $album_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	if ($type == "photos") {
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getRecords = "SELECT * FROM sys_photos WHERE album_id = '".$album_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter'];
		$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
		$row_getRecords = mysql_fetch_assoc($getRecords);
		$totalRows_getRecords = mysql_num_rows($getRecords);
		if 	($totalRows_getRecords != "0") { do {	
			$delete = deleteRecord("cms_gallery_category_media", "media_id", $row_getRecords['photo_id']);
		} while ($row_getRecords = mysql_fetch_assoc($getRecords));	}
	}
	
	if ($type == "videos") {
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getRecords = "SELECT * FROM cms_videos WHERE album_id = '".$album_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter'];
		$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
		$row_getRecords = mysql_fetch_assoc($getRecords);
		$totalRows_getRecords = mysql_num_rows($getRecords);
		if 	($totalRows_getRecords != "0") { do {	
			$delete = deleteRecord("cms_gallery_category_media", "media_id", $row_getRecords['video_id']);
		} while ($row_getRecords = mysql_fetch_assoc($getRecords));	}
	}
		
}

function getGalleryData($gallery_id) {
	
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_galleries WHERE gallery_id = '".$gallery_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter'];
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if 	($totalRows_getRecords != "0") {
		$galleryData = array();
		$galleryData['title'] = $row_getRecords['title'];
		$galleryData['description'] = $row_getRecords['description'];
		$categories = getTheaterCategories($row_getRecords['gallery_id']);
		$galleryData['category_count'] = count($categories);
		
		$videoCount = 0;
		$photoCount = 0;
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getMedia = "SELECT * FROM cms_gallery_category_media WHERE gallery_id = '".$gallery_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY date_created DESC";
		$getMedia = mysql_query($query_getMedia, $ikiosk) or sqlError(mysql_error());
		$row_getMedia = mysql_fetch_assoc($getMedia);
		$totalRows_getMedia = mysql_num_rows($getMedia);
		
		$thumbnail = getMedia($row_getMedia['media_id'], $row_getMedia['media_type']);
		if 	($totalRows_getRecords != "0") {
			do {
				if ($row_getMedia['media_type'] == "photo") {
					$photoCount++;
					$galleryData['thumb'] = $SYSTEM['html_root']."/sites".$SITE['site_root'].$thumbnail['image_thumbnail'];
				} 
				
				if ($row_getMedia['media_type'] == "video") {
					$videoCount++;	
					$galleryData['thumb'] = $thumbnail['media_thumb'];
	
				}
			} while ($row_getMedia = mysql_fetch_assoc($getMedia));	
		}
		
		$galleryData['video_count'] = $videoCount;
		$galleryData['photo_count'] = $photoCount;
		if ($galleryData['thumb'] == "") {$galleryData['thumb'] = $SYSTEM['html_root'].$SYSTEM['ikiosk_root']."/library/images/defaults/empty_video.jpg";}

	}
	
	return $galleryData;
}

//Get Category Details
function getCategoryItems($gallery_id, $category_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_gallery_category_media WHERE category_id = '".$category_id."' AND gallery_id = '".$gallery_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY date_created DESC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);	
	
	if 	($totalRows_getRecords != "0") {
		$categories = array();
		$i = 0;
		do {
			$categories[$i]['media_link'] = $row_getRecords['link_id'];
			$categories[$i]['media_id'] = $row_getRecords['media_id'];
			$categories[$i]['media_type'] = $row_getRecords['media_type'];
		$i++;	
		} while ($row_getRecords = mysql_fetch_assoc($getRecords));	
	}
	
	return $categories;
}

// Returns a list of Valid Categories for a Gallery
function getTheaterCategories($gallery_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	$categories = array();
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_gallery_categories WHERE gallery_id = '".$gallery_id."' AND status = 'Active' AND deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER BY title ASC";
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if 	($totalRows_getRecords != "0") {
		$categories = array();
		$i = 0;
		do {
			$count = getCategoryCount($row_getRecords['category_id']);
			if ($count > 0) {
				$categories[$i]['category_id'] = $row_getRecords['category_id'];
				$categories[$i]['title'] = $row_getRecords['title'];
				$categories[$i]['description'] = $row_getRecords['description'];
				$categories[$i]['items'] = getCategoryCount($row_getRecords['category_id']);
				$i++;
			}
		 } while ($row_getRecords = mysql_fetch_assoc($getRecords));	
	}
	
	return $categories;
}

// Get Multimedia Information
function getMedia($media_id, $media_type) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$mediaData = array();
	
	if ($media_type == "photo") {
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getRecords = "SELECT * FROM sys_photos WHERE photo_id = '".$media_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter'];
		$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
		$row_getRecords = mysql_fetch_assoc($getRecords);
		$totalRows_getRecords = mysql_num_rows($getRecords);	
		
		$mediaData = $row_getRecords;
	}
	
	if ($media_type == "video") {
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getRecords = "SELECT * FROM cms_videos WHERE video_id = '".$media_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter'];
		$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
		$row_getRecords = mysql_fetch_assoc($getRecords);
		$totalRows_getRecords = mysql_num_rows($getRecords);	
		$mediaData = $row_getRecords;
	}
	
	return $mediaData;
}

//Get Category Details
function getCategoryCount($category_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_gallery_category_media WHERE category_id = '".$category_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter'];
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);	
	
	return $totalRows_getRecords;
}

function  checkCategoryLink($category_id, $media_id) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_gallery_category_media WHERE category_id = '".$category_id."' AND media_id = '".$media_id."' AND deleted = '0' AND ".$SYSTEM['active_site_filter'];
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	if ($totalRows_getRecords == "0") {
		return "No";	
	} else {
		return "Yes";	
	}
	
}

//Search YouTube Video Feed
function getVideoFeedYT($query, $username, $order) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;

	$videoAPI = "https://gdata.youtube.com/feeds/api/videos?v=2&alt=json&max-results=30";
	if (!empty($query)) { $videoAPI .= "&q=".urlencode($query); }
	if (!empty($username)) { $videoAPI .= "&author=".urlencode($username); }
	if (!empty($order)) { $videoAPI .= "&orderby=".urlencode($order); }	
	
	$videoObject = urlFetch($videoAPI);
	$videoObject = json_decode($videoObject, true);
	
	if (!empty($videoObject['feed']['entry'])) {
	$videoData = array();	
		foreach ($videoObject['feed']['entry'] as $key => $value) {
			$videoData[$key]['video_id'] = $value['media$group']['yt$videoid']['$t'];
			$videoData[$key]['title'] = $value['title']['$t'];
			$videoData[$key]['url'] = str_replace("?f=videos&app=youtube_gdata", "", $value['content']['src']);
			$videoData[$key]['thumb'] = "http://img.youtube.com/vi/".$videoData[$key]['video_id']."/2.jpg";
			$videoData[$key]['description'] =  $value['media$group']['media$description']['$t'];
			$videoData[$key]['duration'] =  $value['media$group']['yt$duration']['seconds'];
			$videoData[$key]['rating'] =  $value['gd$rating']['average'];
			$videoData[$key]['favorite_count'] =  $value['yt$statistics']['favoriteCount'];
			$videoData[$key]['view_count'] = $value['yt$statistics']['viewCount'];
		}
	}
	return $videoData;
}

//Returns Video Data
function getVimeoVid($videoID) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$videoData = array();
	$videoAPI = "http://vimeo.com/api/v2/video/".$videoID.".php";
	$videoObject = urlFetch($videoAPI);
	$videoObject = unserialize($videoObject);
	
	$videoData['video_id'] = $videoID;
	$videoData['title'] = $videoObject[0]['title'];
	$videoData['url'] = $videoObject[0]['url'];
	$videoData['thumb'] = $videoObject[0]['thumbnail_small'];
	$videoData['description'] =  $videoObject[0]['description'];
	return $videoData;
}

//Returns YouTube Data
function getYoutubeVid($videoID) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	$videoData = array();
	$videoAPI = "https://gdata.youtube.com/feeds/api/videos/".$videoID."?v=2&alt=json";
	
	$videoObject = urlFetch($videoAPI);
	$videoObject = json_decode($videoObject, true);

	$videoData['video_id'] = $videoID;
	$videoData['title'] = $videoObject['entry']['title']['$t'];
	$videoData['url'] = str_replace("?f=videos&app=youtube_gdata", "", $videoObject['entry']['content']['src']);
	$videoData['thumb'] = "http://img.youtube.com/vi/".$videoID."/2.jpg";
	$videoData['description'] =  $videoObject['entry']['media$group']['media$description']['$t'];
	$videoData['duration'] =  $videoObject['entry']['media$group']['yt$duration']['seconds'];
	$videoData['rating'] =   $videoObject['entry']['gd$rating']['average'];
	$videoData['favorite_count'] =   $videoObject['entry']['yt$statistics']['favoriteCount'];
	$videoData['view_count'] =  $videoObject['entry']['yt$statistics']['viewCount'];


	return $videoData;
}

// Get Video Album Data
function videoAlbumData($album_id, $data, $output) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM cms_video_albums WHERE album_id = '".$album_id."' AND deleted = '0' AND ".$_SESSION['team_filter']." AND ".$_SESSION['site_filter'];
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	$albumData = "";
	
	if ($totalRows_getRecords != "0") {
		
		//Get Photo Data
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getVideos = "SELECT * FROM cms_videos WHERE album_id = '".$album_id."' AND deleted = '0' AND ".$_SESSION['team_filter']." AND ".$_SESSION['site_filter']."ORDER BY date_created DESC";
		$getVideos = mysql_query($query_getVideos, $ikiosk) or sqlError(mysql_error());
		$row_getVideos = mysql_fetch_assoc($getVideos);
		$totalRows_getVideos = mysql_num_rows($getVideos);
		
		//Total Photos
		if ($data == "count") {
		$albumData = $totalRows_getVideos;
		}
		
		//Album Cover
		if ($data == "album_cover") {
			if ($totalRows_getVideos == "0") {
				$albumData = $SYSTEM['html_root'].$SYSTEM['ikiosk_root']."/library/images/defaults/empty_video.jpg";	
			} else {
				//Get Site Root
				$albumData = $row_getVideos['media_thumb'];
			}
		}
	}
	
	if ($output == "print") {
		echo $albumData;	
	} else {
		return $albumData;	
	}
}

//Process MultiFile Upload via AJAX
function photoUploadAJAX($baseFile, $album_id, $site_id, $redirect) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	//Get Site Data
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getSite = "SELECT * FROM sys_sites WHERE site_id = '".$site_id."' AND deleted = '0' AND ".$_SESSION['team_filter']." AND ".$_SESSION['site_filter'];
	$getSite = mysql_query($query_getSite, $ikiosk) or sqlError(mysql_error());
	$row_getSite = mysql_fetch_assoc($getSite);
	$totalRows_getSite = mysql_num_rows($getSite);
	
	$photoMiniThumbSizeX = $row_getSite['image_mini_thumbnailX'];
 	$photoMiniThumbSizeY = $row_getSite['image_mini_thumbnailY'];
	$photoThumbSizeX = $row_getSite['image_thumbnailX'];
	$photoThumbSizeY = $row_getSite['image_thumbnailY'];
	$photoInlineSize = $row_getSite['image_inline'];
	$photoFullSize = $row_getSite['image_resized'];
			
	if ($totalRows_getSite != "0") {
		
		$uploadFolder = "/static/resources/userphotos";
		$uploadDir = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSite['site_root'].$uploadFolder;

		$generateID = create_guid();
		$generateID = str_replace("-", "", $generateID);
		$sExtension = substr( $baseFile, ( strrpos($baseFile, '.') + 1 ) ) ;
		$sExtension = strtolower( $sExtension );
		$fileID = $uploadDir."/".$baseFile;
		$fileLocation = $uploadFolder."/".$baseFile;
	
		
		//Get Image Original File Size
		$imagesize = getimagesize($fileID);
		$width = $imagesize[0];
		$height = $imagesize [1];
		
		//Create Mini Image
		$mini_thumbnail_ID = create_guid();
		$mini_thumbnail_ID = str_replace("-", "", $mini_thumbnail_ID); 
		$imageEditor = new ImageEditor($baseFile, $uploadDir);
		
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
		$imageEditor->outputFile($mini_thumbnail, $uploadDir."/");
		$mini_thumbnail_url = $uploadFolder."/".$mini_thumbnail;	
		
		//Create Thumbnail Image
		$thumbnail_ID = create_guid();
		$thumbnail_ID = str_replace("-", "", $thumbnail_ID); 
		$imageEditor = new ImageEditor($baseFile, $uploadDir);
				
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
		$imageEditor->outputFile($thumbnail, $uploadDir."/");
		$thumbnail_url = $uploadFolder."/".$thumbnail;	
		
		//Create Inline Image
		$imageinline_ID = create_guid();
		$imageinline_ID = str_replace("-", "", $imageinline_ID);
		if ($width > $photoInlineSize) {
		$sizeDifference  = $photoInlineSize/$width;
		$newwidth = $photoInlineSize;
		$newheight = $height*$sizeDifference;
		$imageEditor = new ImageEditor($baseFile, $uploadDir."/");
		$imageEditor->resize($newwidth, $newheight);
		$imageinline = $imageinline_ID.".".$sExtension;
		$imageEditor->outputFile($imageinline, $uploadDir."/");
		$imageInline_url = $uploadFolder."/".$imageinline;
		}
		if ($width <= $photoInlineSize) {
		$sizeDifference  = $width/$width;
		$newwidth = $width;
		$newheight = $height*$sizeDifference;
		$imageEditor = new ImageEditor($baseFile, $uploadDir."/");
		$imageEditor->resize($newwidth, $newheight);
		$imageinline = $imageinline_ID.".".$sExtension;
		$imageEditor->outputFile($imageinline, $uploadDir."/");
		$imageInline_url = $uploadFolder."/".$imageinline;
		}
		
		//Create Fullsized Image
		$resizedID = create_guid();
		$resizedID = str_replace("-", "", $resizedID);
		if ($width > $photoFullSize) {
		$sizeDifference  = $photoFullSize/$width;
		$newwidth = $photoFullSize;
		$newheight = $height*$sizeDifference;
		$imageEditor = new ImageEditor($baseFile, $uploadDir."/");
		$imageEditor->resize($newwidth, $newheight);
		$image_resized = $resizedID.".".$sExtension;
		$imageEditor->outputFile($image_resized, $uploadDir."/");
		$imageResized_url = $uploadFolder."/".$image_resized;
		}
		
		if ($width <= $photoFullSize) {
		$sizeDifference  = $width/$width;
		$newwidth = $width;
		$newheight = $height*$sizeDifference;
		$imageEditor = new ImageEditor($baseFile, $uploadDir."/");
		$imageEditor->resize($newwidth, $newheight);
		$image_resized = $resizedID.".".$sExtension;
		$imageEditor->outputFile($image_resized, $uploadDir."/");
		$imageResized_url = $uploadFolder."/".$image_resized;
		}		
		
		$generateID = create_guid();
		$insertSQL = sprintf("INSERT INTO sys_photos (photo_id, site_id, album_id, title, description, file_name, file_size, image_mini_thumbnail, image_thumbnail, image_inline, image_resized, image_original, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
		GetSQLValueString($generateID, "text"),
		GetSQLValueString($row_getSite['site_id'], "text"),
		GetSQLValueString($album_id, "text"),
		GetSQLValueString($_POST['title'], "text"),
		GetSQLValueString($_POST['description'], "text"),
		GetSQLValueString($baseFile, "text"),
		GetSQLValueString($fileSize, "text"),
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
			
	} // End Site Check
	
	if(!empty($redirect)) {
		header("Location: ".$redirect."&msg=10");
	}
}

//Process MultiFile Upload
function photoUpload($album_id, $site_id, $redirect) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	//Get Site Data
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getSite = "SELECT * FROM sys_sites WHERE site_id = '".$site_id."' AND deleted = '0' AND ".$_SESSION['team_filter']." AND ".$_SESSION['site_filter'];
	$getSite = mysql_query($query_getSite, $ikiosk) or sqlError(mysql_error());
	$row_getSite = mysql_fetch_assoc($getSite);
	$totalRows_getSite = mysql_num_rows($getSite);
	
	$photoMiniThumbSizeX = $row_getSite['image_mini_thumbnailX'];
 	$photoMiniThumbSizeY = $row_getSite['image_mini_thumbnailY'];
	$photoThumbSizeX = $row_getSite['image_thumbnailX'];
	$photoThumbSizeY = $row_getSite['image_thumbnailY'];
	$photoInlineSize = $row_getSite['image_inline'];
	$photoFullSize = $row_getSite['image_resized'];
		
	if ($totalRows_getSite != "0") {
		$uploadFolder = "/static/resources/userphotos";
		$uploadDir = $SYSTEM['ikiosk_filesystem_root']."/sites".$row_getSite['site_root'].$uploadFolder;
		
		foreach ($_FILES["Image"]["error"] as $key => $error) {
			
			if ($error == UPLOAD_ERR_OK) {
				
				$generateID = create_guid();
				$generateID = str_replace("-", "", $generateID);
				$fileID = $uploadDir."/".$generateID;
				$fileurl = $_FILES['Image']['name'][$key];
				$sExtension = substr( $fileurl, ( strrpos($fileurl, '.') + 1 ) ) ;
				$sExtension = strtolower( $sExtension );
				$fileID = $fileID.".".$sExtension;
				$fileLocation = $uploadFolder."/".$generateID.".".$sExtension;
				$baseFile = $generateID.".".$sExtension;
				
				// File Extensions are Valid
				if (($sExtension == "jpg") || ($sExtension == "jpeg") || ($sExtension == "png"))  {
					
					//Move Image File for Processing
					move_uploaded_file($_FILES['Image']['tmp_name'][$key], $fileID);
					chmod($fileID, 0777);
					
					//Get Image Original File Size
					$imagesize = getimagesize($fileID);
					$width = $imagesize[0];
					$height = $imagesize [1];
					
					//Create Mini Image
					$mini_thumbnail_ID = create_guid();
					$mini_thumbnail_ID = str_replace("-", "", $mini_thumbnail_ID); 
					$imageEditor = new ImageEditor($baseFile, $uploadDir);
					
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
					$imageEditor->outputFile($mini_thumbnail, $uploadDir."/");
					$mini_thumbnail_url = $uploadFolder."/".$mini_thumbnail;	
					
					//Create Thumbnail Image
					$thumbnail_ID = create_guid();
					$thumbnail_ID = str_replace("-", "", $thumbnail_ID); 
					$imageEditor = new ImageEditor($baseFile, $uploadDir);
							
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
					$imageEditor->outputFile($thumbnail, $uploadDir."/");
					$thumbnail_url = $uploadFolder."/".$thumbnail;	
					
					//Create Inline Image
					$imageinline_ID = create_guid();
					$imageinline_ID = str_replace("-", "", $imageinline_ID);
					if ($width > $photoInlineSize) {
					$sizeDifference  = $photoInlineSize/$width;
					$newwidth = $photoInlineSize;
					$newheight = $height*$sizeDifference;
					$imageEditor = new ImageEditor($baseFile, $uploadDir."/");
					$imageEditor->resize($newwidth, $newheight);
					$imageinline = $imageinline_ID.".".$sExtension;
					$imageEditor->outputFile($imageinline, $uploadDir."/");
					$imageInline_url = $uploadFolder."/".$imageinline;
					}
					if ($width <= $photoInlineSize) {
					$sizeDifference  = $width/$width;
					$newwidth = $width;
					$newheight = $height*$sizeDifference;
					$imageEditor = new ImageEditor($baseFile, $uploadDir."/");
					$imageEditor->resize($newwidth, $newheight);
					$imageinline = $imageinline_ID.".".$sExtension;
					$imageEditor->outputFile($imageinline, $uploadDir."/");
					$imageInline_url = $uploadFolder."/".$imageinline;
					}
					
					//Create Fullsized Image
					$resizedID = create_guid();
					$resizedID = str_replace("-", "", $resizedID);
					if ($width > $photoFullSize) {
					$sizeDifference  = $photoFullSize/$width;
					$newwidth = $photoFullSize;
					$newheight = $height*$sizeDifference;
					$imageEditor = new ImageEditor($baseFile, $uploadDir."/");
					$imageEditor->resize($newwidth, $newheight);
					$image_resized = $resizedID.".".$sExtension;
					$imageEditor->outputFile($image_resized, $uploadDir."/");
					$imageResized_url = $uploadFolder."/".$image_resized;
					}
					
					if ($width <= $photoFullSize) {
					$sizeDifference  = $width/$width;
					$newwidth = $width;
					$newheight = $height*$sizeDifference;
					$imageEditor = new ImageEditor($baseFile, $uploadDir."/");
					$imageEditor->resize($newwidth, $newheight);
					$image_resized = $resizedID.".".$sExtension;
					$imageEditor->outputFile($image_resized, $uploadDir."/");
					$imageResized_url = $uploadFolder."/".$image_resized;
					}		
					
					$generateID = create_guid();
					$insertSQL = sprintf("INSERT INTO sys_photos (photo_id, site_id, album_id, title, description, file_name, file_size, image_mini_thumbnail, image_thumbnail, image_inline, image_resized, image_original, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							GetSQLValueString($generateID, "text"),
							GetSQLValueString($row_getSite['site_id'], "text"),
							GetSQLValueString($album_id, "text"),
							GetSQLValueString($_POST['title'], "text"),
							GetSQLValueString($_POST['description'], "text"),
							GetSQLValueString($_FILES['Image']['name'][$key], "text"),
							GetSQLValueString($_FILES['Image']['size'][$key], "text"),
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
				} // End File Extension Check
			} else {
				errorLog("Photo upload failed: ".print_r($_FILES), "System Error", $redirect);
			}
		} // End For Each
	} // End Site Check
	
	if(!empty($redirect)) {
		header("Location: ".$redirect."&msg=10");
	}
}

//Get Most Recent Photo
function albumData($album_id, $data, $output) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecords = "SELECT * FROM sys_photo_albums WHERE album_id = '".$album_id."' AND deleted = '0' AND ".$_SESSION['team_filter']." AND ".$_SESSION['site_filter'];
	$getRecords = mysql_query($query_getRecords, $ikiosk) or sqlError(mysql_error());
	$row_getRecords = mysql_fetch_assoc($getRecords);
	$totalRows_getRecords = mysql_num_rows($getRecords);
	
	$albumData = "";
	
	if ($totalRows_getRecords != "0") {
		
		//Get Photo Data
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getPhotos = "SELECT * FROM sys_photos WHERE album_id = '".$album_id."' AND deleted = '0' AND ".$_SESSION['team_filter']." AND ".$_SESSION['site_filter']."ORDER BY date_created DESC";
		$getPhotos = mysql_query($query_getPhotos, $ikiosk) or sqlError(mysql_error());
		$row_getPhotos = mysql_fetch_assoc($getPhotos);
		$totalRows_getPhotos = mysql_num_rows($getPhotos);
		
		//Total Photos
		if ($data == "count") {
		$albumData = $totalRows_getPhotos;
		}
		
		//Album Cover
		if ($data == "album_cover") {
			if ($totalRows_getPhotos == "0") {
				$albumData = $SYSTEM['html_root'].$SYSTEM['ikiosk_root']."/library/images/defaults/empty_album.jpg";	
			} else {
				//Get Site Root
				$siteroot = getSiteData($row_getPhotos['site_id'], "site_root");
				$albumData = $SYSTEM['html_root']."/sites".$siteroot.$row_getPhotos['image_thumbnail'];
			}
		}

		//Album Cover Mini
		if ($data == "album_cover_mini") {
			//Get Site Root
			if ($totalRows_getPhotos == "0") {
				$albumData = $SYSTEM['html_root'].$SYSTEM['ikiosk_root']."/library/images/defaults/empty_album.jpg";	
			} else {
			$siteroot = getSiteData($row_getPhotos['site_id'], "site_root");
			$albumData = $SYSTEM['html_root']."/sites".$siteroot.$row_getPhotos['image_mini_thumbnail'];
			}
		}

	}
	
	if ($data != "count" && $data != "album_cover" && $data !="album_cover_mini") {
		$albumData = $row_getRecords[$data];
	}
	
	if ($output == "print") {
		echo $albumData;	
	} else {
		return $albumData;	
	}
}

//Complie Directory List 
function compileDirList() {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;
	$fileList = "/|/[iKiosk]";
	$directoryArray = directoryToArray($SITE['file_root'], $recursive);
	foreach ($directoryArray as $key => $value) {
	$value = str_replace($SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root'], "", $value);
	$fileList .= $value."/|".$value."/[iKiosk]";
	}
	$fileList = substr($fileList, 0, -8);
	$directoryFile = $SYSTEM['ikiosk_docroot']."/webapps/cms/dir_browser/".$SITE['site_id'].".txt";
	
	$fh = fopen($directoryFile, 'w') or errorLog("Unable to create CMS directory file: ".$directoryFile, "System Error", $redirect);
	fwrite($fh, $fileList);
	fclose($fh);
}

//Compile Directory to Array 
function directoryToArray($directory, $recursive) {
  	$array_items = array();
  	if ($handle = opendir($directory)) {
  		while (false !== ($file = readdir($handle))) {
  			if ($file != "." && $file != "..") {
 				if (is_dir($directory. "/" . $file)) {
					if ($file != "_notes" && $file != "fckeditor" && $file != "dir_browser" && $file != "phpmyadmin" && $file != "logs" && $file != ".svn" && $file != "backups" && $file != "system"  && $file != "sites" && $file != ".git"  && $file != "ishare"  && $file != "static"  && $file != "blog"&& $file != "library") {
						$array_items = array_merge($array_items, directoryToArray($directory. "/" . $file, $recursive));
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

//Recursive Delete Directory
function deleteDirectory($dirname) {
	global $ikiosk, $database_ikiosk, $SYSTEM, $SITE, $PAGE, $APPLICATION, $USER;

	if (is_dir($dirname))
	$dir_handle = opendir($dirname);
	if (!$dir_handle)
	return false;
	while($file = readdir($dir_handle)) {
	if ($file != "." && $file != "..") {
	if (!is_dir($dirname."/".$file))
	unlink($dirname."/".$file);
	else
	deleteDirectory($dirname.'/'.$file);
	}
	}
	closedir($dir_handle);
	rmdir($dirname);
	return true;
}

// Date Difference
function date_diffTW($d1, $d2){
	$d1 = (is_string($d1) ? strtotime($d1) : $d1);
	$d2 = (is_string($d2) ? strtotime($d2) : $d2);

	$diff_secs = abs($d1 - $d2);
	$base_year = min(date("Y", $d1), date("Y", $d2));

	$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
	$diffArray = array(
		"years" => date("Y", $diff) - $base_year,
		"months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
		"months" => date("n", $diff) - 1,
		"days_total" => floor($diff_secs / (3600 * 24)),
		"days" => date("j", $diff) - 1,
		"hours_total" => floor($diff_secs / 3600),
		"hours" => date("G", $diff),
		"minutes_total" => floor($diff_secs / 60),
		"minutes" => (int) date("i", $diff),
		"seconds_total" => $diff_secs,
		"seconds" => (int) date("s", $diff)
	);
	if($diffArray['days'] > 0){
		if($diffArray['days'] == 1){
			$days = '1 day';
		}else{
			$days = $diffArray['days'] . ' days';
		}
		return $days . ' and ' . $diffArray['hours'] . ' hours ago';
	}else if($diffArray['hours'] > 0){
		if($diffArray['hours'] == 1){
			$hours = '1 hour';
		}else{
			$hours = $diffArray['hours'] . ' hours';
		}
		return $hours . ' and ' . $diffArray['minutes'] . ' minutes ago';
	}else if($diffArray['minutes'] > 0){
		if($diffArray['minutes'] == 1){
			$minutes = '1 minute';
		}else{
			$minutes = $diffArray['minutes'] . ' minutes';
		}
		return $minutes . ' and ' . $diffArray['seconds'] . ' seconds ago';
	}else{
		return 'Less than a minute ago';
	}
}
?>
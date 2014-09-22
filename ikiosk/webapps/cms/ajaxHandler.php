<?php
ini_set('post_max_size', '20M');
ini_set('post_max_size', '20M');

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
		case "createBlog":
			$actionFile = "admin-createBlog.php";
			break;	
		case "pageVersions":
			$actionFile = "admin-pageVersions.php";
			break;	
		case "cmsAdmin":
			$actionFile = "admin-cmsConfig.php";
			break;		
		case "contentPages":
			$actionFile = "admin-contentPages.php";
			break;
		case "codeSnippets":
			$actionFile = "admin-codeSnippets.php";
			break;			
		case "fileManager":
			$actionFile = "admin-fileManager.php";
			break;		
			
		case "photoGallery":
			$actionFile = "admin-photoGallery.php";
			break;	
			
		case "templates":
			$actionFile = "admin-templates.php";
			break;		
		case "inlineEdit":
			$actionFile = "admin-inlineEdit.php";
			break;								
	}
	include($SYSTEM['ikiosk_filesystem_root']."/ikiosk/webapps/cms/".$actionFile);
	
	if($_GET['ajaxAction'] == "deleteRecord") {
		$status = deleteRecordv7($_GET['table'], $_GET['field'], $_GET['record']);
		if ($status[0] == "success") {
			insertJS("$('.".$_GET['record']."').fadeOut();");
		}
	}
	
	if($_GET['ajaxAction'] == "deleteDir") {
		$dir = htmlentities($_GET['recordID']);
		$dir = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root'].$dir;
		deleteDirectory($dir);
		insertJS("$('.parentDir').click();");
		exit;
	}
	
	if($_GET['ajaxAction'] == "deleteFile") {
		$file = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root'].$_GET['recordID'];
		unlink($file);
		insertJS("$('.parentDir').click();");
		exit;
	}
	
	if($_GET['ajaxAction'] == "uploadFiles") {
		include($SYSTEM['ikiosk_filesystem_root']."/ikiosk/webapps/cms/admin-uploadFiles.php");
		exit;
	}
	
	if($_GET['ajaxAction'] == "uploadPhotos") {
		include($SYSTEM['ikiosk_filesystem_root']."/ikiosk/webapps/cms/admin-uploadPhotos.php");
		exit;
	}
	
	if($_GET['ajaxAction'] == "refreshFiles") {
		$dir = htmlentities($_GET['recordID']);
		$refresh = urlFetch($SITE['site_url']."/cms/ajaxHandler.php?ajaxAction=fileManager&appCode=IKIOSK&directory=".$dir."&action=refreshFiles");
		$js = "\r\n var refreshHTML = '".trim($refresh)."';\r\n";
		$js .= "$('#fileList').html(refreshHTML);\r\n";
		insertJS($js);
		exit;
	}
	
	if($_GET['ajaxAction'] == "refreshPhotos") {
		$refresh = urlFetch($SITE['site_url']."/cms/ajaxHandler.php?ajaxAction=photoGallery&appCode=IKIOSK&recordID=".$_GET['recordID']."&action=refreshPhotos");
		$js = "\r\n var refreshHTML = '".trim($refresh)."';\r\n";
		$js .= "$('#cms-editPhoto').appendTo('#dynModalContent .modal-body');\r\n";
		$js .= "$('#photoList .superbox').html(refreshHTML);\r\n";
		$js .= "$('.superbox').SuperBox();\r\n";
		insertJS($js);
		exit;
	}
	
	if($_GET['ajaxAction'] == "deletePhotoAlbum") {
		$status = deleteRecordv7("sys_photo_albums", "album_id", $_GET['recordID']);
		insertJS("$('.parentAlbum').click();");
		exit;
	}
	
	if($_GET['ajaxAction'] == "deletePhoto") {
		$status = deleteRecordv7("sys_photos", "photo_id", $_GET['recordID']);
		insertJS("$('.dynRefresh').click();");
		exit;
	}
	
	
}

// Begin AJAX Post Wrapper ###########################################################################
if ((isset($_POST["iKioskForm"])) && ($_POST["iKioskForm"] == "Yes")) {
	
	//EditTemplate -----------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "cms-createBlog")) {
		
		$blogFile = sluggify($_POST['title']).".html";
	
		//Create Blog
		$articleID = create_guid();
		$insertSQL = sprintf("INSERT INTO cms_blog_articles (article_id, site_id, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s)",
				GetSQLValueString($articleID, "text"),
				GetSQLValueString($_SESSION['site_id'], "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"));
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);
		
		//Create Blog Version
		$articleVersionID = create_guid();
		$insertSQL = sprintf("INSERT INTO cms_blog_article_versions (article_version_id, article_id, site_id, title, version, status, auto_expire, permalink_filename, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					GetSQLValueString($articleVersionID, "text"),
					GetSQLValueString($articleID, "text"),
					GetSQLValueString($_SESSION['site_id'], "text"),
					GetSQLValueString($_POST['title'], "text"),
					GetSQLValueString("0.0", "text"),
					GetSQLValueString("Draft", "text"),
					GetSQLValueString("No", "text"),
					GetSQLValueString($blogFile, "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"));
			
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);	
		v7publishBlog($articleVersionID);	
		
		$js = "window.location=\"/blog/articles/".$blogFile."?mode=draft&version_id=".$articleVersionID."\"\r\n";
		insertJS($hideModal.$js);
		exit;

	}
	
	
	//EditTemplate -----------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "cms-editTemplate")) {
		
		if ($_POST['version'] != 0.00) {
			$version = $_POST['version'] + 0.05;
		} else {
			$version = $_POST['version'] + 1.00;	
		}
		
		if ($_POST['status'] == "Published") {
			$updateSQL = sprintf("UPDATE cms_template_versions SET status = 'Draft' WHERE template_id=%s",
				GetSQLValueString($_POST['template_id'], "text"));
		
			mysql_select_db($database_ikiosk, $ikiosk);
			$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
			sqlQueryLog($updateSQL);
		}
		
		$generateID = create_guid();
		$insertSQL = sprintf("INSERT INTO cms_template_versions (template_version_id, site_id, template_id, version, title, description, header_code, body_header_code, body_footer_code, status, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
				GetSQLValueString($generateID, "text"),
				GetSQLValueString($SITE['site_id'], "text"),
				GetSQLValueString($_POST['template_id'], "text"),
				GetSQLValueString($version, "text"),
				GetSQLValueString($_POST['title'], "text"),
				GetSQLValueString($_POST['description'], "text"),
				GetSQLValueString($_POST['header_code'], "text"),
				GetSQLValueString($_POST['body_header_code'], "text"),
				GetSQLValueString($_POST['body_footer_code'], "text"),
				GetSQLValueString($_POST['status'], "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"));
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);
		
		$js = "$('.dynRefresh').click();\r\n";
		insertJS($js);	
		exit;
	}
	
	//Create New Template -----------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "cms-createTemplate")) {
		$templateID = create_guid();
		$insertSQL = sprintf("INSERT INTO cms_templates (template_id, site_id, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s)",
				GetSQLValueString($templateID, "text"),
				GetSQLValueString($SITE['site_id'], "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"));
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);
		
		//Create Template Version
		$template_version_id = create_guid();
		$insertSQL = sprintf("INSERT INTO cms_template_versions (template_version_id, template_id, site_id, title, version, status, header_code, body_header_code, body_footer_code, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
						GetSQLValueString($template_version_id, "text"),
						GetSQLValueString($templateID, "text"),
						GetSQLValueString($SITE['site_id'], "text"),
						GetSQLValueString($_POST['title'], "text"),
						GetSQLValueString("1.0", "text"),
						GetSQLValueString("Published", "text"),
						GetSQLValueString($_POST['header_code'], "text"),
						GetSQLValueString($_POST['body_header_code'], "text"),
						GetSQLValueString($_POST['body_footer_code'], "text"),
						GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
						GetSQLValueString($_SESSION['user_id'], "text"),
						GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
						GetSQLValueString($_SESSION['user_id'], "text"));
				
			mysql_select_db($database_ikiosk, $ikiosk);
			$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
			sqlQueryLog($insertSQL);		
			
			$js = "$('.dynRefresh').click();\r\n";
			insertJS($js);	
			exit;
	}
	
	
	//Edit Photo Properties -----------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "cms-editPhoto")) {
		$updateSQL = sprintf("UPDATE sys_photos SET title=%s, description=%s, date_modified=%s, modified_by=%s WHERE photo_id=%s",
        GetSQLValueString($_POST['title'], "text"),
        GetSQLValueString($_POST['description'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($_POST['photo_id'], "text"));
	
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($updateSQL);
		
		insertJS("$('.superbox-close').click();\r\n $('.dynRefresh').click();");
		exit;
	}
	
	
	//Edit Photo Album -----------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "cms-editAlbumPhoto")) {
				$updateSQL = sprintf("UPDATE sys_photo_albums SET title=%s, description=%s, date_modified=%s, modified_by=%s WHERE album_id=%s",
					GetSQLValueString($_POST['title'], "text"),
					GetSQLValueString($_POST['description'], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"),
					GetSQLValueString($_POST['album_id'], "text"));
			
			mysql_select_db($database_ikiosk, $ikiosk);
			$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
			sqlQueryLog($updateSQL);
			insertJS("$('.dynRefresh').click();");
			exit;
	}
	
	//Create Photo Album -----------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "cms-newPhotoAlbum")) {
		
			$generateID = create_guid();
			$insertSQL = sprintf("INSERT INTO sys_photo_albums (album_id, site_id, title, description, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
					GetSQLValueString($generateID, "text"),
					GetSQLValueString($_SESSION['site_id'], "text"),
					GetSQLValueString($_POST['title'], "text"),
					GetSQLValueString($_POST['description'], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"));
			
			mysql_select_db($database_ikiosk, $ikiosk);
			$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
			sqlQueryLog($insertSQL);
			
			$js = "$('.dynRefresh').click();\r\n";
			insertJS($js);		
			exit;
	}
	
	
	//Rename File -----------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "cms-renameFile")) {
		$rootFolder = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root'];
		$oldFile = $rootFolder.$_POST['original'];
		$newFile = $rootFolder.$_POST['parent']."/".$_POST['filename'];
		
		if (!rename($oldFile, $newFile)) {
			displayAlert("danger", "Unable to rename file.");
		} else {
			$js = "$('.parentDir').click();\r\n";
			insertJS($js);	
		}
		exit;
	}
	
	
	//Rename Folder -----------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "cms-renameFolder")) {
		$foldername = preg_replace("/[^A-Za-z0-9 ]/", '', $_POST['foldername']);
		$rootFolder = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root'];
		$oldFolder = $rootFolder.$_POST['original'];
		$newFolder = $rootFolder.$_POST['parent']."/".$foldername;
		
		if (!rename($oldFolder, $newFolder)) {
			displayAlert("danger", "Unable to rename folder.");
		} else {
			$js = "$('.parentDir').click();\r\n";
			insertJS($js);	
		}
		exit;
	}
	
	
	//Create New Folder -----------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "cms-newFileFolder")) {
		$foldername = preg_replace("/[^A-Za-z0-9 ]/", '', $_POST['foldername']);
		$rootFolder = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root'];
		$newFolder = $rootFolder.$_POST['parent']."/".$foldername;
		createDIR($newFolder);
		$js = "$('.fileSelf').click();\r\n";
		insertJS($js);
		exit;
	}
	
	//Create Code Snippet -----------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "cms-createCodeSnippet")) {
		
		$generateID = create_guid();
    $insertSQL = sprintf("INSERT INTO cms_page_elements (`page_element_id`, `site_id`, `template_section_id`, `title`, `content`, `status`, `display_order`, `date_created`, `created_by`, `date_modified`, `modified_by`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($generateID, "text"),
        GetSQLValueString($SITE['site_id'], "text"),
        GetSQLValueString($_POST['template_section_id'], "text"),
        GetSQLValueString($_POST['title'], "text"),
        GetSQLValueString($_POST['content'], "text"),
        GetSQLValueString($_POST['status'], "text"),
        GetSQLValueString($_POST['display_order'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"));

			mysql_select_db($database_ikiosk, $ikiosk);
			$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
			sqlQueryLog($insertSQL);
			
			$js = "$('.dynRefresh').click();\r\n";
			insertJS($js);
			exit;
	}

	
	//Edit Code Snippet -----------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "cms-editCodeSnippet")) {
		
		$updateSQL = sprintf("UPDATE cms_page_elements SET title=%s, content=%s, status=%s, date_modified=%s, modified_by=%s WHERE page_element_id=%s",
        GetSQLValueString($_POST['title'], "text"),
        GetSQLValueString($_POST['content'], "text"),
        GetSQLValueString($_POST['status'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($_POST['page_element_id'], "text"));

				mysql_select_db($database_ikiosk, $ikiosk);
				$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
				sqlQueryLog($updateSQL);	
				
		displayAlert("success", "Changes saved.");
		exit;
		
	}
	
	//Create New Page Properties-----------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "cms-createPage")) {
		
		//Create Page
		$pageID = create_guid();
		$insertSQL = sprintf("INSERT INTO cms_pages (page_id, site_id, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s)",
				GetSQLValueString($pageID, "text"),
				GetSQLValueString($_SESSION['site_id'], "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"),
				GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
				GetSQLValueString($_SESSION['user_id'], "text"));
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);
		
		//Create Page Version
		$pageVersionID = create_guid();
		$insertSQL = sprintf("INSERT INTO cms_page_versions (page_version_id, page_id, site_id, title, version, status, auto_expire, menu_display, menu_display_order, date_created, created_by, date_modified, modified_by, template_id, static_folder, static_file) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					GetSQLValueString($pageVersionID, "text"),
					GetSQLValueString($pageID, "text"),
					GetSQLValueString($_SESSION['site_id'], "text"),
					GetSQLValueString($_POST['title'], "text"),
					GetSQLValueString("0.0", "text"),
					GetSQLValueString("Published", "text"),
					GetSQLValueString("No", "text"),
					GetSQLValueString("No", "text"),
					GetSQLValueString("0.00", "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"),
					GetSQLValueString($_POST['template_id'], "text"),
					GetSQLValueString($_POST['static_folder'], "text"),
					GetSQLValueString($_POST['static_file'], "text"));
			
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);
		
		v7publishPage($pageID);
		$js = "window.location=\"".$_POST['static_folder'].$_POST['static_file']."\"\r\n";
		insertJS($hideModal.$js);
		exit;
		
	}
	
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
	
	//Save Blog Edits-----------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "iKioskCMS-editArticle")) {
		
		//Grab Existing Article Details
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getRecord = "SELECT * FROM cms_blog_article_versions WHERE article_version_id = '".$_POST['article_version_id']."' AND deleted = '0' AND ".$SYSTEM['active_site_filter'];
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
			
			//Create Blog Version
		$articleVersionID = create_guid();
		$insertSQL = sprintf("INSERT INTO cms_blog_article_versions (article_version_id, article_id, site_id, title, content, version, status, auto_expire, publish_date, expiration_date, permalink_filename, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					GetSQLValueString($articleVersionID, "text"),
					GetSQLValueString($row_getRecord['article_id'], "text"),
					GetSQLValueString($row_getRecord['site_id'], "text"),
					GetSQLValueString($row_getRecord['title'], "text"),
					GetSQLValueString($_POST['content'], "text"),
					GetSQLValueString($version, "text"),
					GetSQLValueString("Draft", "text"),
					GetSQLValueString($row_getRecord['auto-expire'], "text"),
					GetSQLValueString($row_getRecord['publish_date'], "text"),
					GetSQLValueString($row_getRecord['expiration_date'], "text"),
					GetSQLValueString($row_getRecord['permalink_filename'], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"));
			
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);	
		v7publishBlog($articleVersionID);	
		
		$js = "window.location=\"/blog/articles/".$row_getRecord['permalink_filename']."?mode=draft&version_id=".$articleVersionID."\"\r\n";
		insertJS($hideModal.$js);
		exit;
			
		}
		
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
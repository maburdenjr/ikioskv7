<?php

//File List
$fileList = urlFetch($SYSTEM['ikiosk_cloud']."/system/api/downloadSoftware.php?ikiosk_id=".$SYSTEM['ikiosk_id']."&ikiosk_license_key=".$SYSTEM['ikiosk_license_key']."&software_id=".$_GET['recordID']);
$fileList = explode("[iKiosk]", $fileList);

//Software Summary
$softwareSummary = urlFetch($SYSTEM['ikiosk_cloud']."/system/api/downloadSoftware.php?ikiosk_id=".$SYSTEM['ikiosk_id']."&ikiosk_license_key=".$SYSTEM['ikiosk_license_key']."&software_id=".$_GET['recordID']."&option=summary");
$softwareSummary = explode("|", $softwareSummary);

//Create Folders
$folderList = $softwareSummary[12];
$folderList = explode("[iKiosk]", $folderList);
foreach ($folderList as $key => $value) {
	if ($value != "") {
	$folderList = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/templates".$value;
	createDIR($folderList);
	}
}
		
	//Copy Files
	foreach ($fileList as $key => $value) { 
		$fileProperties = explode("|", $value);
		$remoteFile = "/".$softwareSummary[10]."/".$fileProperties[1];
		$remoteFileURL = $SYSTEM['ikiosk_cloud']."/system/software_apps".$remoteFile;
		$destinationFile = "/templates".str_replace('/system/cms_templates', "", $fileProperties[2]);
		$destinationFileURL = $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root'].$destinationFile;
		
		$fileContents = urlFetch($remoteFileURL);
		$fh = fopen($destinationFileURL, 'w') or errorLog("Unable to create create: ".$destinationFile, "System Error", $redirect);	
		fwrite($fh, $fileContents);
		fclose($fh);
	}
		
		$templates = urlFetch($SITE['site_url']."/templates/".$softwareSummary[10]."/templateConfig.php?option=templateList");
		$templateList = explode("[iKiosk]", $templates);
			foreach($templateList as $key => $value) {
				$templateSummary = explode("--|--", $value);
				
				if ($templateSummary[0] != "") {
				//Create Template
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
								GetSQLValueString($templateSummary['0'], "text"),
								GetSQLValueString("1.0", "text"),
								GetSQLValueString("Published", "text"),
								GetSQLValueString($templateSummary['1'], "text"),
								GetSQLValueString($templateSummary['2'], "text"),
								GetSQLValueString($templateSummary['3'], "text"),
								GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
								GetSQLValueString($_SESSION['user_id'], "text"),
								GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
								GetSQLValueString($_SESSION['user_id'], "text"));
						
					mysql_select_db($database_ikiosk, $ikiosk);
					$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
					sqlQueryLog($insertSQL);	
					
					//Copy Template Layout File
					$fileContents = urlFetch($SITE['site_url']."/templates/".$softwareSummary[10]."/templateLayouts.txt");
					$destinationFile =  $SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/templates/".$templateID."-layouts.php";
					$fh = fopen($destinationFile, 'w+') or errorLog("Unable to create create: ".$destinationFile, "System Error", $redirect);	
					fwrite($fh, $fileContents);
					fclose($fh);
				}
							
		}

		$snippets = urlFetch($SITE['site_url']."/templates/".$softwareSummary[10]."/templateConfig.php?option=snippetList");
		$snippetList = explode("[iKiosk]", $snippets);
			foreach($snippetList as $key => $value) {
				$snippetSummary = explode("--|--", $value);	
				if ($snippetSummary[0] != "") {
					
					//Does Snippet ID Exist
					mysql_select_db($database_ikiosk, $ikiosk);
					$query_listView = "SELECT * FROM cms_page_elements WHERE deleted = '0' AND page_element_id = '".$snippetSummary[0]."' AND  ".$SYSTEM['active_site_filter'];
					$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
					$row_listView = mysql_fetch_assoc($listView);
					$totalRows_listView = mysql_num_rows($listView);
					if ($totalRows_listView == 0) {
						$insertSQL = sprintf("INSERT INTO cms_page_elements (`page_element_id`, `site_id`, `template_section_id`, `title`, `content`, `status`, `display_order`, `date_created`, `created_by`, `date_modified`, `modified_by`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							GetSQLValueString($snippetSummary[0], "text"),
							GetSQLValueString($SITE['site_id'], "text"),
							GetSQLValueString($_POST['template_section_id'], "text"),
							GetSQLValueString($snippetSummary[1], "text"),
							GetSQLValueString($snippetSummary[2], "text"),
							GetSQLValueString("Active", "text"),
							GetSQLValueString($_POST['display_order'], "text"),
							GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
							GetSQLValueString($_SESSION['user_id'], "text"),
							GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
							GetSQLValueString($_SESSION['user_id'], "text"));
			
						mysql_select_db($database_ikiosk, $ikiosk);
						$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
						sqlQueryLog($insertSQL);							
					}
					 
				}
			} // End Snippets
	
		insertJS("$('#dt-softwareDownloadList_wrapper').hide();");
		$response = '<div class="padding-10"><div class="alert alert-success fade in"><button class="close" data-dismiss="alert">×</button> Template Download Complete</div>';
		
		$response .='<h3>'.$softwareSummary[1].'</h3>';
		$response .='<p>All files, templates, and widgets for this template have been downloaded to this site.  You may edit this template from the <a href="/cms/ajaxHandler.php?ajaxAction=templates&appCode=CMS" class="modalDynLink">template list</a>.</p>';
		$response .='<p><strong>Template Resources</strong></p>';
		$response .='<ul><li><a href="/templates/'.$softwareSummary[10].'/docs" target="_blank">'.$softwareSummary[1].' documentation</a> </li><li><a href="/templates/'.$softwareSummary[10].'" target="_blank">'.$softwareSummary[1].' example pages</a></li></ul>';
		$response .='</div>';
		echo $response;
		exit;	
?>
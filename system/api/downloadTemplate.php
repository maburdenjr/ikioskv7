<?php
/* 
IntelliKiosk 6.x Core 
Copyright (C) 2011 Interactive Remix, LLC.
/index.php 

*/
$PAGE['application_code'] = "IKIOSK";
$PAGE['include_header']  = "No"; 

require('../../ikiosk/includes/core/ikiosk.php'); // Load iKiosk Core Files

if (isset($_GET['ikiosk_id']) && isset($_GET['ikiosk_license_key'])) {
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM ikioskcloud_licenses WHERE deleted = '0' AND status = 'Active' AND ikiosk_id = '".$_GET['ikiosk_id']."' AND ikiosk_license_key = '".$_GET['ikiosk_license_key']."'";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);	
	
	//Get Template
	if ($totalRows_getRecord != 0) {
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getTemplates = "SELECT * FROM ikioskcloud_templates WHERE status='Active' AND deleted = '0' AND template_id = '".$_GET['template_id']."'";
		$getTemplates = mysql_query($query_getTemplates, $ikiosk) or sqlError(mysql_error());
		$row_getTemplates = mysql_fetch_assoc($getTemplates);
		$totalRows_getTemplates = mysql_num_rows($getTemplates);	
		
		if ($totalRows_getTemplates != 0) {
			
			//Template Detail
			if ($_GET['option'] == "templateDetail") {
				
				$templateDetail = $row_getTemplates['template_id']."|".$row_getTemplates['template_title']."|".$row_getTemplates['description']."|".$row_getTemplates['category']."|".$row_getTemplates['version']."|".$row_getTemplates['date_created']."|".$row_getTemplates['date_modified']."|".$row_getTemplates['local_folder']."|".$row_getTemplates['folder_map']."|".$row_getTemplates['template_map'];
				echo $templateDetail;
			}
			
			//Template Files
			if ($_GET['option'] == "templatePages") {
				mysql_select_db($database_ikiosk, $ikiosk);
				$query_getPages = "SELECT * FROM ikioskcloud_template_pages WHERE deleted = '0' AND template_id = '".$row_getTemplates['template_id']."'";
				$getPages = mysql_query($query_getPages, $ikiosk) or sqlError(mysql_error());
				$row_getPages = mysql_fetch_assoc($getPages);
				$totalRows_getPages = mysql_num_rows($getPages);

				
				if ($totalRows_getPages != 0) {
					$templatePageList = "";
					$i = 1;
					do {
						
					$templatePageList .= $row_getPages['title']."|template|".$row_getPages['content_id']."|template|".htmlentities($row_getPages['content'])."|template|".$row_getPages['static_folder']."|template|".$row_getPages['static_file']."|template|".$row_getPages['menu_display']."|template|".$row_getPages['menu_display_order'];
						
					if ($i < $totalRows_getPages) { $templatePageList .= "[iKiosk]";}
					$i++;
					} while ($row_getPages = mysql_fetch_assoc($getPages));
				}
				
				echo $templatePageList;
			}
			
			
			//List Files
			if ($_GET['option'] == "templateFiles") {
				mysql_select_db($database_ikiosk, $ikiosk);
				$query_getFiles = "SELECT * FROM ikioskcloud_template_map WHERE deleted = '0' AND template_id = '".$row_getTemplates['template_id']."'";
				$getFiles = mysql_query($query_getFiles, $ikiosk) or sqlError(mysql_error());
				$row_getFiles = mysql_fetch_assoc($getFiles);
				$totalRows_getFiles = mysql_num_rows($getFiles);
				
				//Add File List
				if ($totalRows_getFiles != 0) {
					$templateFileList = "";
					$i = 1;
					do {
					$templateFileList .= $row_getFiles['source_file']."|".$row_getFiles['package_file']."|".$row_getFiles['destination_file'];
					if ($i < $totalRows_getFiles) { $templateFileList .= "[iKiosk]";}
					$i++;
					} while ($row_getFiles = mysql_fetch_assoc($getFiles));	
				}	
				
				echo $templateFileList;
				
			} // End Files List
			
			//List Layouts
			if ($_GET['option'] == "templateLayouts") {
				mysql_select_db($database_ikiosk, $ikiosk);
				$query_getLayouts = "SELECT * FROM ikioskcloud_template_layouts WHERE deleted = '0' AND status = 'Active' AND template_id = '".$row_getTemplates['template_id']."'";
				$getLayouts = mysql_query($query_getLayouts, $ikiosk) or sqlError(mysql_error());
				$row_getLayouts = mysql_fetch_assoc($getLayouts);
				$totalRows_getLayouts = mysql_num_rows($getLayouts);	
				
				if ($totalRows_getLayouts != 0) {
					$templateLayouts = "";
					$i = 1;
					do {
					
					$templateLayouts .= $row_getLayouts['layout_id']."|template|".$row_getLayouts['title']."|template|".$row_getLayouts['description']."|template|".htmlentities($row_getLayouts['header_code'])."|template|".htmlentities($row_getLayouts['body_header_code'])."|template|".htmlentities($row_getLayouts['body_footer_code']."|template|".$row_getLayouts['template_type']);
						
					if ($i < $totalRows_getLayouts) { $templateLayouts .= "[iKiosk]";}
					$i++;
					} while ($row_getLayouts = mysql_fetch_assoc($getLayouts));		
				}
				
				echo $templateLayouts;
			
			} // End File Layout
			
			$cloudsite = "/testsite";
			if ($SYSTEM['ikiosk_cloud'] == "http://apps.ikioskcloud.com") {$cloudsite = "/sandbox";}
			
			//List Snippets
			if ($_GET['option'] == "templateSnippets") {
				mysql_select_db($database_ikiosk, $ikiosk);
				$query_getSnippets = "SELECT * FROM ikioskcloud_template_snippets WHERE deleted = '0' AND template_id = '".$row_getTemplates['template_id']."'";
				$getSnippets = mysql_query($query_getSnippets, $ikiosk) or sqlError(mysql_error());
				$row_getSnippets = mysql_fetch_assoc($getSnippets);
				$totalRows_getSnippets = mysql_num_rows($getSnippets);	
				
				if ($totalRows_getSnippets != 0) {
					$templateSnippets = "";
					$i = 1;
					do {
						
					$templateSnippets .= $row_getSnippets['title']."|".$row_getSnippets['description']."|".htmlentities($row_getSnippets['content'])."|".$SYSTEM['ikiosk_cloud']."/sites".$cloudsite.$row_getSnippets['screenshot']."|".$row_getSnippets['type'];
						
					if ($i < $totalRows_getSnippets) { $templateSnippets .= "[iKiosk]";}
					$i++;
					} while ($row_getSnippets = mysql_fetch_assoc($getSnippets));		
				}
				
				echo $templateSnippets;
			} //End Snippets
		
		}
	}

}
?>
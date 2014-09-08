<?php
/* 
IntelliKiosk 6.x Core 
Copyright (C) 2011 Interactive Remix, LLC.
*/


$PAGE['application_code'] = "IKIOSK";
$PAGE['include_header']  = "No"; 

require('../../ikiosk/includes/core/ikiosk.php'); // Load iKiosk Core Files


//Returns a list of Downloadable Templates 
$templateList = "";

if (isset($_GET['ikiosk_id']) && isset($_GET['ikiosk_license_key'])) {
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM ikioskcloud_licenses WHERE deleted = '0' AND status = 'Active' AND ikiosk_id = '".$_GET['ikiosk_id']."' AND ikiosk_license_key = '".$_GET['ikiosk_license_key']."'";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);	
	
	//Get Template List
	if ($totalRows_getRecord != 0) {
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getTemplates = "SELECT * FROM ikioskcloud_templates WHERE status='Active' AND deleted = '0' AND license_type = 'Site Builder'";
		$getTemplates = mysql_query($query_getTemplates, $ikiosk) or sqlError(mysql_error());
		$row_getTemplates = mysql_fetch_assoc($getTemplates);
		$totalRows_getTemplates = mysql_num_rows($getTemplates);
		
		//Get Template Details
		if ($totalRows_getTemplates != 0) {	
			$i = 1;
			do {
			$siteID = displayImage($row_getTemplates['screenshot'], "site_id", "return");
			$siteRoot = getSiteData($siteID, "site_root");
			$tmpScreenshot = displayImage($row_getTemplates['screenshot'], "image_inline", "return");
			$tmpScreenshot = $SYSTEM['ikiosk_cloud']."/sites".$siteRoot.$tmpScreenshot;
?>
	<div class="ez_template_item <?php echo $row_getTemplates['category']; ?>">
    	<a class="ez_template_selector" id="<?php echo $row_getTemplates['template_id']; ?>">
        	<div class="ez_template_image">
            	<img src="<?php echo $tmpScreenshot; ?>">
            </div>
            <div class="ez_template_info">
            	<p class="ez_template_title"><?php echo $row_getTemplates['template_title']; ?></p>
                <p class="ez_template_desc"><?php echo $row_getTemplates['description']; ?></p>
                <p align="center"><span class="ez_template_button">Use this Template</span></p>
            </div>
   		</a>
     </div>

<?php
				
			} while ($row_getTemplates = mysql_fetch_assoc($getTemplates));			
		}
	}
	
}
?>
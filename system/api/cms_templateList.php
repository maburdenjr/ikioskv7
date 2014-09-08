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
                <p align="center"><span class="ez_template_button">View <?php echo $row_getTemplates['template_title']; ?></span></p>
            </div>
   		</a>
     </div>

<?php
				
			} while ($row_getTemplates = mysql_fetch_assoc($getTemplates));			
		}
?>
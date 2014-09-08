<?php
/* 
IntelliKiosk 6.x Core 
Copyright (C) 2011 Interactive Remix, LLC.
*/


$PAGE['application_code'] = "IKIOSK";
$PAGE['include_header']  = "No"; 

require('../../ikiosk/includes/core/ikiosk.php'); // Load iKiosk Core Files


if (isset($_GET['ikiosk_id']) && isset($_GET['ikiosk_license_key']) && isset($_GET['template_id'])) {
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM ikioskcloud_licenses WHERE deleted = '0' AND status = 'Active' AND ikiosk_id = '".$_GET['ikiosk_id']."' AND ikiosk_license_key = '".$_GET['ikiosk_license_key']."'";
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);	
	
	
	//Get Screenshots
	if ($totalRows_getRecord != 0) {
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getScreenshots = "SELECT * FROM sys_photos WHERE album_id='".$_GET['template_id']."' AND deleted = '0'";
		$getScreenshots = mysql_query($query_getScreenshots, $ikiosk) or sqlError(mysql_error());
		$row_getScreenshots = mysql_fetch_assoc($getScreenshots);
		$totalRows_getScreenshots = mysql_num_rows($getScreenshots);
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_getTemplates = "SELECT * FROM ikioskcloud_templates WHERE status='Active' AND deleted = '0' AND license_type = 'Site Builder' and template_id='".$_GET['template_id']."'";
		$getTemplates = mysql_query($query_getTemplates, $ikiosk) or sqlError(mysql_error());
		$row_getTemplates = mysql_fetch_assoc($getTemplates);
		$totalRows_getTemplates = mysql_num_rows($getTemplates);
		?>
        <div class="ez_template_info_header">
   			<p class="ez_template_info_title"><?php echo $row_getTemplates['template_title']; ?></p>
            <p><?php echo $row_getTemplates['description']; ?></p>
    	</div>
        
    <?php 
		
		//Get Template Details
		if ($totalRows_getScreenshots != 0) {
			?>
            <div class="ez_template_info_subtitle">
            	Screenshots
            </div>
            <!--<div class="notification information">Click on the thumbnails on the right to see a screenshot of the page.</div>-->
            <div class="ez_template_wrapper">
                <div class="ez_template_thumbnails">
                	<?php 
			do {	
			
			$siteID = $row_getScreenshots['site_id'];
			$siteRoot = getSiteData($siteID, "site_root");
			
?>
		 <div class="ez_template_screenshot">
         	<div class="ez_template_screenshot_shield">
                 <a data-screenshot="<?php echo  $SYSTEM['ikiosk_cloud']."/sites".$siteRoot.$row_getScreenshots['image_original']; ?>" class="ez_screenshot_trigger">
                 <img src="<?php echo  $SYSTEM['ikiosk_cloud']."/sites".$siteRoot.$row_getScreenshots['image_inline']; ?>">
                 </a>	
        	 </div>
        </div>

<?php
				
			} while ($row_getScreenshots = mysql_fetch_assoc($getScreenshots));		
			?>
                </div>
            </div>
            
            
			<?php 	
		}
	}
	
}
?>
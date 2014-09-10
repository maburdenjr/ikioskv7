<?php
/* iKiosk 7.0 Tiger */
$PAGE['application_code'] = "IKIOSK";
require('ikiosk-tmp-core'); // Load iKiosk Core Files

$SITE['site_id'] = "ikiosk_tmp_site";
$page_id = "ikiosk-tmp-page";

if (!empty($_GET['page'])) {
	$filter = " AND page_version_id = '".$_GET['page']."' ";	
} else {
	$filter = " AND status = 'Published' ";	
}

//Load Page Properties
mysql_select_db($database_ikiosk, $ikiosk);
$query_getPage = "SELECT * FROM cms_page_versions WHERE page_id = '".$page_id."' ".$filter." AND deleted = '0'";
$getPage = mysql_query($query_getPage, $ikiosk) or sqlError(mysql_error());
$row_getPage = mysql_fetch_assoc($getPage);
$totalRows_getPage = mysql_num_rows($getPage);

//Load Site Properties
mysql_select_db($database_ikiosk, $ikiosk);
$query_getSite = "SELECT * FROM sys_sites WHERE site_id = '".$row_getPage['site_id']."' AND deleted = '0'";
$getSite = mysql_query($query_getSite, $ikiosk) or sqlError(mysql_error());
$SITE =  mysql_fetch_assoc($getSite);
$totalRows_getSite = mysql_num_rows($getSite);

$_SESSION['site_id'] = $SITE['site_id'];
if (empty($_SESSION['user_id'])) {
	$USER['user_timezone'] = $SITE['site_timezone'];
	$USER['user_dateformat'] = $SITE['site_dateformat'];
}

//Load Template Properties
mysql_select_db($database_ikiosk, $ikiosk);
$query_getTemplate = "SELECT * FROM cms_template_versions WHERE template_id = '".$row_getPage['template_id']."' AND status = 'Published' AND deleted = '0'";
$getTemplate = mysql_query($query_getTemplate, $ikiosk) or sqlError(mysql_error());
$row_getTemplate = mysql_fetch_assoc($getTemplate);
$totalRows_getTemplate = mysql_num_rows($getTemplate);


//Load CMS Properties
mysql_select_db($database_ikiosk, $ikiosk);
$query_getCMS = "SELECT * FROM cms_config WHERE site_id = '".$row_getPage['site_id']."' AND deleted = '0'";
$getCMS = mysql_query($query_getCMS, $ikiosk) or sqlError(mysql_error());
$row_getCMS = mysql_fetch_assoc($getCMS);
$totalRows_getCMS = mysql_num_rows($getCMS);

$inlineEdit = cmsInlineCheck();

if ($inlineEdit == "Yes") {	
	include($SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/cms/editPage.php");
} else {
	include($SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/cms/displayPage.php");
}
accessLog("Page");	
?>



<?php
/* iKiosk 7.0 Tiger */
$PAGE['application_code'] = "IKIOSK";
require('ikiosk-tmp-core'); // Load iKiosk Core Files

$SITE['site_id'] = "ikiosk_tmp_site";
$blogModule = "index";

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

//Load CMS Configuration
mysql_select_db($database_ikiosk, $ikiosk);
$query_getConfig = "SELECT * FROM cms_config WHERE site_id = '".$SITE['site_id']."' AND deleted = '0'";
$getConfig = mysql_query($query_getConfig, $ikiosk) or sqlError(mysql_error());
$row_getConfig = mysql_fetch_assoc($getConfig);
$totalRows_getConfig = mysql_num_rows($getConfig);

//Load Template Properties
mysql_select_db($database_ikiosk, $ikiosk);
$query_getTemplate = "SELECT * FROM cms_template_versions WHERE template_id = '".$row_getConfig['blog_home_template']."' AND status = 'Published' AND deleted = '0'";
$getTemplate = mysql_query($query_getTemplate, $ikiosk) or sqlError(mysql_error());
$row_getTemplate = mysql_fetch_assoc($getTemplate);
$totalRows_getTemplate = mysql_num_rows($getTemplate);

//Get Articles
mysql_select_db($database_ikiosk, $ikiosk);
$query_getPage = "SELECT * FROM cms_blog_article_versions a INNER JOIN cms_blog_articles b ON a.article_id = b.article_id WHERE a.site_id = '".$SITE['site_id']."' AND a.status = 'Published' AND a.deleted = '0' AND b.deleted = '0' ".$subQuery." ORDER BY a.display_order DESC, b.date_created DESC";
$getPage = mysql_query($query_getPage, $ikiosk) or sqlError(mysql_error());
$row_getPage = mysql_fetch_assoc($getPage);
$totalRows_getPage = mysql_num_rows($getPage);

$inlineEdit = cmsInlineCheck();

if (($inlineEdit == "Yes") && ($_GET['editor'] != "off")) {	
	include($SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/blog/indexEdit.php");
} else {
	include($SYSTEM['ikiosk_filesystem_root']."/sites".$SITE['site_root']."/blog/indexDisplay.php");
}

?>
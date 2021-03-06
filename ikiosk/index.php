<?php
/* iKiosk 7.0 Tiger */
$PAGE['track'] = "No";
$PAGE['application_code'] = "USER";
require('includes/core/ikiosk.php');
require($SYSTEM['ikiosk_docroot'].'/smartui/inc/init.php');
require($SYSTEM['ikiosk_docroot'].'/smartui/inc/config.ui.php');

$page_title = "Dashboard";
$page_css[] = "global.css";
$page_css[] = "prettify.css";
include($SYSTEM['ikiosk_docroot'].'/smartui/inc/header.php');
include($SYSTEM['ikiosk_docroot'].'/smartui/inc/nav.php');
?>
<div id="iKioskMMWrapper">
<div id="main" role="main">
<?php include($SYSTEM['ikiosk_docroot']."/smartui/inc/ribbon.php"); ?>
<div id="content"></div>
</div>
<?php 
include($SYSTEM['ikiosk_docroot'].'/smartui/inc/footer.php');
?>
</div>
<?php 
include($SYSTEM['ikiosk_docroot']."/smartui/inc/scripts.php"); 
include($SYSTEM['ikiosk_docroot']."/smartui/inc/google-analytics.php"); 
?>
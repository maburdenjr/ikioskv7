<?php
/* iKiosk 7.0 Tiger */
$PAGE['application_code'] = "IKIOSK";
require('ikiosk-tmp-core'); // Load iKiosk Core Files

$activeUser = cmsInlineCheck();
if ($activeUser == "No") {
	header("Location: ".$SITE['site_url']."/cms/login.php");
} else {
	header("Location: ".$SYSTEM['system_url']."/ikiosk/index.php#webapps/cms/dashboard.php");
}
?>

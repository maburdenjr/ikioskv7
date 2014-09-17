<?php
if (isset($_GET['panel'])) {
	switch($_GET['panel']) {
		case "insertImage":
			$actionFile = "admin-inlinePhotos.php";
			break;
		case "codeSnippet":
			$actionFile = "admin-inlineSnippet.php";
			break;						
	}
	include($SYSTEM['ikiosk_filesystem_root']."/ikiosk/webapps/cms/".$actionFile);
} // Wrapper
?>

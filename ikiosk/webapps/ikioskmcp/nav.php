<?php
//Navigation File
$page_nav["ikioskmcp"] = array(
	"title" => "iKiosk MCP",
	"url" => "webapps/ikioskmcp/index.php",
	"icon" => "fa-cogs",
		"sub" => array(
			"sites" => array(
				"title" => "iKioskCloud Sites",
				"url" => "webapps/ikioskmcp/cloudSites.php"
			),
			"dbupdate" => array(
				"title" => "Database Updates",
				"url" => "webapps/cms/dbUpdates.php"
			),
			"software" => array(
				"title" => "Software Packages",
				"url" => "webapps/cms/softwarePackages.php"
			),
			"licenses" => array(
				"title" => "License Management",
				"url" => "webapps/cms/licenses.php"
			),
			"codebase" => array(
				"title" => "Update Codebase",
				"url" => "webapps/cms/updateCodebase.php"
			)
		)
)
?>
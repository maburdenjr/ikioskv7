<?php
//Navigation File
//Navigation File
$app_shortcuts["ikioskmcp"] = array(
	"packages" => array(
		"title" => "Software Packages",
		"url" => "webapps/ikioskmcp/softwarePackages.php",
		"icon" => "fa-briefcase",
		"tile" => "bg-color-teal"
	),
	"cloudsites" => array(
		"title" => "iKioskCloud Sites",
		"url" => "webapps/ikioskmcp/cloudSites.php",
		"icon" => "fa-sitemap",
		"tile" => "bg-color-pinkDark"
	),
	"users" => array(
		"title" => "Licenses",
		"url" => "webapps/ikioskmcp/licenses.php",
		"icon" => "fa-cloud-download",
		"tile" => "bg-color-green"
	)
	
);

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
				"url" => "webapps/ikioskmcp/dbUpdates.php"
			),
			"software" => array(
				"title" => "Software Packages",
				"url" => "webapps/ikioskmcp/softwarePackages.php"
			),
			"licenses" => array(
				"title" => "License Management",
				"url" => "webapps/ikioskmcp/licenses.php"
			),
			"codebase" => array(
				"title" => "Update Codebase",
				"url" => "webapps/ikioskmcp/updateCodebase.php"
			)
		)
)
?>
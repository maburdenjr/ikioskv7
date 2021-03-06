<?php
//Navigation File
$app_shortcuts["admin"] = array(
	"applications" => array(
		"title" => "Applications",
		"url" => "webapps/admin/applications.php",
		"icon" => "fa-codepen",
		"tile" => "bg-color-blue"
	),
	"sysconfig" => array(
		"title" => "iKiosk Config",
		"url" => "webapps/admin/sysConfig.php",
		"icon" => "fa-cogs",
		"tile" => "bg-color-orangeDark"
	),
	"users" => array(
		"title" => "Users",
		"url" => "webapps/admin/users.php",
		"icon" => "fa-users",
		"tile" => "bg-color-blueDark"
	)
	
);

$page_nav["admin"] = array(
	"title" => "Administration",
	"url" => "webapps/admin/index.php",
	"icon" => "fa-wrench",
	"sub" => array(
		"applications" => array(
			"title" => "Applications",
			"url" => "webapps/admin/applications.php",
		),
		"error" => array(
			"title" => "Error Codes",
			"url" => "webapps/admin/errorCodes.php"
		),
		"sites" => array(
			"title" => "Sites",
			"url" => "webapps/admin/sites.php"
		),
		"config" => array(
			"title" => "System Configuration",
			"url" => "webapps/admin/sysConfig.php",
			"url_target"=> "modal"
		),
		"teams" => array(
			"title" => "Teams",
			"url" => "webapps/admin/teams.php"
		),
		"users" => array(
			"title" => "Users",
			"url" => "webapps/admin/users.php"
		),
		"logs" => array(
			"title" => "Logging",
			"url" => "webapps/admin/accessLogs.php",
			"sub" => array (
				"access" => array(
					"title" => "Access Logs",
					"url" => "webapps/admin/accessLogs.php"
				),
				"errorlogs" => array(
					"title" => "Error Logs",
					"url" => "webapps/admin/errorLogs.php"
				),
				"mysql" => array(
					"title" => "MySQL Logs",
					"url" => "webapps/admin/mysqlLogs.php"
				)
			)
		),
		"advanced" => array(
			"title" => "Advanced Tools",
			"url" => "webapps/admin/softwareUpdates.php",
			"sub" => array (
				"phpmyadmin" => array(
						"title" => "phpMyAdmin",
						"url" => $SYSTEM['html_root']."/ikiosk/webapps/phpmyadmin/index.php",
						"url_target"=> "_blank"
				),
				"querybuilder" => array(
					"title" => "Code Generator",
					"url" => "webapps/admin/codeGenerator.php"
				),
				"updates" => array(
					"title" => "Software Updates",
					"url" => "webapps/admin/softwareUpdates.php"
				),
				"backups" => array(
					"title" => "Database Backups",
					"url" => "webapps/admin/dbBackups.php"
				)
			)
		)
	) 
)
?>
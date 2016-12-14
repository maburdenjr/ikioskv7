<?php
//Navigation File
$app_shortcuts["cerebro"] = array(
	"grindr" => array(
		"title" => "Grindr",
		"url" => "webapps/cerebro/grindr.php",
		"icon" => "fa-briefcase",
		"tile" => "bg-color-teal"
	),
	"jackd" => array(
		"title" => "Jackd",
		"url" => "webapps/cerebro/jackd.php",
		"icon" => "fa-sitemap",
		"tile" => "bg-color-pinkDark"
	),
	"scruff" => array(
		"title" => "Scruff",
		"url" => "webapps/cerebro/scruff.php",
		"icon" => "fa-cloud-download",
		"tile" => "bg-color-green"
	)

);

$page_nav["cerebro"] = array(
	"title" => "Cerebro Archives",
	"url" => "webapps/cerbero/index.php",
	"icon" => "fa-cogs",
		"sub" => array(
			"grindr" => array(
				"title" => "Grindr",
				"url" => "webapps/cerebro/grindr.php"
			),
			"jackd" => array(
				"title" => "Database Updates",
				"url" => "webapps/cerebro/jackd.php"
			),
			"scruff" => array(
				"title" => "Software Packages",
				"url" => "webapps/cerebro/scruff.php"
			)
		)
)
?>

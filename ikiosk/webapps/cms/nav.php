<?php
//Navigation File
$app_shortcuts["cms"] = array(
	"pages" => array(
		"title" => "Content Pages",
		"url" => "webapps/cms/pages.php",
		"icon" => "fa-file-text-o",
		"tile" => "bg-color-purple"
	),
	"photos" => array(
		"title" => "Photos",
		"url" => "webapps/cms/photos.php",
		"icon" => "fa-image",
		"tile" => "bg-color-greenLight"
	),
	"users" => array(
		"title" => "File Manager",
		"url" => "webapps/cms/fileManager.php",
		"icon" => "fa-folder-open-o",
		"tile" => "bg-color-blueDark"
	)
	
);


$page_nav["cms"] = array(
	"title" => "CMS",
	"url" => "webapps/cms/index.php",
	"icon" => "fa-desktop",
		"sub" => array(
			"blog" => array(
				"title" => "Blog",
				"url" => "webapps/cms/blog.php"
			),
			"pages" => array(
				"title" => "Content Pages",
				"url" => "webapps/cms/pages.php"
			),
			"snippets" => array(
				"title" => "Code Snippets",
				"url" => "webapps/cms/snippets.php"
			),
			"files" => array(
				"title" => "File Manager",
				"url" => "webapps/cms/fileManager.php"
			),
			"photos" => array(
				"title" => "Photos",
				"url" => "webapps/cms/photos.php"
			),
			"settings" => array(
				"title" => "Settings",
				"url" => "webapps/cms/settings.php"
			),
			"templates" => array(
				"title" => "Templates",
				"url" => "webapps/cms/templates.php"
			),
			"videos" => array(
				"title" => "Videos",
				"url" => "webapps/cms/videos.php"
			)
		)
)
?>
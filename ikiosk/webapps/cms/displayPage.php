<?php
// Publish Date
$currentDate = time();
$displayPage = "Yes";
if ((empty($_GET['page'])) && (!empty($row_getPage['publish_date']))) {
	$publishDate = strtotime($row_getPage['publish_date']);	
	if ($currentDate < $publishDate) { $displayPage = "No"; }
}

//Auto Expire
if ((empty($_GET['page'])) && (!empty($row_getPage['expiration_date'])) && ($row_getPage['auto_expire'] == "Yes")) {
	$expireDate = strtotime($row_getPage['expiration_date']);	
	if ($currentDate > $expireDate) { $displayPage = "No"; }
}
?>
<?php if ($displayPage == "Yes") { ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php v7ContentProcessor("page:title"); ?></title>
<?php if (!empty($row_getPage['meta_author'])) { ?>
<meta name="author" content="<?php echo $row_getPage['meta_author']; ?>">
<?php } ?>
<?php if (!empty($row_getPage['meta_cache_control'])) { ?>
<meta http-equiv="Cache-control" content="<?php echo $row_getPage['meta_cache_control']; ?>">
<?php } ?>
<?php if (!empty($row_getPage['meta_description'])) { ?>
<meta name="description" content="<?php echo $row_getPage['meta_description']; ?>">
<?php } ?>
<?php if (!empty($row_getPage['meta_keywords'])) { ?>
<meta name="keywords" content="<?php echo $row_getPage['meta_keywords']; ?>">
<?php } ?>
<?php if (!empty($row_getPage['meta_robots'])) { ?>
<meta name="robots" content="<?php echo  $row_getPage['meta_robots']; ?>">
<?php v7ContentProcessor($row_getTemplate['header_code']); ?>
<?php } ?>
</head>
<body<?php if (!empty($row_getPage['content_id'])) { echo " id=\"".v7ContentProcessor("page:content_id")."\"";} ?>>
<?php if ($SITE['site_status'] == "Active") { //Site is Active ?>

		<!--  Template Body Header -->
    <?php v7ContentProcessor($row_getTemplate['body_header_code']); ?>
    <!--  Template Page Content -->
    <?php v7ContentProcessor($row_getPage['content']); ?>
    <!--  Template Body Footer -->
    <?php v7ContentProcessor($row_getTemplate['body_footer_code']); ?>
    
<?php } else { echo $SITE['site_status_message']; }  // Site is Active ?>
</body>
</html>
<?php } ?>
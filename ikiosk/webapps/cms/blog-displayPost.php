<?php
$assetUrl = $SYSTEM['system_url']."/ikiosk/smartui/"; 
$timePosted = timezoneProcess($row_getPage['date_created'], "return");
$author = getUserData($row_getPage['created_by'], "display_name");
?>
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
<title><?php echo $row_getPage['title']." - ".$CMS['blog_title']; ?></title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- CMS Editor Scripts -->
<script> if (!window.jQuery) { document.write('<script src="<?php echo $assetUrl; ?>js/libs/jquery-2.0.2.min.js"><\/script>');} </script>
<script> if (!window.jQuery.ui) { document.write('<script src="<?php echo $assetUrl; ?>js/libs/jquery-ui-1.10.3.min.js"><\/script>');} </script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<?php v7ContentProcessor($row_getTemplate['header_code']); ?>
</head>
<body>
<?php if ($SITE['site_status'] == "Active") { //Site is Active ?>

<!--  Template Body Header -->
<?php v7ContentProcessor($row_getTemplate['body_header_code']); ?>
<article id="<?php echo $row_getPage['article_id']; ?>">
  <header>
    <h1><?php echo $row_getPage['title']; ?></h1>
    <p>Posted on <?php echo $timePosted." by ".$author; ?></p>
  </header>
  <section> 
    <!--  Template Page Content -->
    <?php v7ContentProcessor($row_getPage['content']); ?>
  </section>
</article>
<!--  Template Body Footer -->
<?php v7ContentProcessor($row_getTemplate['body_footer_code']); ?>
<?php } else { echo $SITE['site_status_message']; }  // Site is Active ?>
</body>
</html>
<?php } ?>
<?php
$assetUrl = $SYSTEM['system_url']."/ikiosk/smartui/"; 
$timePosted = timezoneProcess($row_getPage['date_created'], "return");
$author = getUserData($row_getPage['created_by'], "display_name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $CMS['blog_title']; ?></title>
<?php v7ContentProcessor($row_getTemplate['header_code']); ?>
</head>
<body>
<?php if ($SITE['site_status'] == "Active") { //Site is Active ?>
<?php v7ContentProcessor($row_getTemplate['body_header_code']); ?>
<?php do {
	$displayPage = 	cmsPublishCheckBlog($row_getPage['article_version_id']);
	if ($displayPage == "Yes"){	
	
	$timePosted = timezoneProcess($row_getPage['date_modified'], "return");
	$author = getUserData($row_getPage['modified_by'], "display_name");
?>
<article id="<?php echo $row_getPage['article_id']; ?>">
  <header>
    <h1><a href="/blog/articles/<?php echo $row_getPage['permalink_filename']; ?>"><?php echo $row_getPage['title']; ?></a></h1>
    <p>Posted on <?php echo $timePosted." by ".$author; ?></p>
  </header>
  <section>
    <?php v7ContentProcessor($row_getPage['content']); ?>
  </section>
</article>
<?php } } while ($row_getPage = mysql_fetch_assoc($getPage)); ?>
<?php v7ContentProcessor($row_getTemplate['body_footer_code']); ?>
<?php } ?>
</body>
</html>
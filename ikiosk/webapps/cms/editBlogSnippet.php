<?php 
$assetUrl = $SYSTEM['system_url']."/ikiosk/smartui/"; 
$timePosted = timezoneProcess($row_getPage['date_modified'], "return");
$author = getUserData($row_getPage['created_by'], "modified_by");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php v7ContentProcessor("page:title"); ?> - iKioskCMS Editor</title>
<script> if (!window.jQuery) { document.write('<script src="<?php echo $assetUrl; ?>js/libs/jquery-2.0.2.min.js"><\/script>');} </script>
<script> if (!window.jQuery.ui) { document.write('<script src="<?php echo $assetUrl; ?>js/libs/jquery-ui-1.10.3.min.js"><\/script>');} </script> 
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $assetUrl; ?>css/redactor.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $assetUrl; ?>css/iKioskUI.css">
<!-- Template Head -->
<?php v7ContentProcessor($row_getTemplate['header_code']); ?>
<body<?php if (!empty($row_getPage['content_id'])) { echo " id=\"".v7ContentProcessor("page:content_id")."\"";} ?>>

<!-- Template Header Code -->
<?php v7ContentProcessor($row_getTemplate['body_header_code']); ?>
<!-- Page Display -->
<div id = "iKioskCMSdisplay">
<article id="<?php echo $row_getPage['article_id']; ?>">
  <header>
    <h1><?php echo $row_getPage['title']; ?></h1>
    <p>Posted on <?php echo $timePosted." by ".$author; ?></p>
  </header>
  <section>
    <?php v7ContentProcessor($row_getPage['content']); ?>
  </section>
</article>
</div>
<?php include($systemFileRoot."/ikiosk/webapps/cms/admin-editor-blog.php"); ?>
<!-- Template Footer Code -->
<?php v7ContentProcessor($row_getTemplate['body_footer_code']); ?>

<form id="ikiosk_keys" name="ikiosk_keys" style="display:none;">
	<input name="site_url" class="site_url" type="hidden" value="<?php echo $SITE['site_url']; ?>">
  <input name="current_page" class="current_page" type="hidden" value="<?php echo $SYSTEM['current_page']; ?>">
  <input name="template_id" class="template_id" type="hidden" value="<?php echo $row_getTemplate['template_id']; ?>">
</form>
 <!-- CMS Editor Scripts --> 
<script src="<?php echo $assetUrl; ?>js/plugin/jquery-validate/jquery.validate.min.js"></script>  
<script src="<?php echo $assetUrl; ?>js/redactor.js"></script>
<script src="<?php echo $assetUrl; ?>js/tabifier.js"></script>
<script src="/cms/iKioskCMSEditMode.js"></script>
</body>
</html>

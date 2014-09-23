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
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title><?php echo $CMS['blog_title']; ?>- iKioskCMS Editor</title>
<!-- Template Head -->
<?php v7ContentProcessor($row_getTemplate['header_code']); ?>
<!-- CMS Editor CSS -->
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $assetUrl; ?>css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $assetUrl; ?>css/smartadmin-cms.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $assetUrl; ?>css/redactor.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $assetUrl; ?>css/prettify.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $assetUrl; ?>css/iKioskUI.css">
<link rel="shortcut icon" href="<?php echo $assetUrl; ?>img/favicon/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo $assetUrl; ?>img/favicon/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
</head>
<body>
<!-- CMS Header -->
<div id ="iKioskCMSheader" class="ikiosk-cms-editor">
  <?php include($SYSTEM['ikiosk_filesystem_root']."/ikiosk/webapps/cms/admin-blog-header.php"); ?>
</div>
<div id ="iKioskCMSwrapper">
  <div id="iKioskCMSContent"> 
    <!-- Template Header Code -->
    <?php v7ContentProcessor($row_getTemplate['body_header_code']); ?>
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

    <?php v7ContentProcessor($row_getTemplate['body_footer_code']); ?>
  </div>
  <div id="iKioskCMSInlineEditor" class="ikiosk-cms-editor">
    <?php include ($systemFileRoot."/ikiosk/webapps/cms/admin-cmsEditPanel.php"); ?>
  </div>
</div>
<div id="iKioskCMSmodals" class="ikiosk-cms-editor">
  <?php if ($SYSTEM['debug'] == "Yes") { include ($systemFileRoot."/ikiosk/webapps/admin/systemDebug.php"); } ?>
  <div class="modal fade" id="dynamicModal">
    <div class="modal-dialog">
      <div class="modal-content"> </div>
    </div>
  </div>
</div>
<form id="ikiosk_keys" name="ikiosk_keys" style="display:none;">
  <input name="site_url" class="site_url" type="hidden" value="<?php echo $SITE['site_url']; ?>">
  <input name="current_page" class="current_page" type="hidden" value="<?php echo $SYSTEM['current_page']; ?>">
  <input name="template_id" class="template_id" type="hidden" value="<?php echo $row_getTemplate['template_id']; ?>">
</form>
<!-- CMS Editor Scripts --> 
<script> if (!window.jQuery) { document.write('<script src="<?php echo $assetUrl; ?>js/libs/jquery-2.0.2.min.js"><\/script>');} </script> 
<script> if (!window.jQuery.ui) { document.write('<script src="<?php echo $assetUrl; ?>js/libs/jquery-ui-1.10.3.min.js"><\/script>');} </script> 
<script src="<?php echo $assetUrl; ?>js/bootstrap/bootstrap.min.js"></script> 
<script src="<?php echo $assetUrl; ?>js/notification/SmartNotification.min.js"></script> 
<script src="<?php echo $assetUrl; ?>js/smartwidgets/jarvis.widget.min.js"></script> 
<script src="<?php echo $assetUrl; ?>js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script> 
<script src="<?php echo $assetUrl; ?>js/plugin/sparkline/jquery.sparkline.min.js"></script> 
<script src="<?php echo $assetUrl; ?>js/plugin/jquery-validate/jquery.validate.min.js"></script> 
<script src="<?php echo $assetUrl; ?>js/plugin/masked-input/jquery.maskedinput.min.js"></script> 
<script src="<?php echo $assetUrl; ?>js/plugin/select2/select2.min.js"></script> 
<script src="<?php echo $assetUrl; ?>js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script> 
<script src="<?php echo $assetUrl; ?>js/plugin/msie-fix/jquery.mb.browser.min.js"></script> 
<script src="<?php echo $assetUrl; ?>js/plugin/fastclick/fastclick.min.js"></script> 
<script src="<?php echo $assetUrl; ?>js/plugin/slimscroll/jquery.slimscroll.min.js"></script> 
<script src="<?php echo $assetUrl; ?>js/plugin/datatables/jquery.dataTables.min.js"></script> 
<script src="<?php echo $assetUrl; ?>js/plugin/datatables/dataTables.colVis.min.js"></script> 
<script src="<?php echo $assetUrl; ?>js/plugin/datatables/dataTables.tableTools.min.js"></script> 
<script src="<?php echo $assetUrl; ?>js/plugin/datatables/dataTables.bootstrap.min.js"></script> 
<script src="<?php echo $assetUrl; ?>js/app.min.js"></script> 
<script src="<?php echo $assetUrl; ?>js/freeformatter.js"></script> 
<script src="<?php echo $assetUrl; ?>js/redactor.js"></script> 
<script src="<?php echo $assetUrl; ?>js/tabifier.js"></script> 
<script src="<?php echo $assetUrl; ?>js/plugin/superbox/superbox.cms.js"></script> 
<script src="/cms/iKioskCMS.js"></script> 
<script type="text/javascript">
   pageSetUp();
   iKioskUI();
</script>
</body>

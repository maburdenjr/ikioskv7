<?php 
	$assetUrl = $SYSTEM['system_url']."/ikiosk/smartui/"; 
	if($_GET['mode'] != "edit") {
			if (!empty($_GET['page'])) { $pageFilter = "&page=".$_GET['page']; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title><?php v7ContentProcessor("page:title"); ?> - iKioskCMS Editor</title>
<script> if (!window.jQuery) { document.write('<script src="<?php echo $assetUrl; ?>js/libs/jquery-2.0.2.min.js"><\/script>');} </script>
<script> if (!window.jQuery.ui) { document.write('<script src="<?php echo $assetUrl; ?>js/libs/jquery-ui-1.11.0.min.js"><\/script>');} </script> 
<!-- CMS Editor CSS -->
<link rel="stylesheet" type="text/css" media="screen" href="//maxcdn.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
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
<?php include($SYSTEM['ikiosk_filesystem_root']."/ikiosk/webapps/cms/admin-header.php"); ?>
</div>
<div id ="iKioskCMSwrapper">
	<div id="iKioskCMSContent">
  	<iframe id="editorFrame" src="<?php echo $row_getPage['static_folder'].$row_getPage['static_file']; ?>?mode=edit<?php echo $pageFilter; ?>"></iframe>     
  </div>
  <div id="iKioskCMSInlineEditor" class="ikiosk-cms-editor">
  	<?php include ($systemFileRoot."/ikiosk/webapps/cms/admin-cmsEditPanel.php"); ?>
  </div>
</div>
<div id="iKioskCMSmodals" class="ikiosk-cms-editor">
<?php if ($SYSTEM['debug'] == "Yes") { include ($systemFileRoot."/ikiosk/webapps/admin/systemDebug.php"); } ?>
  <div class="modal fade" id="dynamicModal">
    <div class="modal-dialog">
      <div class="modal-content">
      </div>
    </div>
  </div>
</div> 
<form id="ikiosk_keys" name="ikiosk_keys" style="display:none;">
	<input name="site_url" class="site_url" type="hidden" value="<?php echo $SITE['site_url']; ?>">
  <input name="current_page" class="current_page" type="hidden" value="<?php echo $SYSTEM['current_page']; ?>">
  <input name="template_id" class="template_id" type="hidden" value="<?php echo $row_getTemplate['template_id']; ?>">
</form>
 <!-- CMS Editor Scripts --> 
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script> 
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
<script src="<?php echo $assetUrl; ?>js/app.cms.min.js"></script>
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
</html>
<?php } else { 	include($SYSTEM['ikiosk_filesystem_root']."/ikiosk/webapps/cms/editPageSnippet.php");	 } ?>
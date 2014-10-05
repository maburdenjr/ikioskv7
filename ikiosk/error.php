<?php
/* iKiosk 7.0 Tiger */
$PAGE['application_code'] = "IKIOSK";
require('includes/core/ikiosk.php');
$assetUrl = $SYSTEM['system_url']."/ikiosk/smartui/";

mysql_select_db($database_ikiosk, $ikiosk);
$query_getErrorInfo = "SELECT * FROM sys_errors WHERE error_id = '".$_GET['error']."' AND deleted='0'";
$getErrorInfo = mysql_query($query_getErrorInfo, $ikiosk) or sqlError(mysql_error());
$row_getErrorInfo = mysql_fetch_assoc($getErrorInfo);
$totalRows_getErrorInfo = mysql_num_rows($getErrorInfo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Login -<?php echo $SYSTEM['system_name']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" type="text/css" media="screen" href="//maxcdn.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $assetUrl; ?>css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $assetUrl; ?>css/smartadmin-production.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $assetUrl; ?>css/lockscreen.min.css">
<link rel="shortcut icon" href="<?php echo $assetUrl; ?>img/favicon/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo $assetUrl; ?>img/favicon/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
<style t	ype="text/css">
#cmsUILogin .btn {
	padding: 6px 12px;
}
#cmsUILogin input[type="text"], #cmsUILogin input[type="password"] {
	padding-left: 10px;
	background: #FFF;
}
</style>
</head>
<body>
<div id="main" role="main">
  <form id="cmsUILogin" class="lockscreen animated flipInY smart-form" method="post">
    <div class="logo">
      <h1 class="semi-bold"><img src="<?php echo $assetUrl; ?>img/logo-o.png" alt="" /> IntelliKiosk</h1>
    </div>
    <div> <img src="<?php echo $assetUrl; ?>img/avatars/sunny-big.png" alt="" width="120" height="120" />
      <div>
        <h1 style="padding-bottom:10px;"><i class="fa fa-user fa-3x text-muted air air-top-right hidden-mobile"></i><?php echo $SYSTEM['system_name']; ?><small><i class="fa fa-lock text-muted"></i> &nbsp;Locked</small></h1>
        <div class="form-response"></div>
        <?php if (!empty($_GET['error'])) { ?>
        <section>
          <div class="alert alert-danger fade in">
            <button class="close" data-dismiss="alert">×</button>
            <i class="fa-fw fa fa-times"></i><strong><?php echo $row_getErrorInfo['error_title']; ?>:</strong> <?php echo $row_getErrorInfo['error_description']; ?> </div>
        </section>
        <?php } ?>
        <section>
          <label class="input" style="margin-bottom:5px;">
            <input name= "loginemail" class="form-control" type="text" placeholder="Email Address">
            <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter email address/username</b> </label>
        </section>
        <section>
          <label class="input">
            <input name="password" class="form-control" type="password" placeholder="Password">
            <b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your password</b> </label>
        </section>
        <div class="pull-right">
          <button class="btn btn-primary">Login </button>
        </div>
      </div>
    </div>
    <input type="hidden" name="ikioskSubmit" value="MasterLogin" />
  </form>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> 
<script> if (!window.jQuery) { document.write('<script src="<?php echo $assetUrl; ?>js/libs/jquery-2.0.2.min.js"><\/script>');} </script 
><script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script> 
<script> if (!window.jQuery.ui) { document.write('<script src="<?php echo $assetUrl; ?>js/libs/jquery-ui-1.11.0.min.js"><\/script>');} </script> 
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
<script src="<?php echo $assetUrl; ?>js/app.min.js"></script> 
<script type="text/javascript">
	runAllForms();
	$(function() {
		// Validation
		$("#cmsUILogin").validate({
			// Rules for form validation
			rules : {
				loginemail : {
					required : true,
					email : true
				},
				password : {
					required : true,
					minlength : 3,
					maxlength : 20
				}
			},

			// Messages for form validation
			messages : {
				loginemail : {
					required : 'Please enter your email address',
					email : 'Please enter a VALID email address'
				},
				password : {
					required : 'Please enter your password'
				}
			},

			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});
	});
</script>
</body>
</html>
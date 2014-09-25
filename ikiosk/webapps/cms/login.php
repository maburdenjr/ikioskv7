<?php
/* iKiosk 7.0 Tiger */
$PAGE['application_code'] = "IKIOSK";
require('ikiosk-tmp-core'); // Load iKiosk Core Files

$SITE['site_id'] = "ikiosk_tmp_site";

//Load Site Properties
mysql_select_db($database_ikiosk, $ikiosk);
$query_getSite = "SELECT * FROM sys_sites WHERE site_id = '".$SITE['site_id']."' AND deleted = '0'";
$getSite = mysql_query($query_getSite, $ikiosk) or sqlError(mysql_error());
$SITE =  mysql_fetch_assoc($getSite);
$totalRows_getSite = mysql_num_rows($getSite);

$assetUrl = $SYSTEM['system_url']."/ikiosk/smartui/";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Login - <?php echo $SITE['site_name']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" type="text/css" media="screen" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $assetUrl; ?>css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $assetUrl; ?>css/smartadmin-production.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $assetUrl; ?>css/lockscreen.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="/cms/iKioskUI.css">
<link rel="shortcut icon" href="<?php echo $assetUrl; ?>img/favicon/favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo $assetUrl; ?>img/favicon/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">
</head>
<body>
<div id="main" role="main"> 
  
  <!-- MAIN CONTENT -->
  
  <form id="cmsUILogin" class="lockscreen animated flipInY smart-form" method="post">
    <div class="logo">
      <h1 class="semi-bold"><img src="<?php echo $assetUrl; ?>img/logo-o.png" alt="" /> iKioskCMS</h1>
    </div>
    <div> <img src="<?php echo $assetUrl; ?>img/avatars/sunny-big.png" alt="" width="120" height="120" />
      <div>
        <h1 style="padding-bottom:10px;"><i class="fa fa-user fa-3x text-muted air air-top-right hidden-mobile"></i><?php echo $SITE['site_name']; ?><small><i class="fa fa-lock text-muted"></i> &nbsp;Locked</small></h1>
        <div class="form-response"></div>
        <section>
        <label class="input" style="margin-bottom:5px;">
          <input name= "login_email" class="form-control" type="text" placeholder="Email Address">
        </label>
        </section>
        <section>
        <label class="input">
          <input name="password" class="form-control" type="password" placeholder="Password">
        </label>
        </section>
        <div class="pull-right">
          <button class="btn btn-primary btn-ajax-submit" data-form="cmsUILogin">Login </button>
        </div>
      </div>
    </div>
    <p class="font-xs margin-top-5"> Powered By IntelliKiosk</p>
    <input type="hidden" name="formID" value="cmsUILogin">
    <input type="hidden" name="iKioskForm" value="Yes" />
    <input type="hidden" name="appCode" value="IKIOSK" />
  </form>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script> 
<script> if (!window.jQuery) { document.write('<script src="<?php echo $assetUrl; ?>js/libs/jquery-2.0.2.min.js"><\/script>');} </script 
><script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script> 
<script> if (!window.jQuery.ui) { document.write('<script src="<?php echo $assetUrl; ?>js/libs/jquery-ui-1.10.3.min.js"><\/script>');} </script> 
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> 
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
<script src="<?php echo $assetUrl; ?>js/app.cms.min.js"></script>
<script src="/cms/iKioskCMS.js"></script>
<script type="text/javascript">
   pageSetUp();
  
   
   $(function() {
       $("#cmsUILogin").validate({
           rules : {
          	login_email : {
							required : true
						},
						password : {
							required : true
						}
					},
					
					messages : {
						login_email : {
							required : 'Please enter your login email'
						},
						password : {
							required : 'Please enter your password'	
						}
					},
					
          errorPlacement : function(error, element) {
          	error.insertAfter(element.parent());
          },
          submitHandler: function(form) {
          	var targetForm = $(this.currentForm).attr("id");
             submitAjaxForm(targetForm);
           }
       });
   });
</script>
</body>
</html>

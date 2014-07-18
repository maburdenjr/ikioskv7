<?php
/* iKiosk 7.0 Tiger */
$PAGE['application_code'] = "IKIOSK";

require('includes/core/ikiosk.php');
require($SYSTEM['ikiosk_docroot'].'/smartui/inc/init.php');
require($SYSTEM['ikiosk_docroot'].'/smartui/inc/config.ui.php');

$page_title = "Login";
$page_css[] = "global.css";
$no_main_header = true;
$page_body_prop = array("id"=>"extr-page", "class"=>"animated fadeInDown");
include($SYSTEM['ikiosk_docroot'].'/smartui/inc/header.php');
?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- possible classes: minified, no-right-panel, fixed-ribbon, fixed-header, fixed-width-->
<header id="header">
	<!--<span id="logo"></span>-->

	<div id="logo-group">
		<span id="logo"> <img src="<?php echo ASSETS_URL; ?>/img/logo.png" alt="SmartAdmin"> </span>

		<!-- END AJAX-DROPDOWN -->
	</div>

</header>

<div id="main" role="main">

	<!-- MAIN CONTENT -->
	<div id="content" class="container">

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<div class="well no-padding">
					<form action="<?php $SYSTEM['current_page']; ?>" id="login-form" class="smart-form client-form" method="post">
						<header>
							<?php echo $SYSTEM['system_name']; ?>
						</header>

						<fieldset>
							<section>
								<label class="label">E-mail</label>
								<label class="input"> <i class="icon-append fa fa-user"></i>
									<input type="email" name="loginemail">
									<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Please enter email address/username</b></label>
							</section>

							<section>
								<label class="label">Password</label>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
									<input type="password" name="password">
									<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Enter your password</b> </label>
							</section>

							
						</fieldset>
						<footer>
							<button type="submit" class="btn btn-primary">
								Log in
							</button>
             <input type="hidden" name="ikioskSubmit" value="MasterLogin" />
						</footer>
					</form>

				</div>
			</div>
		</div>
	</div>

</div>
<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->

<?php 
include($SYSTEM['ikiosk_docroot'].'/smartui/inc/scripts.php'); 
?>
<script type="text/javascript">
	runAllForms();

	$(function() {
		// Validation
		$("#login-form").validate({
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
<?php
include($SYSTEM['ikiosk_docroot'].'/smartui/inc/google-analytics.php'); 
?>

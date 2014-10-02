<?php
if ($_GET['option'] == "folderList") {
	
		$PAGE['application_code'] = "IKIOSK";
		require('../../../ikiosk/includes/core/ikiosk.php'); 
	
		$thisPath = realpath(dirname(__FILE__));
		$directoryArray = directoryToArray($thisPath, $recursive);
		sort($directoryArray);
		$fileList = "/unify[iKiosk]";
		foreach ($directoryArray as $key => $value) {
		$value = str_replace($SYSTEM['ikiosk_filesystem_root']."/system/cms_templates", "", $value);
		$fileList .= $value."[iKiosk]";
		}
		echo $fileList;
}
?>
<?php 
// Template List
if ($_GET['option'] == "templateList") {	
$templates = array();
$templates[0]['title'] = 'Unify';
$templates[0]['header_code'] = '
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- CSS Global Compulsory -->
    <link rel="stylesheet" href="/templates/unify/assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/templates/unify/assets/css/style.css">

    <!-- CSS Theme -->    
    <link rel="stylesheet" href="/templates/unify/assets/css/themes/default.css" id="style_color">

    <!-- CSS Customization -->
    <link rel="stylesheet" href="/templates/unify/assets/css/custom.css">
		
	<!-- JS Global Compulsory -->			
	<script> if (!window.jQuery) { document.write(\'<script src="/templates/unify/assets/plugins/jquery-2.0.2.min.js"><\/script>\');} </script>
	<script type="text/javascript" src="/templates/unify/assets/plugins/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript" src="/templates/unify/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
	<!-- JS Implementing Plugins -->
	<script type="text/javascript" src="/templates/unify/assets/plugins/back-to-top.js"></script>
	<!-- JS Page Level -->           
	<script type="text/javascript" src="/templates/unify/assets/js/app.js"></script>
	<script type="text/javascript" src="/templates/unify/assets/js/pages/index.js"></script>
	<script type="text/javascript">
			jQuery(document).ready(function() {
					App.init();   
			});
	</script>
	<!--[if lt IE 9]>
			<script src="/templates/unify/assets/js/respond.js"></script>
			<script src="/templates/unify/assets/plugins/html5shiv.js"></script>    
	<![endif]-->
';
$templates[0]['body_header_code'] = '
<span class="ikiosk-cmsSnippet">snippet:template-unify-style-switcher</span>
<div class="wrapper">
<!--=== Header ===-->
<div class="header">
    <span class="ikiosk-cmsSnippet">snippet:template-unify-topbar-nav</span>
		<span class="ikiosk-cmsSnippet">snippet:template-unify-nav</span>
</div>
<!--=== End Header ===--> 
';
$templates[0]['body_footer_code'] = '
   	<span class="ikiosk-cmsSnippet">snippet:template-unify-footer</span>
		<span class="ikiosk-cmsSnippet">snippet:template-unify-copyright</span>

</div><!--/wrapper-->
';

/*
$templates[1]['title'] = 'Unify: One Page';
$templates[1]['header_code'] = '
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- CSS Global Compulsory -->
	<link rel="stylesheet" href="/templates/unify/One-Page/assets/plugins/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/templates/unify/One-Page/assets/css/style.css">

	<!-- CSS Implementing Plugins -->
	<link rel="stylesheet" href="/templates/unify/One-Page/assets/plugins/line-icons/line-icons.css">
	<link rel="stylesheet" href="/templates/unify/One-Page/assets/plugins/font-awesome/css/font-awesome.min.css">    
	<link rel="stylesheet" href="/templates/unify/One-Page/assets/plugins/pace/pace-flash.css">
	<link rel="stylesheet" href="/templates/unify/One-Page/assets/plugins/YTPlayer/css/YTPlayer.css">
	<link rel="stylesheet" href="/templates/unify/One-Page/assets/plugins/owl-carousel/owl-carousel/owl.carousel.css">    
	<link rel="stylesheet" href="/templates/unify/One-Page/assets/plugins/revolution-slider/examples-sources/rs-plugin/css/settings.css" type="text/css" media="screen">

	<!-- load css for cubeportfolio -->
	<link rel="stylesheet" type="text/css" href="/templates/unify/One-Page/assets/plugins/cbp-plugin/cubeportfolio/css/cubeportfolio.min.css">

	<!-- load main css for this page -->
	<link rel="stylesheet" type="text/css" href="/templates/unify/One-Page/assets/plugins/cbp-plugin/templates/lightbox-gallery/css/main.css">

	<!-- CSS Customization -->
	<link rel="stylesheet" href="/templates/unify/One-Page/assets/css/custom.css">
';
$templates[1]['body_header_code'] = '
	<span class="ikiosk-cmsSnippet">snippet:template-unify-onepage-nav</span>
';
$templates[1]['body_footer_code'] = '
	<!-- JS Global Compulsory -->
	<script> if (!window.jQuery) { document.write(\'<script src="/templates/unify/One-Page/assets/plugins/jquery-2.0.2.min.js"><\/script>\');} </script>
    <script type="text/javascript" src="/templates/unify/One-Page/assets/plugins/jquery-migrate-1.2.1.min.js"></script>    
    <script type="text/javascript" src="/templates/unify/One-Page/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- JS Implementing Plugins -->
    <script type="text/javascript" src="/templates/unify/One-Page/assets/plugins/jquery.easing.min.js"></script>
    <script type="text/javascript" src="/templates/unify/One-Page/assets/plugins/pace/pace.min.js"></script>
    <script type="text/javascript" src="/templates/unify/One-Page/assets/plugins/jquery.parallax.js"></script>
    <script type="text/javascript" src="/templates/unify/One-Page/assets/plugins/counter/waypoints.min.js"></script>
    <script type="text/javascript" src="/templates/unify/One-Page/assets/plugins/counter/jquery.counterup.min.js"></script>
    <script type="text/javascript" src="/templates/unify/One-Page/assets/plugins/owl-carousel/owl-carousel/owl.carousel.js"></script>    
    <script type="text/javascript" src="/templates/unify/One-Page/assets/plugins/revolution-slider/examples-sources/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
    <script type="text/javascript" src="/templates/unify/One-Page/assets/plugins/revolution-slider/examples-sources/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
    <!-- load caPortfolio plugin -->
    <script type="text/javascript" src="/templates/unify/One-Page/assets/plugins/cbp-plugin/cubeportfolio/js/jquery.cubeportfolio.min.js"></script>
    <!-- load main js -->
    <script type="text/javascript" src="/templates/unify/One-Page/assets/plugins/cbp-plugin/templates/lightbox-gallery/js/main.js"></script>

    <!-- JS Page Level-->
    <script type="text/javascript" src="/templates/unify/One-Page/assets/js/app.js"></script>
    <script type="text/javascript" src="/templates/unify/One-Page/assets/js/plugins/owl-carousel.js"></script>    
    <script type="text/javascript">
        jQuery(document).ready(function() {
						$("body").addClass("demo-lightbox-gallery");
						$("body").attr("id", "body");
						$("body").attr("data-spy", "scroll");
						$("body").attr("data-target", ".navbar-fixed-top");
            App.init();
            App.initCounter();
            App.initParallaxBg();
            OwlCarousel.initOwlCarousel();            
        });
    </script>

    <script type="text/javascript">
        var revapi;
        jQuery(document).ready(function() {
           revapi = jQuery(\'.fullscreenbanner\').revolution(
            {
                delay:15000,
                startwidth:1170,
                startheight:500,
                hideThumbs:10,
                fullWidth:"on",
                fullScreen:"on",
                dottedOverlay:"twoxtwo",
                fullScreenOffsetContainer: "",
            });
        });
    </script>

    <script type="text/javascript">
        paceOptions = {
          // Disable the \'elements\' source
          elements: false,

          // Only show the progress on regular and ajax-y page navigation,
          // not every request
          restartOnRequestAfter: false
        }
    </script>

    <!--[if lt IE 9]>
        <script src="/templates/unify/One-Page/assets/plugins/respond.js"></script>
        <script src="/templates/unify/One-Page/assets/plugins/html5shiv.js"></script>
    <![endif]-->  
'; */

	foreach($templates as $key=>$value) {
		echo $value['title']."--|--".$value['header_code']."--|--".$value['body_header_code']."--|--".$value['body_footer_code']."[iKiosk]";	
	}
}

//Snippet List
if ($_GET['option'] == "snippetList") {
	$snippets = array();	
	
	//Style Switcher
	$snippets[0]['id'] = "template-unify-style-switcher";
	$snippets[0]['title'] = "Unify: Style Switcher";
	$snippets[0]['category'] = "Miscellaneous";
	$snippets[0]['html'] = '<!--=== Style Switcher ===-->    
<i class="style-switcher-btn fa fa-cogs hidden-xs"></i>
<div class="style-switcher animated fadeInRight">
    <div class="theme-close"><i class="icon-close"></i></div>
    <div class="theme-heading">Theme Colors</div>
    <ul class="list-unstyled">
        <li class="theme-default theme-active" data-style="default" data-header="light"></li>
        <li class="theme-blue" data-style="blue" data-header="light"></li>
        <li class="theme-orange" data-style="orange" data-header="light"></li>
        <li class="theme-red" data-style="red" data-header="light"></li>
        <li class="theme-light last" data-style="light" data-header="light"></li>

        <li class="theme-purple" data-style="purple" data-header="light"></li>
        <li class="theme-aqua" data-style="aqua" data-header="light"></li>
        <li class="theme-brown" data-style="brown" data-header="light"></li>
        <li class="theme-dark-blue" data-style="dark-blue" data-header="light"></li>
        <li class="theme-light-green last" data-style="light-green" data-header="light"></li>
    </ul>
    <div style="margin-bottom:18px;"></div>
    <div class="theme-heading">Layouts</div>
    <div class="text-center">
        <a href="javascript:void(0);" class="btn-u btn-u-green btn-block active-switcher-btn wide-layout-btn">Wide</a>
        <a href="javascript:void(0);" class="btn-u btn-u-green btn-block boxed-layout-btn">Boxed</a>
    </div>
</div><!--/style-switcher-->
<!--=== End Style Switcher ===-->  
';

//Top Bar Navigation
	$snippets[1]['id'] = "template-unify-topbar-nav";
	$snippets[1]['title'] = "Unify: Top Bar Navigation";
	$snippets[1]['category'] = "Navigation";
	$snippets[1]['html'] = '<!-- Topbar -->
        <div class="topbar">
            <div class="container">
                <!-- Topbar Navigation -->
                <ul class="loginbar pull-right">
                    <li>
                        <i class="fa fa-globe"></i>
                        <a>Languages</a>
                        <ul class="lenguages">
                            <li class="active">
                                <a href="#">English <i class="fa fa-check"></i></a> 
                            </li>
                            <li><a href="#">Spanish</a></li>
                            <li><a href="#">Russian</a></li>
                            <li><a href="#">German</a></li>
                        </ul>
                    </li>
                    <li class="topbar-devider"></li>   
                    <li><a href="/templates/unify/page_faq.html">Help</a></li>  
                    <li class="topbar-devider"></li>   
                    <li><a href="/templates/unify/page_login.html">Login</a></li>   
                </ul>
                <!-- End Topbar Navigation -->
            </div>
        </div>
        <!-- End Topbar -->
';

//Top Bar Navigation
	$snippets[2]['id'] = "template-unify-nav";
	$snippets[2]['title'] = "Unify: Main Navigation";
	$snippets[2]['category'] = "Navigation";
	$snippets[2]['html'] = '<!-- Navbar -->
        <div class="navbar navbar-default" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="fa fa-bars"></span>
                    </button>
                    <a class="navbar-brand" href="/templates/unify/index.html">
                        <img id="logo-header" src="/templates/unify/assets/img/logo1-default.png" alt="Logo">
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-responsive-collapse">
                    <ul class="nav navbar-nav">
                        <!-- Home -->
                        <li class="dropdown active">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                                Home
                            </a>
                            <ul class="dropdown-menu">
                                <li class="active"><a href="/templates/unify/index.html">Option 1: Default Page</a></li>
                                <li><a target="_blank" href="/templates/unify/One-Page/index.html">Option 2: One Page Template</a></li>                                
                                <li><a href="/templates/unify/page_home1.html">Option 3: Layer Slider</a></li>
                                <li><a href="/templates/unify/page_home2.html">Option 4: Revolution Slider</a></li>
                                <li><a href="/templates/unify/page_home3.html">Option 5: Amazing Content</a></li>
                                <li><a href="/templates/unify/page_home4.html">Option 6: Home Sidebar</a></li>
                                <li><a href="/templates/unify/page_home5.html">Option 7: Home Flatty</a></li>
                                <li><a href="/templates/unify/page_home6.html">Option 8: Home Magazine</a></li>
                                <li><a href="/templates/unify/page_home7.html">Option 9: Home Portfolio</a></li>
                                <li><a href="/templates/unify/page_home8.html">Option 10: Home Discover</a></li>
                                <li><a href="/templates/unify/page_jobs.html">Option 11: Home Jobs</a></li>
                                <li><a href="/templates/unify/page_home9.html">Option 12: Home Boxed</a></li>
                                <li><a href="/templates/unify/page_home11.html">Option 13: Home Boxed Image</a></li>
                                <li><a href="/templates/unify/page_home10.html">Option 14: Home Fixed Menu</a></li>
                            </ul>
                        </li>
                        <!-- End Home -->

                        <!-- Pages -->                        
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                                Pages
                            </a>
                            <ul class="dropdown-menu">
                                <!-- About Pages -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">About Pages</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/page_about1.html">About Us</a></li>
                                        <li><a href="/templates/unify/page_about.html">About Basic</a></li>
                                        <li><a href="/templates/unify/page_about_me.html">About Me</a></li>
                                        <li><a href="/templates/unify/page_about_our_team.html">About Our Team</a></li>
                                    </ul>                                
                                </li>
                                <!-- End About Pages -->

                                <!-- Profile Pages -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Profile Dashboard Pages</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/profile.html">Profile Main Page</a></li>
                                        <li><a href="/templates/unify/profile_me.html">Profile Overview</a></li>
                                        <li><a href="/templates/unify/profile_users.html">Profile Users</a></li>
                                        <li><a href="/templates/unify/profile_projects.html">Profile Projects</a></li>
                                        <li><a href="/templates/unify/profile_comments.html">Profile Comments</a></li>
                                        <li><a href="/templates/unify/profile_history.html">Profile History</a></li>
                                        <li><a href="/templates/unify/profile_settings.html">Profile Settings</a></li>
                                    </ul>                                
                                </li>
                                <!-- End Profile Pages -->

                                <!-- Job Pages -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Job Pages</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/page_jobs.html">Jobs Main Page</a></li>                                
                                        <li><a href="/templates/unify/page_jobs_inner.html">Jobs Description Default</a></li>                                
                                        <li><a href="/templates/unify/page_jobs_inner1.html">Jobs Description Basic</a></li>                                
                                        <li><a href="/templates/unify/page_jobs_inner2.html">Jobs Description Min</a></li>                                
                                    </ul>                                
                                </li>
                                <!-- End Job Pages -->

                                <!-- Email Tempaltes -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Email Templates</a>
                                    <ul class="dropdown-menu">
                                        <li class="dropdown-submenu">
                                            <a href="javascript:void(0);">Email Corporate</a>
                                            <ul class="dropdown-menu">
                                                <li><a target="_blank" href="/templates/unify/email-templates/corporate/email_corporate_aqua.html">Corporate Aqua Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/corporate/email_corporate_blue.html">Corporate Blue Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/corporate/email_corporate_brown.html">Corporate Brown Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/corporate/email_corporate_dark_blue.html">Corporate Dark Blue Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/corporate/email_corporate_green.html">Corporate Green Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/corporate/email_corporate_light_green.html">Corporate Light Green Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/corporate/email_corporate_grey.html">Corporate Grey Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/corporate/email_corporate_orange.html">Corporate Orange Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/corporate/email_corporate_purple.html">Corporate Purple Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/corporate/email_corporate_red.html">Corporate Red Color</a></li>
                                            </ul>                                
                                        </li>
                                        <li class="dropdown-submenu">
                                            <a href="javascript:void(0);">Email Flat</a>
                                            <ul class="dropdown-menu">
                                                <li><a target="_blank" href="/templates/unify/email-templates/flat/email_flat_aqua.html">Flat Aqua Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/flat/email_flat_blue.html">Flat Blue Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/flat/email_flat_brown.html">Flat Brown Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/flat/email_flat_dark_blue.html">Flat Dark Blue Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/flat/email_flat_green.html">Flat Green Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/flat/email_flat_light_green.html">Flat Light Green Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/flat/email_flat_grey.html">Flat Grey Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/flat/email_flat_orange.html">Flat Orange Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/flat/email_flat_purple.html">Flat Purple Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/flat/email_flat_red.html">Flat Red Color</a></li>
                                            </ul>                                
                                        </li>
                                        <li class="dropdown-submenu">
                                            <a href="javascript:void(0);">Email Modern</a>
                                            <ul class="dropdown-menu">
                                                <li><a target="_blank" href="/templates/unify/email-templates/modern/email_modern_aqua.html">Modern Aqua Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/modern/email_modern_blue.html">Modern Blue Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/modern/email_modern_brown.html">Modern Brown Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/modern/email_modern_dark_blue.html">Modern Dark Blue Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/modern/email_modern_green.html">Modern Green Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/modern/email_modern_light_green.html">Modern Light Green Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/modern/email_modern_grey.html">Modern Grey Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/modern/email_modern_orange.html">Modern Orange Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/modern/email_modern_purple.html">Modern Purple Color</a></li>
                                                <li><a target="_blank" href="/templates/unify/email-templates/modern/email_modern_red.html">Modern Red Color</a></li>
                                            </ul>                                
                                        </li>
                                    </ul>                                
                                </li>

                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Service Pages</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/page_services.html">Our Services</a></li>
                                        <li><a href="/templates/unify/page_services1.html">Our Services Basic</a></li>
                                    </ul>                                
                                </li>
                                <!-- End Email Tempaltes -->

                                <!-- Funny Boxes -->
                                <li><a href="/templates/unify/page_funny_boxes.html">Funny Boxes</a></li>
                                <!-- End Funny Boxes -->

                                <!-- Pricing Tables -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Pricing Tables</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/page_pricing_flat.html">Flat Pricing Tables</a></li>                                    
                                        <li><a href="/templates/unify/page_pricing_light.html">Light Pricing Tables</a></li>
                                        <li><a href="/templates/unify/page_pricing_mega.html">Mega Pricing Tables</a></li>
                                        <li><a href="/templates/unify/page_pricing.html">Default Pricing Tables</a></li>
                                    </ul>                                
                                </li>
                                <!-- End Pricing Tables -->

                                <!-- Invoice Page -->
                                <li><a href="/templates/unify/page_invoice.html">Invoice Page</a></li>
                                <!-- End Invoice Page -->

                                <!-- Search Results -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Search Results</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/page_search_inner.html">Default Search Results</a></li>
                                        <li><a href="/templates/unify/page_search_table.html">Search Result Tables</a></li>
                                    </ul>                                
                                </li>
                                <!-- End Search Results -->

                                <!-- Coming Soon -->
                                <li><a href="/templates/unify/page_coming_soon.html">Coming Soon</a></li>
                                <!-- End Coming Soon -->

                                <!-- FAQs Pages -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">FAQs Pages</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/page_faq1.html">FAQs Page</a></li>
                                        <li><a href="/templates/unify/page_faq.html">FAQs Basic</a></li>
                                    </ul>                                
                                </li>
                                <!-- End FAQs Pages -->

                                <!-- Gallery Page -->
                                <li><a href="/templates/unify/page_gallery.html">Gallery Page</a></li>
                                <!-- End Gallery Page -->

                                <!-- Login and Registration -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Login and Registration</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/page_registration.html">Registration Page</a></li>
                                        <li><a href="/templates/unify/page_login.html">Login Page</a></li>
                                        <li><a href="/templates/unify/page_registration1.html">Registration Option</a></li>
                                        <li><a href="/templates/unify/page_login1.html">Login Option</a></li>
                                    </ul>                                
                                </li>
                                <!-- End Login and Registration -->

                                <!-- Error Pages -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Error Pages</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/page_404_error.html">404 Error Default</a></li>
                                        <li><a href="/templates/unify/page_404_error1.html">404 Error Option 1</a></li>
                                        <li><a href="/templates/unify/page_404_error2.html">404 Error Option 2</a></li>
                                        <li><a href="/templates/unify/page_404_error3.html">404 Error Option 3</a></li>
                                    </ul>                                
                                </li>
                                <!-- End Error Pages -->

                                <!-- Clients Page -->
                                <li><a href="/templates/unify/page_clients.html">Clients Page</a></li>
                                <!-- End Clients Page -->

                                <!-- Column Pages -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Column Pages</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/page_2_columns_left.html">2 Columns Page Left</a></li>
                                        <li><a href="/templates/unify/page_2_columns_right.html">2 Columns Page Right</a></li>
                                        <li><a href="/templates/unify/page_3_columns.html">3 Columns Page</a></li>
                                    </ul>                                
                                </li>
                                <!-- End Column Pages -->

                                <!-- Privacy Policy -->
                                <li><a href="/templates/unify/page_privacy.html">Privacy Policy</a></li>
                                <!-- End Privacy Policy -->

                                <!-- Terms Of Service -->
                                <li><a href="/templates/unify/page_terms.html">Terms Of Service</a></li>
                                <!-- End Terms Of Service -->
                            </ul>
                        </li>
                        <!-- End Pages -->

                        <!-- Features -->
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                                Features
                            </a>
                            <ul class="dropdown-menu">
                                <!-- Typography -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Typography</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/feature_typo_general.html"><i class="fa fa-sort-alpha-asc"></i> General Typography</a></li>
                                        <li><a href="/templates/unify/feature_typo_headings.html"><i class="fa fa-magic"></i> Headings Options</a></li>
                                        <li><a href="/templates/unify/feature_typo_dividers.html"><i class="fa fa-ellipsis-h"></i> Deviders</a></li>
                                        <li><a href="/templates/unify/feature_typo_blockquote.html"><i class="fa fa-quote-left"></i> Blockquote Blocks</a></li>
                                        <li><a href="/templates/unify/feature_typo_boxshadows.html"><i class="fa fa-asterisk"></i> Box Shadows</a></li>
                                        <li><a href="/templates/unify/feature_typo_testimonials.html"><i class="fa fa-comments"></i> Testimonials</a></li>
                                        <li><a href="/templates/unify/feature_typo_tagline_boxes.html"><i class="fa fa-tasks"></i> Tagline Boxes</a></li>
                                        <li><a href="/templates/unify/feature_typo_grid.html"><i class="fa fa-align-justify"></i> Grid Layouts</a></li>
                                    </ul>                                
                                </li>
                                <!-- End Typography -->

                                <!-- Buttons -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Buttons UI</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/feature_btn_general.html"><i class="fa fa-flask"></i> General Buttons</a></li>
                                        <li><a href="/templates/unify/feature_btn_brands.html"><i class="fa fa-html5"></i> Brand &amp; Social Buttons</a></li>
                                        <li><a href="/templates/unify/feature_btn_effects.html"><i class="fa fa-bolt"></i> Loading &amp; Hover Effects</a></li>
                                    </ul>                                
                                </li>
                                <!-- End Buttons -->

                                <!-- Icons -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Icons</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/feature_icon_general.html"><i class="fa fa-chevron-circle-right"></i> General Icons</a></li>
                                        <li><a href="/templates/unify/feature_icon_fa.html"><i class="fa fa-chevron-circle-right"></i> Font Awesome Icons</a></li>
                                        <li><a href="/templates/unify/feature_icon_line.html"><i class="fa fa-chevron-circle-right"></i> Line Icons</a></li>
                                        <li><a href="/templates/unify/feature_icon_glyph.html"><i class="fa fa-chevron-circle-right"></i> Glyphicons Icons</a></li>
                                    </ul>                                
                                </li>
                                <!-- End Icons -->

                                <!-- Content Boxes -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Content Boxes</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/feature_box_general.html"><i class="fa fa-cog"></i> General Content Boxes</a></li>
                                        <li><a href="/templates/unify/feature_box_colored.html"><i class="fa fa-align-center"></i> Colored Boxes</a></li>
                                        <li><a href="/templates/unify/feature_box_funny.html"><i class="fa fa-bars"></i> Funny Boxes</a></li>
                                    </ul>                                
                                </li>
                                <!-- End Content Boxes -->

                                <!-- Thumbnails -->
                                <li><a href="/templates/unify/feature_thumbails.html">Thumbnails</a></li>
                                <!-- End Thumbnails -->

                                <!-- Components -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Components</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/feature_compo_messages.html"><i class="fa fa-comment"></i> Alerts &amp; Messages</a></li>
                                        <li><a href="/templates/unify/feature_compo_labels.html"><i class="fa fa-tags"></i> Labels &amp; Badges</a></li>
                                        <li><a href="/templates/unify/feature_compo_progress_bars.html"><i class="fa fa-align-left"></i> Progress Bars</a></li>
                                        <li><a href="feature_compo_media.html"><i class="fa fa-volume-down"></i> Audio/Videos &amp; Images</a></li>
                                        <li><a href="/templates/unify/feature_compo_panels.html"><i class="fa fa-columns"></i> Panels</a></li>
                                        <li><a href="/templates/unify/feature_compo_pagination.html"><i class="fa fa-arrows-h"></i> Paginations</a></li>
                                    </ul>                                
                                </li>
                                <!-- End Components -->

                                <!-- Accordion and Tabs -->
                                <li><a href="/templates/unify/feature_accordion_and_tabs.html">Accordion &amp; Tabs</a></li>
                                <!-- End Accordion and Tabs -->

                                <!-- Timeline -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Timeline</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/feature_timeline1.html"><i class="fa fa-dot-circle-o"></i> Timeline Option 1</a></li>
                                        <li><a href="/templates/unify/feature_timeline2.html"><i class="fa fa-dot-circle-o"></i> Timeline Option 2</a></li>
                                    </ul>                                
                                </li>
                                <!-- End Timeline -->

                                <!-- Carousel -->
                                <li><a href="/templates/unify/feature_carousels.html">Carousel Examples</a></li>
                                <!-- End Carousel -->

                                <!-- Forms -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Forms</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/feature_form_general.html"><i class="fa fa-bars"></i> Common Bootstrap Forms</a></li>
                                        <li><a href="/templates/unify/feature_form_general1.html"><i class="fa fa-bars"></i> General Unify Forms</a></li>
                                        <li><a href="/templates/unify/feature_form_advanced.html"><i class="fa fa-bars"></i> Advanced Forms</a></li>
                                        <li><a href="/templates/unify/feature_form_layouts.html"><i class="fa fa-bars"></i> Form Layouts</a></li>
                                        <li><a href="feature_form_layouts_advanced.html"><i class="fa fa-bars"></i> Advanced Layout Forms</a></li>
                                        <li><a href="/templates/unify/feature_form_states.html"><i class="fa fa-bars"></i> Form States</a></li>
                                        <li><a href="/templates/unify/feature_form_sliders.html"><i class="fa fa-bars"></i> Form Sliders</a></li>
                                        <li><a href="/templates/unify/feature_form_modals.html"><i class="fa fa-bars"></i> Modals</a></li>
                                    </ul>                                
                                </li>
                                <!-- End Forms -->

                                <!-- Tables -->
                                <li><a href="/templates/unify/feature_table_general.html">Tables</a></li>
                                <!-- End Tables -->

                                <!-- Maps -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Maps</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/templates/unify/feature_maps_google.html"><i class="fa fa-map-marker"></i> Google Maps</a></li>
                                        <li><a href="/templates/unify/feature_maps_vector.html"><i class="fa fa-align-center"></i> Vector Maps</a></li>
                                    </ul>                                
                                </li>
                                <!-- End Maps -->

                                <!-- Charts and Countdowns -->
                                <li><a href="/templates/unify/feature_compo_charts.html">Charts &amp; Countdowns</a></li>
                                <!-- End Charts and Countdowns -->

                                <!-- Sub Level Menu -->
                                <li class="dropdown-submenu">
                                    <a href="javascript:void(0);">Sub Level 1</a>
                                    <ul class="dropdown-menu">
                                        <li><a href=/templates/unify/"index.hmtl">Sub Level 2</a></li>
                                        <li class="dropdown-submenu">
                                            <a href="javascript:void(0);">Sub Level 2</a>
                                            <ul class="dropdown-menu">
                                                <li><a href="/templates/unify/index.hmtl">Sub Level 3</a></li>
                                                <li><a href="/templates/unify/index.hmtl">Sub Level 3</a></li>
                                                <li><a href="/templates/unify/index.hmtl">Sub Level 3</a></li>
                                                <li><a href="/templates/unify/index.hmtl">Sub Level 3</a></li>
                                            </ul>                                
                                        </li>
                                        <li><a href="index.hmtl">Sub Level 2</a></li>
                                        <li class="dropdown-submenu">
                                            <a href="javascript:void(0);">Sub Level 2</a>
                                            <ul class="dropdown-menu">
                                                <li><a href="/templates/unify/index.hmtl">Sub Level 3</a></li>
                                                <li><a href="/templates/unify/index.hmtl">Sub Level 3</a></li>
                                                <li><a href="/templates/unify/index.hmtl">Sub Level 3</a></li>
                                            </ul>                                
                                        </li>
                                    </ul>                                
                                </li>                            
                                <!-- End Sub Level Menu -->
                            </ul>
                        </li>
                        <!-- End Features -->

                        <!-- Portfolio -->
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                                Portfolio
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/templates/unify/portfolio_text_blocks.html">Portfolio Text Blocks</a></li>
                                <li><a href="/templates/unify/portfolio_2_column.html">Portfolio 2 Columns</a></li>
                                <li><a href="/templates/unify/portfolio_3_column.html">Portfolio 3 Columns</a></li>
                                <li><a href="/templates/unify/portfolio_4_column.html">Portfolio 4 Columns</a></li>
                                <li><a href="/templates/unify/portfolio_item.html">Portfolio Item Option 1</a></li>
                                <li><a href="/templates/unify/portfolio_item1.html">Portfolio Item Option 2</a></li>
                            </ul>
                        </li>
                        <!-- Ens Portfolio -->

                        <!-- Blog -->
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                                Blog
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/templates/unify/blog_page.html">Blog Page</a></li>
                                <li><a href="/templates/unify/blog_large.html">Blog Large</a></li>
                                <li><a href="/templates/unify/blog_medium.html">Blog Medium</a></li>
                                <li><a href="/templates/unify/blog_full_width.html">Blog Full Width</a></li>
                                <li><a href="/templates/unify/blog_timeline.html">Blog Timeline</a></li>
                                <li><a href="/templates/unify/blog_masonry_3col.html">Masonry Grid Blog</a></li>
                                <li><a href="/templates/unify/blog_right_sidebar.html">Blog Right Sidebar</a></li>
                                <li><a href="/templates/unify/blog_left_sidebar.html">Blog Left Sidebar</a></li>
                                <li><a href="/templates/unify/blog_item_option1.html">Blog Item Option 1</a></li>
                                <li><a href="/templates/unify/blog_item_option2.html">Blog Item Option 2</a></li>
                            </ul>
                        </li>
                        <!-- End Blog -->

                        <!-- Contacts -->
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
                                Contacts
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="/templates/unify/page_contact1.html">Contacts Default</a></li>
                                <li><a href="/templates/unify/page_contact2.html">Contacts Option 1</a></li>
                                <li><a href="/templates/unify/page_contact3.html">Contacts Option 2</a></li>
                            </ul>
                        </li>                    
                        <!-- End Contacts -->

                        <!-- Search Block -->
                        <li>
                            <i class="search fa fa-search search-btn"></i>
                            <div class="search-open">
                                <div class="input-group animated fadeInDown">
                                    <input type="text" class="form-control" placeholder="Search">
                                    <span class="input-group-btn">
                                        <button class="btn-u" type="button">Go</button>
                                    </span>
                                </div>
                            </div>    
                        </li>
                        <!-- End Search Block -->
                    </ul>
                </div><!--/navbar-collapse-->
            </div>    
        </div>            
        <!-- End Navbar -->

';


	//Footer
	$snippets[3]['id'] = "template-unify-footer";
	$snippets[3]['title'] = "Unify: Footer";
	$snippets[3]['category'] = "Navigation";
	$snippets[3]['html'] = '<!--=== Footer ===-->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 md-margin-bottom-40">
                    <!-- About -->
                    <div class="headline"><h2>About</h2></div>  
                    <p class="margin-bottom-25 md-margin-bottom-40">Unify is an incredibly beautiful responsive Bootstrap Template for corporate and creative professionals.</p>    
                    <!-- End About -->

                    <!-- Monthly Newsletter -->
                    <div class="headline"><h2>Monthly Newsletter</h2></div> 
                    <p>Subscribe to our newsletter and stay up to date with the latest news and deals!</p>
                    <form class="footer-subsribe">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Email Address">                            
                            <span class="input-group-btn">
                                <button class="btn-u" type="button">Subscribe</button>
                            </span>
                        </div>                  
                    </form>                         
                    <!-- End Monthly Newsletter -->
                </div><!--/col-md-4-->  
                
                <div class="col-md-4 md-margin-bottom-40">
                    <!-- Recent Blogs -->
                    <div class="posts">
                        <div class="headline"><h2>Recent Blog Entries</h2></div>
                        <dl class="dl-horizontal">
                            <dt><a href="#"><img src="/templates/unify/assets/img/sliders/elastislide/6.jpg" alt=""></a></dt>
                            <dd>
                                <p><a href="#">Anim moon officia Unify is an incredibly beautiful responsive Bootstrap Template</a></p> 
                            </dd>
                        </dl>
                        <dl class="dl-horizontal">
                        <dt><a href="#"><img src="/templates/unify/assets/img/sliders/elastislide/10.jpg" alt=""></a></dt>
                            <dd>
                                <p><a href="#">Anim moon officia Unify is an incredibly beautiful responsive Bootstrap Template</a></p> 
                            </dd>
                        </dl>
                        <dl class="dl-horizontal">
                        <dt><a href="#"><img src="/templates/unify/assets/img/sliders/elastislide/11.jpg" alt=""></a></dt>
                            <dd>
                                <p><a href="#">Anim moon officia Unify is an incredibly beautiful responsive Bootstrap Template</a></p> 
                            </dd>
                        </dl>
                    </div>
                    <!-- End Recent Blogs -->                    
                </div><!--/col-md-4-->

                <div class="col-md-4">
                    <!-- Contact Us -->
                    <div class="headline"><h2>Contact Us</h2></div> 
                    <address class="md-margin-bottom-40">
                        25, Lorem Lis Street, Orange <br />
                        California, US <br />
                        Phone: 800 123 3456 <br />
                        Fax: 800 123 3456 <br />
                        Email: <a href="mailto:info@anybiz.com" class="">info@anybiz.com</a>
                    </address>
                    <!-- End Contact Us -->

                    <!-- Social Links -->
                    <div class="headline"><h2>Stay Connected</h2></div> 
                    <ul class="social-icons">
                        <li><a href="#" data-original-title="Feed" class="social_rss"></a></li>
                        <li><a href="#" data-original-title="Facebook" class="social_facebook"></a></li>
                        <li><a href="#" data-original-title="Twitter" class="social_twitter"></a></li>
                        <li><a href="#" data-original-title="Goole Plus" class="social_googleplus"></a></li>
                        <li><a href="#" data-original-title="Pinterest" class="social_pintrest"></a></li>
                        <li><a href="#" data-original-title="Linkedin" class="social_linkedin"></a></li>
                        <li><a href="#" data-original-title="Vimeo" class="social_vimeo"></a></li>
                    </ul>
                    <!-- End Social Links -->
                </div><!--/col-md-4-->
            </div>
        </div> 
    </div><!--/footer-->
    <!--=== End Footer ===-->
';


//Footer
	$snippets[4]['id'] = "template-unify-copyright";
	$snippets[4]['title'] = "Unify: Copyright";
	$snippets[4]['category'] = "Miscellaneous";
	$snippets[4]['html'] = '<!--=== Copyright ===-->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-6">                     
                    <p>
                        2014 &copy; Unify. ALL Rights Reserved. 
                        <a target="_blank" href="https://twitter.com/htmlstream">Htmlstream</a> | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a>
                    </p>
                </div>
                <div class="col-md-6">  
                    <a href="/templates/unify/index.html">
                        <img class="pull-right" id="logo-footer" src="/templates/unify/assets/img/logo2-default.png" alt="">
                    </a>
                </div>
            </div>
        </div> 
    </div><!--/copyright--> 
    <!--=== End Copyright ===-->
';

	$snippets[5]['id'] = "template-unify-onepage-nav";
	$snippets[5]['title'] = "Unify: One Page Navigation";
	$snippets[5]['category'] = "Navigation";
	$snippets[5]['html'] = '<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#intro">
                    <span>U</span>nify
                    <!-- <img src="assets/img/logo1.png" alt="Logo"> -->
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li class="page-scroll home">
                        <a href="#body">Home</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#about">About Us</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#services">Services</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#news">News</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#portfolio">Portfolio</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#contact">Contact</a>
                    </li>                    
                    <li class="page-scroll">
                        <a href="../index.html">Main</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>';

	$snippets[6]['id'] = "template-unify-home-slider2";
	$snippets[6]['title'] = "Unify: Home Slider 2";
	$snippets[6]['category'] = "Carousels & Sliders";
	$snippets[6]['html'] = ' <link rel="stylesheet" href="/templates/unify/assets/plugins/revolution-slider/examples/rs-plugin/css/settings.css">
<!--=== Slider ===-->
    <div class="tp-banner-container">
        <div class="tp-banner">
            <ul>
                <!-- SLIDE -->
                <li class="revolution-mch-1" data-transition="fade" data-slotamount="5" data-masterspeed="1000">
                    <!-- MAIN IMAGE -->
                    <img src="/templates/unify/assets/img/sliders/1.jpg"  alt="darkblurbg"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">

                    <div class="tp-caption revolution-ch1 sft start"
                        data-x="center"
                        data-hoffset="0"
                        data-y="100"
                        data-speed="1500"
                        data-start="500"
                        data-easing="Back.easeInOut"
                        data-endeasing="Power1.easeIn"                        
                        data-endspeed="300">
                        Introducing Unify Template
                    </div>

                    <!-- LAYER -->
                    <div class="tp-caption revolution-ch2 sft"
                        data-x="center"
                        data-hoffset="0"
                        data-y="190"
                        data-speed="1400"
                        data-start="2000"
                        data-easing="Power4.easeOut"
                        data-endspeed="300"
                        data-endeasing="Power1.easeIn"
                        data-captionhidden="off"
                        style="z-index: 6">
                        We are creative technology company providing <br/>
                        key digital services on web and mobile.
                    </div>

                    <!-- LAYER -->
                    <div class="tp-caption sft"
                        data-x="center"
                        data-hoffset="0"
                        data-y="310"
                        data-speed="1600"
                        data-start="2800"
                        data-easing="Power4.easeOut"
                        data-endspeed="300"
                        data-endeasing="Power1.easeIn"
                        data-captionhidden="off"
                        style="z-index: 6">
                        <a href="#" class="btn-u btn-brd btn-brd-hover btn-u-light">Learn More</a>
                        <a href="#" class="btn-u btn-brd btn-brd-hover btn-u-light">Our Work</a>
                    </div>
                </li>
                <!-- END SLIDE -->

                <!-- SLIDE -->
                <li class="revolution-mch-1" data-transition="fade" data-slotamount="5" data-masterspeed="1000">
                    <!-- MAIN IMAGE -->
                    <img src="/templates/unify/assets/img/sliders/2.jpg"  alt="darkblurbg"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">

                    <div class="tp-caption revolution-ch1 sft start"
                        data-x="center"
                        data-hoffset="0"
                        data-y="100"
                        data-speed="1500"
                        data-start="500"
                        data-easing="Back.easeInOut"
                        data-endeasing="Power1.easeIn"                        
                        data-endspeed="300">
                        Includes 120+ Template Pages
                    </div>

                    <!-- LAYER -->
                    <div class="tp-caption revolution-ch2 sft"
                        data-x="center"
                        data-hoffset="0"
                        data-y="190"
                        data-speed="1400"
                        data-start="2000"
                        data-easing="Power4.easeOut"
                        data-endspeed="300"
                        data-endeasing="Power1.easeIn"
                        data-captionhidden="off"
                        style="z-index: 6">
                        We are creative technology company providing <br/>
                        key digital services on web and mobile.
                    </div>

                    <!-- LAYER -->
                    <div class="tp-caption sft"
                        data-x="center"
                        data-hoffset="0"
                        data-y="310"
                        data-speed="1600"
                        data-start="2800"
                        data-easing="Power4.easeOut"
                        data-endspeed="300"
                        data-endeasing="Power1.easeIn"
                        data-captionhidden="off"
                        style="z-index: 6">
                        <a href="#" class="btn-u btn-brd btn-brd-hover btn-u-light">Learn More</a>
                        <a href="#" class="btn-u btn-brd btn-brd-hover btn-u-light">Our Work</a>
                    </div>
                </li>
                <!-- END SLIDE -->

                <!-- SLIDE -->
                <li class="revolution-mch-1" data-transition="fade" data-slotamount="5" data-masterspeed="1000">
                    <!-- MAIN IMAGE -->
                    <img src="/templates/unify/assets/img/sliders/3.jpg"  alt="darkblurbg"  data-bgfit="cover" data-bgposition="left top" data-bgrepeat="no-repeat">

                    <div class="tp-caption revolution-ch1 sft start"
                        data-x="center"
                        data-hoffset="0"
                        data-y="100"
                        data-speed="1500"
                        data-start="500"
                        data-easing="Back.easeInOut"
                        data-endeasing="Power1.easeIn"                        
                        data-endspeed="300">
                        Over 9000+ Satisfied Users
                    </div>

                    <!-- LAYER -->
                    <div class="tp-caption revolution-ch2 sft"
                        data-x="center"
                        data-hoffset="0"
                        data-y="190"
                        data-speed="1400"
                        data-start="2000"
                        data-easing="Power4.easeOut"
                        data-endspeed="300"
                        data-endeasing="Power1.easeIn"
                        data-captionhidden="off"
                        style="z-index: 6">
                        We are creative technology company providing <br/>
                        key digital services on web and mobile.
                    </div>

                    <!-- LAYER -->
                    <div class="tp-caption sft"
                        data-x="center"
                        data-hoffset="0"
                        data-y="310"
                        data-speed="1600"
                        data-start="2800"
                        data-easing="Power4.easeOut"
                        data-endspeed="300"
                        data-endeasing="Power1.easeIn"
                        data-captionhidden="off"
                        style="z-index: 6">
                        <a href="#" class="btn-u btn-brd btn-brd-hover btn-u-light">Learn More</a>
                        <a href="#" class="btn-u btn-brd btn-brd-hover btn-u-light">Our Work</a>
                    </div>
                </li>
                <!-- END SLIDE -->
            </ul>
            <div class="tp-bannertimer tp-bottom"></div>            
        </div>
    </div>
    <!--=== End Slider ===-->
    <!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
<script type="text/javascript" src="/templates/unify/assets/plugins/revolution-slider/examples/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
<script type="text/javascript" src="/templates/unify/assets/plugins/revolution-slider/examples/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        Index.initRevolutionSlider();                                
    });
</script>';	

	$snippets[7]['id'] = "template-unify-home-slider3";
	$snippets[7]['title'] = "Unify: Home Slider 3";
	$snippets[7]['category'] = "Carousels & Sliders";
	$snippets[7]['html'] = '<link rel="stylesheet" href="/templates/unify/assets/plugins/layer-slider/layerslider/css/layerslider.css">
<!--=== Slider ===-->
<div id="layerslider" style="width: 100%; height: 500px; margin: 0px auto;"> 
  <!-- First slide -->
  <div class="ls-slide" data-ls="slidedelay:4500;transition2d:25;">
    <img src="/templates/unify/assets/img/sliders/layer/bg1.jpg" class="ls-bg" alt="Slide background"/>
    <img class="ls-l" src="/templates/unify/assets/img/mockup/iphone1.png" style="top: 85%; left: 44%;" 
            data-ls="offsetxin:left; durationin:1500; delayin:900; fadein:false; offsetxout:left; durationout:1000; fadeout:false;" />
    <img src="/templates/unify/assets/img/mockup/iphone.png" alt="Slider image" class="ls-s-1" style=" top:62px; left: 29%;" 
            data-ls="offsetxin:left; durationin:1500; delayin:1500; fadein:false; offsetxout:left; durationout:1000; fadeout:false;">
    <span class="ls-s-1" style=" text-transform: uppercase; line-height: 45px; font-size:35px; color:#fff; top:200px; left: 590px; slidedirection : top; slideoutdirection : bottom; durationin : 3500; durationout : 3500; delayin : 1000;"> Fully Responsive <br>
    Bootstrap 3 Template </span>
    <a class="btn-u btn-u-orange ls-s-1" href="#" style=" padding: 9px 20px; font-size:25px; top:340px; left: 590px; slidedirection : bottom; slideoutdirection : top; durationin : 3500; durationout : 2500; delayin : 1000; "> Download Now </a> </div>
  
  <!--Second Slide-->
  <div class="ls-slide" data-ls="transition2d:93;">
    <img src="/templates/unify/assets/img/bg/5.jpg" class="ls-bg" alt="Slide background">
    <i class="fa fa-chevron-circle-right ls-s-1" style=" color: #fff; font-size: 24px; top:70px; left: 40px; slidedirection : left; slideoutdirection : top; durationin : 1500; durationout : 500; "></i>
    <span class="ls-s-2" style=" color: #fff; font-weight: 200; font-size: 22px; top:70px; left: 70px; slidedirection : top; slideoutdirection : bottom; durationin : 1500; durationout : 500; "> Fully Responsive and Easy to Customize </span>
    <i class="fa fa-chevron-circle-right ls-s-1" style=" color: #fff; font-size: 24px; top:120px; left: 40px; slidedirection : left; slideoutdirection : top; durationin : 2500; durationout : 1500; "></i>
    <span class="ls-s-2" style=" color: #fff; font-weight: 200; font-size: 22px; top:120px; left: 70px; slidedirection : top; slideoutdirection : bottom; durationin : 2500; durationout : 1500; "> Revolution and Layer Slider Included </span>
    <i class="fa fa-chevron-circle-right ls-s-1" style=" color: #fff; font-size: 24px; top:170px; left: 40px; slidedirection : left; slideoutdirection : top; durationin : 3500; durationout : 3500; "></i>
    <span class="ls-s-2" style=" color: #fff; font-weight: 200; font-size: 22px; top:170px; left: 70px; slidedirection : top; slideoutdirection : bottom; durationin : 3500; durationout : 2500; "> 1000+ Glyphicons Pro and Font Awesome Icons </span>
    <i class="fa fa-chevron-circle-right ls-s-1" style=" color: #fff; font-size: 24px; top:220px; left: 40px; slidedirection : left; slideoutdirection : top; durationin : 4500; durationout : 3500; "></i>
    <span class="ls-s-2" style=" color: #fff; font-weight: 200; font-size: 22px; top:220px; left: 70px; slidedirection : top; slideoutdirection : bottom; durationin : 4500; durationout : 3500; "> Revolution and Layer Slider Included </span>
    <i class="fa fa-chevron-circle-right ls-s-1" style=" color: #fff; font-size: 24px; top:270px; left: 40px; slidedirection : left; slideoutdirection : top; durationin : 5500; durationout : 4500; "></i>
    <span class="ls-s-2" style=" color: #fff; font-weight: 200; font-size: 22px; top:270px; left: 70px; slidedirection : top; slideoutdirection : bottom; durationin : 5500; durationout : 4500; "> 60+ Template Pages and 20+ Plugins Included </span>
    <a class="btn-u btn-u-blue ls-s1" href="#" style=" padding: 9px 20px; font-size:25px; top:340px; left: 40px; slidedirection : bottom; slideoutdirection : bottom; durationin : 6500; durationout : 3500; "> Twitter Bootstrap 3 </a>
    <img src="/templates/unify/assets/img/mockup/iphone1.png" alt="Slider Image" class="ls-s-1" style=" top:30px; left: 650px; slidedirection : right; slideoutdirection : bottom; durationin : 1500; durationout : 1500; ">
  </div>
  
  <!--Third Slide-->
  <div class="ls-slide" style="slidedirection: right; transition2d: 92,93,105; ">
    <img src="/templates/unify/assets/img/sliders/layer/bg2.jpg" class="ls-bg" alt="Slide background">
    <span class="ls-s-1" style=" color: #777; line-height:45px; font-weight: 200; font-size: 35px; top:100px; left: 50px; slidedirection : top; slideoutdirection : bottom; durationin : 1000; durationout : 1000; "> Unify is Fully Responsive <br>
    Twitter Bootstrap 3 Template </span>
    <a class="btn-u btn-u-green ls-s-1" href="#" style=" padding: 9px 20px; font-size:25px; top:220px; left: 50px; slidedirection : bottom; slideoutdirection : bottom; durationin : 2000; durationout : 2000; "> Find Out More </a>
    <img src="/templates/unify/assets/img/mockup/iphone.png" alt="Slider Image" class="ls-s-1" style=" top:30px; left: 670px; slidedirection : right; slideoutdirection : bottom; durationin : 3000; durationout : 3000; ">
  </div>
  <!--End Third Slide--> 
</div>
<!--/layer_slider--> 
<!--=== End Slider ===-->
<!-- Layer Slider -->
<script type="text/javascript" src="/templates/unify/assets/plugins/layer-slider/layerslider/js/greensock.js"></script>
<script type="text/javascript" src="/templates/unify/assets/plugins/layer-slider/layerslider/js/layerslider.transitions.js"></script>
<script type="text/javascript" src="/templates/unify/assets/plugins/layer-slider/layerslider/js/layerslider.kreaturamedia.jquery.js"></script>
<!-- End Layer Slider -->   
<script type="text/javascript">
    jQuery(document).ready(function() {
        Index.initLayerSlider();
    });
</script>
<!--[if lt IE 9]>
    <script src="/templates/unify/assets/plugins/layer-slider/assets/js/html5.js"></script>
<![endif]-->';

	$snippets[8]['id'] = "template-unify-home-slider1";
	$snippets[8]['title'] = "Unify: Home Slider 1";
	$snippets[8]['category'] = "Carousels & Sliders";
	$snippets[8]['html'] = '<link rel="stylesheet" href="/templates/unify/assets/plugins/parallax-slider/css/parallax-slider.css">
	<!--=== Slider ===-->
    <div class="slider-inner">
        <div id="da-slider" class="da-slider">
            <div class="da-slide">
                <h2><i>CLEAN &amp; FRESH</i> <br /> <i>FULLY RESPONSIVE</i> <br /> <i>DESIGN</i></h2>
                <p><i>Lorem ipsum dolor amet</i> <br /> <i>tempor incididunt ut</i> <br /> <i>veniam omnis </i></p>
                <div class="da-img"><img class="img-responsive" src="/templates/unify/assets/plugins/parallax-slider/img/1.png" alt=""></div>
            </div>
            <div class="da-slide">
                <h2><i>RESPONSIVE VIDEO</i> <br /> <i>SUPPORT AND</i> <br /> <i>MANY MORE</i></h2>
                <p><i>Lorem ipsum dolor amet</i> <br /> <i>tempor incididunt ut</i></p>
                <div class="da-img">
    				<iframe src="http://player.vimeo.com/video/47911018" width="530" height="300" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe> 
                </div>
            </div>
            <div class="da-slide">
                <h2><i>USING BEST WEB</i> <br /> <i>SOLUTIONS WITH</i> <br /> <i>HTML5/CSS3</i></h2>
                <p><i>Lorem ipsum dolor amet</i> <br /> <i>tempor incididunt ut</i> <br /> <i>veniam omnis </i></p>
                <div class="da-img"><img src="/templates/unify/assets/plugins/parallax-slider/img/html5andcss3.png" alt="image01" /></div>
            </div>
            <div class="da-arrows">
                <span class="da-arrows-prev"></span>
                <span class="da-arrows-next"></span>		
            </div>
        </div>
    </div><!--/slider-->
    <!--=== End Slider ===-->
		<script type="text/javascript" src="/templates/unify/assets/plugins/parallax-slider/js/modernizr.js"></script>
		<script type="text/javascript" src="/templates/unify/assets/plugins/parallax-slider/js/jquery.cslider.js"></script>
		<script type="text/javascript">
				jQuery(document).ready(function() {
						Index.initParallaxSlider();        
				});
		</script>'; 
		

foreach($snippets as $key=>$value) {
		echo $value['id']."--|--".$value['title']."--|--".$value['html']."--|--".$value['category']."[iKiosk]";	
	}

}

?>
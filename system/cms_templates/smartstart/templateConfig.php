<?php
if ($_GET['option'] == "folderList") {
	
		$PAGE['application_code'] = "IKIOSK";
		require('../../../ikiosk/includes/core/ikiosk.php'); 
	
		$thisPath = realpath(dirname(__FILE__));
		$directoryArray = directoryToArray($thisPath, $recursive);
		$fileList = "/smartstart[iKiosk]";
		foreach ($directoryArray as $key => $value) {
		$value = str_replace($SYSTEM['ikiosk_filesystem_root']."/system/cms_templates", "", $value);
		$fileList .= $value."[iKiosk]";
		}
		echo $fileList;
}
?>
<?php 
if ($_GET['option'] == "templateList") {
	
$templates = array();
$templates[0]['title'] = 'SmartStart Main Template';
$templates[0]['header_code'] = '	<!--[if !lte IE 6]><!-->
		<link rel="stylesheet" href="/templates/smartstart/css/style.css" media="screen" />

		<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:400,600,300,800,700,400italic|PT+Serif:400,400italic" />
		
		<link rel="stylesheet" href="/templates/smartstart/css/fancybox.min.css" media="screen" />

		<link rel="stylesheet" href="/templates/smartstart/css/video-js.min.css" media="screen" />

		<link rel="stylesheet" href="/templates/smartstart/css/audioplayerv1.min.css" media="screen" />
	<!--<![endif]-->

	<!--[if lte IE 6]>
		<link rel="stylesheet" href="//universal-ie6-css.googlecode.com/files/ie6.1.1.css" media="screen, projection">
	<![endif]-->

	<!-- HTML5 Shiv + detect touch events -->
	<script src="/templates/smartstart/js/modernizr.custom.js"></script>

	<!-- HTML5 video player -->
	<script src="/templates/smartstart/js/video.min.js"></script>
	<script>_V_.options.flash.swf = "/templates/smartstart/js/video-js.swf";</script>';

$templates[0]['body_header_code'] = '<header id="header" class="container clearfix">

	<a href="/templates/smartstart/index.html" id="logo">
		<img src="/templates/smartstart/img/logo.png" alt="SmartStart">
	</a>

	<nav id="main-nav">
		
		<ul>
			<li class="current">
				<a href="/templates/smartstart/index.html" data-description="All starts here">Home</a>
				<ul>
					<li><a href="/templates/smartstart/logos-slider.html">Logos Slider</a></li>
					<li><a href="/templates/smartstart/photos-slider.html">Photos Slider</a></li>
				</ul>
			</li>
			<li>
				<a href="/templates/smartstart/elements.html" data-description="All the different stuff">Features</a>
				<ul>
					<li><a href="/templates/smartstart/about-us.html">About Us</a></li>
					<li><a href="/templates/smartstart/our-team.html">Our Team</a>
						<ul>
							<li><a href="/templates/smartstart/we-are-hiring.html">We are hiring</a></li>
						</ul>
					</li>
					<li><a href="/templates/smartstart/elements.html">Elements</a></li>
					<li><a href="/templates/smartstart/pricing-tables.html">Pricing Tables</a></li>
					<li><a href="/templates/smartstart/columns.html">Columns</a></li>
					<li><a href="#">Third Level Item</a>
						<ul>
							<li><a href="#">This is a simple example</a></li>
							<li><a href="#">Of the third level</a></li>
							<li><a href="#">Navigation item</a></li> 
						</ul>
					</li>
				</ul>
			</li>
			<li>
				<a href="/templates/smartstart/blog.html" data-description="What we think">Blog</a>
				<ul>
					<li><a href="/templates/smartstart/single-post.html">Single Post</a></li>
				</ul>
			</li>
			<li>
				<a href="/templates/smartstart/portfolio-4-columns.html" data-description="Work we are proud of">Portfolio</a>
				<ul>
					<li><a href="/templates/smartstart/portfolio-2-columns.html">2 Columns</a></li>
					<li><a href="/templates/smartstart/portfolio-3-columns.html">3 Columns</a></li>
					<li><a href="/templates/smartstart/portfolio-4-columns.html">4 Columns</a></li>
					<li><a href="/templates/smartstart/single-project.html">Single Project</a></li>
				</ul>
			</li>
			<li>
				<a href="/templates/smartstart/contact-us.html" data-description="Enquire here">Contact</a>
			</li>
		</ul>

	</nav><!-- end #main-nav -->
	
</header><!-- end #header -->

<section id="content" class="container clearfix">';

$templates[0]['body_footer_code'] = '</section><!-- end #content -->

<footer id="footer" class="clearfix">

	<div class="container">

		<div class="three-fourth">

			<nav id="footer-nav" class="clearfix">

				<ul>
					<li><a href="/templates/smartstart/index.html">Home</a></li>
					<li><a href="/templates/smartstart/elements.html">Features</a></li>
					<li><a href="/templates/smartstart/blog.html">Blog</a></li>
					<li><a href="/templates/smartstart/portfolio-4-columns.html">Portfolio</a></li>
					<li><a href="/templates/smartstart/contact-us.html">Contact</a></li>
				</ul>
				
			</nav><!-- end #footer-nav -->

			<ul class="contact-info">
				<li class="address">012 Some Street. New York, NY, 12345. USA</li>
				<li class="phone">(123) 456-7890</li>
				<li class="email"><a href="mailto:contact@companyname.com">contact@companyname.com</a></li>
			</ul><!-- end .contact-info -->
			
		</div><!-- end .three-fourth -->

		<div class="one-fourth last">

			<span class="title">Stay connected</span>

			<ul class="social-links">
				<li class="twitter"><a href="#">Twitter</a></li>
				<li class="facebook"><a href="#">Facebook</a></li>
				<li class="digg"><a href="#">Digg</a></li>
				<li class="vimeo"><a href="#">Vimeo</a></li>
				<li class="youtube"><a href="#">YouTube</a></li>
				<li class="skype"><a href="#">Skype</a></li>
			</ul><!-- end .social-links -->

		</div><!-- end .one-fourth.last -->
		
	</div><!-- end .container -->

</footer><!-- end #footer -->

<footer id="footer-bottom" class="clearfix">

	<div class="container">

		<ul>
			<li>SmartStart &copy; 2012</li>
			<li><a href="#">Legal Notice</a></li>
			<li><a href="#">Terms</a></li>
		</ul>

	</div><!-- end .container -->

</footer><!-- end #footer-bottom -->

<!--[if !lte IE 6]><!-->
	<!--[if lt IE 9]> <script src="/templates/smartstart/js/selectivizr-and-extra-selectors.min.js"></script> <![endif]-->
	<script src="/templates/smartstart/js/respond.min.js"></script>
	<script src="/templates/smartstart/js/jquery.easing-1.3.min.js"></script>
	<script src="/templates/smartstart/js/jquery.fancybox.pack.js"></script>
	<script src="/templates/smartstart/js/jquery.smartStartSlider.min.js"></script>
	<script src="/templates/smartstart/js/jquery.jcarousel.min.js"></script>
	<script src="/templates/smartstart/js/jquery.cycle.all.min.js"></script>
	<script src="/templates/smartstart/js/jquery.isotope.min.js"></script>
	<script src="/templates/smartstart/js/audioplayerv1.min.js"></script>
	<script src="//maps.google.com/maps/api/js?sensor=false"></script>
	<script src="/templates/smartstart/js/jquery.gmap.min.js"></script>
	<script src="/templates/smartstart/js/jquery.touchSwipe.min.js"></script>
	<script src="/templates/smartstart/js/custom.js"></script>
<!--<![endif]-->';

	foreach($templates as $key=>$value) {
		echo $value['title']."--|--".$value['header_code']."--|--".$value['body_header_code']."--|--".$value['body_footer_code']."[iKiosk]";	
	}
}
?>
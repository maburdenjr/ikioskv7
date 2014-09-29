<?php
$content = '
<!--=== Content Part ===-->
<div class="container content">
</div>
<!-- End Content Part -->
';
?>
<!-- Grid Layout -->
<div class="acc-section-trigger"><i class="fa fa-fw fa-cubes"></i> General</div>
<div class="acc-section-content custom-scroll">
  <div class="layoutItem ui-element" data-code="<?php echo htmlentities($content); ?>">
    <div class="layoutImage"><img src="/templates/unify/layouts/default.jpg" /></div>
    <div class="layoutTitle">Empty Content Area</div>	
  </div>
</div>

<?php
$col2 = '<div class="row"><div class="col-md-6"></div><div class="col-md-6"></div></row>';
$col3 = '<div class="row"><div class="col-md-4"></div><div class="col-md-4"></div><div class="col-md-4"></div>
</row>';
$col4 = '<div class="row"><div class="col-md-3"></div><div class="col-md-3"></div><div class="col-md-3"></div><div class="col-md-3"></div></row>';
?>

<!-- Grid Layout -->
<div class="acc-section-trigger"><i class="fa fa-fw fa-columns"></i> Columns</div>
<div class="acc-section-content custom-scroll">
  <div class="layoutItem ui-element" data-code="<?php echo htmlentities($col2); ?>">
    <div class="layoutImage"><img src="/templates/unify/layouts/default.jpg" /></div>
    <div class="layoutTitle">2 Columns</div>	
  </div>
  <div class="layoutItem ui-element" data-code="<?php echo htmlentities($col3); ?>">
    <div class="layoutImage"><img src="/templates/unify/layouts/default.jpg" /></div>
    <div class="layoutTitle">3 Columns</div>	
  </div>
  <div class="layoutItem ui-element" data-code="<?php echo htmlentities($col4); ?>">
    <div class="layoutImage"><img src="/templates/unify/layouts/default.jpg" /></div>
    <div class="layoutTitle">4 Columns</div>	
  </div>
</div>
<!-- Home Page Elements -->
<?php

$slider1 = '
  <link rel="stylesheet" href="/templates/unify/assets/plugins/parallax-slider/css/parallax-slider.css">
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
		</script>
		';
		
?>

<div class="acc-section-trigger"><i class="fa fa-fw fa-picture-o"></i> Carousels & Sliders</div>
<div class="acc-section-content custom-scroll">
	<div class="layoutItem ui-element" data-code="<?php echo htmlentities($slider1); ?>">
    <div class="layoutImage"><img src="/templates/unify/layouts/homeslider1.jpg" /></div>
    <div class="layoutTitle">Default Slider</div>	
  </div>

</div>
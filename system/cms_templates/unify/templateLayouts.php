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

$slider1 = '<!--=== Slider ===-->
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
    <!--=== End Slider ===-->';
		
$slider2 = '<!--=== Slider ===-->
    <div id="layerslider" style="width: 100%; height: 500px; margin: 0px auto;">
        <!-- First slide -->
        <div class="ls-slide" data-ls="slidedelay:4500;transition2d:25;">
            <img src="/templates/unify/assets/img/sliders/layer/bg1.jpg" class="ls-bg" alt="Slide background"/>

            <img class="ls-l" src="/templates/unify/assets/img/mockup/iphone1.png" style="top: 85%; left: 44%;" 
            data-ls="offsetxin:left; durationin:1500; delayin:900; fadein:false; offsetxout:left; durationout:1000; fadeout:false;" />
            
            <img src="/templates/unify/assets/img/mockup/iphone.png" alt="Slider image" class="ls-s-1" style=" top:62px; left: 29%;" 
            data-ls="offsetxin:left; durationin:1500; delayin:1500; fadein:false; offsetxout:left; durationout:1000; fadeout:false;">
        
            <span class="ls-s-1" style=" text-transform: uppercase; line-height: 45px; font-size:35px; color:#fff; top:200px; left: 590px; slidedirection : top; slideoutdirection : bottom; durationin : 3500; durationout : 3500; delayin : 1000;">
                Fully Responsive <br> Bootstrap 3 Template
            </span>

            <a class="btn-u btn-u-orange ls-s-1" href="#" style=" padding: 9px 20px; font-size:25px; top:340px; left: 590px; slidedirection : bottom; slideoutdirection : top; durationin : 3500; durationout : 2500; delayin : 1000; ">
                Download Now
            </a>
        </div>

        <!--Second Slide-->
        <div class="ls-slide" data-ls="transition2d:93;">
            <img src="/templates/unify/assets/img/bg/5.jpg" class="ls-bg" alt="Slide background">

            <i class="fa fa-chevron-circle-right ls-s-1" style=" color: #fff; font-size: 24px; top:70px; left: 40px; slidedirection : left; slideoutdirection : top; durationin : 1500; durationout : 500; "></i> 

            <span class="ls-s-2" style=" color: #fff; font-weight: 200; font-size: 22px; top:70px; left: 70px; slidedirection : top; slideoutdirection : bottom; durationin : 1500; durationout : 500; ">
                Fully Responsive and Easy to Customize
            </span>

            <i class="fa fa-chevron-circle-right ls-s-1" style=" color: #fff; font-size: 24px; top:120px; left: 40px; slidedirection : left; slideoutdirection : top; durationin : 2500; durationout : 1500; "></i> 

            <span class="ls-s-2" style=" color: #fff; font-weight: 200; font-size: 22px; top:120px; left: 70px; slidedirection : top; slideoutdirection : bottom; durationin : 2500; durationout : 1500; ">
                Revolution and Layer Slider Included 
            </span>

            <i class="fa fa-chevron-circle-right ls-s-1" style=" color: #fff; font-size: 24px; top:170px; left: 40px; slidedirection : left; slideoutdirection : top; durationin : 3500; durationout : 3500; "></i> 

            <span class="ls-s-2" style=" color: #fff; font-weight: 200; font-size: 22px; top:170px; left: 70px; slidedirection : top; slideoutdirection : bottom; durationin : 3500; durationout : 2500; ">
                1000+ Glyphicons Pro and Font Awesome Icons 
            </span>

            <i class="fa fa-chevron-circle-right ls-s-1" style=" color: #fff; font-size: 24px; top:220px; left: 40px; slidedirection : left; slideoutdirection : top; durationin : 4500; durationout : 3500; "></i> 

            <span class="ls-s-2" style=" color: #fff; font-weight: 200; font-size: 22px; top:220px; left: 70px; slidedirection : top; slideoutdirection : bottom; durationin : 4500; durationout : 3500; ">
                Revolution and Layer Slider Included 
            </span>

            <i class="fa fa-chevron-circle-right ls-s-1" style=" color: #fff; font-size: 24px; top:270px; left: 40px; slidedirection : left; slideoutdirection : top; durationin : 5500; durationout : 4500; "></i> 

            <span class="ls-s-2" style=" color: #fff; font-weight: 200; font-size: 22px; top:270px; left: 70px; slidedirection : top; slideoutdirection : bottom; durationin : 5500; durationout : 4500; ">
                60+ Template Pages and 20+ Plugins Included
            </span>

            <a class="btn-u btn-u-blue ls-s1" href="#" style=" padding: 9px 20px; font-size:25px; top:340px; left: 40px; slidedirection : bottom; slideoutdirection : bottom; durationin : 6500; durationout : 3500; ">
                Twitter Bootstrap 3
            </a>

            <img src="/templates/unify/assets/img/mockup/iphone1.png" alt="Slider Image" class="ls-s-1" style=" top:30px; left: 650px; slidedirection : right; slideoutdirection : bottom; durationin : 1500; durationout : 1500; ">
        </div>                

        <!--Third Slide-->
        <div class="ls-slide" style="slidedirection: right; transition2d: 92,93,105; ">
            <img src="/templates/unify/assets/img/sliders/layer/bg2.jpg" class="ls-bg" alt="Slide background">

            <span class="ls-s-1" style=" color: #777; line-height:45px; font-weight: 200; font-size: 35px; top:100px; left: 50px; slidedirection : top; slideoutdirection : bottom; durationin : 1000; durationout : 1000; ">
                Unify is Fully Responsive <br> Twitter Bootstrap 3 Template
            </span>

            <a class="btn-u btn-u-green ls-s-1" href="#" style=" padding: 9px 20px; font-size:25px; top:220px; left: 50px; slidedirection : bottom; slideoutdirection : bottom; durationin : 2000; durationout : 2000; ">
                Find Out More
            </a>

            <img src="assets/img/mockup/iphone.png" alt="Slider Image" class="ls-s-1" style=" top:30px; left: 670px; slidedirection : right; slideoutdirection : bottom; durationin : 3000; durationout : 3000; ">
        </div>
        <!--End Third Slide-->
    </div><!--/layer_slider-->
    <!--=== End Slider ===-->';		

?>

<div class="acc-section-trigger"><i class="fa fa-fw fa-picture-o"></i> Carousels & Sliders</div>
<div class="acc-section-content custom-scroll">
	<div class="layoutItem ui-element" data-code="<?php echo htmlentities($slider1); ?>">
    <div class="layoutImage"><img src="/templates/unify/layouts/homeslider1.jpg" /></div>
    <div class="layoutTitle">Default Slider</div>	
  </div>
  <div class="layoutItem ui-element" data-code="<?php echo htmlentities($slider2); ?>">
    <div class="layoutImage"><img src="/templates/unify/layouts/default.jpg" /></div>
    <div class="layoutTitle">Layer Slider</div>	
  </div>

</div>
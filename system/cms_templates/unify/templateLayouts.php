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

<?php
//One Pager Sections 
$onepageIntro = '
 <!-- Intro Section -->
    <section id="intro" class="intro-section">
        <div class="fullscreenbanner-container">
            <div class="fullscreenbanner">
                <ul>
                    <!-- SLIDE  -->
                    <li data-transition="curtain-1" data-slotamount="5" data-masterspeed="700">
                        <!-- MAIN IMAGE -->
                        <img src="/templates/unify/One-Page/assets/img/sliders/revolution/bg1.jpg" alt="slidebg1" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">

                        <!-- LAYERS -->
                        <div class="tp-caption rs-caption-1 sft start"
                            data-x="center"
                            data-hoffset="0"
                            data-y="100"
                            data-speed="800"
                            data-start="2000"
                            data-easing="Back.easeInOut"
                            data-endspeed="300">
                            WE ARE UNIFY CREATIVE TECHNOLOGY COMPANY
                        </div>

                        <!-- LAYER -->
                        <div class="tp-caption rs-caption-2 sft"
                            data-x="center"
                            data-hoffset="0"
                            data-y="200"
                            data-speed="1000"
                            data-start="3000"
                            data-easing="Power4.easeOut"
                            data-endspeed="300"
                            data-endeasing="Power1.easeIn"
                            data-captionhidden="off"
                            style="z-index: 6">
                            Creative freedom matters user experience.<br>
                            We minimize the gap between technology and its audience.
                        </div>

                        <!-- LAYER -->
                        <div class="tp-caption rs-caption-3 sft"
                            data-x="center"
                            data-hoffset="0"
                            data-y="360"
                            data-speed="800"
                            data-start="3500"
                            data-easing="Power4.easeOut"
                            data-endspeed="300"
                            data-endeasing="Power1.easeIn"
                            data-captionhidden="off"
                            style="z-index: 6">
                            <span class="page-scroll"><a href="#about" class="btn-u btn-brd btn-brd-hover btn-u-light">Learn More</a></span>
                            <span class="page-scroll"><a href="#portfolio" class="btn-u btn-brd btn-brd-hover btn-u-light">Our Work</a></span>
                        </div>
                    </li>

                    <!-- SLIDE -->
                    <li data-transition="slideup" data-slotamount="5" data-masterspeed="1000">
                        <!-- MAIN IMAGE -->
                        <img src="/templates/unify/One-Page/assets/img/sliders/revolution/bg2.jpg" alt="slidebg1"  data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">

                        <!-- LAYERS -->
                        <div class="tp-caption rs-caption-1 sft start"
                            data-x="center"
                            data-hoffset="0"
                            data-y="100"
                            data-speed="800"
                            data-start="1500"
                            data-easing="Back.easeInOut"
                            data-endspeed="300">
                            DEDICATED ADVANCED TEAM
                        </div>

                        <!-- LAYER -->
                        <div class="tp-caption rs-caption-2 sft"
                            data-x="center"
                            data-hoffset="0"
                            data-y="200"
                            data-speed="1000"
                            data-start="2500"
                            data-easing="Power4.easeOut"
                            data-endspeed="300"
                            data-endeasing="Power1.easeIn"
                            data-captionhidden="off"
                            style="z-index: 6">
                            We are creative technology company providing<br> 
                            key digital services on web and mobile.                            
                        </div>

                        <!-- LAYER -->
                        <div class="tp-caption rs-caption-3 sft"
                            data-x="center"
                            data-hoffset="0"
                            data-y="360"
                            data-speed="800"
                            data-start="3500"
                            data-easing="Power4.easeOut"
                            data-endspeed="300"
                            data-endeasing="Power1.easeIn"
                            data-captionhidden="off"
                            style="z-index: 6">
                            <span class="page-scroll"><a href="#about" class="btn-u btn-brd btn-brd-hover btn-u-light">Learn More</a></span>
                            <span class="page-scroll"><a href="#portfolio" class="btn-u btn-brd btn-brd-hover btn-u-light">Our Work</a></span>
                        </div>
                    </li>

                    <!-- SLIDE -->
                    <li data-transition="slideup" data-slotamount="5" data-masterspeed="700">
                        <!-- MAIN IMAGE -->
                        <img src="/templates/unify/One-Page/assets/img/sliders/revolution/bg3.jpg"  alt="slidebg1"  data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat">

                        <!-- LAYERS -->
                        <div class="tp-caption rs-caption-1 sft start"
                            data-x="center"
                            data-hoffset="0"
                            data-y="110"
                            data-speed="800"
                            data-start="1500"
                            data-easing="Back.easeInOut"
                            data-endspeed="300">
                            WE DO THINGS DIFFERENTLY
                        </div>

                        <!-- LAYER -->
                        <div class="tp-caption rs-caption-2 sfb"
                            data-x="center"
                            data-hoffset="0"
                            data-y="210"
                            data-speed="800"
                            data-start="2500"
                            data-easing="Power4.easeOut"
                            data-endspeed="300"
                            data-endeasing="Power1.easeIn"
                            data-captionhidden="off"
                            style="z-index: 6">
                            Creative freedom matters user experience.<br>
                            We minimize the gap between technology and its audience.
                        </div>

                        <!-- LAYER -->
                        <div class="tp-caption rs-caption-3 sfb"
                            data-x="center"
                            data-hoffset="0"
                            data-y="370"
                            data-speed="800"
                            data-start="3500"
                            data-easing="Power4.easeOut"
                            data-endspeed="300"
                            data-endeasing="Power1.easeIn"
                            data-captionhidden="off"
                            style="z-index: 6">
                            <span class="page-scroll"><a href="#about" class="btn-u btn-brd btn-brd-hover btn-u-light">Learn More</a></span>
                            <span class="page-scroll"><a href="#portfolio" class="btn-u btn-brd btn-brd-hover btn-u-light">Our Work</a></span>
                        </div>
                    </li>                    
                </ul>
                <div class="tp-bannertimer tp-bottom"></div>
                <div class="tp-dottedoverlay twoxtwo"></div>
            </div>
        </div>
    </section>
    <!-- End Intro Section -->
';

$onepageAboutUs = '
    <!--  About Section -->
    <section id="about" class="about-section section-first">
        <div class="block-v1">
            <div class="container">
                <div class="row content-boxes-v3">
                    <div class="col-md-4 md-margin-bottom-30">
                        <i class="icon-custom rounded-x icon-bg-dark fa fa-lightbulb-o"></i>
                        <div class="content-boxes-in-v3">
                            <h2 class="heading-sm">Creative Desgin</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s</p>
                        </div>
                    </div>
                    <div class="col-md-4 md-margin-bottom-30">
                        <i class="icon-custom rounded-x icon-bg-dark fa fa-flask"></i>
                        <div class="content-boxes-in-v3">
                            <h2 class="heading-sm">Web Development</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s</p>
                        </div>
                    </div>
                    <div class="col-md-4 md-margin-bottom-30">
                        <i class="icon-custom rounded-x icon-bg-dark fa fa-bolt"></i>
                        <div class="content-boxes-in-v3">
                            <h2 class="heading-sm">Online Marketing</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s</p>
                        </div>
                    </div>
                </div>                
            </div>
        </div>

        <div class="about-image">
            <div class="container">
                <div class="title-v1">
                    <h1>We are Unify Agency</h1>
                    <p>Unify <strong>creative</strong> technology company providing key digital services. <br> 
                    Focused on helping our clients to build a <strong>successful</strong> business on web and mobile.</p>                
                </div>
                <div class="img-center">
                    <img class="img-responsive" src="/templates/unify/One-Page/assets/img/mockup/mockup.png" alt="">
                </div>
            </div>
        </div>        

        <div class="container content-lg">
            <div class="title-v1">
                <h2>Our Vision And Mission</h2>
                <p>We <strong>meet</strong> and get to know you. You tell us and we listen. <br> 
                We build your website to realise your vision and we <strong>deliver</strong> the ready product.</p>
            </div>

            <div class="row">
                <div class="col-md-6 content-boxes-v3 margin-bottom-40">
                    <div class="clearfix margin-bottom-30">
                        <i class="icon-custom icon-md rounded-x icon-bg-u icon-line icon-trophy"></i>
                        <div class="content-boxes-in-v3">
                            <h2 class="heading-sm">Innovation Leader</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s</p>
                        </div>
                    </div>
                    <div class="clearfix margin-bottom-30">
                        <i class="icon-custom icon-md rounded-x icon-bg-u icon-line icon-directions"></i>
                        <div class="content-boxes-in-v3">
                            <h2 class="heading-sm">Best Solutions &amp; Approaches</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s</p>
                        </div>
                    </div>
                    <div class="clearfix margin-bottom-30">
                        <i class="icon-custom icon-md rounded-x icon-bg-u icon-line icon-diamond"></i>
                        <div class="content-boxes-in-v3">
                            <h2 class="heading-sm">Quality Service &amp; Support</h2>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <img class="img-responsive" src="/templates/unify/One-Page/assets/img/mockup/mockup1.png" alt="">
                </div>
            </div>
        </div>        

        <div class="parallax-quote parallaxBg">
            <div class="container">
                <div class="parallax-quote-in">
                    <p>If you can design one thing <span class="color-green">you can design</span> everything. <br> Just Believe It.</p>
                    <small>- HtmlStream -</small>
                </div>
            </div>
        </div>        

        <div class="team content-lg">
            <div class="container">
                <div class="title-v1">
                    <h2>Meet Our Team</h2>
                    <p>We <strong>meet</strong> and get to know you. You tell us and we listen. <br> 
                    We build your website to realise your vision and we <strong>deliver</strong> the ready product.</p>
                </div>

                <ul class="list-unstyled row">
                    <li class="col-sm-3 col-xs-6 md-margin-bottom-30">
                        <div class="team-img">
                            <img class="img-responsive" src="/templates/unify/One-Page/assets/img/team/img1-md.jpg" alt="">
                            <ul>
                                <li><a href="#"><i class="icon-custom icon-sm rounded-x fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="icon-custom icon-sm rounded-x fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="icon-custom icon-sm rounded-x fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                        <h3>John Brown</h3>
                        <h4>/ Technical Director</h4>
                        <p>Technical Director mi porta gravida at eget metus id elit mi egetine...</p>
                    </li>
                    <li class="col-sm-3 col-xs-6 md-margin-bottom-30">
                        <div class="team-img">
                            <img class="img-responsive" src="/templates/unify/One-Page/assets/img/team/img2-md.jpg" alt="">
                            <ul>
                                <li><a href="#"><i class="icon-custom icon-sm rounded-x fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="icon-custom icon-sm rounded-x fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="icon-custom icon-sm rounded-x fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                        <h3>Tina Krueger</h3>
                        <h4>/ Lead Designer</h4>
                        <p>Lead Designer mi porta gravida at eget metus id elit mi egetine...</p>
                    </li>
                    <li class="col-sm-3 col-xs-6">
                        <div class="team-img">
                            <img class="img-responsive" src="/templates/unify/One-Page/assets/img/team/img3-md.jpg" alt="">
                            <ul>
                                <li><a href="#"><i class="icon-custom icon-sm rounded-x fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="icon-custom icon-sm rounded-x fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="icon-custom icon-sm rounded-x fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                        <h3>David Case</h3>
                        <h4>/ Web Developer</h4>
                        <p>Web Developer in Unify agency porta gravida at eget metus id elit...</p>
                    </li>
                    <li class="col-sm-3 col-xs-6">
                        <div class="team-img">
                            <img class="img-responsive" src="/templates/unify/One-Page/assets/img/team/img5-md.jpg" alt="">
                            <ul>
                                <li><a href="#"><i class="icon-custom icon-sm rounded-x fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="icon-custom icon-sm rounded-x fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="icon-custom icon-sm rounded-x fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                        <h3>Kathy Reyes</h3>
                        <h4>/ Creative Designer</h4>
                        <p>Former Designer in Twitter non mi porta gravida at elit mi egetine...</p>
                    </li>
                </ul>                
            </div>
        </div>

        <div class="parallax-counter parallaxBg">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3 col-xs-6">
                        <div class="counters">
                            <span class="counter">10629</span>   
                            <h4>Users</h4>
                        </div>    
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="counters">
                            <span class="counter">277</span> 
                            <h4>Projects</h4>
                        </div>    
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="counters">
                            <span class="counter">78</span>
                            <h4>Team Members</h4>
                        </div>    
                    </div>
                    <div class="col-sm-3 col-xs-6">
                        <div class="counters">
                            <span class="counter">109</span>
                            <h4>Awards</h4>
                        </div>    
                    </div>
                </div>            
            </div>
        </div>        
    </section>
    <!--  About Section -->
';

$onepageServices = '
<!-- Services Section -->
    <section id="services">
        <div class="container content-lg">
            <div class="title-v1">
                <h2>Our Services</h2>
                <p>We do <strong>things</strong> differently company providing key digital services. <br> 
                Focused on helping our clients to build a <strong>successful</strong> business on web and mobile.</p>                
            </div>            
    
            <div class="row service-box-v1">
                <div class="col-md-4 col-sm-6">
                    <div class="servive-block servive-block-default">
                        <i class="icon-custom icon-lg icon-bg-u rounded-x fa fa-lightbulb-o"></i>
                        <h2 class="heading-md">Web Design &amp; Development</h2>
                        <p>Donec id elit non mi porta gravida at eget metus id elit mi egetine. Fusce dapibus</p>
                        <ul class="list-unstyled">
                            <li>Logo &amp; Brand Design</li>
                            <li>Mobile Development</li>
                            <li>E-commerce</li>
                            <li>App &amp; Icon Design</li>
                            <li>Responsive Web Desgin</li>
                        </ul>                        
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="servive-block servive-block-default">
                        <i class="icon-custom icon-lg icon-bg-u rounded-x icon-line icon-present"></i>
                        <h2 class="heading-sm">Marketing &amp; Cunsulting</h2>
                        <p>Donec id elit non mi porta gravida at eget metus id elit mi egetine usce dapibus elit nondapibus</p>
                        <ul class="list-unstyled">
                            <li>Analysis &amp; Consulting</li>
                            <li>Mobile Development</li>
                            <li>Email Marketing</li>
                            <li>App &amp; Icon Design</li>
                            <li>Responsive Web Desgin</li>
                        </ul>                        
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="servive-block servive-block-default">            
                        <i class="icon-custom icon-lg icon-bg-u rounded-x icon-line icon-rocket"></i>
                        <h2 class="heading-sm">SEO &amp; Advertising</h2>
                        <p>Donec id elit non mi porta gravida at eget metus id elit mi egetine. Fusce dapibus</p>
                        <ul class="list-unstyled">
                            <li>Google AdSense</li>
                            <li>Social Media</li>
                            <li>Display Advertising</li>
                            <li>App &amp; Icon Design</li>
                            <li>Analysis &amp; Consulting</li>
                        </ul>                        
                    </div>
                </div>
            </div>
        </div>

        
        <ul class="list-unstyled row portfolio-box-v1">
            <li class="col-sm-4">
                <img class="img-responsive" src="/templates/unify/One-Page/assets/img/mockup/img1.jpg" alt="">
                <div class="portfolio-box-v1-in">
                    <h3>Collective Package</h3>
                    <p>Web Design, Mock-up</p>
                    <a class="btn-u btn-u-sm btn-brd btn-brd-hover btn-u-light" href="#">Read More</a>
                </div>
            </li>
            <li class="col-sm-4">
                <img class="img-responsive" src="/templates/unify/One-Page/assets/img/mockup/img2.jpg" alt="">
                <div class="portfolio-box-v1-in">
                    <h3>Ahola Company</h3>
                    <p>Brand Design, UI</p>
                    <a class="btn-u btn-u-sm btn-brd btn-brd-hover btn-u-light" href="#">Read More</a>
                </div>
            </li>
            <li class="col-sm-4">
                <img class="img-responsive" src="/templates/unify/One-Page/assets/img/mockup/img4.jpg" alt="">
                <div class="portfolio-box-v1-in">
                    <h3>Allan Project</h3>
                    <p>Web Development, HTML5</p>
                    <a class="btn-u btn-u-sm btn-brd btn-brd-hover btn-u-light" href="#">Read More</a>
                </div>
            </li>
        </ul>
        
        <div class="call-action-v1">
            <div class="container">
                <div class="inner">
                    <div class="inner1">
                        <p>Unify creative technology company providing key digital services and focused on helping our clients to build a successful business on web and mobile.</p>
                    </div>
                    <div class="inner1 inner-btn page-scroll">
                        <a href="#portfolio" class="btn-u btn-brd btn-brd-hover btn-u-dark btn-u-block">View Our Portfolio</a>
                    </div>
                </div>
            </div>
        </div>                    
    </section>
    <!-- End Services Section -->
';

$onepageNews = '
<!-- News Section -->
    <section id="news" class="news-section">
        <div class="container content-lg">
            <div class="title-v1">
                <h2>Latest News</h2>
                <p>We do <strong>things</strong> differently company providing key digital services. <br> 
                Focused on helping our clients to build a <strong>successful</strong> business on web and mobile.</p>             
            </div>

            <div class="row news-v1">
                <div class="col-md-4 md-margin-bottom-40">
                    <div class="news-v1-in">
                        <img class="img-responsive" src="/templates/unify/One-Page/assets/img/contents/img1.jpg" alt="">
                        <h3><a href="#">Focused on helping our clients to build a successful business</a></h3>
                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores.</p>
                        <ul class="list-inline news-v1-info">
                            <li><span>By</span> <a href="#">Kathy Reyes</a></li>
                            <li>|</li>
                            <li><i class="fa fa-clock-o"></i> July 02, 2014</li>
                            <li class="pull-right"><a href="#"><i class="fa fa-comments-o"></i> 14</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 md-margin-bottom-40">
                    <div class="news-v1-in">
                        <img class="img-responsive" src="/templates/unify/One-Page/assets/img/contents/img4.jpg" alt="">
                        <h3><a href="#">We build your website to realise your vision and best product</a></h3>
                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores.</p>
                        <ul class="list-inline news-v1-info">
                            <li><span>By</span> <a href="#">John Clarck</a></li>
                            <li>|</li>
                            <li><i class="fa fa-clock-o"></i> July 02, 2014</li>
                            <li class="pull-right"><a href="#"><i class="fa fa-comments-o"></i> 07</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="news-v1-in">
                        <img class="img-responsive" src="/templates/unify/One-Page/assets/img/contents/img3.jpg" alt="">
                        <h3><a href="#">Focused on helping our clients to build a successful business</a></h3>
                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores.</p>
                        <ul class="list-inline news-v1-info">
                            <li><span>By</span> <a href="#">Tina Kruiger</a></li>
                            <li>|</li>
                            <li><i class="fa fa-clock-o"></i> July 02, 2014</li>
                            <li class="pull-right"><a href="#"><i class="fa fa-comments-o"></i> 22</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="parallax-twitter parallaxBg">
            <div class="container parallax-twitter-in">
                <div class="margin-bottom-30">
                    <i class="icon-custom rounded-x icon-bg-blue fa fa-twitter"></i>
                </div>

                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <ul class="list-unstyled owl-twitter-v1">
                            <li class="item">
                                <p>Unify has reached 10000 plus sales and we just want to thank you to our all customers for being part of the Unify Template success <a href="http://bit.ly/1c0UN3Y">http://bit.ly/1c0UN3Y</a><p>
                                <span>3 min ago via <a href="https://twitter.com/htmlstream">@htmlstream</a></span>
                            </li>
                            <li class="item">
                                <p><a href="#">@htmlstream</a> jQuery lightGallery - Lightweight jQuery lightbox gallery for displaying image and video gallery <a href="#">http://sachinchoolur.github.io/lightGallery</a> <a href="#">#javascript</a></p>
                                <span>10 min ago Retweeted by <a href="https://twitter.com/htmlstream">@twbootstrap</a></span>
                            </li>
                            <li class="item">
                                <p>New 100% Free Stock Photos. Every. Single. Day. Everything you need for your creative projects. <a href="#">http://publicdomainarchive.com</a></p>
                                <span>30 min ago via <a href="https://twitter.com/htmlstream">@wrapbootstrap</a></span>
                            </li>
                        </ul>                    
                    </div>
                </div>
            </div>
        </div> 
    </section>
    <!-- End News Section -->
';

$onepagePortfolio = '
<!-- Portfolio Section -->
    <section id="portfolio" class="about-section">
        <div class="container content-lg">
            <div class="title-v1">
                <h2>Our Portfolio</h2>
                <p>We do <strong>things</strong> differently company providing key digital services. <br> 
                Focused on helping our clients to build a <strong>successful</strong> business on web and mobile.</p>                
            </div>
            <div class="wrapper-portfolio">
                <div id="filters-container" class="cbp-l-filters-alignLeft">
                    <div data-filter="*" class="cbp-filter-item-active cbp-filter-item">All (<span class="cbp-filter-counter"></span> items)</div>
                    <div data-filter=".print" class="cbp-filter-item">Print (<span class="cbp-filter-counter"></span> items)</div>
                    <div data-filter=".web-design" class="cbp-filter-item">Web Design (<span class="cbp-filter-counter"></span> items)</div>
                    <div data-filter=".motion" class="cbp-filter-item">Motion (<span class="cbp-filter-counter"></span> items)</div>
                </div>

                <div id="grid-container" class="cbp-l-grid-gallery">
                    <ul>
                        <li class="cbp-item print motion">
                            <a href="/templates/unify/One-Page/assets/ajax/project1.html" class="cbp-caption cbp-singlePageInline" data-title="World Clock Widget<br>by Paul Flavius Nechita">
                                <div class="cbp-caption-defaultWrap">
                                    <img src="/templates/unify/One-Page/assets/img/portfolio/1.jpg" alt="" width="100%">
                                </div>
                                <div class="cbp-caption-activeWrap">
                                    <div class="cbp-l-caption-alignLeft">
                                        <div class="cbp-l-caption-body">
                                            <div class="cbp-l-caption-title">World Clock Widget</div>
                                            <div class="cbp-l-caption-desc">by Paul Flavius Nechita</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="cbp-item web-design">
                            <a href="/templates/unify/One-Page/assets/ajax/project2.html" class="cbp-caption cbp-singlePageInline" data-title="Bolt UI<br>by Tiberiu Neamu">
                                <div class="cbp-caption-defaultWrap">
                                    <img src="/templates/unify/One-Page/assets/img/portfolio/2.jpg" alt="" width="100%">
                                </div>
                                <div class="cbp-caption-activeWrap">
                                    <div class="cbp-l-caption-alignLeft">
                                        <div class="cbp-l-caption-body">
                                            <div class="cbp-l-caption-title">Bolt UI</div>
                                            <div class="cbp-l-caption-desc">by Tiberiu Neamu</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="cbp-item print motion">
                            <a href="/templates/unify/One-Page/assets/ajax/project3.html" class="cbp-caption cbp-singlePageInline" data-title="WhereTO App<br>by Tiberiu Neamu">
                                <div class="cbp-caption-defaultWrap">
                                    <img src="/templates/unify/One-Page/assets/img/portfolio/3.jpg" alt="" width="100%">
                                </div>
                                <div class="cbp-caption-activeWrap">
                                    <div class="cbp-l-caption-alignLeft">
                                        <div class="cbp-l-caption-body">
                                            <div class="cbp-l-caption-title">WhereTO App</div>
                                            <div class="cbp-l-caption-desc">by Tiberiu Neamu</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="cbp-item web-design print">
                            <a href="/templates/unify/One-Page/assets/ajax/project4.html" class="cbp-caption cbp-singlePageInline" data-title="iDevices<br>by Tiberiu Neamu">
                                <div class="cbp-caption-defaultWrap">
                                    <img src="/templates/unify/One-Page/assets/img/portfolio/11.jpg" alt="" width="100%">
                                </div>
                                <div class="cbp-caption-activeWrap">
                                    <div class="cbp-l-caption-alignLeft">
                                        <div class="cbp-l-caption-body">
                                            <div class="cbp-l-caption-title">iDevices</div>
                                            <div class="cbp-l-caption-desc">by Tiberiu Neamu</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="cbp-item motion">
                            <a href="/templates/unify/One-Page/assets/ajax/project5.html" class="cbp-caption cbp-singlePageInline" data-title="Seemple* Music for iPad<br>by Tiberiu Neamu">
                                <div class="cbp-caption-defaultWrap">
                                    <img src="/templates/unify/One-Page/assets/img/portfolio/5.jpg" alt="" width="100%">
                                </div>
                                <div class="cbp-caption-activeWrap">
                                    <div class="cbp-l-caption-alignLeft">
                                        <div class="cbp-l-caption-body">
                                            <div class="cbp-l-caption-title">Seemple* Music for iPad</div>
                                            <div class="cbp-l-caption-desc">by Tiberiu Neamu</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="cbp-item print motion">
                            <a href="/templates/unify/One-Page/assets/ajax/project6.html" class="cbp-caption cbp-singlePageInline" data-title="Remind~Me Widget<br>by Tiberiu Neamu">
                                <div class="cbp-caption-defaultWrap">
                                    <img src="/templates/unify/One-Page/assets/img/portfolio/6.jpg" alt="" width="100%">
                                </div>
                                <div class="cbp-caption-activeWrap">
                                    <div class="cbp-l-caption-alignLeft">
                                        <div class="cbp-l-caption-body">
                                            <div class="cbp-l-caption-title">Remind~Me Widget</div>
                                            <div class="cbp-l-caption-desc">by Tiberiu Neamu</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="cbp-item web-design print">
                            <a href="/templates/unify/One-Page/assets/ajax/project7.html" class="cbp-caption cbp-singlePageInline" data-title="Workout Buddy<br>by Tiberiu Neamu">
                                <div class="cbp-caption-defaultWrap">
                                    <img src="/templates/unify/One-Page/assets/img/portfolio/7.jpg" alt="" width="100%">
                                </div>
                                <div class="cbp-caption-activeWrap">
                                    <div class="cbp-l-caption-alignLeft">
                                        <div class="cbp-l-caption-body">
                                            <div class="cbp-l-caption-title">Workout Buddy</div>
                                            <div class="cbp-l-caption-desc">by Tiberiu Neamu</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="cbp-item print">
                            <a href="/templates/unify/One-Page/assets/ajax/project8.html" class="cbp-caption cbp-singlePageInline" data-title="Digital Menu<br>by Cosmin Capitanu">
                                <div class="cbp-caption-defaultWrap">
                                    <img src="/templates/unify/One-Page/assets/img/portfolio/8.jpg" alt="" width="100%">
                                </div>
                                <div class="cbp-caption-activeWrap">
                                    <div class="cbp-l-caption-alignLeft">
                                        <div class="cbp-l-caption-body">
                                            <div class="cbp-l-caption-title">Digital Menu</div>
                                            <div class="cbp-l-caption-desc">by Cosmin Capitanu</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="cbp-item motion">
                            <a href="/templates/unify/One-Page/assets/ajax/project9.html" class="cbp-caption cbp-singlePageInline" data-title="Holiday Selector<br>by Cosmin Capitanu">
                                <div class="cbp-caption-defaultWrap">
                                    <img src="/templates/unify/One-Page/assets/img/portfolio/4.jpg" alt="" width="100%">
                                </div>
                                <div class="cbp-caption-activeWrap">
                                    <div class="cbp-l-caption-alignLeft">
                                        <div class="cbp-l-caption-body">
                                            <div class="cbp-l-caption-title">Holiday Selector</div>
                                            <div class="cbp-l-caption-desc">by Cosmin Capitanu</div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="cbp-l-loadMore-button">
                    <a href="/templates/unify/One-Page/assets/ajax/loadMore.html" class="cbp-l-loadMore-button-link">LOAD MORE</a>
                </div>
            </div>
        </div>

        <div class="clients-section parallaxBg">
            <div class="container">
                <div class="title-v1">
                    <h2>Our Clients</h2>
                </div>            
                <ul class="owl-clients-v2">
                    <li class="item"><a href="#"><img src="/templates/unify/One-Page/assets/img/clients/national-geographic.png" alt=""></a></li>
                    <li class="item"><a href="#"><img src="/templates/unify/One-Page/assets/img/clients/inspiring.png" alt=""></a></li>
                    <li class="item"><a href="#"><img src="/templates/unify/One-Page/assets/img/clients/fred-perry.png" alt=""></a></li>
                    <li class="item"><a href="#"><img src="/templates/unify/One-Page/assets/img/clients/emirates.png" alt=""></a></li>
                    <li class="item"><a href="#"><img src="/templates/unify/One-Page/assets/img/clients/baderbrau.png" alt=""></a></li>
                    <li class="item"><a href="#"><img src="/templates/unify/One-Page/assets/img/clients/inspiring.png" alt=""></a></li>
                </ul>            
            </div>
        </div>

        <div class="testimonials-v3">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <ul class="list-unstyled owl-ts-v1">
                            <li class="item">
                                <img class="rounded-x img-bordered" src="/templates/unify/One-Page/assets/img/team/img3-sm.jpg" alt="">
                                <div class="testimonials-v3-title">
                                    <p>David Case</p>
                                    <span>Web Developer, Google</span>
                                </div>
                                <p>I just wanted to tell you how much I like to use Unify - <strong>it\'s so sleek and elegant!</strong> <br>
                                The customisation options you implemented are countless, and I feel sorry I can\'t use them all. Good job, and keep going!<p>
                            </li>
                            <li class="item">
                                <img class="rounded-x img-bordered" src="/templates/unify/One-Page/assets/img/team/img2-sm.jpg" alt="">
                                <div class="testimonials-v3-title">
                                    <p>Tina Krueger</p>
                                    <span>UI Designer, Apple</span>
                                </div>                                
                                <p>Keep up the great work. Your template is by far the best on the market in terms of features, quality and value or money.</p>
                            </li>
                            <li class="item">
                                <img class="rounded-x img-bordered" src="/templates/unify/One-Page/assets/img/team/img1-sm.jpg" alt="">
                                <div class="testimonials-v3-title">
                                    <p>John Clarck</p>
                                    <span>Marketing &amp; Cunsulting, IBM</span>
                                </div>
                                <p>So far I really like the theme. I am looking forward to exploring more of your themes. Thank you!</p>
                            </li>
                        </ul>
                    </div>                    
                </div>
            </div>
        </div>                 
    </section>
    <!-- End Portfolio Section -->
';

$onepageContact = '
<!-- Contact Section -->
    <section id="contact" class="contacts-section">
        <div class="container content-lg">
            <div class="title-v1">
                <h2>Contact Us</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. <br>
                It has been the industry\'s standard dummy text.</p>
            </div>

            <div class="row contacts-in">
                <div class="col-md-6 md-margin-bottom-40">
                    <ul class="list-unstyled">
                        <li><i class="fa fa-home"></i> 5B Streat, City 50987 New Town US</li>
                        <li><i class="fa fa-phone"></i> 1(800) 220 084</li>
                        <li><i class="fa fa-envelope"></i> <a href="info@example.com">info@example.com</a></li>
                        <li><i class="fa fa-globe"></i> <a href="http://htmlstream.com">www.htmlstream.com</a></li>
                    </ul>
                </div>

                <div class="col-md-6">
                        <label>Name</label>
                        <div class="row margin-bottom-20">
                            <div class="col-md-7 col-md-offset-0">
                                <input type="text" class="form-control">
                            </div>                
                        </div>
                        
                        <label>Email <span class="color-red">*</span></label>
                        <div class="row margin-bottom-20">
                            <div class="col-md-7 col-md-offset-0">
                                <input type="text" class="form-control">
                            </div>                
                        </div>
                        
                        <label>Message</label>
                        <div class="row margin-bottom-20">
                            <div class="col-md-11 col-md-offset-0">
                                <textarea rows="8" class="form-control"></textarea>
                            </div>                
                        </div>
                        
                        <p><button type="submit" class="btn-u btn-brd btn-brd-hover btn-u-dark">Send Message</button></p>
                </div>
            </div>            
        </div>

        <div class="copyright-section">
            <p>2014 &copy; All Rights Reserved. Unify Theme by <a target="_blank" href="https://twitter.com/htmlstream">Htmlstream</a></p>
            <ul class="social-icons">
                <li><a href="#" data-original-title="Facebook" class="social_facebook rounded-x"></a></li>
                <li><a href="#" data-original-title="Twitter" class="social_twitter rounded-x"></a></li>
                <li><a href="#" data-original-title="Goole Plus" class="social_googleplus rounded-x"></a></li>
                <li><a href="#" data-original-title="Pinterest" class="social_pintrest rounded-x"></a></li>
                <li><a href="#" data-original-title="Linkedin" class="social_linkedin rounded-x"></a></li>
            </ul>
            <span class="page-scroll"><a href="#intro"><i class="fa fa-angle-double-up back-to-top"></i></a></span>
        </div>
    </section>
    <!-- End Contact Section -->
';
?>
<div class="acc-section-trigger"><i class="fa fa-fw fa-file-code-o"></i> One-Page Sections</div>
<div class="acc-section-content custom-scroll">
  <div class="layoutItem ui-element" data-code="<?php echo htmlentities($onepageIntro); ?>">
    <div class="layoutImage"><img src="/templates/unify/layouts/default.jpg" /></div>
    <div class="layoutTitle">Intro</div>
  </div>
  <div class="layoutItem ui-element" data-code="<?php echo htmlentities($onepageAboutUs); ?>">
    <div class="layoutImage"><img src="/templates/unify/layouts/default.jpg" /></div>
    <div class="layoutTitle">About Us</div>
  </div>
  <div class="layoutItem ui-element" data-code="<?php echo htmlentities($onepageServices); ?>">
    <div class="layoutImage"><img src="/templates/unify/layouts/default.jpg" /></div>
    <div class="layoutTitle">Services</div>
  </div>
  <div class="layoutItem ui-element" data-code="<?php echo htmlentities($onepageNews); ?>">
    <div class="layoutImage"><img src="/templates/unify/layouts/default.jpg" /></div>
    <div class="layoutTitle">News</div>
  </div>
  <div class="layoutItem ui-element" data-code="<?php echo htmlentities($onepagePortfolio); ?>">
    <div class="layoutImage"><img src="/templates/unify/layouts/default.jpg" /></div>
    <div class="layoutTitle">Portfolio</div>
  </div>
</div>



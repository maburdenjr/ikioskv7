// JavaScript Document
function iKioskUI() {
	
	//Large Inputs
	//$('.smart-form input, .smart-form select').addClass('input-lg');
	//$('.modal .smart-form input, .modal .smart-form select').removeClass('input-lg');
	
	updateUI();
	
	//Window Resize Controls
	$(window).on('resize', function() {
		updateUI();	
	});
	
	function updateUI() {
		var windowHeight = $(this).height();
		var windowWidth = $(this).width();
		if (windowWidth > 979) {
			$('#iKioskMMWrapper').css('min-height', windowHeight-119);		
		} else {
			$('#iKioskMMWrapper').css('min-height', windowHeight);		
		}
		$('body.mobile-view-activated aside#left-panel, .animating aside#left-panel').css('max-height', windowHeight);	
	}
	
	//Mobile Menu Toggle
	var isTouch = !!('ontouchstart' in window)
	TorC = isTouch ? 'touchstart' : 'click';

	$('header').on("touchstart click", '#hide-menu a', function(e) {
			e.preventDefault();
			e.stopPropagation();
			var $html = $('html');
			var $body = $('body');
			var $page = $('#iKioskUiWrapper');
			transitionEnd = 'transitionend webkitTransitionEnd otransitionend MSTransitionEnd';
			
			$body.addClass('animating');
			
			if ($html.hasClass( 'hidden-menu-mobile-lock' ) ) {
				 $body.addClass('right');
				} else {
				 $body.addClass('left');
			 }
								 
			$page.on(transitionEnd, function() {
				 $body.removeClass('animating left right');
				 $html.toggleClass('hidden-menu-mobile-lock');
				 $('#left-panel').toggleClass('menu-visible');
				 $page.off( transitionEnd );
			});
	});	
	//Dynamic Modal
	function dynamicModal(targetURL) {
		$('#dynamicModal .modal-content').html("<div class='modal-body'><i class='fa fa-cog fa-spin'></i> Loading..</div>").fadeIn('slow');	
		$.ajax({
			url: targetURL,
			timeout: 10000,	
			error: function(data) {
				var error="<div class='alert alert-danger fade in'><a class='close' data-dismiss='alert' href='#'>×</a> An unknown error has occurred.  Please try again.</div>";
				$('#dynamicModal .modal-body').html(error).fadeIn('slow');
			},	
			success: function(data) {
				$('#dynamicModal .modal-content').html(data).fadeIn('slow');
				$('#dynamicModal .page-title').appendTo('#dynamicModal .modal-title');
			}
		});	
	}
	
	
	$(document).on('click', '.dynamicModal', function(e){
		e.preventDefault();
		e.stopPropagation();
		var targetURL = $(this).attr("href");
		dynamicModal(targetURL);
	});
	
	$(document).on("click", 'nav a[target="modal"]', function (a) {
		a.preventDefault();
		a.stopPropagation();
		var targetURL = $(this).attr("href");
		dynamicModal(targetURL);
		$('#dynamicModal').modal('show');
	}),
	
	//Dynamic File Browser
	$(document).on('click', '.browserLink', function(){
		event.stopPropagation();
		var directory = $(this).data('directory');
		var record = $(this).data('record');
		$.ajax({
					url: "includes/core/formProcessor.php",	
					data: {appCode: "IKMCP", ajaxAction: "softwareFileBrowser", directory: directory, recordID: record},
					timeout: 10000,
				error: function(data) {
						var error="<div class='alert alert-danger fade in'><a class='close' data-dismiss='alert' href='#'>×</a> An unknown error has occurred.  Please try again.</div>";
						$('.form-response').html(error).fadeIn('slow');
				},
				success: function(data) {
						$('#editCtn-IkioskcloudSoftware-fileBrowser .widget-body').html(data).fadeIn('slow');
				}
			});
		
	});
	
	//Display Progress Bar
	function progressBar() {
		var progressBar = "<div class='progress progress-sm progress-striped active'><div class='progress-bar bg-color-blue' style='width: 0px'></div></div>";		
		$('.system-message').html(progressBar).fadeIn();
		$('.system-message .progress-bar').animate({
				width: "100%"
				}, 
				{duration: 500,
				complete: function () {
					setTimeout(function(){
					}, 600);
				}
			});
	}
	
	//Custom Actions
	$(document).on('click', '.icon-action', function(){
			event.stopPropagation();
			var iconAction = $(this).data('type');
			var code = $(this).data("code");
			var record = $(this).data("record");
			var file = $(this).data('file');

				progressBar();
				$.ajax({
							url: "includes/core/formProcessor.php",	
							data: {appCode: code, ajaxAction: iconAction, recordID: record, file: file},
							timeout: 600000,
							error: function(data) {
									var error="<div class='alert alert-danger fade in'><a class='close' data-dismiss='alert' href='#'>×</a> An unknown error has occurred.  Please try again.</div>";
									$('.system-message').html(error).fadeIn('slow');
							},
							success: function(data) {
									$('.system-message').html(data).fadeIn('slow');
	
							}
					});
	}); // End Custom Actions
	
	//Delete Records
	$(document).on('click', '.delete-record', function(){
		event.stopPropagation();
		var deleteRecord = confirm("Are you sure you want to delete this item?");
		if (deleteRecord == true) {
			$('.system-message').hide();
			var table = $(this).data("table");
			var record = $(this).data("record");
			var code = $(this).data("code");
			var field = $(this).data("field");
			$.ajax({
							url: "includes/core/formProcessor.php",
							data: {table: table, record: record, appCode: code, ajaxAction: "deleteRecord", field: field},
							timeout: 3000,
							error: function(data) {
									var error="<div class='alert alert-danger fade in'><a class='close' data-dismiss='alert' href='#'>×</a> An unknown error has occurred.  Please try again.</div>";
									$('.system-message').html(error).fadeIn('slow');
							},
							success: function(data) {
									$('.system-message').html(data).fadeIn('slow');
									$('.jarviswidget-refresh-btn').click();
							}
				});
		}
	});
	
	//Slide Toggle
	$('.btn-toggle').on('click', function(){
		var openTarget = $(this).data("open");
		var closeTarget = $(this).data("close");
		$('#'+openTarget+', #'+openTarget+' .jarviswidget').fadeIn();
		$('#'+closeTarget).hide();
	});
	
	$('.btn-close-panel').on('click', function(){
		var targetPanel = $(this).data("target");
		$('#'+targetPanel).fadeOut();
	});

}

//AJAX Form Processing
function submitAjaxForm(formID) {
	var targetForm = "#"+formID;
	var formData = $(targetForm).serialize();
	$(targetForm+' button').attr("disabled", "disabled");
	$(targetForm+ ' section').css("opacity", 0.2);
	var progressBar = "<div class='progress progress-sm progress-striped active'><div class='progress-bar bg-color-blue' style='width: 0px'></div></div>";	
		$(targetForm+' .form-response').html(progressBar).fadeIn();
		$(targetForm+' .form-response .progress-bar').animate({
				width: "100%"
				}, 
				{duration: 500,
				complete: function () {
					setTimeout(function(){
					$.ajax({
								type:"POST",
								data: formData,
								url: "includes/core/formProcessor.php",
								timeout: 3000,
								error: function(data) {
										var error="<div class='alert alert-danger fade in'><a class='close' data-dismiss='alert' href='#'>×</a> An unknown error has occurred.  Please try again.</div>";
										$(targetForm+' .form-response').html(error);
										$(targetForm+' button').removeAttr("disabled");
										$(targetForm+ ' section').css("opacity", 1);
								},
								success: function(data) {
										$(targetForm+' .form-response').html(data);
										$(targetForm+' button').removeAttr("disabled");
										$(targetForm+ ' section').css("opacity", 1);
								}
					});
					}, 1200);
				}
		});
}



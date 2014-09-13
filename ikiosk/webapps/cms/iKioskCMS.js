// JavaScript Document
function iKioskUI() {
	
	var base_url = $('#ikiosk_keys .site_url').val();
	
	//Admin Modal
	$(document).on('touchstart click', '#cms-menu', function(e) {
		 e.preventDefault();
		var $body = $( '#dynModalWrapper'),
     		$page = $( '#dynModalContent'),
      		$menu = $( '#dynModalMenu'),
			transitionEnd = 'transitionend webkitTransitionEnd otransitionend MSTransitionEnd';
			
		$body.addClass( 'animating' );
		if ( $body.hasClass( 'menu-visible' ) ) {
		   $body.addClass( 'right' );
		  } else {
		   $body.addClass( 'left' );
		  }
		  
		 $page.on( transitionEnd, function() {
		   $body
			.removeClass( 'animating left right' )
			.toggleClass( 'menu-visible' );
		 
		   $page.off( transitionEnd );
		  }); 
	});
	
	$(document).on('touchstart click', '#dynModalMenu .modalDynLink', function(e) {
		$('#cms-menu').click();	
	});
	
	//Admin Modal Ajax
	$(document).on('touchstart click', '.modalDynLink', function(e) {
		e.preventDefault();
		e.stopPropagation();	
		var targetURL = $(this).attr('href');
		$('#dynModalContent').html("<div class='modal-body'><i class='fa fa-cog fa-spin'></i> Loading..</div>").fadeIn('slow');	
		$.ajax({
			url: targetURL,
			timeout: 10000,	
			error: function(data) {
				var error="<div class='alert alert-danger fade in'><a class='close' data-dismiss='alert' href='#'>×</a> An unknown error has occurred.  Please try again.</div>";
				$('#dynModalContent').html(error).fadeIn('slow');
			},	
			success: function(data) {
				$('#dynModalContent').html(data).fadeIn('slow');
			}
		});
	});
	
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
							url: "/cms/ajaxHandler.php",
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
	
	//Dynamic Modal
	$('.ikiosk-cms-editor').on("touchstart click", 'a.dynamicModal', function(e) {
		e.preventDefault();
		e.stopPropagation();
		var targetURL = $(this).attr('href');
		dynamicModal(targetURL);
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
			}
		});
		$('#dynamicModal').modal({
			 show: true,  
			 backdrop: 'static'
		});
	}

	//Edit Page Toggle
	$('#iKioskCMSheader').on("touchstart click", '#editPage a', function(e) {
		e.preventDefault();
		$('#iKioskCMSheader a').removeClass('active');
		$(this).toggleClass('active');
		$('#iKioskCMSdisplay').hide();
		$('#iKioskCMSeditor').show();
	  $("#iKioskCMS-editContent").validate({
				errorPlacement : function(error, element) {
					error.insertAfter(element.parent());
				},
				submitHandler: function(form) {
					var targetForm = $(this.currentForm).attr("id");
					 submitAjaxForm(targetForm);
				 }
       });
	});
	
	//Cancel Page Edit
	$('#iKioskCMSeditor').on("click", '.editContentCancel', function(e) {
		e.preventDefault();
		var cancelEdit = confirm("Are you sure you want to cancel and discard changes.");
		if (cancelEdit == true) {
			$('#iKioskCMSheader a').removeClass('active');
			$('#iKioskCMSdisplay').show();
			$('#iKioskCMSeditor').hide();
			$('#iKioskCMS-editContent #redactorEditor').html(original_html);
		}
	});
	if ($('.redactor-editor').length) {
		//Redactor Editor
		$('.redactor-editor').redactor({ 
			autoresize: true,  
			cleanup: false,  
			convertDivs: false,
			minHeight: 500, 
			fixed:true,
			imageUpload: base_url+'/cms/ajaxHandler.php?option=uploadPhoto',
		});
	}
	
	var original_html = $('#iKioskCMS-editContent #redactorEditor').html();

	//Submit Form
	$('.ikiosk-cms-editor').on('click', '.btn-ajax-submit', function(e) {
		var targetForm = $(this).data("form");
		$('#'+targetForm).submit();
	})
	
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
								url: "/cms/ajaxHandler.php",
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
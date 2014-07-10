// JavaScript Document
function iKioskUI() {
	
	//Delete Records
	$('.delete-record').on('click', function(){
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
							}
				});
		}
	});
	
	//Add Record Inline
	$('.btn-add').on('click', function(){
		var targetPanel = $(this).data("target");
		$('#'+targetPanel).slideDown();
	});
	
	$('.btn-close-panel').on('click', function(){
		var targetPanel = $(this).data("target");
		$('#'+targetPanel).slideUp();
	});

}

//AJAX Form Processing
function submitAjaxForm(formID) {
	var targetForm = "#"+formID;
	var formData = $(targetForm).serialize();
	var formType = $(targetForm).data("type");
	var formContainer = $(targetForm).data("container");
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
										if (formType == "create") {
											$('#'+formContainer).slideUp();
											$(targetForm)[0].reset();
										}
								}
					});
					}, 1200);
				}
		});
}



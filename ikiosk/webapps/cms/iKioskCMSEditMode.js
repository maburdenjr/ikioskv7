// JavaScript Document
var base_url = $('#ikiosk_keys .site_url').val();

(function($) {
	
	$(document).ready(function() {
		//Redactor Editor
		if ($('.redactor-editor').length) {
			$('.redactor-editor').redactor({ 
				autoresize: true,  
				cleanup: false,  
				convertDivs: false,
				minHeight: 500, 
				fixed:false,
				imageUpload: base_url+'/cms/ajaxHandler.php?option=uploadPhoto',
			});
		}
		
		//MouseOver Highlight
	$(document).on('mouseover', '#iKioskCMSeditor.cms-layout-editor .ui-droppable', function(e) {
		e.stopPropagation();
		$(this).addClass('cms-droppable-hover');
	});
		
	$(document).on('mouseout', '#iKioskCMSeditor.cms-layout-editor .ui-droppable', function(e) {
		e.stopPropagation();
		$(this).removeClass('cms-droppable-hover');
	});
	
	//Fix Draggables
	$(document).on('click', '.ui-draggable', function(e) {
		$(this).draggable("destroy");
		$(this).addClass('ui-drag-pause');
	});
	
	$(document).on('mouseout', '.ui-drag-pause', function(e) {
		$(this).draggable({
				containment: "#redactorEditor",
				cursor: "move",
				snap: true,
				start: function() {
					$('#cmsStyleEditor', parent.document).hide();
				},
				stop: function() {
					$('.redactor-editor').data('redactor').syncCode();
				}
		});
		$(this).removeClass('ui-drag-pause');
	});
	
	//MouseOver Highlight
	$(document).on('mouseover', '#redactorEditor div:not(.ui-resizable-handle), #redactorEditor p, #redactorEditor h1, #redactorEditor h2, #redactorEditor h3, #redactorEditor h4, #redactorEditor h5, #redactorEditor ul, #redactorEditor li, #redactorEditor span, #redactorEditor footer, #redactorEditor header, #redactorEditor section, #redactorEditor nav, #redactorEditor article, #redactorEditor a, #redactorEditor img', function(e) {
		e.stopPropagation();
		$(this).addClass('cms-element-hover');
	});
	
	$(document).on('mouseout', '#redactorEditor div:not(.ui-resizable-handle), #redactorEditor p, #redactorEditor h1, #redactorEditor h2, #redactorEditor h3, #redactorEditor h4, #redactorEditor h5, #redactorEditor ul, #redactorEditor li, #redactorEditor span, #redactorEditor footer, #redactorEditor header, #redactorEditor section, #redactorEditor nav, #redactorEditor article, #redactorEditor a, #redactorEditor img', function(e) {
		e.stopPropagation();
		$(this).removeClass('cms-element-hover');
	});
	
	//Select Element for Editing
	$(document).on('dblclick', '#redactorEditor div:not(.ui-resizable-handle), #redactorEditor p, #redactorEditor h1, #redactorEditor h2, #redactorEditor h3, #redactorEditor h4, #redactorEditor h5, #redactorEditor ul, #redactorEditor li, #redactorEditor span, #redactorEditor footer, #redactorEditor header, #redactorEditor section, #redactorEditor nav, #redactorEditor article, #redactorEditor a, #redactorEditor img', function(e){
			e.stopPropagation(e);
			$('.cms-selected-element').removeClass('cms-selected-element');
			$(this).addClass('cms-selected-element');
			if ($(this).hasClass('ui-drag-pause')) { $('.elementMove').addClass('btn-primary'); }
			if ($(this).hasClass('ui-resizable')) { $('.elementResize').addClass('btn-primary'); }
			$('#cms-editElement', parent.document).show();
			parent.updateStyleEditor();
		});
		
	//Disable Element Editing
	$(document).on('click', '#redactorEditor div:not(.cms-selected-element), #redactorEditor p:not(.cms-selected-element), #redactorEditor h1:not(.cms-selected-element), #redactorEditor h2:not(.cms-selected-element), #redactorEditor h3:not(.cms-selected-element), #redactorEditor h4:not(.cms-selected-element), #redactorEditor h5:not(.cms-selected-element), #redactorEditor ul:not(.cms-selected-element), #redactorEditor li:not(.cms-selected-element), #redactorEditor span:not(.cms-selected-element), #redactorEditor footer:not(.cms-selected-element), #redactorEditor header:not(.cms-selected-element), #redactorEditor section:not(.cms-selected-element), #redactorEditor nav:not(.cms-selected-element), #redactorEditor article:not(.cms-selected-element), #redactorEditor a:not(.cms-selected-element), #redactorEditor img:not(.cms-selected-element)', function(e) {
		e.stopPropagation(e);
		$('#cms-editElement', parent.document).hide();
		$('.css-styles', parent.document).hide();
		$('.elementResize, .elementMove, .cssTrigger', parent.document).removeClass('btn-primary');
		$('.cms-selected-element').removeClass('.cms-selected-element');	
		//Clear Styles in CSS Editor
	});
		
		
	//Custom Accordion 
	$('.acc-section-trigger:first-child').addClass('accActive');
	$('.acc-section-trigger:first-child').next().css('display', 'block');
	
	$(document).on('click', '.acc-section-trigger', function(e) {
		e.stopPropagation();
		$('.accActive').removeClass('accActive');
		$('.acc-section-content').hide();
		$(this).addClass('accActive');
		$(this).next().show();
	});	
		
	
	
	});
}(jQuery));	

	//Drag and Drop Functionality
	function dragAndDrop() {
	
	$('#redactorEditor').addClass('cms-level');	
	$('#redactorEditor > *').addClass('cms-level level-1');	
	$('#redactorEditor > * > *').addClass('cms-level level-2');	
	$('#redactorEditor > * > * > *').addClass('cms-level level-3');	
	$("#redactorEditor, #redactorEditor .level-1, #redactorEditor .level-2").sortable({
		placeholder: "cms-placeholder",
		opacity: 0.6,
		tolerance: 'pointer',
		helper: 'clone',
		pointer: 'move',
		start: function( event, ui ) {
			var thisWidth = $(ui.item).css('width');
			var thisFloat = $(ui.item).css('float');
			var thisHeight = $(ui.item).css('height');
			$('.cms-placeholder').css('float', thisFloat);
			if (!$(ui.this).hasClass('.level-1')) {
					$('.cms-placeholder').css('height', thisHeight);
			}
		},
	});			

 $('#redactorEditor, #redactorEditor .level-1, #redactorEditor .level-2').droppable({
		accept: ".ui-element",
		greedy: true,
		drop: function( event, ui ) {
			var code = $(ui.draggable).data('code');
			$(code).insertAfter(ui.draggable);
			$(ui.draggable).remove();
			dragAndDrop();
		}
	});
	
	 $('#layoutElements .ui-element').draggable({
		 connectToSortable: ".cms-level",
		 containment: 'window',
		 helper: 'clone',
		 revert: "invalid",
		 zIndex: 5000,
			start: function( event, ui ) {
				$(ui.helper).css('width', '200px');
				$(ui.helper).css('height', '100px');
			}
		}); 
}

function resizeElement() {
	var tag = $(".cms-selected-element").prop("tagName");
		if (tag == "IMG") { 
			$('.cms-selected-element').resizable({
				start: function() {
				},
				stop: function(e, ui) {
					syncCode();
				},
				handles: "all",
				grid: 5,
				aspectRatio: true
			});
		} else {
			$('.cms-selected-element').resizable({
				start: function() {
				},
				stop: function(e, ui) {
					syncCode();
				},
				handles: "all",
				grid: 5,
			});	
		}
}


function moveElement() {
	 	var tag = $(".cms-selected-element").prop("tagName");
		var thisWidth = $('.cms-selected-element').width();
		var thisHeight = $('.cms-selected-element').height();
		var thisPosition = $(".cms-selected-element").offsetRelative("#redactorEditor");
		var topPos =  thisPosition.top;
		var leftPos = thisPosition.left;
			
		//Create Placeholder
		if (!$('.cms-selected-element').next().hasClass('cms-placeholder')) {
			var ePosition = $(".cms-selected-element").css("position");
			var eFloat = $(".cms-selected-element").css("float");
			var eDisplay = $(".cms-selected-element").css("display");
			var eMargin = $(".cms-selected-element").css("margin");
			var ePadding = $(".cms-selected-element").css("padding");
		
			var wrapper = "<span style='position: "+ePosition+"; float: "+eFloat+"; width: "+thisWidth+"px; height: "+thisHeight+"px; display: "+eDisplay+"; margin: "+eMargin+"; padding: "+ePadding+"; left: "+leftPos+"px; top: "+topPos+"px;' class='cms-placeholder'></span>";
			$('.cms-selected-element').wrap(wrapper); 
			$('.cms-selected-element').insertBefore($('.cms-selected-element').parent());
		}
	
		$('.cms-selected-element').css('position', 'absolute');	
		$('.cms-selected-element').css('left', leftPos);	
		$('.cms-selected-element').css('top', topPos);
		$('.cms-selected-element').css('width', thisWidth);	
		$('.cms-selected-element').css('height', thisHeight);	
				
		$('.cms-selected-element').draggable({
			containment: "#redactorEditor",
			cursor: "move",
			snap: true,
			start: function() {
				$('#cmsStyleEditor').hide();
			},
			stop: function() {
				$('.redactor-editor').data('redactor').syncCode();
			}
		});	
}

function cloneElement() {
	$(".cms-selected-element" ).clone().removeClass('cms-selected-element').insertAfter(".cms-selected-element" )
}

function deleteElement() {
	$('.cms-selected-element').remove();
	$('#cms-editElement', parent.document).hide();
	$('.css-styles', parent.document).hide();
	$('.elementResize, .elementMove', parent.document).removeClass('btn-primary');	
}

function contentEdit() {
	$('#iKioskCMSeditor').removeClass('cms-layout-editor');		
	$('.redactor_toolbar').show();	
	$("#iKioskCMSeditor .ui-sortable").sortable('destroy');
	$("#iKioskCMSeditor .ui-droppable").droppable('destroy');
	$("#iKioskCMSeditor .ui-draggable").draggable('destroy');
	$('#redactorEditor .cms-level').removeClass('cms-level level-1 level-2 level-3 level-4');
	$('#layoutWidget').hide();
}

function layoutEdit() {
	$('.redactor_toolbar').hide();
	$('#layoutWidget').show();
	$('#iKioskCMSeditor').addClass('cms-layout-editor');
	$("#iKioskCMSeditor .ui-resizable").resizable('destroy');
	$("#iKioskCMSeditor .ui-draggable").draggable('destroy');
	$('.cms-selected-element').removeClass('cms-selected-element');
	dragAndDrop();
}

function validateForms() {
	 $("#iKioskCMS-editContent, #iKioskCMS-editArticle").validate({
		errorPlacement : function(error, element) {
			error.insertAfter(element.parent());
		},
		submitHandler: function(form) {
			var targetForm = $(this.currentForm).attr("id");
			 submitAjaxForm(targetForm);
		 }
	 });	
}

function submitForms() {
	$('.redactor-editor').data('redactor').toggle();
	if ($('#iKioskCMS-editContent').length) {
		$('#iKioskCMS-editContent').submit();
	}
	if ($('#iKioskCMS-editArticle').length) {
		$('#iKioskCMS-editArticle').submit();
	}	
}

function insertHTML(code) {
	$('.redactor-editor').data('redactor').insertHtml(code);	
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


var savedRange = null;

document.addEventListener("selectionchange", HandleSelectionChange, false);

function HandleSelectionChange() {
    var sel = window.getSelection && window.getSelection();
    if (sel && sel.rangeCount > 0) {
        savedRange = sel.getRangeAt(0);
    }
}

function doInsert(text) {
		var sel = window.getSelection && window.getSelection();
		if (sel && sel.rangeCount == 0 && savedRange != null) {
				sel.addRange(savedRange);
		}
		if (sel && sel.rangeCount > 0) {
				var range = sel.getRangeAt(0);
				console.log(range);
				//var node = document.createTextNode(text);
				//range.deleteContents();
				//range.insertNode(node);
		}
		
}

function syncCode() {
	$('.redactor-editor').data('redactor').syncCode();
}

(function($){
    $.fn.offsetRelative = function(top){
        var $this = $(this);
        var $parent = $this.offsetParent();
        var offset = $this.position();
        if(!top) return offset; // Didn't pass a 'top' element 
        else if($parent.get(0).tagName == "BODY") return offset; // Reached top of document
        else if($(top,$parent).length) return offset; // Parent element contains the 'top' element we want the offset to be relative to 
        else if($parent[0] == $(top)[0]) return offset; // Reached the 'top' element we want the offset to be relative to 
        else { // Get parent's relative offset
            var parent_offset = $parent.offsetRelative(top);
            offset.top += parent_offset.top;
            offset.left += parent_offset.left;
            return offset;
        }
    };
    $.fn.positionRelative = function(top){
        return $(this).offsetRelative(top);
    };
}(jQuery));


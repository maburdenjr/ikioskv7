// JavaScript Document
function iKioskUI() {
	var base_url = $('#ikiosk_keys .site_url').val();
	resizeEditor();
	
	//Custom Actions
	$(document).on('click', '.icon-action', function(){
			event.stopPropagation();
			var iconAction = $(this).data('type');
			var code = $(this).data("code");
			var record = $(this).data("record");
			var file = $(this).data('file');

				progressBar();
				$.ajax({
							url: "/cms/ajaxHandler.php",	
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
	
	
	$(document).on('change', '.toggleGrid', function() {
		$('#editorFrame').contents().find('#redactorEditor').toggleClass('cms-layout-grid');
	});
	
	//CMS Mode 
	$(document).on('click', '.cmsMode', function(e) {
		var mode = $(this).data('mode');
		$('.cmsMode').removeClass('btn-primary');
		$(this).addClass('btn-primary');
		$('#cms-widget-popover').fadeOut('fast');
		$('.cmstooltip').removeClass('btn-primary');
		
		if (mode == 'content') { // Content Editor
			$('#cmsModeLayout').hide();
			$('#cmsModeContent').fadeIn();
			document.getElementById("editorFrame").contentWindow.contentEdit();
		} else { // Layout Editor
			$('#cmsModeContent').hide();	
			$('#cmsModeLayout').fadeIn();
			document.getElementById("editorFrame").contentWindow.layoutEdit();		
		}
	});
	
	
	//Style Updates
	$(document).on('change', '.cms-style-update', function(e) {
		var styleDeclaration = $(this).attr('rel');
		var styleValue = $(this).val();
		$('#editorFrame').contents().find('.cms-selected-element').css(''+styleDeclaration, ''+styleValue);
		document.getElementById("editorFrame").contentWindow.syncCode();
	});
	
	$(document).on('change', '.cms-attr-update', function(e) {
		var attrDeclaration = $(this).attr('rel');
		var attrValue = $(this).val();
		$('#editorFrame').contents().find('.cms-selected-element').attr(''+attrDeclaration, ''+attrValue);
		document.getElementById("editorFrame").contentWindow.syncCode();
	});
	
	
	//Clone Element 
	$(document).on('click', '.elementClone', function(e) {
		document.getElementById("editorFrame").contentWindow.cloneElement();
	});
	
	//Delete Element 
	$(document).on('click', '.elementDelete', function(e) {
		var deleteElement = confirm("Are you sure you want to delete this element?");
		if (deleteElement == true) {
			document.getElementById("editorFrame").contentWindow.deleteElement();	
		} 	
	});
	
	
	
	//Move Element
	$(document).on('click', '.elementMove', function(e) {
		$(this).addClass('btn-primary');
		document.getElementById("editorFrame").contentWindow.moveElement();	
	});

	//Resize Element
	$(document).on('click', '.elementResize', function(e) {
		$(this).addClass('btn-primary');
		document.getElementById("editorFrame").contentWindow.resizeElement();			
	});
	
	function syncCode() {
		document.getElementById("editorFrame").contentWindow.syncCode();
	}
	
	//Insert Code
	$(document).on('click', '.insertCode', function() {
		var code = $(this).data('code');
		document.getElementById("editorFrame").contentWindow.doInsert();
		$('#editorFrame').contents().find('.ikiosk-cmsSnippet').attr('contenteditable', false);
		document.getElementById("editorFrame").contentWindow.insertHTML(code);
		$('#cms-widget-popover').fadeOut('fast');
		$('.cmstooltip').removeClass('btn-primary');
	});
	
	//Panel Toggle
	$(document).on('click', '.panelToggle', function() {
			var openPanel = $(this).data('open');
			var closePanel = $(this).data('close');
			$('#'+closePanel).hide();
			$('#'+openPanel).show();
	});
	
	//Code Preview
	$(document).on('click', '.codePreview', function() {
			var title = $(this).data('title');
			var code = $(this).data('htmlcode');
			var systemTag = $(this).data('code');
			$('.snippetTitle').html(title);
			$('.htmlCode').html(htmlEntities(code));
			$('#codePreview .insertCode').data('code', systemTag);
			 prettyPrint();
	});
	
	//CMS ToolTips
	$(document).on('click', '.cmstooltip', function() {
		$('#cms-widget-popover .widget-popover-wrapper').html("<i class='fa fa-cog fa-spin'></i> Loading..").fadeIn('slow');	
		if ($(this).hasClass("mainBtn")) {
			$('.cmstooltip').removeClass('btn-primary');
			$('#cms-widget-popover').removeClass('css-styles');	
			var arrow = $(this).data('arrow');
			var tooltiptop = $(this).data('cmstooltop');
			var tooltipright = $(this).data('cmstoolright');
			$('#cms-widget-popover').css('top', tooltiptop);
			$('#cms-widget-popover').css('right', tooltipright);
			$('#cms-widget-popover :after').css('top', arrow);
			$('#cms-widget-popover').fadeIn('fast');
			$('#cms-widget-popover').addClass('active');
			$(this).addClass('btn-primary');
		}
		var action = "inlineEdit";
		var panel = $(this).data('panel');
		var record = $(this).data('record');
		var option = $(this).data('option');
		$.ajax({
					url: "/cms/ajaxHandler.php",	
					data: {appCode: "CMS", ajaxAction: action, panel: panel, recordID: record, option: option},
					timeout: 600000,
					error: function(data) {
							var error="<div class='alert alert-danger fade in'><a class='close' data-dismiss='alert' href='#'>×</a> An unknown error has occurred.  Please try again.</div>";
							$('#cms-widget-popover .widget-popover-wrapper').html(error).fadeIn('slow');
					},
					success: function(data) {
							$('#cms-widget-popover .widget-popover-wrapper').html(data).fadeIn('slow');
							updateStyleEditor();
					}
			});
		
	});
	
	//Style Editor
	$(document).on('click', '.cssTrigger', function(e) {
		$('#cms-widget-popover').addClass('css-styles');	
	});
	
	$(document).on('click', '.cmstooltip-close, .redactor_toolbar, #header', function(e) {
		e.stopPropagation();
		$('#cms-widget-popover').fadeOut('fast');
		$('#cms-widget-popover').removeClass('active');
		$('.cmstooltip').removeClass('btn-primary');
	});
	function resizeEditor() {
		var docWidth = $(window).width();
		var docHeight = $('#iKioskCMSContent').height();
		var winHeight = $(window).height();
		var rightPanel = 250;
		var leftPanel = docWidth-rightPanel;
		if ($('body').hasClass('ikiosk-editor-active')) {
			if (docWidth > 568) {
				$('#iKioskCMSContent').css('width', leftPanel);
				$('#iKioskCMSInlineEditor, #iKioskCMSContent').css('min-height', winHeight);
				$('#iKioskCMSInlineEditor').css('height', docHeight);
				$('#editorFrame').css('min-height', winHeight);
			} else {
				$('#iKioskCMSContent').css('width', '100%');
			}
		} else {
			$('#iKioskCMSContent').css('width', '100%');	
		}
		
	}
	
	$(window).on('resize', function () {
		resizeEditor();
	});
	
	$('iframe').load(function() {
			var winHeight = $(window).height();
			this.style.height =
			this.contentWindow.document.body.offsetHeight + 'px';
			$(this).css('min-height', winHeight);
			$('#editorFrame').contents().find('a').attr('target', '_top');
	});
		
	//Smart Actions
	$(document).on('touchstart click', ".cms-action", function(e) {
			event.stopPropagation();
			$('#cms-widget-popover').hide();
			var action = $(this).data('action');
			var confirmation = $(this).data("confirm");
			var record = $(this).data("record");
			var processAction = "Yes";
			if (confirmation != "none") {
				var getConfirm = confirm(confirmation);
				if (getConfirm == true) {	
					var processAction = "Yes";
				} else {
					var processAction = "No";
				}
			}
			if (processAction == "Yes") {
				progressBar();	
				$.ajax({
							url: "/cms/ajaxHandler.php",	
							data: {appCode: "CMS", ajaxAction: action, recordID: record},
							timeout: 600000,
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
	
	//Hidden Panels
	$(document).on('touchstart click', ".panelTrigger", function(e) {
		e.preventDefault();
		var panel = $(this).data('panel');
		$('#'+panel).slideToggle('fast');
	});
	
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
				//Load File Uploader
				if ($('#file-uploadFiles').length) {
					createUploader();    	
				}
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
	$(document).on("touchstart click", 'a.dynamicModal', function(e) {
		e.preventDefault();
		e.stopPropagation();
		var targetURL = $(this).attr('href');
		dynamicModal(targetURL);
	});
	
	//Dynamic Modal
	function dynamicModal(targetURL) {
		$('#cms-widget-popover').hide();
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
	$('#iKioskCMSheader').on("touchstart click", '#editPage a, #editBlog a', function(e) {
		e.preventDefault();
		$('body').addClass('ikiosk-editor-active');
		resizeEditor();
		$('#cms-widget-popover').hide();
		$('#iKioskCMSheader a').removeClass('active');
		$(this).toggleClass('active');
		$('#editorFrame').contents().find('#iKioskCMSdisplay').hide();
		$('#editorFrame').contents().find('#iKioskCMSeditor').show();
		document.getElementById("editorFrame").contentWindow.validateForms();
		$('.toggleGrid').prop('checked', true);
		$('#editorFrame').contents().find('#redactorEditor').addClass('cms-layout-grid');
	});
	
	//Cancel Page Edit
	$('#iKioskCMSwrapper').on("click", '.editContentCancel', function(e) {
		e.preventDefault();
		var cancelEdit = confirm("Are you sure you want to cancel and discard changes.");
		if (cancelEdit == true) {
			$('#cms-widget-popover').hide();
			$('#iKioskCMSheader a').removeClass('active');
			$('body').removeClass('ikiosk-editor-active');
			document.getElementById('editorFrame').contentDocument.location.reload(true);
			resizeEditor();

		}
	});
	
	$(document).on('click', '.editContentSave', function(e) {
		document.getElementById("editorFrame").contentWindow.submitForms();
		$('#cms-widget-popover').hide();
		$('#iKioskCMSheader a').removeClass('active');
		$('body').removeClass('ikiosk-editor-active');
		resizeEditor();
	});

	//Submit Form
	$('#iKioskCMSwrapper').on('click', '.btn-ajax-submit', function(e) {
		var targetForm = $(this).data("form");
		$('#'+targetForm).submit();
	})
	
}
function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
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

// File Uploader
/**
 * http://github.com/valums/file-uploader
 * 
 * Multiple file upload component with progress-bar, drag-and-drop. 
 * Â© 2010 Andrew Valums ( andrew(at)valums.com ) 
 * 
 * Licensed under GNU GPL 2 or later and GNU LGPL 2 or later, see license.txt.
 */    

//
// Helper functions
//

var qq = qq || {};

/**
 * Adds all missing properties from second obj to first obj
 */ 
qq.extend = function(first, second){
    for (var prop in second){
        first[prop] = second[prop];
    }
};  

/**
 * Searches for a given element in the array, returns -1 if it is not present.
 * @param {Number} [from] The index at which to begin the search
 */
qq.indexOf = function(arr, elt, from){
    if (arr.indexOf) return arr.indexOf(elt, from);
    
    from = from || 0;
    var len = arr.length;    
    
    if (from < 0) from += len;  

    for (; from < len; from++){  
        if (from in arr && arr[from] === elt){  
            return from;
        }
    }  
    return -1;  
}; 
    
qq.getUniqueId = (function(){
    var id = 0;
    return function(){ return id++; };
})();

//
// Events

qq.attach = function(element, type, fn){
    if (element.addEventListener){
        element.addEventListener(type, fn, false);
    } else if (element.attachEvent){
        element.attachEvent('on' + type, fn);
    }
};
qq.detach = function(element, type, fn){
    if (element.removeEventListener){
        element.removeEventListener(type, fn, false);
    } else if (element.attachEvent){
        element.detachEvent('on' + type, fn);
    }
};

qq.preventDefault = function(e){
    if (e.preventDefault){
        e.preventDefault();
    } else{
        e.returnValue = false;
    }
};

//
// Node manipulations

/**
 * Insert node a before node b.
 */
qq.insertBefore = function(a, b){
    b.parentNode.insertBefore(a, b);
};
qq.remove = function(element){
    element.parentNode.removeChild(element);
};

qq.contains = function(parent, descendant){       
    // compareposition returns false in this case
    if (parent == descendant) return true;
    
    if (parent.contains){
        return parent.contains(descendant);
    } else {
        return !!(descendant.compareDocumentPosition(parent) & 8);
    }
};

/**
 * Creates and returns element from html string
 * Uses innerHTML to create an element
 */
qq.toElement = (function(){
    var div = document.createElement('div');
    return function(html){
        div.innerHTML = html;
        var element = div.firstChild;
        div.removeChild(element);
        return element;
    };
})();

//
// Node properties and attributes

/**
 * Sets styles for an element.
 * Fixes opacity in IE6-8.
 */
qq.css = function(element, styles){
    if (styles.opacity != null){
        if (typeof element.style.opacity != 'string' && typeof(element.filters) != 'undefined'){
            styles.filter = 'alpha(opacity=' + Math.round(100 * styles.opacity) + ')';
        }
    }
    qq.extend(element.style, styles);
};
qq.hasClass = function(element, name){
    var re = new RegExp('(^| )' + name + '( |$)');
    return re.test(element.className);
};
qq.addClass = function(element, name){
    if (!qq.hasClass(element, name)){
        element.className += ' ' + name;
    }
};
qq.removeClass = function(element, name){
    var re = new RegExp('(^| )' + name + '( |$)');
    element.className = element.className.replace(re, ' ').replace(/^\s+|\s+$/g, "");
};
qq.setText = function(element, text){
    element.innerText = text;
    element.textContent = text;
};

//
// Selecting elements

qq.children = function(element){
    var children = [],
    child = element.firstChild;

    while (child){
        if (child.nodeType == 1){
            children.push(child);
        }
        child = child.nextSibling;
    }

    return children;
};

qq.getByClass = function(element, className){
    if (element.querySelectorAll){
        return element.querySelectorAll('.' + className);
    }

    var result = [];
    var candidates = element.getElementsByTagName("*");
    var len = candidates.length;

    for (var i = 0; i < len; i++){
        if (qq.hasClass(candidates[i], className)){
            result.push(candidates[i]);
        }
    }
    return result;
};

/**
 * obj2url() takes a json-object as argument and generates
 * a querystring. pretty much like jQuery.param()
 * 
 * how to use:
 *
 *    `qq.obj2url({a:'b',c:'d'},'http://any.url/upload?otherParam=value');`
 *
 * will result in:
 *
 *    `http://any.url/upload?otherParam=value&a=b&c=d`
 *
 * @param  Object JSON-Object
 * @param  String current querystring-part
 * @return String encoded querystring
 */
qq.obj2url = function(obj, temp, prefixDone){
    var uristrings = [],
        prefix = '&',
        add = function(nextObj, i){
            var nextTemp = temp 
                ? (/\[\]$/.test(temp)) // prevent double-encoding
                   ? temp
                   : temp+'['+i+']'
                : i;
            if ((nextTemp != 'undefined') && (i != 'undefined')) {  
                uristrings.push(
                    (typeof nextObj === 'object') 
                        ? qq.obj2url(nextObj, nextTemp, true)
                        : (Object.prototype.toString.call(nextObj) === '[object Function]')
                            ? encodeURIComponent(nextTemp) + '=' + encodeURIComponent(nextObj())
                            : encodeURIComponent(nextTemp) + '=' + encodeURIComponent(nextObj)                                                          
                );
            }
        }; 

    if (!prefixDone && temp) {
      prefix = (/\?/.test(temp)) ? (/\?$/.test(temp)) ? '' : '&' : '?';
      uristrings.push(temp);
      uristrings.push(qq.obj2url(obj));
    } else if ((Object.prototype.toString.call(obj) === '[object Array]') && (typeof obj != 'undefined') ) {
        // we wont use a for-in-loop on an array (performance)
        for (var i = 0, len = obj.length; i < len; ++i){
            add(obj[i], i);
        }
    } else if ((typeof obj != 'undefined') && (obj !== null) && (typeof obj === "object")){
        // for anything else but a scalar, we will use for-in-loop
        for (var i in obj){
            add(obj[i], i);
        }
    } else {
        uristrings.push(encodeURIComponent(temp) + '=' + encodeURIComponent(obj));
    }

    return uristrings.join(prefix)
                     .replace(/^&/, '')
                     .replace(/%20/g, '+'); 
};

//
//
// Uploader Classes
//
//

var qq = qq || {};
    
/**
 * Creates upload button, validates upload, but doesn't create file list or dd. 
 */
qq.FileUploaderBasic = function(o){
    this._options = {
        // set to true to see the server response
        debug: false,
        action: '/server/upload',
        params: {},
        button: null,
        multiple: true,
        maxConnections: 3,
        // validation        
        allowedExtensions: [],               
        sizeLimit: 0,   
        minSizeLimit: 0,                             
        // events
        // return false to cancel submit
        onSubmit: function(id, fileName){},
        onProgress: function(id, fileName, loaded, total){},
        onComplete: function(id, fileName, responseJSON){},
        onCancel: function(id, fileName){},
        // messages                
        messages: {
            typeError: "{file} has invalid extension. Only {extensions} are allowed.",
            sizeError: "{file} is too large, maximum file size is {sizeLimit}.",
            minSizeError: "{file} is too small, minimum file size is {minSizeLimit}.",
            emptyError: "{file} is empty, please select files again without it.",
            onLeave: "The files are being uploaded, if you leave now the upload will be cancelled."            
        },
        showMessage: function(message){
            alert(message);
        }               
    };
    qq.extend(this._options, o);
        
    // number of files being uploaded
    this._filesInProgress = 0;
    this._handler = this._createUploadHandler(); 
    
    if (this._options.button){ 
        this._button = this._createUploadButton(this._options.button);
    }
                        
    this._preventLeaveInProgress();         
};
   
qq.FileUploaderBasic.prototype = {
    setParams: function(params){
        this._options.params = params;
    },
    getInProgress: function(){
        return this._filesInProgress;         
    },
    _createUploadButton: function(element){
        var self = this;
        
        return new qq.UploadButton({
            element: element,
            multiple: this._options.multiple && qq.UploadHandlerXhr.isSupported(),
            onChange: function(input){
                self._onInputChange(input);
            }        
        });           
    },    
    _createUploadHandler: function(){
        var self = this,
            handlerClass;        
        
        if(qq.UploadHandlerXhr.isSupported()){           
            handlerClass = 'UploadHandlerXhr';                        
        } else {
            handlerClass = 'UploadHandlerForm';
        }

        var handler = new qq[handlerClass]({
            debug: this._options.debug,
            action: this._options.action,         
            maxConnections: this._options.maxConnections,   
            onProgress: function(id, fileName, loaded, total){                
                self._onProgress(id, fileName, loaded, total);
                self._options.onProgress(id, fileName, loaded, total);                    
            },            
            onComplete: function(id, fileName, result){
                self._onComplete(id, fileName, result);
                self._options.onComplete(id, fileName, result);
            },
            onCancel: function(id, fileName){
                self._onCancel(id, fileName);
                self._options.onCancel(id, fileName);
            }
        });

        return handler;
    },    
    _preventLeaveInProgress: function(){
        var self = this;
        
        qq.attach(window, 'beforeunload', function(e){
            if (!self._filesInProgress){return;}
            
            var e = e || window.event;
            // for ie, ff
            e.returnValue = self._options.messages.onLeave;
            // for webkit
            return self._options.messages.onLeave;             
        });        
    },    
    _onSubmit: function(id, fileName){
        this._filesInProgress++;  
    },
    _onProgress: function(id, fileName, loaded, total){        
    },
    _onComplete: function(id, fileName, result){
        this._filesInProgress--;                 
        if (result.error){
            this._options.showMessage(result.error);
        }             
    },
    _onCancel: function(id, fileName){
        this._filesInProgress--;        
    },
    _onInputChange: function(input){
        if (this._handler instanceof qq.UploadHandlerXhr){                
            this._uploadFileList(input.files);                   
        } else {             
            if (this._validateFile(input)){                
                this._uploadFile(input);                                    
            }                      
        }               
        this._button.reset();   
    },  
    _uploadFileList: function(files){
        for (var i=0; i<files.length; i++){
            if ( !this._validateFile(files[i])){
                return;
            }            
        }
        
        for (var i=0; i<files.length; i++){
            this._uploadFile(files[i]);        
        }        
    },       
    _uploadFile: function(fileContainer){      
        var id = this._handler.add(fileContainer);
        var fileName = this._handler.getName(id);
        
        if (this._options.onSubmit(id, fileName) !== false){
            this._onSubmit(id, fileName);
            this._handler.upload(id, this._options.params);
        }
    },      
    _validateFile: function(file){
        var name, size;
        
        if (file.value){
            // it is a file input            
            // get input value and remove path to normalize
            name = file.value.replace(/.*(\/|\\)/, "");
        } else {
            // fix missing properties in Safari
            name = file.fileName != null ? file.fileName : file.name;
            size = file.fileSize != null ? file.fileSize : file.size;
        }
                    
        if (! this._isAllowedExtension(name)){            
            this._error('typeError', name);
            return false;
            
        } else if (size === 0){            
            this._error('emptyError', name);
            return false;
                                                     
        } else if (size && this._options.sizeLimit && size > this._options.sizeLimit){            
            this._error('sizeError', name);
            return false;
                        
        } else if (size && size < this._options.minSizeLimit){
            this._error('minSizeError', name);
            return false;            
        }
        
        return true;                
    },
    _error: function(code, fileName){
        var message = this._options.messages[code];        
        function r(name, replacement){ message = message.replace(name, replacement); }
        
        r('{file}', this._formatFileName(fileName));        
        r('{extensions}', this._options.allowedExtensions.join(', '));
        r('{sizeLimit}', this._formatSize(this._options.sizeLimit));
        r('{minSizeLimit}', this._formatSize(this._options.minSizeLimit));
        
        this._options.showMessage(message);                
    },
    _formatFileName: function(name){
        if (name.length > 33){
            name = name.slice(0, 19) + '...' + name.slice(-13);    
        }
        return name;
    },
    _isAllowedExtension: function(fileName){
        var ext = (-1 !== fileName.indexOf('.')) ? fileName.replace(/.*[.]/, '').toLowerCase() : '';
        var allowed = this._options.allowedExtensions;
        
        if (!allowed.length){return true;}        
        
        for (var i=0; i<allowed.length; i++){
            if (allowed[i].toLowerCase() == ext){ return true;}    
        }
        
        return false;
    },    
    _formatSize: function(bytes){
        var i = -1;                                    
        do {
            bytes = bytes / 1024;
            i++;  
        } while (bytes > 99);
        
        return Math.max(bytes, 0.1).toFixed(1) + ['kB', 'MB', 'GB', 'TB', 'PB', 'EB'][i];          
    }
};
    
       
/**
 * Class that creates upload widget with drag-and-drop and file list
 * @inherits qq.FileUploaderBasic
 */
qq.FileUploader = function(o){
    // call parent constructor
    qq.FileUploaderBasic.apply(this, arguments);
    
    // additional options    
    qq.extend(this._options, {
        element: null,
        // if set, will be used instead of qq-upload-list in template
        listElement: null,
                
        template: '<div class="qq-uploader">' + 
                '<div class="qq-upload-drop-area hidden-mobile"><span>Drop files here to upload</span></div>' +
                '<div class="align-right"><button type="button" class="btn btn-default panelTrigger" data-panel="file-uploadFiles"><i class="fa fa-times"></i> Close </button> <div class="qq-upload-button btn btn-primary"><i class="fa fa-files-o"></i> Select Files</div></div>' +
                '<ul class="qq-upload-list"></ul>' + 
             '</div>',

        // template for one item in file list
        fileTemplate: '<li>' +
                '<span class="qq-upload-file"></span>' +
                '<span class="qq-upload-spinner"><i class="fa fa-spinner fa-spin"></i></span>' +
                '<span class="qq-upload-size"></span>' +
                '<a class="qq-upload-cancel" href="#"><i class="fa fa-times"></i></a>' +
                '<span class="qq-upload-failed-text"><i class="fa fa-check"></i></span>' +
            '</li>',        
        
        classes: {
            // used to get elements from templates
            button: 'qq-upload-button',
            drop: 'qq-upload-drop-area',
            dropActive: 'qq-upload-drop-area-active',
            list: 'qq-upload-list',
                        
            file: 'qq-upload-file',
            spinner: 'qq-upload-spinner',
            size: 'qq-upload-size',
            cancel: 'qq-upload-cancel',

            // added to list item when upload completes
            // used in css to hide progress spinner
            success: 'alert-success',
            fail: 'alert-warning'
        }
    });
    // overwrite options with user supplied    
    qq.extend(this._options, o);       

    this._element = this._options.element;
    this._element.innerHTML = this._options.template;        
    this._listElement = this._options.listElement || this._find(this._element, 'list');
    
    this._classes = this._options.classes;
        
    this._button = this._createUploadButton(this._find(this._element, 'button'));        
    
    this._bindCancelEvent();
    this._setupDragDrop();
};

// inherit from Basic Uploader
qq.extend(qq.FileUploader.prototype, qq.FileUploaderBasic.prototype);

qq.extend(qq.FileUploader.prototype, {
    /**
     * Gets one of the elements listed in this._options.classes
     **/
    _find: function(parent, type){                                
        var element = qq.getByClass(parent, this._options.classes[type])[0];        
        if (!element){
            throw new Error('element not found ' + type);
        }
        
        return element;
    },
    _setupDragDrop: function(){
        var self = this,
            dropArea = this._find(this._element, 'drop');                        

        var dz = new qq.UploadDropZone({
            element: dropArea,
            onEnter: function(e){
                qq.addClass(dropArea, self._classes.dropActive);
                e.stopPropagation();
            },
            onLeave: function(e){
                e.stopPropagation();
            },
            onLeaveNotDescendants: function(e){
                qq.removeClass(dropArea, self._classes.dropActive);  
            },
            onDrop: function(e){
                dropArea.style.display = 'none';
                qq.removeClass(dropArea, self._classes.dropActive);
                self._uploadFileList(e.dataTransfer.files);    
            }
        });
                
        dropArea.style.display = 'none';

        qq.attach(document, 'dragenter', function(e){     
            if (!dz._isValidFileDrag(e)) return; 
            
            dropArea.style.display = 'block';            
        });                 
        qq.attach(document, 'dragleave', function(e){
            if (!dz._isValidFileDrag(e)) return;            
            
            var relatedTarget = document.elementFromPoint(e.clientX, e.clientY);
            // only fire when leaving document out
            if ( ! relatedTarget || relatedTarget.nodeName == "HTML"){               
                dropArea.style.display = 'none';                                            
            }
        });                
    },
    _onSubmit: function(id, fileName){
        qq.FileUploaderBasic.prototype._onSubmit.apply(this, arguments);
        this._addToList(id, fileName);  
    },
    _onProgress: function(id, fileName, loaded, total){
        qq.FileUploaderBasic.prototype._onProgress.apply(this, arguments);

        var item = this._getItemByFileId(id);
        var size = this._find(item, 'size');
        size.style.display = 'inline';
        
        var text; 
        if (loaded != total){
            text = Math.round(loaded / total * 100) + '% from ' + this._formatSize(total);
        } else {                                   
            text = this._formatSize(total);
        }          
        
        qq.setText(size, text);         
    },
    _onComplete: function(id, fileName, result){
        qq.FileUploaderBasic.prototype._onComplete.apply(this, arguments);

        // mark completed
        var item = this._getItemByFileId(id);                
        qq.remove(this._find(item, 'cancel'));
        qq.remove(this._find(item, 'spinner'));
        
        if (result.success){
            qq.addClass(item, this._classes.success);    
        } else {
            qq.addClass(item, this._classes.fail);
        }         
    },
    _addToList: function(id, fileName){
        var item = qq.toElement(this._options.fileTemplate);                
        item.qqFileId = id;

        var fileElement = this._find(item, 'file');        
        qq.setText(fileElement, this._formatFileName(fileName));
        this._find(item, 'size').style.display = 'none';        

        this._listElement.appendChild(item);
    },
    _getItemByFileId: function(id){
        var item = this._listElement.firstChild;        
        
        // there can't be txt nodes in dynamically created list
        // and we can  use nextSibling
        while (item){            
            if (item.qqFileId == id) return item;            
            item = item.nextSibling;
        }          
    },
    /**
     * delegate click event for cancel link 
     **/
    _bindCancelEvent: function(){
        var self = this,
            list = this._listElement;            
        
        qq.attach(list, 'click', function(e){            
            e = e || window.event;
            var target = e.target || e.srcElement;
            
            if (qq.hasClass(target, self._classes.cancel)){                
                qq.preventDefault(e);
               
                var item = target.parentNode;
                self._handler.cancel(item.qqFileId);
                qq.remove(item);
            }
        });
    }    
});
    
qq.UploadDropZone = function(o){
    this._options = {
        element: null,  
        onEnter: function(e){},
        onLeave: function(e){},  
        // is not fired when leaving element by hovering descendants   
        onLeaveNotDescendants: function(e){},   
        onDrop: function(e){}                       
    };
    qq.extend(this._options, o); 
    
    this._element = this._options.element;
    
    this._disableDropOutside();
    this._attachEvents();   
};

qq.UploadDropZone.prototype = {
    _disableDropOutside: function(e){
        // run only once for all instances
        if (!qq.UploadDropZone.dropOutsideDisabled ){

            qq.attach(document, 'dragover', function(e){
                if (e.dataTransfer){
                    e.dataTransfer.dropEffect = 'none';
                    e.preventDefault(); 
                }           
            });
            
            qq.UploadDropZone.dropOutsideDisabled = true; 
        }        
    },
    _attachEvents: function(){
        var self = this;              
                  
        qq.attach(self._element, 'dragover', function(e){
            if (!self._isValidFileDrag(e)) return;
            
            var effect = e.dataTransfer.effectAllowed;
            if (effect == 'move' || effect == 'linkMove'){
                e.dataTransfer.dropEffect = 'move'; // for FF (only move allowed)    
            } else {                    
                e.dataTransfer.dropEffect = 'copy'; // for Chrome
            }
                                                     
            e.stopPropagation();
            e.preventDefault();                                                                    
        });
        
        qq.attach(self._element, 'dragenter', function(e){
            if (!self._isValidFileDrag(e)) return;
                        
            self._options.onEnter(e);
        });
        
        qq.attach(self._element, 'dragleave', function(e){
            if (!self._isValidFileDrag(e)) return;
            
            self._options.onLeave(e);
            
            var relatedTarget = document.elementFromPoint(e.clientX, e.clientY);                      
            // do not fire when moving a mouse over a descendant
            if (qq.contains(this, relatedTarget)) return;
                        
            self._options.onLeaveNotDescendants(e); 
        });
                
        qq.attach(self._element, 'drop', function(e){
            if (!self._isValidFileDrag(e)) return;
            
            e.preventDefault();
            self._options.onDrop(e);
        });          
    },
    _isValidFileDrag: function(e){
        var dt = e.dataTransfer,
            // do not check dt.types.contains in webkit, because it crashes safari 4            
            isWebkit = navigator.userAgent.indexOf("AppleWebKit") > -1;                        

        // dt.effectAllowed is none in Safari 5
        // dt.types.contains check is for firefox            
        return dt && dt.effectAllowed != 'none' && 
            (dt.files || (!isWebkit && dt.types.contains && dt.types.contains('Files')));
        
    }        
}; 

qq.UploadButton = function(o){
    this._options = {
        element: null,  
        // if set to true adds multiple attribute to file input      
        multiple: false,
        // name attribute of file input
        name: 'file',
        onChange: function(input){},
        hoverClass: 'qq-upload-button-hover',
        focusClass: 'qq-upload-button-focus'                       
    };
    
    qq.extend(this._options, o);
        
    this._element = this._options.element;
    
    // make button suitable container for input
    qq.css(this._element, {
        position: 'relative',
        overflow: 'hidden',
        // Make sure browse button is in the right side
        // in Internet Explorer
        direction: 'ltr'
    });   
    
    this._input = this._createInput();
};

qq.UploadButton.prototype = {
    /* returns file input element */    
    getInput: function(){
        return this._input;
    },
    /* cleans/recreates the file input */
    reset: function(){
        if (this._input.parentNode){
            qq.remove(this._input);    
        }                
        
        qq.removeClass(this._element, this._options.focusClass);
        this._input = this._createInput();
    },    
    _createInput: function(){                
        var input = document.createElement("input");
        
        if (this._options.multiple){
            input.setAttribute("multiple", "multiple");
        }
                
        input.setAttribute("type", "file");
        input.setAttribute("name", this._options.name);
        
        qq.css(input, {
            position: 'absolute',
            // in Opera only 'browse' button
            // is clickable and it is located at
            // the right side of the input
            right: 0,
            top: 0,
            fontFamily: 'Arial',
            // 4 persons reported this, the max values that worked for them were 243, 236, 236, 118
            fontSize: '118px',
            margin: 0,
            padding: 0,
            cursor: 'pointer',
            opacity: 0
        });
        
        this._element.appendChild(input);

        var self = this;
        qq.attach(input, 'change', function(){
            self._options.onChange(input);
        });
                
        qq.attach(input, 'mouseover', function(){
            qq.addClass(self._element, self._options.hoverClass);
        });
        qq.attach(input, 'mouseout', function(){
            qq.removeClass(self._element, self._options.hoverClass);
        });
        qq.attach(input, 'focus', function(){
            qq.addClass(self._element, self._options.focusClass);
        });
        qq.attach(input, 'blur', function(){
            qq.removeClass(self._element, self._options.focusClass);
        });

        // IE and Opera, unfortunately have 2 tab stops on file input
        // which is unacceptable in our case, disable keyboard access
        if (window.attachEvent){
            // it is IE or Opera
            input.setAttribute('tabIndex', "-1");
        }

        return input;            
    }        
};

/**
 * Class for uploading files, uploading itself is handled by child classes
 */
qq.UploadHandlerAbstract = function(o){
    this._options = {
        debug: false,
        action: '/upload.php',
        // maximum number of concurrent uploads        
        maxConnections: 999,
        onProgress: function(id, fileName, loaded, total){},
        onComplete: function(id, fileName, response){},
        onCancel: function(id, fileName){}
    };
    qq.extend(this._options, o);    
    
    this._queue = [];
    // params for files in queue
    this._params = [];
};
qq.UploadHandlerAbstract.prototype = {
    log: function(str){
        if (this._options.debug && window.console) console.log('[uploader] ' + str);        
    },
    /**
     * Adds file or file input to the queue
     * @returns id
     **/    
    add: function(file){},
    /**
     * Sends the file identified by id and additional query params to the server
     */
    upload: function(id, params){
        var len = this._queue.push(id);

        var copy = {};        
        qq.extend(copy, params);
        this._params[id] = copy;        
                
        // if too many active uploads, wait...
        if (len <= this._options.maxConnections){               
            this._upload(id, this._params[id]);
        }
    },
    /**
     * Cancels file upload by id
     */
    cancel: function(id){
        this._cancel(id);
        this._dequeue(id);
    },
    /**
     * Cancells all uploads
     */
    cancelAll: function(){
        for (var i=0; i<this._queue.length; i++){
            this._cancel(this._queue[i]);
        }
        this._queue = [];
    },
    /**
     * Returns name of the file identified by id
     */
    getName: function(id){},
    /**
     * Returns size of the file identified by id
     */          
    getSize: function(id){},
    /**
     * Returns id of files being uploaded or
     * waiting for their turn
     */
    getQueue: function(){
        return this._queue;
    },
    /**
     * Actual upload method
     */
    _upload: function(id){},
    /**
     * Actual cancel method
     */
    _cancel: function(id){},     
    /**
     * Removes element from queue, starts upload of next
     */
    _dequeue: function(id){
        var i = qq.indexOf(this._queue, id);
        this._queue.splice(i, 1);
                
        var max = this._options.maxConnections;
        
        if (this._queue.length >= max && i < max){
            var nextId = this._queue[max-1];
            this._upload(nextId, this._params[nextId]);
        }
    }        
};

/**
 * Class for uploading files using form and iframe
 * @inherits qq.UploadHandlerAbstract
 */
qq.UploadHandlerForm = function(o){
    qq.UploadHandlerAbstract.apply(this, arguments);
       
    this._inputs = {};
};
// @inherits qq.UploadHandlerAbstract
qq.extend(qq.UploadHandlerForm.prototype, qq.UploadHandlerAbstract.prototype);

qq.extend(qq.UploadHandlerForm.prototype, {
    add: function(fileInput){
        fileInput.setAttribute('name', 'qqfile');
        var id = 'qq-upload-handler-iframe' + qq.getUniqueId();       
        
        this._inputs[id] = fileInput;
        
        // remove file input from DOM
        if (fileInput.parentNode){
            qq.remove(fileInput);
        }
                
        return id;
    },
    getName: function(id){
        // get input value and remove path to normalize
        return this._inputs[id].value.replace(/.*(\/|\\)/, "");
    },    
    _cancel: function(id){
        this._options.onCancel(id, this.getName(id));
        
        delete this._inputs[id];        

        var iframe = document.getElementById(id);
        if (iframe){
            // to cancel request set src to something else
            // we use src="javascript:false;" because it doesn't
            // trigger ie6 prompt on https
            iframe.setAttribute('src', 'javascript:false;');

            qq.remove(iframe);
        }
    },     
    _upload: function(id, params){                        
        var input = this._inputs[id];
        
        if (!input){
            throw new Error('file with passed id was not added, or already uploaded or cancelled');
        }                

        var fileName = this.getName(id);
                
        var iframe = this._createIframe(id);
        var form = this._createForm(iframe, params);
        form.appendChild(input);

        var self = this;
        this._attachLoadEvent(iframe, function(){                                 
            self.log('iframe loaded');
            
            var response = self._getIframeContentJSON(iframe);

            self._options.onComplete(id, fileName, response);
            self._dequeue(id);
            
            delete self._inputs[id];
            // timeout added to fix busy state in FF3.6
            setTimeout(function(){
                qq.remove(iframe);
            }, 1);
        });

        form.submit();        
        qq.remove(form);        
        
        return id;
    }, 
    _attachLoadEvent: function(iframe, callback){
        qq.attach(iframe, 'load', function(){
            // when we remove iframe from dom
            // the request stops, but in IE load
            // event fires
            if (!iframe.parentNode){
                return;
            }

            // fixing Opera 10.53
            if (iframe.contentDocument &&
                iframe.contentDocument.body &&
                iframe.contentDocument.body.innerHTML == "false"){
                // In Opera event is fired second time
                // when body.innerHTML changed from false
                // to server response approx. after 1 sec
                // when we upload file with iframe
                return;
            }

            callback();
        });
    },
    /**
     * Returns json object received by iframe from server.
     */
    _getIframeContentJSON: function(iframe){
        // iframe.contentWindow.document - for IE<7
        var doc = iframe.contentDocument ? iframe.contentDocument: iframe.contentWindow.document,
            response;
        
        this.log("converting iframe's innerHTML to JSON");
        this.log("innerHTML = " + doc.body.innerHTML);
                        
        try {
            response = eval("(" + doc.body.innerHTML + ")");
        } catch(err){
            response = {};
        }        

        return response;
    },
    /**
     * Creates iframe with unique name
     */
    _createIframe: function(id){
        // We can't use following code as the name attribute
        // won't be properly registered in IE6, and new window
        // on form submit will open
        // var iframe = document.createElement('iframe');
        // iframe.setAttribute('name', id);

        var iframe = qq.toElement('<iframe src="javascript:false;" name="' + id + '" />');
        // src="javascript:false;" removes ie6 prompt on https

        iframe.setAttribute('id', id);

        iframe.style.display = 'none';
        document.body.appendChild(iframe);

        return iframe;
    },
    /**
     * Creates form, that will be submitted to iframe
     */
    _createForm: function(iframe, params){
        // We can't use the following code in IE6
        // var form = document.createElement('form');
        // form.setAttribute('method', 'post');
        // form.setAttribute('enctype', 'multipart/form-data');
        // Because in this case file won't be attached to request
        var form = qq.toElement('<form method="post" enctype="multipart/form-data"></form>');

        var queryString = qq.obj2url(params, this._options.action);

        form.setAttribute('action', queryString);
        form.setAttribute('target', iframe.name);
        form.style.display = 'none';
        document.body.appendChild(form);

        return form;
    }
});

/**
 * Class for uploading files using xhr
 * @inherits qq.UploadHandlerAbstract
 */
qq.UploadHandlerXhr = function(o){
    qq.UploadHandlerAbstract.apply(this, arguments);

    this._files = [];
    this._xhrs = [];
    
    // current loaded size in bytes for each file 
    this._loaded = [];
};

// static method
qq.UploadHandlerXhr.isSupported = function(){
    var input = document.createElement('input');
    input.type = 'file';        
    
    return (
        'multiple' in input &&
        typeof File != "undefined" &&
        typeof (new XMLHttpRequest()).upload != "undefined" );       
};

// @inherits qq.UploadHandlerAbstract
qq.extend(qq.UploadHandlerXhr.prototype, qq.UploadHandlerAbstract.prototype)

qq.extend(qq.UploadHandlerXhr.prototype, {
    /**
     * Adds file to the queue
     * Returns id to use with upload, cancel
     **/    
    add: function(file){
        if (!(file instanceof File)){
            throw new Error('Passed obj in not a File (in qq.UploadHandlerXhr)');
        }
                
        return this._files.push(file) - 1;        
    },
    getName: function(id){        
        var file = this._files[id];
        // fix missing name in Safari 4
        return file.fileName != null ? file.fileName : file.name;       
    },
    getSize: function(id){
        var file = this._files[id];
        return file.fileSize != null ? file.fileSize : file.size;
    },    
    /**
     * Returns uploaded bytes for file identified by id 
     */    
    getLoaded: function(id){
        return this._loaded[id] || 0; 
    },
    /**
     * Sends the file identified by id and additional query params to the server
     * @param {Object} params name-value string pairs
     */    
    _upload: function(id, params){
        var file = this._files[id],
            name = this.getName(id),
            size = this.getSize(id);
                
        this._loaded[id] = 0;
                                
        var xhr = this._xhrs[id] = new XMLHttpRequest();
        var self = this;
                                        
        xhr.upload.onprogress = function(e){
            if (e.lengthComputable){
                self._loaded[id] = e.loaded;
                self._options.onProgress(id, name, e.loaded, e.total);
            }
        };

        xhr.onreadystatechange = function(){            
            if (xhr.readyState == 4){
                self._onComplete(id, xhr);                    
            }
        };

        // build query string
        params = params || {};
        params['qqfile'] = name;
        var queryString = qq.obj2url(params, this._options.action);

        xhr.open("POST", queryString, true);
        xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhr.setRequestHeader("X-File-Name", encodeURIComponent(name));
        xhr.setRequestHeader("Content-Type", "application/octet-stream");
        xhr.send(file);
    },
    _onComplete: function(id, xhr){
        // the request was aborted/cancelled
        if (!this._files[id]) return;
        
        var name = this.getName(id);
        var size = this.getSize(id);
        
        this._options.onProgress(id, name, size, size);
                
        if (xhr.status == 200){
            this.log("xhr - server response received");
            this.log("responseText = " + xhr.responseText);
                        
            var response;
                    
            try {
                response = eval("(" + xhr.responseText + ")");
            } catch(err){
                response = {};
            }
            
            this._options.onComplete(id, name, response);
                        
        } else {                   
            this._options.onComplete(id, name, {});
        }
                
        this._files[id] = null;
        this._xhrs[id] = null;    
        this._dequeue(id);                    
    },
    _cancel: function(id){
        this._options.onCancel(id, this.getName(id));
        
        this._files[id] = null;
        
        if (this._xhrs[id]){
            this._xhrs[id].abort();
            this._xhrs[id] = null;                                   
        }
    }
});


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

function css(a) {
    var sheets = document.styleSheets, o = {};
    for (var i in sheets) {
        var rules = sheets[i].rules || sheets[i].cssRules;
        for (var r in rules) {
            if (a.is(rules[r].selectorText)) {
                o = $.extend(o, css2json(rules[r].style), css2json(a.attr('style')));
            }
        }
    }
    return o;
}

function css2json(css) {
    var s = {};
    if (!css) return s;
    if (css instanceof CSSStyleDeclaration) {
        for (var i in css) {
            if ((css[i]).toLowerCase) {
                s[(css[i]).toLowerCase()] = (css[css[i]]);
            }
        }
    } else if (typeof css == "string") {
        css = css.split("; ");
        for (var i in css) {
            var l = css[i].split(": ");
            s[l[0].toLowerCase()] = (l[1]);
        }
    }
    return s;
}


//Style Editor
	function updateStyleEditor() {
		if ($('#styleCategories').length) {
			$('#styleCategories input.cms-style-update, #styleCategories select.cms-style-update').each(function() {
					var thisAttr = $(this).attr('rel');
					var targetAttr = $('#editorFrame').contents().find('.cms-selected-element').css(thisAttr);
					$(this).val(targetAttr);
			});
			$('#styleCategories input.cms-attr-update, #styleCategories select.cms-attr-update').each(function() {
					var thisAttr = $(this).attr('rel');
					var targetAttr = $('#editorFrame').contents().find('.cms-selected-element').attr(thisAttr);
					$(this).val(targetAttr);	
			});
		}
	}
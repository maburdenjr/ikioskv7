<form id = "cms-editPageProperties" class="smart-form">
	<div class="modal-header">
  	<h4 class="modal-title"><i class="fa fa-wrench"></i> Edit Page Properties</h4>
  </div>
  <div class="modal-body">
  	<div class="form-response"></div>
  </div>
  <div class="modal-footer">
 		<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel </button>
    <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="cms-editPageProperties"> <i class="fa fa-check"></i> Save </button>
  </div>
  <input type="hidden" name="page_id" value="<?php echo $row_getRecord['page_id']; ?>" />
  <input type="hidden" name="version" value="<?php echo $row_getRecord['version']; ?>" />
  <input type="hidden" name="page_version_id" value="<?php echo $row_getRecord['page_version_id']; ?>" />
  <input type="hidden" name="formID" value="cms-editPageProperties">
  <input type="hidden" name="iKioskForm" value="Yes" />
  <input type="hidden" name="appCode" value="CMS" />
  </div>
</form>
<script type="text/javascript">
	pageSetUp();
	runAllForms();
   
  $(function() {
		 $("#cms-editPageProperties").validate({
				 rules : {
					login_email : {
						required : true
					},
					password : {
						required : true
					}
				},
				
				messages : {
					login_email : {
						required : 'Please enter your login email'
					},
					password : {
						required : 'Please enter your password'	
					}
				},
				
				errorPlacement : function(error, element) {
					error.insertAfter(element.parent());
				},
				submitHandler: function(form) {
					var targetForm = $(this.currentForm).attr("id");
					 submitAjaxForm(targetForm);
				 }
		 });
   });
</script>
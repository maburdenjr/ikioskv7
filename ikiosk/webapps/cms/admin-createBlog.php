<form id = "cms-createBlog" class="smart-form">
  <div class="modal-header">
    <h4 class="modal-title">Create New Blog Post</h4>
  </div>
  <fieldset>
    <div class="form-response"></div>
      <section>
        <label class="label">Title</label>
        <label class="input">
          <input type="text" name="title" />
        </label>
      </section>
  </fieldset>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
    <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="cms-createBlog"> <i class="fa fa-check"></i> Save </button>
  </div>
  <input type="hidden" name="formID" value="cms-createBlog">
  <input type="hidden" name="iKioskForm" value="Yes" />
  <input type="hidden" name="appCode" value="CMS" />
  </div>
</form>
<script type="text/javascript">
 pageSetUp();
  $(function() {
		 $("#cms-createBlog").validate({
				 rules : {
					title : {
						required : true
					},
					static_file : {
						required : true
					}
				},
				
				messages : {
					title : {
						required : 'Please enter a title for this blog post'
					},
					static_file : {
						required : 'Please enter a filename for this blog post'	
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
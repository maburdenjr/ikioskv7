<form id = "cms-createPage" class="smart-form">
  <div class="modal-header">
    <h4 class="modal-title">Create New Page</h4>
  </div>
  <fieldset>
    <div class="form-response"></div>
    <div class="row">
      <section class="col col-6">
        <label class="label">Title</label>
        <label class="input">
          <input type="text" name="title" />
        </label>
      </section>
      <section class="col col-6">
        <label class="label">Template</label>
        <label class="select">
          <?php templateList("template_id", $row_getRecord['template_id']); ?>
          <i></i> </label>
      </section>
    </div>
    <div class="row">
      <section class="col col-6">
        <label class="label">Directory</label>
        <label class="select">
          <?php displayDirBrowser("static_folder", $row_getRecord['static_folder']); ?>
          <i></i> </label>
      </section>
      <section class="col col-6">
        <label class="label">Filename</label>
        <label class="input">
          <input type="text" name="static_file" />
        </label>
      </section>
      </section>
    </div>
  </fieldset>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel </button>
    <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="cms-createPage"> <i class="fa fa-check"></i> Save </button>
  </div>
  <input type="hidden" name="formID" value="cms-createPage">
  <input type="hidden" name="iKioskForm" value="Yes" />
  <input type="hidden" name="appCode" value="CMS" />
  </div>
</form>
<script type="text/javascript">
 pageSetUp();
  $(function() {
		 $("#cms-createPage").validate({
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
						required : 'Please enter a title for this content page'
					},
					static_file : {
						required : 'Please enter a filename for this content page'	
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
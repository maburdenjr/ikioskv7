<?php if ($_GET['templateID'] == "softwareUpdates") { ?>
<section class="stacked-set">
  <table id="dt-license2Software" class="table table-striped table-hover table-bordered no-margin no-border">
    <thead>
      <tr>
        <th>Title</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
    [table-body]
      </tbody>
    
  </table>
</section>
<form id = "edit-addSoftware2License" class="smart-form" method="post">
  <fieldset>
    <div class="form-response"></div>
    <section>
      <label class="select">
        <select name="software_id">
          <option value="">Select Application</option>
          [select-list]
        </select><i></i>
      </label>
    </section>
  </fieldset>
  <footer>
    <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="edit-addSoftware2License"> <i class="fa fa-plus"></i> Add</button>
    <input type="hidden" name="cloud_id" value="[cloud-id]" />
    <input type="hidden" name="formID" value="edit-addSoftware2License">
    <input type="hidden" name="iKioskForm" value="Yes" />
    <input type="hidden" name="appCode" value="IKMCP" />
  </footer>
</form>
<script type="text/javascript">
$("#edit-addSoftware2License").validate({
		 errorPlacement : function(error, element) {
				 error.insertAfter(element.parent());
		 },
		 submitHandler: function(form) {
				 var targetForm = $(this.currentForm).attr("id");
				 submitAjaxForm(targetForm);
		 }
 });
 </script>
<?php } ?>

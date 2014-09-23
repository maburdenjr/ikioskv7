<?php
$query_getRecord = "SELECT * FROM cms_blog_article_versions WHERE article_version_id = '".$_GET['recordID']."' AND deleted = '0' AND ".$SYSTEM['active_site_filter'];
$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
$row_getRecord = mysql_fetch_assoc($getRecord);
$totalRows_getRecord = mysql_num_rows($getRecord);
?>

<form id = "cms-editBlogProperties" class="smart-form">
  <div class="modal-header">
    <h4 class="modal-title">Edit Article Properties</h4>
  </div>
  <div class="form-response"></div>
  <fieldset>
    <div class="row">
      <section class="col col-6">
        <label class="label">Title</label>
        <label class="input">
          <input type="text" name="title" value="<?php echo $row_getRecord['title']; ?>">
        </label>
      </section>
      <section class="col col-6">
        <label class="label">Status</label>
        <label class="select">
          <select name="status">
            <option value="Draft" <?php if (!(strcmp("Draft", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Draft</option>
            <option value="Published" <?php if (!(strcmp("Published", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Published</option>
          </select>
          <i></i> </label>
      </section>
    </div>
    <div class="row">
      <section class="col col-6">
        <label class="label">Publish Date</label>
        <div class="input-group">
          <input name="publish_date" type="text" class="form-control datepicker" data-dateformat="mm/dd/yy" value="<?php timezoneProcessDate($row_getRecord['publish_date'], "print"); ?>">
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
      </section>
      <section class="col col-6">
        <label class="label">Expiration Date</label>
        <div class="input-group">
          <input name="expire_date" type="text" class="form-control datepicker" data-dateformat="mm/dd/yy" value="<?php timezoneProcessDate($row_getRecord['expire_date'], "print"); ?>">
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
      </section>
    </div>
    <div class="row">
      <section class="col col-6">
        <label class="label">Auto-Expire?</label>
        <label class="select">
          <select name="auto_expire">
          <option value="No" <?php if (!(strcmp("No", $row_getRecord['auto_expire']))) {echo "selected=\"selected\"";} ?>>No</option>
            <option value="Yes" <?php if (!(strcmp("Yes", $row_getRecord['auto_expire']))) {echo "selected=\"selected\"";} ?>>Yes</option>
          </select>
          <i></i> </label>
      </section>
    </div>
  </fieldset>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel </button>
    <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="cms-editBlogProperties"> <i class="fa fa-check"></i> Save </button>
    <input type="hidden" name="article_id" value="<?php echo $row_getRecord['article_id']; ?>" />
    <input type="hidden" name="version" value="<?php echo $row_getRecord['version']; ?>" />
    <input type="hidden" name="article_version_id" value="<?php echo $row_getRecord['article_version_id']; ?>" />
    <input type="hidden" name="formID" value="cms-editBlogProperties">
    <input type="hidden" name="iKioskForm" value="Yes" />
    <input type="hidden" name="appCode" value="CMS" />
    <input type="hidden" name="content" value="<?php echo htmlentities($row_getRecord['content']); ?>" />
  </div>
</form>
<script type="text/javascript">
 pageSetUp();
  $(function() {
		 $("#cms-editBlogProperties").validate({
				 rules : {
					title : {
						required : true
					}
				},
				
				messages : {
					title : {
						required : 'Please enter a title for this article page'
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
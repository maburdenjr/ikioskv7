<?php
	mysql_select_db($database_ikiosk, $ikiosk);
	$query_getRecord = "SELECT * FROM cms_config WHERE site_id = '".$SITE['site_id']."' AND deleted = '0' AND ".$SYSTEM['active_site_filter'];
	$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
	$row_getRecord = mysql_fetch_assoc($getRecord);
	$totalRows_getRecord = mysql_num_rows($getRecord);

if ($totalRows_getRecord == "0") {
	$generateID = create_guid();
	$insertSQL = sprintf("INSERT INTO cms_config (config_id, site_id, editor_type, slideshow_theme, blog_title, blog_display_count, blog_home_template, blog_article_template, blog_comment_moderation, calendar_month_template, calendar_event_template, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
			GetSQLValueString($generateID, "text"),
			GetSQLValueString($SITE['site_id'], "text"),
			GetSQLValueString("Redactor", "text"),
			GetSQLValueString("Classic", "text"),
			GetSQLValueString($_POST['blog_title'], "text"),
			GetSQLValueString($_POST['blog_display_count'], "text"),
			GetSQLValueString($_POST['blog_home_template'], "text"),
			GetSQLValueString($_POST['blog_article_template'], "text"),
			GetSQLValueString($_POST['blog_comment_moderation'], "text"),
			GetSQLValueString($_POST['calendar_month_template'], "text"),
			GetSQLValueString($_POST['calendar_event_template'], "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"),
			GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
			GetSQLValueString($_SESSION['user_id'], "text"));

	mysql_select_db($database_ikiosk, $ikiosk);
	$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
	sqlQueryLog($insertSQL);
	
	header("Location:".$SYSTEM['current_page']."");
	exit;	
}
?>

<form id = "cms-updateSettings" class="smart-form">
  <div class="modal-header">
    <h4 class="modal-title">Settings</h4>
  </div>
  <div class="modal-body">
    <div class="form-response"></div>
    <header>Blog Settings</header>
    <div class="row">
      <section class="col col-6">
        <label class="label">Title</label>
        <label class="input">
          <input name="blog_title" type="text" class="medium" value="<?php echo $row_getRecord['blog_title']; ?>" />
        </label>
      </section>
      <section class="col col-6">
        <label class="label">Home Template</label>
        <label class="select"><?php templateList("blog_home_template", $row_getRecord['blog_home_template']); ?><i></i></label>
      </section>
    </div>
    <div class="row">
      <section class="col col-6">
        <label class="label">Article Template</label>
        <label class="select"><?php templateList("blog_article_template", $row_getRecord['blog_article_template']); ?><i></i></label>
      </section>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel </button>
    <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="cms-updateSettings"> <i class="fa fa-check"></i> Save </button>
  </div>
  <input type="hidden" name="formID" value="cms-updateSettings">
  <input type="hidden" name="iKioskForm" value="Yes" />
  <input type="hidden" name="appCode" value="CMS" />
  </div>
</form>
<script type="text/javascript">
 pageSetUp();
  $(function() {
		 $("#cms-updateSettings").validate({
				 rules : {
					title : {
						required : true
					}
				},
				
				messages : {
					title : {
						required : 'Please enter a title for this blog'
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
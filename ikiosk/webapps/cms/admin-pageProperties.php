<?php
mysql_select_db($database_ikiosk, $ikiosk);
$query_getRecord = "SELECT * FROM cms_page_versions WHERE page_version_id = '".$_GET['recordID']."' AND deleted = '0' AND ".$SYSTEM['active_site_filter'];
$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
$row_getRecord = mysql_fetch_assoc($getRecord);
$totalRows_getRecord = mysql_num_rows($getRecord);

mysql_select_db($database_ikiosk, $ikiosk);
$query_pageIndex = "SELECT * FROM cms_pages WHERE page_id = '".$row_getRecord['page_id']."' AND deleted = '0' AND ".$SYSTEM['active_site_filter'];
$pageIndex = mysql_query($query_pageIndex, $ikiosk) or sqlError(mysql_error());
$row_pageIndex = mysql_fetch_assoc($pageIndex);
$totalRows_pageIndex = mysql_num_rows($pageIndex);
?>

<form id = "cms-editPageProperties" class="smart-form">
  <div class="modal-header">
    <h4 class="modal-title"><i class="fa fa-wrench"></i> Edit Page Properties</h4>
  </div>
  <ul id="pageProperties-tabs" class="nav nav-tabs">
    <li class="active"> <a data-toggle="tab" href="#general"> General</a> </li>
    <li> <a data-toggle="tab" href="#publishing"> Publishing </a> </li>
    <li> <a data-toggle="tab" href="#seo"> SEO </a> </li>
  </ul>
  <fieldset>
    <div class="tab-content">
      <div class="form-response"></div>
      <div class="tab-pane fade in active" id="general">
        <section>
          <label class="label">Title</label>
          <label class="input">
            <input type="text" name="title" value="<?php echo $row_getRecord['title']; ?>">
          </label>
        </section>
        <div class="row">
          <section class = "col col-4">
            <label class="label">Folder</label>
            <label class="select">
              <?php displayDirBrowser("static_folder", $row_getRecord['static_folder']); ?>
              <i></i> </label>
          </section>
          <section class = "col col-4">
            <label class="label">Filename</label>
            <label class="input">
              <input type="text" name="title" value="<?php echo $row_getRecord['static_file']; ?>">
            </label>
          </section>
          <section class = "col col-4">
            <label class="label">Template</label>
            <label class="select">
              <?php templateList("template_id", $row_getRecord['template_id']); ?>
              <i></i> </label>
          </section>
        </div>
        <div class="row">
          <section class = "col col-6">
            <label class="label">Parent Page</label>
            <label class="select">
              <?php selectParentPage($row_getRecord['page_id'], "parent_id", $row_getRecord['parent_id']); ?>
              <i></i> </label>
          </section>
          <section class = "col col-6">
            <label class="label">Content ID</label>
            <label class="input">
              <input name="content_id" type="text" value="<?php echo $row_getRecord['content_id']; ?>" />
            </label>
          </section>
        </div>
      </div>
      <div class="tab-pane fade in" id="publishing">
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
                <option value="Yes" <?php if (!(strcmp("Yes", $row_getRecord['auto_expire']))) {echo "selected=\"selected\"";} ?>>Yes</option>
                <option value="No" <?php if (!(strcmp("No", $row_getRecord['auto_expire']))) {echo "selected=\"selected\"";} ?>>No</option>
              </select>
              <i></i> </label>
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
      </div>
      <div class="tab-pane fade in" id="seo">
      	<div class="row">
        	<section class="col col-4">
            	<label class="label">Author</label>
            <label class="input">
              <input name="meta_author" type="text" value="<?php echo $row_getRecord['meta_author']; ?>" />
            </label>
            </section>
            <section class="col col-4">
            <label class="label">Robots</label>
            <label class="input">
              <input name="meta_robots" type="text" value="<?php echo $row_getRecord['meta_robots']; ?>" />
            </label>
            </section>
            <section class="col col-4">
            <label class="label">Cache-Control</label>
            <label class="select">
              <select name="meta_cache_control">
                  <option value="" <?php if (!(strcmp("", $row_getRecord['cache_control']))) {echo "selected=\"selected\"";} ?>></option>
                  <option value="Public" <?php if (!(strcmp("Public", $row_getRecord['cache_control']))) {echo "selected=\"selected\"";} ?>>Public</option>
                  <option value="Private" <?php if (!(strcmp("Private", $row_getRecord['cache_control']))) {echo "selected=\"selected\"";} ?>>Private</option>
                  <option value="No-Cache" <?php if (!(strcmp("no-cache", $row_getRecord['cache_control']))) {echo "selected=\"selected\"";} ?>>no-cache</option>
                  <option value="No-Store" <?php if (!(strcmp("no-store", $row_getRecord['cache_control']))) {echo "selected=\"selected\"";} ?>>No-Store</option>
                </select>
              <i></i> </label>
            </section>
        </div>
        <div class="row">
        	<section class="col col-6">
            <label class="label">Description</label>
            <label class="textarea">
                <textarea rows="3" class="custom-scroll" name="meta_description"><?php echo $row_getRecord['meta_description']; ?></textarea>
              </label>
            </section>
            <section class="col col-6">
            <label class="label">Keywords</label>
            <label class="textarea">
                <textarea rows="3" class="custom-scroll" name="meta_keywords"><?php echo $row_getRecord['meta_keywords']; ?></textarea>
              </label>
            </section>
        </div>
      </div>
    </div>
  </fieldset>
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
					title : {
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
<?php 
if (empty($_GET['action'])) {
//List View
mysql_select_db($database_ikiosk, $ikiosk);
$query_listView = "SELECT * FROM cms_templates WHERE deleted = '0' AND ".$SYSTEM['active_site_filter']." ORDER by date_created DESC ";
$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
$row_listView = mysql_fetch_assoc($listView);
$totalRows_listView = mysql_num_rows($listView);
?>

<div class="modal-header">
  <h4 class="modal-title">Templates</h4>
</div>
<div class="modal-body no-padding">
  <div class="system-message"></div>
  <table id="dt-templates" class="table table-striped table-hover" width="100%">
    <thead>
      <tr>
        <th>Title</th>
        <th>Status</th>
        <th>Date Modified</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php if ($totalRows_listView != 0) { do {
					   $thisTemplate = getTemplateVersion($row_listView['template_id']);	
				 ?>
      <tr class="<?php echo $row_listView['template_id']; ?>">
        <td><a href="/cms/ajaxHandler.php?ajaxAction=templates&appCode=CMS&action=edit&recordID=<?php echo $thisTemplate['template_version_id']; ?>" class="modalDynLink"><?php echo $thisTemplate['title']; ?></a></td>
        <td><?php echo $thisTemplate['status']; ?></td>
        <td><?php timezoneProcess($thisTemplate['date_modified'], "print"); ?></td>
        <td class="icon"><a class="delete-record" data-table="cms_templates" data-record="<?php echo $thisTemplate['template_id']; ?>" data-code="CMS" data-field="template_id"><i class="fa fa-trash-o"></i></a></td>
        <?php } while ($row_listView = mysql_fetch_assoc($listView)); } ?>
    </tbody>
  </table>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
</div>
<script type="text/javascript">
		var listView = $('#dt-templates').dataTable();
		   $('.dataTables_length').before('<a href="/cms/ajaxHandler.php?ajaxAction=templates&appCode=CMS&action=create" class="btn btn-primary btn-toggle btn-add modalDynLink""><i class="fa fa-plus"></i> New <span class="hidden-mobile"> Template</span></a> <a href="/cms/ajaxHandler.php?ajaxAction=downloadTemplate&appCode=CMS" class="btn btn-default btn-toggle btn-add modalDynLink""><i class="fa fa-cloud-download"></i> Download <span class="hidden-mobile"> Template</span></a>');
	
</script>
<?php } ?>
<?php if ($_GET['action'] == "create") { ?>
<form id = "cms-createTemplate" class="smart-form">
  <div class="modal-header">
    <h4 class="modal-title">New Template</h4>
    <small><a href="/cms/ajaxHandler.php?ajaxAction=cmsAdmin&appCode=CMS" class="dynamicModal">CMS</a> > <a href="/cms/ajaxHandler.php?ajaxAction=templates&appCode=CMS" class="modalDynLink dynRefresh">Templates</a></small> </div>
  <div class="modal-body">
    <div class="form-response"></div>
    <section>
      <label class="label">Title</label>
      <label class="input">
        <input name="title" value="<?php echo $row_getRecord['title']; ?>" />
      </label>
    </section>
    <section>
      <label class="label">Header Code</label>
      <div class="note">Code appears between the &lt;head&gt;> and &lt;/head&gt; tags.</div>
      <label class="textarea">
        <textarea rows="4" class="custom-scroll" name="header_code"><?php echo $row_getRecord['header_code']; ?></textarea>
      </label>
    </section>
    <section>
      <label class="label">Body Header</label>
      <div class="note">Code appears after the &lt;body&gt; tag and before page content.</div>
      <label class="textarea">
        <textarea rows="4" class="custom-scroll" name="body_header_code"><?php echo $row_getRecord['body_header_code']; ?></textarea>
      </label>
    </section>
    <section>
      <label class="label">Body Footer</label>
      <div class="note">Code appears after the  page content and before the &lt;/body&gt; tag.</div>
      <label class="textarea">
        <textarea rows="4" class="custom-scroll" name="body_footer_code"><?php echo $row_getRecord['body_footer_code']; ?></textarea>
      </label>
    </section>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
    <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="cms-createTemplate"> <i class="fa fa-check"></i> Save </button>
    <input type="hidden" name="formID" value="cms-createTemplate">
    <input type="hidden" name="iKioskForm" value="Yes" />
    <input type="hidden" name="appCode" value="CMS" />
  </div>
</form>
<script type="text/javascript">
 pageSetUp();
  $(function() {
		 $("#cms-createTemplate").validate({
				 rules : {
					title : {
						required : true
					}
				},
				
				messages : {
					title : {
						required : 'Please enter a title for this code template'
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
<?php } ?>
<?php 
if ($_GET['action'] == "edit") { 
mysql_select_db($database_ikiosk, $ikiosk);
$query_getRecord = "SELECT * FROM cms_template_versions WHERE template_version_id = '".$_GET['recordID']."' AND deleted = '0' AND  ".$SYSTEM['active_site_filter'];
$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
$row_getRecord = mysql_fetch_assoc($getRecord);
$totalRows_getRecord = mysql_num_rows($getRecord);
?>
<form id = "cms-editTemplate" class="smart-form">
  <div class="modal-header">
    <h4 class="modal-title"><?php echo $row_getRecord['title']; ?></h4>
    <small><a href="/cms/ajaxHandler.php?ajaxAction=cmsAdmin&appCode=CMS" class="dynamicModal">CMS</a> > <a href="/cms/ajaxHandler.php?ajaxAction=templates&appCode=CMS" class="modalDynLink dynRefresh">Templates</a></small> </div>
  <ul id="systemDebug-tabs" class="nav nav-tabs">
    <li class="active"> <a data-toggle="tab" href="#edit">Edit</a> </li>
    <li> <a data-toggle="tab" href="#preview">Preview</a> </li>
  </ul>
  <div class="modal-body">
    <div class="form-response"></div>
    <div class="tab-content no-padding custom-scroll">
      <div class="tab-pane fade in active" id="edit">
        <section>
          <label class="label">Title</label>
          <label class="input">
            <input name="title" value="<?php echo $row_getRecord['title']; ?>" />
          </label>
        </section>
        <section>
          <label class="label">Header Code</label>
          <div class="note">Code appears between the &lt;head&gt;> and &lt;/head&gt; tags. <br>
            All templates are pre-loaded with jQuery 2.0.2, jQueryUI 1.10.3, and Bootstrap 3.1.1.</div>
          <label class="textarea">
            <textarea rows="4" class="custom-scroll" name="header_code"><?php echo $row_getRecord['header_code']; ?></textarea>
          </label>
        </section>
        <section>
          <label class="label">Body Header</label>
          <div class="note">Code appears after the &lt;body&gt; tag and before page content.</div>
          <label class="textarea">
            <textarea rows="4" class="custom-scroll" name="body_header_code"><?php echo $row_getRecord['body_header_code']; ?></textarea>
          </label>
        </section>
        <section>
          <label class="label">Body Footer</label>
          <div class="note">Code appears after the  page content and before the &lt;/body&gt; tag.</div>
          <label class="textarea">
            <textarea rows="4" class="custom-scroll" name="body_footer_code"><?php echo $row_getRecord['body_footer_code']; ?></textarea>
          </label>
        </section>
        <section>
          <label class="label">Status</label>
          <label class="select">
            <select name="status">
              <option value="Draft" <?php if (!(strcmp("Draft", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Draft</option>
              <option value="Published" <?php if (!(strcmp("Published", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Published</option>
            </select>
            <i></i> </label>
        </section>
      </div>
      <div class="tab-pane fade in" id="preview">
      <iframe src ="<?php echo $SITE['site_url']."?editor=off&template=".$row_getRecord['template_id'];?>"></iframe>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
    <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="cms-editTemplate"> <i class="fa fa-check"></i> Save </button>
    <input type="hidden" name="template_id" value="<?php echo $row_getRecord['template_id']; ?>" />
    <input type="hidden" name="version" value="<?php echo $row_getRecord['version']; ?>" />
    <input type="hidden" name="formID" value="cms-editTemplate">
    <input type="hidden" name="iKioskForm" value="Yes" />
    <input type="hidden" name="appCode" value="CMS" />
  </div>
</form>
<script type="text/javascript">
 pageSetUp();
  $(function() {
		 $("#cms-editTemplate").validate({
				 rules : {
					title : {
						required : true
					}
				},
				
				messages : {
					title : {
						required : 'Please enter a title for this template'
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
<?php } ?>

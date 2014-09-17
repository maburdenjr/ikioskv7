<?php 
if (empty($_GET['action'])) {
//List View
mysql_select_db($database_ikiosk, $ikiosk);
$query_listView = "SELECT * FROM cms_page_elements WHERE deleted = '0' AND  ".$SYSTEM['active_site_filter'];
$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
$row_listView = mysql_fetch_assoc($listView);
$totalRows_listView = mysql_num_rows($listView);
?>

<div class="modal-header">
  <h4 class="modal-title">Code Snippets</h4>
</div>
<div class="modal-body no-padding">
  <div class="system-message"></div>
  <table id="dt-codeSnippets" class="table table-striped table-hover" width="100%">
    <thead>
      <tr>
        <th>Title</th>
        <th>Status</th>
        <th>Date Modified</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php if ($totalRows_listView != 0) { do { ?>
      <tr class="<?php echo $row_listView['page_element_id']; ?>">
        <td><a href="/cms/ajaxHandler.php?ajaxAction=codeSnippets&appCode=CMS&action=edit&recordID=<?php echo $row_listView['page_element_id']; ?>" class="modalDynLink"><?php echo $row_listView['title']; ?></a></td>
        <td><?php echo $row_listView['status']; ?></td>
        <td><?php timezoneProcess($row_listView['date_modified'], "print"); ?></td>
        <td class="icon"><a class="delete-record" data-table="cms_page_elements" data-record="<?php echo $row_listView['page_element_id']; ?>" data-code="CMS" data-field="page_id"><i class="fa fa-trash-o"></i></a></td>
        <?php } while ($row_listView = mysql_fetch_assoc($listView)); } ?>
    </tbody>
  </table>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
</div>
<script type="text/javascript">
		var listView = $('#dt-codeSnippets').dataTable({
			"order": [[	2, "desc"]]
			});
		   $('.dataTables_length').before('<a href="/cms/ajaxHandler.php?ajaxAction=codeSnippets&appCode=CMS&action=create" class="btn btn-primary btn-toggle btn-add modalDynLink""><i class="fa fa-plus"></i> New <span class="hidden-mobile"> Code Snippet</span></a>');
	
</script>
<?php } 
if ($_GET['action'] == "edit") { 
mysql_select_db($database_ikiosk, $ikiosk);
$query_getRecord = "SELECT * FROM cms_page_elements WHERE page_element_id = '".$_GET['recordID']."' AND deleted = '0' AND  ".$SYSTEM['active_site_filter'];
$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
$row_getRecord = mysql_fetch_assoc($getRecord);
$totalRows_getRecord = mysql_num_rows($getRecord);
?>
<form id = "cms-editCodeSnippet" class="smart-form">
  <div class="modal-header">
    <h4 class="modal-title"><?php echo $row_getRecord['title']; ?></h4>
    <small><a href="/cms/ajaxHandler.php?ajaxAction=cmsAdmin&appCode=CMS" class="dynamicModal">CMS</a> > <a href="/cms/ajaxHandler.php?ajaxAction=codeSnippets&appCode=CMS" class="modalDynLink">Code Snippets</a></small> </div>
  <div class="modal-body">
    <div class="form-response"></div>
    <section>
      <label class="label">Title</label>
      <label class="input">
        <input name="title" value="<?php echo $row_getRecord['title']; ?>" />
      </label>
    </section>
    <section>
      <label class="label">HTML</label>
      <label class="textarea">
        <textarea rows="8" class="custom-scroll" name="content"><?php echo $row_getRecord['content']; ?></textarea>
      </label>
    </section>
    <section>
      <label class="label">Status</label>
      <label class="select">
        <select name="status">
          <option value="Active" <?php if (!(strcmp("Active", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Active</option>
          <option value="Inactive" <?php if (!(strcmp("Inactive", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Inactive</option>
        </select>
        <i></i> </label>
    </section>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
    <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="cms-editCodeSnippet"> <i class="fa fa-check"></i> Save </button>
    <input type="hidden" name="page_element_id" value="<?php echo $row_getRecord['page_element_id']; ?>" />
    <input type="hidden" name="formID" value="cms-editCodeSnippet">
    <input type="hidden" name="iKioskForm" value="Yes" />
    <input type="hidden" name="appCode" value="CMS" />
  </div>
</form>
<script type="text/javascript">
 pageSetUp();
  $(function() {
		 $("#cms-editCodeSnippet").validate({
				 rules : {
					title : {
						required : true
					}
				},
				
				messages : {
					title : {
						required : 'Please enter a title for this code snippet'
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
<?php if ($_GET['action'] == "create") { ?>
<form id = "cms-createCodeSnippet" class="smart-form">
  <div class="modal-header">
    <h4 class="modal-title">New Code Snippet</h4>
    <small><a href="/cms/ajaxHandler.php?ajaxAction=cmsAdmin&appCode=CMS" class="dynamicModal">CMS</a> > <a href="/cms/ajaxHandler.php?ajaxAction=codeSnippets&appCode=CMS" class="modalDynLink dynRefresh">Code Snippets</a></small> </div>
  <div class="modal-body">
    <div class="form-response"></div>
    <section>
      <label class="label">Title</label>
      <label class="input">
        <input name="title" value="<?php echo $row_getRecord['title']; ?>" />
      </label>
    </section>
    <section>
      <label class="label">HTML</label>
      <label class="textarea">
        <textarea rows="8" class="custom-scroll" name="content"><?php echo $row_getRecord['content']; ?></textarea>
      </label>
    </section>
    <section>
      <label class="label">Status</label>
      <label class="select">
        <select name="status">
          <option value="Active" <?php if (!(strcmp("Active", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Active</option>
          <option value="Inactive" <?php if (!(strcmp("Inactive", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Inactive</option>
        </select>
        <i></i> </label>
    </section>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
    <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="cms-createCodeSnippet"> <i class="fa fa-check"></i> Save </button>
    <input type="hidden" name="formID" value="cms-createCodeSnippet">
    <input type="hidden" name="iKioskForm" value="Yes" />
    <input type="hidden" name="appCode" value="CMS" />
  </div>
</form>
<script type="text/javascript">
 pageSetUp();
  $(function() {
		 $("#cms-createCodeSnippet").validate({
				 rules : {
					title : {
						required : true
					}
				},
				
				messages : {
					title : {
						required : 'Please enter a title for this code snippet'
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

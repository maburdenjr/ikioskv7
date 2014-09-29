<?php 
//List View
mysql_select_db($database_ikiosk, $ikiosk);
$query_listView = "SELECT * FROM cms_page_versions WHERE page_id = '".$_GET['recordID']."' AND deleted = '0' AND  ".$SYSTEM['active_site_filter'];
$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
$row_listView = mysql_fetch_assoc($listView);
$totalRows_listView = mysql_num_rows($listView);
?>

<div class="modal-header">
  <h4 class="modal-title">Version History</h4>
</div>
<div class="modal-body no-padding">
<div class="system-message"></div>
<table id="dt-pageVersions" class="table table-striped table-hover" width="100%">
  <thead>
    <tr>
      <th>Title</th>
      <th>Version</th>
      <th>Status</th>
      <th>Date Modified</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php if ($totalRows_listView != 0) { do { ?>
      <tr class="<?php echo $row_listView['page_version_id']; ?>">
        <td><a href="<?php echo $row_listView['static_folder'].$row_listView['static_file']."?page=".$row_listView['page_version_id']; ?>"><?php echo $row_listView['title']; ?></a></td>
        <td><?php echo $row_listView['version']; ?></td>
        <td><?php echo $row_listView['status']; ?></td>
        <td><?php timezoneProcess($row_listView['date_modified'], "print"); ?></td>
           <td class="icon"><a class="delete-record" data-table="cms_page_versions" data-record="<?php echo $row_listView['page_version_id']; ?>" data-code="CMS" data-field="page_version_id"><i class="fa fa-trash-o"></i></a></td>
      </tr>
      <?php } while ($row_listView = mysql_fetch_assoc($listView)); } ?>
  </tbody>
</table>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Close </button>
</div>
<script type="text/javascript">
		var listView = $('#dt-pageVersions').dataTable({
				"order": [[	3, "desc"]]
			});
</script> 

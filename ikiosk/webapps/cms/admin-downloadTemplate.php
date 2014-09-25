<?php if (empty($_GET['action'])) { 
$softwareList = urlFetch($SYSTEM['ikiosk_cloud']."/system/api/software.php?ikiosk_id=".$SYSTEM['ikiosk_id']."&ikiosk_license_key=".$SYSTEM['ikiosk_license_key']."");
$softwareList = explode("[iKiosk]", $softwareList);
?>

<div class="modal-header">
  <h4 class="modal-title">Download Templates</h4>
  <small><a href="/cms/ajaxHandler.php?ajaxAction=cmsAdmin&appCode=CMS" class="dynamicModal">CMS</a> > <a href="/cms/ajaxHandler.php?ajaxAction=templates&appCode=CMS" class="modalDynLink">Templates</a></small> </div>
   <div class="modal-body no-padding">
  <table id="dt-softwareDownloadList" class="table table-striped table-bordered table-hover" width="100%">
    <thead>
      <tr>
        <th>Title</th>
        <th>Version</th>
        <th>Type</th>
        <th>Last Updated</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($softwareList as $key => $value) { 
										$softwareDetail = explode("|", $value);
										if (!empty($softwareDetail[2]) && ($softwareDetail[6] == "CMS Template")) {
										?>
      <tr>
        <td><?php echo $softwareDetail[1]; ?></td>
        <td><?php echo $softwareDetail[4]; ?></td>
        <td><?php echo $softwareDetail[6]; ?></td>
        <td><?php timezoneProcess($softwareDetail[9], "print"); ?></td>
        <td class="align-right"><a class="btn btn-primary icon-action" data-type="processTemplate" data-code="CMS" data-record="<?php echo $softwareDetail[0]; ?>"><i class="fa fa-cloud-download"></i> Install</a></td>
      </tr>
      <?php } } ?>
    </tbody>
  </table>
    <div class="system-message"></div>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel </button>
</div>
<script type="text/javascript">
				 var listView = $('#dt-softwareDownloadList').dataTable();
			</script>
<?php } ?>

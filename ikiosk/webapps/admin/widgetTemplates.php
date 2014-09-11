<?php if ($_GET['templateID'] == "downloadSoftware") { ?>

<section class="embedded-response">
  <table id="dt-downloadFileList" class="table table-striped table-hover table-bordered">
    <thead>
      <tr>
        <th>Source</th>
        <th>Destination</th>
      </tr>
    </thead>
    <tbody>
    
    [table-body]
      </tbody>
    
  </table>
</section>
<script type="text/javascript">
	 var listView = $('#dt-downloadFileList').dataTable({"iDisplayLength": 5});
	 $('#sys-softwareDownloadArchive .jarviswidget-refresh-btn').click();
</script>
<?php } ?>
<?php if ($_GET['templateID'] == "softwareHistory") { ?>

<section class="embedded-response">
  <table id="dt-softwareHistory" class="table table-striped table-hover table-bordered">
    <thead>
      <tr>
        <th>Title</th>
        <th>Version</th>
        <th>Type</th>
        <th>Date</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
    
    [table-body]
      </tbody>
    
  </table>
</section>
<script type="text/javascript">
	 var listView = $('#dt-softwareHistory').dataTable({"iDisplayLength": 5});
</script>
<?php } ?>

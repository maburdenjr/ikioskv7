<?php 
//List View
mysql_select_db($database_ikiosk, $ikiosk);
$query_listView = "SELECT * FROM cms_page_versions WHERE page_id = '".$row_getRecord['recordID']."' AND deleted = '0' AND  ".$SYSTEM['active_site_filter'];
$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
$row_listView = mysql_fetch_assoc($listView);
$totalRows_listView = mysql_num_rows($listView);

?>

<div class="modal-header">
  <h4 class="modal-title">Versions</h4>
</div>
<div class="modal-body">
  <section id="widget-grid">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="system-message"></div>
      <div class="jarviswidget" id="cms-lv-pageVersions" data-widget-editbutton="false" data-widget-deletebutton="false"> </div>
      <div>
        <div class="jarviswidget-editbox">
          <input class="form-control" type="text">
        </div>
        <div class="widget-body no-padding"> </div>
      </div>
    </article>
  </section>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel </button>
</div>

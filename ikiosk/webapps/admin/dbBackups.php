<?php
 /* iKiosk 7.0 Tiger */
 $PAGE['application_code'] = "SYS";
 require('../../includes/core/ikiosk.php');
 
 //List View
mysql_select_db($database_ikiosk, $ikiosk);
$query_listView = "SELECT * FROM sys_backups WHERE deleted = '0' AND  ".$_SESSION['team_filter'];
$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
$row_listView = mysql_fetch_assoc($listView);
$totalRows_listView = mysql_num_rows($listView);
 ?>

<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title">Database Backups</h1>
  </div>
</div>
<section id="widget-grid">
  <div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="jarviswidget" id="sys-dbBackups" data-widget-editbutton="false" data-widget-deletebutton="false">
        <header> <span class="widget-icon"> <i class="fa fa-database"></i> </span>
          <h2>Backups</h2>
        </header>
        <div>
          <div class="jarviswidget-editbox">
            <input class="form-control" type="text">
          </div>
          <div class="widget-body no-padding">
             <table id="dt-dbBackups" class="table table-striped table-bordered table-hover" width="100%">
              <thead>
            <tr>
              <th>Backup File</th>
              <th>Date Created</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
        <?php if ($totalRows_listView != "0") { do { ?>
			<tr>
            <td><a href="/backups/<?php echo $row_listView['backup_file']; ?>" target="_blank"><?php echo $row_listView['backup_file']; ?></a></td>
            <td><?php timezoneProcess($row_listView['date_created'], "print"); ?></td>
            <td></td>
            </tr>
		<?php } while ($row_listView = mysql_fetch_assoc($listView)); } ?>
        </tbody>
</table>
          </div>
        </div>
      </div>
    </article>
  </div>
</section>
<script type="text/javascript">
	 var listView = $('#dt-dbBackups').dataTable({
	 		"order": [[ 1, "desc" ]]
	 });
   pageSetUp();

</script>
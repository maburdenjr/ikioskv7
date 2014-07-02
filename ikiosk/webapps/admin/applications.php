<?php
/* iKiosk 7.0 Tiger */
$PAGE['application_code'] = "SYS";
require('../../includes/core/ikiosk.php');

//Action Controller
switch($_GET['action']) {
	case "edit":
			$panelAction = "edit";
			break;
	case "create":
		$panelAction = "create";
		break;
	default:
		$panelAction = "list";
}
?>
<?php 
if ($panelAction == "list") { // List View - Default 

mysql_select_db($database_ikiosk, $ikiosk);
$query_listView = "SELECT * FROM sys_applications WHERE deleted = '0'";
$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
$row_listView = mysql_fetch_assoc($listView);
$totalRows_listView = mysql_num_rows($listView);
?>
<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title">Application Management</h1>
  </div>
</div>
<section id="widget-grid">
  <div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="jarviswidget" id="sys-applications" data-widget-editbutton="false">
        <header> <span class="widget-icon"> <i class="fa fa-table"></i> </span>
          <h2>Applications</h2>
        </header>
        <!-- widget div-->
        <div> 
          <!-- widget edit box -->
          <div class="jarviswidget-editbox"> 
            <!-- This area used as dropdown edit box -->
            <input class="form-control" type="text">
          </div>
          <!-- end widget edit box --> 
          
          <!-- widget content -->
          <div class="widget-body no-padding">
            <table id="dt_applications" class="table table-striped table-bordered table-hover" width="100%">
              <thead>
                <tr>
                  <th>Title</th>
                  <th>System Code</th>
                  <th>User Access</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
              <?php do { ?>
              		<tr>
                  <td><a href="?action=edit&recordID=<?php echo $row_listView['application_id']; ?>#webapps/admin/applications.php"><?php echo $row_listView['application_title']; ?></a></td>
                  <td><?php echo $row_listView['application_code']; ?></td>
                  <td><?php echo $row_listView['application_security']; ?></td>
                  <td><?php echo $row_listView['application_status']; ?></td>
                 </tr> 
              <?php } while ($row_listView = mysql_fetch_assoc($listView)); ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </article>
  </div>
</section>
<script type="text/javascript">
		pageSetUp();
		$('#dt_applications').dataTable();
</script> 
<?php } ?>
<?php 
if ($panelAction == "edit") { // Edit View 
//Get Current Record
mysql_select_db($database_ikiosk, $ikiosk);
$query_getRecord = "SELECT * FROM sys_applications WHERE deleted = '0' AND application_id = '".$_GET['recordID']."'";
$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
$row_getRecord = mysql_fetch_assoc($getRecord);
$totalRows_getRecord = mysql_num_rows($getRecord);

if ($totalRows_getRecord == "0") {
}
?>
<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title">Application Test</h1>
  </div>
</div>
<?php } ?>

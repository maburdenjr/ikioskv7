<?php
/* iKiosk 7.0 Tiger */
$PAGE['application_code'] = "SYS";
require('../../includes/core/ikiosk.php');

//List View
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
                  <th>Version</th>
                  <th>FileSystem Root</th>
                  <th>Security Clearance</th>
                  <th>User Access</th>
                  <th>Status</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </article>
  </div>
</section>
<script type="text/javascript">
		pageSetUp();
</script> 

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
	 
 if ($panelAction == "list") { // List View - Default 

 ?>

<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title">mySQL Logs</h1>
  </div>
</div>
<section id="widget-grid">
  <div class="row">
    <article class="col-sm-12 col-md-12 col-lg-12">
      <div class="jarviswidget" id="sys-mysqllogs" data-widget-editbutton="false" data-widget-deletebutton="false">
        <header> <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
          <h2>Recent Activity</h2>
        </header>
        <div>
          <div class="jarviswidget-editbox"> 
            <!-- This area used as dropdown edit box -->
            <input class="form-control" type="text">
          </div>
          <div class="widget-body no-padding">
            <table id="dt-mysqlLogs" class="table table-striped table-bordered table-hover" width="100%">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>User</th>
                  <th>GPS</th>
                  <th>IP Address</th>
                  <th>Server</th>
                  <th>Site</th>
                  <th>Application</th>
                  <th>URL</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </article>
  </div>
</section>
<?php } ?>
<script type="text/javascript">
   pageSetUp();
</script>
<?php
 /* iKiosk 7.0 Tiger */
   $PAGE['track'] = "No";
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
 
 //Get and Parse Access Logs
$accessFile = $SYSTEM['ikiosk_filesystem_root'].$SYSTEM['ikiosk_root']."/logs/error.log";
$fh = fopen($accessFile, 'r');
$accessLogs = fread($fh, filesize($accessFile));
fclose($fh);
$accessLogData = explode("[iKioskLog]", $accessLogs);
krsort($accessLogData);

 ?>

<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title"><i class="fa fa-warning fa-fw "></i> Error Logs</h1>
  </div>
</div>
<section id="widget-grid">
  <div class="row">
    <article class="col-sm-12 col-md-12 col-lg-12">
      <div class="jarviswidget" id="sys-errorLogs" data-widget-editbutton="false" data-widget-deletebutton="false">
        <header> <span class="widget-icon"> <i class="fa fa-bar-chart-o"></i> </span>
          <h2>Recent Activity</h2>
        </header>
        <div>
          <div class="jarviswidget-editbox"> 
            <!-- This area used as dropdown edit box -->
            <input class="form-control" type="text">
          </div>
          <div class="widget-body no-padding">
            <table id="dt-errorLogs" class="table table-striped table-bordered table-hover" width="100%">
              <thead>
                <tr>
                  <th nowrap>Date</th>
                  <th>Type</th>
                  <th>User</th>
                  <th>IP </th>
                  <th>Site</th>
                  <th>Error Details</th>
                </tr>
              </thead>
              <tbody>
                <?php 
foreach ($accessLogData  as $key => $value) { 
	$accessLogRow = explode("|", $value);
	$userName = getUserData($accessLogRow[7], "display_name");
	$siteName = getSiteData(trim($accessLogRow[0]), "site_name");
	$applicationName = crossReference("sys_applications", "application_code", $accessLogRow[2], $subQuery, $teamFilter, $siteFilter, "application_title", "return");
	$applicationID = crossReference("sys_applications", "application_code", $accessLogRow[2], $subQuery, $teamFilter, $siteFilter, "application_id", "return");
	$urlFilter = substr($accessLogRow[5], -4);
		if ($urlFilter == "?v=0") {
			$accessLogRow[5] = str_replace($urlFilter, "", $accessLogRow[5]);	
		}
	if (!empty($accessLogRow[6])) {
	?>
                <tr>
                  <td nowrap><?php timezoneProcess($accessLogRow[3], "print") ?></td>
                  <td><?php echo $accessLogRow[1]; ?></td>
                  <td><a href="index.php?action=edit&recordID=<?php echo $accessLogRow[7]; ?>#webapps/admin/users.php" class="ajaxLink"><?php echo $userName; ?></a></td>
                  <td><?php echo $accessLogRow[4]; ?></td>
                  <td><a href="index.php?action=edit&recordID=<?php echo trim($accessLogRow[0]); ?>#webapps/admin/sites.php" class="ajaxLink"><?php echo $siteName; ?></a></td>
                  <td><a href="index.php?action=edit&recordID=<?php echo $applicationID; ?>#webapps/admin/applications.php" class="ajaxLink"><?php echo $applicationName; ?></a><br><?php echo $accessLogRow[5]; ?><br><br><?php echo $accessLogRow[6]; ?></td>
                  
                </tr>
                <?php } } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </article>
  </div>
  <script type="text/javascript">
   var listView = $('#dt-errorLogs').dataTable({
	 		"order": [[ 0, "desc" ]]
	 });
	</script> 
</section>
<?php } ?>
<script type="text/javascript">
   pageSetUp();


</script>
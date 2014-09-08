<?php
/* iKiosk 7.0 Tiger */
$PAGE['application_code'] = "SYS";
require('../../includes/core/ikiosk.php');

$softwareList = urlFetch($SYSTEM['ikiosk_cloud']."/system/api/software.php?ikiosk_id=".$SYSTEM['ikiosk_id']."&ikiosk_license_key=".$SYSTEM['ikiosk_license_key']."");
$softwareList = explode("[iKiosk]", $softwareList);
?>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-lg-12">
    <h1 class="page-title">Software Downloads and Updates</h1>
  </div>
</div>
<section id="widget-grid">
  <div class="row">
    <article class="col-sm-12 col-md-6 col-lg-6">
      <div class="jarviswidget" id="cloud-softwareDownloads" data-widget-editbutton="false">
        <header> <span class="widget-icon"> <i class="fa fa-cubes"></i> </span>
          <h2>Available Downloads</h2>
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
										if (!empty($softwareDetail[2])) {
										?>
               <tr>
              		 <td><?php echo $softwareDetail[1]; ?></td>
                  <td><?php echo $softwareDetail[4]; ?></td>
                   <td><?php echo $softwareDetail[6]; ?></td>
                  <td><?php timezoneProcess($softwareDetail[9], "print"); ?></td>
                  <td><a class="btn btn-primary icon-action" data-type="downloadSoftware" data-code="<?php echo $APPLICATION['application_code']; ?>" data-record="<?php echo $softwareDetail[0]; ?>"><i class="fa fa-cloud-download"></i> Install</a></td>
               </tr>     
               <?php } } ?>
              </tbody>
            </table>
            <div class="system-message embedded-response"></div>
          </div>
        </div>
      </div>
      <script type="text/javascript">
				 var listView = $('#dt-softwareDownloadList').dataTable();
			</script> 
    </article>
    <article class="col-sm-12 col-md-6 col-lg-6">
      <div class="jarviswidget" id="sys-softwareDownloadArchive" data-widget-editbutton="false" data-widget-deletebutton="false"  data-widget-togglebutton="false"  data-widget-fullscreenbutton="false" data-widget-load="includes/core/formProcessor.php?ajaxAction=softwareHistory&appCode=SYS&recordID=<?php echo $row_getRecord['user_id']; ?>">
        <header> <span class="widget-icon"> <i class="fa fa-cubes"></i> </span>
          <h2>Download History</h2>
        </header>
        <div>
          <div class="jarviswidget-editbox"> 
            <!-- This area used as dropdown edit box -->
            <input class="form-control" type="text">
          </div>
          <div class="widget-body no-padding"> </div>
        </div>
      </div>
    </article>
  </div>
</section>
<script type="text/javascript">
		pageSetUp();
</script> 

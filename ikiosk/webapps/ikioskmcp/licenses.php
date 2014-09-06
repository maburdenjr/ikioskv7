<?php
   /* iKiosk 7.0 Tiger */
   
   $PAGE['application_code'] = "IKMCP";
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
   
   mysql_select_db($database_ikiosk, $ikiosk);
   $query_listView = "SELECT * FROM ikioskcloud_licenses WHERE deleted = '0' ";
   $listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
   $row_listView = mysql_fetch_assoc($listView);
   $totalRows_listView = mysql_num_rows($listView);
   ?>

<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title">Software Licenses</h1>
  </div>
</div>
<section id="widget-grid"> 
  <!-- Begin Create Record -->
  <div class="modal fade" id="createCtn-IkioskcloudLicenses">
    <div class="modal-dialog">
      <div class="modal-content">
      <form id = "create-IkioskcloudLicenses" class="smart-form" method="post">
        <div class="modal-header">
          <h4 class="modal-title">Create Software License</h4>
        </div>
        <div class="modal-body">
          <div class="form-response"></div>
          <div class="row">
            <section class="col col-6">
              <label class="label">Site Name</label>
              <label class="input">
                <input type="text" name="site_name" value="<?php echo $row_getRecord['site_name']; ?>">
              </label>
            </section>
            <section class="col col-6">
              <label class="label">Site URL</label>
              <label class="input">
                <input type="text" name="site_url" value="<?php echo $row_getRecord['site_url']; ?>">
              </label>
            </section>
          </div>
          <div class="row">
            <section class="col col-6">
              <label class="label">iKiosk ID</label>
              <label class="input">
                <input type="text" name="ikiosk_id" value="<?php echo $row_getRecord['ikiosk_id']; ?>">
              </label>
            </section>
            <section class="col col-6">
              <label class="label">License Type</label>
              <label class="select">
                <select name="license_type">
                  <option value="Basic" <?php if (!(strcmp("Basic", $row_getRecord['license_type']))) {echo "selected=\"selected\"";} ?>>Basic</option>
                  <option value="Premium" <?php if (!(strcmp("Premium", $row_getRecord['license_type']))) {echo "selected=\"selected\"";} ?>>Premium</option>
                  <option value="Professional" <?php if (!(strcmp("Professional", $row_getRecord['license_type']))) {echo "selected=\"selected\"";} ?>>Professional</option>
                  <option value="Affiliate" <?php if (!(strcmp("Affiliate", $row_getRecord['license_type']))) {echo "selected=\"selected\"";} ?>>Affiliate</option>
                  <option value="Reseller" <?php if (!(strcmp("Reseller", $row_getRecord['license_type']))) {echo "selected=\"selected\"";} ?>>Reseller</option>
                  <option value="CMS Cloud" <?php if (!(strcmp("CMS Cloud", $row_getRecord['license_type']))) {echo "selected=\"selected\"";} ?>>CMS Cloud</option>
                  <option value="OEM" <?php if (!(strcmp("OEM", $row_getRecord['license_type']))) {echo "selected=\"selected\"";} ?>>OEM</option>
                </select>
                <i></i> </label>
            </section>
          </div>
          <div class="row">
            <section class="col col-6">
              <label class="label">Expiration Date</label>
              <div class="input-group">
                <input name="expiration_date" type="text" class="form-control datepicker" data-dateformat="mm/dd/yy" value="<?php timezoneProcessDate($row_getRecord['expiration_date'], "print"); ?>">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
            </section>
            <section class="col col-6">
              <label class="label">Status</label>
              <label class="select">
                <select name="status">
                  <option value="Active" <?php if (!(strcmp("Active", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Active</option>
                  <option value="Inactive" <?php if (!(strcmp("Inactive", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Inactive</option>
                </select>
                <i></i> </label>
            </section>
          </div>
          <div class="row">
            <section class="col col-6">
              <label class="label">Max Sites</label>
              <label class="input">
                <input type="text" name="max_sites" value="<?php echo $row_getRecord['max_sites']; ?>">
              </label>
            </section>
            <section class="col col-6">
              <label class="label">Max Users</label>
              <label class="input">
                <input type="text" name="max_users" value="<?php echo $row_getRecord['max_users']; ?>">
              </label>
            </section>
          </div>
        <input type="hidden" name="formID" value="create-IkioskcloudLicenses">
        <input type="hidden" name="iKioskForm" value="Yes">
        <input type="hidden" name="appCode" value="<?php echo $APPLICATION['application_code']; ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel </button>
          <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="create-IkioskcloudLicenses"> <i class="fa fa-check"></i> Save </button>
        </div>
      </form>
    </div>
  </div>
  </div>
  
  <!-- End Create Record --> 
  <!-- Start List View -->
  <div id="listCtn-IkioskcloudLicenses" class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="system-message"></div>
      <div class="jarviswidget" id="list-IkioskcloudLicenses" data-widget-editbutton="false" data-widget-deletebutton="false">
        <header> <span class="widget-icon"> <i class="fa fa-table"></i> </span>
          <h2>Software Licenses</h2>
        </header>
        <div>
          <div class="jarviswidget-editbox">
            <input class="form-control" type="text">
          </div>
          <div class="widget-body no-padding">
            <table id="dt-IkioskcloudLicenses" class="table table-striped table-bordered table-hover" width="100%">
              <thead>
                <tr>
                  <th>Site Name</th>
                  <th>Site Url</th>
                  <th>License Type</th>
                  <th>Expiration Date</th>
                  <th>Max Users</th>
                  <th>Max Sites</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php do { ?>
                  <tr class="<?php echo $row_listView['cloud_id']; ?>">
                    <td><a href="index.php?action=edit&recordID=<?php echo $row_listView['cloud_id']; ?>#webapps/ikioskmcp/licenses.php" class="ajaxLink"><?php echo $row_listView['site_name']; ?></a></td>
                    <td><?php echo $row_listView['site_url']; ?></td>
                    <td><?php echo $row_listView['license_type']; ?></td>
                    <td><?php timezoneProcess($row_listView['expiration_date'], "print");  ?></td>
                    <td><?php echo $row_listView['max_users']; ?></td>
                    <td><?php echo $row_listView['max_sites']; ?></td>
                    <td class="icon"><a class="delete-record" data-table="ikioskcloud_licenses" data-record="<?php echo $row_listView['cloud_id']; ?>" data-code="<?php echo $APPLICATION['application_code']; ?>" data-field="cloud_id"><i class="fa fa-trash-o"></i></a></td>
                  </tr>
                  <?php } while ($row_listView = mysql_fetch_assoc($listView)); ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </article>
  </div>
  <!--  End List View --> 
</section>
<script type="text/javascript">
   var listView = $('#dt-IkioskcloudLicenses').dataTable();
   $('.dataTables_length').before('<button class="btn btn-primary btn-toggle btn-add"   data-toggle="modal" data-target="#createCtn-IkioskcloudLicenses"><i class="fa fa-plus"></i> New <span class="hidden-mobile">Software Licenses</span></button>');
</script> 
<script type="text/javascript">
   runAllForms();
   
   $(function() {
       // Validation
       $("#create-IkioskcloudLicenses").validate({
       
           rules : {
                		ikiosk_id : {
			required : true
		},
		expiration_date : {
			required : true
		},
		max_users : {
			required : true,
			number: true
		},
		max_sites : {
			required : true,
			number: true
		},
		site_name : {
			required: true	
		}

            },
           
           // Do not change code below
           errorPlacement : function(error, element) {
               error.insertAfter(element.parent());
           },
           //Handler
           submitHandler: function(form) {
               var targetForm = $(this.currentForm).attr("id");
               submitAjaxForm(targetForm);
           }
       });
   });
</script>
<?php } ?>
<?php 
   if ($panelAction == "edit") { // Edit View 
   
   //Get Current Record
   mysql_select_db($database_ikiosk, $ikiosk);
   $query_getRecord = "SELECT * FROM ikioskcloud_licenses WHERE deleted = '0' AND cloud_id = '".$_GET['recordID']."' ";
   $getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
   $row_getRecord = mysql_fetch_assoc($getRecord);
   $totalRows_getRecord = mysql_num_rows($getRecord);
   
   ?>
<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title"><?php echo $row_getRecord['site_name']; ?> </h1>
  </div>
</div>
<section id="widget-grid">
  <div class="row">
    <article class="col-sm-12 col-md-6 col-lg-6">
      <div class="jarviswidget" id="editCtn-IkioskcloudLicenses" data-widget-editbutton="false" data-widget-deletebutton="false">
        <header> <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
          <h2>Edit Software Licens</h2>
        </header>
        <div>
          <div class="jarviswidget-editbox"> 
            <!-- This area used as dropdown edit box -->
            <input class="form-control" type="text">
          </div>
          <div class="widget-body no-padding">
            <form id= "edit-IkioskcloudLicenses" class="smart-form" method="post">
              <fieldset>
                <div class="form-response"></div>
                <div class="row">
                  <section class="col col-6">
                    <label class="label">Site Name</label>
                    <label class="input">
                      <input type="text" name="site_name" value="<?php echo $row_getRecord['site_name']; ?>">
                    </label>
                  </section>
                  <section class="col col-6">
                    <label class="label">Site URL</label>
                    <label class="input">
                      <input type="text" name="site_url" value="<?php echo $row_getRecord['site_url']; ?>">
                    </label>
                  </section>
                </div>
                <div class="row">
                  <section class="col col-6">
                    <label class="label">iKiosk ID</label>
                    <label class="input">
                      <input type="text" name="ikiosk_id" value="<?php echo $row_getRecord['ikiosk_id']; ?>">
                    </label>
                  </section>
                  <section class="col col-6">
                    <label class="label">License Key</label>
                    <label class="input state-disabled">
                      <input type="text" name="ikiosk_license_key" value="<?php echo $row_getRecord['ikiosk_license_key']; ?>" disabled>
                    </label>
                  </section>
                </div>
                <div class="row">
                  <section class="col col-6">
                    <label class="label">License Type</label>
                    <label class="select">
                      <select name="license_type">
                        <option value="Basic" <?php if (!(strcmp("Basic", $row_getRecord['license_type']))) {echo "selected=\"selected\"";} ?>>Basic</option>
                        <option value="Premium" <?php if (!(strcmp("Premium", $row_getRecord['license_type']))) {echo "selected=\"selected\"";} ?>>Premium</option>
                        <option value="Professional" <?php if (!(strcmp("Professional", $row_getRecord['license_type']))) {echo "selected=\"selected\"";} ?>>Professional</option>
                        <option value="Affiliate" <?php if (!(strcmp("Affiliate", $row_getRecord['license_type']))) {echo "selected=\"selected\"";} ?>>Affiliate</option>
                        <option value="Reseller" <?php if (!(strcmp("Reseller", $row_getRecord['license_type']))) {echo "selected=\"selected\"";} ?>>Reseller</option>
                        <option value="CMS Cloud" <?php if (!(strcmp("CMS Cloud", $row_getRecord['license_type']))) {echo "selected=\"selected\"";} ?>>CMS Cloud</option>
                        <option value="OEM" <?php if (!(strcmp("OEM", $row_getRecord['license_type']))) {echo "selected=\"selected\"";} ?>>OEM</option>
                      </select>
                      <i></i> </label>
                  </section>
                  <section class="col col-6">
                    <label class="label">Expiration Date</label>
                    <div class="input-group">
                      <input name="expiration_date" type="text" class="form-control datepicker" data-dateformat="mm/dd/yy" value="<?php timezoneProcessDate($row_getRecord['expiration_date'], "print"); ?>">
                      <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
                  </section>
                </div>
                <div class="row">
                  <section class="col col-6">
                    <label class="label">Max Sites</label>
                    <label class="input">
                      <input type="text" name="max_sites" value="<?php echo $row_getRecord['max_sites']; ?>">
                    </label>
                  </section>
                  <section class="col col-6">
                    <label class="label">Max Users</label>
                    <label class="input">
                      <input type="text" name="max_users" value="<?php echo $row_getRecord['max_users']; ?>">
                    </label>
                  </section>
                </div>
                <div class="row">
                  <section class="col col-6">
                    <label class="label">Status</label>
                    <label class="select">
                      <select name="status">
                        <option value="Active" <?php if (!(strcmp("Active", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Active</option>
                        <option value="Inactive" <?php if (!(strcmp("Inactive", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Inactive</option>
                      </select>
                      <i></i> </label>
                  </section>
                </div>
              </fieldset>
              <footer>
                <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="edit-IkioskcloudLicenses"> <i class="fa fa-check"></i> Save </button>
                <button type="button" class="btn btn-default ajaxLink" href="index.php#webapps/ikioskmcp/licenses.php"><i class="fa fa-times"></i> Cancel </button>
                <input type="hidden" name="cloud_id" value="<?php echo $row_getRecord['cloud_id']; ?>" />
                <input type="hidden" name="formID" value="edit-IkioskcloudLicenses">
                <input type="hidden" name="iKioskForm" value="Yes" />
                <input type="hidden" name="appCode" value="<?php echo $APPLICATION['application_code']; ?>" />
              </footer>
            </form>
          </div>
        </div>
      </div>
    </article>
  </div>
</section>
<script type="text/javascript">
   runAllForms();
   
   $(function() {
       // Validation
       $("#edit-IkioskcloudLicenses").validate({
            rules : {
                		ikiosk_id : {
			required : true
		},
		expiration_date : {
			required : true
		},
		max_users : {
			required : true,
			number: true
		},
		max_sites : {
			required : true,
			number: true
		},
		site_name : {
			required: true	
		}

            },
           
           // Do not change code below
           errorPlacement : function(error, element) {
               error.insertAfter(element.parent());
           },
           //Handler
           submitHandler: function(form) {
               var targetForm = $(this.currentForm).attr("id");
               submitAjaxForm(targetForm);
           }
       });
   });
</script>
<?php } ?>
<script type="text/javascript">
   pageSetUp();
</script>
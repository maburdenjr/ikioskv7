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
   $query_listView = "SELECT * FROM ikioskcloud_software WHERE deleted = '0' ";
   $listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
   $row_listView = mysql_fetch_assoc($listView);
   $totalRows_listView = mysql_num_rows($listView);
   ?>

<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title">Software Packages</h1>
  </div>
  
</div>
<section id="widget-grid">
<!-- Begin Create Record -->
<div class="modal fade" id="createCtn-IkioskcloudSoftware">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id = "create-IkioskcloudSoftware" class="smart-form" method="post">
        <div class="modal-header">
          <h4 class="modal-title">Create Software Package</h4>
        </div>
        <div class="modal-body">
          <div class="form-response"></div>
          <div class="row">
            <section class="col col-9">
              <label class="label">Title</label>
              <label class="input">
                <input type="text" name="software_title" value="<?php echo $row_getRecord['software_title']; ?>">
              </label>
            </section>
            <section class="col col-3">
              <label class="label">Version</label>
              <label class="input">
                <input type="text" name="version" value="<?php echo $row_getRecord['version']; ?>">
              </label>
            </section>
          </div>
          <div class="row">
            <section class="col col-6">
              <label class="label">App Code</label>
              <label class="input">
                <input type="text" name="app_code" value="<?php echo $row_getRecord['app_code']; ?>">
              </label>
            </section>
            <section class="col col-6">
              <label class="label">Software Type</label>
              <label class="select">
                <select name="software_type">
                  <option value="Full Version">Full Version</option>
                  <option value="Patch">Patch</option>
                  <option value="Upgrade">Upgrade</option>
                </select>
                <i></i> </label>
            </section>
          </div>
          <div class="row">
            <section class="col col-6">
              <label class="label">Software Scope</label>
              <label class="select">
                <select name="software_scope">
                  <option value="System">System</option>
                  <option value="Site">Site</option>
                </select>
                <i></i> </label>
            </section>
            <section class="col col-6">
              <label class="label">Status</label>
              <label class="select">
                <select name="status">
                  <option value="Active">Active</option>
                  <option value="Inactive">Inactive</option>
                  <option value="Pending">Pending</option>
                </select>
                <i></i> </label>
            </section>
          </div>
          <div class="row">
            <section class="col col-12">
              <label class="label">Local Folder</label>
              <div class="note">This should be a unique folder name. All package files will be stored in this folder relative to '<?php echo $SYSTEM['ikiosk_filesystem_root']; ?>/system/software_apps'. Do not include the trailing slash.</div>
              <label class="input">
                <input type="text" name="local_folder" value="<?php echo $row_getRecord['local_folder']; ?>">
              </label>
            </section>
          </div>
          <div class="row">
            <section class="col col-12">
              <label class="label">Folder Map</label>
              <div class="note">If this package required the creation of file folders that are not in the base IntelliKiosk installation, list them here. Each folder name should be relative to the IntelliKiosk filesystem root. Do not include the trailing slash. Separate folder names by the [iKiosk] delimiter.</div>
              <label class="textarea">
                <textarea rows="3" class="custom-scroll" name="folder_map"><?php echo $row_getRecord['folder_map']; ?></textarea>
              </label>
            </section>
          </div>
          <div class="row">
            <section class="col col-12">
              <label class="label">Description</label>
              <label class="textarea">
                <textarea rows="3" class="custom-scroll" name="description"><?php echo $row_getRecord['description']; ?></textarea>
              </label>
            </section>
          </div>
          <input type="hidden" name="formID" value="create-IkioskcloudSoftware">
          <input type="hidden" name="iKioskForm" value="Yes">
          <input type="hidden" name="appCode" value="<?php echo $APPLICATION['application_code']; ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel </button>
          <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="create-IkioskcloudSoftware"> <i class="fa fa-check"></i> Save </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- End Create Record --> 
<!-- Start List View -->
<div id="listCtn-IkioskcloudSoftware" class="row">
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="system-message"></div>
  <div class="jarviswidget" id="list-IkioskcloudSoftware" data-widget-editbutton="false" data-widget-deletebutton="false">
    <header> <span class="widget-icon"> <i class="fa fa-table"></i> </span>
      <h2>Software Packages</h2>
    </header>
    <div>
      <div class="jarviswidget-editbox">
        <input class="form-control" type="text">
      </div>
      <div class="widget-body no-padding">
        <table id="dt-IkioskcloudSoftware" class="table table-striped table-bordered table-hover" width="100%">
          <thead>
            <tr>
              <th>Software Title</th>
              <th>Version</th>
              <th>Build</th>
              <th>App Code</th>
              <th>Type</th>
              <th>Software Folder</th>
              <th>Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php do { ?>
              <tr class="<?php echo $row_listView['software_id']; ?>">
                <td><a href="index.php?action=edit&recordID=<?php echo $row_listView['software_id']; ?>#webapps/ikioskmcp/softwarePackages.php" class="ajaxLink"><?php echo $row_listView['software_title']; ?></a></td>
                <td><?php echo $row_listView['version']; ?></td>
                <td><?php echo $row_listView['build']; ?></td>
                <td><?php echo $row_listView['app_code']; ?></td>
                <td><?php echo $row_listView['software_type']; ?></td>
                <td><?php echo $row_listView['local_folder']; ?></td>
                <td><?php echo $row_listView['status']; ?></td>
                <td class="icon"><a class="delete-record" data-table="ikioskcloud_software" data-record="<?php echo $row_listView['software_id']; ?>" data-code="<?php echo $APPLICATION['application_code']; ?>" data-field="software_id"><i class="fa fa-trash-o"></i></a></td>
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
   var listView = $('#dt-IkioskcloudSoftware').dataTable();
   $('.dataTables_length').before('<button class="btn btn-primary btn-toggle btn-add"   data-toggle="modal" data-target="#createCtn-IkioskcloudSoftware"><i class="fa fa-plus"></i> New <span class="hidden-mobile">Software Package</span></button>');
</script> 
<script type="text/javascript">
   runAllForms();
   
   $(function() {
       // Validation
       $("#create-IkioskcloudSoftware").validate({
       
           rules : {
                		software_title : {
			required : true
		},
		version : {
			required : true,
			number: true
		},
		app_code : {
			required : true,
			rangelength: [3, 5]
		},
		local_folder : {
			required : true
		},

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
   $query_getRecord = "SELECT * FROM ikioskcloud_software WHERE deleted = '0' AND software_id = '".$_GET['recordID']."' ";
   $getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
   $row_getRecord = mysql_fetch_assoc($getRecord);
   $totalRows_getRecord = mysql_num_rows($getRecord);
   
   ?>
<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title"><?php echo $row_getRecord['software_title']; ?></h1>
  </div>
  <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8 header-actions">
    <a class="btn btn-primary icon-action" data-code="IKMCP" data-type="buildPackage" data-record="<?php echo $row_getRecord['software_id']; ?>"><i class="fa fa-cog"></i> Build Package</a>
  </div>
</div>
  <div class="system-message"></div>

<section id="widget-grid">
  <div class="row">
    <article class="col-sm-12 col-md-6 col-lg-6">
      <div class="jarviswidget" id="editCtn-IkioskcloudSoftware" data-widget-editbutton="false" data-widget-deletebutton="false">
        <header> <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
          <h2>Edit Software Package</h2>
        </header>
        <div>
          <div class="jarviswidget-editbox"> 
            <!-- This area used as dropdown edit box -->
            <input class="form-control" type="text">
          </div>
          <div class="widget-body no-padding">
            <form id= "edit-IkioskcloudSoftware" class="smart-form" method="post">
              <fieldset>
                <div class="form-response"></div>
                <div class="row">
                  <section class="col col-6">
                    <label class="label">Software Title</label>
                    <label class="input">
                      <input type="text" name="software_title" value="<?php echo $row_getRecord['software_title']; ?>">
                    </label>
                  </section>
                  <section class="col col-3">
                    <label class="label">Version</label>
                    <label class="input">
                      <input type="text" name="version" value="<?php echo $row_getRecord['version']; ?>">
                    </label>
                  </section>
                  <section class="col col-3">
                    <label class="label">App Code</label>
                    <label class="input">
                      <input type="text" name="app_code" value="<?php echo $row_getRecord['app_code']; ?>">
                    </label>
                  </section>
                </div>
                <div class="row">
                  <section class="col col-4">
                    <label class="label">Software Type</label>
                    <label class="select">
                      <select name="software_type">
                        <option value="Full Version" <?php if (!(strcmp("Full Version", $row_getRecord['software_type']))) {echo "selected=\"selected\"";} ?>>Full Version</option>
                        <option value="Patch" <?php if (!(strcmp("Patch", $row_getRecord['software_type']))) {echo "selected=\"selected\"";} ?>>Patch</option>
                        <option value="Upgrade" <?php if (!(strcmp("Upgrade", $row_getRecord['software_type']))) {echo "selected=\"selected\"";} ?>>Upgrade</option>
                      </select>
                      <i></i> </label>
                  </section>
                  <section class="col col-4">
                    <label class="label">Software Scope</label>
                    <label class="select">
                      <select name="software_scope">
                        <option value="System" <?php if (!(strcmp("System", $row_getRecord['software_scope']))) {echo "selected=\"selected\"";} ?>>System</option>
                        <option value="Site" <?php if (!(strcmp("Site", $row_getRecord['software_scope']))) {echo "selected=\"selected\"";} ?>>Site</option>
                      </select>
                      <i></i> </label>
                  </section>
                  <section class="col col-4">
                    <label class="label">Status</label>
                    <label class="select">
                      <select name="status">
                        <option value="Active" <?php if (!(strcmp("Active", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Active</option>
                        <option value="Inactive" <?php if (!(strcmp("Inactive", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Inactive</option>
                        <option value="Pending" <?php if (!(strcmp("Pending", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Pending</option>
                      </select>
                      <i></i> </label>
                  </section>
                </div>
                <div class="row">
                  <section class="col col-12">
                    <label class="label">Local Folder</label>
                    <div class="note">This should be a unique folder name. All package files will be stored in this folder relative to '<?php echo $SYSTEM['ikiosk_filesystem_root']; ?>/system/software_apps'. Do not include the trailing slash.</div>
                    <label class="input">
                      <input type="text" name="local_folder" value="<?php echo $row_getRecord['local_folder']; ?>">
                    </label>
                  </section>
                </div>
                <div class="row">
                  <section class="col col-12">
                    <label class="label">Folder Map</label>
                    <div class="note">If this package required the creation of file folders that are not in the base IntelliKiosk installation, list them here. Each folder name should be relative to the IntelliKiosk filesystem root. Do not include the trailing slash. Separate folder names by the [iKiosk] delimiter.</div>
                    <label class="textarea">
                      <textarea rows="3" class="custom-scroll" name="folder_map"><?php echo $row_getRecord['folder_map']; ?></textarea>
                    </label>
                  </section>
                </div>
                <div class="row">
                  <section class="col col-12">
                    <label class="label">Description</label>
                    <label class="textarea">
                      <textarea rows="3" class="custom-scroll" name="description"><?php echo $row_getRecord['description']; ?></textarea>
                    </label>
                  </section>
                </div>
              </fieldset>
              <footer>
                <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="edit-IkioskcloudSoftware"> <i class="fa fa-check"></i> Save </button>
                <button type="button" class="btn btn-default ajaxLink" href="index.php#webapps/ikioskmcp/softwarePackages.php"><i class="fa fa-times"></i> Cancel </button>
                <input type="hidden" name="software_id" value="<?php echo $row_getRecord['software_id']; ?>" />
                <input type="hidden" name="formID" value="edit-IkioskcloudSoftware">
                <input type="hidden" name="iKioskForm" value="Yes" />
                <input type="hidden" name="appCode" value="<?php echo $APPLICATION['application_code']; ?>" />
              </footer>
            </form>
          </div>
        </div>
      </div>
    </article>
    
    <!-- File Management -->
    <article class="col-sm-12 col-md-6 col-lg-6">
      <div class="jarviswidget" id="editCtn-IkioskcloudSoftware-addFolder" data-widget-editbutton="false" data-widget-deletebutton="false">
        <header> <span class="widget-icon"> <i class="fa fa-folder"></i> </span>
          <h2>Add Folder to Package</h2>
        </header>
        <div>
          <div class="jarviswidget-editbox"> 
            <!-- This area used as dropdown edit box -->
            <input class="form-control" type="text">
          </div>
          <div class="widget-body no-padding">
            <form id= "edit-IkioskcloudSoftware-AddFolder" class="smart-form" method="post">
              <fieldset>
                <div class="form-response"></div>
                <section>
                  <label class="label">Select Folder</label>
                  <div class="note">This is a recursive function. All subdirectories and files will be added to the package.</div>
                  <label class="select">
                    <select name="ikiosk_folder">
                      <?php
									 $dirList = directoryToArray($SYSTEM['ikiosk_filesystem_root'], $recursive);
									 foreach ($dirList as $k => $v) { 
										$displayDir = str_replace($SYSTEM['ikiosk_filesystem_root'], "", $v);
										$displayDir = str_replace("//", "/", $displayDir); 
										$pos = strpos($displayDir, "smartui/js/plugin");
										if ($pos === false) {
										?>
                      <option value="<?php echo $v; ?>"><?php echo $displayDir; ?></option>
                      <?php } } ?>
                    </select>
                    <i></i> </label>
                </section>
              </fieldset>
              <footer>
                <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="edit-IkioskcloudSoftware-AddFolder"> <i class="fa fa-plus"></i> Add </button>
                <input type="hidden" name="software_id" value="<?php echo $row_getRecord['software_id']; ?>" />
                <input type="hidden" name="formID" value="edit-IkioskcloudSoftware-AddFolder">
                <input type="hidden" name="iKioskForm" value="Yes" />
                <input type="hidden" name="appCode" value="<?php echo $APPLICATION['application_code']; ?>" />
              </footer>
            </form>
          </div>
        </div>
      </div>
    </article>
    
    <!-- File Package Management -->
    <article class="col-sm-12 col-md-6 col-lg-6">
      <div class="jarviswidget" id="editCtn-IkioskcloudSoftware-manageFiles" data-widget-editbutton="false" data-widget-deletebutton="false"  data-widget-togglebutton="false"  data-widget-fullscreenbutton="false" data-widget-load="includes/core/formProcessor.php?ajaxAction=managePackageFiles&appCode=IKMCP&recordID=<?php echo $row_getRecord['software_id']; ?>">
        <header> <span class="widget-icon"> <i class="fa fa-folder"></i> </span>
          <h2>Manage Package Files</h2>
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
  <div class="row">
    <article class="col-sm-12 col-md-6 col-lg-12">
      <div class="jarviswidget" id="editCtn-IkioskcloudSoftware-fileBrowser" data-widget-editbutton="false" data-widget-deletebutton="false"  data-widget-togglebutton="false"  data-widget-fullscreenbutton="false" data-widget-load="includes/core/formProcessor.php?ajaxAction=softwareFileBrowser&appCode=IKMCP&recordID=<?php echo $row_getRecord['software_id']; ?>">
        <header> <span class="widget-icon"> <i class="fa fa-folder"></i> </span>
          <h2>Add Files to Package</h2>
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
   runAllForms();
   
   $(function() {
       // Validation
       $("#edit-IkioskcloudSoftware").validate({
            rules : {
                		software_title : {
			required : true
		},
		version : {
			required : true,
			number: true
		},
		app_code : {
			required : true,
			rangelength: [2, 5]
		},
		local_folder : {
			required : true
		},

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
			 
			 $("#edit-IkioskcloudSoftware-AddFolder").validate({           
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
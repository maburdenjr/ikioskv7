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
   $query_listView = "SELECT * FROM ikioskcloud_sites WHERE deleted = '0' ";
   $listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
   $row_listView = mysql_fetch_assoc($listView);
   $totalRows_listView = mysql_num_rows($listView);
	 
	 //Set Defaults
	$fileSystemRoot = $_SERVER['DOCUMENT_ROOT'];
	$fileSystemRoot = str_replace("apps/intellikiosk/v7/ikioskv7", "sites", $fileSystemRoot);
	$systemRoot = "/ikiosk";
   ?>

<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title"><i class="fa fa-sitemap fa-fw "></i> iKioskCloud Sites</h1>
  </div>
</div>
<section id="widget-grid">
<!-- Begin Create Record -->
<div class="modal fade" id="createCtn-IkioskcloudSites">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id = "create-IkioskcloudSites" class="smart-form" method="post">
        <div class="modal-header">
          <h4 class="modal-title">Create iKioskCloud Site</h4>
        </div>
          <div class="form-response"></div>
          <ul id="createCloudSite-tabs" class="nav nav-tabs">
            <li class="active"> <a data-toggle="tab" href="#system">System</a> </li>
            <li> <a data-toggle="tab" href="#database">Database</a> </li>
            <li> <a data-toggle="tab" href="#license">License</a> </li>
            <li> <a data-toggle="tab" href="#site">Default Site</a> </li>
          </ul>
          <div class="tab-content padding-10">
            <div class="tab-pane fade in active" id="system">
              <section>
                <label class="label">System Name</label>
                <label class="input">
                  <input type="text" name="system_name" value="<?php echo $row_getRecord['system_name']; ?>">
                </label>
              </section>
              <section>
                <label class="label">System URL</label>
                <div class="note">The base url of the IntelliKiosk installation. Do not include the trailing slash.</div>
                <label class="input">
                  <input type="text" name="system_url">
                </label>
              </section>
              <section>
                <label class="label">iKioskCloud Local Folder</label>
                <div class="note">This folder will be created relative to '/sites' on the iKioskCloud server. Do not include any slashes.</div>
                <label class="input">
                  <input type="text" name="ikiosk_cloud_root" value="<?php echo $row_getRecord['ikiosk_cloud_root']; ?>">
                </label>
              </section>
              <section>
                <label class="label">FileSystem Root</label>
                <div class="note">The FileSystem Root is the physical location of the IntelliKiosk installation on the file server. It has been auto-populated based on the server configuration. Do not include the trailing slash.</div>
                <label class="input">
                  <input type="text" name="ikiosk_filesystem_root" value="<?php echo $fileSystemRoot; ?>">
                </label>
              </section>
              <section>
                <label class="label">iKiosk System Root</label>
                <div class="note">The iKiosk system root is the location of the IntelliKiosk installation relative to the FileSystem Root. This should typically be '/ikiosk'. Do not include the trailing slash.</div>
                <label class="input">
                  <input type="text" name="ikiosk_root" value="<?php echo $systemRoot; ?>">
                </label>
              </section>
            </div>
            <div class="tab-pane fade in" id="database">
              <section>
                <label class="label">Database Server</label>
                <label class="input">
                  <input type="text" name="db_host" value="<?php echo $row_getRecord['db_host']; ?>">
                </label>
              </section>
              <section>
                <label class="label">Database Name</label>
                <div class="note">This database should already exist on this server. If it doesn't exist, please create it first and then proceed with the installation process.</div>
                <label class="input">
                  <input type="text" name="db_name" value="<?php echo $row_getRecord['db_name']; ?>">
                </label>
              </section>
              <section>
                <label class="label">Database User</label>
                <label class="input">
                  <input type="text" name="db_user" value="<?php echo $row_getRecord['db_user']; ?>">
                </label>
              </section>
              <section>
                <label class="label">Database Password</label>
                <label class="input">
                  <input type="text" name="db_password" value="<?php echo $row_getRecord['db_password']; ?>">
                </label>
              </section>
            </div>
            <div class="tab-pane fade in" id="license">
              <section>
                <label class="label">License Type</label>
                <label class="select">
                  <select name="license_type">
                    <option value="Basic">Basic</option>
                    <option value="Premium">Premium</option>
                    <option value="Professional">Professional</option>
                    <option value="Reseller">Reseller</option>
                  </select>
                  <i></i> </label>
              </section>
              <section>
                <label class="label">Expiration Date</label>
                <div class="input-group">
                  <input name="expiration_date" type="text" class="form-control datepicker" data-dateformat="mm/dd/yy">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span> </div>
              </section>
              <section>
                <label class="label">Max Users</label>
                <label class="input">
                  <input name="max_users" type="text">
                </label>
              </section>
              <section>
                <label class="label">Max Sites</label>
                <label class="input">
                  <input name="max_sites" type="text">
                </label>
              </section>
              <section>
                <label class="label">Status</label>
                <label class="select">
                  <select name="status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                  </select>
                  <i></i> </label>
              </section>
            </div>
            <div class="tab-pane fade in" id="site">
              <section>
                <label class="label">Site Name</label>
                <label class="input">
                  <input name="site_name" type="text">
                </label>
              </section>
              <section>
                <label class="label">Site URL</label>
                <label class="input">
                  <input name="site_url" type="text">
                </label>
              </section>
              <section>
                <label class="label">Site Shortname</label>
                <div class="note">The shortname is used to identify the site within the IntelliKiosk system.</div>
                <label class="input">
                  <input name="site_root" type="text">
                </label>
              </section>
              <section>
                <label class="label">Default Timezone</label>
                <label class="select">
                  <select name="site_timezone">
                    <?php selectTimeZone($row_getRecord['user_timezone']); ?>
                  </select>
                  <i></i> </label>
              </section>
            </div>
          </div>
          <input type="hidden" name="formID" value="create-IkioskcloudSites">
          <input type="hidden" name="iKioskForm" value="Yes">
          <input type="hidden" name="appCode" value="<?php echo $APPLICATION['application_code']; ?>">
        <div class="modal-footer no-margin">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel </button>
          <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="create-IkioskcloudSites"> <i class="fa fa-check"></i> Save </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- End Create Record --> 
<!-- Start List View -->
<div id="listCtn-IkioskcloudSites" class="row">
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="system-message"></div>
  <div class="jarviswidget" id="list-IkioskcloudSites" data-widget-editbutton="false" data-widget-deletebutton="false">
    <header> <span class="widget-icon"> <i class="fa fa-sitemap"></i> </span>
      <h2>Site List</h2>
    </header>
    <div>
      <div class="jarviswidget-editbox">
        <input class="form-control" type="text">
      </div>
      <div class="widget-body no-padding">
        <table id="dt-IkioskcloudSites" class="table table-striped table-bordered table-hover" width="100%">
          <thead>
            <tr>
              <th>Site</th>
              <th>Local Folder</th>
              <th>DB Host</th>
              <th>DB Name</th>
              <th>DB User</th>
              <th>DB Password</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php do { ?>
              <tr class="<?php echo $row_listView['site_id']; ?>">
                <td><a href="webapps/ikioskmcp/cloudSites.php?action=edit&recordID=<?php echo $row_listView['site_id']; ?>" class="dynamicModal" data-toggle="modal" data-target="#dynamicModal"><?php echo $row_listView['system_name']; ?></a></td>
                <td><?php echo $row_listView['local_folder']; ?></td>
                <td><?php echo $row_listView['db_host']; ?></td>
                <td><?php echo $row_listView['db_name']; ?></td>
                <td><?php echo $row_listView['db_user']; ?></td>
                <td><?php echo $row_listView['db_password']; ?></td>
                <td class="icon"><a class="delete-record" data-table="ikioskcloud_sites" data-record="<?php echo $row_listView['site_id']; ?>" data-code="<?php echo $APPLICATION['application_code']; ?>" data-field="site_id"><i class="fa fa-trash-o"></i></a></td>
              </tr>
              <?php } while ($row_listView = mysql_fetch_assoc($listView)); ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</article>
<div>
<!--  End List View -->
</section>
<script type="text/javascript">
   var listView = $('#dt-IkioskcloudSites').dataTable();
   $('.dataTables_length').before('<button class="btn btn-primary btn-toggle btn-add"   data-toggle="modal" data-target="#createCtn-IkioskcloudSites"><i class="fa fa-plus"></i> New <span class="hidden-mobile"> Site</span></button>');
</script> 
<script type="text/javascript">
   runAllForms();
   
   $(function() {
       // Validation
       $("#create-IkioskcloudSites").validate({
       
           rules : {
                		system_name : {
			required : true
		},
		ikiosk_cloud_root : {
			required : true
		},
		system_url : {
			required : true,
			url : true
		},
		local_folder : {
			required : true
		},
		ikiosk_filesystem_root : {
			required : true
		},
		ikiosk_root : {
			required : true
		},
		db_host : {
			required : true
		},
		db_name : {
			required : true
		},
		db_user : {
			required : true
		},
		db_password : {
			required : true
		},
		max_users : {
			required : true,
			number : true
		},
		max_sites : {
			required : true,
			number : true
		},
		site_name : {
			required : true
		},
		site_url : {
			required : true, 
			url: true
		},
		site_root : {
			required : true
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
   $query_getRecord = "SELECT * FROM ikioskcloud_sites WHERE deleted = '0' AND site_id = '".$_GET['recordID']."' ";
   $getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
   $row_getRecord = mysql_fetch_assoc($getRecord);
   $totalRows_getRecord = mysql_num_rows($getRecord);
   
   ?>

            <form id= "edit-IkioskcloudSites" class="smart-form" method="post">
            <div class="modal-header">
    <h4 class="modal-title"><?php echo $row_getRecord['system_name']; ?></h4>
  </div>
              <ul id="editCloud-tabs" class="nav nav-tabs">
                <li class="active"> <a data-toggle="tab" href="#cloud-system">System</a> </li>
                <li> <a data-toggle="tab" href="#cloud-database">Database</a> </li>
              </ul>
              <fieldset>
                <div class="form-response"></div>
                <div class="tab-content">
                  <div class="tab-pane fade in active" id="cloud-system">
                    <div class="row">
                      <section class="col col-6">
                        <label class="label">System Name</label>
                        <label class="input">
                          <input type="text" name="system_name" value="<?php echo $row_getRecord['system_name']; ?>">
                        </label>
                      </section>
                      <section class="col col-6">
                        <label class="label">Local Folder</label>
                        <label class="input state-disabled">
                          <input type="text" name="local_folder" value="<?php echo $row_getRecord['local_folder']; ?>" disabled>
                        </label>
                      </section>
                    </div>
                    <div class="row">
                      <section class="col col-6">
                        <label class="label">iKiosk Cloud Root</label>
                        <label class="input state-disabled">
                          <input type="text" name="ikiosk_cloud_root" value="<?php echo $row_getRecord['ikiosk_cloud_root']; ?>" disabled>
                        </label>
                      </section>
                      <section class="col col-6">
                        <label class="label">iKiosk FileSystem Root</label>
                        <label class="input state-disabled">
                          <input type="text" name="ikiosk_filesystem_root" value="<?php echo $row_getRecord['ikiosk_filesystem_root']; ?>" disabled>
                        </label>
                      </section>
                    </div>
                  </div>
                  <div class="tab-pane fade in" id="cloud-database">
                    <div class="row">
                      <section class="col col-6">
                        <label class="label">Database Host</label>
                        <label class="input">
                          <input type="text" name="db_host" value="<?php echo $row_getRecord['db_host']; ?>" >
                        </label>
                      </section>
                      <section class="col col-6">
                        <label class="label ">Database Name</label>
                        <label class="input">
                          <input type="text" name="db_name" value="<?php echo $row_getRecord['db_name']; ?>" >
                        </label>
                      </section>
                    </div>
                    <div class="row">
                      <section class="col col-6">
                        <label class="label">Database User</label>
                        <label class="input">
                          <input type="text" name="db_user" value="<?php echo $row_getRecord['db_user']; ?>" >
                        </label>
                      </section>
                      <section class="col col-6">
                        <label class="label">Database Password</label>
                        <label class="input">
                          <input type="text" name="db_password" value="<?php echo $row_getRecord['db_password']; ?>" >
                        </label>
                      </section>
                    </div>
                  </div>
                </div>
              </fieldset>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel </button>

                <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="edit-IkioskcloudSites"> <i class="fa fa-check"></i> Save </button>
                <input type="hidden" name="site_id" value="<?php echo $row_getRecord['site_id']; ?>" />
                <input type="hidden" name="formID" value="edit-IkioskcloudSites">
                <input type="hidden" name="iKioskForm" value="Yes" />
                <input type="hidden" name="appCode" value="<?php echo $APPLICATION['application_code']; ?>" />
              </div>
            </form>

<script type="text/javascript">
   runAllForms();
   
   $(function() {
       // Validation
       $("#edit-IkioskcloudSites").validate({
            rules : {
                		system_name : {
			required : true
		},
		db_host : {
			required : true
		},
		db_name : {
			required : true
		},
		db_user : {
			required : true
		},
		db_password : {
			required : true
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
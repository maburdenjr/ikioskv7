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
           $panelAction = "edit";
   }
	 
	 getLicense();
   
   if ($panelAction == "edit") { // Edit View 
   
   //Get Current Record
   mysql_select_db($database_ikiosk, $ikiosk);
   $query_getRecord = "SELECT * FROM sys_config";
   $getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
   $row_getRecord = mysql_fetch_assoc($getRecord);
   $totalRows_getRecord = mysql_num_rows($getRecord);
   
   ?>

<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title">System Configuration</h1>
  </div>
</div>
<section id="widget-grid">
  <div class="row">
    <article class="col-sm-12 col-md-12 col-lg-12">
      <div class="jarviswidget" id="editCtn-SysConfig" data-widget-editbutton="false" data-widget-deletebutton="false">
        <header> <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
          <h2>Edit</h2>
        </header>
        <div>
          <div class="jarviswidget-editbox"> 
            <!-- This area used as dropdown edit box -->
            <input class="form-control" type="text">
          </div>
          <div class="widget-body no-padding">
            <form id= "edit-SysConfig" class="smart-form" method="post">
              <ul id="editSite-tabs" class="nav nav-tabs">
                <li class="active"> <a data-toggle="tab" href="#site"> Site Properties</a> </li>
                <li> <a data-toggle="tab" href="#license"> License Information </a> </li>
                <li> <a data-toggle="tab" href="#advanced">Advanced</a> </li>
              </ul>
              <fieldset>
                    <div class="form-response"></div>
              <div class="tab-content">
                <div class="tab-pane fade in active" id="site">
                  
                    <div class="row">
                      <section class="col col-4">
                        <label class="label">System Name</label>
                        <label class="input">
                          <input type="text" name="system_name" value="<?php echo $row_getRecord['system_name']; ?>">
                        </label>
                      </section>
                      <section class="col col-4">
                        <label class="label">System URL</label>
                        <label class="input">
                          <input type="text" name="system_url" value="<?php echo $row_getRecord['system_url']; ?>">
                        </label>
                      </section>
                      <section class="col col-4">
                        <label class="label">System Status</label>
                        <label class="select">
                          <select name="sys_message_status">
                            <option value="Active" <?php if (!(strcmp("Active", $row_getRecord['sys_message_status']))) {echo "selected=\"selected\"";} ?>>Active</option>
                            <option value="Inactive" <?php if (!(strcmp("Inactive", $row_getRecord['sys_message_status']))) {echo "selected=\"selected\"";} ?>>Inactive</option>
                          </select>
                          <i></i> </label>
                      </section>
                    </div>
                    <div class="row">
                      <section class="col col-4">
                        <label class="label">iKiosk ID</label>
                        <label class="input state-disabled">
                          <input type="text" name="ikiosk_id" value="<?php echo $row_getRecord['ikiosk_id']; ?>" disabled="disabled">
                        </label>
                      </section>
                      <section class="col col-4">
                        <label class="label">Ikiosk License Key</label>
                        <label class="input">
                          <input type="text" name="ikiosk_license_key" value="<?php echo $row_getRecord['ikiosk_license_key']; ?>">
                        </label>
                      </section>
                      <section class="col col-4">
                        <label class="label">iKiosk Filesystem Root</label>
                        <label class="input">
                          <input type="text" name="ikiosk_filesystem_root" value="<?php echo $row_getRecord['ikiosk_filesystem_root']; ?>">
                        </label>
                      </section>
                    </div>
              
                </div>
                <div class="tab-pane fade in" id="license">
              
                    <div class="row">
                      <section class="col col-4">
                        <label class="label">Account Name</label>
                        <label class="input state-disabled">
                          <input type ="text" name="license-account" value="<?php echo $_SESSION['license_account']; ?>">
                        </label>
                      </section>
                      <section class="col col-4">
                        <label class="label">iKiosk URL</label>
                        <label class="input state-disabled">
                          <input type ="text" name="license-url" value="<?php echo $_SESSION['license_url']; ?>">
                        </label>
                      </section>
                      <section class="col col-4">
                        <label class="label">License Type</label>
                        <label class="input state-disabled">
                          <input type ="text" name="license-type" value="<?php echo $_SESSION['license_type']; ?>">
                        </label>
                      </section>
                    </div>
                    <div class="row">
                      <section class="col col-4">
                        <label class="label">Date Issued</label>
                        <label class="input state-disabled">
                          <input type ="text" name="license-date" value="<?php echo $_SESSION['license_issue']; ?>">
                        </label>
                      </section>
                      <section class="col col-4">
                        <label class="label">Expiration Date</label>
                        <label class="input state-disabled">
                          <input type ="text" name="license-expire" value="<?php echo $_SESSION['license_expire']; ?>">
                        </label>
                      </section>
                      <section class="col col-4">
                        <label class="label">License Status</label>
                        <label class="input state-disabled">
                          <input type ="text" name="license-staus" value="<?php echo $_SESSION['license_status']; ?>">
                        </label>
                      </section>
                    </div>
                    <div class="row">
                      <section class="col col-4">
                        <label class="label">Max Sites</label>
                        <label class="input state-disabled">
                          <input type ="text" name="license-sites" value="<?php echo $_SESSION['license_sites']; ?>">
                        </label>
                      </section>
                      <section class="col col-4">
                        <label class="label">Max Users</label>
                        <label class="input state-disabled">
                          <input type ="text" name="license-users" value="<?php echo $_SESSION['license_sites']; ?>">
                        </label>
                      </section>
                    </div>
           
                </div>
                <div class="tab-pane fade in" id="advanced">
          
                    <div class="row">
                      <section class="col col-4">
                        <label class="label">Auth User</label>
                        <label class="input state-disabled">
                          <input type ="text" name="auth_user" value="<?php echo $username_ikiosk; ?>">
                        </label>
                      </section>
                      <section class="col col-4">
                        <label class="label">Auth Key</label>
                        <label class="input state-disabled">
                          <input type ="text" name="auth_key" value="<?php echo $password_ikiosk; ?>">
                        </label>
                      </section>
                    </div>
                  
                </div>
              </div>
              </fieldset>
              <footer>
                <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="edit-SysConfig"> <i class="fa fa-check"></i> Save </button>
                <input type="hidden" name="ikiosk_id" value="<?php echo $row_getRecord['ikiosk_id']; ?>" />
                <input type="hidden" name="formID" value="edit-SysConfig">
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
       $("#edit-SysConfig").validate({
            rules : {
                		ikiosk_license_key : {
			required : true
		},
		system_name : {
			required : true
		},
		system_url : {
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
<script type="text/javascript">
   pageSetUp();
</script>
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
   
   mysql_select_db($database_ikiosk, $ikiosk);
   $query_listView = "SELECT * FROM sys_users WHERE deleted = '0' ";
   $listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
   $row_listView = mysql_fetch_assoc($listView);
   $totalRows_listView = mysql_num_rows($listView);
   ?>

<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title">User Management</h1>
  </div>
</div>
<section id="widget-grid">
<!-- Begin Create Record -->
<div class="modal fade" id="createCtn-SysUsers">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id = "create-SysUsers" class="smart-form" method="post">
        <div class="modal-header">
          <h4 class="modal-title">Create Users</h4>
        </div>
        <div class="modal-body">
          <div class="form-response"></div>
          <div class="row">
            <section class="col col-6">
              <label class="label">Login Email</label>
              <label class="input">
                <input type="text" name="login_email" value="<?php echo $row_getRecord['login_email']; ?>">
              </label>
            </section>
            <section class="col col-6">
              <label class="label">Login Password</label>
              <label class="input">
                <input type="text" name="login_password" value="<?php echo $row_getRecord['login_password']; ?>">
              </label>
            </section>
          </div>
          <div class="row">
            <section class="col col-6">
              <label class="label">Display Name</label>
              <label class="input">
                <input type="text" name="display_name" value="<?php echo $row_getRecord['display_name']; ?>">
              </label>
            </section>
            <section class="col col-6">
              <label class="label">First Name</label>
              <label class="input">
                <input type="text" name="first_name" value="<?php echo $row_getRecord['first_name']; ?>">
              </label>
            </section>
          </div>
          <div class="row">
            <section class="col col-6">
              <label class="label">Last Name</label>
              <label class="input">
                <input type="text" name="last_name" value="<?php echo $row_getRecord['last_name']; ?>">
              </label>
            </section>
            <section class="col col-6">
              <label class="label">Is Admin</label>
              <label class="select">
                <select name="is_admin">
                  <option value="value1" <?php if (!(strcmp("value1", $row_getRecord['is_admin']))) {echo "selected=\"selected\"";} ?>>value1</option>
                  <option value="value2" <?php if (!(strcmp("value2", $row_getRecord['is_admin']))) {echo "selected=\"selected\"";} ?>>value2</option>
                </select>
                <i></i> </label>
            </section>
          </div>
          <div class="row">
            <section class="col col-6">
              <label class="label">User Type</label>
              <label class="select">
                <select name="user_type">
                  <option value="value1" <?php if (!(strcmp("value1", $row_getRecord['user_type']))) {echo "selected=\"selected\"";} ?>>value1</option>
                  <option value="value2" <?php if (!(strcmp("value2", $row_getRecord['user_type']))) {echo "selected=\"selected\"";} ?>>value2</option>
                </select>
                <i></i> </label>
            </section>
            <section class="col col-6">
              <label class="label">User Timezone</label>
              <label class="input">
                <input type="text" name="user_timezone" value="<?php echo $row_getRecord['user_timezone']; ?>">
              </label>
            </section>
          </div>
          <div class="row">
            <section class="col col-6">
              <label class="label">User Dateformat</label>
              <label class="input">
                <input type="text" name="user_dateformat" value="<?php echo $row_getRecord['user_dateformat']; ?>">
              </label>
            </section>
            <section class="col col-6">
              <label class="label">User Homepage</label>
              <label class="input">
                <input type="text" name="user_homepage" value="<?php echo $row_getRecord['user_homepage']; ?>">
              </label>
            </section>
          </div>
          <div class="row">
            <section class="col col-6">
              <label class="label">Account Status</label>
              <label class="select">
                <select name="user_status">
                  <option value="Active" <?php if (!(strcmp("Active", $row_getRecord['user_status']))) {echo "selected=\"selected\"";} ?>>Active</option>
                  <option value="Inactive" <?php if (!(strcmp("Inactive", $row_getRecord['user_status']))) {echo "selected=\"selected\"";} ?>>Inactive</option>
                </select>
                <i></i> </label>
            </section>
          </div>
          <input type="hidden" name="formID" value="create-SysUsers">
          <input type="hidden" name="iKioskForm" value="Yes">
          <input type="hidden" name="appCode" value="<?php echo $APPLICATION['application_code']; ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel </button>
          <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="create-SysUsers"> <i class="fa fa-check"></i> Save </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- End Create Record --> 
<!-- Start List View -->
<div id="listCtn-SysUsers" class="row">
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="system-message"></div>
  <div class="jarviswidget" id="list-SysUsers" data-widget-editbutton="false" data-widget-deletebutton="false">
    <header> <span class="widget-icon"> <i class="fa fa-table"></i> </span>
      <h2>Users</h2>
    </header>
    <div>
      <div class="jarviswidget-editbox">
        <input class="form-control" type="text">
      </div>
      <div class="widget-body no-padding">
        <table id="dt-SysUsers" class="table table-striped table-bordered table-hover" width="100%">
          <thead>
            <tr>
              <th>Display Name</th>
              <th>Login Email</th>
              <th>Admin</th>
              <th>User Type</th>
              <th>User Status</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php do { ?>
              <tr class="<?php echo $row_listView['user_id']; ?>">
                <td><a href="index.php?action=edit&recordID=<?php echo $row_listView['user_id']; ?>#webapps/admin/users.php" class="ajaxLink"><?php echo $row_listView['display_name']; ?></a></td>
                <td><?php echo $row_listView['login_email']; ?></td>
                <td><?php echo $row_listView['is_admin']; ?></td>
                <td><?php echo $row_listView['user_type']; ?></td>
                <td><?php echo $row_listView['user_status']; ?></td>
                <td class="icon"><a class="delete-record" data-table="sys_users" data-record="<?php echo $row_listView['user_id']; ?>" data-code="<?php echo $APPLICATION['application_code']; ?>" data-field="user_id"><i class="fa fa-trash-o"></i></a></td>
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
   var listView = $('#dt-SysUsers').dataTable();
   $('.dataTables_length').before('<button class="btn btn-primary btn-toggle btn-add"   data-toggle="modal" data-target="#createCtn-SysUsers"><i class="fa fa-plus"></i> New <span class="hidden-mobile">User</span></button>');
</script> 
<script type="text/javascript">
   runAllForms();
   
   $(function() {
       // Validation
       $("#create-SysUsers").validate({
       
           rules : {
                		login_email : {
			required : true
		},
		login_password : {
			required : true
		},
		first_name : {
			required : true
		},
		last_name : {
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
   $query_getRecord = "SELECT * FROM sys_users WHERE deleted = '0' AND user_id = '".$_GET['recordID']."' ";
   $getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
   $row_getRecord = mysql_fetch_assoc($getRecord);
   $totalRows_getRecord = mysql_num_rows($getRecord);
   
   ?>
<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title"><?php echo $row_getRecord['display_name']; ?></h1>
  </div>
</div>
<section id="widget-grid">
  <div class="row">
    <article class="col-sm-12 col-md-12 col-lg-12">
      <div class="jarviswidget" id="editCtn-SysUsers" data-widget-editbutton="false" data-widget-deletebutton="false">
        <header> <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
          <h2>Edit User</h2>
        </header>
        <div>
          <div class="jarviswidget-editbox"> 
            <!-- This area used as dropdown edit box -->
            <input class="form-control" type="text">
          </div>
          <div class="widget-body no-padding">
            <form id= "edit-SysUsers" class="smart-form" method="post">
              <ul id="editUser-tabs" class="nav nav-tabs">
                <li class="active"> <a data-toggle="tab" href="#general">General</a> </li>
                <li> <a data-toggle="tab" href="#security">Security</a> </li>
                <li> <a data-toggle="tab" href="#advanced">Preferences</a> </li>
                <li> <a data-toggle="tab" href="#password">Password</a> </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane fade in active" id="general">
                  <fieldset>
                    <div class="form-response"></div>
                    <div class="row">
                      <section class="col col-6">
                        <label class="label">Login Email</label>
                        <label class="input state-disabled">
                          <input type="text" name="login_email" value="<?php echo $row_getRecord['login_email']; ?>" disabled="disabled">
                        </label>
                      </section>
                      <section class="col col-6">
                        <label class="label">Display Name</label>
                        <label class="input">
                          <input type="text" name="display_name" value="<?php echo $row_getRecord['display_name']; ?>">
                        </label>
                      </section>
                    </div>
                    <div class="row">
                      <section class="col col-6">
                        <label class="label">First Name</label>
                        <label class="input">
                          <input type="text" name="first_name" value="<?php echo $row_getRecord['first_name']; ?>">
                        </label>
                      </section>
                      <section class="col col-6">
                        <label class="label">Last Name</label>
                        <label class="input">
                          <input type="text" name="last_name" value="<?php echo $row_getRecord['last_name']; ?>">
                        </label>
                      </section>
                    </div>
                  </fieldset>
                </div>
                <div class="tab-pane fade in" id="security">
                  <fieldset>
                    <div class="row">
                      <section class="col col-6">
                        <label class="label">User Type</label>
                        <label class="select">
                          <select name="user_type">
                            <option value="Web Portal User" <?php if (!(strcmp("Web Portal User", $row_getRecord['user_type']))) {echo "selected=\"selected\"";} ?>>Web Portal User</option>
                            <option value="Standard" <?php if (!(strcmp("Standard", $row_getRecord['user_type']))) {echo "selected=\"selected\"";} ?>>Standard</option>
                            <option value="Internal" <?php if (!(strcmp("Internal", $row_getRecord['user_type']))) {echo "selected=\"selected\"";} ?>>Internal</option>
                            <option value="Administrator" <?php if (!(strcmp("Administrator", $row_getRecord['user_type']))) {echo "selected=\"selected\"";} ?>>Administrator</option>
                            <option value="Super Admin" <?php if (!(strcmp("Super Admin", $row_getRecord['user_type']))) {echo "selected=\"selected\"";} ?>>Super Admin</option>
                            <?php if ($USER['user_type'] == "iKiosk Admin") { ?>
                            <option value="iKiosk Admin" <?php if (!(strcmp("iKiosk Admin", $row_getRecord['user_type']))) {echo "selected=\"selected\"";} ?>>iKiosk Admin</option>
                            <?php } ?>
                          </select>
                          <i></i> </label>
                      </section>
                      <section class="col col-6">
                        <label class="label">Administrator?</label>
                        <label class="select">
                          <select name="is_admin">
                            <option value="Yes" <?php if (!(strcmp("Yes", $row_getRecord['is_admin']))) {echo "selected=\"selected\"";} ?>>Yes</option>
                            <option value="No" <?php if (!(strcmp("No", $row_getRecord['is_admin']))) {echo "selected=\"selected\"";} ?>>No</option>
                          </select>
                          <i></i> </label>
                      </section>
                    </div>
                    <div class="row">
                      <section class="col col-6">
                        <label class="label">User Status</label>
                        <label class="select">
                          <select name="user_status">
                            <option value="Active" <?php if (!(strcmp("Active", $row_getRecord['user_status']))) {echo "selected=\"selected\"";} ?>>Active</option>
                            <option value="Inactive" <?php if (!(strcmp("Inactive", $row_getRecord['user_status']))) {echo "selected=\"selected\"";} ?>>Inactive</option>
                          </select>
                          <i></i> </label>
                      </section>
                    </div>
                  </fieldset>
                </div>
                <div class="tab-pane fade in" id="advanced">
                  <fieldset>
                    <div class="row">
                      <section class="col col-6">
                        <label class="label">Date Format</label>
                        <label class="input">
                          <input type="text" name="user_dateformat" value="<?php echo $row_getRecord['user_dateformat']; ?>">
                        </label>
                      </section>
                      <section class="col col-6">
                        <label class="label">Timezone</label>
                        <label class="select">
                          <select name="user_timezone">
                            <?php selectTimeZone($row_getRecord['user_timezone']); ?>
                          </select>
                          <i></i> </label>
                      </section>
                    </div>
                    <div class="row">
                      <section class="col col-6">
                        <label class="label">iKiosk Homepage</label>
                        <label class="input">
                          <input type="text" name="user_homepage" value="<?php echo $row_getRecord['user_homepage']; ?>">
                        </label>
                      </section>
                      <section class="col col-6"> </section>
                    </div>
                  </fieldset>
                </div>
                <div class="tab-pane fade in" id="password">
                  <fieldset>
                    <div class="row">
                      <section class="col col-6">
                        <label class="label">Password</label>
                        <label class="input">
                          <input type="password" name="login_password" value="<?php echo $row_getRecord['login_password']; ?>">
                        </label>
                      </section>
                      <section class="col col-6">
                        <label class="label">Confirm Password</label>
                        <label class="input">
                          <input type="password" name="confirm_password" value="<?php echo $row_getRecord['login_password']; ?>">
                        </label>
                      </section>
                    </div>
                  </fieldset>
                </div>
              </div>
              <footer>
                <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="edit-SysUsers"> <i class="fa fa-check"></i> Save </button>
                <button type="button" class="btn btn-default ajaxLink" href="index.php#webapps/admin/users.php"><i class="fa fa-times"></i> Cancel </button>
                <input type="hidden" name="user_id" value="<?php echo $row_getRecord['user_id']; ?>" />
                <input type="hidden" name="formID" value="edit-SysUsers">
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
       $("#edit-SysUsers").validate({
            rules : {
                		login_email : {
			required : true
		},
		login_password : {
			required : true
		},
		confirm_password : {
			required : true,
			equalTo : '#login_password'
		},
		first_name : {
			required : true
		},
		last_name : {
			required : true
		},

            },
						// Messages for form validation
			messages : {
				confirm_password : {
					equalTo : 'Passwords do not match'
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
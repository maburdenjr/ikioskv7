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
      <div class="system-message"></div>
      <div class="jarviswidget" id="sys-applications" data-widget-editbutton="false" data-widget-deletebutton="false">
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
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php do { ?>
                  <tr class="<?php echo $row_listView['application_id']; ?>">
                    <td><a href="?action=edit&recordID=<?php echo $row_listView['application_id']; ?>#webapps/admin/applications.php"><?php echo $row_listView['application_title']; ?></a></td>
                    <td><?php echo $row_listView['application_code']; ?></td>
                    <td><?php echo $row_listView['application_security']; ?></td>
                    <td><?php echo $row_listView['application_status']; ?></td>
                    <td class="icon"><a class="delete-record" data-table="sys_applications" data-record="<?php echo $row_listView['application_id']; ?>" data-code="<?php echo $APPLICATION['application_code']; ?>" data-field="application_id"><i class="fa fa-trash-o"></i></a></td>
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
		$('#dt_applications').dataTable();
</script>
<?php } ?>



<?php 
if ($panelAction == "edit") { // Edit View ###########################################################

mysql_select_db($database_ikiosk, $ikiosk);
$query_listView = "SELECT * FROM sys_applications WHERE deleted = '0'";
$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
$row_listView = mysql_fetch_assoc($listView);
$totalRows_listView = mysql_num_rows($listView);

//Get Current Record
mysql_select_db($database_ikiosk, $ikiosk);
$query_getRecord = "SELECT * FROM sys_applications WHERE deleted = '0' AND application_id = '".$_GET['recordID']."'";
$getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
$row_getRecord = mysql_fetch_assoc($getRecord);
$totalRows_getRecord = mysql_num_rows($getRecord);
?>
<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title">Application Management</h1>
  </div>
</div>
<section id="widget-grid">
  <div class="row">
		<article class="col-sm-12 col-md-12 col-lg-8">
      <div class="jarviswidget" id="edit-application" data-widget-editbutton="false" data-widget-deletebutton="false">
        <header> <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
          <h2>Edit Application</h2>
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
            <form id= "editApplication" class="smart-form" method="post">
              <header> <?php echo $row_getRecord['application_title']; ?> </header>
              <fieldset>
              <div class="form-response"></div>
              <section>
                <label class="label">Title</label>
                <label class="input">
                  <input name="application_title" type="text" value="<?php echo $row_getRecord['application_title']; ?>"/>
                </label>
               </section>
               <div class="row">
              
               <section class="col col-4">
               <label class="label">System Code</label>
               <label class="input state-disabled">
                <input name="application_code" type="text" disabled="disabled" value="<?php echo $row_getRecord['application_code']; ?>" />
                </label>
               </section>
               <section class="col col-4">
               <label class="label">Type</label>
               <label class="select">
                <select name="application_type">
          <option value="Application" <?php if (!(strcmp("Application", $row_getRecord['application_type']))) {echo "selected=\"selected\"";} ?>>Application</option>
          <option value="Module" <?php if (!(strcmp("Module", $row_getRecord['application_type']))) {echo "selected=\"selected\"";} ?>>Module</option>
          <option value="Widget" <?php if (!(strcmp("Widget", $row_getRecord['application_type']))) {echo "selected=\"selected\"";} ?>>Widget</option>
        </select><i></i>
                </label>
               </section>
                <section class="col col-4">
               	<label class="label">Version</label>
                <label class="input">
                <input name="application_version" type="text" value="<?php echo $row_getRecord['application_version']; ?>" />
                </label>
               </section> 
               </div>
               <section>
               	<label class="label">System Location</label>
                <label class="input">
                <i class="icon-append fa fa-question-circle"></i>
                <input name="application_root" type="text" value="<?php echo $row_getRecord['application_root']; ?>" />
                <b class="tooltip tooltip-top-right">
											<i class="fa fa-warning txt-color-teal"></i> 
											Application root should be relative to the IntelliKiosk root directory (<?php echo $SYSTEM['ikiosk_root']; ?>)</b>
                </label>
               </section>
               <div class="row">
               	<section class="col col-4">
                	<label class="label">User Level</label>
                 <label class="select">
                 <select name="application_security">
                    <option value="public" <?php if (!(strcmp("public", $row_getRecord['application_security']))) {echo "selected=\"selected\"";} ?>>Public</option>
                    <option value="registered" <?php if (!(strcmp("registered", $row_getRecord['application_security']))) {echo "selected=\"selected\"";} ?>>Registered</option>
                    <option value="admin" <?php if (!(strcmp("admin", $row_getRecord['application_security']))) {echo "selected=\"selected\"";} ?>>Admin</option>
                  </select><i></i>
                 </label>
                </section>
               	<section class="col col-4">
                <label class="label">Access Level</label>
                <label class="select">
                <select name="application_clearance">
          <option value="000" <?php if (!(strcmp(000, $row_getRecord['application_clearance']))) {echo "selected=\"selected\"";} ?>>No Access</option>
          <option value="111" <?php if (!(strcmp(111, $row_getRecord['application_clearance']))) {echo "selected=\"selected\"";} ?>>Standard</option>
          <option value="112" <?php if (!(strcmp(112, $row_getRecord['application_clearance']))) {echo "selected=\"selected\"";} ?>>Admin</option>
          <option value="999" <?php if (!(strcmp(999, $row_getRecord['application_clearance']))) {echo "selected=\"selected\"";} ?>>Super Admin</option>
        </select><i></i>
                </label>
                </section>
                <section class="col col-4">
                	<label class="label">Status</label>
                  <label class="select">
                  <select name="application_status">
                    <option value="Active" <?php if (!(strcmp("Active", $row_getRecord['application_status']))) {echo "selected=\"selected\"";} ?>>Active</option>
                    <option value="Inactive" <?php if (!(strcmp("Inactive", $row_getRecord['application_status']))) {echo "selected=\"selected\"";} ?>>Inactive</option>
                  </select><i></i>
                  </label>
                </section>
               </div>
               <section>
               <label class="label">Description</label>
               <label class="textarea">
               	<textarea name="application_description" rows="3" class="custom-scroll"><?php echo $row_getRecord['application_description']; ?></textarea>
               </label>
               </section>
              </fieldset>
              <footer>
                <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="editApplication"> Save </button>
                <button type="button" class="btn btn-default" onclick="window.history.back();"> Cancel </button>
         
               <input type="hidden" name="application_id" value="<?php echo $row_getRecord['application_id']; ?>" />
               <input type="hidden" name="formID" value="editApplication">
               <input type="hidden" name="iKioskForm" value="Yes" />
               <input type="hidden" name="application-code" value="<?php echo $APPLICATION['application_code']; ?>" />
              </footer>
            </form>
          </div>
        </div>
      </div>
    </article>
    <article class="col-sm-12 col-md-12 col-lg-4">
    <div class="jarviswidget" id="sys-applications-widget" data-widget-editbutton="false" data-widget-deletebutton="false">
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
                </tr>
              </thead>
              <tbody>
                <?php do { ?>
                  <tr>
                    <td class="<?php echo $row_listView['application_id']; ?>"><a href="?action=edit&recordID=<?php echo $row_listView['application_id']; ?>#webapps/admin/applications.php"><?php echo $row_listView['application_title']; ?></a></td>
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
	runAllForms();

	$(function() {
		// Validation
		$("#editApplication").validate({
			// Rules for form validation
			rules : {
				application_title : {
					required : true,
				},
				application_root : {
					required: true,
				}
			},
			// Messages for form validation
			messages : {
				application_title : {
					required : 'Please enter a title for this application',
				},
				application_root: {
					required : 'Please the location for this application within the IntelliKiosk filesystem.',
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

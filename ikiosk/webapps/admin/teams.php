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
   $query_listView = "SELECT * FROM sys_teams WHERE deleted = '0' ";
   $listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
   $row_listView = mysql_fetch_assoc($listView);
   $totalRows_listView = mysql_num_rows($listView);
   ?>

<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title">Team Management</h1>
  </div>
</div>
<section id="widget-grid">
<!-- Begin Create Record -->
<div class="modal fade" id="createTeam">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id = "create-SysTeams" class="smart-form" method="post">
        <div class="modal-header">
          <h4 class="modal-title">Create Team</h4>
        </div>
        <div class="modal-body">
          <div class="form-response"></div>
          <section>
            <label class="label">Title</label>
            <label class="input">
              <input type="text" name="title" value="<?php echo $row_getRecord['title']; ?>">
            </label>
          </section>
          <section>
            <label class="label">Description</label>
            <label class="textarea">
              <textarea rows="3" class="custom-scroll" name="description"><?php echo $row_getRecord['description']; ?></textarea>
            </label>
          </section>
          <input type="hidden" name="formID" value="create-SysTeams">
          <input type="hidden" name="iKioskForm" value="Yes">
          <input type="hidden" name="appCode" value="<?php echo $APPLICATION['application_code']; ?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel </button>
          <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="create-SysTeams"> <i class="fa fa-check"></i> Save </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Create Record --> 
<!-- Start List View -->
<div id="listCtn-SysTeams" class="row">
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="system-message"></div>
  <div class="jarviswidget" id="list-SysTeams" data-widget-editbutton="false" data-widget-deletebutton="false">
    <header> <span class="widget-icon"> <i class="fa fa-table"></i> </span>
      <h2>Teams</h2>
    </header>
    <div>
      <div class="jarviswidget-editbox">
        <input class="form-control" type="text">
      </div>
      <div class="widget-body no-padding">
        <table id="dt-SysTeams" class="table table-striped table-bordered table-hover" width="100%">
          <thead>
            <tr>
              <th>Title</th>
              <th>Description</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php do { ?>
              <tr class="<?php echo $row_listView['team_id']; ?>">
                <td><a href="index.php?action=edit&recordID=<?php echo $row_listView['team_id']; ?>#webapps/admin/teams.php" class="ajaxLink"><?php echo $row_listView['title']; ?></a></td>
                <td><?php echo $row_listView['description']; ?></td>
                <td class="icon"><a class="delete-record" data-table="sys_teams" data-record="<?php echo $row_listView['team_id']; ?>" data-code="<?php echo $APPLICATION['application_code']; ?>" data-field="team_id"><i class="fa fa-trash-o"></i></a></td>
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
   var listView = $('#dt-SysTeams').dataTable();
   $('.dataTables_length').before('<button class="btn btn-primary btn-toggle btn-add"  data-toggle="modal" data-target="#createTeam"><i class="fa fa-plus"></i> New <span class="hidden-mobile">Team</span></button>');
</script> 
<script type="text/javascript">
   runAllForms();
   
   $(function() {
       // Validation
       $("#create-SysTeams").validate({
       
           rules : {
                		title : {
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
   $query_getRecord = "SELECT * FROM sys_teams WHERE deleted = '0' AND team_id = '".$_GET['recordID']."' ";
   $getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
   $row_getRecord = mysql_fetch_assoc($getRecord);
   $totalRows_getRecord = mysql_num_rows($getRecord);
   
   ?>
<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title"><?php echo $row_getRecord['title']; ?></h1>
  </div>
</div>
<section id="widget-grid">
  <div class="system-message"></div>
  <div class="row">
    <article class="col-sm-12 col-md-12 col-lg-12">
      <div class="jarviswidget" id="editCtn-SysTeams-<?php echo $row_getRecord['team_id']; ?>" data-widget-editbutton="false" data-widget-deletebutton="false">
        <header> <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
          <h2>Edit Team</h2>
        </header>
        <div>
          <div class="jarviswidget-editbox"> 
            <!-- This area used as dropdown edit box -->
            <input class="form-control" type="text">
          </div>
          <div class="widget-body no-padding">
            <form id= "edit-SysTeams" class="smart-form" method="post">
              <fieldset>
                <div class="form-response"></div>
                <div class="row">
                  <section class="col col-12">
                    <label class="label">Title</label>
                    <label class="input">
                      <input type="text" name="title" value="<?php echo $row_getRecord['title']; ?>">
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
                <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="edit-SysTeams"> <i class="fa fa-check"></i> Save </button>
                <button type="button" class="btn btn-default ajaxLink" href="index.php#webapps/admin/teams.php"><i class="fa fa-times"></i> Cancel </button>
                <input type="hidden" name="team_id" value="<?php echo $row_getRecord['team_id']; ?>" />
                <input type="hidden" name="formID" value="edit-SysTeams">
                <input type="hidden" name="iKioskForm" value="Yes" />
                <input type="hidden" name="appCode" value="<?php echo $APPLICATION['application_code']; ?>" />
              </footer>
            </form>
          </div>
        </div>
      </div>
      
    </article>
  </div>
  <div class="row">
  		    <article class="col-sm-12 col-md-6 col-lg-6">
          <div class="jarviswidget" id="editCtn-SysTeams-<?php echo $row_getRecord['team_id']; ?>-members" data-widget-editbutton="false" data-widget-deletebutton="false"  data-widget-togglebutton="false"  data-widget-fullscreenbutton="false" data-widget-load="includes/core/formProcessor.php?ajaxAction=teamMembers&appCode=SYS&recordID=<?php echo $row_getRecord['team_id']; ?>">
        <header> <span class="widget-icon"> <i class="fa fa-user"></i> </span>
          <h2>Team Members</h2>
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
          <article class="col-sm-12 col-md-6 col-lg-6">
          <div class="jarviswidget" id="editCtn-SysTeams-Add" data-widget-editbutton="false" data-widget-deletebutton="false" data-widget-togglebutton="false"  data-widget-fullscreenbutton="false" data-widget-load="includes/core/formProcessor.php?ajaxAction=teamMemberSelect&appCode=SYS&recordID=<?php echo $row_getRecord['team_id']; ?>">
        <header> <span class="widget-icon"> <i class="fa fa-user"></i> </span>
          <h2>Add User</h2>
        </header>
        <div>
          <div class="jarviswidget-editbox"> 
            <!-- This area used as dropdown edit box -->
            <input class="form-control" type="text">
          </div>
          <div class="widget-body no-padding">
            
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
       $("#edit-SysTeams").validate({
            rules : {
                		title : {
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
			 $("#edit-AddUserToTeam").validate({
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
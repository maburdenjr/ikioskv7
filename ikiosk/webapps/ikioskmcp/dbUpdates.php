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
   $query_listView = "SELECT * FROM ikioskcloud_db_update WHERE deleted = '0' ";
   $listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
   $row_listView = mysql_fetch_assoc($listView);
   $totalRows_listView = mysql_num_rows($listView);
   ?>
<div class="row">
   <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
      <h1 class="page-title">Database Updates</h1>
   </div>
</div>
<section id="widget-grid">
   <!-- Begin Create Record -->
   <div class="modal fade" id="createCtn-IkioskcloudDbUpdate">
           <div class="modal-dialog">
            <div class="modal-content">
                <form id = "create-IkioskcloudDbUpdate" class="smart-form" method="post">
                <div class="modal-header">
                <h4 class="modal-title">Create Database Update Query</h4>
              </div>
              <div class="modal-body">
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
                                    <label class="label">SQL Query</label>
                                    <label class="textarea">
                                        <textarea rows="3" class="custom-scroll" name="sql_query"><?php echo $row_getRecord['sql_query']; ?></textarea>
                                    </label>
                                </section>
                            </div>
                            <div class="row">
                                <section class="col col-12">
                                    <label class="label">Status</label>
                                    <label class="select">
                                        <select name="status">
                                            <option value="Active" <?php if (!(strcmp("Active", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Active</option>
                                            <option value="Inactive" <?php if (!(strcmp("Inactive", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Inactive</option>
                                        </select><i></i>
                                    </label>
                                </section>
                            </div>
                            
                            <div class="row">
                            </div>
                      <input type="hidden" name="formID" value="create-IkioskcloudDbUpdate">
                  <input type="hidden" name="iKioskForm" value="Yes">
                  <input type="hidden" name="appCode" value="<?php echo $APPLICATION['application_code']; ?>">
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel </button>
                         <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="create-IkioskcloudDbUpdate"> <i class="fa fa-check"></i> Save </button>
              </div>
                        </form>
            </div>
        </div>
   </div>

  <!-- End Create Record -->
   <!-- Start List View -->
   <div id="listCtn-IkioskcloudDbUpdate" class="row">
   <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="system-message"></div>
      <div class="jarviswidget" id="list-IkioskcloudDbUpdate" data-widget-editbutton="false" data-widget-deletebutton="false">
         <header>
            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
            <h2>Database Updates</h2>
         </header>
         <div>
            <div class="jarviswidget-editbox"> 
               <input class="form-control" type="text">
            </div>
            <div class="widget-body no-padding">
               <table id="dt-IkioskcloudDbUpdate" class="table table-striped table-bordered table-hover" width="100%">
                  <thead>
                    <tr>
                        <th>Title</th>
                        <th>SQL Query</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                    <tbody>
                        <?php do { ?>
                        <tr class="<?php echo $row_listView['update_id']; ?>">
                            <td><a href="index.php?action=edit&recordID=<?php echo $row_listView['update_id']; ?>#webapps/ikioskmcp/dbUpdates.php" class="ajaxLink"><?php echo $row_listView['title']; ?></a></td>
                            <td><?php echo $row_listView['sql_query']; ?></td>
                             <td><?php echo $row_listView['status']; ?></td>
                            <td class="icon"><a class="delete-record" data-table="ikioskcloud_db_update" data-record="<?php echo $row_listView['update_id']; ?>" data-code="<?php echo $APPLICATION['application_code']; ?>" data-field="update_id"><i class="fa fa-trash-o"></i></a></td>
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
   var listView = $('#dt-IkioskcloudDbUpdate').dataTable();
   $('.dataTables_length').before('<button class="btn btn-primary btn-toggle btn-add"   data-toggle="modal" data-target="#createCtn-IkioskcloudDbUpdate"><i class="fa fa-plus"></i> New <span class="hidden-mobile">Database Query</span></button>');
</script>
<script type="text/javascript">
   runAllForms();
   
   $(function() {
       // Validation
       $("#create-IkioskcloudDbUpdate").validate({
       
           rules : {
                		title : {
			required : true
		},
		sql_query : {
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
   $query_getRecord = "SELECT * FROM ikioskcloud_db_update WHERE deleted = '0' AND update_id = '".$_GET['recordID']."' ";
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
   <div class="row">
      <article class="col-sm-12 col-md-12 col-lg-12">
         <div class="jarviswidget" id="editCtn-IkioskcloudDbUpdate" data-widget-editbutton="false" data-widget-deletebutton="false">
            <header>
               <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
               <h2>Edit Database Query</h2>
            </header>
            <div>
               <div class="jarviswidget-editbox">
                  <!-- This area used as dropdown edit box -->
                  <input class="form-control" type="text">
               </div>
               <div class="widget-body no-padding">
                  <form id= "edit-IkioskcloudDbUpdate" class="smart-form" method="post">
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
                                    <label class="label">SQL Query</label>
                                    <label class="textarea">
                                        <textarea rows="3" class="custom-scroll" name="sql_query"><?php echo $row_getRecord['sql_query']; ?></textarea>
                                    </label>
                                </section>
                            </div>
                            <div class="row">
                                <section class="col col-12">
                                    <label class="label">Status</label>
                                    <label class="select">
                                        <select name="status">
                                            <option value="Active" <?php if (!(strcmp("Active", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Active</option>
                                            <option value="Inactive" <?php if (!(strcmp("Inactive", $row_getRecord['status']))) {echo "selected=\"selected\"";} ?>>Active</option>
                                        </select><i></i>
                                    </label>
                                </section>
                            </div>
                           
                     </fieldset>
                     <footer>
                        <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="edit-IkioskcloudDbUpdate"> <i class="fa fa-check"></i> Save </button>
                        <button type="button" class="btn btn-default ajaxLink" href="index.php#webapps/ikioskmcp/dbUpdates.php"><i class="fa fa-times"></i> Cancel </button>
                        <input type="hidden" name="update_id" value="<?php echo $row_getRecord['update_id']; ?>" />
                        <input type="hidden" name="formID" value="edit-IkioskcloudDbUpdate">
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
       $("#edit-IkioskcloudDbUpdate").validate({
            rules : {
                		title : {
			required : true
		},
		sql_query : {
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
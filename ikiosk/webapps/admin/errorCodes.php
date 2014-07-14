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
   $query_listView = "SELECT * FROM sys_errors WHERE deleted = '0' ";
   $listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
   $row_listView = mysql_fetch_assoc($listView);
   $totalRows_listView = mysql_num_rows($listView);
   ?>
<div class="row">
   <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
      <h1 class="page-title">Error Codes</h1>
   </div>
</div>
<section id="widget-grid">
   <!-- Begin Create Record -->
   <div id="createCtn-SysErrors" class="row hidden-panel">
      <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
         <div class="jarviswidget" id="add-SysErrors" data-widget-editbutton="false" data-widget-deletebutton="false">
            <header>
               <span class="widget-icon"> <i class="fa fa-plus"></i> </span>
               <h2>New Error Codes</h2>
            </header>
            <div>
               <div class="jarviswidget-editbox"> 
                  <input class="form-control" type="text">
               </div>
               <div class="widget-body no-padding">
                  <form id = "create-SysErrors" class="smart-form" method="post">
                     <fieldset>
                                            <div class="form-response"></div>
                                                    <div class="row">
                                <section class="col col-12">
                                    <label class="label">Error Title</label>
                                    <label class="input">
                                        <input type="text" name="error_title" value="<?php echo $row_getRecord['error_title']; ?>">
                                    </label>
                                </section>
                            </div>
                            <div class="row">
                                <section class="col col-12">
                                    <label class="label">Error Description</label>
                                    <label class="textarea">
                                        <textarea rows="3" class="custom-scroll"><?php echo $row_getRecord['error_description']; ?></textarea>
                                    </label>
                                </section>
                            </div>
                            <div class="row">
                            </div>
                     </fieldset>
                     <footer>
                        <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="create-SysErrors"> <i class="fa fa-check"></i> Save </button>
                        <button type="button" class="btn btn-default btn-toggle" data-close="createCtn-SysErrors" data-open="listCtn-SysErrors"><i class="fa fa-times"></i> Cancel </button>
                        <input type="hidden" name="formID" value="create-SysErrors">
                        <input type="hidden" name="iKioskForm" value="Yes">
                        <input type="hidden" name="appCode" value="<?php echo $APPLICATION['application_code']; ?>">
                     </footer>
                  </form>
               </div>
            </div>
         </div>
      </article>
   </div>
  <!-- End Create Record -->
   <!-- Start List View -->
   <div id="listCtn-SysErrors" class="row">
   <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="system-message"></div>
      <div class="jarviswidget" id="list-SysErrors" data-widget-editbutton="false" data-widget-deletebutton="false">
         <header>
            <span class="widget-icon"> <i class="fa fa-table"></i> </span>
            <h2>Error Codes</h2>
         </header>
         <div>
            <div class="jarviswidget-editbox"> 
               <input class="form-control" type="text">
            </div>
            <div class="widget-body no-padding">
               <table id="dt-SysErrors" class="table table-striped table-bordered table-hover" width="100%">
                  <thead>
                    <tr>
                        <th></th>
                        <th>Error Title</th>
                        <th>Error Description</th>
                        <th></th>
                    </tr>
                </thead>
                    <tbody>
                        <?php do { ?>
                        <tr class="<?php echo $row_listView['error_id']; ?>">
                            <td><a href="index.php?action=edit&recordID=<?php echo $row_listView['error_id']; ?>#webapps/admin/errorCodes.php"><?php echo $row_listView['error_title']; ?></a></td>
                            <td><?php echo $row_listView['error_title']; ?></td>
                            <td><?php echo $row_listView['error_description']; ?></td>
                            <td class="icon"><a class="delete-record" data-table="sys_errors" data-record="<?php echo $row_listView['error_id']; ?>" data-code="<?php echo $APPLICATION['application_code']; ?>" data-field="error_id"><i class="fa fa-trash-o"></i></a></td>
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
   var listView = $('#dt-SysErrors').dataTable();
   $('.dataTables_length').before('<button class="btn btn-primary btn-toggle btn-add" data-open="createCtn-SysErrors" data-close="listCtn-SysErrors"><i class="fa fa-plus"></i> New <span class="hidden-mobile">Error Codes</span></button>');
</script>
<script type="text/javascript">
   runAllForms();
   
   $(function() {
       // Validation
       $("#create-SysErrors").validate({
       
           rules : {
                		error_title : {
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
   $query_getRecord = "SELECT * FROM sys_errors WHERE deleted = '0' AND error_id = '".$_GET['recordID']."' ";
   $getRecord = mysql_query($query_getRecord, $ikiosk) or sqlError(mysql_error());
   $row_getRecord = mysql_fetch_assoc($getRecord);
   $totalRows_getRecord = mysql_num_rows($getRecord);
   
   ?>
<div class="row">
   <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
      <h1 class="page-title">Error Codes</h1>
   </div>
</div>
<section id="widget-grid">
   <div class="row">
      <article class="col-sm-12 col-md-12 col-lg-12">
         <div class="jarviswidget" id="editCtn-SysErrors" data-widget-editbutton="false" data-widget-deletebutton="false">
            <header>
               <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
               <h2>Edit Error Codes</h2>
            </header>
            <div>
               <div class="jarviswidget-editbox">
                  <!-- This area used as dropdown edit box -->
                  <input class="form-control" type="text">
               </div>
               <div class="widget-body no-padding">
                  <form id= "edit-SysErrors" class="smart-form" method="post">
                     <header> <?php echo $row_getRecord['error_title']; ?> </header>
                     <fieldset>
                        <div class="form-response"></div>
                                                    <div class="row">
                                <section class="col col-12">
                                    <label class="label">Error Title</label>
                                    <label class="input">
                                        <input type="text" name="error_title" value="<?php echo $row_getRecord['error_title']; ?>">
                                    </label>
                                </section>
                            </div>
                            <div class="row">
                                <section class="col col-12">
                                    <label class="label">Error Description</label>
                                    <label class="textarea">
                                        <textarea rows="3" class="custom-scroll"><?php echo $row_getRecord['error_description']; ?></textarea>
                                    </label>
                                </section>
                            </div>
                            
                     </fieldset>
                     <footer>
                        <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="edit-SysErrors"> <i class="fa fa-check"></i> Save </button>
                        <button type="button" class="btn btn-default" onclick="window.history.back();"><i class="fa fa-times"></i> Cancel </button>
                        <input type="hidden" name="error_id" value="<?php echo $row_getRecord['error_id']; ?>" />
                        <input type="hidden" name="formID" value="edit-SysErrors">
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
       $("#edit-SysErrors").validate({
            rules : {
                		error_title : {
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
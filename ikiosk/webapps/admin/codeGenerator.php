<?php
/* iKiosk 7.0 Tiger */
$PAGE['application_code'] = "SYS";
require('../../includes/core/ikiosk.php');

mysql_select_db($database_ikiosk, $ikiosk);
$query_showTables = "SHOW TABLES";
$showTables = mysql_query($query_showTables, $ikiosk) or sqlError(mysql_error());
$row_showTables = mysql_fetch_assoc($showTables);
$totalRows_showTables = mysql_num_rows($showTables);

$databaseMAP = "Tables_in_".$database_ikiosk;

mysql_select_db($database_ikiosk, $ikiosk);
$query_getApps = "SELECT * FROM sys_applications WHERE deleted = '0'";
$getApps = mysql_query($query_getApps, $ikiosk) or sqlError(mysql_error());
$row_getApps = mysql_fetch_assoc($getApps);
$totalRows_getApps = mysql_num_rows($getApps);
?>

<div class="row">
  <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
    <h1 class="page-title"><i class="fa fa-code-fork fa-fw "></i> Code Generator</h1>
  </div>
</div>
<section id="widget-grid">
  <div class="row">
    <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="jarviswidget" id="codeGenerator" data-widget-editbutton="false" data-widget-deletebutton="false">
        <header> <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
          <h2>Build New Code Snippet</h2>
        </header>
        <div>
          <div class="jarviswidget-editbox">
            <input class="form-control" type="text">
          </div>
          <div class="widget-body no-padding">
            <form id= "codeSnippet" class="smart-form" method="post">
              <fieldset>
                <div class="form-response"></div>
                <div class="row">
                  <section class="col col-3">
                    <label class="label">Module Title</label>
                    <label class="input">
                      <input name="module_title" type="text">
                    </label>
                  </section>
                  <section class="col col-3">
                    <label class="label">Database Table</label>
                    <label class="select">
                      <select name="query_table" id="query_table">
                        <?php
do {  
?>
                        <option value="<?php echo $row_showTables[$databaseMAP]; ?>" <?php if ($row_showTables[$databaseMAP] == $_GET['query_table']) {echo "selected = \"selected\"";} ?>><?php echo $row_showTables[$databaseMAP]; ?></option>
                        <?php
} while ($row_showTables = mysql_fetch_assoc($showTables));
  $rows = mysql_num_rows($showTables);
  if($rows > 0) {
      mysql_data_seek($showTables, 0);
	  $row_showTables = mysql_fetch_assoc($showTables);
  }
?>
                      </select>
                      <i></i> </label>
                  </section>
                  <section class="col col-3">
                    <label class="label">Primary Key Field</label>
                    <label class="select">
                      <select name="primary_key" id="primary_key">
                      </select>
                      <i></i> </label>
                  </section>

                  <section class="col col-3">
                    <label class="label">Link Label</label>
                    <label class="select">
                      <select name="link_label" id="link_label">
                      </select>
                      <i></i></label>
                  </section>
                  

                </div>
                <div class="row">
                <section class="col col-3">
                    <label class="label">Module Index</label>
                    <label class="input">
                      <input name="module_index" type="text">
                    </label>
                  </section>
                <section class="col col-3">
                    <label class="label">Query Filter</label>
                    <label class="select">
                      <select name="query_filter">
                        <option value="None">None</option>
                        <option value="Team">Team</option>
                        <option value="Site">Site</option>
                      </select>
                      <i></i></label>
                  </section>
                  <section class="col col-3">
                    <label class="label">App Code</label>
                    <label class="select">
                      <select name="app_code" id="app_code">
                        <?php do { ?>
                        <option value="<?php echo $row_getApps['application_code']; ?>"><?php echo $row_getApps['application_code']." - ".$row_getApps['application_title']; ?></option>
                        <?php } while ($row_getApps = mysql_fetch_assoc($getApps)); ?>
                      </select>
                      <i></i> </label>
                  </section>
                                    
                  <section class="col col-3">
                    <label class="label">Form Columns</label>
                    <label class="select">
                      <select name="form_columns" id="form_columns">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                      </select>
                      <i></i> </label>
                  </section>
                </div>
                <section>
                  <label class="label">Form Fields</label>
                  <table id="dbFieldList" class="table table-striped table-bordered table-hover" width="100%">
                    <thead>
                      <tr>
                        <th><label class="checkbox">
                            <input type="checkbox" class="checkall">
                            <i></i></label></th>
                        <th>Field Name</th>
                        <th>Label</th>
                        <th>Type</th>
                        <th>Required</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </section>
              </fieldset>
              <footer>
                <button type="submit" class="btn btn-primary btn-ajax-submit" data-form="codeSnippet"> <i class="fa fa-check"></i> Generate Code</button>
                <button type="button" class="btn btn-default" onclick="window.history.back();"><i class="fa fa-times"></i> Cancel </button>
                <input type="hidden" name="formID" value="codeSnippet">
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
<div class="row">
  <div id="codeResponse" class="col-sm-12"> </div>
</div>
<script type="text/javascript">
	runAllForms();

	$(function() {
		// Validation
		$("#codeSnippet").validate({
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
<script type="text/javascript">
		pageSetUp();


		
		$('#query_table').on("change", function() {
			var dbTable = $(this).val();
			
			$.ajax({
					url: "includes/core/formProcessor.php?appCode=SYS&ajaxAction=dbFields&option=select&table="+dbTable,	
					timeout: 3000,
					error: function(data) {
							var error="<div class='alert alert-danger fade in'><a class='close' data-dismiss='alert' href='#'>×</a> An unknown error has occurred.  Please try again.</div>";
							$('#codeSnippet .form-response').html(error);
					},
					success: function(data) {
							$('#codeSnippet #primary_key').html(data);
							$('#codeSnippet #link_label').html(data);
					}
			});
			
			$.ajax({
					url: "includes/core/formProcessor.php?appCode=SYS&ajaxAction=dbFields&option=list&table="+dbTable,	
					timeout: 3000,
					error: function(data) {
							var error="<div class='alert alert-danger fade in'><a class='close' data-dismiss='alert' href='#'>×</a> An unknown error has occurred.  Please try again.</div>";
							$('#codeSnippet .form-response').html(error);
					},
					success: function(data) {
							$('#codeSnippet #dbFieldList tbody').html(data);
					}
			});
		});
		
		$('#query_table').change();
		
		$('.checkall').on("click", function () {
			var checkBoxes = $("input[name=include_field\\[\\]]");
			checkBoxes.prop("checked", !checkBoxes.prop("checked"));
		});
		
</script> 

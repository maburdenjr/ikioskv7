<?php
//Record Action Wrapper ###############################################################################

if (isset($_GET['ajaxAction'])) {

// Return DB Fileds in Table  ------------------------------------------------------------------------
	if($_GET['ajaxAction'] == "dbFields") {
		
		$response = "";
		$restricted = array("date_created", "created_by", "modified_by", "date_modified", "deleted");
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_showColumns = "SHOW COLUMNS FROM ".$_GET['table']."";
		$showColumns = mysql_query($query_showColumns, $ikiosk) or sqlError(mysql_error());
		$row_showColumns = mysql_fetch_assoc($showColumns);
		$totalRows_showColumns = mysql_num_rows($showColumns);
		
		if ($_GET['option'] == "select") {
				do {
					if (!in_array($row_showColumns['Field'], $restricted)) {
						$response .= "<option value='".$row_showColumns['Field']."'>".$row_showColumns['Field']."</option>";
					}
				} while ($row_showColumns = mysql_fetch_assoc($showColumns));
		}
		
		if ($_GET['option'] == "list") {
				do {
					if (!in_array($row_showColumns['Field'], $restricted)) {
						$label = str_replace("_", " ", $row_showColumns['Field']);
						$label = ucwords($label);
						$response .= "<tr><td><label class='checkbox'><input type='checkbox' name='include_field[]' value='".$row_showColumns['Field']."'><i></i></label></td>";
						$response .="<td>".$row_showColumns['Field']."</td>";
						$response .="<td><label class='input'><input type='text' name='".$row_showColumns['Field']."[label]' value='".$label."'></label></td>";
						$response .="<td><label class='select'><select name='".$row_showColumns['Field']."[type]'><option value='input'>Text Input</option><option value='select'>Select</option><option value='select-multiple'>Multiple Select</option><option value='textarea'>Textarea</option><option value='radio'>Radio</option><option value='checkbox'>Checkbox</option></select><i></i></label></td>";
						$response .="<td><label class='toggle'><input type='checkbox' name='".$row_showColumns['Field']."[required]' value='Yes'><i data-swchon-text='YES' data-swchoff-text='NO'></i></label></td></tr>";
					}
				} while ($row_showColumns = mysql_fetch_assoc($showColumns));
		} 
		 
		
		echo $response;
		exit;	
	}


// Delete Records --------------------------------------------------------------------------------	
	
	if($_GET['ajaxAction'] == "deleteRecord") {
		$status = deleteRecordv7($_GET['table'], $_GET['field'], $_GET['record']);
		displayAlert($status[0], $status[1]);
		if ($status[0] == "success") {
			insertJS("$('.".$_GET['record']."').fadeOut();");
		}
	}

// AppCode Check --------------------------------------------------------------------------------	
	
	if($_GET['ajaxAction'] == "appCodeCheck") {
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_listView = "SELECT * FROM sys_applications WHERE deleted = '0' AND application_code = '".$_GET['application_code']."'";
		$listView = mysql_query($query_listView, $ikiosk) or sqlError(mysql_error());
		$row_listView = mysql_fetch_assoc($listView);
		$totalRows_listView = mysql_num_rows($listView);
		
		if($totalRows_listView == 0) {
			echo "true";
		} else {
			echo "false";
		}
	}

} // End AJAX Get Wrapper



// Begin AJAX Post Wrapper ###########################################################################

if ((isset($_POST["iKioskForm"])) && ($_POST["iKioskForm"] == "Yes")) {
	
// Code Generator --------------------------------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "codeSnippet")) {
		
		$codeTemplate = urlFetch($SYSTEM['ikiosk_docroot']."/webapps/admin/codeTemplate.txt");
		$codeTemplate = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", htmlentities($codeTemplate));
		$codeTemplate2= urlFetch($SYSTEM['ikiosk_docroot']."/webapps/admin/formTemplate.txt");
		$codeTemplate2 = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", htmlentities($codeTemplate2));
		
		$response = "<div id='codeBlock' class='well'>";
		$response .= "<h2>Application Index File</h2>";
		$response .= "<pre id='appIndex' class='prettyprint custom-scroll html'>".$codeTemplate."</pre>";
		$response .= "<h2>Form Processor Scripts</h2>";
		$response .= "<pre>".$codeTemplate2."</pre>";
		$response .="</div>";	
		
		// Parse Code
		$appID = str_replace("_", " ", $_POST['query_table']);
		$appID = ucwords($appID);
		$appID = str_replace(" ", "", $appID);
		
		$response = str_replace('{APPCODE}', $_POST['app_code'], $response);
		$response = str_replace('{TABLE}', $_POST['query_table'], $response);
		$response = str_replace('{TITLE}', $_POST['module_title'], $response);
		$response = str_replace('{APPID}', $appID, $response);
		$response = str_replace('{PRIMARYKEY}', $_POST['primary_key'], $response);
		
		if($_POST['query_filter'] == "Site") {
				$response = str_replace("{QUERYFILTER}", "AND \".\$SYSTEM['active_site_filter'].\"", $response);	
		}
		if($_POST['query_filter'] == "Team") {
				$response = str_replace("{QUERYFILTER}", "AND \".\$SYSTEM['team_filter'].\"", $response);	
		}
		if($_POST['query_filter'] == "None") {
				$response = str_replace("{QUERYFILTER}", "", $response);	
		}
		
		$col = $_POST['form_columns']; // Number of Columns
		$colInt = 12 / $col;
		
 		$createForm = tab(7)."<div class=\"row\">\r\n";
		
		$loop = 0;
		$validation = "";
		$listView = "<thead>\r\n".tab(5)."<tr>\r\n".tab(6)."<th></th>\r\n";
		$listViewRow = tab(6)."<tr class=\"<?php echo \$row_listView['".$_POST['primary_key']."']; ?>\">\r\n";
		$listViewRow .= tab(7)."<td><a href=\"index.php?action=edit&recordID=<?php echo \$row_listView['".$_POST['primary_key']."']; ?>#".$_POST['module_index']."\"><?php echo \$row_listView['".$_POST['link_label']."']; ?></a></td>\r\n";

		foreach ($_POST['include_field'] as $key => $value) {
			
			if ($_POST[$value]['required'] == "Yes") {
					$validation .= tab(2).$value." : {\r\n".tab(3)."required : true\r\n".tab(2)."},\r\n";
			}	
			
			$listView .= tab(6)."<th>".$_POST[$value]['label']."</th>\r\n";
			$listViewRow .= tab(7)."<td><?php echo \$row_listView['".$value."']; ?></td>\r\n";
			
			switch($_POST[$value]['type']) {
				case "input":
					$type = "input";
						$formField = tab(9)."<label class=\"".$type."\">\r\n";
						$formField .= tab(10)."<input type=\"text\" name=\"".$value."\" value=\"<?php echo \$row_getRecord['".$value."']; ?>\">\r\n";
						$formField .= tab(9)."</label>\r\n";
					break;
				case "select":
					$type = "select";
						$formField = tab(9)."<label class=\"".$type."\">\r\n";
						$formField .= tab(10)."<select name=\"".$value."\">\r\n";
						$formField .= tab(11)."<option value=\"value1\" <?php if (!(strcmp(\"value1\", \$row_getRecord['".$value."']))) {echo \"selected=\\\"selected\\\"\";} ?>>value1</option>\r\n";
						$formField .= tab(11)."<option value=\"value2\" <?php if (!(strcmp(\"value2\", \$row_getRecord['".$value."']))) {echo \"selected=\\\"selected\\\"\";} ?>>value2</option>\r\n";
						$formField .= tab(10)."</select><i></i>\r\n";
						$formField .= tab(9)."</label>\r\n";
					break;
				case "select-multiple":
					$type = "select select-multiple";
						$formField = tab(9)."<label class=\"".$type."\">\r\n";
						$formField .= tab(10)."<select multiple name=\"".$value."\" class=\"custom-scroll\">\r\n";
						$formField .= tab(11)."<option value=\"value1\" <?php if (!(strcmp(\"value1\", \$row_getRecord['".$value."']))) {echo \"selected=\\\"selected\\\"\";} ?>>value1</option>\r\n";
						$formField .= tab(11)."<option value=\"value2\" <?php if (!(strcmp(\"value2\", \$row_getRecord['".$value."']))) {echo \"selected=\\\"selected\\\"\";} ?>>value2</option>\r\n";
						$formField .= tab(10)."</select><i></i>\r\n";
						$formField .= tab(9)."</label>\r\n";
					break;
				case "textarea":
					$type = "textarea";
						$formField = tab(9)."<label class=\"".$type."\">\r\n";
						$formField .= tab(10)."<textarea rows=\"3\" class=\"custom-scroll\"><?php echo \$row_getRecord['".$value."']; ?></textarea>\r\n";
						$formField .= tab(9)."</label>\r\n";
					break;
				case "radio":
					$type = "radio";
						$formField = tab(9)."<div class=\"row\">\r\n";
						$formField .= tab(10)."<label class=\"".$type."\">\r\n";
						$formField .= tab(11)."<input type=\"radio\" name=\"".$value."\" value=\"value1\" <?php if (!(strcmp(\"value1\", \$row_getRecord['".$value."']))) {echo \"checked=\\\"checked\\\"\";} ?>>\r\n".tab(11)."<i></i>Value1\r\n";
						$formField .= tab(10)."</label>\r\n";
						$formField .= tab(10)."<label class=\"".$type."\">\r\n";
						$formField .= tab(11)."<input type=\"radio\" name=\"".$value."\" value=\"value2\" <?php if (!(strcmp(\"value2\", \$row_getRecord['".$value."']))) {echo \"checked=\\\"checked\\\"\";} ?>>\r\n".tab(11)."<i></i>Value2\r\n";
						$formField .= tab(10)."</label>\r\n";
						$formField .= tab(9)."</row>\r\n";

					break;
				case "checkbox":
					$type = "checkbox";
					$formField = tab(9)."<div class=\"inline-group\">\r\n";
					$formField .= tab(10)."<label class=\"".$type."\">\r\n";
					$formField .= tab(11)."<input type=\"checkbox\" name=\"".$value."\"  <?php if (!(strcmp(\"value2\", \$row_getRecord['".$value."']))) {echo \"checked=\\\"checked\\\"\";} ?>>\r\n".tab(11)."<i></i>Value1\r\n";
					$formField .= tab(10)."</label>\r\n";
					$formField .= tab(9)."</div>\r\n";
					break;				
			}
			
			$createForm .= tab(8)."<section class=\"col col-".$colInt."\">\r\n";
			$createForm .= tab(9)."<label class=\"label\">".$_POST[$value]['label']."</label>\r\n";
			$createForm .= $formField;
			$createForm .= tab(8)."</section>\r\n";
			$loop++;
			if ($loop == $col) { $createForm .= tab(7)."</row>\r\n".tab(7)."<div class=\"row\">\r\n"; $loop = 0;}
		}
		
		$listViewRow .= tab(7)."<td class=\"icon\"><a class=\"delete-record\" data-table=\"".$_POST['query_table']."\" data-record=\"<?php echo \$row_listView['".$_POST['primary_key']."']; ?>\" data-code=\"<?php echo \$APPLICATION['application_code']; ?>\" data-field=\"".$_POST['primary_key']."\"><i class=\"fa fa-trash-o\"></i></a></td>\r\n";
		$listViewRow .= tab(6)."</tr>\r\n";

		
		$listView .= tab(6)."<th></th>\r\n".tab(5)."</tr>\r\n".tab(4)."</thead>\r\n";
		$listView .= tab(5)."<tbody>\r\n";
		$listView .= tab(6)."<?php do { ?>\r\n";
		$listView .= $listViewRow;
		$listView .= tab(6)."<?php } while (\$row_listView = mysql_fetch_assoc(\$listView)); ?>\r\n";
		$listView .= tab(5)."</tbody>\r\n";	

		
		$createForm .= tab(7)."</row>";
		$createForm = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", htmlentities($createForm));
		$listView = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", htmlentities($listView));

		$response = str_replace('{CREATEFORM}', $createForm, $response);
		$response = str_replace('{EDITFORM}', $createForm, $response);
		$response = str_replace('{VALIDATION}', $validation, $response);
		$response = str_replace('{LISTVIEW}', $listView, $response);
		$response = str_replace('{LINKLABEL}', $_POST['link_label'], $response);
				
		echo $response;
		
		$js = "$('#codeResponse').hide().html('').fadeIn(); ";
		//$js .= "$('.jarviswidget-toggle-btn').click(); ";
		$js .= "$('#codeBlock').appendTo('#codeResponse'); ";
		$js .= "prettyPrint(); ";
		insertJS($js);
		exit;
	}
	
// Applications: Edit --------------------------------------------------------------------------------
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "editApplication")) {
			$updateSQL = sprintf("UPDATE sys_applications SET application_title=%s, application_root=%s, application_type=%s, application_description=%s, application_security=%s, application_clearance=%s, application_version=%s, application_status=%s, date_modified=%s, modified_by=%s WHERE application_id=%s",
					GetSQLValueString($_POST['application_title'], "text"),
					GetSQLValueString($_POST['application_root'], "text"),
					GetSQLValueString($_POST['application_type'], "text"),
					GetSQLValueString($_POST['application_description'], "text"),
					GetSQLValueString($_POST['application_security'], "text"),
					GetSQLValueString($_POST['application_clearance'], "text"),
					GetSQLValueString($_POST['application_version'], "text"),
					GetSQLValueString($_POST['application_status'], "text"),
					GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
					GetSQLValueString($_SESSION['user_id'], "text"),
					GetSQLValueString($_POST['application_id'], "text"));
	
			mysql_select_db($database_ikiosk, $ikiosk);
			$Result1 = mysql_query($updateSQL, $ikiosk) or sqlError(mysql_error());
			sqlQueryLog($updateSQL);
			
			insertJS("$('.".$_POST['application_id']." a').hide().text('".$_POST['application_title']."').fadeIn()");
			displayAlert("success", "Changes saved.");
			exit;
	}
	// Applications: Create --------------------------------------------------------------------------------
	
	if ((isset($_POST["formID"])) && ($_POST["formID"] == "createApplication")) {
		
		//GPS Mod
		$sqlMod = "ALTER TABLE `sys_permissions` ADD `".$_POST['application_code']."` VARCHAR(5) DEFAULT '".$_POST['default_application_clearance']."' NOT NULL AFTER `USER`";
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($sqlMod, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($sqlMod);
		
		$generateID = create_guid();
		$insertSQL = sprintf("INSERT INTO sys_applications (application_id, application_code, application_title, application_root, application_type, application_description, application_security, application_clearance, application_version, application_status, date_created, created_by, date_modified, modified_by) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
        GetSQLValueString($generateID, "text"),
        GetSQLValueString($_POST['application_code'], "text"),
        GetSQLValueString($_POST['application_title'], "text"),
        GetSQLValueString($_POST['application_root'], "text"),
        GetSQLValueString($_POST['application_type'], "text"),
        GetSQLValueString($_POST['application_description'], "text"),
        GetSQLValueString($_POST['application_security'], "text"),
        GetSQLValueString($_POST['application_clearance'], "text"),
        GetSQLValueString($_POST['application_version'], "text"),
        GetSQLValueString($_POST['application_status'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"),
        GetSQLValueString($SYSTEM['mysql_datetime'], "text"),
        GetSQLValueString($_SESSION['user_id'], "text"));
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$Result1 = mysql_query($insertSQL, $ikiosk) or sqlError(mysql_error());
		sqlQueryLog($insertSQL);
		insertJS($refresh);
		exit;
	}
	
} // End AJAX Post Wrapper

?>
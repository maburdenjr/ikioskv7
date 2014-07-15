<?php
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
		$response .= "<pre id='formScripts' class='prettyprint custom-scroll html'>{FORMHANDLER}</pre>";
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
						$formField .= tab(9)."</div>\r\n";

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
			if ($loop == $col) { $createForm .= tab(7)."</div>\r\n".tab(7)."<div class=\"row\">\r\n"; $loop = 0;}
		}
		
		$listViewRow .= tab(7)."<td class=\"icon\"><a class=\"delete-record\" data-table=\"".$_POST['query_table']."\" data-record=\"<?php echo \$row_listView['".$_POST['primary_key']."']; ?>\" data-code=\"<?php echo \$APPLICATION['application_code']; ?>\" data-field=\"".$_POST['primary_key']."\"><i class=\"fa fa-trash-o\"></i></a></td>\r\n";
		$listViewRow .= tab(6)."</tr>\r\n";

		
		$listView .= tab(6)."<th></th>\r\n".tab(5)."</tr>\r\n".tab(4)."</thead>\r\n";
		$listView .= tab(5)."<tbody>\r\n";
		$listView .= tab(6)."<?php do { ?>\r\n";
		$listView .= $listViewRow;
		$listView .= tab(6)."<?php } while (\$row_listView = mysql_fetch_assoc(\$listView)); ?>\r\n";
		$listView .= tab(5)."</tbody>\r\n";	

		
		$createForm .= tab(7)."</div>";
		$createForm = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", htmlentities($createForm));
		$listView = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", htmlentities($listView));

		$response = str_replace('{CREATEFORM}', $createForm, $response);
		$response = str_replace('{EDITFORM}', $createForm, $response);
		$response = str_replace('{VALIDATION}', $validation, $response);
		$response = str_replace('{LISTVIEW}', $listView, $response);
		$response = str_replace('{LINKLABEL}', $_POST['link_label'], $response);
		
		//Form Handler
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_showColumns = "SHOW COLUMNS FROM ".$_POST['query_table']."";
		$showColumns = mysql_query($query_showColumns, $ikiosk) or sqlError(mysql_error());
		$row_showColumns = mysql_fetch_assoc($showColumns);
		$totalRows_showColumns = mysql_num_rows($showColumns);

		$formHandler = "// ".$_POST['module_title'].": Create -------------------------------------------\r\n";
		$formHandler .= "\r\nif ((isset(\$_POST[\"formID\"])) && (\$_POST[\"formID\"] == \"create-".$appID."\")) {\r\n";
		$formHandler .= tab(1)."\$generateID = create_guid();\r\n";
		$formHandler .= tab(1)."\$insertSQL = sprintf(\"INSERT INTO ".$_POST['query_table']." (";

		do {
				if (($row_showColumns['Field'] != "deleted") && ($row_showColumns['Field'] != "team_id")) {
						$fieldDisplay = "\$_POST['".$row_showColumns['Field']."']";
						if ($row_showColumns['Field'] == "date_modified") { $fieldDisplay = "\$SYSTEM['mysql_datetime']";}
						if ($row_showColumns['Field'] == "date_created") { $fieldDisplay = "\$SYSTEM['mysql_datetime']";}
						if ($row_showColumns['Field'] == "modified_by") { $fieldDisplay = "\$_SESSION['user_id']";}
						if ($row_showColumns['Field'] == "created_by") { $fieldDisplay = "\$_SESSION['user_id']";}
						if ($row_showColumns['Field'] == $_POST['primary_key']) { $fieldDisplay = "\$generateID";}	
						
						$columnSet .= "`".$row_showColumns['Field']."`, ";
						$sprintSet .= "%s, ";
						$sqlSet .= tab(2)."GetSQLValueString(".$fieldDisplay.", \"text\"),\r\n";
				}
			
		} while ($row_showColumns = mysql_fetch_assoc($showColumns));
		
		$columnSet = substr($columnSet, 0, -2);
		$sprintSet = substr($sprintSet, 0, -2);
		$sqlSet = substr($sqlSet, 0, -3);
		$formHandler .= $columnSet.") VALUES (".$sprintSet.")\",\r\n".$sqlSet.");\r\n\r\n";
		$formHandler .= tab(1)."mysql_select_db(\$database_ikiosk, \$ikiosk)\r\n";
		$formHandler .= tab(1)."\$Result1 = mysql_query(\$insertSQL, \$ikiosk) or sqlError(mysql_error());\r\n";
		$formHandler .= tab(1)."sqlQueryLog(\$insertSQL);\r\n";
		$formHandler .= tab(1)."insertJS(\$refresh);\r\n";
		$formHandler .= tab(1)."exit;\r\n";	
		$formHandler .= "}\r\n\r\n";
		$formHandler .= "// ".$_POST['module_title'].": Edit -------------------------------------------\r\n";
		
		mysql_select_db($database_ikiosk, $ikiosk);
		$query_showColumns = "SHOW COLUMNS FROM ".$_POST['query_table']."";
		$showColumns = mysql_query($query_showColumns, $ikiosk) or sqlError(mysql_error());
		$row_showColumns = mysql_fetch_assoc($showColumns);
		$totalRows_showColumns = mysql_num_rows($showColumns);
		
		$sqlSet = "";
		$columnSet = "";
		$formHandler .= "\r\nif ((isset(\$_POST[\"formID\"])) && (\$_POST[\"formID\"] == \"edit-".$appID."\")) {\r\n";
		$formHandler .= tab(1)."\$updateSQL = sprintf(\"UPDATE ".$_POST['query_table']." SET \r\n";
		do {
				$fieldDisplay = "\$_POST['".$row_showColumns['Field']."']";
				if ($row_showColumns['Field'] == "date_modified") { $fieldDisplay = "\$SYSTEM['mysql_datetime']";}
				if ($row_showColumns['Field'] == "modified_by") { $fieldDisplay = "\$_SESSION['user_id']";}
				if (($row_showColumns['Field'] != "deleted") 
						&& ($row_showColumns['Field'] != "created_by") 
						&& ($row_showColumns['Field'] != "date_created") 
						&& ($row_showColumns['Field'] != $_POST['primary_key']) 
						&& ($row_showColumns['Field'] != "team_id")) {
							
							$columnSet .= "`".$row_showColumns['Field']."`=%s, ";
							$sqlSet .= tab(2)."GetSQLValueString(".$fieldDisplay.", \"text\"),\r\n";
						}
		} while ($row_showColumns = mysql_fetch_assoc($showColumns));
		$columnSet = substr($columnSet, 0, -2);
		$sqlSet .= tab(2)."GetSQLValueString(\$_POST['".$_POST['primary_key']."'], \"text\"),\r\n";
		$sqlSet = substr($sqlSet, 0, -3);	
		$queryPrefix = $_POST['query_table'];
		
		$formHandler .= $columnSet." WHERE ".$_POST['primary_key']."=%s\",\r\n".$sqlSet.");\r\n\r\n";
		$formHandler .= tab(1)."mysql_select_db(\$database_ikiosk, \$ikiosk);\r\n";
		$formHandler .= tab(1)."\$Result1 = mysql_query(\$updateSQL, \$ikiosk) or sqlError(mysql_error());\r\n";
		$formHandler .= tab(1)."sqlQueryLog(\$updateSQL);\r\n\r\n";
		$formHandler .= tab(1)."displayAlert(\"success\", \"Changes saved.\");\r\n";
		$formHandler .= tab(1)."}\r\n";

		$formHandler = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", htmlentities($formHandler));

		$response = str_replace('{FORMHANDLER}', $formHandler, $response);		
		
		echo $response;
		
		$js = "$('#codeResponse').hide().html('').fadeIn(); ";
		//$js .= "$('.jarviswidget-toggle-btn').click(); ";
		$js .= "$('#codeBlock').appendTo('#codeResponse'); ";
		$js .= "prettyPrint(); ";
		insertJS($js);
		exit;
	}
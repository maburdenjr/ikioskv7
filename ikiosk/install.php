<?php
/* iKiosk 7.0 Tiger */
$PAGE['application_code'] = "INSTALL";
$PAGE['title'] = "IntelliKiosk v7.0 Installation";
require('includes/core/ikiosk.php');
if(isset($database_ikiosk)) {
		header("Location: index.php");
		exit;
}

if ((isset($_POST["iKioskForm"])) && ($_POST["iKioskForm"] == "Yes")) {
	
	//Check Database Configuration
	$hostname_ikiosk = $_POST['db_host'];
	$database_ikiosk = $_POST['db_name'];
	$username_ikiosk = $_POST['db_user'];
	$password_ikiosk = $_POST['db_password'];
	$ikiosk = mysql_pconnect($hostname_ikiosk, $username_ikiosk, $password_ikiosk); 
	
	if (!$ikiosk) { //Connection Failed
		$msgType = "error";
		$msgContent = "Unable to connect to database.  Please check your settings and try again.";
	} else {
		
		//Create DB and New User
		
		//Create DB Connection File
		$dbConn = $_POST['ikiosk_filesystem_root']."/ikiosk/includes/core/db_conn.php";
		$dbConnFile = "<?php\r\n"; 
		$dbConnFile .= "//Database Connection\r\n\r\n";
		$dbConnFile .= "\$hostname_ikiosk = \"".$_POST['db_host']."\";\r\n";
		$dbConnFile .= "\$database_ikiosk = \"".$_POST['db_name']."\";\r\n";
		$dbConnFile .= "\$username_ikiosk = \"".$_POST['db_user']."\";\r\n";
		$dbConnFile .= "\$password_ikiosk = \"".$_POST['db_password']."\";\r\n";
		$dbConnFile .= "\$ikiosk = mysql_pconnect(\$hostname_ikiosk, \$username_ikiosk, \$password_ikiosk) or trigger_error(mysql_error(),E_USER_ERROR);\r\n"; 
		$dbConnFile .= "// FileSystem Configuration\r\n\r\n";
		$dbConnFile .= "\$systemRoot = \"/ikiosk\";\r\n";
		$dbConnFile .= "\$systemFileRoot = \"".$_POST['ikiosk_filesystem_root']."\";\r\n";
		$dbConnFile .= "?>";
		
		$fh = fopen($dbConn, 'w') or errorAlert("Unable to create iKiosk Configuration File.");
		fwrite($fh, $dbConnFile);
		fclose($fh);
		
		header("Location: login.php");
		exit;
		
	}
}

renderUIHeader(); //Renders UI Header

if ($_SESSION['is_mobile'] == "True") { // Mobile UI
?>
<div data-role="page" id="install">
	<div data-role="header" data-position="fixed" data-theme="b">
  	<h1><span class="med">iKiosk</span> <span class="strong">7.0</span> Install</h1>
  </div>
  <div role="main" class="ui-content">
  	<?php messageHandler($msgType, $msgContent); ?>
  	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    	<ul data-role="listview" data-inset="true">
      	 <li data-role="list-divider" data-theme="b">User Information</li>
      	 <li data-role="fieldcontain">
         	<label for="user_email">Email Address:</label>
           <input type="email" name="user_email" id="user_email" value="<?php echo $_POST['user_email']; ?>" data-clear-btn="true" class="required email">
        </li>
        <li data-role="fieldcontain">
         	<label for="user_password">Password:</label>
           <input type="password" name="user_password" id="user_password" value="" data-clear-btn="true" class="required" minlength="5">
        </li>
        <li data-role="list-divider" data-theme="b">System Information</li>
        <li data-role="fieldcontain">
        		<label for="system_name">System Name:</label>
           <input type="text" name="system_name" id="system_name" data-clear-btn="true" class="required" value="<?php echo $_POST['system_name']; ?>">
        </li>
        <li data-role="fieldcontain">
        		<label for="ikiosk_filesystem_root">Document Root:</label>
           <input type="text" name="ikiosk_filesystem_root" id="ikiosk_filesystem_root" value="<?php echo $_SERVER['DOCUMENT_ROOT']; ?>" data-clear-btn="true" class="required">
        </li>
         <li data-role="list-divider" data-theme="b">Database Configuration</li>

        <li data-role="fieldcontain">
        		<label for="db_host">Database Server:</label>
           <input type="text" name="db_host" id="db_host" data-clear-btn="true" class="required" value="<?php echo $_POST['db_host']; ?>">
        </li>
        <li data-role="fieldcontain">
        		<label for="db_name">Database Name:</label>
           <input type="text" name="db_name" id="db_name" data-clear-btn="true" class="required" value="<?php echo $_POST['db_name']; ?>">
        </li>
        <li data-role="fieldcontain">
        		<label for="db_user">Database User:</label>
           <input type="text" name="db_user" id="db_user" data-clear-btn="true" class="required" value="<?php echo $_POST['db_user']; ?>">
        </li>
        <li data-role="fieldcontain">
        		<label for="db_password">Database Password:</label>
           <input type="text" name="db_password" id="db_password" data-clear-btn="true" class="required" value="<?php echo $_POST['db_password']; ?>">
        </li>
        <li>
        		<button type="submit" data-inline='true' class="btn-primary"><i class='lIcon fa fa-check'></i>Install</button>
           <input type="hidden" name="iKioskForm" value="Yes" />    
        </li>
      </ul>
    </form>
  </div>
</div>
<?php } else { // Desktop UI?>

<?php }  
renderUIFooter(); //Renders UI Footer 
?>
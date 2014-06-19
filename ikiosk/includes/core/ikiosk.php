<?php
//Start Sessions
ob_start();
session_start();

//Default System Variables
$SYSTEM = array();
$SITE = array();
$USER = array(); 
$APPLICATION = array();

//Load Core Functions
if (file_exists($_SERVER['DOCUMENT_ROOT']."/ikiosk/includes/core/db_conn.php")) {
	require('db_conn.php');
}
require('corefunctions.php'); 

//Redirect to Installation Script
if (!isset($database_ikiosk) && $PAGE['application_code'] != "INSTALL") {
	header("Location: install.php");
	exit;
} else {
	
//Initialize Users and Applications
}
?>
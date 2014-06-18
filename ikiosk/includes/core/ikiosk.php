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
require('corefunctions.php'); 

//Redirect to Installation Script
if (!isset($database_ikiosk) && $PAGE['application_code'] != "INSTALL") {
	header("Location: install.php");
	exit;
} else {
	
//Initialize Users and Applications
}
?>
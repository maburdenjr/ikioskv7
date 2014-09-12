<?php
/* iKiosk 7.0 Tiger */
$PAGE['application_code'] = "IKIOSK";
require('ikiosk-tmp-core'); // Load iKiosk Core Files
session_destroy();
header("Location: /index.html"); 
?>


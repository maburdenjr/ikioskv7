<?php

//if (session_id() == '')
//    session_start();
if (!empty($SYSTEM['ikiosk_docroot'])) {
require_once($SYSTEM['ikiosk_docroot']."/smartui/lib/config.php");
} else {
require_once('lib/config.php');	
}

?>
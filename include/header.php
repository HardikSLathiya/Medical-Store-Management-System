<?php
	session_start();
	if ($_SESSION['role']=='admin') {
		include("include/header_admin.php");
	}
	if ($_SESSION['role']=='recep') {
		include("include/header_recep.php");		
	}
?>
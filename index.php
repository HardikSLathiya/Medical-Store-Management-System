<?php 
	require 'login.php';
	if(isset($_SESSION["username"])){
		header("Location: home.php");
	}
 ?>
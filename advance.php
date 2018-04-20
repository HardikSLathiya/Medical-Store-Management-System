<?php
	include("include/header.php");

	//session_start();
	if(!isset($_SESSION["username"])){
		header("Location: login.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Advance</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<style type="text/css">
		#advance{
			background-color: #fff;
			color: #333;
		}
	</style>
</head>
<body>
<div class="container">
	<table border="0">
		<tr>
			<td class="card" onclick="window.location.href='advance_employee.php'">
				<img src="res/employee.png" alt="EMPLOYEE" style="width:40%">
				<br/>				
				<h4>EMPLOYEE</h4>			
			</td>

			<!-- <td class="card" onclick="window.location.href='advance_suppliers.php'">
				<img src="res/supplier.png" alt="SUPPLIER" style="width:40%">
				<br/>
				<h4>SUPPLIER</h4>			
			</td>
 -->
			<td class="card" onclick="window.location.href='advance_users.php'">
				<img src="res/users.png" alt="SUPPLIER" style="width:40%">
				<br/>
				<h4>USERS</h4>			
			</td>
	</table>
</div>
</body>
</html>
<?php
	include("include/header.php");	
	//session_start();
	if(!isset($_SESSION["username"])){
		header("Location: login.php");
	}
	$plink = "'med_purchase.php'";
	$purchase = '<td class="card" onclick="window.location.href='.$plink.'">
				<img src="res/purchase.png" alt="PURCHASE" style="width:40%">
				<br/>
				<h4>PURCHASE</h4>			
				</td>';
?>

<!DOCTYPE html>
<html>
<head>
	<title>home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<style type="text/css">
		#home{
			background-color: #fff;
			color: #333;
		}		
	</style>
</head>
<body>
<div class="container">
	<table border="0">
		<tr>
			<td class="card" onclick="window.location.href='med_sell.php'">
				<img src="res/sell.png" alt="SELL" style="width:40%">
				<br/>				
				<h4>SELL</h4>
			</td>

			<?php  if ($_SESSION['role'] == 'admin') {
				echo $purchase;
			} ?>
			
			<td class="card" onclick="window.location.href='med_search.php'">
				<img src="res/search.png" alt="SEARCH" style="width:40%">
				<br/>
				<h4>SEARCH</b></h4>		
			</td>			
			<td class="card" onclick="window.location.href='med_bill.php'">
				<img src="res/bill.png" alt="BILLS" style="width:40%">	
				<br/>			
				<h4><b>VIEW BILLS</b></h4>
			</td>		
		</tr>	
	</table>
</div>
</body>
</html>
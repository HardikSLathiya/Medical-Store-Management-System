<?php
	include("include/header.php");

	//session_start();
	include 'config.php';	
	if(!isset($_SESSION["username"])){
		header("Location: login.php");
	}

if(isset($_POST['sbtn'])){		

		$phname = $_POST['phname'];
		$sname  = $_POST['sname'];
		$phone  = $_POST['phone'];
		$address= $_POST['address'];
			
	try{
		$conn = new PDO("mysql:host=$dbhost;dbname=$db",$dbuser, $dbpass) or die(mysql_error());
		$sql = "INSERT INTO supplier(phname,sname,phone,address) VALUES(:phname,:sname,:phone,:address)";
		$stmt = $conn->prepare($sql);				         
	            $stmt->bindParam(':phname', $phname);
	            $stmt->bindParam(':sname', $sname);
	            $stmt->bindParam(':phone', $phone);
	            $stmt->bindParam(':address', $address);

		if ($stmt->execute() === TRUE) {
	            $result = $stmt->rowCount();
				$msg= "<script type='text/javascript'>alert(Successfully Add".$result."Row(s))</script>";
	            echo $msg;
	              
	    } else {
	               echo "<script type='text/javascript'>alert('failed!')</script>";
	    }
	   	    
	}
	catch(Exception $e)
	{
	    echo "Error: " . $e->getMessage();
	}	
}
?>



<!DOCTYPE html>
<html>
<head>
	<title>Suppliers</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<style type="text/css">
		#advance{
			background-color: #fff;
			color: #333;
		}
	</style>
</head>
<body>
<form id="form" action="" method="POST">	
	<div class="form_input_table">
	<fieldset>
    <legend>SUPPLIER</legend>
	<table border="0" cellspacing="5">	
		<tr>
			<td><label for="pname">Pharma Co.</label></td>
			<td><input type="text" name="phname" maxlength="30" size="30" required></td>
		</tr>
		<tr>
			<td><label for="sname">Supplier Name</label></td>
			<td><input type="text" name="sname" maxlength="30" size="30" required></td>
		</tr>
		<tr>
			<td><label for="phone">Phone</label></td>
			<td><input type="number" name="phone" size="12" maxlength="10" required></td>
		</tr>
		<tr>
			<td><label for="address">Address</label></td>
			<td><input type="text"  name="address" size="50" maxlength="255" required></td>
		</tr>		
		<tr>
			<td></td>
			<td colspan="1"><input type="submit" id="btn" name="sbtn" value="SUBMIT"/>
			<input type="reset" id="btn" name="sbtn" value="RESET"/></td>
		</tr>
	</table>
</fieldset>
</div>
</form>
</body>
</html>
<?php
	include("include/header.php");
	include 'config.php';
	$mname='';
	$sp='';
	//session_start();
	if(!isset($_SESSION["username"])){
			header("Location: login.php");
	}	
	
	if(isset($_POST['sbtn'])){

		$mname = $_POST['mname'];
		$exdate = $_POST['exdate'];
		$chamt = $_POST['chamt'];
		$qty = $_POST['qty'];
		$cp = $_POST['cp'];
		$sp = $_POST['sp'];
		$c1 = $_POST['c1'];
		$pname = $_POST['pname'];
		$c2='-';
		$c3='-';
		$notes='-';	
		if(isset($_POST['c2'])){$c2 = $_POST['c2'];}
		if(isset($_POST['c3'])){$c3 = $_POST['c3'];}	
		if(isset($_POST['notes'])){$notes = $_POST['notes'];}
		
		try{
			$conn = new PDO("mysql:host=$dbhost;dbname=$db",$dbuser, $dbpass) or die(mysql_error());
			$sql = "INSERT INTO medicine(mname,exdate,chamt,qty,cp,sp,c1,c2,c3,pname,notes) VALUES(:mname,:exdate,:chamt,:qty,:cp,:sp,:c1,:c2,:c3,:pname,:notes)";	
			$stmt = $conn->prepare($sql);          
		            $stmt->bindParam(':mname', $mname);
		            $stmt->bindParam(':exdate', $exdate);
		            $stmt->bindParam(':chamt', $chamt);
		            $stmt->bindParam(':qty', $qty);
		            $stmt->bindParam(':cp', $cp);
		            $stmt->bindParam(':sp', $sp);
		            $stmt->bindParam(':c1', $c1);
		            $stmt->bindParam(':c2', $c2);
		            $stmt->bindParam(':c3', $c3);
		            $stmt->bindParam(':pname', $pname);
		            $stmt->bindParam(':notes', $notes);
		    $stmt->execute();		   
			$result = $stmt->rowCount();
		  	if ($result >= 1) {
		  		$msg = "<script type='text/javascript'>alert('SucsessFully Inserted')</script>";
				echo $msg;
		  	} else {
		        echo "<script type='text/javascript'>alert('failed! Medicine May be alredy Exist ')</script>";
		    }
		}
		catch(PDOException $e)
		{
		    echo "Error: " . $e->getMessage();
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Purchase</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<style type="text/css">
		#purchase{
			background-color: #fff;
			color: #333;
		}
	</style>
</head>
<body>
<form id="form" action="" method="POST">	
	<div class="form_input_table">
	<fieldset>
    <legend>MEDICINE PURCHASE</legend>
		<table border="0" cellspacing="5" style="background-color: #59202020;border: 1px solid black;border-radius: 5px;">
			
			<tr><td colspan="4" id="uderline"></td></tr>

			<tr>
				<td><label for="name">Medicine Name</label></td>
				<td><input type="text" name="mname" placeholder="Medicine Name" required/></td> 
				<td><label for="expirydate">Expiry Date(MM-YYYY)</label></td>
				<td><input type="text" name="exdate" pattern="[0-9][0-9][-][0-9][0-9][0-9][0-9]" placeholder="Expiration Date" required/></td>
			</tr>

			<tr><td colspan="4" id="uderline"></td></tr>

			<tr>				
				<td><label for="chemamt">Chemical Amount</label></td>
				<td><input type="text" name="chamt" placeholder="Chemical Quantity in mg" required/></td>
				<td><label for="qty" >Quantity</label></td>
				<td><input type="number" name="qty" pattern="[0-9]+" placeholder="Quantity" required/></td>				
			</tr>

			<tr><td colspan="4" id="uderline"></td></tr>

			<tr>
				<td><label for="cp">Cost Price</label></td>
				<td><input type="decimal" name="cp"  placeholder="Cost Price" required/></td>
				<td><label for="sp">Selling Price</label></td>
				<td><input type="decimal" name="sp"  placeholder="Selling Price" required/></td>				
			</tr>

			<tr><td colspan="4" id="uderline"></td></tr>

			<tr>
				<td colspan="1"><label for="c1">Compound 1</label></td>
				<td colspan="3"><input type="text" name="c1" placeholder="Compound in Medicine" required/></td>
			</tr>
			<tr>
				<td colspan="1"><label for="c2">Compound 2</label></td>
				<td colspan="3"><input type="text" name="c2" placeholder="Compound in Medicine Optional" /></td>
			</tr>
			<tr>
				<td colspan="1"><label for="c3">Compound 3</label></td>
				<td colspan="3"><input type="text" name="c3" placeholder="Compound in Medicine Optional" /></td>
			</tr>

			<tr>
				<td colspan="1"><label for="pname">Pharma Co.</label></td>
				<td colspan="3"><input type="text" name="pname" placeholder="Pharmasutical Name" required></td>
			</tr>
			<tr>
				<td colspan="1"><label for="notes">Notes</label></td>
				<td colspan="3"><input type="text" name="notes" placeholder="Remarks/Notes/Description Optional" /></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="1"><input type="submit" id="btn" name="sbtn" value="SUBMIT"/></td>
				<td colspan="1"><input type="reset" id="btn" name="rbtn" value="RESET"/></td>
				<td colspan="1"><input type="reset" id="btn" name="ubtn" value="MODIFY" onclick="window.location.href='purchase_update.php'" /></td>				
			</tr>
		</table>
	</fieldset>		
	</div>	
</form>
</body>
</html>

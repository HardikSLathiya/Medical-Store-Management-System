<?php
	include("include/header.php");
	//session_start();
	require_once 'config.php';
	if(!isset($_SESSION["username"])){
		header("Location: login.php");
	}

	$mname = '';	
	$exdate = '';
	$chamt = '';
	$qty = '';
	$cp = '';
	$sp = '';
	$c1 = '';	
	$c2 ='';
	$c3 ='';
	$notes ='';
	$pname ='';

	if (isset($_POST['sbtn'])) {
		$mname = $_POST['mname'];
		try{
			$conn = new PDO("mysql:host=$dbhost;dbname=$db",$dbuser, $dbpass) or die(mysql_error());
			$select =$conn->prepare("SELECT * FROM medicine WHERE mname = '$mname'");
			$select->execute();
			$res = $select->fetch();

			$exdate = $res['exdate'];
			$chamt = $res['chamt'];
			$qty = $res['qty'];
			$cp = $res['cp'];
			$sp = $res['sp'];
			$c1 = $res['c1'];	
			$c2 = $res['c2'];
			$c3 = $res['c3'];
			$notes = $res['notes'];
			$pname =$res['pname'];

			}catch(PDOException $e){
	  		echo "Error: " . $e->getMessage();
	  	}
	}

	
	$result=0;
	if(isset($_POST['ubtn'])){
		$mname = $_POST['mname'];
		$exdate = $_POST['exdate'];
		$chamt = $_POST['chamt'];
		$qty = $_POST['qty'];
		$cp = $_POST['cp'];
		$sp = $_POST['sp'];
		$c1 = $_POST['c1'];	
		$c2 = $_POST['c2'];
		$c3 = $_POST['c3'];
		$notes = $_POST['notes'];
		$pname =$_POST['pname'];		
		try{
			$conn = new PDO("mysql:host=$dbhost;dbname=$db",$dbuser, $dbpass) or die(mysql_error());
			$select =$conn->prepare("SELECT qty FROM medicine WHERE mname = '$mname'");
			$select->execute();
			$QTY = $select->fetch();
			$qty = $QTY['qty'];

			$sqlUpdate = "UPDATE medicine SET
							mname = '$mname',
							exdate = '$exdate',
							chamt = '$chamt',
							qty = '$qty',
							cp = '$cp',
							sp = '$sp',
							c1 = '$c1',
							c2 = '$c2',
							c3 = '$c3',
							pname = '$pname',
							notes = '$notes' 
							WHERE mname = '$mname'";

			$update = $conn->prepare($sqlUpdate);
		  	$update->execute();
		  	$result = $update->rowCount(); 
		  	if ($result >= 1) {
		  		$msg = "<script type='text/javascript'>alert('SucsessFull Update')</script>";
				echo $msg;
		  	}
		  
	  	}catch(PDOException $e){
	  		echo "Error: " . $e->getMessage();
	  	}
 	} 

 		

 	if (isset($_POST['dbtn'])) {
 		$mname = $_POST['mname'];
 		try {
 			$conn = new PDO("mysql:host=$dbhost;dbname=$db",$dbuser, $dbpass) or die(mysql_error());
 			$delete =$conn->prepare("DELETE FROM medicine WHERE mname = '$mname'");
			$delete->execute();
			$result = $delete->rowCount();
			if ($result >= 1) {
		  		$msg = "<script type='text/javascript'>alert('SucsessFull Update')</script>";
				echo $msg;
		  	}		
 		} catch (PDOException $e) {
 			echo "Error: " . $e->getMessage();
 		}
 	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Update Medicine</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
    <legend>UPDATE MEDICINE</legend>
    <table border="0" cellspacing="5">

			<tr>
				<td><label for="name">Medicine Name</label></td>
				<td><input type="text" name="mname" placeholder="Enter Medicine Name " value="<?php echo $mname; ?>" style="width: 70%" required/>&nbsp;<input type="submit" name="sbtn" id="btn" value="GO" style="width: 20%"></td> 
				<td><label for="expirydate">Expiry Date(MM-YYYY)</label></td>
				<td><input type="text" name="exdate" value="<?php echo $exdate; ?>" pattern="[0-9][0-9][-][0-9][0-9][0-9][0-9]" /></td>
			</tr>

			<tr><td colspan="4" id="uderline"></td></tr>

			<tr>				
				<td><label for="chemamt">Chemical Amount</label></td>
				<td><input type="text" name="chamt"  value="<?php echo $chamt; ?>" /></td>
				<td><label for="qty" >Quantity</label></td>
				<td><input type="number" name="qty" pattern="[0-9]+"  value="<?php echo $qty; ?>" /></td>				
			</tr>

			<tr><td colspan="4" id="uderline"></td></tr>

			<tr>
				<td><label for="cp">Cost Price</label></td>
				<td><input type="decimal" name="cp" value="<?php echo $cp; ?>" /></td>
				<td><label for="sp">Selling Price</label></td>
				<td><input type="decimal" name="sp" value="<?php echo $sp; ?>" /></td>				
			</tr>

			<tr><td colspan="4" id="uderline"></td></tr>

			<tr>
				<td colspan="1"><label for="c1">Compound 1</label></td>
				<td colspan="3"><input type="text" name="c1"  value="<?php echo $c1; ?>" /></td>
			</tr>
			<tr>
				<td colspan="1"><label for="c2">Compound 2</label></td>
				<td colspan="3"><input type="text" name="c2"  value="<?php echo $c2; ?>" /></td>
			</tr>
			<tr>
				<td colspan="1"><label for="c3">Compound 3</label></td>
				<td colspan="3"><input type="text" name="c3"  value="<?php echo $c3; ?>" /></td>
			</tr>

			<tr>
				<td colspan="1"><label for="pname">Pharma Co.</label></td>
				<td colspan="3"><input type="text" name="pname"  value="<?php echo $pname; ?>" /></td>
			</tr>
			<tr>
				<td colspan="1"><label for="notes">Notes</label></td>
				<td colspan="3"><input type="text" name="notes"  value="<?php echo $notes; ?>" /></td>
			</tr>
			<tr>
				<td></td>
				<td colspan="1"><input type="submit" id="btn" name="ubtn"  value="UPDATE"/></td>
				<td colspan="1"><input type="submit" id="btn" name="dbtn"  value="DELETE"/></td>
			</tr>
		</table>
    <?php
    	if(!$result){    	
		  		$msg = "<script type='text/javascript'>alert('Failed Update')</script>";
				echo $msg;
		  	}
    ?>
	</fieldset>
	</div>
</form>
</body>
</html>

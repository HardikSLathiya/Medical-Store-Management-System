<?php
	include("include/header.php");

	//session_start();
	include 'config.php';
	if(!isset($_SESSION["username"])){
		header("Location: login.php");
	}

	try{
		$conn = new PDO("mysql:host=$dbhost;dbname=$db",$dbuser, $dbpass) or die(mysql_error());
	}catch(Exception $e){
		echo "Error: " . $e->getMessage();
	}
	if(isset($_POST['sbtn'])){	
		$id=null;
		$name  =$_POST['name'];
		$phone =$_POST['phone'];
		$address =$_POST['address'];
		$salary =$_POST['salary'];		
	try{
		$sql = "INSERT INTO employee(empid,name,phone,address,salary) VALUES(:empid,:name,:phone,:address,:salary)";	
		$stmt = $conn->prepare($sql);
				$stmt->bindParam(':empid', $id);          
	            $stmt->bindParam(':name', $name);
	            $stmt->bindParam(':phone', $phone);
	            $stmt->bindParam(':address', $address);
	            $stmt->bindParam(':salary', $salary);
	    $stmt->execute();
	    $result = $stmt->rowCount();
		if ($result) {				
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
	$print = '';
	if (isset($_POST['vbtn'])) {
		try{	
			$sql = "SELECT * FROM employee";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
		    if($stmt->rowCount()){
		    $print .= '<table border="1" id="user" cellspacing="0" style="
						border:1px solid #333;
						font-family:sans-serif;
						color:#000;
						background-color:#fff;">
                        <tr style="color: #fff;background-color: #333;font-size: 18px;">
			    		<th>Emp_id</th>
			    		<th>Name</th>
			    		<th>Phone</th>
			    		<th>Address</th>
			    		<th>Salary</th>
			    		<th>DELETE</th>		    		
			    		</tr>';
				while ($array = $stmt->fetch()) {
					$print .= '<tr><td>';
					$print .= $array['empid'].'</td><td>';
			    	$print .= $array['name'].'</td><td>';
			    	$print .= $array['phone'].'</td><td>';
			    	$print .= $array['address'].'</td><td>';
			    	$print .= $array['salary'].'</td>
			    	<td><a href="advance_employee.php?deleteUID='.$array['empid'].'">delete</a></td>';		    			    	
				}
	    	$print .= '</tr></table>';
	    	}			
		}
	    catch(Exception $e)
		{
		    echo "Error: " . $e->getMessage();
		}
	}

	if (isset($_GET['deleteUID'])) {
		$uid = $_GET['deleteUID'];
		$sql = "DELETE FROM employee WHERE empid =".$uid;	
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->rowCount();
		  	if ($result >= 1) {
		  		$msg = "<script type='text/javascript'>alert('DELETED SucsessFully)</script>";
				echo $msg;
		  	}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Employee</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<style type="text/css">
		#advance{
			background-color: #fff;
			color: #333;
		}
	</style>
</head>
<body>
<div class="form_input_table">
<fieldset>
<legend>EMPLOYEE</legend>
<form id="form1"  action="" method="POST">	
	<table style="border : 1px solid black;border-radius: 5px;background-color: #59202020 ;"border="0" cellspacing="5">		
		<tr>
			<td><label for="name">Name</label></td>
			<td><input type="text" name="name" maxlength="15" size="15" required></td>
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
			<td><label for="salary">Salary</label></td>
			<td><input type="number" name="salary" size="8" maxlength="8" required></td>
		</tr>
		<tr>
			<td></td>
			<td colspan="1"><input type="submit" id="btn" name="sbtn" value="SUBMIT"/>
			<input type="reset" id="btn" name="sbtn" value="RESET"/></td>
		</tr>
	</table>
	</form>
	<form id="form2"  action="" method="POST"><br><input type="submit" id="btn" name="vbtn" value="VIEW EMPLOYEE"/>
	</form><br>
	<?php echo $print ?>
</fieldset>
</div>
</body>
</html>
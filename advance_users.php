<?php
	include("include/header.php");
	//session_start();
	include 'config.php';
	if(!isset($_SESSION["username"])){
		header("Location: login.php");
	}
	$print = '';
	try{
		$conn = new PDO("mysql:host=$dbhost;dbname=$db",$dbuser, $dbpass) or die(mysql_error());
		$sql = "SELECT * FROM users";	
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->rowCount();
		$print .= '<table border="1" id="user" cellspacing="0" style="
						border:1px solid #333;
						font-family:sans-serif;
						color:#000;
						background-color:#fff;">
                        <tr style="color: #fff;background-color: #333;font-size: 18px;">
			    		<th>UserID</th>
			    		<th>Username</th>
			    		<th>Role</th>
			    		<th>Delete</th>			    		
			    		</tr>';
			while ($array = $stmt->fetch()) {
				$print .= '<tr><td>';
				$print .= $array['id'].'</td><td>';
		    	$print .= $array['username'].'</td><td>';
		    	$print .= $array['role'].'</td>
		    	<td><a href="advance_users.php?deleteUID='.$array['id'].'">delete</a></td>';		    	
		    }
	    	$print .= '</tr></table>';	 
	   	    
	}
	catch(Exception $e)
	{
	     echo "Error: " . $e->getMessage();
	}	

	if (isset($_POST['abtn'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$role = $_POST['role'];
		try{
			$sql = "INSERT INTO users VALUES('','".$username."','".$password."','".$role."')";	
			$stmt = $conn->prepare($sql);
			$result = $stmt->execute();
			// echo $result;
		}
		catch(Exception $e)
		{
		     echo "Error: " . $e->getMessage();
		}

	}
	if (isset($_GET['deleteUID'])) {
		$uid = $_GET['deleteUID'];
		$sql = "DELETE FROM users WHERE id =".$uid;	
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
	<title>Users</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<style type="text/css">
		#advance{
			background-color: #fff;
			color: #333;
		}
	</style>
	<script type="text/javascript">
		function varify() {
			var pass = document.getElementById('pass').value;
			var repass = document.getElementById('repass').value;
			if (pass != repass) {
				confirm("Password Does Not Match");
				return false;
			}
			else{
				return true;
			}
		}
	</script>
</head>
<body>
<form id="form"  action="" method="POST"  onsubmit="varify()">	
	<div class="form_input_table">
		<fieldset>
			<legend>USERS</legend>
			<div>
				<?php  echo $print;?>
			</div><hr>
			<div style="padding: 15px 30px;width: 30%;text-align: left;border: 1px solid black;border-radius: 5px;background-color: #59202020">

				<p>
					<select id="select" name="role" required>							
						<option value="recep">Receptionist</option>
						<option value="admin">Admin</option>
					</select>					
				</p>
				<p><input type="text" name="username"  placeholder="Username" required autofocus></p>
				<p><input id="pass" type="password" name="password"  placeholder="Password" required></p>
				<p><input id="repass" type="password" name="repassword"  placeholder="Confirm-Password" required></p>
				<input type="submit" id="btn" name="abtn" value="ADD"></p>
			</div>
		</fieldset>
	</div>
</form>
</body>
</html>

<script type="text/javascript">
	table = document.getElementById('user');
</script>
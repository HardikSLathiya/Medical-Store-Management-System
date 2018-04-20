<?php
$error ='';
session_start();
?>
<!DOCTYPE html>
<html>
<head> 
	<meta http-equiv="Cache-Control" content="no-store" />	
  	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Login</title>
	<script type="text/javascript">
		function showpass() {
			var cbox = document.getElementById('show');
			var pass = document.getElementById('pass');
			if(cbox.checked == true){
				pass.type = "text";
			}
			else{
				pass.type = "password";
			}

		}
	</script>
</head>
<body bgcolor="#e7e6e6">
<div class="login_card">
	<p>
	<h1 align="center" style="color:#f3827c">MED<span  style="color:#8baba8">SHOP</span></h1>	
	<h2 align="center" style="color:#353839">LOG IN</h2>
	</p>
	<form action=" " method="POST"  id="form">
		<p><select id="select" name="role">				
				<option value="recep">Receptionist</option>
				<option value="admin">Admin</option>
			</select>
		</p>
  		<p><input type="text" class="input" name="username"  placeholder="Username" required autofocus></p>  			
  		<p><input id="pass" type="password" class="input" name="password" id="pass" placeholder="Password" required></p>

  		<p align="left" style="font-size: 15px;"><input type="checkbox" id="show" onchange="showpass()" >Show Password</p>	

		<p><input type="submit" id="btn" name="lbtn" value="LOGIN" ></p>
		<span><?php echo $error; ?></span>
	</form>	
</div>
</body>
</html>

<?php
require_once 'config.php';
	if(isset($_POST['lbtn'])){
		$username = $_POST['username'];		
		$password = $_POST['password'];
		$role = $_POST['role'];
		try{			
			$conn = new PDO("mysql:host=$dbhost;dbname=$db",$dbuser, $dbpass) or die(mysql_error());
			$stmt = $conn->prepare("select * from users where username='$username' and password='$password' and role = '$role'");
		  	$stmt->execute();		  
			if($stmt->rowCount()){
				$_SESSION["username"] = $username;
				$_SESSION["role"] = $role;
				header("Location: home.php");
			} 
			else{
				$error = "please enter correct credentials";
			}
		}catch(PDOException $e){
			$msg = '<script type="text/javascript"> alert("Error: Can Not Connect To Database");</script>';
			echo($msg);
		}
	}
?>
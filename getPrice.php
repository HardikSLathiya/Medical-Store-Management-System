<?php
	require_once 'config.php';
	if(isset($_GET['mname'])){
		$mname = $_GET['mname'];
		try{
			$conn = new PDO("mysql:host=$dbhost;dbname=$db",$dbuser, $dbpass) or die(mysql_error());
			$select =$conn->prepare("SELECT sp FROM medicine WHERE mname = '$mname'");
			$select->execute();
			$res = $select->fetch();
			echo $res['sp'];
		}catch(PDOException $e){
	  		echo "Error: " . $e->getMessage();
	  	}
	}
?>

<?php
	include("include/header.php");
	require_once 'config.php';
	//session_start();
	if(!isset($_SESSION["username"])){
		header("Location: login.php");
	}

	$result=0;
	$searchResult='';
	$error='';

	if(isset($_POST['sbtn'])){
		$mname = $_POST['search'];
		$searchResult = $mname;
		if (!empty($mname)) {		
		try{
			$conn = new PDO("mysql:host=$dbhost;dbname=$db",$dbuser, $dbpass) or die(mysql_error());
			$stmt = $conn->prepare("select * from medicine where mname LIKE '%".$mname."%' or c1  LIKE '%".$mname."%' or c2  LIKE '%".$mname."%' or c3  LIKE '%".$mname."%'");
		  	$stmt->execute();
		  	$result = $stmt->rowCount();
		  	if (!$result) {
		  		$error = "No Result Found";
		  	}		  	
	  	}catch(PDOException $e){
	  		echo "Error: " . $e->getMessage();
	  	}
	  }
	  else{
	  	$error = "No Result Found";
	  } 
 	} 

 	if(isset($_POST['btn'])){
 		$searchResult = 'All';
 		try{	
			$conn = new PDO("mysql:host=$dbhost;dbname=$db",$dbuser, $dbpass) or die(mysql_error());
			$stmt = $conn->prepare("select * from medicine");
		  	$stmt->execute();
		  	$result = $stmt->rowCount();
	  	}catch(PDOException $e){
	  		$msg = 	'<script type="text/javascript"> alert("Error: Can Not Connect To Database");</script>';	
			echo($msg);
	  	}	  	
 	} 

?>

<!DOCTYPE html>
<html>
<head>
	<title>Search</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<style type="text/css">
		#search{
			background-color: #fff;
			color: #333;
		}
		.form_input_table table td{
			padding: 0;
		}
	</style>
</head>
<body>
<form id="form" action="" method="POST">	
	<div class="form_input_table">
	<fieldset>
    <legend>MEDICINE SEARCH</legend>
    <table border="0" width="50%" cellspacing="0" cellpadding="0">
    	<tr>
    		<td>
    			<input type="text" placeholder="Search Mdicine Name,Compound..." name="search" autofocus 
    			style="
    			border-radius: 0;
    			width: 100%;
    			height: 28px;    			
    			border-right-style: none;">	    		
	    	</td>
	    	<td>
    			<input type="submit" id="search_btn" name="sbtn" value="" style="    			
    			width: 100%;
    			height: 40px;
    			padding: 15px;
    			border-radius: 0;
    			background-image: url('res/search_btn.png');
    			background-repeat: no-repeat;
    			background-position: center;
    			border-left-style: none;
    			">    			
    		</td>
    		<td>
    			<input type="submit" id="btn" name="btn" value="View All" style="height: 40px;font-size: 16px;">
    		</td>
    	</tr>  
    </table>  
<?php  
		if($result){
			echo '<p align="left">Total Result Found For : "'.$searchResult.'" is '. $result.'</p>';	
			$print = '<table border="1" cellspacing="0" style="
						border:1px solid #333;
						font-family:sans-serif;
						color:#000;
						background-color:#fff;">
                        <tr style="color: #fff;background-color: #333;font-size: 18px;">
			    		<th>Meicine</th>
			    		<th>Expiary Date</th>
			    		<th>Chemical Amount</th>
			    		<th>Qty</th>
			    		<th>Compound 1</th>
			    		<th>Compound 2</th>
			    		<th>Compound 3</th>
			    		<th>pharma Name</th>
			    		<th>Notes</th>
			    		</tr>';
			while ($array = $stmt->fetch()) {
				$print .= '<tr><td>';
		    	$print .= $array['mname'].'</td><td>';
		    	$print .= $array['exdate'].'</td><td>';
		    	$print .= $array['chamt'].'</td><td>';
		    	$print .= $array['qty'].'</td><td>';
		    	$print .= $array['c1'].'</td><td>';
		    	$print .= $array['c2'].'</td><td>';
		    	$print .= $array['c3'].'</td><td>';
		    	$print .= $array['pname'].'</td><td>';
		    	$print .= $array['notes'].'</td>';
		    }
	    	$print .= '</tr></table>';
	    	echo $print;
			
		} 
		else{			
			echo '<p align="left">'.$error.'<p>';
		} 
?>
	</fieldset>		
	</div>
</form>
</body>
</html>
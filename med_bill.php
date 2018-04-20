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

        $fdate = $_POST['from'];
        $fparts = explode('/', $fdate);
        $from = $fparts[0];
        
        $tdate= $_POST['to'];
        $tparts = explode('/', $tdate);
        $to = $tparts[0];

        $searchResult = $from.' - '.$to;

        try{
	        $conn = new PDO("mysql:host=$dbhost;dbname=$db",$dbuser, $dbpass) or die(mysql_error());
            $sql = "SELECT * FROM medsell WHERE '".$from."' <= selldate and selldate <= '".$to."'";
	        $stmt = $conn->prepare($sql);
	        $stmt->execute();
	        $result = $stmt->rowCount();
            if(!$result){
                $error = "No Result Found";
            }
        }catch(PDOException $e){
            $msg ='<script type="text/javascript"> alert("Error: Can Not Connect To Database");</script>';
            echo($msg);
            //echo "Error: " . $e->getMessage();
        }
    }
    if(isset($_POST['csbtn'])){
        $cname = $_POST['search'];
        $searchResult = $cname;
        if (!empty($cname)) {       
        try{
            $conn = new PDO("mysql:host=$dbhost;dbname=$db",$dbuser, $dbpass) or die(mysql_error());
            $sql = "SELECT * FROM medsell WHERE cname LIKE '%".$cname."%'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->rowCount();
            if(!$result){
                $error = "No Result Found";
            }       
        }catch(PDOException $e){
            $msg ='<script type="text/javascript"> alert("Error: Can Not Connect To Database");</script>';
            echo($msg);
            //echo "Error: " . $e->getMessage();
        }
      }
      else{
        $error = "No Result Found";
      } 
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Bills</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<style type="text/css">#bills{background-color: #fff;color: #333;}</style>
</head>
<body>	
	<div class="form_input_table">
	<fieldset>
    <legend>MEDICINE BILLS</legend>	 
    <form action="" method="POST"> 
    	<table border="0" width="100%" cellspacing="0">
            <tr>
                <td style="padding: 0">
                    <input type="text" placeholder="Search Customer Name..." name="search" autofocus 
                    style="
                    border-radius: 0;
                    width: 100%;
                    height: 28px;               
                    border-right-style: none;">             
                </td>
                <td>
                    <input type="submit" id="search_btn" name="csbtn" value="" style="               
                    width: 25%;
                    height: 40px;
                    padding: 15px;
                    border-radius: 0;
                    background-image: url('res/search_btn.png');
                    background-repeat: no-repeat;
                    background-position: center;
                    border-left-style: none;
                    ">              
                </td>
            </tr>
        </table>
    </form>
    <form id="form" action="" method="POST">
        <br/>
        <table border="0">
    		<tr>
    			<th colspan="2" style="height: 30px;background-color: #2b2b2b;color:#fff;">
    				<label>View Bills</label>
    			</th>
    		</tr>
    		<tr>
    			<td>
    				<label>From</label>
    			</td> 
    			<td>
    				<input type="date" name="from" required>
    			</td>
    		</tr>
    		<tr>
    			<td>
    				<label>To</label>
    			</td> 
    			<td>
    				<input type="date" name="to" required>
    			</td>               
    		</tr>
    		<tr style="height: 30px;">               
    			<td colspan="2" style="padding-right: 0">
    				<input type="submit" id="btn" name="sbtn" value="VIEW" style="width: 100%;">
    			</td>
    		</tr>
    	</table>
<?php  
        if($result){
            echo '<p align="left">Total Result Found For : "'.$searchResult.'" is '. $result.'</p>';
            $print = '<table border="1"cellspacing="0" style="border:1px solid grey;
                        font-family:sans-serif;
                        color:#000;
                        background-color:#fff;">
                        <tr style="color: #fff;background-color: #333;font-size: 18px;">
                        <th>Id</th>
                        <th>Customer Name</th>
                        <th>Sold Medicine</th>
                        <th>Selldate</th>
                        <th>Medicine QTY</th>
                        <th>Total Bill</th>
                        <th>Notes</th>
                        </tr>';
            while ($array = $stmt->fetch()) {
                $print .= '<tr><td>';
                $print .= $array['id'].'</td><td>';
                $print .= $array['cname'].'</td><td>';
                $print .= $array['medsell'].'</td><td>';
                $print .= $array['selldate'].'</td><td>';
                $print .= $array['qty'].'</td><td>';
                $print .= $array['total'].' Rs.</td><td>';
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
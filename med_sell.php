<?php
	include("include/header.php");
	include("mpdf/mpdf.php");
	require_once 'config.php';
	//session_start();
	if(!isset($_SESSION["username"])){
		header("Location: login.php");
	}

	$result=0;
	$date='';
	$verify=1;
	$id=null;
	$cname		= '';		
	$medsell	= '';			
	$date 		= '';		
	$sellqty	= '';
	$total		= '';
	$mname= array();
	$qty = array();
	$nqty = array();
	$sp=array();
	$rate=array();
	$notes='';

	if(isset($_POST['sbtn'])){
		$cname		= $_POST['cname'];		
		$medsell	= $_POST['mcount'];
		$adate		= $_POST['date'];
		$parts 		= explode('/', $adate);
		$date 		= $parts[0];		
		$sellqty	= $_POST['qtotal'];;
		$total		= $_POST['ptotal'];
		$notes='-';
		if(isset($_POST['notes'])){$notes = $_POST['notes'];}

		for ($i=1; $i <= $medsell; $i++) { 
			$mname[$i] = $_POST['mname'.$i];
			$qty[$i]   = $_POST['qty'.$i];
			$rate[$i]  = $_POST['rate'.$i];
		}

		try{	
			$conn = new PDO("mysql:host=$dbhost;dbname=$db",$dbuser, $dbpass) or die(mysql_error());
				
				for ($i=1; $i <= $medsell ; $i++) {				
					$select = "SELECT sp,qty FROM medicine WHERE  mname = '$mname[$i]'";
					$stmt = $conn->prepare($select);
					$stmt->execute();
					$RES = $stmt->fetch();
					$sp[$i] = (int)$RES['sp']*$qty[$i];

					$nqty[$i] =(int)$RES['qty'] - $qty[$i];				
					$commit = 1;
					if ($nqty[$i]<0) {
						$commit = 0;
						die();
					}
					if ($commit == 1) {
						$update = "UPDATE medicine SET qty = '$nqty[$i]' WHERE mname = '$mname[$i]'";
						$stmt = $conn->prepare($update);
						$stmt->execute();
					}
					else{
						$msg = "<script type='text/javascript'>alert('failed! Not Enough Medicine ".
								$mname[$i]." Available')</script>";
						echo $msg;
						$verify = 0;					
					}
					//echo "update sucessessfull rowCount".$stmt->rowCount();				
				}
		if ($verify) {
		
			$sql = "INSERT INTO medsell (id,cname,medsell,selldate,qty,total,notes) VALUES
										(:id,:cname,:medsell,:selldate,:qty,:ptotal,:notes)";	
			$stmt = $conn->prepare($sql);   
					$stmt->bindParam(':id', $id);       
		            $stmt->bindParam(':cname', $cname);
		            $stmt->bindParam(':medsell', $medsell);
		            $stmt->bindParam(':selldate', $date);
		            $stmt->bindParam(':qty', $sellqty);	            
		            $stmt->bindParam(':ptotal', $total);
		            $stmt->bindParam(':notes', $notes);		
		  	$stmt->execute();
		  	$result = $stmt->rowCount();
		  	if ($result >= 1) {
		  		$msg = "<script type='text/javascript'>alert('SucsessFull Update')</script>";
				echo $msg;
		  	}
		  	createPDF();	  	
		  	}
		}	  			 	
		catch(PDOException $e)
		{
			echo "Error: " . $e->getMessage();
		}
	}

	function createPDF(){
		$d = time();
		$print = '<style type="text/css">
		
		table{
			width: 100%;
		}
			
		table th{		
			background-color:#333;
			color:#fff;	
			font-size:18px;
		}	
		table #td1{			
			text-align: left;
			padding: 10px;
		}
		table #td2{			
			text-align: right;
			padding: 10px;
		}
		#desc{
			border: 0;
		}
		#noborder{
			border: 0;
		}
		span{
			width:100%;
		}
		</style>

		<div>
			<table border="0" cellspacing="0">
				<tr id="header" >
					<th style="width=100%;font-size: 28px;"  colspan="12">MEDSHOP<span>&nbsp;</span>INVOICE</th>					
				</tr>
				<tr>
					<td id="td1" colspan="6"><b>Bill To</b><br>'.$GLOBALS['cname'].'</td>
					<td id="td2" colspan="6"><b>Invoice:</b></b>#'.$d.'<br><b>Bill Date:</b>'.$GLOBALS['date'].'</td>
				</tr>
			</table>
			<span><br/><br/></span>
			<table id="desc" border="0" cellspacing="0">
				<tr>					
					<th colspan="4">Sr</th>
					<th colspan="5">Description</th>
					<th>Quantity</th>
					<th>Rate</th>					
					<th>Price</th>				
				</tr>';

				for ($i=1; $i <= $GLOBALS['medsell'] ; $i++) { 
					$print .= '<tr>					
								<td colspan="4">'.$i.'</td>
								<td colspan="5">'.$GLOBALS['mname'][$i].'</td>
								<td>'.$GLOBALS['qty'][$i].'</td>
								<td>'.$GLOBALS['rate'][$i].'</td>					
								<td>'.$GLOBALS['qty'][$i]*$GLOBALS['rate'][$i].'</td>				
							   </tr>';
				}
				
	  $print .='<tr>
					<td id="noborder" colspan="10"></td>
					<td>Total</td>
					<td>'.$GLOBALS['total'].'</td>
				</tr>				
			</table>
		</div>';
		
		$filename = $GLOBALS['cname'].'_'.$GLOBALS['date'].'_'.$d;

		$pdf = new MPDF;
		$pdf ->AddPage();
		$pdf ->SetFont("inherit",'',16);	
		$pdf ->SetTitle("Invoice");
		$pdf ->SetAuthor("MEDSHOP");
		$pdf ->SetDisplayMode('fullpage');
		$pdf ->WriteHTML($print);
		$pdf ->Output('Bills/'.$filename.'.pdf');		
		//$pdf ->Output();	
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Sell</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<style type="text/css">#sell{background-color: #fff;color: #333;}</style>

<script type="text/javascript">

	function addrows(){
		var table = document.getElementById("table1");
		var j=1;		
		for (var i = 4; i < parseInt(document.getElementById("mcount").value,10) + 4; i++) {
			row = table.insertRow(i);
			var cell0 =	row.insertCell(0);	
			var cell1 = row.insertCell(1);
			var cell2 = row.insertCell(2);
			var cell3 = row.insertCell(3);
				cell0.colSpan = "2";
				cell1.colSpan = "1";
				cell2.colSpan = "1";
				cell3.colSpan = "2";				
				cell0.innerHTML = '<input type=text name="mname'+j+'" id="mname'+j+'" placeholder="Medicine Name" required/>';
				cell1.innerHTML = '<input type=number name="qty'+j+'" id ="qty'+j+'"  onblur="getPrice('+j+')" pattern=[0-9]+ placeholder="Quantity" required/>';
				cell2.innerHTML = '<input type=decimal name="rate'+j+'" id="rate'+j+'"  required placeholder="Rate"/>';
				cell3.innerHTML = '<input type=decimal name="sp'+j+'" id="sp'+j+'"  placeholder="Price" required/>';
				j++;
		}
		document.getElementById("mname1").focus();
	}

	function make_total(){		
		ptotal=0;
		qtotal=0;		
		for (var i = 1; i <= parseInt(document.getElementById('mcount').value,10); i++) {	
			ptotal = ptotal + parseFloat(document.getElementById('sp'+i).value,10.0);
		}
		for (var i = 1; i <= parseInt(document.getElementById('mcount').value,10); i++) {	
			qtotal = qtotal + parseInt(document.getElementById('qty'+i).value,10);
		}
		document.getElementById('ptotal').value = ptotal;
		document.getElementById('qtotal').value = qtotal;			
	}
	
	function getPrice(ind) {
		var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
            	var sp = this.responseText;
            	var qty = document.getElementById("qty"+ind).value;
            	var price = qty * sp;
                document.getElementById("rate"+ind).value = sp;
                document.getElementById("sp"+ind).value = price;               
            }
        };
        var mname =  document.getElementById("mname"+ind).value;
        xmlhttp.open("GET", "getPrice.php?mname="+mname+"", true);
        xmlhttp.send();
	}

</script>	
</head>
<body>
<form id="form" method="POST" action="">
	<div class="form_input_table">
	<fieldset>
    <legend>MEDICINE SELL</legend>
		<table border="0"  id="table1" cellspacing="5" style="background-color: #59202020;border: 1px solid black;border-radius: 5px;" >
			<tr>
				<td colspan="1" align="left"><label for="cname">Customer Name</label></td>
				<td colspan="3"><input type="text" name="cname" id="cname" placeholder="Customer's Full Name" required/></td>
				<td><label for="date">Date</label></td>
				<td><input type="date" name="date" id="sdate" value="<?php echo date('Y-m-d');?>" required/></td>
			</tr>

			<tr>
				<td colspan="1" align="left">No. of Medicine<br>Being Sold</td>
				<td colspan="1">
					<input type="number" name="mcount" id="mcount" onchange="addrows()" placeholder="Number of Medicine" required/>
				</td>				
			</tr>	
			<tr><td colspan="6" id="underline"><hr></td></tr>
			<tr>				
				<th colspan="2"><label for="mname">Medicine Name</label></th>
				<th colspan="1"><label for="qty" >Quantity</label></th>
				<th colspan="1"><label for="rate" >Rate</label></th>
				<th colspan="2"><label for="sp">Price</label></th>
			</tr>
			
			<!--
				table row to be inserted here by avascript at index 4;		
			-->	

			<tr><td colspan="6" id="underline"><hr></td></tr>
			<tr>				
				<td align="left"><label for="notes">Notes</label></td>
				<td><input type="text" name="notes" placeholder="Remarks" /></td>
				<td><input type="text" placeholder="Total Quantity" name="qtotal" id="qtotal" onfocus="make_total()" required /></td>
				<td><label for="total">Total Price</label></td>
				<td colspan="2"><input type="text" name="ptotal" id="ptotal" onfocus="make_total()" required /></td>
			</tr>
			<tr><td colspan="6" id="underline"><hr></td></tr>
			<tr>				
				<td colspan="1"><input type="submit" id="btn" name="sbtn" value="SUBMIT"/></td>
				<td colspan="1"><input type="reset" id="btn" name="rbtn" onclick="window.location.href='med_sell.php'" value="RESET"/></td>	
			</tr>
		</table>		 
	</fieldset>		
	</div>	
</form>
</body>
</html>

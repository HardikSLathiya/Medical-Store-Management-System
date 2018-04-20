<?php
	require_once 'mpdf/mpdf.php';

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
					<td id="td1" colspan="6"><b>Bill To</b><br>'.$cname.'</td>
					<td id="td2" colspan="6"><b>Invoice:</b></b>#'.$d.'<br><b>Bill Date:</b>'.$date.'</td>
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
				for ($i=1; $i <= medsell ; $i++) { 
					$print .= '<tr>					
								<th colspan="4">'.$medsell.'</th>
								<th colspan="5">'.$mname[$i].'</th>
								<th>'.$qty[$i].'</th>
								<th>'.$rate[$i].'</th>					
								<th>'.$sp[$i].'</th>				
							   </tr>';
				}
				
	  $print .='<tr>
					<td id="noborder" colspan="10"></td>
					<td>Total</td>
					<td>'.$total.'</td>
				</tr>
				<tr>
					<td id="noborder" colspan="10"></td>
					<td>Amount Paid</td>
					<td>'.$total.'</td>
				</tr>
			</table>
		</div>';
		
		$filename = $cname.'_'.$date.'_'.$d;

		$pdf = new MPDF;
		$pdf ->AddPage();
		$pdf ->SetFont("inherit",'',16);	
		$pdf ->SetTitle("Invoice");
		$pdf ->SetAuthor("MEDSHOP");
		$pdf ->SetDisplayMode('fullpage');
		$pdf ->WriteHTML($print);
		$pdf ->Output('pdf/'.$filename.'.pdf');
		$pdf ->Output();	
	
?>


<!--DOCTYPE html>
<html>
<head>
	<title>Print PDF</title>
	<style type="text/css">
		
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
					<td id="td1" colspan="6"><b>Bill To</b><br> Hardik Lathiya</td>
					<td id="td2" colspan="6"><b>Invoice:</b></b>#3924312<br><b>Bill Date:</b>3/2/2018</td>
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
				</tr>
				<tr>					
					<td colspan="4">Item1</td>
					<td colspan="5">Description</td>
					<td>Quantity</td>
					<td>Rate</td>					
					<td>Price</td>				
				</tr>
				<tr>					
					<td colspan="4">Item2</td>
					<td colspan="5">Description</td>
					<td>Quantity</td>
					<td>Rate</td>	
					<td>Price</td>				
				</tr>
				<tr>					
					<td colspan="4">Item3</td>
					<td colspan="5">Description</td>
					<td>Quantity</td>
					<td>Rate</td>	
					<td>Price</td>				
				</tr>
				<tr>
					<td id="noborder" colspan="12"><br/></td>
				</tr>
				<tr>
					<td id="noborder" colspan="10"></td>
					<td>Total</td>
					<td>100 Rs.</td>
				</tr>
				<tr>
					<td id="noborder" colspan="10"></td>
					<td>Amount Paid</td>
					<td>100 Rs.</td>
				</tr>
			</table>
		</div>		
	</form>
</body>
</html-->
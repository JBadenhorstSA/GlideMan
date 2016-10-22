<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GlideMan</title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table border="1" width="800">
	<tr>
    	<td width="400">
        <strong>Account Statement</strong>
        <p>P.O. Box 19916
        <br />Noordbrug
        <br />Potchefstroom
        <br />2522
        </p>
   	    <p>www.potchgliding.co.za</p></td>
    	<td><img src="images/avplogo.jpg" width="100" height="80" />
        </td>
    </tr>
</table>
<?php
	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	include('functions.php');
	$fromdate = $_GET['date1'];
	$todate = $_GET['date2'];
	$mem_no = $_GET['mem_no'];
	$resultarray = mysql_fetch_array(mysql_query("SELECT account_no, balance FROM tbl_accounts WHERE mem_no=$mem_no;"));
	$account_no = $resultarray['account_no'];
	$balance = $resultarray['balance'];
	//echo $mem_id, $account_no;
	
	//Display Statement Date at the top
	print "<table border='1' width='800' cellpadding='5' cellspacing='5'>";
  	print "<tr><td colspan='4'>Statement: ".$fromdate." to ".$todate."</td></tr>";
	
	//Dislay Member and account Info
	$resultarray1 = mysql_fetch_array(mysql_query("SELECT name, surname FROM tbl_members WHERE mem_no=$mem_no;"));
	$mem_name = $resultarray1['name'];
	$mem_surname = $resultarray1['surname'];
	print "<tr>";
	print "<td colspan='2'>";
	print $mem_name;
	print "</td>";
	print "<td colspan='2'>";
	print "Account Number: ".$account_no;
	print "</td>";
	print "</tr>";	
	
	print "<tr>";
	print "<td colspan='2'>";
	print $mem_surname;
	print "</td>";
	print "<td colspan='2'>";
	print "Member Number: ".$mem_no;
	print "</td>";
	print "</tr>";	
	

	//Payments, Credit Notes and Invoices Area
	print "<tr>";
	print "<td colspan='2'>";
	print "<strong>Payments</strong>";
	print "</td>";
	print "<td colspan='2'>";
	print "<strong>Invoices</strong>";
	print "</td>";
	print "</tr>";
	
	print "<tr><td colspan='2'>";
	//Payments
	$query = "SELECT payment_no, ammount FROM tbl_payments WHERE (pdate BETWEEN '$fromdate' AND '$todate') AND (account_no='$account_no');";
	$result = mysql_query($query);
	print "<table border='1' cellpadding='5' cellspacing='5'>";
	print "<tr><td>Payment Number</td><td>Payment Amount</td></tr>";
	while ($db_field = mysql_fetch_assoc($result)) {
		print "<tr><td>";
			print $db_field['payment_no'];
			print "</td><td>";
			print $db_field['ammount'];
			print "</td></tr>";
	}
	print "</table>";
	
	print "</td><td colspan='2'>";
	//Invoices
	$query = "SELECT inv_no, tot_ammount FROM tbl_invoices WHERE (idate BETWEEN '$fromdate' AND '$todate') AND (account_no='$account_no');";
	$result = mysql_query($query);
	print "<table border='1' cellpadding='5' cellspacing='5'>";
	print "<tr><td>Invoice Number</td><td>Invoice Amount</td></tr>";
	while ($db_field2 = mysql_fetch_assoc($result)) {
		print "<tr><td>";
			print $db_field2['inv_no'];
			print "</td><td>";
			print $db_field2['tot_ammount'];
			print "</td></tr>";
	}
	print "</table>";
	
	
	print "</td><tr>";
	print "<td colspan='2'>";
	print "<strong>Credit Notes</strong>";
	print "</td>";
	print "</tr>";
	
	print "</td><td colspan='2'>";
	//Credit Notes
	$query = "SELECT note_no, tot_credit FROM tbl_creditnote WHERE (cdate BETWEEN '$fromdate' AND '$todate') AND (account_no='$account_no');";
	$result = mysql_query($query);
	print "<table border='1' cellpadding='5' cellspacing='5'>";
	print "<tr><td>Credit Note Number</td><td>Credit Note Amount</td></tr>";
	while ($db_field3 = mysql_fetch_assoc($result)) {
		print "<tr><td>";
			print $db_field3['note_no'];
			print "</td><td>";
			print $db_field3['tot_credit'];
			print "</td></tr>";
	}
	print "</table>";
	
	print "</td><tr>";
	print "<td colspan='4'>";
	print "Account Balance: R".$balance;
	print "</td>";
	print "</tr>";
	
	print "</table>"; //Ends The Table 
	mysql_close($db_handle);

?>

</body>
</html>
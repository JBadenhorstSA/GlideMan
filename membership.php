<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GlideMan</title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
</head>
<?php
	session_start();
	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	include('functions.php');//Include the functions page. Calling various functions from that page.
	if ($_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
		if (isset($_POST['submit'])) {
			$month = $_POST['month']; //Get the month for which Memberships are being processed
			
			$query = "SELECT * FROM tbl_members WHERE active='Y';";
			$result = mysql_query($query);
			print "<table border='1' width='800' cellpadding='5' cellspacing='5'>";
			print "<tr><td>Member No</td><td>Name</td><td>Surname</td><td>Member Type</td><td>Amount</td></tr>";
			while ($db_field = mysql_fetch_assoc($result)) {
						$mem_no = $db_field['mem_no'];
						$name = $db_field['name'];
						$surname = $db_field['surname'];
						$mem_type = $db_field['mem_type'];
						
						print "<tr><td>";
						print $db_field['mem_no'];
						print "</td><td>";
						print $db_field['name'];
						print "</td><td>";
						print $db_field['surname'];
						print "</td><td>";
						print $db_field['mem_type'];
						print "<td>";
						
						//tests for type of membership, and depending on membership type get the ammount from the memberships table
						switch ($mem_type) {
							case "Normal Corporate":
								$monthly_amount = memAmount($mem_type);//calls the memAmount Function 
								break;
							case "Student":
								$monthly_amount = memAmount($mem_type);//calls the memAmount Function 
								break;
							case "Executive":
								$monthly_amount = memAmount($mem_type);//calls the memAmount Function 
								break;
							case "Honorary":
								$monthly_amount = memAmount($mem_type);//calls the memAmount Function 
								break;
							case "Social":
								$monthly_amount = memAmount($mem_type);//calls the memAmount Function ;
								break;
							case "Family":
								$monthly_amount = memAmount($mem_type);//calls the memAmount Function 
								break;
							case "Country":
								$monthly_amount = memAmount($mem_type);//calls the memAmount Function 
								break;
							case "Special":
								$monthly_amount = memAmount($mem_type);//calls the memAmount Function 
								break;
							case "Temporary":
								$monthly_amount = memAmount($mem_type);//calls the memAmount Function 
								break;
							
						}
						
						
						//Get the next invoice number that will be created Automatically
						$resultarray = callQuery("SELECT COUNT(*) AS 'total' FROM tbl_invoices");
						$invoice_no = $resultarray['total'] + 1;
						$invoice_date = date("Y-m-d");// insert date on which the invoice was created
						$dateArray = explode("-", $invoice_date);
						$year = $dateArray['0'];
						
						//get the members details from the accounts table
						$accountarray = callQuery("SELECT account_no, balance FROM tbl_accounts WHERE mem_no='$mem_no';");
						$account_no = $accountarray['account_no'];
						$balance = $accountarray['balance'];
						
						//Create Invoice for the Membership for that month to the member. use the month in the description similar to invoice for flight in timesheet_final
						$invoice_item_descr = $mem_type." membership for ".$month." ".$year;
						$item_no_counter = 1;
						runQuery("INSERT INTO tbl_invoices (idate, account_no, mem_name, mem_surname, tot_ammount) VALUES('$invoice_date', '$account_no', '$name', '$surname', '$monthly_amount');");
						runQuery("INSERT INTO tbl_inv_items (inv_no, item_no, item_descr, item_ammount) VALUES('$invoice_no', '$item_no_counter', '$invoice_item_descr', '$monthly_amount');");	
						
						//Adjust Account balance for the member
						$balance = $balance + $monthly_amount;
						runQuery("UPDATE tbl_accounts SET balance='$balance' WHERE account_no = '$account_no'");
						echo $invoice_item_descr." R".$monthly_amount;
						
						print "</td>";
						print "</tr>";
			
			
			
			}
			print "</table>";
			//Add Entry into History table that the memberships have been invoiced
			$change_made = "Invoiced membership for ".$month." ".$year;
			addHistory($_SESSION['mem_no'], $change_made, "Accounts & Invoices");//calls the addHistory method to add info to the history table.
		}
		else {
			
		}
		
	}
	else {
		
	}
	
	mysql_close($db_handle);
?>


<body>


<form action="membership.php" name="frm_membership" id="frm_membership" method="post">
<select name="month" id="month">
    <option>January</option>
	<option>February</option>
    <option>March</option>
    <option>April</option>
 	<option>May</option>   
 	<option>June</option>
    <option>July</option>
    <option>August</option>
    <option>September</option>
    <option>October</option>
    <option>November</option>
    <option>December</option>
</select>
<input type="submit" name="submit" id="submit" value="Submit" />
</form>


<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
</body>
</html>
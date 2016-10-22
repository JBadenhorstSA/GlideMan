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
<!-- This is the little menu area -->
<p><a href="members.php"><img src="images/members.jpg"></a><a href="flights.php"><img src="images/flights.jpg"></a><a href="accounts.php"><img src="images/accounts.jpg"></a><a href="gliders.php"><img src="images/gliders.jpg"></a><a href="reports.php"><img src="images/logbooks.jpg"></a><a href="snags.php"><img src="images/snags.jpg"></a></p>




<h1>Accounts Section:</h1>
<p>
<!-- Present a list of accounting functions If user is Authorised-->
<?php
	if ($_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
	print "<ul>";
		print "<li><a href=pos.php>POS</a></li>";
		//print "<li><a href=account_add.php>Add Account</a></li>"; //Create new Account
	    //print "<li><a href=account_edit.php>Edit Account</a></li>"; // Trasfer or edit existing account
	    print "<li><a href=timesheet_final.php>Finalize Timesheet and Generate Invoices</a></li>";
		print "<li><a href=membership.php>Process Monthly Memberships</a></li>";
	    print "<li><a href=invoice_create.php>Create Invoice</a></li>";
		print "<li><a href=invoice_create_single.php>Quick Invoice - Single Item</a></li>";
	    print "<li><a href=payment_create.php>Create Payment</a></li>";
	    print "<li><a href=creditnote_create.php>Create Credit Note</a></li>";
	    print "<li><a href=items_add.php>Add Items for Invoicing and Credit Notes</a></li>";
	    print "<li><a href=statement_comp.php>Compile Statement</a></li>";
	print "</ul>";
	}
?>
</p>
<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved Version 2.0</p>
</body>
</html>
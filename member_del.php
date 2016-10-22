<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GlideMan</title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />

</head>


<body>
<!-- This is the little menu area -->
<p><a href="members.php"><img src="images/members.jpg"></a><a href="flights.php"><img src="images/flights.jpg"></a><a href="accounts.php"><img src="images/accounts.jpg"></a><a href="gliders.php"><img src="images/gliders.jpg"></a><a href="reports.php"><img src="images/logbooks.jpg"></a><a href="snags.php"><img src="images/snags.jpg"></a></p>
<h3>Message:</h3>

<?php
	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	include('functions.php');//Include the functions page. Calling various functions from that page.
	session_start(); //start session so that the user session can be tracked
	if (isset($_SESSION['name'])) {
		$session_message = "<br />Logged in as: ".$_SESSION['name']."<br />";
	}
	else {
		$session_message = "<br />ALERT!!!!! Not Logged in. NO Changes will be made! <br />";
	}
	
	$delete_ID = $_GET['mem_no'];
	//Check to see if the user loggend in has the correct privelage to make the change
	if ($_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
				$deletearray = callQuery("SELECT * FROM tbl_members WHERE mem_no = '$delete_ID'");
				$delaccountarray = callQuery("SELECT * FROM tbl_accounts WHERE mem_no = '$delete_ID'");
				//Check to see if the member's account balance is 0, and only the is the member and account Deleted.
				if ($delaccountarray['balance'] != 0){
						echo "<strong>Member can not be deactivated. The Account Balance for this member is not R0.</strong>" ;
				}
				else {
					//Call the functions to execute queries to deactivate the member record and associated account record
					runQuery("UPDATE tbl_members SET active='N' WHERE mem_no = '$delete_ID'");
					echo "Member Deactivated Successfully: " . " Name: " . $deletearray['name'] . ". Surname: " . $deletearray['surname'] . ". Member Number: " . $deletearray['mem_no'] . ". Account Number: " . $delaccountarray['account_no'];
					$change_made = "Deactivated Member Record and Account for member $delete_ID ".$deletearray['name']." ". $deletearray['surname'];
							
					//call function to record the change in the history table
					addHistory($_SESSION['mem_no'], $change_made, "Members & Accounts");
				}
	}
	else {
				$session_message = "Invalid Access - Record Not Deleted";
	}
	mysql_close($db_handle);
	print $session_message;
	?>

<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved - Version 2.0</p>
</body>
</html>
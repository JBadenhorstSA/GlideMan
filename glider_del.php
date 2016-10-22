<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GlideMan</title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />

</head>
<!-- This is the little menu area -->
<p><a href="members.php"><img src="images/members.jpg"></a><a href="flights.php"><img src="images/flights.jpg"></a><a href="accounts.php"><img src="images/accounts.jpg"></a><a href="gliders.php"><img src="images/gliders.jpg"></a><a href="reports.php"><img src="images/logbooks.jpg"></a><a href="snags.php"><img src="images/snags.jpg"></a></p>

<h3>Deleted Glider</h3>
<?php
	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	include('functions.php');
	session_start(); //start session so that the user session can be tracked
	$delete_ID = $_GET['reg'];
	if (isset($_SESSION['name'])) {
		$session_message = "<br />Logged in as: ".$_SESSION['name']."<br />";
	}
	else {
		$session_message = "<br />ALERT!!!!! Not Logged in. NO Changes will be made! <br />";
	}
	
	//Check to see if the user loggend in has the correct privelage to make the change
	if ($_SESSION['authorised'] == "Admin") {
			$deletearray = callQuery("SELECT * FROM tbl_gliders WHERE reg = '$delete_ID'");
			runQuery("DELETE FROM tbl_gliders WHERE reg = '$delete_ID'");
			$session_message = "Record Deleted Successfully: " . " Glider: " . $deletearray['reg'] . " Callsign: " . $deletearray['callsign'] . " Type: " . $deletearray['type_name'];
			$change_made = $deletearray['reg']." Deleted by ".$_SESSION['name'];// Creage a Change message to add to the history table
			//call function to add a change in the history table
			addHistory($_SESSION['mem_no'], $change_made, "Gliders");
	}
	else {
		$session_message = "Invalid Access - Record Not Deleted";
	}
	mysql_close($db_handle);
	print $session_message;
	?>


<body>
</body>
</html>
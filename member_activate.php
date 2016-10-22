<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GlideMan</title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
</head>
<?php
	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	include('functions.php');//Include the functions page. Calling various functions from that page.
	session_start(); //start session so that the user session can be tracked

	if ($_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
		if (isset($_POST['submit'])) {
				$member = $_POST['member'];
				$mem_array = explode(" ", $member);
				$mem_no = $mem_array[0];
				$mem_name = $mem_array[1];
				$mem_surname = $mem_array[2];
				
				//Call the functions to execute queries to Activate the member record and associated account record
				runQuery("UPDATE tbl_members SET active='Y' WHERE mem_no = '$mem_no'");
				echo "Member Activated Successfully: " . " Name: " . $mem_name . ". Surname: " . $mem_surname . ". Member Number: " . $mem_no;
				$change_made = "Activated Member Record and Account for member: ".$mem_no ." ".$mem_name." ". $mem_surname;
							
				//call function to record the change in the history table
				addHistory($_SESSION['mem_no'], $change_made, "Members & Accounts");
		}
	}
	else {
				$session_message = "Invalid Access - Records cannot be modified";
	}
	mysql_close($db_handle);
	print $session_message;


?>

<body>

<form action="member_activate.php" name="mem_act" id="mem_act" method="post">
<select name="member" id="member" />
		<!-- This is a Select option for the form with a PHP piece of code to pull all the timesheets available from the DB -->
      	<option></option>
      <?php
	  	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	  	$query = "SELECT mem_no, name, surname FROM tbl_members WHERE active='N' ORDER BY name ASC;";
		$result = mysql_query($query)
			or die ("Query Failed: " . mysql_error());
		//$memberarray = mysql_fetch_array($result13);
		while ($row = mysql_fetch_array($result))
		{
			echo "<option>", $row['mem_no']." ".$row['name']." ".$row['surname'],"</option>";	
		}
      	mysql_close($db_handle);
      ?></select>

<input type="submit" name="submit" id="submit" value="Submit" />
</form>



<p align="left"><a href="members.php">Back To Members</a></p>
<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
	session_start(); //start session so that the user session can be tracked
	if (isset($_SESSION['name'])) {
		$session_message = "Logged in as: ".$_SESSION['name'];
	}
	else {
		$session_message = "ALERT!!!!! Not Logged in. NO Changes will be made! ";
	}
?>
<head>
<?php
	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	include('functions.php');
	$change_made = "";
	if (isset($_POST['save'])) {
		$sheet_no = $_POST['sheet_no'];
		$date = $_POST['date'];
		$duty_off = $_POST['duty_off'];
		if ($_SESSION['authorised'] == "Normal" || $_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
				//call the runquery function to run the query and insert the values into timesheets table
				runQuery("INSERT INTO tbl_timesheets (sheet_no, date, duty_officer, locked) VALUES('$sheet_no', '$date', '$duty_off', 'N');");
				$change_made = " Added Timesheet ".$sheet_no." ".$date;
				echo $change_made;
				echo "<br />";
				//call function to record the change in the history table
				addHistory($_SESSION['mem_no'], $change_made, "Timesheets");
		
		}
		else {
			echo "No Change Made";	
		}
	}
	else {
	
	}
	mysql_close($db_handle);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GlideMan</title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
	print $session_message;
?>
<form id="addtsheet" name="addtsheet" method="post" action="timesheet_add.php">
	<p>Sheet Number: </p>
    <input type="text" name="sheet_no" id="sheet_no" />
    <p>Sheet Date: </p>
    <input type="text" name="date" id="date" value="YYYY-MM-DD" />
    <p>Duty Officer: </p>
	<select name="duty_off" id="duty_off">
      	<option></option>
         <?php
	  			include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
				//Query the members table and add Member No, Name and Surname as available options to select as owner
	  			$query = "SELECT mem_no, name, surname FROM tbl_members;";
				$result = mysql_query($query)
						or die ("Query Failed: " . mysql_error());
				while ($s_row = mysql_fetch_array($result))
				{
						echo "<option>", $s_row['mem_no']." ".$s_row['name']." ".$s_row['surname'],"</option>";	
				}
      			mysql_close($db_handle);
      		?> 
        
      </select>


	<input type="submit" name="save" id="button" value="Save" />
</form>
<p align="left"><a href="flights.php">Back to Flights</a></p>
<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved - Version 2.0</p>
</body>
</html>
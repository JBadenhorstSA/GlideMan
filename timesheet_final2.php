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
	<?php
	include('connect.php');//Include the php page that makes the connection to the database
	include('functions.php'); //Include the functions page to call functions.
	if ($_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
		if(isset($_POST['submit'])) {
			$timesheet = $_POST['timesheet'];
			$sheetarray = explode(" ", $_POST['timesheet']);
			$sheet_no = $sheetarray[0];
			$sheet_date = $sheetarray[1];
			
			//lock the timesheet, uncomment when ready
			//runQuery("UPDATE tbl_timesheets SET locked='Y' WHERE sheet_no = '$sheet_no'");
			
			//echo for testing
			echo $sheet_no;
			echo "<br />";
			echo $sheet_date;
			
			
			// Check all flights that they conform to the rules.
			
			
			
			//FOR EACH FLIGHT
			// * Display the flight in a table
			// *Calculate the Costs of that flight
			// *Bill the costs to the relevant member
			// *Update logbooks for Aircraft and Launching Equipment.
			
			
			
			
			
			
			echo "Timesheet: ".$timesheet." processed successfully";
			
			
			
			//Creates a message and adds it to the auditing History Table
			$change_made = $_SESSION['name']." processed and invoiced timesheet ".$timesheet;
			addHistory($_SESSION['mem_no'], $change_made, "Accounts & Invoices");//calls the addHistory method to add info to the history table.


		}
		else {

		}

	}
	mysql_close($db_handle);
	?>
<body>
<!-- Can be removed after rules are set in coding -->
<strong>Timesheet Finalizing Rules:</strong>
<ul>
	<li>Can not finalize if all Aerotow ("Tug") flights do not have a tug time</li>
    <li>TMFG (Launch Method ("Self) Flights have to have Tacho Times</li>
</ul>

<form action="timesheet_final2.php" name="sheet_final" id="sheet_final" method="post">
<select name="timesheet" id="timesheet" />
		<!-- This is a Select option for the form with a PHP piece of code to pull all the timesheets available from the DB -->
      	<option></option>
      <?php
	  	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	  	$query = "SELECT sheet_no, date FROM tbl_timesheets WHERE locked = 'N';";
		$result = mysql_query($query)
			or die ("Query Failed: " . mysql_error());
		while ($row_t = mysql_fetch_array($result))
		{
			echo "<option>", $row_t['sheet_no']." ".$row_t['date'],"</option>";	
		}
      	mysql_close($db_handle);
      ?></select>



<input type="submit" name="submit" id="submit" value="Submit" />
</form>
<p align="left"><a href="accounts.php">Cancel</a></p>
<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
</body>
</html>
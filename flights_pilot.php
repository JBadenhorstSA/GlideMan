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

<p>Report Complete:
</p>
<?php
	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	
	$pilot = $_GET['pilot'];
	
	$query = "SELECT * FROM tbl_flights WHERE p1='$pilot' OR p2='$pilot';";
	$result = mysql_query($query);
	//echo $query21;    Echo the query when required for testing
	print "<table border='1' width='800' cellpadding='5' cellspacing='5'>";
  	print "<tr><td>Flight No</td><td>Date</td><td>Glider</td><td>Duration</td><td>Payment</td><td>P1</td><td>P2</td><td>Flight Type</td><td>Take Off</td><td>Landing</td><td>No Landings</td><td>Launch Method</td><td>Tug Time</td><td>Tacho Start</td><td>Tacho End</td></tr>";
	
	while ($db_field = mysql_fetch_assoc($result)) {
			print "<tr><td>";
			print $db_field['flight_no'];
			print "</td><td>";
			print $db_field['date'];
			print "</td><td>";
			print $db_field['glider_reg'];
			print "</td><td>";
			print $db_field['flight_duration'];
			print "</td><td>";
			print $db_field['payment_resp'];
			print "</td><td>";
			print $db_field['p1'];
			print "</td><td>";
			print $db_field['p2'];
			print "</td><td>";
			print $db_field['flight_type'];
			print "</td><td>";
			print $db_field['take_off_time'];
			print "</td><td>";
			print $db_field['landing_time'];
			print "</td><td>";
			print $db_field['no_landings'];
			print "</td><td>";
			print $db_field['launch_method'];
			print "</td><td>";
			print $db_field['tug_time'];
			print "</td><td>";
			print $db_field['tacho_start'];
			print "</td><td>";
			print $db_field['tacho_end'];
			print "</td>";
			print "</tr>";
		}
	echo "</table>"; //Ends The Table 
	mysql_close($db_handle);

?>

<p align="left"><a href="flights.php">Flights Search</a></p>
<p>&nbsp;</p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved - Version 2.0</p>
</body>
</html>
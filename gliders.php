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




<h1>Gliders:</h1>
<?php
	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	if (isset($_SESSION['authorised'])) {
		if ($_SESSION['authorised'] == "Normal" || $_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
			$query = "SELECT * FROM tbl_gliders";
			$result = mysql_query($query);
			print "<table border='1' width='800' cellpadding='5' cellspacing='5'>";
			print "<tr><td>Glider Registration</td><td>Callsign</td><td>Type Name</td><td>LS1 Expiry</td><td>Hours</td><td>Charge Option</td><td>Calculation</td><td colspan='2'>Action</td></tr>";
			
			while ($db_field = mysql_fetch_assoc($result)) {
					$reg = $db_field['reg'];//creates a registration variable to pass in the URL of the Edit and Delete Links
					print "<tr><td>";
					print $db_field['reg'];
					print "</td><td>";
					print $db_field['callsign'];
					print "</td><td>";
					print $db_field['type_name'];
					print "</td><td>";
					print $db_field['ls1_exp'];
					print "</td><td>";
					print $db_field['hours'];
					print "</td><td>";
					print $db_field['charge_option'];
					print "</td><td>";
					print $db_field['charge_calculation'];
					print "</td><td>";
					print "<a href=glider_edit.php?reg=$reg&update=yes>Edit</a>";
					print "</td><td>";
					print "<a href=glider_del.php?reg=$reg&delete=yes>Delete</a></td>";
					print "</tr>";
				}
			echo "</table>"; //Ends The Table 
		}
		else {
		print "<br />You are not authorised<br />";
		}
	}
	else {
		print "<br />You are not authorised<br />";
	}
	mysql_close($db_handle);

?>

<p><a href="glider_add.php">| Add a Glider |</a></p>
<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
<p>&nbsp;</p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved - Version 2.0</p>
</body>
</html>
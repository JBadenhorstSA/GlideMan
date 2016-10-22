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

<h1>SNAGS:</h1>
<?php
	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	if (isset($_SESSION['authorised'])) {
		if ($_SESSION['authorised'] == "Normal" || $_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
			$query16 = "SELECT * FROM tbl_snags";
			$result16 = mysql_query($query16);
			print "<table border='1' width='800' cellpadding='5' cellspacing='5'>";
			print "<tr><td>Snag No</td><td>Date</td><td>Aircraft / Equipment Name</td><td>Problem Notes</td><td>Member No</td><td>Status</td><td>Action</td></tr>";
			
			while ($db_field = mysql_fetch_assoc($result16)) {
					$snag_no = $db_field['snag_no'];//creates a Fault ID variable to pass in the URL of the Edit and Delete Links
					print "<tr><td>";
					print $db_field['snag_no'];
					print "</td><td>";
					print $db_field['date'];
					print "</td><td>";
					print $db_field['aircraft_equip_name'];
					print "</td><td>";
					print $db_field['notes'];
					print "</td><td>";
					print $db_field['member_no'];
					print "</td><td>";
					print $db_field['status'];
					print "</td><td>";
					print "<a href=snag_edit.php?snag_no=$snag_no&update=yes>Edit</a>";
					print "</td>";
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
<p><a href="snag_add.php">| New Snag |</a></p>
<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
<p>&nbsp;</p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved - Version 2.0</p>
</body>
</html>
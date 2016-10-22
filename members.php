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


<h1>Members:</h1>
<p><a href="member_add.php">| New Member |</a><a href="member_activate.php">| Reactivate Old Member |</a><a href="password_change.php">| Change Password |</a></p>
<?php
	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	//include('functions.php');//Include the functions page to easily call Queries
	//Queries all the information from the members table in the db
	if (isset($_SESSION['authorised'])) {
		if ($_SESSION['authorised'] == "Normal" || $_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
		
			$query = "SELECT * FROM tbl_members WHERE active='Y'";
			$result = mysql_query($query);
			print "<table border='1' width='800' cellpadding='5' cellspacing='5'>";
			print "<tr><td>Member No</td><td>Name</td><td>Surname</td><td>ID Number</td><td>Cell</td><td>E-Mail</td><td>Member Type</td><td colspan='2'>Action</td></tr>";
			
			//All the information from the members table is inserted into an array and then displayed in a table
			while ($db_field = mysql_fetch_assoc($result)) {
					$mem_no = $db_field['mem_no'];//creates a member ID variable to pass in the URL of the Edit and Delete Links
					print "<tr><td>";
					print $db_field['mem_no'];
					print "</td><td>";
					print $db_field['name'];
					print "</td><td>";
					print $db_field['surname'];
					print "</td><td>";
					print $db_field['id_no'];
					print "</td><td>";
					print $db_field['cell'];
					print "</td><td>";
					print $db_field['email'];
					print "</td><td>";
					print $db_field['mem_type'];
					print "</td><td>";
					print "<a href=member_edit.php?mem_no=$mem_no&update=yes>Edit</a>";
					print "</td><td>";
					print "<a href=member_del.php?mem_no=$mem_no&delete=yes>Delete</a></td>";
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


<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
<p>&nbsp;</p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved - Version 2.0</p>
</body>
</html>
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
	
	<?php
			include('connect.php');
			include('functions.php');
			echo $_SESSION['authorised'];
			echo "<br />";
			if ($_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
				$query = "SELECT * FROM tbl_members WHERE active='Y'";
				$result = mysql_query($query);
				print "<table border='1' width='800' cellpadding='5' cellspacing='5'>";
				print "<tr><td>Member No</td><td>Name</td><td>Surname</td><td>ID Number</td><td>Cell</td><td>E-Mail</td><td>Member Type</td><td>Balance</td><td></td></tr>";
				
				//All the information from the members table is inserted into an array and then displayed in a table
				while ($db_field = mysql_fetch_assoc($result)) {
						$mem_no = $db_field['mem_no'];//creates a member ID variable to pass in the URL of the Edit and Delete Links
						print "<tr><td>";
						print $db_field['mem_no'];
						$mem_no = $db_field['mem_no'];
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
						$query1 = "SELECT balance FROM tbl_accounts WHERE mem_no='$mem_no'";
						$result1 = mysql_query($query1);
						$acc_field = mysql_fetch_assoc($result1);
						print "R".$acc_field['balance'];
						print "</td><td>";
						print "";
						print "</tr>";
					}
				echo "</table>"; //Ends The Table 
			}
		else {
			echo "Not Authorised";
		}
			mysql_close($db_handle);
	?>

<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
</body>
</html>
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

<h1>Logbooks Reports:</h1>
<form id="form1" name="form1" method="post" action="logbooks.php">
  <select name="glider" id="glider">
  <option></option>
      <?php
	  	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
		
	  	$query = "SELECT reg, callsign FROM tbl_gliders;";
		$result = mysql_query($query)
			or die ("Query Failed: " . mysql_error());
		while ($row_c = mysql_fetch_array($result))
		{
			echo "<option>", $row_c['reg']." ".$row_c['callsign'],"</option>";	
		}
      	mysql_close($db_handle);
      ?>
  </select>
  <input type="submit" name="load" id="load" value="Load" />
</form>
<p>&nbsp;</p>
<?php
	include('connect.php');
	
	if (isset($_POST['load'])) {
		$gliderselect = explode(" ",$_POST['glider']);
		$glider = $gliderselect[0];
		
		
		$query = "SELECT * FROM tbl_gliders WHERE reg='$glider'";
		$result = mysql_query($query);
    	print "<table border='1' width='800' cellpadding='5' cellspacing='5'>";
  		
		$db_field = mysql_fetch_assoc($result); 
			print "<tr><td>Glider Registration: ".$db_field['reg']."</td><td>Glider Type: ".$db_field['type_name']."</td></tr>";
			print "<tr><td>Glider Callsign: ".$db_field['callsign']."</td><td></td></tr>";
			print "<tr><td><strong>Maintanance Info: </strong></br>
				Authority To Fly: ".$db_field['auth_fly']."</br>
				LS1 Expiry Date: ".$db_field['ls1_exp']."</br>
			</td><td><strong>Aircraft Info: </strong>
				Hours: ".$db_field['hours']."</br>
				Landings: ".$db_field['land']."</br>
				Launches: ".$db_field['tot_launch']."</br></td></tr>";
			print "<tr><td colspan='2'>Notes: ".$db_field['notes']."</td></tr>";

		print "</table>";
	
	}
	else {
		
	}
	mysql_close($db_handle);
?>
<p align="left"><a href="reports.php"><img src="images/done.jpg"></a></p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved - Version 2.0</p>
</body>
</html>
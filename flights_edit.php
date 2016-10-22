<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GlideMan</title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
<?php
	
	
	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	include('functions.php');//Include the functions page
	//$edit_ID = $_GET['flight_no'];
	//echo $edit_ID;

	if ($_SESSION['authorised'] == "Normal" || $_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
		$session_message = "Logged in as: " . $_SESSION['name'];
		if (isset($_POST['save'])) {
			$update_ID = $_POST['update_ID'];//Different to flight_no and edit_ID to avoid a Indefined Index error, since I am using both _GET and _POST
			$timesheet = $_POST['timesheet'];
			$date = $_POST['date'];
			$take_off_time = $_POST['take_off_time'];
			$landing_time = $_POST['landing_time'];
			$flight_duration = $_POST['flight_duration'];
			$p1 = $_POST['p1'];
			$p2 = $_POST['p2'];
			$pax_name_surname = $_POST['pax_name_surname'];
			$payment_resp = $_POST['payment_resp'];
			$launch_method = $_POST['launch_method'];
			// Read only the first part of the selector for Glider which would be the registration and assign it to glider variable
			$gliderselect = explode(" ",$_POST['glider_reg']);
			$glider_reg = $gliderselect[0];// $glider variable gets aircraft registration (reg)
			$no_landings = $_POST['no_landings'];
			$flight_type = $_POST['flight_type'];
			$tug_time = $_POST['tug_time'];
			$tacho_start = $_POST['tacho_start'];
			$tacho_end = $_POST['tacho_end'];
			
			//testing
			//echo "$timesheet", " ", "$date", " ", "$take_off_time", " ", "$landing_time", " ", "$flight_duration",  " ", "$p1";
			//echo " ", "$p2", " ", "$pax_name_surname", " ", "$payment_resp", " ", "$launch_method", " ", "$glider_reg", " ", "$no_landings";
			//echo " ", "$instruction_flight", "</br>";
				runQuery("UPDATE tbl_flights SET timesheet ='$timesheet', date = '$date', glider_reg = '$glider_reg', flight_duration = '$flight_duration', payment_resp = '$payment_resp', 
					pax_name_surname = '$pax_name_surname', p1 = '$p1', p2 = '$p2', flight_type = '$flight_type', 
					take_off_time = '$take_off_time', landing_time = '$landing_time', tug_time = '$tug_time', no_landings = '$no_landings', launch_method = '$launch_method', tacho_start = '$tacho_start', tacho_end = '$tacho_end'
					WHERE flight_no = $update_ID");
				//echo $query; //Tested the query by echoing it
				//$result = mysql_query($query)
					//or die("Query Failed: " . mysql_error());// Displays the error if the SQL Query does not succeed.
				echo "Flight Successfully Edited </br>";
		
			

			//Show Flights entered for specified timesheet in Table
			print "Time Sheet: ".$timesheet;
			$query = "SELECT * FROM tbl_flights WHERE timesheet='$timesheet'";
			$result = mysql_query($query);
			print "<table border='1' width='800' cellpadding='5' cellspacing='5'>";
			print "<tr><td>Flight No</td><td>Date</td><td>Glider</td><td>Duration</td><td>Payment</td><td>P1</td><td>P2</td><td>Flight Type</td><td>Take Off</td><td>Landing</td><td>No Landings</td><td>Launch Method</td><td>Tug Time</td><td>Tacho Start</td><td>Tacho End</td><td colspan='2'>Action</td></tr>";
			
			//All the information from the flights table for the specified timesheet is inserted into an array and then displayed in a table
			while ($db_field = mysql_fetch_assoc($result)) {
					$flight_no = $db_field['flight_no'];//creates a member ID variable to pass in the URL of the Edit and Delete Links
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
					print "</td><td>";
					print "<a href=flights_edit.php?flight_no=$flight_no&update=yes>Edit</a>";
					print "</td><td>";
					print "<a href=flights_del.php?flight_no=$flight_no&delete=yes>Delete</a></td>";
					print "</tr>";
				}
			echo "</table>"; //Ends The Table
			echo "<p><a href=flights_add.php?timesheet=$timesheet_encoded>| Add Flight |</a></p>";
			
		}
		else {
			//Display the details of the flight in the DB using the variable passed through the URL
			$edit_ID = $_GET['flight_no'];
			$flightarray = callQuery("SELECT * FROM tbl_flights WHERE flight_no = '$edit_ID'");
			$update_ID = $edit_ID;//assign another variable to use as the ID, this is so that the form can be posted using the ID as Hidden item.
			$timesheet = $flightarray['timesheet'];
			$date = $flightarray['date'];
			$take_off_time = $flightarray['take_off_time'];
			$landing_time = $flightarray['landing_time'];
			$flight_duration = $flightarray['flight_duration'];
			$p1 = $flightarray['p1'];
			$p2 = $flightarray['p2'];
			$pax_name_surname = $flightarray['pax_name_surname'];
			$payment_resp = $flightarray['payment_resp'];
			$launch_method = $flightarray['launch_method'];
			$glider_reg = $flightarray['glider_reg'];
			$no_landings = $flightarray['no_landings'];
			$flight_type = $flightarray['flight_type'];
			$tug_time = $flightarray['tug_time'];
			$tacho_start = $flightarray['tacho_start'];
			$tacho_end = $flightarray['tacho_end'];
		}
	
	}
	
	else {
			$session_message = "Not Logged in";
		}
	
	mysql_close($db_handle);
	
?>
</head>

<body>
<p><strong><?php print $session_message; ?></strong></p>
<p><strong>Edit flight.</strong></p>

<form id="form1" name="form1" method="post" action="flights_edit.php">
<input type="hidden" name="update_ID" value="<?php echo $update_ID; ?>">
<td>
	<!-- Create a Drop Down list from available Timesheets on the form -->
<select name="timesheet" id="timesheet" />
			<!-- Here is a Piece of PHP code that will insert the Timesheet as an already selected option if A 
			Timesheet has already been specified -->
			<?php
			if (isset($timesheet)) {
				echo "<option selected>$timesheet</option>";
			}
			?>
      		<option></option>
      <?php
	  	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
		
	  	$query = "SELECT sheet_no, date FROM tbl_timesheets WHERE locked = 'N';";
		$result = mysql_query($query)
			or die ("Query Failed: " . mysql_error());
		while ($row_c = mysql_fetch_array($result))
		{
			echo "<option>", $row_c['sheet_no']." ".$row_c['date'],"</option>";	
		}
      	mysql_close($db_handle);
      ?></select>
</td>
  <table width="800" border="0" cellspacing="5" cellpadding="5">
    <tr>
      <td>Date : </td>
      <td><input type="text" name="date" id="date" value="<?php echo $date; ?>" /></td>
      <td>Take off Time : </td>
      <td><input type="text" name="take_off_time" id="take_off_time" value="<?php echo $take_off_time; ?>" /></td>
    </tr>
    <tr>
      <td>Glider :</td>
      <!-- Create a Drop Down Selection from all Gliders in the Database -->
      <td><select name="glider_reg" id="glider_reg" />
      		<option></option>
      <?php
	  	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
		echo "<option selected>$glider_reg</option>";
	  	$query = "SELECT reg, callsign FROM tbl_gliders;";
		$result = mysql_query($query)
			or die ("Query Failed: " . mysql_error());
		//$memberarray = mysql_fetch_array($result13);
		while ($row_c = mysql_fetch_array($result))
		{
			echo "<option>", $row_c['reg']." ".$row_c['callsign'],"</option>";	
		}
      	mysql_close($db_handle);
      ?></select></td>
      <td>Landing Time : </td>
      <td><input type="text" name="landing_time" id="landing_time" value="<?php echo $landing_time; ?>" /></td>
    </tr>
    <tr>
      <td>P1 (PIC):</td>
      <td><select name="p1" id="p1">
      		<option></option>
      <?php
	  	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	  	echo "<option selected>$p1</option>";
	  	$query = "SELECT mem_no, name, surname FROM tbl_members WHERE active='Y' ORDER BY name ASC;";
		$result = mysql_query($query)
			or die ("Query Failed: " . mysql_error());
		//$memberarray = mysql_fetch_array($result13);
		while ($row = mysql_fetch_array($result))
		{
			echo "<option>", $row['mem_no']." ".$row['name']." ".$row['surname'],"</option>";	
		}
      	mysql_close($db_handle);
      ?>
      </select></td>
      <td>P2 :</td>
      <td><select name="p2" id="p2">
      		<option></option>
      <?php
	  	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
		echo "<option selected>$p2</option>";
	  	$query = "SELECT mem_no, name, surname FROM tbl_members WHERE active='Y' ORDER BY name ASC;";
		$result = mysql_query($query)
			or die ("Query Failed: " . mysql_error());
		//$memberarray = mysql_fetch_array($result13);
		while ($row = mysql_fetch_array($result))
		{
			echo "<option>", $row['mem_no']." ".$row['name']." ".$row['surname'],"</option>";	
		}
      	mysql_close($db_handle);
      ?>
      </select></td>
    </tr>
    <tr>
      <td>Paying Pilot : </td>
      <td><select name="payment_resp" id="payment_resp">
      		<?php
      			echo "<option selected>$payment_resp</option>";
      		?>
      		<option></option>
            <option>P1</option>
     		<option>P2</option>
            <option>PAX</option>
            <option>OWNER_P1</option>
            <option>OWNER_P2</option>
            <option>SPLIT</option>
      </select></td>
      <td>Pax Name & Surname:</td>
      <td><input type="text" name="pax_name_surname" id="pax_name_surname" value="<?php echo $pax_name_surname; ?>" /></td>
    </tr>
    <tr>
      <td>Duration : (Specified in decimal)</td>
      <td><input type="text" name="flight_duration" id="flight_duration" value="<?php echo $flight_duration; ?>" /></td>
      <td>Flight Type :</td>
      <td><select name="flight_type" id="flight_type">
      		<?php
      			echo "<option selected>$flight_type</option>";
      		?>
      		<option>Normal</option>
            <option>Instruction</option>
     		<option>Flight Test</option>
            <option>Check Flight</option>
            <option>PAX</option>
      </select></td>
    </tr>
    <tr>
      <td>Launch Method : </td>
      <td><select name="launch_method" id="launch_method">
        <option></option>
        <?php
	  			include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
				echo "<option selected>$launch_method</option>";
				//Query the Winch Table for Winch Names to provide in the selection list for launch method.
				$query = "SELECT name FROM tbl_winches;";
				$result = mysql_query($query)
						or die ("Query Failed: " . mysql_error());
				while ($w_row = mysql_fetch_array($result))
				{
						echo "<option>", $w_row['name'],"</option>";	
				}
				//Query the Tugs table for Tug Registrations to provide in the selection list for launch method.
				$query = "SELECT tug_reg FROM tbl_tugs;";
				$result = mysql_query($query)
						or die ("Query Failed: " . mysql_error());
				
				while ($t_row = mysql_fetch_array($result))
				{
						echo "<option>", $t_row['tug_reg']." Tug","</option>";	
				}
				mysql_close($db_handle);
      		?> 
        <option>Self</option>
        <option>Vehicle</option>
      </select></td>
      <td>Tug Tacho Time:</td>
      <td><input type="text" name="tug_time" id="tug_time" value="<?php echo $tug_time; ?>" /></td>
    </tr>
    <tr>
      <td>Number of Landings : </td>
      <td><input type="text" name="no_landings" id="no_landings" value="<?php echo $no_landings; ?>" /></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<tr>
      <td colspan='4'><strong>------------------------------------------</strong></td>
    </tr>
	<tr>
      <td><strong>Only required for TMG</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
	<tr>
      <td>Tacho Start : </td>
      <td><input type="text" name="tacho_start" id="tacho_start" value="<?php echo $tacho_start; ?>" /></td>
      <td>Tacho End : </td>
      <td><input type="text" name="tacho_end" id="tacho_end" value="<?php echo $tacho_end; ?>" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center"><input type="submit" name="save" id="save" value="Save" /></td>
      <td align="center"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>

<p align="left"><a href="flights.php"><img src="images/done.jpg"></a></p>
<p>&nbsp;</p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved - Version 2.0</p>

</body>
</html>
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
	include('functions.php');//Includes the function page
	if (isset($_POST['save'])) {	
		if (isset($_SESSION['authorised'])) {
			$snag_date = $_POST['snag_date'];
			$equipment_lst = $_POST['equipment_lst'];
			$prob_descr = $_POST['prob_descr'];
			$mem_no = $_SESSION['mem_no'];
			$status = $_POST['status'];
			if ($_SESSION['authorised'] == "Normal" || $_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
				runQuery("INSERT INTO tbl_snags (date, aircraft_equip_name, notes, member_no, status) VALUES('$snag_date', '$equipment_lst', '$prob_descr','$mem_no', '$status');");
					echo "Snag Successfully Added";
					$change_made = "Added a Problem With ".$equipment_lst;
					addHistory($_SESSION['mem_no'], $change_made, "Snags");
				
			}
			else {
				echo "You are not logged in";	
			}
		}
		else {
			echo "You are not logged in. Snag not created";	
		}
						
	}
	else {
		$snag_date = "YYYY-MM-DD";
	}
	mysql_close($db_handle);//Closes the Databse Handle since we are finished with it for now
?>
</head>

<body>
<form id="snagform" method="post" name="snagform" action="snag_add.php">

<table width="800" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td width="302">Aircraft Registration or Equipment Name : </td>
    <td width="463"><select name="equipment_lst" id="equipment_lst" tabindex="1">
    		<option></option>
            <?php
	  			include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
				//Query the Winch Table for Winch Names to provide in the selection list for equipment with problems.
				$query = "SELECT name FROM tbl_winches;";
				$result = mysql_query($query)
						or die ("Query Failed: " . mysql_error());
				while ($w_row = mysql_fetch_array($result))
				{
						echo "<option>", $w_row['name'],"</option>";	
				}
				//Query the Gliders table for Glider Registrations to provide in the selection list for equipment with problems.
	  			$query = "SELECT reg, callsign FROM tbl_gliders;";
				$result = mysql_query($query)
						or die ("Query Failed: " . mysql_error());
				
				while ($row_d = mysql_fetch_array($result))
				{
						echo "<option>", $row_d['reg']." ".$row_d['callsign'],"</option>";	
				}
				//Query the Tugs table for Tug Registrations to provide in the selection list for equipment with problems.
				$query = "SELECT tug_reg FROM tbl_tugs;";
				$result = mysql_query($query)
						or die ("Query Failed: " . mysql_error());
				
				while ($t_row = mysql_fetch_array($result))
				{
						echo "<option>", $t_row['tug_reg']." Tug","</option>";	
				}
				mysql_close($db_handle);
      		?>   
   		</select></td>
  </tr>
  <tr>
    <td>Date :</td>
    <td><input type="text" name="snag_date" id="snag_date" tabindex="2" value = "<?php echo $snag_date; ?>"/></td>
  </tr>
  <tr>
    <td>Problem Description:</td>
    <td><textarea name="prob_descr" id="prob_descr" cols="45" rows="5" tabindex="3"></textarea></td>
  </tr>
  
  <tr>
    <td>Status:</td>
    <td><select name="status" id="status" tabindex="5">
    		<option selected="selected">New</option>
    		<option>In Progress</option>
            <option>Resolved</option>
    </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="save" id="save" value="Save" tabindex="6" /></td>
  </tr>
</table>
</form>
<p>&nbsp;</p>
<p align="left"><a href="snags.php"><img src="images/done.jpg"></a></p>
<p>&nbsp;</p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved - Version 2.0</p>
</body>
</html>
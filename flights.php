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
	$session_message = "";
	if ($_SESSION['authorised'] == "Normal" || $_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
		if (isset($_POST['list1'])){
			$date1 = $_POST['fromdate'];
			$date2 = $_POST['todate'];
			echo "<a href=flights_date.php?date1=$date1&date2=$date2>Open List</a>";
		}
		elseif (isset($_POST['list2'])){
			$pilot = urlencode($_POST['pilot']);
			echo "<a href=flights_pilot.php?pilot=$pilot>Open List</a>";
		}
		elseif (isset($_POST['list3'])){
			$timesheet = urlencode($_POST['timesheet']);
			echo "<a href=flights_timesheet.php?timesheet=$timesheet>Open List</a>";
		}
		else {
		 echo "";
		 $date1 = "YYYY-MM-DD";
		 $date2 = "YYYY-MM-DD";
		}
	}
	else {
		$session_message = "You are not logged in";
	}
?>

</head>



<body>
<!-- This is the little menu area -->
<p><a href="members.php"><img src="images/members.jpg"></a><a href="flights.php"><img src="images/flights.jpg"></a><a href="accounts.php"><img src="images/accounts.jpg"></a><a href="gliders.php"><img src="images/gliders.jpg"></a><a href="reports.php"><img src="images/logbooks.jpg"></a><a href="snags.php"><img src="images/snags.jpg"></a></p>

<h1>Flights:</h1>
<form id="form1" name="form1" method="post" action="flights.php">
  <table width="800" border="0" cellspacing="5" cellpadding="5">
    <tr>
      <td width="227">From Date : </td>
      <td width="210"><input type="text" name="fromdate" id="fromdate" value="<?php echo $date1; ?>"/></td>
      <td width="313"><input type="submit" name="list1" id="list1" value="Request List" /></td>
      
    </tr>
    <tr>
      <td>To Date :</td>
      <td><input type="text" name="todate" id="todate" value="<?php echo $date2; ?>"/></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</br>
<form id="form2" name="form2" method="post" action="flights.php">
  <table width="800" border="0" cellspacing="5" cellpadding="5">
    <tr>
      <td width="226">Flights by Pilot : </td>
      <td width="209">
      <select name="pilot" id="pilot">
      		<option></option>
       <?php
	  	include('connect.php');
		// Query the members table and insert all the available members into the select option box
	  	$query = "SELECT mem_no, name, surname FROM tbl_members;";
		$result = mysql_query($query)
			or die ("Query Failed: " . mysql_error());
		
		while ($row_p = mysql_fetch_array($result))
		{
			echo "<option>", $row_p['mem_no']." ".$row_p['name']." ".$row_p['surname'],"</option>";	
		}
      	mysql_close($db_handle);
      ?>
      </select>
      </td>
      <td width="315"><input type="submit" name="list2" id="list2" value="Request List" /></td>
    </tr>
  </table>
</form>
</br>
<form id="form3" name="form3" method="post" action="flights.php">
  <table width="800" border="0" cellspacing="5" cellpadding="5">
    <tr>
      <td width="226">Time Sheet : </td>
      <td width="208"><select name="timesheet" id="timesheet" />
      		<option></option>
      <?php
	  	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
		
	  	$query = "SELECT sheet_no, date FROM tbl_timesheets;";
		$result = mysql_query($query)
			or die ("Query Failed: " . mysql_error());
		while ($row_c = mysql_fetch_array($result))
		{
			echo "<option>", $row_c['sheet_no']." ".$row_c['date'],"</option>";	
		}
      	mysql_close($db_handle);
      ?></select></td>
      <td width="316"><input type="submit" name="list3" id="list3" value="Request List" /></td>
    </tr>
  </table>
</form>
<p><strong><?php echo $session_message;?></strong></p>
<p>&nbsp;</p>
<p><a href="timesheet_add.php">| Create Timesheet |</a></p>
<p><a href="flights_add.php">| Add Flight |</a></p>
<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
<p>&nbsp;</p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved - Version 2.0</p>
</body>
</html>
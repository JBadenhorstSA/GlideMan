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
	include ('connect.php');
	include('functions.php');
	if ($_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
	if (isset($_POST['save'])) {
		$date1 = $_POST['fromdate'];
		$date2 = $_POST['todate'];
			$member = explode(" ", $_POST['member']);
			$mem_no = $member[0];
			//$resultarray2 = mysql_fetch_array(mysql_query("SELECT account_no FROM tbl_accounts WHERE mem_id=$mem_id;"));
			//$account_no = $resultarray2['account_no'];

		echo "<a href=statement.php?date1=$date1&date2=$date2&mem_no=$mem_no target='_blank'>Open Statement</a>";
	}
	
	else {
	 	$fromdate = "YYYY-MM-DD";
	 	$todate = "YYYY-MM-DD";
	}
	}
?>

</head>

<body>
<form id="form2" name="form2" method="post" action="statement_comp.php">
  <table width="800" border="0" cellspacing="5" cellpadding="5">
    <tr>
      <td>From Date : </td>
      <td><input type="text" name="fromdate" id="fromdate" value="<?php echo $fromdate; ?>"/></td>
      <td></td>
      
    </tr>
    <tr>
      <td>To Date :</td>
      <td><input type="text" name="todate" id="todate" value="<?php echo $todate; ?>"/></td>
      <td>&nbsp;</td>
    </tr>
     <tr>
      <td>Member : </td>
      <td>
      <select name="member" id="member">
      		<option></option>
       <?php
	  	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
		
	  	$query = "SELECT mem_no, name, surname FROM tbl_members WHERE active='Y' ORDER BY name ASC;";
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
      <td><input type="submit" name="save" id="save" value="Create Statement" /></td>
    </tr>
  </table>
</form>
</br>

<p align="left"><a href="accounts.php"><img src="images/done.jpg"></a></p>
<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved</p>
</body>
</html>
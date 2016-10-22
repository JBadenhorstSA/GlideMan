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
	include ('functions.php');
	if (isset($_POST['show'])) {
		$fromdate = $_POST['fromdate'];
		$todate = $_POST['todate'];
		//echo $_SESSION['name'];
		if ($_SESSION['authorised'] == "Admin") {
			$query = "SELECT * FROM tbl_history WHERE change_date BETWEEN '$fromdate' AND '$todate' ORDER BY change_no DESC;";
			$result = mysql_query($query);
			print "<table border='1' width='800' cellpadding='5' cellspacing='5'>";
		  	print "<tr><td>Change No</td><td>Changer Member No</td><td>Change Made</td><td>Date of Change</td><td>Table Changed</td></tr>";
			
			while ($db_field = mysql_fetch_assoc($result)) {
					print "<tr><td>";
					print $db_field['change_no'];
					print "</td><td>";
					print $db_field['changer_mem_no'];
					print "</td><td>";
					print $db_field['change_made'];
					print "</td><td>";
					print $db_field['change_date'];
					print "</td><td>";
					print $db_field['change_table'];
					print "</td>";
					print "</tr>";
				}
			echo "</table>"; //Ends The Table 
			
		}
		
		
	}
	mysql_close($db_handle);
?>
</head>

<body>
	<p>Show System History</p>
	<form id="form1" name="form1" method="post" action="view_history.php">
  	<table width="800" border="0" cellspacing="5" cellpadding="5">
    	<tr>
      		<td width="227">From Date : </td>
     		<td width="210"><input type="text" name="fromdate" id="fromdate" value="YYYY-MM-DD" /></td>
      		<td width="313"><input type="submit" name="show" id="show" value="Show History" /></td>
      
    	</tr>
    	<tr>
	      <td>To : Date :</td>
	      <td><input type="text" name="todate" id="todate" value="YYYY-MM-DD" /></td>
	      <td>&nbsp;</td>
    	</tr>
  </table>
</form>
</br>


<p align="left"><a href="view_history.php">Cancel</a></p>
<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GlideMan</title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />

<?php
	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.

	if (isset($_POST['save'])) {
			$memlist = explode(" ", $_POST['memlist']);
			$mem_no = $memlist[0];
			$bal = $_POST['bal'];
			
			//testing
			//echo "$memlist", " balance: ", "$bal", "</br>";
				$query31 = "INSERT INTO tbl_accounts (mem_no, balance) VALUES('$mem_no', '$bal');";// 
				
				//echo $query1; //Tested the query by echoing it
				$result31 = mysql_query($query31)
					or die("Query Failed: " . mysql_error());// Displays the error if the SQL Query does not succeed.
				echo "Account Successfully created";
	}
	else {
		// If the save button has been clicked show the values entered , Otherwise, show clean new fields.
		$memlist = "";
			$bal = "";
			
		}
	
	mysql_close($db_handle);
?>

</head>

<body>
<p>Select a member id and select an initial balance for the account</p>
<form action="account_add.php" method="post" name="add_account" id="add_account">
<table width="800" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td width="145">&nbsp;</td>
    <td width="620">&nbsp;</td>
  </tr>
  <tr>
    <td>Member ID:</td>
    <td><select name="memlist" id="memlist">
    	<option></option>
    <?php
	  	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
		
	  	$query30 = "SELECT mem_no, name, surname FROM tbl_members;";
		$result30 = mysql_query($query30)
			or die ("Query Failed: " . mysql_error());
		while ($row = mysql_fetch_array($result30))
		{
			echo "<option>", $row['mem_no']." ".$row['name']." ".$row['surname'],"</option>";	
		}
      	mysql_close($db_handle);
      ?>
    </select></td>
  </tr>
  <tr>
    <td><p>Initial Balance:</p></td>
    <td><input type="text" name="bal" id="bal" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="save" id="save" value="Save" /></td>
  </tr>
</table>
</form>

<p align="left"><a href="accounts.php"><img src="images/done.jpg"></a></p>
<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved</p>
</body>
</html>
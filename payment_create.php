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
include('functions.php');
if ($_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
if (isset($_POST['save'])) {
			//Determine the payment number
			$member = explode(" ", $_POST['member']);
			$mem_no = $member[0];
			$resultarray2 = mysql_fetch_array(mysql_query("SELECT account_no FROM tbl_accounts WHERE mem_no=$mem_no;"));
			$account_no = $resultarray2['account_no'];
			$pdate = $_POST['pdate']; 
			$desc = $_POST['desc'];
			$ammount = $_POST['ammount'];
				
		//Update the details in the DB with the details specified. 
		$query = "INSERT INTO tbl_payments (account_no, pdate, description, ammount) VALUES('$account_no', '$pdate', '$desc', '$ammount');";
		$result = mysql_query($query);
		
		//Update balance in the accounts table
		$balresultarray = mysql_fetch_array(mysql_query("SELECT balance FROM tbl_accounts WHERE account_no=$account_no;"));
			$old_balance = $balresultarray['balance'];
			$new_balance = $old_balance - $ammount;
			$query = "UPDATE tbl_accounts SET balance='$new_balance' WHERE account_no = '$account_no'";
			$result = mysql_query($query);
	
		echo "Payment on account number: ".$account_no." for member number: ".$mem_no."</br> Recorded Successfully";	
		
		$resultarray1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS 'total' FROM tbl_payments"));
		$payment_no = $resultarray1['total'] + 1;
	
	}
	else {
	//Show Empty Variables
			$resultarray1 = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS 'total' FROM tbl_payments"));
			$payment_no = $resultarray1['total'] + 1;
	}
}
	mysql_close($db_handle);
?>

</head>

<body>

<form id="form1" name="form1" method="post" action="payment_create.php">
<table width="800" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td>&nbsp;</td>
    <td>Payment Number: <?php echo "$payment_no"; ?></td>
  </tr>
  <tr>
    <td>Member: </td>
    <td><select name="member" id="member">
      		<option></option>
      <?php
	  	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
		
	  	$query = "SELECT mem_no, name, surname FROM tbl_members;";
		$result = mysql_query($query)
			or die ("Query Failed: " . mysql_error());
		while ($row = mysql_fetch_array($result))
		{
			echo "<option>", $row['mem_no']." ".$row['name']." ".$row['surname'],"</option>";	
		}
      	mysql_close($db_handle);
      ?>
      </select>
      </td>
  </tr>
  <tr>
    <td>Date (YYYY-MM-DD)</td>
    <td><input type="text" name="pdate" id="pdate" tabindex="2" /></td>
  </tr>
  <tr>
    <td>Payment Description : </td>
    <td><input type="text" name="desc" id="desc" tabindex="3" /></td>
  </tr>
  <tr>
    <td>Amount: </td>
    <td>R
        <input type="text" name="ammount" id="ammount" tabindex="4" />
    </td>
  </tr>
  <tr><td><input type="submit" name="save" id="save" value="Save" /></td></tr>
</table>
<p align="left">&nbsp;</p>
<p align="left">&nbsp;</p>
</form>
<p align="left"><a href="accounts.php"><img src="images/done.jpg"></a></p>
<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved - Version 2.0</p>
</body>
</html>
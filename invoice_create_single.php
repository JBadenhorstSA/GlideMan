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
				$invoice_no = $_POST['invoice_no'];
				$member = $_POST['member'];
				$member_array = explode(" ", $_POST['member']);
				$mem_no = $member_array[0];
				$mem_array = callQuery("SELECT name, surname FROM tbl_members WHERE mem_no='$mem_no';");
				$name = $mem_array['name'];
				$surname = $mem_array['surname'];
				$idate = $_POST['idate'];
				$description = $_POST['description'];
				$amount = $_POST['amount'];
				
				
				//Update the Account Balance for the member
				$account_array = callQuery("SELECT account_no, balance FROM tbl_accounts WHERE mem_no='$mem_no';");
				$new_balance = $account_array['balance'] + $amount;
				$account_no = $account_array['account_no'];
				runQuery("UPDATE tbl_accounts SET balance='$new_balance' WHERE mem_no = '$mem_no'");
				
				//Create the Credit note by inserting a Record in the credit Note Table and one in the Credit note items Table
				runQuery("INSERT INTO tbl_invoices (idate, account_no, mem_name, mem_surname, tot_ammount) VALUES('$idate', '$account_no', '$name', '$surname', '$amount');");				
				//This query inserts all items for the credit notes items table - Inserts detail for the credit Note
				$inv_item_no_counter = 1;
				runQuery("INSERT INTO tbl_inv_items (inv_no, item_no, item_descr, item_ammount) VALUES('$invoice_no', '$inv_item_no_counter', '$description', '$amount');");
					
				$change_made = "Invoice Created For ".$member." Amount: R".$amount;
				echo $change_made;
				//Create an Entry in the History Table
				addHistory($_SESSION['mem_no'], $change_made, "Invoices");
				
		}
		else {
			// If the save button has been clicked show the names entered , Otherwise, show clean new fields.
				$idate = "YYYY-MM-DD";
		}
		mysql_close($db_handle);
	}
?>

</head>

<body>
<strong>Quick Invoice - Single Item</strong>
<form action="invoice_create_single.php" method="post" name="frm_credit" id="frm_credit">
<table width="400" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td>
    	Invoice No:
    </td>
    <td>
    	<?php 
		include('connect.php');
		//Find out the what the next credit note number will be to display;
		$resultarray = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS 'total' FROM tbl_invoices;"));
		$invoice_no = $resultarray['total'] + 1;
		echo "<input type='text' name='invoice_no' id='invoice_no' value='$invoice_no'/>"
		 ?>
    </td>
  </tr>
  <tr>
    <td>
    	Invoice Date:
    </td>
    <td>
    	<input type="text" name="idate" id="idate" value="<?php echo $idate; ?>"/>
    </td>
  </tr>
  <tr>
    <td>
    	Member:
    </td>
    <td>
    	<select name="member" id="member">
    <option></option>
    <?php
	  	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	  	$query = "SELECT mem_no, name, surname FROM tbl_members WHERE active='Y' ORDER BY name ASC;";
		$result = mysql_query($query)
			or die ("Query Failed: " . mysql_error());
		while ($row_m = mysql_fetch_array($result))
		{
			echo "<option>", $row_m['mem_no']." ".$row_m['name']." ".$row_m['surname'],
			"</option>";	
		}
      	mysql_close($db_handle);
      ?>
    </select>
    </td>
  </tr>
  <tr>
    <td>
    	Description:
    </td>
    <td>
    	<input type="text" name="description" id="description" />
    </td>
  </tr>
  <tr>
    <td>
    	Amount:
    </td>
    <td>
    	<input type="text" name="amount" id="amount" />
    </td>
  </tr>
</table>
 <p>
   <input type="submit" name="save" id="save" value="Save" />
 </p>

</p>
</form>

<p align="left"><a href="accounts.php"><img src="images/done.jpg"></a></p>
<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved - Version 2.0</p>
</body>
</html>
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

	if ($_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
		if (isset($_POST['save'])) {
				$descr = $_POST['descr'];
				$cost = $_POST['cost'];
				$charge = $_POST['charge'];
				
				$itemquery = "INSERT INTO tbl_items (item_descr, item_cost, item_charge) VALUES('$descr', '$cost', '$charge');";
					
					//echo $query1; //Tested the query by echoing it
					$itemresult = mysql_query($itemquery)
						or die("Query Failed: " . mysql_error());// Displays the error if the SQL Query does not succeed.
					echo "Item Successfully Added </br>";		
		}
		else {
			// If the save button has been clicked show the detailes entered , Otherwise, show clean new fields.
			$descr = "";
				$cost = "";
				$charge = "";	
			}
		$session_message = "You are Logged in as: ".$_SESSION['name'];	
		//Display Table with Items available
		$query = "SELECT * FROM tbl_items;";
		$result = mysql_query($query);
		print "<table border='1' width='800' cellpadding='5' cellspacing='5'>";
  		print "<tr><td>Item No</td><td>Item Description</td><td>Item Cost</td><td>Item Charge</td><td colspan='2'>Action</td></tr>";
		while ($db_field = mysql_fetch_assoc($result)) {
				$item_no = $db_field['item_no'];//creates a member ID variable to pass in the URL of the Edit and Delete Links
				print "<tr><td>";
				print $db_field['item_no'];
				print "</td><td>";
				print $db_field['item_descr'];
				print "</td><td>";
				print $db_field['item_cost'];
				print "</td><td>";
				print $db_field['item_charge'];
				print "</td><td>";
				print "<a href=items_edit.php?item_no=$item_no&update=yes>Edit</a>";
				print "</td><td>";
				print "<a href=items_del.php?item_no=$item_no&delete=yes>Delete</a></td>";
				print "</tr>";
		}
	}
	else {
		$session_message = "You are not Logged in";
	}

	mysql_close($db_handle);

?>

</head>

<body>
<?php echo $session_message; ?>
<p><strong>Add a new Item:</strong></p>
<form id="additem" name="addmem" method="post" action="items_add.php">
  <table width="800" border="0" cellspacing="5" cellpadding="5">
    <tr>
      <td>Item Description :</td>
      <td>
        <input type="text" name="descr" id="descr" />
      </td>
      
    </tr>
    <tr>
      <td>Item Cost : </td>
      <td>R<input type="text" name="cost" id="cost" /></td>
      
    </tr>
    <tr>
      <td>Item Charge : </td>
      <td>R<input type="text" name="charge" id="charge" /></td>
      
    </tr>
   
    <tr>
     
      <td><input type="submit" name="save" id="button" value="Save" /></td>
    </tr>
  </table>
</form>
<p align="left"><a href="accounts.php"><img src="images/done.jpg"></a></p>
<p>&nbsp;</p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved Version 2.0</p>

</body>
</html>
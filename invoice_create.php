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
				$resultarray7 = callQuery("SELECT COUNT(*) AS 'total' FROM tbl_invoices");
				$invoice_no = $resultarray7['total'] + 1;

				$member = explode(" ", $_POST['member']);
				$mem_no = $member[0];
				$idate = $_POST['idate'];
				//echo $mem_id, "| |";
				$resultarray = mysql_fetch_array(mysql_query("SELECT account_no FROM tbl_accounts WHERE mem_no=$mem_no;"));
				$account_no = $resultarray['account_no'];
				$resultarray1 = mysql_fetch_array(mysql_query("SELECT name, surname FROM tbl_members WHERE mem_no=$mem_no;"));
				$mem_name = $resultarray1['name'];
				$mem_surname = $resultarray1['surname'];

				//Each Item has a section that gets information from the item selected in the form field and 
				//then uses that information to query the db and get all the relevant other info for each item
				//This first part is for item 1
				$item1 = explode(" ", $_POST['item1']);
				$item_no1 = $item1[0];
				$resultarray2 = mysql_fetch_array(mysql_query("SELECT item_descr, item_charge FROM tbl_items WHERE item_no=$item_no1;"));
				$item_descr1 = $resultarray2['item_descr'];
				$item_ammount1 = $resultarray2['item_charge'];
				
				//Item 2
				$item_descr2 = "";
				$item_ammount2 = "";
				if ($_POST['item2'] <> ""){
					$item2 = explode(" ", $_POST['item2']);
					$item_no2 = $item2[0];
					$resultarray3 = mysql_fetch_array(mysql_query("SELECT item_descr, item_charge FROM tbl_items WHERE item_no=$item_no2;"));
					$item_descr2 = $resultarray3['item_descr'];
					$item_ammount2 = $resultarray3['item_charge'];
					$query11 = "INSERT INTO tbl_inv_items (inv_no, item_no, item_descr, item_ammount) VALUES('$invoice_no', '$item_no2', '$item_descr2', '$item_ammount2')";
					$result11 = mysql_query($query11)
						or die("Query Failed: " . mysql_error());
				}
				
				
				//Item 3
				$item_descr3 = "";
				$item_ammount3 = "";
				if ($_POST['item3'] <> ""){
					$item3 = explode(" ", $_POST['item3']);
					$item_no3 = $item3[0];
					$resultarray4 = mysql_fetch_array(mysql_query("SELECT item_descr, item_charge FROM tbl_items WHERE item_no=$item_no3;"));
					$item_descr3 = $resultarray4['item_descr'];
					$item_ammount3 = $resultarray4['item_charge'];
					$query12 = "INSERT INTO tbl_inv_items (inv_no, item_no, item_descr, item_ammount) VALUES('$invoice_no', '$item_no3', '$item_descr3', '$item_ammount3')";
					$result12 = mysql_query($query12)
						or die("Query Failed: " . mysql_error());
				}
				
				//Item 4
				$item_descr4 = "";
				$item_ammount4 = "";
				if ($_POST['item4'] <> ""){
					$item4 = explode(" ", $_POST['item4']);
					$item_no4 = $item4[0];
					$resultarray5 = mysql_fetch_array(mysql_query("SELECT item_descr, item_charge FROM tbl_items WHERE item_no=$item_no4;"));
					$item_descr4 = $resultarray5['item_descr'];
					$item_ammount4 = $resultarray5['item_charge'];
					$query13 = "INSERT INTO tbl_inv_items (inv_no, item_no, item_descr, item_ammount) VALUES('$invoice_no', '$item_no4', '$item_descr4', '$item_ammount4')";
					$result13 = mysql_query($query13)
						or die("Query Failed: " . mysql_error());
				}
				
				//Item 5
				$item_descr5 = "";
				$item_ammount5 = "";
				if ($_POST['item5'] <> ""){
					$item5 = explode(" ", $_POST['item5']);
					$item_no5 = $item5[0];
					$resultarray6 = mysql_fetch_array(mysql_query("SELECT item_descr, item_charge FROM tbl_items WHERE item_no=$item_no5;"));
					$item_descr5 = $resultarray6['item_descr'];
					$item_ammount5 = $resultarray6['item_charge'];
					$query14 = "INSERT INTO tbl_inv_items (inv_no, item_no, item_descr, item_ammount) VALUES('$invoice_no', '$item_no5', '$item_descr5', '$item_ammount5')";
					$result14 = mysql_query($query14)
						or die("Query Failed: " . mysql_error());
				
				}
				
				//This part totals the ammount for all items and updates the balance in the accounts table
				$tot_amnt = $item_ammount1 + $item_ammount2 + $item_ammount3 + $item_ammount4 + $item_ammount5;
				$balresultarray = mysql_fetch_array(mysql_query("SELECT balance FROM tbl_accounts WHERE account_no=$account_no;"));
				$old_balance = $balresultarray['balance'];
				$new_balance = $old_balance + $tot_amnt;
				$query16 = "UPDATE tbl_accounts SET balance='$new_balance' WHERE account_no = '$account_no'";
				$result16 = mysql_query($query16);
				
				
				//echo $account_no;
				
				//testing
				//echo "$idate", " ", "$account_no", " ", "$mem_name", " ", "$mem_surname",  "</br>";
					$query36 = "INSERT INTO tbl_invoices (idate, account_no, mem_name, mem_surname, tot_ammount) VALUES('$idate', '$account_no', '$mem_name', '$mem_surname', '$tot_amnt');";// 
					//echo $query1; //Tested the query by echoing it
					$result36 = mysql_query($query36)
						or die("Query Failed: " . mysql_error());// Displays the error if the SQL Query does not succeed.
					
					//This query inserts all the items selected into the in_items table
					$query37 = "INSERT INTO tbl_inv_items (inv_no, item_no, item_descr, item_ammount) VALUES('$invoice_no', '$item_no1', '$item_descr1', '$item_ammount1')";
					$result37 = mysql_query($query37)
						or die("Query Failed: " . mysql_error());


						  	//This part of the table is completed automatically. This is the invoice display
			  	print "<table width=800 border=1 cellspacing=5 cellpadding=5>";
			  	print "<tr>";
			  	print "<td>";
			  		echo "<strong>Invoice Date: ".$idate."</strong>";
			  		echo "<br />";
			  		echo "<br />Member Number:".$mem_no;
			  		echo "<br />Member Name: ".$mem_name;
			  		echo "<br />Member Surname: ".$mem_surname;
			  		echo "<br />Account Number :".$account_no;
			  	print "</td>";
			  	print "<td>";
			  		echo "AKAVLIEG Potchefstroom Gliding";
			  		echo "<br />Potchefstroom Airfield";
			  		echo "<br />";
			  		echo "<br /><img src=images/avplogo.JPG height=60 width=70>";
			  	print "</td>";
			  	print "</tr>";
			  	print "</table>";
			  	//This is the table for the independant invoice items displayed on the invoice
			  	print "<table width=800 border=0 cellspacing=5 cellpadding=5>";
			  	print "<tr>";
			  	print "<td>";
			  		echo "Item No";
			  	print "</td>";
			  	print "<td>";
			  		echo "Item Description";
			  	print "</td>";
			  	print "<td align=right>";
			  		echo "Item Amount";
			  	print "</td>";
			  	print "</tr>";
			  	print "<tr>";
			  	print "<td>";
			  		echo $item_no1;
			  	print "</td>";
			  	print "<td>";
			  		echo $item_descr1;
			  	print "</td>";
			  	print "<td align=right>";
			  		echo "R".$item_ammount1;
			  	print "</td>";
			  	print "</tr>";
			  	print "<tr>";
			  	print "<td>";
			  		echo $item_no2;
			  	print "</td>";
			  	print "<td>";
			  		echo $item_descr2;
			  	print "</td>";
			  	print "<td align=right>";
			  		if ($_POST['item2'] <> ""){
			  		echo "R".$item_ammount2;
			  		}
			  	print "</td>";
			  	print "</tr>";
			  	
			  	print "<tr>";
			  	print "<td>";
			  		echo $item_no3;
			  	print "</td>";
			  	print "<td>";
			  		echo $item_descr3;
			  	print "</td>";
			  	print "<td align=right>";
			  		if ($_POST['item3'] <> ""){
			  		echo "R".$item_ammount3;
			  		}
			  	print "</td>";
			  	print "</tr>";
			  	print "<tr>";
			  	print "<td>";
			  		echo $item_no4;
			  	print "</td>";
			  	print "<td>";
			  		echo $item_descr4;
			  	print "</td>";
			  	print "<td align=right>";
			  		if ($_POST['item4'] <> ""){
			  		echo "R".$item_ammount4;
			  		}
			  	print "</td>";
			  	print "</tr>";
			  	print "<tr>";
			  	print "<td>";
			  		echo $item_no5;
			  	print "</td>";
			  	print "<td>";
			  		echo $item_descr5;
			  	print "</td>";
			  	print "<td align=right>";
			  		if ($_POST['item5'] <> ""){
			  		echo "R".$item_ammount5;
			  		}
			  	print "</td>";
			  	print "</tr>";
			  	print "<tr><td colspan=3 align=right>Total Amount: R".$tot_amnt."</td></tr>";
			  	print "</table>";
				
				echo "Invoice Successfully Created";
				
		}
		else {
			// If the save button has been clicked show the names entered , Otherwise, show clean new fields.
			$name = "";
				$idate = "YYYY-MM-DD";
				$account_no = "";
				$mem_name = "";
				$mem_surname = "";
				$tot_amnt = "";
				$item_descr1 = "";
				$item_ammount1 = "";
				$item_descr2 = "";
				$item_ammount2 = "";
				$item_descr3 = "";
				$item_ammount3 = "";
				$item_descr4 = "";
				$item_ammount4 = "";
				$item_descr5 = "";
				$item_ammount5 = "";
				//Find the next invoice number so it can be displayed
				$resultarray7 = callQuery("SELECT COUNT(*) AS 'total' FROM tbl_invoices");
				$invoice_no = $resultarray7['total'] + 1;

				print "<form action=invoice_create.php method=post name=frm_invoice id=frm_invoice>";
				print "<table width=800 border=0 cellspacing=5 cellpadding=5>";
	  			print "<tr>";
	    		print "<td>&nbsp;</td>";
	    		print "<td>Invoice No: ".$invoice_no."</td>";
	  			print "</tr>";
	  			print "<tr>";
	    		print "<td>Date: </td>";
	    		print "<td><input type=text name=idate id=idate value=".$idate." /></td>";
	  			print "</tr>";
	  			print "<tr>";
	    		print "<td>Select Member :</td>";
	    		print "<td><select name=member id=member>";
	    		print "<option></option>";
		  		$query = "SELECT mem_no, name, surname FROM tbl_members;";
				$result = mysql_query($query)
					or die ("Query Failed: " . mysql_error());
				while ($row_m = mysql_fetch_array($result)) {
					echo "<option>".$row_m['mem_no']." ".$row_m['name']." ".$row_m['surname']."</option>";	
				}
	    		print "</select></td>";
	  			print "</tr>";
	  			print "</table>";
				print "<p>Invoice Items:</p>";
				print "<p>";
				//This is the start of the items table where items are selected
				print "<table width=800 border=0 cellspacing=5 cellpadding=5>";
	 			print "<tr>";
	    		print "<td>Item</td>";
	    		print "<td>Item Description</td>";
	    		print "<td>Item Amount</td>";
	  			print "</tr><tr>";
	    		print "<td><select name=item1 id=item1>"; 
	    		print "<option></option>"; 
		
				$query1 = "SELECT item_no, item_descr, item_charge FROM tbl_items;";
				$result1 = mysql_query($query1)
					or die ("Query Failed: " . mysql_error());
				while ($row_i = mysql_fetch_array($result1)) {
					echo "<option>".$row_i['item_no']." ".$row_i['item_descr']."</option>";	
				}
	    		print "</select></td>";
	    		print "<td>".$item_descr1."</td>";
	    		print "<td>R".$item_ammount1."</td>";
	  			print "</tr><tr>";
	     		print "<td><select name=item2 id=item2>";
	     		print "<option></option>";
	     		
				$query2 = "SELECT item_no, item_descr, item_charge FROM tbl_items;";
				$result2 = mysql_query($query2)
					or die ("Query Failed: " . mysql_error());
				while ($row_i2 = mysql_fetch_array($result2)) {
					echo "<option>". $row_i2['item_no']." ".$row_i2['item_descr']."</option>";	
				}
	    		print "</select></td>";
	    		print "<td>".$item_descr2."</td>";
	    		print "<td>R".$item_ammount2."</td>";
	    		print "</tr><tr>";
	     		print "<td><select name=item3 id=item3>";
	    		print "<option></option>";
				$query3 = "SELECT item_no, item_descr, item_charge FROM tbl_items;";
				$result3 = mysql_query($query3)
					or die ("Query Failed: " . mysql_error());
				while ($row_i3 = mysql_fetch_array($result3)) {
					echo "<option>". $row_i3['item_no']." ".$row_i3['item_descr']."</option>";	
				}
	    		print "</select></td>";
	    		print "<td>".$item_descr3."</td>";
	    		print "<td>R".$item_ammount3."</td>";
	    		print "</tr><tr>";
	     		print "<td><select name=item4 id=item4>";
	    		print "<option></option>";
				$query4 = "SELECT item_no, item_descr, item_charge FROM tbl_items;";
				$result4 = mysql_query($query4)
					or die ("Query Failed: " . mysql_error());
				while ($row_i4 = mysql_fetch_array($result4)) {
					echo "<option>". $row_i4['item_no']." ".$row_i4['item_descr']."</option>";	
				}
	    		print "</select></td>";
	    		print "<td>".$item_descr4."</td>";
	    		print "<td>R".$item_ammount4."</td>";
	    		print "</tr><tr>";
	     		print "<td><select name=item5 id=item5>";
	    		print "<option></option>";
				$query5 = "SELECT item_no, item_descr, item_charge FROM tbl_items;";
				$result5 = mysql_query($query5)
					or die ("Query Failed: " . mysql_error());
				while ($row_i5 = mysql_fetch_array($result5)) {
					echo "<option>". $row_i5['item_no']." ".$row_i5['item_descr']."</option>";	
				}
	    		print "</select></td>";
	    		print "<td>".$item_descr5."</td>";
	    		print "<td>R".$item_ammount5."</td>";
	    		print "</tr>";
				print "</table>";
				//End of Item table Part
	 			

	 			print "<p>";
	   			print "<input type=submit name=save id=save value=Save />";
	 			print "</p>";
				print "</p>";
				print "</form>";
			}
	}
	mysql_close($db_handle);

?>


</head>

<body>

<p align="left"><a href="invoice_create.php">Create another invoice</a></p>
<p align="left"><a href="accounts.php"><img src="images/done.jpg"></a></p>
<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved Version 2.0</p>
</body>
</html>
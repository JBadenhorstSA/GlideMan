<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start(); //start session so that the user session can be tracked
	if (isset($_SESSION['name'])) {
		$session_message = "Logged in as: ".$_SESSION['name'];
	}
	else {
		$session_message = "ALERT!!!!! Not Logged in. NO Changes will be made! ";
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GlideMan</title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
<?php
	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	include('functions.php');//Include the functions page.
	if (isset($_POST['save'])) {
			$reg = $_POST['reg'];
			$callsign = $_POST['callsign'];
			$type = $_POST['type'];
			$owner = $_POST['owner'];
			if (isset($_POST['auth_to_fly'])) {
				$auth_fly = 'Y';
			}
			else {
				$auth_fly = 'N';
			}
			$ls1date = $_POST['ls1date'];
			$charge_option = $_POST['charge_option'];
			$charge_calculation = $_POST['charge_calculation'];
			$notes = $_POST['notes'];
			$radio_exp = $_POST['radio_exp'];
			$w_b_exp = $_POST['w_b_exp'];
			$hours = $_POST['hours'];
			$launches = $_POST['launches'];	
			//Update the details in the DB with the details specified
			//Check if Glider Registration has been entered
			if ($reg == ""){
				$session_message = "You have not entered a glider registration";
			}
			//Check if Glider Registration already exists
			//elseif (checkExistance("tbl_gliders", "reg", $reg) && getExistance("tbl_gliders", "reg", $reg) != $reg){
			//	$session_message = "This glider already exists";
			//}
			//Check that an owner has been selected
			elseif ($owner == ""){
				$session_message = "No owner for the glider selected";
			}
			//Check that a value for cost has been entered
			elseif ($charge_option == ""){
				$session_message = "You have not entered a value for cost of the glider";
			}//Check that a value for glider charge has been entered
			elseif ($charge_calculation == ""){
				$session_message = "You have not entered a value for the glider charge";
			}
			else {
				if ($_SESSION['authorised'] == "Admin") {
				runQuery("UPDATE tbl_gliders SET reg='$reg', type_name='$type', callsign='$callsign', owner='$owner', auth_fly='$auth_fly', ls1_exp='$ls1date', radio_exp_date='$radio_exp', weight_bal_exp_date='$w_b_exp', hours='$hours', tot_launch='$launches', notes='$notes', charge_option='$charge_option', charge_calculation='$charge_calculation' WHERE reg = '$reg';");
		
				$change_made = "Glider $reg edited successfuly";
				//call function to add a change in the history table
				addHistory($_SESSION['mem_no'], $change_made, "Gliders");
				$session_message = "Glider: ".  $reg. " ". $type. "</br>". "Updated Successfully";
				}
				else {
					$session_message = "Invalid Access Rights - Record not created";
				}
			}
	}
	else {
	//Display the details of the member in the DB using the variable passed through the URL
	$reg = $_GET['reg'];
	$gliderarray = callQuery("SELECT * FROM tbl_gliders WHERE reg = '$reg'");
			$callsign = $gliderarray['callsign'];
			$type = $gliderarray['type_name'];
			$owner = $gliderarray['owner'];
			//$auth_to_fly = $gliderarray['auth_fly'];
			$ls1date = $gliderarray['ls1_exp'];
			$charge_option = $gliderarray['charge_option'];
			$charge_calculation = $gliderarray['charge_calculation'];
			$notes = $gliderarray['notes'];
			$radio_exp = $gliderarray['radio_exp_date'];
			$w_b_exp = $gliderarray['weight_bal_exp_date'];
			$hours = $gliderarray['hours'];
			$launches = $gliderarray['tot_launch'];	
	}
	mysql_close($db_handle);

?>
</head>

<body>
<?php
	print "<strong>$session_message</strong>";
?>
<p><strong>Editing a glider:</strong></p>
<form id="glideredit" name="glideredit" method="post" action="glider_edit.php">
	
  <table width="800" border="0" cellspacing="5" cellpadding="5">
    <tr>
      <td>Glider Full Registration : (e.g. ZS-GGM) </td>
      <td><input type="text" name="reg" id="reg" value="<?php echo $reg; ?>"/></td>
    </tr>
    <tr>
      <td>Callsign : </td>
      <td><input type="text" name="callsign" id="callsign" value="<?php echo $callsign; ?>"/></td>
    </tr>
    <tr>
      <td>Type Name : </td>
      <td><input type="text" name="type" id="type" value="<?php echo $type; ?>"/></td>
    </tr>
    <tr>
      <td>Owner : </td>
      <td><select name="owner" id="owner">
      	<?php
      		echo "<option selected>$owner</option>";
      	?>
        <option>Club</option>
         <?php
	  			include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
				//Query the members table and add Member No, Name and Surname as available options to select as owner
	  			$query = "SELECT mem_no, name, surname FROM tbl_members;";
				$result = mysql_query($query)
						or die ("Query Failed: " . mysql_error());
				while ($s_row = mysql_fetch_array($result))
				{
						echo "<option>", $s_row['mem_no']." ".$s_row['name']." ".$s_row['surname'],"</option>";	
				}
      			mysql_close($db_handle);
      		?> 
        
      </select></td>
    </tr>
    <tr>
      <td>Authority to fly : </td>
      <td><input type="checkbox" name="auth_to_fly" id="auth_to_fly" /></td>
    </tr>
    <tr>
      <td>LS1 expiry date: </td>
      <td><input type="text" name="ls1date" id="ls1date" value="<?php echo $ls1date; ?>"/></td>
    </tr>
    <tr>
      <td>Radio License Exp Date: </td>
      <td><input type="text" name="radio_exp" id="radio_exp" value="<?php echo $radio_exp; ?>"/></td>
    </tr>
    <tr>
      <td>Weight & Balance Exp Date: </td>
      <td><input type="text" name="w_b_exp" id="w_b_exp" value="<?php echo $w_b_exp; ?>"/></td>
    </tr>
    <tr>
      <td>Hours: </td>
      <td><input type="text" name="hours" id="hours" value="<?php echo $hours; ?>"/></td>
    </tr>
    <tr>
      <td>Launches: </td>
      <td><input type="text" name="launches" id="launches" value="<?php echo $launches; ?>"/></td>
    </tr>
    <tr>
      <td align="right">Charge Option : </td>
      <td><select name="charge_option" id="charge_option">
      	<?php
      		echo "<option selected>$charge_option</option>";
      	?>
        <option>Option1</option>
        <option>Option2</option>
        <option>Option3</option>
        <option>TMG1</option>
        <option>TMG2</option>
      </select></td>
    </tr>
    <tr>
      <td align="right">Charge Calculation Formula : </td>
      <td><input type="text" name="charge_calculation" id="charge_calculation" value="<?php echo $charge_calculation; ?>"/><a href="charge_explain.html" target="_blank">  Click here for a formula explanation</a></td>
    </tr>
    <tr>
      <td>Notes: </td>
      <td><textarea name="notes" id="notes" cols="45" rows="5"><?php echo $notes; ?></textarea></td>
    </tr>
    <tr>
      <td><input type="submit" name="save" id="save" value="Save" /></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
<p align="left"><a href="gliders.php"><img src="images/done.jpg"></a></p>
<p>&nbsp;</p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved - Version 2.0</p>
</body>
</html>
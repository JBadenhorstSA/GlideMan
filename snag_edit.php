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
if (isset($_SESSION['authorised'])) {
	if ($_SESSION['authorised'] == "Normal" || $_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
		if (isset($_POST['save'])) {
				$update_ID = $_POST['update_ID'];//Different to Mem_ID and edit_ID to avoid a Indefined Index error, since I am using both _GET and _POST
					$name = $_POST['equipment_lst'];
					$prob_descr = $_POST['prob_descr'];
					$date = $_POST['date'];
					$note_descr = $_POST['note_descr'];
					$status = $_POST['status'];
					$prob_descr = $prob_descr."<br />".date("Y-m-d")." ".$_SESSION['name'].": ".$note_descr;
					
				//Update the details in the DB with the details specified
				runQuery("UPDATE tbl_snags SET notes='$prob_descr', status='$status' WHERE snag_no = '$update_ID'");
				$change_made = "Record: "." $name"." Snag No: "."$update_ID "."Updated Successfully";	
				//Call the history function to add detail of the change to the history log.
				addHistory($_SESSION['mem_no'], $change_made, "Snags");
			
			
			}
			else {
			//Display the details of the problem in the DB using the variable passed through the URL
			$edit_ID = $_GET['snag_no'];
			$snagarray = callQuery("SELECT * FROM tbl_snags WHERE snag_no = '$edit_ID'");
			$update_ID = $edit_ID;//assign another variable to use as the ID, this is so that the form can be posted using the ID as Hidden item.
					$name = $snagarray['aircraft_equip_name'];
					$date = $snagarray['date'];
					$prob_descr = $snagarray['notes'];
					$status = $snagarray['status'];
			}
	}
	else {
		echo "You are not authorised";	
	}
}
else {
	echo "You are not logged in";
}
	
	mysql_close($db_handle);
?>





</head>

<body>
<form action="snag_edit.php" id="snagform" method="post" name="snagform">
<input type="hidden" name="update_ID" value="<?php echo "$update_ID"; ?>">
<input type="hidden" name="prob_descr" value="<?php echo "$prob_descr"; ?>">
<input type="hidden" name="date" value="<?php echo "$date"; ?>">
<table width="800" border="0" cellspacing="5" cellpadding="5">
  <tr>
    <td width="302">Aircraft Registration or Equipment Name : </td>
    <td width="463"><select name="equipment_lst" id="equipment_lst" tabindex="1">
    		<option><?php echo "$name"; ?></option>
   		</select></td>
  </tr>
  <tr>
    <td>Date (YYYY-MM-DD) :</td>
    <td><?php echo "$date"; ?></td>
  </tr>
  <tr>
    <td>Problem Description:</td>
    <td><?php echo "$prob_descr"; ?></td>
  </tr>
 <tr>
 	<td>Add Notes:</td>
    <td><textarea name="note_descr" id="note_descr" cols="45" rows="5" tabindex="3"></textarea></td>
 </tr>
  <tr>
    <td>Status:</td>
    <td><select name="status" id="status" tabindex="5">
    		<option>New</option>
    		<option selected="selected">In Progress</option>
            <option>Resolved</option>
    </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="save" id="save" value="Save" tabindex="6" /></td>
  </tr>
</table>

</form>

<p align="left"><a href="snags.php"><img src="images/done.jpg"></a></p>
<p>&nbsp;</p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved - Version 2.0</p>
</body>
</html>
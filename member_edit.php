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
include('functions.php');
if (isset($_POST['save'])) {
		$update_ID = $_POST['update_ID'];//Different to Mem_No and edit_ID to avoid a Indefined Index error, since I am using both _GET and _POST
			$name = $_POST['name'];
			$surname = $_POST['surname'];
			$id_no = $_POST['idno'];
			$cell_no = $_POST['cell'];
			$tel_no = $_POST['tel'];
			$email = $_POST['email'];
			$physical = $_POST['physical'];
			$postal = $_POST['postal'];
			$birthday = $_POST['birthday'];
			$kin = $_POST['kin'];
			$memtype = $_POST['memtype'];
			$username = $_POST['username'];
			$pass1 = $_POST['pass1'];
			$pass2 = $_POST['pass2'];
			$acc_group = $_POST['group'];
			$photo = $_POST['photo'];
			
			//This section checks that fields have been entered correclty. 
				// Check password match
				if ($pass1 != $pass2){
					$session_message = "Passwords do not match";
				}
				//check id not empty. This is needed to check if user is already in DB
				elseif ($id_no == ""){
					$session_message = "No ID no specified";
				}
				//Check if the id_no you entered is already in DB under another person
				elseif (checkExistance("tbl_members", "id_no", $id_no) && getExistance("tbl_members", "id_no", $id_no) != $update_ID){
					$session_message = "A user with this ID Number already exists";
				}
				//check that a usename has been entered
				elseif ($username == ""){
					$session_message = "You have not entered a username";
				}
				//check if username already exists under another user
				elseif (checkExistance("tbl_members", "username", $username) && getExistance("tbl_members", "username", $username) != $update_ID){
					$session_message = "The username is already being used by another person";
				}
				//check email not empty
				elseif ($email == ""){
					$session_message = "You have not entered an email address";
				}
				//check cell number not empty
				elseif ($cell_no == ""){
					$session_message = "You have not entered a cellphone number";
				}
				//check membership type selected
				elseif ($memtype == ""){
					$session_message = "Membership Type Not Selected";
				}
				
				//If All fields are properly completed Test to see if the user has Authorisation. If the user has Authorisation  continue updating the records
				else {
					if ($_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
						//call runQuery function in functions.php page to executy the query
						runQuery("UPDATE tbl_members SET name='$name', surname='$surname', id_no='$id_no', cell='$cell_no', tel='$tel_no', email='$email', physical_add='$physical', postal_add='$postal', birthday='$birthday', next_of_kin='$kin', mem_type='$memtype', username='$username', password='$pass1', access_group='$acc_group', photo_url='$photo' WHERE mem_no = '$update_ID'");
	
						$session_message = "Member Record Successfully Changed";
						$change_made = " Edited record for member $update_ID";
							
						//call function to make a change in the history table
						addHistory($_SESSION['mem_no'], $change_made, "Members");
						
					}
					else {
						$session_message = "Invalid Access - Record Change not changed";
					}
				}
	
	}
	
	else {
	//Display the details of the member in the DB using the variable passed through the URL
	$edit_ID = $_GET['mem_no'];
	$memberarray = callQuery("SELECT * FROM tbl_members WHERE mem_no = '$edit_ID'");//Call callQuery Function to return array of query results
	$update_ID = $edit_ID;//assign another variable to use as the ID, this is so that the form can be posted using the ID as Hidden item.
				$name = $memberarray['name'];
				$surname = $memberarray['surname'];
				$id_no = $memberarray['id_no'];
				$cell_no = $memberarray['cell'];
				$tel_no = $memberarray['tel'];
				$email = $memberarray['email'];
				$physical = $memberarray['physical_add'];
				$postal = $memberarray['postal_add'];
				$birthday = $memberarray['birthday'];
				$kin = $memberarray['next_of_kin'];
				$memtype = $memberarray['mem_type'];;
				$username = $memberarray['username'];
				$pass1 = $memberarray['password'];
				$pass2 = $memberarray['password'];
				$acc_group = $memberarray['access_group'];
				$photo = $memberarray['photo_url'];
	
	}
	
	
	mysql_close($db_handle);
?>



</head>

<body>
<p><strong>Edit a member:</strong></p>
<?php
	print "<strong>$session_message</strong>";
?>
<form id="memedit1" name="memedit" method="post" action="member_edit.php">
	<input type="hidden" name="update_ID" value="<?php echo "$update_ID"; ?>">
  <table width="800" border="0" cellspacing="5" cellpadding="5">
    <tr>
      <td>Name :</td>
      <td>
        <input type="text" name="name" id="name" value="<?php echo $name; ?>"/>
      </td>
      <td>Password :</td>
      <td>
        <input type="password" name="pass1" id="pass1" value="<?php echo $pass1; ?>"/>
      </td>
    </tr>
    <tr>
      <td>Surname : </td>
      <td><input type="text" name="surname" id="surname" value="<?php echo $surname; ?>"/></td>
      <td>Confirm password:</td>
      <td>
        <input type="password" name="pass2" id="pass2" value="<?php echo $pass2; ?>"/>
      </td>
    </tr>
    <tr>
      <td>ID No : </td>
      <td><input type="text" name="idno" id="idno" value="<?php echo $id_no; ?>"/></td>
      <td>Access Group : </td>
      <td>
        <select name="group" id="group">
			<?php
      		echo "<option selected>$acc_group</option>";
			?>
          <option>Normal</option>
          <option>Admin</option>
          <option>Finance</option>
        </select>
      </td>
    </tr>
    <tr>
      <td><p>Birthday  : </p></td>
      <td><input type="text" name="birthday" id="birthday" value="<?php echo $birthday; ?>"/></td>
      <td>System Username :</td>
      <td><input type="text" name="username" id="username" value="<?php echo $username; ?>"/>
       </td>
    </tr>
    <tr>
      <td>Postal Address: </td>
      <td>
        <textarea name="postal" id="postal" cols="30" rows="5"><?php echo $postal; ?></textarea>
      </td>
      <td>Photo URL : </td>
      <td><textarea name="photo" id="photo" cols="30" rows="5"><?php echo $photo; ?></textarea>
	  <img src="<?php echo $photo; ?>">  
	  </td>
    </tr>
    <tr>
      <td>Physical Address:</td>
      <td><textarea name="physical" id="physical" cols="30" rows="5"><?php echo $physical; ?></textarea></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Tel : </td>
      <td><input type="text" name="tel" id="tel" value="<?php echo $tel_no; ?>"/></td>
      <td>&nbsp;</td>
      <td>Next Of Kin - Name &amp; Number</td>
    </tr>
    <tr>
      <td>Cell : </td>
      <td><input type="text" name="cell" id="cell" value="<?php echo $cell_no; ?>"/></td>
      <td>&nbsp;</td>
      <td><input type="text" name="kin" id="kin" size="35" value="<?php echo $kin; ?>"/></td>
    </tr>
    <tr>
      <td>E-Mail</td>
      <td><input type="text" name="email" id="email" value="<?php echo $email; ?>"/></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Member Type : </td>
      <td><select name="memtype" id="memtype">
      	<?php
      		echo "<option selected>$memtype</option>";
      	?>
        <option>Normal Corporate</option>
        <option>Student</option>
        <option>Executive</option>
        <option>Honorary</option>
        <option>Social</option>
        <option>Family</option>
        <option>Country</option>
        <option>Special</option>
        <option>Temporary</option>
      </select></td>
      <td>&nbsp;</td>
      <td><input type="submit" name="save" id="button" value="Save" /></td>
    </tr>
  </table>
</form>

<p>&nbsp;</p>
<p align="left"><a href="members.php"><img src="images/done.jpg"></a></p>
<p>&nbsp;</p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved - Version 2.0</p>
</body>
</html>
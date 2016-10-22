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
	include('functions.php'); // Include Functions PHP page.
	$change_made = "";
		//If the Save buton has been pressed assign Values from the form fields to Variables
		if (isset($_POST['save'])) {
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
				
				
				//testing echo the values to see if they contained values up to this point
				//echo "$pass", " ", "$name", " ", "$surname", " ", "$id_no",  " ", "$lic_no",  " ", "$postal", " ", "$physical", " ", "$tel_no", " ", "$cell_no", " ", "$email", " ", "$memtype", " ", "$group","</br>";
					
				//This section checks that fields have been entered correclty. 
				// Check password match
				if ($pass1 != $pass2){
					$session_message = "Passwords do not match";
				}
				//check id not empty. This is needed to check if user is already in DB
				elseif ($id_no == ""){
					$session_message = "No ID no specified";
				}
				//Check if user is already in DB
				elseif (checkExistance("tbl_members", "id_no", $id_no)){
					$session_message = "A user with this ID Number already exists";
				}
				//check that a usename has been entered
				elseif ($username == ""){
					$session_message = "You have not entered a username";
				}
				//check if username already exists
				elseif (checkExistance("tbl_members", "username", $username)){
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
				
				//If All fields are properly completed Test to see if the user has Authorisation. If the user has Authorisation  continue creating the records
				else {
					if ($_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
						$query = "INSERT INTO tbl_members (name, surname, id_no, cell, tel, email, physical_add, postal_add, birthday, next_of_kin, 
														   mem_type, username, password, access_group, photo_url, active) VALUES('$name', '$surname', '$id_no', 
														   '$cell_no', '$tel_no', '$email', '$physical', '$postal', '$birthday', '$kin', '$memtype', 
														   '$username', '$pass1', '$acc_group', '$photo', 'Y');";
						
						//echo $query1; //Tested the query by echoing it
						$result = mysql_query($query)
							or die("Query Failed: " . mysql_error());// Displays the error if the SQL Query does not succeed.
						$session_message = "Member Successfully Added.";
						//determine the member ID just created to create account automatically
						$newmemarray = mysql_fetch_array(mysql_query("SELECT mem_no FROM tbl_members WHERE id_no='$id_no';"));
						$mem_no = $newmemarray['mem_no'];
						$change_made = $change_made." Added Member $mem_no";
						//Create account for new member in the accounts table
						$query = "INSERT INTO tbl_accounts (mem_no, balance) VALUES('$mem_no', '0');";
							$result = mysql_query($query)
								or die("Query Failed: " . mysql_error());// Displays the error if the SQL Query does not succeed.
							$session_message = $session_message." & Account Successfully created";
							$change_made = $change_made." & Account Automatically created";
							
						//call function to make a change in the history table
						addHistory($_SESSION['mem_no'], $change_made, "Members & Accounts");
						//If the records are sucessfully Created, Show Clean new Fields
						$name = "";
						$surname = "";
						$id_no = "";
						$cell_no = "";
						$tel_no = "";
						$email = "";
						$physical = "";
						$postal = "";
						$birthday = "YYYY-MM-DD";
						$kin = "";
						$memtype = "";
						$username = "";
						$pass1 = "";
						$pass2 = "";
						$acc_group = "";
						$photo = "";
						
					}
					else {
						$session_message = "Invalid Access Rights - Record not created";
					}
				}
		}
	else {
		// If the save button has been clicked show the detailes entered , Otherwise, show clean new fields.
			$name = "";
			$surname = "";
			$id_no = "";
			$cell_no = "";
			$tel_no = "";
			$email = "";
			$physical = "";
			$postal = "";
			$birthday = "YYYY-MM-DD";
			$kin = "";
			$memtype = "";
			$username = "";
			$pass1 = "";
			$pass2 = "";
			$acc_group = "";
			$photo = "";
		
		}
	
	mysql_close($db_handle);

?>

</head>

<body>
<p><strong>Add a new member:</strong></p>
<p>
<?php
	print "<strong>$session_message</strong>";
?>
</p>
<form id="addmem" name="addmem" method="post" action="member_add.php">
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
      		<option selected>Normal</option>
          <option>Admin</option>
          <option>Finance</option>
        </select>
      </td>
    </tr>
    <tr>
      <td><p>Birthday  : </p></td>
      <td><input type="text" name="birthday" id="birthday" value="<?php echo $birthday; ?>"/></td>
      <td>System Username :</td>
      <td><input type="text" name="username" id="username" value="<?php echo $username; ?>"/></td>
    </tr>
    <tr>
      <td>Postal Address: </td>
      <td>
        <textarea name="postal" id="postal" cols="30" rows="5"><?php echo $postal; ?></textarea>
      </td>
      <td>Photo URL : </td>
      <td><textarea name="photo" id="photo" cols="30" rows="5"><?php echo $photo; ?></textarea></td>
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
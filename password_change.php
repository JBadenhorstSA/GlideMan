<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GlideMan</title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
</head>
<?php
	session_start();
	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	include('functions.php');//Include the functions page. Calling various functions from that page.
	if (isset($_POST['submit'])) {
			$username = $_POST['username'];
			$oldpassword = $_POST['oldpassword'];
			$newpassword = $_POST['newpassword'];
			$confirmpassword = $_POST['confirmpassword'];
		
		if ($_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
			$member = $_POST['member'];
			$mem_array = explode(" ", $member);
			$mem_no = $mem_array[0];
			$mem_name = $mem_array[1];
			$mem_surname = $mem_array[2];
			
			
			echo $member;
			echo $mem_no;
			echo $mem_name;
			echo $mem_surname;
			echo $username;
			echo $oldpassword;
			echo $newpassword;
			echo $confirmpassword;
		
		
		}
		
		
		elseif ($_SESSION['authorised'] == "Normal"){
			
			
		}
		else {
			echo "You are not logged in";
		}
		
	}
	else {
		
	}
	
	
?>


<body>


<form action="password_change.php" name="pass" id="pass" method="post">
<select name="member" id="member" />
		<!-- This is a Select option for the form with a PHP piece of code to pull all the timesheets available from the DB -->
      	<option></option>
	  <?php
	  	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	  	$query = "SELECT mem_no, name, surname FROM tbl_members WHERE active='Y' ORDER BY name ASC;";
		$result = mysql_query($query)
			or die ("Query Failed: " . mysql_error());
		//$memberarray = mysql_fetch_array($result13);
		while ($row = mysql_fetch_array($result))
		{
			echo "<option>", $row['mem_no']." ".$row['name']." ".$row['surname'],"</option>";	
		}
      	mysql_close($db_handle);
      ?></select>
      
      <p>Username : </p>
      <p><input type="text" name="username" id="username" /></p>
      <p>Old Password : </p>
      <p><input type="password" name="oldpassword" id="oldpassword" /></p>
      <p>New Password : </p>
      <p><input type="password" name="newpassword" id="newpassword" /></p>
      <p>Confirm Password : </p>
      <p><input type="password" name="confirmpassword" id="confirmpassword" /></p>

<input type="submit" name="submit" id="submit" value="Submit" />
</form>


<p align="left"><a href="members.php">Back To Members</a></p>
<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
</body>
</html>
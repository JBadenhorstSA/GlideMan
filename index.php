<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
	if (isset($_SESSION['name'])) {
		$login_message = "Logged in as: ".$_SESSION['name'];
	}
	else {
		$login_message = "Not Logged in. ";
		$_SESSION['authorised'] = "None";// Assign a None value to the SESSION Authorises, So If you open Pages Without being logged in The SQL Erros Don't Display. Only System Error Messages
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
	//session_start();
	if (isset($_POST['login'])) {
	
		$username = $_POST['user'];
		$password = $_POST['pass'];
	
		//call the function to query the database for the userinfo of the username provided
		$userarray = callQuery("SELECT * FROM tbl_members WHERE username = '$username'");
		
		
		// Test to see if the password is correct
		if ($userarray['password'] == $password) {
			//Assign Session values if logon was succesful
			$_SESSION['name'] = $userarray['name'];
			$_SESSION['authorised'] = $userarray['access_group'];
			$_SESSION['mem_no'] = $userarray['mem_no'];
			$login_message = "Logged in as: ".$_SESSION['name'];
			$change_made = "User ".$userarray['name']." ".$userarray['surname']." Logged in.";
			addHistory($_SESSION['mem_no'], $change_made, "History");
		}
		else {
			$login_message = "Login Failed";
		}
	}
	elseif (isset($_POST['logoff'])){
		session_destroy();
		$login_message = "Logged Off";
	}
	else {
		//Displays empty fields for logon screen
		$username = "";
		$password = "";	
	}
	mysql_close($db_handle);
?>
</head>
<body>


<!-- This is the little menu area -->
<p><a href="members.php"><img src="images/members.jpg"></a><a href="flights.php"><img src="images/flights.jpg"></a><a href="accounts.php"><img src="images/accounts.jpg"></a><a href="gliders.php"><img src="images/gliders.jpg"></a><a href="reports.php"><img src="images/logbooks.jpg"></a><a href="snags.php"><img src="images/snags.jpg"></a></p>

<h1>Welcome to the GlideMan Home page!
</h1>
<p>Designed for:</p>
<table border="0" cellpadding="10">
<tr>
	<td><p><img src="images/avplogo.JPG" width="447" height="335" alt="AVP logo" longdesc="http://www.potchgliding.co.za" /></p></td>
    <td>
    	<h2>Login:</h2>
        <form action="index.php" method="post">
        	<p>Name : </p><input type="text" name="user" id="user" />
            <p>Password: </p><input type="password" name="pass" id="pass" /> 
            <p><input type="submit" name="login" id="button" value="Login" /> <input type="submit" name="logoff" id="button" value="Log Off" /></p>
    	</form>
        <?php
			print $login_message;
			print "<br /> ".date("Y-m-d");
			print "<br /><a href=view_history.php>View System History</a>";
		?>
        
    </td>
</tr>
</table>
<!-- <p align="left"><a href="index.php"><img src="images/home.jpg" /></a></p> -->
<p>&nbsp;</p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved - Version 2.0</p>
<p align="center"><a href="user_manual.pdf" target="blank">User Guide Documentation</a></p>
</body>
</html>
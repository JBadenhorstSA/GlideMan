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
	if ($_SESSION['authorised'] == "Normal" || $_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
		if (isset($_POST['submit'])) {
		
		
		}
		else {
			
		}
		
	}
	else {
		
	}
	
	
?>


<body>


<form action="page.php" name="" id="" method="post">

<input type="submit" name="submit" id="submit" value="Submit" />
</form>


<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
</body>
</html>
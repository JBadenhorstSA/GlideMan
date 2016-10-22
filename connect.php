<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GlideMan</title>
</head>

<body>
	<!-- This Page only establishes the connection to the database, for other pages to use-->
	<?php

	//Create variable to hold information used to connect to the database
	//Using variable like this makes it easy to change information needed to connect to Databases
	
	//IDEA!!!! - Have the user enter these fields?
	$user_name = "root";
	$password = "";
	$database = "glideman";
	$server = "127.0.0.1";
	
	
	
	//Connect to the Database
	$db_handle = mysql_connect($server, $user_name, $password);
	//Open the database
	$db_found = mysql_select_db($database, $db_handle);
	
	//Check to see if the Database is connected. Uncomment to test
	//if ($db_found) {
	//	print "Database Connected </br>";
	//}
	//else {
	//	print "Database NOT Found ";
	//} 
		

	?>

</body>
</html>

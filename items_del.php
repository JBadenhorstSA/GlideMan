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
		$session_message = "Logged in as: ".$_SESSION['name'];
		$delete_ID = $_GET['item_no'];
		runQuery("DELETE FROM tbl_items WHERE item_no ='$delete_ID';");
		echo "Item deleted successfully";

	}
	else {
		$session_message = "You are not Logged in";
	}

	mysql_close($db_handle);

?>

</head>

<body>
<?php echo $session_message; ?>

<p align="left"><a href="accounts.php"><img src="images/done.jpg"></a></p>
<p>&nbsp;</p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved Version 2.0</p>

</body>
</html>
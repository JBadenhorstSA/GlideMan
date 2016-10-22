<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GlideMan</title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
<?php
	$width=0;
	$height=20;
	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	include('functions.php');
	$fromdate = "2015-01-01";
	$todate = "2015-12-31";
	//echo $width;//echo for testing
	print "<table border='0' cellpadding='0' cellspacing='0'>";
	print "<tr>";
	$jan_flights = flightCount("2015-01-01", "2015-01-31");
	$width=$jan_flights * 10;
	print "<td>Januarie</td>";
	print "<td><img src=images/bar1.png height=$height width=$width/></td>";
	print "<td>".$width / 10 ."</td>";
	print "</tr>";
	
	print "<tr>";
	$feb_flights = flightCount("2015-02-01", "2015-02-28");
	$width=$feb_flights * 10;
	print "<td>February</td>";
	print "<td><img src=images/bar2.png height=$height width=$width/></td>";
	print "<td>".$width / 10 ."</td>";
	print "</tr>";
	
	
	print "<tr>";
	$mar_flights = flightCount("2015-03-01", "2015-03-31");
	$width=$mar_flights * 10;
	print "<td>March</td>";
	print "<td><img src=images/bar3.png height=$height width=$width/></td>";
	print "<td>".$width / 10 ."</td>";
	print "</tr>";
	
	
	print "<tr>";
	$apr_flights = flightCount("2015-04-01", "2015-04-30");
	$width=$apr_flights * 10;
	print "<td>April</td>";
	print "<td><img src=images/bar4.png height=$height width=$width/></td>";
	print "<td>".$width / 10 ."</td>";
	print "</tr>";
	
	
	print "<tr>";
	$may_flights = flightCount("2015-05-01", "2015-05-31");
	$width=$may_flights * 10;
	print "<td>May</td>";
	print "<td><img src=images/bar5.png height=$height width=$width/></td>";
	print "<td>".$width / 10 ."</td>";
	print "</tr>";
	
	
	print "<tr>";
	$jun_flights = flightCount("2015-06-01", "2015-06-30");
	$width=$jun_flights * 10;
	print "<td>June</td>";
	print "<td><img src=images/bar6.png height=$height width=$width/></td>";
	print "<td>".$width / 10 ."</td>";
	print "</tr>";
	
	
	print "<tr>";
	$jul_flights = flightCount("2015-07-01", "2015-07-31");
	$width=$jul_flights * 10;
	print "<td>July</td>";
	print "<td><img src=images/bar7.png height=$height width=$width/></td>";
	print "<td>".$width / 10 ."</td>";
	print "</tr>";
	
	
	print "<tr>";
	$aug_flights = flightCount("2015-08-01", "2015-08-31");
	$width=$aug_flights * 10;
	print "<td>August</td>";
	print "<td><img src=images/bar8.png height=$height width=$width/></td>";
	print "<td>".$width / 10 ."</td>";
	print "</tr>";
	
	
	print "<tr>";
	$sep_flights = flightCount("2015-09-01", "2015-09-30");
	$width=$sep_flights * 10;
	print "<td>September</td>";
	print "<td><img src=images/bar9.png height=$height width=$width/></td>";
	print "<td>".$width / 10 ."</td>";
	print "</tr>";

	print "<tr>";
	$oct_flights = flightCount("2015-10-01", "2015-10-31");
	$width=$oct_flights * 10;
	print "<td>October</td>";
	print "<td><img src=images/bar10.png height=$height width=$width/></td>";
	print "<td>".$width / 10 ."</td>";
	print "</tr>";

	print "<tr>";
	$nov_flights = flightCount("2015-11-01", "2015-11-30");
	$width=$nov_flights * 10;
	print "<td>November</td>";
	print "<td><img src=images/bar11.png height=$height width=$width/></td>";
	print "<td>".$width / 10 ."</td>";
	print "</tr>";

	print "<tr>";
	$dec_flights = flightCount("2015-12-01", "2015-12-31");
	$width=$dec_flights * 10;
	print "<td>December</td>";
	print "<td><img src=images/bar12.png height=$height width=$width/></td>";
	print "<td>".$width / 10 ."</td>";
	print "</tr>";
	mysql_close($db_handle);
	
	
?>



</head>

<body>
<h1>Flights Per Month</h1>


<p align="left"><a href="reports.php"><img src="images/done.jpg"></a></p>
<p align="center">&copy; Johan Badenhorst 2013 All Rights Reserved - Version 2.0</p>
</body>
</html>





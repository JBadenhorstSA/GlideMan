<?php
	//Generic Funstion to create a Query on a Database and return the results in an Array
	function callQuery($query){
		$result = mysql_query($query);
		$resultArray = mysql_fetch_assoc($result);
		return $resultArray;
	}
	//Generic Function TO Process a Query - Similar to callQuery, but no result is returned.
	function runQuery($query){
		$result = mysql_query($query)	
			or die("Query Failed: " . mysql_error());// Displays the error if the SQL Query does not succeed.
	}
	
	//This is an easy function  to add records into the history table ,accepting Parameters for member no of the person making the change, The changes made String, and then Which Table was Changed
	function addHistory($changer_no, $change_made, $table) {
		$todays_date = date("Y-m-d"); // Automatically Gets Todays Date to Enter in the System
		$query = "INSERT INTO tbl_history (changer_mem_no, change_made, change_date, change_table) VALUES ('$changer_no', '$change_made', '$todays_date', '$table');";
						$result = mysql_query($query)
							or die("Query Failed: " . mysql_error());
	}
	//This Functions accepts a table name, field and value parameter and determins if that value exists in the database for the given parameter. 
	//It the returns a 1 if the value exists or nothing if the value does not. This is So that it can be called in IF statements
	function checkExistance($table, $field, $value) {
			$query = "SELECT * FROM $table WHERE $field='$value'";
			$result = mysql_query($query);
			$resultarray = mysql_fetch_assoc($result);
				if ($value == $resultarray[$field]) {
						return "1";	
				}
				else {
					return "";
				}
		//Also Possible to check the values using the in_array function?
	}
	//This function is a follow on to the checkExistance function and returns the member_no for the record if it exists
	//Takes the same arguements as checkExistance function, which table to check, matching with field with witch Value
	function getExistance($table, $field, $value) {
			$query = "SELECT * FROM $table WHERE $field='$value'";
			$result = mysql_query($query);
			$resultarray = mysql_fetch_assoc($result);
			return $resultarray['mem_no'];
	}
	
	//This function returns a number value for the ammount of flights found in a specific period
	//Takes a start and end date as arguments to determine the period
	function flightCount($fromdate, $todate) {
		$resultarray = callQuery("SELECT COUNT(*) AS 'total' FROM tbl_flights WHERE date BETWEEN '$fromdate' AND '$todate';");
		return $resultarray['total'];
		
	}
	
	//This function returns the membership monthly amount based on the membership type provided
	function memAmount($mem_type) {
		$query = "SELECT monthly_amount FROM tbl_membership WHERE type='$mem_type';";
		$result = mysql_query($query);
		$resultarray = mysql_fetch_assoc($result);
		$monthly_amount = $resultarray['monthly_amount'];
		return $monthly_amount;
	}
	
	
	//This fucntion receives a given timesheet and checks that timesheet complies with all the ruls
	/*
	function checkFlightRules($timesheet) {
		$query = "SELECT * FROM tbl_flights WHERE timesheet='$timesheet';";
		$result = mysql_query($query);
		while ($db_field = mysql_fetch_assoc($result)) {
			if ($dbfield['launch_method'] = strpos($launch_method, "Tug")
		}
	}
	*/
	
	/// ----- COST CALCULATING FUNCTIONS FOR AIRCRAFT  -------
	
	
	//These methods is used for TMG's to calculate Flight Cost
	function flightCostTMG($tachoStart, $tachoEnd, $tachoCharge, $noLandings, $landingCharge) {
		//calculate flight cost using tacho time and gliding time
		$tachoTime = $tachoEnd - $tachoStart;
		$totalFlightCost = $tachoTime * $tachoCharge;
		
		//calcualte landing costs
		$totalLandingCost = $noLandings * $landingCharge;
		
		$billingCost = $totalLandingCost + $totalFlightCost;
		return $billingCost;
	}
	
	function flightCostTMG2($flightDuration, $glidingCharge, $tachoStart, $tachoEnd, $tachoCharge, $noLandings, $landingCharge) {
		//calculate flight cost using tacho time and gliding time
		$tachoTime = $tachoEnd - $tachoStart;
		$glidingTime = $flightDuration - $tachoTime;
		$totalFlightCost = ($tachoTime * $tachoCharge) + ($glidingTime * $glidingCharge);
		
		//calcualte landing costs
		$totalLandingCost = $noLandings * $landingCharge;
		
		$billingCost = $totalLandingCost + $totalFlightCost;
		return $billingCost;
	}
	
	
	//This is a standard method to calculate flight cost on charge per hour bases
	function flightCostOption1($flightDuration, $chargePerHour) {
		$billingCost = $flightDuration * $chargePerHour;
		return $billingCost;
	}
	
	//This is a customized method to calculate flight Cost based on per minute charge with minimum and maximum ammounts
	function flightCostOption2($flightDuration, $chargePerMinute, $minCost, $maxCost) {
		//If the flight cost is less than the minimum apply minomum cost, if it is more than the maksimum apply the makisim cost
		//otherwise calculate flight cosyt is based on per minute charge
		$flightCost = ($flightDuration * 60) * $chargePerMinute;
		if ($flightCost < $minCost) {
			$billingCost = $minCost;
		}
		elseif ($flightCost > $maxCost) {
			$billingCost = $maxCost;
		}
		else {
			$billingCost = $flightCost;
		}
		return $billingCost;
	}
	
	//This is a method to calculate flight cost for club aircraft using a minimum and maximum cost
	function flightCostOption3($flightDuration, $minCost, $maxCost, $timeSplit) {
		//If the flight is longer than the time split given the maximum charge is applied, if it is less than 30 minutes the minimum charge is applied
		if ($flightDuration > $timeSplit) {
			$billingCost = $maxCost;
		}
		else {
			$billingCost = $minCost;	
		}
		return $billingCost;
	}
	
?>

<!--
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>

<body>
</body>
</html>
-->
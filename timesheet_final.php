<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GlideMan</title>
<link href="stylesheet.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#warning {
	color: #F00;
}
-->
</style>
</head>
	<?php
	include('connect.php');//Include the php page that makes the connection to the database
	include('functions.php'); //Include the functions page to call functions.
	if ($_SESSION['authorised'] == "Admin" || $_SESSION['authorised'] == "Finance") {
		if(isset($_POST['submit'])) {
			$timesheet = $_POST['timesheet'];
			$sheetarray = explode(" ", $_POST['timesheet']);
			$sheet_no = $sheetarray[0];
			$sheet_date = $sheetarray[1];
			
			//PERFORM RULE CHECKS
			//cals a function to run through the timesheet and check all the flights to comply with the rules
			//if (checkFlightRules($timesheet) != false) {
				
			
					//lock the timesheet
					runQuery("UPDATE tbl_timesheets SET locked='Y' WHERE sheet_no = '$sheet_no'");
					echo "<br />";
					
					
					//This part is a query and then a while loop tp process and display the flights for each timesheet in a table
					
					$query = "SELECT * FROM tbl_flights WHERE timesheet='$timesheet';";
					$result = mysql_query($query);
					print "<table border='1' width='800' cellpadding='5' cellspacing='5'>";
					print "<tr><td>Flight No</td><td>Date</td><td>Glider</td><td>Duration</td><td>Paying Pilot</td><td>P1</td><td>P2</td><td>Flight Type</td><td>Take Off</td><td>Landing</td><td>Tug Time</td><td>No Landings</td><td>Launch Method</td><td>Amount To Pay</td></tr>";
					while ($db_field = mysql_fetch_assoc($result)) {
						print "<tr><td>";
						$flight_no = $db_field['flight_no'];
						echo $flight_no;//echo for testing
						print "</td><td>";
						$flight_date = $db_field['date'];
						echo $flight_date;//echo for testing
						print "</td><td>";
						$glider_reg = $db_field['glider_reg'];
						echo $glider_reg;//echo for testing
						print "</td><td>";
						$flight_duration = $db_field['flight_duration'];
						echo $flight_duration;//echo for testing
						print "</td><td>";
						$payment_resp = $db_field['payment_resp'];
						echo $payment_resp;//echo for testing
						print "</td><td>";
						$p1_array = explode(" ", $db_field['p1']);
						$p1_mem_no = $p1_array[0];
						$mem_array = callQuery("SELECT name, surname FROM tbl_members WHERE mem_no='$p1_mem_no';");
						$p1_name = $mem_array['name'];
						$p1_surname = $mem_array['surname'];
						echo $p1_mem_no." ".$p1_name." ".$p1_surname;//echo for testing
						print "</td><td>";
						$p2_array = explode(" ", $db_field['p2']);
						$p2_mem_no = $p2_array[0];
						$mem_array = callQuery("SELECT name, surname FROM tbl_members WHERE mem_no='$p2_mem_no';");
						$p2_name = $mem_array['name'];
						$p2_surname = $mem_array['surname'];
						echo $p2_mem_no." ".$p2_name." ".$p2_surname;//echo for testing
						print "</td><td>";
						$flightType = $db_field['flight_type'];
						echo $flightType;//echo for testing
						print "</td><td>";
						$take_off_time = $db_field['take_off_time'];
						echo $take_off_time;//echo for testing
						print "</td><td>";
						$landing_time = $db_field['landing_time'];
						echo $landing_time;//echo for testing
						print "</td><td>";
						$tug_time = $db_field['tug_time'];
						echo $tug_time;//echo for testing
						print "</td><td>";
						$no_landings = $db_field['no_landings'];
						echo $no_landings;//echo for testing
						print "</td><td>";
						$launch_method = $db_field['launch_method'];
						echo $launch_method;//echo for testing
						print "</td><td>";
						//Enter variables here e.g.Tacho Times, not to be displayed in the Table e.g.Tacho Times
						$tachoStart = $db_field['tacho_start'];
						$tachoEnd = $db_field['tacho_end'];

						
						//-----  PROCESSING START -----
						
						//This is the start to the part that determines the flight cost
						$glider_array = callQuery("SELECT owner, hours, tacho, land, tot_launch, s_launch, w_launch, a_launch, m_launch, charge_option, charge_calculation FROM tbl_gliders WHERE reg='$glider_reg';"); 
						$glider_owner = $glider_array['owner'];
						$glider_hours = $glider_array['hours'] + $flight_duration;
						$glider_tacho = $glider_array['tacho'];
						$g_no_landings = $glider_array['land'] + $no_landings;
						$tot_launch = $glider_array['tot_launch'];
						$s_launch = $glider_array['s_launch'];
						$w_launch = $glider_array['w_launch'];
						$a_launch = $glider_array['a_launch'];
						$m_launch = $glider_array['m_launch'];
						$charge_option = $glider_array['charge_option'];
						$charge_calculation = $glider_array['charge_calculation'];
						
						//Determine Launch Costs.
						if (strpos($launch_method, "Winch") !== false) {
							//If launch Method was a winch then update relevant Winch Logbook | Winch Table
							$wincharray = callQuery("SELECT name, tot_launches, launch_cost FROM tbl_winches WHERE name='$launch_method';");
							$launch_cost = $wincharray['launch_cost'];
							$tot_launches = $wincharray['tot_launches'] + 1;
							runQuery("UPDATE tbl_winches SET tot_launches='$tot_launches' WHERE name='$launch_method'");
							$w_launch += 1; //Increment Winch Word gebruik verder ondertoe om aircraft logbook te update
							$tot_launch += 1;
						}
						elseif (strpos($launch_method, "Tug") !== false) {
							$tugdetails = explode(" ", $launch_method);
							$tug_reg = $tugdetails[0];
							$tug_array = callQuery("SELECT hours_tugged, flights_tugged, charge_min AS 'charge' FROM tbl_tugs WHERE tug_reg='$tug_reg'");
							$launch_cost = ($tug_time * 60) * $tug_array['charge'];
							$tot_tug_time = $tug_array['hours_tugged'] + $tug_time;
							//If launch method was a tug, update the tug's logbook | Tug table
							$flights_tugged = $tug_array['flights_tugged'] + 1;
							runQuery("UPDATE tbl_tugs SET hours_tugged='$tot_tug_time', flights_tugged='$flights_tugged' WHERE tug_reg='$tug_reg'"); 
							$a_launch += 1;//Increment Aerotow launches Word gebruik verder ondertoe om aircraft logbook te update
							$tot_launch += 1;
						}
						elseif (strpos($launch_method, "Self") !== false) {
							$launch_cost = 0;
							$s_launch += 1;//Increment Self Launches Word gebruik verder ondertoe om aircraft logbook te update
							$tot_launch += 1;
						}
						else {
							$launch_cost = 0;
							$m_launch += 1;//Increment die Auto Launces Word gebruik verder ondertoe om aircraft logbook te update
							$tot_launch += 1;
						}
						
						
						// ---- DETERMINE FLIGHT COST  / AIRCRAFT COST ----------
						$flight_cost = 0; //clear flight cost variable
						
						if ($charge_option == "Option1") {
							//function flightCostOption1($flightDuration, $chargePerHour)
							$flight_cost = flightCostOption1($flight_duration, $charge_calculation);
							
						}
						elseif ($charge_option == "Option2") {
							//function flightCostOption2($flightDuration, $chargePerMinute, $minCost, $maxCost)
							$calcArray = explode("-", $charge_calculation);
							$chargePerMinute = $calcArray['0'];
							$minCost = $calcArray['1'];
							$maxCost = $calcArray['2'];
							$flight_cost = flightCostOption2($flight_duration, $chargePerMinute, $minCost, $maxCost);
						}
						elseif ($charge_option == "Option3") {
							//function flightCostOption3($flightDuration, $minCost, $maxCost, $timeSplit)
							$calcArray = explode("-", $charge_calculation);
							$minCost = $calcArray['0'];
							$maxCost = $calcArray['1'];
							$timeSplit = $calcArray['2'];
							$flight_cost = flightCostOption3($flight_duration, $minCost, $maxCost, $timeSplit);
						}
						elseif ($charge_option == "TMG1") {
							//function flightCostTMG($tachoStart, $tachoEn1d, $tachoCharge, $noLandings, $landingCharge)
							$calcArray = explode("-", $charge_calculation);
							$tachoCharge = $calcArray['0'];
							$landingCharge = $calcArray['1'];
							$flight_cost = round(flightCostTMG($tachoStart, $tachoEnd, $tachoCharge, $no_landings, $landingCharge),2);
						}
						elseif ($charge_option == "TMG2") {
							//function flightCostTMG2($flightDuration, $glidingCharge, $tachoStart, $tachoEnd, $tachoCharge, $noLandings, $landingCharge)
							$calcArray = explode("-", $charge_calculation);
							$glidingCharge = $calcArray['0'];
							$tachoCharge = $calcArray['1'];
							$landingCharge = $calcArray['2'];
							$flight_cost = round(flightCostTMG2($flight_duration, $glidingCharge, $tachoStart, $tachoEnd, $tachoCharge, $no_landings, $landingCharge),2);
						}
						else {
							echo "Invalid Charge Option";
						}
						
						// Calculate the total flight cost by adding Launch Cost and Flight Cost Together
						$total_flight_cost = $flight_cost + $launch_cost;
						
						
						//find out the invoice number that will be assigned
						$resultarray = callQuery("SELECT COUNT(*) AS 'total' FROM tbl_invoices");
						$invoice_no = $resultarray['total'] + 1;
						
						//this part checks who is responsible for payment and the invoices that person and adds to that person's account
						if ($payment_resp == "P1") {
							$account_array = callQuery("SELECT account_no, balance FROM tbl_accounts WHERE mem_no='$p1_mem_no';");
							$account_no = $account_array['account_no'];
							$balance = $account_array['balance'];
							$balance = $balance + $total_flight_cost;
							$invoice_item_descr = $flight_date." flight in ".$glider_reg." launch: ".$launch_method;
							runQuery("INSERT INTO tbl_invoices (idate, account_no, mem_name, mem_surname, tot_ammount) VALUES('$flight_date', '$account_no', '$p1_name', '$p1_surname', '$total_flight_cost');");
							runQuery("INSERT INTO tbl_inv_items (inv_no, item_descr, item_ammount) VALUES('$invoice_no', '$invoice_item_descr', '$total_flight_cost');");
							runQuery("UPDATE tbl_accounts SET balance='$balance' WHERE account_no = '$account_no'");
							echo "P1 Pays: R".$total_flight_cost;//Echo for testing
						}
						elseif ($payment_resp == "P2") {
							$account_array = callQuery("SELECT account_no, balance FROM tbl_accounts WHERE mem_no='$p2_mem_no';");
							$account_no = $account_array['account_no'];
							$balance = $account_array['balance'];
							$balance = $balance + $total_flight_cost;
							$invoice_item_descr = $flight_date." flight in ".$glider_reg." launch: ".$launch_method;
							runQuery("INSERT INTO tbl_invoices (idate, account_no, mem_name, mem_surname, tot_ammount) VALUES('$flight_date', '$account_no', '$p2_name', '$p2_surname', '$total_flight_cost');");
							runQuery("INSERT INTO tbl_inv_items (inv_no, item_descr, item_ammount) VALUES('$invoice_no', '$invoice_item_descr', '$total_flight_cost');");
							runQuery("UPDATE tbl_accounts SET balance='$balance' WHERE account_no = '$account_no'");
							echo "P2 Pays: R".$total_flight_cost;//Echo for testing
						}
						elseif ($payment_resp == "OWNER_P1") { //This will only calculate the launch cost since it was the owner flying his own aircraft
							$account_array = callQuery("SELECT account_no, balance FROM tbl_accounts WHERE mem_no='$p1_mem_no';");
							$account_no = $account_array['account_no'];
							$balance = $account_array['balance'];
							$balance = $balance + $launch_cost;
							$invoice_item_descr = $flight_date." flight in ".$glider_reg." launch: ".$launch_method;
							runQuery("INSERT INTO tbl_invoices (idate, account_no, mem_name, mem_surname, tot_ammount) VALUES('$flight_date', '$account_no', '$p1_name', '$p1_surname', '$launch_cost');");
							runQuery("INSERT INTO tbl_inv_items (inv_no, item_descr, item_ammount) VALUES('$invoice_no', '$invoice_item_descr', '$launch_cost');");
							runQuery("UPDATE tbl_accounts SET balance='$balance' WHERE account_no = '$account_no'");
							echo "The Owner Pays: R".$launch_cost;//"P2 Pays: R".$total_flight_cost; //Echo for testing
						}
						elseif ($payment_resp == "OWNER_P2") { //This will only calculate the launch cost since it was the owner flying his own aircraft
							$account_array = callQuery("SELECT account_no, balance FROM tbl_accounts WHERE mem_no='$p2_mem_no';");
							$account_no = $account_array['account_no'];
							$balance = $account_array['balance'];
							$balance = $balance + $launch_cost;
							$invoice_item_descr = $flight_date." flight in ".$glider_reg." launch: ".$launch_method;
							runQuery("INSERT INTO tbl_invoices (idate, account_no, mem_name, mem_surname, tot_ammount) VALUES('$flight_date', '$account_no', '$p2_name', '$p2_surname', '$launch_cost');");
							runQuery("INSERT INTO tbl_inv_items (inv_no, item_descr, item_ammount) VALUES('$invoice_no', '$invoice_item_descr', '$launch_cost');");
							runQuery("UPDATE tbl_accounts SET balance='$balance' WHERE account_no = '$account_no'");
							echo "The Owner Pays: R".$launch_cost;//"P2 Pays: R".$total_flight_cost; //Echo for testing
						}
						elseif ($payment_resp == "SPLIT") {
							$splitCost = $total_flight_cost / 2;
							// Invoice Number gaan probleem wees. Opgelos : Increment net die invoice nommer vir die 2 de persoon
							$account_array1 = callQuery("SELECT account_no, balance FROM tbl_accounts WHERE mem_no='$p1_mem_no';");
							$account_no1 = $account_array1['account_no'];
							$balance1 = $account_array1['balance'];
							$balance1 = $balance1 + $splitCost;
							$invoice_item_descr = $flight_date." flight in ".$glider_reg." launch: ".$launch_method;
							runQuery("INSERT INTO tbl_invoices (idate, account_no, mem_name, mem_surname, tot_ammount) VALUES('$flight_date', '$account_no1', '$p1_name', '$p1_surname', '$splitCost');");
							runQuery("INSERT INTO tbl_inv_items (inv_no, item_descr, item_ammount) VALUES('$invoice_no', '$invoice_item_descr', '$splitCost');");
							runQuery("UPDATE tbl_accounts SET balance='$balance1' WHERE account_no = '$account_no1'");
							
							$invoice_no += 1;// Increment Invoice Number because the 2nd person will get another invoice
							
							$account_array2 = callQuery("SELECT account_no, balance FROM tbl_accounts WHERE mem_no='$p2_mem_no';");
							$account_no2 = $account_array2['account_no'];
							$balance2 = $account_array2['balance'];
							$balance2 = $balance2 + $splitCost;
							$invoice_item_descr = $flight_date." flight in ".$glider_reg." launch: ".$launch_method;
							runQuery("INSERT INTO tbl_invoices (idate, account_no, mem_name, mem_surname, tot_ammount) VALUES('$flight_date', '$account_no2', '$p2_name', '$p2_surname', '$splitCost');");
							runQuery("INSERT INTO tbl_inv_items (inv_no, item_descr, item_ammount) VALUES('$invoice_no', '$invoice_item_descr', '$splitCost');");
							runQuery("UPDATE tbl_accounts SET balance='$balance2' WHERE account_no = '$account_no2'");
							
							echo "Each Pays: R".$splitCost;
							
						}
						else {
							$pax_flight_cost = $total_flight_cost + 250;
							echo "PAX pays: R".$pax_flight_cost;//Echo for testing
						}
						
						//AIRCRAFT LOGBOOK UPDATE
						runQuery("UPDATE tbl_gliders SET hours='$glider_hours',tacho='$glider_tacho', land='$g_no_landings', tot_launch='$tot_launch', s_launch='$s_launch', w_launch='$w_launch', a_launch='$a_launch', m_launch='$m_launch' WHERE reg='$glider_reg'");
						
						//Processing finished
						print "</td>";
						print "</tr>";
					}
					echo "</table>"; //Ends The Table
					echo "Timesheet: ".$timesheet." processed successfully";
					
					
					
					//Creates a message and adds it to the auditing History Table
					$change_made = $_SESSION['name']." processed and invoiced timesheet ".$timesheet;
					addHistory($_SESSION['mem_no'], $change_made, "Accounts & Invoices");//calls the addHistory method to add info to the history table.

			//Uncomment this part to enable rule checking
			//}
			//else {
			//	echo "This Timesheet has missing information and can not be finalized. Please check Timesheet Finalizing Rules";
			//}



		}
		else {

		}

	}
	mysql_close($db_handle);
	?>
<body>
<!-- Can be removed after rules are set in coding -->
<strong>Timesheet Finalizing Rules:</strong>
<ul>
	<li>Can not finalize if all Aerotow ("Tug") flights do not have a tug time</li>
    <li>TMG flights have to have Tacho Times</li>
    
</ul>

<form action="timesheet_final.php" name="sheet_final" id="sheet_final" method="post">
<select name="timesheet" id="timesheet" />
		<!-- This is a Select option for the form with a PHP piece of code to pull all the timesheets available from the DB -->
      	<option></option>
      <?php
	  	include('connect.php');// Includes the Connect Page where all the DB connect information is stored in a single place.
	  	$query = "SELECT sheet_no, date FROM tbl_timesheets WHERE locked = 'N';";
		$result = mysql_query($query)
			or die ("Query Failed: " . mysql_error());
		while ($row_t = mysql_fetch_array($result))
		{
			echo "<option>", $row_t['sheet_no']." ".$row_t['date'],"</option>";	
		}
      	mysql_close($db_handle);
      ?></select>

<input type="submit" name="submit" id="submit" value="Submit" />
</form>

<p id="warning"><strong>IMPORTANT - ONCE A TIMESHEET HAS BEEN FINALZED NO CHANGES CAN BE MADE TO ANY OF THE FLIGHTS FOR THAT SHEET. THE FLIGHTS WILL BE INVOICED AS IS</strong></p>

<p align="left"><a href="accounts.php">Cancel</a></p>
<p align="left"><a href="index.php"><img src="images/home.jpg"></a></p>
</body>
</html>
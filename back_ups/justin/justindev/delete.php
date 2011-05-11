<?php session_start(); 

	require("data_access.php");?>
<html>
<!-- DW6 -->
<head>
<title>Exam Reservation System</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="throwaway.css"> 
</head>

	<?php 
	$con = mysql_connect("localhost:3306", "testres", "gaitros");
	if(!$con)
	{
		die("Couldn't connect to SQL host");
	}
	mysql_select_db("test_reservation_system", $con);

	$fsuid = $_REQUEST['fsuid'];
	$seshid = $_REQUEST['seshid'];
	$query = "delete from reservation where fsuid='$fsuid' and tsid='$seshid'";
	mysql_query($query);
	$result = mysql_query("SELECT seats_avail from test_session where seshid = '$seshid'");
	$row = mysql_fetch_array($result);
	$seatcount = $row['seats_avail'];
	$seatcount = $seatcount +1;
	mysql_query("UPDATE test_session SET seats_avail='$seatcount' where seshid='$seshid'");
	$_SESSION['message'] = "Your reservation has been removed.";
	header( 'Location: http://troyprog.dyndns.tv/~testres/student.php' );
	?>




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

	$fsuid = $_SESSION['fsuid'];
	$seshid = $_REQUEST['seshid'];
	$testname = $_REQUEST['testname'];
	$query = " select r1.tsid, t.seats_avail from reservation r1, test_session t where fsuid='$fsuid' AND r1.tsid=t.seshid 
			AND r1.tsid IN ( select seshid from test_session t1, test t2 where t2.testname = '$testname' and t1.testid=t2.testid)";
	$result = mysql_query($query);
	$result2 = mysql_query("SELECT seats_avail from test_session where seshid = '$seshid'");
	$row = mysql_fetch_array($result2);
	$seatcount = $row['seats_avail'];
	if(mysql_num_rows($result))
	{
		$row = mysql_fetch_array($result);
		$oldid = $row['tsid'];
		$oldseat = $row['seats_avail'];
		mysql_query("UPDATE reservation SET tsid='$seshid' where fsuid='$fsuid' and tsid='$oldid'");
		$oldseat=$oldseat+1;
		mysql_query("UPDATE test_session SET seats_avail='$oldseat' where seshid='$oldid'");
		$seatcount = $seatcount-1;
		mysql_query("UPDATE test_session SET seats_avail='$seatcount' where seshid='$seshid'");
		$_SESSION['message'] = "Your reservation has been updated.";
		header( 'Location: http://troyprog.dyndns.tv/~testres/student.php' );
	}
	else
	{
		mysql_query("INSERT INTO reservation VALUES('$fsuid', '$seshid')");
		$seatcount = $seatcount-1;
		mysql_query("UPDATE test_session SET seats_avail='$seatcount' where seshid='$seshid'");
		$_SESSION['message'] = "Your reservation has been set.";
		header( 'Location: http://troyprog.dyndns.tv/~testres/student.php' );
	}
	?>




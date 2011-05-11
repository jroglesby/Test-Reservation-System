<?php 
	session_start(); 

	require("../template/data_access.php");

	redirect();

?>
<html>
<head>
<title>Exam Reservation System</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="../template/testres.css"> 
</head>

<?php 

	$fsuid = $_REQUEST['fsuid'];
	$seshid = $_REQUEST['seshid'];
	deleteReservation($fsuid, $seshid, $con);
	$_SESSION['message'] = "Your reservation has been removed.";
	header( 'Location: http://troyprog.dyndns.tv/~testres/StudentSide/student.php' );
?>




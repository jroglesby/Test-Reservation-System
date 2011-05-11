<?php
        session_start();

        require("../template/data_access.php");

        redirect();

?>
<html>
<head>
<title>Exam Reservation System</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="testres.css">
</head>

<?php

	if(isset($_GET['num'])){
		$temp1 = $_GET['num'];
	} else{}

	if(isset($_GET['l'])){
		$temp2 = $_GET['l'];
	} else{}

	if(isset($_GET['s'])){
		$temp3 = $_GET['s'];
	} else{}

	if(isset($_GET['d'])){
		$temp4 = $_GET['d'];
	} else{}

	if(isset($_GET['t'])){
		$temp5 = $_GET['t'];
	} else{}

	updateSess($temp1,$temp2,$temp3,$temp4,$temp5);
	$result = getSessDate($temp1);

	$mt = date('n');
	$yt = date('Y');

	$row=mysql_fetch_assoc($result);
	$temp = explode("-",$row['day']);

	if(($temp[0] - $yt)==0){
		$mt = $mt - $temp[1];
	} else{}

	echo $mt;
	echo $temp[2];

	$go = 'http://troyprog.dyndns.tv/~testres/AdminSide/calendar.php?day='.$temp[2].'&mon='.$mt;

	header( 'Location: '.$go );
?>

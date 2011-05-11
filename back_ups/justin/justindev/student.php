<?php session_start(); 

	require("data_access.php");?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<title>Exam Reservation Response</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="throwaway.css"> 
</head>
<?php
	if( !array_key_exists('fsuid', $_SESSION) )
	{
		$_SESSION['message'] = "Please sign in.";
		header( 'Location: http://troyprog.dyndns.tv/~testres/testres.php' ) ;
	}
	if ( array_key_exists( 'message', $_SESSION) )
	{
		$message = $_SESSION['message'];
		unset($_SESSION['message']);
	}
	else
	{
		$message = "";
	}
?>
<body>
<body bgcolor="#FFFFFF" text="#000000" link="#660000" leftmargin="0" topmargin="1" marginwidth="0" marginheight="0" vlink="#990000" alink="#FFCC00">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#540115"><b><i><a href="testres.php" class="headlink">Exam Reservation System</a></i></b>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="600" height="550" border="1" align="center" cellpadding="6" cellspacing="0" class="main_box_background">
  <tr height="30"><td bgcolor="#FFFFFF">
	<div class="headerfont"><b>Exam Reservation System<b></div>
  </td></tr>
  <tr>
    <td valign="top">
  <p><font size="+1"><i><font color="#990000"><b>Make a selection:</b></font></i></font></p>
	<div align="center" class="message"><?php echo $message;?></div>
  	<p align="center" class="mainfont"> 
	  <a href="selectclass.php" class="selectlink">Add/Modify a Reservation</a></p>
    <p align="center" class="mainfont">
      <a href="review.php" class="selectlink">Review Reservations</a></p>
  	<p align="center"><br>
  </p> 
    </td></tr></table>


<?php
	session_start(); 

	require("data_access.php");

	redirect();

?>
<html>
<!-- DW6 -->
<head>
<title>Exam Reservation System</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="testres.css"> 
</head>

<?php

	$fsuid = $_SESSION['fsuid'];
	$currentpass = $_REQUEST['currentpass'];
	$newpass1 = $_REQUEST['newpass1'];
	$newpass2 = $_REQUEST['newpass2'];
	$currentpass = passwordHash($currentpass);
	$arr = findLogin($fsuid, $currentpass);
	if(count($arr)>0)
	{
		if($newpass1 == "" || $newpass1 == NULL)
		{
			$_SESSION['message'] = "New password can not be empty.";
			header( 'Location: http://troyprog.dyndns.tv/~testres/changepassword.php' );
		}
		else if($newpass1==$newpass2)
		{
			updatePassword($fsuid, $newpass1);
			$_SESSION['message'] = "Password has been changed.";
			if($_SESSION['role'] == 1)
			{
				header( 'Location: http://troyprog.dyndns.tv/~testres/student.php' );
			}
			else if($_SESSION['role'] == 2)
			{
				header( 'Location: http://troyprog.dyndns.tv/~testres/admin.php' );
			}
		}
		else
		{
			$_SESSION['message'] = "New passwords do not match.";
			header( 'Location: http://troyprog.dyndns.tv/~testres/changepassword.php' );
		}
	}
	else
	{
		$_SESSION['message'] = "Current password incorrect.";
		header( 'Location: http://troyprog.dyndns.tv/~testres/changepassword.php' );
	}

	
	
	
?>




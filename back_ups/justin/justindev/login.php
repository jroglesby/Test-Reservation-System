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
	if($_REQUEST["username"])
	{
		$username = $_REQUEST["username"];
	}
	$password = $_REQUEST["password"];
	$badpass = "";
	if ($username != NULL)
	{
		$result = find_login($username,$password);
		$row = mysql_fetch_array($result);
		if($row)
		{
			$_SESSION['fsuid'] = $row['fsuid'];
			if ($row['role'] = 1)
			{
				header( 'Location: http://troyprog.dyndns.tv/~testres/justin/justindev/student.php' ) ;
			}
			elseif($row['role'] = 2)
			{
				header( 'Location: http://troyprog.dyndns.tv/~testres/admin.php' ) ;
			}
			
		}
		elseif(!$row)
		{
			$_SESSION['message'] = "Invalid username or password.";
			header( 'Location: http://troyprog.dyndns.tv/~testres/testres.php' ) ;
			
		}
	}
	?>




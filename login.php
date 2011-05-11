<?php 
	session_start(); 

	require("template/data_access.php");


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<!-- DW6 -->
<head>
<title>Exam Reservation System</title>
<link rel="stylesheet" type="text/css" href="testres.css"> 
</head>

	<?php 

	$username = $_REQUEST["username"];
	$password = $_REQUEST["password"];
	$badpass = "";
	$password = passwordHash($password);
		$result = findLogin($username,$password);
		if(count($result) > 0)
		{
			$row = $result[0];
			var_dump($row);
			$_SESSION['fsuid'] = $row['fsuid'];
			$_SESSION['role'] = $row['role'];
			
			if($row['reset_password'] == 1)
			{
				header( 'Location: ./changepassword.php' ) ;
			}
			
			else if ($row['role'] == 1)
			{
				header( 'Location: ./StudentSide/student.php' ) ;
			}
			elseif($row['role'] == 2)
			{
				header( 'Location: ./AdminSide/admin.php' ) ;
			}
			
		}
		else
		{
			$_SESSION['message'] = "Invalid username or password.";
			header( 'Location: ./testres.php' ) ;
			
		}
	?>




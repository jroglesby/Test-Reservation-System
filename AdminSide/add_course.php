<?php
	//open session
	session_start(); 

	//server-side include of all data access management layers and utility funcs
	require("../template/data_access.php");
	
	//server-side include of all standard HTML structures that will be used in the file
	require("../template/template_structs.php");
	
	//check for valid session
	redirect();

	//get message to display if there is one
	if ( array_key_exists( 'message', $_SESSION) )
	{
		$message = $_SESSION['message'];
		unset($_SESSION['message']);
	}
	else
	{
		$message = "<br>";
	}
?>

<?php
	//html info, header, etc.
	html_header();
?>

<?php //Name,Num,Sec
	if($_REQUEST['cName'] != NULL)
	{
		$cName = $_REQUEST['cName'];
	}
	else
	{
		$_SESSION['message'] = "Please enter a course name";
		header( 'Location: http://troyprog.dyndns.tv/~testres/AdminSide/edit_course.php' ) ;
		exit;
	}
	if($_REQUEST['cNum'] != NULL)
	{
		$cNum = $_REQUEST['cNum'];
	}
	else
	{
		$_SESSION['message'] = "Please enter a course number";
		header( 'Location: http://troyprog.dyndns.tv/~testres/AdminSide/edit_course.php' ) ;
		exit;
	}
	if($_REQUEST['cSec'] != NULL)
	{
		$cSec = $_REQUEST['cSec'];
	}
	else
	{
		$_SESSION['message'] = "Please enter a section for the course";
		header( 'Location: http://troyprog.dyndns.tv/~testres/AdminSide/edit_course.php' ) ;
		exit;
	}
	
		$ret = add_course($cNum, $cSec, $cName);
		$_SESSION["message"] = $ret;
		header( 'Location: http://troyprog.dyndns.tv/~testres/AdminSide/admin.php' ) ;

?>

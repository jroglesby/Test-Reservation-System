<?php
	//open session
	session_start(); 

	//server-side include of all data access management layers and utility funcs
	require("../template/data_access.php");
	
	//server-side include of all standard HTML structures that will be used in the file
	require("../template/template_structs.php");
	
	//check for valid session
	redirect();
?>	

<?php
	//html info, header, etc.
	html_header();
?>

<?php
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
	
   	//check if test name given, and if it already exists
	if($_REQUEST['newLocName'] != NULL)
	{
		$lName = $_REQUEST['newLocName'];
		trim($lName);
		
		add_location($lName);	
		$_SESSION["message"] = "Location '$lName' successfully added";
		header( 'Location: ./admin.php' ) ;
			
			
	}
	else
	{
		$_SESSION['message'] = "Error adding location, please check if it already exists!";
		header( 'Location: ./location.php' ) ;
		exit;
	}
?>

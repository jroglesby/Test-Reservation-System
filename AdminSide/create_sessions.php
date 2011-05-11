<?php
	//open session
	session_start(); 

	//server-side include of all data access management layers and utility funcs
	require("../template/data_access.php");
	
	//server-side include of all standard HTML structures that will be used in the file
	require("../template/template_structs.php");
	
	//check for valid session
	//redirect();
	
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

<?php
    /*
    NOTE: This message-specific system was set up before the templated mseeage error system
    Technically the erros can all be put into message but this was the error messages are presented
    by the field in which there was a problem
    */
	if ( array_key_exists( 'message', $_SESSION) )
	{
		$message = $_SESSION['message'];
		unset($_SESSION['message']);
	}
	else
	{
		$message = "";
	}
	//Checking everything is still in session
	if(!array_key_exists('test_days_array', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/AdminSide/daily_scheduler.php' );
	}
	else
	{
		$test_days_array = $_SESSION['test_days_array'];
        unset($_SESSION['test_days_array']);
	}
	
	if(!array_key_exists('test_times_array', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/AdminSide/daily_scheduler.php' );
	}
	else
	{
		$test_times_array = $_SESSION['test_times_array'];
        unset($_SESSION['test_times_array']);

	}
	
	if(!array_key_exists('seat_capacity', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/AdminSide/daily_scheduler.php' );
	}
	else
	{
		$seat_capacity = $_SESSION['seat_capacity'];
        unset($_SESSION['seat_capacity']);

	}
	
	if(!array_key_exists('duration', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/AdminSide/daily_scheduler.php' );
	}
	else
	{
		$duration = $_SESSION['duration'];
        unset($_SESSION['duration']);

	}
	if(!array_key_exists('location_id', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/AdminSide/daily_scheduler.php' );
	}
	else
	{
		$loc_id = $_SESSION['location_id'];
        unset($_SESSION['location_id']);

	}
	/* Check for everything for the test name */
	
	if(!array_key_exists('testName', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/AdminSide/daily_scheduler.php' );
	}
	else
	{
		$tName = $_SESSION["testName"];
        unset($_SESSION["testName"]);

	}
	
	if(!array_key_exists('courseName', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/AdminSide/daily_scheduler.php' );
	}
	else
	{
		 $cName = $_SESSION["courseName"];
         unset($_SESSION["courseName"]);

	}
	
	if(!array_key_exists('sectionNum', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/AdminSide/daily_scheduler.php' );
	}
	else
	{
		$sect = $_SESSION["sectionNum"];
        unset($_SESSION["sectionNum"]);

	}
		
	if(!array_key_exists('startDate', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/AdminSide/daily_scheduler.php' );
	}
	else
	{
		$date_one = $_SESSION["startDate"];
        unset($_SESSION["startDate"]);

	}
			
	if(!array_key_exists('endDate', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/AdminSide/daily_scheduler.php' );
	}
	else
	{
		$date_two = $_SESSION["endDate"];
        unset($_SESSION["endDate"]);

	}
	
	//create the test and add it to the database
	$t_id = add_A_test($tName, $cName, $sect, $date_one, $date_two);
	//add sessions to the test
	$ret = create_sessions($test_days_array, $test_times_array, $t_id, $loc_id, $seat_capacity, $duration);
	$_SESSION["message"] = $ret;
	header("Location: http://troyprog.dyndns.tv/~testres/AdminSide/admin.php");
?>

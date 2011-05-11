<!-- Version 0.1 --!>

<?php session_start(); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<title>Created</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="../throwaway.css"> 

</head>

<?php
	require("../template/data_access.php");
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
  /*  $con = mysql_connect("localhost:3306", "testres", "gaitros");
    if(!$con)
    {
        die("Couldn't connect to SQL host");
    }
    $fsuid = $_SESSION['fsuid'];
    mysql_select_db("test_reservation_system", $con);
*/
	//Checking everything is still in session
	if(!array_key_exists('test_days_array', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/troy/daily_scheduler.php' );
	}
	else
	{
		$test_days_array = $_SESSION['test_days_array'];
	}
	
	if(!array_key_exists('test_times_array', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/troy/daily_scheduler.php' );
	}
	else
	{
		$test_times_array = $_SESSION['test_times_array'];
	}
	
	if(!array_key_exists('seat_capacity', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/troy/daily_scheduler.php' );
	}
	else
	{
		$seat_capacity = $_SESSION['seat_capacity'];
	}
	
	if(!array_key_exists('duration', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/troy/daily_scheduler.php' );
	}
	else
	{
		$duration = $_SESSION['duration'];
	}
	if(!array_key_exists('location_id', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/troy/daily_scheduler.php' );
	}
	else
	{
		$loc_id = $_SESSION['location_id'];
	}
	/* Check for everything for the test name */
	
	if(!array_key_exists('testName', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/troy/daily_scheduler.php' );
	}
	else
	{
		$tName = $_SESSION["testName"];
	}
	
	if(!array_key_exists('courseName', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/troy/daily_scheduler.php' );
	}
	else
	{
		 $cName = $_SESSION["courseName"];
	}
	
	if(!array_key_exists('sectionNum', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/troy/daily_scheduler.php' );
	}
	else
	{
		$sect = $_SESSION["sectionNum"];
	}
		
	if(!array_key_exists('startDate', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/troy/daily_scheduler.php' );
	}
	else
	{
		$date_one = $_SESSION["startDate"];
	}
			
	if(!array_key_exists('endDate', $_SESSION))
	{
		//In case session expires or somehow data does not  transfer from review page
		$_SESSION['review_error'] = "Sorry, there was an error processing your request. Please create another schedule";
		header( 'Location: http://troyprog.dyndns.tv/~testres/troy/daily_scheduler.php' );
	}
	else
	{
		$date_two = $_SESSION["endDate"];
	}
	
	//create the test and add it to the database
	$t_id = add_A_test($tName, $cName, $sect, $date_one, $date_two);
	//add sessions to the test
	$ret = create_sessions($test_days_array, $test_times_array, $t_id, $loc_id, $seat_capacity, $duration);
	$_SESSION["message"] = $ret;
	header("Location:http://troyprog.dyndns.tv/~testres/admin.php");
?>
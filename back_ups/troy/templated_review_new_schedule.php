<?php
	//open session
	session_start(); 

	//server-side include of all data access management layers and utility funcs
	require("../data_access.php");
	
	//server-side include of all standard HTML structures that will be used in the file
	require("template_structs.php");
	
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
     *   These are the checks to make sure daily_scheduler.php was filled out
     */
     
    //Checks there is a start and end date:
    if($_REQUEST['first_test_day'] != NULL && $_REQUEST['last_test_day'] != NULL)
    {
    	$start_date = $_REQUEST['first_test_day'];
    	$end_date = $_REQUEST['last_test_day'];
    	
    	//confirm valid range
		$time_one = strtotime($start_date);						
		$time_two = strtotime($end_date);
		$date_one = date("Ymd", $time_one);
		$date_two = date("Ymd", $time_two);
		$today = date("Ymd");
		
		//make sure test starts today (or after)
		//and ends strictly after
		if($today > $date_one || $today >= $date_two)
		{
			$_SESSION['date_error'] = "You must a valid range of days for your test!";
			header( 'Location: http://troyprog.dyndns.tv/~testres/troy/daily_scheduler.php' );
		}
		//make sure test ends after it start
		if($date_one > $date_two)
		{
			$_SESSION['date_error'] = "You must a valid range of days for your test!";
			header( 'Location: http://troyprog.dyndns.tv/~testres/troy/daily_scheduler.php' );
		}
    }
    else
	{
		$_SESSION['date_error'] = "You must a range of days for your test!";
		header( 'Location: http://troyprog.dyndns.tv/~testres/troy/daily_scheduler.php' ) ;
	}
	
	//Check for an entered duration 
	if($_REQUEST['time_limit'] != NULL)
	{
		$test_dur = $_REQUEST['time_limit'];
	}
	else
	{
		$_SESSION['duration_error'] = "You must enter a duration for your test!";
		header( 'Location: http://troyprog.dyndns.tv/~testres/troy/daily_scheduler.php' ) ;
	}
	
	//Check for arrary of times
	if($_REQUEST['date_time'] != NULL)
	{
		$datime_arr = $_REQUEST['date_time'];
	}
	else
	{
		$_SESSION['datime_error'] = "You must select atleast one time to give your test!";
		header( 'Location: http://troyprog.dyndns.tv/~testres/troy/daily_scheduler.php' ) ;
	}
	
	//Check for number of seats
	if($_REQUEST['num_seats'] != NULL)
	{
		$seat_capacity = $_REQUEST['num_seats'];
	}
	else
	{
		$_SESSION['num_seats_error'] = "You must select provide atleast one seat per session to give your test!";
		header( 'Location: http://troyprog.dyndns.tv/~testres/troy/daily_scheduler.php' ) ;
	}
	

$test_days_array = getAllDays($date_one,$date_two); 
$test_times_array = day_time_array($datime_arr);
?>



 				
<?php
	//top header
	html_topBar();
?>
<p>&nbsp;</p>

<!-- main box starts here -->

	<table class="main_box_background" align="center" border="1" cellspacing="0" >
		<tr>
			<td class="headerbox">
					Exam Reservation System
			</td>
		</tr>
		<tr>
			<td class="main_box_td" valign="top">
				<p class="cornercaption">
					<!-- Caption -->
					Review your proposed schedule:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<p class="mainfont">
								<form method="post" action="create_sessions.php">
 				
								<?php
								//Dispay Dates:
								echo '<span class="headerfont">Start Date for test: </span>'.$start_date.'<br><br>';
								echo '<span class="headerfont">End Date for test: </span>'.$end_date.'<br><br>';
								echo '<span class="headerfont">Duration: </span>'.$test_dur.' minutes<br><br>';
								echo '<span class="headerfont">Number of seats: </span>'.$seat_capacity.' seats<br><br>';
								
								echo '<div id="show_review">';

								//MONDAY
								echo '<div style="float:left; width:50%;"> ';
								echo '<div class="headerfont">Monday times: </div>';
								if(count($test_times_array["Monday"]) == 0)
								{
									echo "No Monday test times";
								}
								else
								{
									for ($i=0; $i<count($test_times_array["Monday"])-1; $i++)
									{
										echo $test_times_array["Monday"][$i].",&nbsp;&nbsp;  ";
									}
									echo $test_times_array["Monday"][$i];
								}
								echo "</div>";
								echo '<div style="float:left; width:50%;"> ';
								echo '<div class="headerfont"> Monday dates: </div>';
								if(count($test_days_array["Monday"]) == 0)
								{
									echo "No Mondays within the requested range";
								}
								else
								{
									for ($i=0; $i<count($test_days_array["Monday"]); $i++)
									{
										echo $test_days_array["Monday"][$i]."<br>";
									}
								}
								echo "</div>";
								echo "<br><br><br>";
								//TUESDAY
								echo '<div style="float:left; width:50%;"> ';
								echo '<div class="headerfont">Tuesday times: </div>';
								if(count($test_times_array["Tuesday"]) == 0)
								{
									echo "No Tuesday test times";
								}
								else
								{
									for ($i=0; $i<count($test_times_array["Tuesday"])-1; $i++)
									{
										echo $test_times_array["Tuesday"][$i].",&nbsp;&nbsp;  ";
									}
									echo $test_times_array["Tuesday"][$i];
								}
								echo "</div>";
								echo '<div style="float:left; width:50%;"> ';
								echo '<div class="headerfont"> Tuesday dates: </div>';
								if(count($test_days_array["Tuesday"]) == 0)
								{
									echo "No Tuesdays within the requested range";
								}
								else
								{
									for ($i=0; $i<count($test_days_array["Tuesday"]); $i++)
									{
										echo $test_days_array["Tuesday"][$i]."<br>";
									}
								}
								echo "</div>";
								echo "<br><br><br>"; 	
								//WEDNESDAY
								echo '<div style="float:left; width:50%;"> ';
								echo '<div class="headerfont">Wednesday times: </div>';
								if(count($test_times_array["Wednesday"]) == 0)
								{
									echo "No Wednesday test times";
								}
								else
								{
									for ($i=0; $i<count($test_times_array["Wednesday"])-1; $i++)
									{
										echo $test_times_array["Wednesday"][$i].",&nbsp;&nbsp;  ";
									}
									echo $test_times_array["Wednesday"][$i];
								}
								echo "</div>";
								echo '<div style="float:left; width:50%;"> ';
								echo '<div class="headerfont"> Wednesday dates: </div>';
								if(count($test_days_array["Wednesday"]) == 0)
								{
									echo "No Wednesdays within the requested range";
								}
								else
								{
									for ($i=0; $i<count($test_days_array["Wednesday"]); $i++)
									{
										echo $test_days_array["Wednesday"][$i]."<br>";
									}
								}
								echo "</div>";
								echo "<br><br><br>";
								//THURSDAY
								echo '<div style="float:left; width:50%;"> ';
								echo '<div class="headerfont">Thursday times: </div>';
								if(count($test_times_array["Thursday"]) == 0)
								{
									echo "No Thursday test times";
								}
								else
								{
									for ($i=0; $i<count($test_times_array["Thursday"])-1; $i++)
									{
										echo $test_times_array["Thursday"][$i].",&nbsp;&nbsp;  ";
									}
									echo $test_times_array["Thursday"][$i];
								}
								echo "</div>";
								echo '<div style="float:left; width:50%;"> ';
								echo '<div class="headerfont"> Thursday dates: </div>';
								if(count($test_days_array["Thursday"]) == 0)
								{
									echo "No Thursdays within the requested range";
								}
								else
								{
									for ($i=0; $i<count($test_days_array["Thursday"]); $i++)
									{
										echo $test_days_array["Thursday"][$i]."<br>";
									}
								}
								echo "</div>";
								echo "<br><br><br>";
								//FRIDAY
								echo '<div style="float:left; width:50%;"> ';
								echo '<div class="headerfont">Friday times: </div>';
								if(count($test_times_array["Friday"]) == 0)
								{
									echo "No Friday test times";
								}
								else
								{
									for ($i=0; $i<count($test_times_array["Friday"])-1; $i++)
									{
										echo $test_times_array["Friday"][$i].",&nbsp;&nbsp;  ";
									}
									echo $test_times_array["Friday"][$i];
								}
								echo "</div>";
								echo '<div style="float:left; width:50%;"> ';
								echo '<div class="headerfont"> Friday dates: </div>';
								if(count($test_days_array["Friday"]) == 0)
								{
									echo "No Fridays within the requested range";
								}
								else
								{
									for ($i=0; $i<count($test_days_array["Friday"]); $i++)
									{
										echo $test_days_array["Friday"][$i]."<br>";
									}
								}
								echo "</div>";
								echo "<br><br><br><br>";
							
							echo "</div> <!-- end of review print -->";
							
							
							//Set checked and completed varibles into session
							$_SESSION['test_days_array'] = $test_days_array;
							$_SESSION['test_times_array'] = $test_times_array;
							$_SESSION['seat_capacity'] = $seat_capacity;
							$_SESSION['duration'] = $test_dur;
							?>
				   
						<center><input type="submit" name="Submit" value="Next"></input></center>
						</form>
						<form>
							<!-- JS hax -->
							<center><input type="submit" name="Back" value="Back" onClick="history.go(-1)"></input></center>
						</form>
							</p>
							<!-- End Content -->
						</td>
					</tr>
				</table>
				<!-- inner box ends here -->
				<br>
			</td>
		</tr>
	</table>
<!-- main box ends here -->
<?php
	//whatever needs to go at the bottom of the page.
	html_footer();
?>
						
						
							
					
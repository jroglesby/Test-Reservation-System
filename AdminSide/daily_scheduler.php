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

<link rel="stylesheet" type="text/css" media="all" href="../javascript/jsdatepick-calendar/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="../javascript/jsdatepick-calendar/jsDatePick.min.1.3.js"></script>
<!-- JS DatePicker thanks to: http://javascriptcalendar.org/javascript-date-picker.php -->
<script type="text/javascript">
	
	window.onload = function()
	{
		start_dateObj = new JsDatePick(
		{
			useMode:2,
			target:"startDate",
			dateFormat:"%m/%d/%Y"		
		});
		end_dateObj = new JsDatePick(
		{
			useMode:2,
			target:"endDate",
			dateFormat:"%m/%d/%Y"
		});
	};
</script>

<?php
	//html info, header, etc.
	html_header();
?>
	
<?php
  /*
     * Error checking on this page:
     */
     
     //dates filled out
    if(array_key_exists('date_error', $_SESSION))
	{
		$d_err = $_SESSION['date_error']; 
		unset($_SESSION['date_error']);
    }
    
    //valid # of seats given
    if(array_key_exists('num_seats_error', $_SESSION))
    {
	    $num_seats_error = $_SESSION['num_seats_error'];
	    unset($_SESSION['num_seats_error']);
    }
    
    //duration filled
    if(array_key_exists('duration_error', $_SESSION))
    {
    	$dur_err = $_SESSION['duration_error'];
    	unset($_SESSION['duration_error']);
    }
    
    //atleast one time selected
    if(array_key_exists('datime_error', $_SESSION))
    {
	    $datime_err = $_SESSION['datime_error'];
	    unset($_SESSION['datime_error']);
    }
    
    //genereal error creating schedule from review pg
    if(array_key_exists('review_error', $_SESSION))
    {
	    $review_err = $_SESSION['review_error'];
	    unset($_SESSION['review_error']);
    }
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
					Daily Scheduler:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
														
								  <form method="post" action="review_new_schedule.php">
												<br>
											   <?php
													if(isset($review_err))
													{
														echo ' <div id="reviewErrorOut"><font color = "red">'.$review_err.'</font></div>';
													}
												?>
												Start Date:
												<input type="text" size="12" name = "first_test_day" id="startDate" />
												
												&nbsp; &nbsp; &nbsp; End Date:
										
												<input type="text" size="12" name = "last_test_day" id="endDate" />
												
											  
												<?php
													if(isset($d_err))
													{
														echo ' <div id="dateErrorOut"><font color = "red">'.$d_err.'</font></div>';
													}
												?>
												
												  <br><br>
												Number of Seats:
												<input type="text" size="5" name = "num_seats"/>  
												<?php
													if(isset($num_seats_error))
													{
														echo ' <div id="numSeatsErrorOut"><font color = "red">'.$num_seats_error.'</font></div>';
													}
												?>
							 
											 
												<br><br>
												Duration: &nbsp;
												<input type ="radio" name="time_limit" value="35" />35 minutes &nbsp;&nbsp;
												<input type ="radio" name="time_limit" value="50" />50 minutes &nbsp;&nbsp;
												<input type ="radio" name="time_limit" value="75" />75 minutes &nbsp;&nbsp;
												<input type ="radio" name="time_limit" value="120" />120 minutes                    
												<?php
													if(isset($dur_err))
													{
														echo '<div id="durationErrorOut"> <font color = "red">'.$dur_err.'</font></div>';
													}
												?>                    
												<br><br>
												<?php
													if(isset($datime_err))
													{
														echo '<div id="durationErrorOut"> <center><font color = "red">'.$datime_err.'</center></font></div>';
													}
												?>   
												<center><table name="day_and_time" cellspacing=5 cellpadding=5 >
													<tr>
														<th> Time </th>
														<th></th><th></th>
														<th> Monday </th>
														<th> Tuesday </th>
														<th> Wednesday </th>
														<th> Thursday </th>
														<th> Friday </th>
													</tr>
													<tr>
														<td><center>8:00 am</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="8M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="8T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="8W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="8R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="8F" /></center></td>
													</tr>
													<tr>
														<td><center>8:30 am</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="830M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="830T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="830W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="830R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="830F" /></center></td>
													</tr>
													<tr>
														<td><center>9:00 am</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="9M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="9T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="9W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="9R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="9F" /></center></td>
													</tr>
													<tr>
														<td><center>9:30 am</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="930M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="930T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="930W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="930R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="930F" /></center></td>
													</tr>
													<tr>
														<td><center>10:00 am</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="10M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="10T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="10W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="10R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="10F" /></center></td>
													</tr>
													<tr>
														<td><center>10:30 am</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="1030M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1030T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1030W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1030R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1030F" /></center></td>
													</tr>
													<tr>
														<td><center>11:00 am</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="11M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="11T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="11W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="11R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="11F" /></center></td>
													</tr>
													<tr>
														<td><center>11:30 am</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="1130M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1130T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1130W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1130R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1130F" /></center></td>
													</tr>
													<tr>
														<td><center>12:00 pm</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="12M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="12T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="12W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="12R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="12F" /></center></td>
													</tr>
													<tr>
														<td><center>12:30 pm</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="1230M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1230T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1230W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1230R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1230F" /></center></td>
													</tr>
													<tr>
														<td><center>1:00 pm</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="13M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="13T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="13W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="13R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="13F" /></center></td>
													</tr>
													<tr>
														<td><center>1:30 pm</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="1330M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1330T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1330W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1330R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1330F" /></center></td>
													</tr>
													<tr>
														<td><center>2:00 pm</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="14M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="14T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="14W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="14R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="14F" /></center></td>
													</tr>
													<tr>
														<td><center>2:30 pm</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="1430M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1430T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1430W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1430R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1430F" /></center></td>
													</tr>
													<tr>
														<td><center>3:00 pm</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="15M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="15T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="15W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="15R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="15F" /></center></td>
													</tr>
													<tr>
														<td><center>3:30 pm</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="1530M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1530T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1530W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1530R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1530F" /></center></td>
													</tr>
													<tr>
														<td><center>4:00 pm</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="16M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="16T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="16W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="16R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="16F" /></center></td>
													</tr>
													<tr>
														<td><center>4:30 pm</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="1630M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1630T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1630W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1630R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1630F" /></center></td>
													</tr>
													<tr>
														<td><center>5:00 pm</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="17M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="17T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="17W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="17R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="17F" /></center></td>
													</tr>
													<tr>
														<td><center>5:30 pm</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="1730M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1730T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1730W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1730R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1730F" /></center></td>
													</tr>
													<tr>
														<td><center>6:00 pm</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="18M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="18T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="18W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="18R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="18F" /></center></td>
													</tr>
													<tr>
														<td><center>6:30 pm</center></td>
														<td></td><td></td>
														<td><center><input type="checkbox" name="date_time[]" value="1830M" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1830T" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1830W" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1830R" /></center></td>
														<td><center><input type="checkbox" name="date_time[]" value="1830F" /></center></td>
													</tr>
													<tr>
														<th> Time </th>
														<th></th><th></th>
														<th> Monday </th>
														<th> Tuesday </th>
														<th> Wednesday </th>
														<th> Thursday </th>
														<th> Friday </th>
													</tr>
												</table></center>
							
								   
											<center><input type="submit" name="Submit" value="Next"></center>
										</form>
										
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
						
						
							
					

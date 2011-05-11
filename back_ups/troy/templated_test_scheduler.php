<?php
	//open session
	session_start(); 

	//server-side include of all data access management layers and utility funcs
	require("../data_access.php");
	
	//server-side include of all standard HTML structures that will be used in the file
	require("template_structs.php");
	
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
			target:"reg_startDate",
			dateFormat:"%m/%d/%Y"		
		});
		end_dateObj = new JsDatePick(
		{
			useMode:2,
			target:"reg_endDate",
			dateFormat:"%m/%d/%Y"
		});
	};
</script>
	
<?php
	//TROY
	/* ERROR CHECKING */ 
     
     //dates filled out
    if(array_key_exists('date_error', $_SESSION))
	{
		$d_err = $_SESSION['date_error']; 
		unset($_SESSION['date_error']);
    }
     //name filled out and new
    if(array_key_exists('name_error', $_SESSION))
	{
		$name_err = $_SESSION['name_error']; 
		unset($_SESSION['name_error']);
    }
    //location id found
    if(array_key_exists('loc_error', $_SESSION))
	{
		$l_err = $_SESSION['loc_error']; 
		unset($_SESSION['loc_error']);
    }
?>
	
<?php
	//top header
	html_topBar();
?>

<!--Begin Troy -->
<?php
	//Get course number and section
	$courses = get_courses_array();
	
	
	///Get location options
	/*$loc_query = "SELECT * FROM location";
	$result = mysql_query($loc_query);
	$loc_arry = array();
	while($row = mysql_fetch_array($result))
	{
		$loc_arry[] = $row;
	}*/
	//return $loc_arry
	$loc_arry = get_locations();
    
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
			<td valign="top">
				<p class="cornercaption">
					<!-- Caption -->
					Create new test:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<form method="post" action="add_test.php">
								<br><br>
								Course: 
								<select id=course name="courseNsect">
									<?php
									//for loop to go through courses
									//and put them into the options
										for($i=0; $i<count($courses); $i++)
										{
									?>
											<option>
												<?php
													echo $courses[$i];
												?>
											</option>
									<?php
										}
									?>	
								</select>
								
								<br><br>
								<?php
									if(isset($name_err))
									{
										echo ' <div id="dateErrorOut" class="message">'.$name_err.'</div>';
									}
								?>
								Test Name: <input type = "text" name="testName" \>
								<br><br><br>
								<?php
									if(isset($l_err))
									{
										echo ' <div id="dateErrorOut" class="message">'.$l_err.'</div>';
									}
								?>
								Location:
									<select name="locSel" id="locsel">								
										<?php
											//for loop to go through locations
											//and put them into the options
											//NOTE: loc[iter][0] is locid	
												for($i=0; $i<count($loc_arry); $i++)
												{
											?>
													<option>
														<?php
															echo $loc_arry[$i][1];
														?>
													</option>
											<?php
												}
											?>	
									</select>
								<!--
								<br><br><br> 
								Semester:
								<select id="semester">
									<option>01-Spring</option>
									<option>06-Summer</option>
									<option>09-Fall</option>
								</select>
								<br><br>
								Year:
								<select id="year">
									<option>2011</option>
									<option>2012</option>
								</select>
								-->
								<br><br><br>
								<?php
									if(isset($d_err))
									{
										echo ' <div id="dateErrorOut" class="message">'.$d_err.'</div>';
									}
								?>
								Open Registration:
                    				<input type="text" size="12" name = "reg_open" id="reg_startDate" />
                    
                    			<br><br>
                    			Close Registration:
            					<input type="text" size="12" name = "reg_close" id="reg_endDate" />
            					
						</p>
							<center><input type="submit" name="Submit" value="Next"></center>
						</form>
						<form action = "../admin.php" method="post">
							<center><input type="submit" name="Cancel" value="Cancel"></center>
						</form>
							<!-- End Content -->
						</td>
					</tr>
				</table>
				<!-- inner box ends here -->
			</td>
		</tr>
	</table>
<!-- main box ends here -->
<?php
	//whatever needs to go at the bottom of the page.
	html_footer();
?>
						
						
							
					
<!--Version 0.1 -->
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

<?php
	//Put any applicable data access functions here
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
			<td valign="top">
				<p class="cornercaption">
					<!-- Caption -->
					Administration Home:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<p class="mainfont">
							<?php
								
									echo ' <div id="new_l_err" class="message"><center>'.$message.'<center></div>';
								
							?>
								<ul class="mainfont">
									<li><a href="http://learningforlife.fsu.edu/cat/index.cfm" target="_blank" class="selectlink"> Testing Center's Website </a></li>
									Visit the testing center's website if you have any questions or concerns. The testing center will
									also provide you with the available times to give your exam.
									<br><br>
									<li><a href="RosterUpload.php" class="selectlink"> Import a roster </a></li>
									Using a comma sepertated value (CSV) file, available from Blackboard, you may use this feature to 
									add students, also linking them to the class(es) they are enrolled in.
									<br><br>
									<li><a href="admin_reservation_search.php" class="selectlink">Search for a student's reservation </a></li>
									Use this option to search for a student's current reservations, based on their FSUID.
									<br><br>
									<li><a href="reservation_status.php" class="selectlink">View Reservation Status for a Test</a></li>
									Use this option to view the reservation status for a given class and test. This will display 
									which students in the class have made reservations and which have not. It will also display
									the registration window for the selected test.
									<br><br>
									<li><a href="edit_course.php" class="selectlink">Edit courses </a></li>
									Use this option to add or delete a course, including adding more sections.
									<br><br>
									<li><a href="location.php" class="selectlink"> Add a location </a></li>
									Add a new location to allow tests to be taken.
									<br><br>
									<li><a href="test_scheduler.php" class="selectlink" > Create a new test </a></li>
									Create a new test. You will be required to select the course for which you are creating a test, 
									the name you would like to give the test, a location for the test, and a date range for available
									registration. Once the test is created you are able to create a preliminary schedule. Don't worry
									the schedule is able to be edited.
									<br><br>
									<li><a href="calendar.php" class="selectlink"> Edit a test session </a></li>
									Edit specific test sessions. Upon selecting the course and test you are presented a table of the available
									test sessions. You are then able to edit them on a case by case basis. 
									<div class="message">
										NOTE: Please check the testing center's
										<a href="http://dof.fsu.edu/Leave/Attendance-and-Leave/Holidays-and-Religious-Holy-Days" target="_blank" class="selectlink">
										holiday list </a> to avoid conflicts!
									</div>
									<br>
								</ul>	
							</p>
							<center><a href="../testres.php" class="selectlink"> Logout </a></center>
							<!-- End Content -->
						</td>
					</tr>
				</table>
				<!-- inner box ends here -->
			<!-- Hack padding -->
			<br><br><br>
			</td>
		</tr>
	</table>
<!-- main box ends here -->
<?php
	//whatever needs to go at the bottom of the page.
	html_footer();
?>
						
						
							
					

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
	//Get course number and section
	$courses = get_courses_array();
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
					Edit courses:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<p class="mainfont">
								<form method="post" action="remove_course.php">
									<p>
										If you would like to remove a course please select the course-section
										combination from below and select 'Delete'
									</p>
									<center>Course: 
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
									</select></center>
									<br>
									<center>
									<input type="submit" value="Delete Course"></center>
								</form>
								
								<form method="post" action="add_course.php">
									<br>
									<p>
										If you would like to add a course enter the course's name, number, and section:
									</p>
									<?php
										if(isset($message))
										{
											echo ' <div id="new_l_err" class="message"><center>'.$message.'<center></div>';
										}
									?>
									&nbsp;&nbsp;&nbsp;&nbsp;Course Name:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="cName" size=20/>
									<br>&nbsp;&nbsp;&nbsp;&nbsp;Course Number:&nbsp;&nbsp;<input type="text" name="cNum" size=9/>
									<br>&nbsp;&nbsp;&nbsp;&nbsp;Course Section:&nbsp;&nbsp;&nbsp;<input type="text" name="cSec" size=3/>
								<center><br><input type="submit" value="Create Course"></center>
								</form>
								<br><br>
								<form action = "../admin.php" method="post">
									<center><input type="submit" name="Cancel" value="Cancel"></center>
								</form>
							</p>
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
						
						
							
					
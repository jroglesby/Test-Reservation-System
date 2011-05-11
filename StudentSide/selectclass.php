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
	//Perform any applicable data-access function calls here.
	$result =& findEnrolledClasses($_SESSION['fsuid']);
	if(count($result)==1)
	{
		$row = $result[0];
		header( 'Location: http://troyprog.dyndns.tv/~testres/StudentSide/selecttest.php?classname='.$row['coursenum'] ) ;
	}
?>	


<?php
	//html info, header, etc.
	html_header();
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
					Choose A Class:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<p class="mainfont">
								Please select a class that you are enrolled in that currently has test reservations available:
							</p>
								<form method="post" action="selecttest.php">
								<p class="mainfont" align="center">
									<select name="classname">
<?php
									for($j=0;$j<count($result);$j++)
									{	
										$row = $result[$j];
										$course = $row["coursenum"];
										echo "<option value=\"" . $course . "\">".$course."</option>";
									}
?>
									</select>
								</p>
								<p class="mainfont" align="center">
									<input type="submit" name="Submit" value="Next"><br>
								</p> 
								</form>
								<form action="student.php" method="post">
								<p align="center">
									<input type="submit" name="Cancel" value="Cancel"><br>
								</p>
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
						
						
							
					

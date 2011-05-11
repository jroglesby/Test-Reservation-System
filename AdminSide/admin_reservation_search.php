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
			<td class="main_box_td" valign="top">
				<p class="cornercaption">
					<!-- Caption -->
					Search for Reservations:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<p class="mainfont">
								Providing the FSUID on this page will display all current 
								<br>reservations made by the user with the given FSUID.
								<br><br>
								If no reservations are found, or the user does not exist, page will display:
								<br>
								<div align="center">
									"There are no current reservations for <fsuid>."
								</div>
							</p>
							<hr>
							<p class="mainfont">
								Enter a student's FSUID:
								<form method="post" action="admin_reservation_review.php">
									<input type="text" name="fsuid">&nbsp;&nbsp;
									<input type="Submit" name="submit" value="Search">
								</form>
							</p>
							<br><br>
							<div align="center">
								<form action="admin.php">
									<input type="submit" name="cancel" value="Cancel">
								</form>
							</div>
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
						
						
							
					

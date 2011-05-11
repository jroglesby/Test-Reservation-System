<?php
	//open session
	session_start(); 

	//server-side include of all data access management layers and utility funcs
	require("data_access.php");
	
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
					Make a selection:
				</p>
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<div class="message" align="center">
								<?php echo $message;?>
							</div>
							<p class="mainfont">
								<ul class="mainfont">
									<li>
										<a href="selectclass.php" class="selectlink">Add/Modify a Reservation</a>
									</li>Use this to create a reservation for a test. If a reservation already exists, it will be overwritten with the new reservation.
										<span class="loginbold">Please be certain to review your reservations to ensure that you are not overwriting an existing reservation.</span><br><br>
									<li>
										<a href="review.php" class="selectlink">Review Reservations</a>
									</li>Check this page to review any reservations you currently have. It will also let you know which tests are available for registration
									as well as which tests you've already made reservations for.<br><br>
									<li>
										<a href="http://learningforlife.fsu.edu/cat/index.cfm" target="_blank" class="selectlink"> Testing Center's Website </a>
									</li>
									Visit the testing center's website if you have any questions or concerns.
									<br>
									<br>
									<div align="center">
										<a href="testres.php" class="selectlink">Log Out </a>
									</div>
							</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

<?php
	html_footer();
?>
						
						
							
					
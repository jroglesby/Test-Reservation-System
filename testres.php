<?php
	//open session
	session_start(); 

	//server-side include of all data access management layers and utility funcs
	require("./template/data_access.php");
	
	//server-side include of all standard HTML structures that will be used in the file
	require("./template/template_structs.php");
	
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
					Log In:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<p class="loginbold">
								Important Policies
							</p>
							<ul class="mainfont">
								<li>Exam reservations made or changed after the deadlines posted on the class Agenda will be penalized unless you present a doctor's note at the time of your exam.</li>
								<li>Bring a photo ID to your exam and arrive on time.</li>
							</ul>
							<p class="loginbold">
								Log In Information
							</p>
							<ul class="mainfont">
								<li>Your FSUID is the same that you use to Log In to BlackBoard.</li>
								<li>Your Password will be given to you on the first day of class. You will need to reset it when you first Log In.</li>
							</ul>
							<div align="center" class="loginbold">
								Write down your new password for later use!
							</div>
							<p class="mainfont">
								See the Class Syllabus for more details on these and all class policies.
							</p>
							<hr>
							<p class="loginitalic">
								Please enter the below information then click the Log In button.
							</p>
							<form name="login" method="post" action="login.php">
								<table class="logintable">
									<tr>
										<td class="logintd1">
											<span class="mainfont">
												Your FSUID:&nbsp;
											</span>
										</td>
										<td class="logintd2">
											<span class="mainfont">
												<input type="text" name="username" size="8">@fsu.edu
											</span>
										</td>
									</tr>
									<tr>
										<td class="logintd1">
											<span class="mainfont">
												Your Password:&nbsp;
											</span>
										</td>
										<td class="logintd2">
											<span class="mainfont">
												<input name="password" type="password" maxlength="50">
											</span>
										</td>
									</tr>
								</table>
								<div class="message" align="center">
									<?php echo $message; unset($_SESSION['message']);?>
									<br>
									<input type="submit" name="Submit" value="Log In &gt;">
								</div>
							</form>
							<br>
							<div align="center">
								<form method="post" action="forgotpassword.php">
									<input type="submit" name="forgotpass" value="Forgot Your Password?">
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
						
						
							
					

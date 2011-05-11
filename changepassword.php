<?php
	//open session
	session_start(); 

	//server-side include of all data access management layers and utility funcs
	require("template/data_access.php");
	
	//server-side include of all standard HTML structures that will be used in the file
	require("template/template_structs.php");
	
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
			<td class="main_box_td" valign="top">
				<p class="cornercaption">
					<!-- Caption -->
					Reset your password:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<p class="mainfont">
								For security purposes, you will need to reset your password.
							</p>
							<p class="warning">
								Be sure to write down your new password. You will use this to Log In at a later date.
							</p>
							<form name="passchange" action="passwordreset.php">
							<table>
								<tr>
									<td>
										<span class="mainfont">Enter your current password:</span>
									</td>
									<td>
										<input type="password" name="currentpass">
									</td>
								</tr>
								<tr>
									<td>
										<span class="mainfont">Enter a new password:</span>
									</td>
									<td>
										<input type="password" name="newpass1">
									</td>
								</tr>
								<tr>
									<td>
										<span class="mainfont">Confirm your new password:</span>
									</td>
									<td>
										<input type="password" name="newpass2">
									</td>
								</tr>
							</table>
							<br>
							<div align="center" class="message">
								<?php echo $message;?>
								<br>
								<input type="submit" value="Submit">
							</div>
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
						
						
							
					

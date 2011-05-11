<?php
	//open session
	session_start(); 

	//server-side include of all data access management layers and utility funcs
	require("data_access.php");
	
	//server-side include of all standard HTML structures that will be used in the file
	require("template_structs.php");
	
	//check for valid session
	//redirect();
	
	//get message to display if there is one
	if ( array_key_exists( 'message', $_SESSION) )
	{
		$l_err = $_SESSION['message'];
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
					Add Location
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<form method = post action = "add_loc.php">
								<p class="mainfont">
									<p class="mainfont">
										Tired of only having rooms 401 and 402? Enter the name of a
										new room. The method for naming locations is:
										<div><center>Building_RoomNumber</center></div> 
									</p>
									<br><br><br>
									<center>Location Name: <input type = "text" name="newLocName" \></center>
									<?php
										if(isset($l_err))
										{
											echo ' <div id="new_l_err" class="message"><center>'.$l_err.'<center></div>';
										}
									?>
									<br><br><br>
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
						
						
							
					
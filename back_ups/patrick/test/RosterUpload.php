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
					Roster Upload Tool
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<form action="upload_file.php" method="post"
							enctype="multipart/form-data">
							<label for="file">Filename:</label>
							<input type="file" name="file" id="file" />
							<br />
							<input type="submit" name="submit" value="Submit" />
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
						
						
							
					

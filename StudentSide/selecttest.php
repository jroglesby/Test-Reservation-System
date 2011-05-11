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
	$classname = $_REQUEST['classname'];
	$result =& findAvailableTests($_SESSION['fsuid'], $classname);
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
					Choose a test:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<p class="mainfont">
								Please select a test that you wish to make a reservation for:
							</p>
							<form method="post" action="checkmakeup.php" name="reserve">
							<p class="mainfont" align="center">
								<select name="testid">
<?php
									for($j=0;$j<count($result);$j++)
									{	
										$row = $result[$j];
										$testid = $row['testid'];
										$testname = $row['testname'];
										echo "<option value=\"" . $testid .  "\">".$classname." ".$testname."</option>";
									}
?>

								</select>
								<input type="hidden" name="classname" value="<?php echo $classname;?>">
							</p>
							<p class="mainfont" align="center">
								<input type="submit" name="Submit" value="Next">
								<br>
							</p>
							</form>
							<form method="post" action="student.php">
							<p class="mainfont" align="center">
								<input type="submit" name="Cancel" value="Cancel">
								<br>
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
						
						
							
					

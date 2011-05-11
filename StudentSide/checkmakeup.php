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
	
	$testid = $_REQUEST["testid"];
	$coursenum = $_REQUEST["classname"];
	$_SESSION['makeup'] = checkIfMakeup($coursenum, $testid);
	if($_SESSION['makeup']==false)
	{
		header( 'Location: http://troyprog.dyndns.tv/~testres/StudentSide/searchsession.php?classname='.$coursenum.'&testid='.$testid.'&makeup=false');
	}	
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
					Warning:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<p class="mainfont">
								The registration period for this exam has passed.
								<br>
								If you add or modify your reservation after the registration period, you will be <span class="warning">penalized.</span>
							</p>
							<p align="center" class="mainfont">
								Are you sure you want to do this?
								<center>
									<form action="searchsession.php" method="post">
										<input type="hidden" name="classname" value="<?php echo $_REQUEST["classname"]; ?>">
										<input type="hidden" name="testid" value="<?php echo $_REQUEST["testid"]; ?>">
										<input type="hidden" name="makeup" value="true">
										<input type="submit" name="yes" value="Yes">
									</form>
									&nbsp;&nbsp;&nbsp;
									<form action="student.php">
										<input type="submit" name="cancel" value="Cancel">
									</form>
								</center>
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
						
						
							
					

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
	$fsuid = $_SESSION['fsuid'];
	$seshid = $_REQUEST['seshid'];
	$testid = $_REQUEST['testid'];
	
	
	if(isset($_REQUEST['continue']))
	{
		insertReservation($fsuid, $seshid, $testid, $_SESSION['makeup']);
		$_SESSION['message'] = "Your reservation has been set.";
		header( 'Location: http://troyprog.dyndns.tv/~testres/StudentSide/student.php' );
	}
	else
	{
		$result = checkReservationExists($fsuid, $testid);
		if(count($result) == 0)
		{
			header( "Location: http://troyprog.dyndns.tv/~testres/StudentSide/makereservation.php?seshid=$seshid&testid=$testid&continue=continue" );
		}
		else
		{
			$row = $result[0];
		
	
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
					Confirmation:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<p class="mainfont">
							You currently have a reservation for the following session:
							</p>
							<hr>
							<table border="0" align="center">
								<tr>
									<td width="200">
										Class:
									</td>
									<td>
										<?php echo $row['coursenum'];?>
									</td>
								</tr>
								<tr>
									<td>
										Test:
									</td>
									<td>
										<?php echo $row['testname'];?>
									</td>
								</tr>
								<tr>
									<td>
										Date:
									</td>
									<td>
										<?php echo $row['DATE_FORMAT(t1.day, \'%a, %c/%e\')'];?>
									</td>
								</tr>
								<tr>
									<td>
										Location:
									</td>
									<td>
										<?php echo $row['name'];?>
									</td>
								</tr>
								<tr>
									<td>
										Time:
									</td>
									<td>
										<?php echo $row['TIME_FORMAT(t1.session_time,\'%h:%i%p\')'];?>
									</td>
								</tr>
								<tr>
									<td>
										Makeup:
									</td>
									<td>
									<?php
										if($row['isMakeup']==0)
											echo "<span class=\"makeupno\">No</span>";
										else
											echo "<span class=\"makeupyes\">Yes</span>";
									?>
								</tr>
							</table>
							<hr>
							<p class="mainfont">
								Are you sure you want to overwrite this reservation?
							</p>
							<div align="center">
								<form method="post" action="makereservation.php">
									<input type="hidden" value="<?php echo $testid;?>" name="testid">
									<input type="hidden" value="<?php echo $seshid;?>" name="seshid">
									<input type="hidden" value="continue" name="continue">
									<input type="submit" value="Continue">
								</form>
								<br>
								<form method="post" action="student.php">
									<input type="submit" value="Cancel" name="Cancel">
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
		}
	}
	//whatever needs to go at the bottom of the page.
	html_footer();
?>
						
						
							
					

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
	$fsuid = $_SESSION['fsuid'];
	$result =& findReservedSessions($fsuid);
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
					Review Your Reservations:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<p class="mainfont">
								Below are all of your current reservations.
							</p>
						</td>
					</tr>
<?php 
					$i = 1;
					if(count($result)!=0)
					{
						for($j=0;$j<count($result);$j++)
						{	
							$row = $result[$j];
?>
					<tr>
						<td>
							<hr>
							<p class="mainfont">
								Reservation <?php echo $i;?>:
							</p>
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
								<tr align="center">
									<td>
										<a href="delete.php?fsuid=<?php echo $fsuid ?>&seshid=<?php echo $row[5]?>" class="selectlink">Delete Reservation</a>
									</td>
								</tr>
							</table>
						</td>
					</tr>
<?php 
						$i = $i + 1;
					}
				}
				else
				{
?>
					<tr>
						<td align="center" valign="top">
							<p class="mainfont">
								You do not currently have any reservations.
							</p>
						</td>
					</tr>
<?php
				}
?>
					<tr>
						<td>
							<hr>
							<p align="center" class="mainfont">
								<em>
									NOTE:
									You MUST have your FSU Identification Card to take the exam.
								</em>
							</p>
						</td>
					</tr>
					<tr>
						<td>
							<p align="center">
								<a href="student.php" class="selectlink">Return to home</a>
							</p>
						</td>
					</tr>
				</table>
				<!-- End Content -->
				<!-- inner box ends here -->
			</td>
		</tr>
	</table>
<!-- main box ends here -->
<?php
	//whatever needs to go at the bottom of the page.
	html_footer();
?>
						
						
							
					
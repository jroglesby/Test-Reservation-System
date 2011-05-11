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
	$request = getTestName($_REQUEST['testid']);
	$row = $request[0];
	$testname = $row['testname'];
	
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
					Choose your exam time(s):
				</p>
				<!-- inner box starts here -->
				<table class="searchboxtop" align="center" cellspacing="0" cellpadding="6">
					<tr>
						<th>
							<span class='mainfont'>Webbased Exam Session
								<br><?php echo $_REQUEST["classname"]; ?>
								<br><?php echo $testname; ?>
								<br>Available Times
							</span>
						</th>
					</tr>
				</table>
				<br>
				
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<form name="searchcriteria" method="post" action="displaysession.php">
								<input type="hidden" name="classname" value="<?php echo $_REQUEST["classname"]; ?>">
								<input type="hidden" name="testid" value="<?php echo $_REQUEST["testid"]; ?>">
								<input type="hidden" name="allsessions" value="false">
					<tr>
						<td>
						
							<table>
								<tr>
									<td>
										<span class="mainfont"><b>Search Criteria:</b></span>
									</td>
								</tr>
								<tr valign='top'>
									<td>
										<table>
											<tr>
												<td>
													<span class="mainfont">Enter a date you would like to search for: (MM/DD/YYYY)</span>
												</td>
											</tr>
											<tr>
												<td>
													<input type="text" name="month" size="2"> / 
													<input type="text" name="dayofmonth" size="2"> /
													<input type="text" name="year" size="4">
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td align="center">
										<span class="mainfont"><b>&nbsp;&nbsp;&nbsp;&nbsp;OR</b></span>
									</td>
								</tr>
								<tr>
									<td>
										<span class="mainfont">Select from the following search options:</span>
									</td>
								</tr>
								<tr>
									<td>
										<table>
										<tr>
											<td class="checkboxtd">
												<span class="checklist">Day:<br>
													<input type="checkbox" name="day[]" value="Monday">Monday<br>
													<input type="checkbox" name="day[]" value="Tuesday">Tuesday<br>
													<input type="checkbox" name="day[]" value="Wednesday">Wednesday<br>
													<input type="checkbox" name="day[]" value="Thursday">Thursday<br>
													<input type="checkbox" name="day[]" value="Friday">Friday<br>
												</span>
											</td>
											<td class="checkboxtd">
												<span class="checklist">
												<table>
													<tr>
														<td>
															Start Time:<br>
														</td>
														<td>
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" name="time[]" value="8:00">8:00a.m.
														</td>
														<td>
															<input type="checkbox" name="time[]" value="14:00">2:00p.m.
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" name="time[]" value="9:00">9:00a.m.
														</td>
														<td>
															<input type="checkbox" name="time[]" value="15:00">3:00p.m.
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" name="time[]" value="10:00">10:00a.m.
														</td>
														<td>
															<input type="checkbox" name="time[]" value="17:00">5:00p.m.
														</td>
													</tr>
													<tr>
														<td>
															<input type="checkbox" name="time[]" value="13:00">1:00p.m.
														</td>
														<td>
															<input type="checkbox" name="time[]" value="18:00">6:00p.m.
														</td>
													</tr>
												</table>
												</span>
											</td>
										</tr>
										</table>
									</td>
								</tr>		
							</table>
							<div align="center">
									<br>
									<input type="submit" name="search" value="Search">
								</form>
								<form method="post" action="displaysession.php">
									<input type="hidden" name="allsessions" value="true">
									<input type="hidden" name="classname" value="<?php echo $_REQUEST["classname"]; ?>">
									<input type="hidden" name="testid" value="<?php echo $_REQUEST["testid"]; ?>">
									<input type="submit" name="searchall" value="Display all sessions">
								</form>
								<br>
								<form method="post" action="student.php">
									<input type="submit" name="cancel" value="Cancel">
								</form>
							</div>
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
						
						
							
					

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
	//html info, header, etc.
	html_header();
?>

<?php
	//Put any applicable data access functions here
	$request = getTestName($_REQUEST['testid']);
	$row = $request[0];
	$testname = $row['testname'];
	
	$dayarray = NULL;
	$timearray = NULL;
	if(array_key_exists("day", $_REQUEST))
	{
		$dayarray = $_REQUEST["day"];
	}
	if(array_key_exists("time", $_REQUEST))
	{
		$timearray = $_REQUEST["time"];
	}
	if($_REQUEST["allsessions"] == "true")
	{
		$result =& findAllSessions($_REQUEST["testid"], $_REQUEST["classname"]);
	}
	else
	{
		$result =& findSessions($_REQUEST["testid"], $_REQUEST["classname"], $_REQUEST["year"], $_REQUEST["month"], $_REQUEST["dayofmonth"], $dayarray, $timearray);
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
			<td class="main_box_td" valign="top">
				<p class="cornercaption">
					<!-- Caption -->
					Choose your exam time:
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
<?php

?>
				
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr class="displaySessionBox" valign="top">
						<td>
							<span class="mainfont">Test sessions found that match your search:</span>
							<div align="center"><script type="text/javascript">printMessage();</script></div>
						</td>
					</tr>
<?php
	if(count($result)==0)
	{
?>		
					<tr valign="top">
						<td>
							<span class="message"> No results found. Click "Back to search" and try a different date/time.</span>
						</td>
					</tr>
					<tr align="center">
						<td>
							<form name="return1" action="searchsession.php">
								<input type="hidden" name="classname" value="<?php echo $_REQUEST["classname"]; ?>">
								<input type="hidden" name="testid" value="<?php echo $_REQUEST["testid"]; ?>">
								<input type="submit" name="Back to search" value="Back to search">
							</form>
						</td>
					</tr>
				</table>
<?php
	}
	else
	{
?>	
					
					<tr valign="top">
						<td>
							<form name="reserve" method="post" action="makereservation.php">
								<input type="hidden" name="testid" value="<?php echo $_REQUEST["testid"]; ?>">
								<input type="hidden" name="classname" value="<?php echo $_REQUEST["classname"]; ?>">
							<table width="550" cellspacing='0' class="center_box_background">
								<tr>
										<td width="20">
										</td>
										<td align="center" class="tableheader" width="60">
											Day
										</td>
										<td align="center" class="tableheader" width="75">
											Date
										</td>
										<td align="center" class="tableheader" width="50">
											Time
										</td>
										<td align="center" class="tableheader" width="50">
											Location
										</td>			
										<td align="center" class="tableheader" width="120">
											Number of seats available
										</td>
								</tr>
<?php
						for($i=0;$i<count($result);$i++)
						{	
							$row = $result[$i];
							echo "<tr class=\"blackborder\">\n<td><input type=\"radio\" name=\"seshid\" value=\"".$row['seshid']."\" onchange=\"enableReserveButton();\"></td>\n";
							echo "<td align=\"center\">".$row['DAYNAME(t1.day)']."</td>\n";
							echo "<td align=\"center\">".$row['DATE_FORMAT(t1.day, \'%c/%d/%Y\')']."</td>\n";
							echo "<td align=\"center\">".$row['TIME_FORMAT(t1.session_time,\'%h:%i%p\')']."</td>\n";
							echo "<td align=\"center\">".$row['name']."</td>\n";
							echo "<td align=\"center\">".$row['seats_avail']."</td>\n";
							echo "</tr>";
						}
?>
							</table>
							<div align="center">
									<br>
									<input type="submit" name="Reserve" value="Reserve" disabled="true">
								</form>
								<form action="student.php" method="post">
									<p align="center">
										<input type="submit" name="cancel" value="Cancel">
										<br>
									</p>
								</form>
							</div>
<?php
	}
?>
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
						
						
							
					
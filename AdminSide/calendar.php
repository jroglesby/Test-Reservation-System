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
		$message = "";
	}
?>

<?php
	//html info, header, etc.
	html_header();
?>

<?php
	if(isset($_POST['decre'])){
		$mon_mod = $_POST['thingy'];
		$mon_mod++;
	} else if(isset($_POST['incre'])){
		$mon_mod = $_POST['thingy2'];
		$mon_mod--;
	} else{
		if(isset($_GET['mon'])){
			$mon_mod = $_GET['mon'];
		} else{
			$mon_mod = 0;
		}
	}

	$day_curr_text = date("D", mktime(0,0,0,date("n")-$mon_mod,1,date("Y")));

	if($day_curr_text=="Mon"){
		$find_first = 2;
	} else if($day_curr_text=="Tue"){
		$find_first = 3;
	} else if($day_curr_text=="Wed"){
		$find_first = 4;
	} else if($day_curr_text=="Thu"){
		$find_first = 5;
	} else if($day_curr_text=="Fri"){
		$find_first = 6;
	} else if($day_curr_text=="Sat"){
		$find_first = 7;
	} else if($day_curr_text=="Sun"){
		$find_first = 1;
	} else{}

	$first_found = 0;

	$mon_curr = date("F", mktime(0,0,0,date("n")-$mon_mod,1,date("Y")));
	$year_curr = date("Y", mktime(0,0,0,date("n")-$mon_mod,1,date("Y")));
	$day_in_mon = date("t", mktime(0,0,0,date("n")-$mon_mod,1,date("Y")));
?>
	
<?php
	//top header
	html_topBar();
?>
<p>&nbsp;</p>

<!-- main box starts here -->

	<table class="main_box_background" align="center" border="1" cellspacing="0">
		<tr>
			<td class="headerbox">
					Exam Reservation System
			</td>
		</tr>
		<tr>
			<td valign="top">
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<p class="cornercaption">
						</p>
						<td colspan="5">
							<!-- Content -->
<table border="0"><tr><td>
<div style="width: 395px; height: 485px; border: 1px solid #000000; background-image: url(../template/scanLinesBg.gif)">
<table width="395" height="475" border="0" align="left" cellpadding="2" cellspacing="2">
	<tr height="30" valign="top">
		<td colspan="2" align="right"><font color="#2B0007">
			<form method="post" action="calendar.php" name="form1">
			<input type="hidden" name="thingy" value="<?php echo $mon_mod ?>">
			<input type="submit" name="decre" value="Prev" /></font>
		</td>
		<td colspan="3" align="center"><?php echo $mon_curr." ".$year_curr; ?></td>
		<td colspan="2" align="left"><font color="#2B0007">
			<input type="hidden" name="thingy2" value="<?php echo $mon_mod ?>">
			<input type="submit" name="incre" value="Next" /></form></font>
		</td>
	</tr>

	<tr height="25">
		<td align="center" width="45" bgcolor="#2B0007"><font color="#FFFFFF">Sun</font></td>
		<td align="center" width="45" bgcolor="#2B0007"><font color="#FFFFFF">Mon</font></td>
		<td align="center" width="45" bgcolor="#2B0007"><font color="#FFFFFF">Tue</font></td>
		<td align="center" width="45" bgcolor="#2B0007"><font color="#FFFFFF">Wed</font></td>
		<td align="center" width="45" bgcolor="#2B0007"><font color="#FFFFFF">Thur</font></td>
		<td align="center" width="45" bgcolor="#2B0007"><font color="#FFFFFF">Fri</font></td>
		<td align="center" width="45" bgcolor="#2B0007"><font color="#FFFFFF">Sat</font></td>
	</tr>

<?php   
	$lst_mon = date("t",mktime(0,0,0,date("n")-$mon_mod,0,date("Y"))) - $find_first + 2;

	for($j=0;$j<6;$j++){
		$n = $i = $check =0;
		echo '<tr height="52">';

		while($i<7){
			if(($first_found==0)||($find_first>$day_in_mon)){
				if($find_first==($i+1)){
					$first_found = 1;
					$find_first = 1;
				} else{
					if($first_found==0){
						echo '<td>';
							echo '<table bgcolor="#623E4A" style="color:#FFFFFF;" height="49" width="49"><tr>';
								echo '<td align="center"><font color="gray">'.$lst_mon++.'</font></td>';
							echo '</tr></table>';
						echo '</td>';
						$i++;
					} else if($check!=0){
						echo '<td>';
							echo '<table bgcolor="#623E4A" style="color:#FFFFFF;" height="49" width="49"><tr>';
								echo '<td align="center"><font color="gray">'.++$n.'</font></td>';
							echo '</tr></table>';
						echo '</td>';
						$i++;
					} else{ $i++;}
				}
			} else{
				if(mysql_num_rows(testLookup($year_curr,date("m",mktime(0,0,0,date("n")-$mon_mod)),$find_first))!=0){
					echo '<td><table bgcolor="#2B0007" height="49" width="49"><tr>';
					echo '<td align="center">';
					echo '<a href="calendar.php?day='.$find_first.'&mon='.$mon_mod.'" class="callink2">';
					echo '<font color="red">'.$find_first++.'</font></a>';
				} else{
					echo '<td><table bgcolor="#2B0007" height="49" width="49"><tr>';
					echo '<td align="center">';
					echo '<a href="calendar.php?day='.$find_first.'&mon='.$mon_mod.'" class="callink1">';
					echo '<font color="#FFFFFF">'.$find_first++.'</font></a>';
				}
				echo '</td>';
				echo '</td></tr></table></td>';
				$i++;
			}

			if($find_first==$day_in_mon){
				$check = 1;
			} else{}
		}
		echo '</tr>';
	}
?>

</table>
</div>
</td><td>
<table width="340" border="0">
	<tr>
<?php		
		if(isset($_GET['day'])){
			$trial = $_GET['day'];
			$result = testLookup($year_curr,date("m",mktime(0,0,0,date("n")-$mon_mod)),$trial) or die(mysql_error());
			$holder = "";

			if(mysql_num_rows($result)==1){
				echo '<td>There is '.mysql_num_rows($result).' test sessions on</td>';
			} else if(mysql_num_rows($result)!=0){
				echo '<td>There is '.mysql_num_rows($result).' test sessions on</td>';
			} else{}

			echo '<td align="right">'.$mon_curr.', '.$trial.' '.$year_curr.'</td>';
			echo '</tr></table><BR>';

		echo '<div style="width: 350px; height: 440px; overflow-y: auto; border: 1px solid rgb(0,0,0); background-image: url(../template/scanLinesBg.gif);">';

			echo '<p class=message>'.$message.'</p>'; unset($_SESSION['message']);

			if(mysql_num_rows($result)==0){
				echo '<p>There are no test sessions for this date</p>';
			} else{
				$i = 0;
				echo'<table border="0" height="375" width="320" cellspacing="0" cellpadding="2">';

				$try = "dumb";
				while($row=mysql_fetch_assoc($result)){
					if($i==0){
						$tempCourse = $row['coursenum'];
						$tempTest = $row['testname'];
						echo '<tr height="30"><td colspan="2">'.$tempCourse.'</td></tr>';
						echo '<tr height="20"><td colspan="6" align="center">'.$tempTest.'</td></tr>';
						echo '<tr height="20"><td></td><td align="center">Location</td><td align="center">Seats</td>';
						echo '<td align="center">Start</td><td align="center">Duration</td>';
						$i = 1;
					} else if($tempCourse!=$row['coursenum']){
						$tempCourse = $row['coursenum'];
						echo '<tr height="30"><td colspan="2">'.$tempCourse.'</td></tr>';
						echo '<tr height="20"><td colspan="6" align="center">'.$tempTest.'</td></tr>';
						echo '<tr height="20"><td></td><td align="center">Location</td><td align="center">Seats</td>';
						echo '<td align="center">Start</td><td align="center">Duration</td>';
					} else if($tempTest!=$row['testname']){
						$tempTest = $row['testname'];
						echo '<tr height="20"><td colspan="6" align="center">'.$tempTest.'</td></tr>';
						echo '<tr height="20"><td></td><td align="center">Location</td><td align="center">Seats</td>';
						echo '<td align="center">Start</td><td align="center">Duration</td>';
					} else{}

					echo '<form name="sessions" action="deleteSession.php">';
					echo '<tr height="20"><td align="right"><input type="checkbox" name='.$try++.' value="'.$row['seshid'].'"></td>';
					$holder = "<td align='center'>".$row['name']."</td><td align='center'>".$row['seats_avail']."/".$row['total_seats'];
					$holder = $holder."</td><td align='center'>".$row['session_time']."</td><td width='60' align='center'>".$row['duration']." min</td>";
					echo $holder."<td width='60'align='right'><a href='view.php?num=".$row['seshid']."&l=";
					echo $row['name']."&s=".$row['total_seats']."&d=".$row['duration']."&t=".$row['session_time']."'>view/edit</a></td></tr>";
				}

				echo '<tr height="15"></tr><tr><td colspan="6" align="center">';
				echo '</tr></table></div>';
			}
		} else{
			echo '<td align="left">Select a date to view test sessions on that date.</td>';
			echo '</tr></table><BR>';
			echo '<div style="width: 350px; height: 440px; overflow-y: auto; border: 1px solid rgb(0,0,0); background-image: url(../template/scanLinesBg.gif);">';
			echo '</div>';
		}

?>

</td></td></tr>
<tr><td>
<table width="400" height="85" border="0"><tr>
<td width="340" bgcolor="#2B0007" colspan="3" rowspan="2" align="center">
<font color="red"><u>Dates that have sessions</u></font><BR>
<font color="white"><u>Dates without sessions</u></font><BR>
<font color="gray">Dates from next or last month</font><BR></td></tr></table>
</td><td><table width="350" height="80" bgcolor="#2B0007" border="0"><tr>
<?php	
	if(isset($_GET['day'])){
		if(mysql_num_rows($result)!=0){
			echo '<td align="center">';
			echo '<input type="image" src="../template/delete.gif"></td>';
		} else{
		}

		echo '</form><td align="center"><a href="daily_scheduler.php" class="headlink">Add Session</a></td></tr>';
		echo '</td><td width="300" align="center" colspan="2"><a href="admin.php" class="headlink">Return to Menu</a></td></tr>';
	} else{
		echo '</td><td width="300" align="center"><a href="admin.php" class="headlink">Return to Menu</a></td></tr>';
	}
?>

</td></table></table></table>


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

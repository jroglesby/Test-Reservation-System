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
	if(isset($_GET['num'])){
		$temp = $_GET['num'];
	} else{ $temp = 0;} 
?>
	
<?php
// select lname,fname from reservation R,test_session T,user U where R.fsuid=U.fsuid && R.tsid=T.seshid && R.tsid=46 order by lname;

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
					View Session:
				</p>
				<!-- inner box starts here --><div style="border: 0px solid rgb(0,0,0); width=600;height=350;">
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<table border="0">
								<tr>

								<td rowspan="2"><div style="border: 0px solid rgb(0,0,0); width=450;height=300;">
							<table border="0" width="330"><form name='change' action='changeSession.php'>
<?php

										echo '<tr><td>Location:</td>';
											echo '<td><select name="l">';
		$result = getLocs();
		while($row=mysql_fetch_assoc($result)){

							echo '<option ';
								if(isset($_GET['l'])){
									if($row['name'] == $_GET['l']){
										echo 'selected="yes"';
									} else{}
								} else{}
							echo " value =".$row['locid'].">".$row['name']."</option>";
		}

											echo '</select>';
?>
											</td></tr>
										<tr><td>Seats:</td><td><input type="text" name="s" value="
<?php if(isset($_GET['s'])){	echo $_GET['s'];}else{}?>"
></td></tr>
										<tr><td>Duration:</td>
											<td>
<?php											echo '<select name="d">';
 							echo '<option ';
								if(isset($_GET['d'])){
									if(35 == $_GET['d']){
										echo 'selected="yes"';
									} else{} 
								} else{} 
									echo '>35</option>';
 							echo '<option ';
								if(isset($_GET['d'])){
									if(50 == $_GET['d']){
										echo 'selected="yes"';}
									else{} 
								} else{}
									echo '>50</option>';
 							echo '<option ';
								if(isset($_GET['d'])){
									if(75 == $_GET['d']){
										echo 'selected="yes"';}
									else{} 
								} else{}
									echo '>75</option>';
 							echo '<option ';
								if(isset($_GET['d'])){
									if(120 == $_GET['d']){
										echo 'selected="yes"';}
									else{} 
								} else{}
									echo '>120</option>';

											echo '</select>';
?>
											</td></tr>
										<tr><td>Start Time:</td>
<td>
<select name="t">
<option value="08:00:00">8:00 AM</option>
<option value="08:30:00">8:30 AM</option>
<option value="09:00:00">9:00 AM</option>
<option value="09:30:00">9:30 AM</option>
<option value="10:00:00">10:00 AM</option>
<option value="10:30:00">10:30 AM</option>
<option value="11:00:00">11:00 AM</option>
<option value="11:30:00">11:30 AM</option>
<option value="12:00:00">12:00 PM</option>
<option value="12:30:00">12:30 PM</option>
<option value="13:00:00">1:00 PM</option>
<option value="13:30:00">1:30 PM</option>
<option value="14:00:00">2:00 PM</option>
<option value="14:30:00">2:30 PM</option>
<option value="15:00:00">3:00 PM</option>
<option value="15:30:00">3:30 PM</option>
<option value="16:00:00">4:00 PM</option>
<option value="16:30:00">4:30 PM</option>
<option value="17:00:00">5:00 PM</option>
<option value="17:30:00">5:30 PM</option>
<option value="18:00:00">6:00 PM</option>
<option value="18:30:00">6:30 PM</option>
</select>
</td></tr>
										<input type="hidden" name="num" value="<?php if(isset($_GET['num'])){	echo $_GET['num'];}else{}?>">
										<tr><td colspan="2" align="center"><input type="submit" value="Update"><input type="button" ONCLICK="window.location.href='http://troyprog.dyndns.tv/~testres/tristan/calendar.php'" value="Back"</td></tr>
									</form></table>
								</div></td>

								<td>Registered Students: </td></tr>
								<tr><td><div style="border: 1px solid rgb(0,0,0); overflow-y: auto;background-image: 
										url(scanLinesBg.gif);width=300;height=250;">

<?php		$result = sessLookup($temp);

									echo '<table border="0" width="250" height="300">';
	
		if(mysql_num_rows($result)==0){
					                                echo '<tr><td><p>This session has no registered students</p></td></tr>';
		} else{
			$i = 0;
			while($row=mysql_fetch_assoc($result)){
									echo "<tr valign='top'><td>";
									echo ++$i.". ".$row['lname'].", ".$row['fname'];
									echo "</td></tr>";
			}
		}
?>
						</table></td>

					</tr>
							<!-- End Content -->
				</table></div>
				<!-- inner box ends here -->
			</td>
		</tr>
	</table>
<!-- main box ends here -->
<?php
	//whatever needs to go at the bottom of the page.
	html_footer();
?>

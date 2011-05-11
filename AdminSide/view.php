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
										<tr><td>Location:</td><td><input type="text" name="loc"></tr>
										<tr><td>Seats:</td><td><input type="text" name="seat"></td></tr>
										<tr><td>Duration:</td><td><input type="text" name="dur"></td></tr>
										<tr><td>Start Time:</td><td><input type="text" name="st"></td></tr>
												<input type="hidden" name="mon" value="1">
										<tr><td colspan="2" align="center"><input type="submit" value="Update"></td></tr>
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

<?php session_start(); 

	$connection = mysql_connect("localhost:3306","testres","gaitros") or die(mysql_error());
	mysql_select_db("test_reservation_system",$connection) or die(mysql_error());

?>
<html>
<!-- DW6 -->
<head>
<title>Exam Reservation System</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="../testres.css"> 
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#660000" leftmargin="0" topmargin=".5" marginwidth="0" marginheight="0" vlink="#990000" alink="#FFCC00">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr><td bgcolor="#540115"><b><i><a href="testres.php" class="headlink">Exam Reservation System</a></i></b></td></tr>
</table>
<p>&nbsp;</p>
	<table width="600" height="550" border="1" align="center" cellpadding="6" cellspacing="0" class="main_box_background">
	<tr valign="top" height="30"><td bgcolor="#FFFFFF" colspan="2">
		<div class="headerfont"><b>Exam Reservation System<b></div>
	</td></tr>
 	<tr height="500"><td background="scanLinesBg.gif">
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

		<table width="300" height="475" border="0" align="left" cellpadding="2" cellspacing="2">
			<tr height="30" valign="top">
				<td colspan="2" align="right"><font color="#2B0007">
				<form method="post" action="calendar.php" name="form1"><input type="hidden" name="thingy" value="<?php echo $mon_mod ?>">
				<input type="submit" name="decre" value="Prev" /></font></td>
				<td colspan="3" align="center"><?php echo $mon_curr." ".$year_curr; ?><font color="#2B0007"></font></td>
				<td colspan="2" align="left"><font color="#2B0007"><input type="hidden" name="thingy2" value="<?php echo $mon_mod ?>">
				<input type="submit" name="incre" value="Next" /></form></font></td></tr>

				<tr height="25"><td align="center" width="50" bgcolor="2B0007"><font color="#FFFFFF">Sun</font></td>
				<td align="center" width="50" bgcolor="2B0007"><font color="#FFFFFF">Mon</font></td>
				<td align="center" width="50" bgcolor="2B0007"><font color="#FFFFFF">Tue</font></td>
				<td align="center" width="50" bgcolor="2B0007"><font color="#FFFFFF">Wed</font></td>
				<td align="center" width="50" bgcolor="2B0007"><font color="#FFFFFF">Thur</font></td>
				<td align="center" width="50" bgcolor="2B0007"><font color="#FFFFFF">Fri</font></td>
				<td align="center" width="50" bgcolor="2B0007"><font color="#FFFFFF">Sat</font></td></tr>

			<?php	$form = "";
				$lst_mon = date("t",mktime(0,0,0,date("n")-$mon_mod,0,date("Y"))) - $find_first + 2;

			for($j=0;$j<4;$j++){
				$i = 0;
				$form = '<tr height="52">';

				while($i<7){
					if($first_found==0){
						if($find_first==($i+1)){
							$first_found = 1;
							$find_first = 1;
						} else{
							$form = $form.'<td><table bgcolor="623E4A" style="color:#FFFFFF;" height="50" width="50"><tr>';
							$form = $form.'<td align="center"><font color="gray">'.$lst_mon++.'</font></td>';
							$form = $form.'</td></tr></table></td>';
							$i++;
						}

					} else{
						if(mysql_num_rows(testRet($year_curr,date("m",mktime(0,0,0,date("n")-$mon_mod)),$find_first))!=0){
							$form = $form.'<td><table bgcolor="2B0007" height="50" width="50"><tr>';
							$form = $form.'<td align="center">';
							$form = $form.'<a href="calendar.php?day='.$find_first.'&mon='.$mon_mod.'">';
							$form = $form.'<font color="red">'.$find_first++.'</font></a>';
						} else{
							$form = $form.'<td><table bgcolor="2B0007" height="50" width="50"><tr>';
							$form = $form.'<td align="center">';
							$form = $form.'<a href="calendar.php?day='.$find_first.'&mon='.$mon_mod.'">';
							$form = $form.'<font color="#FFFFFF">'.$find_first++.'</font></a>';
						}

						$form = $form.'</td>';
						$form = $form.'</td></tr></table></td>';

						$i++;
					}
				}
				
				$form = $form.'</tr>';

				echo $form;
			}

			for($j = 0;$j<2;$j++){
				$i = $n = $check = 0;
				$form = '<tr height="52">';

				while($i<7){	
					if($find_first>$day_in_mon){
						if($check!=0){
							$form = $form.'<td><table bgcolor="623E4A" style="color:#FFFFFF;" height="50" width="50"><tr><td align="center">';
							$form = $form.'<font color="gray">'.++$n.'</font>';
							$form = $form.'</td></tr></table></td>';
						} else{}
						$find_first++;
					} else {
						$form = $form.'<td><table bgcolor="2B0007" style="color:#FFFFFF;" height="50" width="50"><tr><td align="center">';
						$form = $form.'<a href="calendar.php?day='.$find_first.'&mon='.$mon_mod.'"><font color=#FFFFFF>'.$find_first++.'</font></a>';
						$form = $form.'</td></tr></table></td>';
						$check = 1;
					}
					$form = $form.'</td>';
				
					$i++;
				}

				$form = $form.'</tr>';

				echo $form;
			}

		?>

		</table>

		<td background="scanLinesBg.gif" width="50%" rowspan="2">
		<table border="0"><tr><td align="left"><a href="../admin.php">Return to Menu</a></td></tr>

<?php		$form = "<tr><td>";

		if(isset($_GET['day'])){
			$trial = $_GET['day'];
			$result = testRet($year_curr,date("m",mktime(0,0,0,date("n")-$mon_mod)),$trial) or die(mysql_error());
			$holder = "";

			$form = $form.'<table border="0"><tr><td width="160" align="left">'.$mon_curr.', '.$trial.' '.$year_curr.'</td>';
			$form = $form.'<td width="160" align="right"><a href="../troy/daily_scheduler.php">Add a session</a></td></tr></table><BR><BR>';

			if(mysql_num_rows($result)==0){
				$form = $form.'There are no test sessions for this date<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>';
			} else{
				$i = 0;
				$form = $form.'<div style="width: 360px; height: 400px; overflow-y: scroll; border: 1px solid rgb(0,0,0); background-color: #FFFFFF;">';
				$form = $form.'<table border="0" height="375" cellspacing="0" cellpadding="2">';
				while($row=mysql_fetch_assoc($result)){
					if($i==0){
						$tempCourse = $row['coursenum'];
						$tempTest = $row['testname'];
						$form = $form.'<tr height="30"><td colspan="2">'.$tempCourse.'</td></tr>';
						$form = $form.'<tr height="20"><td colspan="6" align="center">'.$tempTest.'</td></tr>';
						$form = $form.'<tr height="20"><td></td><td align="center">Location</td><td align="center">Seats</td>';
						$form = $form.'<td align="center">Start</td><td align="center">Duration</td>';
						$i = 1;
					} else if($tempCourse!=$row['coursenum']){
						$tempCourse = $row['coursenum'];
						$form = $form.'<tr height="30"><td colspan="2">'.$tempCourse.'</td></tr>';
						$form = $form.'<tr height="20"><td colspan="6" align="center">'.$tempTest.'</td></tr>';
						$form = $form.'<tr height="20"><td></td><td align="center">Location</td><td align="center">Seats</td>';
						$form = $form.'<td align="center">Start</td><td align="center">Duration</td>';
					} else if($tempTest!=$row['testname']){
						$tempTest = $row['testname'];
						$form = $form.'<tr height="20"><td colspan="6" align="center">'.$tempTest.'</td></tr>';
						$form = $form.'<tr height="20"><td></td><td align="center">Location</td><td align="center">Seats</td>';
						$form = $form.'<td align="center">Start</td><td align="center">Duration</td>';
					} else{}

	
					$form = $form.'<form>';
					$form = $form.'<tr height="20"><td width="8%" align="right"><input type="checkbox"></td>';
					$holder = "<td width='18%'>".$row['name']."</td><td width='18%'>".$row['seats_avail']."/".$row['total_seats'];
					$holder = $holder."</td><td width='18%'>".$row['session_time']."</td><td width='19%' align='center'>".$row['duration']." min</td>";
					$form = $form.$holder."<td width='19%'align='right'><a href='view.php'>view/edit</a></td></tr>";
				}
				$form = $form.'<tr height="15"></tr><tr><td colspan="6" align="center">';
				$form = $form.'<input type="submit" value="Delete Checked"></td></tr></form></table></div>';
			}
		
		} else{
			$form = "<tr height='470'><td>Select a date to view test sessions on that date.";
		}

		echo $form; ?>

		</td></tr></table></td>

		<tr><td bgcolor="#2B0007" align="center">
			<font color="red"><u>Dates that have sessions</u></font><BR>
			<font color="white"><u>Dates without sessions</u></font><BR>
			<font color="gray">Dates from next or last month</font><BR></td>
		</tr>

		</table>

<?php

function testRet($year,$mon,$first){
        global $connection;
	$callIt = $year."-".$mon."-".$first;
	$q = "select coursenum,testname,seats_avail,total_seats,name,session_time,duration from test_session T,test D,location L where T.day='$callIt' && D.testid=T.testid && T.locid=L.locid;";
	return mysql_query($q, $connection);
}

	?>
	</td></tr>
</table>

<p>&nbsp; </p>
</body>
</html>

<?php session_start(); ?>
<html>
<!-- DW6 -->
<head>
<title>Exam Reservation System</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="../testres.css"> 
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#660000" leftmargin="0" topmargin=".5" marginwidth="0" marginheight="0" vlink="#990000" alink="#FFCC00">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#540115"><b><i><a href="testres.php" class="headlink">Exam Reservation System</a></i></b>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
 <table width="600" height="550" border="1" align="center" cellpadding="6" cellspacing="0" class="main_box_background">
	<tr valign="top" height="30"><td bgcolor="#FFFFFF">
		<div class="headerfont"><b>Exam Reservation System<b></div>
	</td></tr>
 	<tr height="500"><td bgcolor="#CDC092">
	<?php 

		$connection = mysql_connect("localhost:3306","testres","gaitros") or die(mysql_error());
		mysql_select_db("test_reservation_system",$connection) or die(mysql_error());


		if(isset($_POST['decre'])){
			$mon_mod = $_POST['thingy'];
			$mon_mod++;
		} else if(isset($_POST['incre'])){
			$mon_mod = $_POST['thingy2'];
			$mon_mod--;
		} else{
			$mon_mod = 0;
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

		<table width="750" height="475" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr valign="top">
				<td colspan="3" align="right"><font color="#2B0007">
				<form method="post" name="form1"><input type="hidden" name="thingy" value="<?php echo $mon_mod ?>">
				<input type="submit" name="decre" value="Back" /></font></td>
				<td colspan="1" align="center"><?php echo $mon_curr." ".$year_curr; ?><font color="#2B0007"></font></td>
				<td colspan="3" align="left"><font color="#2B0007"><input type="hidden" name="thingy2" value="<?php echo $mon_mod ?>">
				<input type="submit" name="incre" value="Forward" /></form></font></td></tr>

				<tr><td align="center" width="14%" bgcolor="2B0007"><font color="#FFFFFF">Sun</font></td>
				<td align="center" width="14%" bgcolor="2B0007"><font color="#FFFFFF">Mon</font></td>
				<td align="center" width="14%" bgcolor="2B0007"><font color="#FFFFFF">Tue</font></td>
				<td align="center" width="14%" bgcolor="2B0007"><font color="#FFFFFF">Wed</font></td>
				<td align="center" width="14%" bgcolor="2B0007"><font color="#FFFFFF">Thur</font></td>
				<td align="center" width="14%" bgcolor="2B0007"><font color="#FFFFFF">Fri</font></td>
				<td align="center" width="14%" bgcolor="2B0007"><font color="#FFFFFF">Sat</font></td></tr>

			<tr valign="top">

			<?php	$form = "";
				$i = 1;
				$lst_mon = date("t",mktime(0,0,0,date("n")-$mon_mod,0,date("Y"))) - $find_first + 2;

				while($i<8){
					if($first_found==1){		
						$first_found = 1;
						$find_first++;
						$form = $form.'<td height="20" align="center">'."$find_first".'</td>';
					} else if($find_first==$i){
						$first_found = 1;
						$find_first = 1;
						$form = $form.'<td height="20" align="center">'."$find_first".'</td>';
					} else{
						$form = $form.'<td align="center"><font color="gray">'.$lst_mon++.'</font></td>';
					}

					$i++;
				}

				$form = $form.'</tr>';

				echo $form;


			for($j=0;$j<3;$j++){
				$i = 6;
				$form = '<tr>';
				$trial = 7;

				while($i>=0){
					if(($find_first-$i)>0){
						$form = $form.'<td height="100"><table bgcolor="2B0007" style="color:#FFFFFF;" height="100" width="105"><tr><td align="center">';
						$result = testRet($year_curr,date("m",mktime(0,0,0,date("n")-$mon_mod)),$find_first-$trial) or die(mysql_error());
						$holder = "";
							if(mysql_num_rows($result)==0){
								echo "error";
							} else{
								while($row = mysql_fetch_assoc($result)){
									if($row['count(*)']!=0){
										$holder = "Test ".$row['testid']." (".$row['count(*)'].")";
										$holder = "<a href='../troy/daily_scheduler.php'>".$holder."</a><BR>";
									} else{}
								}
							}
						$form = $form.$holder.'</td></tr></table></td>';
					} else{
						$form = $form.'<td height="100"><table bgcolor="623E4A" height="100" width="105"><tr><td></td></tr></table></td>';
					}

					$i--;
					$trial--;
				}

				echo $form;

				if($j==0){
					$find_first++;
				} else{}

				$i = 0;
				$form = '<tr height="20" valign="top">';

				while($i<7){
					$form = $form.'<td align="center">'.$find_first++.'</td>';
					$i++;
				}

				echo $form;
			}

				$i = 6;
				$form = '<tr>';
				$trial = 7;

				while($i>=0){
					if(($find_first-$i)>0){
						$form = $form.'<td height="100"><table bgcolor="2B0007" style="color:#FFFFFF;" height="100" width="105"><tr><td align="center">';
						$result = testRet($year_curr,date("m",mktime(0,0,0,date("n")-$mon_mod)),$find_first-$trial) or die(mysql_error());
						$holder = "";
							if(mysql_num_rows($result)==0){
								echo "error";
							} else{
								while($row = mysql_fetch_assoc($result)){
									if($row['count(*)']!=0){
										$holder = "Test ".$row['testid']." (".$row['count(*)'].")";
										$holder = "<a href='../troy/daily_scheduler.php'>".$holder."</a><BR>";
									} else{}
								}
							}
						$form = $form.$holder.'</td></tr></table></td>';
					} else{}

					$i--;
					$trial--;
				}

				echo $form;



			for($j = 0;$j<2;$j++){
				$i = $n = $check = 0;
				$form = '<tr height="20" valign="top">';

				while($i<7){	
					$form = $form.'<td align="center">';
					if($find_first>$day_in_mon){
						if($check!=0){
							$form = $form.'<font color="gray">'.++$n.'</font>';
						} else{}
						$find_first++;
					} else {
						$form = $form.$find_first++;
						$check = 1;
					}
					$form = $form.'</td>';
				
					$i++;
				}

				$form = $form.'</tr>';

				echo $form;

				$i = 0;
				$form = '<tr>';
				$temp_var = $find_first - $day_in_mon;

				$check = 0;
				$trial = 7;
				while($i<7){
					if((8-$temp_var++)>0){
						$form = $form.'<td height="100"><table bgcolor="2B0007" style="color:#FFFFFF;" height="100" width="105"><tr><td align="center">';
						$result = testRet($year_curr,date("m",mktime(0,0,0,date("n")-$mon_mod)),$find_first-$trial) or die(mysql_error());
						$holder = "";
							if(mysql_num_rows($result)==0){
								echo "error";
							} else{
								while($row = mysql_fetch_assoc($result)){
									if($row['count(*)']!=0){
										$holder = "Test ".$row['testid']." (".$row['count(*)'].")";
										$holder = "<a href='../troy/daily_scheduler.php'>".$holder."</a><BR>";
									} else{}
								}
							}
						$form = $form.$holder.'</td></tr></table></td>';
						$check = 1;
					} else{
						if($check!=0){
							$form = $form.'<td height="100"><table bgcolor="623E4A" height="100" width="105"><tr><td></td></tr></table></td>';
						}
						else{}
					}
	
					$i++;
					$trial--;
				}
			
				$form = $form.'</tr>';

				echo $form;
			}
		echo '</table>';

function testRet($year,$mon,$first){
        global $connection;
	$callIt = $year."-".$mon."-".$first;
	$q = "SELECT testid,count(*) FROM test_session WHERE (day='$callIt');";
	return mysql_query($q, $connection);
}

	?>
	</td></tr>
</table>

<p>&nbsp; </p>
</body>
</html>


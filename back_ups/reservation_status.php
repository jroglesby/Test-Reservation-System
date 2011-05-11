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
	$classresult = findAllClasses();
	$classlist='<select name="classname" onchange="submitform(document.resstatus.testid);">';
	$classlist.='<option value="">Select a class</option>';
	$testlist='<select name="testid" onchange="submitform();">';
	$testlist.='<option value="">Select a class</option>';
	$div = "";
	if (isset($_REQUEST['classname']) && $_REQUEST['classname']!="" && $_REQUEST['testid']=="")
	{
		for($i=0;$i<count($classresult);$i++)
		{
			$row = $classresult[$i];
			if($row['coursenum'] == $_REQUEST['classname'])
			{
				$classlist.='<option value="'.$row['coursenum'].'" selected>'.$row['coursenum']."</option>";
			}
			else
			{
				$classlist.='<option value="'.$row['coursenum'].'">'.$row['coursenum']."</option>";
			}
		}
		$result=findAllTests($_REQUEST['classname']);
		
		for($i=0;$i<count($result);$i++)
		{
			$row=$result[$i];
			$testlist.='<option value="'.$row['testid'].'">'.$row['testname']."</option>";
		}
		$div = "Select a test to view the reservation data.";
	} 
	else if(isset($_REQUEST['classname']) && isset($_REQUEST['testid']) && $_REQUEST['classname']!="" && $_REQUEST['testid']!="")
	{
		for($i=0;$i<count($classresult);$i++)
		{
			$row = $classresult[$i];
			if($row['coursenum'] == $_REQUEST['classname'])
			{
				$classlist.='<option value="'.$row['coursenum'].'" selected>'.$row['coursenum']."</option>";
			}
			else
			{
				$classlist.='<option value="'.$row['coursenum'].'">'.$row['coursenum']."</option>";
			}
		}
		$result=findAllTests($_REQUEST['classname']);
		
		for($i=0;$i<count($result);$i++)
		{
			$row=$result[$i];
			if($row['testid'] == $_REQUEST['testid'])
			{
				$testlist.='<option value="'.$row['testid'].'" selected>'.$row['testname']."</option>";
				$reg_win_open = $row['reg_win_open'];
				$reg_win_close = $row['reg_win_close'];
				$testname = $row['testname'];
			}
			else
			{
				$testlist.='<option value="'.$row['testid'].'">'.$row['testname']."</option>";
			}
		}
		$div.='Window for '.$testname.' opens on '.$reg_win_open.'. <br>';
		$div.='Window for '.$testname.' closes on '.$reg_win_close.'. <br><br>';
		$div.='Students who HAVE made reservations for this test:<br><div class="tabbed">';
		$result = findStudentsWithReservation($_REQUEST['testid']);
		if(count($result) == 0)
		{
			$div.='No students have made a reservation.<br>';
		}
		else
		{
			for($i=0;$i<count($result);$i++)
			{
				$div.=$result[$i]['lname'].', '.$result[$i]['fname'].'<br>';
			}
		}
		$div.='</div>';
		
		$result = findStudentsWithoutReservation($_REQUEST['testid'], $_REQUEST['classname']);
		if(count($result) > 0)
		{
			$div.='Students who HAVE NOT made reservations for this test:<br><div class="tabbed">';
			for($i=0;$i<count($result);$i++)
			{
				$div.=$result[$i]['lname'].', '.$result[$i]['fname'].'<br>';
			}
		}
		$div.='</div>';
		
	}
		
	
	else
	{
		for($i=0;$i<count($classresult);$i++)
		{
			$row = $classresult[$i];
			$classlist.='<option value="'.$row['coursenum'].'">'.$row['coursenum']."</option>\n";
			$div = "Select a class to view the reservation data.";
		}
	}
	
	$classlist.="</select>";
	$testlist.="</select>";
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
					View Reservation Status:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<p class="mainfont">
							Please select a class. Once a class has been selected you will be able to select a test
							that you would like to view.
							</p>
							<form name="resstatus" method="post" action="reservation_status.php">
							<table>
								<tr>
									<td width="50">
										Class:&nbsp;&nbsp;
									</td>
									<td>
										<?php echo $classlist; ?>
									</td>
								</tr>
								<tr>
									<td>
										Test:&nbsp;&nbsp;
									</td>
									<td>
										<?php echo $testlist; ?>
										
									<td>
								</tr>
							</table>
							<hr>
							<div class="mainfont">
								<?php echo $div; ?>
							</div>
							<hr>
							<p align="center">
								<a href="admin.php" class="selectlink">Return to menu</a>
							</p>
							</form>
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
						
						
							
					
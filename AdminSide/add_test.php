
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
	//TROY
	//Get course number and section
	$con = mysql_connect("localhost:3306", "testres", "gaitros");
    if(!$con)
    {
        die("Couldn't connect to SQL host");
    }
    $fsuid = $_SESSION['fsuid'];
    mysql_select_db("test_reservation_system", $con);
    
   
   	//check if test name given, and if it already exists
	
	if($_REQUEST['testName'] != NULL)
	{
		$tName = $_REQUEST['testName'];
		trim($tName);
		$str_to_parse = $_REQUEST['courseNsect'];
		$pos = stripos($str_to_parse, "-");
		$cName = substr($str_to_parse, 0, $pos);
		$sect = (int)substr($str_to_parse, $pos+1, strlen($str_to_parse));
		
		$query = "SELECT * FROM test t WHERE t.coursenum = '$cName' AND t.section = '$sect' AND t.testname = '$tName'";
		$result = mysql_query($query);
		$arr=array();
		while($row = mysql_fetch_array($result))
		{	
			$arr[] = $row;
		}
		if(count($arr) != 0) //matching test
		{
			$_SESSION['name_error'] = "You must enter a new test name, one that is not already in use for this course!";
			header( 'Location: ./test_scheduler.php' ) ;
			exit;
		}
		
	}
	else
	{
		$_SESSION['name_error'] = "You must enter a valid test name, one that is actually there!";
		header( 'Location: ./test_scheduler.php' ) ;
		exit;
	}
   
	//Checks there is a start and end date:
    if($_REQUEST['reg_open'] != NULL && $_REQUEST['reg_close'] != NULL)
    {
    	$start_date = $_REQUEST['reg_open'];
    	$end_date = $_REQUEST['reg_close'];
    	
    	//confirm valid range
		$time_one = strtotime($start_date);						
		$time_two = strtotime($end_date);
		$date_one = date("Ymd", $time_one);
		$date_two = date("Ymd", $time_two);
		$today = date("Ymd");
		
		//make sure test starts today (or after)
		//and ends strictly after
		if($today > $date_one || $today >= $date_two)
		{
			$_SESSION['date_error'] = "You must create a valid registration window for your test!";
			header( 'Location: ./test_scheduler.php' ) ;
			exit;
		}
		//make sure test ends after it start
		if($date_one > $date_two)
		{
			$_SESSION['date_error'] = "You must create a valid registration window for your test!";
			header( 'Location: ./test_scheduler.php' ) ;
			exit;
		}
    }
    else
	{
		$_SESSION['date_error'] = "You must create a valid registration window for your test!";
		header( 'Location: ./test_scheduler.php' ) ;
		exit;
	}

	
	//Get loc id from name
	$locName = $_REQUEST['locSel'];
	$loc_id = get_A_location($locName);
	
	
	//If everything is okay 
	//okay to add to table, but
	//We do not add the test until 
	//create_sessions in case they stop
	//early (test would just be 'in limbo'
	//store everythin in session to use later
	$_SESSION["testName"] = $tName;
	$_SESSION["courseName"] = $cName;
	$_SESSION["sectionNum"] = $sect;
	$_SESSION["startDate"] = $date_one;
	$_SESSION["endDate"] = $date_two;
	
	//Save loc id into session for later
	$_SESSION["location_id"] = $loc_id;
	
	
	header( 'Location: daily_scheduler.php' ) ;
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
			<td valign="top">
				<p class="cornercaption">
					<!-- Caption -->
					Caption:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<p class="mainfont">
							Content
							<br>
							Will
							<br>
							Go
							<br>
							Here
							<br>
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
						
						
							
					

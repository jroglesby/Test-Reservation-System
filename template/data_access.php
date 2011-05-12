<?php
	$localhost = "dbsrv.cs.fsu.edu";
	$dbusername = "trosenbe";
	$dbpassword = "9k1MaRZ2";
	$dbname = "tro_cap_ogl_ami_db"
	function redirect()
	{
		if( !array_key_exists('fsuid', $_SESSION) )
		{
			$_SESSION['message'] = "Please sign in.";
			header( 'Location: http://troyprog.dyndns.tv/~testres/testres.php' ) ;
		}
		
	}
	
	function updatePassword($fsuid, $newpassword)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db($dbname, $con);
		$newpassword = passwordHash($newpassword);
		mysql_query("UPDATE user set password='$newpassword' where fsuid='$fsuid'");
		mysql_query("UPDATE user set reset_password='0' where fsuid='$fsuid'");
	}
	
	function findLogin($username, $password)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db($dbname, $con);
		
		$result = mysql_query("SELECT * from user WHERE fsuid='$username' AND password='$password'");
		$arr=array();
		while($row = mysql_fetch_array($result))
		{	
			$arr[] = $row;
		}
		return $arr;
	}
	
	function findSessions($testid, $classname, $year, $month, $dayofmonth, $dayarray, $timearray)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db($dbname, $con);
		
		$dateflag=false;
		$query = "select t1.seshid, DATE_FORMAT(t1.day, '%c/%d/%Y'), DAYNAME(t1.day), TIME_FORMAT(t1.session_time,'%h:%i%p'), 
			l1.name, t1.seats_avail FROM test_session t1, location l1, test t2 WHERE t1.locid=l1.locid and t1.testid = t2.testid 
				and t2.testid='".$testid."'";
					
			if( $month != NULL)
			{
				if( $dayofmonth != NULL)
				{
					if( $year != NULL)
					{
						$dateflag = true;
						$query = $query . "AND (t1.day = '".$year."-".$month."-".$dayofmonth."' ";
					}
				}
			}
			if ($dayarray != NULL)
			{
				if($dateflag == true)
				{	
					$query = $query . "OR (";
				}
				else
				{
					$query = $query . "AND (";
				}
				for($i=0;$i<(count($dayarray)-1);$i++)
				{
					$query = $query . "DAYNAME(t1.day) = '".$dayarray[$i]."' OR ";
				}
				$query = $query . "DAYNAME(t1.day) = '".$dayarray[count($dayarray)-1]."')";
			}
			if ($timearray != NULL)
			{
				$query = $query . "AND (";
				for($i=0;$i<(count($timearray)-1);$i++)
				{
					$query = $query . "t1.session_time = '".$timearray[$i]."' OR ";
				}
				$query = $query . "t1.session_time = '".$timearray[count($timearray)-1]."')";
			}
			if($dateflag == true)
			{
				$query = $query.")";
			}
			$query = $query . " ORDER BY DATE_FORMAT(t1.day, '%c/%d/%Y')";
		$result = mysql_query($query);
		$arr=array();
		while($row = mysql_fetch_array($result))
		{	
			$arr[] = $row;
		}
		return $arr;
	}
	
	function findAllSessions($testid, $classname)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db($dbname, $con);
		
		$query = "select t1.seshid, DATE_FORMAT(t1.day, '%c/%d/%Y'), DAYNAME(t1.day), TIME_FORMAT(t1.session_time,'%h:%i%p'), 
			l1.name, t1.seats_avail FROM test_session t1, location l1, test t2 WHERE t1.locid=l1.locid and t1.testid = t2.testid 
				and t2.testid='".$testid."' and t2.coursenum='".$classname."' and t1.day >= CURDATE() ";
		$query = $query . " ORDER BY DATE_FORMAT(t1.day, '%c/%d/%Y')";
		$result = mysql_query($query);
		$arr=array();
		while($row = mysql_fetch_array($result))
		{	
			$arr[] = $row;
		}
		return $arr;
	}
		
		

	function findReservedSessions($fsuid)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db($dbname, $con);
		
		$result = mysql_query("SELECT t2.coursenum,  t2.testname, DATE_FORMAT(t1.day, '%a, %c/%e'), l1.name, TIME_FORMAT(t1.session_time,'%h:%i%p'),  t1.seshid, r1.isMakeup 
					FROM reservation r1, test_session t1, test t2, location l1 
						WHERE r1.fsuid='$fsuid' AND r1.tsid = t1.seshid AND t1.testid = t2.testid AND t1.locid=l1.locid");
		$arr=array();
		while($row = mysql_fetch_array($result))
		{	
			$arr[] = $row;
		}
		return $arr;
	}

	function deleteReservation($fsuid, $seshid)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db($dbname, $con);
		
		$query = "delete from reservation where fsuid='$fsuid' and tsid='$seshid'";
		mysql_query($query);
		
		$result = mysql_query("SELECT seats_avail from test_session where seshid = '$seshid'");
		$row = mysql_fetch_array($result);
		$seatcount = $row['seats_avail'];
		$seatcount = $seatcount +1;
		
		mysql_query("UPDATE test_session SET seats_avail='$seatcount' where seshid='$seshid'");
		
		$logentry = "$fsuid deleted their reservation for tsid $seshid\n";
		writeToSystemLog($logentry);
		
	}
	
	function findEnrolledClasses($fsuid)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db($dbname, $con);
		
		$result = mysql_query("SELECT * from enrollment WHERE fsuid='$fsuid'");
		$arr=array();
		while($row = mysql_fetch_array($result))
		{	
			$arr[] = $row;
		}
		return $arr;
	}

	function findAvailableTests($fsuid, $classname)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db($dbname, $con);
		
		
		$section_result = mysql_query("SELECT * from enrollment WHERE fsuid='$fsuid' and coursenum='$classname'");
		$section_row = mysql_fetch_array($section_result);
		$section = $section_row['section'];
		$date = date("Y-m-d");
		
		/* TROY SAYS:
			Made <= && >= and initiated the arr for ya :)
		*/
		$result = mysql_query("SELECT * from test WHERE coursenum='$classname' and section = '$section' and reg_win_open <= '$date'");
		$arr = array();
		while($row = mysql_fetch_array($result))
		{	
			$arr[] = $row;
		}
		return $arr;
	}
	function getTestName($testid)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db($dbname, $con);
	
		$query = "select testname from test where testid='$testid'";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
		{	
			$arr[] = $row;
		}
		return $arr;
	}
	
	function checkReservationExists($fsuid, $testid)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db($dbname, $con);
		
		$query = "SELECT t2.coursenum,  t2.testname, DATE_FORMAT(t1.day, '%a, %c/%e'), l1.name, TIME_FORMAT(t1.session_time,'%h:%i%p'),  t1.seshid, r1.isMakeup 
					FROM reservation r1 INNER JOIN test_session t1 on r1.tsid=t1.seshid INNER JOIN test t2 on r1.testid=t2.testid INNER JOIN location l1 on t1.locid=l1.locid
					where r1.fsuid='$fsuid' and r1.testid='$testid'";
		$result = mysql_query($query);
		$arr = array();
		while($row = mysql_fetch_array($result))
		{	
			$arr[] = $row;
		}
		return $arr;
	}
	
	function insertReservation($fsuid, $seshid, $testid, $makeupbool)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db($dbname, $con);
		
		
		$query = " select r1.tsid, t.seats_avail from reservation r1, test_session t where fsuid='$fsuid' AND r1.tsid=t.seshid 
			AND r1.tsid IN ( select seshid from test_session t1, test t2 where t2.testid = '$testid' and t1.testid=t2.testid)";
		$result = mysql_query($query);
		
		$row = mysql_fetch_array($result);
			$oldid = $row['tsid'];
			$oldseat = $row['seats_avail'];
		
		
		if($makeupbool == false)
		{
			$makeup='0';
		}
		else if ($makeupbool == true)
		{
			$makeup='1';
		}
		if(mysql_num_rows($result))
		{
			
			$query = "UPDATE reservation SET tsid='$seshid' where fsuid='$fsuid' and tsid='$oldid'";
			mysql_query($query);
			mysql_query("UPDATE reservation SET isMakeup='$makeup' where fsuid='$fsuid' and tsid='$seshid'");
			$oldseat=$oldseat+1;
			mysql_query("UPDATE test_session SET seats_avail='$oldseat' where seshid='$oldid'");
			
			$logentry = "$fsuid changed their reservation for tsid $oldid to tsid $seshid\n";
			writeToSystemLog($logentry);
		}
		else
		{
			mysql_query("INSERT INTO reservation VALUES('$fsuid', '$seshid', '$testid', '$makeup')");
			
			$logentry = "$fsuid made a reservation for tsid $seshid\n";
			writeToSystemLog($logentry);
			
		}
		$result2 = mysql_query("SELECT seats_avail from test_session where seshid = '$seshid'");
		$row = mysql_fetch_array($result2);
		$seatcount = $row['seats_avail'];
		$seatcount = $seatcount-1;
		mysql_query("UPDATE test_session SET seats_avail='$seatcount' where seshid='$seshid'");
	}
	
	function checkIfMakeup($coursenum, $testid)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db($dbname, $con);
		
		$query = "select reg_win_close from test where testid='$testid' and coursenum='$coursenum'";
		$date = date("Y-m-d");
		
		$result = mysql_query($query);
		$row = mysql_fetch_array($result);
		
		if($date <= $row["reg_win_close"])
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	function writeToSystemLog($log_entry)
	{
		$outFileName = "system_log.txt";
		$writelog = date("D, m/d/Y g:i:sa: ").$log_entry;
		$outFileHandle = fopen($outFileName, 'ab') or die("File cannot be opened. Ensure file is available for writing.");
		fwrite($outFileHandle, $writelog);
	}	
	
	function passwordHash($cleartext)
	{
		$hashed = hash('md5', $cleartext . "$@1+");
		return $hashed;
	}
	
	function insertCheck($coursenum, $section = 0)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if (!$con)
			die("Couldn't connect to SQL host");
		mysql_select_db($dbname, $con);
		$query = "SELECT * FROM course WHERE coursenum='$coursenum' AND section='$section'";
		$result = mysql_query($query);
		if(mysql_num_rows($result) > 0){
			return true;
		} else {
			return false;
		}
	}
	
	function rosterInsert($fsuid, $fname, $lname, $pw)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if (!$con)
			die("Couldn't connect to SQL host");
		mysql_select_db($dbname, $con);
		
		$query = "INSERT IGNORE INTO user (fsuid, fname, lname, password, role, reset_password)
				VALUES ('$fsuid', '$fname', '$lname', '$pw', '1', '1')";
				
		mysql_query($query);
		
	}
	
	function enrollInsert($fsuid, $coursenum, $section = 0)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
			die("Couldn't connect to SQL host");
		mysql_select_db($dbname, $con);
		
		$query = "INSERT IGNORE INTO enrollment (fsuid, coursenum, section)
				VALUES ('$fsuid', '$coursenum', '$section')";
		
		mysql_query($query);
		
	}
	
	function findAllClasses()
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
			die("Couldn't connect to SQL host");
		mysql_select_db($dbname, $con);
		
		$query = "select * from course";
		$result = mysql_query($query);
		$arr = array();
		while($row = mysql_fetch_array($result))
		{	
			$arr[] = $row;
		}
		return $arr;
	}
	
	function findAllTests($coursenum)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
			die("Couldn't connect to SQL host");
		mysql_select_db($dbname, $con);
		
		$query = "select * from test where coursenum='$coursenum'";
		$result = mysql_query($query);
		$arr = array();
		while($row = mysql_fetch_array($result))
		{	
			$arr[] = $row;
		}
		return $arr;
	}
	
	function findStudentsWithReservation($testid)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
			die("Couldn't connect to SQL host");
		mysql_select_db($dbname, $con);
		
		$query = "select u.lname, u.fname from user u INNER JOIN reservation r on u.fsuid=r.fsuid where r.testid='$testid'";
		$result = mysql_query($query);
		$arr = array();
		while($row = mysql_fetch_array($result))
		{	
			$arr[] = $row;
		}
		return $arr;
	}
	
	function findStudentsWithoutReservation($testid, $coursenum)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
			die("Couldn't connect to SQL host");
		mysql_select_db($dbname, $con);
		
		$query= "select u.lname, u.fname from user u where not exists (select * from reservation r where r.fsuid=u.fsuid and testid='$testid') 
			and u.fsuid in (select fsuid from enrollment where coursenum='$coursenum')";
		$result = mysql_query($query);
		$arr = array();
		while($row = mysql_fetch_array($result))
		{	
			$arr[] = $row;
		}
		return $arr;
	}

	/*
	*
	*	ADMIN Functions
	*
	*/

/*
*
*	Used on multiple pages
*
*/
//Get Courses
//Get the listing of courses in an array
//This is used in scheduling a test, editing course
	function get_courses_array()
	{
		$con = mysql_connect("localhost:3306", "testres", "gaitros");
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		$fsuid = $_SESSION['fsuid'];
		mysql_select_db("test_reservation_system", $con);
		
		$course_query = "SELECT c.coursenum, c.section FROM course c";
		$result = mysql_query($course_query);
		$arr = array();
		$courses = array();
		while($row = mysql_fetch_array($result))
		{	
			$arr[] = $row;
		}
		for($i=0; $i<count($arr); $i++)
		{
			//NOTE: for some reason count > then # elements, getting out of bounds
			//hard coding upper limit
			$courses[] = $arr[$i][0]."-".$arr[$i][1];
		}
		
		return $courses;
	}

/*
*
*    edit_course.php
*
*/

//     Add Course
//	This functions is called on the 'add_course.php' page
//	which is used in conjunction wit the edit_course.php page

	function add_course($cNum, $cSec, $cName)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db($dbname, $con);
		
		$insert = "INSERT IGNORE INTO course (coursenum, section, cname) VALUES('$cNum', '$cSec', '$cName')";
		if (!mysql_query($insert,$con))
		{
			 return mysql_error();
		}
		return "Course '$cName' successfully added";
	}
	
//     Remove Course
//	This functions is called on the 'remove_course.php' page
//	which is used in conjunction wit the edit_course.php page

	function remove_course($str_to_parse)
	{
		$con = mysql_connect("localhost:3306", "testres", "gaitros");
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		$fsuid = $_SESSION['fsuid'];
		mysql_select_db("test_reservation_system", $con);
			
		$pos = stripos($str_to_parse, "-");
		$cNum = substr($str_to_parse, 0, $pos);
		$sect = (int)substr($str_to_parse, $pos+1, strlen($str_to_parse));
		
		$query = "DELETE FROM course WHERE coursenum = '$cNum' AND section = '$sect'";
		if (!mysql_query($query,$con))
		{
			 return mysql_error();
		}
		return "Course '$str_to_parse' successfully removed";
	}
	
/*
*
*	location.php
*
*/

//	Add location
// This function is called on the 'add_loc.php" page
// Used in conjjunction w/ the location.php page
	
	function add_location($lName)
	{
		$con = mysql_connect("localhost:3306", "testres", "gaitros");
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		$fsuid = $_SESSION['fsuid'];
		mysql_select_db("test_reservation_system", $con);
    
		$query = "SELECT * FROM location l WHERE l.name = '$lName'";
		$result = mysql_query($query);
		$arr=array();
		while($row = mysql_fetch_array($result))
		{	
			$arr[] = $row;
		}
		if(count($arr) != 0) //matching test
		{
			$_SESSION['message'] = "Error adding location, please check if it already exists!";
			header( 'Location: http://troyprog.dyndns.tv/~testres/AdminSide/location.php' ) ;
			exit;
		}
		else
		{
			$insert = "INSERT IGNORE INTO location (name) VALUES('$lName')";
			if (!mysql_query($insert,$con))
  			{
 				 $_SESSION["message"] = mysql_erro();
  			}
			
			mysql_query($insert);
			
			$_SESSION["message"] = "Location '$lName' successfully added";
			header( 'Location: http://troyprog.dyndns.tv/~testres/AdminSide/admin.php' ) ;
			
			
		}
	
	}

/*
*
*	Creating Test Schedule
*
*/

//Get Locations
//Get the listing of locations in an array 
//use in conjunction with test creation
	function get_locations()
	{
		$con = mysql_connect("localhost:3306", "testres", "gaitros");
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		$fsuid = $_SESSION['fsuid'];
		mysql_select_db("test_reservation_system", $con);
		
	
		$loc_query = "SELECT * FROM location";
		$result = mysql_query($loc_query);
		$loc_arry = array();
		while($row = mysql_fetch_array($result))
		{
			$loc_arry[] = $row;
		}
		return $loc_arry;	
	}
	
//get A location
//check for a specific location
//used for confirmation w/ adding test
	function  get_A_location($locName)
	{
		$loc_query = "SELECT l.locid FROM location l WHERE l.name = '$locName'";
		$result = mysql_query($loc_query);
		$loc_arr=array();
		while($row = mysql_fetch_array($result))
		{	
			$loc_arr[] = $row;
		}
		if(count($loc_arr)>1)
		{
			$_SESSION['loc_error'] = "There was an error with your location request, please try again!";
			header( 'Location: http://troyprog.dyndns.tv/~testres/troy/templated_test_scheduler.php' ) ;
			exit;
		}
		else
		{
			return $loc_arr[0][0];
		}
	}

/*
* Review Schedule	
*/
	function getAllDays($from_date, $to_date)
	{ 
		// getting number of days between two date range. 
		$number_of_days = count_days(strtotime($from_date),strtotime($to_date)); 
		
		$date_arr  = array
					(
						"Monday" => array(),
						"Tuesday" => array(),
						"Wednesday" => array(),
						"Thursday" => array(),
						"Friday" => array()
					);
		
	   
		//TROY: start @ 0 to include start day
		for($i = 0; $i<=$number_of_days; $i++)
		{
		
			$day = Date('l',mktime(0,0,0,date('m',strtotime($from_date)),date('d',strtotime($from_date))+$i,date('y',strtotime($from_date)))); 
			
			if($day == 'Monday')
			{ 	
				array_push($date_arr["Monday"],Date('Y-m-d', 
					mktime(0,0,0,date('m',strtotime($from_date)),date('d',strtotime($from_date))+$i,date('y',strtotime($from_date))))); 
			} 
			else if($day == 'Tuesday')
			{ 	
				array_push($date_arr["Tuesday"],Date('Y-m-d',
					mktime(0,0,0,date('m',strtotime($from_date)),date('d',strtotime($from_date))+$i,date('y',strtotime($from_date))))); 
			} 
			else if($day == 'Wednesday')
			{ 	
				array_push($date_arr["Wednesday"],Date('Y-m-d',
					mktime(0,0,0,date('m',strtotime($from_date)),date('d',strtotime($from_date))+$i,date('y',strtotime($from_date))))); 
			} 
			else if($day == 'Thursday')
			{ 	
				array_push($date_arr["Thursday"],Date('Y-m-d',
					mktime(0,0,0,date('m',strtotime($from_date)),date('d',strtotime($from_date))+$i,date('y',strtotime($from_date))))); 
			} 
			else if($day == 'Friday')
			{ 	
				array_push($date_arr["Friday"],Date('Y-m-d',
					mktime(0,0,0,date('m',strtotime($from_date)),date('d',strtotime($from_date))+$i,date('y',strtotime($from_date))))); 
			} 
			else //weekend
			{
				continue;
			}
		}
		return $date_arr;
	} 
//NOTE: This code is based on code
//that was posted by india dot yogi at gmail dot com
//on the php manual as a comment
//http://php.net/manual/en/function.date.php
// Will return the number of days between the two dates passed in 
	function count_days( $a, $b ) 
	{ 
		// First we need to break these dates into their constituent parts: 
		$gd_a = getdate( $a ); 
		$gd_b = getdate( $b ); 
		// Now recreate these timestamps, based upon noon on each day 
		// The specific time doesn't matter but it must be the same each day 
		$a_new = mktime( 12, 0, 0, $gd_a['mon'], $gd_a['mday'], $gd_a['year'] ); 
		$b_new = mktime( 12, 0, 0, $gd_b['mon'], $gd_b['mday'], $gd_b['year'] ); 
		// Subtract these two numbers and divide by the number of seconds in a 
		// day. Round the result since crossing over a daylight savings time 
		// barrier will cause this time to be off by an hour or two. 
		return round( abs( $a_new - $b_new ) / 86400 ); 
	} 

//this function is used in the 'review_new_schedule.php'
//page. its puts all the times into an array corresponding 
//to the day
	function day_time_array($datime_arr)
	{
				//Create multi-dimensional array of days
 				//Each day will have the times for that day
 				$test_times_array = array
 				(
 					"Monday" => array(),
 					"Tuesday" => array(),
 					"Wednesday" => array(),
 					"Thursday" => array(),
 					"Friday" => array()
 				);

 				
 				for($iter = 0; $iter<count($datime_arr); $iter++)
 				{
 					//hD
 					if(strlen($datime_arr[$iter]) == 2)
	 				{
	 					$hour = substr($datime_arr[$iter], 0, 1);
						$a_day = substr($datime_arr[$iter], 1, 1);
	 					$a_time = mktime($hour, 0, 0);	 	
						$a_time = (date("H:i:s", $a_time));	
	 				}
 					//hhD
 					else if(strlen($datime_arr[$iter]) == 3)
 					{
	 					$hour = substr($datime_arr[$iter], 0, 2);
						$a_day = substr($datime_arr[$iter], 2, 1);
	 					$a_time = mktime($hour, 0, 0);
	 					$a_time = (date("H:i:s", $a_time));
 					}
 					//hmmD
					else if(strlen($datime_arr[$iter]) == 4)
					{
						$hour = substr($datime_arr[$iter], 0, 1);
						$min = substr($datime_arr[$iter], 1, 2);
						$a_day = substr($datime_arr[$iter], 3, 1);
						$a_time = mktime($hour, $min, 0);
						$a_time = (date("H:i:s", $a_time));
					}
					// hhmmD
					else
					{
						$hour = substr($datime_arr[$iter], 0, 2);
						$min = substr($datime_arr[$iter], 2, 2);
						$a_day = substr($datime_arr[$iter], 4, 1);
						$a_time = mktime($hour, $min, 0);
						$a_time = (date("H:i:s", $a_time));
					}
	 	
	 				
	 				switch($a_day)
	 				{
						case 'M':
							array_push($test_times_array["Monday"], $a_time);
							break;
						case 'T':
							array_push($test_times_array["Tuesday"], $a_time);
							break;
						case 'W':
							array_push($test_times_array["Wednesday"], $a_time);
							break;
						case 'R':
							array_push($test_times_array["Thursday"], $a_time);
							break;
						case 'F':
							array_push($test_times_array["Friday"], $a_time);
							break;
						default:
							echo "ERROR";
							break;
	 				}
 				}//end for loop of datime_arr
 				
 				return $test_times_array;
 			}

/*
*	Create Sessions
*/
	function create_sessions($test_days_array, $test_times_array, $t_id, $loc_id, $seat_capacity, $duration)
	{	
		$con = mysql_connect("localhost:3306", "testres", "gaitros");
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		$fsuid = $_SESSION['fsuid'];
		mysql_select_db("test_reservation_system", $con);
		
		//monday's
		//outer loop: dates
		$i = 0;
		for($i; $i<count($test_days_array['Monday']); ++$i)
		{
			//inner loop: times
			//in this way we add all times for each given date
			//before moving on to the next
			$j = 0;
			for($j; $j<count($test_times_array['Monday']); ++$j)
			{
				$a_day = $test_days_array['Monday'][$i];
				$a_time = $test_times_array['Monday'][$j];
				$insert = "REPLACE INTO test_session (testid, locid, total_seats, seats_avail, duration, day, session_time) 
					VALUES('$t_id','$loc_id','$seat_capacity','$seat_capacity', '$duration','$a_day', '$a_time')";
				/*if (!mysql_query($insert,$con))
				{
					 die('Error: ' . mysql_error());
				}*/
				mysql_query($insert);
			}
		}
		//tuesday's
		//outer loop: dates
		$i = 0;
		for($i; $i<count($test_days_array['Tuesday']); ++$i)
		{
			//inner loop: times
			//in this way we add all times for each given date
			//before moving on to the next
			$j = 0;
			for($j; $j<count($test_times_array['Tuesday']); ++$j)
			{
				$a_day = $test_days_array['Tuesday'][$i];
				$a_time = $test_times_array['Tuesday'][$j];
				$insert = "REPLACE INTO test_session (testid, locid, total_seats, seats_avail, duration, day, session_time) 
					VALUES('$t_id','$loc_id','$seat_capacity','$seat_capacity', '$duration','$a_day', '$a_time')";
				/*if (!mysql_query($insert, $con))
				{
					 die('Error: ' . mysql_error());
				}
				echo "1 record added\n";*/
				mysql_query($insert);
			}
		}
		//Wednesday's
		//outer loop: dates
		$i  = 0;
		for($i; $i<count($test_days_array['Wednesday']); ++$i)
		{
			//inner loop: times
			//in this way we add all times for each given date
			//before moving on to the next
			$j = 0;
			for($j; $j<count($test_times_array['Wednesday']); ++$j)
			{
				$a_day = $test_days_array['Wednesday'][$i];
				$a_time = $test_times_array['Wednesday'][$j];
				$insert = "REPLACE INTO test_session (testid, locid, total_seats, seats_avail, duration, day, session_time) 
					VALUES('$t_id','$loc_id','$seat_capacity','$seat_capacity', '$duration','$a_day', '$a_time')";
				/*if (!mysql_query($insert,$con))
				{
					 die('Error: ' . mysql_error());
				}
				echo "1 record added\n";*/
				mysql_query($insert);
			}
		}
		//Thursday's
		//outer loop: dates
		$i = 0;
		for($i; $i<count($test_days_array['Thursday']); ++$i)
		{
			//inner loop: times
			//in this way we add all times for each given date
			//before moving on to the next
			$j = 0;
			for($j; $j<count($test_times_array['Thursday']); ++$j)
			{
				$a_day = $test_days_array['Thursday'][$i];
				$a_time = $test_times_array['Thursday'][$j];
				$insert = "REPLACE INTO test_session (testid, locid, total_seats, seats_avail, duration, day, session_time) 
					VALUES('$t_id','$loc_id','$seat_capacity','$seat_capacity', '$duration','$a_day', '$a_time')";
				/*if (!mysql_query($insert,$con))
				{
					 die('Error: ' . mysql_error());
				}
				echo "1 record added\n";*/
				mysql_query($insert);
			}
		}
		//Friday's
		//outer loop: dates
		$i = 0;
		for($i; $i<count($test_days_array['Friday']); ++$i)
		{
			//inner loop: times
			//in this way we add all times for each given date
			//before moving on to the next
			$j = 0;
			for($j; $j<count($test_times_array['Friday']); ++$j)
			{
				$a_day = $test_days_array['Friday'][$i];
				$a_time = $test_times_array['Friday'][$j];
				$insert = "REPLACE INTO test_session (testid, locid, total_seats, seats_avail, duration, day, session_time) 
					VALUES('$t_id','$loc_id','$seat_capacity','$seat_capacity', '$duration','$a_day', '$a_time')";
				/*if (!mysql_query($insert,$con))
				{
					 die('Error: ' . mysql_error());
				}
				echo "1 record added\n";*/
				mysql_query($insert);
			}
		}
		
		return "New test successfully created!";
	}

//Add a test
//add a test to the database
	function add_A_test($tName, $cName, $sect, $date_one, $date_two)
	{
		$con = mysql_connect("localhost:3306", "testres", "gaitros");
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		$fsuid = $_SESSION['fsuid'];
		mysql_select_db("test_reservation_system", $con);
		
		$ins = "REPLACE INTO test values('', '$tName', '$cName', '$sect', '$date_one', '$date_two')";
		if(!mysql_query($ins))
		{
			$_SESSION["message"] = mysql_error();
			exit;
		}
		
		//get the tid of the test just created
		$tid_query = "SELECT t.testid FROM test t WHERE t.testname = '$tName' AND 
			t.coursenum = '$cName' AND t.section = '$sect' AND t.reg_win_open = '$date_one' AND 
			t.reg_win_close = '$date_two'";
		$result = mysql_query($tid_query);
		$tid_arr=array();
		while($row = mysql_fetch_array($result))
		{	
			$tid_arr[] = $row;
		}
	
		//return the test id of the newly created test
		return $tid_arr[0][0];
	}

    /* Functions for Calendar Page */
	function testLookup($year,$mon,$first)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con){
			die("Couldn't connect to SQL host");
		} else{}
		mysql_select_db($dbname,$con);

		$callIt = $year."-".$mon."-".$first;
		$q = "select coursenum,testname,seats_avail,total_seats,name,session_time,duration,seshid
			from test_session T,test D,location L where T.day='$callIt' && D.testid=T.testid && T.locid=L.locid
			order by coursenum,testname,session_time;";


		$result = mysql_query($q, $con);

		return $result;
	}

	function sessLookup($sessnum)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con){
			die("Couldn't connect to SQL host");
		} else{}
		mysql_select_db($dbname,$con);
		
		$q = "select lname,fname from reservation R,test_session T,user U where R.fsuid=U.fsuid && R.tsid=T.seshid && 
			R.tsid='$sessnum' order by lname;";

		$result = mysql_query($q, $con);

		return $result;
	}

	function deleteSession($sessnum)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con){
			die("Couldn't connect to SQL host");
		} else{}
		mysql_select_db($dbname,$con);
		
		$q = "delete from test_session where seshid='$sessnum';";

		mysql_query($q,$con);
	}

	function getSessDate($sessnum)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con){
			die("Couldn't connect to SQL host");
		} else{}
		mysql_select_db($dbname,$con);
		
		$q = "select day from test_session where seshid='$sessnum';";

		$result = mysql_query($q,$con);

		return $result;
	}

	function getLocs()
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con){
			die("Couldn't connect to SQL host");
		} else{}
		mysql_select_db($dbname,$con);

		$q = "select * from location";

		$result = mysql_query($q,$con);

		return $result;
	}

	function updateSess($temp1,$temp2,$temp3,$temp4,$temp5)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con){
			die("Couldn't connect to SQL host");
		} else{}
		mysql_select_db($dbname,$con);

		$q = "update test_session set locid='$temp2', total_seats='$temp3', duration='$temp4', session_time='$temp5' where seshid='$temp1';";

		mysql_query($q,$con);
	}

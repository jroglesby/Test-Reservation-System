<?php
	$localhost = "localhost:3306";
	$dbusername = "testres";
	$dbpassword = "gaitros";
	$dbname = "test_reservation_system";

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
		
		mysql_query("UPDATE user set password='$newpassword' where fsuid='$fsuid'");
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
	
	function findSessions($testname, $classname, $year, $month, $dayofmonth, $dayarray, $timearray)
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
				and t2.testname='".$testname."' and t2.coursenum='".$classname."' ";
					
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
			
		$result = mysql_query($query);
		$arr=array();
		while($row = mysql_fetch_array($result))
		{	
			$arr[] = $row;
		}
		return $arr;
	}
	
	function findAllSessions($testname, $classname)
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
				and t2.testname='".$testname."' and t2.coursenum='".$classname."' ";
		
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
		$outFileName = "system_log.txt";
		$outFileHandle = fopen($outFileName, 'a') or die("File cannot be opened. Ensure file is available for writing.");
		fwrite($outFileHandle, $logentry);
		
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

	function insertReservation($fsuid, $seshid, $testname, $makeupbool)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db($dbname, $con);
		
		
		$query = " select r1.tsid, t.seats_avail from reservation r1, test_session t where fsuid='$fsuid' AND r1.tsid=t.seshid 
			AND r1.tsid IN ( select seshid from test_session t1, test t2 where t2.testname = '$testname' and t1.testid=t2.testid)";
		echo $query;
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
	
		echo "Old tsid = ";echo $oldid;
		echo "Old seatnum = ";echo $oldseat;
		echo "New tsid = ";echo $seshid;
		
		if(mysql_num_rows($result))
		{
			
			$query = "UPDATE reservation SET tsid='$seshid' where fsuid='$fsuid' and tsid='$oldid'";
			mysql_query($query);
			mysql_query("UPDATE reservation SET isMakeup='$makeup' where fsuid='$fsuid' and tsid='$seshid'");
			$oldseat=$oldseat+1;
			mysql_query("UPDATE test_session SET seats_avail='$oldseat' where seshid='$oldid'");
			
			$logentry = "$fsuid changed their reservation for tsid $oldid to tsid $seshid\n";
			$outFileName = "system_log.txt";
			$outFileHandle = fopen($outFileName, 'a') or die("File cannot be opened. Ensure file is available for writing.");
			fwrite($outFileHandle, $logentry);
		}
		else
		{
			mysql_query("INSERT INTO reservation VALUES('$fsuid', '$seshid', '$makeup')");
			
			$logentry = "$fsuid made a reservation for tsid $seshid\n";
			$outFileName = "system_log.txt";
			$outFileHandle = fopen($outFileName, 'a') or die("File cannot be opened. Ensure file is available for writing.");
			fwrite($outFileHandle, $logentry);
		}
		$result2 = mysql_query("SELECT seats_avail from test_session where seshid = '$seshid'");
		$row = mysql_fetch_array($result2);
		$seatcount = $row['seats_avail'];
		$seatcount = $seatcount-1;
		mysql_query("UPDATE test_session SET seats_avail='$seatcount' where seshid='$seshid'");
	}
	
	function checkIfMakeup($coursenum, $testname)
	{
		global $localhost, $dbusername, $dbpassword, $dbname;
		$con = mysql_connect($localhost, $dbusername, $dbpassword);
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db($dbname, $con);
		
		$query = "select reg_win_close from test where testname='$testname' and coursenum='$coursenum'";
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

<?php

	function redirect()
	{
		if( !array_key_exists('fsuid', $_SESSION) )
		{
			$_SESSION['message'] = "Please sign in.";
			header( 'Location: http://troyprog.dyndns.tv/~testres/testres.php' ) ;
		}
		
	}


	function find_login($username, $password)
	{
		$con = mysql_connect("localhost:3306", "testres", "gaitros");
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db("test_reservation_system", $con);
		$result = mysql_query("SELECT * from user WHERE fsuid='$username' AND password='$password'");
		return $result;
	}
	
	function find_sessions($testname, $classname, $year, $month, $dayofmonth, $dayarray, $timearray)
	{
		$con = mysql_connect("localhost:3306", "testres", "gaitros");
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		$dateflag=false;
		mysql_select_db("test_reservation_system", $con);
		$query = "select t1.seshid, DATE_FORMAT(t1.day, '%c/%d/%Y'), DAYNAME(t1.day), TIME_FORMAT(t1.session_time,'%h:%i%p'), l1.name, t1.seats_avail FROM test_session t1, location l1, test t2 WHERE t1.locid=l1.locid and t1.testid = t2.testid 
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

	function findReservedSessions($fsuid)
	{
		$con = mysql_connect("localhost:3306", "testres", "gaitros");
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db("test_reservation_system", $con);
		$result = mysql_query("SELECT t2.coursenum,  t2.testname, DATE_FORMAT(t1.day, '%a, %c/%e'), l1.name, TIME_FORMAT(t1.session_time,'%h:%i%p'),  t1.seshid 
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
		$con = mysql_connect("localhost:3306", "testres", "gaitros");
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db("test_reservation_system");
		$query = "delete from reservation where fsuid='$fsuid' and tsid='$seshid'";
		mysql_query($query);
		
		$result = mysql_query("SELECT seats_avail from test_session where seshid = '$seshid'");
		$row = mysql_fetch_array($result);
		$seatcount = $row['seats_avail'];
		$seatcount = $seatcount +1;
		
		mysql_query("UPDATE test_session SET seats_avail='$seatcount' where seshid='$seshid'");
	}
	
	function findEnrolledClasses($fsuid)
	{
		$con = mysql_connect("localhost:3306", "testres", "gaitros");
		if(!$con)
		{	
			die("Couldn't connect to SQL host");
		}
		mysql_select_db("test_reservation_system", $con);
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
		$con = mysql_connect("localhost:3306", "testres", "gaitros");
		if(!$con)
		{	
			die("Couldn't connect to SQL host");
		}
		mysql_select_db("test_reservation_system", $con);
		
		$section_result = mysql_query("SELECT * from enrollment WHERE fsuid='$fsuid' and coursenum='$classname'");
		$section_row = mysql_fetch_array($section_result);
		$section = $section_row['section'];
		$date = date("Y-m-d");
		
		$result = mysql_query("SELECT * from test WHERE coursenum='$classname' and section = '$section' and reg_win_open < '$date' and reg_win_close > '$date'");
		
		while($row = mysql_fetch_array($result))
		{	
			$arr[] = $row;
		}
		return $arr;
	}

	function insertReservation($fsuid, $seshid, $testname, $con)
	{
			$con = mysql_connect("localhost:3306", "testres", "gaitros");
		if(!$con)
		{
			die("Couldn't connect to SQL host");
		}
		mysql_select_db("test_reservation_system", $con);
		
		$query = " select r1.tsid, t.seats_avail from reservation r1, test_session t where fsuid='$fsuid' AND r1.tsid=t.seshid 
			AND r1.tsid IN ( select seshid from test_session t1, test t2 where t2.testname = '$testname' and t1.testid=t2.testid)";
		
		$result = mysql_query($query);
		$result2 = mysql_query("SELECT seats_avail from test_session where seshid = '$seshid'");
	

		$row = mysql_fetch_array($result2);
		$seatcount = $row['seats_avail'];
	
		if(mysql_num_rows($result))
		{
			$row = mysql_fetch_array($result);
			$oldid = $row['tsid'];
			$oldseat = $row['seats_avail'];
			mysql_query("UPDATE reservation SET tsid='$seshid' where fsuid='$fsuid' and tsid='$oldid'");
			$oldseat=$oldseat+1;
			mysql_query("UPDATE test_session SET seats_avail='$oldseat' where seshid='$oldid'");
			$seatcount = $seatcount-1;
			mysql_query("UPDATE test_session SET seats_avail='$seatcount' where seshid='$seshid'");
			$_SESSION['message'] = "Your reservation has been updated.";
			header( 'Location: http://troyprog.dyndns.tv/~testres/student.php' );
		}
		else
		{
			mysql_query("INSERT INTO reservation VALUES('$fsuid', '$seshid')");
			$seatcount = $seatcount-1;
			mysql_query("UPDATE test_session SET seats_avail='$seatcount' where seshid='$seshid'");
			$_SESSION['message'] = "Your reservation has been set.";
			header( 'Location: http://troyprog.dyndns.tv/~testres/student.php' );
		}
	}

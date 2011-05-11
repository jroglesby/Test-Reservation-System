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
		
		if($makeupbool == false)
		{
			$makeup=0;
		}
		else
		{
			$makeup=1;
		}
		
		
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
			mysql_query("UPDATE reservation SET tsid='$seshid' and isMakeup='$makeup' where fsuid='$fsuid' and tsid='$oldid'");
			$oldseat=$oldseat+1;
			mysql_query("UPDATE test_session SET seats_avail='$oldseat' where seshid='$oldid'");
			$seatcount = $seatcount-1;
			mysql_query("UPDATE test_session SET seats_avail='$seatcount' where seshid='$seshid'");
			$_SESSION['message'] = "Your reservation has been updated.";
			header( 'Location: http://troyprog.dyndns.tv/~testres/student.php' );
		}
		else
		{
			mysql_query("INSERT INTO reservation VALUES('$fsuid', '$seshid', '$makeup')");
			$seatcount = $seatcount-1;
			mysql_query("UPDATE test_session SET seats_avail='$seatcount' where seshid='$seshid'");
			$_SESSION['message'] = "Your reservation has been set.";
			header( 'Location: http://troyprog.dyndns.tv/~testres/student.php' );
		}
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

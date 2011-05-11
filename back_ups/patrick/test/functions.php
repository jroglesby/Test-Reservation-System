<?php

	$localhost = "localhost:3306";
	$dbusername = "testres";
	$dbpassword = "gaitros";
	$dbname = "test_reservation_system";

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
		
		$query = "INSERT IGNORE INTO user (fsuid, fname, lname, 
password, role, reset_password)
				VALUES ('$fsuid', '$fname', '$lname', 
'$pw', '1', '1')";
				
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
	
	function getDumpTables()
	{
		$dumpString = "";
		$dumpString = $dumpString . dumpEnroll();
		$dumpString = $dumpString . dumpUsers();
		$dumpString = $dumpString . dumpTestSession();
		
	}
	
	function dump_log()
	{
	// needs to drop- user, enrollment, test_session, test, reservation 
	// drop user and test and cascades should handle it? 
		$dateinfo = date("D-d-F-Y");
		$outFileName = "dumpFile-" . $dateinfo;
		$outFileHandle = fopen($outFileName, 'a+') or die ("cannot open file " . $outFileName);
		fwrite($outFileHandle, date("r") . "\n");
		
		fclose($outFileHandle);
	}
	
	
	
?>

<?php session_start(); 

	require("data_access.php");?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<title>Exam Reservation Response</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="throwaway.css">  
<?php
	if( !array_key_exists('fsuid', $_SESSION) )
	{
		$_SESSION['message'] = "Please sign in.";
		header( 'Location: http://troyprog.dyndns.tv/~testres/testres.php' ) ;
	}
	if ( array_key_exists( 'message', $_SESSION) )
	{
		$message = $_SESSION['message'];
	}
	else
	{
		$message = "";
	}
?>



</head>
<body>
<body bgcolor="#FFFFFF" text="#000000" link="#660000" leftmargin="0" topmargin="1" marginwidth="0" marginheight="0" vlink="#990000" alink="#FFCC00">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#540115"><b><i><a href="testres.php" class="headlink">Exam Reservation System</a></i></b>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="600" height="550" border="1" align="center" cellpadding="6" cellspacing="0" class="main_box_background">
  <tr height="30"><td bgcolor="#FFFFFF">
  <div class="headerfont"><b>Exam Reservation System<b></div>
  </td></tr>
  <tr valign="top"><td>
  <p><font size="+1"><i><font color="#990000"><b>Choose your exam time(s):</b></font></i></font></p>
  	<p align="center"> 
<table border='1' width="550" cellspacing='0' cellpadding='6' align="center" class="center_box_background">
<tr>
	<th><span class='mainfont'>Webbased Exam Session
		<br><?php echo $_REQUEST["classname"]; ?>
		<br><?php echo $_REQUEST["testname"]; ?>
		<br>Available Times
		</span>
    </th>
</tr>
</table>
<br>
<?php
	$dayarray = NULL;
	$timearray = NULL;
	$result = NULL;
	if(array_key_exists("day", $_REQUEST))
	{
		$dayarray = $_REQUEST["day"];
	}
	if(array_key_exists("time", $_REQUEST))
	{
		$timearray = $_REQUEST["time"];
	}
	$con = mysql_connect("localhost:3306", "testres", "gaitros");
	if(!$con)
	{
		die("Couldn't connect to SQL host");
	}
	find_sessions($_REQUEST["classname"], $_REQUEST["testname"], $_REQUEST["year"], $_REQUEST["month"], $_REQUEST["dayofmonth"], $dayarray, $timearray, &$result, $con);
?>
		
	
<table border='0' width="550" cellspacing='0' cellpadding='6' align="center" class="center_box_background">
	<tr>
		<td>
			<span class="mainfont">Test sessions found that match your search:</span>
		</td>
	</tr>
<?php
	if(mysql_num_rows($result)==0)
	{
?>
	<tr>
		<td>
			<span class="checklist">No results found.</span>
		</td>
	</tr>
	<tr align="center">
		<td>
			<form name="return1" action="searchsession.php">
				<input type="hidden" name="classname" value="<?php echo $_REQUEST["classname"]; ?>">
				<input type="hidden" name="testname" value="<?php echo $_REQUEST["testname"]; ?>">
				<input type="submit" name="Back to search" value="Back to search">
			</form>
		</td>
	</tr>
	</table>
<?php
	}
	else
	{
?>
	<tr>
	<table width="550" cellspacing='0' class="center_box_background">
	<tr>
	<span class="tableheader">
		<td width="20">
		</td>
		<td align="center" width="60">
			<u>Day</u>
		</td>
		<td align="center" width="75">
			<u>Date</u>
		</td>
		<td align="center" width="50">
			<u>Time</u>
		</td>
		<td align="center" width="50">
			<u>Location</u>
		</td>
		<td align="center" width="120">
			<u>Number of seats available</u>
		</td>
	</span>
	</tr>
	<form name="reserve" action="makereservation.php">
		<input type="hidden" name="testname" value="<?php echo $_REQUEST["testname"]; ?>">
<?php
	while($row = mysql_fetch_array($result))
	{	
		echo "<tr class=\"blackborder\"><td><input type=\"radio\" name=\"seshid\" value=\"".$row['seshid']."\"></td>";
		echo "<td align=\"center\">".$row['DAYNAME(t1.day)']."</td>";
		echo "<td align=\"center\">".$row['DATE_FORMAT(t1.day, \'%c/%d/%Y\')']."</td>";
		echo "<td align=\"center\">".$row['TIME_FORMAT(t1.session_time,\'%h:%i%p\')']."</td>";
		echo "<td align=\"center\">".$row['name']."</td>";
		echo "<td align=\"center\">".$row['seats_avail']."</td>";
		echo "</tr>";
	}
?>
	</table>
	<table width="550" align="center" cellspacing='0'>
	<tr>
		<td align="center">
			<input type="submit" name="Reserve" value="Reserve"><br>
		</td>
	</tr>
	</form>
	</table>
<?php
	}
?>

<form action="student.php" method="post">
			<p align="center">
				<input type="submit" name="Cancel" value="Cancel"><br>
			</p>
			</form>	
</tr>
</table>

<br/>
<br/>
<br/>
<?php
echo "DEBUG INFO:<br/>";
echo $query;
?>
 


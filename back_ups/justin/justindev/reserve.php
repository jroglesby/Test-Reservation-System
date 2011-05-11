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
  	<form method="post" action="" name="reserve">
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
	
<table border='0' width="550" cellspacing='0' cellpadding='6' align="center" class="center_box_background">
	<tr border='1'>
		<td><span class="mainfont"><b>Search Criteria:</b></span></td>
	</tr>
	<form name="searchcriteria">
	<input type="hidden" name="classname" value="<?php echo $_REQUEST["classname"]; ?>">
	<input type="hidden" name="testname" value="<?php echo $_REQUEST["testname"]; ?>">
	<tr valign='top' border="0">
		<td><span class="mainfont">Enter a date you would like to search for: (MM/DD/YYYY)</span></td>
	</tr>
	<tr valign='top' border='0'>
		<td>

			 <input type="text" name="month" size="2"> / 
			 <input type="text" name="dayofmonth" size="2"> /
			 <input type="text" name="year" size="4">
		</td>
	</tr>
	<tr>
		<td>
			<span class="mainfont"><b>&nbsp;&nbsp;&nbsp;&nbsp;OR</b></span>
		</td>
	</tr>
	<tr>
		<td>
			<span class="mainfont">Select from the following search options:</span>
		</td>
	</tr>
	<tr>
	
		<td width="100" valign="top">
			<span class="checklist">Day:<br>
			<input type="checkbox" name="day" value="Monday"/>Monday<br/>
			<input type="checkbox" name="day" value="Tuesday"/>Tuesday<br/>
			<input type="checkbox" name="day" value="Wednesday"/>Wednesday<br/>
			<input type="checkbox" name="day" value="Thursday"/>Thursday<br/>
			<input type="checkbox" name="day" value="Friday"/>Friday<br/>
			</span>
		</td>
		<td width="100" valign="top">
			<span class="checklist">Start Time:<br/>
			<input type="checkbox" name="time" value="9:30"/>9:30a.m.<br/>
			<input type="checkbox" name="time" value="10:30"/>10:30a.m.<br/>
			<input type="checkbox" name="time" value="13:30"/>1:30p.m.<br/>
			<input type="checkbox" name="time" value="14:30"/>2:30p.m.<br/>
			<input type="checkbox" name="time" value="15:30"/>3:30p.m.<br/>
			<input type="checkbox" name="time" value="17:30"/>5:30p.m.<br/>
			<input type="checkbox" name="time" value="18:30"/>6:30p.m.<br/>
			</span>
		</td>
	</tr>
	<tr align="center">
		<td>
			<input type="submit" name="Submit" value="Submit">
			
		</td>
	</tr>
	</form>		
</table>
</p>
	<form action="student.php" method="post">
	<p align="center">
	<input type="submit" name="Cancel" value="Cancel"><br>
	</p>
	</form>
    </td></tr></table>


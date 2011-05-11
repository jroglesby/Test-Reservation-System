<?php session_start(); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<title>Exam Reservation Response</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="throwaway.css"> 
</head>
<?php 
	$con = mysql_connect("localhost:3306", "testres", "gaitros");
	if(!$con)
	{
		die("Couldn't connect to SQL host");
	}
	$classname = $_POST["classname"];
	$fsuid = $_SESSION['fsuid'];
	mysql_select_db("test_reservation_system", $con);
	$section_result = mysql_query("SELECT * from enrollment WHERE fsuid='$fsuid' and coursenum='$classname'");
	$section_row = mysql_fetch_array($section_result);
	$section = $section_row['section'];
	$date = date("Y-m-d");
	$test_result = mysql_query("SELECT * from test WHERE coursenum='$classname' and section = '$section' and reg_win_open < '$date' and reg_win_close > '$date'");
	
?>

<body>
<body bgcolor="#FFFFFF" text="#000000" link="#660000" leftmargin="0" topmargin="1" marginwidth="0" marginheight="0" vlink="#990000" alink="#FFCC00">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#540115"><b><i><a href="throwaway.html" class="headlink">Exam Reservation System</a></i></b>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
 <table width="600" height="550" border="1" align="center" cellpadding="6" cellspacing="0" class="main_box_background">
  	<tr height="30"><td bgcolor="#FFFFFF">
		<div class="headerfont"><b>Exam Reservation System<b></div>
	</td></tr>
	<tr>
    	<td valign="top">
  			<p><font size="+1"><i><font color="#990000"><b>Choose A Test:</b></font></i></font></p>
            <table class="center_box_background" border="1" cellspacing="0" align="center" cellpadding="6" >
            <tr><td>
            <p class="style2">Please select a test that you wish to make a reservation for.</p>
			<form method="post" action="throwaway3.php" name="reserve">
            	<p class="style2" align="center">
				<select name="testname">
				<?php
				while($row = mysql_fetch_array($test_result))
				{	
					$testid = $row['testid'];
					$testname = $row['testname'];
					echo "<option value=\"" . $test .  "\">".$classname." ".$testname."</option>";
				}
				?>
				</select>
				<input type="hidden" name="classname" value="<?php echo $classname; ?>">
                <p class="style2" align="center">
                <input type="submit" name="Submit" value="Next"><br>
                </p> 
    		</form>
			<?echo $classname;?>
            </td></tr></table>
    	</td>
    </tr>
  </table>

</body>
</html>
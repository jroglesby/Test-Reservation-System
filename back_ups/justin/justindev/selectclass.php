<?php 
	session_start(); 

	require("data_access.php");

	$message = redirect();

	$result =& findEnrolledClasses($_SESSION['fsuid']);
	
	/*if(count($result)==1)
	{
		$row=$result[0];
		header( 'Location: http://troyprog.dyndns.tv/~testres/selecttest.php?classname='.$row["coursenum"] );
	}*/

?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<title>Exam Reservation Response</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="testres.css"> 
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
	<tr>
    	<td valign="top">
  			<p><font size="+1"><i><font color="#990000"><b>Choose A Class:</b></font></i></font></p>
            <table class="center_box_background" cellspacing="0" align="center" cellpadding="6">
            <tr width="300"><td>
            <p class="mainfont">Please select a class that you are enrolled in that currently has test reservations available.</p>
			<form method="post" action="selecttest.php">
            	<p class="mainfont" align="center">
				<select name="classname">
<?php 
				
					echo "<select name=\"classname\">

					for($j=0;$j<count($result);$j++)
					{	
						$row = $result[$j];
						$course = $row["coursenum"];
						echo "<option value=\"" . $course . "\">".$course."</option>";
					}
?>
				</select>
				</p>
                <p class="mainfont" align="center">
                <input type="submit" name="Submit" value="Next"><br>
                </p> 
    		</form>
			<form action="student.php" method="post">
			<p align="center">
				<input type="submit" name="Cancel" value="Cancel"><br>
			</p>
			</form>
            </td></tr></table>
    	</td>
    </tr>
  </table>

</body>
</html>
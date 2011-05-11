<?php session_start(); 

	require("data_access.php");?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<title>Exam Reservation Response</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="throwaway.css"> 
</head>
<?php 
	if( !array_key_exists('fsuid', $_SESSION) )
	{
		$_SESSION['message'] = "Please sign in.";
		header( 'Location: http://troyprog.dyndns.tv/~testres/testres.php' ) ;
	}
	$con = mysql_connect("localhost:3306", "testres", "gaitros");
	if(!$con)
	{
		die("Couldn't connect to SQL host");
	}
	$fsuid = $_SESSION['fsuid'];
	mysql_select_db("test_reservation_system", $con);
	$result = mysql_query(" SELECT DATE_FORMAT(t1.day, '%a, %c/%e'), t2.coursenum, t2.testname, t1.session_time, l1.name 
					FROM reservation r1, test_session t1, test t2, location l1 
						WHERE r1.fsuid='jro08' AND r1.tsid = t1.seshid AND t1.testid = t2.testid AND t1.locid=l1.locid");
?>




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
  	<tr height="20">
		<td bgcolor="#FFFFFF">
			<div class="headerfont"><b>Exam Reservation System<b></div>
		</td>
	</tr>
	<tr>
    	<td height="356" valign="top">
  			<p><font size="+1"><i><font color="#990000"><b>Review Your Reservations:</b></font></i></font></p>
            <table class="center_box_background" width="500" border="1" cellspacing="0" align="center" cellpadding="6" >
	            <tr>
                	<td>
       		    	<p class="mainfont">Below are all of your current reservations.		            </p></td>
            	</tr>
				<?php 
					$i = 1;
				if(mysql_num_rows($result))
				{
					while($row = mysql_fetch_row($result))
					{	
				?>
                <tr>
                	<td>	
                    <p class="mainfont">Reservation <?php echo $i; ?>:</p>
                    	<table border="0" align="center">
                        <tr>
                        	<td width="200">Class:</td><td><?php echo $row['coursenum'];?></td>
                      	</tr><tr>
                            <td>Test:</td><td><?php echo $row['testname'];?></td>
                       	</tr><tr>
                            <td>Date:</td><td><?php echo $row['DATE_FORMAT(t1.day, \'%a, %c/%e\')']?></td>
                        </tr><tr>
                            <td>Location:</td><td><?php echo $row['name'];?></td>
                        </tr><tr>
                            <td>Time:</td><td><?php echo $row['session_time'];?></td>
                        </tr>
						<tr align="center">
							<td><a href="student.php" class="selectlink">Delete Reservation</a></td>
						</tr>
                        </table>
                    </td>
                </tr>
				<?php 
					$i = $i + 1;
					}
				}
				else
				{
				?>
				<tr height="360">
					<td valign="top">
						<p class="checklist">You do not currently have any reservations.</p>
					</td>
				</tr>
				<?php
				}
				?>
               <tr>
               		<td>
                    	<p align="center" class="mainfont"><em>
							NOTE: 
							You must have your FSU Identification Card to take the exam
                       	</em></p>
						
							
                    </td>
               </tr>
       		</table>
			<p align="center">
				<a href="student.php" class="selectlink">Return to home</a>
			</p>
    	</td>
    </tr>
  </table>

</body>
</html>

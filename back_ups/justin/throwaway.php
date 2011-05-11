<?php session_start(); ?>
<html>
<!-- DW6 -->
<head>
<title>Exam Reservation System</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="throwaway.css"> 
</head>

	<?php 
	$con = mysql_connect("localhost:3306", "testres", "gaitros");
	if(!$con)
	{
		die("Couldn't connect to SQL host");
	}
	mysql_select_db("test_reservation_system", $con);
	if($_REQUEST["username"])
	{
		$username = $_REQUEST["username"];
	}
	$password = $_REQUEST["password"];
	$badpass = "";
	if ($username != NULL)
	{
		$result = mysql_query("SELECT * from user WHERE fsuid='$username' AND password='$password'");
		$row = mysql_fetch_array($result);
		if($row)
		{
			$_SESSION['fsuid'] = $row['fsuid'];
			header( 'Location: http://troyprog.dyndns.tv/~testres/throwawayselect.php' ) ;
		}
		elseif(!$row)
		{
			$badpass = "Incorrect username or password.";
		}
	}
	?>



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
 
	<tr><td>
	<p class="style2">Important Policies </p>
    <ul class="style2">
      <li>Exam reservations made or changed after the deadlines posted on the class Agenda will be penalized unless you present a doctor's note at the time of your exam.</li>

      <li>Bring a photo ID to your exam and arrive on time.</li>
      </ul>    
    <p class="style2">See the class Syllabus for more details on these and all class policies.</p>    

<!--
    <ul class="style2">actually in <b>315-A MCH</b>, which is a side classroom
         in the MCH 315 public lab.</li>
    </ul>
-->



    <p><strong><em><font size="-1" face="Arial, Helvetica, sans-serif">WHEN RESERVING EXAM TIMES PLEASE WORK THROUGH ALL FOUR PAGES OF THE RESERVATION PROCESS UNTIL YOU SEE THE MESSAGE THAT YOUR RESERVATION IS CONFIRMED. MAKE NOTE OF THE CONFIRMATION NUMBER PROVIDED ON THE LAST PAGE FOR FUTURE REFERENCE. </font></em></strong></p>
    <table width="500" border="1" cellspacing="0" align="center" cellpadding="6" >
        <tr bgcolor="#FFFFFF">
          <td> 
            <p><font face="Times New Roman, Times, serif" size="+2"><i><b><span>Online 
              Student Exam Reservation Form<br>

            <font size="-1">(page 1)</font></span></b></i></font></p>
            <p><font face="Arial, Helvetica, sans-serif" size="-1">Please enter 
              the below information then click the Continue button.</font></p>
            <form name="rez" method="post" action="throwaway.php">
              <input type="hidden" name="page" value="1">
              <input name="section" type="hidden" id="section" value="WB">
              <table width="100%" border="0" cellspacing="0" cellpadding="2">
            <tr> 
                  <td width="190"> 
                    <div align="right"><font face="Arial, Helvetica, sans-serif" size="-1">Your 
                      FSU Username:&nbsp;</font></div>
              </td>
                  <td><font face="Arial, Helvetica, sans-serif" size="-1"> 
                    <input name="username" type="text" id="username" size="8" maxlength="8">
                  @fsu.edu</font></td>
            </tr>
            <tr>
            	<td width="190"> 
                    <div align="right"><font face="Arial, Helvetica, sans-serif" size="-1">Your 
                      Password:&nbsp;</font></div>
              </td>
              <td>
                    <input name="password" type="password" id="password" size="16" maxlength="16">
                 </td>
              </table>

              <div align="center"><?php echo $badpass; ?><br>
                <input type="submit" name="Submit" value="Continue to page two &gt;">
              </div>
              <p>&nbsp;</p>
            </form>
          </td>
        </tr>
      </table>      <p align="center">&nbsp;</p>      <p>&nbsp;</p></td>

</tr>
</table>

<p>&nbsp; </p>
</body>
</html>


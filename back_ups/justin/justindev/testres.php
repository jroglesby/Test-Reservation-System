<?php 
	session_start(); 

	require("data_access.php");

	if ( array_key_exists( 'message', $_SESSION) )
	{
		$message = $_SESSION['message'];
	}
	else
	{
		$message = "<br>";
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<!-- DW6 -->
<head>
<title>Exam Reservation System</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="testres.css"> 
</head>
<?php
	//Session variables that get stored:
	//'fsuid' stores the fsuid of the student that has signed in.
	//'message' is a carrier for any messages that need to be passed between webpages.
	//BE SURE TO UNSET THE MESSAGE AFTER YOU USE IT, OR ELSE IT MIGHT CARRY TO OTHER PAGES.

	if ( array_key_exists( 'fsuid', $_SESSION) )
	{
		session_destroy();
	}
	
?>


<body bgcolor="#FFFFFF" text="#000000" link="#660000" vlink="#990000" alink="#FFCC00">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td bgcolor="#540115"><b><i><a href="testres.php" class="headlink">Exam Reservation System</a></i></b>
    </td>
  </tr>
</table>
<p>&nbsp;</p>
 <table width="600" height="550" border="1" align="center" cellpadding="6" cellspacing="0" class="main_box_background">
	<tr><td bgcolor="#FFFFFF">
		<div class="headerfont"><b>Exam Reservation System</b></div>
	</td></tr>
 
	<tr><td>
	<p class="mainfont"><b>Important Policies</b> </p>
    <ul class="mainfont">
      <li>Exam reservations made or changed after the deadlines posted on the class Agenda will be penalized unless you present a doctor's note at the time of your exam.</li>

      <li>Bring a photo ID to your exam and arrive on time.</li>	  
    </ul>    
	<p class="mainfont"><b>Log In Information</b></p>
	<ul class="mainfont">
		<li>Your FSUID is the same that you use to Log In to BlackBoard.</li>
	    <li>Your Password will be given to you on the first day of class. You will need to reset it. 
			<br><center><b>Write down your new password for later use!</b></center></li>
	</ul>
    <p class="mainfont">See the class Syllabus for more details on these and all class policies.</p>    

    <table width="500" border="1" cellspacing="0" align="center" cellpadding="6" >
        <tr bgcolor="#FFFFFF">
          <td> 
            <p><font face="Times New Roman, Times, serif" size="+2"><i><b>Online 
              Student Exam Reservation Form<br></b></i></font>
			</p>
            <p><font face="Arial, Helvetica, sans-serif" size="-1"><i><b>Please enter 
              the below information then click the Log In button.</b></i></font>
			</p>
            <form name="rez" method="post" action="login.php">
            <table width="100%" border="0" cellspacing="0" cellpadding="2">
            <tr> 
                  <td width="190"> 
                    <div align="right"><font face="Arial, Helvetica, sans-serif" size="-1">Your 
                      FSUID:&nbsp;</font></div>
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
                    <input name="password" type="password" id="password" maxlength="50">
                </td>
            </table>

              <div align="center"><div class="message"><?php echo $message; unset($_SESSION['message']);?></div><br>
                <input type="submit" name="Submit" value="Log In &gt;">
              </div>
			  </form>
			<div align="center">
				<form method="post" action="forgotpassword.php">
					<input type="submit" name="forgotpass" value="Forgot Your Password?">
				</form>
			</div>
        </td>
      </tr>
    </table>      
	  
	  <p align="center">&nbsp;</p>      <p>&nbsp;</p></td>

</tr>
</table>

<p>&nbsp; </p>
</body>
</html>


<?php session_start(); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<title>Exam Reservation Response</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="../throwaway.css"> 
</head>
<?php
	if( !array_key_exists('fsuid', $_SESSION) )
	{
		$_SESSION['message'] = "Please sign in.";
		header( 'Location: http://troyprog.dyndns.tv/~testres/testres.php' ) ;
	}
	if ( array_key_exists( 'message', $_SESSION) )
	{
		$message = $_SESSION['message'];
		unset($_SESSION['message']);
	}
	else
	{
		$message = "";
	}
    $con = mysql_connect("localhost:3306", "testres", "gaitros");
    if(!$con)
    {
        die("Couldn't connect to SQL host");
    }
    $fsuid = $_SESSION['fsuid'];
    mysql_select_db("test_reservation_systm", $con);

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
    <tr height="30">
        <td bgcolor="#FFFFFF">
            <div class="headerfont"><b>Test Scheduler<b></div>
        </td>
    </tr>

    <tr>
        <td valign="top">
            <p><font size="+1"><i><font color="#990000"><b>Choose a course and test:</b></font></i></font></p>
            <div align="center" class="message"><?php echo $message;?></div>
            <p align="center" class="style2"> 
                <form method="post" action="daily_scheduler.php">
                    <br><br>
                    Course: 
                    <select id=course>
                        <option>CEN2100</option>
                        <option>CEN2060</option>
                    </select>
                    &nbsp&nbsp Section:
                    <select id=sec_num>
                        <option>01</option>
                        <option>02</option>
                    </select>
                    <br><br>
                    Test (select a previosuly exisitng test to modify):
                    <select id="test">
                        <option>Add a test</option>
                        <option>Test 1</option>
                        <option>Test 2</option>
                    </select>
                    <br><br>
                    Semester:
                    <select id="semester">
                        <option>01-Spring</option>
                        <option>06-Summer</option>
                        <option>09-Fall</option>
                    </select>
                    Year:
                    <select id="year">
                        <option>2011</option>
                        <option>2012</option>
                    </select>
            </p>
                <center><input type="submit" name="Submit" value="Next"></center>
            </form>
            <form action = "student.php" method="post">
                <center><input type="submit" name="Cancel" value="Cancel"></center>
            </form>
        </td>
    </tr>
</table>

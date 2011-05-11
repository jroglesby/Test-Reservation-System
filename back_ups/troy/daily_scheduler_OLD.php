<?php session_start(); ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<title>Exam Reservation Response</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="throwaway.css"> 
<script language="javascript" src="/javascript/calendar/calendar.js"></script>
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
            <div class="headerfont"><b>Daily Scheduler<b></div>
        </td>
    </tr>

    <tr>
        <td valign="top">
            <p><font size="+1"><i><font color="#990000"><b>Select the options for the test:</b></font></i></font></p>
            <div align="center" class="message"><?php echo $message;?></div>
            <p align="center" class="style2"> 
                <form method="post" action="">
                    <br><br>
                    <?php
                        $myCalendar = new tc_calendar("date2");
                        $myCalendar->setIcon("calendar/images/iconCalendar.gif");
                        $myCalendar->setDate(date('d'), date('m'), date('Y'));
                        $myCalendar->setPath("calendar/");
                        $myCalendar->setYearInterval(1970, 2020);
                        $myCalendar->dateAllow('2008-05-13', '2015-03-01', false);
                        $myCalendar->startMonday(true);
                        $myCalendar->disabledDay("Sat");
                        $myCalendar->disabledDay("sun");
                        $myCalendar->writeScript();


                    ?>
                    <br>
                    <input type ="radio" name="time_limit" value="35">35 minutes</input>&nbsp&nbsp
                    <input type ="radio" name="time_limit" value="50">50 minutes</input>&nbsp&nbsp
                    <input type ="radio" name="time_limit" value="75">75 minutes</input>&nbsp&nbsp
                    <input type ="radio" name="time_limit" value="120">120 minutes</input>
                    <table name="day_and_time">
                        <tr>
                            <th> Time </th>
                            <th> Monday </th>
                            <th> Tuesday </th>
                            <th> Wednesday </th>
                            <th> Thursday </th>
                            <th> Friday </th>
                        </tr>
                        <tr>
                            <td>8:00</td>
                            <td><input type="checkbox" name="date_time" value="8M" />
                            <td><input type="checkbox" name="date_time" value="8T" />
                            <td><input type="checkbox" name="date_time" value="8W" />
                            <td><input type="checkbox" name="date_time" value="8R" />
                            <td><input type="checkbox" name="date_time" value="8F" />
                        </tr>
                    </table>

            </p>
                <center><input type="submit" name="Submit" value="Next"></center>
            </form>
            <form action = "test_scheduler.php" method="post">
                <center><input type="submit" name="Cancel" value="Cancel"></center>
            </form>
        </td>
    </tr>
</table>

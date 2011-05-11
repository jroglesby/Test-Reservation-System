<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<title>Exam Reservation Response</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="throwaway.css">  
<script type="text/javascript">
      function toggleVis(id)
      {
       document.getElementById(id).setAttribute("class", "show")
      }
    </script>




</head>
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
  <tr valign="top"><td>
  <p><font size="+1"><i><font color="#990000"><b>Choose your exam time(s):</b></font></i></font></p>
  	<form method="post" action="" name="reserve">
  	<p align="center"> 
<table border='1' width="550" cellspacing='0' cellpadding='6' align="center" class="center_box_background">
<tr>
	<th>Webbased Exam Session
		<br><?php echo $_REQUEST["classname"]; ?>
		<br><?php echo $_REQUEST["testname"]; ?>
		<br>Available Times
    </th>
</tr>
</table>
<table border='1' width="550" cellspacing='0' cellpadding='6' align="center" class="center_box_background">
<tr><td>//Search Will Go Here
</td></tr>
</table>
<table border='1' width="550" cellspacing='0' cellpadding='6' align="center" class="center_box_background">
<tr valign='top' border="1">
	<td><em>Pick a Test Session date!</em><br>
    	<select name='date1' size='4' onclick="toggleVis('session1loc')">
        	<option name="02-24-2011" value="2011-02-24">Monday, 2/24</option>
            <option name="02-25-2011" value="2011-02-24">Tuesday, 2/25</option>
            <option name="02-26-2011" value="2011-02-26">Wednesday, 2/26</option>
            <option name="02-27-2011" value="2011-02-27">Thursday, 2/27</option>
        </select>
    </td>
	<td id="session1loc" class="hidden"><em>Pick a Test Session location!</em><br />
    	<select name='location1' size='4' onclick="toggleVis('session1time')">
        	<option name="UTC" value="UTC">UCC1200</option>
            <option name="MCH" value="MCH">3-15A MCH</option>
        </select>
   	</td>
    <td id="session1time" class="hidden"><em>Pick a Test Session time!</em><br />
    	<select name='time1' size='4'>
        	<option name="930" value="930">9:30a.m. - 30 seats</option>
            <option name="1030" value="1030">10:30a.m. - 15 seats</option>
            <option name="130" value="130">1:30p.m. - 3 seats</option>
            <option name="230" value="230">2:30p.m. - 24 seats</option>
            <option name="330" value="330">3:30p.m. - 19 seats</option>
            <option name="430" value="430">4:30p.m. - 1 seat</option>
            <option name="530" value="530">5:30p.m. - 10 seats</option>
            <option name="630" value="630">6:30p.m. - 35 seats</option>
       	</select>
    </td>
</tr>
</table>
</p>

    <p align="center">
    <input type="submit" name="Submit" value="Submit"><br>
    </p> 
    </form>
	<form action="throwawayselect.html" method="post">
	<p align="center">
	<input type="submit" name="Cancel" value="Cancel"><br>
	</p>
	</form>
    </td></tr></table>


<?php
	//This file contains all standard HTML headers and table declarations that will be used
	//on all pages. This is for ease of changing/updating/etc.

	function html_header()
	{
?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
			"http://www.w3.org/TR/html4/loose.dtd">
		<html>

		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8;">
			<title>Exam Reservation System</title>
			<link rel="stylesheet" type="text/css" href="http://troyprog.dyndns.tv/~testres/template/testres.css"> 
			<script type="text/javascript" src="testres.js"></script>
		</head>
		<body>
<?php
	}

	
	
	
	function html_topBar()
	{
?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td class="topbar">
					<a href="thttp://troyprog.dyndns.tv/~testres/testres.php" class="headlink">Exam Reservation System</a>
				</td>
			</tr>
		</table>
<?php
	}
	function html_footer()
	{
?>
		</body>
		</html>
<?php
	}
	
	
?>

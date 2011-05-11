<?php
        session_start();

        require("data_access.php");

        redirect();

?>
<html>
<head>
<title>Exam Reservation System</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="testres.css">
</head>

<?php
	$day = $mon = $year = $i = $holder = "";
	$i = "dumb";
	$yes = 0;
	$counter = 0;

	for($j=0;$j<100;$j++){
		if(($yes==0)&&(isset($_GET[$i]))){
			$holder = getSessDate($_GET[$i]);

			$row=mysql_fetch_assoc($holder);
			$holder=$row['day'];

		$trial = 0;

		$tagname = strtok($holder,'--');
		$year = $tagname;

		while($tok = strtok('--'))
		{	if($trial==0){
				$mon = $tok;
			} else if($trial==1){
				$day = $tok;
			} else{}

			$trial++;
		}

		$trial = 1;
		$holder = 0;
		while(($mon!=(date("n")-$holder))&&($trial!=0)){
			if($year-date("Y")>0){
				$holder--;
			} else if($year-date("Y")<0){
				$holder++;
			} else {
				if($mon==(date("n")-$holder)){
					$trial = 0;
				} else {
					if($mon>(date("n")-$holder)){
						$holder--;
					} else {
						$holder++;
					}
				}
			}			

		}
		$mon = $holder;
			$yes=1;
		} else{}

		if(isset($_GET[$i])){
			$temp = $_GET[$i];
			deleteSession($temp);
			$counter++;
		} else{}

		$i++;
	}

	$_SESSION['message'] = $counter." sessions deleted.";

	header( 'Location: http://troyprog.dyndns.tv/~testres/tristan/calendar.php?day='.$day.'&mon='.$mon );
?>


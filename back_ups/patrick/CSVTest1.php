<html>
<head>
<title>CSV Test 1</title>
</head>
<body>
	<?php
	
	$row=1;
	// try to open the test file, if open sucessful, go on
	if (($handle = fopen("test.csv", "r")) !== FALSE ) {
		while (($data = fgetcsv($handle, ",")) !== FALSE ) {
			$num = count($data);
			echo "<p> $num fields in line $row: <br /></p>\n";
			$row++;
			for ($c=0; $c < $num; $c++){
				echo $data[$c]. "<br />\n";
			}
		}
		fclose($handle);
	}
	
	/*
	$con = mysql_connect("localhost:3306", "testres", "gaitros");
	if(!$con)
	{
		die("Couldn't connect to SQL host");
	}
	*/
	?>
	
</body>
</html>
<?php
/*
 * This file is designed to allow uploads of txt/csv files to the upload directory from user's system
 */
 


	//$opener = "";	// storage var for file name
	// check to make sure file is small enough
	if (($_FILES["file"]["size"] < 50000)) {
		// if the above code produces errors, return error
		if ($_FILES["file"]["error"] > 0) {
			echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
		// else, upload, and print to screen file information
		} else {
			echo "Upload: " . $_FILES["file"]["name"] . "<br />";
			echo "Type: " . $_FILES["file"]["type"] . "<br />";
			echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
			$opener = $_FILES["file"]["tmp_name"];
			echo "Temp file: " . $opener . "<br />";
		// if the file has previously been upladed, inform to screen
			if (file_exists("upload/" . $_FILES["file"]["name"]))
				echo $_FILES["file"]["name"] . " already exists. ";
		} 
	} else 
		echo "Invalid file <br />";
	
	
	
	// try to open the test file, if open sucessful, go on
	$row = 1;
	if (($handle = fopen($opener, "r")) !== FALSE ) {
		while (($data = fgetcsv($handle, ",")) !== FALSE ) {
			$num = count($data);
			// strip the headers, we don't care about them.
			if ($row !== 1){
				for ($c=0; $c < 4; $c++){
					if ($c == 2){
						$hashed = hash('md5', $data[$c] . "$@1+");
					}
					echo $data[$c] . "\t";
				}
				echo $hashed . "<br />\n";
			}
			$row++;
		}
	}
	fclose($handle);
	
?> 
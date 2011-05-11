<?php
/*
 * This file is designed to allow uploads of txt/csv files to the upload directory from user's system
 */
 


	//$opener = "";	// storage var for file name
	// check to make sure file is small enough, and CSV
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
			/*
			else {
				move_uploaded_file($_FILES["file"]["tmp_name"],
			"upload/" . $_FILES["file"]["name"]);
			echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
			}
			*/
		}
	} else {
		echo "Number of errors: " . $_FILES["file"]["error"] . "<br />";
		echo "Invalid file <br />";
		echo "opener = " . $opener;
	}
  
	$row=1;
	// try to open the test file, if open sucessful, go on
	if (($handle = fopen($opener, "r")) !== FALSE ) {
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
?> 

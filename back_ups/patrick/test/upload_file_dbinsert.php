<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require("functions.php");

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
			$opener = $_FILES["file"]["tmp_name"];
		// if the file has previously been upladed, inform to screen
			if (file_exists("upload/" . $_FILES["file"]["name"]))
				echo $_FILES["file"]["name"] . " already exists. ";
		} 
	} else 
		echo "Invalid file <br />";
	
	// try to open the file, if open sucessful, go on
	$row = 1;
	$fsuid = 2;
	$fname = 1;
	$lname = 0;
	$course = 3;
	$sect = 4;
	if (($handle = fopen($opener, "r")) !== FALSE ) {
		while (($data = fgetcsv($handle, ",")) !== FALSE ) {
			// strip the headers, we don't care about them.
			if (($row !== 1 ) && (insertCheck($data[$course]))){
				
				$count = count($data);
				if ($count < 4)
					$section = 0;
				else
					$section = $data[$sect];
				
				if (insertCheck($data[$course], $section)){
					enrollInsert($data[$fsuid], $data[$course], $section);
					$hashed = hash('md5', $data[$fsuid] . "$@1+");
					rosterInsert($data[$fsuid], $data[$fname], $data[$lname], $hashed);
				}
			}
			$row++;
		}
	}
?>
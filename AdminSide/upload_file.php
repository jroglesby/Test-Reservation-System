<?php
	//open session
	session_start(); 

	//server-side include of all data access management layers and utility funcs
	require("../template/data_access.php");
	
	//server-side include of all standard HTML structures that will be used in the file
	require("../template/template_structs.php");
	
	//check for valid session
	//redirect();
	
	//get message to display if there is one
	if ( array_key_exists( 'message', $_SESSION) )
	{
		$message = $_SESSION['message'];
		unset($_SESSION['message']);
	}
	else
	{
		$message = "<br>";
	}
?>

<?php
	//html info, header, etc.
	html_header();
?>

<?php
	//Put any applicable data access functions here
?>
	
<?php
	//top header
	html_topBar();
?>
<p>&nbsp;</p>

<!-- main box starts here -->

	<table class="main_box_background" align="center" border="1" cellspacing="0" >
		<tr>
			<td class="headerbox">
					Exam Reservation System
			</td>
		</tr>
		<tr>
			<td valign="top">
				<p class="cornercaption">
					<!-- Caption -->
					Upload Results:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<?php
							error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
							
							/*
							* This file is designed to allow uploads of txt/csv files to the upload directory from user's system
							*/
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
								echo "Invalid file <br>";
	
							// try to open the file, if open sucessful, go on
							$row = 1;
							$fsuid = 2;
							$fname = 1;
							$lname = 0;
							$course = 3;
							$sect = 4;
							$badArray = array();
							if (($handle = fopen($opener, "r")) !== FALSE ) {
								while (($data = fgetcsv($handle, ",")) !== FALSE ) {
									// strip the headers, we don't care about them.
									if (($row !== 1 )){
									// check if the row has section information or not
										$count = count($data);
										if ($count < 4)
											$section = 0;
										else
											$section = $data[$sect];
										// check if the course exists, if so, insert info
										if (insertCheck($data[$course], $section)){
											enrollInsert($data[$fsuid], $data[$course], $section);
											$hashed = hash('md5', $data[$fsuid] . "$@1+");
											rosterInsert($data[$fsuid], $data[$fname], $data[$lname], $hashed);
										} else { 
											$courseFlag = true;
											$badCourse = $data[$course] . " " . $data[$section];
										}
										if ($courseFlag == true ){
											if (in_array($badCourse, $badArray) == NULL){
												array_push($badArray, $badCourse);
												$courseFlag = false;
											}
											else {
												$courseFlag = false;
											}
										}
									}
									$row++;
								}
							
								$maxCount = count($badArray, 0);
								for ($i = 0; $i < $maxCount; $i++){
								?>
								<p>
								<?php
								echo "Course " . $badArray[$i] . " does not exist.<br>";
								?>
								</p>
								<?php 
								}
							}
							if (count($badArray, 0) > 0){
							?>
							<a href="./troy/edit_course.php" class="selectlink">Add Course Here.</a>
							<?php
							}
							?>
							
							<p class="message" align="center"> All updates complete.</p>
							<form method="post" action="admin.php">
							<center>
								<input type="submit" value="Return" style="vertical-align: bottom;" name="Return">
							</center>
							</form>
							
							<!-- End Content -->
						</td>
					</tr>
				</table>
				<!-- inner box ends here -->
			</td>
		</tr>
	</table>
<!-- main box ends here -->
<?php
	//whatever needs to go at the bottom of the page.
	html_footer();
?>
								
					

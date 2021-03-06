<?php
	//open session
	session_start(); 

	//server-side include of all data access management layers and utility funcs
	require("../data_access.php");
	
	//server-side include of all standard HTML structures that will be used in the file
	require("template_structs.php");
	
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
	
	//TROY
	//Get course number and section
	 $con = mysql_connect("localhost:3306", "testres", "gaitros");
    if(!$con)
    {
        die("Couldn't connect to SQL host");
    }
    $fsuid = $_SESSION['fsuid'];
    mysql_select_db("test_reservation_system", $con);
    
   
   	//check if test name given, and if it already exists
	
	if($_REQUEST['newLocName'] != NULL)
	{
		$lName = $_REQUEST['newLocName'];
		trim($lName);
		
		add_location($lName);	
			
		$_SESSION["message"] = "Location '$lName' successfully added";
		header( 'Location: http://troyprog.dyndns.tv/~testres/admin.php' ) ;
			
			
	}
	else
	{
		$_SESSION['message'] = "Error adding location, please check if it already exists!";
		header( 'Location: http://troyprog.dyndns.tv/~testres/troy/location.php' ) ;
		exit;
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
					Caption:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<p class="mainfont">
							Content
							<br>
							Will
							<br>
							Go
							<br>
							Here
							<br>
							</p>
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
						
						
							
					
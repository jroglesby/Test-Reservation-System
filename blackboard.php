<?php
	//open session
	session_start(); 

	//server-side include of all data access management layers and utility funcs
	require("./template/data_access.php");
	
	//server-side include of all standard HTML structures that will be used in the file
	require("./template/template_structs.php");
	
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
			<td class="main_box_td" valign="top">
				<p class="cornercaption">
					<!-- Caption -->
					Secure Apps:
				</p>
				<!-- inner box starts here -->
				<table class="inner_box_background" align="center" cellspacing="0" cellpadding="6">
					<tr valign="top">
						<td>
							<!-- Content -->
							<p class="mainfont">
									<div style="float:left; width:50%;">
<ul>
<li>
<a class="selectlink" target="" href="https://cfprd.oti.fsu.edu/sfs/das/index.cfm?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Account Refund Setup</a>
</li>
<li>
<a class="selectlink" target="" href="/StudentDegreeCandidate/navigator?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Apply for Graduation</a>
</li>
<li>
<a class="selectlink" target="_new" href="/AppBridge/jsp/goingglobal.jsp?noheader=false&nofooter=false&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Career Center Going Global: Career Guides/Employer Database</a>
</li>
<li>
<a class="selectlink" target="" href="/CareerPortfolio/servlet/Main?action=firsttimelogin&noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Career Center Portfolio</a>
</li>
<li>
<a class="selectlink" target="_new" href="http://fsu-csm.symplicity.com/sso/students/login/?noheader=false&nofooter=false&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Career Center Seminole</a>
</li>
<li>
<a class="selectlink" target="_new" href="https://cfprd.oti.fsu.edu/dsa/uniworld/uniworld.cfm?noheader=false&nofooter=false&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Career Center Uniworld's International Subsidiaries</a>
</li>
<li>
<a class="selectlink" target="" href="/StudentCertifications/Navigator?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Certification Request</a>
</li>
<li>
<a class="selectlink" target="" href="https://cfprd.oti.fsu.edu/dsa/CivEd/?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Civ Ed</a>
</li>
<li>
<a class="selectlink" target="" href="/RegistrarDropAddTool/navigator?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Course Drop Tool</a>
</li>
<li>
<a class="selectlink" target="_new" href="/RegistrarCourseLookup/SearchForm?noheader=false&nofooter=false&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Course Search</a>
</li>
<li>
<a class="selectlink" target="" href="https://cfprd.oti.fsu.edu/anr/Menus/courseSupportCodesMenu.cfm?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Course Support Codes Menu</a>
</li>
<li>
<a class="selectlink" target="" href="/RegistrarSDBSupportTables/navigator?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Enrollment Services Support Tables</a>
</li>
<li>
<a class="selectlink" target="" href="/RegistrarPINManagement/StudentNavigator?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">FACTS PIN</a>
</li>
<li>
<a class="selectlink" target="" href="https://cfprd.oti.fsu.edu/sfs/exit_int/index.cfm?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Financial Aid Exit Interview</a>
</li>
<li>
<a class="selectlink" target="" href="/OFAStudentToolkit/navigator?CALLINGURI=LOGGEDINSTUDENT&noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Financial Aid Student Toolkit</a>
</li>
<li>
<a class="selectlink" target="" href="/FSUID/servlet/CASIndex?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">FSUID Identity Management</a>
</li>
<li>
<a class="selectlink" target="" href="/GarnetAndGold/index.jsp?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Garnet and Gold Program</a>
</li>
<li>
<a class="selectlink" target="" href=" /RegistrarGradeRosterArchive/navigator?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Grade Roster Archive</a>
</li>
<li>
<a class="selectlink" target="" href="/RegistrarGradeRoster/navigator?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Grade Roster Submission</a>
</li>
<li>
<a class="selectlink" target="_new" href="http://ir.fsu.edu/secured_redir.cfm?noheader=false&nofooter=false&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Institutional Research</a>
</li>
<li>
<a class="selectlink" target="" href="https://cfprd.oti.fsu.edu/dsa/IntramuralSports/index.cfm?force_auth=1&noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Intramural Sports Sign-up</a>
</li>
<li>
<a class="selectlink" target="" href="https://cfprd.oti.fsu.edu/sfs/late_pay/?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Late Payment Waiver</a>
</li>
<li>
<a class="selectlink" target="" href="https://cfprd.oti.fsu.edu/sfs/pay_online/step1.cfm?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Make a Payment</a>
</li>
</ul>
</div><div style="float:left; width:50%;">
<ul>
<li>
<a class="selectlink" target="_new" href="https://apps.oti.fsu.edu/WebIntegrate/e-academy?noheader=false&nofooter=false&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Microsoft Work At Home</a>
</li>
<li>
<a class="selectlink" target="" href="https://cfprd.oti.fsu.edu/sfs/finresp/index.cfm?final_destination=payhist&noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">My Account Statement</a>
</li>
<li>
<a class="selectlink" target="" href="/StudentAddress/Navigator?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">My Address</a>
</li>
<li>
<a class="selectlink" target="" href="/StudentClassSchedule/Schedule?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">My Class Schedule</a>
</li>
<li>
<a class="selectlink" target="" href="/StudentGrades/servlet/StudentGradeServlet?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">My Grades (Most Recent Term)</a>
</li>
<li>
<a class="selectlink" target="" href="/StudentProfile/servlet/StudentProfileServlet?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">My Profile</a>
</li>
<li>
<a class="selectlink" target="" href="https://cfprd.oti.fsu.edu/dsa/CivEdStudent?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">My Service Hours</a>
</li>
<li>
<a class="selectlink" target="" href="/StudentSASSAudit/servlet/StudentSASSAudit?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">My Undergraduate Graduation Check</a>
</li>
<li>
<a class="selectlink" target="" href="/StudentAcademicTranscript/servlet/StudentAcademicTranscript?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">My Unofficial Transcript</a>
</li>
<li>
<a class="selectlink" target="" href="/OfficialTranscriptRequest/controller?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Official Transcript Request</a>
</li>
<li>
<a class="selectlink" target="_new" href="https://portal.omni.fsu.edu/psp/sprdep/EMPLOYEE/EMPL/h/?noheader=false&nofooter=false&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">OMNI Login</a>
</li>
<li>
<a class="selectlink" target="_new" href="/AppBridge/jsp/?url=HERITAGE_GROVE_ORDER&noheader=false&nofooter=false&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Order/Disconnect Heritage Grove Cable &amp; Phone Services</a>
</li>
<li>
<a class="selectlink" target="" href="/ParentAccess/?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Parent/Third-Party Access</a>
</li>
<li>
<a class="selectlink" target="_new" href="https://parking.fsu.edu/cmn/auth.asp?noheader=false&nofooter=false&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Parking Permits</a>
</li>
<li>
<a class="selectlink" target="" href="http://www.ecsi.net/promP6?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Perkins Loan Promissory Note</a>
</li>
<li>
<a class="selectlink" target="" href="/CourseRegistration/Navigator?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Register for Classes</a>
</li>
<li>
<a class="selectlink" target="" href="/RegistrationStopsCheck/jsp/index.jsp?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Registration stops/warnings</a>
</li>
<li>
<a class="selectlink" target="_new" href="/SAMSLogin/servlet/Login?noheader=false&nofooter=false&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">SAMS Login</a>
</li>
<li>
<a class="selectlink" target="" href="https://cfprd.oti.fsu.edu/sfs/ddl/index.cfm?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Short Term Loans</a>
</li>
<li>
<a class="selectlink" target="" href="https://cfprd.oti.fsu.edu/sfs/ecsi_transfer/?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Tax Information - Form 1098-T</a>
</li>
<li>
<a class="selectlink" target="" href="https://signup.otc.fsu.edu/?noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">Telecom: Residence Hall Sign-Up/Disconnect Form</a>
</li>
<li>
<a class="selectlink" target="" href="/SpaceUtilizationUSMS/servlet/USMSNavigationServlet?CALLINGURI=/jsp/menu.jsp&noheader=true&nofooter=true&SESSIONID=9ba04ce1a863bcd94807df42d651&uid=&ORIGIN=J">USMS (Space Management)</a>
</li>
<li>
<a class="selectlink" target="" href="./testres.php">Test Reservation System</a>
</li>
</ul>
</div>
							
							
							
							</p>
							<!-- End Content -->
						</td>
					</tr>
				</table>
				<!-- inner box ends here -->
				<br>
			</td>
		</tr>
	</table>
<!-- main box ends here -->
<?php
	//whatever needs to go at the bottom of the page.
	html_footer();
?>
						
						
							
					

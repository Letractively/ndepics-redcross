<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// forgotPassword.php - Obtain enough information to justify sending a password reset e-mail.
//************************************

// This starts or resumes the PHP session.
session_start();

include("./config/functions.php");
include("./config/open_database.php");

print "<html>";
	print "<head>";
		// Analysis of Crowd-sourced Damage Reports
		print "<title>Red Cross Damage Reports </title>";
		
		// This is the CSS used for this website.
		print "<link rel='stylesheet' type='text/css' href='./style/styles.css' />";
		
		// This is the JavaScript file used for this website.
		print "<script type='text/javascript' src='./config/functions.js'>";
		print "</script>";
		
		// This is the shortcut icon used for this website.
 		print "<link rel='shortcut icon' href='./style/icon.ico' />";
 		
 		// This controls layout on mobile browsers.
 		print "<meta name='viewport' content='initial-scale=1.0, user-scalable=no' />";
	print "</head>";

print "<body>";
	// This should be removed upon actual deployment.
	print "<p>THIS WEBSITE IS UNDER DEVELOPMENT AND USED FOR TESTING PURPOSES ONLY.</p>";
	print "<div id='main'>";
	
		// The Red Cross Logo is found here.
		print "<div id='rcLogo'>";
			print "<img src='./style/logo.jpg' alt='red cross' width=100% />";
		print "</div>";
	
		include("./config/display_error_message.php");
		
		print "<form action='forgotPassword2.php' method='post'>";
			print "Please enter the username and e-mail address associated with your account. Your password will be reset and an e-mail will be sent shortly.<br />";
			print "<table>";	
				print "<tr>";
					print "<td>Username: </td>";
					print "<td><input type='text' name='username'></td>";
				print "</tr>";
				print "<tr>";
					print "<td>E-mail Address: </td>";
					print "<td><input type='text' name='email'></td>";
				print "</tr>";
				print "<tr>";
					print "<td></td>";
					print "<td><input type='submit' value='Send e-mail'></td>";
				print "</tr>";
				print "<tr>";
					print "<td><input type='button' value='Go Back' onClick='history.go(-1)'";
				print "</tr>";
			print "</table>";
		print "</form>";
		
	print "</div>";
print "</body>";
print "</html>";

include("./config/close_database.php");

?>
<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// forgotUsername.php - Obtain enough information to justify sending an username reminder e-mail.
//************************************

// This creates or resumes a PHP session.
session_start();

include("./config/functions.php");
include("./config/open_database.php");

print "<html>";
	print "<head>";
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

		print "<form action='forgotUsername2.php' method='post'>";
			print "Please enter the e-mail address associated with your account. An e-mail with your username will be sent shortly. <br />";
			print "<table>";
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
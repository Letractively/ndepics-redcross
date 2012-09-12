<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// index.php - This is the index page of the website where users can log-in.
//************************************

session_start();

// This is obtained from login.php.
$validityCheck = $_SESSION["valid"];

include("./config/functions.php");

// If the user was validated by login.php then go to the home page.
if($validityCheck == "valid") {
	header( 'Location: ./home.php' );
}
// If the user was invalidated by login.php then display a message.
if($validityCheck == "invalid"){
	print "<div id='redText'>";
		print "Invalid login. Please try-again.";	
	print "</div>";
}

// This is used on visitors pages. 
$_SESSION["message"] = "";

include ("./config/open_database.php");
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
		
		print "<div id='centerText'>";
			print "<table>";
				print "<form action='login.php' method='post'>";
			 		print "<tr>";
						print "<td>User Name:</td>";
						print "<td><input type='text' name='username' /></td>";
					print "</tr>";
					print "<tr>";
						print "<td>Password:</td>";
						print "<td><input type='password' name='password'/></td>";
					print "</tr>";
					print "<tr>";
						print "<td></td>";
						print "<td>";
							print "<input type='submit' value='Log-in'>";
							print "     ";
							print "<input type='reset' value='Clear'>";
						print "</td>";
					print "</tr>";
				print "</form>";
			print "</table>";
			print "<br />";
			print "<table>";
				print "<tr>";
					print "<form action='createUser.php' method='post'>";
						print "<td><input type='submit' value='Sign Up'></td>";
					print "</form>";
					print "<form action='forgotUsername.php' method='post'>";
						print "<td><input type='submit' value='Forgot Username?'></td>";
					print "</form>";
					print "<form action='forgotPassword.php' method='post'>";
						print "<td><input type='submit' value='Forgot Password?'></td>";
					print "</form>";
				print "</tr>";
			print "</table>";
		print "</div>";
	print "</div>";
print "</body>";

print "</html>";

include ("./config/close_database.php");

?>
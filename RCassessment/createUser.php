<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// createUser.php - This uses PHP to obtain the information necessary to create a user. A visitor can make their own user account. Admin privileges are needed to create more admins.
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
	
		print "<form action='createUser2.php' method='post'>";
			print "<table>";
				print "<tr>";
					print "<td>User name:</td>";
					print "<td><input type='text' name='username'></td>";
				print "</tr>";
				print "<tr>";
					print "<td>Email:</td>";
					print "<td><input type='text' name='email'></td>";
				print "</tr>";
				print "<tr>";
					print "<td>Cell Phone Number: </td>";
					print "<td><input type='number' name='cellPhone' onKeyPress='return numbersOnly(event)' maxlength='10'></td>";
				print "</tr>";
				print "<tr>";
					print "<td>Cell Phone Carrier: </td>";
					print "<td>";
						print "<select name='cellCarrier'>";
							print "<option></option>";
							print "<option>Alltel</option>";
							print "<option>AT&T</option>";
							print "<option>Cingular</option>";
							print "<option>Nextel</option>";
							print "<option>Sprint</option>";
							print "<option>T-Mobile</option>";
							print "<option>Virgin Mobile</option>";
							print "<option>Verizon</option>";
							print "<option>Other</option>";
						print "</select>";
					print "</td>";
				print "</tr>";
				// Only an admin can create another admin.
				if($_SESSION["authority"] == "admin"){
					print "<tr>";
						print "<td>Authority:</td>";
					print "</tr>";
					print "<tr>";
						print "<td>Admin</td>";
						print "<td><input type='radio' name='authority' value='admin' /></td>";
					print "</tr>";
					print "<tr>";
						print "<td>User</td>";
						print "<td><input type='radio' name='authority' value='user' checked='checked'/></td>";
					print "</tr>";
				}
				else{
					print "<input type='hidden' name='authority' value='user' />";
				}
				print "<tr>";
					print "<td></td>";
					print "<td>";
						print "<input type='submit' value='Create user'>";
						print "<input type='reset' value='Clear form'>";
					print "</td>";
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
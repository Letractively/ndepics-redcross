<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// retrieveuserinfo.php - Helps a user recover a forgotten account
//****************************
include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Resource-Person</title>";
include("html_include_2.php");
if (($_POST['forgot'] == "password") || ($_GET['bad'] == "username")) {
	print "<center><h2>Forgotten password?</h2></center>\n";
	print "Please enter your username below to have your password reset and an email sent to the email address on file with a temporary password.\n";
	print "<br><br>\n";

	print "<form action=\"retrieveuserinfo2.php\" method=\"POST\">\n";
	print "<table>\n";

	print "<tr>";
	print	"<td>Username  </td>\n";
	print	"<td><input type=\"text\" maxsize=\"15\" name=\"username\"></td>\n";
	print "</tr>\n";
	
	// Check to see if the username is passed back from the second page is invalid
	if ($_GET['bad'] == "username") {
		print "<tr>\n";
		print "<td><span style=\"color:red\">Invalid Username</td>\n";
		print "</tr>\n";
	}
	print "<tr>\n";
	print	"<td><input type=\"submit\" value=\"Retrieve Password\"></td>\n";
	print "</tr>\n";
	print "</table>\n";
	print "</form>\n";
}
else if(($_POST['forgot'] == "username") || ($_GET['bad'] == "email")) {
	print "<center><h2>Forgotten username?</h2></center>\n";
	print "Please enter the email associated with your account. An email will be sent with the username associated with the account.\n";
	print "<br> <br> \n";

	print "<form action=\"retrieveuserinfo2.php\" method=\"POST\">\n";
	print "<table>\n";

	print "<tr>";
	print	"<td>Email Address  </td>\n";
	print	"<td><input type=\"text\" maxsize=\"15\" name=\"email\"></td>\n";
	print "</tr>\n";
	
	// Check to see if the username passed back from the second page is invalid
	if ($_GET['bad'] == "email") {
		print "<tr>\n";
		print "<td><span style=\"color:red\">The email address you entered is invalid.</td>\n";
		print "</tr>\n";
	}
	
	print "<tr>\n";
	print	"<td><input type=\"submit\" value=\"Retrieve Username\"></td>\n";
	print "</tr>\n";
	print "</table>\n";
	print "</form>\n";

}
else {
	print "<center><h2>Forgotten username or Password?</h2></center>\n";
	print "<form action=\"index.php\" method=\"POST\">\n";
	print "There was an error processing your request. Please return to the previous page and try again.\n";
	print "<br><br>\n";
	print "<center><input type=\"submit\" value=\"Go Back\"></center>\n";
	print "</form>\n";
}

include("html_include_3.php");	
?>
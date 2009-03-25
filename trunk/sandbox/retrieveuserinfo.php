<?php

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: ND Epics Group
//	    Mike Ellerhorst
//
//  Spring 2009
//
// retrieveuserinfo.php - Page to send an email with a reset password to an input username or an email with a username.
//
// Revision History:	02/11/09	- Created
//						03/25/09	- Changed POST variables returned from retrieveuserinfo2.php
//
//****************************
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Forgotten User Information</title>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="resource-type" content="document">
<meta name="description" content="disaster.stjoe-redcross.org">
<meta name="keywords" content="">
<meta name="copyright" content="stjoe-redcross.org 2008.  All rights reserved.">
<link rel="shortcut icon" href="http://www.stjoe-redcross.org/favicon.ico">

<!-- <link rel="stylesheet" type="text/css" href="/custom.css"/> -->
<STYLE type="text/css">
 SPAN { padding-left:3px; padding-right:3px }
 DIV.header{ margin:0; padding-bottom: 1px; color: white; background-color: #000000; border:none; font-weight:bold}
 BODY.main{ width: 744px; margin:0 auto; padding:0; background-color:#003366; color: #000000; border:outset}
</STYLE>

</head>

<body class="main">
<div style="border:2px solid white; background-color:#FFFFFF">

<iframe src ="homeframe.php" width="745px" height="175px" scrolling= "no" FRAMEBORDER="0">
  <h2 align="center">St. Joseph's County American Red Cross</h2>
  <p align="center">Your browser does not support iframes.</p>
  <div class="menu">
  <a href = "./home.php" target= "_parent"> HOME</a> | 
  <a href = "./search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>

<?
//'
//

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

		
?>


</body>
</html>

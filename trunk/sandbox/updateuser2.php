<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }


//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: ND Epics Group
//	    Mike Ellerhorst
//
//  Spring 2009
//
// updateuser2.php - File to change the account information of the user in the database.
//
// Revision History:  Created - 02/11/09
//
//****************************

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include ("./config/functions.php");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Update User Profile</title>



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

<!--<div class="menu">
<a href = "./home.php"> HOME</a> | 
<a href = "./search.php"> SEARCH </a>
</div>-->

<? // 
   //Get the values from the previous page and verify that they are unique
   // Then add a record to the users table with the input values
   //

$user_id			= $_SESSION['user_id'];
$oldpassword		= $_POST['oldpassword'];
$newpassword		= $_POST['newpassword'];
$verify_password	= $_POST['verify_pass'];
$email				= $_POST['email'];

//
// Only Update the Email
if($oldpassword == '' && $newpassword == '' && $verify_password == '' && $email != '') {
	$query = "UPDATE	users
			  SET		email = '".$email."'
			  WHERE		user_id = ".$user_id."
			  LIMIT		1";
			  
	$result = mysql_query($query) or die("Error: Updating user profile only email");
	
	print "<center><h2>Your user profile has been updated.</h2>\n";
	print "<center> The new email address on this account is ".$email.".";
	exit();

}

// Passwords do not match, direct them back to the new user page.
if ($newpassword != $verify_password) {

print "<form name='invalid_passwords' method='post' action='updateuser.php' align='left'>\n";
print	"<center><h2>I'm sorry, but the passwords you entered did not match.  Please return to the Update User Profile page and try again.</h2>\n";
print	"<input type=submit value='Back to Update User Profile'>\n";
print "</form>\n";

}
else {

	$query = "SELECT	passwd, email
			  FROM		users
			  WHERE		user_id = '".$user_id."'
			  LIMIT		1";
		  
	$result = mysql_query($query) or die("Error in running the username query.");
	$row = mysql_fetch_assoc($result);

	// User already exists
	if($row['passwd'] != md5($oldpassword)) {
			print "<form name='invalid_password' method='post' action='updateuser.php' align='left'>\n";
			print	"<center><h2>I'm sorry, but the old password you entered is not correct.  Please return to the Update User Profile page and try again.</h2>\n";
			print	"<input type=submit value='Back to Update User Profile'>\n";
			print "</form>\n";
			exit();
	}
	
	if($row['email'] != $email) { $email_flag = 1; }
	
	// Insert the user into the database.
	// Verify the email address...send an email to it to complete the registration process.
	
	$query = "UPDATE	users 
			  SET		passwd = '".md5($newpassword)."'";		  
	if($email_flag)		{	$query .= ", email = '".$email."' "; }
			  
	$query .= "WHERE	user_id = ".$user_id."
			   LIMIT	1";
			  
	$result = mysql_query($query) or die ("Error: Unable to update user. Query: ".$query." .");
	
	print "<center>\n";
	print "<h2> Your user profile has been updated.</h2>\n";
		

}



include ("./config/closedb.php"); 
?>

</body>
</html>

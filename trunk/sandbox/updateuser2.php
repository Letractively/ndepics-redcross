<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross
// Spring 2009 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// updateuser2.php - Page to submit changes to user profile to database
//****************************
session_start();
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Update User</title>";
include("html_include_2.php");

   //Get the values from the previous page and verify that they are unique
   // Then add a record to the users table with the input values

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
include("html_include_3.php");
?>
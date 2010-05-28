<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// newuser2.php - Page to insert new user into database
//****************************
session_start();
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}
// Make sure the user is an admin
if($_SESSION['access_level_id'] != 9) {
	header( 'Location: ./index.php' );
} 

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - New User</title>";
echo "<script src=\"./javascript/selectorganization.js\"></script>";
include("html_include_2.php");

//Get the values from the previous page and verify that they are unique
// Then add a record to the users table with the input values
$username	= $_POST['username'];
$password	= createRandomPassword();
$email		= $_POST['email'];
$search		= $_POST['search'];
$insert		= $_POST['insert'];
$update		= $_POST['update'];
$delete		= $_POST['delete'];
$admin		= $_POST['admin'];

// Set the access level based on the the checkbox values
$access_level = 0;

if($admin == 1) {	$access_level = 9;	}
else {
	if ($search == 1) {
		if ($insert == 1) { $access_level += 4; }
		if ($update == 1) { $access_level += 1; }
		if ($delete == 1) { $access_level += 2; }

		// Only search allowed
		if ($access_level == 0) { $access_level = 10; }
	}
	else {
		// Only insert allowed
		if ($insert == 1) { $access_level = 8; }		
	}
}

$query = "SELECT	user_id
		  FROM		users
		  WHERE		username = '".$username."'
		  LIMIT		1";
	  
$result = mysql_query($query) or die("Error in running the username query.");
$row = mysql_fetch_assoc($result);

// User already exists
if($row['user_id'] != '') {
		print "<form name='invalid_username' method='post' action='newuser.php' align='left'>\n";
		print	"<center><h2>I'm sorry, but the username you entered already exists.  Please return to the New User page and try again.</h2>\n";
		print	"<input type=submit value='Back to New User'>\n";
		print "</form>\n";
		exit();
}

// Insert the user into the database.
// Verify the email address...send an email to it to complete the registration process.

$query = "INSERT INTO	users
			(username, 
			 passwd, 
			 email, 
			 access_level_id)
		  VALUES('".$username."', 
				 '".md5($password)."', 
				 '".$email."',
				 '".$access_level."')";
$result = mysql_query($query) or die ("Error: Unable to create new user.");

$mail_to = $email;
$mail_headers = "From: Red Cross User Verification <verify@disaster.stjoe-redcross.org>";
$mail_subject = "New User Verification";
$mail_message = "Thank you for registering with the Disaster Response Website for the St. Joseph County Red Cross.\n\n";
$mail_message .= "Below you will find your user login.  A subsequent email will contain your temporary password.  ";
$mail_message .= "You will be able to change your password once you login to the disaster response site.";
$mail_message .= "\n\nUsername: ".$username."\n\n";
$mail_message .= "Thank you from the Disaster Response Team.";

if(mail($mail_to, $mail_subject, $mail_message, $mail_headers)) {
		$mail_message = "Thank you for registering with the Disaster Response Website for the St. Joseph County Red Cross.\n\n";
		$mail_message .= "Below you will find your password.  A previous email was sent that contains your username.  ";
		$mail_message .= "You will be able to change your password once you login to the disaster response site.";
		$mail_message .= "\n\nPassword: ".$password."\n\n";
		$mail_message .= "Thank you from the Disaster Response Team.";
		if(!mail($mail_to, $mail_subject, $mail_message, $mail_headers)) {
				print "<h3> There was an error sending the password to the user: ".$username." at email ".$email.".  
							Please contact them directly with their password or contact the site administrator for more help.</h3>\n";
		}
}
else {
	print "<center>\n";
	print "<h2> There was an error sending a verification email to  ".$email.".  Please inform the user of their information or contact the site administrator for more help.</h2>\n";
}


print "<center>\n";
print "<h2> An email has been sent to ".$email." for verification.  The new user will now be able to access the site.</h2>\n";

include ("./config/closedb.php"); 
include("html_include_3.php");
?>
<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// newuser2.php - Page to insert new user into database
//****************************
session_start(); //resume active session
if(($_SESSION['valid']) == "valid") { //if already logged in
	header( 'Location: ./home.php' ); //redirect to the homepage
}
if($_SESSION['access_level_id'] != 9) { //make sure user is admin
	header( 'Location: ./index.php' ); //redirect if not authorized
} 
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection to database
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - New User</title>"; //print page title
include("./html_include_2.php"); //rest of html header information

//Get the values from the previous page and verify that they are unique
//Then add a record to the users table with the input values

//Pick up POSTed variables from newuser.php
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

//check to see if username is already in use
$query = "SELECT	user_id
		  FROM		users
		  WHERE		username = '".$username."'
		  LIMIT		1";
$result = mysql_query($query) or die("Error in running the username query.");
$row = mysql_fetch_assoc($result);

if($row['user_id'] != '') { //user already exists
		print "<form name='invalid_username' method='post' action='newuser.php' align='left'>\n";
		print	"<center><h2>I'm sorry, but the username you entered already exists.  Please return to the New User page and try again.</h2>\n";
		print	"<input type=submit value='Back to New User'>\n";
		print "</form>\n";
		exit();
}

//Insert new user into database
$query = "INSERT INTO users
			(username, 
			 passwd, 
			 email, 
			 access_level_id)
		  VALUES('".$username."', 
				 '".md5($password)."', 
				 '".$email."',
				 '".$access_level."')";
$result = mysql_query($query) or die ("Error: Unable to create new user.");

//Prepare username email
$mail_to = $email;
	$mail_headers = "From: Red Cross User Verification <verify@disaster.stjoe-redcross.org>";
	$mail_subject = "New User Verification";
	$mail_message = "Thank you for registering with the Disaster Response Website for the St. Joseph County Red Cross.\n\n";
	$mail_message .= "Below you will find your user login.  A subsequent email will contain your temporary password.  ";
	$mail_message .= "You will be able to change your password once you login to the disaster response site.";
	$mail_message .= "\n\nUsername: ".$username."\n\n";
	$mail_message .= "Thank you from the Disaster Response Team.";

//Send email and prepare and send password email
if(mail($mail_to, $mail_subject, $mail_message, $mail_headers)) {
	$mail_message = "Thank you for registering with the Disaster Response Website for the St. Joseph County Red Cross.\n\n";
	$mail_message .= "Below you will find your password.  A previous email was sent that contains your username.  ";
	$mail_message .= "You will be able to change your password once you login to the disaster response site.";
	$mail_message .= "\n\nPassword: ".$password."\n\n";
	$mail_message .= "Thank you from the Disaster Response Team.";
	if(!mail($mail_to, $mail_subject, $mail_message, $mail_headers)) {
	print "<h3> There was an error sending the password to the user: ".$username." at email ".$email.".  
			Please contact them directly with their password '".$password."' or contact the site administrator for more help.</h3>\n";
	} //end if !mail
} //end if mail
else { //first mail message did not send
	print "<center>\n";
	print "<h2> There was an error sending a verification email to  ".$email.".  Please inform the user of their information (username: '".$username."' password: '".$password."' or contact the site administrator for more help.</h2>\n";
}

print "<center>\n";
print "<h2> An email has been sent to ".$email." for verification.  The new user will now be able to access the site.</h2>\n";

include("./config/closedb.php"); //close database connection
include("./html_include_3.php"); //close HTML tags
?>
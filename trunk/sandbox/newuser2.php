<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }
 // Make sure the user is an admin
 if($_SESSION['access_level_id'] != 9) {
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
// newuser2.php - File to add the new user to the database and send email verifications to the new user.
//
// Revision History:  Created - 02/04/09
//
//****************************

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include ("./config/functions.php");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Create a New User</title>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="resource-type" content="document">
<meta name="description" content="disaster.stjoe-redcross.org">
<meta name="keywords" content="">
<meta name="copyright" content="stjoe-redcross.org 2009.  All rights reserved.">
<link rel="shortcut icon" href="http://www.stjoe-redcross.org/favicon.ico">

<!-- <link rel="stylesheet" type="text/css" href="/custom.css"/> -->
 <STYLE type="text/css">
  SPAN { padding-left:3px; padding-right:3px }
  DIV.header{ margin:0; padding-bottom: 1px; color: white; background-color: #000000; border:none; font-weight:bold}
  BODY.main{ width: 744px; margin:0 auto; padding:0; background-color:#003366; color: #000000; border:outset}
  DIV.menu{ text-align: center; border-top:1px solid white; border-bottom:1px solid white; background-color:#000000; color:white; font-weight: bold}
  DIV.menu A:link { text-decoration: none; color:#FFFFFF; font-weight: bold }
  DIV.menu A:visited { text-decoration: none; color:#999999 }
  DIV.menu A:active { text-decoration: none; color:#666666 }
  DIV.menu A:hover { text-decoration: none; color:#FF0000 }
 </STYLE>


<body class="main">
<div style="border:2px solid white; background-color:#FFFFFF">
<div align="center" class="header">
<c>

<a href = "./home.php">
<img src="masthead.jpg" style="width:740px; height:100px" border="0"></a>
  			<p style="padding-bottom:1px; margin:0">
				American Red Cross, St. Joseph County Chapter
			</p>
			<p style="font-weight:normal; padding:0; margin: 0">
				<span>3220 East Jefferson Boulevard</span>
				<span>&nbsp;</span>
				<span>South Bend</span>
				<span>Indiana</span>
				<span>46615</span>
				<span>Phone (574) 234-0191</span>

			</p>
</c>
</div>
<div class="menu">
<a href = "./home.php"> HOME</a> | 
<a href = "./search.php"> SEARCH </a>
</div>

<? // 
   //Get the values from the previous page and verify that they are unique
   // Then add a record to the users table with the input values
   //

$username			= $_POST['username'];
$password			= $_POST['password'];
$verify_password	= $_POST['verify_pass'];
$email				= $_POST['email'];

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

// Passwords do not match, direct them back to the new user page.
if ($password != $verify_password) {

print "<form name='invalid_passwords' method='post' action='newuser.php' align='left'>\n";
print	"<center><h2>I'm sorry, but the passwords you entered did not match.  Please return to the New User page and try again.</h2>\n";
print	"<input type=submit value='Back to New User'>\n";
print "</form>\n";

}
else {

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
	
	$query = "INSERT INTO	users	(username, passwd, email, access_level_id)
			  VALUES		('".$username."', '".md5($password)."', '".$email."','".$access_level."')";
			  
	$result = mysql_query($query) or die ("Error: Unable to create new user.");
	
	$mail_to = $email;
	$mail_headers = "From: Red Cross User Verification <verify@disaster.stjoe-redcross.org>";
	$mail_subject = "New User Verification";
	$mail_message = "Thank you for registering with the Disaster Response Website for the St. Joseph County Red Cross.\n\n";
	$mail_message .= "Below you will find your user login.  A subsequent email will contain your temporary password.";
	$mail_message .= "You will be able to change your password once you login to the disaster response site.";
	$mail_message .= "\n\n\bUsername: ".$username."\n\n";
	$mail_message .= "Thank you from the Disaster Response Team.";
	
	if(mail($mail_to, $mail_subject, $mail_message, $mail_headers)) {
			$mail_message = "Thank you for registering with the Disaster Response Website for the St. Joseph County Red Cross.\n\n";
			$mail_message .= "Below you will find your password.  A previous email was sent that contains your username.";
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
		print "<h2 There was an error sending a verification email to  ".$email.".  Please inform the user of their information or contact the site administrator for more help.</h2>\n";
	}


	print "<center>\n";
	print "<h2 An email has been sent to ".$email." for verification.  The new user will now be able to access the site.</h2>\n";
		

}



include ("./config/closedb.php"); 
?>

</body>
</html>

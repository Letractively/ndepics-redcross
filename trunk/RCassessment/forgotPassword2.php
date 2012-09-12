<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// forgotPassword2.php - Send a password reset e-mail.
//************************************

session_start();

include("./config/functions.php");
include("./config/open_database.php");

// This is obtained from forgotPassword.php
$username = $_POST["username"];
$email = $_POST["email"];

// This randomly generates a password and hashes it using md5.
$password = createRandomPassword();
$passwordEncrypted = md5($password);

// This finds the correct user.
$query = "SELECT * FROM users WHERE username='$username' AND email='$email' ";
$result = mysql_query($query) or die(mysql_error());

// This changes the password with the randomly generated password and updates the database.
if(mysql_num_rows($result) > 0){
	$query2 = "UPDATE users SET password='$passwordEncrypted' WHERE username='$username' AND email='$email'";
	$result2 = mysql_query($query2) or die(mysql_error());

	// This sends the password reset e-mail.
	$mail_to = $email;
	$mail_subject = "Your New Password";
	$mail_message = "
	Your password to the Disaster Assessment Website for the St. Joseph County Red Cross has been reset to ".$password."
	Thank you from the Disaster Assessment Team.
	";
	$mail_message = wordwrap($mail_message, 70);
	$mail_header = "From: Red Cross User Verification <verify@disaster.stjoe-redcross.org>";
	mail($mail_to, $mail_subject, $mail_message, $mail_header);
	
	// This re-directs the user to the home page.
	header( 'Location: ./home.php' );
}
else{
	// This sets a error message and re-directs the user back to the forgotPassword.php
	$_SESSION["message"] = "Please enter a valid username and e-mail address.";
	header( 'Location: ./forgotPassword.php' );
}

include("./config/close_database.php");

?>
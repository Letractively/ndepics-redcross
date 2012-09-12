<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// changePassword2.php - This uses PHP to change the user's password.
//************************************

include("./config/check_login.php");
include("./config/functions.php");
include("./config/open_database.php");

// These variables are obtained from either the PHP session or changePassword.php
$username = $_SESSION["username"];
$currentPassword = $_POST["currentPassword"];
$newPassword1 = $_POST["newPassword1"];
$newPassword2 = $_POST["newPassword2"];

// This obtains information about the current user.
$query = "SELECT * FROM users WHERE username='$username'";
$result = mysql_query($query) or die(mysql_error());
$person = mysql_fetch_array($result);

// The crypto hash function being used is found in functions.php
$indivSalt = $person["salt"];
$currentPasswordEncrypted = hashPassword($currentPassword, $indivSalt);

// These variables are used to verify the current password and send a confirmation e-mail.
$verifyPasswordEncrypted = $person["password"];
$verifyEmail = $person["email"];

// The current password provided by the user and the password in the database does not match.
if($currentPasswordEncrypted != $verifyPasswordEncrypted){
	$_SESSION["message"] = "The password you gave is incorrect.";
	header( 'Location: ./changePassword.php' );
}
// The new passwords provided by the user does not match.
else if($newPassword1 != $newPassword2){
	$_SESSION["message"] = "The passwords do not match.";
	header( 'Location: ./changePassword.php' );
}
// The new passwords are too small.
else if(!isStrongPassword($newPassword1)){
	$_SESSION["message"] = "The new password has to be at least 8 characters, have an upper-case letter, lower-case letter, a digit, and a special character.";
	header( 'Location: ./changePassword.php' );
}
// The current password is correct and the new passwords matches.
else{
	// This changes the user's password in the database.
	$_SESSION["message"] = "";
	$newSalt = createRandomSalt();
	$newPasswordEncrypted = hashPassword($newPassword1, $newSalt);
	$query2 = "UPDATE users SET password='$newPasswordEncrypted', salt='$newSalt' WHERE username='$username'";
	$result2 = mysql_query($query2) or die(mysql_error());
	
	// This sends a verification e-mail.
	$mail_to = $verifyEmail;
	$mail_subject = "Password Changed";
	$mail_message = "
	Your password to the Disaster Assessment Website for the St. Joseph County Red Cross has been changed.
	Thank you from the Disaster Assessment Team.
	";
	$mail_message = wordwrap($mail_message, 70);
	$mail_header = "From: Red Cross User Verification <verify@disaster.stjoe-redcross.org>";
	
	// The verification e-mail failed to send.
	if(!(mail($mail_to, $mail_subject, $mail_message, $mail_header))){
		$_SESSION["message"] = "There was an error sending a change-of-password e-mail to  ".$email.".<br />";
		$_SESSION["message"] = $_SESSION["message"]."Please contact the site administrator for more help.<br />";
		header( 'Location: ./changePassword.php' );
	}
	
	// This re-directs the user to the home page.
	header( 'Location: ./home.php' );
}

include("./config/close_database.php");

?>
<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// changeProfile2.php - This uses PHP to change the user's profile.
//************************************

include("./config/check_login.php");
include("./config/functions.php");
include("./config/open_database.php");

// These variables are obtained from either the PHP session or changeProfile.php
$username = $_SESSION["username"];
$currentPassword = $_POST["password"];
$newEmail1 = $_POST["newEmail1"];
$newEmail2 = $_POST["newEmail2"];
$newCellPhone1 = $_POST["newCellPhone1"];
$newCellPhone2 = $_POST["newCellPhone2"];
$newCellCarrier1 = $_POST["newCellCarrier1"];

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
	header( 'Location: ./changeProfile.php' );
}
// The new e-mails provided by the user does not match.
else if($newEmail1 != $newEmail2){
	$_SESSION["message"] = "The e-mails does not match.";
	header( 'Location: ./changeProfile.php' );
}
// The new cell phone number provided by the user does not match.
else if($newCellPhone1 != $newCellPhone2){
	$_SESSION["message"] = "The cell phones does not match.";
	header( 'Location: ./changeProfile.php' );
}
// The current password is correct and the new information matches.
else{
	// This changes the user's e-mail in the database.
	$_SESSION["message"] = "";
	if($newEmail1 != ''){
		$query2 = "UPDATE users SET email='$newEmail1' WHERE username='$username'";
		$result2 = mysql_query($query2) or die(mysql_error());
	}
	// This changes the user's cell phone number in the database.
	if($newCellPhone1 != ''){
		$query3 = "UPDATE users SET cellPhone='$newCellPhone1' WHERE username='$username'";
		$result3 = mysql_query($query3) or die(mysql_error());
	}
	// This changes the user's cell carrier in the database.
	if($newCellCarrier1 != ''){
		$query4 = "UPDATE users SET cellCarrier='$newCellCarrier1' WHERE username='$username'";
		$result4 = mysql_query($query4) or die(mysql_error());
	}
	
	// This sends a verification e-mail.
	$mail_to = $verifyEmail;
	$mail_subject = "Profile Information Changed";
	$mail_message = "
	Your profile information for the Disaster Assessment Website for the St. Joseph County Red Cross has been changed.
	Thank you from the Disaster Assessment Team.
	";
	$mail_message = wordwrap($mail_message, 70);
	$mail_header = "From: Red Cross User Verification <verify@disaster.stjoe-redcross.org>";
	
	// The verification e-mail failed to send.
	if(!(mail($mail_to, $mail_subject, $mail_message, $mail_header))){
		$_SESSION["message"] = "There was an error sending a change-of-profile-information e-mail to  ".$email.".<br />";
		$_SESSION["message"] = $_SESSION["message"]."Please contact the site administrator for more help.<br />";
		header( 'Location: ./changeProfile.php' );
	}
	
	// This re-directs the user to the home page.
	header( 'Location: ./home.php' );
	
}
include("./config/close_database.php");

?>
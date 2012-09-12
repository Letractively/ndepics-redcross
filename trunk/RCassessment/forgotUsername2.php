<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// forgotUsername2.php - Send an username reminder e-mail.
//************************************

session_start();

include("./config/functions.php");
include("./config/open_database.php");

// This is obtained from forgotUsername.php
$email = $_POST["email"];

// This obtains information about the user from the database.
$query = "SELECT * FROM users WHERE email='$email' ";
$result = mysql_query($query) or die(mysql_error());
$person = mysql_fetch_array($result);

// This sends a reminder e-mail with the username.
if(mysql_num_rows($result) > 0){
	$mail_to = $email;
	$mail_subject = "Your Username";
	$mail_message = "
	Your username to the Disaster Assessment Website for the St. Joseph County Red Cross is ".$person['username']."
	Thank you from the Disaster Assessment Team.
	";
	$mail_message = wordwrap($mail_message, 70);
	$mail_header = "From: Red Cross User Verification <verify@disaster.stjoe-redcross.org>";
	mail($mail_to, $mail_subject, $mail_message, $mail_header);
	
	// This re-directs the user to the home page.
	header( 'Location: ./home.php' );
}
else{
	// This sets a error message and re-directs the user back to the forgotUsername.php
	$_SESSION["message"] = "Please enter a valid e-mail address.";
	header( 'Location: ./forgotUsername.php' );
}

include("./config/close_database.php");

?>
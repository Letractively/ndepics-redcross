<?php

//************************************
// Summer 2012: Henry Kim (hkim16@nd.edu)
// 
// createUser2.php - This uses PHP to create a new user.
//************************************

// This starts or resumes the PHP session.
session_start();

include("./config/functions.php");
include("./config/open_database.php");

// This assumes the user information is acceptable unless determined otherwise.
$userCreated = true;

// The username is obtained from createUser.php and is checked to see if it is acceptable.
$username = $_POST['username'];

if(strlen($username) == 0){
	$_SESSION["message"] = "Please enter an username.";
	header( 'Location: ./createUser.php' );
	$userCreated = false;
}

if(strlen($username) > 15){
	$_SESSION["message"] = "The username has to less than 15 characters";
	header( 'Location: ./createUser.php' );
	$userCreated = false;
}

if(!ctype_alnum($username)){
	$_SESSION["message"] = "The username has to be an alphanumeric string";
	header('Location:./createUser.php' );
	$userCreated = false;
}

// The email is obtained from createUser.php and is checked to see if it is acceptable.
$email = $_POST['email'];
if(strlen($email) == 0){
	$_SESSION["message"] = "Please enter an e-mail address.";
	header( 'Location: ./createUser.php' );
	$userCreated = false;
}

// The authority is obtained from createUser.php.
$authority = $_POST['authority'];

// The cell phone number and carrier are obtained from createUser.php.
$cellPhone = $_POST['cellPhone'];
$cellCarrier = $_POST['cellCarrier'];

// This checks whether the username already exists.
$query = "SELECT * FROM users WHERE username='$username'";
$result = mysql_query($query) or die(mysql_error()); 
if(mysql_num_rows($result) > 0){
	$_SESSION["message"] = "The user ".$username." already exists.<br />"."Please choose another username.";
	header( 'Location: ./createUser.php' );
	$userCreated = false;
}

// This checks whether the email already exists.
$query2 = "SELECT * FROM users WHERE email='$email'";
$result2 = mysql_query($query2) or die(mysql_error()); 
if(mysql_num_rows($result2) > 0){
	$_SESSION["message"] = "The e-mail ".$email." is already being used.<br />"."If you forgot your username or password, then go to the index page and click the relevant button(s).";
	header( 'Location: ./createUser.php' );
	$userCreated = false;
}

// This checks whether the cell phone number already exists.
if($cellPhone != ''){
	$query3 = "SELECT * FROM users WHERE cellPhone='$cellPhone'";
	$result3 = mysql_query($query3) or die(mysql_error()); 
	if(mysql_num_rows($result3) > 0){
		$_SESSION["message"] = "The cell phone number ".$cellphone." is already being used.<br />";
		header( 'Location: ./createUser.php' );
		$userCreated = false;
	}
}

// If the user's profile information meets the above requirements then the user is created.
if($userCreated){
	// These functions are defined in functions.php.
	$password = createRandomPassword();
	$salt = createRandomSalt();
	
	// The crypto hash function being used is found in functions.php
	$passwordEncrypted = hashPassword($password, $salt);
	
	// Insert the user into the database.
	$query2 = "INSERT INTO users(username,password,salt,email,cellPhone,cellCarrier,authority) VALUES ('$username', '$passwordEncrypted', '$salt', '$email', '$cellPhone', '$cellCarrier', '$authority')";
	$result2 = mysql_query($query2) or die(mysql_error());

	// Send an confirmation e-mail.
	$mail_to = $email;
	$mail_subject = "New User Verification";
	$mail_message = "
	Thank you for registering with the Disaster Assessment Website for the St. Joseph County Red Cross.
	Below you will find your username and temporary password information.  You will be able to change your password once you login to the disaster response site.
	Username: ".$username."
	Password: ".$password."
	Thank you from the Disaster Assessment Team.
	";
	$mail_message = wordwrap($mail_message, 70);
	$mail_header = "From: Red Cross User Verification <verify@disaster.stjoe-redcross.org>";
	if(!(mail($mail_to, $mail_subject, $mail_message, $mail_header))){
		$_SESSION["message"] = "There was an error sending a verification email to  ".$email.".<br />";
		$_SESSION["message"] = $_SESSION["message"]."Please inform the user of their information (username: '".$username."' password: '".$password."' or contact the site administrator for more help.<br />";
		header( 'Location: ./createUser.php' );
	}
	// This re-directs the user to the home page.
	header( 'Location: ./home.php' );
}
// The user's profile information does not meet the above requirement.
else{
	// This re-directs the user to createUser.php
	header( 'Location: ./createUser.php' );
}

include("./config/close_database.php");

?>
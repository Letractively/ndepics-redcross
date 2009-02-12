<?php

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: ND Epics Group
//	    Mike Ellerhorst
//
//  Spring 2009
//
// retrieveuserinfo2.php - Query the database and retrieve the requested information (either password or username)
//							and send it to the email address associated to the account.
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
<title>Forgotten User Information</title>
</head>

<?
$username = $_POST['username'];
$email = $_POST['email'];

if ($username) {
	$_POST['forgot'] = "password";
	$query = "	SELECT	user_id, email
				FROM	users
				WHERE	username = '".$username."' 
				LIMIT	1";
}
elseif ($email) { 
	$_POST['forgot'] = "username";
	$query = "	SELECT	user_id, username
				FROM	users
				WHERE	email = '".$email."' 
				LIMIT	1";
}

$result = mysql_query($query) or die( "Error executing user query");

$row = mysql_fetch_assoc($result);

print "User_id: ".$row['user_id']."<br>";
print "Username: ".$row['username']."<br>";
print "Email: ".$row['email']."<br>";



//
// Reset the user's password and send the new password to the accounts email address.
//

if($row['email'] != '') {

	$newpassword = createRandomPassword(); 

	$query = "	UPDATE	users
				SET		passwd = '".md5($newpassword)."'
				WHERE	user_id = '".$row['user_id']."' 
				LIMIT	1";

	$passresult = mysql_query($query) or die("Error: Query to change password failed");

	$mail_to = $row['email'];
	$mail_headers = "From: Red Cross Disaster Database <no-reply@disaster.stjoe-redcross.org>";
	$mail_subject = "Password Reset";
	$mail_message = "Your password has been successfully reset.  Below you will find your new password.  ";
	$mail_message .= "Please change this temporary password next time you login to the site.";
	$mail_message .= "\n\nTemporary Password: ".$newpassword."\n\n";
	$mail_message .= "Thank you from the Disaster Response Team.";
	
	mail($mail_to, $mail_subject, $mail_message, $mail_headers);


}
elseif($row['username'] != '') {

print "Got Here";
	$mail_to = $email;
	$mail_headers = "From: Red Cross Disaster Database <no-reply@disaster.stjoe-redcross.org>";
	$mail_subject = "Username Retrieved";
	$mail_message = "Below you will find the username that is associated with this email address.  ";
	$mail_message .= "If you have also forgotten your password, please follow the link to reset your password on the entry page.";
	$mail_message .= "\n\nUsername: ".$row['username']."\n\n";
	$mail_message .= "Thank you from the Disaster Response Team.";
	
	mail($mail_to, $mail_subject, $mail_message, $mail_headers);

}

?>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<? if($row['user_id'] == '') {
	print "<meta http-equiv=\"Refresh\" content=\"0.01; url=./retrieveuserinfo.php\">\n";
  }

?>
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

<?

if($row['user_id'] == '') {
	print "<center><h3> Invalid entry, you will be redirected back to the last page shortly...</h3>\n";
}
elseif ($_POST['forgot'] == "password") {
	print "<center><h3> Password has been Reset</h3>\n";
	print "An email has been sent to ".$row['email']." with a temporary password.  Please change your password on the \"Update User\" page next time you log in.\n";
}
elseif ($_POST['forgot'] == "username") {
	print "<center><h3> Username Retrieved</h3>\n";
	print "An email has been sent to ".$email." with your username.  If you have also forgotten your password, please follow the corresponding link on the entry page to reset your password after retrieving your username.\n";
}



include ("./config/closedb.php");
?>


</body>
</html>


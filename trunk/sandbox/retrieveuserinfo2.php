<?
include ("./config/dbconfig.php");
include ("./config/opendb.php");
include("config/functions.php");include("html_include_1.php");echo "<title>St. Joseph Red Cross - Retrieve User Information</title>";include("html_include_2.php");
$username = $_POST['username'];
$email = $_POST['email'];	
$username = scrub_input($username);
$email = scrub_input($email);

$errCount=0;
validator("Email",$email,"email");
if($messages[0])
{
  $errCount++;
  $email = "BLANK";
}
validator("Username",$username,"alphanumeric");
if($messages[0] || ($errCount == 1 && $messages[1]))
{
  $errCount++;
  $username = "BLANK";
}

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
else {
	$query = '';
}

$result = mysql_query($query) or die( "Error executing user query");

$row = mysql_fetch_assoc($result);

/*
 // * Used to DEBUG
 // *
print "User_id: ".$row['user_id']."<br>";
print "Username: ".$row['username']."<br>";
print "Email: ".$row['email']."<br>";
 // * 
 // * 
*/


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

	$mail_to = $email;
	$mail_headers = "From: Red Cross Disaster Database <no-reply@disaster.stjoe-redcross.org>";
	$mail_subject = "Username Retrieved";
	$mail_message = "Below you will find the username that is associated with this email address.  ";
	$mail_message .= "If you have also forgotten your password, please follow the link to reset your password on the entry page.";
	$mail_message .= "\n\nUsername: ".$row['username']."\n\n";
	$mail_message .= "Thank you from the Disaster Response Team.";
	
	mail($mail_to, $mail_subject, $mail_message, $mail_headers);

}

$url_error = '';

if($row['user_id'] == '') {
	if ($_POST['forgot'] == "password") {
		$url_error = "?bad=username";
	}
	elseif ($_POST['forgot'] == "username") {
		$url_error = "?bad=email";
	}
}



?>



<?if($row['user_id'] == '') {
	print "<meta http-equiv=\"Refresh\" content=\"1.0; url=./retrieveuserinfo.php".$url_error."\">\n";
}

if($row['user_id'] == '') {	print "<center><h3> Invalid entry, you will be redirected back to the last page shortly...</h3>\n";}
elseif ($_POST['forgot'] == "password") {	print "<center><h3> Password has been Reset</h3>\n";	print "An email has been sent to ".$row['email']." with a temporary password.  Please change your password on the \"Update User\" page next time you log in.\n";	print "<br><br>";}
elseif ($_POST['forgot'] == "username") {	print "<center><h3> Username Retrieved</h3>\n";	print "An email has been sent to ".$email." with your username.  If you have also forgotten your password, please follow the corresponding link on the entry page to reset your password after retrieving your username.\n";	print "<br><br>";}
include ("./config/closedb.php");include("html_include_3.php");
?>
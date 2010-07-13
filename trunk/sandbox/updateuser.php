<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross
// Spring 2009 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// updateuser.php - Page to make changes to user profile
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not loggin in
}
// Make sure the user is an admin
if($_SESSION['access_level_id'] != 9) {
	header( 'Location: ./index.php' ); //redirect if not authorized
} 
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - Update User</title>"; //print page title
include("./html_include_2.php"); //rest of html header information

//Form to list current registered users
$query = "SELECT	*
 			FROM	users
			WHERE	user_id = ".$_SESSION['user_id']."
			LIMIT	1";
$result = mysql_query($query) or die("Error: Query retrieving user info");
$row = mysql_fetch_assoc($result);
$username	= $row['username'];	
$email		= $row['email'];?>

<h3><? echo $username; ?>'s User Profile</h3>

<form name="updateuser" method="post" action="updateuser2.php">
	<table style="border: 1px solid black; padding: 5px">
		<tr>
		<td>Old Password</td>
		<td><input name="oldpassword" type="password" maxlength="15" align="left"> </td>
		</tr>
		
		<tr>
		<td>New Password</td>
		<td><input name="newpassword" type="password" maxlength="15" align="left"> </td>
		</tr>
		
		<tr>
		<td>Verify New Password</td>
		<td><input name="verify_pass" type="password" maxlength="15" align="left"> </td>
		</tr>

		<tr>
		<td>Email</td>
		<td><input name="email" type="text" maxlength="50" align="left" value="<? echo $email; ?>" > </td>
		</tr>
	</table>
	
	<input type=submit value="Update User">
	<input type=reset value="Clear Form">
</form>
<? 
include("config/closedb.php"); //close database connection
include("html_include_3.php"); //close HTML tags
?>

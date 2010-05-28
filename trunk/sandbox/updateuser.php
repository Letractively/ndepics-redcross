<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross
// Spring 2009 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// updateuser.php - Page to make changes to user profile
//****************************
session_start();
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Update User</title>";
include("html_include_2.php");

//Form to collect new user info
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
	<br>
	<input type=submit value="Update User">
	<input type=reset value="Clear Form">
</form>
<? 
include("config/closedb.php");
include("html_include_3.php"); 
?>

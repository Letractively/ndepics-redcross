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
//  Developed by ND Epics for St. Joe County Red Cross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Spring 2009
//
// deleteuser.php - admin only page that verifies that a user should be deleted;
//
// Revision History:  02/24/09 - Created
//
//****************************

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Delete User</title>";
echo "<script src=\"./javascript/selectorganization.js\"></script>";
include("html_include_2.php");

print "<center><h2>Select User to Change: </h2>";
print "<form name=\"select_user\" action=\"deleteuser2.php\" method=\"post\">\n";
print "<select name=\"user_id\" onchange=\"showUser(this.value)\">";
  
$query = "SELECT * FROM users WHERE user_id != ".$_SESSION['user_id'];

$result = mysql_query($query) or die("Could not get other users");

if( mysql_num_rows($result) < 1 )
{
	print "There are no other users in the database except you!<br>";
}
else 
{
	print "<option value=\"NULL\"> </option>";
	
	while( $row = mysql_fetch_assoc($result) )
	{
		$uid = $row['user_id'];
		$uname = $row['username'];
		print "<option value=\"".$uid."\">".$uname."</option>";
	}
}

print "</select>";

print "<p>";
print "<div align=\"center\" id=\"txtHint\"><b>User info will be listed here.</b></div>";
print "</p>";

print "Are you sure you want to delete this user?<br>";
print "	<input type=\"submit\" value=\"Delete User\">";

print "</form>";

include ("config/closedb.php");
include("html_include_3.php");
?>
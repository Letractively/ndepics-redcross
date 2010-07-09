<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// deleteuser.php - Page to select a user to delete
//****************************
session_start(); //resume current session
if(($_SESSION['valid']) != "valid") { //check for credentials
	header( 'Location: ./index.php' ); //redirect to index.php if not authorized
}
if($_SESSION['access_level_id'] != 9) { //ensure that user is an admin
        header( 'Location: ./index.php' ); //redirect if not authorized to manage users
} 

include ("./config/dbconfig.php");//database name and password
include ("./config/opendb.php");//connect to the database
include("config/functions.php");//import external functions
include("html_include_1.php");//Open HTML tags
echo "<title>St. Joseph Red Cross - Delete User</title>"; //print page title
echo "<script src=\"./javascript/selectuser.js\"></script>";
include("html_include_2.php");//print rest of HTML header

print "<h2>Select User to Change: </h2>";

//Build a select/dropdown form to pick a user
print "<form name=\"select_user\" action=\"deleteuser2.php\" method=\"post\">\n";
print "<select name=\"user_id\" onchange=\"showUser(this.value)\">";

//query the database for a list of other (not me) users
$query = "SELECT * 
			FROM users 
			WHERE user_id != ".$_SESSION['user_id'];
$result = mysql_query($query) or die("Could not get other users");

if( mysql_num_rows($result) < 1 ) {	//if current user is the only user
	print "There are no other users in the database except you!<br />";
} else { //list other registered users
	print "<option value=\"NULL\"> </option>";
	while( $row = mysql_fetch_assoc($result) ) { //print each user as an option
		$uid = $row['user_id'];
		$uname = $row['username'];
		print "<option value=\"".$uid."\">".$uname."</option>"; //set the value to the uid and print name
	}
}
print "</select>"; //end the select/dropdown box

//print the user information
print "<p>";
print "<div align=\"center\" id=\"txtHint\"><b>User info will be listed here.</b></div>";
print "</p>";

//Confirmation message and delete button
print "Are you sure you want to delete this user?<br />";
print "	<input type=\"submit\" value=\"Delete User\">";
print "</form>"; //end the form

include ("config/closedb.php"); //close database connection
include("html_include_3.php"); //close HTML tags
?>
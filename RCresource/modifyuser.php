<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// modifyuser.php - Page to select user to modify permissions
//****************************
session_start(); //resume active session
/*if(($_SESSION['valid']) == "valid") { //if already logged in
	header( 'Location: ./home.php' ); //redirect to the homepage
}*/
if($_SESSION['access_level_id'] != 9) { //make sure user is admin
	header( 'Location: ./index.php' ); //redirect if not authorized
} 
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection to database
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - Modify User</title>"; //print page title
include("./html_include_2.php"); //rest of html header information
echo "<h1>Modify User</h1>";

print "<center><h2>Select User to Change: </h2>";
print "<form name=\"select_user\" action=\"updateuseraccess.php\" method=\"post\">\n";
print "<select name=\"user_id\" onchange=\"showUser(this.value)\">";
  
$query = "SELECT * FROM users WHERE user_id != ".$_SESSION['user_id'];
$result = mysql_query($query) or die("Could not get other users");

if( mysql_num_rows($result) < 1 ) {
	print "There are no other users in the database except you!<br>";
}
else {
	print "<option value=\"NULL\"> </option>";
	
	while( $row = mysql_fetch_assoc($result) )
	{
		$uid = $row['user_id'];
		$uname = $row['username'];
		print "<option value=\"".$uid."\">".$uname."</option>";
	}
}

print "</select>";
print "<br>\n";
print "<p>";
print "<div align=\"center\" id=\"txtHint\"><b>User info will be listed here.</b></div>";
print "</p>";
print "	<input type=\"submit\" value=\"Change User Capabilities\">";
print "</form>";

include ("./config/closedb.php");
include("html_include_3.php");
?>

<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross
// Spring 2009 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// updateuseraccess.php - Page to submit changes to user permissions to database
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
echo "<title>St. Joseph Red Cross - Update User Access</title>"; //print page title
include("./html_include_2.php"); //rest of html header information

//Pick up POSTed variables from updateuseraccess.php
$redirect_url = "./home.php";
$user_id	= $_POST['user_id'];
$search		= $_POST['search'];
$insert		= $_POST['insert'];
$update		= $_POST['update'];
$delete		= $_POST['delete'];
$admin		= $_POST['admin'];

//Set the access level based on the the checkbox values
$access_level = 0;
if($admin == 1) {	$access_level = 9;	}
else {
	if ($search == 1) {
		if ($insert == 1) { $access_level += 4; }
		if ($update == 1) { $access_level += 1; }
		if ($delete == 1) { $access_level += 2; }

		// Only search allowed
		if ($access_level == 0) { $access_level = 10; }
	}
	else {
		// Only insert allowed
		if ($insert == 1) { $access_level = 8; }
		
	}
}

//Query to update database
$query = "UPDATE	users
		  SET		access_level_id = ".$access_level."
		  WHERE		user_id = ".$user_id."
		  LIMIT		1";
$result = mysql_query($query) or die("Error: ".mysql_error());
?>
<div align="center">
  <h1>Update Person</h1>
</div>
<?php

print "<center><h2>Success</h2></center>";

print "<div align='center'>";
print "<form action=\"./home.php\">\n";
print "<input type=\"submit\" value=\"Return Home\">";
print "</form>\n";

include ("config/closedb.php"); //close database connection
include("html_include_3.php"); //close HTML tags
?>
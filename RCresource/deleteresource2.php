<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// deleteresource2.php - Page to delete resource from database
//****************************
session_start(); //resumes active session
 if(($_SESSION['valid']) != "valid") { //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not logged in
}
if( ($_SESSION['access_level_id'] != 2) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 6) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)) { //ensure user has delete rights
 	header( 'Location: ./index.php' ); //redirect if not authorized
}
include ("config/dbconfig.php"); //database name and password
include ("config/opendb.php"); //open connection to database
include("config/functions.php"); //imports external functions
include("html_include_1.php"); //open HTML tags
echo "<title>St. Joseph Red Cross - Delete Resource</title>"; //print page title
include("html_include_2.php"); //rest of HTML header information
echo "<h1>Delete Resource</h1>";

//Pick up POSTed resource_id
$resource_id = $_POST['resource_id'];

//MAIN DELETE QUERY: Delete entry from Resource table
$query = "DELETE	
		  FROM		detailed_resource
		  WHERE		resource_id = ".$resource_id."
		  LIMIT		1";
$result = mysql_query($query) or die ("Deletion Query failed");

//Delete associations with organizations
$query = "DELETE
		  FROM		resource_listing
		  WHERE		resource_id = ".$resource_id;
$result = mysql_query($query) or die ("Deletion Query 2 failed");

//Delete associations with persons
$query = "DELETE
		  FROM		resource_person
		  WHERE		resource_id = ".$resource_id;
$result = mysql_query($query) or die ("Deletion Query 3 failed");

print "<center><h2>Resource Deleted Successfully</h2></center>";

print "<div align='center'>";
print "<form action=\"./home.php\">\n";
print "<button type=\"submit\">Return Home</button>";
print "</form>\n";
print "</div><br />";

include ("config/closedb.php"); //close connection to database
include("html_include_3.php"); //close HTML tags
?>
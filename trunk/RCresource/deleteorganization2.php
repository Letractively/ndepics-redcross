<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// deleteorganization2.php - Page to delete organization from database
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
echo "<title>St. Joseph Red Cross - Delete Organization</title>"; //print page title
include("html_include_2.php"); //rest of HTML header information
echo "<h1>Delete Organization</h1>";

//Pick up the POSTed organization_id
$organization_id = $_POST['organization_id'];

//MAIN DELETE QUERY: Delete organization from organization table
$query = "DELETE
			FROM	organization
			WHERE	organization_id = ".$organization_id."
			LIMIT	1";
$result = mysql_query($query) or die ("Deletion Query failed (organization)");

//Delete works_for relationships to persons
$query = "DELETE	
			FROM	works_for
			WHERE	organization_id = ".$organization_id;
$result = mysql_query($query) or die ("Deletion Query 2 failed (works_for)");

//Delete resource_listing relationships to resources
$query = "DELETE
			FROM		resource_listing
			WHERE		organization_id = ".$organization_id;
$result = mysql_query($query) or die ("Deletion Query 3 failed (resrouce_listing)");

//Delete Statement of Understanding files
$query = "DELETE
			FROM		statement_of_understanding
			WHERE		organization_id = ".$organization_id;
$result = mysql_query($query) or die ("Deletion Query 4 failed (SoU)");

//Delete Facility Survey files
$query = "DELETE
			FROM		facility_survey
			WHERE		organization_id = ".$organization_id;
$result = mysql_query($query) or die ("Deletion Query 5 failed (facility_survey) IGNORE THIS");

//Delete shelter_info listing
$query = "DELETE
			FROM	shelter_info
			WHERE	organization_id = ".$organization_id;
$result = mysql_query($query) or die ("Deletion Query 6 failed (shelter_info): Ignore if not shelter");

print "<center><h2>Organization Deleted Successfully</h2></center>";
print "<div align='center'>";
print "<form action=\"./home.php\">\n";
print "<button type=\"submit\">Return Home</button>";
print "</form>\n";
print "</div><br />";

include ("config/closedb.php"); //close connection to database
include("html_include_3.php"); //close HTML tags
?>
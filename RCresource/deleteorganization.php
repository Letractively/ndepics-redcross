<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// deleteorganization.php - Page to select an organization to delete from the database
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
echo "<h1>Confirm Deletion of Organization</h1>";

//Pick up organization_id
$organization_id = $_REQUEST['organization_id']; //get the organization id

//Query the database for organization information
$query = "SELECT	*
			FROM	organization
			WHERE	organization_id = ".$organization_id;
$result = mysql_query($query) or die ("query failed.  Query was: $query<br/>".mysql_error());
$row = mysql_fetch_assoc($result);

//Print out the name of the organization and confirmation message
print "Are you sure you want to delete the organization?<br />";
print "Name: ".$row['organization_name']."<br />";
print "<table align=center>";
print "<tr>";
print "<td>";
print "<form action=\"./deleteorganization2.php\" method=\"POST\" >";
print	"<input type=hidden name=organization_id value=".$organization_id.">";
print	"<input type=submit value='Delete Organization'>";
print "</form>";
print "</td>";
print "<td>";
print "<form>";
print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
print "</form>";
print "</td>";
print "</tr>";
print "</table>";
print "<br />";

include ("config/closedb.php"); //close database connection
include("html_include_3.php"); //close HTML tags
?>
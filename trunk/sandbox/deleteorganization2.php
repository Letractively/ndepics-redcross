<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// deleteorganization2.php - Page to delete organization from database
//****************************
session_start();
if(($_SESSION['valid']) != "valid"){
	header( 'Location: ./index.php' );
}
if( ($_SESSION['access_level_id'] != 2) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 6) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)){ 	
	header( 'Location: ./index.php' );
}

include ("config/dbconfig.php");
include ("config/opendb.php");
include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Delete Organization</title>";
echo "<script src=\"./javascript/selectorganization.js\"></script>";
include("html_include_2.php");

echo "<div align=\"center\">
  <h1>Delete Organization</h1>
</div>";

//Delete from Organization Table
$organization_id = $_POST['organization_id'];
$query = "DELETE
			FROM	organization
			WHERE	organization_id = ".$organization_id."
			LIMIT	1";
			
$result = mysql_query($query) or die ("Deletion Query failed");

//Delete works_for relationships to persons
$query = "DELETE	
			FROM	works_for
			WHERE	organization_id = ".$organization_id;
	  
$result = mysql_query($query) or die ("Deletion Query 2 failed");

//Delete resource_listing relationships to resources
$query = "DELETE
			FROM		resource_listing
			WHERE		organization_id = ".$organization_id;
			
$result = mysql_query($query) or die ("Deletion Query 3 failed");

//Delete Statement of Understanding files
$query = "DELETE
			FROM		statement_of_understanding
			WHERE		organization_id = ".$organization_id;
			
$result = mysql_query($query) or die ("Deletion Query 4 failed");

//Delete Facility Survey files
$query = "DELETE
			FROM		facility_survery
			WHERE		organization_id = ".$organization_id;
			
$result = mysql_query($query) or die ("Deletion Query 5 failed");

print "<center><h2>Organization Deleted Successfully</h2></center>";
print "<div align='center'>";
print "<form action=\"./home.php\">\n";
print "<button type=\"submit\">Return Home</button>";
print "</form>\n";
print "</div><br>";

include ("config/closedb.php");
include("html_include_3.php");
?>
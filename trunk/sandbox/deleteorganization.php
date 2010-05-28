<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// deleteorganization.php - Page to select an organization to delete from the database
//****************************
session_start();
 if(($_SESSION['valid']) != "valid") {
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
  <h1>Confirm Deletion of Organization</h1>
</div>";

$organization_id = $_REQUEST['organization_id'];

$query = "SELECT	*
			FROM	organization
			WHERE	organization_id = ".$organization_id;
$result = mysql_query($query) or die ("query failed.  Query was: $query<br/>".mysql_error());
$row = mysql_fetch_assoc($result);

print "Are you sure you want to delete the organization?<br>";
print "Name: ".$row['organization_name']."<br>";
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
print "<br>";

include ("config/closedb.php");
include("html_include_3.php");
?>
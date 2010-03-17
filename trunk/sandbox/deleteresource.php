<?php
session_start();
// Validate the users's session
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}
if( ($_SESSION['access_level_id'] != 2) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 6) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)){ 	header( 'Location: ./index.php' );} 
//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// deleteresource.php - file that verifies that a resource should be deleted;
//****************************
include ("config/dbconfig.php");
include ("config/opendb.php");include("config/functions.php");include("html_include_1.php");echo "<title>St. Joseph Red Cross - Delete Resource</title>";echo "<script src=\"./javascript/selectorganization.js\"></script>";include("html_include_2.php");
?>
<div align="center">
  <h1>Confirm Deletion of Resource</h1>
</div>
<?php
// Get and display the resource information$resource_id = $_POST['resource_id'];$query = "SELECT	*		  FROM		detailed_resource		  WHERE		resource_id = ".$resource_id;
$result = mysql_query($query) or die ("Resource Query failed");$row = mysql_fetch_assoc($result);print "Are you sure you want to delete the resource?<br>";print "Resource Type: ".$row['resource_type']."<br>";print "<table align=center>";print "<tr>";print "<td>";print "<form action=\"./deleteresource2.php\" method=\"POST\" >";print	"<input type=hidden name=resource_id value=".$resource_id.">";print	"<input type=submit value='Delete Resource'>";print "</form>";print "</td>";print "<td>";print "<form>";print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";print "</form>";print "</td>";print "</tr>";print "</table>";print "<br>";
include ("config/closedb.php");include("html_include_3.php");
?>
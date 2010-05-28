<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// deleteperson2.php - Page to delete person from database
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
echo "<title>St. Joseph Red Cross - Delete Person</title>";
echo "<script src=\"./javascript/selectorganization.js\"></script>";
include("html_include_2.php");
?>
<div align="center">
  <h1>Delete Person</h1>
</div>
<?
//Delete person from Person table
$person_id = $_POST['person_id'];
$query = "DELETE
			FROM		person
			WHERE		person_id = ".$person_id."		  
			LIMIT		1";
$result = mysql_query($query) or die ("Deletion Query failed");

//Delete associations to organizations
$query = "DELETE		  
			FROM		works_for
			WHERE		person_id = ".$person_id;
$result = mysql_query($query) or die ("Deletion Query 2 failed");

print "<center><h2>Person Deleted Successfully</h2></center>";
print "<div align='center'>";
print "<form action=\"./home.php\">\n";
print "<button type=\"submit\">Return Home</button>";
print "</form>\n";
print "</div><br>";

include ("config/closedb.php");
include("html_include_3.php");
?>
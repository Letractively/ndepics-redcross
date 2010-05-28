<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// deleteperson.php - Page to select a person to delete
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
echo "<title>St. Joseph Red Cross - Delete Person</title>";
echo "<script src=\"./javascript/selectorganization.js\"></script>";
include("html_include_2.php");
?>
<div align="center">  <h1>Confirm Deletion of Person</h1></div>
<?
// Get and display the person information
$person_id = $_POST['person_id'];
$query = "SELECT	*
			FROM		person
			WHERE		person_id = ".$person_id;
$result = mysql_query($query) or die ("Person Query failed");
$row = mysql_fetch_assoc($result);

print "Are you sure you want to delete the person?<br>";
print "Name: ".$row['salutation']." ".$row['first_name']." ".$row['last_name']."<br>";
print "<table align=center>";
print "<tr>";
print "<td>";
print "<form action=\"./deleteperson2.php\" method=\"POST\" >";
print	"<input type=hidden name=person_id value=".$person_id.">";
print	"<input type=submit value='Delete Person'>";
print "</form>";
print "</td>";
print "<td>";
print "<form>";
print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";print "</form>";
print "</td>";
print "</tr>";
print "</table>";
print "<br>";

include ("config/closedb.php");
include("html_include_3.php");
?>
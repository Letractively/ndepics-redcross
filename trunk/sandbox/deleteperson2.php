<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }

 if( ($_SESSION['access_level_id'] != 2) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 6) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)){
 	header( 'Location: ./index.php' );
 }

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// deleteperson2.php - deletes the designated person;
//****************************

include ("config/dbconfig.php");
include ("config/opendb.php");
include("config/functions.php");include("html_include_1.php");echo "<title>St. Joseph Red Cross - Delete Person</title>";echo "<script src=\"./javascript/selectorganization.js\"></script>";include("html_include_2.php");
?>
<div align="center">
  <h1>Delete Person</h1>
</div>
<?php
// Get and display the resource information$person_id = $_POST['person_id'];$query = "DELETE			  FROM		person		  WHERE		person_id = ".$person_id."		  LIMIT		1";
$result = mysql_query($query) or die ("Deletion Query failed");$query = "DELETE		  FROM		works_for		  WHERE		person_id = ".$person_id;
$result = mysql_query($query) or die ("Deletion Query 2 failed");print "<center><h2>Person Deleted Successfully</h2></center>";print "<div align='center'>";
print "<form action=\"./home.php\">\n";
print "<button type=\"submit\">Return Home</button>";
print "</form>\n";
print "</div><br>";
include ("config/closedb.php");include("html_include_3.php");
?>
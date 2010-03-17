<?php
session_start();
// Validate the users's session
if(($_SESSION['valid']) != "valid") {
  header( 'Location: ./index.php' );
 }

if( ($_SESSION['access_level_id'] < 1) || ($_SESSION['access_level_id'] > 10)){
  header( 'Location: ./index.php' );
 }

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Matt Mooney & Alyssa Krauss
//  Fall 2009
//
// resourcetoperson.php - method to associate resource with a person
//****************************

include ("./config/dbconfig.php");
include ("./config/opendb.php");


include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Resource-Person</title>";
include("html_include_2.php");

?>

<?
    $person_id = $_POST['person_id'];
    $resource_id = $_POST['resource_id'];
    print "<h3 align='center'>Table Updated</h3>";

    $query = "INSERT into resource_person (person_id,resource_id)
                VALUES (".$person_id.",".$resource_id.")";
    $result = mysql_query($query) or die ("Error adding resource to perosn");

    print "<div align='center'>";
    print "Association Successfully Added<br>";
    print "<form action=\"./home.php\" >\n";
    print "<button type=\"submit\">Return Home</button>";
    print "</form>\n";
    print "</div>";

include ("config/closedb.php");
include("html_include_3.php");
?>

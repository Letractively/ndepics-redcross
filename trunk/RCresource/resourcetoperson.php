<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Matt Mooney & Alyssa Krauss
// Summer 2010 - Matt Mooney
// resourcetoperson.php - This page is used to link a person with a resource
//****************************
session_start();
if(($_SESSION['valid']) != "valid") {
  header( 'Location: ./index.php' );
}

if( ($_SESSION['access_level_id'] < 1) || ($_SESSION['access_level_id'] > 10)){
  header( 'Location: ./index.php' );
}

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include("./config/functions.php");
include("./html_include_1.php");
echo "<title>St. Joseph Red Cross - Resource-Person</title>";
include("./html_include_2.php");

$person_id = $_POST['person_id'];


print "<h3 align='center'>Choose a resource to associate this person with</h3>";

print "Select a Resource: ";
 
$query = "Select * from detailed_resource ";
$query .= "ORDER BY resource_type";
 
$result = mysql_query($query) or die("Could not access resources");

if( mysql_num_rows($result) < 1 )
  {
    print "There are no resources to be added, please go back and add a resource first!<br>";
  }
else 
  {
    print "<form action='./resourcetoperson2.php' method='POST'>";
    print "<select name='resource_id' onchange='showResource(this.value)'>";
    print "<option value='NULL'> </option>";
    while( $row = mysql_fetch_assoc($result) )
      {
 	print "<option value='".$row['resource_id']."'>".$row['resource_type']."</option>";
      }
    print "</select>";
    print "<input type='hidden' name='person_id' value='".$person_id."'>";
    print "<input type='submit' value='Continue'>";
    print "</form>";
  }
include ("./config/closedb.php");
include("./html_include_3.php");
?>

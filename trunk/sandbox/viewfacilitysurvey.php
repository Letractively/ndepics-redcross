<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross
// Spring 2009 - Alyssa Krauss and Chris Durr
// Summer 2010 - Matt Mooney
// viewfacilitysurvey.php - Page to download stores FSs
//****************************
session_start();
 if(($_SESSION['valid']) != "valid") {
    header( 'Location: ./index.php' );
 }
include ("config/dbconfig.php");
include ("config/opendb.php");
include ("config/functions.php");

$organization_id = $_POST["organization_id"];
$queryid = "SELECT	filename,filetype,filesize,uploaded_report 
			FROM 	facility_survey 
			WHERE 	organization_id = ".$organization_id;
$result = mysql_query($queryid);// or die("Query Error: Could not retreive file from database.");
mysql_error();

list($name, $type, $size, $content) = mysql_fetch_array($result);
if($name != NULL)
{
  header("Content-length: $size");
  header("Content-type: $type");
  header("Content-Disposition: attachment; filename=$name");
  echo $content;
}
else
{
  print "No facility survey uploaded.\n";
}

include ("html_include_1.php");
echo "<title>St. Joseph Red Cross - FS</title>";
include ("html_include_2.php");
include ("config/closedb.php");
include("html_include_3.php");
?>
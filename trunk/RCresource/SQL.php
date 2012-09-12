<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// blank.php - This page is a template for pages on this site.
//****************************
session_start();
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }

//Additional Security Checks go HERE

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include("./config/functions.php");
include("./html_include_1.php");
echo "<title>St. Joseph Red Cross - Disaster Database</title>";
echo "<script src=\"./javascript/selectorganization.js\"></script>";
include("./html_include_2.php");

$q = "DESCRIBE organization";
$r = mysql_query($q);
print $r;
$x=0;
while($row = mysql_fetch_assoc($r)){
	print $row[1][0]; 
	$x++;
}
	print $row[2][1]; 
	$x++;
		print $row[3][2]; 
	$x++;
		print $row[4][0]; 
	$x++;
		print $row[5][0]; 
	$x++;

include("./config/closedb.php");
include("./html_include_3.php");
?>


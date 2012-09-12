<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// Summer 2012 - Henry Kim
// construction.php - This page is a template for pages on this site.
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
?>

<center>
	<h2> 
		This feature is currently under construction by the Notre Dame EPICS group.
		We apologise for the inconvenience. 
	</h2>
</center>

<?
include("./config/closedb.php");
include("./html_include_3.php");
?>
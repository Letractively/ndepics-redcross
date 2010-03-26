<?php
//THIS IS A BANK PAGE TO USE FOR DEVELOPMENT
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Disaster Database</title>";
echo "<script src=\"./javascript/selectorganization.js\"></script>";
include("html_include_2.php");

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// home.php - the main entry page for the Disaster Database;
//
// Revision History: 2/10/09	Mike Ellerhorst - Added "Create New User" button limited to admin users.

include("html_include_3.php");
?>


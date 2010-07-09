<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// blank.php - a blank file for making new pages!
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not loggin in
}
 
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection to database
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - PAGE TITLE</title>"; //print page title
include("./html_include_2.php"); //rest of html header information
echo "<h1>Page Title</h1>";

//************
//CONTENT HERE
//************

include("./config/closedb.php"); //closes connection to database
include("./html_include_3.php"); //close HTML tags
?>


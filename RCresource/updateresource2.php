<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross
// Spring 2009 - Mike Ellerhorst, Mark Pasquier & Bryan Winther
// Summer 2010 - Matt Mooney
// updateresource2.php - Page to submit changes to resource to database
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not loggin in
}
//Determine if user has update rights
if( ($_SESSION['access_level_id'] != 1) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 5) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)){
	header( 'Location: ./index.php' ); //redirect if not authorized
} 
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - Update Resource</title>"; //print page title
include("./html_include_2.php"); //rest of html header information

//Pick up POSTed variables from updateresource.php
$resource_id	= $_POST["resource_id"];
$resource_type	= $_POST["resource_type"];
$description	= $_POST["resource_description"];
$keyword		= $_POST["resource_keyword"];

//Query to update resource
$query = "UPDATE	detailed_resource 
		  SET		resource_type = \"".$resource_type."\" ,
					description = \"".$description."\" ,
					keyword = \"".$keyword."\" 
		  WHERE		resource_id = ".$resource_id."
		  LIMIT 1";
$result = mysql_query($query) or die ("Error sending resource update query");

//Update Log
$query = "SELECT log FROM detailed_resource WHERE resource_id = ".$resource_id;
$result = mysql_query($query) or die ("Resource Log Query failed");
$row = mysql_fetch_assoc($result);

//Get Date and Time and set log
$tempdate = date("m/d/Y H:i:s");
$query = "UPDATE 	detailed_resource 
			SET 	log = '" .$_SESSION['username']. ": " .$tempdate. "\n".$row['log']. "' 
			WHERE resource_id = ".$resource_id;
$result = mysql_query($query) or die ("Resource Log Update failed");

//Redirect back to the resources's information page
$redirect_url = "./resourceinfo.php?id=".$resource_id;

print "The resource record was updated successfully.  Click <a href=\"$redirect_url\">here</a> to continue.";

include ("config/closedb.php"); //close database connection
include("html_include_3.php"); //close HTML tags
?>
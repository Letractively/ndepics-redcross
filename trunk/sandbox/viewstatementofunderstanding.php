<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross
// Spring 2009 - Alyssa Krauss and Chris Durr
// Summer 2010 - Matt Mooney
// viewstatementofunderstanding.php - Page to download stores SOUs.
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not loggin in
}
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - View FS</title>"; //print page title
include("./html_include_2.php"); //rest of html header information

//Pick up POSTed variable from organizationinfo.php
$organization_id = $_POST["organization_id"];

//Query database for file (BLOLB
$queryid = "SELECT	filename,filetype,filesize,uploaded_contract 
			FROM	statement_of_understanding 
			WHERE	organization_id = ".$organization_id;
$result = mysql_query($queryid) or die("Query Error: Could not retreive file from database.");

//Store info
list($name, $type, $size, $content) = mysql_fetch_array($result);

//If file indeed exists, set download
if($name != NULL)
{
  header("Content-length: $size");
  header("Content-type: $type");
  header("Content-Disposition: attachment; filename=$name");
  echo $content;
}

print "If you were not prompted for a download, then no statement of understanding has been uploaded.\n";
include ("config/closedb.php"); //close database connection
include("html_include_3.php"); //close HTML tags
?>
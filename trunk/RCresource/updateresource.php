<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross
// Spring 2009 - Mike Ellerhorst, Mark Pasquier & Bryan Winther
// Summer 2010 - Matt Mooney
// updateresource.php - Page to make changed to a resource
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
?>
<div align="center">
  <h1>Update Resource</h1>
</div>

<?php
//Pick up the POSTed variable from resourceinfo.php
$resource_id = $_POST["resource_id"];

//Query database for resource info to pre-populate fields
$query = "SELECT	*
		  FROM		detailed_resource
		  WHERE		resource_id = ".$resource_id;
$result = mysql_query($query) or die ("Resource Query failed");
$row = mysql_fetch_assoc($result);

//Save values in variables
$resource_type	= $row['resource_type'];
$description	= $row['description'];
$keyword		= $row['keyword'];

print "<p align=center><b>Change the desired fields and press 'Update Resource'.</b></p>\n";
//Print update form with pre-populated fields
print "<center><form name='updateresource' method='post' action='updateresource2.php'>\n";
	print "<input name='resource_id' type='hidden' value='".$resource_id."'>\n";
	/*******/
	//  Provide input fields pre-populated with the existing values in the database
	print "<table>\n";
		print "<tr>\n";
		print "<td><b>Resource Type: </b></td>\n";
		print "<td><input name='resource_type' type='text' maxlength='30' align= 'left' value='".$resource_type."'></td>\n";
		print "</tr>\n";

		print "<tr>\n";
		print "<td><b>Description (maximum of 1000 characters): </b></td>\n";
		print "<td><textarea name='resource_description' rows=6 cols=40 align= 'left' valign='top'>".$description."</textarea></td>\n";
		print "</tr>\n";

		print "<tr>\n";
		print "<td><b>Keyword(s): </b></td>\n";
		print "<td><input name='resource_keyword' type='text' maxlength='50' align= 'left' value='".$keyword."'></td>\n";
		print "</tr>\n";
		
	print "</table>\n";

	print "<br />\n";
	
	print "<input type='submit' value='Update Resource'>\n";
print "</form></center>\n";


print "<br /><div align = 'center'>\n";
print "<form>\n";
print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">\n";
print "</form>\n";
print "<br /></div>\n";
print "</div>\n";

include ("config/closedb.php"); //close database connection
include("html_include_3.php"); //close HTML tags
?>
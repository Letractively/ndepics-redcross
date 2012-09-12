<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Summer 2010 - Matt Mooney
// shelter.php - This page is used to view/update additional shelter information
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not loggin in
}

include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - Shelter Information</title>"; //print page title
include("./html_include_2.php"); //rest of html header information

//Pick up POSTed variables from shelter.php
$size 		= mysql_escape_string($_POST['size']);
$capacity 	= mysql_escape_string($_POST['capacity']);
$date		= mysql_escape_string($_POST['year']."-".$_POST['month']."-".$_POST['day']);
$org_id		= $_POST['org_id'];
$type		= $_POST['type'];

//The type variable determins if we need to update a record in the shelter_info table
//or if we need to create a new row for the identified organization to store info
if($type == "update")
{
	//row exists, update based on organization id
	$query = "UPDATE 	shelter_info
				SET 	size = \"".$size."\" ,
						capacity = \"".$capacity."\",
						nat_entry_date = \"".$date."\"
				WHERE	organization_id = \"".$org_id."\"
				LIMIT	1";
	$result = mysql_query($query);// or die ("Error updating shelter info");
	mysql_error();
}
else if($type == "new")
{
	//create new record
	$query = 	"INSERT INTO shelter_info
						(organization_id ,
				 		size ,
				 		capacity ,
				 		nat_entry_date)
				VALUES	(\"".$org_id."\",
						 \"".$size."\",
						 \"".$capacity."\",
						 \"".$date."\")";
	$result = mysql_query($query);// or die ("Error adding shelter info");
	mysql_error();
}

//redirect back to the organization info page.
$redirect_url = "./organizationinfo.php?id=".$org_id."\"";
$message .= "Successful Update...redirecting<br />";
print "Successfull Update...redirecting to information page";
print "<meta http-equiv=\"Refresh\" content=\"1.0; url=".$redirect_url."\">";

include("./config/closedb.php"); //close database connection
include("./html_include_3.php"); //close HTML tags
?>


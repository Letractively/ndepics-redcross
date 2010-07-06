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
echo "<title>St. Joseph Red Cross - Shelter Information</title>";
include("./html_include_2.php");

$size 		= mysql_escape_string($_POST['size']);
$capacity 	= mysql_escape_string($_POST['capacity']);
$date		= mysql_escape_string($_POST['year']."-".$_POST['month']."-".$_POST['day']);
$org_id		= $_POST['org_id'];
$type		= $_POST['type'];

if($type == "update")
{
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


$redirect_url = "./organizationinfo.php?id=".$org_id."\"";
$message .= "Successful Update...redirecting<br>";
print "Successfull Update...redirecting to information page";
print "<meta http-equiv=\"Refresh\" content=\"1.0; url=".$redirect_url."\">";

include("./config/closedb.php");
include("./html_include_3.php");
?>


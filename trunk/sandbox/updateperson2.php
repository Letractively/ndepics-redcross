<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// updateperson2.php - Page to modify person in database
//****************************
session_start();
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}
if( ($_SESSION['access_level_id'] != 1) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 5) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)){
 	header( 'Location: ./index.php' );
}

include ("config/dbconfig.php");
include ("config/opendb.php");
include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Update Person</title>";
include("html_include_2.php");

$person_id		= $_POST['person_id'];
$salutation		= mysql_real_escape_string($_POST['salutation']);
$first_name		= mysql_real_escape_string($_POST['first_name']);
$last_name		= mysql_real_escape_string($_POST['last_name']);
$street_address         = mysql_real_escape_string($_POST['street_address']);
$city			= mysql_real_escape_string($_POST['city']);
$state			= mysql_real_escape_string($_POST['state']);
$zip			= mysql_real_escape_string($_POST['zip']);
$home_phone		= $_POST['home_phone_1'].$_POST['home_phone_2'].$_POST['home_phone_3'];
$work_phone		= $_POST['work_phone_1'].$_POST['work_phone_2'].$_POST['work_phone_3'];
$mobile_phone	        = $_POST['mobile_phone_1'].$_POST['mobile_phone_2'].$_POST['mobile_phone_3'];
$fax			= $_POST['fax'];
$email			= mysql_real_escape_string($_POST['email']);
$im			= mysql_real_escape_string($_POST['im']);
$additional_info        = mysql_real_escape_string($_POST['additional_info']);

$organization_id = $_POST["organization_id"];
$title_in_organization = mysql_real_escape_string($_POST["title_in_organization"]);
$role_in_organization = mysql_real_escape_string($_POST["role_in_organization"]);
$organizationremove_id = $_POST["organizationremove_id"];
$resource_id = $_POST['resource_id'];
$updated_by = $_POST['updated_by'];

//Query to update organization
$query = "UPDATE	person 
	  SET			salutation = \"".$salutation."\" ,
					first_name = \"".$first_name."\" ,
					last_name = \"".$last_name."\" ,
					street_address = \"".$street_address."\" ,
					city = \"".$city."\" ,
					state = \"".$state."\" ,
					zip = \"".$zip."\" ,
					home_phone = \"".$home_phone."\" ,
					work_phone = \"".$work_phone."\" ,
					mobile_phone = \"".$mobile_phone."\" ,
					fax = \"".$fax."\" ,
					email = \"".$email."\" ,
					im = \"".$im."\" ,
		            additional_info = \"".$additional_info."\" ,
   		 	        updated_by = \"".$updated_by."\" ,
					updated_time = NOW()
	   WHERE		person_id = ".$person_id."
	   LIMIT 1";
	   
$result = mysql_query($query) or die ("Error sending person update query");

if ($organization_id != "NULL") {
	// Query to link resource to the added organization
	$query = "INSERT INTO works_for (person_id, organization_id, title, role) 
			  VALUES (".$person_id.",".$organization_id.",\"".$title_in_organization."\",\"".$role_in_organization."\")";
			  
	$result = mysql_query($query) or die ("Error adding works_for");
}

if($organizationremove_id != "NULL") {
$query = "DELETE	
		  FROM		works_for 
		  WHERE		person_id = ".$person_id."
		  AND		organization_id = ".$organizationremove_id."";
		  
$result = mysql_query($query) or die ("Deletion Query failed, please retry.");
}

if($resource_id != "NULL"){
 $query = "INSERT into resource_person (person_id,resource_id)
                VALUES (".$person_id.",".$resource_id.")";
    $result = mysql_query($query) or die ("Error adding resource to perosn");
 }

//Update Log
$query = "SELECT log FROM person WHERE person_id = ".$person_id;
$result = mysql_query($query) or die ("Person Log Query failed");
$row = mysql_fetch_assoc($result);
$tempdate = date("m/d/Y H:i");
$query = "UPDATE person SET log = '".$tempdate.": ".$updated_by." authenticated as ".$_SESSION['username']."\n".$row['log']. "' WHERE person_id = ".$person_id;
$result = mysql_query($query) or die ("Person Log Update failed");


// Redirect back to the organization's information page
$redirect_url = "./personinfo.php?id=".$person_id;

print "This record was updated successfully.  Please click <a href=\"$redirect_url\">here</a>";
print "<div align='center'>";
print "<form action=\"./home.php\" >\n";
print "<button type=\"submit\">Return Home</button>";
print "</form>\n";
print "</div>";

include ("config/closedb.php");
include("html_include_3.php");
?>
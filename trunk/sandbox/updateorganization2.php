<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }
 if( ($_SESSION['access_level_id'] != 1) && ($_SESSION['access_level_id'] != 3) && ($_SESSION['access_level_id'] != 5) && ($_SESSION['access_level_id'] != 7) && ($_SESSION['access_level_id'] != 9)){
 	header( 'Location: ./index.php' );
 }

include ("config/dbconfig.php");
include ("config/opendb.php");
include("config/functions.php");include("html_include_1.php");echo "<title>St. Joseph Red Cross - Update Organization</title>";include("html_include_2.php");

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// updateorganization2.php - file to verify the modification to an organization in the disaster database
//****************************

//
// Get the variables from the previous page to be updated in database
$organization_id	= mysql_real_escape_string($_POST["organization_id"]);
$organization_name	= mysql_real_escape_string($_POST["organization_name"]);
$street_address		= mysql_real_escape_string($_POST["street_address"]);
$city			= mysql_real_escape_string($_POST["city"]);
$state			= mysql_real_escape_string($_POST["state"]);
$zip			= mysql_real_escape_string($_POST["zip"]);
$county			= mysql_real_escape_string($_POST["county"]);
$business_phone		= mysql_real_escape_string($_POST["bus_phone_1"]).mysql_real_escape_string($_POST["bus_phone_2"]).mysql_real_escape_string($_POST["bus_phone_3"]);
$business_phone2	= mysql_real_escape_string($_POST["bus2_phone_1"]).mysql_real_escape_string($_POST["bus2_phone_2"]).mysql_real_escape_string($_POST["bus2_phone_3"]);
$business_fax		= mysql_real_escape_string($_POST["bus_fax_1"]).mysql_real_escape_string($_POST["bus_fax_2"]).mysql_real_escape_string($_POST["bus_fax_3"]);
$email			= mysql_real_escape_string($_POST["email"]);
$website		= mysql_real_escape_string($_POST["website"]);
$additional_info        = mysql_real_escape_string($_POST['additional_info']);
$updated_by = $_POST['updated_by'];

$resource_id 		= mysql_real_escape_string($_POST["resource_id"]);
$resourceremove_id 	= mysql_real_escape_string($_POST["resourceremove_id"]);

//print $organization_name."<br>";
//print $street_address."<br>";
//print $city."<br>";
//print $state."<br>";
//print $zip."<br>";
//print $county."<br>";
//print $business_phone."<br>";
//print $business_fax."<br>";
//print $email."<br>";
//print $website."<br>";

//
//Query to update organization
$query = "UPDATE	organization 
	  		SET		organization_name = \"".$organization_name."\" ,
					street_address = \"".$street_address."\" ,
					city = \"".$city."\" ,
					state = \"".$state."\" ,
					zip = \"".$zip."\" ,
					county = \"".$county."\" ,
					business_phone = \"".$business_phone."\" ,
                    24_hour_phone = \"".$business_phone2."\" ,
					business_fax = \"".$business_fax."\" ,
					email = \"".$email."\" ,
					website = \"".$website."\" ,
                    additional_info = \"".$additional_info."\" ,
                    updated_by = \"".$updated_by."\" ,
					updated_time = NOW()
	  	WHERE		organization_id = ".$organization_id."
	  LIMIT 1";

$result = mysql_query($query) or die ("Error sending organization update query");

if($resource_id != "NULL") {
	$query = "INSERT INTO resource_listing (resource_id, organization_id) 
			  VALUES (".$resource_id.",".$organization_id.")";
			  
	$result = mysql_query($query) or die ("Error adding resource_listing");
}


if($resourceremove_id != "NULL") {
$query = "DELETE	
		  FROM		resource_listing 
		  WHERE		resource_id = ".$resourceremove_id."
		  AND		organization_id = ".$organization_id."";
		  
$result = mysql_query($query) or die ("Deletion Query failed, please retry.");
}


//Log Changes
$query = "SELECT log FROM organization WHERE organization_id = ".$organization_id;
$result = mysql_query($query) or die ("Failed to access Organization Log");
$row = mysql_fetch_assoc($result);
$tempdate = date("m/d/Y H:i");
$query = "UPDATE organization SET log = '".$tempdate.": ".$updated_by." authenticated as ".$_SESSION['username']."\n".$row['log']. "' WHERE organization_id = ".$organization_id;
$result = mysql_query($query) or die ("Organization Log Update failed");

// Redirect back to the organization's information page
$redirect_url = "./organizationinfo.php?id=".$organization_id;

?>
<div align="center">
  <h3>Updating Organization... Please click <a href="<? echo $redirect_url; ?>">here</a>.</h3>
</div>

<?
include ("config/closedb.php");include("html_include_3.php");
?>
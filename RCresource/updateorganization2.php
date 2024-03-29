<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2009 - Matt Mooney
// Summer 2010 - Matt Mooney
// Summer 2012 - Henry Kim
// updateorganization2.php - Page to make changes to organization in database
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
echo "<title>St. Joseph Red Cross - Update Organization</title>"; //print page title
include("./html_include_2.php"); //rest of html header information

//Pick up POSTed variables from updateorganization.php
$organization_id	= mysql_real_escape_string($_POST["organization_id"]);
$organization_name	= mysql_real_escape_string($_POST["organization_name"]);
$street_address		= mysql_real_escape_string($_POST["street_address"]);
$mailing_address	= mysql_real_escape_string($_POST["mailing_address"]);
$city				= mysql_real_escape_string($_POST["city"]);
$state				= mysql_real_escape_string($_POST["state"]);
$zip				= mysql_real_escape_string($_POST["zip"]);
$county				= mysql_real_escape_string($_POST["county"]);
$business_phone		= mysql_real_escape_string($_POST["bus_phone_1"]).mysql_real_escape_string($_POST["bus_phone_2"]).mysql_real_escape_string($_POST["bus_phone_3"]);
$business_phone2	= mysql_real_escape_string($_POST["bus_phone2_1"]).mysql_real_escape_string($_POST["bus_phone2_2"]).mysql_real_escape_string($_POST["bus_phone2_3"]);
$business_fax		= mysql_real_escape_string($_POST["bus_fax_1"]).mysql_real_escape_string($_POST["bus_fax_2"]).mysql_real_escape_string($_POST["bus_fax_3"]);
$email				= mysql_real_escape_string($_POST["email"]);
$website			= mysql_real_escape_string($_POST["website"]);
$additional_info    = mysql_real_escape_string($_POST['additional_info']);
$unit 				= $_POST['unit'];
$updated_by 		= mysql_real_escape_string($_POST['updated_by']);
$resource_id 		= mysql_real_escape_string($_POST["resource_id"]);
$resourceremove_id 	= mysql_real_escape_string($_POST["resourceremove_id"]);

//Set up $unit string
if(!is_string($unit)) {
	//explode unit array
	for ($i=0; $i<count($unit); $i++) { 
		if(empty($unit[$i])) 
			{unset($unit[$i]);}
	}
	//convert array to string
	$unit = implode (",", $unit); 
}//end if is_string

//Query to update organization
$query = "UPDATE	organization 
	  		SET		organization_name = \"".$organization_name."\" ,
					street_address = \"".$street_address."\" ,
					mailing_address = \"".$mailing_address."\" ,
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
					association = \"".$unit."\" ,
                    updated_by = \"".$updated_by."\" ,
					updated_time = NOW()
	  	WHERE		organization_id = ".$organization_id."
	  LIMIT 1";
$result = mysql_query($query) or die ("Error sending organization update query");

//Add the resource if one is specified
if($resource_id != "NULL") {
	$query = "INSERT INTO resource_listing (resource_id, organization_id) 
			  VALUES (".$resource_id.",".$organization_id.")";
	$result = mysql_query($query) or die ("Error adding resource_listing");
}

//Remove resource if one is specified
if($resourceremove_id != "NULL") {
$query = "DELETE	
		  FROM		resource_listing 
		  WHERE		resource_id = ".$resourceremove_id."
		  AND		organization_id = ".$organization_id."";
		  
$result = mysql_query($query) or die ("Deletion Query failed");
}

//Log Changes
$query = "SELECT log FROM organization WHERE organization_id = ".$organization_id;
$result = mysql_query($query) or die ("Failed to access Organization Log");
$row = mysql_fetch_assoc($result);
$tempdate = date("m/d/Y H:i");
$query = "UPDATE organization SET log = '".$tempdate.": ".$updated_by." authenticated as ".$_SESSION['username']."\n".$row['log']. "' WHERE organization_id = ".$organization_id;
$result = mysql_query($query) or die ("Organization Log Update failed");

// Redirect back to the organization's information page
$message .= "Successfully Updated Organization.<br /> Redirecting...<br />";
$redirect_url = "./organizationinfo.php?id=".$organization_id;

print $message;
print "<meta http-equiv=\"Refresh\" content=\"1.0; url=".$redirect_url."\">";

include ("config/closedb.php"); //close database connection
include("html_include_3.php"); //close HTML tags
?>
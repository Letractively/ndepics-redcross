<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// Summer 2012 - Henry Kim
// addorganization3.php - file to insert an organization into the disaster database
//****************************
session_start(); //resumes active session
if(($_SESSION['valid']) != "valid") {  //check for credentials
	header( 'Location: ./index.php' ); //redirect to index if not loggin in
}
if( !(($_SESSION['access_level_id'] > 3) && ($_SESSION['access_level_id'] < 10))){ //ensure user has "add" rights
	header( 'Location: ./index.php' ); //redirect if not authorized
}  
include("./config/dbconfig.php"); //database name and password
include("./config/opendb.php"); //opens connection
include("./config/functions.php"); //imports external functions
include("./html_include_1.php"); //open html tags
echo "<title>St. Joseph Red Cross - Organization Added</title>"; //print page title
include("html_include_2.php"); //rest of HTML header info
?>
<div align="center">
  <h1>Added Organization</h1>
</div>
<?
// Get the variables POSTed from addorganization2.php
$organization_name = $_POST["organization_name"];
$street_address = $_POST["street_address"];
$mailing_address = $_POST["mailing_address"];
$city = $_POST["city"];
$state = $_POST["state"];
$zip = $_POST["zip"];
$county = $_POST["county"];
$business_phone = $_POST["business_phone"];
$business_phone2 = $_POST["business_phone2"];
$business_fax = $_POST["business_fax"];
$email = $_POST["email"];
$website = $_POST["website"];
$addtl_info = $_POST["addtl_info"];
$unit = $_POST["unit"];
$nss_id = $_POST["nss_id"];
$resource_id = $_POST["resource_id"];

//Query to check if organization already exists
$org_query = "SELECT * FROM organization WHERE organization_name = '".$organization_name." ' ";
$result3 = mysql_query($org_query) or die ("Error checking if organization exists query");
$num_rows = mysql_num_rows($result3);
if ($num_rows != 0){
       print "<div align='center'><br />";
       print "Cannot Add Organization: \"<b>".$organization_name."</b>\" already exists <br /><br />";
       print "<form action=\"./home.php\" >\n";
       print "<button type=\"submit\">Return Home</button>";
       print "</form>\n";
       print "</div>";
       exit(-1);
}

// Get the next auto_increment value (organization id)
// We are not using the value, only peeking at it
// We are getting this value so we can redirect to the organizationinfo.php page using the correct GET variable
$query = "SHOW TABLE STATUS LIKE 'organization'";
$result = mysql_query($query) or die ("Error sending table status query");
$row = mysql_fetch_assoc($result);
$organization_id = $row['Auto_increment'];

$street_address_search = str_replace(" ","+",$street_address); 
$state_search = str_replace(" ","+",$state_search); 
$city_search = str_replace(" ","+",$city_search);

$search_url = 'http://maps.google.com/maps/api/geocode/json?address='.$street_address_search.'+'.$city_search.',+'.$state_search.'&sensor=false';


$geocode=file_get_contents($search_url);

$output= json_decode($geocode);

$lat = $output->results[0]->geometry->location->lat;
$longitude = $output->results[0]->geometry->location->lng;

//Query to add organization
$tempdate = date("m/d/Y H:i");
$query = "INSERT INTO  organization (organization_name ,
				     street_address ,
                     mailing_address ,
				     city ,
				     state ,
				     zip ,
				     county ,
                     lat ,
                     longitude ,
				     business_phone ,
                     24_hour_phone ,
				     business_fax ,
				     email ,
				     website ,
                     additional_info , 
					 association ,
					 nss_id ,
					 updated_time ,
                     log)
		 VALUES (\"".$organization_name."\",
                         \"".$street_address."\",
                         \"".$mailing_address."\",
                         \"".$city."\",
                         \"".$state."\",
                         \"".$zip."\",
                         \"".$county."\",
                         \"".$lat."\",
                         \"".$longitude."\",
                         \"".$business_phone."\",
                         \"".$business_phone2."\",
                         \"".$business_fax."\",
                         \"".$email."\",
                         \"".$website."\",
                         \"".$addtl_info."\",
						 \"".$unit."\",
						 \"".$nss_id."\",
						 NOW(),
                         \"".$tempdate.": authenticated as ".$_SESSION['username']."\n".$row['log']."\")";
 $result = mysql_query($query) or die("Error: Adding Organization");

//Set up re-direction
$redirect_url = "./organizationinfo.php?id=".$organization_id."\""; //set redirection_url by inserting GET value
print "Successfull add...redirecting to information page"; //print friendly message to user.

// Query to link resource to the added organization
if($resource_id != "NULL"){
	$query = "INSERT INTO resource_listing (resource_id, organization_id) 
			  VALUES (".$resource_id.",".$organization_id.")";
	$result = mysql_query($query) or die ("Error: Adding resource_listing");
} else {
	print "Organization Successfully Added With NO RESOURCES...Redirecting<br />";
}
print "<meta http-equiv=\"Refresh\" content=\"1.0; url=".$redirect_url."\">";
include ("config/closedb.php");
include("html_include_3.php");
?>

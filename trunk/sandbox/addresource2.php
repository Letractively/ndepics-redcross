<?php
//****************************
// Developed by Notre Dame EPICS for St. Joe County RedCross 
// Fall 2008 - Mike Ellerhorst & Mark Pasquier
// Summer 2010 - Matt Mooney
// addresource2.php - file to insert a resource into the disaster database
//****************************
session_start();
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}
if( !(($_SESSION['access_level_id'] > 3) && ($_SESSION['access_level_id'] < 10))){
	header( 'Location: ./index.php' );
} 

include("config/functions.php");
include("html_include_1.php");
echo "<title>St. Joseph Red Cross - Add Resource</title>";
echo "<script src=\"./javascript/selectorganization.js\"></script>";
include("html_include_2.php");

$addresfromorg = $_POST["addresfromorg"];

if($addresfromorg){
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
  $updated_by = $_POST["updated_by"];
 }

$resource_type = $_POST["resource_type"];
$resource_description = $_POST["resource_description"];
$resource_keyword = $_POST["resource_keyword"];


//
// Scrub the inputs
$resource_type = scrub_input($resource_type);
$resource_description = scrub_input($resource_description);
$resource_keyword = scrub_input($resource_keyword);

//
// Display them for the user to verify

print "<p align='center'><b>Please verify this information.  If anything is incorrect, press the back button to return to the input form.</b></p>";

print "<form name='verifyresource' method='post' action='addresource3.php' align='left'>";
print "<input type=hidden name='resource_type' value=\"".$resource_type."\">";
print "<input type=hidden name='resource_description' value=\"".$resource_description."\">";
print "<input type=hidden name='resource_keyword' value=\"".$resource_keyword."\">";

print "<table>";
	print "<tr>";
	print "<td width=120><b> Resource Type: </b></td>";
	print "<td>".$resource_type."</td>";
	print "</tr>";

	print "<tr>";
	print "<td valign=\"top\"><b>Description: </b></td>";
	print "<td width=620>".$resource_description."</td>";
	print "</tr>";

	print "<tr>";
	print "<td><b>Keywords: </b></td>";
	print "<td>".$resource_keyword."</td>";
	print "</tr>";
print "</table><br>";
print "<div align='center'>";
print "<input type=hidden name='addresfromorg' value=\"".$addresfromorg."\">";

if($addresfromorg){
print "<input type=hidden name='organization_name' value=\"".$organization_name."\">";
print "<input type=hidden name='street_address' value=\"".$street_address."\">";
print "<input type=hidden name='mailing_address' value=\"".$mailing_address."\">";
print "<input type=hidden name='city' value=\"".$city."\">";
print "<input type=hidden name='state' value=\"".$state."\">";
print "<input type=hidden name='zip' value=".$zip.">";
print "<input type=hidden name='county' value=\"".$county."\">";
print "<input type=hidden name='business_phone' value='".$business_phone."'>";
print "<input type=hidden name='business_phone2' value='".$business_phone2."'>";
print "<input type=hidden name='business_fax' value='".$business_fax."'>";
print "<input type=hidden name='email' value=\"".$email."\">";
print "<input type=hidden name='website' value=\"".$website."\">";
print "<input type=hidden name='addtl_info' value=\"".$addtl_info."\">";
print "<input type=hidden name='unit' value=\"".$unit."\">";
print "<input type=hidden name='updated_by' value=\"".$updated_by."\">";
}
print "<input type=submit value='Continue'>";
print "</div>";
print "</form>";

include("./config/closedb.php");
include("html_include_3.php");
?>
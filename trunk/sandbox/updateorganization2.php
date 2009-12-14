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
include_once ("config/functions.php");

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
                        updated_by = \"".$updated_by."\" 
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
$result = mysql_query($query) or die ("Organization Query failed");
$row = mysql_fetch_assoc($result);

$tempdate = date("m/d/Y H:i");
$query = "UPDATE organization SET log = '".$tempdate.": ".$updated_by." authenticated as ".$_SESSION['username']."\n".$row['log']. "' WHERE organization_id = ".$organization_id;
$result = mysql_query($query) or die ("Organization Log Update failed");

// Redirect back to the organization's information page
$redirect_url = "./organizationinfo.php?id=".$organization_id;

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Disaster Database - Organization Added</title>
<? print "<script type=\"text/javascript\">
			<!-- 
			function redirect(url) {
				window.location = \"".$redirect_url."\" 
			}
			//-->
			</script>"; ?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="resource-type" content="document">
<meta name="description" content="disaster.stjoe-redcross.org">
<meta name="keywords" content="">
<meta name="copyright" content="stjoe-redcross.org 2009.  All rights reserved.">
<link rel="shortcut icon" href="http://www.stjoe-redcross.org/favicon.ico">

<STYLE type="text/css">
 SPAN { padding-left:3px; padding-right:3px }
 DIV.header{ margin:0; padding-bottom: 1px; color: white; background-color: #000000; border:none; font-weight:bold}
 BODY.main{ width: 744px; margin:0 auto; padding:0; background-color:#003366; color: #000000; border:outset}
</STYLE>

</head>

<body class="main" onLoad="setTimeout('redirect()', 300)">
<div style="border:2px solid white; background-color:#FFFFFF">
<div align="center" class="header">
<img src="masthead.jpg" style="width:740px; height:100px">
  			<p style="padding-bottom:1px; margin:0">
				American Red Cross, St. Joseph County Chapter
			</p>
			<p style="font-weight:normal; padding:0; margin: 0">
				<span>3220 East Jefferson Boulevard</span>
				<span>&nbsp;</span>
				<span>South Bend</span>
				<span>Indiana</span>
				<span>46615</span>
				<span>Phone (574) 234-0191</span>

			</p>
</div>
<div align="center">
  <h3>Updating Organization... Please be patient, you will be redirected shortly.</h3>
</div>

<?
//print "<br> Got to the end of the script <br>";

print "<div align='center'>";
print "<form action=\"./home.php\" >\n";
print "<button type=\"submit\">Return Home</button>";
print "</form>\n";
print "</div>";

include ("config/closedb.php");
?>
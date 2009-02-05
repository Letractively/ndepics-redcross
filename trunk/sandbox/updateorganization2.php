<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }
 if( ($_SESSION['access_level_id'] != 7)){
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
$organization_id	= $_POST["organization_id"];
$organization_name	= $_POST["organization_name"];
$street_address		= $_POST["street_address"];
$city				= $_POST["city"];
$state				= $_POST["state"];
$zip				= $_POST["zip"];
$county				= $_POST["county"];
$business_phone		= $_POST["bus_phone_1"].$_POST["bus_phone_2"].$_POST["bus_phone_3"];
$business_fax		= $_POST["bus_fax_1"].$_POST["bus_fax_2"].$_POST["bus_fax_3"];
$email				= $_POST["email"];
$website			= $_POST["website"];


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
					business_fax = \"".$business_fax."\" ,
					email = \"".$email."\" ,
					website = \"".$website."\" 
		  WHERE		organization_id = ".$organization_id."
		  LIMIT 1";

$result = mysql_query($query) or die ("Error sending organization update query");

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
</head>



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


<body class="main" onLoad="setTimeout('redirect()', 300)">
<div style="border:2px solid white; background-color:#FFFFFF">
<div align="center" class="header">
<c>
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
</c>
</div>
<div align="center">
<c>
  <h3 align="center">Updating Organization... Please be patient, you will be redirected shortly.</h3>
</c>
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
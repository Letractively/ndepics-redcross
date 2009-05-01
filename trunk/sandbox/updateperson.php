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
include("config/functions.php");
 
// ****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst, Mark Pasquier, Bryan Winther, Matt Mooney
//  Spring 2009
//
// updateperson.php - file to update an existing person in the disaster database;
// ****************************
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Disaster Database - Update Person</title>

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

<body class="main">
<div style="border:2px solid white; background-color:#FFFFFF">

<iframe src ="homeframe.php" width="745px" height="175px" scrolling= "no" FRAMEBORDER="0">
  <h2 align="center">St. Joseph's County American Red Cross</h2>
  <p align="center">Your browser does not support iframes.</p>
  <div class="menu">
  <a href = "./home.php" target= "_parent"> HOME</a> | 
  <a href = "./search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>

<div align="center">
  <h1>Update Person</h1>
</div>

<?php

// Retrieve the requested organization's information
$person_id = $_POST["person_id"];
$query = "SELECT	*
		  FROM		person
		  WHERE		person_id = ".$person_id;
		  
$result = mysql_query($query) or die ("Person Query failed");

$row = mysql_fetch_assoc($result);

$salutation		= $row['salutation'];
$first_name		= $row['first_name'];
$last_name		= $row['last_name'];
$street_address = $row['street_address'];
$city			= $row['city'];
$state			= $row['state'];
$zip			= $row['zip'];
$home_phone		= $row['home_phone'];
$work_phone		= $row['work_phone'];
$mobile_phone	= $row['mobile_phone'];
$fax			= $row['fax'];
$email			= $row['email'];
$im				= $row['im'];


print "<p align=center><b>Change the desired fields and press 'Update Person'.</b></p>\n";

print "<center><form name='updateperson' method='post' action='updateperson2.php'>\n";

	print "<input name='person_id' type='hidden' value='".$person_id."'>\n";

	/*******/
	//  Provide input fields pre-populated with the existing values in the database
	print "<table>\n";
		print "<tr>\n";
		print "<td><b>Salutation (Mr., Mrs., etc.): </b></td>\n";
		print "<td><input name='salutation' type='text' size='10' maxlength='10' align= 'left' value=\"".$salutation."\"></td>\n";
		print "</tr>\n";
		
		print "<tr>\n";
		print "<td><b>First Name: </b></td>\n";
		print "<td><input name='first_name' type='text' maxlength='30' align= 'left' value=\"".$first_name."\"></td>\n";
		print "</tr>\n";
		
		print "<tr>\n";
		print "<td><b>Last Name: </b></td>\n";
		print "<td><input name='last_name' type='text' maxlength='30' align= 'left' value=\"".$last_name."\"></td>\n";
		print "</tr>\n";

		print "<tr>\n";
		print "<td><b>Street Address: </b></td>\n";
		print "<td><input name='street_address' type='text' size='30' maxlength='50' align= 'left' value=\"".$street_address."\"></td>\n";
		print "</tr>\n";

		print "<tr>\n";
		print "<td><b>City: </b></td>\n";
		print "<td><input name='city' type='text' size='30' maxlength='30' align= 'left' value=\"".$city."\"></td>\n";
		print "</tr>\n";
		
		print "<tr>\n";
		print "<td><b>State: </b></td>\n";
		print "<td><input name='state' type='text' size='2' maxlength='2' align= 'left' value=\"".$state."\"></td>\n";
		print "</tr>\n";
		
		print "<tr>\n";
		print "<td><b>Zip:</b></td>\n";
		print "<td><input name='zip' type='text' size='10' maxlength='10' align= 'left' value=\"".$zip."\"></td>\n";
		print "</tr>\n";
		
		print "<tr>\n";
		print "<td><b>Home Phone: </b></td>\n";
		print "<td>(<input name='home_phone_1' type='number' size='3' maxlength='3' align='left' value='".substr($home_phone,0,3)."'>)&nbsp\n";
		print "		<input name='home_phone_2' type='number' size='3' maxlength='3' align='left' value='".substr($home_phone,3,3)."'>&nbsp - &nbsp\n";
		print "		<input name='home_phone_3' type='number' size='4' maxlength='4' align='left' value='".substr($home_phone,6,4)."'>\n";
		print "</td>\n";
		print "</tr>\n";
		
		print "<tr>\n";
		print "<td><b>Work Phone: </b></td>\n";
		print "<td>(<input name='work_phone_1' type='number' size='3' maxlength='3' align='left' value='".substr($work_phone,0,3)."'>)&nbsp\n";
		print "		<input name='work_phone_2' type='number' size='3' maxlength='3' align='left' value='".substr($work_phone,3,3)."'>&nbsp - &nbsp\n";
		print "		<input name='work_phone_3' type='number' size='4' maxlength='4' align='left' value='".substr($work_phone,6,4)."'>\n";
		print "</td>\n";
		print "</tr>\n";
		
		print "<tr>\n";
		print "<td><b>Mobile Phone: </b></td>\n";
		print "<td>(<input name='mobile_phone_1' type='number' size='3' maxlength='3' align='left' value='".substr($mobile_phone,0,3)."'>)&nbsp\n";
		print "		<input name='mobile_phone_2' type='number' size='3' maxlength='3' align='left' value='".substr($mobile_phone,3,3)."'>&nbsp - &nbsp\n";
		print "		<input name='mobile_phone_3' type='number' size='4' maxlength='4' align='left' value='".substr($mobile_phone,6,4)."'>\n";
		print "</td>\n";
		print "</tr>\n";
		
		print "<tr>\n";
		print "<td><b>Fax: </b></td>\n";
		print "<td>(<input name='fax_1' type='number' size='3' maxlength='3' align='left' value='".substr($fax,0,3)."'>)&nbsp\n";
		print "		<input name='fax_2' type='number' size='3' maxlength='3' align='left' value='".substr($fax,3,3)."'>&nbsp - &nbsp\n";
		print "		<input name='fax_3' type='number' size='4' maxlength='4' align='left' value='".substr($fax,6,4)."'>\n";
		print "</td>\n";
		print "</tr>\n";
		
		print "<tr>\n";
		print "<td><b>Email: </b></td>\n";
		print "<td><input name='email' type='text' maxlength='50' align= 'left' value=\"".$email."\"></td>\n";
		print "</tr>\n";
		
		print "<tr>\n";
		print "<td><b>IM: </b></td>\n";
		print "<td><input name='im' type='text' size='30' maxlength='30' align= 'left' value=\"".$im."\"></td>\n";
		print "</tr>\n";
		
	print "</table>\n";

	print "<br>\n";
	
	print "<b>Add this person to an organization:</b><br><br>";

print "<table>";
print "<tr>";
print "<td>Title in Organization: </td>";
print "<td><input type='text' name='title_in_organization' maxsize='30'> (e.g. 'Pastor')</td>";
print "</table>";

print "<p>";
print "Select the role of this person ";
print "<select name=\"role_in_organization\">";
print	"<option value=\"volunteer\">Volunteer with organization</option>";
print	"<option value=\"open\">Open the facility</option>";
print	"<option value=\"authorize\">Authorize the opening of the facility</option>";
print	"<option value=\"contact\">Main Organization Contact</option>";
print "</select>";
print "<p>";

print "Select an Organization to link this person to: ";
print "<select name=\"organization_id\" onchange=\"showOrganization(this.value)\">";
  
$query = "SELECT	o.* 
			FROM		organization o
			WHERE		NOT EXISTS (
							SELECT  wf.*
							FROM    works_for wf 
							WHERE	wf.organization_id = o.organization_id
							AND		wf.person_id = ".$person_id.")";
$query .= "ORDER BY o.organization_name";

$result = mysql_query($query) or die("Could not access resources");

if( mysql_num_rows($result) < 1 )
{
	print "There are no resources to be added, please go back and add an organization first!<br>";
}
else 
{
	print "<option value=\"NULL\"> </option>";
	
	while( $row = mysql_fetch_assoc($result) )
	{
		print "<option value=\"".$row['organization_id']."\">".$row['organization_name']."</option>";
	}
}
print "</select>";

print "<p>";

print "<b>Remove this person from an organization:</b><br><br>";
print "<select name=\"organizationremove_id\" onchange=\"showOrganization(this.value)\">";
  
$query = "SELECT	o.* 
			FROM		organization o
			WHERE		EXISTS (
							SELECT  wf.*
							FROM    works_for wf 
							WHERE	wf.organization_id = o.organization_id
							AND		wf.person_id = ".$person_id.")";
$query .= "ORDER BY o.organization_name";

$result = mysql_query($query) or die("Could not access resources");
	print "<option value=\"NULL\"> </option>";
	
	while( $row = mysql_fetch_assoc($result) )
	{
		print "<option value=\"".$row['organization_id']."\">".$row['organization_name']."</option>";
	}
print "</select>";

print "<br><br><input type='submit' value='Update Person'>\n";
print "</form></center>\n";


print "<br><div align = 'center'>\n";
print "<form>\n";
print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">\n";
print "</form>\n";
print "<br></div>\n";
print "</div>\n";

print "</div>\n";
print "</body>\n";
print "</html>\n";


include ("config/closedb.php");
?>

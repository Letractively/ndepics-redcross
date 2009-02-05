<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include("./config/functions.php");


//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// addorganization2.php - file to insert an organization into the disaster database;
//****************************
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Disaster Database - Add Person</title>
<script src="./javascript/selectorganization.js"></script>
</head>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="resource-type" content="document">
<meta name="description" content="disaster.stjoe-redcross.org">
<meta name="keywords" content="">
<meta name="copyright" content="stjoe-redcross.org 2008.  All rights reserved.">
<link rel="shortcut icon" href="http://www.stjoe-redcross.org/favicon.ico">

 <STYLE type="text/css">
  SPAN { padding-left:3px; padding-right:3px }
  DIV.header{ margin:0; padding-bottom: 1px; color: white; background-color: #000000; border:none; font-weight:bold}
  BODY.main{ width: 744px; margin:0 auto; padding:0; background-color:#003366; color: #000000; border:outset}
 </STYLE>


<body class="main">
<div style="border:2px solid white; background-color:#FFFFFF">

<iframe src ="homeframe.php" width="745px" height="175px" scrolling= "no" FRAMEBORDER="0">
  <h2 align="center">St. Joseph's County American Red Cross</h2>
  <p align="center">Your browser does not support iframes.</p>
  <div class="menu">
  <a href = "http://disaster.stjoe-redcross.org/sandbox/home.php" target= "_parent"> HOME</a> | 
  <a href = "http://disaster.stjoe-redcross.org/sandbox/search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>

<div align="center">
<c>
  <h1 align="center">Add Person</h1>
<form>
<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
</form>
</c>
</div>

<?php

$salutation = $_POST["salutation"];
$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$street_address = $_POST["street_address"];
$city = $_POST["city"];
$state = $_POST["state"];
$zip = $_POST["zip"];
$home_phone = $_POST["home_phone_1"].$_POST["home_phone_2"].$_POST["home_phone_3"];
$work_phone = $_POST["work_phone_1"].$_POST["work_phone_2"].$_POST["work_phone_3"];
$mobile_phone = $_POST["mobile_phone_1"].$_POST["mobile_phone_2"].$_POST["mobile_phone_3"];
$fax = $_POST["fax_1"].$_POST["fax_2"].$_POST["fax_3"];
$email = $_POST["email"];
$im = $_POST["im"];



// Scrub the inputs
$salutation = scrub_input($salutation);
$first_name = scrub_input($first_name);
$last_name = scrub_input($last_name);
$street_address = scrub_input($street_address);
$city = scrub_input($city);
$state = scrub_input($state);
$email = scrub_input($email);
$im = scrub_input($im);



// Display them for the user to verify

print "<p align='center'><b>Please verify this information.  If anything is incorrect, press the back button to return to the input form.</b></p>";

print "<table>";
	print "<tr>";
	print "<td><b>Salutation: </b></td>";
	print "<td>".$salutation."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>First Name: </b></td>";
	print "<td>".$first_name."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Last Name: </b></td>";
	print "<td>".$last_name."</td>";
	print "</tr>";

	print "<tr>";
	print "<td><b>Street Address: </b></td>";
	print "<td>".$street_address."</td>";
	print "</tr>";

	print "<tr>";
	print "<td><b>City: </b></td>";
	print "<td>".$city."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>State: </b></td>";
	print "<td>".$state."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Zip: </b></td>";
	print "<td>".$zip."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Home Phone: </b></td>";
	print "<td>";
	echo print_phone($home_phone);
	print "</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Work Phone: </b></td>";
	print "<td>";
	echo print_phone($work_phone);
	print "</td>";
	print "</tr>";
	
	//print "<tr>";
	//print "<td>Work Phone</td>";
	//print "<td>";
	//echo print_phone($work_phone);
	//print "</td>";
	//print "</tr>";
	
	print "<tr>";
	print "<td><b>Fax: </b></td>";
	print "<td>";
	echo print_phone($fax);
	print "</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>Email: </b></td>";
	print "<td>".$email."</td>";
	print "</tr>";
	
	print "<tr>";
	print "<td><b>IM: </b></td>";
	print "<td>".$im."</td>";
	print "</tr>";
	
print "</table>";

print "<br><br>";


print "<form name='verifyperson' method='post' action='addperson3.php' align='left'>";
print "<input type=hidden name='salutation' value=\"".$salutation."\">";
print "<input type=hidden name='first_name' value=\"".$first_name."\">";
print "<input type=hidden name='last_name' value=\"".$last_name."\">";
print "<input type=hidden name='street_address' value=\"".$street_address."\">";
print "<input type=hidden name='city' value=\"".$city."\">";
print "<input type=hidden name='state' value=\"".$state."\">";
print "<input type=hidden name='zip' value=".$zip.">";
print "<input type=hidden name='home_phone' value=".$home_phone.">";
print "<input type=hidden name='work_phone' value=".$work_phone.">";
print "<input type=hidden name='fax' value=".$fax.">";
print "<input type=hidden name='email' value=\"".$email."\">";
print "<input type=hidden name='im' value=\"".$im."\">";

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
print "</select>";
print "<p>";

print "Select an Organization to link this person to: ";
print "<select name=\"organization_id\" onchange=\"showOrganization(this.value)\">";
  
$query = "SELECT * FROM organization";

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

print "&nbsp&nbsp<input type=submit value='Add Person'>";
print "</form>";

print "<p>";
print "<div id=\"txtHint\"><b>Organization info will be listed here.</b></div>";
print "</p>";

print "<br><div align = 'center'>";
print "<form>";
print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
print "</form>";
print "<br></div>";


print "</body>";
print "</html>";



include ("config/closedb.php");
?>

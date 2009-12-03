<?php
session_start();
// Validate the users's session
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}

if( !(($_SESSION['access_level_id'] > 3) && ($_SESSION['access_level_id'] < 10))){
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
 
</head>

<body class="main">
<div style="border:2px solid white; background-color:#FFFFFF">

<iframe src ="homeframe.php" width="745px" height="175px" scrolling= "no" FRAMEBORDER="0">
  <h2 align="center">St. Joseph\'s County American Red Cross</h2>
  <p align="center">Your browser does not support iframes.</p>
  <div class="menu">
  <a href = "./home.php" target= "_parent"> HOME</a> | 
  <a href = "./search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>

<div align="center">
	<h1>Add Person</h1>
</div>

<?php

//print"<center><b>WARNING: PHP ERROR REPORTING IS ACTIVE FOR DEVELOPMENT!</b></center>";
//error_reporting(E_ALL);
//ini_set ('display_errors', '1');


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
$info = $_POST["info"];
$updated_by = $_POST["updated_by"];
$form_filled = $_POST["form_filled"];
$form_valid = $_POST["form_valid"];

// Scrub the inputs
$salutation = scrub_input($salutation);
$first_name = scrub_input($first_name);
$last_name = scrub_input($last_name);
$street_address = scrub_input($street_address);
$city = scrub_input($city);
$state = scrub_input($state);
$email = scrub_input($email);
$im = scrub_input($im);
$updated_by = scrub_input($updated_by);
$info = scrub_input($info);

print "<form name='finishperson' method='post' action='./addperson3.php' align='left'>";

print "<table>";
//Salutation
  print "<input type=hidden name='salutation' value=\"".$salutation."\">";
  print"<tr>\n";
  print"<td><b>Salutation: </b></td>\n";
  print"<td>".$salutation."</td>\n";
  print"</tr>\n";

//Fisrt Name
  print "<input type=hidden name='first_name' value=\"".$first_name."\">";
  print"<tr>\n";
  print"<td><b>First Name: </b></td>\n";
  print"<td>".$first_name."</td>\n";
  print"</tr>\n";

//Last Name
  print "<input type=hidden name='last_name' value=\"".$last_name."\">";
  print"<tr>\n";
  print"<td><b>Last Name: </b></td>\n";
  print"<td>".$last_name."</td>\n";
  print"</tr>\n";

//Street Address
  print "<input type=hidden name='street_address' value=\"".$street_address."\">";
  print"<tr>\n";
  print"<td><b>Street Address: </b></td>\n";
  print"<td>".$street_address."</td>\n";
  print"</tr>\n";

//City
  print "<input type=hidden name='city' value=\"".$city."\">";
  print"<tr>\n";
  print"<td><b>City: </b></td>\n";
  print"<td>".$city."</td>\n";
  print"</tr>\n";

//State
  print "<input type=hidden name='state' value=\"".$state."\">";
  print"<tr>\n";
  print"<td><b>State: </b></td>\n";
  print"<td>".$state."</td>\n";
  print"</tr>\n";

//Zip
  print "<input type=hidden name='zip' value=".$zip.">";
  print"<tr>\n";
  print"<td><b>Zip: </b></td>\n";
  print"<td>".$zip."</td>\n";
  print"</tr>\n";

//Phone Numbers
  print "<input type=hidden name='home_phone_1' value='".substr($home_phone,0,3)."'>";
  print "<input type=hidden name='home_phone_2' value='".substr($home_phone,3,3)."'>";
  print "<input type=hidden name='home_phone_3' value='".substr($home_phone,6,4)."'>";
  print"<tr>\n";
  print"<td><b>Home Phone: </b></td>\n";
  print"<td>".substr($home_phone,0,3)."-".substr($home_phone,3,3)."-".substr($home_phone,6,4)."</td>\n";
  print"</tr>\n";

  print "<input type=hidden name='work_phone_1' value='".substr($work_phone,0,3)."'>";
  print "<input type=hidden name='work_phone_2' value='".substr($work_phone,3,3)."'>";
  print "<input type=hidden name='work_phone_3' value='".substr($work_phone,6,4)."'>";
  print"<tr>\n";
  print"<td><b>Work Phone: </b></td>\n";
  print"<td>".substr($work_phone,0,3)."-".substr($work_phone,3,3)."-".substr($work_phone,6,4)."</td>\n";
  print"</tr>\n";

  print "<input type=hidden name='mobile_phone_1' value='".substr($mobile_phone,0,3)."'>";
  print "<input type=hidden name='mobile_phone_2' value='".substr($mobile_phone,3,3)."'>";
  print "<input type=hidden name='mobile_phone_3' value='".substr($mobile_phone,6,4)."'>";
  print"<tr>\n";
  print"<td><b>Mobile Phone: </b></td>\n";
  print"<td>".substr($mobile_phone,0,3)."-".substr($mobile_phone,3,3)."-".substr($mobile_phone,6,4)."</td>\n";
  print"</tr>\n";

  print "<input type=hidden name='fax_1' value='".substr($fax,0,3)."'>";
  print "<input type=hidden name='fax_2' value='".substr($fax,3,3)."'>";
  print "<input type=hidden name='fax_3' value='".substr($fax,6,4)."'>";
  print"<tr>\n";
  print"<td><b>Fax: </b></td>\n";
  print"<td>".substr($fax,0,3)."-".substr($fax,3,3)."-".substr($fax,6,4)."</td>\n";
  print"</tr>\n";

//Email
  print "<input type=hidden name='email' value=\"".$email."\">";
  print"<tr>\n";
  print"<td><b>Email: </b></td>\n";
  print"<td>".$email."</td>\n";
  print"</tr>\n";

//IM
  print "<input type=hidden name='im' value=\"".$im."\">";
  print"<tr>\n";
  print"<td><b>IM: </b></td>\n";
  print"<td>".$im."</td>\n";
  print"</tr>\n";

//Info
  print "<input type=hidden name='info' value=\"".$info."\">";
  print"<tr>\n";
  print"<td><b>Additional Info: </b></td>\n";
  print"<td>".$info."</td>\n";
  print"</tr>\n";

  //Initials
  print "<tr>";
  print "<td><b>Your Initials</b></td>";
  print "<td>".$updated_by."</td>";
  print "</tr>";

print "</table>\n";

print "<br><br>";


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
  
  $query = "SELECT * FROM organization ";
  $query .= "ORDER BY organization_name";

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
print "</form>";
print "<br></div>";

print "</body>";
print "</html>";

include ("config/closedb.php");

?>

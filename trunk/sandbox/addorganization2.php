<?php
//print"<center><b>WARNING: PHP ERROR REPORTING IS ACTIVE FOR DEVELOPMENT!</b></center>";
error_reporting(E_ALL);
ini_set ('display_errors', '1');
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
<title>Disaster Database - Add Organization</title>
<script src="./javascript/selectresource.js"></script>

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

<div style="border:2px solid white; background-color:#FFFFFF" align="center">
<iframe src ="homeframe.php" width="745px" height="175px" scrolling= "no" FRAMEBORDER="0">
	<center>
  	<h2>St. Joseph\'s County American Red Cross</h2>
	<p>Your browser does not support iframes.</p>
	</center>
	<div class="menu">
	<a href = "http://disaster.stjoe-redcross.org/sandbox/home.php" target= "_parent"> HOME</a> | 
	<a href = "http://disaster.stjoe-redcross.org/sandbox/search.php" target= "_parent"> SEARCH </a>
	</div>
</iframe>


<div align="center">
  	<h1>Add Organization</h1>
	<form>
	<INPUT TYPE="BUTTON" VALUE="Back" ONCLICK="window.location.href='javascript:history.back()'">
	</form>
</div>

<?php

$organization_name = $_POST["organization_name"];
$street_address = $_POST["street_address"];
$city = $_POST["city"];
$state = $_POST["state"];
$zip = $_POST["zip"];
$county = $_POST["county"];
$business_phone = $_POST["bus_phone_1"].$_POST["bus_phone_2"].$_POST["bus_phone_3"];
$business_fax = $_POST["bus_fax_1"].$_POST["bus_fax_2"].$_POST["bus_fax_3"];
$email = $_POST["email"];
$website = $_POST["website"];



// Scrub the inputs
$organization_name = scrub_input($organization_name);
$street_address = scrub_input($street_address);
$city = scrub_input($city);
$state = scrub_input($state);
$county = scrub_input($county);
$email = scrub_input($email);
$website = scrub_input($website);

$errCount = 0;
if($form_valid == 1)
{
  print "<form name='verifyorg' method='post' action='./addorganization3.php' align='left'>";
  print "<p align='center'><b>Please verify this information. If anything is incorrect, please press back to make changes</b></p>";
}
else
{
  print "<form name='verifyorg' method='post' action='./addorganization2.php' align='left'>";
  print "<p align='center'><b>Please verufy this information and make necessary corrections</b></p>";
}


print "<table>";
//Org name
validator("Organization Name",$organization_name,"string");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Organization Name:</b></td>";
  print "<td><input name='organization_name' type='text' size='50' maxlength='50' align='left' value='"$salutation"'></td>\n";
  print "</tr>\n";
}
else
{
  print "<tr>";
  print "<td><b>Organization Name: </b></td>";
  print "<td>".$organization_name."</td>";
  print "</tr>";
}

//Address
validator("Street Address",$street_address,"string");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Street Address:</b></td>";
  print "<td><input name='street_address' type='text' size='50' maxlength='50' align='left' value='"$street_address"'></td>\n";
  print "</tr>\n";
}
else
{
	print "<tr>";
	print "<td><b>Street Address: </b></td>";
	print "<td>".$street_address."</td>";
	print "</tr>";
}

//City
validator("City",$city,"alpha_space");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>City: </b></td>\n";
  print "<td><input name='city' type='text' size='30' maxlength='30' align= 'left' value='".$city."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='city' value=\"".$city."\">";
  print"<tr>\n";
  print"<td><b>City: </b></td>\n";
  print"<td>".$city."</td>\n";
  print"</tr>\n";
}

//State
validator("State",$state,"alpha","2","2");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>State: </b></td>\n";
  print "<td><input name='state' type='text' size='2' maxlength='2' align= 'left' value='".$state."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='state' value=\"".$state."\">";
  print"<tr>\n";
  print"<td><b>State: </b></td>\n";
  print"<td>".$state."</td>\n";
  print"</tr>\n";
}

//Zip
validator("Zip",$zip,"number","5","5");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Zip:</b></td>\n";
  print "<td><input name='zip' type='text' size='10' maxlength='10' align= 'left' value='".$zip."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='zip' value=".$zip.">";
  print"<tr>\n";
  print"<td><b>Zip: </b></td>\n";
  print"<td>".$zip."</td>\n";
  print"</tr>\n";
}

//County
validator("County",$county,"string");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>County: </b></td>\n";
  print "<td><input name='county' type='text' size='30' maxlength='30' align= 'left' value='".$county."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<tr>";
  print "<td><b>County: </b></td>";
  print "<td>".$county."</td>";
  print "</tr>";
}

//Phone & Fax
validator("Business Phone",$business_phone,"number","10","10","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Business Phone: </b></td>\n";
  print "<td>(<input name='bus_phone_1' type='number' size='3' maxlength='3' align='left' value='".substr($business_phone,0,3)."'>)&nbsp\n";
  print "		<input name='bus_phone_2' type='number' size='3' maxlength='3' align='left' value='".substr($business_phone,3,3)."'>&nbsp - &nbsp\n";
  print "		<input name='bus_phone_3' type='number' size='4' maxlength='4' align='left' value='".substr($business_phone,6,4)."'>\n";
  print "</td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='work_phone' value=".$business_phone.">";
  print"<tr>\n";
  print"<td><b>Business Phone: </b></td>\n";
  print"<td>".substr($business_phone,0,3)."-".substr($business_phone,3,3)."-".substr($business_phone,6,4)."</td>\n";
  print"</tr>\n";
}	

validator("Fax",$business_fax,"number","10","10","0");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Fax: </b></td>\n";
  print "<td>(<input name='bus_fax_1' type='number' size='3' maxlength='3' align='left' value='".substr($business_fax,0,3)."'>)&nbsp\n";
  print "		<input name='bus_fax_2' type='number' size='3' maxlength='3' align='left' value='".substr($business_fax,3,3)."'>&nbsp - &nbsp\n";
  print "		<input name='bus_fax_3' type='number' size='4' maxlength='4' align='left' value='".substr($business_fax,6,4)."'>\n";
  print "</td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='business_fax' value=".$business_fax.">";
  print"<tr>\n";
  print"<td><b>Fax: </b></td>\n";
  print"<td>".substr($business_fax,0,3)."-".substr($business_fax,3,3)."-".substr($business_fax,6,4)."</td>\n";
  print"</tr>\n";
}

//Email
validator("Email",$email,"email");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Email: </b></td>\n";
  print "<td><input name='email' type='text' maxlength='50' align= 'left' value='".$email."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='email' value=\"".$email."\">";
  print"<tr>\n";
  print"<td><b>Email: </b></td>\n";
  print"<td>".$email."</td>\n";
  print"</tr>\n";
}	

validator("Website",$website,"string");
if($messages[$errCount])
{
  print $messages[$errCount]."<br>";
  $errCount++;
  print "<tr>\n";
  print "<td><b>Website: </b></td>\n";
  print "<td><input name='website' type='text' size='30' maxlength='30' align= 'left' value='".$website."'></td>\n";
  print "</tr>\n";
}
else
{
  print "<input type=hidden name='website' value=\"".$website."\">";
  print"<tr>\n";
  print"<td><b>Website: </b></td>\n";
  print"<td>".$website."</td>\n";
  print"</tr>\n";
}

	
print "</table>";

print "<br><br>";

//CHECK
if($errCount > 0)
{
  print "<input type=hidden name='form_valid' value='0'>";
  print "&nbsp&nbsp<input type=submit value='Add Organization'>";
  print "<input type=\"button\" value=\"back\" onclick=\"window.location.href='javascript:history.back()'\"?|>";
  print "</form>";
}
else
{
  print "Select a Resource: ";
  
  $query = "Select * from detailed_resource";
  
  $result = mysql_query($query) or die("Could not access resources");
  
  if( mysql_num_rows($result) < 1 )
    {
      print "There are no resources to be added, please go back and add a resource first!<br>";
    }
  else 
    {
      print "<select name=\"resource_id\" onchange=\"showResource(this.value)\">";
      print "<option value=\"NULL\"> </option>";
      
      while( $row = mysql_fetch_assoc($result) )
	{
	  print "<option value=\"".$row['resource_id']."\">".$row['resource_type']."</option>";
	}
      
      print "</select>";
    }
  print "&nbsp&nbsp or &nbsp&nbsp";
  print "<INPUT TYPE=\"BUTTON\" VALUE=\"Add New Resource\" ONCLICK=\"window.location.href='http://disaster.stjoe-redcross.org/sandbox/addresource1.php'\">";
  print "<br><br><input type=submit value='Add Organization'>";
  print "</form>";
  
  
  print "<p>";
  print "<div id=\"txtHint\"><b>Resource info will be listed here.</b></div>";
  print "</p>";
  
  print "<br><div align = 'center'>";
  print "<form>";
  print "<INPUT TYPE=\"BUTTON\" VALUE=\"Back\" ONCLICK=\"window.location.href='javascript:history.back()'\">";
  print "</form>";
}
print "<br></div>";
print "</div>";

print "</div>";
print "</body>";
print "</html>";


include ("config/closedb.php");
?>


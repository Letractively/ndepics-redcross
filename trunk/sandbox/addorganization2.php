<?php
session_start();
// Validate the users's session
if(($_SESSION['valid']) != "valid") {
        header( 'Location: ./index.php' );
}

if( !(($_SESSION['access_level_id'] > 3) && ($_SESSION['access_level_id'] < 10))){
        header( 'Location: ./index.php' );
} 



include ("config/dbconfig.php");
include ("config/opendb.php");
include("config/functions.php");


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

<div style="border:2px solid white; background-color:#FFFFFF" align="center">
<iframe src ="homeframe.php" width="745px" height="175px" scrolling= "no" FRAMEBORDER="0">
        <center>
        <h2>St. Joseph\'s County American Red Cross</h2>
        <p>Your browser does not support iframes.</p>
        </center>
        <div class="menu">
        <a href = "./home.php" target= "_parent"> HOME</a> | 
        <a href = "./search.php" target= "_parent"> SEARCH </a>
        </div>
</iframe>


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
$addresfromorg = 2;



// Scrub the inputs
$organization_name = scrub_input($organization_name);
$street_address = scrub_input($street_address);
$city = scrub_input($city);
$state = scrub_input($state);
$county = scrub_input($county);
$email = scrub_input($email);
$website = scrub_input($website);

print "<p align=center><b>Please add a resource for this organization.</b></p>";

print "<table>";
        print "<tr>";
        print "<td><b>Organization Name: </b></td>";
        print "<td>".$organization_name."</td>";
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
        print "<td><b>Zip:</b></td>";
        print "<td>".$zip."</td>";
        print "</tr>";
        
        print "<tr>";
        print "<td><b>County: </b></td>";
        print "<td>".$county."</td>";
        print "</tr>";
        
        print "<tr>";
        print "<td><b>Business Phone: </b></td>";
        print "<td>";
        echo print_phone($business_phone);
        print "</td>";
        print "</tr>";
        
        print "<tr>";
        print "<td><b>Business Fax: </b></td>";
        print "<td>";
        echo print_phone($business_fax);
        print "</td>";
        print "</tr>";
        
        print "<tr>";
        print "<td><b>Email: </b></td>";
        print "<td>".$email."</td>";
        print "</tr>";
        
        print "<tr>";
        print "<td><b>Website</b></td>";
        print "<td>".$website."</td>";
        print "</tr>";
        
print "</table>";

print "<br><br>";

print "<form name='verifyorganization' method='post' action='addorganization3.php' align='left'>";
print "<input type=hidden name='organization_name' value=\"".$organization_name."\">";
print "<input type=hidden name='street_address' value=\"".$street_address."\">";
print "<input type=hidden name='city' value=\"".$city."\">";
print "<input type=hidden name='state' value=\"".$state."\">";
print "<input type=hidden name='zip' value=".$zip.">";
print "<input type=hidden name='county' value=\"".$county."\">";
print "<input type=hidden name='business_phone' value=".$business_phone.">";
print "<input type=hidden name='business_fax' value=".$business_fax.">";
print "<input type=hidden name='email' value=\"".$email."\">";
print "<input type=hidden name='website' value=\"".$website."\">";

print "<div align = 'center'>";
print "Select a Resource: ";
  
$query = "Select * from detailed_resource";
$query .= "ORDER BY resource_type";

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

print "&nbsp&nbsp or &nbsp&nbsp Add New Resource Below";



print "<br><br><input type=submit value='Add Organization'>";
print "</form>";
print "<form name='addresourcefromorganization' method='post' action='addresource1.php' align='center'>";
print "<input type=hidden name='organization_name' value=\"".$organization_name."\">";
print "<input type=hidden name='street_address' value=\"".$street_address."\">";
print "<input type=hidden name='city' value=\"".$city."\">";
print "<input type=hidden name='state' value=\"".$state."\">";
print "<input type=hidden name='zip' value=".$zip.">";
print "<input type=hidden name='county' value=\"".$county."\">";
print "<input type=hidden name='business_phone' value=".$business_phone.">";
print "<input type=hidden name='business_fax' value=".$business_fax.">";
print "<input type=hidden name='email' value=\"".$email."\">";
print "<input type=hidden name='website' value=\"".$website."\">";
print "<input type=hidden name='addresfromorg' value='2'>";
print "<br><input type=submit value='Add New Resource'>";
print "</form>";
print "</div>";

print "<p>";
print "<div id=\"txtHint\"><b>Resource info will be listed here.</b></div>";
print "</p>";

print "<br></div>";
print "</div>";

print "</div>";
print "</body>";
print "</html>";


include ("config/closedb.php");
?>

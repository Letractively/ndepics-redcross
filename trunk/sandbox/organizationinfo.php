<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// organizationinfo.php - Page to display information about a given organization;
//****************************

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include ("./config/functions.php");
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Disaster Database - Organization Information</title>
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
</div>

<?php

print "<h1 align=\"center\">Organization Information</h1><hr>";

$organization_id = $_GET['id'];

//print "Org_id: ".$organization_id."<br>";

$query = "SELECT * FROM organization WHERE organization_id = ".$organization_id;

$result = mysql_query($query) or die ("Query Failed...could not retrieve organization information");

$row = mysql_fetch_assoc($result);

//
// Navigation Buttons
print "<div align=\"center\" name=\"navigation_buttons\">";
print "<table>";
print	"<tr>";


// Update BUTTON
print		"<td><form action=\"./updateorganization.php\"  method=\"POST\">";
print			"<input type=\"hidden\" name=\"organization_id\" value=".$organization_id.">";
print			"<input type=\"submit\" value=\"Update Record\">";
print			"</form>";
print		"</td>";


// Delete BUTTON
print		"<td><form action=\"./deleteorganization.php\" method=\"POST\">";
print			"<input type=hidden name=organization_id value=".$organization_id.">";
print			"<input type=submit value=\"Delete Record\">";
print			"</form>";
print		"</td>";

// Home BUTTON
print		"<td><form action=\"./home.php\">";
print			"<input type=submit value='Home'>";
print			"</form>";
print		"</td>";

print	"</tr>";
print "</table>";

print "</div>";

//
// Display the Organization Information
print "<h3>".$row['organization_name']."</h3>";
print		 $row['street_address']."<br>";
print		 $row['city'].", ".$row['state']." ".$row['zip']."<br>";
print		 $row['county']."<br>";
print		 "Business Phone:  ".print_phone($row['business_phone'])."<br>";
print	     "Business Fax: ".print_phone($row['business_fax'])."<br>";
print		 "Email: ".$row['email']."<br>";
print		 "Website: ".$row['website']."<br>";

mysql_free_result($result);


print "<center><h2>Resources</h2></center>";

//
// Resource query
$rsrcquery = "SELECT	DR.* 
			  FROM		detailed_resource DR JOIN (resource_listing RL, organization O)
			  ON		(DR.resource_id = RL.resource_id AND RL.organization_id = O.organization_id)
			  AND		O.organization_id = ".$organization_id;
			  
$result = mysql_query($rsrcquery) or die ("Resource Query failed");

//
	// Display the resource information
	print "<table border='1' align='center'>";
	print	"<tr>";
	print	"<th>Type of Resource</th>";
	print	"<th>Description</th>";
	print	"<th>Keyword(s)</th>";
	print	"</tr>";

while($row = mysql_fetch_assoc($result)) {

	print "<tr>";
	print	"<td><a href=\"./resourceinfo.php?id=".$row['resource_id']."\">".$row['resource_type']."</td>";
	print	"<td>".$row['description']."</td>";
	print	"<td>".$row['keywords']."</td>";
	print "</tr>";
}

	print "</table>";
	
mysql_free_result($result);


//
// Display the people that are connected to an organization
print "<center><h2>People Associated with the Organization</h2></center>";

//
// Resource query
$person_query = "SELECT		P.* , WF.*
				 FROM		person P JOIN (works_for WF, organization O)
				 ON			(P.person_id = WF.person_id AND WF.organization_id = O.organization_id )
				 AND		O.organization_id = ".$organization_id;
				  
$result = mysql_query($person_query) or die ("Person Query failed");

//
// Display the person's information
	print "<table border='1' align='center'>";
	print	"<tr>";
	print	"<th>Name</th>";
	print	"<th>Address</th>";
	print	"<th>Home Phone</th>";
	print	"<th>Work Phone</th>";
	print	"<th>Mobile Phone</th>";
	print	"<th>Title in Organization</th>";
	print	"<th>Role for Organization</th>";
	print	"</tr>";

while($row = mysql_fetch_assoc($result)) {

	print "<tr>";
	print	"<td><a href=\"./personinfo.php?id=".$row['person_id']."\">".$row['salutation']." ".$row['first_name']." ".$row['last_name']."</td>";
	print	"<td>".$row['street_address'];
	print		"<br>".$row['city'].", ".$row['state']."  ".$row['zip']."</td>";
	print	"<td>".print_phone($row['home_phone'])."</td>";
	print	"<td>".print_phone($row['work_phone'])."</td>";
	print	"<td>".print_phone($row['mobile_phone'])."</td>";
	print	"<td>".$row['title']."</td>";
	print   "<td>".$row['role']."</td>";
	print "</tr>";
}

	print "</table>";
	
mysql_free_result($result);


include ("./config/closedb.php");
?>

</div>
</body>
</html>
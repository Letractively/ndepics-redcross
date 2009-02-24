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
include_once ("config/functions.php");

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// addorganization3.php - file that inserts an organization into the disaster database;
//****************************

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><title>Disaster Database - Organization Added</title>

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
  <center>
  <h2>St. Joseph's County American Red Cross</h2>
  <p>Your browser does not support iframes.</p>
  </center>
  <div class="menu">
  <a href = "http://disaster.stjoe-redcross.org/sandbox/home.php" target= "_parent"> HOME</a> | 
  <a href = "http://disaster.stjoe-redcross.org/sandbox/search.php" target= "_parent"> SEARCH </a>
  </div>
</iframe>


<div align="center">
  <h1>Add Organization</h1>
</div>

<?
//
// Get the variables from the previous page
$organization_name = $_POST["organization_name"];
$street_address = $_POST["street_address"];
$city = $_POST["city"];
$state = $_POST["state"];
$zip = $_POST["zip"];
$county = $_POST["county"];
$business_phone = $_POST["business_phone"];
$business_fax = $_POST["business_fax"];
$email = $_POST["email"];
$website = $_POST["website"];

$resource_id = $_POST["resource_id"];

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
//print "Resource ID: ".$resource_id."<br>";

//
//Query to check if organization already exists
$org_query = "SELECT * FROM organization WHERE organization_name = '".$organization_name." ' ";

$result3 = mysql_query($org_query) or die ("Error checking if organization exists query");

$num_rows = mysql_num_rows($result3);

if ($num_rows != 0){
       print "<div align='center'><br>";
       print "Cannot Add Organization: \"<b>".$organization_name."</b>\" already exists <br><br>";
       print "<form action=\"./home.php\" >\n";
       print "<button type=\"submit\">Return Home</button>";
       print "</form>\n";
       print "</div>";
       exit(-1);
}
else{
     // print "Organization " .$organization_name." does not exist";
}

//
// Get the next auto_increment value (organization id)
$query = "SHOW TABLE STATUS LIKE 'organization'";
$result = mysql_query($query) or die ("Error sending table status query");
$row = mysql_fetch_assoc($result);
$organization_id = $row['Auto_increment'];

//print "***** AUTO INCREMENT (org_id) is: ".$organization_id." ***<br>\n";

//
//Query to add organization
$query = "INSERT INTO  organization (organization_name ,
									 street_address ,
									 city ,
									 state ,
								 	 zip ,
									 county ,
									 business_phone ,
									 business_fax ,
									 email ,
									 website )
		 VALUES (\"".$organization_name."\",\"".$street_address."\",\"".$city."\",\"".$state."\",\"".$zip."\",\"".
					 $county."\",\"".$business_phone."\",\"".$business_fax."\",\"".$email."\",\"".$website."\")";

$result = mysql_query($query) or die ("Error sending organization query");


//
// Make sure the organization id is correct
$org_query = "SELECT * FROM organization WHERE organization_id = ".$organization_id;
$result2 = mysql_query($org_query) or die ("Error checking the Organization ID");
$row = mysql_fetch_assoc($result2);
if($row['organization_name'] != $organization_name) {
	print "Organization names do not match up! Exiting...<br>\n";
       //Display what values are being added to the database

print "<h2><font color = \"red\">Failed to Add Values: </font></h2>";
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
	
print "</table><br>";
	$org_query = "DELETE FROM organization WHERE organization_name = \"".$organization_name."\"";
	mysql_query($org_query);
	exit (-1);
	//$redirect_url = "./home.php";
}
else {
	$redirect_url = "./organizationinfo.php?id=".$row['organization_id']."\"";
    $message .= "Successful Add...redirecting<br>";

//	//Display what values are being added to the database
//print "<h2>Successfully Added Values: </h2>";
//print "<table>";
//	print "<tr>";
//	print "<td><b>Organization Name: </b></td>";
//	print "<td>".$organization_name."</td>";
//	print "</tr>";
//
//	print "<tr>";
//	print "<td><b>Street Address: </b></td>";
//	print "<td>".$street_address."</td>";
//	print "</tr>";
//
//	print "<tr>";
//	print "<td><b>City: </b></td>";
//	print "<td>".$city."</td>";
//	print "</tr>";
//	
//	print "<tr>";
//	print "<td><b>State: </b></td>";
//	print "<td>".$state."</td>";
//	print "</tr>";
//	
//	print "<tr>";
//	print "<td><b>Zip:</b></td>";
//	print "<td>".$zip."</td>";
//	print "</tr>";
//	
//	print "<tr>";
//	print "<td><b>County: </b></td>";
//	print "<td>".$county."</td>";
//	print "</tr>";
//	
//	print "<tr>";
//	print "<td><b>Business Phone: </b></td>";
//	print "<td>";
//	echo print_phone($business_phone);
//	print "</td>";
//	print "</tr>";
//	
//	print "<tr>";
//	print "<td><b>Business Fax: </b></td>";
//	print "<td>";
//	echo print_phone($business_fax);
//	print "</td>";
//	print "</tr>";
//	
//	print "<tr>";
//	print "<td><b>Email: </b></td>";
//	print "<td>".$email."</td>";
//	print "</tr>";
//	
//	print "<tr>";
//	print "<td><b>Website</b></td>";
//	print "<td>".$website."</td>";
//	print "</tr>";
//	
//print "</table><br>";

}

// Query to link resource to the added organization
$query = "INSERT INTO resource_listing (resource_id, organization_id) 
		  VALUES (".$resource_id.",".$organization_id.")";
		  
$result = mysql_query($query) or die ("Error adding resource_listing");




print "<div align='center'>";
print "Organization Successfully Added...Redirecting<br>";
print "<form action=\"./home.php\" >\n";
print "<button type=\"submit\">Return Home</button>";
print "</form>\n";
print "</div>";

include ("config/closedb.php");
?>

<? print "<meta http-equiv=\"Refresh\" content=\"1.5; url=".$redirect_url."\">"; ?>
<meta name="resource-type" content="document">
<meta name="description" content="disaster.stjoe-redcross.org">
<meta name="keywords" content="">
<meta name="copyright" content="stjoe-redcross.org 2008.  All rights reserved.">
<link rel="shortcut icon" href="http://www.stjoe-redcross.org/favicon.ico">

<body class="main" onLoad="setTimeout('redirect()', 1000000)">
<div style="border:2px solid white; background-color:#FFFFFF">

	
</div>
</body>

</html>
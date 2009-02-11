<?php
session_start();
// Validate the users's session
if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
}

if( !(($_SESSION['access_level_id'] > 3) && ($_SESSION['access_level_id'] < 10))){
	header( 'Location: ./index.php' );
}  
 
// ***** TO BE ADDED LATER TO VALIDATE USERS ****
// if(!isset($_SESSION['valid']))
// 	header( 'Location: ./baduser.php' );

include ("config/dbconfig.php");
include ("config/opendb.php");
include_once ("config/functions.php");

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// addresource2.php - file to insert a resource into the disaster database;
//****************************

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><title>Disaster Database - Resource Added</title>



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
  <h1>Add Resource</h1>
</div>

<?

$resource_type = $_POST["resource_type"];
$resource_description = $_POST["resource_description"];
$resource_keyword = $_POST["resource_keyword"];

//print $resource_type."<br>";
//print $resource_description."<br>";
//print $resource_keyword."<br><br>";


//
// Scrub the inputs
//$resource_type = scrub_input($resource_type);
//$resource_description = scrub_input($resource_description);
//$resource_keyword = scrub_input($resource_keyword);

//
//Query to check if person already exists
$res_query = "SELECT * FROM detailed_resource WHERE resource_type = '".$resource_type." ' ";

$result3 = mysql_query($res_query) or die ("Error checking if organization exists query");

$num_rows = mysql_num_rows($result3);

if ($num_rows != 0){
       print "<div align='center'><br>";
       print "Cannot Add Resource Type: \"<b>".$resource_type."</b>\" already exists <br><br>";
       print "<form action=\"./home.php\" >\n";
       print "<button type=\"submit\">Return Home</button>";
       print "</form>\n";
       print "</div>";
       exit(-1);
}
else{
     // print "Organization " .$organization_name." does not exist";
}

$query = "INSERT INTO detailed_resource (resource_type, description, keyword)
				 VALUES (\"".$resource_type."\",\"".$resource_description."\",\"".$resource_keyword."\")";



//$query = "SELECT organization_id, organization_name, street_address, city FROM organization";
				 
				 
$result = mysql_query($query) or die ("Error sending query");

while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
{
	echo "Org_ID : {$row['organization_id']} <br>" .
	     "Org_Name: {$row['organization_name']} <br>" .
	     "Address: {$row['street_address']} <br>" .
	     "City: {$row['city']} <br>";
}

print "<h2>Adding values: </h2>";
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

//print $resource_type." was added as a resource successfully.";

print "<div align='center'>";
print "<form action=\"./home.php\">\n";
print "<button type=\"submit\">Return Home</button>";
print "</form>\n";
print "</div><br>";


include ("config/closedb.php");
?>

</body>
</html>
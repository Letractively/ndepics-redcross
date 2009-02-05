<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
	header( 'Location: ./index.php' );
 }
  if( ($_SESSION['access_level_id'] != 4) && ($_SESSION['access_level_id'] != 6) && ($_SESSION['access_level_id'] != 7) ){
 	header( 'Location: ./index.php' );
 } 

//****************************
//  Developed by ND Epics for St. Joe County RedCross 
//  
// Authors: Mike Ellerhorst & Mark Pasquier
//  Fall 2008
//
// resourceinfo.php - Page to display information about a given resource;
//****************************

include ("./config/dbconfig.php");
include ("./config/opendb.php");
include ("./config/functions.php");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Disaster Database - Resource Information</title>

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

<?php

print "<h1 align=\"center\">Resource Information</h1><hr>";

$resource_id = $_GET['id'];

//print "Resource_id: ".$resource_id."<br>";

$query = "SELECT * FROM detailed_resource WHERE resource_id = ".$resource_id;

$result = mysql_query($query) or die ("Query Failed...could not retrieve resource information");

$row = mysql_fetch_assoc($result);

//
// Navigation Buttons
print "<div align=\"center\" name=\"navigation_buttons\">";
print "<table>";
print	"<tr>";


// Update BUTTON
print		"<td><form action=\"./updateresource.php\" method=\"POST\" >";
print			"<input type=hidden name=resource_id value=".$resource_id.">";
print			"<input type=submit value='Update Record'>";
print			"</form>";
print		"</td>";


// Delete BUTTON
print		"<td><form action=\"./deleteresource.php\" method=\"POST\" >";
print			"<input type=hidden name=resource_id value=".$resource_id.">";
print			"<input type=submit value='Delete Record'>";
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
// Display the Resource Information
print "<h3>".$row['resource_type']."</h3>";
print "<table>";

print	"<tr>";
print		"<td>Description: </td>";
print		"<td>".$row['description']."</td>";
print	"</tr>";

print	"<tr>";
print		"<td>Keyword(s): </td>";
print		"<td>".$row['keyword']."</td>";
print	"</tr>";

print "</table>";

mysql_free_result($result);


include ("./config/closedb.php");
?>

</div>

</body>
</html>
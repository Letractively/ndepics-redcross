<?php
session_start();
// Validate the users's session
 if(($_SESSION['valid']) != "valid") {
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
// updateresource.php - file to update an existing resource in the disaster database;
// ****************************
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Disaster Database - Update Resource</title>
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
  <h1 align="center">Update Resource</h1>
</div>

<?php

// Retrieve the requested organization's information
$resource_id = $_POST["resource_id"];
$query = "SELECT	*
		  FROM		detailed_resource
		  WHERE		resource_id = ".$resource_id;
		  
$result = mysql_query($query) or die ("Resource Query failed");
$row = mysql_fetch_assoc($result);

$resource_type	= $row['resource_type'];
$description	= $row['description'];
$keyword		= $row['keyword'];

print "<p align=center><b>Change the desired fields and press 'Update Resource'.</b></p>\n";

print "<center><form name='updateresource' method='post' action='updateresource2.php'>\n";

	print "<input name='resource_id' type='hidden' value='".$resource_id."'>\n";

	/*******/
	//  Provide input fields pre-populated with the existing values in the database
	print "<table>\n";
		print "<tr>\n";
		print "<td><b>Resource Type: </b></td>\n";
		print "<td><input name='resource_type' type='text' maxlength='30' align= 'left' value='".$resource_type."'></td>\n";
		print "</tr>\n";

		print "<tr>\n";
		print "<td><b>Description (maximum of 1000 characters): </b></td>\n";
		print "<td><textarea name='resource_description' rows=6 cols=40 align= 'left' valign='top'>".$description."</textarea></td>\n";
		print "</tr>\n";

		print "<tr>\n";
		print "<td><b>Keyword(s): </b></td>\n";
		print "<td><input name='resource_keyword' type='text' maxlength='50' align= 'left' value='".$keyword."'></td>\n";
		print "</tr>\n";
		
	print "</table>\n";

	print "<br>\n";
	
	print "<input type='submit' value='Update Resource'>\n";
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
